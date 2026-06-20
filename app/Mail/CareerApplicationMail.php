<?php

namespace App\Mail;

use App\Models\CareerApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CareerApplicationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public CareerApplication $application
    ) {}

    public function envelope(): Envelope
    {
        $jobTitle = $this->application->careerJob?->title ?? 'Open Position';

        return new Envelope(
            subject: "Career Application: {$jobTitle} - {$this->application->name}",
            replyTo: [$this->application->email],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.career-application',
        );
    }

    public function attachments(): array
    {
        if (! Storage::disk('public')->exists($this->application->resume_path)) {
            return [];
        }

        return [
            Attachment::fromStorageDisk('public', $this->application->resume_path)
                ->as(basename($this->application->resume_path))
                ->withMime('application/pdf'),
        ];
    }
}
