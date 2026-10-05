<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | REGISTER PAGE
    |--------------------------------------------------------------------------
    */

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.register');
    }


    /*
    |--------------------------------------------------------------------------
    | REGISTER PROCESS
    |--------------------------------------------------------------------------
    */

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',

            'email' => 'required|email|max:255|unique:users,email',

            'password' => 'required|string|min:8|confirmed',
        ]);


        /*
        |--------------------------------------------------------------------------
        | CREATE USER
        |--------------------------------------------------------------------------
        */

        $user = User::create([
            'name' => trim($request->name),

            'email' => strtolower(
                trim($request->email)
            ),

            'password' => $request->password,

            'email_verified_at' => null,
        ]);


        /*
        |--------------------------------------------------------------------------
        | SEND OTP
        |--------------------------------------------------------------------------
        */

        $this->sendOtp(
            $user,
            'register'
        );


        /*
        |--------------------------------------------------------------------------
        | SAVE OTP SESSION
        |--------------------------------------------------------------------------
        */

        session([
            'otp_user_id' => $user->id,

            'otp_purpose' => 'register',

            'otp_remember' => false,
        ]);


        return redirect()
            ->route('otp.form')
            ->with(
                'success',
                'Kode OTP telah dikirim ke email Anda.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | LOGIN PAGE
    |--------------------------------------------------------------------------
    */

    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }


    /*
    |--------------------------------------------------------------------------
    | LOGIN PROCESS
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',

            'password' => 'required|string',
        ]);


        /*
        |--------------------------------------------------------------------------
        | FIND USER
        |--------------------------------------------------------------------------
        */

        $user = User::where(
            'email',
            strtolower(
                trim($request->email)
            )
        )->first();


        /*
        |--------------------------------------------------------------------------
        | CHECK EMAIL + PASSWORD
        |--------------------------------------------------------------------------
        */

        if (
            !$user ||
            !Hash::check(
                $request->password,
                $user->password
            )
        ) {
            return back()
                ->withInput(
                    $request->only('email')
                )
                ->withErrors([
                    'email' => 'Email atau password salah.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | PURPOSE
        |--------------------------------------------------------------------------
        |
        | Kalau email belum pernah diverifikasi,
        | maka OTP ini sekaligus verifikasi akun.
        |
        */

        $purpose = $user->email_verified_at
            ? 'login'
            : 'register';


        /*
        |--------------------------------------------------------------------------
        | SEND OTP
        |--------------------------------------------------------------------------
        */

        $this->sendOtp(
            $user,
            $purpose
        );


        /*
        |--------------------------------------------------------------------------
        | SAVE SESSION
        |--------------------------------------------------------------------------
        */

        session([
            'otp_user_id' => $user->id,

            'otp_purpose' => $purpose,

            'otp_remember' => $request->boolean('remember'),
        ]);


        return redirect()
            ->route('otp.form')
            ->with(
                'success',
                'Kode OTP telah dikirim ke email Anda.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | OTP PAGE
    |--------------------------------------------------------------------------
    */

    public function showOtp()
    {
        if (!session()->has('otp_user_id')) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Silakan login terlebih dahulu.',
                ]);
        }


        $user = User::find(
            session('otp_user_id')
        );


        if (!$user) {
            session()->forget([
                'otp_user_id',
                'otp_purpose',
                'otp_remember',
            ]);

            return redirect()->route('login');
        }


        return view(
            'auth.verify-otp',
            compact('user')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | VERIFY OTP
    |--------------------------------------------------------------------------
    */

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);


        /*
        |--------------------------------------------------------------------------
        | GET USER FROM SESSION
        |--------------------------------------------------------------------------
        */

        $userId = session('otp_user_id');


        if (!$userId) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'otp' => 'Session OTP sudah berakhir.',
                ]);
        }


        $user = User::find($userId);


        if (!$user) {
            return redirect()->route('login');
        }


        /*
        |--------------------------------------------------------------------------
        | CHECK OTP EXISTS
        |--------------------------------------------------------------------------
        */

        if (empty($user->otp_code)) {
            return back()
                ->withErrors([
                    'otp' => 'Kode OTP tidak tersedia. Silakan kirim ulang OTP.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | CHECK EXPIRED
        |--------------------------------------------------------------------------
        */

        if (
            !$user->otp_expires_at ||
            now()->greaterThan(
                $user->otp_expires_at
            )
        ) {
            return back()
                ->withErrors([
                    'otp' => 'Kode OTP sudah kedaluwarsa. Silakan kirim ulang OTP.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | CHECK OTP
        |--------------------------------------------------------------------------
        */

        if (
            !Hash::check(
                $request->otp,
                $user->otp_code
            )
        ) {
            return back()
                ->withErrors([
                    'otp' => 'Kode OTP salah.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | VERIFY EMAIL
        |--------------------------------------------------------------------------
        */

        if (!$user->email_verified_at) {
            $user->email_verified_at = now();
        }


        /*
        |--------------------------------------------------------------------------
        | REMOVE OTP
        |--------------------------------------------------------------------------
        */

        $user->otp_code = null;

        $user->otp_expires_at = null;

        $user->save();


        /*
        |--------------------------------------------------------------------------
        | LOGIN USER
        |--------------------------------------------------------------------------
        */

        $remember = session(
            'otp_remember',
            false
        );


        Auth::login(
            $user,
            $remember
        );


        /*
        |--------------------------------------------------------------------------
        | REGENERATE SESSION
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerate();


        /*
        |--------------------------------------------------------------------------
        | CLEAR OTP SESSION
        |--------------------------------------------------------------------------
        */

        session()->forget([
            'otp_user_id',
            'otp_purpose',
            'otp_remember',
        ]);


        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Login berhasil.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | RESEND OTP
    |--------------------------------------------------------------------------
    */

    public function resendOtp()
    {
        $userId = session('otp_user_id');


        if (!$userId) {
            return redirect()->route('login');
        }


        $user = User::find($userId);


        if (!$user) {
            return redirect()->route('login');
        }


        $purpose = session(
            'otp_purpose',
            'login'
        );


        $this->sendOtp(
            $user,
            $purpose
        );


        return back()
            ->with(
                'success',
                'Kode OTP baru telah dikirim.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        Auth::logout();


        $request->session()->invalidate();


        $request->session()->regenerateToken();


        return redirect()
            ->route('login')
            ->with(
                'success',
                'Anda berhasil logout.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SEND OTP
    |--------------------------------------------------------------------------
    */

    private function sendOtp(
        User $user,
        string $purpose
    ): void {
        /*
        |--------------------------------------------------------------------------
        | GENERATE OTP
        |--------------------------------------------------------------------------
        */

        $otp = (string) random_int(
            100000,
            999999
        );


        /*
        |--------------------------------------------------------------------------
        | SAVE HASHED OTP
        |--------------------------------------------------------------------------
        */

        $user->otp_code = Hash::make($otp);


        /*
        |--------------------------------------------------------------------------
        | OTP EXPIRES IN 5 MINUTES
        |--------------------------------------------------------------------------
        */

        $user->otp_expires_at = now()->addMinutes(5);


        $user->save();


        /*
        |--------------------------------------------------------------------------
        | SEND EMAIL
        |--------------------------------------------------------------------------
        */

        Mail::to(
            $user->email
        )->send(
            new OtpMail(
                $user,
                $otp,
                $purpose
            )
        );
    }
}