<?php

namespace Database\Seeders;

use App\Models\Leadership;
use Illuminate\Database\Seeder;

class LeadershipSeeder extends Seeder
{
    public function run(): void
    {
        $leaders = [
            [
                'name' => 'Dr Rahul Kulkarni',
                'designation' => 'Director',
                'qualification' => 'MBBS, MS ENT – Mumbai',
                'experience' => 'More than 25 years experience in the Medical Field.',
                'achievements' => "Hon. Consultant at Sir JJ Group of Hospitals.\nHead of ENT Department at St George Hospital.\nFormer President, ENT Association of India, Mumbai Branch.\nHeading Kalwa ENT Centre, Kalwa, Thane.\nChief ENT Consultant, Currae Hospital, Thane.",
                'photo' => 'images/leadership/dr-rahul-kulkarni.jpg',
                'sort_order' => 1,
            ],
            [
                'name' => 'Dr Ashwini Kulkarni',
                'designation' => 'Director',
                'qualification' => 'MBBS, DMRD',
                'experience' => '20 years of experience in clinical practice.',
                'achievements' => "Director at Kalwa Diagnostic Centre, Thane.\nChief Sonologist, Currae Hospital and IVF Birthing Center, Thane.\nOrganizing member, Asia (AOCR) Radiology Conference.",
                'photo' => 'images/leadership/dr-ashwini-kulkarni.jpg',
                'sort_order' => 2,
            ],
        ];

        foreach ($leaders as $leader) {
            Leadership::query()->updateOrCreate(
                ['name' => $leader['name']],
                $leader + ['is_active' => true]
            );
        }
    }
}
