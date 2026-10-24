@extends('layouts.app')

@php
    $isBn = app()->getLocale() === 'bn';
@endphp

@section('page_title', ($isBn ? 'অনলাইন URL এনকোডার ও ডিকোডার — URL Encode & Decode' : 'Online URL Encoder & Decoder — Safe URL Encoding') . ' — ' . __('ui.site_name'))
@section('seo_description', $isBn
    ? 'ফ্রি অনলাইন URL এনকোডার ও ডিকোডার। যেকোনো ওয়েব লিংক বা স্পেশাল ক্যারেক্টারকে সহজে encodeURIComponent ও decodeURIComponent করুন।'
    : 'Free online URL encoder and decoder. Safely encode and decode special characters, parameters, and query strings for web URLs.')

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "WebApplication",
    "name": "{{ $isBn ? 'অনলাইন URL এনকোডার ও ডিকোডার' : 'Online URL Encoder & Decoder' }}",
    "description": "{{ $isBn ? 'URL এনকোড ও ডিকোড করার ফ্রি অনলাইন ওয়েব টুল।' : 'Free online tool to encode and decode URLs and query string parameters.' }}",
    "url": "{{ url()->current() }}",
    "applicationCategory": "DeveloperApplication",
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
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    @include('partials.tool-back')
    <h1 class="section-header mb-2 flex items-center justify-center gap-2">
        <i class="fa-solid fa-link text-orange-600"></i>
        <span>{{ __('ui.url_encoder') }}</span>
    </h1>
    <p class="section-subtitle mb-8">{{ $isBn ? 'URL এনকোড ও ডিকোড করুন — বিশেষ অক্ষর নিরাপদে পরিচালনা করুন।' : 'Encode and decode URLs — handle special characters safely.' }}</p>

    <div class="card p-6">
        <div class="grid grid-cols-1 gap-5">
            <div>
                <label class="form-label">{{ app()->getLocale() === 'bn' ? 'ইনপুট:' : 'Input:' }}</label>
                <textarea id="url-input" class="form-textarea w-full h-32 font-mono text-sm" spellcheck="false"
                          placeholder="{{ app()->getLocale() === 'bn' ? 'এখানে URL বা টেক্সট লিখুন...' : 'Enter URL or text here...' }}"></textarea>
            </div>

            <div class="flex flex-wrap gap-2">
                <button id="btn-encode" class="btn-primary inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-lock text-xs"></i>
                    <span>{{ app()->getLocale() === 'bn' ? 'এনকোড' : 'Encode' }}</span>
                </button>
                <button id="btn-decode" class="btn-secondary inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-lock-open text-xs"></i>
                    <span>{{ app()->getLocale() === 'bn' ? 'ডিকোড' : 'Decode' }}</span>
                </button>
                <button id="btn-encode-comp" class="btn-secondary inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-gear text-xs"></i>
                    <span>{{ app()->getLocale() === 'bn' ? 'কম্পোনেন্ট এনকোড' : 'Encode Component' }}</span>
                </button>
                <button id="btn-decode-comp" class="btn-secondary inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-gear text-xs"></i>
                    <span>{{ app()->getLocale() === 'bn' ? 'কম্পোনেন্ট ডিকোড' : 'Decode Component' }}</span>
                </button>
                <button id="btn-clear-url" class="btn-secondary inline-flex items-center gap-1 text-gray-500 hover:text-red-500" title="Clear">
                    <i class="fa-solid fa-trash-can text-xs"></i>
                </button>
            </div>

            <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="form-label mb-0">{{ app()->getLocale() === 'bn' ? 'আউটপুট:' : 'Output:' }}</label>
                    <button id="btn-copy-url" class="btn-secondary btn-sm inline-flex items-center gap-1.5">
                        <i class="fa-solid fa-copy text-xs"></i>
                        <span>{{ __('ui.copy') }}</span>
                    </button>
                </div>
                <textarea id="url-output" class="form-textarea w-full h-32 font-mono text-sm" readonly spellcheck="false"></textarea>
                <p id="copy-msg-url" class="text-emerald-600 text-xs mt-1 hidden">{{ __('ui.copied') }}</p>
            </div>
        </div>
    </div>

    @include('partials.tool-ad')
</div>

@push('scripts')
<script>
const inp = document.getElementById('url-input');
const out = document.getElementById('url-output');

function tryFn(fn) {
    try { out.value = fn(inp.value); }
    catch(e) { out.value = 'Error: ' + e.message; }
}

document.getElementById('btn-encode').onclick = () => tryFn(encodeURI);
document.getElementById('btn-decode').onclick = () => tryFn(decodeURI);
document.getElementById('btn-encode-comp').onclick = () => tryFn(encodeURIComponent);
document.getElementById('btn-decode-comp').onclick = () => tryFn(decodeURIComponent);
document.getElementById('btn-clear-url').onclick = () => { inp.value = ''; out.value = ''; };
document.getElementById('btn-copy-url').onclick = async () => {
    if (!out.value) return;
    await navigator.clipboard.writeText(out.value);
    const m = document.getElementById('copy-msg-url');
    m.classList.remove('hidden');
    setTimeout(() => m.classList.add('hidden'), 2000);
};
</script>
@endpush
@endsection
