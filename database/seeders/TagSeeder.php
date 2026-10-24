<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            ['name_bn' => 'সরকার', 'name_en' => 'Government'],
            ['name_bn' => 'বিশ্ববিদ্যালয়', 'name_en' => 'University'],
            ['name_bn' => 'প্রযুক্তি', 'name_en' => 'Technology'],
            ['name_bn' => 'অর্থনীতি', 'name_en' => 'Economy'],
            ['name_bn' => 'স্বাস্থ্য', 'name_en' => 'Health'],
            ['name_bn' => 'শিক্ষা', 'name_en' => 'Education'],
            ['name_bn' => 'পরিবেশ', 'name_en' => 'Environment'],
            ['name_bn' => 'কৃষি', 'name_en' => 'Agriculture'],
        ];

        foreach ($tags as $tag) {
            $slug = Str::slug($tag['name_en']);
            Tag::firstOrCreate(
                ['slug' => $slug],
                array_merge($tag, ['slug' => $slug])
            );
        }

        $this->command->info('✅ Tags seeded.');
    }
}
