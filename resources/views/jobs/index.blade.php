@extends('layouts.app')

@section('page_title', __('ui.jobs_title') . ' — ' . __('ui.site_name'))
@section('seo_description', __('ui.jobs_subtitle'))

@section('content')
@php
    $locale = app()->getLocale();
    $isBn = $locale === 'bn';
    $hasActiveFilters = !empty($filters['q']) || !empty($filters['category']) || !empty($filters['location']) || !empty($filters['employment_type']) || !empty($filters['education_level']) || !empty($filters['deadline_within']);
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-10">

    {{-- Page Header & Hero Search --}}
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6">
            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100 mb-2">
                    <i class="fa-solid fa-briefcase text-blue-600"></i>
                    <span>{{ $isBn ? 'চাকরি পোর্টাল' : 'Job Portal' }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-gray-900 tracking-tight">{{ __('ui.jobs_title') }}</h1>
                <p class="text-gray-500 text-sm mt-1">{{ __('ui.jobs_subtitle') }}</p>
            </div>

            {{-- Saved jobs link for logged-in or guest --}}
            @auth
                <a href="{{ route('jobs.saved', ['locale' => $locale]) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold bg-amber-50 text-amber-800 border border-amber-200 hover:bg-amber-100 transition-colors shrink-0">
                    <i class="fa-solid fa-bookmark text-amber-600"></i>
                    <span>{{ $isBn ? 'সংরক্ষিত চাকরি' : 'Saved Jobs' }}</span>
                    @if(auth()->user()->savedJobs()->count() > 0)
                        <span class="w-5 h-5 rounded-full bg-amber-600 text-white text-xs flex items-center justify-center font-bold">
                            {{ auth()->user()->savedJobs()->count() }}
                        </span>
                    @endif
                </a>
            @endauth
        </div>

        {{-- Unified Hero Search Box --}}
        <form method="GET" action="{{ route('jobs.index', ['locale' => $locale]) }}" class="bg-white p-2.5 sm:p-3 rounded-2xl border border-gray-200 shadow-sm focus-within:ring-2 focus-within:ring-blue-500 transition-all">
            <div class="flex flex-col sm:flex-row items-stretch gap-2">
                {{-- Search Keyword Input --}}
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-magnifying-glass text-sm"></i>
                    </div>
                    <input type="text" name="q" value="{{ $filters['q'] ?? '' }}"
                           placeholder="{{ $isBn ? 'পদের নাম, কোম্পানি বা দক্ষতা খুঁজুন...' : 'Job title, employer, skill...' }}"
                           class="w-full pl-10 pr-3 py-2.5 text-sm rounded-xl border-0 focus:ring-0 text-gray-900 placeholder-gray-400">
                </div>

                <div class="hidden sm:block w-px bg-gray-200 self-stretch my-1"></div>

                {{-- Location Input --}}
                <div class="relative sm:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-location-dot text-sm"></i>
                    </div>
                    <input type="text" name="location" value="{{ $filters['location'] ?? '' }}"
                           placeholder="{{ $isBn ? 'স্থান (যেমন: ঢাকা)' : 'Location (e.g. Dhaka)' }}"
                           class="w-full pl-10 pr-3 py-2.5 text-sm rounded-xl border-0 focus:ring-0 text-gray-900 placeholder-gray-400">
                </div>

                {{-- Preserve Category if already chosen --}}
                @if(!empty($filters['category']))
                    <input type="hidden" name="category" value="{{ $filters['category'] }}">
                @endif
                @if(!empty($filters['employment_type']))
                    <input type="hidden" name="employment_type" value="{{ $filters['employment_type'] }}">
                @endif

                {{-- Search Buttons --}}
                <div class="flex items-center gap-2">
                    <button type="submit" class="btn-primary flex-1 sm:flex-initial px-6 py-2.5 text-sm font-semibold shadow-sm">
                        <i class="fa-solid fa-magnifying-glass mr-1.5"></i>
                        <span>{{ $isBn ? 'খুঁজুন' : 'Search' }}</span>
                    </button>
                    @if($hasActiveFilters)
                        <a href="{{ route('jobs.index', ['locale' => $locale]) }}"
                           class="px-3.5 py-2.5 rounded-xl border border-gray-200 text-gray-500 hover:text-red-600 hover:bg-red-50 text-sm font-medium transition-colors"
                           title="{{ $isBn ? 'ফিল্টার পরিষ্কার করুন' : 'Clear filters' }}">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>

        {{-- Quick Category Pills --}}
        @if($categories->count() > 0)
            <div class="flex items-center gap-2 overflow-x-auto py-3 no-scrollbar text-xs">
                <span class="text-gray-400 font-semibold shrink-0">{{ $isBn ? 'জনপ্রিয় বিভাগ:' : 'Popular:' }}</span>
                <a href="{{ route('jobs.index', array_merge(request()->except('category', 'page'), ['locale' => $locale])) }}"
                   class="px-3 py-1.5 rounded-full shrink-0 transition-colors {{ empty($filters['category']) ? 'bg-blue-600 text-white font-medium shadow-xs' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    {{ $isBn ? 'সকল' : 'All' }}
                </a>
                @foreach($categories->take(6) as $cat)
                    <a href="{{ route('jobs.index', array_merge(request()->all(), ['locale' => $locale, 'category' => $cat->id, 'page' => null])) }}"
                       class="px-3 py-1.5 rounded-full shrink-0 transition-colors {{ ($filters['category'] ?? '') == $cat->id ? 'bg-blue-600 text-white font-medium shadow-xs' : 'bg-white text-gray-600 border border-gray-200 hover:border-blue-400 hover:text-blue-600' }}">
                        {{ $cat->getName() }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Mobile Filter Toggle Button --}}
    <div class="lg:hidden mb-4 flex items-center justify-between">
        <button type="button" id="mobile-filter-btn"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold bg-white border border-gray-200 text-gray-700 shadow-xs hover:bg-gray-50 transition-colors">
            <i class="fa-solid fa-sliders text-blue-600"></i>
            <span>{{ $isBn ? 'ফিল্টার পরিবর্তন করুন' : 'Filters' }}</span>
            @if($hasActiveFilters)
                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
            @endif
        </button>

        <span class="text-xs text-gray-500 font-medium">
            {{ $isBn
                ? number_format($jobs->total()) . 'টি চাকরি'
                : number_format($jobs->total()) . ' job' . ($jobs->total() !== 1 ? 's' : '') }}
        </span>
    </div>

    {{-- 2-Column Responsive Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        {{-- ── Left Sidebar (Filters & Widgets) ── --}}
        <aside id="job-filter-sidebar" class="hidden lg:block lg:col-span-4 space-y-6">

            {{-- Filter Form Card --}}
            <div class="card p-5 sm:p-6 sticky top-20">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-5">
                    <h2 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                        <i class="fa-solid fa-sliders text-blue-600"></i>
                        <span>{{ $isBn ? 'ফিল্টার' : 'Filter Jobs' }}</span>
                    </h2>
                    @if($hasActiveFilters)
                        <a href="{{ route('jobs.index', ['locale' => $locale]) }}"
                           class="text-xs text-red-500 hover:text-red-700 font-medium flex items-center gap-1">
                            <i class="fa-solid fa-rotate-left text-[10px]"></i>
                            <span>{{ $isBn ? 'মুছুন' : 'Reset' }}</span>
                        </a>
                    @endif
                </div>

                <form method="GET" action="{{ route('jobs.index', ['locale' => $locale]) }}" id="sidebar-filter-form" class="space-y-5">
                    @if(!empty($filters['q']))
                        <input type="hidden" name="q" value="{{ $filters['q'] }}">
                    @endif

                    {{-- Category --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                            {{ $isBn ? 'বিভাগ / ক্যাটাগরি' : 'Category' }}
                        </label>
                        <select name="category" onchange="document.getElementById('sidebar-filter-form').submit()"
                                class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                            <option value="">{{ $isBn ? 'সব বিভাগ' : 'All Categories' }}</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ ($filters['category'] ?? '') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->getName() }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Employment Type --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                            {{ $isBn ? 'চাকরির ধরন' : 'Employment Type' }}
                        </label>
                        <div class="space-y-2">
                            <label class="flex items-center gap-2.5 text-sm text-gray-700 cursor-pointer">
                                <input type="radio" name="employment_type" value=""
                                       {{ empty($filters['employment_type']) ? 'checked' : '' }}
                                       onchange="document.getElementById('sidebar-filter-form').submit()"
                                       class="text-blue-600 focus:ring-blue-500">
                                <span>{{ $isBn ? 'সব ধরন' : 'All types' }}</span>
                            </label>
                            @foreach($employmentTypes as $val => $label)
                                <label class="flex items-center gap-2.5 text-sm text-gray-700 cursor-pointer">
                                    <input type="radio" name="employment_type" value="{{ $val }}"
                                           {{ ($filters['employment_type'] ?? '') === $val ? 'checked' : '' }}
                                           onchange="document.getElementById('sidebar-filter-form').submit()"
                                           class="text-blue-600 focus:ring-blue-500">
                                    <span>{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Education Level --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                            {{ $isBn ? 'শিক্ষাগত যোগ্যতা' : 'Education' }}
                        </label>
                        <select name="education_level" onchange="document.getElementById('sidebar-filter-form').submit()"
                                class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                            <option value="">{{ $isBn ? 'যেকোনো যোগ্যতা' : 'Any Education' }}</option>
                            @foreach($educationLevels as $val => $label)
                                <option value="{{ $val }}" {{ ($filters['education_level'] ?? '') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Deadline Filter --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                            {{ $isBn ? 'আবেদনের সময়সীমা' : 'Deadline' }}
                        </label>
                        <select name="deadline_within" onchange="document.getElementById('sidebar-filter-form').submit()"
                                class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                            <option value="">{{ $isBn ? 'সব সময়সীমা' : 'Any time' }}</option>
                            <option value="7"  {{ ($filters['deadline_within'] ?? '') === '7'  ? 'selected' : '' }}>{{ $isBn ? '৭ দিনের মধ্যে' : 'Within 7 days' }}</option>
                            <option value="14" {{ ($filters['deadline_within'] ?? '') === '14' ? 'selected' : '' }}>{{ $isBn ? '১৪ দিনের মধ্যে' : 'Within 14 days' }}</option>
                            <option value="30" {{ ($filters['deadline_within'] ?? '') === '30' ? 'selected' : '' }}>{{ $isBn ? '৩০ দিনের মধ্যে' : 'Within 30 days' }}</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-primary w-full py-2.5 text-sm font-semibold">
                        <i class="fa-solid fa-filter mr-1.5"></i>
                        <span>{{ $isBn ? 'প্রয়োগ করুন' : 'Apply Filters' }}</span>
                    </button>
                </form>
            </div>

            {{-- Job Alert Signup Card --}}
            <div class="card p-5 bg-gradient-to-br from-blue-600 to-indigo-700 text-white shadow-md">
                <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center mb-3">
                    <i class="fa-solid fa-bell text-yellow-300 text-lg"></i>
                </div>
                <h3 class="font-extrabold text-base mb-1">{{ $isBn ? 'নতুন চাকরির অ্যালার্ট পান' : 'Job Alerts via Email' }}</h3>
                <p class="text-blue-100 text-xs mb-4 leading-relaxed">
                    {{ $isBn ? 'আপনার পছন্দের ক্যাটাগরির নতুন বিজ্ঞপ্তি সরাসরি ইমেইলে পেয়ে যান।' : 'Get instant email updates whenever new matching jobs are published.' }}
                </p>
                <form action="{{ route('job-alerts.subscribe') }}" method="POST" class="space-y-2.5">
                    @csrf
                    <input type="email" name="email" required
                           placeholder="{{ $isBn ? 'আপনার ইমেইল ঠিকানা' : 'your@email.com' }}"
                           class="w-full px-3.5 py-2.5 rounded-xl text-sm text-gray-900 border-0 focus:ring-2 focus:ring-white bg-white placeholder-gray-400">
                    @if(!empty($filters['q']))
                        <input type="hidden" name="keyword" value="{{ $filters['q'] }}">
                    @endif
                    @if(!empty($filters['location']))
                        <input type="hidden" name="location" value="{{ $filters['location'] }}">
                    @endif
                    <button type="submit" class="w-full bg-white text-blue-700 font-bold text-sm py-2.5 rounded-xl hover:bg-blue-50 transition-colors shadow-xs">
                        <i class="fa-solid fa-paper-plane mr-1.5"></i>
                        <span>{{ $isBn ? 'সাবস্ক্রাইব করুন' : 'Subscribe Free' }}</span>
                    </button>
                </form>
            </div>

            {{-- Ad Placement if enabled --}}
            @if(isset($sidebarAd) && $sidebarAd)
                <div class="card p-3 text-center">
                    <p class="text-[10px] text-gray-300 mb-1 uppercase tracking-widest">Sponsored</p>
                    {!! $sidebarAd->html_code !!}
                </div>
            @endif
        </aside>

        {{-- ── Main Listings Column ── --}}
        <main class="lg:col-span-8">

            {{-- Results Top Bar --}}
            <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                <p class="text-sm text-gray-600 font-semibold">
                    {{ $isBn
                        ? number_format($jobs->total()) . 'টি চাকরি পাওয়া গেছে'
                        : number_format($jobs->total()) . ' job' . ($jobs->total() !== 1 ? 's' : '') . ' available' }}
                </p>

                {{-- Active filter tags --}}
                @if($hasActiveFilters)
                    <div class="flex flex-wrap items-center gap-1.5 text-xs">
                        @if(!empty($filters['q']))
                            <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 px-2.5 py-1 rounded-lg border border-blue-100 font-medium">
                                <i class="fa-solid fa-magnifying-glass text-[10px]"></i> {{ $filters['q'] }}
                            </span>
                        @endif
                        @if(!empty($filters['location']))
                            <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-lg border border-emerald-100 font-medium">
                                <i class="fa-solid fa-location-dot text-[10px]"></i> {{ $filters['location'] }}
                            </span>
                        @endif
                        @if(!empty($filters['employment_type']))
                            <span class="inline-flex items-center gap-1 bg-violet-50 text-violet-700 px-2.5 py-1 rounded-lg border border-violet-100 font-medium">
                                {{ $employmentTypes[$filters['employment_type']] ?? $filters['employment_type'] }}
                            </span>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Empty State --}}
            @if($jobs->count() === 0)
                <div class="card p-12 text-center bg-white">
                    <div class="w-16 h-16 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl shadow-xs">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $isBn ? 'কোনো চাকরি পাওয়া যায়নি' : 'No jobs match your criteria' }}</h3>
                    <p class="text-gray-500 text-sm max-w-md mx-auto mb-6">
                        {{ $isBn ? 'অনুগ্রহ করে কি-ওয়ার্ড পরিবর্তন করে অথবা ফিল্টার সরিয়ে আবার চেষ্টা করুন।' : 'Try adjusting your search keywords, location or removing some filters.' }}
                    </p>
                    <a href="{{ route('jobs.index', ['locale' => $locale]) }}" class="btn-primary text-sm px-6 py-2.5">
                        <i class="fa-solid fa-rotate-left mr-1.5"></i>
                        <span>{{ $isBn ? 'সব চাকরি দেখুন' : 'View all jobs' }}</span>
                    </a>
                </div>
            @else
                {{-- Job Cards List --}}
                <div class="space-y-4">
                    @foreach($jobs as $job)
                        <article class="card p-5 sm:p-6 hover:shadow-md transition-all group border-l-4 {{ $job->is_verified ? 'border-l-emerald-500' : 'border-l-blue-500' }}">
                            <div class="flex flex-col sm:flex-row sm:items-start gap-4">
                                {{-- Employer monogram / icon --}}
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-50 to-indigo-100 text-blue-700 flex items-center justify-center font-extrabold text-lg shrink-0 shadow-xs border border-blue-100/60">
                                    {{ strtoupper(mb_substr($job->getEmployer() ?: 'P', 0, 1)) }}
                                </div>

                                {{-- Job Core Details --}}
                                <div class="flex-1 min-w-0">
                                    {{-- Badges row --}}
                                    <div class="flex flex-wrap items-center gap-1.5 mb-2">
                                        @if($job->isExpired())
                                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold px-2.5 py-0.5 rounded-full bg-red-50 text-red-700 border border-red-200">
                                                <i class="fa-solid fa-circle-exclamation text-[10px]"></i>
                                                {{ __('ui.job_expired') }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <i class="fa-solid fa-circle-check text-[10px]"></i>
                                                {{ $isBn ? 'চলমান' : 'Active' }}
                                            </span>
                                        @endif

                                        @if($job->is_verified)
                                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-100">
                                                <i class="fa-solid fa-shield-halved text-[10px]"></i>
                                                {{ $isBn ? 'যাচাইকৃত' : 'Verified' }}
                                            </span>
                                        @endif

                                        @if($job->employment_type)
                                            <span class="inline-flex items-center text-[11px] font-medium px-2.5 py-0.5 rounded-full bg-gray-100 text-gray-700">
                                                {{ $employmentTypes[$job->employment_type] ?? $job->employment_type }}
                                            </span>
                                        @endif

                                        @if($job->deadline)
                                            <span class="inline-flex items-center gap-1 text-[11px] font-medium px-2.5 py-0.5 rounded-full {{ $job->isExpired() ? 'bg-gray-100 text-gray-500' : 'bg-amber-50 text-amber-800 border border-amber-200/60' }}">
                                                <i class="fa-regular fa-clock text-[10px]"></i>
                                                {{ __('ui.deadline') }}: {{ $job->deadline->format('d M Y') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Job Title --}}
                                    <h2 class="text-base sm:text-lg font-bold text-gray-900 leading-snug group-hover:text-blue-600 transition-colors mb-2">
                                        <a href="{{ route('jobs.show', ['locale' => $locale, 'slug' => $job->slug]) }}">
                                            {{ $job->getTitle() }}
                                        </a>
                                    </h2>

                                    {{-- Meta attributes (Company, Location, Education) --}}
                                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 text-xs text-gray-500">
                                        @if($job->getEmployer())
                                            <span class="inline-flex items-center gap-1.5 font-medium text-gray-700">
                                                <i class="fa-solid fa-building text-gray-400"></i>
                                                <span>{{ $job->getEmployer() }}</span>
                                            </span>
                                        @endif

                                        @if($job->getLocation())
                                            <span class="inline-flex items-center gap-1.5">
                                                <i class="fa-solid fa-location-dot text-gray-400"></i>
                                                <span>{{ $job->getLocation() }}</span>
                                            </span>
                                        @endif

                                        @if($job->education_level && $job->education_level !== 'any')
                                            <span class="inline-flex items-center gap-1.5">
                                                <i class="fa-solid fa-graduation-cap text-gray-400"></i>
                                                <span>{{ $educationLevels[$job->education_level] ?? $job->education_level }}</span>
                                            </span>
                                        @endif

                                        @if($job->views > 0)
                                            <span class="inline-flex items-center gap-1 text-gray-400">
                                                <i class="fa-regular fa-eye text-[11px]"></i>
                                                <span>{{ number_format($job->views) }}</span>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Action Buttons (Details, Apply & Bookmark) --}}
                                <div class="flex items-center sm:flex-col sm:items-end justify-between sm:justify-start gap-2 pt-3 sm:pt-0 border-t sm:border-t-0 border-gray-100 shrink-0">
                                    <div class="flex items-center gap-2">
                                        {{-- Save Job Bookmark --}}
                                        @auth
                                            @php $isSaved = auth()->user()->savedJobs()->where('job_id', $job->id)->exists(); @endphp
                                            <button type="button"
                                                    class="job-card-save-btn p-2 rounded-xl border border-gray-200 text-gray-400 hover:text-amber-500 hover:border-amber-300 transition-colors"
                                                    data-url="{{ route('jobs.save', $job) }}"
                                                    data-saved="{{ $isSaved ? '1' : '0' }}"
                                                    title="{{ $isBn ? 'চাকরি সংরক্ষণ করুন' : 'Save job' }}">
                                                <i class="fa-{{ $isSaved ? 'solid' : 'regular' }} fa-bookmark {{ $isSaved ? 'text-amber-500' : '' }}"></i>
                                            </button>
                                        @endauth

                                        <a href="{{ route('jobs.show', ['locale' => $locale, 'slug' => $job->slug]) }}"
                                           class="btn-secondary btn-sm px-4 py-2 font-semibold">
                                            {{ __('ui.read_more') }}
                                        </a>

                                        @if($job->application_url && !$job->isExpired())
                                            <a href="{{ $job->application_url }}" target="_blank" rel="noopener noreferrer"
                                               class="btn-primary btn-sm px-4 py-2 font-semibold">
                                                <i class="fa-solid fa-paper-plane mr-1 text-[11px]"></i>
                                                {{ __('ui.apply_now') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $jobs->links() }}
                </div>
            @endif
        </main>
    </div>
</div>

{{-- Mobile Filter Drawer Toggle & AJAX Bookmark Scripts --}}
@push('scripts')
<script>
(function () {
    // Mobile filter accordion toggle
    const filterBtn = document.getElementById('mobile-filter-btn');
    const sidebar   = document.getElementById('job-filter-sidebar');
    if (filterBtn && sidebar) {
        filterBtn.addEventListener('click', function () {
            sidebar.classList.toggle('hidden');
        });
    }

    // Job card inline save button AJAX
    const saveBtns = document.querySelectorAll('.job-card-save-btn');
    const isBn = document.documentElement.lang === 'bn';

    saveBtns.forEach(btn => {
        btn.addEventListener('click', async function (e) {
            e.preventDefault();
            const url  = btn.dataset.url;
            const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
            const icon = btn.querySelector('i');

            btn.disabled = true;
            try {
                const res  = await fetch(url, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json', 'Content-Type': 'application/json' },
                });
                const data = await res.json();
                if (data.saved) {
                    icon.className = 'fa-solid fa-bookmark text-amber-500';
                    btn.dataset.saved = '1';
                    if (window.toast) window.toast.success(isBn ? 'চাকরিটি সংরক্ষণ হয়েছে।' : 'Job saved to your bookmarks!');
                } else {
                    icon.className = 'fa-regular fa-bookmark';
                    btn.dataset.saved = '0';
                    if (window.toast) window.toast.info(isBn ? 'সংরক্ষণ তালিকা থেকে সরানো হয়েছে।' : 'Job removed from bookmarks.');
                }
            } catch (err) {
                if (window.toast) window.toast.error(isBn ? 'কিছু একটা সমস্যা হয়েছে।' : 'Failed to update saved job.');
            } finally {
                btn.disabled = false;
            }
        });
    });
})();
</script>
@endpush
@endsection
