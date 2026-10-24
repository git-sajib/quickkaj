@extends('layouts.app')

@section('page_title', __('ui.site_name') . ' — ' . __('ui.site_tagline'))
@section('seo_description', __('ui.site_tagline'))

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@graph": [
        {
            "@@type": "WebSite",
            "@@id": "{{ url('/') }}#website",
            "url": "{{ url('/') }}",
            "name": "{{ config('app.name', 'Quickkaj') }}",
            "description": "{{ __('ui.site_tagline') }}",
            "inLanguage": "{{ app()->getLocale() === 'bn' ? 'bn-BD' : 'en-US' }}"
        },
        {
            "@@type": "Organization",
            "@@id": "{{ url('/') }}#organization",
            "name": "{{ config('app.name', 'Quickkaj') }}",
            "url": "{{ url('/') }}",
            "logo": {
                "@@type": "ImageObject",
                "url": "{{ asset('images/logo.png') }}"
            }
        }
    ]
}
</script>
@endsection

@section('content')

{{-- HERO SECTION (Compact Premium Multi-tonal Design) --}}
<section class="relative overflow-hidden bg-gradient-to-b from-slate-950 via-[#0a1226] to-slate-900 text-white py-8 sm:py-10 lg:py-11 border-b border-slate-800/80">
    {{-- Ambient Glows & Gradient Mesh --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-600/20 rounded-full blur-[100px]"></div>
        <div class="absolute top-0 -right-24 w-96 h-96 bg-violet-600/20 rounded-full blur-[100px]"></div>
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(rgba(255, 255, 255, 0.4) 1px, transparent 1px); background-size: 24px 24px;"></div>
    </div>

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        {{-- Main Headline --}}
        <h1 class="text-2xl sm:text-4xl lg:text-[40px] font-black tracking-tight leading-tight">
            <span>{{ __('ui.site_name') }} —</span>
            <span class="bg-gradient-to-r from-blue-400 via-indigo-300 to-teal-300 bg-clip-text text-transparent">
                {{ app()->getLocale() === 'bn' ? 'স্মার্ট ক্যারিয়ার, সংবাদ ও অনলাইন টুলস' : 'Smart Career, Breaking News & Online Tools' }}
            </span>
        </h1>

        <p class="text-slate-300 text-xs sm:text-sm max-w-lg mx-auto mt-2 leading-relaxed">
            {{ app()->getLocale() === 'bn' 
                ? 'চাকরির সার্কুলার, সর্বশেষ সংবাদ ও দরকারি ডিজিটাল টুলস—সব এক প্ল্যাটফর্মে।' 
                : __('ui.site_tagline') }}
        </p>

        {{-- Sleek Action Buttons & Universal Quick Search --}}
        <div class="flex flex-wrap items-center justify-center gap-2.5 sm:gap-3 mt-5">
            <a href="{{ route('jobs.index', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-semibold text-xs sm:text-sm transition-all shadow-md shadow-blue-600/25">
                <i class="fa-solid fa-briefcase text-xs"></i>
                <span>{{ __('ui.jobs') }}</span>
            </a>
            <a href="{{ route('articles.index', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-800/80 hover:bg-slate-700/80 text-slate-200 border border-slate-700 font-semibold text-xs sm:text-sm transition-all backdrop-blur-sm">
                <i class="fa-solid fa-newspaper text-indigo-400 text-xs"></i>
                <span>{{ __('ui.news') }}</span>
            </a>
            <a href="{{ route('tools.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-violet-600/20 hover:bg-violet-600/35 text-violet-300 border border-violet-500/30 font-semibold text-xs sm:text-sm transition-all backdrop-blur-sm">
                <i class="fa-solid fa-toolbox text-violet-400 text-xs"></i>
                <span>{{ __('ui.tools') }}</span>
            </a>
            <button type="button" onclick="window.openQuickSearch()" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-slate-800/60 hover:bg-slate-700/80 text-slate-300 hover:text-white border border-slate-700/80 font-medium text-xs sm:text-sm transition-all backdrop-blur-sm group">
                <i class="fa-solid fa-magnifying-glass text-slate-400 group-hover:text-blue-400 text-xs transition-colors"></i>
                <span>{{ app()->getLocale() === 'bn' ? 'কুইক সার্চ' : 'Quick Search' }}</span>
                <span class="hidden sm:inline-block text-[10px] bg-slate-900/90 text-slate-400 px-1.5 py-0.5 rounded border border-slate-700 font-mono">⌘K</span>
            </button>
        </div>

        {{-- Inline Quick Stats Chips (Compact Row) --}}
        @php
            $statsData = [
                ['number' => \App\Models\Job::active()->count(), 'label' => app()->getLocale() === 'bn' ? 'সক্রিয় চাকরি' : 'Jobs', 'icon' => 'fa-solid fa-briefcase', 'color' => 'text-emerald-400'],
                ['number' => \App\Models\Article::published()->count(), 'label' => app()->getLocale() === 'bn' ? 'সংবাদ' : 'News', 'icon' => 'fa-solid fa-newspaper', 'color' => 'text-blue-400'],
                ['number' => '18+', 'label' => app()->getLocale() === 'bn' ? 'ফ্রি টুলস' : 'Free Tools', 'icon' => 'fa-solid fa-toolbox', 'color' => 'text-violet-400'],
                ['number' => \App\Models\ShortUrl::sum('clicks'), 'label' => app()->getLocale() === 'bn' ? 'ক্লিক' : 'Clicks', 'icon' => 'fa-solid fa-chart-line', 'color' => 'text-amber-400'],
            ];
        @endphp
        <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3 mt-4 text-[11px] sm:text-xs">
            @foreach($statsData as $stat)
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-900/70 border border-slate-800 text-slate-300">
                    <i class="{{ $stat['icon'] }} {{ $stat['color'] }} text-[10px]"></i>
                    <span class="font-bold text-white">{{ $stat['number'] }}</span>
                    <span class="text-slate-400">{{ $stat['label'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- OUR SERVICES CAROUSEL (আমাদের সেবাসমূহ) --}}
@include('partials.services-carousel')

{{-- FEATURED JOBS --}}
@if($featuredJobs->count() > 0)
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10">
            <div>
                <h2 class="section-header">{{ __('ui.jobs_title') }}</h2>
                <p class="section-subtitle">{{ __('ui.jobs_subtitle') }}</p>
                <div class="section-divider"></div>
            </div>
            <a href="{{ route('jobs.index', ['locale' => app()->getLocale()]) }}" class="btn-secondary hidden sm:inline-flex items-center gap-1.5">
                <span>{{ __('ui.view_all') }}</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featuredJobs as $job)
                <article class="job-card group">
                    <div class="card-body flex-1 flex flex-col">
                        {{-- Status badge --}}
                        <div class="flex items-center justify-between mb-3">
                            @if($job->isExpired())
                                <span class="job-badge-expired">{{ __('ui.job_expired') }}</span>
                            @else
                                <span class="job-badge"><i class="fa-solid fa-circle-check text-xs"></i> {{ app()->getLocale() === 'bn' ? 'চলমান' : 'Active' }}</span>
                            @endif
                            @if($job->deadline)
                                <span class="text-xs text-gray-400">{{ __('ui.deadline') }}: {{ $job->deadline->format('d M Y') }}</span>
                            @endif
                        </div>

                        {{-- Title --}}
                        <h3 class="font-bold text-gray-900 text-base leading-snug group-hover:text-blue-600 transition-colors mb-2">
                            <a href="{{ route('jobs.show', ['locale' => app()->getLocale(), 'slug' => $job->slug]) }}">
                                {{ $job->getTitle() }}
                            </a>
                        </h3>

                        {{-- Meta --}}
                        <div class="flex flex-col gap-1 text-xs text-gray-500 mb-4">
                            @if($job->employer_bn || $job->employer_en)
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    {{ $job->getEmployer() }}
                                </div>
                            @endif
                            @if($job->location_bn || $job->location_en)
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                    {{ $job->getLocation() }}
                                </div>
                            @endif
                        </div>

                        {{-- Footer --}}
                        <div class="mt-auto flex items-center justify-between">
                            <a href="{{ route('jobs.show', ['locale' => app()->getLocale(), 'slug' => $job->slug]) }}"
                               class="text-blue-600 hover:text-blue-800 font-semibold text-xs transition-colors inline-flex items-center gap-1">
                                <span>{{ __('ui.read_more') }}</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                            @if($job->application_url && !$job->isExpired())
                                <a href="{{ $job->application_url }}" target="_blank" rel="noopener noreferrer"
                                   class="btn-primary btn-sm">{{ __('ui.apply_now') }}</a>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="text-center mt-8 sm:hidden">
            <a href="{{ route('jobs.index', ['locale' => app()->getLocale()]) }}" class="btn-primary">{{ __('ui.view_all') }}</a>
        </div>
    </div>
</section>
@endif

{{-- TOOLS SHOWCASE (Curated Top 12 Tools with Category Filters) --}}
@php
    $isBn = app()->getLocale() === 'bn';
    $showcaseTools = [
        [
            'cats'      => 'career popular',
            'icon'      => 'fa-solid fa-file-invoice',
            'bg'        => 'bg-blue-50 text-blue-600',
            'badge'     => 'Hot',
            'badge_cls' => 'bg-rose-50 text-rose-600 border border-rose-200/80',
            'name'      => $isBn ? 'ফ্রি CV বিল্ডার' : 'Free CV Builder',
            'desc'      => $isBn ? '৩টি প্রফেশনাল রেজুমে টেমপ্লেট — সরাসরি PDF হিসেবে ডাউনলোড' : '3 professional resume templates — instant PDF download',
            'route'     => 'tools.cv-builder',
            'action'    => $isBn ? 'সিভি তৈরি করুন' : 'Create CV',
        ],
        [
            'cats'      => 'pdf popular',
            'icon'      => 'fa-solid fa-file-pdf',
            'bg'        => 'bg-rose-50 text-rose-600',
            'badge'     => 'Hot',
            'badge_cls' => 'bg-rose-50 text-rose-600 border border-rose-200/80',
            'name'      => $isBn ? 'Merge ও Split PDF' : 'Merge & Split PDF',
            'desc'      => $isBn ? 'একাধিক PDF মার্জ, পৃষ্ঠা আলাদা ও ৯০° ঘুরিয়ে সেভ করুন' : 'Combine PDFs, extract pages & rotate orientation',
            'route'     => 'tools.pdf-tools',
            'action'    => $isBn ? 'PDF মার্জ করুন' : 'Merge PDF',
        ],
        [
            'cats'      => 'image career popular',
            'icon'      => 'fa-solid fa-crop-simple',
            'bg'        => 'bg-teal-50 text-teal-600',
            'badge'     => '300×300',
            'badge_cls' => 'bg-amber-50 text-amber-700 border border-amber-200/80',
            'name'      => $isBn ? 'চাকরির ছবি ও স্বাক্ষর রিসাইজ' : 'Job Photo & Sign Resizer',
            'desc'      => $isBn ? 'টেলিটক ও সরকারি চাকরির ৩০০×৩০০ ছবি এবং ৩০০×৮০ স্বাক্ষর ক্রপ' : '300x300 photo & 300x80 signature crop with KB limiter',
            'route'     => 'tools.image-resizer',
            'action'    => $isBn ? 'ছবি রিসাইজ করুন' : 'Resize Photo',
        ],
        [
            'cats'      => 'image popular',
            'icon'      => 'fa-solid fa-wand-magic-sparkles',
            'bg'        => 'bg-violet-50 text-violet-600',
            'badge'     => 'New',
            'badge_cls' => 'bg-violet-50 text-violet-600 border border-violet-200/80',
            'name'      => $isBn ? 'ব্যাকগ্রাউন্ড রিমুভার' : 'Background Remover',
            'desc'      => $isBn ? 'ছবির ব্যাকগ্রাউন্ড মুছে স্বচ্ছ বা পাসপোর্ট সাইজ নীল/সাদা করুন' : 'Remove background, make transparent or passport blue',
            'route'     => 'tools.background-remover',
            'action'    => $isBn ? 'ব্যাকগ্রাউন্ড মুছুন' : 'Remove BG',
        ],
        [
            'cats'      => 'calculator career popular',
            'icon'      => 'fa-solid fa-cake-candles',
            'bg'        => 'bg-emerald-50 text-emerald-600',
            'badge'     => 'Popular',
            'badge_cls' => 'bg-emerald-50 text-emerald-700 border border-emerald-200/80',
            'name'      => $isBn ? 'চাকরির বয়স ক্যালকুলেটর' : 'Age Calculator for Jobs',
            'desc'      => $isBn ? 'বিজ্ঞপ্তির তারিখে সঠিক বয়স বছর, মাস ও দিনে নির্ভুল বের করুন' : 'Calculate exact age in years, months & days for circulars',
            'route'     => 'tools.age-calculator',
            'action'    => $isBn ? 'বয়স হিসাব করুন' : 'Calculate Age',
        ],
        [
            'cats'      => 'calculator popular',
            'icon'      => 'fa-solid fa-graduation-cap',
            'bg'        => 'bg-indigo-50 text-indigo-600',
            'badge'     => '4.0 / 5.0',
            'badge_cls' => 'bg-indigo-50 text-indigo-700 border border-indigo-200/80',
            'name'      => $isBn ? 'CGPA ক্যালকুলেটর' : 'CGPA Calculator',
            'desc'      => $isBn ? 'বিশ্ববিদ্যালয় ও জাতীয় বিশ্ববিদ্যালয়ের সঠিক সিজিপিএ হিসাব' : '4.0 & 5.0 scale semester and cumulative GPA calculator',
            'route'     => 'tools.cgpa-calculator',
            'action'    => $isBn ? 'CGPA বের করুন' : 'Calculate GPA',
        ],
        [
            'cats'      => 'image',
            'icon'      => 'fa-solid fa-compress',
            'bg'        => 'bg-blue-50 text-blue-600',
            'badge'     => 'Fast',
            'badge_cls' => 'bg-blue-50 text-blue-700 border border-blue-200/80',
            'name'      => $isBn ? 'ইমেজ কম্প্রেসার' : 'Image Compressor',
            'desc'      => $isBn ? 'ছবির মান ঠিক রেখে সাইজ ১০০KB-এর নিচে কমান ব্রাউজারেই' : 'Compress image KB size without losing visible quality',
            'route'     => 'tools.image-compressor',
            'action'    => $isBn ? 'সাইজ কমান' : 'Compress',
        ],
        [
            'cats'      => 'career popular',
            'icon'      => 'fa-solid fa-qrcode',
            'bg'        => 'bg-rose-50 text-rose-600',
            'badge'     => 'Custom',
            'badge_cls' => 'bg-gray-100 text-gray-700 border border-gray-200/80',
            'name'      => $isBn ? 'QR কোড জেনারেটর' : 'QR Code Generator',
            'desc'      => $isBn ? 'যেকোনো লিংক বা টেক্সটের কালারফুল QR কোড তৈরি করুন' : 'Generate stylish colored QR codes from any URL or text',
            'route'     => 'tools.qr-generator',
            'action'    => $isBn ? 'QR তৈরি করুন' : 'Generate QR',
        ],
        [
            'cats'      => 'calculator',
            'icon'      => 'fa-solid fa-bangladeshi-taka-sign',
            'bg'        => 'bg-orange-50 text-orange-600',
            'badge'     => 'NBR Tax',
            'badge_cls' => 'bg-orange-50 text-orange-700 border border-orange-200/80',
            'name'      => $isBn ? 'বেতন ও আয়কর ক্যালকুলেটর' : 'Salary & Tax Calculator',
            'desc'      => $isBn ? 'মাসিক মূল বেতন, বাড়িভাড়া ও আয়কর স্ল্যাব সহজে হিসাব করুন' : 'Monthly salary breakdown, allowances & NBR income tax',
            'route'     => 'tools.salary-calculator',
            'action'    => $isBn ? 'বেতন হিসাব' : 'Calculate Salary',
        ],
        [
            'cats'      => 'pdf image',
            'icon'      => 'fa-solid fa-images',
            'bg'        => 'bg-emerald-50 text-emerald-600',
            'badge'     => 'PDF',
            'badge_cls' => 'bg-emerald-50 text-emerald-700 border border-emerald-200/80',
            'name'      => $isBn ? 'JPG to PDF কনভার্টার' : 'JPG to PDF Converter',
            'desc'      => $isBn ? 'এক বা একাধিক ছবিকে ক্লিন সাজানো PDF ডকুমেন্টে রূপান্তর' : 'Convert multiple photos into a single clean PDF document',
            'route'     => 'tools.pdf-tools',
            'hash'      => '#jpg-to-pdf',
            'action'    => $isBn ? 'ছবি রূপান্তর' : 'Convert to PDF',
        ],
        [
            'cats'      => 'career',
            'icon'      => 'fa-solid fa-calculator',
            'bg'        => 'bg-violet-50 text-violet-600',
            'badge'     => 'Live',
            'badge_cls' => 'bg-violet-50 text-violet-700 border border-violet-200/80',
            'name'      => $isBn ? 'ওয়ার্ড ও ক্যারেক্টার কাউন্টার' : 'Word & Character Counter',
            'desc'      => $isBn ? 'বাংলা ও ইংরেজি টেক্সটের শব্দ, ক্যারেক্টার ও লাইন রিয়েল-টাইমে গণনা' : 'Real-time word, character, and line count for writers',
            'route'     => 'tools.word-counter',
            'action'    => $isBn ? 'গণনা করুন' : 'Count Words',
        ],
        [
            'cats'      => 'career popular',
            'icon'      => 'fa-solid fa-link',
            'bg'        => 'bg-amber-50 text-amber-600',
            'badge'     => 'Shorten',
            'badge_cls' => 'bg-amber-50 text-amber-700 border border-amber-200/80',
            'name'      => $isBn ? 'URL Shortener' : 'URL Shortener',
            'desc'      => $isBn ? 'বড় লিংক সহজে ছোট করুন এবং লাইভ ক্লিক অ্যানালিটিক্স দেখুন' : 'Shorten long links with live visit stats and QR support',
            'route'     => 'shorturl.index',
            'action'    => $isBn ? 'লিংক ছোট করুন' : 'Shorten Link',
        ],
    ];
@endphp

<section class="py-16 bg-gradient-to-b from-gray-50/80 via-white to-blue-50/30 border-y border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-8 gap-4">
            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 border border-blue-200/70 text-blue-700 mb-2">
                    <i class="fa-solid fa-toolbox text-blue-600 text-xs"></i>
                    <span>{{ $isBn ? 'ডিজিটাল টুলকিট' : 'Digital Toolkit' }}</span>
                </div>
                <h2 class="section-header text-gray-900">{{ __('ui.tools_title') }}</h2>
                <p class="section-subtitle">{{ $isBn ? 'কোনো সফটওয়্যার ইনস্টল ছাড়াই ব্রাউজারেই ব্যবহার করুন ১৮+ দরকারি টুলস।' : '18+ free browser-based digital utilities with 100% privacy and zero installation.' }}</p>
                <div class="section-divider"></div>
            </div>
            <a href="{{ route('tools.index') }}" class="btn-secondary hidden sm:inline-flex items-center gap-2 self-start md:self-end">
                <span>{{ $isBn ? 'সব ১৮টি টুলস দেখুন' : 'View All 18 Tools' }}</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        {{-- Filter Tabs (Pill Navigation) --}}
        <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-3 mb-6 -mx-4 px-4 sm:mx-0 sm:px-0">
            <button type="button" onclick="filterHomeTools('all', this)"
                    class="home-tool-tab px-4 py-2 rounded-full text-xs font-bold transition-all duration-200 whitespace-nowrap bg-blue-600 text-white shadow-xs">
                {{ $isBn ? 'সবগুলো (১৮+)' : 'All Tools (18+)' }}
            </button>
            <button type="button" onclick="filterHomeTools('popular', this)"
                    class="home-tool-tab px-4 py-2 rounded-full text-xs font-semibold transition-all duration-200 whitespace-nowrap bg-white text-gray-600 hover:bg-gray-100 border border-gray-200/80">
                <i class="fa-solid fa-fire text-amber-500 mr-1"></i>
                {{ $isBn ? 'জনপ্রিয় ও হট' : 'Popular & Hot' }}
            </button>
            <button type="button" onclick="filterHomeTools('career', this)"
                    class="home-tool-tab px-4 py-2 rounded-full text-xs font-semibold transition-all duration-200 whitespace-nowrap bg-white text-gray-600 hover:bg-gray-100 border border-gray-200/80">
                <i class="fa-solid fa-briefcase text-emerald-500 mr-1"></i>
                {{ $isBn ? 'চাকরি ও ক্যারিয়ার' : 'Career & Jobs' }}
            </button>
            <button type="button" onclick="filterHomeTools('pdf', this)"
                    class="home-tool-tab px-4 py-2 rounded-full text-xs font-semibold transition-all duration-200 whitespace-nowrap bg-white text-gray-600 hover:bg-gray-100 border border-gray-200/80">
                <i class="fa-solid fa-file-pdf text-rose-500 mr-1"></i>
                {{ $isBn ? 'ডকুমেন্ট ও PDF' : 'PDF & Docs' }}
            </button>
            <button type="button" onclick="filterHomeTools('image', this)"
                    class="home-tool-tab px-4 py-2 rounded-full text-xs font-semibold transition-all duration-200 whitespace-nowrap bg-white text-gray-600 hover:bg-gray-100 border border-gray-200/80">
                <i class="fa-solid fa-image text-violet-500 mr-1"></i>
                {{ $isBn ? 'ছবি ও এডিটর' : 'Photo & Image' }}
            </button>
            <button type="button" onclick="filterHomeTools('calculator', this)"
                    class="home-tool-tab px-4 py-2 rounded-full text-xs font-semibold transition-all duration-200 whitespace-nowrap bg-white text-gray-600 hover:bg-gray-100 border border-gray-200/80">
                <i class="fa-solid fa-calculator text-blue-500 mr-1"></i>
                {{ $isBn ? 'ক্যালকুলেটর' : 'Calculators' }}
            </button>
        </div>

        {{-- 12 Rich Tool Cards Grid --}}
        <div id="home-tools-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-5">
            @foreach($showcaseTools as $tool)
                <a href="{{ route($tool['route']) }}{{ $tool['hash'] ?? '' }}"
                   data-cats="{{ $tool['cats'] }}"
                   class="home-tool-card group relative bg-white rounded-2xl p-5 border border-gray-200/80 shadow-2xs hover:shadow-xl hover:border-blue-300 hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between block">
                    <div>
                        {{-- Top flex: Squircle Icon + Badge --}}
                        <div class="flex items-center justify-between mb-3.5">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center {{ $tool['bg'] }} text-lg group-hover:scale-110 transition-transform duration-200 shadow-2xs">
                                <i class="{{ $tool['icon'] }}"></i>
                            </div>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $tool['badge_cls'] }}">
                                {{ $tool['badge'] }}
                            </span>
                        </div>

                        {{-- Tool Title --}}
                        <h3 class="font-extrabold text-gray-900 text-sm sm:text-base leading-snug group-hover:text-blue-600 transition-colors mb-1.5">
                            {{ $tool['name'] }}
                        </h3>

                        {{-- Tool Description --}}
                        <p class="text-xs text-gray-500 leading-relaxed min-h-[36px]">
                            {{ $tool['desc'] }}
                        </p>
                    </div>

                    {{-- Bottom Action Link --}}
                    <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-xs font-semibold text-blue-600 group-hover:text-blue-700">
                        <span>{{ $tool['action'] }}</span>
                        <i class="fa-solid fa-arrow-right text-[11px] group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Bottom Banner (More tools available) --}}
        <div class="mt-10 rounded-2xl bg-gradient-to-r from-blue-600 via-indigo-600 to-violet-600 p-6 sm:p-7 text-white shadow-lg flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3.5 text-center sm:text-left">
                <div class="w-12 h-12 rounded-2xl bg-white/15 backdrop-blur-md flex items-center justify-center flex-shrink-0 text-xl border border-white/20">
                    <i class="fa-solid fa-toolbox"></i>
                </div>
                <div>
                    <h3 class="font-bold text-sm sm:text-base text-white">
                        {{ $isBn ? 'আরো ৬টি স্পেশালাইজড টুলস আমাদের ডিরেক্টরিতে রয়েছে' : 'Explore 6 More Specialized Digital Utilities' }}
                    </h3>
                    <p class="text-xs text-blue-100 mt-0.5">
                        {{ $isBn ? 'JSON Formatter, Password Generator, Unit Converter, BMI, Image Converter ও Case Converter সহ মোট ১৮টি টুল।' : 'Including JSON Formatter, Password Generator, Unit Converter, BMI & Case Converter.' }}
                    </p>
                </div>
            </div>
            <a href="{{ route('tools.index') }}" class="btn-white text-xs sm:text-sm px-5 py-2.5 rounded-xl font-bold whitespace-nowrap shadow-md hover:bg-blue-50 transition-colors">
                {{ $isBn ? 'সব ১৮টি টুলস দেখুন' : 'Browse All 18 Tools' }} →
            </a>
        </div>
    </div>
