@extends('layouts.app')

@php
    $locale = app()->getLocale();
    $isBn   = $locale === 'bn';
@endphp

@section('page_title', ($isBn ? 'NID ও জন্ম নিবন্ধন সংশোধন গাইড ২০২৬ — ' . config('app.name', 'Quickkaj') : 'NID & Birth Certificate Correction Guide — ' . config('app.name', 'Quickkaj')))
@section('seo_description', $isBn
    ? 'জাতীয় পরিচয়পত্র (এনআইডি) নাম, বয়স ও ঠিকানা সংশোধন ফি এবং জন্ম নিবন্ধন অনলাইন যাচাই ও সংশোধনের পূর্ণাঙ্গ নির্দেশিকা।'
    : 'Complete guideline for NID card correction, fees, required documents, and online birth certificate verification in Bangladesh.')

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "HowTo",
    "name": "{{ $isBn ? 'এনআইডি ও জন্ম নিবন্ধন সংশোধনের নিয়ম' : 'NID and Birth Certificate Correction Guide' }}",
    "description": "{{ $isBn ? 'অনলাইনে NID ভুল সংশোধন ও প্রয়োজনীয় কাগজপত্র।' : 'NID correction procedure and documents in Bangladesh.' }}",
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
        <a href="{{ route('citizen.index', ['locale' => $locale]) }}" class="hover:text-blue-600 transition-colors">
            <span>{{ $isBn ? 'নাগরিক সেবা' : 'Citizen Services' }}</span>
        </a>
        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
        <span class="text-gray-900 font-semibold">{{ $isBn ? 'NID সংশোধন' : 'NID Guide' }}</span>
    </nav>

    {{-- Header --}}
    <div class="mb-10">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200 mb-3">
            <i class="fa-solid fa-id-card"></i>
            <span>{{ $isBn ? 'জাতীয় পরিচয়পত্র বাতায়ন' : 'NID Services' }}</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-gray-900 tracking-tight mb-3">
            {{ $isBn ? 'NID ও জন্ম নিবন্ধন সংশোধন: ফি ও প্রয়োজনীয় কাগজপত্র' : 'NID & Birth Certificate Correction Guide' }}
        </h1>
        <p class="text-sm text-gray-600 leading-relaxed">
            {{ $isBn
                ? 'অনলাইনে নির্বাচন কমিশনের পোর্টাল (services.nidw.gov.bd) থেকে ঘরে বসেই নিজের জাতীয় পরিচয়পত্রের ভুল সংশোধন ও রি-ইস্যু করা যায়।'
                : 'Correct errors in name, birth date, parent names, or re-issue lost NID directly through the official Election Commission portal.' }}
        </p>
    </div>

    {{-- NID Correction Categories --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">

        {{-- Box 1: Types of Correction --}}
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2.5">
                <i class="fa-solid fa-pen-to-square text-blue-600"></i>
                <span>{{ $isBn ? 'কী কী সংশোধন করা যায়?' : 'Types of Corrections' }}</span>
            </h3>
            <ul class="space-y-3 text-xs sm:text-sm text-gray-600">
                <li class="flex items-start gap-2.5">
                    <i class="fa-solid fa-check text-blue-500 mt-1"></i>
                    <span><strong>নিজের নাম (বাংলা ও ইংরেজি):</strong> স্পেলিং ভুল বা আংশিক পরিবর্তনের জন্য এসএসসি সার্টিফিকেট / পাসপোর্ট প্রয়োজন।</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <i class="fa-solid fa-check text-blue-500 mt-1"></i>
                    <span><strong>পিতা ও মাতার নাম:</strong> বাবা-মায়ের এনআইডি কপি অথবা ভাই-বোনের এনআইডি দ্বারা প্রমাণিত তথ্য।</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <i class="fa-solid fa-check text-blue-500 mt-1"></i>
                    <span><strong>জন্ম তারিখ সংশোধন:</strong> এসএসসি মূল সনদ / পিএসসি-জেএসসি সনদ অথবা চিকিৎসকের বয়স নির্ধারণী সনদ।</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <i class="fa-solid fa-check text-blue-500 mt-1"></i>
                    <span><strong>ঠিকানা ও রক্তের গ্রুপ:</strong> স্থানীয় চেয়ারম্যান/কাউন্সিলর প্রত্যয়ন এবং ডায়াগনস্টিক রিপোর্ট।</span>
                </li>
            </ul>
        </div>

        {{-- Box 2: Official Fees --}}
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2.5">
                <i class="fa-solid fa-receipt text-emerald-600"></i>
                <span>{{ $isBn ? 'সংশোধন ও রি-ইস্যু সরকারি ফি' : 'Government Fees (Incl. VAT)' }}</span>
            </h3>
            <div class="space-y-3 text-xs sm:text-sm">
                <div class="p-3 bg-gray-50 rounded-xl flex items-center justify-between">
                    <div>
                        <p class="font-bold text-gray-900">ব্যক্তিগত তথ্য সংশোধন (১ম বার)</p>
                        <p class="text-[11px] text-gray-400">নাম, পিতা-মাতা, জন্মতারিখ</p>
                    </div>
                    <span class="font-mono font-bold text-emerald-600 text-base">৳ ২৩০</span>
                </div>
                <div class="p-3 bg-gray-50 rounded-xl flex items-center justify-between">
                    <div>
                        <p class="font-bold text-gray-900">অন্যান্য তথ্য সংশোধন (ঠিকানা ইত্যাদি)</p>
                        <p class="text-[11px] text-gray-400">রক্তের গ্রুপ, ঠিকানা</p>
                    </div>
                    <span class="font-mono font-bold text-emerald-600 text-base">৳ ১১৫</span>
                </div>
                <div class="p-3 bg-gray-50 rounded-xl flex items-center justify-between">
                    <div>
                        <p class="font-bold text-gray-900">হারানো NID রি-ইস্যু (সাধারণ)</p>
                        <p class="text-[11px] text-gray-400">জিডি নম্বর আবশ্যক</p>
                    </div>
                    <span class="font-mono font-bold text-emerald-600 text-base">৳ ৩৪৫</span>
                </div>
                <div class="p-3 bg-gray-50 rounded-xl flex items-center justify-between">
                    <div>
                        <p class="font-bold text-gray-900">হারানো NID রি-ইস্যু (জরুরি)</p>
                        <p class="text-[11px] text-gray-400">দ্রুত প্রিন্ট ও ডাউনলোড</p>
                    </div>
                    <span class="font-mono font-bold text-emerald-600 text-base">৳ ৫৭৫</span>
                </div>
            </div>
            <p class="text-[11px] text-gray-400 mt-2">* ফি বিকাশ বা রকেটের মাধ্যমে সরাসরি পরিশোধ করা যায়।</p>
        </div>

    </div>

    {{-- Birth Registration Guide --}}
    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-3xl p-6 sm:p-10 shadow-lg mb-12">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-white/20 backdrop-blur-md text-white border border-white/30 mb-3">
                <i class="fa-solid fa-certificate"></i>
                <span>{{ $isBn ? 'জন্ম নিবন্ধন অনলাইন যাচাই (BDRIS)' : 'Online Birth Certificate (BDRIS)' }}</span>
            </div>
            <h3 class="text-2xl font-black mb-3">
                {{ $isBn ? 'আপনার জন্ম সনদ কি অনলাইনে আছে? সহজেই চেক করুন' : 'Verify Your 17-Digit Birth Certificate Online' }}
            </h3>
            <p class="text-xs sm:text-sm text-white/90 leading-relaxed mb-6">
                {{ $isBn
                    ? 'সরকারি পোর্টাল everify.bdris.gov.bd-এ ১৭ সংখ্যার জন্ম নিবন্ধন নম্বর এবং জন্ম তারিখ (YYYY-MM-DD) দিলে সাথে সাথেই আপনার ডিজিটাল রেকর্ড দেখা যাবে।'
                    : 'Enter your 17-digit birth registration number and date of birth at everify.bdris.gov.bd to verify online record authenticity.' }}
            </p>
            <div class="flex flex-wrap items-center gap-3">
                <a href="https://everify.bdris.gov.bd/" target="_blank" rel="noopener noreferrer"
                   class="px-5 py-2.5 rounded-xl bg-white text-emerald-800 font-bold text-xs hover:bg-emerald-50 transition-colors shadow-xs flex items-center gap-2">
                    <span>{{ $isBn ? 'জন্ম নিবন্ধন ভেরিফাই করুন' : 'Verify Certificate' }}</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                </a>
                <a href="https://services.nidw.gov.bd/" target="_blank" rel="noopener noreferrer"
                   class="px-5 py-2.5 rounded-xl bg-emerald-700/80 hover:bg-emerald-800 text-white font-bold text-xs transition-colors flex items-center gap-2 border border-white/20">
                    <span>{{ $isBn ? 'নির্বাচন কমিশন NID পোর্টাল' : 'NID Citizen Portal' }}</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Lost NID GD Callout --}}
    <div class="bg-gray-50 border border-gray-200 rounded-3xl p-6 sm:p-8 flex flex-col sm:flex-row items-center justify-between gap-6">
        <div>
            <h4 class="text-base font-bold text-gray-900 mb-1">
                {{ $isBn ? 'জাতীয় পরিচয়পত্র হারিয়ে গেছে? এখনই জিডি ড্রাফট করুন' : 'Lost Your NID? Download Ready GD Draft' }}
            </h4>
            <p class="text-xs text-gray-600">
                {{ $isBn ? 'থানায় সাধারণ ডায়েরি (GD) করার জন্য রেডিমেড বাংলা ফরম্যাট এক ক্লিকেই কপি বা প্রিন্ট করুন।' : 'Copy or print ready-to-use Police GD draft format for lost NID in one click.' }}
            </p>
        </div>
        <a href="{{ route('citizen.applications', ['locale' => $locale]) }}"
           class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs transition-colors flex-shrink-0">
            {{ $isBn ? 'জিডি ফরম্যাট দেখুন' : 'View GD Draft' }}
        </a>
    </div>

</div>
@endsection
