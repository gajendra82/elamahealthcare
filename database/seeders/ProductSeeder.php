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
    public function run(): void
    {
        $this->prepareProductColumns();

        $rows = self::loadRowsFromSource();

        if ($rows === []) {
            $this->command?->warn('No product rows found in _source/Product list.xlsx or _source/products_raw.json');

            return;
        }

        if (Category::query()->count() === 0) {
            $this->call(CategorySeeder::class);
        }

        $categories = Category::query()->pluck('id', 'name');
        $categorySeeder = new CategorySeeder();
        $importedSlugs = [];

        foreach ($rows as $row) {
            $serial = is_numeric($row[0] ?? null) ? (int) $row[0] : null;
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
                    'product_name' => $productName,
                    'composition' => null,
                    'dosage' => $dosageForm,
                    'packaging' => null,
                    'description' => null,
                    'image' => null,
                    'sort_order' => $serial,
                    'status' => 'active',
                    'format' => $format !== '' ? $format : null,
                ]
            );

            $importedSlugs[] = $slug;
        }

        Product::query()->whereNotIn('slug', $importedSlugs)->delete();

        $this->command?->info('Imported '.count($importedSlugs).' products from Pharma Ready Dossiers list.');
    }

    public static function loadRowsFromSource(): array
    {
        $jsonPath = base_path('_source/products_raw.json');

        if (! file_exists($jsonPath)) {
            return [];
        }

        $payload = json_decode(file_get_contents($jsonPath), true);

        return array_values(array_filter(
            array_slice($payload['data'] ?? [], 1),
            fn (array $row) => trim((string) ($row[1] ?? '')) !== ''
        ));
    }

    private function prepareProductColumns(): void
    {
        if (Schema::getConnection()->getDriverName() !== 'mysql') {
            return;
        }

        try {
            DB::statement('ALTER TABLE `products` MODIFY `product_name` TEXT NOT NULL');
            DB::statement('ALTER TABLE `products` MODIFY `composition` TEXT NULL');
            DB::statement('ALTER TABLE `products` MODIFY `description` TEXT NULL');
        } catch (\Throwable $exception) {
            $this->command?->warn('Could not alter products table: '.$exception->getMessage());
        }
    }
}
