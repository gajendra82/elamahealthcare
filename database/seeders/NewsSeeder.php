<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Elama Healthcare Expands Cardiovascular Portfolio Across Asia-Pacific Markets',
                'excerpt' => 'Elama Healthcare strengthens its cardiovascular and diabetes therapeutic segments with new dossier-ready products for private markets in Southeast Asia.',
                'content' => "Elama Healthcare Solutions Pvt. Ltd. continues to expand its cardiovascular portfolio, leveraging decades of formulation expertise and WHO GMP-certified manufacturing partnerships.\n\nThe company has secured new supply agreements across Myanmar, Cambodia, Vietnam and the Philippines, reinforcing its commitment to affordable quality medicines in high-growth therapeutic segments.",
                'published_at' => now()->subMonths(2),
            ],
            [
                'title' => 'New WHO GMP Partnership Strengthens Injectable Manufacturing Capabilities',
                'excerpt' => 'A strategic manufacturing alliance enhances Elama\'s capacity for small volume parenterals, lyophilized injections and cephalosporin products.',
                'content' => "Elama Healthcare has entered a new manufacturing partnership with a WHO GMP and EU GMP certified facility, expanding capacity for injectable and lyophilized dosage forms.\n\nThis alliance supports the company's contract manufacturing and dossier out-licensing services for global generic partners.",
                'published_at' => now()->subMonth(),
            ],
            [
                'title' => 'Elama Healthcare Highlights IPMC Capabilities at International Pharma Summit',
                'excerpt' => 'The Intellectual Property Management Cell showcased patent landscape analysis and non-infringing generic development strategies.',
                'content' => "Elama Healthcare's Intellectual Property Management Cell (IPMC) presented its capabilities in patent analysis, landscape reporting and filing strategies at a leading international pharmaceutical summit.\n\nThe IPMC supports R&D pipeline decisions, co-development projects and regulatory filing strategies for partners worldwide.",
                'published_at' => now()->subWeeks(2),
            ],
        ];

        foreach ($articles as $article) {
            News::query()->updateOrCreate(
                ['slug' => Str::slug($article['title'])],
                $article + [
                    'image' => 'images/banners/hero-1.jpeg',
                    'is_active' => true,
                    'meta_title' => $article['title'],
                    'meta_description' => $article['excerpt'],
                ]
            );
        }
    }
}
