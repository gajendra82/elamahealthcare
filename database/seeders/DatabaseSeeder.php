<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@elamahealthcare.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $this->call([
            SettingSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            LeadershipSeeder::class,
            BannerSeeder::class,
            TestimonialSeeder::class,
            PartnerSeeder::class,
            NewsSeeder::class,
            CsrGallerySeeder::class,
            CareerJobSeeder::class,
        ]);
    }
}
