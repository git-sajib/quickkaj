@extends('layouts.app')

@php
    $isBn = app()->getLocale() === 'bn';
@endphp

@section('page_title', ($isBn ? 'টেলিটক সরকারি চাকরির SMS ফরম্যাট জেনারেটর — ১ ক্লিকে ১ ও ২য় এসএমএস তৈরি' : 'Teletalk Job SMS Format Generator — 1st & 2nd SMS 16222') . ' — ' . __('ui.site_name'))
@section('seo_description', $isBn
    ? 'সরকারি চাকরির আবেদনের পর টেলিটক প্রিপেইড সিম দিয়ে ১৬২২২ নম্বরে ১ম ও ২য় এসএমএস ফরম্যাট তৈরির ফ্রি অনলাইন টুল। ভুল ছাড়া ১ ক্লিকেই এসএমএস কপি করুন ও ফি জমা দিন।'
    : 'Free Teletalk job application SMS format generator for 16222. Generate exact 1st SMS, 2nd confirmation SMS, and User ID/PIN recovery message with 1-click copy.')

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@type": "WebApplication",
    "name": "{{ $isBn ? 'টেলিটক জব এসএমএস জেনারেটর' : 'Teletalk Job SMS Generator' }}",
    "description": "{{ $isBn ? 'সরকারি চাকরির আবেদনের ১ম ও ২য় এসএমএস তৈরির টুল।' : 'Generate Teletalk 16222 job application SMS formats.' }}",
    "url": "{{ url()->current() }}",
    "applicationCategory": "UtilitiesApplication",
    "operatingSystem": "All",
    "inLanguage": "{{ $isBn ? 'bn-BD' : 'en-US' }}",
    "offers": {
        "@type": "Offer",
        "price": "0",
        "priceCurrency": "USD"
    }
}
</script>
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        {
            "@type": "Question",
            "name": "{{ $isBn ? 'টেলিটকে সরকারি চাকরির আবেদন ফি দেওয়ার প্রথম এসএমএস ফরম্যাট কী?' : 'What is the 1st SMS format for Teletalk job fees?' }}",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "{{ $isBn ? 'মেসেজ অপশনে গিয়ে লিখুন: [প্রতিষ্ঠানের শর্টকোড] [USER ID] এবং পাঠিয়ে দিন 16222 নম্বরে। যেমন: BPSC ABCDEF লিখে 16222 এ পাঠান।' : 'Type: [Job Code] [USER ID] and send to 16222. Example: BPSC ABCDEF to 16222.' }}"
            }
        },
        {
            "@type": "Question",
            "name": "{{ $isBn ? 'পিন পাওয়ার পর দ্বিতীয় এসএমএস কীভাবে পাঠাবেন?' : 'How to send the 2nd confirmation SMS with PIN?' }}",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "{{ $isBn ? 'মেসেজ অপশনে লিখুন: [প্রতিষ্ঠানের শর্টকোড] YES [PIN] এবং পাঠিয়ে দিন 16222 নম্বরে। যেমন: BPSC YES 12345678।' : 'Type: [Job Code] YES [PIN] and send to 16222. Example: BPSC YES 12345678.' }}"
            }
        }
    ]
}
</script>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
    @include('partials.tool-back')

    {{-- Top Header --}}
    <div class="mb-7 flex items-center justify-between flex-wrap gap-4 bg-white p-5 rounded-2xl border border-gray-100 shadow-xs">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 bg-gradient-to-br from-emerald-600 to-teal-600 text-white rounded-2xl flex items-center justify-center shadow-md shadow-emerald-500/20 text-xl shrink-0">
                <i class="fa-solid fa-comment-sms"></i>
            </div>
            <div>
                <div class="flex items-center gap-2 flex-wrap">
                    <h1 class="text-xl sm:text-2xl font-extrabold text-gray-900">
                        {{ $isBn ? 'টেলিটক জব SMS ফরম্যাট জেনারেটর' : 'Teletalk Job SMS Generator' }}
                    </h1>
                    <span class="text-[11px] font-bold bg-emerald-100 text-emerald-800 px-2.5 py-0.5 rounded-full">
                        {{ $isBn ? '১৬২২২ হেল্পার' : '16222 Helper' }}
                    </span>
                </div>
                <p class="text-gray-500 text-xs sm:text-sm mt-0.5">
                    {{ $isBn ? 'সরকারি চাকরির আবেদনের পর নির্ভুলভাবে ১ম ও ২য় এসএমএস তৈরি ও ১-ক্লিকে কপি করুন।' : 'Generate exact 1st and 2nd SMS formats for BD government job applications with 1-click copy.' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Main Workspace Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-7 items-start">

        {{-- Left Form Panel --}}
        <div class="lg:col-span-5 space-y-5">
            <div class="card p-6 space-y-4 bg-white border border-gray-100 shadow-sm rounded-2xl">
                <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2 pb-2 border-b border-gray-100">
                    <i class="fa-solid fa-sliders text-emerald-600"></i>
                    <span>{{ $isBn ? 'আবেদনের তথ্য দিন' : 'Enter Application Info' }}</span>
                </h3>

                {{-- 1. Select Popular Organization / Code --}}
                <div>
                    <label class="block text-xs font-bold text-gray-800 mb-1.5 flex items-center justify-between">
                        <span>{{ $isBn ? 'প্রতিষ্ঠানের নাম / শর্টকোড' : 'Organization / Shortcode' }}</span>
                        <span class="text-[10px] text-emerald-600 font-semibold">{{ $isBn ? 'জনপ্রিয় প্রিসেট' : 'Presets' }}</span>
                    </label>
                    <select id="org-select" onchange="onOrgChange(this.value)" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-xs sm:text-sm font-semibold text-gray-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-gray-50 focus:bg-white transition-all cursor-pointer">
                        <option value="BPSC">{{ $isBn ? 'BPSC — সরকারি কর্ম কমিশন (বিসিএস/নন-ক্যাডার)' : 'BPSC — Public Service Commission' }}</option>
                        <option value="DPE">{{ $isBn ? 'DPE — প্রাথমিক শিক্ষা অধিদপ্তর (প্রাইমারি শিক্ষক)' : 'DPE — Directorate of Primary Education' }}</option>
                        <option value="RAIL">{{ $isBn ? 'BR / RAIL — বাংলাদেশ রেলওয়ে' : 'BR / RAIL — Bangladesh Railway' }}</option>
                        <option value="NSI">{{ $isBn ? 'CNP / NSI — জাতীয় নিরাপত্তা গোয়েন্দা' : 'CNP / NSI — National Security Intelligence' }}</option>
                        <option value="BANBEIS">BANBEIS — শিক্ষা তথ্য ও পরিসংখ্যান ব্যুরো</option>
                        <option value="BREB">BREB — পল্লী বিদ্যুতায়ন বোর্ড</option>
                        <option value="BPDB">BPDB — বিদ্যুৎ উন্নয়ন বোর্ড</option>
                        <option value="DPHE">DPHE — জনস্বাস্থ্য প্রকৌশল অধিদপ্তর</option>
                        <option value="CUSTOMS">NBR / CUSTOMS — শুল্ক ও কাস্টমস</option>
                        <option value="POST">POST — ডাক অধিদপ্তর</option>
                        <option value="DGHS">DGHS — স্বাস্থ্য অধিদপ্তর</option>
                        <option value="custom">{{ $isBn ? '✍️ অন্যান্য / নিজের শর্টকোড লিখুন' : '✍️ Other / Custom Code' }}</option>
                    </select>
                </div>

                {{-- Custom Code Input (Hidden unless 'custom' is selected) --}}
                <div id="custom-code-box" class="hidden">
                    <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isBn ? 'বিজ্ঞপ্তিতে উল্লিখিত কোড (যেমন: BAPEX)' : 'Job Code (e.g. BAPEX)' }}</label>
                    <input type="text" id="custom-code-input" oninput="updateSMS()" placeholder="e.g. DAE" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm uppercase font-mono font-bold focus:ring-2 focus:ring-emerald-500 focus:outline-none bg-gray-50 focus:bg-white">
                </div>

                {{-- 2. User ID --}}
                <div>
                    <label class="block text-xs font-bold text-gray-800 mb-1.5 flex items-center justify-between">
                        <span>{{ $isBn ? 'ইউজার আইডি (User ID)' : 'Applicant User ID' }}</span>
                        <span class="text-[10px] text-gray-400 font-normal">{{ $isBn ? 'আবেদন ফরমের নিচে থাকে' : 'From Form' }}</span>
                    </label>
                    <input type="text" id="user-id-input" oninput="updateSMS()" value="ABCDEF" placeholder="e.g. ABCDEF" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm uppercase font-mono font-bold focus:ring-2 focus:ring-emerald-500 focus:outline-none bg-gray-50 focus:bg-white tracking-wider">
                </div>

                {{-- 3. PIN Number (for 2nd SMS) --}}
                <div>
                    <label class="block text-xs font-bold text-gray-800 mb-1.5 flex items-center justify-between">
                        <span>{{ $isBn ? 'পিন নম্বর (PIN Number — ২য় ধাপের জন্য)' : 'PIN (For 2nd SMS)' }}</span>
                        <span class="text-[10px] text-gray-400 font-normal">{{ $isBn ? '১ম SMS এর উত্তরে আসে' : 'From 1st reply' }}</span>
                    </label>
                    <input type="text" id="pin-input" oninput="updateSMS()" value="12345678" placeholder="e.g. 12345678" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-mono font-bold focus:ring-2 focus:ring-emerald-500 focus:outline-none bg-gray-50 focus:bg-white tracking-wider">
                </div>

                {{-- Tip Card --}}
                <div class="p-3 bg-emerald-50/70 border border-emerald-100 rounded-xl text-xs text-emerald-800 space-y-1">
                    <p class="font-bold flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-info text-emerald-600"></i>
                        <span>{{ $isBn ? 'টেলিটক সিমে পর্যাপ্ত ব্যালেন্স রাখুন' : 'Maintain Sufficient Balance' }}</span>
                    </p>
                    <p class="text-[11px] text-emerald-700 leading-relaxed">
                        {{ $isBn ? 'আবেদন ফি (যেমন: ১১২/২২৪/৫৬০ টাকা) ছাড়াও অতিরিক্ত ৫-১০ টাকা ব্যালেন্স থাকতে হবে।' : 'Keep extra 5-10 TK in your Teletalk SIM beyond application fee.' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Right Output Panel --}}
        <div class="lg:col-span-7 space-y-5">

            {{-- 1. Step 1: 1st SMS Card --}}
            <div class="card p-6 bg-white border border-gray-100 shadow-sm rounded-2xl space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                    <div class="flex items-center gap-2">
                        <span class="w-7 h-7 rounded-full bg-blue-100 text-blue-700 font-extrabold text-xs flex items-center justify-center">1</span>
                        <div>
                            <h4 class="font-bold text-gray-900 text-sm sm:text-base">
                                {{ $isBn ? 'প্রথম এসএমএস (1st SMS — ফি পরিশোধের আবেদন)' : '1st SMS — Apply to Pay Fee' }}
                            </h4>
                            <p class="text-[11px] text-gray-500">{{ $isBn ? 'এই মেসেজটি পাঠালে ফিরতি এসএমএসে পিন নম্বর (PIN) আসবে' : 'Reply will contain your 8-digit PIN' }}</p>
                        </div>
                    </div>
                    <span class="text-xs font-mono font-bold bg-blue-50 text-blue-700 px-2.5 py-1 rounded-lg">To: 16222</span>
                </div>

                {{-- SMS Message Bubble --}}
                <div class="bg-gray-900 text-emerald-400 p-4 rounded-xl font-mono text-sm sm:text-base tracking-wider flex items-center justify-between select-all border border-gray-800">
                    <span id="sms1-output" class="font-bold">BPSC ABCDEF</span>
                    <span class="text-[11px] text-gray-500 font-sans uppercase">To: 16222</span>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-2.5 flex-wrap">
                    <button type="button" onclick="copySMS('sms1')" id="btn-copy-sms1" class="flex-1 btn-primary !bg-emerald-600 hover:!bg-emerald-700 text-xs py-2.5 font-bold flex items-center justify-center gap-2 shadow-sm">
                        <i class="fa-solid fa-copy"></i>
                        <span id="copy-text-sms1">{{ $isBn ? '১ম এসএমএস কপি করুন' : 'Copy 1st SMS' }}</span>
                    </button>
                    <a id="btn-send-sms1" href="sms:16222?body=BPSC%20ABCDEF" class="flex-1 btn-secondary text-xs py-2.5 font-bold flex items-center justify-center gap-2 border border-gray-200">
                        <i class="fa-solid fa-paper-plane text-emerald-600"></i>
                        <span>{{ $isBn ? 'মেসেজ অ্যাপে পাঠান' : 'Open in Messages' }}</span>
                    </a>
                </div>
            </div>

            {{-- 2. Step 2: 2nd SMS Card --}}
            <div class="card p-6 bg-white border border-gray-100 shadow-sm rounded-2xl space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                    <div class="flex items-center gap-2">
                        <span class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-700 font-extrabold text-xs flex items-center justify-center">2</span>
                        <div>
                            <h4 class="font-bold text-gray-900 text-sm sm:text-base">
                                {{ $isBn ? 'দ্বিতীয় এসএমএস (2nd SMS — ফি কনফার্মেশন)' : '2nd SMS — Confirm Payment' }}
                            </h4>
                            <p class="text-[11px] text-gray-500">{{ $isBn ? '১ম মেসেজে আসা পিন নম্বরটি দিয়ে এই এসএমএস পাঠালেই ফি সম্পন্ন হবে' : 'Send with PIN received in 1st reply' }}</p>
                        </div>
                    </div>
                    <span class="text-xs font-mono font-bold bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-lg">To: 16222</span>
                </div>

                {{-- SMS Message Bubble --}}
                <div class="bg-gray-900 text-emerald-400 p-4 rounded-xl font-mono text-sm sm:text-base tracking-wider flex items-center justify-between select-all border border-gray-800">
                    <span id="sms2-output" class="font-bold">BPSC YES 12345678</span>
                    <span class="text-[11px] text-gray-500 font-sans uppercase">To: 16222</span>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-2.5 flex-wrap">
                    <button type="button" onclick="copySMS('sms2')" id="btn-copy-sms2" class="flex-1 btn-primary !bg-emerald-600 hover:!bg-emerald-700 text-xs py-2.5 font-bold flex items-center justify-center gap-2 shadow-sm">
                        <i class="fa-solid fa-copy"></i>
                        <span id="copy-text-sms2">{{ $isBn ? '২য় এসএমএস কপি করুন' : 'Copy 2nd SMS' }}</span>
                    </button>
                    <a id="btn-send-sms2" href="sms:16222?body=BPSC%20YES%2012345678" class="flex-1 btn-secondary text-xs py-2.5 font-bold flex items-center justify-center gap-2 border border-gray-200">
                        <i class="fa-solid fa-paper-plane text-emerald-600"></i>
                        <span>{{ $isBn ? 'মেসেজ অ্যাপে পাঠান' : 'Open in Messages' }}</span>
                    </a>
                </div>
            </div>

            {{-- 3. Recovery Formats (User ID / PIN হারানো গেলে) --}}
            <div class="card p-5 bg-gradient-to-br from-amber-50/60 to-orange-50/40 border border-amber-200/80 rounded-2xl shadow-xs space-y-3">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-key text-amber-600"></i>
                    <h4 class="font-bold text-amber-950 text-xs sm:text-sm">
                        {{ $isBn ? 'ইউজার আইডি বা পিন হারিয়ে গেলে উদ্ধারের নিয়ম:' : 'Lost User ID or PIN Recovery SMS:' }}
                    </h4>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 text-xs">
                    <div class="bg-white p-3 rounded-xl border border-amber-200/80 space-y-1">
                        <span class="text-[10px] font-bold text-amber-800 block uppercase">{{ $isBn ? 'পিন (PIN) উদ্ধারের এসএমএস' : 'Recover PIN' }}</span>
                        <p class="font-mono text-gray-800 font-bold" id="rec-pin-text">BPSC HELP PIN ABCDEF</p>
                        <p class="text-[10px] text-gray-500">Send to 16222</p>
                    </div>
                    <div class="bg-white p-3 rounded-xl border border-amber-200/80 space-y-1">
                        <span class="text-[10px] font-bold text-amber-800 block uppercase">{{ $isBn ? 'ইউজার আইডি (User ID) উদ্ধারের এসএমএস' : 'Recover User ID' }}</span>
                        <p class="font-mono text-gray-800 font-bold" id="rec-user-text">BPSC HELP USER NAME</p>
                        <p class="text-[10px] text-gray-500">Send to 16222</p>
                    </div>
                </div>
            </div>

            {{-- 4. WhatsApp Share --}}
            <div class="card p-4 bg-emerald-50/70 border border-emerald-200/80 rounded-2xl flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="text-center sm:text-left">
                    <p class="text-xs font-bold text-emerald-900">{{ $isBn ? 'চাকরিপ্রার্থী বন্ধুদের সাথে শেয়ার করুন' : 'Share with Friends' }}</p>
                    <p class="text-[11px] text-emerald-700">{{ $isBn ? 'আবেদনের ফি দিতে ভুল এড়াতে এই ফ্রি টুলটি শেয়ার করুন।' : 'Help friends format 16222 job fee SMS without errors.' }}</p>
                </div>
                <button type="button" onclick="shareWhatsApp()" class="w-full sm:w-auto px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold inline-flex items-center justify-center gap-1.5 shadow-sm transition-colors">
                    <i class="fa-brands fa-whatsapp text-sm"></i>
                    <span>{{ $isBn ? 'হোয়াটসঅ্যাপে পাঠান' : 'Share' }}</span>
                </button>
            </div>

        </div>
    </div>

    {{-- Bottom FAQ & Guide Section --}}
    <div class="mt-12 bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm space-y-6">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-lg">
                <i class="fa-solid fa-circle-question"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900">{{ $isBn ? 'টেলিটক জব ফি সংক্রান্ত জরুরি প্রশ্নোত্তর' : 'Teletalk Job Fee FAQ & Important Guidelines' }}</h3>
                <p class="text-xs text-gray-500">{{ $isBn ? 'ফি পরিশোধের সময় যেসব বিষয় খেয়াল রাখা আবশ্যক' : 'Crucial rules to follow when paying government application fees' }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs leading-relaxed text-gray-600">
            <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 space-y-1.5">
                <h4 class="font-bold text-gray-900 text-sm flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                    <span>{{ $isBn ? 'সময়সীমা: ৭২ ঘণ্টা' : 'Deadline: 72 Hours' }}</span>
                </h4>
                <p>{{ $isBn ? 'অনলাইন আবেদন ফরম সাবমিট করার পরবর্তী ৭২ ঘণ্টার মধ্যে অবশ্যই ফি পরিশোধ করতে হবে। ৭২ ঘণ্টা পার হলে আবেদন বাতিল হয়ে যায়।' : 'Application fee must be paid within 72 hours of submitting the online form.' }}</p>
            </div>

            <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 space-y-1.5">
                <h4 class="font-bold text-gray-900 text-sm flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    <span>{{ $isBn ? 'টেলিটক প্রিপেইড সিম' : 'Teletalk SIM Required' }}</span>
                </h4>
                <p>{{ $isBn ? 'শুধুমাত্র টেলিটক প্রিপেইড মোবাইল সংযোগ থেকেই এই এসএমএস পাঠানো যাবে। অন্য কোনো অপারেটর (গ্রামীনফোন, রবি বা বাংলালিংক) দিয়ে কাজ হবে না।' : 'Only Teletalk prepaid SIM connections can send SMS to 16222.' }}</p>
            </div>

            <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 space-y-1.5">
                <h4 class="font-bold text-gray-900 text-sm flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-amber-600"></span>
                    <span>{{ $isBn ? 'কনফার্মেশন ও পাসওয়ার্ড' : 'Password Confirmation' }}</span>
                </h4>
                <p>{{ $isBn ? '২য় এসএমএস সফল হলে একটি ফিরতি এসএমএস আসবে যাতে "Congratulations" সহ User ID ও Password থাকবে। এটি সংরক্ষণ করুন।' : 'Keep the final confirmation SMS containing your User ID and Password safely.' }}</p>
            </div>
        </div>
    </div>

    @include('partials.tool-ad')
</div>

@push('scripts')
<script>
const isBn = @json($isBn);

function onOrgChange(val) {
    const customBox = document.getElementById('custom-code-box');
    if (val === 'custom') {
        customBox.classList.remove('hidden');
        document.getElementById('custom-code-input').focus();
    } else {
        customBox.classList.add('hidden');
    }
    updateSMS();
}

function getActiveCode() {
    const sel = document.getElementById('org-select').value;
    if (sel === 'custom') {
        return (document.getElementById('custom-code-input').value || 'JOBCODE').trim().toUpperCase();
    }
    return sel;
}

function updateSMS() {
    const code = getActiveCode();
    const userId = (document.getElementById('user-id-input').value || 'USERID').trim().toUpperCase();
    const pin = (document.getElementById('pin-input').value || 'PIN').trim();

    const sms1 = `${code} ${userId}`;
    const sms2 = `${code} YES ${pin}`;

    document.getElementById('sms1-output').textContent = sms1;
    document.getElementById('sms2-output').textContent = sms2;

    document.getElementById('btn-send-sms1').href = `sms:16222?body=${encodeURIComponent(sms1)}`;
    document.getElementById('btn-send-sms2').href = `sms:16222?body=${encodeURIComponent(sms2)}`;

    // Recovery formats
    document.getElementById('rec-pin-text').textContent = `${code} HELP PIN ${userId}`;
    document.getElementById('rec-user-text').textContent = `${code} HELP USER NAME`;
}

function copySMS(type) {
    const text = type === 'sms1'
        ? document.getElementById('sms1-output').textContent
        : document.getElementById('sms2-output').textContent;

    navigator.clipboard.writeText(text).then(() => {
        const textSpan = document.getElementById(`copy-text-${type}`);
        const orig = textSpan.textContent;
        textSpan.textContent = isBn ? 'কপি হয়েছে! ✅' : 'Copied! ✅';
        setTimeout(() => textSpan.textContent = orig, 2000);

        if (window.toast) {
            window.toast.success(isBn ? 'এসএমএস টেক্সট কপি হয়েছে!' : 'SMS text copied!');
        }
    });
}

function shareWhatsApp() {
    const url = window.location.href;
    const text = isBn
        ? `সরকারি চাকরির আবেদনের টেলিটক ১ম ও ২য় এসএমএস ফরম্যাট সহজে তৈরি ও কপি করুন এই লিংকে: ${url}`
        : `Generate Teletalk job application SMS formats for 16222 with 1-click copy: ${url}`;

    window.open(`https://api.whatsapp.com/send?text=${encodeURIComponent(text)}`, '_blank');
}

// Initial Run
document.addEventListener('DOMContentLoaded', updateSMS);
</script>
@endpush
@endsection
