<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('products')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE `products` MODIFY `product_name` TEXT NOT NULL');
            DB::statement('ALTER TABLE `products` MODIFY `composition` TEXT NULL');
            DB::statement('ALTER TABLE `products` MODIFY `description` TEXT NULL');
            DB::statement('ALTER TABLE `products` MODIFY `slug` VARCHAR(512) NOT NULL');
        } else {
            Schema::table('products', function (Blueprint $table) {
                $table->text('product_name')->change();
                $table->string('slug', 512)->change();
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('products')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE `products` MODIFY `product_name` VARCHAR(255) NOT NULL');
            DB::statement('ALTER TABLE `products` MODIFY `slug` VARCHAR(255) NOT NULL');
        }
    }
};
