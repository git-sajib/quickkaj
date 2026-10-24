@extends('layouts.app')

@php
    $isBn = app()->getLocale() === 'bn';
@endphp

@section('page_title', ($isBn ? 'ফ্রি URL শর্টনার — যেকোনো বড় লিংক ছোট করুন ও ক্লিক ট্র্যাক করুন' : 'Free URL Shortener — Shorten Long Links & Track Clicks') . ' — ' . __('ui.site_name'))
@section('seo_description', $isBn
    ? 'ফ্রি ও ফাস্ট অনলাইন ইউআরএল শর্টনার। যেকোনো দীর্ঘ ও জটিল ওয়েবসাইট লিংক এক ক্লিকে ছোট করুন এবং ফেসবুক ও সোশ্যালে শেয়ার করুন।'
    : 'Free and fast URL shortener. Create short, shareable links with instant real-time click tracking analytics.')

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "WebApplication",
    "name": "{{ $isBn ? 'ফ্রি অনলাইন URL শর্টনার' : 'Free Online URL Shortener' }}",
    "description": "{{ $isBn ? 'বড় ওয়েব লিংক সহজে ছোট ও ট্র্যাক করার ফ্রি টুল।' : 'Free tool to shorten long web links and track user clicks.' }}",
    "url": "{{ url()->current() }}",
    "applicationCategory": "UtilitiesApplication",
    "operatingSystem": "All",
    "inLanguage": "{{ $isBn ? 'bn-BD' : 'en-US' }}",
    "offers": {
        "@@type": "Offer",
        "price": "0",
        "priceCurrency": "USD"
    }
}
</script>
@endsection

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-10">
        <h1 class="section-header"><i class="fa-solid fa-link text-blue-600 mr-2"></i>{{ __('ui.shorten_title') }}</h1>
        <p class="section-subtitle">{{ __('ui.shorten_subtitle') }}</p>
        <div class="section-divider mx-auto"></div>
    </div>

    <div class="card p-6 md:p-8">
        {{-- Input form --}}
        <div class="flex gap-3">
            <input type="url" id="url-input-short" class="form-input flex-1 text-base"
                   placeholder="{{ __('ui.enter_url') }}: https://example.com..."
                   autocomplete="off" autocorrect="off">
            <button id="btn-shorten" class="btn-primary flex-shrink-0 px-6 inline-flex items-center gap-2">
                <i class="fa-solid fa-bolt text-amber-300"></i>
                <span id="btn-text">{{ app()->getLocale() === 'bn' ? 'ছোট করুন' : 'Shorten' }}</span>
                <svg id="btn-spinner" class="hidden w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
            </button>
        </div>
        <p id="url-error" class="text-red-500 text-sm mt-2 hidden"></p>

        {{-- Result --}}
        <div id="result-box" class="hidden mt-6 bg-gradient-to-r from-blue-50 to-violet-50 rounded-2xl p-5 border border-blue-100">
            <p class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-500"></i>
                <span>{{ __('ui.your_short_url') }}:</span>
            </p>
            <div class="flex gap-2">
                <input type="text" id="short-url-display" class="form-input flex-1 bg-white font-mono text-sm font-semibold text-blue-600" readonly>
                <button id="btn-copy-short" class="btn-primary btn-sm flex-shrink-0 inline-flex items-center gap-1.5">
                    <i class="fa-regular fa-copy"></i>
                    <span>{{ __('ui.copy') }}</span>
                </button>
            </div>
            <div class="flex items-center gap-4 mt-3 text-xs text-gray-400">
                <span class="inline-flex items-center gap-1">
                    <i class="fa-regular fa-eye text-gray-500"></i>
                    {{ __('ui.clicks') }}: <span id="click-count" class="font-semibold text-gray-700">0</span>
                </span>
                <a id="short-url-link" href="#" target="_blank" rel="noopener" class="text-blue-500 hover:underline inline-flex items-center gap-1">
                    <span>{{ app()->getLocale() === 'bn' ? 'খুলুন' : 'Open' }}</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                </a>
            </div>
            <p id="copy-msg-short" class="text-emerald-600 text-xs mt-2 hidden">{{ __('ui.copied') }}</p>
        </div>
    </div>

    {{-- How it works --}}
    <div class="mt-10 grid grid-cols-1 sm:grid-cols-3 gap-4">
        @foreach([
            ['icon' => 'fa-regular fa-paste text-blue-600', 'step' => '1', 'title' => app()->getLocale() === 'bn' ? 'URL পেস্ট করুন' : 'Paste URL', 'desc' => app()->getLocale() === 'bn' ? 'আপনার দীর্ঘ URL কপি করে বক্সে দিন' : 'Copy your long URL and paste it'],
            ['icon' => 'fa-solid fa-bolt text-amber-500', 'step' => '2', 'title' => app()->getLocale() === 'bn' ? 'ক্লিক করুন' : 'Click Shorten', 'desc' => app()->getLocale() === 'bn' ? '"ছোট করুন" বাটনে ক্লিক করুন' : 'Hit the Shorten button'],
            ['icon' => 'fa-solid fa-share-nodes text-emerald-500', 'step' => '3', 'title' => app()->getLocale() === 'bn' ? 'শেয়ার করুন' : 'Share It', 'desc' => app()->getLocale() === 'bn' ? 'ছোট লিংক কপি করে শেয়ার করুন' : 'Copy and share your short link'],
        ] as $step)
            <div class="card p-5 text-center">
                <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-extrabold mx-auto mb-3">{{ $step['step'] }}</div>
                <div class="text-2xl mb-2"><i class="{{ $step['icon'] }}"></i></div>
                <h3 class="font-bold text-gray-900 text-sm">{{ $step['title'] }}</h3>
                <p class="text-gray-500 text-xs mt-1">{{ $step['desc'] }}</p>
            </div>
        @endforeach
    </div>

    @include('partials.tool-ad')
