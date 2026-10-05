<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register - ARJ Document System</title>

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
            background: white;
            padding: 32px;
            border-radius: 16px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.09);
        }

        .card h2 {
            margin-top: 0;
            margin-bottom: 8px;
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
            font-weight: 600;
            color: #374151;
        }

        input {
            width: 100%;
            padding: 12px 13px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #111827;
        }

        .button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 8px;
            background: #111827;
            color: white;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
        }

        .button:hover {
            background: #1f2937;
        }

        .alert {
            padding: 12px 14px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 14px;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
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

        .info {
            margin-top: 6px;
            font-size: 12px;
            color: #9ca3af;
        }
    </style>
</head>

<body>

<div class="wrapper">

    <div class="brand">
        <h1>ARJ Document System</h1>
        <p>PT Arjuna Petrogas Indonesia</p>
    </div>

    <div class="card">

        <h2>Buat Akun</h2>

        <p class="description">
            Daftar menggunakan email aktif.
            Email pribadi maupun email kantor dapat digunakan.
            Setelah daftar, kode OTP akan dikirim untuk verifikasi akun.
        </p>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('register.process') }}"
        >

            @csrf

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
                    required
                    autofocus
                >
            </div>

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
                    required
                >
            </div>

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
                    required
                >

                <div class="info">
                    Password minimal 8 karakter.
                </div>
            </div>

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
                    required
                >
            </div>

            <button
                type="submit"
                class="button"
            >
                Daftar & Kirim OTP
            </button>

        </form>

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