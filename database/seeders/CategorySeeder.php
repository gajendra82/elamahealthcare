<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $path = base_path('_source/products_raw.json');

        if (! file_exists($path)) {
            return;
        }

        $rows = ProductSeeder::loadRowsFromSource();
        $normalized = [];

        foreach ($rows as $row) {
            $dosageForm = trim((string) ($row[2] ?? ''));

            if ($dosageForm === '') {
                continue;
            }

            $name = $this->normalizeCategoryName($dosageForm);
            $normalized[$name] = ($normalized[$name] ?? 0) + 1;
        }

        arsort($normalized);

        $sortOrder = 1;
        foreach (array_keys($normalized) as $name) {
            Category::query()->updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => "Pharmaceutical products in {$name} dosage form.",
                    'sort_order' => $sortOrder++,
                    'is_active' => true,
                ]
            );
        }
    }

    public function normalizeCategoryName(string $dosageForm): string
    {
        $name = trim(preg_replace('/\s+/', ' ', $dosageForm));

        $patterns = [
            '/\btablet/i' => 'Tablet',
            '/\bcapsule/i' => 'Capsule',
            '/\bsyrup/i' => 'Syrup',
            '/\binjection|injectable|vial|ampoule|lyophil/i' => 'Injection',
            '/\bdrop|eye\/ear|ophthalmic|nasal/i' => 'Drops',
            '/\bgel|cream|ointment|lotion|topical/i' => 'Topical',
            '/\bsuspension|solution|liquid|sachet|powder for oral/i' => 'Liquid',
            '/\binhal|respir/i' => 'Inhalation',
            '/\bsuppositor/i' => 'Suppository',
            '/\bpatch/i' => 'Patch',
        ];

        foreach ($patterns as $pattern => $category) {
            if (preg_match($pattern, $name)) {
                return $category;
            }
        }

        return $name;
    }
}
