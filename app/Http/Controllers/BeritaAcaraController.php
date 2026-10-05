<?php

namespace App\Http\Controllers;

use App\Models\Document;

use App\Models\Signature;

use Carbon\Carbon;

use Illuminate\Http\Request;

use Illuminate\Support\Str;

use PhpOffice\PhpWord\TemplateProcessor;

class BeritaAcaraController extends Controller

{

    /*

    |--------------------------------------------------------------------------

    | HALAMAN FORM BERITA ACARA

    |--------------------------------------------------------------------------

    */

    public function create()

    {

        $signatures = Signature::orderBy('name', 'asc')->get();

        return view('berita-acara.create', compact('signatures'));

    }

    /*

    |--------------------------------------------------------------------------

    | GENERATE WORD

    |--------------------------------------------------------------------------

    */

    public function generate(Request $request)

    {

        $validated = $this->validateRequest($request);

        try {

            $directory = storage_path('app/generated');

            if (!is_dir($directory) && !mkdir($directory, 0775, true) && !is_dir($directory)) {

                throw new \RuntimeException('Folder generated tidak dapat dibuat.');

            }

            $slug = Str::slug($validated['document_title']) ?: 'berita-acara';

            $fileName = $slug . '-' . now()->format('Ymd-His') . '.docx';

            $outputPath = $directory . DIRECTORY_SEPARATOR . $fileName;

            $this->buildWordDocumentFromTemplate($validated, $outputPath);

            $downloadName = $this->downloadFileName($validated['document_title'], 'docx');

            $this->recordGeneratedDocument($validated, $fileName, $downloadName);

            return response()->download($outputPath, $downloadName)->deleteFileAfterSend(false);

        } catch (\Throwable $e) {

            return back()->withInput()->with('error', 'Gagal generate Berita Acara Word: ' . $e->getMessage());

        }

    }

    public function generatePdf(Request $request)

    {

        $validated = $this->validateRequest($request);

        try {

            $directory = storage_path('app/generated');

            if (!is_dir($directory) && !mkdir($directory, 0775, true) && !is_dir($directory)) {

                throw new \RuntimeException('Folder generated tidak dapat dibuat.');

            }

            $slug = Str::slug($validated['document_title']) ?: 'berita-acara';

            $baseName = $slug . '-' . now()->format('Ymd-His') . '-' . Str::random(6);

            $wordPath = $directory . DIRECTORY_SEPARATOR . $baseName . '.docx';

            $fileName = $baseName . '.pdf';

            $pdfPath = $directory . DIRECTORY_SEPARATOR . $fileName;

            $this->buildWordDocumentFromTemplate($validated, $wordPath);

            try {

                $this->convertWordDocumentToPdf($wordPath, $pdfPath);

            } finally {

                @unlink($wordPath);

            }

            $downloadName = $this->downloadFileName($validated['document_title'], 'pdf');

            $this->recordGeneratedDocument($validated, $fileName, $downloadName);

            return response()->download($pdfPath, $downloadName, [

                'Content-Type' => 'application/pdf',

            ])->deleteFileAfterSend(false);

        } catch (\Throwable $e) {

            return back()->withInput()->with('error', 'Gagal generate Berita Acara PDF: ' . $e->getMessage());

        }

    }

    private function buildWordDocumentFromTemplate(array $validated, string $outputPath): void

