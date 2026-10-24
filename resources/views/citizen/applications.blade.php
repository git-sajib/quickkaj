@extends('layouts.app')

@php
    $locale = app()->getLocale();
    $isBn   = $locale === 'bn';
@endphp

@section('page_title', ($isBn ? 'দরখাস্ত ও জিডি ড্রাফট ফরম্যাট ২০২৬ — ' . config('app.name', 'Quickkaj') : 'GD & Application Draft Templates — ' . config('app.name', 'Quickkaj')))
@section('seo_description', $isBn
    ? 'পাসপোর্ট, এনআইডি ও সার্টিফিকেট হারানোর জিডি দরখাস্ত এবং নাগরিকত্ব সনদের তৈরি বাংলা ফরম্যাট। এক ক্লিকেই কপি ও প্রিন্ট করুন।'
    : 'Ready-to-use official draft templates for lost passport, NID, academic certificates GD, and citizenship applications with 1-click copy.')

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "Article",
    "name": "{{ $isBn ? 'দরখাস্ত ও জিডি ড্রাফট ফরম্যাট' : 'GD and Application Draft Templates' }}",
    "description": "{{ $isBn ? 'পাসপোর্ট, এনআইডি ও সার্টিফিকেট হারানোর রেডিমেড দরখাস্ত।' : 'Ready templates for official applications.' }}",
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
        <a href="{{ route('citizen.index', ['locale' => $locale]) }}" class="hover:text-violet-600 transition-colors">
            <span>{{ $isBn ? 'নাগরিক সেবা' : 'Citizen Services' }}</span>
        </a>
        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
        <span class="text-gray-900 font-semibold">{{ $isBn ? 'দরখাস্ত ও জিডি ফরম্যাট' : 'Draft Templates' }}</span>
    </nav>

    {{-- Header --}}
    <div class="mb-10">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-violet-50 text-violet-700 border border-violet-200 mb-3">
            <i class="fa-solid fa-file-lines"></i>
            <span>{{ $isBn ? 'প্রয়োজনীয় আইনি ও অফিশিয়াল ড্রাফট' : 'Official Application Templates' }}</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-gray-900 tracking-tight mb-3">
            {{ $isBn ? 'দরখাস্ত ও জিডি (GD) প্রস্তুত ফরম্যাট' : 'Ready Application & GD Drafts' }}
        </h1>
        <p class="text-sm text-gray-600 leading-relaxed">
            {{ $isBn
                ? 'পাসপোর্ট, এনআইডি বা সার্টিফিকেট হারিয়ে গেলে থানায় ডায়েরি (GD) করার জন্য নিচের ড্রাফটগুলো ব্যবহার করুন। খালি জায়গা পূরণ করে ১-ক্লিকেই কপি বা প্রিন্ট করতে পারবেন।'
                : 'Copy or print ready-made Bengali drafts for lost NID, passport, certificates GD, and local municipal citizenship requests.' }}
        </p>
    </div>

    {{-- Draft 1: Lost NID GD --}}
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 mb-4 border-b border-gray-100">
            <div class="flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-xl bg-blue-100 text-blue-600 font-bold flex items-center justify-center text-xs">১</span>
                <h2 class="text-base sm:text-lg font-bold text-gray-900">জাতীয় পরিচয়পত্র (NID) হারানোর জিডি আবেদন</h2>
            </div>
            <button type="button" onclick="copyTemplate('tpl-nid', this)"
                    class="px-4 py-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-xs flex items-center gap-2 transition-colors self-start sm:self-auto">
                <i class="fa-regular fa-copy"></i>
                <span>টেক্সট কপি করুন</span>
            </button>
        </div>
        <div id="tpl-nid" class="bg-gray-50/80 rounded-2xl p-5 text-xs sm:text-sm text-gray-800 leading-relaxed font-sans border border-gray-200/60 whitespace-pre-line">
বরাবর,
ভারপ্রাপ্ত কর্মকর্তা (ওসি)
[ থানার নাম ], [ জেলার নাম ]।

বিষয়: জাতীয় পরিচয়পত্র হারানোর বিষয়ে সাধারণ ডায়েরি (জিডি) করার আবেদন।

জনাব,
বিনীত নিবেদন এই যে, আমি নিম্ন স্বাক্ষরকারী [ আপনার নাম ], পিতা: [ পিতার নাম ], মাতা: [ মাতার নাম ], বর্তমান ঠিকানা: [ আপনার বর্তমান ঠিকানা ], স্থায়ী ঠিকানা: [ আপনার স্থায়ী ঠিকানা ], এই মর্মে জানাচ্ছি যে, গত [ তারিখ ] আনুমানিক [ সময় ] ঘটিকায় [ যে এলাকা থেকে হারিয়েছে, যেমন: ফার্মগেট বাসস্ট্যান্ড ] এলাকায় আমার জাতীয় পরিচয়পত্রটি (NID) অনিচ্ছাকৃতভাবে হারিয়ে যায়। অনেক খোঁজাখুঁজি করেও তা পাওয়া যায়নি।

