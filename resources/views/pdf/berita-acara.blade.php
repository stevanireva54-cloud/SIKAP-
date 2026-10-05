<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $data['document_title'] ?? 'Berita Acara' }}</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            background: #ffffff;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            color: #000000;
            font-size: 11.4pt;
            line-height: 1.23;
        }

        /*
        |--------------------------------------------------------------------------
        | HALAMAN A4
        |--------------------------------------------------------------------------
        |
        | Pakai width 100%, bukan width 210mm. Dengan wkhtmltopdf ini mencegah
        | seluruh dokumen dikecilkan (smart shrinking) seperti hasil sebelumnya.
        | Padding kiri/kanan 24mm mengikuti contoh dokumen perusahaan.
        |
        */
        .page {
            width: 100%;
            min-height: 297mm;
            margin: 0;
            padding: 9mm 20mm 22mm 20mm;
            position: relative;
            padding-bottom: 22mm;
        }

        .logo-wrap {
            text-align: center;
            margin: 0 0 1.4mm 0;
            height: 17mm;
        }

        .logo-wrap img {
            width: 42mm;
            max-height: 16mm;
            object-fit: contain;
        }

        .title {
            margin: 0 0 6.5mm 0;
            text-align: center;
            font-size: 16.2pt;
            font-weight: 700;
            line-height: 1;
        }

        .block {
            margin-bottom: 4.4mm;
        }

        .line {
            margin: 0 0 1.4mm 0;
        }

        .bold {
            font-weight: 700;
        }

        .underline {
            text-decoration: underline;
            font-weight: 700;
        }

        .person-table {
            width: 100%;
            border-collapse: collapse;
            margin: 2.0mm 0 4.0mm 0;
            table-layout: fixed;
        }

        .person-table td {
            border: 0;
            padding: 0.45mm 0;
            vertical-align: top;
        }

        .person-label {
            width: 27mm;
        }

        .person-colon {
            width: 4mm;
            text-align: center;
        }

        .body-paragraph {
            margin: 0 0 3.9mm 0;
            text-align: justify;
        }

        .hsse-list {
            margin: -0.1mm 0 4.0mm 8mm;
            padding-left: 7mm;
        }

        .hsse-list li {
            margin: 0 0 1.2mm 0;
            padding-left: 1.5mm;
            text-align: justify;
        }

        .date-company {
            margin-top: 3.0mm;
            margin-bottom: 3.8mm;
        }

        .date-company .date {
            font-weight: 700;
            margin-bottom: 0.5mm;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-top: 1mm;
        }

        .signature-table td {
            width: 25%;
            border: 0;
            padding: 0 1.5mm;
            text-align: center;
            vertical-align: bottom;
        }

        .signature-head td {
            text-align: left;
            padding-bottom: 0.5mm;
            font-size: 10.5pt;
        }

        .signature-head td:nth-child(2),
        .signature-head td:nth-child(3) {
            text-align: center;
        }

        .signature-head td:nth-child(4) {
            text-align: right;
        }

        .signature-box {
            height: 28mm;
            position: relative;
            text-align: center;
            vertical-align: bottom;
        }

        .signature-box img {
            display: block;
            margin: 0 auto;
            max-width: 34mm;
            max-height: 22mm;
        }

        .signature-name {
            min-height: 4.5mm;
            border-bottom: 0.3mm solid #000;
            font-size: 10.5pt;
            line-height: 1.05;
            padding: 0 0.8mm 0.4mm;
            white-space: nowrap;
        }

        .signature-position {
            margin-top: 0.6mm;
            font-size: 10.1pt;
            line-height: 1.05;
        }

        .note {
            margin: 4.2mm 0 0 0;
            font-size: 10.2pt;
            line-height: 1.13;
            text-align: justify;
        }

        /*
        |--------------------------------------------------------------------------
        | FOOTER ORANGE
        |--------------------------------------------------------------------------
        |
        | Diposisikan di bawah halaman agar hasil PDF memenuhi satu halaman A4,
        | sama seperti contoh dan tidak berhenti di tengah halaman.
        |
        */
        .footer {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            margin: 0;
            background: #f58218;
            color: #ffffff;
            text-align: center;
            padding: 2mm 0 1.8mm;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 7.8pt;
            line-height: 1.12;
            letter-spacing: 0.1px;
        }

        .footer .company {
            font-weight: 700;
            letter-spacing: 2.2px;
            margin-bottom: 0.4mm;
        }

        .footer .small {
            font-size: 7.4pt;
        }
    </style>
</head>
<body>