    {

        $templatePath = storage_path(

            'app/templates/BERITA ACARA PERGANTIAN SEMENTARA - FINAL GARIS NAMA.docx'

        );

        if (!is_file($templatePath)) {

            throw new \RuntimeException('Template Berita Acara tidak ditemukan di: ' . $templatePath);

        }

        $template = \App\Services\SignatureTemplateLayout::processor($templatePath, 'berita_acara');

        $data = $this->prepareData($validated);

        /*

        |------------------------------------------------------------------

        | RIG

        |------------------------------------------------------------------

        */

        $template->setValue('rig', $this->cleanValue($data['rig_number']));

        $template->setValue('rig2', $this->cleanValue($data['rig_number']));

        $template->setValue('rig3', $this->cleanValue($data['rig_number']));

        $template->setValue('rig4', $this->cleanValue($data['rig_number']));

        /*

        |------------------------------------------------------------------

        | PERSONEL TIDAK HADIR

        |------------------------------------------------------------------

        */

        $template->setValue('abs_n', $this->cleanValue($data['tidak_nama']));

        $template->setValue('abs_j', $this->cleanValue($data['tidak_jabatan']));

        $template->setValue('abs_c', $this->cleanValue($data['tidak_crew']));

        $template->setValue('abs_s', $this->cleanValue($data['tidak_schedule']));

        /*

        |------------------------------------------------------------------

        | ALASAN + TANGGAL

        |------------------------------------------------------------------

        */

        $template->setValue('reason', $this->cleanValue($data['alasan']));

        $template->setValue('date_range', $this->cleanValue($data['date_range']));

        $template->setValue('days', $this->cleanValue($data['days']));

        /*

        |------------------------------------------------------------------

        | PERSONEL PENGGANTI

        |------------------------------------------------------------------

        */

        $template->setValue('rep_j', $this->cleanValue($data['pengganti_jabatan']));

        // Template sudah mencantumkan awalan ARJ- pada kedua placeholder.

        $penggantiRigNumber = preg_replace(

            '/^(?:ARJ[\s-]*)+/i',

            '',

            trim((string) $data['pengganti_rig'])

        );

        $template->setValue('rep_rig', $this->cleanValue($penggantiRigNumber));

        $template->setValue('rep_n', $this->cleanValue($data['pengganti_nama']));

        $template->setValue('rep_j2', $this->cleanValue($data['pengganti_jabatan']));

        $template->setValue('rep_rig2', $this->cleanValue($penggantiRigNumber));

        $template->setValue('rep_c', $this->cleanValue($data['pengganti_crew']));

        $template->setValue('rep_s', $this->cleanValue($data['pengganti_schedule']));

        /*

        |------------------------------------------------------------------

        | FAMILIARISASI

        |------------------------------------------------------------------

        */

        $template->setValue('fam', $this->cleanValue($data['familirisasi']));

        /*

        |------------------------------------------------------------------

        | TANGGAL DOKUMEN

        |------------------------------------------------------------------

        */

        $template->setValue('date', $this->cleanValue($data['tanggal_surat_text']));

        /*

        |------------------------------------------------------------------

        | NAMA PENANDATANGAN

        |------------------------------------------------------------------

        */

        $template->setValue('name_fc', $this->cleanValue($data['field_coordinator_name']));

        $template->setValue('name_rs', $this->cleanValue($data['rig_supt_name']));

        $template->setValue('name_gm', $this->cleanValue($data['general_manager_name']));

        $template->setValue('name_wsr', $this->cleanValue($data['wsr_name']));

        /*

        |------------------------------------------------------------------

        | TANDA TANGAN WORD

        |------------------------------------------------------------------

        */

        $this->setStoredSignature(

            $template,

            'sig_fc',

            $data['field_coordinator_signature']

        );

        $this->setStoredSignature(

            $template,

            'sig_rs',

            $data['rig_supt_signature']

        );

        $this->setStoredSignature(

            $template,

            'sig_gm',

            $data['general_manager_signature']

        );

        $this->setStoredSignature(

            $template,

            'sig_wsr',

            $data['wsr_signature']

        );

        $template->saveAs($outputPath);

        if (!is_file($outputPath) || filesize($outputPath) === 0) {

            throw new \RuntimeException('Dokumen Word sumber PDF gagal dibuat.');

        }

    }

    private function downloadFileName(string $title, string $extension): string

    {

        $name = rtrim(str_replace(['/', '\\\\\\\\', ':', '*', '?', '"', '<', '>', '|'], '-', trim($title)), ' .-');

        return ($name !== '' ? $name : 'Berita Acara') . '.' . $extension;

    }

    private function recordGeneratedDocument(array $validated, string $fileName, string $downloadName): void

    {

        Document::create([

                'form_data' => \App\Services\DocumentSnapshot::capture($validated),

            'user_id' => auth()->id(),

            'document_type' => 'berita_acara',

            'document_title' => $validated['document_title'],

            'employee_name' => $validated['tidak_nama'],

            'file_name' => $downloadName,

            'file_path' => 'generated/' . $fileName,

        ]);

    }

