<?php

namespace App\Http\Controllers;

use App\Services\SeoService;

class ManufacturingController extends Controller
{
    public function __construct(
        private readonly SeoService $seoService
    ) {}

    public function index()
    {
        return view('pages.manufacturing', [
            'seo' => $this->seoService->forPage(
                'Manufacturing | Elama Healthcare',
                'WHO GMP, EU GMP and USFDA approved manufacturing partners delivering quality pharmaceutical products.'
            ),
        ]);
    }
}
