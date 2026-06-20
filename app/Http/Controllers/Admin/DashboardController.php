<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\CareerApplication;
use App\Models\CareerJob;
use App\Models\Category;
use App\Models\ContactEnquiry;
use App\Models\CsrGallery;
use App\Models\Leadership;
use App\Models\News;
use App\Models\Partner;
use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function dashboard(): View
    {
        return view('admin.dashboard', [
            'counts' => $this->getCounts(),
        ]);
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'counts' => $this->getCounts(),
        ]);
    }

    private function getCounts(): array
    {
        return [
            'products' => Product::query()->count(),
            'categories' => Category::query()->count(),
            'leadership' => Leadership::query()->count(),
            'testimonials' => Testimonial::query()->count(),
            'partners' => Partner::query()->count(),
            'news' => News::query()->count(),
            'csr_gallery' => CsrGallery::query()->count(),
            'career_jobs' => CareerJob::query()->count(),
            'career_applications' => CareerApplication::query()->count(),
            'contact_enquiries' => ContactEnquiry::query()->count(),
            'banners' => Banner::query()->count(),
            'pending_applications' => CareerApplication::query()->pending()->count(),
            'new_enquiries' => ContactEnquiry::query()->new()->count(),
        ];
    }
}
