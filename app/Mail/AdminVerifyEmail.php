<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class AdminVerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Verifikasi Email Akun Admin — EdukaVisionNews');
    }

    public function content(): Content
    {
        $minutes = 60;

        return new Content(
            view: 'emails.admin.verify-email',
            with: [
                'user' => $this->user,
                'expireMinutes' => $minutes,
                'url' => URL::temporarySignedRoute(
                    'admin.account.verification.verify',
                    now()->addMinutes($minutes),
                    ['id' => $this->user->getKey(), 'hash' => sha1($this->user->email)]
                ),
            ],
        );
    }
}