</section>

@push('scripts')
<script>
function filterHomeTools(category, btn) {
    document.querySelectorAll('.home-tool-tab').forEach(b => {
        b.classList.remove('bg-blue-600', 'text-white', 'shadow-xs');
        b.classList.add('bg-white', 'text-gray-600', 'hover:bg-gray-100');
    });
    btn.classList.add('bg-blue-600', 'text-white', 'shadow-xs');
    btn.classList.remove('bg-white', 'text-gray-600', 'hover:bg-gray-100');

    const cards = document.querySelectorAll('.home-tool-card');
    cards.forEach(card => {
        const cats = card.getAttribute('data-cats') || '';
        if (category === 'all' || cats.includes(category)) {
            card.classList.remove('hidden');
        } else {
            card.classList.add('hidden');
        }
    });
}
</script>
@endpush

{{-- LATEST ARTICLES --}}
@if($latestArticles->count() > 0)
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10">
            <div>
                <h2 class="section-header">{{ __('ui.articles_title') }}</h2>
                <p class="section-subtitle">{{ __('ui.articles_subtitle') }}</p>
                <div class="section-divider"></div>
            </div>
            <a href="{{ route('articles.index', ['locale' => app()->getLocale()]) }}" class="btn-secondary hidden sm:inline-flex">
                {{ __('ui.view_all') }} →
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($latestArticles as $article)
                <article class="article-card group">
                    {{-- Thumbnail --}}
                    <a href="{{ route('articles.show', ['locale' => app()->getLocale(), 'slug' => $article->slug]) }}" class="block overflow-hidden">
                    @if($article->featured_image)
                        <img src="{{ Storage::url($article->featured_image) }}"
                             alt="{{ $article->getTitle() }}"
                             class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <x-category-placeholder :category="$article->category" height="192px" />
                    @endif
                    </a>

                    <div class="card-body">
                        {{-- Category --}}
                        @if($article->category)
                            <span class="badge-blue mb-2 inline-block">{{ $article->category->getName() }}</span>
                        @endif

                        {{-- Title --}}
                        <h3 class="font-bold text-gray-900 text-base leading-snug group-hover:text-blue-600 transition-colors mb-2">
                            <a href="{{ route('articles.show', ['locale' => app()->getLocale(), 'slug' => $article->slug]) }}">
                                {{ $article->getTitle() }}
                            </a>
                        </h3>

                        {{-- Excerpt --}}
                        @if($article->excerpt_bn || $article->excerpt_en)
                            <p class="text-gray-500 text-xs line-clamp-2 mb-3">{{ $article->getExcerpt() }}</p>
                        @endif

                        {{-- Meta --}}
                        <div class="flex items-center justify-between text-xs text-gray-400">
                            <span>{{ $article->published_at?->diffForHumans() }}</span>
                            <a href="{{ route('articles.show', ['locale' => app()->getLocale(), 'slug' => $article->slug]) }}"
                               class="text-blue-600 hover:text-blue-800 font-semibold transition-colors inline-flex items-center gap-1">
                                <span>{{ __('ui.read_more') }}</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ALL-IN-ONE QUICK ACTION HUB (Career, Citizen Services & Resume Tools) --}}
