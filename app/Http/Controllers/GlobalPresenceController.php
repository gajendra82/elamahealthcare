<?php

namespace App\Http\Controllers;

use App\Services\SeoService;
use App\Services\SettingService;

class GlobalPresenceController extends Controller
{
    public function __construct(
        private readonly SeoService $seoService,
        private readonly SettingService $settingService
    ) {}

    public function index()
    {
        return view('pages.global-presence', [
            'seo' => $this->seoService->forPage(
                'Global Presence | Elama Healthcare',
                'Elama Healthcare operates across India and international markets including Asia, Africa and beyond.'
            ),
            'stats' => $this->settingService->stats(),
        ]);
    }
}
