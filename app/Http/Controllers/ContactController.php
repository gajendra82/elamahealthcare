<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Services\ContactService;
use App\Services\SeoService;
use App\Services\SettingService;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function __construct(
        private readonly ContactService $contactService,
        private readonly SeoService $seoService,
        private readonly SettingService $settingService
    ) {}

    public function index()
    {
        return view('pages.contact', [
            'seo' => $this->seoService->forPage(
                'Contact Us | Elama Healthcare',
                'Get in touch with Elama Healthcare Solutions Pvt. Ltd. at our corporate office in Thane, India.'
            ),
            'contact' => [
                'address' => $this->settingService->get('contact_address', config('contact.address')),
                'phone' => $this->settingService->get('contact_phone', config('contact.phone')),
                'email' => $this->settingService->get('contact_email', config('contact.email')),
            ],
        ]);
    }

    public function store(ContactRequest $request): RedirectResponse
    {
        $this->contactService->store($request->validated());

        return redirect()
            ->route('contact.index')
            ->with('success', 'Thank you for contacting us. We will get back to you shortly.');
    }
}
