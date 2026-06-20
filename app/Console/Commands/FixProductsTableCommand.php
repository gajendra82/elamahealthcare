<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FixProductsTableCommand extends Command
{
    protected $signature = 'elama:fix-products-table';

    protected $description = 'Expand products.product_name to TEXT (required for long pharmaceutical names on MySQL)';

    public function handle(): int
    {
        if (Schema::getConnection()->getDriverName() !== 'mysql') {
            $this->info('Skipped: this command is for MySQL only.');

            return self::SUCCESS;
        }

        $this->info('Altering products table columns...');

        DB::statement('ALTER TABLE `products` MODIFY `product_name` TEXT NOT NULL');
        DB::statement('ALTER TABLE `products` MODIFY `composition` TEXT NULL');
        DB::statement('ALTER TABLE `products` MODIFY `description` TEXT NULL');

        $this->info('Done. product_name, composition, and description are now TEXT.');
        $this->line('Run: php artisan db:seed --class=ProductSeeder --force');

        return self::SUCCESS;
    }
}
