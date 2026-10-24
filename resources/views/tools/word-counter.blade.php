@extends('layouts.app')

@php
    $isBn = app()->getLocale() === 'bn';
@endphp

@section('page_title', ($isBn ? 'অনলাইন ওয়ার্ড কাউন্টার — শব্দ, ক্যারেক্টার ও লাইন গণনা' : 'Online Word Counter — Word, Character & Line Count') . ' — ' . __('ui.site_name'))
@section('seo_description', $isBn
    ? 'বিনামূল্যে অনলাইন ওয়ার্ড ও ক্যারেক্টার কাউন্টার। বাংলা ও ইংরেজি টেক্সটের শব্দ সংখ্যা, অক্ষর (স্পেস সহ ও ছাড়া) এবং লাইন রিয়েল-টাইমে গণনা করুন।'
    : 'Free online word and character counter. Calculate words, characters with or without spaces, and lines instantly with zero latency.')

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "WebApplication",
    "name": "{{ $isBn ? 'অনলাইন ওয়ার্ড কাউন্টার' : 'Online Word Counter' }}",
    "description": "{{ $isBn ? 'বাংলা ও ইংরেজি টেক্সটের শব্দ, অক্ষর ও লাইন রিয়েল-টাইমে গণনা করার টুল।' : 'Free online tool to count words, characters and lines instantly in your browser.' }}",
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
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "FAQPage",
    "mainEntity": [
        {
            "@@type": "Question",
            "name": "{{ $isBn ? 'এই ওয়ার্ড কাউন্টার কি বাংলা টেক্সট সঠিকভাবে গণনা করতে পারে?' : 'Does this word counter support Bengali and Unicode text?' }}",
            "acceptedAnswer": {
                "@@type": "Answer",
                "text": "{{ $isBn ? 'হ্যাঁ, এটি সম্পূর্ণ ইউনিকোড সাপোর্টেড। বাংলা, ইংরেজি সহ যেকোনো ভাষার যুক্তাক্ষর, শব্দ ও অক্ষর ১০০% নির্ভুলভাবে গণনা করে।' : 'Yes, it provides full Unicode support and accurately calculates words, characters, and spaces across all languages.' }}"
            }
        },
        {
            "@@type": "Question",
            "name": "{{ $isBn ? 'আমার টেক্সট কি কোনো সার্ভারে সেভ বা আপলোড হয়?' : 'Is my text uploaded or stored on any server?' }}",
            "acceptedAnswer": {
                "@@type": "Answer",
                "text": "{{ $isBn ? 'না, সম্পূর্ণ গণনাটি আপনার ব্রাউজারেই ক্লায়েন্ট-সাইডে সম্পন্ন হয়। আপনার কোনো টেক্সট সার্ভারে পাঠানো বা সংরক্ষণ করা হয় না।' : 'No, all calculations happen 100% locally in your browser. Your text is never stored, tracked, or sent to any server.' }}"
            }
        }
    ]
}
</script>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    @include('partials.tool-back')

    <h1 class="section-header mb-2 flex items-center justify-center gap-2">
        <i class="fa-solid fa-file-lines text-blue-600"></i>
        <span>{{ __('ui.word_counter') }}</span>
    </h1>
    <p class="section-subtitle mb-8">{{ $isBn ? 'টেক্সট পেস্ট করুন এবং তাৎক্ষণিক শব্দ, অক্ষর ও লাইন গণনা দেখুন।' : 'Paste text and instantly see word, character, and line counts.' }}</p>

    {{-- Stats Bar --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        @foreach([
            ['id' => 'stat-words', 'label' => __('ui.word_count'), 'icon' => 'fa-file-lines', 'color' => 'text-blue-600'],
            ['id' => 'stat-chars', 'label' => __('ui.char_count'), 'icon' => 'fa-font', 'color' => 'text-emerald-600'],
            ['id' => 'stat-chars-no-space', 'label' => $isBn ? 'স্পেস ছাড়া' : 'No Spaces', 'icon' => 'fa-arrows-left-right-to-line', 'color' => 'text-violet-600'],
            ['id' => 'stat-lines', 'label' => __('ui.line_count'), 'icon' => 'fa-bars', 'color' => 'text-amber-600'],
        ] as $stat)
            <div class="stat-card">
                <div class="text-xl mb-1 {{ $stat['color'] }}"><i class="fa-solid {{ $stat['icon'] }}"></i></div>
                <div class="stat-number" id="{{ $stat['id'] }}">0</div>
                <div class="stat-label">{{ $stat['label'] }}</div>
            </div>
        @endforeach
    </div>

    <div class="card p-6">
        <div class="flex items-center justify-between mb-3">
            <label class="form-label mb-0">{{ $isBn ? 'আপনার টেক্সট এখানে লিখুন:' : 'Type or paste your text here:' }}</label>
            <button id="btn-clear" class="btn-secondary btn-sm inline-flex items-center gap-1.5 hover:text-red-600">
                <i class="fa-solid fa-trash-can text-xs"></i>
                <span>{{ __('ui.cancel') }}</span>
            </button>
        </div>
        <textarea id="word-input" class="form-textarea w-full h-64 font-mono text-sm"
                  placeholder="{{ $isBn ? 'এখানে টাইপ করুন বা পেস্ট করুন...' : 'Type or paste text here...' }}" autocomplete="off" spellcheck="false"></textarea>
    </div>

    @include('partials.tool-ad')

    {{-- SEO Guide & FAQ Section --}}
    <div class="mt-8 bg-white rounded-2xl border border-gray-100 p-6 shadow-xs space-y-6">
        <div>
            <h2 class="text-base font-bold text-gray-900 mb-2 flex items-center gap-2">
                <i class="fa-solid fa-circle-question text-blue-600"></i>
                <span>{{ $isBn ? 'অনলাইন ওয়ার্ড কাউন্টার ব্যবহারের সুবিধা' : 'Benefits of Using Online Word Counter' }}</span>
            </h2>
            <p class="text-xs text-gray-600 leading-relaxed">
                {{ $isBn
                    ? 'আর্টিকেল, ফেসবুক পোস্ট, টুইটার থ্রেড, কিংবা অ্যাসাইনমেন্ট লেখার সময় শব্দ ও অক্ষরের সীমাবদ্ধতা বজায় রাখা জরুরি। আমাদের এই টুলটি তাৎক্ষণিক প্রতিটি শব্দ ও ক্যারেক্টার হিসাব করে দেয় যাতে কোনো লিমিট অতিক্রম না হয়।'
                    : 'Whether drafting articles, academic essays, or social media posts with character constraints, this real-time word counter helps you monitor your text length without any page reloads.' }}
            </p>
        </div>

        <div class="pt-4 border-t border-gray-100 grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
            <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                <h3 class="font-bold text-gray-900 mb-1 flex items-center gap-1.5">
                    <i class="fa-solid fa-bolt text-amber-500"></i>
                    <span>{{ $isBn ? 'ইনস্ট্যান্ট ক্যালকুলেশন' : 'Real-time Calculations' }}</span>
                </h3>
                <p class="text-gray-500">{{ $isBn ? 'টাইপ করার সাথে সাথেই সংখ্যা পরিবর্তিত হয়।' : 'Updates immediately as you type or paste.' }}</p>
            </div>
            <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                <h3 class="font-bold text-gray-900 mb-1 flex items-center gap-1.5">
                    <i class="fa-solid fa-lock text-emerald-500"></i>
                    <span>{{ $isBn ? '১০০% নিরাপদ ও প্রাইভেট' : '100% Client-side Privacy' }}</span>
                </h3>
                <p class="text-gray-500">{{ $isBn ? 'আপনার টেক্সট সম্পূর্ণ ব্রাউজারে সুরক্ষিত থাকে।' : 'Text stays strictly in your browser and is never stored.' }}</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const input = document.getElementById('word-input');
const sWords = document.getElementById('stat-words');
const sChars = document.getElementById('stat-chars');
const sCharsNS = document.getElementById('stat-chars-no-space');
const sLines = document.getElementById('stat-lines');

function update() {
    const text = input.value;
    sWords.textContent = text.trim() ? text.trim().split(/\s+/).length : 0;
    sChars.textContent = text.length;
    sCharsNS.textContent = text.replace(/\s/g, '').length;
    sLines.textContent = text ? text.split('\n').length : 0;
}

input.addEventListener('input', update);
document.getElementById('btn-clear').addEventListener('click', () => { input.value = ''; update(); });
</script>
@endpush
@endsection