    private function convertWordDocumentToPdf(

        string $wordPath,

        string $pdfPath

    ): void {

        $errors = [];

        if ($this->tryConvertWithMicrosoftWord(

            $wordPath,

            $pdfPath,

            $errors

        )) {

            return;

        }

        if ($this->tryConvertWithLibreOffice(

            $wordPath,

            $pdfPath,

            $errors

        )) {

            return;

        }

        throw new \RuntimeException(

            "Tidak ada converter Word ke PDF yang berhasil.\n\n" .

            implode("\n\n", $errors) .

            "\n\nGunakan Microsoft Word desktop atau install LibreOffice."

        );

    }

    /*

    |--------------------------------------------------------------------------

    | CONVERT USING MICROSOFT WORD

    |--------------------------------------------------------------------------

    */

    private function tryConvertWithMicrosoftWord(

        string $wordPath,

        string $pdfPath,

        array &$errors

    ): bool {

        if (PHP_OS_FAMILY !== 'Windows') {

            $errors[] =

                'Microsoft Word COM dilewati karena server bukan Windows.';

            return false;

        }

        $powershell = $this->findPowerShellExecutable();

        if (!$powershell) {

            $errors[] =

                'PowerShell tidak ditemukan untuk menjalankan Microsoft Word.';

            return false;

        }

        $scriptPath =

            sys_get_temp_dir() .

            DIRECTORY_SEPARATOR .

            'sikap-word-to-pdf-' .

            Str::random(12) .

            '.ps1';

        $script = <<<'POWERSHELL'

param(

    [Parameter(Mandatory=$true)]

    [string]$InputFile,

    [Parameter(Mandatory=$true)]

    [string]$OutputFile

)

$ErrorActionPreference = "Stop"

$word = $null

$doc = $null

try {

    $word = New-Object -ComObject Word.Application

    $word.Visible = $false

    $word.DisplayAlerts = 0

    $doc = $word.Documents.Open(

        $InputFile,

        $false,

        $true

    )

    # 17 = wdExportFormatPDF

    $doc.ExportAsFixedFormat(

        $OutputFile,

        17

    )

}

finally {

    if ($doc -ne $null) {

        $doc.Close($false)

        [void][System.Runtime.InteropServices.Marshal]::ReleaseComObject($doc)

    }

    if ($word -ne $null) {

        $word.Quit()

        [void][System.Runtime.InteropServices.Marshal]::ReleaseComObject($word)

    }

    [GC]::Collect()

    [GC]::WaitForPendingFinalizers()

}

POWERSHELL;

        file_put_contents(

            $scriptPath,

            $script

        );

        $command =

            escapeshellarg($powershell) .

            ' -NoProfile -NonInteractive -ExecutionPolicy Bypass' .

            ' -File ' . escapeshellarg($scriptPath) .

            ' -InputFile ' . escapeshellarg($wordPath) .

            ' -OutputFile ' . escapeshellarg($pdfPath) .

            ' 2>&1';

        $output = [];

        $exitCode = 1;

        exec(

            $command,

            $output,

            $exitCode

        );

        @unlink($scriptPath);

        if (

            $exitCode === 0 &&

            file_exists($pdfPath) &&

            filesize($pdfPath) > 0

        ) {

            return true;

        }

        if (file_exists($pdfPath)) {

            @unlink($pdfPath);

        }

        $errors[] =

            "Microsoft Word gagal mengkonversi DOCX ke PDF.\n" .

            trim(implode("\n", $output));

        return false;

    }

    /*

    |--------------------------------------------------------------------------

    | CONVERT USING LIBREOFFICE

    |--------------------------------------------------------------------------

    */

    private function tryConvertWithLibreOffice(

        string $wordPath,

        string $pdfPath,

        array &$errors

    ): bool {

        $soffice =

            $this->findLibreOfficeExecutable();

        if (!$soffice) {

            $errors[] =

                'LibreOffice tidak ditemukan.';

            return false;

        }

        $outputDirectory =

            dirname($pdfPath);

        $expectedPdfPath =

            $outputDirectory .

            DIRECTORY_SEPARATOR .

            pathinfo(

                $wordPath,

                PATHINFO_FILENAME

            ) .

            '.pdf';

        if (file_exists($expectedPdfPath)) {

            @unlink($expectedPdfPath);

        }

        $command =

            escapeshellarg($soffice) .

            ' --headless' .

            ' --convert-to pdf' .

            ' --outdir ' .

            escapeshellarg($outputDirectory) .

            ' ' .

            escapeshellarg($wordPath) .

            ' 2>&1';

        $output = [];

        $exitCode = 1;

        exec(

            $command,

            $output,

            $exitCode

        );

        if (

            $exitCode === 0 &&

            file_exists($expectedPdfPath) &&

            filesize($expectedPdfPath) > 0

        ) {

            if (

                realpath($expectedPdfPath) !==

                realpath($pdfPath)

            ) {

                if (file_exists($pdfPath)) {

                    @unlink($pdfPath);

                }

                if (!@rename(

                    $expectedPdfPath,

                    $pdfPath

                )) {

                    if (!@copy(

                        $expectedPdfPath,

                        $pdfPath

                    )) {

                        $errors[] =

                            'LibreOffice menghasilkan PDF, tetapi file gagal dipindahkan.';

                        return false;

                    }

                    @unlink($expectedPdfPath);

                }

            }

            return (

                file_exists($pdfPath) &&

                filesize($pdfPath) > 0

            );

        }

        $errors[] =

            "LibreOffice gagal mengkonversi DOCX ke PDF.\n" .

            trim(implode("\n", $output));

        return false;

    }

