<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Dr. James Morrison',
                'company' => 'Global Pharma Partners Ltd.',
                'designation' => 'Chief Procurement Officer',
                'content' => 'Elama Healthcare has consistently delivered dossier-ready products with impeccable documentation. Their regulatory support and timely responses make them a trusted partner in our international expansion.',
                'rating' => 5,
            ],
            [
                'name' => 'Sarah Chen',
                'company' => 'Pacific Med Distribution',
                'designation' => 'Director of Supply Chain',
                'content' => 'We have partnered with Elama for contract manufacturing across multiple dosage forms. Their quality systems, competitive pricing and logistics support have exceeded our expectations.',
                'rating' => 5,
            ],
            [
                'name' => 'Ahmed Hassan',
                'company' => 'East Africa Healthcare Group',
                'designation' => 'Managing Director',
                'content' => 'Elama Healthcare understands the needs of emerging markets. Their affordable, WHO GMP-compliant products have helped us serve patients across Kenya, Tanzania and neighbouring countries.',
                'rating' => 5,
            ],
        ];

        foreach ($testimonials as $index => $testimonial) {
            Testimonial::query()->updateOrCreate(
                ['name' => $testimonial['name'], 'company' => $testimonial['company']],
                $testimonial + ['is_active' => true]
            );
        }
    }
}
