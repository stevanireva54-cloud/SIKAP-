<?php

namespace App\Http\Controllers;

use App\Models\Document;

use App\Models\Signature;

use Illuminate\Http\Request;

use Illuminate\Support\Str;

use PhpOffice\PhpWord\Settings;

use PhpOffice\PhpWord\TemplateProcessor;

class MocController extends Controller

{

    /*

    |--------------------------------------------------------------------------

    | FORM MOC

    |--------------------------------------------------------------------------

    */

    public function create()

    {

        $signatures = Signature::orderBy('name', 'asc')->get();

        return view('moc.create', compact('signatures'));

    }

    /*

    |--------------------------------------------------------------------------

    | GENERATE MOC

    |--------------------------------------------------------------------------

    */

    public function generate(Request $request)

    {
        $revision = \App\Services\DocumentRevision::get('moc');
        $request->merge($revision);


        $request->validate([

            /*

            |--------------------------------------------------------------------------

            | DOCUMENT

            |--------------------------------------------------------------------------

            */

            'document_title' => 'required|string|max:255',

            'moc_number' => 'required|string|max:255',

            /*

            |--------------------------------------------------------------------------

            | USULAN MOC

            |--------------------------------------------------------------------------

            */

            'nama_pengusul' => 'nullable|string|max:255',

            /*

            |--------------------------------------------------------------------------

            | INFORMASI PERUBAHAN

            |--------------------------------------------------------------------------

            */

            'department' => 'nullable|string|max:255',

            'proses' => 'nullable|string|max:255',

            'jenis_bahaya' => 'nullable|string|max:255',

            'peralatan' => 'nullable|string|max:255',

            'lokasi' => 'nullable|string|max:255',

            'prosedur' => 'nullable|string|max:255',

            'lain_lain' => 'nullable|string|max:255',

            /*

            |--------------------------------------------------------------------------

            | PERUBAHAN

            |--------------------------------------------------------------------------

            */

            'tujuan_perubahan' => 'nullable|string',

            'hasil_perubahan' => 'nullable|string',

            'penilaian_resiko' => 'nullable|string',

            /*

            |--------------------------------------------------------------------------

            | RISK

            |--------------------------------------------------------------------------

            */

            'overall_risk' => 'nullable|in:TINGGI,SEDANG,RENDAH',

            /*

            |--------------------------------------------------------------------------

            | K3LL

            |--------------------------------------------------------------------------

            */

            'penelitian_bahaya' => 'nullable|in:YA,TIDAK',

            'risk_register_action_plan' => 'required|string',

            'bahaya_baru' => 'nullable|string',

            'kemungkinan_insiden' => 'nullable|string',

            /*

            |--------------------------------------------------------------------------

            | IMPACT

            |--------------------------------------------------------------------------

            */

            'impact.*.keterangan' => 'nullable|string',

            'impact.*.status' => 'nullable|in:YA,TIDAK,N/A',

            /*

            |--------------------------------------------------------------------------

            | INFORMASI

            |--------------------------------------------------------------------------

            */

            'informasi.*.nama_jabatan' => 'nullable|string|max:255',

            'informasi.*.departemen' => 'nullable|string|max:255',

            'informasi.*.keterangan' => 'nullable|in:Diterima,Ditolak',

            /*

            |--------------------------------------------------------------------------

            | DIPERIKSA

            |--------------------------------------------------------------------------

            */

            'diperiksa.*.nama' => 'nullable|string|max:255',

            'diperiksa.*.jabatan' => 'nullable|string|max:255',

            'diperiksa.*.tanggal' => 'nullable|date',

            'diperiksa.*.status' => 'nullable|in:Diterima,Ditolak',

            /*

            |--------------------------------------------------------------------------

            | DISETUJUI

            |--------------------------------------------------------------------------

            */

            'approval.0.nama' => 'nullable|string|max:255',

            'approval.1.nama' => 'nullable|string|max:255',

            /*

            | Sekarang TTD dari Signature Library

            */

            'approval.0.signature_id' =>

                'nullable|exists:signatures,id',

            'approval.1.signature_id' =>

                'nullable|exists:signatures,id',

            /*

            |--------------------------------------------------------------------------

            | PENUTUP

            |--------------------------------------------------------------------------

            */

            'tanggal_efektif' => 'nullable|date',

            'kontak_person' => 'nullable|string|max:255',

        ]);

        /*

        |--------------------------------------------------------------------------

        | TEMPLATE

        |--------------------------------------------------------------------------

        |

        | Aku pertahankan nama template yang controller kamu sekarang pakai.

        |

        */

        $templatePath = storage_path(

            'app/templates/API - Formulir MOC - FINAL-PLACEHOLDER.docx'

        );

        if (!file_exists($templatePath)) {

            return back()

                ->withInput()

                ->with(

                    'error',

                    'Template MOC tidak ditemukan di: ' . $templatePath

                );

        }

        try {

            Settings::setOutputEscapingEnabled(true);

            $template = new TemplateProcessor($templatePath);
            $template->setValue('rev_date', $request->input('rev_date'));
            $template->setValue('rev_no', $request->input('rev_no'));

            $variables = $template->getVariables();

            /*

            |--------------------------------------------------------------------------

            | MOC NUMBER

            |--------------------------------------------------------------------------

            */

            $template->setValue(

                'moc_number',

                $request->input('moc_number', '')

            );

            /*

            |--------------------------------------------------------------------------

            | USULAN MOC

            |--------------------------------------------------------------------------

            */

            $template->setValue(

                'pengusul_nama',

                $request->input('nama_pengusul', '')

            );

            /*

            | Permanen

            */

            $template->setValue(

                'pengusul_departemen',

                'Operation Rig'

            );

            $template->setValue(

                'pengusul_jabatan',

                'Area Manager'

            );

            /*

            |--------------------------------------------------------------------------

            | INFORMASI PERUBAHAN

            |--------------------------------------------------------------------------

            */

            $template->setValue(

                'department',

                $request->input('department', '')

            );

            /*

            | Permanen

            */

            $template->setValue(

                'pekerja',

                'WOWS'

            );

            $template->setValue(

                'proses',

                $request->input('proses', '')

            );

            $template->setValue(

                'jenis_bahaya',

                $request->input('jenis_bahaya', '')

            );

            $template->setValue(

                'peralatan',

                $request->input('peralatan', '')

            );

            $template->setValue(

                'lokasi',

                $request->input('lokasi', '')

            );

            $template->setValue(

                'prosedur',

                $request->input('prosedur', '')

            );

            $template->setValue(

                'lain_lain',

                $request->input('lain_lain', '')

            );

            /*

            |--------------------------------------------------------------------------

            | PERUBAHAN KHUSUS

            |--------------------------------------------------------------------------

            */

            $template->setValue(

                'tujuan_perubahan',

                $request->input('tujuan_perubahan', '')

            );

            $template->setValue(

                'hasil_perubahan',

                $request->input('hasil_perubahan', '')

            );

            /*

            |--------------------------------------------------------------------------

            | PENILAIAN RESIKO - KETERANGAN

            |--------------------------------------------------------------------------

            | Template Word menggunakan ${penilaian_Resiko}.

            | Field form tetap bernama penilaian_resiko.

            */

            $penilaianResiko = $request->input('penilaian_resiko', '');

            $template->setValue(

                'penilaian_Resiko',

                $penilaianResiko

            );

            // Tetap isi versi lowercase juga untuk kompatibilitas template lain.

            $template->setValue(

                'penilaian_resiko',

                $penilaianResiko

            );

            /*

            |--------------------------------------------------------------------------

            | PENILAIAN RESIKO

            |--------------------------------------------------------------------------

            */

            $risk = $request->input('overall_risk', '');

            $template->setValue(

                'risk_tinggi',

                $risk === 'TINGGI' ? 'X' : ''

            );

            $template->setValue(

                'risk_sedang',

                $risk === 'SEDANG' ? 'X' : ''

            );

            $template->setValue(

                'risk_rendah',

                $risk === 'RENDAH' ? 'X' : ''

            );

            $template->setValue(

                'overall_risk_label',

                $risk !== '' ? ucfirst(strtolower($risk)) : ''

            );

            /*

            |--------------------------------------------------------------------------

            | PEMERIKSAAN K3LL

            |--------------------------------------------------------------------------

            */

            $penelitianBahaya = $request->input('penelitian_bahaya', '');

            $template->setValue(

                'penelitian_bahaya',

                $penelitianBahaya

            );

            $template->setValue(

                'penelitian_bahaya_display',

                $penelitianBahaya === 'YA' ? 'Ya' : ($penelitianBahaya === 'TIDAK' ? 'Tidak' : '')

            );

            $template->setValue(

                'risk_register_action_plan',

                $request->input('risk_register_action_plan', '')

            );

            $template->setValue(

                'bahaya_baru',

                $request->input('bahaya_baru', '')

            );

            $template->setValue(

                'kemungkinan_insiden',

                $request->input('kemungkinan_insiden', '')

            );

            /*

            |--------------------------------------------------------------------------

            | DAMPAK PERUBAHAN 1 - 9

            |--------------------------------------------------------------------------

            */

            $impact = $request->input('impact', []);

            for ($i = 1; $i <= 9; $i++) {

                $row = $impact[$i] ?? [];

                $template->setValue(

                    "impact_{$i}_keterangan",

                    $row['keterangan'] ?? ''

                );

                $template->setValue(

                    "impact_{$i}_status",

                    $row['status'] ?? ''

                );

            }

            /*

            |--------------------------------------------------------------------------

            | SIAPA YANG PERLU DIINFORMASIKAN

            |--------------------------------------------------------------------------

            */

            $informasi = array_values(

                $request->input('informasi', [])

            );

            for ($i = 0; $i < 6; $i++) {

                $row = $informasi[$i] ?? [];

                $template->setValue(

                    "informasi_{$i}_nama_jabatan",

                    $row['nama_jabatan'] ?? ''

                );

                $template->setValue(

                    "informasi_{$i}_departemen",

                    $row['departemen'] ?? ''

                );

                $template->setValue(

                    "informasi_{$i}_keterangan",

                    $row['keterangan'] ?? ''

                );

            }

            /*

            |--------------------------------------------------------------------------

            | DIPERIKSA OLEH

            |--------------------------------------------------------------------------

            */

            $diperiksa = array_values(

                $request->input('diperiksa', [])

            );

            for ($i = 0; $i < 2; $i++) {

                $row = $diperiksa[$i] ?? [];

                $tanggal = $row['tanggal'] ?? '';

                if (!empty($tanggal)) {

                    $tanggal = date(

                        'd/m/y',

                        strtotime($tanggal)

                    );

                }

                $template->setValue(

                    "diperiksa_{$i}_nama",

                    $row['nama'] ?? ''

                );

                $template->setValue(

                    "diperiksa_{$i}_jabatan",

                    $row['jabatan'] ?? ''

                );

                $template->setValue(

                    "diperiksa_{$i}_tanggal",

                    $tanggal

                );

                $template->setValue(

                    "diperiksa_{$i}_status",

                    $row['status'] ?? ''

                );

            }

            /*

            |--------------------------------------------------------------------------

            | DISETUJUI OLEH

            |--------------------------------------------------------------------------

            */

            $approval = $request->input(

                'approval',

                []

            );

            /*

            |--------------------------------------------------------------------------

            | AMBIL TTD DARI SIGNATURE LIBRARY

            |--------------------------------------------------------------------------

            */

            $rigSignature = Signature::find(

                $approval[0]['signature_id'] ?? null

            );

            $areaSignature = Signature::find(

                $approval[1]['signature_id'] ?? null

            );

            /*

            |--------------------------------------------------------------------------

            | NAMA PENANDATANGAN

            |--------------------------------------------------------------------------

            |

            | Kalau kolom Nama di form kosong, otomatis ambil nama dari

            | Signature Library yang dipilih.

            |

            */

            $rigName = trim(

                (string) ($approval[0]['nama'] ?? '')

            );

            if ($rigName === '' && $rigSignature) {

                $rigName = (string) $rigSignature->name;

            }

            $areaName = trim(

                (string) ($approval[1]['nama'] ?? '')

            );

            if ($areaName === '' && $areaSignature) {

                $areaName = (string) $areaSignature->name;

            }

            $template->setValue(

                'rig_superintendent_nama',

                $rigName

            );

            $template->setValue(

                'area_manager_nama',

                $areaName

            );

            /*

            |--------------------------------------------------------------------------

            | TTD RIG SUPERINTENDENT

            |--------------------------------------------------------------------------

            */

            $this->setStoredSignature(

                $template,

                $variables,

                'rig_superintendent_signature',

                $rigSignature

            );

            /*

            |--------------------------------------------------------------------------

            | TTD AREA MANAGER

            |--------------------------------------------------------------------------

            */

            $this->setStoredSignature(

                $template,

                $variables,

                'area_manager_signature',

                $areaSignature

            );

            /*

            |--------------------------------------------------------------------------

            | TANGGAL EFEKTIF

            |--------------------------------------------------------------------------

            */

            $tanggalEfektif = $request->input(

                'tanggal_efektif',

                ''

            );

            if (!empty($tanggalEfektif)) {

                $tanggalEfektif = date(

                    'd/m/y',

                    strtotime($tanggalEfektif)

                );

            }

            $template->setValue(

                'tanggal_efektif',

                $tanggalEfektif

            );

            /*

            |--------------------------------------------------------------------------

            | KONTAK PERSON

            |--------------------------------------------------------------------------

            */

            $template->setValue(

                'kontak_person',

                $request->input(

                    'kontak_person',

                    ''

                )

            );

            /*

            |--------------------------------------------------------------------------

            | OUTPUT FOLDER

            |--------------------------------------------------------------------------

            */

            $outputDirectory = storage_path(

                'app/generated'

            );

            if (!is_dir($outputDirectory)) {

                mkdir(

                    $outputDirectory,

                    0775,

                    true

                );

            }

            /*

            |--------------------------------------------------------------------------

            | FILE NAME DARI DOCUMENT TITLE

            |--------------------------------------------------------------------------

            */

            $safeTitle = Str::slug(

                $request->document_title

            );

            if (empty($safeTitle)) {

                $safeTitle = 'moc';

            }

            $fileName =

                $safeTitle .

                '-' .

                date('Ymd-His') .

                '.docx';

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

                'document_type' => 'moc',

                'document_title' => $request->document_title,

                'employee_name' => $request->input('nama_pengusul'),

                'file_name' => $fileName,

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

                    $fileName

                )

                ->deleteFileAfterSend(false);

        } catch (\Throwable $e) {

            return back()

                ->withInput()

                ->with(

                    'error',

                    'Gagal generate MOC: ' .

                    $e->getMessage()

                );

        }

    }

    /*

    |--------------------------------------------------------------------------

    | GENERATE MOC PDF

    |--------------------------------------------------------------------------

    */

    public function generatePdf(Request $request)

    {
        $revision = \App\Services\DocumentRevision::get('moc');
        $request->merge($revision);


        $request->validate([

            'document_title' => 'required|string|max:255',

            'moc_number' => 'required|string|max:255',

            'nama_pengusul' => 'nullable|string|max:255',

            'department' => 'nullable|string|max:255',

            'proses' => 'nullable|string|max:255',

            'jenis_bahaya' => 'nullable|string|max:255',

            'peralatan' => 'nullable|string|max:255',

            'lokasi' => 'nullable|string|max:255',

            'prosedur' => 'nullable|string|max:255',

            'lain_lain' => 'nullable|string|max:255',

            'tujuan_perubahan' => 'nullable|string',

            'hasil_perubahan' => 'nullable|string',

            'penilaian_resiko' => 'nullable|string',

            'overall_risk' => 'nullable|in:TINGGI,SEDANG,RENDAH',

            'penelitian_bahaya' => 'nullable|in:YA,TIDAK',

            'risk_register_action_plan' => 'required|string',

            'bahaya_baru' => 'nullable|string',

            'kemungkinan_insiden' => 'nullable|string',

            'impact.*.keterangan' => 'nullable|string',

            'impact.*.status' => 'nullable|in:YA,TIDAK,N/A',

            'informasi.*.nama_jabatan' => 'nullable|string|max:255',

            'informasi.*.departemen' => 'nullable|string|max:255',

            'informasi.*.keterangan' => 'nullable|in:Diterima,Ditolak',

            'diperiksa.*.nama' => 'nullable|string|max:255',

            'diperiksa.*.jabatan' => 'nullable|string|max:255',

            'diperiksa.*.tanggal' => 'nullable|date',

            'diperiksa.*.status' => 'nullable|in:Diterima,Ditolak',

            'approval.0.nama' => 'nullable|string|max:255',

            'approval.1.nama' => 'nullable|string|max:255',

            'approval.0.signature_id' => 'nullable|exists:signatures,id',

            'approval.1.signature_id' => 'nullable|exists:signatures,id',

            'tanggal_efektif' => 'nullable|date',

            'kontak_person' => 'nullable|string|max:255',

        ]);

        try {

            $data = $request->all();

            // Sesuaikan jumlah baris dengan template resmi MOC:

            // 6 pihak yang perlu diinformasikan dan 2 pemeriksa.

            $data['informasi'] = array_slice(array_values($request->input('informasi', [])), 0, 6);

            $data['diperiksa'] = array_slice(

                array_values($request->input('diperiksa', [])),

                0,

                2

            );

            $approval = $request->input('approval', []);

            $rigSignature = Signature::find(

                $approval[0]['signature_id'] ?? null

            );

            $areaSignature = Signature::find(

                $approval[1]['signature_id'] ?? null

            );

            $rigName = trim(

                (string) ($approval[0]['nama'] ?? '')

            );

            if ($rigName === '' && $rigSignature) {

                $rigName = (string) $rigSignature->name;

            }

            $areaName = trim(

                (string) ($approval[1]['nama'] ?? '')

            );

            if ($areaName === '' && $areaSignature) {

                $areaName = (string) $areaSignature->name;

            }

            $data['approval'][0]['nama'] = $rigName;

            $data['approval'][1]['nama'] = $areaName;

            $rigSignatureData = $this->getSignatureDataUri(

                $rigSignature

            );

            $areaSignatureData = $this->getSignatureDataUri(

                $areaSignature

            );

            $html = view(

                'pdf.moc',

                compact(

                    'data',

                    'rigSignatureData',

                    'areaSignatureData'

                )

            )->render();

            $pdf = app('snappy.pdf.wrapper');

            $pdf->loadHTML($html);

            $pdf->setPaper('a4');

            $pdf->setOption('encoding', 'UTF-8');

            $pdf->setOption('enable-local-file-access', true);

            $pdf->setOption('print-media-type', true);

            $outputDirectory = storage_path(

                'app/generated'

            );

            if (!is_dir($outputDirectory)) {

                mkdir(

                    $outputDirectory,

                    0775,

                    true

                );

            }

            $safeTitle = Str::slug(

                $request->document_title

            );

            if (empty($safeTitle)) {

                $safeTitle = 'moc';

            }

            $fileName =

                $safeTitle .

                '-' .

                date('Ymd-His') .

                '.pdf';

            $downloadName = rtrim(

                str_replace(

                    ['/', '\\\\\\\\', ':', '*', '?', '"', '<', '>', '|'],

                    '-',

                    trim($request->document_title)

                ),

                ' .-'

            ) . '.pdf';

            $outputPath =

                $outputDirectory .

                DIRECTORY_SEPARATOR .

                $fileName;

            file_put_contents(

                $outputPath,

                $pdf->output()

            );

            Document::create([

                'form_data' => \App\Services\DocumentSnapshot::capture($request->input()),

                'user_id' => auth()->id(),

                'document_type' => 'moc',

                'document_title' => $request->document_title,

                'employee_name' => $request->input('nama_pengusul'),

                'file_name' => $downloadName,

                'file_path' => 'generated/' . $fileName,

            ]);

            return response()

                ->download(

                    $outputPath,

                    $downloadName,

                    [

                        'Content-Type' => 'application/pdf',

                    ]

                )

                ->deleteFileAfterSend(false);

        } catch (\Throwable $e) {

            return back()

                ->withInput()

                ->with(

                    'error',

                    'Gagal generate PDF MOC: ' .

                    $e->getMessage()

                );

        }

    }

    /*

    |--------------------------------------------------------------------------

    | SIGNATURE LIBRARY → PDF

    |--------------------------------------------------------------------------

    */

    private function getSignatureDataUri(

        ?Signature $signature

    ): ?string {

        if (!$signature) {

            return null;

        }

        $storedPath = str_replace(

            '\\\\\\\\\\\\\\\\',

            '/',

            trim((string) $signature->file_path)

        );

        $candidates = [];

        if (

            (strlen($storedPath) >= 3 && ctype_alpha($storedPath[0]) && $storedPath[1] === ':' && ($storedPath[2] === '/' || $storedPath[2] === chr(92))) ||

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

        $signaturePath = null;

        foreach (array_unique($candidates) as $candidate) {

            if (

                file_exists($candidate) &&

                is_file($candidate)

            ) {

                $signaturePath = $candidate;

                break;

            }

        }

        if (!$signaturePath) {

            throw new \RuntimeException(

                'File tanda tangan "' .

                ($signature->name ?? 'Tanpa Nama') .

                '" tidak ditemukan. Path database: ' .

                $signature->file_path

            );

        }

        if (@getimagesize($signaturePath) === false) {

            throw new \RuntimeException(

                'File tanda tangan bukan gambar valid: ' .

                $signaturePath

            );

        }

        $mime = mime_content_type(

            $signaturePath

        );

        if (!in_array(

            $mime,

            ['image/png', 'image/jpeg'],

            true

        )) {

            throw new \RuntimeException(

                'Format tanda tangan PDF harus PNG/JPG/JPEG.'

            );

        }

        return

            'data:' .

            $mime .

            ';base64,' .

            base64_encode(

                file_get_contents(

                    $signaturePath

                )

            );

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

        | PLACEHOLDER TIDAK ADA

        |--------------------------------------------------------------------------

        */

        if (!in_array($placeholder, $variables, true)) {

            return;

        }

        /*

        |--------------------------------------------------------------------------

        | TANPA TANDA TANGAN

        |--------------------------------------------------------------------------

        */

        if (!$signature) {

            $template->setValue($placeholder, '');

            return;

        }

        /*

        |--------------------------------------------------------------------------

        | CARI FILE TTD DI SEMUA LOKASI YANG MUNGKIN

        |--------------------------------------------------------------------------

        |

        | Signature Library bisa menyimpan path seperti:

        | signatures/xxx.png

        | public/signatures/xxx.png

        | private/signatures/xxx.png

        | storage/signatures/xxx.png

        |

        */

        $storedPath = str_replace(

            '\\\\\\\\\\\\\\\\',

            '/',

            trim((string) $signature->file_path)

        );

        $candidates = [];

        /*

        | Absolute Windows/Linux path

        */

        if (

            (strlen($storedPath) >= 3 && ctype_alpha($storedPath[0]) && $storedPath[1] === ':' && ($storedPath[2] === '/' || $storedPath[2] === chr(92))) ||

            str_starts_with($storedPath, '/')

        ) {

            $candidates[] = $storedPath;

        }

        /*

        | storage/app/<path>

        */

        $candidates[] = storage_path(

            'app/' . ltrim($storedPath, '/')

        );

        /*

        | storage/app/public/<path>

        */

        $publicRelative = preg_replace(

            '#^public/#',

            '',

            ltrim($storedPath, '/')

        );

        $candidates[] = storage_path(

            'app/public/' . $publicRelative

        );

        /*

        | storage/app/private/<path>

        */

        $privateRelative = preg_replace(

            '#^private/#',

            '',

            ltrim($storedPath, '/')

        );

        $candidates[] = storage_path(

            'app/private/' . $privateRelative

        );

        /*

        | public/<path>

        */

        $candidates[] = public_path(

            ltrim($storedPath, '/')

        );

        /*

        | public/storage/<path>

        */

        $storageRelative = preg_replace(

            '#^storage/#',

            '',

            ltrim($storedPath, '/')

        );

        $candidates[] = public_path(

            'storage/' . $storageRelative

        );

        $signaturePath = null;

        foreach (array_unique($candidates) as $candidate) {

            if (

                file_exists($candidate) &&

                is_file($candidate)

            ) {

                $signaturePath = $candidate;

                break;

            }

        }

        if (!$signaturePath) {

            throw new \RuntimeException(

                'File tanda tangan "' .

                ($signature->name ?? 'Tanpa Nama') .

                '" tidak ditemukan. Path database: ' .

                $signature->file_path

            );

        }

        /*

        |--------------------------------------------------------------------------

        | VALIDASI GAMBAR

        |--------------------------------------------------------------------------

        */

        if (@getimagesize($signaturePath) === false) {

            throw new \RuntimeException(

                'File tanda tangan bukan gambar valid: ' .

                $signaturePath

            );

        }

        /*

        |--------------------------------------------------------------------------

        | COPY KE TEMP AGAR PHPWORD BISA BACA STABIL

        |--------------------------------------------------------------------------

        */

        $extension = strtolower(

            pathinfo($signaturePath, PATHINFO_EXTENSION)

        );

        if (!in_array(

            $extension,

            ['png', 'jpg', 'jpeg'],

            true

        )) {

            throw new \RuntimeException(

                'Format tanda tangan harus PNG/JPG/JPEG.'

            );

        }

        $tempDirectory = storage_path(

            'app/temp-signatures'

        );

        if (!is_dir($tempDirectory)) {

            mkdir(

                $tempDirectory,

                0775,

                true

            );

        }

        $tempSignature =

            $tempDirectory .

            DIRECTORY_SEPARATOR .

            'moc-signature-' .

            $signature->id .

            '-' .

            uniqid() .

            '.' .

            $extension;

        if (!copy($signaturePath, $tempSignature)) {

            throw new \RuntimeException(

                'Gagal menyiapkan file tanda tangan.'

            );

        }

        /*

        |--------------------------------------------------------------------------

        | MASUKKAN KE WORD

        |--------------------------------------------------------------------------

        */

        $template->setImageValue(

            $placeholder,

            [

                'path' => $tempSignature,

                'width' => 105,

                'height' => 45,

                'ratio' => false,

            ]

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

            'app/templates/API - Formulir MOC - FINAL-PLACEHOLDER.docx'

        );

        if (!file_exists($templatePath)) {

            return response()->json([

                'status' => 'ERROR',

                'message' => 'Template tidak ditemukan.',

                'path' => $templatePath,

            ]);

        }

        try {

            $template = new TemplateProcessor(

                $templatePath

            );

            $variables = $template->getVariables();

            return response()->json([

                'status' => 'OK',

                'template_path' =>

                    $templatePath,

                'template_size' =>

                    filesize($templatePath),

                'placeholders' =>

                    $variables,

                'penelitian_bahaya_ada' =>

                    in_array(

                        'penelitian_bahaya',

                        $variables

                    ),

                'rig_signature_ada' =>

                    in_array(

                        'rig_superintendent_signature',

                        $variables

                    ),

                'area_signature_ada' =>

                    in_array(

                        'area_manager_signature',

                        $variables

                    ),

                'rig_nama_ada' =>

                    in_array(

                        'rig_superintendent_nama',

                        $variables

                    ),

                'area_nama_ada' =>

                    in_array(

                        'area_manager_nama',

                        $variables

                    ),

            ]);

        } catch (\Throwable $e) {

            return response()->json([

                'status' => 'ERROR',

                'message' => $e->getMessage(),

            ]);

        }

    }

}
