<?php

namespace App\Http\Controllers;

use App\Services\SeoService;

class PageController extends Controller
{
    public function __construct(
        private readonly SeoService $seoService
    ) {}

    public function privacy()
    {
        return view('pages.privacy', [
            'seo' => $this->seoService->forPage(
                'Privacy Policy | Elama Healthcare',
                'Privacy policy for Elama Healthcare Solutions Pvt. Ltd.'
            ),
        ]);
    }

    public function terms()
    {
        return view('pages.terms', [
            'seo' => $this->seoService->forPage(
                'Terms & Conditions | Elama Healthcare',
                'Terms and conditions for Elama Healthcare Solutions Pvt. Ltd.'
            ),
        ]);
    }
}