<div class="page">

    <div class="logo-wrap">
        @if(!empty($logoData))
            <img src="{{ $logoData }}" alt="ARJUNA">
        @endif
    </div>

    <div class="title">
        BERITA ACARA
    </div>

    <div class="block">
        <div class="line bold">
            Kepada Yth :
        </div>

        <div class="line">
            Bpk Rig Leader {{ $data['rig'] }}
        </div>
    </div>

    <div class="block">
        <div class="line">
            Perihal :
            <span class="underline">
                Pergantian Sementara Personel {{ $data['rig'] }}
            </span>
        </div>
    </div>

    <div class="block">
        <div class="line">
            Dengan Hormat,
        </div>
    </div>

    <div class="block">
        <div class="line">
            Sehubungan dengan
            <span class="bold">Tidak-Hadirnya</span>
            salah satu personel Rig {{ $data['rig'] }} Atas Nama :
        </div>

        <table class="person-table">
            <tr>
                <td class="person-label">Nama</td>
                <td class="person-colon">:</td>
                <td>{{ $data['tidak_nama'] }}</td>
            </tr>
            <tr>
                <td class="person-label">Jabatan</td>
                <td class="person-colon">:</td>
                <td>{{ $data['tidak_jabatan'] }}</td>
            </tr>
            <tr>
                <td class="person-label">Crew</td>
                <td class="person-colon">:</td>
                <td>{{ $data['tidak_crew'] }}</td>
            </tr>
            <tr>
                <td class="person-label">Schedule</td>
                <td class="person-colon">:</td>
                <td>{{ $data['tidak_schedule'] }}</td>
            </tr>
        </table>
    </div>

    <p class="body-paragraph">
        Personil tersebut tidak hadir dikarenakan {{ $data['alasan'] }} pada tanggal
        {{ $data['date_range'] }} ({{ $data['days'] }} Hari), maka dilakukan pergantian
        sementara dengan {{ $data['pengganti_jabatan'] }} {{ $data['pengganti_rig'] }}
        atas nama :
    </p>

    <table class="person-table">
        <tr>
            <td class="person-label">Nama</td>
            <td class="person-colon">:</td>
            <td>{{ $data['pengganti_nama'] }}</td>
        </tr>
        <tr>
            <td class="person-label">Jabatan</td>
            <td class="person-colon">:</td>
            <td>{{ $data['pengganti_jabatan'] }}</td>
        </tr>
        <tr>
            <td class="person-label">Rig</td>
            <td class="person-colon">:</td>
            <td>{{ $data['pengganti_rig'] }}</td>
        </tr>
        <tr>
            <td class="person-label">Crew</td>
            <td class="person-colon">:</td>
            <td>{{ $data['pengganti_crew'] }}</td>
        </tr>
        <tr>
            <td class="person-label">Schedule</td>
            <td class="person-colon">:</td>
            <td>{{ $data['pengganti_schedule'] }}</td>
        </tr>
    </table>

    <p class="body-paragraph">
        Bersamaan dengan ini menyatakan bahwa terkait ketentuan onboarding sebelum melakukan
        pekerjaan di Rig {{ $data['rig'] }} perusahaan meminta kepada Rig Superintendent sebagai&nbsp;pimpinan tertinggi (Onsite) rig {{ $data['rig'] }}, untuk memastikan penguatan HSSE
        kepada personil pengganti sebagai berikut :
    </p>

    <ol class="hsse-list">
        <li>
            Memastikan komunikasi dan koordinasi telah berjalan dengan Rig Superintendent
        </li>
        <li>
            Memastikan Ybs melakukan Beyond PTI dan Familiarisasi {{ $data['familirisasi'] }}
            didampingi oleh Rig Supt &amp; Truck Pusher Incharge {{ $data['rig'] }}
        </li>
        <li>
            Melakukan Re-Sosialisasi 5 Action Plans to Fronliner Leader
        </li>
    </ol>

    <p class="body-paragraph">
        Demikian Berita Acara ini dibuat dengan sebenar-benarnya untuk dipatuhi dan dilaksanakan
        dengan penuh tanggung jawab.
    </p>

    <div class="date-company">
        <div class="date">
            Duri, {{ $data['tanggal_surat_text'] }}
        </div>
        <div>
            PT Arjuna Petrogas Indonesia
        </div>
    </div>

    <table class="signature-table">
        <tr class="signature-head">
            <td>Dibuat oleh,</td>
            <td colspan="2">Disetujui oleh,</td>
            <td>Diketahui oleh,</td>
        </tr>

        <tr>
            <td class="signature-box">
                @if(!empty($fieldCoordinatorSignatureData))
                    <img src="{{ $fieldCoordinatorSignatureData }}" alt="Field Coordinator">
                @endif
            </td>

            <td class="signature-box">
                @if(!empty($rigSuptSignatureData))
                    <img src="{{ $rigSuptSignatureData }}" alt="Rig Supt">
                @endif
            </td>

            <td class="signature-box">
                @if(!empty($generalManagerSignatureData))
                    <img src="{{ $generalManagerSignatureData }}" alt="General Manager">
                @endif
            </td>

            <td class="signature-box">
                @if(!empty($wsrSignatureData))
                    <img src="{{ $wsrSignatureData }}" alt="WSR">
                @endif
            </td>
        </tr>

        <tr>
            <td>
                <div class="signature-name">
                    {{ $data['field_coordinator_name'] }}
                </div>
            </td>
            <td>
                <div class="signature-name">
                    {{ $data['rig_supt_name'] }}
                </div>
            </td>
            <td>
                <div class="signature-name">
                    {{ $data['general_manager_name'] }}
                </div>
            </td>
            <td>
                <div class="signature-name">
                    {{ $data['wsr_name'] }}
                </div>
            </td>
        </tr>

        <tr>
            <td class="signature-position">Field Coordinator</td>
            <td class="signature-position">Rig Supt</td>
            <td class="signature-position">General Manager</td>
            <td class="signature-position">WSR</td>
        </tr>
    </table>

    <div class="note">
        <span class="bold">Note :</span>
        Berdasarkan evaluasi yang bersangkutan mampu bekerja sesuai dengan posisinya.
        Mohon agar seluruh team berkoordinasi dan memastikan proses berjalan lancar.
    </div>

    <div class="footer">
        <div class="company">PT. ARJUNA PETROGAS INDONESIA</div>
        <div class="small">Pakuwon Tower, Lantai 11</div>
        <div class="small">Jl. Casablanca Raya Kav. 88, Jakarta 12870 - INDONESIA</div>
        <div class="small">PH. +62 (21) 3882 6888</div>
        <div class="small">FAX. +62 (21) 3882 6899</div>
    </div>

</div>

</body>
</html>
