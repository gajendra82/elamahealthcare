<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Services\SettingService;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'company_name', 'value' => 'Elama Healthcare Solutions Pvt. Ltd.', 'group' => 'company'],
            ['key' => 'company_tagline', 'value' => 'Global Healthcare Solutions Built on Trust, Quality & Innovation', 'group' => 'company'],
            ['key' => 'company_founded', 'value' => '1986', 'group' => 'company'],
            ['key' => 'company_logo', 'value' => 'images/logo/logo.png', 'group' => 'company'],
            ['key' => 'company_mission', 'value' => 'Serve Global Healthcare needs through Empathy, Innovation and Technology.', 'group' => 'company'],
            ['key' => 'company_vision', 'value' => 'Lead the way to bring Wellness and Healthcare to the world.', 'group' => 'company'],

            ['key' => 'stat_years', 'value' => '40', 'group' => 'stats'],
            ['key' => 'stat_countries', 'value' => '15', 'group' => 'stats'],
            ['key' => 'stat_products', 'value' => '338', 'group' => 'stats'],
            ['key' => 'stat_partners', 'value' => '50', 'group' => 'stats'],
            ['key' => 'stat_manufacturing_partners', 'value' => '12', 'group' => 'stats'],

            ['key' => 'contact_address', 'value' => config('contact.address'), 'group' => 'contact'],
            ['key' => 'contact_phone', 'value' => config('contact.phone'), 'group' => 'contact'],
            ['key' => 'contact_email', 'value' => config('contact.email'), 'group' => 'contact'],

            ['key' => 'social_linkedin', 'value' => 'https://www.linkedin.com/company/elama-healthcare', 'group' => 'social'],
            ['key' => 'social_facebook', 'value' => 'https://www.facebook.com/elamahealthcare', 'group' => 'social'],
            ['key' => 'social_twitter', 'value' => 'https://twitter.com/elamahealthcare', 'group' => 'social'],

            ['key' => 'seo_default_title', 'value' => 'Elama Healthcare Solutions Pvt. Ltd.', 'group' => 'seo'],
            ['key' => 'seo_default_description', 'value' => 'Global Healthcare Solutions Built on Trust, Quality & Innovation. Delivering affordable quality pharmaceutical products across the globe.', 'group' => 'seo'],
            ['key' => 'seo_default_image', 'value' => 'images/logo/logo.png', 'group' => 'seo'],
        ];

        foreach ($settings as $setting) {
            Setting::query()->updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'group' => $setting['group']]
            );
        }

        app(SettingService::class)->clearCache();
    }
}
