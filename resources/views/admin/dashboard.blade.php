@extends('layouts.admin')

@section('page_title', __('ui.dashboard'))

@section('admin-content')
@if(($stats['unread_messages'] ?? 0) > 0)
    <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-rose-500 text-white flex items-center justify-center font-bold flex-shrink-0">
                <i class="fa-solid fa-envelope"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-900">
                    {{ app()->getLocale() === 'bn' ? 'আপনার ' . $stats['unread_messages'] . 'টি নতুন অপঠিত কন্টাক্ট মেসেজ রয়েছে।' : 'You have ' . $stats['unread_messages'] . ' unread contact messages.' }}
                </p>
                <p class="text-xs text-gray-500">{{ app()->getLocale() === 'bn' ? 'ব্যবহারকারীরা যোগাযোগ পেজ থেকে এই বার্তাগুলো পাঠিয়েছেন।' : 'Inquiries submitted from the public contact page.' }}</p>
            </div>
        </div>
        <a href="{{ route('admin.contact-messages.index', ['status' => 'unread']) }}"
           class="self-start sm:self-auto px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition-colors shadow-xs">
            {{ app()->getLocale() === 'bn' ? 'মেসেজগুলো পড়ুন' : 'View Inquiries' }} →
        </a>
    </div>
@endif

{{-- Stats grid --}}
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
        </div>
        <div class="text-3xl font-extrabold text-gray-900">{{ number_format($stats['jobs_total']) }}</div>
        <div class="text-sm font-medium text-gray-700 mt-1">{{ app()->getLocale() === 'bn' ? 'মোট চাকরি' : 'Total Jobs' }}</div>
        <div class="text-xs text-gray-400 mt-0.5">{{ $stats['jobs_published'] }} published</div>
    </div>

    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            </div>
        </div>
        <div class="text-3xl font-extrabold text-gray-900">{{ number_format($stats['articles_total']) }}</div>
        <div class="text-sm font-medium text-gray-700 mt-1">{{ app()->getLocale() === 'bn' ? 'মোট নিবন্ধ' : 'Total Articles' }}</div>
        <div class="text-xs text-gray-400 mt-0.5">{{ $stats['articles_published'] }} published</div>
    </div>

    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
            </div>
        </div>
        <div class="text-3xl font-extrabold text-gray-900">{{ number_format($stats['short_urls_total']) }}</div>
        <div class="text-sm font-medium text-gray-700 mt-1">{{ app()->getLocale() === 'bn' ? 'সংক্ষিপ্ত URL' : 'Short URLs' }}</div>
        <div class="text-xs text-gray-400 mt-0.5">{{ number_format($stats['short_urls_clicks']) }} clicks</div>
    </div>

    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center">
                <i class="fa-solid fa-bell text-lg"></i>
            </div>
        </div>
        <div class="text-3xl font-extrabold text-gray-900">{{ number_format($stats['job_alerts_total'] ?? 0) }}</div>
        <div class="text-sm font-medium text-gray-700 mt-1">{{ app()->getLocale() === 'bn' ? 'অ্যালার্ট গ্রাহক' : 'Job Subscribers' }}</div>
        <div class="text-xs text-gray-400 mt-0.5"><a href="{{ route('admin.job-alerts.index') }}" class="text-blue-500 hover:underline">{{ app()->getLocale() === 'bn' ? 'তালিকা দেখুন →' : 'View list →' }}</a></div>
    </div>

    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
        </div>
        <div class="text-3xl font-extrabold text-gray-900">{{ number_format($stats['users_total']) }}</div>
        <div class="text-sm font-medium text-gray-700 mt-1">{{ app()->getLocale() === 'bn' ? 'ব্যবহারকারী' : 'Users' }}</div>
        <div class="text-xs text-gray-400 mt-0.5">{{ $stats['ads_active'] }} ads active</div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
    <a href="{{ route('admin.jobs.create') }}" class="btn-primary justify-center py-2.5 inline-flex items-center gap-1.5"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg><span>{{ app()->getLocale() === 'bn' ? 'নতুন চাকরি' : 'New Job' }}</span></a>
    <a href="{{ route('admin.articles.create') }}" class="btn-primary justify-center py-2.5 inline-flex items-center gap-1.5"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg><span>{{ app()->getLocale() === 'bn' ? 'নতুন নিবন্ধ' : 'New Article' }}</span></a>
    <a href="{{ route('admin.categories.create') }}" class="btn-secondary justify-center py-2.5 inline-flex items-center gap-1.5"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg><span>{{ app()->getLocale() === 'bn' ? 'বিভাগ' : 'Category' }}</span></a>
    <a href="{{ route('admin.ad-placements.index') }}" class="btn-secondary justify-center py-2.5 inline-flex items-center gap-1.5"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg><span>{{ __('ui.manage_ads') }}</span></a>
