<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta

        name="viewport"

        content="width=device-width, initial-scale=1.0"

    >

    <meta

        name="csrf-token"

        content="{{ csrf_token() }}"

    >

    <title>

        @yield('title', 'SIKAP (Sistem Kelengkapan Administrasi Personil)')

    </title>

    <style>

        /* =========================================================

           RESET

        ========================================================= */

        * {

            margin: 0;

            padding: 0;

            box-sizing: border-box;

        }

        :root {

            --navy-900: #061d31;

            --navy-800: #082944;

            --navy-700: #0b3658;

            --orange: #ff7a00;

            --orange-light: #fff2e7;

            --green: #496329;

            --green-light: #eef3e9;

            --blue: #1473e6;

            --blue-hover: #0d64ca;

            --blue-light: #edf5ff;

            --background: #f5f7fa;

            --white: #ffffff;

            --text-primary: #172230;

            --text-secondary: #667085;

            --text-muted: #98a2b3;

            --border: #e5e9ef;

            --sidebar-width: 260px;

            --shadow-small:

                0 1px 3px rgba(16, 24, 40, .05);

            --shadow-medium:

                0 10px 30px rgba(16, 24, 40, .08);

        }

        html {

            scroll-behavior: smooth;

        }

        body {

            min-height: 100vh;

            font-family:

                Inter,

                "Segoe UI",

                Arial,

                Helvetica,

                sans-serif;

            background: var(--background);

            color: var(--text-primary);

        }

        button,

        input,

        textarea,

        select {

            font-family: inherit;

        }

        /* =========================================================

           APP SHELL

        ========================================================= */

        .app-shell {

            min-height: 100vh;

            display: flex;

        }

        /* =========================================================

           SIDEBAR

        ========================================================= */

        .sidebar {

            width: var(--sidebar-width);

            height: 100vh;

            position: fixed;

            top: 0;

            left: 0;

            display: flex;

            flex-direction: column;

            padding:

                22px

                16px

                20px;

            overflow-y: auto;

            background: #ffffff;

            color: #111827;

            z-index: 100;

            box-shadow:

                4px 0 20px

                rgba(5, 25, 42, .07);

        }

        /* =========================================================

           BRAND / LOGO

        ========================================================= */

        .sidebar-brand {

            width: 100%;

            display: flex;

            align-items: center;

            padding:

                4px

                5px

                22px;

            margin-bottom: 22px;

            border-bottom:

                1px solid

                #e5e7eb;

            text-decoration: none;

        }

        .sidebar-brand img {

            display: block;

            width: 100%;

            max-width: 210px;

            height: auto;

            object-fit: contain;

            object-position: left center;

        }

        /* =========================================================

           MENU

        ========================================================= */

        .menu-group {

            margin-bottom: 24px;

        }

        .menu-label {

            margin:

                0

                11px

                9px;

            color: #6b7280;

            font-size: 9px;

            font-weight: 700;

            letter-spacing: 1.2px;

            text-transform: uppercase;

        }

        .menu-link {

            width: 100%;

            min-height: 42px;

            display: flex;

            align-items: center;

            gap: 11px;

            padding:

                10px

                12px;

            margin-bottom: 4px;

            border: none;

            border-radius: 9px;

            background: transparent;

            color: #111827;

            font-size: 12px;

            font-weight: 500;

            text-decoration: none;

            text-align: left;

            cursor: pointer;

            transition:

                *background* .2s ease,

                color .2s ease,

                transform .2s ease,

                box-shadow .2s ease;

        }

        .menu-link:hover {

            background: #f3f4f6;

            color: #111827;

            transform: translateX(2px);

        }

        .menu-link.active {

            background: #eaf3ff;

            color: #111827;

            box-shadow:

                0 4px 12px

                rgba(16, 24, 40, .06);

        }

        .menu-link svg {

            width: 18px;

            height: 18px;

            flex-shrink: 0;

            fill: none;

            stroke: currentColor;

            stroke-width: 1.8;

            stroke-linecap: round;

            stroke-linejoin: round;

        }

        /* =========================================================

           LOGOUT

        ========================================================= */

        .logout-form {

            width: 100%;

        }

        .logout-form .menu-link {

            width: 100%;

        }

        .logout-form .menu-link:hover {

            background: #fff1f1;

            color: #dc2626;

        }

        /* =========================================================

           MAIN AREA

        ========================================================= */

        .main-area {

            width:

                calc(

                    100%

                    -

                    var(--sidebar-width)

                );

            min-height: 100vh;

            margin-left:

                var(--sidebar-width);

        }

        /* =========================================================

           TOPBAR

        ========================================================= */

        .topbar {

            min-height: 72px;

            position: sticky;

            top: 0;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            padding:

                11px

                32px;

            border-bottom:

                1px solid

                var(--border);

            background:

                rgba(

                    255,

                    255,

                    255,

                    .95

                );

            backdrop-filter:

                blur(12px);

            z-index: 50;

        }

        .page-heading {

            min-width: 0;

        }

        .page-heading h1 {

            color: var(--text-primary);

            font-size: 20px;

            font-weight: 700;

            line-height: 1.25;

        }

        .page-heading p {

            margin-top: 4px;

            color: var(--text-muted);

            font-size: 10px;

            line-height: 1.4;

        }

        /* =========================================================

           USER PROFILE

        ========================================================= */

        .user-profile {

            display: flex;

            align-items: center;

            gap: 10px;

            flex-shrink: 0;

            padding:

                5px

                8px;

            border-radius: 10px;

        }

        .user-avatar {

            width: 38px;

            height: 38px;

            display: flex;

            align-items: center;

            justify-content: center;

            flex-shrink: 0;

            border-radius: 10px;

            background:

                linear-gradient(

                    135deg,

                    #fff0df,

                    #ffe2c3

                );

            color: var(--orange);

            font-size: 13px;

            font-weight: 800;

        }

        .user-data {

            min-width: 0;

        }

        .user-data strong {

            display: block;

            max-width: 210px;

            overflow: hidden;

            color: #344054;

            font-size: 11px;

            font-weight: 700;

            text-overflow: ellipsis;

            white-space: nowrap;

        }

        .user-data span {

            display: block;

            max-width: 210px;

            margin-top: 2px;

            overflow: hidden;

            color: var(--text-muted);

            font-size: 9px;

            text-overflow: ellipsis;

            white-space: nowrap;

        }

        /* =========================================================

           PAGE CONTENT

        ========================================================= */

        .page-content {

            padding:

                30px

                32px

                45px;

        }

        /* =========================================================

           GLOBAL PANEL

        ========================================================= */

        .panel {

            border:

                1px solid

                var(--border);

            border-radius: 13px;

            background:

                var(--white);

            box-shadow:

                var(--shadow-small);

        }

        /* =========================================================

           GLOBAL BUTTON

        ========================================================= */

        .btn {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 6px;

            min-height: 36px;

            padding:

                8px

                14px;

            border: none;

            border-radius: 8px;

            font-size: 10px;

            font-weight: 700;

            text-decoration: none;

            cursor: pointer;

            transition: .2s ease;

        }

        .btn-primary {

            background: var(--blue);

            color: white;

        }

        .btn-primary:hover {

            background: var(--blue-hover);

            transform: translateY(-1px);

        }

        .btn-orange {

            background: var(--orange);

            color: white;

        }

        .btn-orange:hover {

            background: #e86e00;

        }

        .btn-light {

            background: #f2f4f7;

            color: #475467;

        }

        .btn-light:hover {

            background: #e9edf1;

        }

        /* =========================================================

           INPUT

        ========================================================= */

        .form-input {

            width: 100%;

            min-height: 39px;

            padding:

                9px

                12px;

            border:

                1px solid

                #d7dde5;

            border-radius: 8px;

            outline: none;

            background: white;

            color: #344054;

            font-size: 11px;

            transition:

                border .2s ease,

                box-shadow .2s ease;

        }

        .form-input:focus {

            border-color: var(--blue);

            box-shadow:

                0 0 0 3px

                rgba(

                    20,

                    115,

                    230,

                    .08

                );

        }

        /* =========================================================

           ALERT

        ========================================================= */

        .alert {

            margin-bottom: 18px;

            padding:

                12px

                15px;

            border-radius: 9px;

            font-size: 11px;

            line-height: 1.5;

        }

        .alert-success {

            border:

                1px solid

                #b7e4c7;

            background: #ecf9f1;

            color: #247443;

        }

        .alert-error {

            border:

                1px solid

                #fac5c5;

            background: #fff0f0;

            color: #b42318;

        }

        /* =========================================================

           SCROLLBAR

        ========================================================= */

        .sidebar::-webkit-scrollbar {

            width: 4px;

        }

        .sidebar::-webkit-scrollbar-track {

            background: transparent;

        }

        .sidebar::-webkit-scrollbar-thumb {

            border-radius: 20px;

            background:

                rgba(

                    17,

                    24,

                    39,

                    .12

                );

        }

        /* =========================================================

           RESPONSIVE

        ========================================================= */

        @media (max-width: 900px) {

            :root {

                --sidebar-width: 220px;

            }

            .sidebar {

                padding-left: 12px;

                padding-right: 12px;

            }

            .sidebar-brand img {

                max-width: 175px;

            }

            .topbar {

                padding-left: 20px;

                padding-right: 20px;

            }

            .page-content {

                padding-left: 20px;

                padding-right: 20px;

            }

            .user-data strong,

            .user-data span {

                max-width: 150px;

            }

        }

        @media (max-width: 700px) {

            :root {

                --sidebar-width: 190px;

            }

            .sidebar-brand img {

                max-width: 150px;

            }

            .menu-link {

                font-size: 11px;

                padding-left: 10px;

                padding-right: 10px;

            }

            .page-heading h1 {

                font-size: 17px;

            }

            .user-data {

                display: none;

            }

            .page-content {

                padding:

                    20px

                    15px

                    35px;

            }

        }

    </style>

    @stack('styles')

