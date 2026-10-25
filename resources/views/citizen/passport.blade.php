@extends('layouts.app')

@php
    $locale = app()->getLocale();
    $isBn   = $locale === 'bn';
@endphp

@section('page_title', ($isBn ? 'ই-পাসপোর্ট আবেদন ও ফি গাইড ২০২৬ — ' . config('app.name', 'Quickkaj') : 'e-Passport Fee & Application Guide — ' . config('app.name', 'Quickkaj')))
@section('seo_description', $isBn
    ? 'ই-পাসপোর্টের সম্পূর্ণ ফি তালিকা (৪৮ ও ৬৪ পৃষ্ঠা, ৫ ও ১০ বছর), প্রয়োজনীয় কাগজপত্র এবং ঘরে বসে আবেদনের পূর্ণাঙ্গ নির্দেশিকা।'
    : 'Complete e-Passport fee chart in Bangladesh, required documents list, and step-by-step online application instructions.')

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "HowTo",
    "name": "{{ $isBn ? 'ই-পাসপোর্ট আবেদনের সঠিক নিয়ম ও ফি' : 'e-Passport Application and Fee Guide' }}",
    "description": "{{ $isBn ? 'বাংলাদেশ ই-পাসপোর্ট আবেদনের ধাপ ও সরকারি ফি তালিকা।' : 'Step-by-step e-Passport application steps and fees in Bangladesh.' }}",
    "url": "{{ url()->current() }}"
}
</script>
@endsection

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs text-gray-500 mb-6">
        <a href="{{ route('home', ['locale' => $locale]) }}" class="hover:text-blue-600 transition-colors">
            <i class="fa-solid fa-house"></i>
            <span>{{ __('ui.home') }}</span>
        </a>
        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
        <a href="{{ route('citizen.index', ['locale' => $locale]) }}" class="hover:text-amber-600 transition-colors">
            <span>{{ $isBn ? 'নাগরিক সেবা' : 'Citizen Services' }}</span>
        </a>
        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
        <span class="text-gray-900 font-semibold">{{ $isBn ? 'ই-পাসপোর্ট গাইড' : 'e-Passport Guide' }}</span>
    </nav>

    {{-- Header --}}
    <div class="mb-10">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200 mb-3">
            <i class="fa-solid fa-passport"></i>
            <span>{{ $isBn ? 'পাসপোর্ট সেবা গাইড' : 'Passport Service Guide' }}</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-gray-900 tracking-tight mb-3">
            {{ $isBn ? 'ই-পাসপোর্ট আবেদন, ফি ও প্রয়োজনীয় কাগজপত্রের তালিকা' : 'e-Passport Application, Fee Chart & Checklist' }}
        </h1>
        <p class="text-sm text-gray-600 leading-relaxed">
            {{ $isBn
                ? 'অনলাইনে ই-পাসপোর্ট আবেদন করতে কোনো দালালের প্রয়োজন নেই। নিচের সঠিক ফি ও প্রয়োজনীয় কাগজপত্র দেখে নিজেই সহজে আবেদন সম্পন্ন করুন।'
                : 'Apply online directly without agents. Check verified official fees, checklists, and application steps below.' }}
        </p>
    </div>

    {{-- Fee Table Card --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-md overflow-hidden mb-12">
        <div class="p-6 sm:p-8 bg-gradient-to-r from-amber-500 to-orange-500 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold mb-1">{{ $isBn ? 'সরকারি ই-পাসপোর্ট ফি তালিকা (১৫% ভ্যাটসহ)' : 'Official e-Passport Fee Chart (Incl. 15% VAT)' }}</h2>
                <p class="text-xs text-white/90">{{ $isBn ? 'নিয়মিত, জরুরি ও অতীব জরুরি ডেলিভারি ফি' : 'Regular, Express & Super Express Delivery Rates' }}</p>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <a href="{{ \App\Models\AdPlacement::getSmartlinkUrl() }}" target="_blank" rel="noopener noreferrer nofollow"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-orange-700/90 text-white font-bold text-xs hover:bg-orange-800 transition-colors shadow-xs">
                    <i class="fa-solid fa-file-arrow-down"></i>
                    <span>{{ $isBn ? 'ফরম ও গাইড ডাউনলোড' : 'Download Forms' }}</span>
                </a>
                <a href="https://www.epassport.gov.bd/" target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white text-gray-900 font-bold text-xs hover:bg-amber-50 transition-colors shadow-xs">
                    <span>{{ $isBn ? 'অফিসিয়াল পোর্টালে যান' : 'Go to Portal' }}</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs sm:text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-gray-600 font-bold">
                        <th class="p-4 sm:px-6">পাসপোর্টের ধরণ (পাতা ও মেয়াদ)</th>
                        <th class="p-4">সাধারণ (১৫ কর্মদিবস)</th>
                        <th class="p-4">জরুরি (৭ কর্মদিবস)</th>
                        <th class="p-4 sm:px-6">অতীব জরুরি (২ কর্মদিবস)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    <tr class="hover:bg-amber-50/40 transition-colors">
                        <td class="p-4 sm:px-6 font-semibold text-gray-900">৪৮ পৃষ্ঠা — ৫ বছর মেয়াদী</td>
                        <td class="p-4 font-mono font-bold text-amber-700">৳ ৪,০২৫</td>
                        <td class="p-4 font-mono font-bold text-amber-700">৳ ৬,৩২৫</td>
                        <td class="p-4 sm:px-6 font-mono font-bold text-amber-700">৳ ৮,৬২৫</td>
                    </tr>
                    <tr class="hover:bg-amber-50/40 transition-colors bg-gray-50/30">
                        <td class="p-4 sm:px-6 font-semibold text-gray-900">৪৮ পৃষ্ঠা — ১০ বছর মেয়াদী</td>
                        <td class="p-4 font-mono font-bold text-emerald-700">৳ ৫,৭৫০</td>
                        <td class="p-4 font-mono font-bold text-emerald-700">৳ ৮,০৫০</td>
                        <td class="p-4 sm:px-6 font-mono font-bold text-emerald-700">৳ ১০,৩৫০</td>
                    </tr>
                    <tr class="hover:bg-amber-50/40 transition-colors">
                        <td class="p-4 sm:px-6 font-semibold text-gray-900">৬৪ পৃষ্ঠা — ৫ বছর মেয়াদী</td>
                        <td class="p-4 font-mono font-bold text-amber-700">৳ ৬,৩২৫</td>
                        <td class="p-4 font-mono font-bold text-amber-700">৳ ৮,৬২৫</td>
                        <td class="p-4 sm:px-6 font-mono font-bold text-amber-700">৳ ১২,০৭৫</td>
                    </tr>
                    <tr class="hover:bg-amber-50/40 transition-colors bg-gray-50/30">
                        <td class="p-4 sm:px-6 font-semibold text-gray-900">৬৪ পৃষ্ঠা — ১০ বছর মেয়াদী</td>
                        <td class="p-4 font-mono font-bold text-emerald-700">৳ ৮,০৫০</td>
                        <td class="p-4 font-mono font-bold text-emerald-700">৳ ১০,৩৫০</td>
                        <td class="p-4 sm:px-6 font-mono font-bold text-emerald-700">৳ ১৩,৮০০</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="p-4 bg-gray-50/80 text-[11px] text-gray-500 border-t border-gray-100 flex items-center gap-2">
            <i class="fa-solid fa-circle-info text-amber-500"></i>
            <span>* ১৮ বছরের কম এবং ৬৫ বছরের বেশি বয়সের আবেদনকারীদের ক্ষেত্রে শুধুমাত্র ৫ বছর মেয়াদী ৪৮ পাতার পাসপোর্ট প্রদান করা হয়।</span>
        </div>
    </div>

    {{-- Checklist & Steps Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">

        {{-- Required Documents --}}
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2.5">
                <i class="fa-solid fa-clipboard-check text-emerald-600"></i>
                <span>{{ $isBn ? 'প্রয়োজনীয় কাগজপত্র তালিকা' : 'Required Documents' }}</span>
            </h3>
            <ul class="space-y-3 text-xs sm:text-sm text-gray-600">
                <li class="flex items-start gap-2.5">
                    <i class="fa-solid fa-circle-check text-emerald-500 mt-1 text-xs"></i>
                    <span><strong>জাতীয় পরিচয়পত্র (NID):</strong> মূল কপি ও ফটোকপি (১৮ বছর বা তদূর্ধ্বদের জন্য আবশ্যক)।</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <i class="fa-solid fa-circle-check text-emerald-500 mt-1 text-xs"></i>
                    <span><strong>অনলাইন জন্ম নিবন্ধন (BRC):</strong> ১৭ ডিজিটের ইংরেজি ও বাংলা অনলাইন জন্ম সনদ (১৮ বছরের কম বয়সীদের জন্য)।</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <i class="fa-solid fa-circle-check text-emerald-500 mt-1 text-xs"></i>
                    <span><strong>আবেদন সারসংক্ষেপ (Application Summary):</strong> অনলাইনে সাবমিট করার পর প্রাপ্ত বারকোডসহ প্রিন্ট কপি।</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <i class="fa-solid fa-circle-check text-emerald-500 mt-1 text-xs"></i>
                    <span><strong>পেমেন্ট স্লিপ (A-Challan):</strong> ব্যাংক বা অনলাইন পেমেন্টের মূল চালান কপি।</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <i class="fa-solid fa-circle-check text-emerald-500 mt-1 text-xs"></i>
                    <span><strong>পুরাতন পাসপোর্ট (যদি থাকে):</strong> রি-ইস্যুর ক্ষেত্রে পুরাতন পাসপোর্টের মূল কপি সাথে নিতে হবে।</span>
                </li>
            </ul>
        </div>

        {{-- Step-by-Step Process --}}
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2.5">
                <i class="fa-solid fa-stairs text-amber-600"></i>
                <span>{{ $isBn ? 'আবেদনের ৪টি সহজ ধাপ' : '4 Simple Application Steps' }}</span>
            </h3>
            <div class="space-y-4 text-xs sm:text-sm text-gray-600">
                <div class="flex items-start gap-3">
                    <span class="w-6 h-6 rounded-full bg-amber-100 text-amber-700 font-bold flex items-center justify-center text-xs flex-shrink-0">১</span>
                    <div>
                        <p class="font-bold text-gray-900">অনলাইন পোর্টাল রেজিস্ট্রেশন</p>
                        <p class="text-[11px] text-gray-500">epassport.gov.bd-এ নিজের মোবাইল নম্বর ও ইমেইল দিয়ে অ্যাকাউন্ট খুলুন।</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <span class="w-6 h-6 rounded-full bg-amber-100 text-amber-700 font-bold flex items-center justify-center text-xs flex-shrink-0">২</span>
                    <div>
                        <p class="font-bold text-gray-900">ফরম পূরণ ও ফি প্রদান</p>
                        <p class="text-[11px] text-gray-500">NID অনুযায়ী নিখুঁত তথ্য দিয়ে বিকাশ, নগদ বা ব্যাংকের A-Challan-এ ফি পরিশোধ করুন।</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <span class="w-6 h-6 rounded-full bg-amber-100 text-amber-700 font-bold flex items-center justify-center text-xs flex-shrink-0">৩</span>
                    <div>
                        <p class="font-bold text-gray-900">বায়োমেট্রিক ও ছবি প্রদান</p>
                        <p class="text-[11px] text-gray-500">নির্ধারিত তারিখে পাসপোর্ট অফিসে গিয়ে আঙুলের ছাপ, চোখের আইরিশ ও ছবি দিন।</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <span class="w-6 h-6 rounded-full bg-amber-100 text-amber-700 font-bold flex items-center justify-center text-xs flex-shrink-0">৪</span>
                    <div>
                        <p class="font-bold text-gray-900">অনলাইনে স্ট্যাটাস চেক ও ডেলিভারি</p>
                        <p class="text-[11px] text-gray-500">Application ID দিয়ে ওয়েবসাইটে স্ট্যাটাস রেডি দেখলে ডেলিভারি স্লিপ নিয়ে পাসপোর্ট সংগ্রহ করুন।</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Cross-link Tools --}}
    <div class="bg-amber-50/60 border border-amber-200/80 rounded-3xl p-6 sm:p-8 flex flex-col sm:flex-row items-center justify-between gap-6">
        <div>
            <h4 class="text-base font-bold text-gray-900 mb-1">
                {{ $isBn ? 'পাসপোর্ট ও ভিসার ছবি সাইজ করতে চান?' : 'Need to resize passport photo?' }}
            </h4>
            <p class="text-xs text-gray-600">
                {{ $isBn ? 'কুইককাজের ১০০% ফ্রি ইমেজ রিসাইজার দিয়ে ৩০০×৩০০ ও পাসপোর্ট সাইজের ছবি সেকেন্ডে তৈরি করুন।' : 'Use our 100% free Photo Resizer to crop and format photos for passport requirements.' }}
            </p>
        </div>
        <a href="{{ route('tools.image-resizer') }}" class="px-5 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs shadow-xs transition-colors flex-shrink-0">
            {{ $isBn ? 'ছবি রিসাইজ করুন' : 'Photo Resizer' }}
        </a>
    </div>

</div>
@endsection
