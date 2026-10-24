@extends('layouts.app')

@php
    $locale = app()->getLocale();
    $isBn   = $locale === 'bn';
@endphp

@section('page_title', ($isBn ? 'নাগরিক সেবা ও রেজাল্ট হাব — ' . config('app.name', 'Quickkaj') : 'Citizen Services & Result Hub — ' . config('app.name', 'Quickkaj')))
@section('seo_description', $isBn
    ? 'ই-পাসপোর্ট আবেদন গাইড, এনআইডি ও জন্ম নিবন্ধন সংশোধন, বোর্ড পরীক্ষার রেজাল্ট SMS কোড ও সরকারি দরখাস্ত ফরম্যাট এক জায়গায়।'
    : 'Complete citizen service guide: e-Passport, NID correction, exam result SMS tracker, and official application draft templates in Bangladesh.')

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "Guide",
    "name": "{{ $isBn ? 'নাগরিক সেবা ও রেজাল্ট হাব' : 'Citizen Services & Result Hub' }}",
    "description": "{{ $isBn ? 'বাংলাদেশের সরকারি সেবা গাইড ও রেজাল্ট ট্র্যাকার।' : 'Citizen guidelines, portals, and exam results directory in Bangladesh.' }}",
    "url": "{{ url()->current() }}"
}
</script>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs text-gray-500 mb-6">
        <a href="{{ route('home', ['locale' => $locale]) }}" class="hover:text-blue-600 transition-colors">
            <i class="fa-solid fa-house"></i>
            <span>{{ __('ui.home') }}</span>
        </a>
        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
        <span class="text-gray-900 font-semibold">{{ $isBn ? 'নাগরিক সেবা ও রেজাল্ট' : 'Citizen Services' }}</span>
    </nav>

    {{-- Hero Section --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-amber-500 via-orange-500 to-rose-500 text-white p-8 sm:p-12 shadow-xl mb-12">
        <div class="absolute -right-16 -top-16 w-80 h-80 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
        <div class="absolute right-12 bottom-0 opacity-15 pointer-events-none hidden md:block">
            <i class="fa-solid fa-landmark-flag text-[180px]"></i>
        </div>

        <div class="relative z-10 max-w-2xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-white/20 backdrop-blur-md text-white border border-white/30 mb-4">
                <i class="fa-solid fa-shield-halved"></i>
                <span>{{ $isBn ? 'সহজ নাগরিক তথ্য বাতায়ন' : 'Citizen Information & Services' }}</span>
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-tight mb-4">
                {{ $isBn ? 'নাগরিক সেবা ও রেজাল্ট হাব' : 'Citizen Services & Result Hub' }}
            </h1>
            <p class="text-sm sm:text-base text-white/90 leading-relaxed mb-6">
                {{ $isBn
                    ? 'ই-পাসপোর্ট আবেদন ও ফি, এনআইডি সংশোধন, পরীক্ষার রেজাল্ট এসএমএস কোড এবং প্রয়োজনীয় সরকারি দরখাস্ত ফরম্যাট এক জায়গায়।'
                    : 'Verified guidelines for e-Passport, NID corrections, SMS codes for SSC/HSC exam results, and ready-to-use official draft templates.' }}
            </p>

            {{-- Quick Stats Pills --}}
            <div class="flex flex-wrap items-center gap-3 text-xs">
                <div class="flex items-center gap-1.5 bg-black/20 backdrop-blur-sm px-3 py-1.5 rounded-xl border border-white/10">
                    <i class="fa-solid fa-passport text-amber-200"></i>
                    <span>{{ $isBn ? 'পাসপোর্ট ফি ক্যালকুলেটর' : 'Passport Fee Guide' }}</span>
                </div>
                <div class="flex items-center gap-1.5 bg-black/20 backdrop-blur-sm px-3 py-1.5 rounded-xl border border-white/10">
                    <i class="fa-solid fa-comment-sms text-amber-200"></i>
                    <span>{{ $isBn ? 'এসএমএস রেজাল্ট জেনারেটর' : 'SMS Code Helper' }}</span>
                </div>
                <div class="flex items-center gap-1.5 bg-black/20 backdrop-blur-sm px-3 py-1.5 rounded-xl border border-white/10">
                    <i class="fa-solid fa-file-lines text-amber-200"></i>
                    <span>{{ $isBn ? 'ফ্রি দরখাস্ত ও জিডি ড্রাফট' : 'Ready Application Drafts' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Main 4 Pillar Feature Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-14">

        {{-- Card 1: E-Passport Guide --}}
        <a href="{{ route('citizen.passport', ['locale' => $locale]) }}"
           class="group relative bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:border-amber-200 transition-all duration-300 flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-100 text-amber-600 flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-passport"></i>
                </div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-amber-600 bg-amber-50 px-2 py-0.5 rounded-md">
                        {{ $isBn ? 'পাসপোর্ট' : 'Passport' }}
                    </span>
                    <span class="text-xs text-gray-400 group-hover:text-amber-600 transition-colors">
                        <i class="fa-solid fa-arrow-right"></i>
                    </span>
                </div>
                <h2 class="text-lg font-bold text-gray-900 group-hover:text-amber-600 transition-colors mb-2">
                    {{ $isBn ? 'ই-পাসপোর্ট আবেদন ও ফি গাইড' : 'e-Passport & Fee Guide' }}
                </h2>
                <p class="text-xs text-gray-500 leading-relaxed">
                    {{ $isBn ? '৪৮ ও ৬৪ পাতার ৫/১০ বছর মেয়াদী সম্পূর্ণ ফি তালিকা, প্রয়োজনীয় কাগজপত্র ও অনলাইন ট্র্যাকিং লিংক।' : 'Full fees table for 5/10 years, required documents checklist and online status check link.' }}
                </p>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-50 flex items-center gap-2 text-xs font-semibold text-amber-600">
                <span>{{ $isBn ? 'বিস্তারিত গাইড পড়ুন' : 'Read Guide' }}</span>
                <i class="fa-solid fa-chevron-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
            </div>
        </a>

        {{-- Card 2: NID & Birth Certificate --}}
        <a href="{{ route('citizen.nid', ['locale' => $locale]) }}"
           class="group relative bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:border-blue-200 transition-all duration-300 flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-id-card"></i>
                </div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md">
                        {{ $isBn ? 'এনআইডি' : 'NID & SmartCard' }}
                    </span>
                    <span class="text-xs text-gray-400 group-hover:text-blue-600 transition-colors">
                        <i class="fa-solid fa-arrow-right"></i>
                    </span>
                </div>
                <h2 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors mb-2">
                    {{ $isBn ? 'NID ও জন্ম নিবন্ধন সংশোধন' : 'NID & Birth Certificate' }}
                </h2>
                <p class="text-xs text-gray-500 leading-relaxed">
                    {{ $isBn ? 'ভুল সংশোধন, নতুন ভোটার আবেদন, হারানো কার্ডের রি-ইস্যু এবং জন্ম নিবন্ধন অনলাইন ভেরিফাইয়ের উপায়।' : 'Name, age, parents name corrections, lost NID re-issue, and birth registration verification.' }}
                </p>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-50 flex items-center gap-2 text-xs font-semibold text-blue-600">
                <span>{{ $isBn ? 'সংশোধন প্রক্রিয়া জানুন' : 'View Instructions' }}</span>
                <i class="fa-solid fa-chevron-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
            </div>
        </a>

        {{-- Card 3: Exam Results & SMS Tracker --}}
        <a href="{{ route('citizen.results', ['locale' => $locale]) }}"
           class="group relative bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:border-emerald-200 transition-all duration-300 flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">
                        {{ $isBn ? 'রেজাল্ট' : 'Results' }}
                    </span>
                    <span class="text-xs text-gray-400 group-hover:text-emerald-600 transition-colors">
                        <i class="fa-solid fa-arrow-right"></i>
                    </span>
                </div>
                <h2 class="text-lg font-bold text-gray-900 group-hover:text-emerald-600 transition-colors mb-2">
                    {{ $isBn ? 'বোর্ড রেজাল্ট ও এসএমএস ট্র্যাকার' : 'Exam Results & SMS Codes' }}
                </h2>
                <p class="text-xs text-gray-500 leading-relaxed">
                    {{ $isBn ? 'SSC, HSC, জাতীয় বিশ্ববিদ্যালয় (NU) রেজাল্ট ও টেলিটকে ১৬২২২ নম্বরে এসএমএস পাঠানোর সঠিক কোড।' : 'Fastest result portals, SMS code formats for all education boards, and Teletalk admit cards.' }}
                </p>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-50 flex items-center gap-2 text-xs font-semibold text-emerald-600">
                <span>{{ $isBn ? 'রেজাল্ট ও SMS কোড দেখুন' : 'Get Results & SMS' }}</span>
                <i class="fa-solid fa-chevron-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
            </div>
        </a>

        {{-- Card 4: GD & Ready Applications --}}
        <a href="{{ route('citizen.applications', ['locale' => $locale]) }}"
           class="group relative bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:border-violet-200 transition-all duration-300 flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 rounded-2xl bg-violet-50 border border-violet-100 text-violet-600 flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-file-signature"></i>
                </div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-violet-600 bg-violet-50 px-2 py-0.5 rounded-md">
                        {{ $isBn ? 'ফরম্যাট' : 'Drafts' }}
                    </span>
                    <span class="text-xs text-gray-400 group-hover:text-violet-600 transition-colors">
                        <i class="fa-solid fa-arrow-right"></i>
                    </span>
                </div>
                <h2 class="text-lg font-bold text-gray-900 group-hover:text-violet-600 transition-colors mb-2">
                    {{ $isBn ? 'দরখাস্ত ও জিডি ড্রাফট ফরম্যাট' : 'GD & Application Drafts' }}
                </h2>
                <p class="text-xs text-gray-500 leading-relaxed">
                    {{ $isBn ? 'পাসপোর্ট/এনআইডি/সার্টিফিকেট হারানোর জিডি আবেদন ও নাগরিকত্ব সনদের রেডি ফরম্যাট (কপি ও প্রিন্ট)।' : 'Lost document GD templates and citizenship certificate application drafts with 1-click copy.' }}
                </p>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-50 flex items-center gap-2 text-xs font-semibold text-violet-600">
                <span>{{ $isBn ? 'ফরম্যাট কপি করুন' : 'View Templates' }}</span>
                <i class="fa-solid fa-chevron-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
            </div>
        </a>

    </div>

    {{-- Interactive Live SMS Helper Widget --}}
    <div class="bg-gradient-to-br from-slate-900 to-indigo-950 text-white rounded-3xl p-6 sm:p-10 shadow-xl mb-14 border border-slate-800">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 mb-3">
                <i class="fa-solid fa-bolt"></i>
                <span>{{ $isBn ? 'ইনস্ট্যান্ট এসএমএস কোড জেনারেটর' : 'Instant Result SMS Code Generator' }}</span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-black mb-3">
                {{ $isBn ? 'সার্ভার ডাউন? মুহূর্তেই সঠিক এসএমএস কোড তৈরি করুন' : 'Official Server Busy? Generate Result SMS Code' }}
            </h2>
            <p class="text-xs sm:text-sm text-slate-300 mb-6">
                {{ $isBn
                    ? 'পরীক্ষার নাম, আপনার বোর্ড ও রোল নম্বর বসিয়ে নিচের কোডটি কপি করে ১৬২২২ নম্বরে পাঠিয়ে দিন।'
                    : 'Select exam, board, and enter roll number to generate the exact SMS to send to 16222.' }}
            </p>

            {{-- Controls Form --}}
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-3 mb-6">
                <div>
                    <label class="block text-[11px] font-semibold text-slate-400 mb-1">{{ $isBn ? 'পরীক্ষা' : 'Exam' }}</label>
                    <select id="sms-exam" class="w-full bg-slate-800/90 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        <option value="SSC">SSC (এসএসসি)</option>
                        <option value="HSC">HSC (এইচএসসি)</option>
                        <option value="DAKHIL">Dakhil (দাখিল)</option>
                        <option value="VOC">Vocational (ভোকেশনাল)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-400 mb-1">{{ $isBn ? 'বোর্ড' : 'Education Board' }}</label>
                    <select id="sms-board" class="w-full bg-slate-800/90 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        <option value="DHA">Dhaka (DHA)</option>
                        <option value="CHI">Chittagong (CHI)</option>
                        <option value="RAJ">Rajshahi (RAJ)</option>
                        <option value="COM">Comilla (COM)</option>
                        <option value="JES">Jessore (JES)</option>
                        <option value="BAR">Barisal (BAR)</option>
                        <option value="SYL">Sylhet (SYL)</option>
                        <option value="DIN">Dinajpur (DIN)</option>
                        <option value="MYM">Mymensingh (MYM)</option>
                        <option value="MAD">Madrasah (MAD)</option>
                        <option value="TEC">Technical (TEC)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-400 mb-1">{{ $isBn ? 'রোল নম্বর' : 'Roll Number' }}</label>
                    <input type="text" id="sms-roll" placeholder="123456" value="123456"
                           class="w-full bg-slate-800/90 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none font-mono">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-400 mb-1">{{ $isBn ? 'পাশের বছর' : 'Year' }}</label>
                    <input type="text" id="sms-year" placeholder="2026" value="2026"
                           class="w-full bg-slate-800/90 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none font-mono">
                </div>
            </div>

            {{-- Result Output Box --}}
            <div class="bg-black/50 border border-slate-700/80 rounded-2xl p-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="w-full sm:w-auto">
                    <p class="text-[11px] text-slate-400 mb-0.5">{{ $isBn ? 'পাঠাতে হবে (To): 16222' : 'Send To: 16222' }}</p>
                    <p class="text-xs text-slate-300">{{ $isBn ? 'মেসেজ টেক্সট:' : 'SMS Message Body:' }}</p>
                    <div id="sms-preview" class="text-base sm:text-lg font-mono font-bold text-emerald-400 tracking-wider mt-0.5">
                        SSC DHA 123456 2026
                    </div>
                </div>
                <button type="button" id="copy-sms-btn"
                        class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-bold text-xs flex items-center justify-center gap-2 transition-colors flex-shrink-0">
                    <i class="fa-regular fa-copy"></i>
                    <span id="copy-sms-text">{{ $isBn ? 'এসএমএস কোড কপি করুন' : 'Copy SMS' }}</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Direct Official Portals Directory --}}
    <div class="mb-14">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-900">{{ $isBn ? 'অফিসিয়াল সরকারি পোর্টাল ডিরেক্টরি' : 'Official Government Portals' }}</h3>
                <p class="text-xs text-gray-500">{{ $isBn ? 'সরাসরি সরকারি ওয়েবসাইটে ঢুকে নিরাপদে আবেদন বা যাচাই করুন' : 'Direct links to official portals for safe verification' }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="https://www.epassport.gov.bd/" target="_blank" rel="noopener noreferrer"
               class="p-4 bg-white rounded-2xl border border-gray-100 shadow-xs hover:border-amber-300 hover:shadow-md transition-all flex items-center justify-between group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-passport"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-gray-900 group-hover:text-amber-600 transition-colors">ই-পাসপোর্ট বাংলাদেশ</h4>
                        <p class="text-[10px] text-gray-400">epassport.gov.bd</p>
                    </div>
                </div>
                <i class="fa-solid fa-arrow-up-right-from-square text-xs text-gray-300 group-hover:text-amber-600"></i>
            </a>

            <a href="https://services.nidw.gov.bd/" target="_blank" rel="noopener noreferrer"
               class="p-4 bg-white rounded-2xl border border-gray-100 shadow-xs hover:border-blue-300 hover:shadow-md transition-all flex items-center justify-between group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-id-card"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-gray-900 group-hover:text-blue-600 transition-colors">নির্বাচন কমিশন NID উইং</h4>
                        <p class="text-[10px] text-gray-400">services.nidw.gov.bd</p>
                    </div>
                </div>
                <i class="fa-solid fa-arrow-up-right-from-square text-xs text-gray-300 group-hover:text-blue-600"></i>
            </a>

            <a href="https://bdris.gov.bd/" target="_blank" rel="noopener noreferrer"
               class="p-4 bg-white rounded-2xl border border-gray-100 shadow-xs hover:border-emerald-300 hover:shadow-md transition-all flex items-center justify-between group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-gray-900 group-hover:text-emerald-600 transition-colors">জন্ম ও মৃত্যু নিবন্ধন পোর্টাল</h4>
                        <p class="text-[10px] text-gray-400">bdris.gov.bd</p>
                    </div>
                </div>
                <i class="fa-solid fa-arrow-up-right-from-square text-xs text-gray-300 group-hover:text-emerald-600"></i>
            </a>

            <a href="http://www.educationboardresults.gov.bd/" target="_blank" rel="noopener noreferrer"
               class="p-4 bg-white rounded-2xl border border-gray-100 shadow-xs hover:border-violet-300 hover:shadow-md transition-all flex items-center justify-between group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-gray-900 group-hover:text-violet-600 transition-colors">শিক্ষা বোর্ড রেজাল্ট পোর্টাল</h4>
                        <p class="text-[10px] text-gray-400">educationboardresults.gov.bd</p>
                    </div>
                </div>
                <i class="fa-solid fa-arrow-up-right-from-square text-xs text-gray-300 group-hover:text-violet-600"></i>
            </a>

            <a href="http://www.nu.ac.bd/results/" target="_blank" rel="noopener noreferrer"
               class="p-4 bg-white rounded-2xl border border-gray-100 shadow-xs hover:border-indigo-300 hover:shadow-md transition-all flex items-center justify-between group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-building-columns"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">জাতীয় বিশ্ববিদ্যালয় রেজাল্ট</h4>
                        <p class="text-[10px] text-gray-400">nu.ac.bd/results</p>
                    </div>
                </div>
                <i class="fa-solid fa-arrow-up-right-from-square text-xs text-gray-300 group-hover:text-indigo-600"></i>
            </a>

            <a href="https://alljobs.teletalk.com.bd/" target="_blank" rel="noopener noreferrer"
               class="p-4 bg-white rounded-2xl border border-gray-100 shadow-xs hover:border-rose-300 hover:shadow-md transition-all flex items-center justify-between group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-gray-900 group-hover:text-rose-600 transition-colors">টেলিটক অলজবস ও এডমিট কার্ড</h4>
                        <p class="text-[10px] text-gray-400">alljobs.teletalk.com.bd</p>
                    </div>
                </div>
                <i class="fa-solid fa-arrow-up-right-from-square text-xs text-gray-300 group-hover:text-rose-600"></i>
            </a>
        </div>
    </div>

    {{-- Cross-link with Free Tools Banner --}}
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100 rounded-3xl p-6 sm:p-8 flex flex-col sm:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-xl flex-shrink-0 shadow-md">
                <i class="fa-solid fa-crop-simple"></i>
            </div>
            <div>
                <h4 class="text-base font-bold text-gray-900 mb-1">
                    {{ $isBn ? 'পাসপোর্ট ও সরকারি ফরমে ছবির সাইজ নিয়ে সমস্যা?' : 'Need 300x300 Photo for Govt Forms?' }}
                </h4>
                <p class="text-xs text-gray-600">
                    {{ $isBn ? 'আমাদের ফ্রি ৩০০০×৩০০ ইমেজ সাইজার ও পিডিএফ মার্জার দিয়ে ঘরে বসেই রেডি করুন।' : 'Use our 100% free Photo Resizer and PDF Tools to prepare documents instantly.' }}
                </p>
            </div>
        </div>
        <div class="flex items-center gap-3 flex-shrink-0 w-full sm:w-auto">
            <a href="{{ route('tools.image-resizer') }}"
               class="flex-1 sm:flex-initial text-center px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-xs transition-colors">
                {{ $isBn ? 'ছবি রিসাইজ করুন' : 'Resize Photo' }}
            </a>
            <a href="{{ route('tools.pdf-tools') }}"
               class="flex-1 sm:flex-initial text-center px-4 py-2.5 rounded-xl bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 text-xs font-bold transition-colors">
                {{ $isBn ? 'PDF মার্জ করুন' : 'Merge PDF' }}
            </a>
        </div>
    </div>

</div>

<script>
(() => {
    const exam = document.getElementById('sms-exam');
    const board = document.getElementById('sms-board');
    const roll = document.getElementById('sms-roll');
    const year = document.getElementById('sms-year');
    const preview = document.getElementById('sms-preview');
    const copyBtn = document.getElementById('copy-sms-btn');
    const copyText = document.getElementById('copy-sms-text');

    function updateSms() {
        const e = (exam.value || 'SSC').trim().toUpperCase();
        const b = (board.value || 'DHA').trim().toUpperCase();
        const r = (roll.value || '123456').trim();
        const y = (year.value || '2026').trim();
        preview.textContent = `${e} ${b} ${r} ${y}`;
    }

    [exam, board, roll, year].forEach(el => el?.addEventListener('input', updateSms));

    copyBtn?.addEventListener('click', () => {
        const text = preview.textContent.trim();
        navigator.clipboard.writeText(text).then(() => {
            const original = copyText.textContent;
            copyText.textContent = 'কপি হয়েছে!';
            copyBtn.classList.replace('bg-emerald-500', 'bg-emerald-400');
            setTimeout(() => {
                copyText.textContent = original;
                copyBtn.classList.replace('bg-emerald-400', 'bg-emerald-500');
            }, 2000);
        });
    });
})();
</script>
@endsection
