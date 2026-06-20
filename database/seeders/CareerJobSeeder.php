<?php

namespace Database\Seeders;

use App\Models\CareerJob;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CareerJobSeeder extends Seeder
{
    public function run(): void
    {
        $jobs = [];

        $slugs = [];

        foreach ($jobs as $job) {
            $slug = Str::slug($job['title']);
            $slugs[] = $slug;

            CareerJob::query()->updateOrCreate(
                ['slug' => $slug],
                $job + ['is_active' => true]
            );
        }

        CareerJob::query()
            ->when($slugs !== [], fn ($query) => $query->whereNotIn('slug', $slugs))
            ->update(['is_active' => false]);
    }
}
