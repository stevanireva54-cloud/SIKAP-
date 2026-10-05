<?php
namespace App\Http\Controllers;
use App\Models\Document;
use App\Models\Signature;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\TemplateProcessor;
class SuratTugasController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FORM SURAT TUGAS
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $signatures = Signature::orderBy('name', 'asc')->get();
        return view('surat-tugas.create', compact('signatures'));
    }
    /*
    |--------------------------------------------------------------------------
    | GENERATE WORD
    |--------------------------------------------------------------------------
    */
    public function generate(Request $request)
    {
        $revision = \App\Services\DocumentRevision::get('surat_tugas');
        $request->merge($revision);

        $request->validate([
            /*
            |--------------------------------------------------------------------------
            | INFORMASI DOKUMEN
            |--------------------------------------------------------------------------
            */
            'document_title' => 'required|string|max:255',
            'rig' => 'required|string|max:50',
            /*
            |--------------------------------------------------------------------------
            | PERSONEL YANG DIGANTI
            |--------------------------------------------------------------------------
            */
            'old_name' =>
                'required|string|max:255',
            'old_job' =>
                'required|string|max:255',
            'reason' =>
                'required|string|max:255',
            /*
            |--------------------------------------------------------------------------
            | PERIODE
            |--------------------------------------------------------------------------
            */
            'start_date' =>
                'required|date',
            'end_date' =>
                'nullable|date|after_or_equal:start_date',
            /*
            |--------------------------------------------------------------------------
            | PERSONEL PENGGANTI
            |--------------------------------------------------------------------------
            */
            'new_name' =>
                'required|string|max:255',
            'new_job' =>
                'required|string|max:255',
            /*
            |--------------------------------------------------------------------------
            | MENTOR
            |--------------------------------------------------------------------------
            */
            'mentor_name' =>
                'nullable|string|max:255',
            'mentor_job' =>
                'nullable|string|max:255',
            /*
            |--------------------------------------------------------------------------
            | CHECKLIST
            |--------------------------------------------------------------------------
            */
            'badge' =>
                'nullable|in:V,X,T/P',
            'iadc' =>
                'nullable|in:V,X,T/P',
            'apps' =>
                'nullable|in:V,X,T/P',
            'oups' =>
                'nullable|in:V,X,T/P',
            'omps' =>
                'nullable|in:V,X,T/P',
            'olps' =>
                'nullable|in:V,X,T/P',
            'tkbt' =>
                'nullable|in:V,X,T/P',
            'sio' =>
                'nullable|in:V,X,T/P',
            'lop' =>
                'nullable|in:V,X,T/P',
            'k3' =>
                'nullable|in:V,X,T/P',
            'sim' =>
                'nullable|in:V,X,T/P',
            'apb' =>
                'nullable|in:V,X,T/P',
            'jb' =>
                'nullable|in:V,X,T/P',
            'olb' =>
                'nullable|in:V,X,T/P',
            'omb' =>
                'nullable|in:V,X,T/P',
            'k3_disnaker' =>
                'nullable|in:V,X,T/P',
            'rigger' =>
                'nullable|in:V,X,T/P',
            'other_certificate' =>
                'nullable|string|max:255',
            'mcu' =>
                'nullable|in:V,X,T/P',
            'kp' =>
                'nullable|in:V,X,T/P',
            'mcu_vaccine' =>
                'nullable|in:V,X,T/P',
            'self_declaration' =>
                'nullable|in:V,X,T/P',
            'sse_yes_no' =>
                'nullable|in:Yes,No',
            'apd_yes_no' =>
                'nullable|in:Yes,No',
            'training_yes_no' =>
                'nullable|in:Yes,No',
            /*
            |--------------------------------------------------------------------------
            | TANGGAL SURAT
            |--------------------------------------------------------------------------
            */
            'document_date' =>
                'required|date',
            /*
            |--------------------------------------------------------------------------
            | SIGNATURE LIBRARY
            |--------------------------------------------------------------------------
            */
            'field_coordinator_signature_id' =>
                'nullable|exists:signatures,id',
            'tool_pusher_signature_id' =>
                'nullable|exists:signatures,id',
            'rig_supt_signature_id' =>
                'nullable|exists:signatures,id',
            'area_manager_signature_id' =>
                'nullable|exists:signatures,id',
        ]);
        /*
        |--------------------------------------------------------------------------
        | TEMPLATE
        |--------------------------------------------------------------------------
        */
        $templatePath = storage_path(
            'app/templates/Surat Tugas - FINAL PLACEHOLDER.docx'
        );
        if (!file_exists($templatePath)) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Template Surat Tugas tidak ditemukan di: ' .
                    $templatePath
                );
        }
        try {
            $template = \App\Services\SignatureTemplateLayout::processor($templatePath, 'surat_tugas');
        $template->setValue('rev_date', $request->input('rev_date'));
        $template->setValue('rev_no', $request->input('rev_no'));
            /*
            |--------------------------------------------------------------------------
            | AMBIL PLACEHOLDER TEMPLATE
            |--------------------------------------------------------------------------
            */
            $variables =
                $template->getVariables();
            /*
            |--------------------------------------------------------------------------
            | RIG
            |--------------------------------------------------------------------------
            |
            | Contoh:
            |
            | ARJ-10
            |
            | menjadi:
            |
            | 10
            |
            */
            $rig = strtoupper(
                trim($request->rig)
            );
            $rig = str_replace(
                [
                    'ARJ-',
                    'API-',
                    'ARJ ',
                    'API '
                ],
                '',
                $rig
            );
            $template->setValue(
                'rig',
                $this->cleanValue($rig)
            );
            /*
            |--------------------------------------------------------------------------
            | STATUS PERSONEL
            |--------------------------------------------------------------------------
            */
            $template->setValue(
                'status',
                $this->cleanValue(
                    $request->status_personel
                )
            );
            /*
            |--------------------------------------------------------------------------
            | PERSONEL YANG DIGANTI
            |--------------------------------------------------------------------------
            */
            $template->setValue(
                'old_name',
                $this->cleanValue(
                    $request->old_name
                )
            );
            $template->setValue(
                'old_job',
                $this->cleanValue(
                    $request->old_job
                )
            );
            $template->setValue(
                'reason',
                $this->cleanValue(
                    $request->reason
                )
            );
            /*
            |--------------------------------------------------------------------------
            | PERIODE
            |--------------------------------------------------------------------------
            */
            $startDate = Carbon::parse(
                $request->start_date
            );
            $endDate = $request->filled('end_date')
                ? Carbon::parse($request->end_date)
                : $startDate->copy();
            $period =
                $this->formatDateRangeIndonesia(
                    $startDate,
                    $endDate
                );
            $template->setValue(
                'period',
                $this->cleanValue(
                    $period
                )
            );
            /*
            |--------------------------------------------------------------------------
            | PERSONEL PENGGANTI
            |--------------------------------------------------------------------------
            */
            $template->setValue(
                'new_name',
                $this->cleanValue(
                    $request->new_name
                )
            );
            $template->setValue(
                'new_job',
                $this->cleanValue(
                    $request->new_job
                )
            );
            /*
            |--------------------------------------------------------------------------
            | MENTOR
            |--------------------------------------------------------------------------
            */
            $template->setValue(
                'mentor_name',
                $this->cleanValue(
                    $request->mentor_name
                )
            );
            $template->setValue(
                'mentor_job',
                $this->cleanValue(
                    $request->mentor_job
                )
            );
            /*
            |--------------------------------------------------------------------------
            | CHECKLIST
            |--------------------------------------------------------------------------
            */
            $checklistMap = [
                'a' => 'badge',
                'c' => 'iadc',
                'd' => 'apps',
                'e' => 'oups',
                'f' => 'omps',
                'g' => 'olps',
                'h' => 'tkbt',
                'i' => 'lop',
                'j' => 'k3',
                'k' => 'sim',
                'l' => 'apb',
                'm' => 'jb',
                'n' => 'olb',
                'o' => 'omb',
                'sio' => 'sio',
                'q' => 'k3_disnaker',
                'r' => 'rigger',
                's' => 'mcu',
                't' => 'kp',
                'u' => 'mcu_vaccine',
                'v' => 'self_declaration',
            ];
            foreach (
                $checklistMap
                as $placeholder => $field
            ) {
                $template->setValue(
                    $placeholder,
                    $this->cleanValue(
                        $request->input(
                            $field,
                            ''
                        )
                    )
                );
            }
            /*
            |--------------------------------------------------------------------------
            | SERTIFIKAT LAIN-LAIN
            |--------------------------------------------------------------------------
            */
            $template->setValue(
                'other',
                $this->cleanValue(
                    $request->other_certificate
                )
            );
            /*
            |--------------------------------------------------------------------------
            | SSE YES / NO
            |--------------------------------------------------------------------------
            */
            $template->setValue('w', $request->sse_yes_no === 'Yes' ? 'V' : '');
            $template->setValue('wy', $request->sse_yes_no === 'No' ? 'V' : '');
            /*
            |--------------------------------------------------------------------------
            | APD YES / NO
            |--------------------------------------------------------------------------
            */
            $template->setValue('x', $request->apd_yes_no === 'Yes' ? 'V' : '');
            $template->setValue('xy', $request->apd_yes_no === 'No' ? 'V' : '');
            /*
            |--------------------------------------------------------------------------
            | TRAINING YES / NO
            |--------------------------------------------------------------------------
            */
            $template->setValue('y', $request->training_yes_no === 'Yes' ? 'V' : '');
            $template->setValue('yy', $request->training_yes_no === 'No' ? 'V' : '');
            /*
            |--------------------------------------------------------------------------
            | TANGGAL SURAT
            |--------------------------------------------------------------------------
            |
            | FIX:
            |
            | Template Word tidak lagi memakai tahun statis.
            |
            | Placeholder ${date} sekarang diisi lengkap:
            |
            | 03 September 2027
            |
            | BUKAN:
            |
            | 03 September 2026
            |
            */
            $documentDate = Carbon::parse(
                $request->document_date
            );
            $template->setValue(
                'date',
                $this->cleanValue(
                    $this
                        ->formatDateWithoutYearIndonesia(
                            $documentDate
                        ) . ' ' . $documentDate->year
                )
            );
            /*
            |--------------------------------------------------------------------------
            | SIGNATURE LIBRARY
            |--------------------------------------------------------------------------
            */
            $fieldCoordinator =
                Signature::find(
                    $request
                        ->field_coordinator_signature_id
                );
            $toolPusher =
                Signature::find(
                    $request
                        ->tool_pusher_signature_id
                );
            $rigSupt =
                Signature::find(
                    $request
                        ->rig_supt_signature_id
                );
            $areaManager =
                Signature::find(
                    $request
                        ->area_manager_signature_id
                );
            /*
            |--------------------------------------------------------------------------
            | NAMA PENANDATANGAN
            |--------------------------------------------------------------------------
            */
            $template->setValue(
                'name_fc',
                $this->cleanValue(
                    $fieldCoordinator?->name
                )
            );
            $template->setValue(
                'name_tp',
                $this->cleanValue(
                    $toolPusher?->name
                )
            );
            $template->setValue(
                'name_rs',
                $this->cleanValue(
                    $rigSupt?->name
                )
            );
            $template->setValue(
                'name_am',
                $this->cleanValue(
                    $areaManager?->name
                )
            );
            /*
            |--------------------------------------------------------------------------
            | TTD FIELD COORDINATOR
            |--------------------------------------------------------------------------
            */
            $this->setStoredSignature(
                $template,
                $variables,
                's_fc',
                $fieldCoordinator
            );
            /*
            |--------------------------------------------------------------------------
            | TTD TOOL PUSHER
            |--------------------------------------------------------------------------
            */
            $this->setStoredSignature(
                $template,
                $variables,
                's_tp',
                $toolPusher
            );
            /*
            |--------------------------------------------------------------------------
            | TTD RIG SUPT
            |--------------------------------------------------------------------------
            */
            $this->setStoredSignature(
                $template,
                $variables,
                's_rs',
                $rigSupt
            );
            /*
            |--------------------------------------------------------------------------
            | TTD AREA MANAGER
            |--------------------------------------------------------------------------
            */
            $this->setStoredSignature(
                $template,
                $variables,
                's_am',
                $areaManager
            );
            /*
            |--------------------------------------------------------------------------
            | OUTPUT DIRECTORY
            |--------------------------------------------------------------------------
            */
            $outputDirectory =
                storage_path(
                    'app/generated'
                );
            if (!is_dir(
                $outputDirectory
            )) {
                mkdir(
                    $outputDirectory,
                    0775,
                    true
                );
            }
            /*
            |--------------------------------------------------------------------------
            | FILE NAME
            |--------------------------------------------------------------------------
            */
            $safeTitle = Str::slug(
                $request->document_title
            );
            if (empty($safeTitle)) {
                $safeTitle =
                    'surat-tugas';
            }
            $fileName =
                $safeTitle .
                '-' .
                now()->format(
                    'Ymd-His'
                ) .
                '.docx';
            $downloadName = $this->downloadFileName($request->document_title, 'docx');
            $outputPath =
                $outputDirectory .
                DIRECTORY_SEPARATOR .
                $fileName;
            /*
            |--------------------------------------------------------------------------
            | SAVE WORD
            |--------------------------------------------------------------------------
            */
            $template->saveAs(
                $outputPath
            );
            /*
            |--------------------------------------------------------------------------
            | SIMPAN WORD KE RIWAYAT
            |--------------------------------------------------------------------------
            */
            Document::create([
                'form_data' => \App\Services\DocumentSnapshot::capture($request->input()),
                'user_id' => auth()->id(),
                'document_type' => 'surat_tugas',
                'document_title' => $request->document_title,
                'employee_name' => $request->old_name,
                'file_name' => $downloadName,
                'file_path' => 'generated/' . $fileName,
            ]);
            /*
            |--------------------------------------------------------------------------
            | DOWNLOAD WORD
            |--------------------------------------------------------------------------
            */
            return response()
                ->download(
                    $outputPath,
                    $downloadName
                )
                ->deleteFileAfterSend(false);
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Gagal generate Surat Tugas: ' .
                    $e->getMessage()
                );
        }
    }
    /*
    |--------------------------------------------------------------------------
    | GENERATE PDF - PDFKIT / WKHTMLTOPDF
    |--------------------------------------------------------------------------
    */
    public function generatePdf(Request $request)
    {
        $revision = \App\Services\DocumentRevision::get('surat_tugas');
        $request->merge($revision);

        $request->validate([
            'document_title' => 'required|string|max:255',
            'rig' => 'required|string|max:50',
            'status_personel' => 'required|in:Tidak hadir,Di actingkan',
            'old_name' => 'required|string|max:255',
            'old_job' => 'required|string|max:255',
            'reason' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'new_name' => 'required|string|max:255',
            'new_job' => 'required|string|max:255',
            'mentor_name' => 'nullable|string|max:255',
            'mentor_job' => 'nullable|string|max:255',
            'badge' => 'nullable|in:V,X,T/P',
            'iadc' => 'nullable|in:V,X,T/P',
            'apps' => 'nullable|in:V,X,T/P',
            'oups' => 'nullable|in:V,X,T/P',
            'omps' => 'nullable|in:V,X,T/P',
            'olps' => 'nullable|in:V,X,T/P',
            'tkbt' => 'nullable|in:V,X,T/P',
            'sio' => 'nullable|in:V,X,T/P',
            'lop' => 'nullable|in:V,X,T/P',
            'k3' => 'nullable|in:V,X,T/P',
            'sim' => 'nullable|in:V,X,T/P',
            'apb' => 'nullable|in:V,X,T/P',
            'jb' => 'nullable|in:V,X,T/P',
            'olb' => 'nullable|in:V,X,T/P',
            'omb' => 'nullable|in:V,X,T/P',
            'k3_disnaker' => 'nullable|in:V,X,T/P',
            'rigger' => 'nullable|in:V,X,T/P',
            'other_certificate' => 'nullable|string|max:255',
            'mcu' => 'nullable|in:V,X,T/P',
            'kp' => 'nullable|in:V,X,T/P',
            'mcu_vaccine' => 'nullable|in:V,X,T/P',
            'self_declaration' => 'nullable|in:V,X,T/P',
            'sse_yes_no' => 'nullable|in:Yes,No',
            'apd_yes_no' => 'nullable|in:Yes,No',
            'training_yes_no' => 'nullable|in:Yes,No',
            'document_date' => 'required|date',
            'field_coordinator_signature_id' => 'nullable|exists:signatures,id',
            'tool_pusher_signature_id' => 'nullable|exists:signatures,id',
            'rig_supt_signature_id' => 'nullable|exists:signatures,id',
            'area_manager_signature_id' => 'nullable|exists:signatures,id',
        ]);
        $outputDirectory = storage_path('app/generated');
        if (!is_dir($outputDirectory)) {
            mkdir($outputDirectory, 0775, true);
        }
        $safeTitle = Str::slug($request->document_title);
        if ($safeTitle === '') {
            $safeTitle = 'surat-tugas';
        }
        $stamp = now()->format('Ymd-His') . '-' . Str::lower(Str::random(6));
        $wordFileName = $safeTitle . '-' . $stamp . '-pdf-source.docx';
        $pdfFileName = $safeTitle . '-' . $stamp . '.pdf';
        $downloadName = $this->downloadFileName($request->document_title, 'pdf');
        $wordPath = $outputDirectory . DIRECTORY_SEPARATOR . $wordFileName;
        $pdfPath = $outputDirectory . DIRECTORY_SEPARATOR . $pdfFileName;
        try {
            /*
             * PDF sekarang TIDAK dibuat dari Blade HTML.
             * Sistem terlebih dahulu mengisi template Word yang sama dengan
             * tombol Generate Word, lalu file DOCX hasilnya dikonversi ke PDF.
             *
             * Hasilnya jauh lebih konsisten dengan template Word:
             * font, posisi tabel, checkbox, signature, footer, dan spacing.
             */
            $this->buildWordDocumentFromTemplate(
                $request,
                $wordPath
            );
            $this->convertWordDocumentToPdf(
                $wordPath,
                $pdfPath
            );
            if (!file_exists($pdfPath) || filesize($pdfPath) === 0) {
                throw new \RuntimeException(
                    'Konversi selesai tetapi file PDF tidak ditemukan.'
                );
            }
            Document::create([
                'form_data' => \App\Services\DocumentSnapshot::capture($request->input()),
                'user_id' => auth()->id(),
                'document_type' => 'surat_tugas',
                'document_title' => $request->document_title,
                'employee_name' => $request->old_name,
                'file_name' => $downloadName,
                'file_path' => 'generated/' . $pdfFileName,
            ]);
            if (file_exists($wordPath)) {
                @unlink($wordPath);
            }
            return response()
                ->download(
                    $pdfPath,
                    $downloadName,
                    ['Content-Type' => 'application/pdf']
                )
                ->deleteFileAfterSend(false);
        } catch (\Throwable $e) {
            if (file_exists($wordPath)) {
                @unlink($wordPath);
            }
            if (
                file_exists($pdfPath) &&
                filesize($pdfPath) === 0
            ) {
                @unlink($pdfPath);
            }
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Gagal generate PDF Surat Tugas dari template Word: ' .
                    $e->getMessage()
                );
        }
    }
    /*
    |--------------------------------------------------------------------------
    | BUILD WORD DOCUMENT FOR PDF
    |--------------------------------------------------------------------------
    |
    | Menggunakan template yang SAMA dengan tombol Generate Word.
    | Method ini tidak mengubah desain template. Ia hanya mengisi placeholder.
    |
    */
    private function buildWordDocumentFromTemplate(
        Request $request,
        string $outputPath
    ): void {
        $templatePath = storage_path(
            'app/templates/Surat Tugas - FINAL PLACEHOLDER.docx'
        );
        if (!file_exists($templatePath)) {
            throw new \RuntimeException(
                'Template Surat Tugas tidak ditemukan di: ' .
                $templatePath
            );
        }
        $template = \App\Services\SignatureTemplateLayout::processor($templatePath, 'surat_tugas');
        $template->setValue('rev_date', $request->input('rev_date'));
        $template->setValue('rev_no', $request->input('rev_no'));
        $variables = $template->getVariables();
        $rig = strtoupper(trim((string) $request->rig));
        $rig = str_replace(
            ['ARJ-', 'API-', 'ARJ ', 'API '],
            '',
            $rig
        );
        $template->setValue(
            'rig',
            $this->cleanValue($rig)
        );
        $template->setValue(
            'status',
            $this->cleanValue($request->status_personel)
        );
        $template->setValue(
            'old_name',
            $this->cleanValue($request->old_name)
        );
        $template->setValue(
            'old_job',
            $this->cleanValue($request->old_job)
        );
        $template->setValue(
            'reason',
            $this->cleanValue($request->reason)
        );
        $startDate = Carbon::parse($request->start_date);
        $endDate = $request->filled('end_date')
            ? Carbon::parse($request->end_date)
            : $startDate->copy();
        $template->setValue(
            'period',
            $this->cleanValue(
                $this->formatDateRangeIndonesia(
                    $startDate,
                    $endDate
                )
            )
        );
        $template->setValue(
            'new_name',
            $this->cleanValue($request->new_name)
        );
        $template->setValue(
            'new_job',
            $this->cleanValue($request->new_job)
        );
        $template->setValue(
            'mentor_name',
            $this->cleanValue($request->mentor_name)
        );
        $template->setValue(
            'mentor_job',
            $this->cleanValue($request->mentor_job)
        );
        $checklistMap = [
            'a' => 'badge',
            'c' => 'iadc',
            'd' => 'apps',
            'e' => 'oups',
            'f' => 'omps',
            'g' => 'olps',
            'h' => 'tkbt',
            'i' => 'lop',
            'j' => 'k3',
            'k' => 'sim',
            'l' => 'apb',
            'm' => 'jb',
            'n' => 'olb',
            'o' => 'omb',
            'sio' => 'sio',
            'q' => 'k3_disnaker',
            'r' => 'rigger',
            's' => 'mcu',
            't' => 'kp',
            'u' => 'mcu_vaccine',
            'v' => 'self_declaration',
        ];
        foreach ($checklistMap as $placeholder => $field) {
            $template->setValue(
                $placeholder,
                $this->cleanValue(
                    $request->input($field, '')
                )
            );
        }
        $template->setValue(
            'other',
            $this->cleanValue(
                $request->other_certificate
            )
        );
        $template->setValue('w', $request->sse_yes_no === 'Yes' ? 'V' : '');
            $template->setValue('wy', $request->sse_yes_no === 'No' ? 'V' : '');
        $template->setValue('x', $request->apd_yes_no === 'Yes' ? 'V' : '');
            $template->setValue('xy', $request->apd_yes_no === 'No' ? 'V' : '');
        $template->setValue('y', $request->training_yes_no === 'Yes' ? 'V' : '');
            $template->setValue('yy', $request->training_yes_no === 'No' ? 'V' : '');
        $documentDate = Carbon::parse(
            $request->document_date
        );
        /*
         * Mengikuti Generate Word yang sekarang:
         * placeholder ${date} diisi tanggal + bulan + tahun dari form web.
         * Tahun mengikuti document_date yang dipilih di web.
         */
        $template->setValue(
            'date',
            $this->cleanValue(
                $this->formatDateWithoutYearIndonesia(
                    $documentDate
                ) . ' ' . $documentDate->year
            )
        );
        $fieldCoordinator = Signature::find(
            $request->field_coordinator_signature_id
        );
        $toolPusher = Signature::find(
            $request->tool_pusher_signature_id
        );
        $rigSupt = Signature::find(
            $request->rig_supt_signature_id
        );
        $areaManager = Signature::find(
            $request->area_manager_signature_id
        );
        $template->setValue(
            'name_fc',
            $this->cleanValue(
                $fieldCoordinator?->name
            )
        );
        $template->setValue(
            'name_tp',
            $this->cleanValue(
                $toolPusher?->name
            )
        );
        $template->setValue(
            'name_rs',
            $this->cleanValue(
                $rigSupt?->name
            )
        );
        $template->setValue(
            'name_am',
            $this->cleanValue(
                $areaManager?->name
            )
        );
        $this->setStoredSignature(
            $template,
            $variables,
            's_fc',
            $fieldCoordinator
        );
        $this->setStoredSignature(
            $template,
            $variables,
            's_tp',
            $toolPusher
        );
        $this->setStoredSignature(
            $template,
            $variables,
            's_rs',
            $rigSupt
        );
        $this->setStoredSignature(
            $template,
            $variables,
            's_am',
            $areaManager
        );
        $template->saveAs($outputPath);
        if (
            !file_exists($outputPath) ||
            filesize($outputPath) === 0
        ) {
            throw new \RuntimeException(
                'File Word sumber PDF gagal dibuat.'
            );
        }
    }
    /*
    |--------------------------------------------------------------------------
    | WORD -> PDF
    |--------------------------------------------------------------------------
    |
    | Prioritas 1: Microsoft Word melalui PowerShell COM.
    | Ini memberikan hasil paling dekat dengan file Word asli.
    |
    | Fallback: LibreOffice headless.
    |
    */
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
                    '\\System32\\WindowsPowerShell\\v1.0\\powershell.exe'
                : null,
            'C:\\Windows\\System32\\WindowsPowerShell\\v1.0\\powershell.exe',
            'powershell.exe',
        ];
        foreach ($candidates as $candidate) {
            if (!$candidate) {
                continue;
            }
            if (
                str_contains($candidate, '\\') &&
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
                    '\\LibreOffice\\program\\soffice.exe';
            }
            if ($programFilesX86) {
                $candidates[] =
                    $programFilesX86 .
                    '\\LibreOffice\\program\\soffice.exe';
            }
            $candidates[] =
                'C:\\Program Files\\LibreOffice\\program\\soffice.exe';
            $candidates[] =
                'C:\\Program Files (x86)\\LibreOffice\\program\\soffice.exe';
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
        $storedPath = str_replace(
            '\\\\',
            '/',
            trim((string) $signature->file_path)
        );
        $candidates = [];
        if (
            preg_match('/^[A-Za-z]:**\\/**/', $storedPath) ||
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
                file_exists($candidate) &&
                is_file($candidate) &&
                @getimagesize($candidate) !== false
            ) {
                return $this->getPublicImageDataUri($candidate);
            }
        }
        throw new \RuntimeException(
            'File tanda tangan "' .
            ($signature->name ?? 'Tanpa Nama') .
            '" tidak ditemukan. Path database: ' .
            $signature->file_path
        );
    }
    /*
    |--------------------------------------------------------------------------
    | ISO PNG -> DATA URI
    |--------------------------------------------------------------------------
    |
    | Dibuat khusus agar wkhtmltopdf Windows tidak bergantung pada
    | mime_content_type() atau file:///. File ISO.png dibaca langsung
    | dan dipaksa sebagai image/png.
    |
    */
    private function getIsoImageDataUri(): ?string
    {
        $path = public_path('images/ISO.png');
        if (!file_exists($path) || !is_file($path)) {
            throw new \RuntimeException(
                'ISO.png tidak ditemukan di: ' . $path
            );
        }
        $contents = file_get_contents($path);
        if ($contents === false || $contents === '') {
            throw new \RuntimeException(
                'ISO.png tidak dapat dibaca: ' . $path
            );
        }
        if (@getimagesize($path) === false) {
            throw new \RuntimeException(
                'ISO.png bukan file gambar PNG yang valid: ' . $path
            );
        }
        return 'data:image/png;base64,' . base64_encode($contents);
    }
    /*
    |--------------------------------------------------------------------------
    | IMAGE -> DATA URI
    |--------------------------------------------------------------------------
    */
    private function getPublicImageDataUri(
        string $path
    ): ?string {
        if (!file_exists($path) || !is_file($path)) {
            return null;
        }
        $mime = mime_content_type($path);
        if (!in_array(
            $mime,
            ['image/png', 'image/jpeg', 'image/jpg'],
            true
        )) {
            return null;
        }
        return
            'data:' .
            $mime .
            ';base64,' .
            base64_encode(file_get_contents($path));
    }
    /*
    |--------------------------------------------------------------------------
    | SIGNATURE LIBRARY → WORD
    |--------------------------------------------------------------------------
    */
    private function setStoredSignature(
        TemplateProcessor $template,
        array $variables,
        string $placeholder,
        ?Signature $signature
    ): void {
        /*
        |--------------------------------------------------------------------------
        | CEK PLACEHOLDER WORD
        |--------------------------------------------------------------------------
        */
        if (!in_array(
            $placeholder,
            $variables,
            true
        )) {
            throw new \Exception(
                'Placeholder ${' .
                $placeholder .
                '} tidak ditemukan di template Surat Tugas.'
            );
        }
        /*
        |--------------------------------------------------------------------------
        | TANPA TANDA TANGAN
        |--------------------------------------------------------------------------
        */
        if (!$signature) {
            $template->setValue(
                $placeholder,
                ''
            );
            return;
        }
        /*
        |--------------------------------------------------------------------------
        | PATH DATABASE
        |--------------------------------------------------------------------------
        */
        $relativePath = ltrim(
            str_replace(
                '\\\\',
                '/',
                (string) $signature->file_path
            ),
            '/'
        );
        /*
        |--------------------------------------------------------------------------
        | CARI FILE TTD
        |--------------------------------------------------------------------------
        */
        $possiblePaths = [
            storage_path(
                'app/' .
                $relativePath
            ),
            storage_path(
                'app/private/' .
                $relativePath
            ),
            storage_path(
                'app/public/' .
                $relativePath
            ),
        ];
        /*
        |--------------------------------------------------------------------------
        | PATH PUBLIC
        |--------------------------------------------------------------------------
        */
        if (
            str_starts_with(
                $relativePath,
                'public/'
            )
        ) {
            $withoutPublic =
                substr(
                    $relativePath,
                    strlen('public/')
                );
            $possiblePaths[] =
                storage_path(
                    'app/public/' .
                    $withoutPublic
                );
        }
        /*
        |--------------------------------------------------------------------------
        | PATH PRIVATE
        |--------------------------------------------------------------------------
        */
        if (
            str_starts_with(
                $relativePath,
                'private/'
            )
        ) {
            $withoutPrivate =
                substr(
                    $relativePath,
                    strlen('private/')
                );
            $possiblePaths[] =
                storage_path(
                    'app/private/' .
                    $withoutPrivate
                );
        }
        /*
        |--------------------------------------------------------------------------
        | TEMUKAN FILE
        |--------------------------------------------------------------------------
        */
        $signaturePath =
            null;
        foreach (
            $possiblePaths
            as $possiblePath
        ) {
            if (
                file_exists(
                    $possiblePath
                )
            ) {
                $signaturePath =
                    $possiblePath;
                break;
            }
        }
        /*
        |--------------------------------------------------------------------------
        | FILE TIDAK ADA
        |--------------------------------------------------------------------------
        */
        if (!$signaturePath) {
            throw new \Exception(
                'File tanda tangan "' .
                $signature->name .
                '" tidak ditemukan. Path database: ' .
                $signature->file_path
            );
        }
        /*
        |--------------------------------------------------------------------------
        | VALIDASI GAMBAR
        |--------------------------------------------------------------------------
        */
        if (
            @getimagesize(
                $signaturePath
            ) === false
        ) {
            throw new \Exception(
                'File tanda tangan "' .
                $signature->name .
                '" bukan gambar yang valid.'
            );
        }
        /*
        |--------------------------------------------------------------------------
        | MASUKKAN GAMBAR KE WORD
        |--------------------------------------------------------------------------
        |
        | FIX:
        |
        | Ukuran sebelumnya:
        |
        | width  = 110
        | height = 50
        |
        | sekarang diperbesar supaya tanda tangan lebih jelas
        | dan tetap proporsional dengan nama/jabatan.
        |
        */
        /*
        |--------------------------------------------------------------------------
        | POTONG AREA KOSONG TANDA TANGAN
        |--------------------------------------------------------------------------
        |
        | Signature Library sering menyimpan PNG/JPG dengan canvas putih/transparan
        | yang lebar. Kalau gambar langsung dibesarkan, yang membesar justru canvas
        | kosongnya dan Word dapat mendorong layout menjadi 2 halaman.
        |
        | Di sini gambar dipotong otomatis ke area tinta tanda tangan, lalu baru
        | dimasukkan ke template. Hasil tanda tangan terlihat lebih besar tanpa
        | membutuhkan ukuran image yang berlebihan.
        |
        */
        $signaturePath = $this->prepareSignatureImage($signaturePath);
        /*
        |--------------------------------------------------------------------------
        | UKURAN TANDA TANGAN PER POSISI
        |--------------------------------------------------------------------------
        |
        | Ukuran Tool Pusher dan Rig Supt dibuat seimbang agar keduanya
        | tetap jelas tanpa saling bertabrakan di baris template.
        |
        */
        $signatureWidth = 84;
        $signatureHeight = 42;
        if ($placeholder === 's_fc') {
            $signatureWidth = 110;
            $signatureHeight = 48;
        }

        $template->setImageValue(
            $placeholder,
            [
                'path' =>
                    $signaturePath,
                'width' =>
                    $signatureWidth,
                'height' =>
                    $signatureHeight,
                'ratio' =>
                    true,
            ]
        );
    }
    /*
    |--------------------------------------------------------------------------
    | FORMAT PERIODE
    |--------------------------------------------------------------------------
    |
    | 03 s/d 09 September 2026
    |
    */
    /*
    |--------------------------------------------------------------------------
    | TRIM SIGNATURE IMAGE
    |--------------------------------------------------------------------------
    |
    | Menghapus margin putih/transparan di sekeliling gambar tanda tangan.
    | Tujuan utamanya agar tinta tanda tangan terlihat besar, tetapi kotak gambar
    | yang dimasukkan ke Word tetap cukup kecil sehingga PDF tidak menjadi 2 halaman.
    |
    */
    private function prepareSignatureImage(string $sourcePath): string
    {
        if (!extension_loaded('gd')) {
            return $sourcePath;
        }
        $imageInfo = @getimagesize($sourcePath);
        if ($imageInfo === false) {
            return $sourcePath;
        }
        $mime = strtolower((string) ($imageInfo['mime'] ?? ''));
        try {
            if ($mime === 'image/png') {
                $image = @imagecreatefrompng($sourcePath);
            } elseif ($mime === 'image/jpeg' || $mime === 'image/jpg') {
                $image = @imagecreatefromjpeg($sourcePath);
            } else {
                return $sourcePath;
            }
        } catch (\Throwable $e) {
            return $sourcePath;
        }
        if (!$image) {
            return $sourcePath;
        }
        $width = imagesx($image);
        $height = imagesy($image);
        if ($width <= 1 || $height <= 1) {
            imagedestroy($image);
            return $sourcePath;
        }
        $minX = $width;
        $minY = $height;
        $maxX = -1;
        $maxY = -1;
        /*
         * Pixel dianggap bagian tanda tangan jika:
         * - tidak transparan, dan
         * - bukan putih / hampir putih.
         *
         * Threshold 242 sengaja cukup longgar supaya tinta biru yang tipis tetap
         * ikut terbaca saat cropping.
         */
        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                $rgba = imagecolorat($image, $x, $y);
                $alpha = ($rgba & 0x7F000000) >> 24;
                $red = ($rgba >> 16) & 0xFF;
                $green = ($rgba >> 8) & 0xFF;
                $blue = $rgba & 0xFF;
                $isVisible = $alpha < 120;
                $isNotWhite = ($red < 242 || $green < 242 || $blue < 242);
                if ($isVisible && $isNotWhite) {
                    if ($x < $minX) $minX = $x;
                    if ($y < $minY) $minY = $y;
                    if ($x > $maxX) $maxX = $x;
                    if ($y > $maxY) $maxY = $y;
                }
            }
        }
        if ($maxX < $minX || $maxY < $minY) {
            imagedestroy($image);
            return $sourcePath;
        }
        /* Sedikit padding supaya ujung tinta tidak terlalu mepet. */
        $paddingX = max(4, (int) round(($maxX - $minX + 1) * 0.04));
        $paddingY = max(4, (int) round(($maxY - $minY + 1) * 0.08));
        $cropX = max(0, $minX - $paddingX);
        $cropY = max(0, $minY - $paddingY);
        $cropRight = min($width - 1, $maxX + $paddingX);
        $cropBottom = min($height - 1, $maxY + $paddingY);
        $cropWidth = $cropRight - $cropX + 1;
        $cropHeight = $cropBottom - $cropY + 1;
        $cropped = imagecreatetruecolor($cropWidth, $cropHeight);
        if (!$cropped) {
            imagedestroy($image);
            return $sourcePath;
        }
        imagealphablending($cropped, false);
        imagesavealpha($cropped, true);
        $transparent = imagecolorallocatealpha($cropped, 255, 255, 255, 127);
        imagefill($cropped, 0, 0, $transparent);
        imagecopy(
            $cropped,
            $image,
            0,
            0,
            $cropX,
            $cropY,
            $cropWidth,
            $cropHeight
        );
        $cacheDirectory = storage_path('app/generated/signature-cache');
        if (!is_dir($cacheDirectory)) {
            @mkdir($cacheDirectory, 0775, true);
        }
        if (!is_dir($cacheDirectory)) {
            imagedestroy($cropped);
            imagedestroy($image);
            return $sourcePath;
        }
        $cacheName = sha1(
            $sourcePath . '|' .
            (string) @filemtime($sourcePath) . '|' .
            (string) @filesize($sourcePath)
        ) . '.png';
        $outputPath = $cacheDirectory . DIRECTORY_SEPARATOR . $cacheName;
        $saved = @imagepng($cropped, $outputPath, 6);
        imagedestroy($cropped);
        imagedestroy($image);
        if (!$saved || !file_exists($outputPath)) {
            return $sourcePath;
        }
        return $outputPath;
    }
    private function formatDateRangeIndonesia(
        Carbon $start,
        Carbon $end
    ): string {
        $months =
            $this->months();
        /*
        |--------------------------------------------------------------------------
        | SATU HARI
        |--------------------------------------------------------------------------
        |
        | Jika tanggal selesai dikosongkan, controller memakai tanggal mulai
        | sebagai tanggal selesai. Jika keduanya sama, output hanya:
        |
        | 22 September 2026
        |
        | Bukan:
        | 22 s/d 22 September 2026
        |
        */
        if ($start->isSameDay($end)) {
            return
                $start->format('d') .
                ' ' .
                $months[$start->month] .
                ' ' .
                $start->year;
        }
        if (
            $start->month ===
                $end->month
            &&
            $start->year ===
                $end->year
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
    | FORMAT TANGGAL TANPA TAHUN
    |--------------------------------------------------------------------------
    |
    | Contoh:
    |
    | 03 September 2027
    |
    */
    private function formatDateWithoutYearIndonesia(
        Carbon $date
    ): string {
        $months =
            $this->months();
        return
            $date->format('d') .
            ' ' .
            $months[$date->month];
    }
    /*
    |--------------------------------------------------------------------------
    | BULAN INDONESIA
    |--------------------------------------------------------------------------
    */
    private function months(): array
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
    | CLEAN VALUE
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
        $templatePath =
            storage_path(
                'app/templates/Surat Tugas - FINAL PLACEHOLDER.docx'
            );
        if (!file_exists(
            $templatePath
        )) {
            return response()->json([
                'status' =>
                    'ERROR',
                'message' =>
                    'Template Surat Tugas tidak ditemukan.',
                'path' =>
                    $templatePath,
            ]);
        }
        try {
            $template =
                new TemplateProcessor(
                    $templatePath
                );
            $variables =
                $template->getVariables();
            return response()->json([
                'status' =>
                    'OK',
                'template_path' =>
                    $templatePath,
                'template_size' =>
                    filesize(
                        $templatePath
                    ),
                'variables' =>
                    $variables,
                /*
                |--------------------------------------------------------------------------
                | CEK TTD
                |--------------------------------------------------------------------------
                */
                'signature_placeholders' => [
                    's_fc' =>
                        in_array(
                            's_fc',
                            $variables,
                            true
                        ),
                    's_tp' =>
                        in_array(
                            's_tp',
                            $variables,
                            true
                        ),
                    's_rs' =>
                        in_array(
                            's_rs',
                            $variables,
                            true
                        ),
                    's_am' =>
                        in_array(
                            's_am',
                            $variables,
                            true
                        ),
                ],
                /*
                |--------------------------------------------------------------------------
                | CEK NAMA
                |--------------------------------------------------------------------------
                */
                'name_placeholders' => [
                    'name_fc' =>
                        in_array(
                            'name_fc',
                            $variables,
                            true
                        ),
                    'name_tp' =>
                        in_array(
                            'name_tp',
                            $variables,
                            true
                        ),
                    'name_rs' =>
                        in_array(
                            'name_rs',
                            $variables,
                            true
                        ),
                    'name_am' =>
                        in_array(
                            'name_am',
                            $variables,
                            true
                        ),
                ],
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' =>
                    'ERROR',
                'message' =>
                    $e->getMessage(),
            ]);
        }
    }
    private function downloadFileName(string $title, string $extension): string
    {
        $name = rtrim(str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', trim($title)), ' .-');
        return ($name !== '' ? $name : 'Surat Tugas') . '.' . $extension;
    }
}
