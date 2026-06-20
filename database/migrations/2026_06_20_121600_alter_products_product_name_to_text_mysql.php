<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::getConnection()->getDriverName() !== 'mysql') {
            return;
        }

        DB::statement('ALTER TABLE `products` MODIFY `product_name` TEXT NOT NULL');
        DB::statement('ALTER TABLE `products` MODIFY `composition` TEXT NULL');
        DB::statement('ALTER TABLE `products` MODIFY `description` TEXT NULL');
    }

    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() !== 'mysql') {
            return;
        }

        DB::statement('ALTER TABLE `products` MODIFY `product_name` VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE `products` MODIFY `composition` TEXT NULL');
        DB::statement('ALTER TABLE `products` MODIFY `description` TEXT NULL');
    }
};
