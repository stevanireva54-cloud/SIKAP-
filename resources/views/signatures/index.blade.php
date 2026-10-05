<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Signature Library</title>

    <style>
        * {
            box-sizing: border-box;
        }

        :root {
            --navy: #06345e;
            --navy-dark: #052744;
            --accent: #7c5ce7;
            --accent-dark: #6848d2;
            --accent-soft: #f3f0ff;
            --text: #10213a;
            --muted: #718096;
            --line: #dfe6ee;
            --bg: #f8faff;
            --white: #ffffff;
            --danger: #e5484d;
            --danger-soft: #fff0f1;
            --success: #2f855a;
            --success-soft: #edf9f1;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            min-height: 100vh;
            padding-left: 187px;
            padding-top: 62px;

            font-family:
                Inter,
                "Segoe UI",
                Arial,
                sans-serif;

            color: var(--text);

            background:
                radial-gradient(
                    circle at 88% 2%,
                    rgba(124, 92, 231, .08),
                    transparent 24%
                ),
                linear-gradient(
                    180deg,
                    #ffffff 0%,
                    var(--bg) 100%
                );
        }

        button,
        input {
            font: inherit;
        }

        /* =========================================================
           SIDEBAR
        ========================================================= */

        .sidebar {
            width: 187px;
            min-height: 100vh;

            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;

            display: flex;
            flex-direction: column;

            padding: 18px 12px 14px;

            background: #ffffff;
            color: #111827;

            border-right: 1px solid #e5e7eb;

            overflow-y: auto;
        }

        .brand {
            display: flex;
            align-items: center;
            justify-content: flex-start;

            width: 100%;

            padding: 6px 6px 18px;
            margin-bottom: 14px;

            border-bottom: 1px solid #e5e7eb;
        }

        .brand-image {
            display: block;

            width: 148px;
            max-width: 100%;
            height: auto;

            object-fit: contain;
            object-position: left center;
        }

        .menu-section {
            margin-bottom: 18px;
        }

        .menu-title {
            padding: 0 3px;
            margin-bottom: 7px;

            color: #6b7280;

            font-size: 9px;
            font-weight: 800;

            text-transform: uppercase;
            letter-spacing: .7px;
        }

        .menu-item {
            width: 100%;
            min-height: 38px;

            display: flex;
            align-items: center;

            gap: 10px;

            padding: 9px 10px;
            margin-bottom: 4px;

            border: none;
            border-radius: 7px;

            background: transparent;
            color: #111827;

            font-size: 11px;
            font-weight: 600;
            text-decoration: none;
            text-align: left;

            cursor: pointer;

            transition:
                background .2s ease,
                color .2s ease,
                transform .2s ease;
        }

        .menu-item:hover {
            background: #f3f4f6;
            color: #111827;

            transform: translateX(1px);
        }

        .menu-item.active {
            background: #eaf3ff;
            color: #111827;
        }

        .menu-icon {
            width: 16px;
            height: 16px;

            flex: 0 0 16px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .menu-icon svg {
            width: 15px;
            height: 15px;

            fill: none;
            stroke: currentColor;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .logout-area {
            margin-top: auto;
        }

        .logout-area .menu-item {
            color: #ff5b5b;
        }

        .logout-area .menu-item:hover {
            background: #fff1f1;
            color: #e5484d;
        }



        /* =========================================================
           TOPBAR
        ========================================================= */

        .app-topbar {
            position: fixed;

            top: 0;
            left: 187px;
            right: 0;

            height: 62px;

            z-index: 900;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;

            padding: 0 26px;

            border-bottom:
                1px solid
                #e6edf4;

            background:
                rgba(255, 255, 255, .95);

            backdrop-filter: blur(12px);
        }

        .topbar-search {
            width: min(330px, 42vw);
            height: 34px;

            display: flex;
            align-items: center;

            gap: 8px;

            padding: 0 11px;

            border:
                1px solid
                #e7edf3;

            border-radius: 7px;

            background: #f6f8fb;
            color: #7d8a9b;
        }

        .topbar-search input {
            width: 100%;

            border: 0 !important;
            outline: 0 !important;

            background: transparent !important;

            min-height: 0 !important;

            padding: 0 !important;

            box-shadow: none !important;

            font-size: 10px !important;
        }

        .topbar-user {
            display: flex;
            align-items: center;

            gap: 10px;

            margin-left: auto;
        }

        .topbar-user-text {
            text-align: right;
        }

        .topbar-user-text strong {
            display: block;

            color: #12223a;

            font-size: 10px;
        }

        .topbar-user-text span {
            display: block;

            margin-top: 2px;

            color: #93a0af;

            font-size: 8px;
        }

        .topbar-avatar {
            width: 31px;
            height: 31px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: var(--accent-soft);
            color: var(--accent);

            font-size: 11px;
            font-weight: 900;
        }

        /* =========================================================
           MAIN PAGE
        ========================================================= */

        .page {
            width: calc(100% - 44px);
            max-width: 1040px;

            margin: 0 auto;
            padding: 24px 0 56px;
        }

        .back {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            min-height: 38px;

            margin: 0 0 20px;
            padding: 8px 13px;

            border:
                1px solid
                #cfd9e5;

            border-radius: 7px;

            background: white;
            color: #20364f;

            font-size: 12px;
            font-weight: 700;

            text-decoration: none;

            box-shadow:
                0 2px 6px
                rgba(16, 33, 58, .04);

            transition: .2s ease;
        }

        .back:hover {
            border-color: var(--accent);

            color: var(--accent);
            background: #fbfaff;

            transform: translateY(-1px);
        }

        /* =========================================================
           HERO
        ========================================================= */

        .hero {
            position: relative;

            min-height: 132px;

            overflow: hidden;

            margin-bottom: 16px;

            padding:
                8px 185px
                12px 4px;
        }

        .hero-content {
            position: relative;
            z-index: 2;

            padding-top: 6px;
        }

        .hero h1 {
            margin: 0 0 10px;

            color: var(--text);

            font-size: 30px;
            font-weight: 800;

            line-height: 1.15;
            letter-spacing: -.55px;
        }

        .hero p {
            max-width: 650px;

            margin: 0;

            color: #66758a;

            font-size: 13px;
            line-height: 1.55;
        }

        .hero-art {
            position: absolute;

            right: 16px;
            top: 0;

            width: 150px;
            height: 128px;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-art::before {
            content: "";

            position: absolute;

            width: 128px;
            height: 128px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle at 50% 50%,
                    rgba(124, 92, 231, .12) 0 46%,
                    rgba(124, 92, 231, .04) 47% 64%,
                    transparent 65%
                );
        }

        .hero-art svg {
            position: relative;
            z-index: 2;

            width: 106px;
            height: 106px;

            filter:
                drop-shadow(
                    0 10px 16px
                    rgba(124, 92, 231, .12)
                );
        }

        /* =========================================================
           ALERT
        ========================================================= */

        .alert-success,
        .alert-error {
            margin-bottom: 14px;

            padding: 11px 13px;

            border-radius: 7px;

            font-size: 11px;
            line-height: 1.5;
        }

        .alert-success {
            border:
                1px solid
                #b7e4c7;

            background: var(--success-soft);
            color: #236443;
        }

        .alert-error {
            border:
                1px solid
                #fecaca;

            background: #fff1f2;
            color: #b42318;
        }

        .alert-error ul {
            margin-bottom: 0;
        }

        /* =========================================================
           CARDS
        ========================================================= */

        .card {
            position: relative;

            overflow: hidden;

            margin-bottom: 14px;
            padding: 20px 22px;

            border:
                1px solid
                #e7e0fb;

            border-radius: 9px;

            background: white;

            box-shadow:
                0 5px 14px
                rgba(28, 56, 92, .055);
        }

        .card::before {
            content: "";

            position: absolute;

            top: 0;
            left: 0;
            bottom: 0;

            width: 3px;

            background: var(--accent);
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 16px;

            margin-bottom: 18px;
        }

        .card-title-wrap {
            display: flex;
            align-items: center;

            gap: 12px;
        }

        .card-number {
            width: 34px;
            height: 34px;

            flex: 0 0 34px;

            display: flex;
            align-items: center;
            justify-content: center;

            border:
                1.8px solid
                var(--accent);

            border-radius: 7px;

            background: white;
            color: var(--accent);

            font-size: 12px;
            font-weight: 800;

            box-shadow:
                0 2px 5px
                rgba(124, 92, 231, .07);
        }

        .card-title h2 {
            margin: 0;

            color: var(--accent);

            font-size: 16px;
            font-weight: 800;
        }

        .card-title p {
            margin: 3px 0 0;

            color: #8190a3;

            font-size: 10px;
            line-height: 1.4;
        }

        /* =========================================================
           FORM
        ========================================================= */

        .form-grid {
            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 14px 16px;
        }

        .form-group {
            margin-bottom: 14px;
        }

        .form-grid .form-group {
            margin-bottom: 0;
        }

        label {
            display: block;

            margin-bottom: 7px;

            color: #14253d;

            font-size: 12px;
            font-weight: 700;
        }

        input {
            width: 100%;
            min-height: 42px;

            padding: 10px 12px;

            border:
                1px solid
                #d8e2ec;

            border-radius: 7px;

            outline: none;

            background: white;
            color: #26364b;

            font-size: 12px;

            transition: .2s ease;
        }

        input:focus {
            border-color: var(--accent);

            box-shadow:
                0 0 0 3px
                rgba(124, 92, 231, .09);
        }

        input[type="file"] {
            padding: 7px;
        }

        input[type="file"]::file-selector-button {
            margin-right: 10px;

            padding: 8px 12px;

            border: 0;
            border-radius: 6px;

            background: var(--accent-soft);
            color: var(--accent);

            font-size: 11px;
            font-weight: 700;

            cursor: pointer;
        }

        /* =========================================================
           BUTTONS
        ========================================================= */

        button {
            border: 0;
            cursor: pointer;
        }

        .btn-primary {
            min-height: 40px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            padding: 10px 18px;

            border-radius: 7px;

            background:
                linear-gradient(
                    180deg,
                    #8d70ee 0%,
                    var(--accent) 100%
                );

            color: white;

            font-size: 12px;
            font-weight: 800;

            box-shadow:
                0 7px 16px
                rgba(124, 92, 231, .20);

            transition: .2s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            filter: brightness(.97);
        }

        .btn-danger {
            min-height: 34px;

            padding: 8px 12px;

            border-radius: 6px;

            background: var(--danger-soft);
            color: var(--danger);

            font-size: 11px;
            font-weight: 700;

            transition: .2s ease;
        }

        .btn-danger:hover {
            background: var(--danger);
            color: white;
        }

        /* =========================================================
           TABLE / LIBRARY
        ========================================================= */

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;

            border-collapse: separate;
            border-spacing: 0;

            overflow: hidden;

            border:
                1px solid
                #e1e8ef;

            border-radius: 7px;

            background: white;
        }

        th {
            padding: 10px 12px;

            border-bottom:
                1px solid
                #e2e8ef;

            background: var(--accent-soft);
            color: #506176;

            font-size: 10px;
            font-weight: 800;

            text-align: left;
        }

        td {
            padding: 11px 12px;

            border-bottom:
                1px solid
                #edf1f5;

            color: #4b596d;

            font-size: 11px;

            vertical-align: middle;
        }

        tbody tr:last-child td {
            border-bottom: 0;
        }

        tbody tr:hover {
            background: #fcfbff;
        }

        .signature-image-box {
            width: 145px;
            min-height: 72px;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 6px;

            border:
                1px solid
                #ece7fa;

            border-radius: 7px;

            background: #fff;
        }

        .signature-image {
            width: 125px;
            height: 58px;

            object-fit: contain;
        }

        .name-cell strong {
            display: block;

            color: #17263c;

            font-size: 11px;
        }

        .name-cell span {
            display: block;

            margin-top: 3px;

            color: #93a0af;

            font-size: 9px;
        }

        .empty {
            text-align: center;

            padding: 40px 20px;

            color: #7d8b9c;

            font-size: 12px;
        }

        .empty-icon {
            width: 48px;
            height: 48px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin: 0 auto 10px;

            border-radius: 50%;

            background: var(--accent-soft);
            color: var(--accent);

            font-size: 20px;
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 980px) {
            body {
                padding-left: 178px;
            }

            .app-sidebar {
                width: 178px;
            }

            .app-topbar {
                left: 178px;
            }

            .app-brand img {
                width: 138px;
            }
        }

        @media (max-width: 760px) {
            body {
                padding-left: 0;
                padding-top: 58px;
            }

            .app-sidebar {
                display: none;
            }

            .app-topbar {
                left: 0;
                height: 58px;

                padding: 0 14px;
            }

            .topbar-search {
                width:
                    min(
                        230px,
                        56vw
                    );
            }

            .topbar-user-text {
                display: none;
            }

            .page {
                width:
                    calc(
                        100% - 24px
                    );

                padding-top: 18px;
            }

            .hero {
                min-height: 112px;

                padding-right:
                    105px;
            }

            .hero h1 {
                font-size: 24px;
            }

            .hero p {
                font-size: 12px;
            }

            .hero-art {
                right: 0;

                width: 100px;
                height: 105px;
            }

            .hero-art::before {
                width: 92px;
                height: 92px;
            }

            .hero-art svg {
                width: 72px;
                height: 72px;
            }

            .form-grid {
                grid-template-columns:
                    1fr;
            }

            .card {
                padding: 18px 16px;
            }
        }
    </style>
</head>

<body>

<!-- =========================================================
     SIDEBAR
========================================================= -->

    <aside class="sidebar">

        <div class="brand">
            <img
                src="{{ asset('images/logo-arjuna.png') }}"
                alt="PT Arjuna Petrogas Indonesia"
                class="brand-image"
            >
        </div>

        <div class="menu-section">

            <div class="menu-title">
                Dashboard
            </div>

            <a
                href="{{ route('dashboard') }}"
                class="menu-item"
            >
                <span class="menu-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M3 11L12 4L21 11"></path>
                        <path d="M5 10V20H19V10"></path>
                    </svg>
                </span>

                <span>Dashboard</span>
            </a>

        </div>

        <div class="menu-section">

            <div class="menu-title">
                Dokumen
            </div>

            <a
                href="{{ route('documents.moc') }}"
                class="menu-item"
            >
                <span class="menu-icon">
                    <svg viewBox="0 0 24 24">
                        <rect x="5" y="3" width="14" height="18" rx="1"></rect>
                        <path d="M9 8H15"></path>
                        <path d="M9 12H15"></path>
                    </svg>
                </span>

                <span>Formulir MOC</span>
            </a>

            <a
                href="{{ route('documents.berita-acara') }}"
                class="menu-item"
            >
                <span class="menu-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M6 3H15L19 7V21H6Z"></path>
                        <path d="M14 3V8H19"></path>
                    </svg>
                </span>

                <span>Berita Acara</span>
            </a>

            <a
                href="{{ route('documents.surat-tugas') }}"
                class="menu-item"
            >
                <span class="menu-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M7 4H17V20H7Z"></path>
                        <path d="M9 4V2H15V4"></path>
                        <path d="M10 9H14"></path>
                        <path d="M10 13H14"></path>
                    </svg>
                </span>

                <span>Surat Tugas</span>
            </a>

        </div>

        
        <!-- DATA KARYAWAN -->

        <div class="menu-section">

            <div class="menu-title">
                Data Karyawan
            </div>

            <a
                href="{{ route('employees.index') }}"
                class="menu-item"
            >
                <span class="menu-icon">
                    <svg viewBox="0 0 24 24">
                        <circle cx="12" cy="8" r="4"></circle>
                        <path d="M4 21C4 16.5 7.5 13 12 13C16.5 13 20 16.5 20 21"></path>
                    </svg>
                </span>

                <span>Data Karyawan</span>
            </a>

            <a
                href="{{ route('schedules.index') }}"
                class="menu-item"
            >
                <span class="menu-icon">
                    <svg viewBox="0 0 24 24">
                        <rect x="3" y="5" width="18" height="16" rx="2"></rect>
                        <path d="M16 3V7"></path>
                        <path d="M8 3V7"></path>
                        <path d="M3 10H21"></path>
                        <path d="M8 14H8.01"></path>
                        <path d="M12 14H12.01"></path>
                        <path d="M16 14H16.01"></path>
                        <path d="M8 18H8.01"></path>
                        <path d="M12 18H12.01"></path>
                    </svg>
                </span>

                <span>Schedule Karyawan</span>
            </a>

        </div>

<div class="menu-section">

            <div class="menu-title">
                Riwayat
            </div>

            <a
                href="{{ route('documents.index') }}"
                class="menu-item"
            >
                <span class="menu-icon">
                    <svg viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="8"></circle>
                        <path d="M12 8V12L15 14"></path>
                    </svg>
                </span>

                <span>Semua Dokumen</span>
            </a>

        </div>

        <div class="menu-section">

            <div class="menu-title">
                Pengaturan
            </div>

            <a
                href="{{ route('signatures.index') }}"
                class="menu-item active"
            >
                <span class="menu-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M4 18C8 14 9 10 12 7"></path>
                        <path d="M12 7L16 3L20 7L16 11Z"></path>
                    </svg>
                </span>

                <span>Signature Library</span>
            </a>

        </div>

        <div class="logout-area">

            <form
                method="POST"
                action="{{ route('logout') }}"
            >
                @csrf

                <button
                    type="submit"
                    class="menu-item"
                >
                    <span class="menu-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M10 4H5V20H10"></path>
                            <path d="M14 8L18 12L14 16"></path>
                            <path d="M18 12H9"></path>
                        </svg>
                    </span>

                    <span>Logout</span>
                </button>

            </form>

        </div>

    </aside>

<header class="app-topbar">

    <div class="topbar-search">

        <span>
            ⌕
        </span>

        <input
            type="text"
            placeholder="Cari dokumen, menu, dll..."
            aria-label="Pencarian"
        >

    </div>


    <div class="topbar-user">

        <div class="topbar-user-text">

            <strong>
                {{ auth()->user()->name }}
            </strong>

            <span>
                {{ auth()->user()->email }}
            </span>

        </div>


        <div class="topbar-avatar">

            {{
                strtoupper(
                    substr(
                        auth()->user()->name,
                        0,
                        1
                    )
                )
            }}

        </div>

    </div>

</header>


<!-- =========================================================
     PAGE
========================================================= -->

<div class="page">

    <a
        href="{{ route('dashboard') }}"
        class="back"
    >
        ← Kembali ke Dashboard
    </a>


    <!-- =====================================================
         HERO
    ====================================================== -->

    <div class="hero">

        <div
            class="hero-art"
            aria-hidden="true"
        >

            <svg
                viewBox="0 0 120 120"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >

                <rect
                    x="28"
                    y="20"
                    width="64"
                    height="80"
                    rx="11"
                    fill="#FFFFFF"
                    stroke="#7C5CE7"
                    stroke-width="5"
                />

                <rect
                    x="45"
                    y="13"
                    width="30"
                    height="15"
                    rx="6"
                    fill="#7C5CE7"
                />

                <path
                    d="M41 56C47 46 54 65 60 54C66 43 71 62 80 48"
                    stroke="#7C5CE7"
                    stroke-width="4"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />

                <rect
                    x="39"
                    y="70"
                    width="42"
                    height="4"
                    rx="2"
                    fill="#D7CFEE"
                />

                <rect
                    x="39"
                    y="81"
                    width="31"
                    height="4"
                    rx="2"
                    fill="#D7CFEE"
                />

                <circle
                    cx="89"
                    cy="88"
                    r="18"
                    fill="#7C5CE7"
                />

                <path
                    d="M81 88L87 94L98 81"
                    stroke="white"
                    stroke-width="5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />

            </svg>

        </div>


        <div class="hero-content">

            <h1>
                Signature Library
            </h1>

            <p>
                Simpan tanda tangan satu kali dan gunakan kembali
                pada dokumen Berita Acara, Formulir MOC,
                dan Surat Tugas.
            </p>

        </div>

    </div>


    <!-- =====================================================
         ALERT
    ====================================================== -->

    @if(session('success'))

        <div class="alert-success">

            {{ session('success') }}

        </div>

    @endif


    @if($errors->any())

        <div class="alert-error">

            <strong>
                Terjadi kesalahan:
            </strong>

            <ul>

                @foreach(
                    $errors->all()
                    as $error
                )

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <!-- =====================================================
         ADD SIGNATURE
    ====================================================== -->

    <div class="card">

        <div class="card-header">

            <div class="card-title-wrap">

                <div class="card-number">
                    01
                </div>


                <div class="card-title">

                    <h2>
                        Tambah Tanda Tangan
                    </h2>

                    <p>
                        Masukkan identitas dan file tanda tangan.
                    </p>

                </div>

            </div>

        </div>


        <form
            action="{{ route('signatures.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf


            <div class="form-grid">

                <div class="form-group">

                    <label>
                        Nama
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Contoh: Riduwansyah"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Jabatan
                    </label>

                    <input
                        type="text"
                        name="position"
                        value="{{ old('position') }}"
                        placeholder="Contoh: Rig Supt"
                    >

                </div>

            </div>


            <div
                class="form-group"
                style="margin-top: 14px;"
            >

                <label>
                    File Tanda Tangan
                </label>

                <input
                    type="file"
                    name="signature"
                    accept=".png,.jpg,.jpeg"
                    required
                >

            </div>


            <button
                type="submit"
                class="btn-primary"
            >
                + Simpan Tanda Tangan
            </button>

        </form>

    </div>


    <!-- =====================================================
         LIBRARY
    ====================================================== -->

    <div class="card">

        <div class="card-header">

            <div class="card-title-wrap">

                <div class="card-number">
                    02
                </div>


                <div class="card-title">

                    <h2>
                        Daftar Tanda Tangan
                    </h2>

                    <p>
                        Tanda tangan yang dapat digunakan pada dokumen.
                    </p>

                </div>

            </div>

        </div>


        @if($signatures->count() > 0)

            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th>
                                Nama
                            </th>

                            <th>
                                Jabatan
                            </th>

                            <th>
                                Tanda Tangan
                            </th>

                            <th style="width: 100px;">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach(
                            $signatures
                            as $signature
                        )

                            <tr>

                                <td class="name-cell">

                                    <strong>
                                        {{ $signature->name }}
                                    </strong>

                                    <span>
                                        Signature tersimpan
                                    </span>

                                </td>


                                <td>

                                    {{
                                        $signature->position
                                        ?? '-'
                                    }}

                                </td>


                                <td>

                                    <div class="signature-image-box">

                                        <img
                                            src="{{
                                                route(
                                                    'signatures.image',
                                                    $signature
                                                )
                                            }}"
                                            class="signature-image"
                                            alt="Tanda tangan {{ $signature->name }}"
                                        >

                                    </div>

                                </td>


                                <td>

                                    <form
                                        action="{{
                                            route(
                                                'signatures.destroy',
                                                $signature
                                            )
                                        }}"
                                        method="POST"
                                        onsubmit="
                                            return confirm(
                                                'Hapus tanda tangan ini?'
                                            )
                                        "
                                    >

                                        @csrf
                                        @method('DELETE')


                                        <button
                                            type="submit"
                                            class="btn-danger"
                                        >
                                            Hapus
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="empty">

                <div class="empty-icon">
                    ✎
                </div>

                <strong>
                    Belum ada tanda tangan
                </strong>

                <div style="margin-top: 5px;">
                    Tambahkan tanda tangan pertama menggunakan form di atas.
                </div>

            </div>

        @endif

    </div>

</div>

</body>
</html>
