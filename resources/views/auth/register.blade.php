<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register - SIKAP (Sistem Kelengkapan Administrasi Personil)</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;

            font-family: Arial, Helvetica, sans-serif;
            background: #f3f4f6;
        }

        .wrapper {
            width: 100%;
            max-width: 450px;
        }

        .brand {
            text-align: center;
            margin-bottom: 24px;
        }

        .brand h1 {
            margin: 0 0 6px;
            color: #111827;
        }

        .brand p {
            margin: 0;
            color: #6b7280;
        }

        .card {
            background: #ffffff;
            padding: 32px;
            border-radius: 16px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.09);
        }

        .card h2 {
            margin-top: 0;
            margin-bottom: 8px;
            color: #111827;
        }

        .description {
            margin-top: 0;
            margin-bottom: 24px;

            color: #6b7280;
            font-size: 14px;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;

            color: #374151;
            font-weight: 600;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 12px 13px;

            border: 1px solid #d1d5db;
            border-radius: 8px;

            font-size: 14px;
            background: #ffffff;
        }

        input:focus {
            outline: none;
            border-color: #111827;
        }

        .password-info {
            margin-top: 6px;

            color: #9ca3af;
            font-size: 12px;
        }

        .register-button {
            width: 100%;
            padding: 13px;

            border: none;
            border-radius: 8px;

            background: #111827;
            color: #ffffff;

            font-size: 15px;
            font-weight: 600;

            cursor: pointer;
        }

        .register-button:hover {
            background: #1f2937;
        }

        .login-link {
            margin-top: 20px;

            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }

        .login-link a {
            color: #2563eb;
            font-weight: 600;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .alert {
            margin-bottom: 18px;
            padding: 12px 14px;

            border-radius: 8px;
            font-size: 14px;
            line-height: 1.5;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
        }
    </style>

</head>

<body>

<div class="wrapper">

    <!-- BRAND -->
    <div class="brand">

        <h1>
            SIKAP (Sistem Kelengkapan Administrasi Personil)
        </h1>

        <p>
            PT Arjuna Petrogas Indonesia
        </p>

    </div>


    <!-- REGISTER CARD -->
    <div class="card">

        <h2>
            Buat Akun
        </h2>

        <p class="description">
            Daftar menggunakan email aktif.
            Email pribadi maupun email kantor dapat digunakan.
            Setelah daftar, kode OTP akan digunakan untuk verifikasi akun.
        </p>


        <!-- SUCCESS MESSAGE -->
        @if(session('success'))

            <div class="alert alert-success">
                {{ session('success') }}
            </div>

        @endif


        <!-- ERROR MESSAGE -->
        @if($errors->any())

            <div class="alert alert-error">

                @foreach($errors->all() as $error)

                    <div>
                        {{ $error }}
                    </div>

                @endforeach

            </div>

        @endif


        <!-- REGISTER FORM -->
        <form
            method="POST"
            action="{{ route('register.process') }}"
        >

            @csrf


            <!-- NAME -->
            <div class="form-group">

                <label for="name">
                    Nama Lengkap
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Masukkan nama lengkap"
                    autocomplete="name"
                    required
                    autofocus
                >

            </div>


            <!-- EMAIL -->
            <div class="form-group">

                <label for="email">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="contoh@gmail.com"
                    autocomplete="email"
                    required
                >

            </div>


            <!-- PASSWORD -->
            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Minimal 8 karakter"
                    minlength="8"
                    autocomplete="new-password"
                    required
                >

                <div class="password-info">
                    Password minimal 8 karakter.
                </div>

            </div>


            <!-- CONFIRM PASSWORD -->
            <div class="form-group">

                <label for="password_confirmation">
                    Konfirmasi Password
                </label>

                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Masukkan ulang password"
                    minlength="8"
                    autocomplete="new-password"
                    required
                >

            </div>


            <!-- BUTTON -->
            <button
                type="submit"
                class="register-button"
            >
                Daftar & Kirim OTP
            </button>

        </form>


        <!-- LOGIN -->
        <div class="login-link">

            Sudah punya akun?

            <a href="{{ route('login') }}">
                Login
            </a>

        </div>

    </div>

</div>

</body>

</html>