    /*

    |--------------------------------------------------------------------------

    | FIND POWERSHELL

    |--------------------------------------------------------------------------

    */

    private function findPowerShellExecutable(): ?string

    {

        $candidates = [

            getenv('SystemRoot')

                ? getenv('SystemRoot') .

                    '\\\\\System32\\\\\WindowsPowerShell\\\\\v1.0\\\\\powershell.exe'

                : null,

            'C:\\\\\Windows\\\\\System32\\\\\WindowsPowerShell\\\\\v1.0\\\\\powershell.exe',

            'powershell.exe',

        ];

        foreach ($candidates as $candidate) {

            if (!$candidate) {

                continue;

            }

            if (

                str_contains($candidate, '\\\\\\\\') &&

                file_exists($candidate)

            ) {

                return $candidate;

            }

            if ($candidate === 'powershell.exe') {

                return $candidate;

            }

        }

        return null;

    }

    /*

    |--------------------------------------------------------------------------

    | FIND LIBREOFFICE

    |--------------------------------------------------------------------------

    */

    private function findLibreOfficeExecutable(): ?string

    {

        $candidates = [];

        if (PHP_OS_FAMILY === 'Windows') {

            $programFiles = getenv('ProgramFiles');

            $programFilesX86 = getenv('ProgramFiles(x86)');

            if ($programFiles) {

                $candidates[] =

                    $programFiles .

                    '\\\\\LibreOffice\\\\\program\\\\\soffice.exe';

            }

            if ($programFilesX86) {

                $candidates[] =

                    $programFilesX86 .

                    '\\\\\LibreOffice\\\\\program\\\\\soffice.exe';

            }

            $candidates[] =

                'C:\\\\\Program Files\\\\\LibreOffice\\\\\program\\\\\soffice.exe';

            $candidates[] =

                'C:\\\\\Program Files (x86)\\\\\LibreOffice\\\\\program\\\\\soffice.exe';

        } else {

            $candidates[] = '/usr/bin/libreoffice';

            $candidates[] = '/usr/bin/soffice';

            $candidates[] = '/snap/bin/libreoffice';

        }

        foreach (array_unique($candidates) as $candidate) {

            if (

                $candidate &&

                file_exists($candidate)

            ) {

                return $candidate;

            }

        }

        return null;

    }

    /*

    | VALIDASI FORM

    */

    private function validateRequest(Request $request): array

    {

        return $request->validate([

            'document_title' => 'required|string|max:255',

            'rig' =>

                'required|in:ARJ-06,ARJ-07,ARJ-08,ARJ-09,ARJ-10,ARJ-11,ARJ-12,ARJ-13,ARJ-14,ARJ-15',

            'tidak_nama' => 'required|string|max:255',

            'tidak_jabatan' => 'required|string|max:255',

            'tidak_crew' => 'required|string|max:100',

            'tidak_schedule' => 'required|string|max:255',

            'alasan' => 'required|string|max:255',

            'tanggal_mulai' => 'required|date',

            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',

            'pengganti_nama' => 'required|string|max:255',

            'pengganti_jabatan' => 'required|string|max:255',

            'pengganti_rig' => 'required|string|max:100',

            'pengganti_crew' => 'required|string|max:100',

            'pengganti_schedule' => 'required|string|max:255',

            'familirisasi' => 'required|string|max:255',

            'tanggal_surat' => 'required|date',

            'field_coordinator_signature_id' =>

                'nullable|exists:signatures,id',

            'rig_supt_signature_id' =>

                'nullable|exists:signatures,id',

            'general_manager_signature_id' =>

                'nullable|exists:signatures,id',

            'wsr_signature_id' =>

                'nullable|exists:signatures,id',

        ]);

    }