উক্ত জাতীয় পরিচয়পত্রের প্রয়োজনীয় তথ্য নিম্নরূপ:
১. জাতীয় পরিচয়পত্র নম্বর: [ আপনার NID নম্বর ]
২. কার্ডধারীর নাম: [ আপনার নাম ]
৩. জন্ম তারিখ: [ আপনার জন্ম তারিখ ]

এমতাবস্থায়, ভবিষ্যতে উক্ত জাতীয় পরিচয়পত্রের কোনো অপব্যবহার রোধকল্পে বিষয়টি আপনার থানায় সাধারণ ডায়েরিভুক্ত (GD) করার বিনীত অনুরোধ জানাচ্ছি।

বিনীত নিবেদক,
নাম: [ আপনার নাম ]
মোবাইল: [ আপনার মোবাইল নম্বর ]
তারিখ: [ আজকের তারিখ ]
        </div>
    </div>

    {{-- Draft 2: Lost Passport GD --}}
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 mb-4 border-b border-gray-100">
            <div class="flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-xl bg-amber-100 text-amber-600 font-bold flex items-center justify-center text-xs">২</span>
                <h2 class="text-base sm:text-lg font-bold text-gray-900">পাসপোর্ট হারানোর জিডি আবেদন</h2>
            </div>
            <button type="button" onclick="copyTemplate('tpl-pass', this)"
                    class="px-4 py-2 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold text-xs flex items-center gap-2 transition-colors self-start sm:self-auto">
                <i class="fa-regular fa-copy"></i>
                <span>টেক্সট কপি করুন</span>
            </button>
        </div>
        <div id="tpl-pass" class="bg-gray-50/80 rounded-2xl p-5 text-xs sm:text-sm text-gray-800 leading-relaxed font-sans border border-gray-200/60 whitespace-pre-line">
বরাবর,
ভারপ্রাপ্ত কর্মকর্তা (ওসি)
[ থানার নাম ], [ জেলার নাম ]।

বিষয়: পাসপোর্ট হারানোর বিষয়ে সাধারণ ডায়েরি (জিডি) করার আবেদন।

জনাব,
বিনীত নিবেদন এই যে, আমি [ আপনার নাম ], পিতা: [ পিতার নাম ], মাতা: [ মাতার নাম ], পাসপোর্ট নম্বর: [ আপনার পাসপোর্ট নম্বর ], এই মর্মে অবগত করছি যে, গত [ তারিখ ] তারিখে [ স্থান বা ভ্রমণের পথ ] এলাকা দিয়ে যাওয়ার সময় আমার উক্ত পাসপোর্টটি অসাবধানতাবশত হারিয়ে যায়। তাৎক্ষণিকভাবে আশপাশে সন্ধান করেও পাওয়া যায়নি।

এমতাবস্থায়, জরুরি প্রয়োজনে নতুন পাসপোর্ট রি-ইস্যু আবেদন এবং হারানো পাসপোর্টের সুরক্ষা নিশ্চিত করতে বিষয়টি সাধারণ ডায়েরিভুক্ত করতে আপনার সদয় মর্জি কামনা করছি।

বিনীত নিবেদক,
নাম: [ আপনার নাম ]
পাসপোর্ট নম্বর: [ নম্বর ]
মোবাইল: [ মোবাইল নম্বর ]
তারিখ: [ তারিখ ]
        </div>
    </div>

    {{-- Draft 3: Academic Certificate Lost --}}
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 mb-4 border-b border-gray-100">
            <div class="flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 font-bold flex items-center justify-center text-xs">৩</span>
                <h2 class="text-base sm:text-lg font-bold text-gray-900">মূল সার্টিফিকেট হারানোর জিডি আবেদন</h2>
            </div>
            <button type="button" onclick="copyTemplate('tpl-cert', this)"
                    class="px-4 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold text-xs flex items-center gap-2 transition-colors self-start sm:self-auto">
                <i class="fa-regular fa-copy"></i>
                <span>টেক্সট কপি করুন</span>
            </button>
        </div>
        <div id="tpl-cert" class="bg-gray-50/80 rounded-2xl p-5 text-xs sm:text-sm text-gray-800 leading-relaxed font-sans border border-gray-200/60 whitespace-pre-line">
বরাবর,
ভারপ্রাপ্ত কর্মকর্তা (ওসি)
[ থানার নাম ], [ জেলার নাম ]।

বিষয়: এসএসসি/এইচএসসি মূল সার্টিফিকেট হারানোর সাধারণ ডায়েরি করার আবেদন।

