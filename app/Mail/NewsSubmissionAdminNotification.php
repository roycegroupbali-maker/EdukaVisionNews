<?php

namespace App\Mail;

use App\Models\NewsSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsSubmissionAdminNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public NewsSubmission $submission)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Permohonan Berita Baru — '.$this->submission->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.news-submission.admin-notification',
            with: [
                'submission' => $this->submission,
            ],
        );
    }
}
