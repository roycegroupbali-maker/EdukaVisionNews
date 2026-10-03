<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminAccountActivated extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Akun Admin Anda Sudah Aktif — EdukaVisionNews');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.admin.account-activated', with: ['user' => $this->user]);
    }
}
