<?php

use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CareerJobController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactEnquiryController;
use App\Http\Controllers\Admin\CsrGalleryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LeadershipController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TestimonialController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

Route::get('products', [AdminPageController::class, 'products'])->name('products.index');
Route::get('categories', [AdminPageController::class, 'categories'])->name('categories.index');
Route::get('leadership', [AdminPageController::class, 'leadership'])->name('leadership.index');
Route::get('csr-gallery', [AdminPageController::class, 'csrGallery'])->name('csr.index');
Route::get('partners', [AdminPageController::class, 'partners'])->name('partners.index');
Route::get('news', [AdminPageController::class, 'news'])->name('news.index');
Route::get('career-jobs', [AdminPageController::class, 'jobs'])->name('jobs.index');
Route::get('contact-enquiries', [AdminPageController::class, 'enquiries'])->name('enquiries.index');
Route::get('settings', [AdminPageController::class, 'settings'])->name('settings.index');
Route::get('media', [AdminPageController::class, 'media'])->name('media.index');
Route::get('banners', [AdminPageController::class, 'banners'])->name('banners.index');
Route::get('testimonials', [AdminPageController::class, 'testimonials'])->name('testimonials.index');

Route::prefix('api')->name('api.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::apiResource('products', ProductController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('leadership', LeadershipController::class);
    Route::apiResource('csr-gallery', CsrGalleryController::class);
    Route::apiResource('partners', PartnerController::class);
    Route::apiResource('news', NewsController::class);
    Route::apiResource('career-jobs', CareerJobController::class);
    Route::apiResource('banners', BannerController::class);
    Route::apiResource('testimonials', TestimonialController::class);

    Route::get('contact-enquiries', [ContactEnquiryController::class, 'index'])->name('contact-enquiries.index');
    Route::get('contact-enquiries/{contactEnquiry}', [ContactEnquiryController::class, 'show'])->name('contact-enquiries.show');
    Route::patch('contact-enquiries/{contactEnquiry}', [ContactEnquiryController::class, 'update'])->name('contact-enquiries.update');

    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

    Route::get('media', [MediaController::class, 'index'])->name('media.index');
    Route::post('media/upload', [MediaController::class, 'upload'])->name('media.upload');
    Route::delete('media', [MediaController::class, 'destroy'])->name('media.destroy');
});
