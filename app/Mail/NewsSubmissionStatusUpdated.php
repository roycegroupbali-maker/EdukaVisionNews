<?php

namespace App\Mail;

use App\Models\NewsSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsSubmissionStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public NewsSubmission $submission,
        public string $previousStatus,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Update Status Usulan Berita Kamu — '.$this->submission->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.news-submission.status-updated',
            with: [
                'submission' => $this->submission,
                'previousStatus' => $this->previousStatus,
            ],
        );
    }
}
