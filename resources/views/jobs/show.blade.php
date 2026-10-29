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

                {{-- Official Circular & PDF Notice Section --}}
                @if($job->hasCircularPdf() || $job->hasFeaturedImage())
                    <div class="mb-8 p-5 bg-gradient-to-br from-slate-50 to-blue-50/40 rounded-2xl border border-blue-100 shadow-sm">
                        <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                            <h2 class="font-bold text-gray-900 text-lg flex items-center gap-2">
                                <i class="fa-solid fa-file-shield text-blue-600"></i>
                                <span>{{ app()->getLocale() === 'bn' ? 'অফিসিয়াল সার্কুলার ও নোটিশ' : 'Official Circular Notice' }}</span>
                            </h2>
                            <span class="text-xs bg-emerald-100 text-emerald-800 font-semibold px-2.5 py-1 rounded-full flex items-center gap-1">
                                <i class="fa-solid fa-circle-check text-emerald-600"></i>
                                {{ app()->getLocale() === 'bn' ? 'যাচাইকৃত ডকুমেন্ট' : 'Verified Document' }}
                            </span>
                        </div>

                        {{-- If PDF is available --}}
                        @if($job->hasCircularPdf())
                            <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm mb-4">
                                <div class="flex items-center justify-between flex-wrap gap-3 mb-3">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center font-bold">
                                            <i class="fa-solid fa-file-pdf text-xl"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-gray-800">{{ app()->getLocale() === 'bn' ? 'সম্পূর্ণ সার্কুলার ফাইল (PDF)' : 'Full Circular File (PDF)' }}</h3>
                                            <p class="text-xs text-gray-500">{{ app()->getLocale() === 'bn' ? 'নিচে সরাসরি পড়ুন অথবা সংরক্ষণ করুন' : 'Read below or download directly' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ $job->getCircularPdfUrl() }}" download
                                           class="btn-primary !bg-red-600 hover:!bg-red-700 text-xs sm:text-sm px-4 py-2 inline-flex items-center gap-1.5 shadow-sm">
                                            <i class="fa-solid fa-download"></i>
                                            <span>{{ app()->getLocale() === 'bn' ? 'PDF ডাউনলোড' : 'Download PDF' }}</span>
                                        </a>
                                        <a href="{{ $job->getCircularPdfUrl() }}" target="_blank" rel="noopener noreferrer"
                                           class="btn-secondary text-xs sm:text-sm px-3.5 py-2 inline-flex items-center gap-1.5">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                            <span class="hidden sm:inline">{{ app()->getLocale() === 'bn' ? 'ফুল স্ক্রিন' : 'Fullscreen' }}</span>
                                        </a>
                                    </div>
                                </div>

                                {{-- Embedded PDF Viewer --}}
                                <div class="relative w-full rounded-xl overflow-hidden border border-gray-200 bg-gray-900 shadow-inner">
                                    <iframe src="{{ $job->getCircularPdfUrl() }}#view=FitH"
                                            class="w-full h-[500px] sm:h-[650px] border-0"
                                            loading="lazy"
                                            title="{{ $job->getTitle() }} Circular PDF">
                                    </iframe>
                                </div>
                                <p class="text-[11px] text-gray-400 text-center mt-2 flex items-center justify-center gap-1">
                                    <i class="fa-solid fa-circle-info text-blue-500"></i>
                                    {{ app()->getLocale() === 'bn' ? 'মোবাইলে সরাসরি পড়তে সমস্যা হলে "PDF ডাউনলোড" বাটনে চাপুন।' : 'If PDF does not preview on mobile, tap "Download PDF".' }}
                                </p>
                            </div>
                        @endif

                        {{-- If Circular Image is available --}}
                        @if($job->hasFeaturedImage())
                            <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="text-sm font-bold text-gray-800 flex items-center gap-1.5">
                                        <i class="fa-regular fa-image text-blue-600"></i>
                                        <span>{{ app()->getLocale() === 'bn' ? 'সার্কুলার ছবি / পত্রিকা বিজ্ঞপ্তি' : 'Circular Notice Image' }}</span>
                                    </h3>
                                    <a href="{{ $job->getFeaturedImageUrl() }}" target="_blank" rel="noopener noreferrer"
                                       class="text-xs text-blue-600 hover:underline font-semibold flex items-center gap-1">
                                        <i class="fa-solid fa-magnifying-glass-plus"></i>
                                        <span>{{ app()->getLocale() === 'bn' ? 'আসল ছবি দেখুন' : 'View Full Image' }}</span>
                                    </a>
                                </div>
                                <div class="rounded-xl overflow-hidden border border-gray-100 bg-gray-50 flex items-center justify-center p-2">
                                    <a href="{{ $job->getFeaturedImageUrl() }}" target="_blank" rel="noopener noreferrer" class="block group relative cursor-zoom-in">
                                        <img src="{{ $job->getFeaturedImageUrl() }}" alt="{{ $job->getTitle() }}"
                                             class="w-full max-h-[750px] object-contain rounded-lg transition-transform group-hover:scale-[1.01]" loading="lazy">
                                        <div class="absolute bottom-3 right-3 bg-gray-900/80 text-white text-xs px-3 py-1.5 rounded-lg flex items-center gap-1.5 backdrop-blur-sm shadow">
                                            <i class="fa-solid fa-expand"></i>
                                            <span>{{ app()->getLocale() === 'bn' ? 'বড় করে দেখতে ক্লিক করুন' : 'Click to zoom' }}</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endif
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

                    @if($job->hasCircularPdf())
                        <a href="{{ $job->getCircularPdfUrl() }}" download target="_blank"
                           class="btn-primary !bg-red-600 hover:!bg-red-700 text-sm sm:text-base px-6 py-3 w-full sm:w-auto font-semibold shadow-md inline-flex items-center justify-center gap-2">
                            <i class="fa-solid fa-file-pdf"></i>
                            <span>{{ app()->getLocale() === 'bn' ? 'অফিসিয়াল PDF (সার্ভার ১)' : 'Official PDF (Server 1)' }}</span>
                        </a>
                    @endif

                    @php $smartlinkUrl = \App\Models\AdPlacement::getSmartlinkUrl(); @endphp
                    @if($smartlinkUrl)
                        <a href="{{ $smartlinkUrl }}" target="_blank" rel="noopener noreferrer nofollow"
                           class="btn-secondary !bg-gradient-to-r !from-emerald-500 !to-teal-600 !text-white !border-0 text-sm sm:text-base px-6 py-3 w-full sm:w-auto font-semibold shadow-md hover:shadow-lg hover:from-emerald-600 hover:to-teal-700 transition-all inline-flex items-center justify-center gap-2">
                            <i class="fa-solid fa-file-shield"></i>
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

                {{-- WhatsApp 1-Click Viral Share Card --}}
                <div class="mt-6 p-4 sm:p-5 rounded-2xl bg-gradient-to-r from-emerald-500 via-teal-600 to-emerald-600 text-white shadow-md flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5 text-center sm:text-left">
                        <div class="w-11 h-11 rounded-xl bg-white/20 backdrop-blur-xs text-white flex items-center justify-center text-2xl shrink-0">
                            <i class="fa-brands fa-whatsapp"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm sm:text-base">
                                {{ app()->getLocale() === 'bn' ? 'চাকরিপ্রার্থী বন্ধুকে হোয়াটসঅ্যাপে পাঠান' : 'Share Job with Friends on WhatsApp' }}
                            </h4>
                            <p class="text-xs text-emerald-100">
                                {{ app()->getLocale() === 'bn' ? '১ ক্লিকেই বিজ্ঞপ্তির বিস্তারিত লিংক সহ বন্ধুদের গ্রুপে শেয়ার করুন।' : 'Send full job details and link directly to WhatsApp groups.' }}
                            </p>
                        </div>
                    </div>
                    @php
                        $waText = (app()->getLocale() === 'bn' ? 'চাকরির বিজ্ঞপ্তি: ' : 'Job Circular: ') . $job->getTitle() . ' (' . $job->company . ')' . "\n" . (app()->getLocale() === 'bn' ? 'সার্কুলার ও আবেদনের লিংক: ' : 'Details: ') . url()->current();
                    @endphp
                    <a href="https://api.whatsapp.com/send?text={{ rawurlencode($waText) }}" target="_blank" rel="noopener noreferrer"
                       class="w-full sm:w-auto px-5 py-2.5 bg-white text-emerald-700 hover:bg-emerald-50 rounded-xl text-xs sm:text-sm font-extrabold inline-flex items-center justify-center gap-2 shadow-sm transition-all hover:scale-105 shrink-0">
                        <i class="fa-brands fa-whatsapp text-emerald-600 text-base"></i>
                        <span>{{ app()->getLocale() === 'bn' ? 'হোয়াটসঅ্যাপে পাঠান' : 'Share on WhatsApp' }}</span>
                    </a>
                </div>
            </article>
        </div>

        {{-- Sidebar --}}
        <aside class="lg:col-span-4 mt-8 lg:mt-0 space-y-6">
            {{-- Quick Job Application Toolkit (Loop traffic to tools) --}}
            <div class="card p-5 bg-gradient-to-br from-blue-50/70 via-indigo-50/50 to-white border border-blue-100/90 rounded-2xl shadow-xs space-y-3">
                <h3 class="font-extrabold text-gray-900 text-sm flex items-center gap-2">
                    <i class="fa-solid fa-toolbox text-blue-600"></i>
                    <span>{{ app()->getLocale() === 'bn' ? 'আবেদনের প্রয়োজনীয় টুলস' : 'Application Toolkit' }}</span>
                </h3>
                <div class="space-y-2">
                    <a href="{{ route('tools.age-calculator', ['locale' => app()->getLocale()]) }}"
                       class="p-2.5 bg-white hover:bg-blue-50 border border-gray-200/80 rounded-xl flex items-center justify-between text-xs font-semibold text-gray-800 transition-colors group">
                        <span class="flex items-center gap-2">
                            <i class="fa-solid fa-calculator text-blue-600"></i>
                            <span>{{ app()->getLocale() === 'bn' ? 'বয়স হয়েছে কিনা যাচাই করুন' : 'Check Age Eligibility' }}</span>
                        </span>
                        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400 group-hover:translate-x-0.5 transition-transform"></i>
                    </a>
                    <a href="{{ route('tools.cv-builder', ['locale' => app()->getLocale()]) }}"
                       class="p-2.5 bg-white hover:bg-blue-50 border border-gray-200/80 rounded-xl flex items-center justify-between text-xs font-semibold text-gray-800 transition-colors group">
                        <span class="flex items-center gap-2">
                            <i class="fa-solid fa-file-invoice text-emerald-600"></i>
                            <span>{{ app()->getLocale() === 'bn' ? 'ফ্রি ১-পেজের সিভি বানান' : 'Create Free CV' }}</span>
                        </span>
                        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400 group-hover:translate-x-0.5 transition-transform"></i>
                    </a>
                    <a href="{{ route('tools.image-resizer', ['locale' => app()->getLocale()]) }}"
                       class="p-2.5 bg-white hover:bg-blue-50 border border-gray-200/80 rounded-xl flex items-center justify-between text-xs font-semibold text-gray-800 transition-colors group">
                        <span class="flex items-center gap-2">
                            <i class="fa-solid fa-crop text-indigo-600"></i>
                            <span>{{ app()->getLocale() === 'bn' ? 'ছবি ও স্বাক্ষর ৩০০×৩০০ রিসাইজ' : 'Resize Photo & Signature' }}</span>
                        </span>
                        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400 group-hover:translate-x-0.5 transition-transform"></i>
                    </a>
                </div>
            </div>

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
