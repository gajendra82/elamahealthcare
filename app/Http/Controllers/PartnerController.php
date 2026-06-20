<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Services\SeoService;

class PartnerController extends Controller
{
    public function __construct(
        private readonly SeoService $seoService
    ) {}

    public function index()
    {
        return view('pages.partners', [
            'seo' => $this->seoService->forPage(
                'Partners | Elama Healthcare',
                'Flexible, dynamic partnerships built on trust, quality and competitive pricing in the pharmaceutical industry.'
            ),
            'partners' => Partner::query()->active()->ordered()->get(),
        ]);
    }
}
