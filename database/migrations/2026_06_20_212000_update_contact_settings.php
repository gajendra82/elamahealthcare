<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('settings')) {
            return;
        }

        $now = now();
        $updates = [
            'contact_email' => config('contact.email'),
            'contact_address' => config('contact.address'),
        ];

        foreach ($updates as $key => $value) {
            $existing = DB::table('settings')->where('key', $key)->first();

            if ($existing) {
                DB::table('settings')->where('key', $key)->update([
                    'value' => $value,
                    'updated_at' => $now,
                ]);
            } else {
                DB::table('settings')->insert([
                    'key' => $key,
                    'value' => $value,
                    'group' => 'contact',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        Cache::forget('settings.flat');
        Cache::forget('settings.all');
    }

    public function down(): void
    {
        if (! Schema::hasTable('settings')) {
            return;
        }

        $now = now();
        $rollback = [
            'contact_email' => 'md.elamahealthcare@gmail.com',
            'contact_address' => 'NL-5, Building no 14/4, Triveni APT, Behind St Augustine High School, Sector 11, Nerul East, Navi Mumbai',
        ];

        foreach ($rollback as $key => $value) {
            DB::table('settings')->where('key', $key)->update([
                'value' => $value,
                'updated_at' => $now,
            ]);
        }

        Cache::forget('settings.flat');
        Cache::forget('settings.all');
    }
};
