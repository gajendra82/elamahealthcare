<?php

namespace App\Mail;

use App\Models\CareerApplication;
use App\Services\StorageService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

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
        $storage = app(StorageService::class);
        $path = $storage->physicalPath($this->application->resume_path);

        if (! $path) {
            return [];
        }

        return [
            Attachment::fromPath($path)
                ->as(basename($this->application->resume_path))
                ->withMime('application/pdf'),
        ];
    }
}
