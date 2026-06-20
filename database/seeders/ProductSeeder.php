<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $path = base_path('_source/products_raw.json');

        if (! file_exists($path)) {
            return;
        }

        $payload = json_decode(file_get_contents($path), true);
        $rows = array_slice($payload['data'] ?? [], 1);
        $categorySeeder = new CategorySeeder();
        $categories = Category::query()->pluck('id', 'name');
        $usedSlugs = [];

        foreach ($rows as $row) {
            $productName = trim(preg_replace('/\s+/', ' ', (string) ($row[1] ?? '')));
            $dosageForm = trim((string) ($row[2] ?? ''));
            $rawStatus = trim((string) ($row[3] ?? ''));
            $format = trim((string) ($row[4] ?? ''));

            if ($productName === '') {
                continue;
            }

            $categoryName = $categorySeeder->normalizeCategoryName($dosageForm);
            $categoryId = $categories[$categoryName] ?? null;
            $slug = $this->uniqueSlug(Str::slug($productName), $usedSlugs);
            $usedSlugs[] = $slug;

            Product::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'category_id' => $categoryId,
                    'category' => $categoryName,
                    'product_name' => $productName,
                    'dosage' => $dosageForm,
                    'description' => $productName,
                    'status' => strcasecmp($rawStatus, 'Completed') === 0 ? 'active' : 'inactive',
                    'format' => $format,
                ]
            );
        }
    }

    private function uniqueSlug(string $baseSlug, array $usedSlugs): string
    {
        if ($baseSlug === '') {
            $baseSlug = 'product';
        }

        $slug = $baseSlug;
        $counter = 1;

        while (in_array($slug, $usedSlugs, true) || Product::query()->where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
