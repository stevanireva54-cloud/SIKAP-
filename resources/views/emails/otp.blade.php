<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <title>Kode OTP</title>
</head>

<body
    style="
        margin:0;
        padding:30px;
        background:#f4f6f8;
        font-family:Arial,Helvetica,sans-serif;
    "
>

<div
    style="
        max-width:520px;
        margin:auto;
        background:#ffffff;
        padding:30px;
        border-radius:12px;
    "
>

    <h2 style="margin-top:0;">
        SIKAP (Sistem Kelengkapan Administrasi Personil)
    </h2>


    <p>
        Halo
        <strong>{{ $user->name }}</strong>,
    </p>


    @if($purpose === 'register')

        <p>
            Gunakan kode OTP berikut untuk
            memverifikasi akun Anda.
        </p>

    @else

        <p>
            Gunakan kode OTP berikut untuk
            menyelesaikan proses login.
        </p>

    @endif


    <div
        style="
            margin:25px 0;
            padding:18px;
            background:#f3f4f6;
            border-radius:10px;
            text-align:center;
            font-size:32px;
            font-weight:bold;
            letter-spacing:8px;
        "
    >
        {{ $otp }}
    </div>


    <p>
        Kode OTP berlaku selama
        <strong>5 menit</strong>.
    </p>


    <p
        style="
            color:#777;
            font-size:13px;
        "
    >
        Jangan berikan kode OTP ini kepada orang lain.
    </p>


    <hr
        style="
            border:none;
            border-top:1px solid #eeeeee;
            margin:25px 0;
        "
    >


    <p
        style="
            color:#999;
            font-size:12px;
        "
    >
        PT Arjuna Petrogas Indonesia<br>
        SIKAP (Sistem Kelengkapan Administrasi Personil)
    </p>

</div>

</body>

</html>

