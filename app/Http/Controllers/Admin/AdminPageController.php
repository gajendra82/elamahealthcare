<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AdminPageController extends Controller
{
    public function products(): View
    {
        return view('admin.products.index');
    }

    public function categories(): View
    {
        return view('admin.categories.index');
    }

    public function leadership(): View
    {
        return view('admin.leadership.index');
    }

    public function csrGallery(): View
    {
        return view('admin.csr.index');
    }

    public function partners(): View
    {
        return view('admin.partners.index');
    }

    public function news(): View
    {
        return view('admin.news.index');
    }

    public function jobs(): View
    {
        return view('admin.jobs.index');
    }

    public function enquiries(): View
    {
        return view('admin.enquiries.index');
    }

    public function settings(): View
    {
        return view('admin.settings.index');
    }

    public function media(): View
    {
        return view('admin.media.index');
    }

    public function banners(): View
    {
        return view('admin.banners.index');
    }

    public function testimonials(): View
    {
        return view('admin.testimonials.index');
    }
}
