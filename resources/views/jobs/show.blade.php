@extends('layouts.app')

@section('page_title', $job->getTitle() . ' — ' . __('ui.site_name'))
@section('seo_description', $job->seo_description ?? $job->getEmployer() . ' — ' . ($job->deadline ? __('ui.deadline') . ': ' . $job->deadline->format('d M Y') : ''))

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "JobPosting",
    "title": "{{ addslashes($job->getTitle()) }}",
    "hiringOrganization": {
        "@@type": "Organization",
        "name": "{{ addslashes($job->getEmployer()) }}"
    },
    "jobLocation": {
        "@@type": "Place",
        "address": "{{ addslashes($job->getLocation()) }}"
    },
    "datePosted": "{{ $job->published_at?->toIso8601String() }}",
    "validThrough": "{{ $job->deadline?->toIso8601String() }}",
    "url": "{{ url()->current() }}"
}
</script>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="lg:grid lg:grid-cols-12 lg:gap-8">

        {{-- Main Content --}}
        <div class="lg:col-span-8">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-xs text-gray-400 mb-6">
                <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="hover:text-blue-600">{{ __('ui.home') }}</a>
                <span>/</span>
                <a href="{{ route('jobs.index', ['locale' => app()->getLocale()]) }}" class="hover:text-blue-600">{{ __('ui.jobs') }}</a>
                <span>/</span>
                <span class="text-gray-600">{{ Str::limit($job->getTitle(), 50) }}</span>
            </nav>

            <article class="card p-6 md:p-8">
                {{-- Header --}}
                <div class="mb-6">
                    <div class="flex flex-wrap items-center gap-2 mb-3">
                        @if($job->isExpired())
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-0.5 rounded-full bg-red-50 text-red-700 border border-red-200">
                                <i class="fa-solid fa-circle-exclamation text-xs"></i>
                                {{ __('ui.job_expired') }}
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <i class="fa-solid fa-circle-check text-xs"></i>
                                {{ app()->getLocale() === 'bn' ? 'চলমান' : 'Active' }}
                            </span>
                        @endif
                        @if($job->deadline)
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-0.5 rounded-full {{ $job->isExpired() ? 'bg-gray-100 text-gray-600' : 'bg-amber-50 text-amber-800 border border-amber-200' }}">
                                <i class="fa-regular fa-clock text-xs"></i>
                                {{ __('ui.deadline') }}: {{ $job->deadline->format('d M Y') }}
                            </span>
                        @endif
                        @if($job->is_verified ?? false)
                            <span class="inline-flex items-center gap-1 text-xs bg-blue-50 text-blue-700 border border-blue-200 rounded-full px-2.5 py-0.5 font-semibold">
                                <i class="fa-solid fa-shield-halved text-xs"></i> {{ app()->getLocale() === 'bn' ? 'যাচাইকৃত' : 'Verified' }}
                            </span>
                        @endif
                    </div>

                    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 leading-tight">
                        {{ $job->getTitle() }}
                    </h1>

                    {{-- Meta grid --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-5 bg-gray-50 rounded-xl p-4">
                        @if($job->employer_bn || $job->employer_en)
                            <div class="flex items-start gap-2">
                                <i class="fa-solid fa-building text-gray-400 mt-0.5 w-4 flex-shrink-0"></i>
                                <div>
                                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">{{ __('ui.employer') }}</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $job->getEmployer() }}</p>
                                </div>
                            </div>
                        @endif
                        @if($job->location_bn || $job->location_en)
                            <div class="flex items-start gap-2">
                                <i class="fa-solid fa-location-dot text-gray-400 mt-0.5 w-4 flex-shrink-0"></i>
                                <div>
                                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">{{ __('ui.location') }}</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $job->getLocation() }}</p>
                                </div>
                            </div>
                        @endif
                        @if($job->deadline)
                            <div class="flex items-start gap-2">
                                <i class="fa-regular fa-calendar text-gray-400 mt-0.5 w-4 flex-shrink-0"></i>
                                <div>
                                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">{{ __('ui.deadline') }}</p>
                                    <p class="text-sm font-semibold {{ $job->isExpired() ? 'text-red-600' : 'text-gray-800' }}">
                                        {{ $job->deadline->format('d F Y') }}
                                        @if($job->isExpired())
                                            <span class="text-xs text-red-500 ml-1">({{ app()->getLocale() === 'bn' ? 'মেয়াদ শেষ' : 'Expired' }})</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endif
                        @if($job->source_url)
                            <div class="flex items-start gap-2">
                                <i class="fa-solid fa-link text-gray-400 mt-0.5 w-4 flex-shrink-0"></i>
                                <div>
                                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">{{ __('ui.source') }}</p>
                                    <a href="{{ $job->source_url }}" target="_blank" rel="noopener noreferrer"
                                       class="text-sm text-blue-600 hover:underline font-medium">{{ parse_url($job->source_url, PHP_URL_HOST) }}</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Eligibility --}}
                @if($job->eligibility_bn || $job->eligibility_en)
                    <div class="mb-6">
                        <h2 class="font-bold text-gray-900 text-lg mb-3 flex items-center gap-2">
                            <i class="fa-solid fa-circle-check text-blue-600"></i>
                            <span>{{ __('ui.eligibility') }}</span>
                        </h2>
                        <div class="article-body bg-blue-50/60 rounded-xl p-4 text-sm border border-blue-100/60">
                            {!! nl2br(e(app()->getLocale() === 'en' && $job->eligibility_en ? $job->eligibility_en : $job->eligibility_bn)) !!}
                        </div>
                    </div>
                @endif

                {{-- Description --}}
                @if($job->description_bn || $job->description_en)
                    <div class="article-body mb-6">
                        {!! $job->getDescription() !!}
                    </div>
                @endif

                {{-- Inline Ad BELOW description (high CTR) --}}
                @if(!empty($inlineAd))
                    <div class="my-6 p-3 bg-gray-50 rounded-xl text-center border border-gray-100">
                        <p class="text-[10px] text-gray-300 mb-1 uppercase tracking-widest">Advertisement</p>
                        {!! $inlineAd->html_code !!}
                    </div>
                @endif

                {{-- Apply / Save Buttons (Always visible) --}}
                <div class="border-t border-gray-100 pt-6 flex flex-col sm:flex-row gap-3 flex-wrap items-center">
                    @if($job->application_url)
                        @if(!$job->isExpired())
                            <a href="{{ $job->application_url }}" target="_blank" rel="noopener noreferrer"
                               class="btn-primary text-sm sm:text-base px-8 py-3 w-full sm:w-auto font-semibold">
                                <i class="fa-solid fa-paper-plane mr-2"></i>{{ __('ui.apply_now') }}
                            </a>
                        @else
                            <span class="inline-flex items-center justify-center gap-2 px-8 py-3 rounded-xl bg-gray-100 text-gray-400 font-semibold text-sm sm:text-base cursor-not-allowed w-full sm:w-auto">
                                <i class="fa-solid fa-ban"></i> {{ __('ui.job_expired') }}
                            </span>
                        @endif
                    @endif

                    @php $smartlinkUrl = \App\Models\AdPlacement::getSmartlinkUrl(); @endphp
                    @if($smartlinkUrl)
                        <a href="{{ $smartlinkUrl }}" target="_blank" rel="noopener noreferrer nofollow"
                           class="btn-secondary !bg-gradient-to-r !from-emerald-500 !to-teal-600 !text-white !border-0 text-sm sm:text-base px-6 py-3 w-full sm:w-auto font-semibold shadow-md hover:shadow-lg hover:from-emerald-600 hover:to-teal-700 transition-all inline-flex items-center justify-center gap-2">
                            <i class="fa-solid fa-file-pdf"></i>
                            <span>{{ app()->getLocale() === 'bn' ? 'সার্কুলার নোটিশ (সার্ভার ২)' : 'Circular Notice (Server 2)' }}</span>
                        </a>
                    @endif

                    @auth
                        <button type="button" id="save-btn"
                            data-url="{{ route('jobs.save', $job) }}"
                            data-saved="{{ auth()->user()->savedJobs()->where('job_id', $job->id)->exists() ? '1' : '0' }}"
                            class="btn-secondary text-sm sm:text-base px-6 py-3 flex items-center justify-center gap-2 transition-all w-full sm:w-auto font-semibold">
                            <i id="save-icon" class="fa-{{ auth()->user()->savedJobs()->where('job_id', $job->id)->exists() ? 'solid' : 'regular' }} fa-bookmark {{ auth()->user()->savedJobs()->where('job_id', $job->id)->exists() ? 'text-amber-500' : '' }}"></i>
                            <span id="save-text">
                                {{ auth()->user()->savedJobs()->where('job_id', $job->id)->exists()
                                    ? (app()->getLocale() === 'bn' ? 'সংরক্ষিত' : 'Saved')
                                    : (app()->getLocale() === 'bn' ? 'সংরক্ষণ করুন' : 'Save Job') }}
                            </span>
                        </button>
                    @endauth

                    <a href="{{ route('jobs.index', ['locale' => app()->getLocale()]) }}" class="btn-secondary text-sm sm:text-base px-6 py-3 w-full sm:w-auto font-semibold">
                        <i class="fa-solid fa-arrow-left mr-2"></i>{{ app()->getLocale() === 'bn' ? 'সব চাকরি' : 'All Jobs' }}
                    </a>
                </div>

                {{-- Social Share Bar --}}
                <x-social-share :url="url()->current()" :title="$job->getTitle() . ' — ' . $job->company" />
            </article>
        </div>

        {{-- Sidebar --}}
        <aside class="lg:col-span-4 mt-8 lg:mt-0 space-y-6">
            {{-- Related Jobs --}}
            @if($relatedJobs->count() > 0)
                <div class="card p-5">
                    <h3 class="font-bold text-gray-900 mb-4">
                        {{ app()->getLocale() === 'bn' ? 'অন্যান্য চাকরি' : 'More Jobs' }}
                    </h3>
                    <ul class="space-y-3">
                        @foreach($relatedJobs as $related)
                            <li class="border-b border-gray-100 pb-3 last:border-0 last:pb-0">
                                <a href="{{ route('jobs.show', ['locale' => app()->getLocale(), 'slug' => $related->slug]) }}"
                                   class="text-sm font-medium text-gray-800 hover:text-blue-600 transition-colors line-clamp-2">
                                    {{ $related->getTitle() }}
                                </a>
                                @if($related->deadline)
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $related->deadline->format('d M Y') }}</p>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Sidebar Ad --}}
            @if(isset($inlineAd) && $inlineAd)
                <div class="card p-3">{!! $inlineAd->html_code !!}</div>
            @endif
        </aside>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    const btn = document.getElementById('save-btn');
    if (!btn) return;

    const isBn = document.documentElement.lang === 'bn';

    btn.addEventListener('click', async function () {
        const url  = btn.dataset.url;
        const csrf = document.querySelector('meta[name="csrf-token"]').content;

        btn.disabled = true;
        document.getElementById('save-icon').className = 'fa-solid fa-spinner fa-spin';

        try {
            const res  = await fetch(url, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json', 'Content-Type': 'application/json' },
            });
            const data = await res.json();

            if (data.saved) {
                document.getElementById('save-icon').className = 'fa-solid fa-bookmark';
                document.getElementById('save-text').textContent = isBn ? 'সংরক্ষিত' : 'Saved';
                btn.dataset.saved = '1';
                window.toast.success(isBn ? 'চাকরিটি সংরক্ষণ হয়েছে।' : 'Job saved!');
            } else {
                document.getElementById('save-icon').className = 'fa-regular fa-bookmark';
                document.getElementById('save-text').textContent = isBn ? 'সংরক্ষণ করুন' : 'Save Job';
                btn.dataset.saved = '0';
                window.toast.info(isBn ? 'চাকরিটি সরানো হয়েছে।' : 'Removed from saved jobs.');
            }
        } catch (e) {
            window.toast.error(isBn ? 'কিছু একটা ভুল হয়েছে।' : 'Something went wrong.');
            document.getElementById('save-icon').className = 'fa-regular fa-bookmark';
        } finally {
            btn.disabled = false;
        }
    });
})();
</script>
@endpush
