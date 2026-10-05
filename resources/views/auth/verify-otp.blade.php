<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Verifikasi OTP - SIKAP (Sistem Kelengkapan Administrasi Personil)</title>

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

        .card {
            width: 100%;
            max-width: 430px;
            background: white;
            padding: 32px;
            border-radius: 16px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.09);
            text-align: center;
        }

        h2 {
            margin-top: 0;
        }

        .description {
            color: #6b7280;
            font-size: 14px;
            line-height: 1.5;
        }

        .email {
            margin: 15px 0 22px;
            font-weight: 600;
        }

        .otp-input {
            width: 100%;
            padding: 15px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            text-align: center;
            font-size: 26px;
            letter-spacing: 8px;
            margin-bottom: 18px;
        }

        .otp-input:focus {
            outline: none;
            border-color: #111827;
        }

        button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }

        .verify {
            background: #111827;
            color: white;
        }

        .resend {
            margin-top: 10px;
            background: transparent;
            color: #2563eb;
        }

        .alert {
            padding: 12px 14px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 14px;
            text-align: left;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .expire {
            margin-top: 15px;
            font-size: 12px;
            color: #9ca3af;
        }
    </style>
</head>

<body>

<div class="card">

    <h2>Verifikasi OTP</h2>

    <p class="description">
        Masukkan kode OTP 6 digit yang dikirim ke email:
    </p>

    <div class="email">
        {{ $user->email }}
    </div>

    @if(session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert error">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('otp.verify') }}"
    >

        @csrf

        <input
            type="text"
            name="otp"
            class="otp-input"
            maxlength="6"
            inputmode="numeric"
            pattern="[0-9]{6}"
            placeholder="000000"
            autocomplete="one-time-code"
            required
            autofocus
        >

        <button
            type="submit"
            class="verify"
        >
            Verifikasi OTP
        </button>

    </form>

    <form
        method="POST"
        action="{{ route('otp.resend') }}"
    >

        @csrf

        <button
            type="submit"
            class="resend"
        >
            Kirim Ulang OTP
        </button>

    </form>

    <div class="expire">
        Kode OTP berlaku selama 5 menit.
    </div>

</div>

</body>
</html>

