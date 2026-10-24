<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name_bn' => 'জাতীয়', 'name_en' => 'National', 'icon' => '🏛', 'order' => 1],
            ['name_bn' => 'আন্তর্জাতিক', 'name_en' => 'International', 'icon' => '🌏', 'order' => 2],
            ['name_bn' => 'প্রযুক্তি', 'name_en' => 'Technology', 'icon' => '💻', 'order' => 3],
            ['name_bn' => 'শিক্ষা', 'name_en' => 'Education', 'icon' => '📚', 'order' => 4],
            ['name_bn' => 'অর্থনীতি', 'name_en' => 'Economy', 'icon' => '💰', 'order' => 5],
            ['name_bn' => 'খেলাধুলা', 'name_en' => 'Sports', 'icon' => '⚽', 'order' => 6],
            ['name_bn' => 'বিনোদন', 'name_en' => 'Entertainment', 'icon' => '🎬', 'order' => 7],
            ['name_bn' => 'স্বাস্থ্য', 'name_en' => 'Health', 'icon' => '🏥', 'order' => 8],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['slug' => Str::slug($cat['name_en'])],
                $cat
            );
        }

        $this->command->info('✅ '.count($categories).' categories seeded.');
    }
}
