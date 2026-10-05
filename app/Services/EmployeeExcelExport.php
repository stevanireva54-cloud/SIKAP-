<?php
namespace App\Services;

use ZipArchive;

class EmployeeExcelExport
{
    private const TYPES = ['employees' => 'Data Karyawan'];
    private const FIELDS = ['employees' => [
        'nip' => 'NIP',
        'nik_internal' => 'NIK Internal',
        'nama_lengkap' => 'Nama Lengkap',
        'jabatan' => 'Jabatan',
        'rig' => 'Rig / Lokasi',
        'tanggal_bergabung' => 'Tanggal Bergabung',
        'status' => 'Status',
        'nama_ibu_kandung' => 'Nama Ibu Kandung',
        'pendidikan_terakhir' => 'Pendidikan Terakhir',
        'nama_sekolah' => 'Nama Sekolah',
        'tahun_lulus' => 'Tahun Lulus',
        'agama' => 'Agama',
        'status_pernikahan' => 'Status Pernikahan',
        'jumlah_anak' => 'Jumlah Anak',
        'tempat_lahir' => 'Tempat Lahir',
        'tanggal_lahir' => 'Tanggal Lahir',
        'nik_ktp' => 'NIK KTP',
        'alamat' => 'Alamat',
        'no_telepon' => 'No Telepon',
        'email' => 'Email',
        'no_kis' => 'No KIS',
        'no_kpj' => 'No KPJ',
        'npwp' => 'NPWP',
        'nama_bank' => 'Nama Bank',
        'nama_pemilik_rekening' => 'Nama Pemilik Rekening',
        'nomor_rekening' => 'Nomor Rekening',
        'saldo_cuti' => 'Saldo Cuti',
        'ukuran_baju' => 'Ukuran Baju',
        'ukuran_sepatu' => 'Ukuran Sepatu',
        'ktp_expiry_date' => 'Masa Berlaku KTP',
        'contract_end_date' => 'Tanggal Akhir Kontrak',
        'sim_expiry_date' => 'Masa Berlaku SIM',
        'certificate_expiry_date' => 'Masa Berlaku Sertifikat',
        'documents_count' => 'Jumlah Dokumen Karyawan',
    ]];

    public static function write($documents): string
    {
        $directory = storage_path('app/exports');
        if (!is_dir($directory) && !@mkdir($directory, 0775, true) && !is_dir($directory)) {
            throw new \RuntimeException('Folder storage/app/exports tidak dapat dibuat.');
        }
        $path = tempnam($directory, 'sikap_detail_');
        if ($path === false) { throw new \RuntimeException('Gagal membuat file sementara.'); }
        $zip = new ZipArchive();
        $opened = false;
        try {
            if ($zip->open($path, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                throw new \RuntimeException('Gagal membuat Excel.');
            }
            $opened = true;
            $types = ['employees'];
            $sheets = ''; $rels = ''; $overrides = '';
            foreach ($types as $index => $documentType) {
                $number = $index + 1;
                $rows = $documents->values();
                $fields = self::FIELDS[$documentType];
                $headers = array_merge(['No.'], array_values($fields));
                $lastColumn = self::column(count($headers));
                $xml = '<?xml version="1.0" encoding="UTF-8"?><worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"><sheetViews><sheetView workbookViewId="0"><pane ySplit="1" topLeftCell="A2" activePane="bottomLeft" state="frozen"/></sheetView></sheetViews><cols><col min="1" max="1" width="7" customWidth="1"/><col min="2" max="2" width="60" customWidth="1"/><col min="3" max="' . count($headers) . '" width="32" customWidth="1"/></cols><sheetData>';
                $xml .= self::row(1, $headers, true);
                foreach ($rows as $i => $document) {
                    $values = [$i + 1];
                    foreach ($fields as $key => $label) {
                        $value = $document->getAttribute($key);
                        if ($value instanceof \DateTimeInterface) { $value = $value->format('d/m/Y'); }
                        if ($value !== null && in_array($key, ['jumlah_anak', 'tahun_lulus', 'documents_count'], true)) { $value = (int) $value; }
                        if ($value !== null && $key === 'saldo_cuti') { $value = (float) $value; }
                        $values[] = $value ?? '';
                    }
                    $xml .= self::row($i + 2, $values);
                }
                $xml .= '</sheetData><autoFilter ref="A1:' . $lastColumn . ($rows->count() + 1) . '"/></worksheet>';
                $zip->addFromString('xl/worksheets/sheet' . $number . '.xml', $xml);
                $sheets .= '<sheet name="' . self::xml(self::TYPES[$documentType]) . '" sheetId="' . $number . '" r:id="rId' . $number . '"/>';
                $rels .= '<Relationship Id="rId' . $number . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet' . $number . '.xml"/>';
                $overrides .= '<Override PartName="/xl/worksheets/sheet' . $number . '.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>';
            }
            $zip->addFromString('[Content_Types].xml', '<?xml version="1.0" encoding="UTF-8"?><Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types"><Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/><Default Extension="xml" ContentType="application/xml"/><Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/><Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>' . $overrides . '</Types>');
            $zip->addFromString('_rels/.rels', '<?xml version="1.0" encoding="UTF-8"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/></Relationships>');
            $zip->addFromString('xl/workbook.xml', '<?xml version="1.0" encoding="UTF-8"?><workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"><sheets>' . $sheets . '</sheets></workbook>');
            $zip->addFromString('xl/_rels/workbook.xml.rels', '<?xml version="1.0" encoding="UTF-8"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">' . $rels . '<Relationship Id="rStyles" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/></Relationships>');
            $zip->addFromString('xl/styles.xml', '<?xml version="1.0" encoding="UTF-8"?><styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"><fonts count="2"><font><sz val="11"/><name val="Calibri"/></font><font><b/><sz val="11"/><name val="Calibri"/></font></fonts><fills count="3"><fill><patternFill patternType="none"/></fill><fill><patternFill patternType="gray125"/></fill><fill><patternFill patternType="solid"><fgColor rgb="FFFFFF00"/><bgColor indexed="64"/></patternFill></fill></fills><borders count="1"><border/></borders><cellStyleXfs count="1"><xf/></cellStyleXfs><cellXfs count="2"><xf fontId="0" fillId="0" borderId="0" xfId="0" applyAlignment="1"><alignment vertical="top" wrapText="1"/></xf><xf fontId="1" fillId="2" borderId="0" xfId="0" applyFont="1" applyFill="1" applyAlignment="1"><alignment vertical="top" wrapText="1"/></xf></cellXfs><cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles></styleSheet>');
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
            if (!$header && (is_int($value) || is_float($value))) {
                $xml .= '<c r="' . $reference . '" s="0" t="n"><v>' . $value . '</v></c>';
            } else {
                $xml .= '<c r="' . $reference . '" s="' . ($header ? 1 : 0) . '" t="inlineStr"><is><t xml:space="preserve">' . self::xml((string) $value) . '</t></is></c>';
            }
        }
        return $xml . '</row>';
    }
}
