<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JobSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@quickkaj.com')->first() ?? User::first();

        $jobs = [
            [
                'title_bn' => '৪৮তম বিসিএস: বিভিন্ন ক্যাডারে ৩,১৪০টি পদে নিয়োগ',
                'title_en' => '48th BCS: Recruitment for 3,140 Posts in Various Cadres',
                'employer_bn' => 'বাংলাদেশ সরকারি কর্ম কমিশন (বিপিএসসি)',
                'employer_en' => 'Bangladesh Public Service Commission (BPSC)',
                'location_bn' => 'সারা বাংলাদেশ',
                'location_en' => 'All over Bangladesh',
                'eligibility_bn' => "যেকোনো বিষয়ে স্নাতক বা সমমান\nবয়স: ২১-৩০ বছর\nমুক্তিযোদ্ধার সন্তানদের ক্ষেত্রে ৩২ বছর",
                'description_bn' => '<p>৪৮তম বিসিএস পরীক্ষায় বিভিন্ন ক্যাডারে নিয়োগ দেওয়া হবে। আগ্রহী প্রার্থীরা অনলাইনে আবেদন করুন।</p><p>পরীক্ষা তিনটি ধাপে হবে — প্রিলিমিনারি, লিখিত এবং ভাইভা।</p>',
                'deadline' => now()->addDays(45),
                'source_url' => 'https://bpsc.gov.bd',
                'application_url' => 'https://bpsc.teletalk.com.bd',
                'is_published' => true,
            ],
            [
                'title_bn' => 'প্রাথমিক বিদ্যালয় সহকারী শিক্ষক নিয়োগ ২০২৫',
                'title_en' => 'Primary School Assistant Teacher Recruitment 2025',
                'employer_bn' => 'প্রাথমিক শিক্ষা অধিদপ্তর',
                'employer_en' => 'Directorate of Primary Education',
                'location_bn' => 'সারা বাংলাদেশ (উপজেলাভিত্তিক)',
                'location_en' => 'All Districts',
                'eligibility_bn' => "যেকোনো বিষয়ে স্নাতক\nবয়স: ২১-৩০ বছর\nমহিলা প্রার্থীদের ৬০% কোটা",
                'description_bn' => '<p>৩০,০০০ পদে সহকারী শিক্ষক নিয়োগ। লিখিত পরীক্ষায় বাংলা, ইংরেজি, গণিত ও সাধারণ জ্ঞান থেকে প্রশ্ন হবে।</p>',
                'deadline' => now()->addDays(30),
                'source_url' => 'https://dpe.gov.bd',
                'application_url' => 'https://dpe.teletalk.com.bd',
                'is_published' => true,
            ],
            [
                'title_bn' => 'সোনালী ব্যাংক অফিসার নিয়োগ ২০২৫',
                'title_en' => 'Sonali Bank Officer Recruitment 2025',
                'employer_bn' => 'সোনালী ব্যাংক পিএলসি',
                'employer_en' => 'Sonali Bank PLC',
                'location_bn' => 'ঢাকাসহ সারা দেশ',
                'location_en' => 'Dhaka and All Districts',
                'eligibility_bn' => "যেকোনো বিষয়ে স্নাতকোত্তর\nCGPA ন্যূনতম ৩.০\nবয়স: ২১-৩০ বছর",
                'description_bn' => '<p>সোনালী ব্যাংকে অফিসার পদে ১,০০০ জন নিয়োগ। MCQ ও লিখিত পরীক্ষার পর ভাইভা।</p><p>বেতন স্কেল ৬ষ্ঠ গ্রেড।</p>',
                'deadline' => now()->addDays(25),
                'source_url' => 'https://sonalibank.com.bd',
                'application_url' => 'https://sonalibank.teletalk.com.bd',
                'is_published' => true,
            ],
            [
                'title_bn' => 'বাংলাদেশ পুলিশ কনস্টেবল নিয়োগ ২০২৫',
                'title_en' => 'Bangladesh Police Constable Recruitment 2025',
                'employer_bn' => 'বাংলাদেশ পুলিশ',
                'employer_en' => 'Bangladesh Police',
                'location_bn' => 'সকল জেলা',
                'location_en' => 'All Districts',
                'eligibility_bn' => "এসএসসি বা সমমান পাস\nউচ্চতা: পুরুষ ৫ ফুট ৬ ইঞ্চি, নারী ৫ ফুট ২ ইঞ্চি\nবয়স: ১৮-২০ বছর",
                'description_bn' => '<p>বাংলাদেশ পুলিশে কনস্টেবল পদে ব্যাপক নিয়োগ। শারীরিক পরীক্ষা ও লিখিত পরীক্ষার মাধ্যমে নিয়োগ।</p>',
                'deadline' => now()->addDays(20),
                'source_url' => 'https://police.gov.bd',
                'application_url' => 'https://police.teletalk.com.bd',
                'is_published' => true,
            ],
            [
                'title_bn' => 'বাংলাদেশ রেলওয়ে নিয়োগ: বিভিন্ন পদে বিজ্ঞপ্তি',
                'title_en' => 'Bangladesh Railway Recruitment: Various Posts',
                'employer_bn' => 'বাংলাদেশ রেলওয়ে',
                'employer_en' => 'Bangladesh Railway',
                'location_bn' => 'রেলওয়ে বিভাগসমূহ',
                'location_en' => 'Railway Divisions',
                'eligibility_bn' => "পদ অনুযায়ী SSC/HSC/Diploma\nবয়স: ১৮-৩০ বছর",
                'description_bn' => '<p>বাংলাদেশ রেলওয়েতে বিভিন্ন পদে নিয়োগ বিজ্ঞপ্তি। সহকারী স্টেশনমাস্টার, টেকনিশিয়ান সহ বিভিন্ন পদে।</p>',
                'deadline' => now()->addDays(35),
                'source_url' => 'https://railway.gov.bd',
                'application_url' => 'https://railway.teletalk.com.bd',
                'is_published' => true,
            ],
            [
                'title_bn' => 'ব্র্যাক এনজিও: প্রোগ্রাম অফিসার নিয়োগ',
                'title_en' => 'BRAC NGO: Program Officer Recruitment',
                'employer_bn' => 'ব্র্যাক',
                'employer_en' => 'BRAC',
                'location_bn' => 'ঢাকা ও জেলাসমূহ',
                'location_en' => 'Dhaka and Districts',
                'eligibility_bn' => "সমাজকল্যাণ/উন্নয়ন বিষয়ে স্নাতক\nকমপক্ষে ২ বছরের কাজের অভিজ্ঞতা\nবয়স: সর্বোচ্চ ৩৫ বছর",
                'description_bn' => '<p>ব্র্যাকের বিভিন্ন প্রকল্পে প্রোগ্রাম অফিসার নিয়োগ। স্বাস্থ্য, শিক্ষা ও দারিদ্র্য বিমোচন কার্যক্রমে কাজ করতে হবে।</p>',
                'deadline' => now()->addDays(15),
                'source_url' => 'https://brac.net',
                'application_url' => 'https://careers.brac.net',
                'is_published' => true,
            ],
            [
                'title_bn' => 'গ্রামীণফোন: সফটওয়্যার ইঞ্জিনিয়ার পদে নিয়োগ',
                'title_en' => 'Grameenphone: Software Engineer Recruitment',
                'employer_bn' => 'গ্রামীণফোন লিমিটেড',
                'employer_en' => 'Grameenphone Ltd.',
                'location_bn' => 'ঢাকা',
                'location_en' => 'Dhaka',
                'eligibility_bn' => "CSE/EEE বিষয়ে স্নাতক\nJava/Python দক্ষতা\nবয়স: সর্বোচ্চ ৩২ বছর",
                'description_bn' => '<p>গ্রামীণফোনে সফটওয়্যার ইঞ্জিনিয়ার পদে নিয়োগ। আকর্ষণীয় বেতন ও সুবিধা প্যাকেজ।</p><p>Agile পরিবেশে কাজ করার অভিজ্ঞতা থাকলে অগ্রাধিকার।</p>',
                'deadline' => now()->addDays(18),
                'source_url' => 'https://grameenphone.com',
                'application_url' => 'https://careers.grameenphone.com',
                'is_published' => true,
            ],
            [
                'title_bn' => 'ইসলামী ব্যাংক বাংলাদেশ: অফিসার পদে নিয়োগ ২০২৫',
                'title_en' => 'Islami Bank Bangladesh: Officer Recruitment 2025',
                'employer_bn' => 'ইসলামী ব্যাংক বাংলাদেশ পিএলসি',
                'employer_en' => 'Islami Bank Bangladesh PLC',
                'location_bn' => 'সারা বাংলাদেশ',
                'location_en' => 'All over Bangladesh',
                'eligibility_bn' => "যেকোনো বিষয়ে স্নাতকোত্তর\nCGPA ন্যূনতম ২.৫\nবয়স: ৩০ বছরের মধ্যে",
                'description_bn' => '<p>ইসলামী ব্যাংকে অফিসার (জেনারেল ব্যাংকিং) পদে নিয়োগ। MCQ পরীক্ষার পর ভাইভা।</p>',
                'deadline' => now()->addDays(22),
                'source_url' => 'https://islamibankbd.com',
                'application_url' => 'https://islamibankbd.com/career',
                'is_published' => true,
            ],
            [
                'title_bn' => 'ঢাকা সিটি কর্পোরেশন (ডিএনসিসি): সহকারী প্রশাসনিক কর্মকর্তা',
                'title_en' => 'DNCC: Assistant Administrative Officer',
                'employer_bn' => 'ঢাকা উত্তর সিটি কর্পোরেশন',
                'employer_en' => 'Dhaka North City Corporation',
                'location_bn' => 'ঢাকা',
                'location_en' => 'Dhaka',
                'eligibility_bn' => "যেকোনো বিষয়ে স্নাতক\nকম্পিউটার দক্ষতা আবশ্যক",
                'description_bn' => '<p>ডিএনসিসিতে প্রশাসনিক কাজে সহকারী কর্মকর্তা নিয়োগ। সরকারি চাকরির সুবিধাদি প্রযোজ্য।</p>',
                'deadline' => now()->addDays(28),
                'source_url' => 'https://dncc.gov.bd',
                'application_url' => 'https://dncc.teletalk.com.bd',
                'is_published' => true,
            ],
            [
                'title_bn' => 'বাংলাদেশ ব্যাংক: সহকারী পরিচালক নিয়োগ ২০২৫',
                'title_en' => 'Bangladesh Bank: Assistant Director Recruitment 2025',
                'employer_bn' => 'বাংলাদেশ ব্যাংক',
                'employer_en' => 'Bangladesh Bank',
                'location_bn' => 'ঢাকা ও শাখাসমূহ',
                'location_en' => 'Dhaka and Branches',
                'eligibility_bn' => "অর্থনীতি/ব্যবসায়/পরিসংখ্যান/গণিত/CSE বিষয়ে স্নাতকোত্তর\nCGPA ন্যূনতম ৩.০\nবয়স: ৩২ বছরের মধ্যে",
                'description_bn' => '<p>বাংলাদেশ ব্যাংকে সহকারী পরিচালক (AD) পদে নিয়োগ। লিখিত পরীক্ষা ও ভাইভার মাধ্যমে নির্বাচন।</p><p>বেতন ২২,০০০ টাকা থেকে শুরু এবং আকর্ষণীয় সুবিধাদি।</p>',
                'deadline' => now()->addDays(40),
                'source_url' => 'https://erecruitment.bb.org.bd',
                'application_url' => 'https://erecruitment.bb.org.bd',
                'is_published' => true,
            ],
            [
                'title_bn' => 'ইউএনডিপি বাংলাদেশ: প্রজেক্ট অ্যাসোসিয়েট পদে নিয়োগ',
                'title_en' => 'UNDP Bangladesh: Project Associate Recruitment',
                'employer_bn' => 'ইউএনডিপি বাংলাদেশ',
                'employer_en' => 'UNDP Bangladesh',
                'location_bn' => 'ঢাকা',
                'location_en' => 'Dhaka',
                'eligibility_bn' => "সামাজিক বিজ্ঞান/উন্নয়ন অধ্যয়নে স্নাতকোত্তর\nইংরেজি দক্ষতা আবশ্যক\nকমপক্ষে ৩ বছরের অভিজ্ঞতা",
                'description_bn' => '<p>জাতিসংঘ উন্নয়ন কর্মসূচিতে প্রজেক্ট অ্যাসোসিয়েট নিয়োগ। আন্তর্জাতিক মানের কাজের পরিবেশ।</p>',
                'deadline' => now()->addDays(12),
                'source_url' => 'https://undp.org',
                'application_url' => 'https://jobs.undp.org',
                'is_published' => true,
            ],
            [
                'title_bn' => 'বাংলাদেশ সেনাবাহিনী: অফিসার ক্যাডেট ভর্তি ২০২৫',
                'title_en' => 'Bangladesh Army: Officer Cadet Admission 2025',
                'employer_bn' => 'বাংলাদেশ সেনাবাহিনী',
                'employer_en' => 'Bangladesh Army',
                'location_bn' => 'সারা বাংলাদেশ',
                'location_en' => 'All over Bangladesh',
                'eligibility_bn' => "HSC বিজ্ঞান বিভাগ GPA ৪.৫\nঅবিবাহিত পুরুষ\nবয়স: ১৬.৫ থেকে ২১ বছর\nউচ্চতা: ৫ ফুট ৪ ইঞ্চি",
                'description_bn' => '<p>বাংলাদেশ মিলিটারি একাডেমিতে (বিএমএ) অফিসার ক্যাডেট ভর্তি। ৪ বছরের প্রশিক্ষণ শেষে কমিশনড অফিসার হবেন।</p>',
                'deadline' => now()->addDays(50),
                'source_url' => 'https://joinbangladesharmy.mil.bd',
                'application_url' => 'https://joinbangladesharmy.mil.bd',
                'is_published' => true,
            ],
            [
                'title_bn' => 'পল্লী বিদ্যুৎ সমিতি: সহকারী প্রকৌশলী নিয়োগ',
                'title_en' => 'Rural Electrification Board: Assistant Engineer Recruitment',
                'employer_bn' => 'বাংলাদেশ পল্লী বিদ্যুতায়ন বোর্ড',
                'employer_en' => 'Bangladesh Rural Electrification Board',
                'location_bn' => 'সকল উপজেলা',
                'location_en' => 'All Upazilas',
                'eligibility_bn' => "ইলেকট্রিক্যাল/ইলেকট্রনিক্স বিষয়ে BSc Engineering\nবয়স: ৩০ বছরের মধ্যে",
                'description_bn' => '<p>পল্লী বিদ্যুতায়ন বোর্ডে সহকারী প্রকৌশলী পদে নিয়োগ। বিভিন্ন উপজেলায় পদায়ন হবে।</p>',
                'deadline' => now()->addDays(33),
                'source_url' => 'https://reb.gov.bd',
                'application_url' => 'https://reb.teletalk.com.bd',
                'is_published' => true,
            ],
            [
                'title_bn' => 'স্কয়ার ফার্মাসিউটিক্যালস: মেডিকেল রিপ্রেজেন্টেটিভ নিয়োগ',
                'title_en' => 'Square Pharmaceuticals: Medical Representative Recruitment',
                'employer_bn' => 'স্কয়ার ফার্মাসিউটিক্যালস লিমিটেড',
                'employer_en' => 'Square Pharmaceuticals Ltd.',
                'location_bn' => 'ঢাকা, চট্টগ্রাম, রাজশাহী, খুলনা',
                'location_en' => 'Dhaka, Chittagong, Rajshahi, Khulna',
                'eligibility_bn' => "ফার্মেসি/বিজ্ঞান বিষয়ে স্নাতক\nযোগাযোগ দক্ষতা থাকতে হবে\nমোটরসাইকেল চালানো জানলে অগ্রাধিকার",
                'description_bn' => '<p>স্কয়ার ফার্মাসিউটিক্যালসে মেডিকেল রিপ্রেজেন্টেটিভ নিয়োগ। আকর্ষণীয় কমিশন ও সুবিধাদি।</p>',
                'deadline' => now()->addDays(16),
                'source_url' => 'https://squarepharma.com.bd',
                'application_url' => 'https://careers.squarepharma.com.bd',
                'is_published' => true,
            ],
            [
                'title_bn' => 'ওয়ালটন হাই-টেক ইন্ডাস্ট্রিজ: ইঞ্জিনিয়ার ও অফিসার নিয়োগ',
                'title_en' => 'Walton Hi-Tech Industries: Engineer and Officer Recruitment',
                'employer_bn' => 'ওয়ালটন হাই-টেক ইন্ডাস্ট্রিজ পিএলসি',
                'employer_en' => 'Walton Hi-Tech Industries PLC',
                'location_bn' => 'গাজীপুর (হেড অফিস ও ফ্যাক্টরি)',
                'location_en' => 'Gazipur',
                'eligibility_bn' => "ইলেকট্রিক্যাল/মেকানিক্যাল/CSE বিষয়ে BSc\nফ্রেশার ও অভিজ্ঞ উভয়ই আবেদন করতে পারবেন",
                'description_bn' => '<p>ওয়ালটনে ইঞ্জিনিয়ার (R&D, Production) ও অফিসার পদে নিয়োগ। আবাসন সুবিধা প্রযোজ্য।</p>',
                'deadline' => now()->addDays(10),
                'source_url' => 'https://waltonbd.com',
                'application_url' => 'https://careers.waltonbd.com',
                'is_published' => true,
            ],
        ];

        $count = 0;
        foreach ($jobs as $data) {
            $slug = Str::slug($data['title_en']);
            if (empty($slug)) {
                $slug = 'job-'.Str::random(8);
            }
            $existing = Job::where('slug', $slug)->count();
            if ($existing > 0) {
                $slug .= '-'.($existing + 1);
            }

            Job::firstOrCreate(
                ['slug' => $slug],
                array_merge($data, [
                    'slug' => $slug,
                    'created_by' => $admin?->id,
                    'published_at' => now()->subDays(rand(1, 15)),
                    'views' => rand(100, 5000),
                ])
            );
            $count++;
        }

        $this->command->info("✅ {$count} jobs seeded.");
    }
}
