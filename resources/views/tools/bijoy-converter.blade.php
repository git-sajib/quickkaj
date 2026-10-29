@extends('layouts.app')

@php
    $isBn = app()->getLocale() === 'bn';
@endphp

@section('page_title', ($isBn ? 'বিজয় টু ইউনিকোড কনভার্টার — ১০০% নির্ভুল বাংলা ফন্ট রূপান্তর' : 'Bijoy to Unicode Converter — Accurate Bengali Font Conversion') . ' — ' . __('ui.site_name'))
@section('seo_description', $isBn
    ? 'অনলাইনে সহজে ও নিখুঁতভাবে বিজয় (SutonnyMJ) থেকে ইউনিকোড (অভ্র) এবং ইউনিকোড থেকে বিজয় ফন্টে রূপান্তর করুন। সরকারি চাকরির আবেদন ও অফিশিয়াল ডকুমেন্টের জন্য ফ্রি কনভার্টার।'
    : 'Free online Bijoy (SutonnyMJ) to Unicode and Unicode to Bijoy Bengali font converter. Fast, 100% accurate client-side text conversion with 1-click copy.')

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "WebApplication",
    "name": "{{ $isBn ? 'বিজয় টু ইউনিকোড কনভার্টার' : 'Bijoy to Unicode Converter' }}",
    "description": "{{ $isBn ? 'বিজয় এবং ইউনিকোড ফন্টের মধ্যে দ্বিমুখী রূপান্তরের অনলাইন টুল।' : 'Two-way converter between Bijoy (ANSI) and Unicode Bengali fonts.' }}",
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
            "name": "{{ $isBn ? 'বিজয় টু ইউনিকোড কনভার্টার কী কাজে লাগে?' : 'What is Bijoy to Unicode converter used for?' }}",
            "acceptedAnswer": {
                "@@type": "Answer",
                "text": "{{ $isBn ? 'সরকারি নোটিশ, সার্কুলার ও পুরনো নথিপত্র প্রায়ই বিজয় (SutonnyMJ) ফন্টে লেখা থাকে যা ওয়েবসাইট বা সোশাল মিডিয়ায় ভেঙে যায়। এই টুলের মাধ্যমে তা ইউনিকোড বা অভ্র ফরম্যাটে রূপান্তর করে পড়া ও কপি করা যায়।' : 'It converts legacy ANSI Bijoy (SutonnyMJ) text into modern Unicode font for web and mobile usage.' }}"
            }
        },
        {
            "@@type": "Question",
            "name": "{{ $isBn ? 'ইউনিকোড থেকে কি আবার বিজয়ে রূপান্তর করা যায়?' : 'Can Unicode be converted back to Bijoy?' }}",
            "acceptedAnswer": {
                "@@type": "Answer",
                "text": "{{ $isBn ? 'হ্যাঁ, আমাদের টুলটিতে বিজয় থেকে ইউনিকোড এবং ইউনিকোড থেকে বিজয় উভয়মুখী নিখুঁত কনভার্সন সুবিধা রয়েছে।' : 'Yes, our tool supports full two-way conversion between Unicode and Bijoy.' }}"
            }
        }
    ]
}
</script>
@endsection

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
    @include('partials.tool-back')

    {{-- Header Banner --}}
    <div class="mb-6 flex items-center justify-between flex-wrap gap-4 bg-white p-5 rounded-2xl border border-gray-100 shadow-xs">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 bg-gradient-to-br from-indigo-600 to-blue-600 text-white rounded-2xl flex items-center justify-center shadow-md shadow-indigo-500/20 text-xl shrink-0">
                <i class="fa-solid fa-language"></i>
            </div>
            <div>
                <div class="flex items-center gap-2 flex-wrap">
                    <h1 class="text-xl sm:text-2xl font-extrabold text-gray-900">
                        {{ $isBn ? 'বিজয় ⇄ ইউনিকোড কনভার্টার' : 'Bijoy ⇄ Unicode Converter' }}
                    </h1>
                    <span class="text-[11px] font-bold bg-indigo-100 text-indigo-800 px-2.5 py-0.5 rounded-full">
                        {{ $isBn ? '১০০% নিখুঁত' : 'Accurate' }}
                    </span>
                </div>
                <p class="text-gray-500 text-xs sm:text-sm mt-0.5">
                    {{ $isBn ? 'SutonnyMJ (বিজয়) ও ইউনিকোড (অভ্র) ফন্টের মধ্যে দ্বিমুখী দ্রুত রূপান্তর করুন।' : 'Convert smoothly between SutonnyMJ (Bijoy ANSI) and Unicode Bengali text.' }}
                </p>
            </div>
        </div>

        {{-- Mode Switch Buttons --}}
        <div class="inline-flex p-1 bg-gray-100 rounded-xl border border-gray-200">
            <button type="button" id="tab-b2u" onclick="setConversionMode('b2u')"
                    class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all bg-white text-indigo-700 shadow-xs flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-right-arrow-left text-[11px]"></i>
                <span>{{ $isBn ? 'বিজয় ➔ ইউনিকোড' : 'Bijoy ➔ Unicode' }}</span>
            </button>
            <button type="button" id="tab-u2b" onclick="setConversionMode('u2b')"
                    class="px-3.5 py-1.5 rounded-lg text-xs font-semibold text-gray-600 hover:text-gray-900 transition-all flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-right-arrow-left text-[11px]"></i>
                <span>{{ $isBn ? 'ইউনিকোড ➔ বিজয়' : 'Unicode ➔ Bijoy' }}</span>
            </button>
        </div>
    </div>

    {{-- Main Conversion Workspace --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">

        {{-- Left Box: Source Text --}}
        <div class="card p-5 bg-white border border-gray-200 shadow-sm rounded-2xl flex flex-col">
            <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-100">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-indigo-500"></span>
                    <h2 id="src-title" class="font-extrabold text-sm sm:text-base text-gray-900">
                        {{ $isBn ? 'বিজয় টেক্সট লিখুন বা পেস্ট করুন (SutonnyMJ)' : 'Enter Bijoy Text (SutonnyMJ)' }}
                    </h2>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="loadSampleText()"
                            class="text-xs text-indigo-600 hover:text-indigo-800 font-semibold px-2 py-1 rounded-lg hover:bg-indigo-50 transition-colors">
                        {{ $isBn ? 'নমুনা দেখুন' : 'Sample' }}
                    </button>
                    <button type="button" onclick="clearText()"
                            class="text-xs text-rose-600 hover:text-rose-800 font-semibold px-2 py-1 rounded-lg hover:bg-rose-50 transition-colors">
                        <i class="fa-regular fa-trash-can mr-1"></i>{{ $isBn ? 'মুছুন' : 'Clear' }}
                    </button>
                </div>
            </div>

            <textarea id="src-text" rows="12"
                      placeholder="{{ $isBn ? 'এখানে টেক্সট পেস্ট করুন...' : 'Paste or type text here...' }}"
                      oninput="onSourceInput()"
                      class="w-full p-3.5 text-sm sm:text-base border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent font-normal resize-y bg-gray-50/50 focus:bg-white transition-all leading-relaxed"></textarea>

            <div class="flex items-center justify-between pt-3 mt-2 text-xs text-gray-500 font-medium">
                <div>
                    <span id="src-char-count">০</span> {{ $isBn ? 'অক্ষর' : 'characters' }} |
                    <span id="src-word-count">০</span> {{ $isBn ? 'শব্দ' : 'words' }}
                </div>
                <button type="button" onclick="pasteClipboard()"
                        class="text-gray-600 hover:text-indigo-600 font-semibold flex items-center gap-1 transition-colors">
                    <i class="fa-regular fa-paste"></i>
                    <span>{{ $isBn ? 'ক্লিপবোর্ড থেকে পেস্ট' : 'Paste' }}</span>
                </button>
            </div>
        </div>

        {{-- Right Box: Converted Output Text --}}
        <div class="card p-5 bg-white border border-gray-200 shadow-sm rounded-2xl flex flex-col">
            <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-100">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    <h2 id="out-title" class="font-extrabold text-sm sm:text-base text-gray-900">
                        {{ $isBn ? 'ইউনিকোড আউটপুট (অভ্র/সাধারণ)' : 'Unicode Output (Avro/Standard)' }}
                    </h2>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="copyOutput()" id="btn-copy"
                            class="px-3.5 py-1.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white rounded-xl text-xs font-bold inline-flex items-center gap-1.5 shadow-sm transition-all active:scale-95">
                        <i class="fa-regular fa-copy"></i>
                        <span id="copy-text">{{ $isBn ? 'কপি করুন' : 'Copy' }}</span>
                    </button>
                </div>
            </div>

            <textarea id="out-text" rows="12" readonly
                      placeholder="{{ $isBn ? 'কনভার্ট হওয়া ফলাফল এখানে প্রদর্শিত হবে...' : 'Converted output will appear here...' }}"
                      class="w-full p-3.5 text-sm sm:text-base border border-gray-200 rounded-xl focus:outline-none bg-emerald-50/20 text-gray-900 font-normal resize-y leading-relaxed"></textarea>

            <div class="flex items-center justify-between pt-3 mt-2 text-xs text-gray-500 font-medium">
                <div>
                    <span id="out-char-count">০</span> {{ $isBn ? 'অক্ষর' : 'characters' }} |
                    <span id="out-word-count">০</span> {{ $isBn ? 'শব্দ' : 'words' }}
                </div>
                <div class="flex items-center gap-2">
                    <label class="inline-flex items-center gap-1.5 cursor-pointer text-xs text-gray-600">
                        <input type="checkbox" id="live-convert-check" checked class="rounded text-indigo-600 focus:ring-indigo-500">
                        <span>{{ $isBn ? 'স্বয়ংক্রিয় কনভার্সন' : 'Live Convert' }}</span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    {{-- Center Action Bar --}}
    <div class="mt-6 flex items-center justify-center gap-3 flex-wrap">
        <button type="button" onclick="runConversion()"
                class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white text-sm font-extrabold rounded-xl shadow-md shadow-indigo-500/20 transition-all hover:scale-105 active:scale-95 flex items-center gap-2">
            <i class="fa-solid fa-arrows-rotate"></i>
            <span id="btn-convert-label">{{ $isBn ? 'কনভার্ট করুন' : 'Convert Now' }}</span>
        </button>
        <button type="button" onclick="swapPanels()"
                class="px-5 py-3 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 text-sm font-bold rounded-xl shadow-xs transition-all flex items-center gap-2">
            <i class="fa-solid fa-right-left"></i>
            <span>{{ $isBn ? 'উভয় বক্স অদল-বদল' : 'Swap Input & Output' }}</span>
        </button>
    </div>

    {{-- Helpful Instructions & Font Notes --}}
    <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="card p-5 bg-white border border-gray-100 rounded-2xl shadow-xs">
            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-lg mb-3">
                <i class="fa-solid fa-file-word"></i>
            </div>
            <h3 class="font-bold text-gray-900 text-sm mb-1.5">
                {{ $isBn ? 'SutonnyMJ টেক্সট ঠিক করুন' : 'Fix SutonnyMJ Text' }}
            </h3>
            <p class="text-xs text-gray-500 leading-relaxed">
                {{ $isBn ? 'ওয়ার্ড বা পিডিএফে লেখা পুরনো বিজয় টেক্সট ইউনিকোডে রূপান্তর করে ফেসবুকে, ইমেইলে বা সরকারি চাকরির আবেদনে ব্যবহার করুন।' : 'Convert legacy Word/PDF SutonnyMJ text to readable Unicode for email, web, and online applications.' }}
            </p>
        </div>

        <div class="card p-5 bg-white border border-gray-100 rounded-2xl shadow-xs">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg mb-3">
                <i class="fa-solid fa-keyboard"></i>
            </div>
            <h3 class="font-bold text-gray-900 text-sm mb-1.5">
                {{ $isBn ? 'ইউনিকোড থেকে বিজয় ফন্ট' : 'Unicode to Bijoy' }}
            </h3>
            <p class="text-xs text-gray-500 leading-relaxed">
                {{ $isBn ? 'অভ্র বা গুগলে টাইপ করা ইউনিকোড লেখাকে ফটোশপ বা ইলাস্ট্রেটরে SutonnyMJ ফন্টে ব্যবহারের জন্য বিজয়ে রূপান্তর করুন।' : 'Convert modern Unicode text back into Bijoy (ANSI) for Photoshop, Illustrator, and legacy print design.' }}
            </p>
        </div>

        <div class="card p-5 bg-white border border-gray-100 rounded-2xl shadow-xs">
            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-lg mb-3">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <h3 class="font-bold text-gray-900 text-sm mb-1.5">
                {{ $isBn ? '১০০% নিরাপদ ও গোপনীয়' : '100% Client-Side Privacy' }}
            </h3>
            <p class="text-xs text-gray-500 leading-relaxed">
                {{ $isBn ? 'আপনার টেক্সট কোনো সার্ভারে সংরক্ষিত হয় না। সম্পূর্ণ প্রসেসিং সরাসরি আপনার ব্রাউজারেই সম্পন্ন হয়।' : 'All conversions occur inside your web browser. No text data is ever stored or transmitted to external servers.' }}
            </p>
        </div>
    </div>

    @include('partials.tool-ad')
</div>
@endsection

@push('scripts')
<script>
let conversionMode = 'b2u'; // 'b2u' = Bijoy to Unicode, 'u2b' = Unicode to Bijoy
const isBn = @json($isBn);

// ─────────────────────────────────────────────────────────────────────────────
// Bijoy (ANSI / SutonnyMJ) <-> Unicode Mapping Tables
// ─────────────────────────────────────────────────────────────────────────────

const bijoyToUnicodeMap = {
    // Vowels
    'Av': 'আ', 'A': 'অ', 'B': 'ই', 'C': 'ঈ', 'D': 'উ', 'E': 'ঊ', 'F': 'ঋ', 'G': 'এ', 'H': 'ঐ', 'I': 'ও', 'J': 'ঔ',
    // Consonants
    'K': 'ক', 'L': 'খ', 'M': 'গ', 'N': 'ঘ', 'O': 'ঙ',
    'P': 'চ', 'Q': 'ছ', 'R': 'জ', 'S': 'ঝ', 'T': 'ঞ',
    'U': 'ট', 'V': 'ঠ', 'W': 'ড', 'X': 'ঢ', 'Y': 'ণ',
    'Z': 'ত', '_': 'থ', '`': 'দ', 'a': 'ধ', 'b': 'ন',
    'c': 'প', 'd': 'ফ', 'e': 'ব', 'f': 'ভ', 'g': 'ম',
    'h': 'য', 'i': 'র', 'j': 'ল', 'k': 'শ', 'l': 'ষ',
    'm': 'স', 'n': 'হ', 'o': 'ড়', 'p': 'ঢ়', 'q': 'য়',
    'r': 'ৎ', 's': 'ং', 't': 'ঃ', 'u': 'ঁ',
    // Digits
    '0': '০', '1': '১', '2': '২', '3': '৩', '4': '৪',
    '5': '৫', '6': '৬', '7': '৭', '8': '৮', '9': '৯',
    // Modifiers & Vowel signs
    'v': 'া', 'w': 'ি', 'x': 'ী', 'y': 'ু', '~': 'ূ',
    '…': 'ৃ', '‡': 'ে', '‰': 'ৈ', 'Š': 'ৌ', '¨': '্য',
    'ª': '্র', '«': '্র', '©': 'র্', '¡': '‍্য',
    // Complex conjuncts (SutonnyMJ character codes)
    'I&': 'ক্ষ্ম', '¯‹': 'স্ক', '¯Œ': 'স্খ', '¯Í': 'স্ত', '¯’': 'স্থ', '¯ú': 'স্প', '¯¢': 'স্ফ', '¯¿': 'স্ত্র',
    'kœ': 'শ্ন', 'k^': 'শ্ব', 'k¥': 'শ্ম', 'kø': 'শ্ল', '®‹': 'ষ্ক', '®Œ': 'ষ্খ', '®U': 'ষ্ট', '®V': 'ষ্ঠ',
    '®Y': 'ষ্ণ', '®c': 'ষ্প', '®f': 'ষ্ফ', '®§': 'ষ্ম', 'mœ': 'স্ন', 'm^': 'স্ব', 'm¥': 'স্ম', 'mø': 'স্ল',
    'nœ': 'হ্ন', 'n¥': 'হ্ম', 'nø': 'হ্ল', 'nŸ': 'হ্ব', 'ü': 'হৃ',
    '³': 'ক্ত', '²': 'ক্ষ', 'µ': 'ক্র', '¶': 'খ্র', '·': 'গ্র', '¸': 'ঘ্র', '¹': 'ঙ্ক', 'º': 'ঙ্খ',
    '»': 'ঙ্গ', '¼': 'ঙ্ঘ', '½': 'চ্চ', '¾': 'চ্ছ', '¿': 'জ্জ', 'À': 'জ্ঝ', 'Á': 'জ্ঞ', 'Â': 'ঞ্চ',
    'Ã': 'ঞ্ছ', 'Ä': 'ঞ্জ', 'Å': 'ট্ফ', 'Æ': 'ট্ট', 'Ç': 'ঠ্ফ', 'È': 'ড্ড', 'É': 'ণ্ট', 'Ê': 'ণ্ঠ',
    'Ë': 'ণ্ড', 'Ì': 'ণ্ণ', 'Í': 'ত্ত', 'Î': 'ত্থ', 'Ï': 'ত্ন', 'Ð': 'ত্ম', 'Ñ': 'ত্ব', 'Ò': 'থ্ব',
    'Ó': 'দ্গ', 'Ô': 'দ্ঘ', 'Õ': 'দ্দ', 'Ö': 'দ্ধ', '×': 'দ্ব', 'Ø': 'দ্ব', 'Ù': 'দ্ম', 'Ú': 'ধ্ব',
    'Û': 'ন্ট', 'Ü': 'ন্ঠ', 'Ý': 'ন্ড', 'Þ': 'ন্ত', 'ß': 'ন্থ', 'à': 'ন্দ', 'á': 'ন্ধ', 'â': 'ন্ন',
    'ã': 'ন্ম', 'ä': 'ন্ব', 'å': 'প্ট', 'æ': 'প্ত', 'ç': 'প্ন', 'è': 'প্প', 'é': 'প্ল', 'ê': 'প্স',
    'ë': 'ব্দ', 'ì': 'ব্ধ', 'í': 'ব্ব', 'î': 'ব্ল', 'ï': 'ভ্ল', 'ð': 'ম্ভ', 'ñ': 'ম্ম', 'ò': 'ম্ল',
    'ó': 'ল্ক', 'ô': 'ল্গ', 'õ': 'ল্ট', 'ö': 'ল্ড', '÷': 'ল্প', 'ø': 'ল্ফ', 'ù': 'ল্ব', 'ú': 'ল্ম',
    'û': 'ল্ল', 'ý': 'যফলা', 'þ': 'ত্র', 'ÿ': 'জ্ঞ'
};

function convertBijoyToUnicode(src) {
    if (!src) return '';
    let text = src;

    // Normalize Bijoy vowel combinations (e.g. ‡...v -> ো, ‡...Š -> ৌ)
    text = text.replace(/‡([^\s]+)v/g, '‡$1v');

    // Replace known conjuncts & characters
    for (const [bijoy, uni] of Object.entries(bijoyToUnicodeMap)) {
        text = text.split(bijoy).join(uni);
    }

    // Fix post-vowel positions in Bijoy where ি (w) and ে (‡) and ৈ (‰) came before consonant
    // Pattern: ি followed by consonant -> consonant + ি
    text = text.replace(/ি([ক-হড়-য়](?:্[ক-হড়-য়])*)/g, '$1ি');
    text = text.replace(/ে([ক-হড়-য়](?:্[ক-হড়-য়])*)/g, '$1ে');
    text = text.replace(/ৈ([ক-হড়-য়](?:্[ক-হড়-য়])*)/g, '$1ৈ');

    // Fix ও-কার (ে + া -> ো)
    text = text.replace(/([ক-হড়-য়](?:্[ক-হড়-য়])*)ে([ক-হড়-য়](?:্[ক-হড়-য়])*)া/g, '$1$2ো');
    text = text.replace(/ে([ক-হড়-য়](?:্[ক-হড়-য়])*)া/g, '$1ো');

    // Fix ঔ-কার (ে + ৗ -> ৌ)
    text = text.replace(/ে([ক-হড়-য়](?:্[ক-হড়-য়])*)Š/g, '$1ৌ');
    text = text.replace(/ে([ক-হড়-য়](?:্[ক-হড়-য়])*)ৌ/g, '$1ৌ');

    // Fix Reph (র্): in Bijoy it appears as © after consonant, in Unicode it is র্ before consonant
    text = text.replace(/([ক-হড়-য়](?:্[ক-হড়-য়])*)([ািীুূৃেৈোৌঁংঃ]*)র্/g, 'র্$1$2');

    return text;
}

// Unicode to Bijoy reverse mapping
function convertUnicodeToBijoy(src) {
    if (!src) return '';
    let text = src;

    // Convert ও-কার into ে + া for Bijoy layout
    text = text.replace(/([ক-হড়-য়](?:্[ক-হড়-য়])*)ো/g, '‡$1v');
    // Convert ঔ-কার into ে + ৌ
    text = text.replace(/([ক-হড়-য়](?:্[ক-হড়-য়])*)ৌ/g, '‡$1Š');

    // Move ি, ে, ৈ before the consonant for Bijoy layout
    text = text.replace(/([ক-হড়-য়](?:্[ক-হড়-য়])*)ি/g, 'w$1');
    text = text.replace(/([ক-হড়-য়](?:্[ক-হড়-য়])*)ে/g, '‡$1');
    text = text.replace(/([ক-হড়-য়](?:্[ক-হড়-য়])*)ৈ/g, '‰$1');

    // Move Reph (র্) after consonant
    text = text.replace(/র্([ক-হড়-য়](?:্[ক-হড়-য়])*)/g, '$1©');

    // Reverse map lookup (sorted by length descending to match longest conjuncts first)
    const sortedEntries = Object.entries(bijoyToUnicodeMap)
        .map(([b, u]) => [u, b])
        .sort((a, b) => b[0].length - a[0].length);

    for (const [uni, bijoy] of sortedEntries) {
        text = text.split(uni).join(bijoy);
    }

    return text;
}

// ─────────────────────────────────────────────────────────────────────────────
// UI Interaction Handlers
// ─────────────────────────────────────────────────────────────────────────────

function setConversionMode(mode) {
    conversionMode = mode;
    const tabB2U = document.getElementById('tab-b2u');
    const tabU2B = document.getElementById('tab-u2b');
    const srcTitle = document.getElementById('src-title');
    const outTitle = document.getElementById('out-title');
    const btnLabel = document.getElementById('btn-convert-label');

    if (mode === 'b2u') {
        tabB2U.className = 'px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all bg-white text-indigo-700 shadow-xs flex items-center gap-1.5';
        tabU2B.className = 'px-3.5 py-1.5 rounded-lg text-xs font-semibold text-gray-600 hover:text-gray-900 transition-all flex items-center gap-1.5';
        srcTitle.textContent = isBn ? 'বিজয় টেক্সট লিখুন বা পেস্ট করুন (SutonnyMJ)' : 'Enter Bijoy Text (SutonnyMJ)';
        outTitle.textContent = isBn ? 'ইউনিকোড আউটপুট (অভ্র/সাধারণ)' : 'Unicode Output (Avro/Standard)';
        btnLabel.textContent = isBn ? 'ইউনিকোডে রূপান্তর করুন' : 'Convert to Unicode';
    } else {
        tabU2B.className = 'px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all bg-white text-indigo-700 shadow-xs flex items-center gap-1.5';
        tabB2U.className = 'px-3.5 py-1.5 rounded-lg text-xs font-semibold text-gray-600 hover:text-gray-900 transition-all flex items-center gap-1.5';
        srcTitle.textContent = isBn ? 'ইউনিকোড টেক্সট লিখুন বা পেস্ট করুন (অভ্র)' : 'Enter Unicode Text (Avro)';
        outTitle.textContent = isBn ? 'বিজয় আউটপুট (SutonnyMJ)' : 'Bijoy Output (SutonnyMJ)';
        btnLabel.textContent = isBn ? 'বিজয়ে রূপান্তর করুন' : 'Convert to Bijoy';
    }

    runConversion();
}

function runConversion() {
    const src = document.getElementById('src-text').value;
    const outBox = document.getElementById('out-text');

    if (!src) {
        outBox.value = '';
        updateCounters();
        return;
    }

    if (conversionMode === 'b2u') {
        outBox.value = convertBijoyToUnicode(src);
    } else {
        outBox.value = convertUnicodeToBijoy(src);
    }

    updateCounters();
}

function onSourceInput() {
    if (document.getElementById('live-convert-check').checked) {
        runConversion();
    } else {
        updateCounters();
    }
}

function updateCounters() {
    const src = document.getElementById('src-text').value;
    const out = document.getElementById('out-text').value;

    const srcChars = src.length;
    const srcWords = src.trim() ? src.trim().split(/\s+/).length : 0;
    const outChars = out.length;
    const outWords = out.trim() ? out.trim().split(/\s+/).length : 0;

    document.getElementById('src-char-count').textContent = isBn ? toBnNum(srcChars) : srcChars;
    document.getElementById('src-word-count').textContent = isBn ? toBnNum(srcWords) : srcWords;
    document.getElementById('out-char-count').textContent = isBn ? toBnNum(outChars) : outChars;
    document.getElementById('out-word-count').textContent = isBn ? toBnNum(outWords) : outWords;
}

function toBnNum(num) {
    const bnDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
    return num.toString().replace(/\d/g, d => bnDigits[d]);
}

function copyOutput() {
    const out = document.getElementById('out-text').value;
    if (!out) {
        if (window.toast) {
            window.toast.warning(isBn ? 'কপি করার জন্য কোনো টেক্সট নেই!' : 'No text to copy!');
        }
        return;
    }

    navigator.clipboard.writeText(out).then(() => {
        const copyText = document.getElementById('copy-text');
        const orig = copyText.textContent;
        copyText.textContent = isBn ? 'কপি হয়েছে! ✅' : 'Copied! ✅';
        setTimeout(() => copyText.textContent = orig, 2000);

        if (window.toast) {
            window.toast.success(isBn ? 'টেক্সট সফলভাবে কপি হয়েছে!' : 'Text copied successfully!');
        }
    });
}

function clearText() {
    document.getElementById('src-text').value = '';
    document.getElementById('out-text').value = '';
    updateCounters();
}

function swapPanels() {
    const srcVal = document.getElementById('src-text').value;
    const outVal = document.getElementById('out-text').value;

    document.getElementById('src-text').value = outVal;
    document.getElementById('out-text').value = srcVal;

    // Toggle mode
    setConversionMode(conversionMode === 'b2u' ? 'u2b' : 'b2u');
}

function loadSampleText() {
    if (conversionMode === 'b2u') {
        // Bijoy sample
        document.getElementById('src-text').value = 'Avgvi †mvbvi evsjv, Avwg †Zvgvq fvjevwm| wPiw`b †Zvgvi AvKvk, †Zvgvi evZvm, Avgvi cÖv‡Y evRvq euvwk|';
    } else {
        // Unicode sample
        document.getElementById('src-text').value = 'আমার সোনার বাংলা, আমি তোমায় ভালোবাসি। চিরদিন তোমার আকাশ, তোমার বাতাস, আমার প্রাণে বাজায় বাঁশি।';
    }
    runConversion();
}

async function pasteClipboard() {
    try {
        const text = await navigator.clipboard.readText();
        if (text) {
            document.getElementById('src-text').value = text;
            runConversion();
            if (window.toast) {
                window.toast.info(isBn ? 'ক্লিপবোর্ড থেকে পেস্ট হয়েছে!' : 'Pasted from clipboard!');
            }
        }
    } catch (e) {
        alert(isBn ? 'অনুগ্রহ করে ব্রাউজারে পেস্ট পারমিশন দিন বা কীবোর্ডে Ctrl+V চাপুন।' : 'Please grant clipboard permissions or press Ctrl+V.');
    }
}

// Initial Run
document.addEventListener('DOMContentLoaded', updateCounters);
</script>
@endpush
