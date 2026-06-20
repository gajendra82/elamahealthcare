<?php

namespace App\Mail;

use App\Models\ContactEnquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactEnquiryMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public ContactEnquiry $enquiry
    ) {}

    public function envelope(): Envelope
    {
        $subject = $this->enquiry->subject
            ? "Contact Enquiry: {$this->enquiry->subject}"
            : 'New Contact Enquiry - Elama Healthcare';

        return new Envelope(
            subject: $subject,
            replyTo: [$this->enquiry->email],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-enquiry',
        );
    }
}
