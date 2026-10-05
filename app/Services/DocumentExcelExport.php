<?php
namespace App\Services;

use ZipArchive;

class DocumentExcelExport
{
    private const TYPES = ['moc' => 'MOC', 'berita_acara' => 'Berita Acara', 'surat_tugas' => 'Surat Tugas'];
    private const FIELDS = [
        'moc' => [
            'moc_number' => 'Nomor MOC', 'nama_pengusul' => 'Nama Pengusul', 'pengusul_departemen' => 'Departemen Pengusul', 'pengusul_jabatan' => 'Jabatan Pengusul', 'department' => 'Department Informasi Perubahan',
            'nama_digantikan' => 'Nama yang Digantikan', 'nama_pengganti' => 'Nama yang Menggantikan',
            'tujuan_perubahan' => 'Tujuan Perubahan termasuk Personel yang Diganti dan Pengganti',
            'hasil_perubahan' => 'Hasil Perubahan', 'penilaian_resiko' => 'Penilaian Risiko',
            'tanggal_efektif' => 'Tanggal Efektif',
            'approval.0.nama' => 'Nama Rig Superintendent', 'approval.0.signature_name' => 'Penandatangan Rig Superintendent',
            'approval.1.nama' => 'Nama Area Manager', 'approval.1.signature_name' => 'Penandatangan Area Manager',
        ],
        'berita_acara' => [
            'rig' => 'Rig', 'tidak_nama' => 'Nama yang Digantikan', 'tidak_jabatan' => 'Jabatan yang Digantikan',
            'tidak_crew' => 'Crew yang Digantikan', 'tidak_schedule' => 'Schedule yang Digantikan',
            'pengganti_nama' => 'Nama yang Menggantikan', 'pengganti_jabatan' => 'Jabatan Pengganti',
            'pengganti_rig' => 'Rig Pengganti', 'pengganti_crew' => 'Crew Pengganti', 'pengganti_schedule' => 'Schedule Pengganti',
            'alasan' => 'Alasan', 'tanggal_mulai' => 'Tanggal Mulai', 'tanggal_selesai' => 'Tanggal Selesai',
            'tanggal_surat' => 'Tanggal Surat', 'familirisasi' => 'Familiarisasi',
            'field_coordinator_signature_name' => 'Penandatangan Field Coordinator',
            'rig_supt_signature_name' => 'Penandatangan Rig Superintendent',
            'general_manager_signature_name' => 'Penandatangan General Manager', 'wsr_signature_name' => 'Penandatangan WSR',
        ],
        'surat_tugas' => [
            'rig' => 'Rig', 'status_personel' => 'Status Personel',
            'old_name' => 'Nama yang Digantikan', 'old_job' => 'Jabatan yang Digantikan',
            'new_name' => 'Nama yang Menggantikan', 'new_job' => 'Jabatan Pengganti',
            'reason' => 'Alasan', 'start_date' => 'Tanggal Mulai', 'end_date' => 'Tanggal Selesai',
            'mentor_name' => 'Nama Mentor', 'mentor_job' => 'Jabatan Mentor',
            'field_coordinator_signature_name' => 'Penandatangan Field Coordinator',
            'tool_pusher_signature_name' => 'Penandatangan Tool Pusher',
            'rig_supt_signature_name' => 'Penandatangan Rig Superintendent',
            'area_manager_signature_name' => 'Penandatangan Area Manager',
        ],
    ];

    public static function write($documents, ?string $type): string
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
            $types = $type === null ? array_keys(self::TYPES) : [$type];
            $sheets = ''; $rels = ''; $overrides = '';
            foreach ($types as $index => $documentType) {
                $number = $index + 1;
                $rows = $documents->where('document_type', $documentType)->values();
                $fields = self::FIELDS[$documentType];
                // Include every saved input, including nested reviewers and recipients.
                foreach ($rows as $document) {
                    foreach (self::flatten(self::normalizeData($document->form_data)) as $key => $value) {
                        if (in_array($key, ['document_title', 'format', 'output_format'], true) || str_ends_with($key, 'signature_id')) { continue; }
                        if (!array_key_exists($key, $fields)) { $fields[$key] = self::label($key); }
                    }
                }
                $headers = array_merge(['No.', 'Nama Dokumen', 'Dibuat Oleh', 'Tanggal Dibuat', 'Ketersediaan Detail'], array_values($fields));
                $lastColumn = self::column(count($headers));
                $xml = '<?xml version="1.0" encoding="UTF-8"?><worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"><sheetViews><sheetView workbookViewId="0"><pane ySplit="1" topLeftCell="A2" activePane="bottomLeft" state="frozen"/></sheetView></sheetViews><cols><col min="1" max="1" width="7" customWidth="1"/><col min="2" max="2" width="60" customWidth="1"/><col min="3" max="' . count($headers) . '" width="32" customWidth="1"/></cols><sheetData>';
                $xml .= self::row(1, $headers, true);
                foreach ($rows as $i => $document) {
                    $data = self::flatten(self::normalizeData($document->form_data));
                    $values = [$i + 1, $document->document_title ?: $document->file_name, $document->user?->name ?? '', $document->created_at?->format('d/m/Y H:i') ?? '', $document->form_data === null ? 'Dokumen lama belum memiliki detail tersimpan' : (isset($data['catatan_pemulihan']) ? $data['catatan_pemulihan'] : 'Detail tersimpan')];
                    foreach ($fields as $key => $label) {
                        $value = $data[$key] ?? '';
                        // Existing history only preserves this one name.
                        if ($value === '' && in_array($key, ['nama_pengusul', 'tidak_nama', 'old_name'], true)) { $value = $document->employee_name ?? ''; }
                        $values[] = $value;
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

    private static function normalizeData($data): array
    {
        if ($data === null || $data === '') { return []; }
        if (is_array($data)) { return $data; }
        if (is_string($data)) {
            $decoded = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
            if (is_array($decoded)) { return $decoded; }
        }
        throw new \UnexpectedValueException('form_data harus berisi objek JSON atau array. Periksa cast form_data pada model Document.');
    }

    private static function flatten(array $data, string $prefix = ''): array
    {
        $result = [];
        foreach ($data as $key => $value) {
            $path = $prefix === '' ? (string) $key : $prefix . '.' . $key;
            if (is_array($value)) { $result += self::flatten($value, $path); }
            else { $result[$path] = is_bool($value) ? ($value ? 'Ya' : 'Tidak') : (string) ($value ?? ''); }
        }
        return $result;
    }

    private static function label(string $key): string
    {
        $parts = explode('.', $key);
        $parts = array_map(function ($part) {
            return ctype_digit($part) ? (string) ((int) $part + 1) : ucwords(str_replace('_', ' ', $part));
        }, $parts);
        return implode(' ', $parts);
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
            $xml .= '<c r="' . self::column($index + 1) . $number . '" s="' . ($header ? 1 : 0) . '" t="inlineStr"><is><t xml:space="preserve">' . self::xml((string) $value) . '</t></is></c>';
        }
        return $xml . '</row>';
    }
}