</head>

<body>

<div class="app-shell">

    <!-- =========================================================

         SIDEBAR

    ========================================================== -->

    <aside class="sidebar">

        <!-- =====================================================

             LOGO

        ====================================================== -->

        <a

            href="{{ route('dashboard') }}"

            class="sidebar-brand"

        >

            <img

                src="{{ asset('images/logo-arjuna.png') }}"

                alt="PT Arjuna Petrogas Indonesia"

            >

        </a>

        <!-- =====================================================

             DASHBOARD

        ====================================================== -->

        <div class="menu-group">

            <div class="menu-label">

                Dashboard

            </div>

            <a

                href="{{ route('dashboard') }}"

                class="

                    menu-link

                    {{

                        request()->routeIs('dashboard')

                            ? 'active'

                            : ''

                    }}

                "

            >

                <svg viewBox="0 0 24 24">

                    <path d="M3 11L12 4L21 11"></path>

                    <path d="M5 10V20H19V10"></path>

                    <path d="M9 20V14H15V20"></path>

                </svg>

                Dashboard

            </a>

        </div>

        <!-- =====================================================

             DOKUMEN

        ====================================================== -->

        <div class="menu-group">

            <div class="menu-label">

                Dokumen

            </div>

            <!-- FORMULIR MOC -->

            <a

                href="{{ route('documents.moc') }}"

                class="

                    menu-link

                    {{

                        request()->routeIs('documents.moc')

                            ? 'active'

                            : ''

                    }}

                "

            >

                <svg viewBox="0 0 24 24">

                    <rect

                        x="5"

                        y="3"

                        width="14"

                        height="18"

                        rx="1"

                    ></rect>

                    <path d="M9 8H15"></path>

                    <path d="M9 12H15"></path>

                    <path d="M9 16H13"></path>

                </svg>

                Formulir MOC

            </a>

            <!-- BERITA ACARA -->

            <a

                href="{{ route('documents.berita-acara') }}"

                class="

                    menu-link

                    {{

                        request()->routeIs('documents.berita-acara')

                            ? 'active'

                            : ''

                    }}

                "

            >

                <svg viewBox="0 0 24 24">

                    <path d="M6 3H15L19 7V21H6Z"></path>

                    <path d="M14 3V8H19"></path>

                    <path d="M9 12H16"></path>

                    <path d="M9 16H16"></path>

                </svg>

                Berita Acara

            </a>

            <!-- SURAT TUGAS -->

            <a

                href="{{ route('documents.surat-tugas') }}"

                class="

                    menu-link

                    {{

                        request()->routeIs('documents.surat-tugas')

                            ? 'active'

                            : ''

                    }}

                "

            >

                <svg viewBox="0 0 24 24">

                    <path d="M7 4H17V20H7Z"></path>

                    <path d="M9 4V2H15V4"></path>

                    <path d="M10 9H14"></path>

                    <path d="M10 13H14"></path>

                </svg>

                Surat Tugas

            </a>

        </div>

        <!-- =====================================================

             DATA KARYAWAN

        ====================================================== -->

        <div class="menu-group">

            <div class="menu-label">

                Data Karyawan

            </div>

            <a

                href="{{ route('employees.index') }}"

                class="

                    menu-link

                    {{

                        request()->routeIs('employees.*')

                            ? 'active'

                            : ''

                    }}

                "

            >

                <svg viewBox="0 0 24 24">

                    <circle

                        cx="9"

                        cy="8"

                        r="3"

                    ></circle>

                    <path

                        d="M3 19C3 15.5 5.5 13 9 13C12.5 13 15 15.5 15 19"

                    ></path>

                    <circle

                        cx="17"

                        cy="9"

                        r="2"

                    ></circle>

                    <path

                        d="M16 14C19 14 21 16 21 19"

                    ></path>

                </svg>

                Data Karyawan

            </a>

            <!-- SCHEDULE KARYAWAN -->

            <a

                href="{{ route('schedules.index') }}"

                class="

                    menu-link

                    {{

                        request()->routeIs('schedules.*')

                            ? 'active'

                            : ''

                    }}

                "

            >

                <svg viewBox="0 0 24 24">

                    <rect

                        x="3"

                        y="5"

                        width="18"

                        height="16"

                        rx="2"

                    ></rect>

                    <path d="M16 3V7"></path>

                    <path d="M8 3V7"></path>

                    <path d="M3 10H21"></path>

                    <path d="M8 14H8.01"></path>

                    <path d="M12 14H12.01"></path>

                    <path d="M16 14H16.01"></path>

                    <path d="M8 18H8.01"></path>

                    <path d="M12 18H12.01"></path>

                </svg>

                Schedule Karyawan

            </a>

        </div>

        <!-- =====================================================

             RIWAYAT

        ====================================================== -->

        <div class="menu-group">

            <div class="menu-label">

                Riwayat

            </div>

            <a

                href="{{ route('documents.index') }}"

                class="

                    menu-link

                    {{

                        request()->routeIs('documents.index')

                            ? 'active'

                            : ''

                    }}

                "

            >

                <svg viewBox="0 0 24 24">

                    <circle

                        cx="12"

                        cy="12"

                        r="8"

                    ></circle>

                    <path

                        d="M12 8V12L15 14"

                    ></path>

                </svg>

                Semua Dokumen

            </a>

            <a href="{{ route('activity-logs.index') }}" class="menu-link {{ request()->routeIs('activity-logs.*') ? 'active' : '' }}"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"></circle><path d="M12 7v5l3 2"></path></svg>Riwayat Aktivitas</a>

        </div>

        <!-- =====================================================

             PENGATURAN

        ====================================================== -->

        <div class="menu-group">

            <div class="menu-label">

                Pengaturan

            </div>

            <!-- SIGNATURE LIBRARY -->

            <a

                href="{{ route('signatures.index') }}"

                class="

                    menu-link

                    {{

                        request()->routeIs('signatures.*')

                            ? 'active'

                            : ''

                    }}

                "

            >

                <svg viewBox="0 0 24 24">

                    <path d="M4 18C8 14 9 10 12 7"></path>

                    <path d="M12 7L16 3L20 7L16 11Z"></path>

                    <path d="M4 20H20"></path>

                </svg>

                Signature Library

            </a>

            <!-- PENGATURAN REVISI DOKUMEN -->
            <a
                href="{{ route('document-revisions.index') }}"
                class="menu-link {{ request()->routeIs('document-revisions.*') ? 'active' : '' }}"
            >
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"></path>
                    <path d="M14 2v6h6"></path>
                    <path d="M8 12h8M8 16h8"></path>
                </svg>
                Revisi Dokumen
            </a>

            

            <!-- LOGOUT -->

            <form

                method="POST"

                action="{{ route('logout') }}"

                class="logout-form"

            >

                @csrf

                <button

                    type="submit"

                    class="menu-link"

                >

                    <svg viewBox="0 0 24 24">

                        <path d="M10 4H5V20H10"></path>

                        <path d="M14 8L18 12L14 16"></path>

                        <path d="M18 12H9"></path>

                    </svg>

                    Logout

                </button>

            </form>

        </div>

    </aside>

    <!-- =========================================================

         MAIN AREA

    ========================================================== -->

    <main class="main-area">

        <!-- =====================================================

             TOPBAR

        ====================================================== -->

        <header class="topbar">

            <div class="page-heading">

                <h1>

                    @yield(

                        'page-title',

                        'Dashboard'

                    )

                </h1>

                <p>

                    @yield(

                        'page-subtitle',

                        'SIKAP (Sistem Kelengkapan Administrasi Personil)'

                    )

                </p>

            </div>

            <!-- USER -->

            <div class="user-profile">

                <div class="user-avatar">

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

                <div class="user-data">

                    <strong>

                        {{

                            auth()

                                ->user()

                                ->name

                        }}

                    </strong>

                    <span>

                        {{

                            auth()

                                ->user()

                                ->email

                        }}

                    </span>

                </div>

            </div>

        </header>

        <!-- =====================================================

             PAGE CONTENT

        ====================================================== -->

        <div class="page-content">

            <!-- ERROR -->

            @if(session('error'))

                <div

                    class="

                        alert

                        alert-error

                    "

                >

                    {{

                        session('error')

                    }}

                </div>

            @endif

            @yield('content')

        </div>

    </main>

</div>

@stack('scripts')

</body>

</html>
