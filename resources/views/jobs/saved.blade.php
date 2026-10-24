@extends('layouts.app')
@section('page_title', (app()->getLocale() === 'bn' ? 'সংরক্ষিত চাকরি' : 'Saved Jobs') . ' — ' . __('ui.site_name'))
@section('content')
@php $locale = app()->getLocale(); $isBn = $locale === 'bn'; @endphp
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8 flex items-center gap-3">
        <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center">
            <i class="fa-solid fa-bookmark text-yellow-600 text-lg"></i>
        </div>
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">{{ $isBn ? 'সংরক্ষিত চাকরি' : 'Saved Jobs' }}</h1>
            <p class="text-sm text-gray-400">{{ $savedJobs->total() }} {{ $isBn ? 'টি চাকরি' : 'jobs saved' }}</p>
        </div>
    </div>

    @if($savedJobs->count() === 0)
        <div class="card p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-bookmark text-gray-200 text-3xl"></i>
            </div>
            <p class="font-medium text-gray-500 mb-2">{{ $isBn ? 'কোনো চাকরি সংরক্ষণ করা হয়নি।' : 'No saved jobs yet.' }}</p>
            <a href="{{ route('jobs.index', ['locale' => $locale]) }}" class="btn-primary mt-3 inline-block">
                <i class="fa-solid fa-briefcase mr-2"></i>{{ $isBn ? 'চাকরি খুঁজুন' : 'Browse Jobs' }}
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($savedJobs as $job)
                <article class="card p-5 flex flex-col sm:flex-row sm:items-center gap-4 group hover:shadow-md transition-shadow">
                    <div class="w-11 h-11 bg-gradient-to-br from-blue-100 to-violet-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-briefcase text-blue-600"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h2 class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                            <a href="{{ route('jobs.show', ['locale' => $locale, 'slug' => $job->slug]) }}">{{ $job->getTitle() }}</a>
                        </h2>
                        <div class="flex flex-wrap gap-3 text-xs text-gray-500 mt-1">
                            @if($job->employer_bn || $job->employer_en)
                                <span><i class="fa-solid fa-building mr-1 text-gray-400"></i>{{ $job->getEmployer() }}</span>
                            @endif
                            @if($job->location_bn || $job->location_en)
                                <span><i class="fa-solid fa-location-dot mr-1 text-gray-400"></i>{{ $job->getLocation() }}</span>
                            @endif
                            <span class="text-gray-300">
                                <i class="fa-regular fa-clock mr-1"></i>{{ $isBn ? 'সংরক্ষণ' : 'Saved' }}
                                {{ $job->pivot->saved_at ? \Carbon\Carbon::parse($job->pivot->saved_at)->diffForHumans() : '' }}
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0">
                        @if($job->isExpired())
                            <span class="job-badge-expired">{{ __('ui.job_expired') }}</span>
                        @else
                            @if($job->application_url)
                                <a href="{{ $job->application_url }}" target="_blank" rel="noopener" class="btn-primary btn-sm">
                                    {{ __('ui.apply_now') }}
                                </a>
                            @endif
                        @endif
                        <form method="POST" action="{{ route('jobs.save', $job) }}">
                            @csrf
                            <button type="submit" class="p-2 text-yellow-500 hover:text-gray-400 transition-colors" title="{{ $isBn ? 'সরান' : 'Remove' }}">
                                <i class="fa-solid fa-bookmark"></i>
                            </button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>
        <div class="mt-6">{{ $savedJobs->links() }}</div>
    @endif
</div>
@endsection
