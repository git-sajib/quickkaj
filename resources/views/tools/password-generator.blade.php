@extends('layouts.app')

@php
    $isBn = app()->getLocale() === 'bn';
@endphp

@section('page_title', ($isBn ? 'শক্তিশালী র‍্যান্ডম পাসওয়ার্ড জেনারেটর — Strong Password Generator' : 'Strong Random Password Generator — Secure Password Maker') . ' — ' . __('ui.site_name'))
@section('seo_description', $isBn
    ? 'ফ্রি অনলাইন শক্তিশালী পাসওয়ার্ড জেনারেটর। কাস্টম দৈর্ঘ্য, বড়-ছোট হাতের অক্ষর, সংখ্যা ও স্পেশাল ক্যারেক্টার দিয়ে হ্যাকার-প্রুফ নিরাপদ পাসওয়ার্ড তৈরি করুন।'
    : 'Generate strong, randomized passwords instantly. Customize length, uppercase, lowercase, numbers, and symbols to maximize account security.')

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "WebApplication",
    "name": "{{ $isBn ? 'শক্তিশালী র‍্যান্ডম পাসওয়ার্ড জেনারেটর' : 'Strong Random Password Generator' }}",
    "description": "{{ $isBn ? 'অনলাইন নিরাপদ ও শক্তিশালী পাসওয়ার্ড তৈরির ফ্রি টুল।' : 'Free online tool to generate strong, secure random passwords.' }}",
    "url": "{{ url()->current() }}",
    "applicationCategory": "SecurityApplication",
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
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    @include('partials.tool-back')
    <h1 class="section-header mb-2 flex items-center justify-center gap-2">
        <i class="fa-solid fa-lock text-gray-700"></i>
        <span>{{ __('ui.password_generator') }}</span>
    </h1>
    <p class="section-subtitle mb-8">{{ $isBn ? 'নিরাপদ, শক্তিশালী পাসওয়ার্ড তৈরি করুন।' : 'Generate strong, secure random passwords.' }}</p>

    <div class="card p-6 space-y-5">
        {{-- Password Output --}}
        <div>
            <label class="form-label">{{ app()->getLocale() === 'bn' ? 'তৈরি পাসওয়ার্ড:' : 'Generated Password:' }}</label>
            <div class="flex gap-2">
                <input type="text" id="pw-output" class="form-input font-mono text-base flex-1 bg-gray-50" readonly>
                <button id="btn-copy-pw" class="btn-primary btn-sm flex-shrink-0 inline-flex items-center justify-center" title="Copy">
                    <i class="fa-solid fa-copy"></i>
                </button>
            </div>
            <div id="strength-bar" class="mt-2 h-1.5 rounded-full transition-all bg-gray-200">
                <div id="strength-fill" class="h-full rounded-full transition-all w-0"></div>
            </div>
            <p id="strength-label" class="text-xs text-gray-400 mt-1"></p>
        </div>

        {{-- Length --}}
        <div>
            <label class="form-label">{{ app()->getLocale() === 'bn' ? 'দৈর্ঘ্য:' : 'Length:' }} <span id="len-label" class="text-blue-600 font-bold">16</span></label>
            <input type="range" id="pw-length" min="6" max="64" value="16" class="w-full accent-blue-600">
        </div>

        {{-- Options --}}
        <div class="grid grid-cols-2 gap-3">
            @foreach([
                ['id' => 'opt-upper', 'label' => app()->getLocale() === 'bn' ? 'বড় হাতের (A-Z)' : 'Uppercase (A-Z)', 'checked' => true],
                ['id' => 'opt-lower', 'label' => app()->getLocale() === 'bn' ? 'ছোট হাতের (a-z)' : 'Lowercase (a-z)', 'checked' => true],
                ['id' => 'opt-numbers', 'label' => app()->getLocale() === 'bn' ? 'সংখ্যা (0-9)' : 'Numbers (0-9)', 'checked' => true],
                ['id' => 'opt-symbols', 'label' => app()->getLocale() === 'bn' ? 'চিহ্ন (!@#$)' : 'Symbols (!@#$)', 'checked' => false],
            ] as $opt)
                <label class="flex items-center gap-2 text-sm cursor-pointer">
                    <input type="checkbox" id="{{ $opt['id'] }}" class="w-4 h-4 rounded text-blue-600 accent-blue-600" {{ $opt['checked'] ? 'checked' : '' }}>
                    {{ $opt['label'] }}
                </label>
            @endforeach
        </div>

        {{-- Generate --}}
        <button id="btn-generate-pw" class="btn-primary w-full text-base py-3 inline-flex items-center justify-center gap-2">
            <i class="fa-solid fa-key"></i>
            <span>{{ app()->getLocale() === 'bn' ? 'পাসওয়ার্ড তৈরি করুন' : 'Generate Password' }}</span>
        </button>
        <p id="copy-msg-pw" class="text-emerald-600 text-sm text-center hidden">{{ __('ui.copied') }}</p>
    </div>

    @include('partials.tool-ad')