</div>

@push('scripts')
<script>
const btn = document.getElementById('btn-shorten');
const btnText = document.getElementById('btn-text');
const btnSpinner = document.getElementById('btn-spinner');
const errEl = document.getElementById('url-error');
const resultBox = document.getElementById('result-box');
const displayInput = document.getElementById('short-url-display');

btn.addEventListener('click', async () => {
    const url = document.getElementById('url-input-short').value.trim();
    if (!url) { errEl.textContent = '{{ __("ui.required_field") }}'; errEl.classList.remove('hidden'); return; }

    errEl.classList.add('hidden');
    btnText.classList.add('hidden'); btnSpinner.classList.remove('hidden');
    btn.disabled = true;

    try {
        const res = await fetch('{{ route("shorturl.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ url }),
        });
        const data = await res.json();

        if (!res.ok) { errEl.textContent = data.error || '{{ __("ui.server_error") }}'; errEl.classList.remove('hidden'); return; }

        displayInput.value = data.short_url;
        document.getElementById('click-count').textContent = data.clicks;
        document.getElementById('short-url-link').href = data.short_url;
        resultBox.classList.remove('hidden');
    } catch (e) {
        errEl.textContent = '{{ __("ui.server_error") }}'; errEl.classList.remove('hidden');
    } finally {
        btnText.classList.remove('hidden'); btnSpinner.classList.add('hidden');
        btn.disabled = false;
    }
});

document.getElementById('btn-copy-short').addEventListener('click', async () => {
    await navigator.clipboard.writeText(displayInput.value);
    const m = document.getElementById('copy-msg-short');
    m.classList.remove('hidden');
    setTimeout(() => m.classList.add('hidden'), 2000);
});

document.getElementById('url-input-short').addEventListener('keydown', e => {
    if (e.key === 'Enter') btn.click();
});
</script>
@endpush
@endsection
