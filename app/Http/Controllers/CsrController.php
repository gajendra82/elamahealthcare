<?php

namespace App\Http\Controllers;

use App\Models\CsrGallery;
use App\Services\SeoService;

class CsrController extends Controller
{
    public function __construct(
        private readonly SeoService $seoService
    ) {}

    public function index()
    {
        return view('pages.csr', [
            'seo' => $this->seoService->forPage(
                'CSR Activities | Elama Healthcare',
                'Corporate social responsibility initiatives delivering healthcare access and community support since 1986.'
            ),
            'galleries' => CsrGallery::query()->active()->ordered()->get(),
        ]);
    }
}