    /*

    |--------------------------------------------------------------------------

    | SIAPKAN DATA WORD & PDF

    |--------------------------------------------------------------------------

    */

    private function prepareData(array $validated): array

    {

        $startDate = Carbon::parse($validated['tanggal_mulai']);

        $endDate = !empty($validated['tanggal_selesai'])

            ? Carbon::parse($validated['tanggal_selesai'])

            : $startDate->copy();

        $documentDate = Carbon::parse($validated['tanggal_surat']);

        $days = $startDate->diffInDays($endDate) + 1;

        $fieldCoordinatorSignature = Signature::find(

            $validated['field_coordinator_signature_id'] ?? null

        );

        $rigSuptSignature = Signature::find(

            $validated['rig_supt_signature_id'] ?? null

        );

        $generalManagerSignature = Signature::find(

            $validated['general_manager_signature_id'] ?? null

        );

        $wsrSignature = Signature::find(

            $validated['wsr_signature_id'] ?? null

        );

        return array_merge(

            $validated,

            [

                'rig_number' => str_replace(

                    'ARJ-',

                    '',

                    $validated['rig']

                ),

                'date_range' => $this->formatDateRangeIndonesia(

                    $startDate,

                    $endDate

                ),

                'days' => $days,

                'tanggal_surat_text' =>

                    $this->formatDateIndonesia($documentDate),

                'field_coordinator_signature' =>

                    $fieldCoordinatorSignature,

                'rig_supt_signature' =>

                    $rigSuptSignature,

                'general_manager_signature' =>

                    $generalManagerSignature,

                'wsr_signature' =>

                    $wsrSignature,

                'field_coordinator_name' =>

                    $fieldCoordinatorSignature?->name ?? '',

                'rig_supt_name' =>

                    $rigSuptSignature?->name ?? '',

                'general_manager_name' =>

                    $generalManagerSignature?->name ?? '',

                'wsr_name' =>

                    $wsrSignature?->name ?? '',

            ]

        );

    }

    /*

    |--------------------------------------------------------------------------

    | SIGNATURE LIBRARY -> WORD

    |--------------------------------------------------------------------------

    */

    private function setStoredSignature(

        TemplateProcessor $template,

        string $placeholder,

        ?Signature $signature

    ): void {

        if (!$signature) {

            $template->setValue($placeholder, '');

            return;

        }

        $signaturePath = $this->resolveSignaturePath($signature);

        if (!$signaturePath) {

            $template->setValue($placeholder, '');

            return;

        }

        if (@getimagesize($signaturePath) === false) {

            $template->setValue($placeholder, '');

            return;

        }

        $template->setImageValue(

            $placeholder,

            [

                'path' => $signaturePath,

                'width' => 85,

                'height' => 42,

                'ratio' => true,

            ]

        );

    }

    /*

    |--------------------------------------------------------------------------

    | SIGNATURE LIBRARY -> PDF

    |--------------------------------------------------------------------------

    */

    private function getSignatureDataUri(

        ?Signature $signature

    ): ?string {

        if (!$signature) {

            return null;

        }

        $signaturePath = $this->resolveSignaturePath($signature);

        if (!$signaturePath) {

            return null;

        }

        return $this->getImageDataUri($signaturePath);

    }

    /*

    |--------------------------------------------------------------------------

    | RESOLVE PATH SIGNATURE

    |--------------------------------------------------------------------------

    */

