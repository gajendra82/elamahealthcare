<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('banners')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE `banners` MODIFY `subtitle` TEXT NULL');
        } elseif ($driver === 'sqlite') {
            // SQLite cannot alter column types easily; recreate is unnecessary for local dev seeds.
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('banners')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE `banners` MODIFY `subtitle` VARCHAR(255) NULL');
        }
    }
};
