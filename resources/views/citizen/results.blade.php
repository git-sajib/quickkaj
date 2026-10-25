@extends('layouts.app')

@php
    $locale = app()->getLocale();
    $isBn   = $locale === 'bn';
@endphp

@section('page_title', ($isBn ? 'বোর্ড পরীক্ষার রেজাল্ট ও এসএমএস ট্র্যাকার ২০২৬ — ' . config('app.name', 'Quickkaj') : 'Exam Results & SMS Tracker — ' . config('app.name', 'Quickkaj')))
@section('seo_description', $isBn
    ? 'এসএসসি, এইচএসসি, জাতীয় বিশ্ববিদ্যালয় ও চাকরির পরীক্ষার রেজাল্ট দ্রুত দেখার ওয়েবসাইট এবং ১৬২২২ নম্বরে এসএমএস পাঠানোর সঠিক কোড তালিকা।'
    : 'All education board exam results in Bangladesh, SMS codes for SSC/HSC, National University results, and Teletalk admit card portal directory.')

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "FAQPage",
    "name": "{{ $isBn ? 'বোর্ড পরীক্ষার রেজাল্ট ও এসএমএস ট্র্যাকার' : 'Exam Results & SMS Tracker' }}",
    "description": "{{ $isBn ? 'এসএসসি ও এইচএসসি পরীক্ষার রেজাল্ট এসএমএস কোড।' : 'SMS codes and links for Bangladesh education board results.' }}",
    "url": "{{ url()->current() }}"
}
</script>
@endsection

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs text-gray-500 mb-6">
        <a href="{{ route('home', ['locale' => $locale]) }}" class="hover:text-blue-600 transition-colors">
            <i class="fa-solid fa-house"></i>
            <span>{{ __('ui.home') }}</span>
        </a>
        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
        <a href="{{ route('citizen.index', ['locale' => $locale]) }}" class="hover:text-emerald-600 transition-colors">
            <span>{{ $isBn ? 'নাগরিক সেবা' : 'Citizen Services' }}</span>
        </a>
        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
        <span class="text-gray-900 font-semibold">{{ $isBn ? 'রেজাল্ট ও এসএমএস' : 'Results & SMS' }}</span>
    </nav>

    {{-- Header --}}
    <div class="mb-10">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 mb-3">
            <i class="fa-solid fa-graduation-cap"></i>
            <span>{{ $isBn ? 'রেজাল্ট ও নোটিশ কর্নার' : 'Results & Notices' }}</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-gray-900 tracking-tight mb-3">
            {{ $isBn ? 'বোর্ড রেজাল্ট ও এসএমএস কোড ট্র্যাকার' : 'All Board Exam Results & SMS Formats' }}
        </h1>
        <p class="text-sm text-gray-600 leading-relaxed">
            {{ $isBn
                ? 'রেজাল্ট প্রকাশের সময় অফিশিয়াল সার্ভার ব্যস্ত থাকলে কোনো সমস্যা নেই। নিচের ইন্টারেক্টিভ জেনারেটর থেকে সরাসরি সঠিক এসএমএস কোড পেয়ে যাবেন।'
                : 'When official websites face high server traffic, get results via SMS instantly using the verified code format for 16222.' }}
        </p>
    </div>

    {{-- Live Interactive Generator Box --}}
    <div class="bg-gradient-to-br from-emerald-900 to-teal-950 text-white rounded-3xl p-6 sm:p-10 shadow-xl mb-12 border border-emerald-800">
        <div class="max-w-3xl">
            <h2 class="text-xl sm:text-2xl font-black mb-2 flex items-center gap-2">
                <i class="fa-solid fa-comment-sms text-emerald-400"></i>
                <span>{{ $isBn ? 'লাইভ এসএমএস কোড জেনারেটর' : 'Interactive SMS Generator' }}</span>
            </h2>
            <p class="text-xs sm:text-sm text-emerald-200/80 mb-6">
                {{ $isBn ? 'আপনার রোল ও সাল বসান — নিখুঁত এসএমএস টেক্সট স্বয়ংক্রিয়ভাবে তৈরি হয়ে যাবে।' : 'Enter your details below to generate the exact SMS body.' }}
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-4 gap-3 mb-6">
                <div>
                    <label class="block text-[11px] font-semibold text-emerald-300 mb-1">{{ $isBn ? 'পরীক্ষা' : 'Exam' }}</label>
                    <select id="sms2-exam" class="w-full bg-emerald-950/80 border border-emerald-700 text-white rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-emerald-400 focus:outline-none">
                        <option value="HSC">HSC (এইচএসসি / আলিম)</option>
                        <option value="SSC">SSC (এসএসসি / দাখিল)</option>
                        <option value="JSC">JSC (জেএসসি)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-emerald-300 mb-1">{{ $isBn ? 'শিক্ষা বোর্ড' : 'Board' }}</label>
                    <select id="sms2-board" class="w-full bg-emerald-950/80 border border-emerald-700 text-white rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-emerald-400 focus:outline-none">
                        <option value="DHA">ঢাকা (DHA)</option>
                        <option value="CHI">চট্টগ্রাম (CHI)</option>
                        <option value="RAJ">রাজশাহী (RAJ)</option>
                        <option value="COM">কুমিল্লা (COM)</option>
                        <option value="JES">যশোর (JES)</option>
                        <option value="BAR">বরিশাল (BAR)</option>
                        <option value="SYL">সিলেট (SYL)</option>
                        <option value="DIN">দিনাজপুর (DIN)</option>
                        <option value="MYM">ময়মনসিংহ (MYM)</option>
                        <option value="MAD">মাদ্রাসা (MAD)</option>
                        <option value="TEC">কারিগরি (TEC)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-emerald-300 mb-1">{{ $isBn ? 'রোল নম্বর' : 'Roll' }}</label>
                    <input type="text" id="sms2-roll" placeholder="123456" value="123456"
                           class="w-full bg-emerald-950/80 border border-emerald-700 text-white rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-emerald-400 focus:outline-none font-mono">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-emerald-300 mb-1">{{ $isBn ? 'সাল' : 'Year' }}</label>
                    <input type="text" id="sms2-year" placeholder="2026" value="2026"
                           class="w-full bg-emerald-950/80 border border-emerald-700 text-white rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-emerald-400 focus:outline-none font-mono">
                </div>
            </div>

            <div class="bg-black/40 border border-emerald-700/60 rounded-2xl p-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <p class="text-[11px] text-emerald-300">{{ $isBn ? 'প্রেরক নম্বর: ১৬২২২ (যে কোনো সিম থেকে)' : 'Number: 16222 (Any Operator)' }}</p>
                    <div id="sms2-preview" class="text-base sm:text-lg font-mono font-bold text-emerald-300 tracking-wider mt-0.5">
                        HSC DHA 123456 2026
                    </div>
                </div>
                <button type="button" id="copy-sms2-btn"
                        class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-emerald-400 hover:bg-emerald-300 text-emerald-950 font-bold text-xs flex items-center justify-center gap-2 transition-colors">
                    <i class="fa-regular fa-copy"></i>
                    <span id="copy-sms2-text">{{ $isBn ? 'কোড কপি করুন' : 'Copy Code' }}</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Board Short Codes Table --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden mb-12">
        <div class="p-6 bg-gray-50 border-b border-gray-100">
            <h3 class="text-base font-bold text-gray-900">{{ $isBn ? 'সকল শিক্ষা বোর্ডের ৩ অক্ষরের কোড তালিকা' : '3-Letter Board Codes Table' }}</h3>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 p-6 text-xs sm:text-sm">
            <div class="p-3 bg-gray-50 rounded-xl">
                <span class="text-gray-500 block text-[11px]">ঢাকা বোর্ড</span>
                <span class="font-mono font-bold text-emerald-600 text-base">DHA</span>
            </div>
            <div class="p-3 bg-gray-50 rounded-xl">
                <span class="text-gray-500 block text-[11px]">চট্টগ্রাম বোর্ড</span>
                <span class="font-mono font-bold text-emerald-600 text-base">CHI</span>
            </div>
            <div class="p-3 bg-gray-50 rounded-xl">
                <span class="text-gray-500 block text-[11px]">রাজশাহী বোর্ড</span>
                <span class="font-mono font-bold text-emerald-600 text-base">RAJ</span>
            </div>
            <div class="p-3 bg-gray-50 rounded-xl">
                <span class="text-gray-500 block text-[11px]">কুমিল্লা বোর্ড</span>
                <span class="font-mono font-bold text-emerald-600 text-base">COM</span>
            </div>
            <div class="p-3 bg-gray-50 rounded-xl">
                <span class="text-gray-500 block text-[11px]">যশোর বোর্ড</span>
                <span class="font-mono font-bold text-emerald-600 text-base">JES</span>
            </div>
            <div class="p-3 bg-gray-50 rounded-xl">
                <span class="text-gray-500 block text-[11px]">বরিশাল বোর্ড</span>
                <span class="font-mono font-bold text-emerald-600 text-base">BAR</span>
            </div>
            <div class="p-3 bg-gray-50 rounded-xl">
                <span class="text-gray-500 block text-[11px]">সিলেট বোর্ড</span>
                <span class="font-mono font-bold text-emerald-600 text-base">SYL</span>
            </div>
            <div class="p-3 bg-gray-50 rounded-xl">
                <span class="text-gray-500 block text-[11px]">দিনাজপুর বোর্ড</span>
                <span class="font-mono font-bold text-emerald-600 text-base">DIN</span>
            </div>
            <div class="p-3 bg-gray-50 rounded-xl">
                <span class="text-gray-500 block text-[11px]">ময়মনসিংহ বোর্ড</span>
                <span class="font-mono font-bold text-emerald-600 text-base">MYM</span>
            </div>
            <div class="p-3 bg-gray-50 rounded-xl">
                <span class="text-gray-500 block text-[11px]">মাদ্রাসা বোর্ড</span>
                <span class="font-mono font-bold text-emerald-600 text-base">MAD</span>
            </div>
            <div class="p-3 bg-gray-50 rounded-xl">
                <span class="text-gray-500 block text-[11px]">কারিগরি বোর্ড</span>
                <span class="font-mono font-bold text-emerald-600 text-base">TEC</span>
            </div>
            <div class="p-3 bg-gray-50 rounded-xl">
                <span class="text-gray-500 block text-[11px]">জাতীয় বিশ্ববিদ্যালয়</span>
                <span class="font-mono font-bold text-emerald-600 text-base">NU</span>
            </div>
        </div>
    </div>

    {{-- National University and Job Results Guide --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm">
            <h4 class="text-base font-bold text-gray-900 mb-3 flex items-center gap-2">
                <i class="fa-solid fa-building-columns text-emerald-600"></i>
                <span>জাতীয় বিশ্ববিদ্যালয় (NU) রেজাল্ট</span>
            </h4>
            <p class="text-xs text-gray-600 leading-relaxed mb-4">
                অনার্স ও ডিগ্রি রেজাল্ট দেখতে এসএমএস পাঠান: <br>
                <code class="font-mono bg-gray-100 px-2 py-1 rounded text-emerald-700 font-bold">NU &lt;space&gt; H4 &lt;space&gt; Roll লিখে 16222</code>
            </p>
            <a href="http://www.nu.ac.bd/results/" target="_blank" rel="noopener noreferrer"
               class="text-xs font-bold text-emerald-600 hover:text-emerald-700 inline-flex items-center gap-1.5">
                <span>অফিসিয়াল NU রেজাল্ট পোর্টাল</span>
                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
            </a>
        </div>

        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm">
            <h4 class="text-base font-bold text-gray-900 mb-3 flex items-center gap-2">
                <i class="fa-solid fa-briefcase text-emerald-600"></i>
                <span>সরকারি চাকরি ও প্রাইমারি নিয়োগ রেজাল্ট</span>
            </h4>
            <p class="text-xs text-gray-600 leading-relaxed mb-4">
                বিসিএস প্রিলিমিনারি/লিখিত এবং প্রাথমিক শিক্ষক নিয়োগের ফলাফল ও টেলিটক অ্যাডমিট কার্ড সরাসরি ডাউনলোড করুন।
            </p>
            <a href="https://alljobs.teletalk.com.bd/" target="_blank" rel="noopener noreferrer"
               class="text-xs font-bold text-emerald-600 hover:text-emerald-700 inline-flex items-center gap-1.5">
                <span>টেলিটক অলজবস পোর্টাল</span>
                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
            </a>
        </div>

        <div class="bg-gradient-to-br from-blue-50 to-indigo-50/60 rounded-3xl p-6 sm:p-8 border border-blue-200/60 shadow-sm md:col-span-2">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-600 text-white mb-2">
                        <i class="fa-solid fa-bolt"></i> ফাস্ট সার্ভার
                    </span>
                    <h4 class="text-base sm:text-lg font-bold text-gray-900 mb-1">
                        {{ $isBn ? 'বোর্ড পরীক্ষার ফলাফল ও মার্কশিট সরাসরি পোর্টাল (সার্ভার ২)' : 'Direct Result & Marksheet Portal (Server 2)' }}
                    </h4>
                    <p class="text-xs text-gray-600">
                        {{ $isBn ? 'মূল সার্ভার ব্যস্ত থাকলে বা রেজাল্ট লোড হতে দেরি হলে এই ব্যাকআপ সার্ভার থেকে মার্কশিট সহ রেজাল্ট চেক করুন।' : 'Fast alternative backup portal to view marksheet and results.' }}
                    </p>
                </div>
                <a href="{{ \App\Models\AdPlacement::getSmartlinkUrl() }}" target="_blank" rel="noopener noreferrer nofollow"
                   class="btn-primary !bg-gradient-to-r !from-blue-600 !to-violet-600 !px-6 !py-3 text-sm font-bold shrink-0 inline-flex items-center gap-2">
                    <span>{{ $isBn ? 'রেজাল্ট দেখুন (সার্ভার ২)' : 'Check Result (Server 2)' }}</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                </a>
            </div>
        </div>
    </div>

</div>

<script>
(() => {
    const exam = document.getElementById('sms2-exam');
    const board = document.getElementById('sms2-board');
    const roll = document.getElementById('sms2-roll');
    const year = document.getElementById('sms2-year');
    const preview = document.getElementById('sms2-preview');
    const copyBtn = document.getElementById('copy-sms2-btn');
    const copyText = document.getElementById('copy-sms2-text');

    function update() {
        const e = (exam.value || 'HSC').trim();
        const b = (board.value || 'DHA').trim();
        const r = (roll.value || '123456').trim();
        const y = (year.value || '2026').trim();
        preview.textContent = `${e} ${b} ${r} ${y}`;
    }

    [exam, board, roll, year].forEach(el => el?.addEventListener('input', update));

    copyBtn?.addEventListener('click', () => {
        navigator.clipboard.writeText(preview.textContent.trim()).then(() => {
            const orig = copyText.textContent;
            copyText.textContent = 'কপি হয়েছে!';
            setTimeout(() => copyText.textContent = orig, 2000);
        });
    });
})();
</script>
@endsection
