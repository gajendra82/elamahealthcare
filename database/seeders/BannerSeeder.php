<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $csrSlides = array_slice(CsrGallerySeeder::imagePaths(), 0, 3);

        $banners = [
            [
                'title' => 'Committed to Community Health',
                'subtitle' => "We supply affordable and quality medicines across the globe, regardless of geographic and socio-economic barriers.\nThrough our strong manufacturing services supported with a highly qualified technical team, we attempt to build blocks to produce an organization that manufactures therapeutics for a range of diseases.",
                'image' => 'images/banners/banner-community.jpg',
                'button_text' => 'Explore Products',
                'button_url' => '/products',
                'sort_order' => 1,
            ],
            [
                'title' => 'Global Healthcare Solutions Built on Trust, Quality & Innovation',
                'subtitle' => 'Delivering affordable, quality pharmaceutical products to healthcare professionals and patients worldwide.',
                'image' => 'images/banners/elama-banner.jpg',
                'button_text' => 'Discover Our Story',
                'button_url' => '/about',
                'sort_order' => 2,
            ],
            [
                'title' => 'Advanced Pharmaceutical Research & Quality',
                'subtitle' => 'Precision-driven laboratory excellence supporting our global medicine portfolio.',
                'image' => 'images/banners/banner-lab-1.jpg',
                'button_text' => 'Our Services',
                'button_url' => '/services',
                'sort_order' => 3,
            ],
            [
                'title' => 'Innovation in Healthcare Manufacturing',
                'subtitle' => 'World-class R&D and quality assurance for trusted pharmaceutical solutions.',
                'image' => 'images/banners/banner-lab-2.jpg',
                'button_text' => 'Manufacturing',
                'button_url' => '/manufacturing',
                'sort_order' => 4,
            ],
        ];

        $csrTitles = [
            'Serving Communities Through Healthcare',
            'Corporate Social Responsibility in Action',
            'Medical Camps & Community Outreach',
        ];

        foreach ($csrSlides as $index => $image) {
            $banners[] = [
                'title' => $csrTitles[$index] ?? 'CSR Healthcare Activity',
                'subtitle' => 'Making quality healthcare accessible through community initiatives.',
                'image' => $image,
                'button_text' => 'View CSR Activities',
                'button_url' => '/csr',
                'sort_order' => 5 + $index,
            ];
        }

        $sortOrders = [];

        foreach ($banners as $banner) {
            $sortOrders[] = $banner['sort_order'];

            Banner::query()->updateOrCreate(
                ['sort_order' => $banner['sort_order']],
                $banner + ['is_active' => true]
            );
        }

        Banner::query()->whereNotIn('sort_order', $sortOrders)->delete();
    }
}
