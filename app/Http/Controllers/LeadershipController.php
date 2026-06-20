<?php

namespace App\Http\Controllers;

use App\Models\Leadership;
use App\Services\SeoService;

class LeadershipController extends Controller
{
    public function __construct(
        private readonly SeoService $seoService
    ) {}

    public function index()
    {
        return view('pages.leadership', [
            'seo' => $this->seoService->forPage(
                'Leadership | Elama Healthcare',
                'Meet the leadership team driving Elama Healthcare\'s mission to deliver affordable quality medicines worldwide.'
            ),
            'leadership' => Leadership::query()->active()->ordered()->get(),
        ]);
    }
}