@php
    $isBn = app()->getLocale() === 'bn';
    $locale = app()->getLocale();
@endphp
<section class="py-16 sm:py-20 bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950 text-white relative overflow-hidden">
    {{-- Background glowing accents --}}
    <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-blue-500/10 blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 rounded-full bg-emerald-500/10 blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- Section Header --}}
        <div class="text-center max-w-3xl mx-auto mb-12">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full text-xs font-semibold bg-white/10 backdrop-blur-md text-blue-200 border border-white/15 mb-3 shadow-2xs">
                <i class="fa-solid fa-compass text-amber-400"></i>
                <span>{{ $isBn ? 'আপনার প্রয়োজনীয় ডিজিটাল বাতায়ন' : 'All-in-One Digital Portal' }}</span>
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight leading-tight mb-3">
                {{ $isBn ? 'আপনার দৈনন্দিন সমাধান এক ছাদের নিচে' : 'Everything You Need in One Single Place' }}
            </h2>
            <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                {{ $isBn
                    ? 'চাকরির খোঁজ, সরকারি সেবা নির্দেশিকা বা প্রফেশনাল CV ও ডকুমেন্ট প্রসেসিং — আপনার পছন্দের সেবা বেছে নিন।'
                    : 'From latest verified job circulars to citizen guidelines and resume builders — choose your service.' }}
            </p>
        </div>

        {{-- 3 Quick Pillar Cards Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Pillar 1: Jobs & Career --}}
            <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-3xl p-6 sm:p-7 flex flex-col justify-between hover:bg-white/[0.08] hover:border-emerald-500/40 transition-all duration-300 group shadow-lg">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-300 bg-emerald-500/20 px-2.5 py-0.5 rounded-full border border-emerald-500/30">
                            {{ $isBn ? 'চাকরি ও ক্যারিয়ার' : 'Jobs & Careers' }}
                        </span>
                        <span class="text-[10px] text-slate-400 flex items-center gap-1">
                            <i class="fa-solid fa-circle text-[6px] text-emerald-400 animate-pulse"></i>
                            {{ $isBn ? 'প্রতিদিন আপডেট' : 'Daily' }}
                        </span>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-emerald-300 transition-colors">
                        {{ $isBn ? 'নতুন চাকরির সন্ধান করছেন?' : 'Looking for Jobs?' }}
                    </h3>
                    <p class="text-xs text-slate-300 leading-relaxed mb-6">
                        {{ $isBn
                            ? 'মন্ত্রণালয়, সরকারি অধিদপ্তর, ব্যাংক ও স্বনামধন্য বেসরকারি প্রতিষ্ঠানের শত শত যাচাইকৃত সার্কুলার ও অফিসিয়াল আবেদন লিংক।'
                            : 'Browse hundreds of verified government, banking, and private career opportunities.' }}
                    </p>
                </div>
                <a href="{{ route('jobs.index', ['locale' => $locale]) }}"
                   class="w-full text-center px-5 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs flex items-center justify-center gap-2 transition-colors shadow-md">
                    <span>{{ $isBn ? 'বিজ্ঞপ্তিগুলো দেখুন' : 'Explore All Jobs' }}</span>
                    <i class="fa-solid fa-arrow-right text-[11px] group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            {{-- Pillar 2: Citizen Services & Results --}}
            <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-3xl p-6 sm:p-7 flex flex-col justify-between hover:bg-white/[0.08] hover:border-amber-500/40 transition-all duration-300 group shadow-lg">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/20 text-amber-400 border border-amber-500/30 flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-landmark-flag"></i>
                    </div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-amber-300 bg-amber-500/20 px-2.5 py-0.5 rounded-full border border-amber-500/30">
                            {{ $isBn ? 'নাগরিক সেবা বাতায়ন' : 'Citizen Hub' }}
                        </span>
                        <span class="text-[10px] text-slate-400">
                            {{ $isBn ? 'জরুরি সেবা' : 'Verified' }}
                        </span>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-amber-300 transition-colors">
                        {{ $isBn ? 'নাগরিক সেবা বা রেজাল্ট দরকার?' : 'Need Citizen Services?' }}
                    </h3>
                    <p class="text-xs text-slate-300 leading-relaxed mb-6">
                        {{ $isBn
                            ? 'ই-পাসপোর্ট ফি, NID সংশোধন, বোর্ড পরীক্ষার রেজাল্ট এসএমএস কোড এবং রেডিমেড আইনি জিডি দরখাস্তের ড্রাফট।'
                            : 'E-Passport fees, NID corrections, SMS codes for board results, and ready-to-use GD templates.' }}
                    </p>
                </div>
                <a href="{{ route('citizen.index', ['locale' => $locale]) }}"
                   class="w-full text-center px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs flex items-center justify-center gap-2 transition-colors shadow-md">
                    <span>{{ $isBn ? 'নাগরিক সেবা ডিরেক্টরি' : 'Open Citizen Hub' }}</span>
                    <i class="fa-solid fa-arrow-right text-[11px] group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            {{-- Pillar 3: Free CV Builder & PDF Tools --}}
            <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-3xl p-6 sm:p-7 flex flex-col justify-between hover:bg-white/[0.08] hover:border-blue-500/40 transition-all duration-300 group shadow-lg">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-blue-500/20 text-blue-400 border border-blue-500/30 flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-file-invoice"></i>
                    </div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-blue-300 bg-blue-500/20 px-2.5 py-0.5 rounded-full border border-blue-500/30">
                            {{ $isBn ? 'ফ্রি টুলস' : 'Free Tools' }}
                        </span>
                        <span class="text-[10px] text-rose-400 font-bold">
                            {{ $isBn ? '১০০% ফ্রি' : '100% Free' }}
                        </span>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-blue-300 transition-colors">
                        {{ $isBn ? 'প্রফেশনাল CV ও ডকুমেন্ট দরকার?' : 'Need a Resume or PDF Tools?' }}
                    </h3>
                    <p class="text-xs text-slate-300 leading-relaxed mb-6">
                        {{ $isBn
                            ? 'মিনিটেই আধুনিক রেজুমে তৈরি করুন, চাকরির ৩০০×৩০০ ছবি রিসাইজ করুন এবং আনলিমিটেড PDF ফাইল মার্জ করুন।'
                            : 'Build sleek modern resumes, crop 300x300 photos for circulars, and merge PDF files in seconds.' }}
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('tools.cv-builder') }}"
                       class="flex-1 text-center px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs transition-colors shadow-md">
                        {{ $isBn ? 'ফ্রি CV বানান' : 'Create CV' }}
                    </a>
                    <a href="{{ route('tools.index') }}"
                       class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 text-white font-bold text-xs transition-colors">
                        {{ $isBn ? 'সব টুলস' : 'All Tools' }}
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
