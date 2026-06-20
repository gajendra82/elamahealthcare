<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $partners = [
            [
                'name' => 'WHO GMP Certified Facility',
                'description' => 'Manufacturing partner with WHO GMP certification for tablets, capsules and oral solutions.',
                'sort_order' => 1,
            ],
            [
                'name' => 'EU GMP Oncology Partner',
                'description' => 'Specialized partner for oncology tablets, capsules, injectables and lyophilized formulations.',
                'sort_order' => 2,
            ],
            [
                'name' => 'USFDA Approved Plant',
                'description' => 'USFDA and UK MHRA approved facility for beta-lactam and general dosage forms.',
                'sort_order' => 3,
            ],
            [
                'name' => 'Ophthalmic Solutions Partner',
                'description' => 'Dedicated facility for ophthalmic solutions and liquid injectables with global certifications.',
                'sort_order' => 4,
            ],
            [
                'name' => 'Cephalosporin Injectable Partner',
                'description' => 'EU GMP certified partner for cephalosporin injectable manufacturing.',
                'sort_order' => 5,
            ],
            [
                'name' => 'Soft Gel Capsule Partner',
                'description' => 'WHO GMP certified facility for soft gelatine capsules and oral solutions.',
                'sort_order' => 6,
            ],
        ];

        foreach ($partners as $partner) {
            Partner::query()->updateOrCreate(
                ['name' => $partner['name']],
                $partner + ['is_active' => true]
            );
        }
    }
}
