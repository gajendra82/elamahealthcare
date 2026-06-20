<?php

namespace App\Services;

use App\Mail\ContactEnquiryMail;
use App\Models\ContactEnquiry;
use Illuminate\Support\Facades\Mail;

class ContactService
{
    public function __construct(
        private readonly SettingService $settingService
    ) {}

    public function store(array $data): ContactEnquiry
    {
        $enquiry = ContactEnquiry::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'subject' => $data['subject'] ?? null,
            'message' => $data['message'],
            'status' => 'new',
        ]);

        $recipient = $this->settingService->get('contact_email', config('mail.from.address'));

        if ($recipient) {
            Mail::to($recipient)->queue(new ContactEnquiryMail($enquiry));
        }

        return $enquiry;
    }
}
