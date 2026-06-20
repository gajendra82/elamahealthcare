<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Support\SlugHelper;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProductSeeder extends Seeder
{
    private bool $truncateProductNames = false;

    public function run(): void
    {
        $this->prepareProductColumns();

        $path = base_path('_source/products_raw.json');

        if (! file_exists($path)) {
            $this->command?->warn('Product source file not found: _source/products_raw.json');

            return;
        }

        $payload = json_decode(file_get_contents($path), true);
        $rows = array_slice($payload['data'] ?? [], 1);
        $categorySeeder = new CategorySeeder();
        $categories = Category::query()->pluck('id', 'name');

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
            $slug = SlugHelper::unique(
                $productName,
                fn (string $candidate) => Product::query()->where('slug', $candidate)->exists()
            );

            Product::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'category_id' => $categoryId,
                    'category' => $categoryName,
                    'product_name' => $this->truncateProductNames
                        ? mb_substr($productName, 0, 255)
                        : $productName,
                    'composition' => $productName,
                    'dosage' => $dosageForm,
                    'description' => $productName,
                    'status' => strcasecmp($rawStatus, 'Completed') === 0 ? 'active' : 'inactive',
                    'format' => $format,
                ]
            );
        }
    }

    /**
     * Expand VARCHAR columns on MySQL before importing long pharmaceutical product names.
     */
    private function prepareProductColumns(): void
    {
        if (Schema::getConnection()->getDriverName() !== 'mysql') {
            return;
        }

        try {
            DB::statement('ALTER TABLE `products` MODIFY `product_name` TEXT NOT NULL');
            DB::statement('ALTER TABLE `products` MODIFY `composition` TEXT NULL');
            DB::statement('ALTER TABLE `products` MODIFY `description` TEXT NULL');

            $this->command?->info('Products table columns expanded to TEXT.');
        } catch (\Throwable $exception) {
            $this->truncateProductNames = true;
            $this->command?->warn(
                'Could not alter products table ('.$exception->getMessage().'). '.
                'Long product names will be truncated to 255 characters.'
            );
        }
    }
}
