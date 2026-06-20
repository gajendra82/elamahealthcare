<?php

namespace Database\Seeders;

use App\Models\CsrGallery;
use Illuminate\Database\Seeder;

class CsrGallerySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'Community Health Camp',
                'description' => 'Free health screening and medicine distribution for underserved communities.',
                'image' => 'images/banners/hero-1.jpeg',
                'sort_order' => 1,
            ],
            [
                'title' => 'Medical Education Initiative',
                'description' => 'Supporting continuing medical education for healthcare professionals in Thane district.',
                'image' => 'images/banners/hero-2.jpeg',
                'sort_order' => 2,
            ],
            [
                'title' => 'Healthcare Access Program',
                'description' => 'Partnering with local organizations to improve access to affordable medicines.',
                'image' => 'images/banners/hero-1.jpeg',
                'sort_order' => 3,
            ],
        ];

        foreach ($items as $item) {
            CsrGallery::query()->updateOrCreate(
                ['title' => $item['title']],
                $item + ['is_active' => true]
            );
        }
    }
}
