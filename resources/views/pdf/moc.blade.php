<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>{{ $data['document_title'] ?? 'FORMULIR MOC' }}</title>

    <style>

        @page {

            size: A4 portrait;

            margin: 4mm 5mm 4mm 5mm;

        }

        * {

            box-sizing: border-box;

        }

        html,

        body {

            margin: 0;

            padding: 0;

            width: 100%;

            background: #ffffff;

        }

        body {

            font-family: Calibri, Arial, sans-serif;

            font-size: 7.85pt;

            line-height: 1.04;

            color: #000000;

        }

        table {

            width: 100%;

            border-collapse: collapse;

            table-layout: fixed;

            margin: 0;

            padding: 0;

        }

        td,

        th {

            border: 1.25pt solid #000000;

            padding: 0.65mm 1mm;

            vertical-align: middle;

            overflow-wrap: break-word;

        }

        .section-title {

            height: 4.2mm;

            padding: 0.6mm 1mm;

            border: 1.25pt solid #000000;

            background: #ed7d31;

            color: #ffffff;

            font-weight: 700;

            font-size: 7.75pt;

            line-height: 1;

        }

        .no-border { border: 0 !important; }

        .center { text-align: center; }

        .right { text-align: right; }

        .bold { font-weight: 700; }

        .small { font-size: 7.05pt; }

        .tiny { font-size: 6.65pt; }

        .nowrap { white-space: nowrap; }

        /* HEADER - disamakan dengan contoh */

        .header-grid {

            width: 100%;

            border-collapse: collapse;

            table-layout: fixed;

            margin: 0;

        }

        .header-grid td {

            border: 1.25pt solid #000000;

            padding: 0.45mm 0.75mm;

            line-height: 1;

            vertical-align: middle;

        }

        .header-grid .meta-label {

            font-family: Calibri, Arial, sans-serif;

            font-size: 7.85pt;

            font-style: italic;

            font-weight: 700;

            text-align: left;

            white-space: nowrap;

        }

        .header-grid .main-title {

            text-align: center;

            font-size: 8pt;

            font-weight: 700;

        }

        .header-grid .form-value {

            text-align: center;

            font-size: 7.75pt;

            font-weight: 700;

        }

        .header-grid .logo-cell {

            text-align: center;

            vertical-align: middle;

            padding: 0.3mm 0.5mm;

        }

        .header-grid .logo-cell img {

            display: block;

            margin: 0 auto;

            max-width: 26mm;

            max-height: 14mm;

        }

        .header-grid .row-doc { height: 7.2mm; }

        .header-grid .row-form { height: 4.7mm; }

        .header-grid .row-manual-head { height: 4.2mm; }

        .header-grid .row-manual-value { height: 4.2mm; }

        .header-grid .manual-label {

            font-size: 7.85pt;

            font-style: italic;

            font-weight: 700;

            white-space: nowrap;

        }

        .header-grid .manual-value,

        .header-grid .rev-head,

        .header-grid .rev-value,

        .header-grid .approved-value {

            text-align: center;

            font-size: 7.45pt;

            font-weight: 700;

        }

        .header-grid .rev-head {

            font-style: italic;

        }

        /* MOC NUMBER */

        .moc-number td {

            height: 5mm;

            font-size: 7.05pt;

        }

        /* 2-COLUMN DATA TABLES */

        .field-table td {

            height: 4.3mm;

            padding-top: 0.45mm;

            padding-bottom: 0.45mm;

        }

        .field-label {

            width: 14%;

            font-weight: 700;

        }

        .field-colon {

            width: 2%;

            text-align: center;

        }

        .field-value {

            width: 34%;

        }

        .proposer-table .field-label { width: 16%; }

        .proposer-table .field-colon { width: 2%; }

        .proposer-table .field-value { width: 82%; }

        .proposer-table td { height: 3mm; padding-top: 0.25mm; padding-bottom: 0.25mm; }

        .bullet-label {

            width: 16%;

            font-weight: 700;

        }

        .bullet-value {

            width: 34%;

        }

        .info-note {

            padding: 0.5mm 1mm 0.7mm 1mm;

            font-size: 6.75pt;

            border-left: 1.25pt solid #000000;

            border-right: 1.25pt solid #000000;

        }

        /* TEXT / QUESTION BLOCKS */

        .question-table td {

            vertical-align: top;

            padding: 0.7mm 1.2mm;

        }

        .question-label {

            font-weight: 700;

            margin-bottom: 0.6mm;

        }

        .question-note {

            margin-top: 0.3mm;

            font-size: 6.65pt;

        }

        .answer {

            padding: 1mm 4mm 0.8mm 4mm;

            white-space: pre-wrap;

            line-height: 1.05;

        }

        .q1 { height: 12mm; }

        .q2 { height: 9mm; }

        .q3 { height: 13mm; }

        /* RISK */

        .risk td {

            height: 5.3mm;

            padding: 0.5mm 0.7mm;

        }

        .risk-text {

            width: 64%;

            font-weight: 700;

        }

        .risk-high,

        .risk-mid,

        .risk-low {

            width: 12%;

            text-align: center;

            font-weight: 700;

            font-size: 7.15pt;

        }

        .risk-high { background: #ff2b2b; }

        .risk-mid { background: #ffe338; }

        .risk-low { background: #43b85a; }

        /* K3LL */

        .k3ll td {

            vertical-align: top;

            padding: 0.7mm 1mm;

        }

        .k3ll .k3ll-1 { height: 10mm; }

        .k3ll .k3ll-2 { height: 10mm; }

        .k3ll .k3ll-3 { height: 11mm; }

        /* IMPACT */

        .impact th,

        .impact td {

            padding: 0.42mm 0.7mm;

            font-size: 6.7pt;

            line-height: 1.02;

        }

        .impact th {

            height: 4.6mm;

            text-align: center;

            font-weight: 700;

        }

        .impact td {

            height: 6.3mm;

        }

        .impact-no { width: 5%; text-align: center; }

        .impact-question { width: 50%; }

        .impact-desc { width: 20%; text-align: center; }

        .impact-extra { width: 15%; text-align: center; }

        .impact-status { width: 10%; text-align: center; }

        /* INFORMED PEOPLE */

        .people th,

        .people td {

            height: 4.3mm;

            padding: 0.35mm 0.8mm;

            font-size: 6.65pt;

            line-height: 1;

        }

        .people th {

            text-align: center;

            font-weight: 700;

        }

        /* REVIEW */

        .review th,

        .review td {

            height: 5mm;

            padding: 0.4mm 0.7mm;

            font-size: 6.65pt;

            line-height: 1;

        }

        .review th {

            text-align: center;

            font-weight: 700;

        }

        /* Isi tabel pihak terkait dan pemeriksa mengikuti perataan template Word. */

        .people tbody td,

        .review tbody td {

            text-align: center;

        }

        /* APPROVAL / FOOTER - mengikuti contoh */

        .approval-signature {

            width: 100%;

            border-collapse: collapse;

            table-layout: fixed;

            margin: 0;

        }

        .approval-signature td {

            height: 21mm;

            border: 1.1pt solid #000000;

            vertical-align: bottom;

            text-align: center;

            padding: 1mm 1mm 0.7mm 1mm;

        }

        .signature-img {

            display: block;

            margin: 0 auto 0.4mm auto;

            max-width: 30mm;

            max-height: 15mm;

        }

        .signature-name {

            margin-top: 0;

            font-size: 7.25pt;

            line-height: 1;

        }

        .approval-role-row {

            width: 100%;

            border-collapse: collapse;

            table-layout: fixed;

            margin: 0;

        }

        .approval-role-row td {

            height: 4.4mm;

            border: 1.1pt solid #000000;

            padding: 0.25mm 0.6mm;

            text-align: center;

            font-size: 7.35pt;

            font-weight: 700;

            vertical-align: middle;

        }

        .footer {

            width: 100%;

            border-collapse: collapse;

            table-layout: fixed;

            margin: 0;

        }

        .footer td {

            text-align: center;

            height: 6.8mm;

            border: 1.1pt solid #000000;

            vertical-align: middle;

            padding: 0.45mm 1mm;

            font-size: 7.25pt;

            font-weight: 700;

        }

        tr, td, th, table {

            page-break-inside: avoid !important;

        }

    </style>

</head>

<body>

@php

    $v = function ($key, $default = '') use ($data) {

        return data_get($data, $key, $default);

    };

    $formatDate = function ($value, $long = false) {

        if (empty($value)) {

            return '';

        }

        try {

            $date = \Carbon\Carbon::parse($value);

            if ($long) {

                $months = [

                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret',

                    4 => 'April', 5 => 'Mei', 6 => 'Juni',

                    7 => 'Juli', 8 => 'Agustus', 9 => 'September',

                    10 => 'Oktober', 11 => 'November', 12 => 'Desember',

                ];

                return $date->format('d') . ' ' . $months[(int) $date->format('n')] . ' ' . $date->format('Y');

            }

            return $date->format('d/m/Y');

        } catch (\Throwable $e) {

            return $value;

        }

    };

    $logoData = null;

    $logoPath = public_path('images/logo-arjuna.png');

    if (file_exists($logoPath)) {

        $mime = mime_content_type($logoPath);

        $logoData = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($logoPath));

    }

    $impactQuestions = [

        1 => 'Apakah perubahan mengakibatkan perubahan juga pada standar atau prosedur? Jika ada, pada standar atau prosedur mana?',

        2 => 'Apakah perubahan berakibat pada garansi atau pada maintenance agreement? Jika ada, apa dampaknya?',

        3 => 'Apakah perubahan berakibat pada maintenance? Bagian yang mana?',

        4 => 'Apakah perubahan mengakibatkan perubahan pada rancangan/drawing? Rancangan/drawing yang mana?',

        5 => 'Apakah perubahan mengurangi barang-barang persediaan? Jika ada, barang-barang persediaan yang mana?',

        6 => 'Apakah perubahan membutuhkan penyimpanan parts baru? Jika ada, barang/parts apakah itu?',

        7 => 'Apakah proposal mengenalkan bahan kimia baru? Jika ada, lampirkan MSDS.',

        8 => 'Apakah perubahan membutuhkan persetujuan dari pabrik pembuat alat / Original Equipment Manufacture?',

        9 => 'Apakah perubahan memiliki dampak kepada pihak lain atau dokumen pendukung? Jika YA, isi tabel di bawah ini:',

    ];

@endphp

{{-- HEADER --}}

<table class="header-grid">

    <colgroup>

        <col style="width:17.5%;">

        <col style="width:6.5%;">

        <col style="width:19%;">

        <col style="width:19%;">

        <col style="width:19%;">

        <col style="width:9.5%;">

        <col style="width:9.5%;">

    </colgroup>

    <tr class="row-doc">

        <td colspan="2" class="meta-label">Document Number : API-MR-012/PRO</td>

        <td colspan="3" class="main-title">Company Safety Management System (CSMS)</td>

        <td colspan="2" rowspan="3" class="logo-cell">

            @if($logoData)

                <img src="{{ $logoData }}" alt="ARJUNA">

            @endif

        </td>

    </tr>

    <tr class="row-form">

        <td colspan="2" class="meta-label">Form Name</td>

        <td colspan="3" class="form-value">FORMULIR MOC</td>

    </tr>

    <tr class="row-form">

        <td colspan="2" class="meta-label">Form No</td>

        <td colspan="3" class="form-value">API-MR-012.001/FORM</td>

    </tr>

    <tr class="row-manual-head">

        <td rowspan="2" class="manual-label">Manual Level</td>

        <td rowspan="2" class="manual-value">3</td>

        <td class="rev-head">Issue Date</td>

        <td class="rev-head">Rev. Date</td>

        <td class="rev-head">Rev. No</td>

        <td colspan="2" class="rev-head">Approved By</td>

    </tr>

    <tr class="row-manual-value">

        <td class="rev-value">20-oct-2020</td>

        <td class="rev-value">{{ $data['rev_date'] ?? \App\Services\DocumentRevision::get('moc')['rev_date'] }}</td>

        <td class="rev-value">{{ $data['rev_no'] ?? \App\Services\DocumentRevision::get('moc')['rev_no'] }}</td>

        <td class="approved-value">GM</td>

        <td class="approved-value">DIREKTUR</td>

    </tr>

</table>

<div class="section-title">

    MOC Number : (Example - NOMOR/MOC/ARJ-01/BULAN/TAHUN - 020/MOC/ARJ-01/05/2024)

</div>

<table class="moc-number">

    <tr>

        <td><strong>MOC Number :</strong> {{ $v('moc_number') }}</td>

    </tr>

</table>

{{-- USULAN MOC --}}

<div class="section-title">Usulan MOC Oleh :</div>

<table class="field-table proposer-table">

    <tr><td class="field-label">Nama</td><td class="field-colon">:</td><td class="field-value">{{ $v('nama_pengusul') }}</td></tr>

    <tr><td class="field-label">Departemen</td><td class="field-colon">:</td><td class="field-value">Operation Rig</td></tr>

    <tr><td class="field-label">Jabatan</td><td class="field-colon">:</td><td class="field-value">Area Manager</td></tr>

</table>

{{-- INFORMASI PERUBAHAN --}}

<div class="section-title">Informasi Perubahan (Umum):</div>

<div class="info-note">*Isi pada informasi yang sesuai</div>

<table class="field-table">

    <tr>

        <td class="bullet-label">&#9679; Department</td>

        <td class="bullet-value">: {{ $v('department') }}</td>

        <td class="bullet-label">&#9679; Pekerja</td>

        <td class="bullet-value">: WOWS</td>

    </tr>

    <tr>

        <td class="bullet-label">&#9679; Proses</td>

        <td class="bullet-value">: {{ $v('proses') }}</td>

        <td class="bullet-label">&#9679; Jenis Bahaya</td>

        <td class="bullet-value">: {{ $v('jenis_bahaya') }}</td>

    </tr>

    <tr>

        <td class="bullet-label">&#9679; Peralatan</td>

        <td class="bullet-value">: {{ $v('peralatan') }}</td>

        <td class="bullet-label">&#9679; Lokasi</td>

        <td class="bullet-value">: {{ $v('lokasi') }}</td>

    </tr>

    <tr>

        <td class="bullet-label">&#9679; Prosedur</td>

        <td class="bullet-value">: {{ $v('prosedur') }}</td>

        <td class="bullet-label">&#9679; Lain-lain</td>

        <td class="bullet-value">: {{ $v('lain_lain') }}</td>

    </tr>

</table>

{{-- PERUBAHAN KHUSUS --}}

<div class="section-title">Perubahan Khusus yang Diajukan:</div>

<table class="question-table">

    <tr>

        <td class="q1">

            <div class="question-label">01. Jelaskan tujuan perubahan:</div>

            <div class="answer">Permohonan Pergantian Sementara {{ $v('tujuan_perubahan') }}</div>

        </td>

    </tr>

    <tr>

        <td class="q2">

            <div class="question-label">02. Hasil yang diharapkan dari perubahan:</div>

            <div class="answer">{{ $v('hasil_perubahan') }}</div>

        </td>

    </tr>

    <tr>

        <td class="q3">

            <div class="question-label">03. Penilaian Resiko:</div>

            <div class="question-note">(Gunakan Risk Matriks untuk menilai seluruh resiko jika perubahan ini dilaksanakan)</div>

            <div class="answer">{{ $v('penilaian_resiko') }}</div>

        </td>

    </tr>

</table>

{{-- RISK --}}

<table class="risk">

    <tr>

        <td class="risk-text">Penilaian Keseluruhan Resiko ({{ $v('overall_risk') ? ucfirst(strtolower($v('overall_risk'))) : '' }})</td>

        <td class="risk-high">TINGGI {{ strtoupper($v('overall_risk')) === 'TINGGI' ? 'X' : '' }}</td>

        <td class="risk-mid">SEDANG {{ strtoupper($v('overall_risk')) === 'SEDANG' ? 'X' : '' }}</td>

        <td class="risk-low">RENDAH {{ strtoupper($v('overall_risk')) === 'RENDAH' ? 'X' : '' }}</td>

    </tr>

</table>

{{-- K3LL --}}

<div class="section-title">Pemeriksaan K3LL & Penilaian</div>

<table class="k3ll">

    <tr>

        <td class="k3ll-1">

            <div class="bold">01. Apakah ada penelitian bahaya lebih lanjut diperlukan? &nbsp; {{ strtoupper($v('penelitian_bahaya')) === 'YA' ? 'Ya' : (strtoupper($v('penelitian_bahaya')) === 'TIDAK' ? 'Tidak' : '') }}</div>

            <div class="tiny">Jika Ya, mohon lampirkan Risk Register dan Risk Action Plan (Lanjutkan pada sesi berikutnya)</div>

            <div style="margin-top:1.2mm;">{{ $v('risk_register_action_plan') }}</div>

        </td>

    </tr>

    <tr>

        <td class="k3ll-2">

            <div class="bold">02. Apa bahaya baru yang ditimbulkan oleh adanya perubahan?</div>

            <div style="margin-top:1.3mm;">{{ $v('bahaya_baru') }}</div>

        </td>

    </tr>

    <tr>

        <td class="k3ll-3">

            <div class="bold">03. Mempertimbangkan dampak dan bahaya dari perubahan yang dianjurkan, apakah kemungkinan insiden yang dapat ditimbulkan dari hasil modifikasi/perubahan:</div>

            <div style="margin-top:1.3mm;">{{ $v('kemungkinan_insiden') }}</div>

        </td>

    </tr>

</table>

{{-- DAMPAK --}}

<div class="section-title">Dampak dari perubahan yang dianjurkan (Silahkan tandai Ya atau Tidak atau Tidak ada penerapan (N/A)), Lingkari</div>

<table class="impact">

    <thead>

        <tr>

            <th class="impact-no">No.</th>

            <th class="impact-question">Pertanyaan</th>

            <th class="impact-desc">Keterangan</th>

            <th colspan="2">YA/TIDAK/N/A</th>

        </tr>

    </thead>

    <tbody>

        @foreach($impactQuestions as $i => $question)

            <tr>

                <td class="impact-no">{{ $i }}</td>

                <td class="impact-question">{{ $question }}</td>

                <td class="impact-desc">{{ $v("impact.$i.keterangan") }}</td>

                <td class="impact-extra">{{ $i === 9 && $v("impact.$i.status") === 'YA' ? 'YA' : '-' }}</td>

                <td class="impact-status">{{ $i === 9 && $v("impact.$i.status") === 'YA' ? '-' : $v("impact.$i.status") }}</td>

            </tr>

        @endforeach

    </tbody>

</table>

{{-- SIAPA YANG PERLU DIINFORMASIKAN --}}

<div class="section-title">Siapa yang Perlu Diinformasikan (Nama dan Jabatan)</div>

<table class="people">

    <colgroup>

        <col style="width:50%;">

        <col style="width:25%;">

        <col style="width:25%;">

    </colgroup>

    <tbody>

        @for($i = 0; $i < 6; $i++)

            <tr>

                <td>{{ $v("informasi.$i.nama_jabatan") }}</td>

                <td class="center">{{ $v("informasi.$i.departemen") }}</td>

                <td class="center">{{ $v("informasi.$i.keterangan") }}</td>

            </tr>

        @endfor

    </tbody>

</table>

{{-- DIPERIKSA --}}

<div class="section-title">Diperiksa Oleh, harus menyertakan perwakilan department terkait yang terkait perubahan:</div>

<table class="review">

    <thead>

        <tr>

            <th style="width:28%;">NAMA</th>

            <th style="width:22%;">JABATAN</th>

            <th style="width:13%;">Tanda Tangan</th>

            <th style="width:18%;">Tanggal (dd/mm/yy)</th>

            <th style="width:19%;">Diterima / Ditolak</th>

        </tr>

    </thead>

    <tbody>

        @for($i = 0; $i < 2; $i++)

            <tr>

                <td>{{ $v("diperiksa.$i.nama") }}</td>

                <td class="center">{{ $v("diperiksa.$i.jabatan") }}</td>

                <td class="center">OK</td>

                <td class="center">{{ $formatDate($v("diperiksa.$i.tanggal")) }}</td>

                <td class="center">{{ $v("diperiksa.$i.status") }}</td>

            </tr>

        @endfor

    </tbody>

</table>

{{-- DISETUJUI --}}

<div class="section-title">Disetujui Oleh:</div>

<table class="approval-signature">

    <tr>

        <td style="width:50%;">

            @if(!empty($rigSignatureData))

                <img src="{{ $rigSignatureData }}" class="signature-img" alt="Rig Superintendent">

            @endif

            <div class="signature-name">{{ $v('approval.0.nama') }}</div>

        </td>

        <td style="width:50%;">

            @if(!empty($areaSignatureData))

                <img src="{{ $areaSignatureData }}" class="signature-img" alt="Operation Manager">

            @endif

            <div class="signature-name">{{ $v('approval.1.nama') }}</div>

        </td>

    </tr>

</table>

<table class="approval-role-row">

    <tr>

        <td style="width:50%;">Rig Superintendent</td>

        <td style="width:50%;">Operation Manager</td>

    </tr>

</table>

{{-- FOOTER --}}

<table class="footer">

    <tr>

        <td style="width:50%;">

            Tanggal Efektif Perubahan: {{ $formatDate($v('tanggal_efektif'), true) }}

        </td>

        <td style="width:50%;">

            Kontak Person terkait Perubahan: {{ $v('kontak_person') }}

        </td>

    </tr>

</table>

</body>

</html>
