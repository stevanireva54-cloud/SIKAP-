<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;


    public function __construct(
        public User $user,
        public string $otp,
        public string $purpose
    ) {
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            subject:
                'Kode OTP - ARJ Document System'
        );
    }


    public function content(): Content
    {
        return new Content(
            view:
                'emails.otp'
        );
    }


    public function attachments(): array
    {
        return [];
    }
}