</div>

{{-- Recent Content --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Recent Jobs --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h2 class="font-bold text-gray-900 flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                <span>{{ app()->getLocale() === 'bn' ? 'সাম্প্রতিক চাকরি' : 'Recent Jobs' }}</span>
            </h2>
            <a href="{{ route('admin.jobs.index') }}" class="text-xs text-blue-600 hover:underline">{{ __('ui.view_all') }}</a>
        </div>
        <ul class="divide-y divide-gray-100">
            @forelse($recentJobs as $job)
                <li class="flex items-center justify-between px-5 py-3 hover:bg-gray-50">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $job->getTitle() }}</p>
                        <p class="text-xs text-gray-400">{{ $job->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="flex items-center gap-2 ml-3 flex-shrink-0">
                        <span class="{{ $job->is_published ? 'badge-green' : 'badge-gray' }}">
                            {{ $job->is_published ? __('ui.published') : __('ui.unpublished') }}
                        </span>
                        <a href="{{ route('admin.jobs.edit', $job) }}" class="text-xs text-blue-600 hover:underline">{{ __('ui.edit') }}</a>
                    </div>
                </li>
            @empty
                <li class="px-5 py-8 text-center text-gray-400 text-sm">{{ app()->getLocale() === 'bn' ? 'কোনো চাকরি নেই।' : 'No jobs yet.' }}</li>
            @endforelse
        </ul>
    </div>

    {{-- Recent Articles --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h2 class="font-bold text-gray-900 flex items-center gap-2">
                <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                <span>{{ app()->getLocale() === 'bn' ? 'সাম্প্রতিক নিবন্ধ' : 'Recent Articles' }}</span>
            </h2>
            <a href="{{ route('admin.articles.index') }}" class="text-xs text-blue-600 hover:underline">{{ __('ui.view_all') }}</a>
        </div>
        <ul class="divide-y divide-gray-100">
            @forelse($recentArticles as $article)
                <li class="flex items-center justify-between px-5 py-3 hover:bg-gray-50">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $article->getTitle() }}</p>
                        <p class="text-xs text-gray-400">{{ $article->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="flex items-center gap-2 ml-3 flex-shrink-0">
                        <span class="{{ $article->is_published ? 'badge-green' : 'badge-gray' }}">
                            {{ $article->is_published ? __('ui.published') : __('ui.unpublished') }}
                        </span>
                        <a href="{{ route('admin.articles.edit', $article) }}" class="text-xs text-blue-600 hover:underline">{{ __('ui.edit') }}</a>
                    </div>
                </li>
            @empty
                <li class="px-5 py-8 text-center text-gray-400 text-sm">{{ app()->getLocale() === 'bn' ? 'কোনো নিবন্ধ নেই।' : 'No articles yet.' }}</li>
            @endforelse
        </ul>
    </div>
</div>

{{-- Top Viewed Pages (Last 7 Days) --}}
@if(!empty($topPages) && count($topPages) > 0)
<div class="mt-6 bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
    <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4">
        <h2 class="font-bold text-gray-900 text-sm flex items-center gap-2">
            <i class="fa-solid fa-fire text-amber-500"></i>
            <span>{{ app()->getLocale() === 'bn' ? 'সর্বাধিক পঠিত পেজ (বিগত ৭ দিন)' : 'Top Visited Pages (Last 7 Days)' }}</span>
        </h2>
        <a href="{{ route('admin.analytics.index') }}" class="text-xs font-semibold text-blue-600 hover:underline">
            {{ app()->getLocale() === 'bn' ? 'সম্পূর্ণ অ্যানালিটিক্স' : 'Full Analytics' }} →
        </a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
        @foreach($topPages as $url => $views)
            <div class="p-3 bg-gray-50/80 rounded-xl border border-gray-200/60 flex flex-col justify-between">
                <p class="text-xs font-bold text-gray-800 truncate" title="{{ $url ?: '/' }}">
                    /{{ ltrim($url ?: '', '/') }}
                </p>
                <div class="flex items-center justify-between mt-2 pt-2 border-t border-gray-200/50 text-[11px]">
                    <span class="text-gray-400">Views</span>
                    <span class="font-mono font-bold text-emerald-600">{{ number_format($views) }}</span>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif
@endsection
