<?php
namespace App\Services;

use ZipArchive;

class ScheduleExcelExport
{
    private const MONTHS = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];

    public static function write($assignments, int $year, int $month, string $viewMode): string
    {
        $directory = storage_path('app/exports');
        if (!is_dir($directory) && !@mkdir($directory, 0775, true) && !is_dir($directory)) {
            throw new \RuntimeException('Folder storage/app/exports tidak dapat dibuat.');
        }
        $path = tempnam($directory, 'schedule_');
        if ($path === false) { throw new \RuntimeException('Gagal membuat file sementara.'); }
        $zip = new ZipArchive();
        $opened = false;
        try {
            if ($zip->open($path, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                throw new \RuntimeException('Gagal membuat Excel.');
            }
            $opened = true;
            $months = $viewMode === 'yearly' ? range(1, 12) : [$month];
            $sheets = ''; $rels = ''; $overrides = '';
            foreach ($months as $index => $selectedMonth) {
                $number = $index + 1;
                $rows = $assignments->values();
                $days = \Carbon\Carbon::create($year, $selectedMonth, 1)->daysInMonth;
                $headers = ['No.', 'NIP', 'Nama Karyawan', 'Jabatan', 'Rig', 'Crew'];
                for ($day = 1; $day <= $days; $day++) {
                    $headers[] = sprintf('%02d/%02d/%04d', $day, $selectedMonth, $year);
                }
                $headers = array_merge($headers, ['Total S', 'Total M', 'Total ON', 'Total OFF']);
                $lastColumn = self::column(count($headers));
                $xml = '<?xml version="1.0" encoding="UTF-8"?><worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"><sheetViews><sheetView workbookViewId="0"><pane xSplit="6" ySplit="1" topLeftCell="G2" activePane="bottomRight" state="frozen"/></sheetView></sheetViews><cols><col min="1" max="1" width="7" customWidth="1"/><col min="2" max="2" width="18" customWidth="1"/><col min="3" max="4" width="30" customWidth="1"/><col min="5" max="6" width="24" customWidth="1"/><col min="7" max="' . count($headers) . '" width="13" customWidth="1"/></cols><sheetData>';
                $xml .= self::row(1, $headers, true);
                foreach ($rows as $i => $assignment) {
                    $employee = $assignment->employee;
                    $crew = $assignment->crew === 'RIG_SUPERINTENDENT' ? 'Rig Superintendent' : 'Crew ' . $assignment->crew;
                    $values = [$i + 1, (string) ($employee?->nip ?? ''), $employee?->nama_lengkap ?? '', $employee?->jabatan ?? '', $assignment->rig, $crew];
                    $schedules = $assignment->schedules->keyBy(fn ($schedule) => \Carbon\Carbon::parse($schedule->schedule_date)->format('Y-m-d'));
                    $totals = ['S' => 0, 'M' => 0, 'ON' => 0, 'OFF' => 0];
                    for ($day = 1; $day <= $days; $day++) {
                        $date = sprintf('%04d-%02d-%02d', $year, $selectedMonth, $day);
                        $schedule = $schedules->get($date);
                        $shift = (string) ($schedule?->shift_code ?? '');
                        $values[] = $shift;
                        if (array_key_exists($shift, $totals)) { $totals[$shift]++; }
                    }
                    $values = array_merge($values, array_values($totals));
                    $xml .= self::row($i + 2, $values);
                }
                $xml .= '</sheetData><autoFilter ref="A1:' . $lastColumn . ($rows->count() + 1) . '"/><pageSetup orientation="landscape" paperSize="9"/></worksheet>';
                if (!$zip->addFromString('xl/worksheets/sheet' . $number . '.xml', $xml)) {
                    throw new \RuntimeException('Gagal menulis sheet schedule.');
                }
                $sheets .= '<sheet name="' . self::xml(self::MONTHS[$selectedMonth] . ' ' . $year) . '" sheetId="' . $number . '" r:id="rId' . $number . '"/>';
                $rels .= '<Relationship Id="rId' . $number . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet' . $number . '.xml"/>';
                $overrides .= '<Override PartName="/xl/worksheets/sheet' . $number . '.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>';
            }
            $zip->addFromString('[Content_Types].xml', '<?xml version="1.0" encoding="UTF-8"?><Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types"><Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/><Default Extension="xml" ContentType="application/xml"/><Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/><Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>' . $overrides . '</Types>');
            $zip->addFromString('_rels/.rels', '<?xml version="1.0" encoding="UTF-8"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/></Relationships>');
            $zip->addFromString('xl/workbook.xml', '<?xml version="1.0" encoding="UTF-8"?><workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"><sheets>' . $sheets . '</sheets></workbook>');
            $zip->addFromString('xl/_rels/workbook.xml.rels', '<?xml version="1.0" encoding="UTF-8"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">' . $rels . '<Relationship Id="rStyles" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/></Relationships>');
            $zip->addFromString('xl/styles.xml', '<?xml version="1.0" encoding="UTF-8"?><styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"><fonts count="4"><font><sz val="11"/><name val="Calibri"/></font><font><b/><sz val="11"/><name val="Calibri"/></font><font><b/><sz val="11"/><color rgb="FF073B56"/><name val="Calibri"/></font><font><b/><sz val="11"/><color rgb="FFFFFFFF"/><name val="Calibri"/></font></fonts><fills count="7"><fill><patternFill patternType="none"/></fill><fill><patternFill patternType="gray125"/></fill><fill><patternFill patternType="solid"><fgColor rgb="FFFFFF00"/><bgColor indexed="64"/></patternFill></fill><fill><patternFill patternType="solid"><fgColor rgb="FF38BDF8"/><bgColor indexed="64"/></patternFill></fill><fill><patternFill patternType="solid"><fgColor rgb="FF8B5CF6"/><bgColor indexed="64"/></patternFill></fill><fill><patternFill patternType="solid"><fgColor rgb="FF22C55E"/><bgColor indexed="64"/></patternFill></fill><fill><patternFill patternType="solid"><fgColor rgb="FFEF4444"/><bgColor indexed="64"/></patternFill></fill></fills><borders count="1"><border/></borders><cellStyleXfs count="1"><xf fontId="0" fillId="0" borderId="0"/></cellStyleXfs><cellXfs count="6"><xf fontId="0" fillId="0" borderId="0" xfId="0" applyAlignment="1"><alignment vertical="top" wrapText="1"/></xf><xf fontId="1" fillId="2" borderId="0" xfId="0" applyFont="1" applyFill="1" applyAlignment="1"><alignment horizontal="center" vertical="center" wrapText="1"/></xf><xf fontId="2" fillId="3" borderId="0" xfId="0" applyFont="1" applyFill="1" applyAlignment="1"><alignment horizontal="center" vertical="center" wrapText="1"/></xf><xf fontId="3" fillId="4" borderId="0" xfId="0" applyFont="1" applyFill="1" applyAlignment="1"><alignment horizontal="center" vertical="center" wrapText="1"/></xf><xf fontId="3" fillId="5" borderId="0" xfId="0" applyFont="1" applyFill="1" applyAlignment="1"><alignment horizontal="center" vertical="center" wrapText="1"/></xf><xf fontId="3" fillId="6" borderId="0" xfId="0" applyFont="1" applyFill="1" applyAlignment="1"><alignment horizontal="center" vertical="center" wrapText="1"/></xf></cellXfs><cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles></styleSheet>');
            if (!$zip->close()) { throw new \RuntimeException('Gagal menyimpan Excel.'); }
            $opened = false;
            return $path;
        } catch (\Throwable $e) {
            // Windows locks an open ZIP. Cleanup must never replace the original exception.
            if ($opened) {
                try { @$zip->close(); } catch (\Throwable $cleanupError) {}
            }
            unset($zip);
            clearstatcache(true, $path);
            try { if (is_file($path)) { @unlink($path); } } catch (\Throwable $cleanupError) {}
            throw $e;
        }
    }

    private static function column(int $number): string
    {
        $name = '';
        while ($number > 0) { $number--; $name = chr(65 + $number % 26) . $name; $number = intdiv($number, 26); }
        return $name;
    }

    private static function xml(string $value): string
    {
        $value = preg_replace('/[^\x{9}\x{A}\x{D}\x{20}-\x{D7FF}\x{E000}-\x{FFFD}\x{10000}-\x{10FFFF}]/u', '', $value) ?? '';
        return htmlspecialchars($value, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }

    private static function row(int $number, array $values, bool $header = false): string
    {
        $xml = '<row r="' . $number . '">';
        foreach ($values as $index => $value) {
            $reference = self::column($index + 1) . $number;
            $style = $header ? 1 : 0;
            if (!$header && $index >= 6 && is_string($value)) {
                $style = match ($value) {
                    'S' => 2,
                    'M' => 3,
                    'ON' => 4,
                    'OFF' => 5,
                    default => 0,
                };
            }
            if (!$header && (is_int($value) || is_float($value))) {
                $xml .= '<c r="' . $reference . '" s="0" t="n"><v>' . $value . '</v></c>';
            } else {
                $xml .= '<c r="' . $reference . '" s="' . $style . '" t="inlineStr"><is><t xml:space="preserve">' . self::xml((string) $value) . '</t></is></c>';
            }
        }
        return $xml . '</row>';
    }
}
