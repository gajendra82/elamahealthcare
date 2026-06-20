<?php

namespace App\Http\Controllers;

use App\Services\SeoService;

class ServiceController extends Controller
{
    public function __construct(
        private readonly SeoService $seoService
    ) {}

    public function index()
    {
        return view('pages.services', [
            'seo' => $this->seoService->forPage(
                'Services | Elama Healthcare',
                'Product development, contract manufacturing, dossier out-licensing, and intellectual property management services.'
            ),
        ]);
    }
}
