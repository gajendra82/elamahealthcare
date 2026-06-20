<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\CsrGallery;
use App\Models\Leadership;
use App\Models\News;
use App\Models\Testimonial;
use App\Repositories\CategoryRepository;
use App\Services\SeoService;
use App\Services\SettingService;

class HomeController extends Controller
{
    public function __construct(
        private readonly SettingService $settingService,
        private readonly CategoryRepository $categoryRepository,
        private readonly SeoService $seoService
    ) {}

    public function index()
    {
        return view('pages.home', [
            'seo' => $this->seoService->forPage(
                $this->settingService->get('seo_default_title', 'Elama Healthcare Solutions Pvt. Ltd.'),
                $this->settingService->get('seo_default_description')
            ),
            'banners' => Banner::query()->active()->ordered()->get(),
            'stats' => $this->settingService->stats(),
            'categories' => $this->categoryRepository->activeWithProductCounts(),
            'testimonials' => Testimonial::query()->active()->ordered()->limit(6)->get(),
            'news' => News::query()->active()->published()->latestNews()->limit(3)->get(),
            'leadership' => Leadership::query()->active()->ordered()->limit(2)->get(),
            'csrGalleries' => CsrGallery::query()->active()->ordered()->limit(4)->get(),
        ]);
    }
}
