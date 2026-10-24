@extends('layouts.admin')

@section('page_title', 'Analytics')

@section('admin-content')
@php $isBn = app()->getLocale() === 'bn'; @endphp

{{-- Period selector --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-900">{{ $isBn ? 'সাইট অ্যানালিটিক্স' : 'Site Analytics' }}</h2>
        <p class="text-sm text-gray-400">{{ $isBn ? 'কোনো ব্যক্তিগত তথ্য সংরক্ষণ করা হয় না।' : 'No personal data is stored.' }}</p>
    </div>
    <div class="flex gap-2">
        @foreach([7, 14, 30, 90] as $d)
            <a href="{{ route('admin.analytics.index', ['days' => $d]) }}"
               class="px-3 py-1.5 text-xs rounded-lg border {{ $days == $d ? 'bg-blue-600 text-white border-blue-600' : 'border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                {{ $d }}d
            </a>
        @endforeach
    </div>
</div>

{{-- KPI row --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    @php
        $kpis = [
            ['label' => $isBn ? 'মোট পেজ ভিউ' : 'Total Page Views', 'value' => number_format($totalViews), 'icon' => 'fa-eye', 'color' => 'text-blue-500', 'bg' => 'bg-blue-50'],
            ['label' => $isBn ? 'আজকের ভিউ' : 'Today\'s Views', 'value' => number_format($todayViews), 'icon' => 'fa-calendar-day', 'color' => 'text-violet-500', 'bg' => 'bg-violet-50'],
            ['label' => $isBn ? 'সক্রিয় চাকরি' : 'Active Jobs', 'value' => number_format($activeJobs), 'icon' => 'fa-briefcase', 'color' => 'text-emerald-500', 'bg' => 'bg-emerald-50'],
            ['label' => $isBn ? 'প্রকাশিত নিবন্ধ' : 'Published Articles', 'value' => number_format($totalArticles), 'icon' => 'fa-newspaper', 'color' => 'text-orange-500', 'bg' => 'bg-orange-50'],
        ];
    @endphp
    @foreach($kpis as $kpi)
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm flex items-center gap-4">
            <div class="{{ $kpi['bg'] }} w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fa-solid {{ $kpi['icon'] }} {{ $kpi['color'] }} text-lg"></i>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-gray-900">{{ $kpi['value'] }}</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ $kpi['label'] }}</p>
            </div>
        </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

    {{-- Daily trend --}}
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
        <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-chart-line text-blue-500"></i>
            {{ $isBn ? 'দৈনিক পেজ ভিউ' : 'Daily Page Views' }}
            <span class="text-xs font-normal text-gray-400">({{ $days }} days)</span>
        </h3>
        @if(empty($dailyTrend))
            <p class="text-gray-400 text-sm text-center py-8">{{ $isBn ? 'কোনো ডেটা নেই।' : 'No data yet.' }}</p>
        @else
            <div class="overflow-x-auto">
                <div class="flex items-end gap-1.5 h-32 min-w-0">
                    @php $maxVal = max($dailyTrend ?: [1]); @endphp
                    @foreach($dailyTrend as $date => $count)
                        <div class="flex-1 flex flex-col items-center gap-1 group" title="{{ $date }}: {{ $count }}">
                            <div class="w-full bg-blue-500 rounded-t-sm transition-all hover:bg-blue-600"
                                 style="height: {{ max(4, ($count / $maxVal) * 100) }}%">
                            </div>
                            <span class="text-[9px] text-gray-400 hidden group-hover:block whitespace-nowrap">{{ substr($date, 5) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    {{-- Device breakdown --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
        <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-mobile-screen text-violet-500"></i>
            {{ $isBn ? 'ডিভাইস' : 'Devices' }}
        </h3>
        @foreach(['desktop' => ['fa-desktop', 'bg-blue-100 text-blue-600'], 'mobile' => ['fa-mobile-screen', 'bg-violet-100 text-violet-600'], 'tablet' => ['fa-tablet-screen-button', 'bg-teal-100 text-teal-600']] as $type => [$icon, $cls])
            @php $count = $deviceBreakdown[$type] ?? 0; $total = array_sum($deviceBreakdown) ?: 1; $pct = round($count / $total * 100); @endphp
            <div class="flex items-center gap-3 mb-3">
                <div class="{{ $cls }} w-8 h-8 rounded-lg flex items-center justify-center text-sm flex-shrink-0">
                    <i class="fa-solid {{ $icon }}"></i>
                </div>
                <div class="flex-1">
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-gray-600 capitalize">{{ $type }}</span>
                        <span class="font-semibold text-gray-900">{{ number_format($count) }} ({{ $pct }}%)</span>
                    </div>
                    <div class="h-1.5 bg-gray-100 rounded-full">
                        <div class="h-1.5 bg-blue-500 rounded-full" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

    {{-- Top pages --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
        <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-fire text-orange-500"></i>
            {{ $isBn ? 'জনপ্রিয় পেজ' : 'Top Pages' }}
        </h3>
        @if(empty($topPages))
            <p class="text-gray-400 text-sm">{{ $isBn ? 'কোনো ডেটা নেই।' : 'No data yet.' }}</p>
        @else
            <div class="space-y-2">
                @foreach(array_slice($topPages, 0, 10, true) as $url => $count)
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-gray-500 truncate flex-1 font-mono">/{{ $url }}</span>
                        <span class="text-xs font-bold text-gray-900 flex-shrink-0">{{ number_format($count) }}</span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Top referrers --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
        <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-share-nodes text-emerald-500"></i>
            {{ $isBn ? 'রেফারার' : 'Top Referrers' }}
        </h3>
        @if(empty($topReferrers))
            <p class="text-gray-400 text-sm">{{ $isBn ? 'কোনো ডেটা নেই।' : 'No referrer data yet.' }}</p>
        @else
            <div class="space-y-2">
                @foreach($topReferrers as $ref => $count)
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-globe text-gray-300 text-xs flex-shrink-0"></i>
                        <span class="text-xs text-gray-500 truncate flex-1">{{ parse_url($ref, PHP_URL_HOST) ?? $ref }}</span>
                        <span class="text-xs font-bold text-gray-900 flex-shrink-0">{{ number_format($count) }}</span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

{{-- Top content --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
        <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-briefcase text-blue-500"></i>
            {{ $isBn ? 'জনপ্রিয় চাকরি' : 'Most Viewed Jobs' }}
        </h3>
        <div class="space-y-3">
            @foreach($topJobs as $job)
                <div class="flex items-center justify-between">
                    <a href="{{ route('admin.jobs.edit', $job) }}" class="text-sm text-gray-700 hover:text-blue-600 truncate flex-1 mr-3">
                        {{ $job->getTitle() }}
                    </a>
                    <span class="text-xs text-gray-400 flex items-center gap-1 flex-shrink-0">
                        <i class="fa-regular fa-eye"></i> {{ number_format($job->views) }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
        <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-newspaper text-violet-500"></i>
            {{ $isBn ? 'জনপ্রিয় নিবন্ধ' : 'Most Viewed Articles' }}
        </h3>
        <div class="space-y-3">
            @foreach($topArticles as $article)
                <div class="flex items-center justify-between">
                    <a href="{{ route('admin.articles.edit', $article) }}" class="text-sm text-gray-700 hover:text-blue-600 truncate flex-1 mr-3">
                        {{ $article->getTitle() }}
                    </a>
                    <span class="text-xs text-gray-400 flex items-center gap-1 flex-shrink-0">
                        <i class="fa-regular fa-eye"></i> {{ number_format($article->views) }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
