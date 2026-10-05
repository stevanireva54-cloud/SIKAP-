<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - SIKAP (Sistem Kelengkapan Administrasi Personil)</title>

    <style>
        * {
            box-sizing: border-box;
        }

        :root {
            --navy: #062f52;
            --navy-dark: #031f38;
            --orange: #ff7900;
            --green: #48662b;
            --text: #10213a;
            --muted: #718096;
            --border: #dce4ec;
            --white: #ffffff;
        }

        html,
        body {
            margin: 0;
            width: 100%;
            min-height: 100%;
        }

        body {
            min-height: 100vh;

            font-family:
                "Segoe UI",
                Arial,
                Helvetica,
                sans-serif;

            color: var(--text);
            background: #f7f9fc;
        }

        button,
        input {
            font: inherit;
        }


        /* =========================================================
           MAIN LAYOUT
        ========================================================= */

        .login-page {
            width: 100%;
            min-height: 100vh;

            display: grid;

            grid-template-columns:
                minmax(430px, 43%)
                minmax(500px, 57%);
        }


        /* =========================================================
           LEFT PANEL
        ========================================================= */

        .brand-panel {
            position: relative;

            min-height: 100vh;

            display: flex;
            flex-direction: column;

            overflow: hidden;

            padding:
                42px
                52px
                32px;

            color: white;

            background:
                radial-gradient(
                    circle at 15% 8%,
                    rgba(20, 108, 173, .28),
                    transparent 32%
                ),
                linear-gradient(
                    180deg,
                    #07395f 0%,
                    var(--navy) 48%,
                    var(--navy-dark) 100%
                );
        }


        /* Orange line pemisah */

        .brand-panel::after {
            content: "";

            position: absolute;

            top: 0;
            right: 0;
            bottom: 0;

            width: 5px;

            background: var(--orange);
        }


        /* Decorative circle */

        .brand-circle {
            position: absolute;

            width: 420px;
            height: 420px;

            left: -220px;
            top: 170px;

            border-radius: 50%;

            border:
                1px solid
                rgba(255, 255, 255, .035);

            box-shadow:
                0 0 0 70px
                rgba(255, 255, 255, .015),
                0 0 0 140px
                rgba(255, 255, 255, .012);
        }


        /* =========================================================
           COMPANY LOGO
        ========================================================= */

        .company-logo {
            position: relative;
            z-index: 5;

            display: flex;
            align-items: center;

            width: 100%;
        }

        .company-logo img {
            display: block;

            width: 310px;
            max-width: 82%;

            height: auto;

            object-fit: contain;
        }


        /* =========================================================
           LEFT CONTENT
        ========================================================= */

        .brand-content {
            position: relative;
            z-index: 5;

            max-width: 460px;

            margin-top: 92px;
        }

        .brand-content h1 {
            margin: 0;

            color: white;

            font-size: 35px;
            font-weight: 800;

            line-height: 1.15;

            letter-spacing: -.6px;
        }

        .orange-line {
            width: 55px;
            height: 4px;

            margin:
                19px
                0
                23px;

            border-radius: 999px;

            background: var(--orange);
        }

        .brand-content p {
            max-width: 405px;

            margin: 0;

            color: #c6d5e2;

            font-size: 14px;

            line-height: 1.75;
        }


        /* =========================================================
           INDUSTRIAL DECORATION
        ========================================================= */

        .industrial {
            position: absolute;

            left: 0;
            right: 5px;
            bottom: 115px;

            height: 270px;

            opacity: .30;

            pointer-events: none;
        }

        .ground {
            position: absolute;

            left: 0;
            right: 0;
            bottom: 0;

            height: 72px;

            border-top:
                2px solid
                rgba(255, 122, 0, .35);

            background:
                linear-gradient(
                    180deg,
                    rgba(255, 122, 0, .03),
                    rgba(0, 0, 0, .22)
                );
        }

        .tower {
            position: absolute;

            bottom: 60px;

            width: 4px;

            background:
                rgba(255, 255, 255, .38);
        }

        .tower::before {
            content: "";

            position: absolute;

            left: 50%;
            bottom: 0;

            width: 40px;
            height: 100%;

            transform:
                translateX(-50%);

            clip-path:
                polygon(
                    50% 0,
                    100% 100%,
                    0 100%
                );

            border-left:
                2px solid
                rgba(255, 255, 255, .28);

            border-right:
                2px solid
                rgba(255, 255, 255, .28);
        }

        .tower::after {
            content: "";

            position: absolute;

            left: 50%;
            top: 20px;

            width: 26px;
            height: calc(100% - 20px);

            transform:
                translateX(-50%);

            background:
                repeating-linear-gradient(
                    180deg,
                    transparent 0 21px,
                    rgba(255, 255, 255, .16) 22px 23px
                );
        }

        .tower-one {
            left: 17%;
            height: 105px;
        }

        .tower-two {
            left: 46%;
            height: 190px;
        }

        .tower-three {
            left: 75%;
            height: 145px;
        }

        .tower-light {
            position: absolute;

            left: 50%;
            top: -5px;

            width: 7px;
            height: 7px;

            transform:
                translateX(-50%);

            border-radius: 50%;

            background: var(--orange);

            box-shadow:
                0 0 8px
                rgba(255, 122, 0, .9),
                0 0 18px
                rgba(255, 122, 0, .5);
        }


        /* =========================================================
           FEATURES
        ========================================================= */

        .features {
            position: absolute;

            z-index: 6;

            left: 52px;
            right: 52px;
            bottom: 78px;

            display: grid;

            grid-template-columns:
                repeat(
                    3,
                    minmax(0, 1fr)
                );

            gap: 20px;
        }

        .feature {
            min-width: 0;
        }

        .feature-icon {
            width: 38px;
            height: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin-bottom: 8px;

            border:
                1px solid
                var(--orange);

            border-radius: 8px;

            color: var(--orange);

            font-size: 17px;
            font-weight: 800;
        }

        .feature strong {
            display: block;

            margin-bottom: 3px;

            color: white;

            font-size: 11px;
        }

        .feature span {
            display: block;

            color: #a9bdce;

            font-size: 9px;

            line-height: 1.45;
        }


        /* =========================================================
           COPYRIGHT
        ========================================================= */

        .copyright {
            position: absolute;

            z-index: 6;

            left: 52px;
            right: 52px;
            bottom: 28px;

            padding-top: 15px;

            border-top:
                1px solid
                rgba(255, 255, 255, .14);

            color: #91a7ba;

            font-size: 9px;
        }


        /* =========================================================
           RIGHT SIDE
        ========================================================= */

        .login-side {
            position: relative;

            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            overflow: hidden;

            padding: 45px;

            background:
                radial-gradient(
                    circle,
                    rgba(16, 61, 98, .06) 1px,
                    transparent 1.4px
                )
                0 0 / 19px 19px,

                linear-gradient(
                    135deg,
                    #ffffff 0%,
                    #f8fafc 100%
                );
        }


        /* white overlay supaya dots hanya halus */

        .login-side::before {
            content: "";

            position: absolute;

            inset: 0;

            background:
                linear-gradient(
                    90deg,
                    rgba(255, 255, 255, .87),
                    rgba(255, 255, 255, .65)
                );
        }


        /* decorative waves */

        .waves {
            position: absolute;

            right: -120px;
            bottom: -110px;

            width: 520px;
            height: 330px;

            opacity: .20;

            border-radius: 50%;

            border:
                1px solid
                #7790a5;

            box-shadow:
                0 0 0 18px transparent,
                0 0 0 19px #7790a5,
                0 0 0 37px transparent,
                0 0 0 38px #7790a5,
                0 0 0 56px transparent,
                0 0 0 57px #7790a5;

            transform:
                rotate(-12deg);
        }


        /* =========================================================
           LOGIN CARD
        ========================================================= */

        .login-card {
            position: relative;
            z-index: 10;

            width: 100%;
            max-width: 500px;

            padding:
                35px
                40px
                32px;

            border:
                1px solid
                rgba(218, 226, 234, .95);

            border-radius: 18px;

            background:
                rgba(255, 255, 255, .97);

            box-shadow:
                0 24px 60px
                rgba(20, 46, 76, .13);
        }


        /* =========================================================
           LOGO DI LOGIN CARD
        ========================================================= */

        .login-logo {
            width: 100%;

            display: flex;
            justify-content: center;

            margin-bottom: 15px;
        }

        .login-logo img {
            display: block;

            width: 230px;
            max-width: 72%;

            height: auto;

            object-fit: contain;
        }


        /* =========================================================
           LOGIN HEADER
        ========================================================= */

        .login-card h2 {
            margin:
                0
                0
                9px;

            text-align: center;

            color: var(--text);

            font-size: 30px;
            font-weight: 800;

            letter-spacing: -.4px;
        }

        .login-description {
            max-width: 360px;

            margin:
                0
                auto
                22px;

            text-align: center;

            color: #65758a;

            font-size: 13px;

            line-height: 1.55;
        }

        .divider {
            height: 1px;

            margin-bottom: 22px;

            background: #e2e8ef;
        }


        /* =========================================================
           ALERTS
        ========================================================= */

        .alert {
            margin-bottom: 16px;

            padding:
                11px
                13px;

            border-radius: 8px;

            font-size: 12px;

            line-height: 1.5;
        }

        .alert-success {
            border:
                1px solid
                #b9e2c5;

            background: #effaf2;

            color: #236442;
        }

        .alert-error {
            border:
                1px solid
                #fecaca;

            background: #fff1f2;

            color: #b42318;
        }


        /* =========================================================
           FORM
        ========================================================= */

        .form-group {
            margin-bottom: 17px;
        }

        .form-group label {
            display: block;

            margin-bottom: 7px;

            color: #17263d;

            font-size: 12px;
            font-weight: 700;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;

            left: 13px;
            top: 50%;

            width: 18px;
            height: 18px;

            display: flex;
            align-items: center;
            justify-content: center;

            transform:
                translateY(-50%);

            color: #66758a;

            pointer-events: none;
        }

        .input-icon svg {
            width: 17px;
            height: 17px;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"].password-field {
            width: 100%;

            min-height: 47px;

            padding:
                11px
                43px
                11px
                42px;

            border:
                1px solid
                #d2dce6;

            border-radius: 8px;

            outline: none;

            background: white;

            color: #1f3046;

            font-size: 13px;

            transition:
                border-color .2s ease,
                box-shadow .2s ease;
        }

        input::placeholder {
            color: #9ba7b4;
        }

        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="text"].password-field:focus {
            border-color: #0a527f;

            box-shadow:
                0 0 0 3px
                rgba(10, 82, 127, .08);
        }


        /* =========================================================
           PASSWORD EYE
        ========================================================= */

        .password-toggle {
            position: absolute;

            right: 10px;
            top: 50%;

            width: 32px;
            height: 32px;

            display: flex;
            align-items: center;
            justify-content: center;

            transform:
                translateY(-50%);

            border: 0;

            background: transparent;

            color: #778598;

            cursor: pointer;
        }

        .password-toggle svg {
            width: 18px;
            height: 18px;
        }


        /* =========================================================
           REMEMBER
        ========================================================= */

        .remember {
            display: flex;
            align-items: center;

            gap: 8px;

            margin:
                2px
                0
                20px;

            color: #5c6a7d;

            font-size: 12px;

            cursor: pointer;
        }

        .remember input {
            width: 15px;
            height: 15px;

            accent-color: var(--navy);
        }


        /* =========================================================
           LOGIN BUTTON
        ========================================================= */

        .login-button {
            width: 100%;

            min-height: 47px;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 9px;

            padding:
                11px
                16px;

            border: 0;

            border-radius: 8px;

            background:
                linear-gradient(
                    180deg,
                    #073c66 0%,
                    #052a49 100%
                );

            color: white;

            font-size: 14px;
            font-weight: 800;

            cursor: pointer;

            box-shadow:
                0 9px 20px
                rgba(5, 42, 73, .19);

            transition:
                transform .2s ease,
                box-shadow .2s ease;
        }

        .login-button:hover {
            transform:
                translateY(-1px);

            box-shadow:
                0 12px 24px
                rgba(5, 42, 73, .24);
        }

        .login-button svg {
            width: 18px;
            height: 18px;

            color: var(--orange);
        }


        /* =========================================================
           SYSTEM DIVIDER
        ========================================================= */

        .system-divider {
            display: flex;
            align-items: center;

            gap: 12px;

            margin:
                24px
                0
                17px;

            color: #7c899a;

            font-size: 10px;
        }

        .system-divider::before,
        .system-divider::after {
            content: "";

            flex: 1;

            height: 1px;

            background: #e2e8ef;
        }


        /* =========================================================
           SECURITY NOTE
        ========================================================= */

        .security-note {
            display: flex;
            align-items: center;

            gap: 11px;

            padding:
                12px
                14px;

            border:
                1px solid
                #e3e9ef;

            border-radius: 8px;

            background: #f8fafc;

            color: #748195;

            font-size: 10px;

            line-height: 1.5;
        }

        .security-icon {
            width: 31px;
            height: 31px;

            flex:
                0
                0
                31px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: #edf2f6;

            color: #607086;
        }

        .security-icon svg {
            width: 17px;
            height: 17px;
        }

        .security-note strong {
            color: #25364b;
        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 1050px) {

            .login-page {
                grid-template-columns:
                    390px
                    1fr;
            }

            .brand-panel {
                padding-left: 36px;
                padding-right: 36px;
            }

            .features {
                left: 36px;
                right: 36px;
            }

            .copyright {
                left: 36px;
                right: 36px;
            }

            .brand-content h1 {
                font-size: 30px;
            }

            .company-logo img {
                width: 270px;
            }

        }


        @media (max-width: 800px) {

            .login-page {
                display: block;
            }

            .brand-panel {
                display: none;
            }

            .login-side {
                min-height: 100vh;

                padding:
                    25px
                    15px;
            }

            .login-card {
                max-width: 470px;

                padding:
                    30px
                    25px
                    27px;
            }

            .login-logo img {
                width: 210px;
            }

        }


        @media (max-width: 450px) {

            .login-card {
                padding:
                    27px
                    18px
                    24px;

                border-radius: 14px;
            }

            .login-card h2 {
                font-size: 26px;
            }

            .login-logo img {
                width: 185px;
            }

        }

    
        /* =========================================================
           SIKAP RUNNING TITLE
        ========================================================= */
        .brand-content {
            overflow: hidden;
        }

        .sikap-marquee {
            position: relative;
            width: 100%;
            overflow: hidden;
            padding: 4px 0 8px;
        }

        .sikap-marquee-track {
            display: flex;
            align-items: baseline;
            gap: 10px;
            width: max-content;
            white-space: nowrap;

            font-size: 35px;
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -.6px;

            animation: sikapJalanKeKanan 8s linear infinite;
            will-change: transform;
        }

        .sikap-orange {
            color: #ff7900 !important;
        }

        .sikap-white {
            color: #ffffff !important;
        }

        @keyframes sikapJalanKeKanan {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        @media (max-width: 1050px) {
            .sikap-marquee-track {
                font-size: 30px;
            }
        }

    </style>

</head>


<body>


<div class="login-page">


    <!-- =====================================================
         LEFT PANEL
    ====================================================== -->

    <section class="brand-panel">


        <div class="brand-circle"></div>


                <!-- MAIN TEXT -->

        <div class="brand-content">

            <div class="sikap-marquee" aria-label="SIKAP (Sistem Kelengkapan Administrasi Personil)">
                <div class="sikap-marquee-track">
                    <span class="sikap-orange">SIKAP</span>
                    <span class="sikap-white">(Sistem Kelengkapan Administrasi Personil)</span>
                </div>
            </div>

            <div class="orange-line"></div>

            <p>
                Sistem manajemen dokumen perusahaan yang aman,
                terstruktur, dan terintegrasi untuk mendukung
                kebutuhan operasional PT Arjuna Petrogas Indonesia.
            </p>

        </div>


        <!-- INDUSTRIAL DECORATION -->

        <div class="industrial">

            <div class="tower tower-one">

                <span class="tower-light"></span>

            </div>


            <div class="tower tower-two">

                <span class="tower-light"></span>

            </div>


            <div class="tower tower-three">

                <span class="tower-light"></span>

            </div>


            <div class="ground"></div>

        </div>


        <!-- FEATURES -->

        <div class="features">


            <div class="feature">

                <div class="feature-icon">
                    &#10003;
                </div>

                <strong>
                    Aman
                </strong>

                <span>
                    Keamanan data terjamin
                </span>

            </div>


            <div class="feature">

                <div class="feature-icon">
                    &#9636;
                </div>

                <strong>
                    Terstruktur
                </strong>

                <span>
                    Dokumen tersimpan dengan rapi
                </span>

            </div>


            <div class="feature">

                <div class="feature-icon">
                    &#9719;
                </div>

                <strong>
                    Terintegrasi
                </strong>

                <span>
                    Akses dokumen lebih mudah
                </span>

            </div>


        </div>


        <!-- COPYRIGHT -->

        <div class="copyright">

            &copy; {{ date('Y') }}
            PT Arjuna Petrogas Indonesia.
            All rights reserved.

        </div>


    </section>



    <!-- =====================================================
         RIGHT LOGIN
    ====================================================== -->

    <main class="login-side">


        <div class="waves"></div>


        <div class="login-card">


            <!-- LOGO -->

            <div class="login-logo">

                <img
                    src="{{ asset('images/logo-arjuna.png') }}"
                    alt="PT Arjuna Petrogas Indonesia"
                >

            </div>


            <!-- TITLE -->

            <h2>
                Login
            </h2>


            <p class="login-description">

                Masukkan email dan password akun Anda
                untuk mengakses SIKAP (Sistem Kelengkapan Administrasi Personil).

            </p>


            <div class="divider"></div>



            <!-- SUCCESS -->

            @if(session('success'))

                <div class="alert alert-success">

                    {{ session('success') }}

                </div>

            @endif



            <!-- ERROR -->

            @if($errors->any())

                <div class="alert alert-error">

                    @foreach($errors->all() as $error)

                        <div>
                            {{ $error }}
                        </div>

                    @endforeach

                </div>

            @endif



            <!-- =================================================
                 LOGIN FORM
            ================================================== -->

            <form
                method="POST"
                action="{{ route('login.process') }}"
            >

                @csrf



                <!-- EMAIL -->

                <div class="form-group">

                    <label for="email">
                        Email
                    </label>


                    <div class="input-wrapper">


                        <span class="input-icon">

                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >

                                <path
                                    d="M4 6H20V18H4V6Z"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linejoin="round"
                                />

                                <path
                                    d="M4 7L12 13L20 7"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />

                            </svg>

                        </span>


                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Masukkan email Anda"
                            autocomplete="email"
                            required
                            autofocus
                        >


                    </div>

                </div>



                <!-- PASSWORD -->

                <div class="form-group">

                    <label for="password">
                        Password
                    </label>


                    <div class="input-wrapper">


                        <span class="input-icon">

                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >

                                <rect
                                    x="5"
                                    y="10"
                                    width="14"
                                    height="10"
                                    rx="2"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                />

                                <path
                                    d="M8 10V7.5C8 5.01472 9.79086 3 12 3C14.2091 3 16 5.01472 16 7.5V10"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                />

                            </svg>

                        </span>


                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan password Anda"
                            autocomplete="current-password"
                            required
                        >


                        <!-- SHOW PASSWORD -->

                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword()"
                            aria-label="Tampilkan password"
                        >

                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >

                                <path
                                    d="M2.5 12C4.7 7.8 8 6 12 6C16 6 19.3 7.8 21.5 12C19.3 16.2 16 18 12 18C8 18 4.7 16.2 2.5 12Z"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                />

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="2.8"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                />

                            </svg>

                        </button>


                    </div>

                </div>



                <!-- REMEMBER -->

                <label class="remember">

                    <input
                        type="checkbox"
                        name="remember"
                        value="1"
                    >

                    <span>
                        Ingat saya
                    </span>

                </label>



                <!-- LOGIN BUTTON -->

                <button
                    type="submit"
                    class="login-button"
                >


                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >

                        <path
                            d="M9 5H6C4.89543 5 4 5.89543 4 7V17C4 18.1046 4.89543 19 6 19H9"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                        />

                        <path
                            d="M13 8L17 12L13 16"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />

                        <path
                            d="M9 12H17"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                        />

                    </svg>


                    Login


                </button>


            </form>



            <!-- SYSTEM -->

            <div class="system-divider">

                SIKAP (Sistem Kelengkapan Administrasi Personil)

            </div>



            <!-- SECURITY NOTE -->

            <div class="security-note">


                <div class="security-icon">

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >

                        <path
                            d="M12 3L19 6V11C19 15.5 16.2 19 12 21C7.8 19 5 15.5 5 11V6L12 3Z"
                            stroke="currentColor"
                            stroke-width="1.7"
                            stroke-linejoin="round"
                        />

                        <path
                            d="M9 12L11 14L15 10"
                            stroke="currentColor"
                            stroke-width="1.7"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />

                    </svg>

                </div>


                <div>

                    Akun pengguna dikelola oleh

                    <strong>
                        SIKAP (Sistem Kelengkapan Administrasi Personil)
                    </strong>.

                </div>


            </div>


        </div>


    </main>


</div>



<script>

    function togglePassword()
    {
        const password =
            document.getElementById('password');

        if (password.type === 'password')
        {
            password.type = 'text';

            password.classList.add(
                'password-field'
            );
        }
        else
        {
            password.type = 'password';

            password.classList.remove(
                'password-field'
            );
        }
    }

</script>


</body>
</html>