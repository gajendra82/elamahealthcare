<?php

namespace App\Http\Controllers;

use App\Models\Leadership;
use App\Services\SeoService;

class AboutController extends Controller
{
    public function __construct(
        private readonly SeoService $seoService
    ) {}

    public function index()
    {
        return view('pages.about', [
            'seo' => $this->seoService->forPage(
                'About Us | Elama Healthcare',
                'Learn about Elama Healthcare Solutions — serving global healthcare needs through empathy, innovation and technology.'
            ),
            'leadership' => Leadership::query()->active()->ordered()->limit(2)->get(),
        ]);
    }
}
