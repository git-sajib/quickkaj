@extends('layouts.app')

@php
    $isBn = app()->getLocale() === 'bn';
@endphp

@section('page_title', ($isBn ? 'অনলাইন JSON ফরম্যাটার ও ভ্যালিডেটর — Beautify & Minify' : 'Online JSON Formatter & Validator — Beautify & Minify') . ' — ' . __('ui.site_name'))
@section('seo_description', $isBn
    ? 'ফ্রি অনলাইন JSON ফরম্যাটার ও ভ্যালিডেটর। অগোছালো JSON কোড সহজে Beautify, Minify ও সিনট্যাক্স এরর যাচাই করুন।'
    : 'Free online JSON formatter, validator, and beautifier. Format, validate, inspect syntax errors, and minify JSON data instantly.')

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "WebApplication",
    "name": "{{ $isBn ? 'অনলাইন JSON ফরম্যাটার ও ভ্যালিডেটর' : 'Online JSON Formatter & Validator' }}",
    "description": "{{ $isBn ? 'JSON ডাটা ফরম্যাট ও ভ্যালিডেট করার ফ্রি অনলাইন ডেভেলপার টুল।' : 'Free online developer tool to format, beautify, and validate JSON data.' }}",
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
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    @include('partials.tool-back')
    <h1 class="section-header mb-2 flex items-center justify-center gap-2">
        <i class="fa-solid fa-code text-emerald-600"></i>
        <span>{{ __('ui.json_formatter') }}</span>
    </h1>
    <p class="section-subtitle mb-8">{{ $isBn ? 'JSON কোড সুন্দরভাবে ফরম্যাট করুন এবং ত্রুটি খুঁজুন।' : 'Beautify, format, and validate your JSON.' }}</p>

    <div id="status-bar" class="mb-4 hidden px-4 py-2.5 rounded-xl text-sm font-medium"></div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="card p-5">
            <div class="flex justify-between items-center mb-3">
                <label class="form-label mb-0">{{ app()->getLocale() === 'bn' ? 'ইনপুট JSON:' : 'Input JSON:' }}</label>
                <button id="btn-paste" class="btn-secondary btn-sm inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-paste text-xs"></i>
                    <span>{{ app()->getLocale() === 'bn' ? 'পেস্ট' : 'Paste' }}</span>
                </button>
            </div>
            <textarea id="json-input" class="form-textarea w-full h-72 font-mono text-xs" spellcheck="false"
                      placeholder='{"key": "value", "array": [1,2,3]}'></textarea>
            <div class="flex gap-2 mt-3">
                <button id="btn-format" class="btn-primary btn-sm inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-wand-magic-sparkles text-xs"></i>
                    <span>{{ app()->getLocale() === 'bn' ? 'ফরম্যাট' : 'Format' }}</span>
                </button>
                <button id="btn-minify" class="btn-secondary btn-sm inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-bolt text-xs"></i>
                    <span>{{ app()->getLocale() === 'bn' ? 'মিনিফাই' : 'Minify' }}</span>
                </button>
                <button id="btn-clear-json" class="btn-secondary btn-sm inline-flex items-center gap-1 text-gray-500 hover:text-red-500" title="Clear">
                    <i class="fa-solid fa-trash-can text-xs"></i>
                </button>
            </div>
        </div>

        <div class="card p-5">
            <div class="flex justify-between items-center mb-3">
                <label class="form-label mb-0">{{ app()->getLocale() === 'bn' ? 'আউটপুট:' : 'Output:' }}</label>
                <button id="btn-copy-json" class="btn-secondary btn-sm inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-copy text-xs"></i>
                    <span>{{ __('ui.copy') }}</span>
                </button>
            </div>
            <textarea id="json-output" class="form-textarea w-full h-72 font-mono text-xs" readonly spellcheck="false"></textarea>
            <p id="copy-msg-json" class="text-emerald-600 text-xs mt-2 hidden">{{ __('ui.copied') }}</p>
        </div>
    </div>

    @include('partials.tool-ad')
</div>

@push('scripts')
<script>
const inp = document.getElementById('json-input');
const out = document.getElementById('json-output');
const bar = document.getElementById('status-bar');

function showStatus(msg, ok) {
    bar.innerHTML = msg;
    bar.className = `mb-4 px-4 py-2.5 rounded-xl text-sm font-medium ${ok ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-red-50 text-red-700 border border-red-200'}`;
    bar.classList.remove('hidden');
}

document.getElementById('btn-format').onclick = () => {
    try {
        out.value = JSON.stringify(JSON.parse(inp.value), null, 2);
        showStatus('<i class="fa-solid fa-circle-check mr-1.5"></i>' + '{{ app()->getLocale() === "bn" ? "বৈধ JSON" : "Valid JSON" }}', true);
    } catch(e) {
        out.value = '';
        showStatus('<i class="fa-solid fa-triangle-exclamation mr-1.5"></i>' + e.message, false);
    }
};

document.getElementById('btn-minify').onclick = () => {
    try {
        out.value = JSON.stringify(JSON.parse(inp.value));
        showStatus('<i class="fa-solid fa-circle-check mr-1.5"></i>' + '{{ app()->getLocale() === "bn" ? "মিনিফাই সম্পন্ন" : "Minified" }}', true);
    } catch(e) {
        out.value = '';
        showStatus('<i class="fa-solid fa-triangle-exclamation mr-1.5"></i>' + e.message, false);
    }
};

document.getElementById('btn-clear-json').onclick = () => { inp.value = ''; out.value = ''; bar.classList.add('hidden'); };

document.getElementById('btn-copy-json').onclick = async () => {
    if (!out.value) return;
    await navigator.clipboard.writeText(out.value);
    const m = document.getElementById('copy-msg-json');
    m.classList.remove('hidden');
    setTimeout(() => m.classList.add('hidden'), 2000);
};

document.getElementById('btn-paste').onclick = async () => {
    try { inp.value = await navigator.clipboard.readText(); } catch {}
};
</script>
@endpush
@endsection
