<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'title' => 'Global Healthcare Solutions',
                'subtitle' => 'Built on Trust, Quality & Innovation',
                'image' => 'images/banners/hero-1.jpeg',
                'button_text' => 'Discover Our Story',
                'button_url' => '/about',
                'sort_order' => 1,
            ],
            [
                'title' => 'Affordable Quality Medicines',
                'subtitle' => 'Delivering pharmaceutical excellence across the globe since 1986',
                'image' => 'images/banners/hero-2.jpeg',
                'button_text' => 'Explore Products',
                'button_url' => '/products',
                'sort_order' => 2,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::query()->updateOrCreate(
                ['image' => $banner['image']],
                $banner + ['is_active' => true]
            );
        }
    }
}