    private function resolveSignaturePath(

        Signature $signature

    ): ?string {

        $storedPath = str_replace(

            '\\\\\\\\\\\\\\\\',

            '/',

            trim((string) $signature->file_path)

        );

        $candidates = [];

        if (

            preg_match('/^[A-Za-z]:/', $storedPath) ||

            str_starts_with($storedPath, '/')

        ) {

            $candidates[] = $storedPath;

        }

        $candidates[] = storage_path(

            'app/' . ltrim($storedPath, '/')

        );

        $publicRelative = preg_replace(

            '#^public/#',

            '',

            ltrim($storedPath, '/')

        );

        $candidates[] = storage_path(

            'app/public/' . $publicRelative

        );

        $privateRelative = preg_replace(

            '#^private/#',

            '',

            ltrim($storedPath, '/')

        );

        $candidates[] = storage_path(

            'app/private/' . $privateRelative

        );

        $candidates[] = public_path(

            ltrim($storedPath, '/')

        );

        $storageRelative = preg_replace(

            '#^storage/#',

            '',

            ltrim($storedPath, '/')

        );

        $candidates[] = public_path(

            'storage/' . $storageRelative

        );

        foreach (array_unique($candidates) as $candidate) {

            if (

                is_string($candidate) &&

                file_exists($candidate) &&

                is_file($candidate)

            ) {

                return $candidate;

            }

        }

        return null;

    }

    /*

    |--------------------------------------------------------------------------

    | IMAGE -> BASE64 DATA URI

    |--------------------------------------------------------------------------

    */

    private function getImageDataUri(

        string $path

    ): ?string {

        if (!file_exists($path) || !is_file($path)) {

            return null;

        }

        if (@getimagesize($path) === false) {

            return null;

        }

        $mime = mime_content_type($path);

        if (!in_array(

            $mime,

            ['image/png', 'image/jpeg'],

            true

        )) {

            return null;

        }

        return

            'data:' .

            $mime .

            ';base64,' .

            base64_encode(

                file_get_contents($path)

            );

    }

    /*

    |--------------------------------------------------------------------------

    | FORMAT RANGE TANGGAL INDONESIA

    |--------------------------------------------------------------------------

    */

    private function formatDateRangeIndonesia(

        Carbon $start,

        Carbon $end

    ): string {

        $months = $this->monthsIndonesia();

        if ($start->isSameDay($end)) {

            return $this->formatDateIndonesia($start);

        }

        if (

            $start->month === $end->month &&

            $start->year === $end->year

        ) {

            return

                $start->format('d') .

                ' s/d ' .

                $end->format('d') .

                ' ' .

                $months[$end->month] .

                ' ' .

                $end->year;

        }

        return

            $start->format('d') .

            ' ' .

            $months[$start->month] .

            ' ' .

            $start->year .

            ' s/d ' .

            $end->format('d') .

            ' ' .

            $months[$end->month] .

            ' ' .

            $end->year;

    }

    /*

    |--------------------------------------------------------------------------

    | FORMAT SATU TANGGAL INDONESIA

    |--------------------------------------------------------------------------

    */

    private function formatDateIndonesia(

        Carbon $date

    ): string {

        $months = $this->monthsIndonesia();

        return

            $date->format('d') .

            ' ' .

            $months[$date->month] .

            ' ' .

            $date->year;

    }

    private function monthsIndonesia(): array

    {

        return [

            1 => 'Januari',

            2 => 'Februari',

            3 => 'Maret',

            4 => 'April',

            5 => 'Mei',

            6 => 'Juni',

            7 => 'Juli',

            8 => 'Agustus',

            9 => 'September',

            10 => 'Oktober',

            11 => 'November',

            12 => 'Desember',

        ];

    }

    /*

    |--------------------------------------------------------------------------

    | CLEAN VALUE UNTUK WORD

    |--------------------------------------------------------------------------

    */

    private function cleanValue($value): string

    {

        if ($value === null) {

            return '';

        }

        return htmlspecialchars(

            (string) $value,

            ENT_QUOTES | ENT_XML1,

            'UTF-8'

        );

    }

    /*

    |--------------------------------------------------------------------------

    | DEBUG TEMPLATE

    |--------------------------------------------------------------------------

    */

    public function debugTemplate()

    {

        $templatePath = storage_path(

            'app/templates/BERITA ACARA PERGANTIAN SEMENTARA - FINAL GARIS NAMA.docx'

        );

        if (!file_exists($templatePath)) {

            return response()->json([

                'status' => 'ERROR',

                'message' => 'Template tidak ditemukan.',

                'path' => $templatePath,

            ]);

        }

        try {

            $template = new TemplateProcessor($templatePath);

            return response()->json([

                'status' => 'OK',

                'path' => $templatePath,

                'size' => filesize($templatePath),

                'variables' => $template->getVariables(),

            ]);

        } catch (\Throwable $e) {

            return response()->json([

                'status' => 'ERROR',

                'message' => $e->getMessage(),

            ]);

        }

    }

}
