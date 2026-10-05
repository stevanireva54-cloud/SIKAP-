<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Verifikasi OTP
    </title>

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

            background: #f3f4f6;

            font-family:
                Arial,
                Helvetica,
                sans-serif;
        }


        .card {

            width: 100%;

            max-width: 430px;

            background: white;

            padding: 32px;

            border-radius: 16px;

            box-shadow:
                0 15px 40px
                rgba(0,0,0,.09);

            text-align: center;
        }


        .email {

            color: #6b7280;

            margin-bottom: 25px;
        }


        .otp-input {

            width: 100%;

            padding: 15px;

            border:
                1px solid #d1d5db;

            border-radius: 8px;

            text-align: center;

            font-size: 26px;

            letter-spacing: 8px;

            margin-bottom: 18px;
        }


        button {

            width: 100%;

            border: 0;

            border-radius: 8px;

            padding: 13px;

            cursor: pointer;

            font-weight: 600;
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

            padding: 12px;

            border-radius: 8px;

            margin-bottom: 18px;

            text-align: left;
        }


        .success {

            background: #dcfce7;

            color: #166534;
        }


        .error {

            background: #fee2e2;

            color: #991b1b;
        }

    </style>

</head>

<body>

<div class="card">

    <h2>
        Verifikasi OTP
    </h2>


    <p>
        Kode OTP telah dikirim ke:
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

            @foreach(
                $errors->all()
                as $error
            )

                <div>
                    {{ $error }}
                </div>

            @endforeach

        </div>

    @endif


    <form
        action="{{ route('otp.verify') }}"
        method="POST"
    >

        @csrf


        <input
            type="text"
            name="otp"
            maxlength="6"
            inputmode="numeric"
            pattern="[0-9]{6}"
            class="otp-input"
            placeholder="000000"
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


    <p
        style="
            font-size:13px;
            color:#9ca3af;
        "
    >
        OTP berlaku selama 5 menit.
    </p>

</div>

</body>
</html>