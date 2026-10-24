@extends('layouts.admin')

@section('page_title', __('ui.manage_jobs'))

@section('admin-content')
@php
    $isBn = app()->getLocale() === 'bn';
@endphp
<div class="space-y-4 mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        {{-- Status Filter Tabs --}}
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.jobs.index', ['status' => 'all', 'search' => request('search')]) }}"
               class="px-3 py-1.5 rounded-xl text-xs font-bold transition-colors {{ ($status ?? 'all') === 'all' ? 'bg-blue-600 text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
                <span>{{ $isBn ? 'সব' : 'All' }}</span>
                <span class="ml-1 px-1.5 py-0.2 rounded-full text-[10px] {{ ($status ?? 'all') === 'all' ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-600' }}">{{ $totalCount ?? $jobs->total() }}</span>
            </a>
            <a href="{{ route('admin.jobs.index', ['status' => 'published', 'search' => request('search')]) }}"
               class="px-3 py-1.5 rounded-xl text-xs font-bold transition-colors {{ ($status ?? '') === 'published' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
                <span>{{ $isBn ? 'প্রকাশিত' : 'Published' }}</span>
                <span class="ml-1 px-1.5 py-0.2 rounded-full text-[10px] {{ ($status ?? '') === 'published' ? 'bg-white/20 text-white' : 'bg-emerald-50 text-emerald-600' }}">{{ $publishedCount ?? 0 }}</span>
            </a>
            <a href="{{ route('admin.jobs.index', ['status' => 'draft', 'search' => request('search')]) }}"
               class="px-3 py-1.5 rounded-xl text-xs font-bold transition-colors {{ ($status ?? '') === 'draft' ? 'bg-amber-600 text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
                <span>{{ $isBn ? 'ড্রাফট' : 'Draft' }}</span>
                <span class="ml-1 px-1.5 py-0.2 rounded-full text-[10px] {{ ($status ?? '') === 'draft' ? 'bg-white/20 text-white' : 'bg-amber-50 text-amber-600' }}">{{ $draftCount ?? 0 }}</span>
            </a>
            <a href="{{ route('admin.jobs.index', ['status' => 'expired', 'search' => request('search')]) }}"
               class="px-3 py-1.5 rounded-xl text-xs font-bold transition-colors {{ ($status ?? '') === 'expired' ? 'bg-rose-600 text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
                <span>{{ $isBn ? 'মেয়াদোত্তীর্ণ' : 'Expired' }}</span>
                <span class="ml-1 px-1.5 py-0.2 rounded-full text-[10px] {{ ($status ?? '') === 'expired' ? 'bg-white/20 text-white' : 'bg-rose-50 text-rose-600' }}">{{ $expiredCount ?? 0 }}</span>
            </a>
        </div>

        {{-- Search and Add button --}}
        <div class="flex items-center gap-2">
            <form method="GET" action="{{ route('admin.jobs.index') }}" class="flex items-center gap-2">
                <input type="hidden" name="status" value="{{ $status ?? 'all' }}">
                <div class="relative">
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                           placeholder="{{ $isBn ? 'চাকরির পদ বা প্রতিষ্ঠান খুঁজুন...' : 'Search jobs...' }}"
                           class="text-xs rounded-xl border-gray-200 pl-8 pr-3 py-1.5 focus:border-blue-500 focus:ring-blue-500 w-44 sm:w-56">
                    <i class="fa-solid fa-magnifying-glass text-gray-400 text-xs absolute left-2.5 top-2.5 pointer-events-none"></i>
                </div>
                @if(!empty($search))
                    <a href="{{ route('admin.jobs.index', ['status' => $status ?? 'all']) }}" class="btn-secondary btn-sm" title="Clear">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
                <button type="submit" class="btn-primary btn-sm">{{ $isBn ? 'সার্চ' : 'Search' }}</button>
            </form>
            <a href="{{ route('admin.jobs.create') }}" class="btn-primary btn-sm whitespace-nowrap">+ {{ $isBn ? 'নতুন চাকরি' : 'Add Job' }}</a>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th>{{ app()->getLocale() === 'bn' ? 'শিরোনাম' : 'Title' }}</th>
                    <th>{{ __('ui.employer') }}</th>
                    <th>{{ __('ui.deadline') }}</th>
                    <th>{{ __('ui.published') }}</th>
                    <th>{{ app()->getLocale() === 'bn' ? 'তারিখ' : 'Date' }}</th>
                    <th>{{ app()->getLocale() === 'bn' ? 'কার্যক্রম' : 'Actions' }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobs as $job)
                    <tr>
                        <td class="max-w-xs">
                            <p class="font-medium text-gray-900 truncate">{{ $job->getTitle() }}</p>
                            <p class="text-xs text-gray-400">{{ $job->slug }}</p>
                        </td>
                        <td class="text-gray-600">{{ $job->employer_bn ?? '—' }}</td>
                        <td class="text-gray-600 whitespace-nowrap">
                            {{ $job->deadline ? $job->deadline->format('d M Y') : '—' }}
                            @if($job->isExpired())
                                <span class="badge-red ml-1">{{ __('ui.job_expired') }}</span>
                            @endif
                        </td>
                        <td>
                            <span class="{{ $job->is_published ? 'badge-green' : 'badge-gray' }}">
                                {{ $job->is_published ? __('ui.published') : __('ui.unpublished') }}
                            </span>
                        </td>
                        <td class="text-gray-400 text-xs whitespace-nowrap">{{ $job->created_at->format('d M Y') }}</td>
                        <td class="whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('jobs.show', ['locale' => 'bn', 'slug' => $job->slug]) }}"
                                   target="_blank" class="text-xs text-blue-500 hover:underline">↗</a>
                                <a href="{{ route('admin.jobs.edit', $job) }}" class="btn-secondary btn-sm">{{ __('ui.edit') }}</a>
                                <form method="POST" action="{{ route('admin.jobs.destroy', $job) }}" onsubmit="return confirm('{{ app()->getLocale() === "bn" ? "সত্যিই মুছবেন?" : "Are you sure?" }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-danger btn-sm">{{ __('ui.delete') }}</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-8 text-gray-400">{{ app()->getLocale() === 'bn' ? 'কোনো চাকরি নেই।' : 'No jobs found.' }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-5 py-4 border-t border-gray-100">
        {{ $jobs->links() }}
    </div>
</div>
@endsection
