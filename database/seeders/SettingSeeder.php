<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name_bn', 'value' => 'কুইককাজ', 'group' => 'general'],
            ['key' => 'site_name_en', 'value' => 'Quickkaj', 'group' => 'general'],
            ['key' => 'site_tagline_bn', 'value' => 'আপনার তথ্যের বিশ্বস্ত সঙ্গী', 'group' => 'general'],
            ['key' => 'site_tagline_en', 'value' => 'Your Trusted Information Hub', 'group' => 'general'],
            ['key' => 'contact_email', 'value' => 'hello@quickkaj.com', 'group' => 'general'],
            ['key' => 'footer_text_bn', 'value' => 'কুইককাজ বাংলাদেশের একটি বিশ্বস্ত তথ্য পোর্টাল। চাকরি, সংবাদ ও দরকারী টুলস পাবেন এখানে।', 'group' => 'general'],
            ['key' => 'footer_text_en', 'value' => 'Quickkaj is a trusted information portal from Bangladesh covering jobs, news, and useful online tools.', 'group' => 'general'],
            ['key' => 'ga_tracking_id', 'value' => '', 'group' => 'analytics'],
            ['key' => 'facebook_url', 'value' => '', 'group' => 'social'],
            ['key' => 'twitter_url', 'value' => '', 'group' => 'social'],
            ['key' => 'youtube_url', 'value' => '', 'group' => 'social'],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('✅ Settings seeded.');
    }
}