জনাব,
বিনীত নিবেদন এই যে, আমি [ আপনার নাম ], রোল: [ রোল ], রেজিস্ট্রেশন: [ রেজি নম্বর ], সেশন: [ সেশন ], শিক্ষা বোর্ড: [ বোর্ডের নাম ], এই মর্মে জানাচ্ছি যে, গত [ তারিখ ] তারিখে বাসা পরিবর্তনের সময় আমার মূল একাডেমিক সার্টিফিকেট সংবলিত ফাইলটি হারিয়ে যায়।

উক্ত সার্টিফিকেটের দ্বিতীয় কপি উত্তোলনের জন্য সংশ্লিষ্ট শিক্ষা বোর্ডে আবেদনের উদ্দেশ্যে একটি জিডি নম্বর আবশ্যক। অতএব, আবেদনটি থানায় সাধারণ ডায়েরিভুক্ত করে প্রয়োজনীয় ব্যবস্থা গ্রহণে কৃতজ্ঞ করবেন।

বিনীত,
নাম: [ আপনার নাম ]
মোবাইল: [ মোবাইল ]
তারিখ: [ তারিখ ]
        </div>
    </div>

    {{-- Draft 4: Municipal Citizenship Application --}}
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 mb-4 border-b border-gray-100">
            <div class="flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-xl bg-violet-100 text-violet-600 font-bold flex items-center justify-center text-xs">৪</span>
                <h2 class="text-base sm:text-lg font-bold text-gray-900">চেয়ারম্যান/কাউন্সিলর নাগরিকত্ব ও চারিত্রিক সনদের আবেদন</h2>
            </div>
            <button type="button" onclick="copyTemplate('tpl-citizen', this)"
                    class="px-4 py-2 rounded-xl bg-violet-50 hover:bg-violet-100 text-violet-700 font-bold text-xs flex items-center gap-2 transition-colors self-start sm:self-auto">
                <i class="fa-regular fa-copy"></i>
                <span>টেক্সট কপি করুন</span>
            </button>
        </div>
        <div id="tpl-citizen" class="bg-gray-50/80 rounded-2xl p-5 text-xs sm:text-sm text-gray-800 leading-relaxed font-sans border border-gray-200/60 whitespace-pre-line">
বরাবর,
মেয়র / কাউন্সিলর / ইউনিয়ন পরিষদ চেয়ারম্যান
[ ওয়ার্ড নং / ইউনিয়ন পরিষদ নাম ], [ উপজেলা / থানা ], [ জেলা ]।

বিষয়: নাগরিকত্ব ও চারিত্রিক সনদপত্র প্রদানের জন্য আবেদন।

জনাব,
যথাবিহিত সম্মান প্রদর্শনপূর্বক বিনীত নিবেদন এই যে, আমি আপনার ওয়ার্ডের/ইউনিয়নের [ গ্রাম / মহল্লার নাম ]-এর একজন স্থায়ী বাসিন্দা। আমার নাম [ আপনার নাম ], পিতা: [ পিতার নাম ], মাতা: [ মাতার নাম ]। 

আমার চাকরির আবেদন / পাসপোর্ট / শিক্ষা প্রতিষ্ঠানে ভর্তির জন্য একটি নাগরিকত্ব ও চারিত্রিক সনদপত্র একান্ত প্রয়োজন। আমি বাংলাদেশের একজন জন্মসূত্রে নাগরিক এবং আমি কখনোই কোনো রাষ্ট্রবিরোধী বা অনৈতিক কর্মকাণ্ডে জড়িত ছিলাম না।

অতএব, বিনীত প্রার্থনা এই যে, উপরোক্ত তথ্যের আলোকে আমাকে একটি নাগরিকত্ব ও চারিত্রিক সনদপত্র প্রদানে আপনার সদয় মর্জি কামনা করছি।

সংযুক্তি:
১. জাতীয় পরিচয়পত্র / জন্ম নিবন্ধনের ফটোকপি
২. পাসপোর্ট সাইজের ২ কপি ছবি

বিনীত নিবেদক,
[ আপনার স্বাক্ষর ও নাম ]
মোবাইল: [ নম্বর ]
তারিখ: [ তারিখ ]
        </div>
    </div>

</div>

<script>
function copyTemplate(id, btn) {
    const el = document.getElementById(id);
    if (!el) return;
    const text = el.innerText.trim();
    navigator.clipboard.writeText(text).then(() => {
        const span = btn.querySelector('span');
        const orig = span ? span.textContent : '';
        if (span) span.textContent = 'কপি হয়েছে!';
        btn.classList.add('bg-emerald-100', 'text-emerald-700');
        setTimeout(() => {
            if (span) span.textContent = orig;
            btn.classList.remove('bg-emerald-100', 'text-emerald-700');
        }, 2000);
    });
}
</script>
@endsection
