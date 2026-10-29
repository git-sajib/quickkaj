@extends('layouts.app')

@php
    $isBn = app()->getLocale() === 'bn';
@endphp

@section('page_title', ($isBn ? 'সরকারি চাকরির বয়স ক্যালকুলেটর ও যোগ্যতা যাচাই — বয়সসীমা ৩২ বছর' : 'Govt Job Age Calculator & Eligibility Checker — 32 Years Limit') . ' — ' . __('ui.site_name'))
@section('seo_description', $isBn
    ? 'সরকারি চাকরির আবেদনের জন্য সঠিক বয়স হিসাব ও যোগ্যতা যাচাইয়ের অনলাইন টুল। সাধারণ প্রার্থী (৩২ বছর) ও কোটা অনুযায়ী সার্কুলারের নির্দিষ্ট তারিখে কত বছর, মাস ও দিন হয়েছে নিখুঁতভাবে বের করুন।'
    : 'Calculate your exact age and verify eligibility for Bangladesh government job applications with the latest 32-year age limit. Instant countdown of remaining career time.')

@section('structured_data')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebApplication",
    "name": "{{ $isBn ? 'সরকারি চাকরির বয়স ক্যালকুলেটর' : 'Govt Job Age Calculator BD' }}",
    "description": "{{ $isBn ? 'চাকরির নির্দিষ্ট তারিখে বয়স ও আবেদন যোগ্যতা যাচাইয়ের টুল।' : 'Calculate exact age and check BD govt job application eligibility.' }}",
    "url": "{{ url()->current() }}",
    "applicationCategory": "UtilitiesApplication",
    "operatingSystem": "All",
    "inLanguage": "{{ $isBn ? 'bn-BD' : 'en-US' }}",
    "offers": {
        "@type": "Offer",
        "price": "0",
        "priceCurrency": "USD"
    }
}
</script>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        {
            "@type": "Question",
            "name": "{{ $isBn ? 'সরকারি চাকরিতে প্রবেশের বর্তমান সর্বোচ্চ বয়সসীমা কত?' : 'What is the current maximum age limit for BD government jobs?' }}",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "{{ $isBn ? 'বাংলাদেশ সরকারের সর্বশেষ সিদ্ধান্ত অনুযায়ী সাধারণ প্রার্থীদের ক্ষেত্রে বয়সসীমা ৩২ বছর এবং মুক্তিযোদ্ধা ও বিশেষ কোটায় ৩৪ বছর।' : 'According to current Bangladesh government policy, the maximum entry age is 32 years for general candidates and 34 years for quota beneficiaries.' }}"
            }
        },
        {
            "@type": "Question",
            "name": "{{ $isBn ? 'সার্কুলারের নির্দিষ্ট তারিখে বয়স কীভাবে হিসাব করবেন?' : 'How to calculate age on the specific circular date?' }}",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "{{ $isBn ? 'আমাদের ক্যালকুলেটরে জন্মতারিখ দিন এবং সার্কুলারে উল্লিখিত তারিখটি দিন, স্বয়ংক্রিয়ভাবে আপনার যোগ্যতা যাচাই হয়ে যাবে।' : 'Select your date of birth and enter the circular reference date to check exact age and eligibility instantly.' }}"
            }
        }
    ]
}
</script>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
    @include('partials.tool-back')

    {{-- Top Header --}}
    <div class="mb-7 flex items-center justify-between flex-wrap gap-4 bg-white p-5 rounded-2xl border border-gray-100 shadow-xs">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-600 text-white rounded-2xl flex items-center justify-center shadow-md shadow-blue-500/20 text-xl shrink-0">
                <i class="fa-solid fa-calculator"></i>
            </div>
            <div>
                <div class="flex items-center gap-2 flex-wrap">
                    <h1 class="text-xl sm:text-2xl font-extrabold text-gray-900">
                        {{ $isBn ? 'সরকারি চাকরি বয়স ও যোগ্যতা ক্যালকুলেটর' : 'Govt Job Age & Eligibility Calculator' }}
                    </h1>
                    <span class="text-[11px] font-bold bg-emerald-100 text-emerald-800 px-2.5 py-0.5 rounded-full">
                        {{ $isBn ? 'সর্বশেষ ৩২ বছর নিয়ম' : 'Updated 32-Yr Limit' }}
                    </span>
                </div>
                <p class="text-gray-500 text-xs sm:text-sm mt-0.5">
                    {{ $isBn ? 'বিজ্ঞপ্তির নির্দিষ্ট তারিখে আপনার বয়স কত এবং সরকারি চাকরিতে আবেদনের যোগ্যতা আছে কিনা তা ১ ক্লিকেই জানুন।' : 'Calculate exact age on circular dates and verify application eligibility instantly.' }}
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-7 items-start">

        {{-- Left Form Column --}}
        <div class="lg:col-span-5 space-y-5">
            <div class="card p-6 space-y-4 bg-white border border-gray-100 shadow-sm rounded-2xl">

                {{-- Mode Switcher Tabs --}}
                <div class="flex items-center bg-gray-100 p-1 rounded-xl text-xs font-bold text-gray-600">
                    <button type="button" onclick="setMode('govt')" id="tab-govt" class="flex-1 py-2 rounded-lg bg-white text-blue-600 shadow-xs transition-all flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-briefcase"></i>
                        <span>{{ $isBn ? 'সরকারি চাকরি' : 'Govt Job' }}</span>
                    </button>
                    <button type="button" onclick="setMode('general')" id="tab-general" class="flex-1 py-2 rounded-lg text-gray-500 hover:text-gray-900 transition-all flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-cake-candles"></i>
                        <span>{{ $isBn ? 'সাধারণ বয়স' : 'General Age' }}</span>
                    </button>
                </div>

                {{-- 1. Date of Birth --}}
                <div>
                    <label class="block text-xs font-bold text-gray-800 mb-1.5 flex items-center gap-1.5">
                        <i class="fa-regular fa-calendar-check text-blue-600"></i>
                        <span>{{ $isBn ? 'আপনার জন্মতারিখ (Date of Birth)' : 'Your Date of Birth' }}</span>
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="dob" onchange="autoCalc()" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50 focus:bg-white transition-all cursor-pointer">
                </div>

                {{-- 2. Circular / Reference Date --}}
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="text-xs font-bold text-gray-800 flex items-center gap-1.5">
                            <i class="fa-regular fa-calendar-days text-indigo-600"></i>
                            <span id="ref-label">{{ $isBn ? 'বিজ্ঞপ্তির নির্দিষ্ট তারিখ (As on Date)' : 'Circular Reference Date' }}</span>
                        </label>
                        <button type="button" onclick="setTodayRef()" class="text-[11px] text-blue-600 hover:underline font-semibold">
                            {{ $isBn ? 'আজকের তারিখ' : 'Today' }}
                        </button>
                    </div>
                    <input type="date" id="ref" onchange="autoCalc()" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50 focus:bg-white transition-all cursor-pointer">
                </div>

                {{-- Quick Reference Date Presets for Job Seekers --}}
                <div id="quick-ref-presets" class="space-y-1.5">
                    <p class="text-[11px] font-semibold text-gray-500">{{ $isBn ? 'জনপ্রিয় রেফারেন্স তারিখ:' : 'Quick Presets:' }}</p>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <button type="button" onclick="setPresetDate('current-first')" class="p-2 bg-gray-50 hover:bg-blue-50 text-gray-700 hover:text-blue-700 border border-gray-200 rounded-lg text-left text-[11px] font-medium transition-colors">
                            {{ $isBn ? 'চলতি মাসের ১ তারিখ' : '1st of this month' }}
                        </button>
                        <button type="button" onclick="setPresetDate('year-first')" class="p-2 bg-gray-50 hover:bg-blue-50 text-gray-700 hover:text-blue-700 border border-gray-200 rounded-lg text-left text-[11px] font-medium transition-colors">
                            {{ $isBn ? '১লা জানুয়ারি' : '1st January' }}
                        </button>
                    </div>
                </div>

                {{-- 3. Quota Selection (Only for Govt Mode) --}}
                <div id="quota-section">
                    <label class="block text-xs font-bold text-gray-800 mb-1.5 flex items-center gap-1.5">
                        <i class="fa-solid fa-award text-amber-500"></i>
                        <span>{{ $isBn ? 'কোটা / প্রার্থী ক্যাটাগরি' : 'Candidate Category / Quota' }}</span>
                    </label>
                    <select id="quota" onchange="autoCalc()" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-xs sm:text-sm font-semibold text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 focus:bg-white transition-all cursor-pointer">
                        <option value="general">{{ $isBn ? 'সাধারণ প্রার্থী (১৮ থেকে ৩২ বছর)' : 'General Candidate (18 to 32 Years)' }}</option>
                        <option value="ff">{{ $isBn ? 'বীর মুক্তিযোদ্ধা / শহীদ বীর মুক্তিযোদ্ধার সন্তান (১৮ থেকে ৩৪ বছর)' : 'Freedom Fighter / Martyr Child (18 to 34 Years)' }}</option>
                        <option value="disabled">{{ $isBn ? 'শারীরিক প্রতিবন্ধী কোটা (১৮ থেকে ৩৪ বছর)' : 'Persons with Disabilities (18 to 34 Years)' }}</option>
                        <option value="dep">{{ $isBn ? 'বিভাগীয় প্রার্থী / বিশেষ কোটা (৪০ বছর পর্যন্ত)' : 'Departmental Candidate (Up to 40 Years)' }}</option>
                    </select>
                </div>

                {{-- Action Button --}}
                <button type="button" onclick="calculateAge()" class="btn-primary w-full py-3.5 text-sm sm:text-base font-bold shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                    <span>{{ $isBn ? 'বয়স ও যোগ্যতা যাচাই করুন' : 'Calculate & Check Eligibility' }}</span>
                </button>
            </div>
        </div>

        {{-- Right Result Column --}}
        <div class="lg:col-span-7 space-y-5">

            {{-- Initial State (Prompt) --}}
            <div id="result-placeholder" class="card p-8 sm:p-12 text-center bg-white border border-gray-100 shadow-sm rounded-2xl flex flex-col items-center justify-center min-h-[380px]">
                <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-3xl mb-4">
                    <i class="fa-solid fa-user-clock"></i>
                </div>
                <h3 class="font-extrabold text-gray-800 text-base sm:text-lg mb-1">
                    {{ $isBn ? 'জন্মতারিখ নির্বাচন করে বয়স দেখুন' : 'Select Birthdate to Calculate' }}
                </h3>
                <p class="text-xs sm:text-sm text-gray-500 max-w-sm leading-relaxed">
                    {{ $isBn ? 'আপনার জন্মতারিখ ও চাকরির বিজ্ঞপ্তির তারিখ ইনপুট দিলে স্বয়ংক্রিয়ভাবে সঠিক বছর, মাস, দিন এবং আবেদনের যোগ্যতা চলে আসবে।' : 'Enter your birth date and reference date to get instant age metrics and eligibility status.' }}
                </p>
            </div>

            {{-- Result Card (Dynamically displayed) --}}
            <div id="result-box" class="hidden space-y-4">

                {{-- 1. Main Eligibility Banner --}}
                <div id="eligibility-banner" class="p-5 sm:p-6 rounded-2xl border transition-all">
                    <div class="flex items-center gap-3">
                        <div id="eligibility-icon-box" class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl shrink-0">
                            {{-- Dynamically populated --}}
                        </div>
                        <div class="flex-1">
                            <span id="eligibility-badge" class="text-[11px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full inline-block mb-1"></span>
                            <h3 id="eligibility-title" class="font-black text-lg sm:text-xl leading-tight"></h3>
                            <p id="eligibility-desc" class="text-xs sm:text-sm mt-1"></p>
                        </div>
                    </div>
                </div>

                {{-- 2. Exact Age Breakdown Grid --}}
                <div class="card p-5 bg-white border border-gray-100 rounded-2xl shadow-sm space-y-4">
                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-solid fa-hourglass-half text-blue-600"></i>
                        <span>{{ $isBn ? 'বিজ্ঞপ্তির তারিখে আপনার নিখুঁত বয়স' : 'Exact Age Breakdown' }}</span>
                    </h4>

                    <div class="grid grid-cols-3 gap-3 text-center">
                        <div class="p-3.5 bg-blue-50/70 border border-blue-100 rounded-xl">
                            <p id="res-years" class="text-2xl sm:text-3xl font-black text-blue-700">0</p>
                            <p class="text-[11px] font-bold text-gray-600 uppercase tracking-wide mt-0.5">{{ $isBn ? 'বছর' : 'Years' }}</p>
                        </div>
                        <div class="p-3.5 bg-indigo-50/70 border border-indigo-100 rounded-xl">
                            <p id="res-months" class="text-2xl sm:text-3xl font-black text-indigo-700">0</p>
                            <p class="text-[11px] font-bold text-gray-600 uppercase tracking-wide mt-0.5">{{ $isBn ? 'মাস' : 'Months' }}</p>
                        </div>
                        <div class="p-3.5 bg-violet-50/70 border border-violet-100 rounded-xl">
                            <p id="res-days" class="text-2xl sm:text-3xl font-black text-violet-700">0</p>
                            <p class="text-[11px] font-bold text-gray-600 uppercase tracking-wide mt-0.5">{{ $isBn ? 'দিন' : 'Days' }}</p>
                        </div>
                    </div>

                    {{-- Sentence summary --}}
                    <div class="p-3 bg-gray-50 rounded-xl text-center text-xs font-semibold text-gray-700">
                        {{ $isBn ? 'অর্থাৎ সম্পূর্ণ বয়স:' : 'Exact age:' }} <span id="res-summary-text" class="text-blue-700 font-extrabold">—</span>
                    </div>
                </div>

                {{-- 3. Career Remaining Time (Govt Job Mode) --}}
                <div id="career-remaining-box" class="card p-5 bg-gradient-to-br from-amber-50/60 to-orange-50/30 border border-amber-200/80 rounded-2xl shadow-xs space-y-2">
                    <div class="flex items-center justify-between">
                        <h4 class="text-xs font-bold text-amber-900 flex items-center gap-1.5">
                            <i class="fa-solid fa-clock-rotate-left text-amber-600"></i>
                            <span id="remaining-label">{{ $isBn ? 'সরকারি চাকরির বয়স আর কতদিন বাকি?' : 'Govt Career Time Remaining' }}</span>
                        </h4>
                        <span id="remaining-limit-badge" class="text-[10px] font-extrabold bg-amber-100 text-amber-800 px-2 py-0.5 rounded-full"></span>
                    </div>
                    <p id="remaining-time-text" class="text-base sm:text-lg font-extrabold text-amber-900"></p>
                    <p id="remaining-subtext" class="text-[11px] text-amber-700/90 leading-relaxed"></p>
                </div>

                {{-- 4. Fun Life Stats (Days, Weeks, Next Birthday) --}}
                <div class="card p-5 bg-white border border-gray-100 rounded-2xl shadow-sm space-y-3">
                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-solid fa-chart-pie text-blue-600"></i>
                        <span>{{ $isBn ? 'জীবন গণনা ও পরবর্তী জন্মদিন' : 'Life Statistics & Next Birthday' }}</span>
                    </h4>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 text-xs">
                        <div class="p-2.5 bg-gray-50 rounded-xl">
                            <span class="text-[10px] text-gray-400 block">{{ $isBn ? 'মোট দিন অতিক্রান্ত' : 'Total Days Lived' }}</span>
                            <strong id="stat-total-days" class="text-sm text-gray-800">—</strong>
                        </div>
                        <div class="p-2.5 bg-gray-50 rounded-xl">
                            <span class="text-[10px] text-gray-400 block">{{ $isBn ? 'মোট সপ্তাহ' : 'Total Weeks' }}</span>
                            <strong id="stat-total-weeks" class="text-sm text-gray-800">—</strong>
                        </div>
                        <div class="p-2.5 bg-gray-50 rounded-xl col-span-2 sm:col-span-1">
                            <span class="text-[10px] text-gray-400 block">{{ $isBn ? 'পরবর্তী জন্মদিন' : 'Next Birthday in' }}</span>
                            <strong id="stat-next-bday" class="text-sm text-blue-600">—</strong>
                        </div>
                    </div>
                </div>

                {{-- 5. WhatsApp & Social Share Bar --}}
                <div class="card p-4 bg-emerald-50/70 border border-emerald-200/80 rounded-2xl flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div class="text-center sm:text-left">
                        <p class="text-xs font-bold text-emerald-900">{{ $isBn ? 'বন্ধুদের সাথে শেয়ার করুন' : 'Share with Friends' }}</p>
                        <p class="text-[11px] text-emerald-700">{{ $isBn ? 'চাকরিপ্রার্থী বন্ধুদেরও বয়স ও যোগ্যতা সহজে যাচাই করতে দিন।' : 'Let your job-seeker friends calculate their age too.' }}</p>
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <button type="button" onclick="shareWhatsApp()" class="flex-1 sm:flex-none px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold inline-flex items-center justify-center gap-1.5 shadow-sm transition-colors">
                            <i class="fa-brands fa-whatsapp text-sm"></i>
                            <span>WhatsApp</span>
                        </button>
                        <button type="button" onclick="shareCopyLink()" class="flex-1 sm:flex-none px-3.5 py-2 bg-white hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-xl text-xs font-bold inline-flex items-center justify-center gap-1.5 transition-colors">
                            <i class="fa-solid fa-link text-xs"></i>
                            <span>{{ $isBn ? 'লিংক কপি' : 'Copy' }}</span>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Bottom Informational Guide (High SEO Value) --}}
    <div class="mt-12 bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm space-y-6">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-lg">
                <i class="fa-solid fa-circle-info"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900">{{ $isBn ? 'সরকারি চাকরিতে বয়সসীমা ও নিয়মাবলী (সর্বশেষ আপডেট)' : 'BD Govt Job Age Rules & Guidelines' }}</h3>
                <p class="text-xs text-gray-500">{{ $isBn ? 'বাংলাদেশ সরকারের সর্বশেষ প্রজ্ঞাপন অনুযায়ী প্রস্তুতকৃত নিয়ম' : 'Updated regulations per official government gazette' }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs leading-relaxed text-gray-600">
            <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 space-y-1.5">
                <h4 class="font-bold text-gray-900 text-sm flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    <span>{{ $isBn ? 'সাধারণ প্রার্থী: ৩২ বছর' : 'General Candidates: 32 Yrs' }}</span>
                </h4>
                <p>{{ $isBn ? 'সরকারি চাকরিতে প্রবেশের সাধারণ বয়সসীমা ৩০ থেকে বৃদ্ধি করে ৩২ বছর নির্ধারণ করা হয়েছে। সর্বনিম্ন বয়স সাধারণত ১৮ বছর।' : 'Maximum entry age limit has been updated to 32 years. Minimum entry age is 18 years.' }}</p>
            </div>

            <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 space-y-1.5">
                <h4 class="font-bold text-gray-900 text-sm flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                    <span>{{ $isBn ? 'মুক্তিযোদ্ধা ও প্রতিবন্ধী: ৩৪ বছর' : 'Quota Candidates: 34 Yrs' }}</span>
                </h4>
                <p>{{ $isBn ? 'বীর মুক্তিযোদ্ধা বা শহীদ মুক্তিযোদ্ধাদের সন্তান এবং শারীরিক প্রতিবন্ধী প্রার্থীদের ক্ষেত্রে সর্বোচ্চ বয়সসীমা ৩৪ বছর পর্যন্ত বহাল।' : 'Children of Freedom Fighters and applicants with disabilities have an upper age limit of 34 years.' }}</p>
            </div>

            <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 space-y-1.5">
                <h4 class="font-bold text-gray-900 text-sm flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                    <span>{{ $isBn ? 'রেফারেন্স তারিখের নিয়ম' : 'Circular Cut-off Rule' }}</span>
                </h4>
                <p>{{ $isBn ? 'বিজ্ঞপ্তিতে উল্লিখিত নির্দিষ্ট তারিখে প্রার্থীর বয়স গণনা করা হয়। অনেক সার্কুলারে মাসের ১ম দিন বা আবেদনের শেষ দিন রেফারেন্স হিসেবে থাকে।' : 'Age is calculated strictly on the cut-off date stated in the official circular (often the 1st of the month or deadline).' }}</p>
            </div>
        </div>
    </div>

    @include('partials.tool-ad')
</div>

@push('scripts')
<script>
let activeMode = 'govt';
const isBn = @json($isBn);

// Initialize default dates
document.addEventListener('DOMContentLoaded', function() {
    setTodayRef();
    // Default sample DOB for instant demonstration
    const sampleDob = new Date();
    sampleDob.setFullYear(sampleDob.getFullYear() - 25);
    sampleDob.setMonth(5);
    sampleDob.setDate(15);
    document.getElementById('dob').value = sampleDob.toISOString().split('T')[0];
    calculateAge();
});

function setTodayRef() {
    const today = new Date();
    document.getElementById('ref').value = today.toISOString().split('T')[0];
}

function setPresetDate(type) {
    const today = new Date();
    if (type === 'current-first') {
        const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        document.getElementById('ref').value = firstDay.toISOString().split('T')[0];
    } else if (type === 'year-first') {
        const yearFirst = new Date(today.getFullYear(), 0, 1);
        document.getElementById('ref').value = yearFirst.toISOString().split('T')[0];
    }
    autoCalc();
}

function setMode(mode) {
    activeMode = mode;
    const tabGovt = document.getElementById('tab-govt');
    const tabGeneral = document.getElementById('tab-general');
    const quotaSection = document.getElementById('quota-section');
    const quickPresets = document.getElementById('quick-ref-presets');
    const careerRemaining = document.getElementById('career-remaining-box');
    const refLabel = document.getElementById('ref-label');

    if (mode === 'govt') {
        tabGovt.className = 'flex-1 py-2 rounded-lg bg-white text-blue-600 shadow-xs transition-all flex items-center justify-center gap-1.5 font-bold';
        tabGeneral.className = 'flex-1 py-2 rounded-lg text-gray-500 hover:text-gray-900 transition-all flex items-center justify-center gap-1.5 font-semibold';
        quotaSection.classList.remove('hidden');
        quickPresets.classList.remove('hidden');
        careerRemaining.classList.remove('hidden');
        refLabel.textContent = isBn ? 'বিজ্ঞপ্তির নির্দিষ্ট তারিখ (As on Date)' : 'Circular Reference Date';
    } else {
        tabGeneral.className = 'flex-1 py-2 rounded-lg bg-white text-blue-600 shadow-xs transition-all flex items-center justify-center gap-1.5 font-bold';
        tabGovt.className = 'flex-1 py-2 rounded-lg text-gray-500 hover:text-gray-900 transition-all flex items-center justify-center gap-1.5 font-semibold';
        quotaSection.classList.add('hidden');
        quickPresets.classList.add('hidden');
        careerRemaining.classList.add('hidden');
        refLabel.textContent = isBn ? 'হিসাবের তারিখ (As of Date)' : 'As of Date';
    }
    calculateAge();
}

function autoCalc() {
    if (document.getElementById('dob').value) {
        calculateAge();
    }
}

function calculateAge() {
    const dobInput = document.getElementById('dob').value;
    const refInput = document.getElementById('ref').value;

    if (!dobInput) {
        return;
    }

    const dob = new Date(dobInput);
    const ref = refInput ? new Date(refInput) : new Date();

    if (isNaN(dob.getTime())) {
        alert(isBn ? 'সঠিক জন্মতারিখ দিন।' : 'Please select a valid date of birth.');
        return;
    }

    if (dob > ref) {
        alert(isBn ? 'জন্মতারিখ রেফারেন্স তারিখের চেয়ে বড় হতে পারে না!' : 'Date of birth cannot be after the reference date!');
        return;
    }

    // Precise year, month, day difference
    let years = ref.getFullYear() - dob.getFullYear();
    let months = ref.getMonth() - dob.getMonth();
    let days = ref.getDate() - dob.getDate();

    if (days < 0) {
        months--;
        const prevMonthLastDay = new Date(ref.getFullYear(), ref.getMonth(), 0).getDate();
        days += prevMonthLastDay;
    }

    if (months < 0) {
        years--;
        months += 12;
    }

    // Populate Numbers
    document.getElementById('res-years').textContent = years;
    document.getElementById('res-months').textContent = months;
    document.getElementById('res-days').textContent = days;

    const summaryStr = isBn
        ? `${years} বছর, ${months} মাস, ${days} দিন`
        : `${years} Years, ${months} Months, ${days} Days`;
    document.getElementById('res-summary-text').textContent = summaryStr;

    // Total Days Lived
    const diffTime = Math.abs(ref - dob);
    const totalDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
    const totalWeeks = Math.floor(totalDays / 7);

    document.getElementById('stat-total-days').textContent = totalDays.toLocaleString() + (isBn ? ' দিন' : ' days');
    document.getElementById('stat-total-weeks').textContent = totalWeeks.toLocaleString() + (isBn ? ' সপ্তাহ' : ' weeks');

    // Next Birthday countdown
    const currentYear = ref.getFullYear();
    let nextBday = new Date(currentYear, dob.getMonth(), dob.getDate());
    if (nextBday < ref) {
        nextBday.setFullYear(currentYear + 1);
    }
    const daysUntilNextBday = Math.ceil((nextBday - ref) / (1000 * 60 * 60 * 24));
    document.getElementById('stat-next-bday').textContent = daysUntilNextBday === 0
        ? (isBn ? '🎉 আজ আপনার জন্মদিন!' : '🎉 Today is Birthday!')
        : `${daysUntilNextBday} ${isBn ? 'দিন বাকি' : 'days left'}`;

    // Government Eligibility Check
    if (activeMode === 'govt') {
        const quota = document.getElementById('quota').value;
        let maxAge = 32;
        let quotaLabel = isBn ? '৩২ বছর (সাধারণ কোটা)' : '32 Years (General)';

        if (quota === 'ff') {
            maxAge = 34;
            quotaLabel = isBn ? '৩৪ বছর (মুক্তিযোদ্ধা কোটা)' : '34 Years (Freedom Fighter)';
        } else if (quota === 'disabled') {
            maxAge = 34;
            quotaLabel = isBn ? '৩৪ বছর (প্রতিবন্ধী কোটা)' : '34 Years (Disabled)';
        } else if (quota === 'dep') {
            maxAge = 40;
            quotaLabel = isBn ? '৪০ বছর (বিভাগীয় কোটা)' : '40 Years (Departmental)';
        }

        const banner = document.getElementById('eligibility-banner');
        const iconBox = document.getElementById('eligibility-icon-box');
        const badge = document.getElementById('eligibility-badge');
        const title = document.getElementById('eligibility-title');
        const desc = document.getElementById('eligibility-desc');

        const remainingLimitBadge = document.getElementById('remaining-limit-badge');
        const remainingTimeText = document.getElementById('remaining-time-text');
        const remainingSubtext = document.getElementById('remaining-subtext');

        remainingLimitBadge.textContent = quotaLabel;

        const minAge = 18;
        const isUnderage = (years < minAge);
        const isEligible = (years >= minAge && (years < maxAge || (years === maxAge && months === 0 && days === 0)));

        if (isEligible) {
            // Eligible
            banner.className = 'p-5 sm:p-6 rounded-2xl border bg-emerald-50/90 border-emerald-200 text-emerald-950 shadow-sm';
            iconBox.className = 'w-12 h-12 rounded-xl bg-emerald-500 text-white flex items-center justify-center text-2xl shrink-0 shadow-md shadow-emerald-500/20';
            iconBox.innerHTML = '<i class="fa-solid fa-circle-check"></i>';
            badge.className = 'text-[11px] font-extrabold uppercase tracking-wider px-2.5 py-0.5 rounded-full inline-block mb-1 bg-emerald-200/80 text-emerald-900';
            badge.textContent = isBn ? 'যোগ্য (Eligible)' : 'Eligible';
            title.textContent = isBn ? 'অভিনন্দন! আপনি সরকারি চাকরিতে আবেদনের যোগ্য' : 'Eligible for Government Jobs!';
            desc.textContent = isBn
                ? `আপনার বয়স ${summaryStr}। এই কোটায় সর্বোচ্চ বয়সসীমা ${maxAge} বছর পর্যন্ত গ্রহণযোগ্য।`
                : `Your age is ${summaryStr}, within the maximum ${maxAge} years limit.`;

            // Calculate remaining career time
            let remYears = maxAge - 1 - years;
            let remMonths = 11 - months;
            const refMonthLastDay = new Date(ref.getFullYear(), ref.getMonth() + 1, 0).getDate();
            let remDays = refMonthLastDay - days;

            if (remDays >= 30) {
                remMonths++;
                remDays -= 30;
            }
            if (remMonths >= 12) {
                remYears++;
                remMonths -= 12;
            }

            remainingTimeText.textContent = isBn
                ? `আর ${remYears} বছর, ${remMonths} মাস, ${remDays} দিন বাকি`
                : `${remYears} Years, ${remMonths} Months, ${remDays} Days remaining`;
            remainingSubtext.textContent = isBn
                ? `আপনার বয়সসীমা ${maxAge} বছর পূর্ণ হতে এখনও উল্লেখিত সময় রয়েছে। পূর্ণ উদ্যমে প্রস্তুতি নিন!`
                : `You still have this amount of time before hitting the ${maxAge}-year threshold.`;
        } else if (isUnderage) {
            // Under 18
            banner.className = 'p-5 sm:p-6 rounded-2xl border bg-amber-50/90 border-amber-200 text-amber-950 shadow-sm';
            iconBox.className = 'w-12 h-12 rounded-xl bg-amber-500 text-white flex items-center justify-center text-2xl shrink-0 shadow-md shadow-amber-500/20';
            iconBox.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i>';
            badge.className = 'text-[11px] font-extrabold uppercase tracking-wider px-2.5 py-0.5 rounded-full inline-block mb-1 bg-amber-200/80 text-amber-900';
            badge.textContent = isBn ? 'বয়স কম' : 'Underage';
            title.textContent = isBn ? 'সরকারি চাকরির জন্য বয়স এখনও পূর্ণ হয়নি' : 'Below Minimum Age Requirement';
            desc.textContent = isBn
                ? `আপনার বয়স ${summaryStr}। সরকারি চাকরিতে আবেদনের সর্বনিম্ন বয়স ১৮ বছর হতে হবে।`
                : `Your age is ${summaryStr}. Minimum age required is 18 years.`;

            const needYears = 17 - years;
            const needMonths = 12 - months;
            remainingTimeText.textContent = isBn
                ? `১৮ বছর হতে আর কিছু সময় বাকি`
                : `Time until 18 years old`;
            remainingSubtext.textContent = isBn
                ? `১৮ বছর পূর্ণ হলে আপনি সরকারি চাকরিতে আবেদন করতে পারবেন।`
                : `You will be eligible once you reach 18 years.`;
        } else {
            // Overaged
            banner.className = 'p-5 sm:p-6 rounded-2xl border bg-rose-50/90 border-rose-200 text-rose-950 shadow-sm';
            iconBox.className = 'w-12 h-12 rounded-xl bg-rose-500 text-white flex items-center justify-center text-2xl shrink-0 shadow-md shadow-rose-500/20';
            iconBox.innerHTML = '<i class="fa-solid fa-circle-xmark"></i>';
            badge.className = 'text-[11px] font-extrabold uppercase tracking-wider px-2.5 py-0.5 rounded-full inline-block mb-1 bg-rose-200/80 text-rose-900';
            badge.textContent = isBn ? 'বয়সসীমা অতিক্রান্ত' : 'Over Maximum Age';
            title.textContent = isBn ? 'সরকারি চাকরির আবেদনের বয়সসীমা শেষ হয়েছে' : 'Maximum Age Limit Exceeded';
            desc.textContent = isBn
                ? `আপনার বয়স ${summaryStr}। এই কোটায় সর্বোচ্চ বয়সসীমা ছিল ${maxAge} বছর।`
                : `Your age is ${summaryStr}, exceeding the upper limit of ${maxAge} years.`;

            remainingTimeText.textContent = isBn ? 'সরকারি চাকরির বয়স শেষ' : 'Age Limit Reached';
            remainingSubtext.textContent = isBn
                ? 'তবে আপনি স্বায়ত্তশাসিত প্রতিষ্ঠান, ব্যাংক বা বেসরকারি প্রতিষ্ঠানে নিজ অভিজ্ঞতার ভিত্তিতে আবেদন করতে পারেন।'
                : 'Consider applying for autonomous bodies, banking, or private sector positions.';
        }
    } else {
        // General Mode Banner
        const banner = document.getElementById('eligibility-banner');
        const iconBox = document.getElementById('eligibility-icon-box');
        const badge = document.getElementById('eligibility-badge');
        const title = document.getElementById('eligibility-title');
        const desc = document.getElementById('eligibility-desc');

        banner.className = 'p-5 sm:p-6 rounded-2xl border bg-blue-50/90 border-blue-200 text-blue-950 shadow-sm';
        iconBox.className = 'w-12 h-12 rounded-xl bg-blue-600 text-white flex items-center justify-center text-2xl shrink-0 shadow-md shadow-blue-500/20';
        iconBox.innerHTML = '<i class="fa-solid fa-calendar-check"></i>';
        badge.className = 'text-[11px] font-extrabold uppercase tracking-wider px-2.5 py-0.5 rounded-full inline-block mb-1 bg-blue-200/80 text-blue-900';
        badge.textContent = isBn ? 'বয়স হিসাব সম্পন্ন' : 'Age Calculated';
        title.textContent = isBn ? `আপনার বর্তমান বয়স ${years} বছর` : `Your Age is ${years} Years`;
        desc.textContent = isBn ? `নিখুঁত হিসাব: ${summaryStr}` : `Exact breakdown: ${summaryStr}`;
    }

    // Toggle views
    document.getElementById('result-placeholder').classList.add('hidden');
    document.getElementById('result-box').classList.remove('hidden');
}

function shareWhatsApp() {
    const years = document.getElementById('res-years').textContent;
    const months = document.getElementById('res-months').textContent;
    const days = document.getElementById('res-days').textContent;
    const url = window.location.href;

    const text = isBn
        ? `আমার সরকারি চাকরির বয়স হিসাব করলাম: ${years} বছর ${months} মাস ${days} দিন! আপনার সরকারি চাকরির আর কতদিন বাকি আছে দেখুন এই লিংকে: ${url}`
        : `Calculated my exact age for BD govt jobs: ${years} years, ${months} months, ${days} days! Check yours here: ${url}`;

    window.open(`https://api.whatsapp.com/send?text=${encodeURIComponent(text)}`, '_blank');
}

function shareCopyLink() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        if (window.toast) {
            window.toast.success(isBn ? 'লিংক কপি হয়েছে!' : 'Link copied to clipboard!');
        } else {
            alert(isBn ? 'লিংক কপি হয়েছে!' : 'Link copied!');
        }
    });
}
</script>
@endpush
@endsection
