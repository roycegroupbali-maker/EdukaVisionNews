<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminPasswordResetLink extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user, public string $token)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Atur Ulang Kata Sandi Akun Admin — EdukaVisionNews');
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.password-reset',
            with: [
                'user' => $this->user,
                'url' => route('admin.password.reset', [
                    'token' => $this->token,
                    'email' => $this->user->email,
                ]),
                'expireMinutes' => (int) config('auth.passwords.users.expire', 60),
            ],
        );
    }
}