</div>

@push('scripts')
<script>
const lenInput = document.getElementById('pw-length');
const lenLabel = document.getElementById('len-label');
lenInput.addEventListener('input', () => { lenLabel.textContent = lenInput.value; generate(); });

function generate() {
    const upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const lower = 'abcdefghijklmnopqrstuvwxyz';
    const numbers = '0123456789';
    const symbols = '!@#$%^&*()_+-=[]{}|;:,.<>?';

    let charset = '';
    if (document.getElementById('opt-upper').checked) charset += upper;
    if (document.getElementById('opt-lower').checked) charset += lower;
    if (document.getElementById('opt-numbers').checked) charset += numbers;
    if (document.getElementById('opt-symbols').checked) charset += symbols;

    if (!charset) { document.getElementById('pw-output').value = ''; return; }

    const len = parseInt(lenInput.value);
    const arr = new Uint32Array(len);
    crypto.getRandomValues(arr);
    const pw = Array.from(arr).map(v => charset[v % charset.length]).join('');
    document.getElementById('pw-output').value = pw;

    // Strength
    let score = 0;
    if (pw.length >= 12) score++;
    if (pw.length >= 20) score++;
    if (/[A-Z]/.test(pw)) score++;
    if (/[a-z]/.test(pw)) score++;
    if (/[0-9]/.test(pw)) score++;
    if (/[^A-Za-z0-9]/.test(pw)) score++;

    const fill = document.getElementById('strength-fill');
    const lbl = document.getElementById('strength-label');
    const pct = Math.round((score / 6) * 100);
    fill.style.width = pct + '%';
    if (score <= 2) { fill.className = 'h-full rounded-full transition-all bg-red-500'; lbl.textContent = '{{ app()->getLocale() === "bn" ? "দুর্বল" : "Weak" }}'; }
    else if (score <= 4) { fill.className = 'h-full rounded-full transition-all bg-yellow-500'; lbl.textContent = '{{ app()->getLocale() === "bn" ? "মাঝারি" : "Fair" }}'; }
    else { fill.className = 'h-full rounded-full transition-all bg-emerald-500'; lbl.textContent = '{{ app()->getLocale() === "bn" ? "শক্তিশালী" : "Strong" }}'; }
}

document.getElementById('btn-generate-pw').addEventListener('click', generate);

document.getElementById('btn-copy-pw').addEventListener('click', async () => {
    const pw = document.getElementById('pw-output').value;
    if (!pw) return;
    await navigator.clipboard.writeText(pw);
    const m = document.getElementById('copy-msg-pw');
    m.classList.remove('hidden');
    setTimeout(() => m.classList.add('hidden'), 2000);
});

['opt-upper','opt-lower','opt-numbers','opt-symbols'].forEach(id => {
    document.getElementById(id).addEventListener('change', generate);
});

generate();
</script>
@endpush
@endsection
