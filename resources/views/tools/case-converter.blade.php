@extends('layouts.app')

@php
    $isBn = app()->getLocale() === 'bn';
@endphp

@section('page_title', ($isBn ? 'টেক্সট কেস কনভার্টার — UPPERCASE, lowercase, Title Case রূপান্তর' : 'Text Case Converter — UPPERCASE, lowercase, Title Case') . ' — ' . __('ui.site_name'))
@section('seo_description', $isBn
    ? 'অনলাইন টেক্সট কেস কনভার্টার। যেকোনো টেক্সটকে সহজে Uppercase, Lowercase, Title Case, Sentence Case ও CamelCase-এ এক ক্লিকে রূপান্তর করুন।'
    : 'Free online text case converter. Convert any text between UPPERCASE, lowercase, Title Case, Sentence case, camelCase, snake_case instantly.')

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "WebApplication",
    "name": "{{ $isBn ? 'টেক্সট কেস কনভার্টার' : 'Text Case Converter' }}",
    "description": "{{ $isBn ? 'যেকোনো টেক্সটের কেস রূপান্তর করার ফ্রি অনলাইন টুল।' : 'Free online tool to change text case between UPPERCASE, lowercase, and Title Case.' }}",
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
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    @include('partials.tool-back')
    <h1 class="section-header mb-2 flex items-center justify-center gap-2">
        <i class="fa-solid fa-text-height text-violet-600"></i>
        <span>{{ __('ui.case_converter') }}</span>
    </h1>
    <p class="section-subtitle mb-8">{{ $isBn ? 'টেক্সটকে বিভিন্ন কেসে রূপান্তর করুন।' : 'Convert your text to different cases instantly.' }}</p>

    <div class="card p-6">
        <label class="form-label">{{ app()->getLocale() === 'bn' ? 'টেক্সট লিখুন:' : 'Input text:' }}</label>
        <textarea id="case-input" class="form-textarea w-full h-40 mb-4 font-mono text-sm"
                  placeholder="{{ app()->getLocale() === 'bn' ? 'এখানে টেক্সট লিখুন...' : 'Type text here...' }}"></textarea>

        <div class="flex flex-wrap gap-2 mb-4">
            @foreach([
                ['id' => 'btn-upper', 'label' => 'UPPERCASE'],
                ['id' => 'btn-lower', 'label' => 'lowercase'],
                ['id' => 'btn-title', 'label' => 'Title Case'],
                ['id' => 'btn-sentence', 'label' => 'Sentence case'],
                ['id' => 'btn-camel', 'label' => 'camelCase'],
                ['id' => 'btn-snake', 'label' => 'snake_case'],
                ['id' => 'btn-kebab', 'label' => 'kebab-case'],
                ['id' => 'btn-reverse', 'label' => app()->getLocale() === 'bn' ? 'উল্টো' : 'Reverse'],
            ] as $btn)
                <button id="{{ $btn['id'] }}" class="btn-secondary btn-sm font-mono">{{ $btn['label'] }}</button>
            @endforeach
        </div>

        <label class="form-label">{{ app()->getLocale() === 'bn' ? 'ফলাফল:' : 'Output:' }}</label>
        <textarea id="case-output" class="form-textarea w-full h-40 mb-3 font-mono text-sm" readonly></textarea>
        <button id="btn-copy-case" class="btn-primary btn-sm inline-flex items-center gap-1.5">
            <i class="fa-solid fa-copy text-xs"></i>
            <span>{{ __('ui.copy') }}</span>
        </button>
        <span id="copy-msg" class="text-emerald-600 text-xs ml-2 hidden">{{ __('ui.copied') }}</span>
    </div>

    @include('partials.tool-ad')
</div>

@push('scripts')
<script>
const inp = document.getElementById('case-input');
const out = document.getElementById('case-output');

function toTitle(s) { return s.replace(/\w\S*/g, t => t.charAt(0).toUpperCase() + t.slice(1).toLowerCase()); }
function toSentence(s) { return s.toLowerCase().replace(/(^\s*\w|[.!?]\s*\w)/g, c => c.toUpperCase()); }
function toCamel(s) { return s.toLowerCase().replace(/[^a-zA-Z0-9]+(.)/g, (m, c) => c.toUpperCase()); }
function toSnake(s) { return s.toLowerCase().replace(/\s+/g, '_'); }
function toKebab(s) { return s.toLowerCase().replace(/\s+/g, '-'); }

document.getElementById('btn-upper').onclick = () => { out.value = inp.value.toUpperCase(); };
document.getElementById('btn-lower').onclick = () => { out.value = inp.value.toLowerCase(); };
document.getElementById('btn-title').onclick = () => { out.value = toTitle(inp.value); };
document.getElementById('btn-sentence').onclick = () => { out.value = toSentence(inp.value); };
document.getElementById('btn-camel').onclick = () => { out.value = toCamel(inp.value); };
document.getElementById('btn-snake').onclick = () => { out.value = toSnake(inp.value); };
document.getElementById('btn-kebab').onclick = () => { out.value = toKebab(inp.value); };
document.getElementById('btn-reverse').onclick = () => { out.value = inp.value.split('').reverse().join(''); };

document.getElementById('btn-copy-case').onclick = async () => {
    if (!out.value) return;
    await navigator.clipboard.writeText(out.value);
    const msg = document.getElementById('copy-msg');
    msg.classList.remove('hidden');
    setTimeout(() => msg.classList.add('hidden'), 2000);
};
</script>
@endpush
@endsection
