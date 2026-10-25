<?php

namespace Database\Seeders;

use App\Models\AdPlacement;
use Illuminate\Database\Seeder;

class AdPlacementSeeder extends Seeder
{
    public function run(): void
    {
        $slots = [
            [
                'slot_key' => 'header-banner',
                'label' => 'Header Banner (Above Navbar)',
                'html_code' => '<!-- Adsterra Header Banner 728x90: paste your code here -->',
                'is_active' => false,
            ],
            [
                'slot_key' => 'social-bar',
                'label' => 'Social Bar / In-Page Push (Global)',
                'html_code' => '<!-- Adsterra Social Bar Script: paste your code here -->',
                'is_active' => false,
            ],
            [
                'slot_key' => 'sidebar-top',
                'label' => 'Sidebar Top (300x250)',
                'html_code' => '<!-- Adsterra Sidebar 300x250: paste your code here -->',
                'is_active' => false,
            ],
            [
                'slot_key' => 'article-inline',
                'label' => 'Article / Job Inline Ad (Native / Banner)',
                'html_code' => '<!-- Adsterra Inline Native Ad: paste your code here -->',
                'is_active' => false,
            ],
            [
                'slot_key' => 'tool-bottom',
                'label' => 'Tools In-Page Banner / Native (High CTR — 728x90 / 300x250 / Native)',
                'html_code' => '<!-- Adsterra Tools In-Page Banner / Native Widget: paste code here -->',
                'is_active' => false,
            ],
            [
                'slot_key' => 'popunder',
                'label' => 'Popunder / OnClick Script (Highest eCPM / Global)',
                'html_code' => '<!-- Adsterra Popunder Script: paste your code here -->',
                'is_active' => false,
            ],
            [
                'slot_key' => 'smartlink',
                'label' => 'Adsterra Smartlink / Direct Link (High CTR Action Buttons)',
                'html_code' => 'https://asiafilm.org/4/33e4688bf6afae608fef6c06eb86d1c9',
                'is_active' => true,
            ],
            [
                'slot_key' => 'footer-banner',
                'label' => 'Footer Banner (728x90)',
                'html_code' => '<!-- Adsterra Footer Banner: paste your code here -->',
                'is_active' => false,
            ],
        ];

        foreach ($slots as $slot) {
            AdPlacement::firstOrCreate(
                ['slot_key' => $slot['slot_key']],
                $slot
            );
        }

        $this->command->info('✅ '.count($slots).' ad placement slots seeded (inactive by default).');
    }
}
