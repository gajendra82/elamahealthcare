<?php

namespace Database\Seeders;

use App\Models\CareerJob;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CareerJobSeeder extends Seeder
{
    public function run(): void
    {
        $jobs = [
            [
                'title' => 'Regulatory Affairs Manager',
                'department' => 'Regulatory Affairs',
                'location' => 'Navi Mumbai, India',
                'type' => 'full-time',
                'description' => "Lead regulatory submissions and dossier preparation for international markets.\nCoordinate with manufacturing partners and ensure compliance with WHO GMP, EU GMP and USFDA requirements.",
                'requirements' => "MBBS/B.Pharm/M.Pharm with 5+ years in regulatory affairs.\nExperience with CTD/eCTD dossier preparation.\nStrong knowledge of international regulatory guidelines.",
            ],
            [
                'title' => 'Business Development Executive',
                'department' => 'Sales & Marketing',
                'location' => 'Navi Mumbai, India',
                'type' => 'full-time',
                'description' => "Identify and develop new business opportunities in international pharmaceutical markets.\nBuild relationships with generic companies, distributors and licensing partners.",
                'requirements' => "Graduate/MBA with 3+ years in pharma business development.\nExperience in export markets preferred.\nExcellent communication and negotiation skills.",
            ],
            [
                'title' => 'Quality Assurance Officer',
                'department' => 'Quality Assurance',
                'location' => 'Navi Mumbai, India',
                'type' => 'full-time',
                'description' => "Support quality assurance activities across manufacturing partner sites.\nReview batch documentation, audit reports and CAPA management.",
                'requirements' => "B.Pharm/M.Sc with 2+ years QA experience in pharmaceuticals.\nKnowledge of GMP, GDP and quality risk management.\nAttention to detail and analytical skills.",
            ],
        ];

        foreach ($jobs as $job) {
            CareerJob::query()->updateOrCreate(
                ['slug' => Str::slug($job['title'])],
                $job + ['is_active' => true]
            );
        }
    }
}
