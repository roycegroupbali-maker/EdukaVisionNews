<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminPasswordChanged extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Kata Sandi Akun Admin Anda Telah Diubah — EdukaVisionNews');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.admin.password-changed', with: ['user' => $this->user]);
    }
}
