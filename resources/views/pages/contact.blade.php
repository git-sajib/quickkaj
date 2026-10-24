@extends('layouts.app')

@php
    $locale = app()->getLocale();
    $isBn   = $locale === 'bn';
    $email  = \App\Models\Setting::getValue('contact_email', 'hello@quickkaj.com');
@endphp

@section('page_title', ($isBn ? 'যোগাযোগ করুন — ' . config('app.name', 'Quickkaj') : 'Contact Us — ' . config('app.name', 'Quickkaj')))
@section('seo_description', $isBn
    ? 'কুইককাজ টিমের সাথে যোগাযোগ করুন। যেকোনো প্রশ্ন, মতামত, নতুন টুলের অনুরোধ বা সহযোগিতার জন্য বার্তা পাঠান।'
    : 'Get in touch with the Quickkaj team. Send us your feedback, tool requests, or support inquiries.')

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "ContactPage",
    "name": "{{ $isBn ? 'যোগাযোগ — কুইককাজ' : 'Contact Us — Quickkaj' }}",
    "description": "{{ $isBn ? 'কুইককাজ টিমের সাথে যোগাযোগের ফর্ম ও ইমেইল।' : 'Contact form and official email for Quickkaj support.' }}",
    "url": "{{ url()->current() }}"
}
</script>
@endsection

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs text-gray-500 mb-6">
        <a href="{{ route('home', ['locale' => $locale]) }}" class="hover:text-blue-600 transition-colors">
            <i class="fa-solid fa-house"></i>
            <span>{{ __('ui.home') }}</span>
        </a>
        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
        <span class="text-gray-900 font-semibold">{{ $isBn ? 'যোগাযোগ' : 'Contact Us' }}</span>
    </nav>

    {{-- Header --}}
    <div class="text-center max-w-2xl mx-auto mb-12">
        <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full text-xs font-semibold bg-blue-50 border border-blue-200/80 text-blue-700 shadow-2xs mb-3">
            <i class="fa-solid fa-headset text-blue-600 text-xs"></i>
            <span>{{ $isBn ? 'আমরা সাহায্য করতে প্রস্তুত' : 'We are here to help' }}</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-gray-950 tracking-tight leading-tight mb-3">
            {{ $isBn ? 'আমাদের সাথে যোগাযোগ করুন' : 'Get in Touch with Us' }}
        </h1>
        <p class="text-sm sm:text-base text-gray-600 leading-relaxed">
            {{ $isBn
                ? 'যেকোনো জিজ্ঞাসা, ফিচার রিকোয়েস্ট, বা ফিডব্যাকের জন্য নিচের ফর্মটি পূরণ করুন অথবা সরাসরি ইমেইল করুন।'
                : 'Have a question, feedback, or tool suggestion? Fill out the form below or send us an email directly.' }}
        </p>
    </div>

    {{-- Success Alert --}}
    @if(session('success'))
        <div class="mb-8 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center gap-3 shadow-sm">
            <div class="w-9 h-9 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0 text-emerald-600">
                <i class="fa-solid fa-circle-check text-lg"></i>
            </div>
            <div>
                <p class="font-bold text-sm">{{ $isBn ? 'বার্তা পাঠানো সফল হয়েছে!' : 'Message Sent Successfully!' }}</p>
                <p class="text-xs text-emerald-700 mt-0.5">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- Two Column Content --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">

        {{-- Left Form (7 cols) --}}
        <div class="lg:col-span-7 card p-6 sm:p-8 border border-gray-200/80 shadow-sm rounded-3xl">
            <h2 class="text-xl font-bold text-gray-900 mb-1 flex items-center gap-2">
                <i class="fa-solid fa-paper-plane text-blue-600 text-base"></i>
                <span>{{ $isBn ? 'বার্তা পাঠান' : 'Send a Message' }}</span>
            </h2>
            <p class="text-xs text-gray-500 mb-6">
                {{ $isBn ? 'সাধারণত ২৪ ঘণ্টার মধ্যে আমরা প্রতিটি বার্তার উত্তর দেওয়ার চেষ্টা করি।' : 'We usually respond to all inquiries within 24 business hours.' }}
            </p>

            <form method="POST" action="{{ route('page.contact.submit', ['locale' => $locale]) }}" class="space-y-4">
                @csrf

                {{-- Name --}}
                <div>
                    <label for="name" class="block text-xs font-semibold text-gray-700 mb-1.5">
                        {{ $isBn ? 'আপনার নাম' : 'Your Name' }} <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400 text-xs">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <input type="text" name="name" id="name" required value="{{ old('name') }}"
                               placeholder="{{ $isBn ? 'উদা: মো: রাকিবুল ইসলাম' : 'e.g. John Doe' }}"
                               class="w-full pl-9 pr-3.5 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all outline-none @error('name') border-red-500 ring-1 ring-red-200 @enderror">
                    </div>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-xs font-semibold text-gray-700 mb-1.5">
                        {{ $isBn ? 'ইমেইল ঠিকানা' : 'Email Address' }} <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400 text-xs">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <input type="email" name="email" id="email" required value="{{ old('email') }}"
                               placeholder="{{ $isBn ? 'উদা: example@gmail.com' : 'e.g. user@example.com' }}"
                               class="w-full pl-9 pr-3.5 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all outline-none @error('email') border-red-500 ring-1 ring-red-200 @enderror">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Subject --}}
                <div>
                    <label for="subject" class="block text-xs font-semibold text-gray-700 mb-1.5">
                        {{ $isBn ? 'বিষয় (ঐচ্ছিক)' : 'Subject (Optional)' }}
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400 text-xs">
                            <i class="fa-solid fa-tag"></i>
                        </span>
                        <input type="text" name="subject" id="subject" value="{{ old('subject') }}"
                               placeholder="{{ $isBn ? 'উদা: নতুন টুলস রিকোয়েস্ট / বাগ রিপোর্ট' : 'e.g. New Tool Suggestion / Bug Report' }}"
                               class="w-full pl-9 pr-3.5 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all outline-none">
                    </div>
                </div>

                {{-- Message --}}
                <div>
                    <label for="message" class="block text-xs font-semibold text-gray-700 mb-1.5">
                        {{ $isBn ? 'আপনার বার্তা বা বিস্তারিত' : 'Your Message' }} <span class="text-red-500">*</span>
                    </label>
                    <textarea name="message" id="message" rows="5" required
                              placeholder="{{ $isBn ? 'আপনার বার্তাটি বিস্তারিত লিখুন (কমপক্ষে ১০ অক্ষর)...' : 'Write your detailed message here (minimum 10 characters)...' }}"
                              class="w-full p-3.5 rounded-xl border border-gray-200 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all outline-none leading-relaxed @error('message') border-red-500 ring-1 ring-red-200 @enderror">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <div class="pt-2">
                    <button type="submit"
                            class="btn-primary w-full sm:w-auto px-8 py-3 rounded-xl font-bold text-sm shadow-md shadow-blue-600/20 inline-flex items-center justify-center gap-2">
                        <i class="fa-solid fa-paper-plane text-xs"></i>
                        <span>{{ $isBn ? 'বার্তা পাঠান' : 'Send Message' }}</span>
                    </button>
                </div>
            </form>
        </div>

        {{-- Right Column: Direct Info & Quick FAQ (5 cols) --}}
        <div class="lg:col-span-5 space-y-6">

            {{-- Email Card --}}
            <div class="card p-6 border-blue-100 bg-gradient-to-br from-blue-50/60 to-white">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-xl flex-shrink-0 shadow-md shadow-blue-600/20">
                        <i class="fa-solid fa-envelope-open-text"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-base mb-1">
                            {{ $isBn ? 'অফিসিয়াল সাপোর্ট ইমেইল' : 'Direct Email Support' }}
                        </h3>
                        <p class="text-xs text-gray-500 mb-2">
                            {{ $isBn ? 'যেকোনো স্পন্সরশিপ বা জরুরি যোগাযোগের জন্য:' : 'For sponsorships, legal inquiries or direct contact:' }}
                        </p>
                        <a href="mailto:{{ $email }}" class="text-sm font-bold text-blue-600 hover:text-blue-800 break-all transition-colors flex items-center gap-1.5">
                            <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                            <span>{{ $email }}</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Quick Social Channels --}}
            <div class="card p-6">
                <h3 class="font-bold text-gray-900 text-sm mb-3 flex items-center gap-2">
                    <i class="fa-solid fa-share-nodes text-indigo-600"></i>
                    <span>{{ $isBn ? 'সোশ্যাল মিডিয়া ও কমিউনিটি' : 'Community & Socials' }}</span>
                </h3>
                <p class="text-xs text-gray-500 leading-relaxed mb-4">
                    {{ $isBn
                        ? 'আমাদের সোশ্যাল পেজে যুক্ত থাকুন নিয়মিত চাকরির সার্কুলার ও আপডেট তথ্যের জন্য।'
                        : 'Follow our channels for regular job updates, circular alerts, and platform news.' }}
                </p>

                <div class="grid grid-cols-2 gap-2.5">
                    @php $fb = \App\Models\Setting::getValue('facebook_url', 'https://facebook.com'); @endphp
                    <a href="{{ $fb }}" target="_blank" rel="noopener noreferrer"
                       class="flex items-center gap-2.5 p-2.5 rounded-xl bg-gray-50 hover:bg-blue-50 hover:text-blue-600 border border-gray-100 text-xs font-semibold text-gray-700 transition-colors">
                        <i class="fa-brands fa-facebook-f text-blue-600"></i>
                        <span>Facebook</span>
                    </a>
                    @php $tg = \App\Models\Setting::getValue('telegram_url', 'https://telegram.org'); @endphp
                    <a href="{{ $tg }}" target="_blank" rel="noopener noreferrer"
                       class="flex items-center gap-2.5 p-2.5 rounded-xl bg-gray-50 hover:bg-sky-50 hover:text-sky-600 border border-gray-100 text-xs font-semibold text-gray-700 transition-colors">
                        <i class="fa-brands fa-telegram text-sky-500"></i>
                        <span>Telegram</span>
                    </a>
                </div>
            </div>

            {{-- Quick Trust FAQs --}}
            <div class="card p-6 border-gray-200/80">
                <h3 class="font-bold text-gray-900 text-sm mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-circle-question text-amber-500"></i>
                    <span>{{ $isBn ? 'জরুরি সাধারণ প্রশ্নোত্তর' : 'Frequently Asked Questions' }}</span>
                </h3>

                <div class="space-y-3.5 text-xs">
                    <div>
                        <p class="font-bold text-gray-900 mb-1">
                            {{ $isBn ? 'টুলস ব্যবহার করতে কি কোনো ফি দিতে হবে?' : 'Is there any fee to use the tools?' }}
                        </p>
                        <p class="text-gray-500 leading-relaxed">
                            {{ $isBn ? 'না, কুইককাজের সকল অনলাইন টুলস আজীবন ১০০% ফ্রি থাকবে।' : 'No, all tools on Quickkaj are 100% free forever without subscriptions.' }}
                        </p>
                    </div>

                    <div class="pt-2 border-t border-gray-100">
                        <p class="font-bold text-gray-900 mb-1">
                            {{ $isBn ? 'আমার আপলোডকৃত ফাইল কি সার্ভারে জমা থাকে?' : 'Are uploaded files saved on your server?' }}
                        </p>
                        <p class="text-gray-500 leading-relaxed">
                            {{ $isBn ? 'না, কোনো ফাইলই সার্ভারে সংরক্ষণ করা হয় না। প্রসেসিং ব্রাউজারেই সম্পন্ন হয়।' : 'Never. Files and documents are processed locally in your browser memory.' }}
                        </p>
                    </div>

                    <div class="pt-2 border-t border-gray-100">
                        <p class="font-bold text-gray-900 mb-1">
                            {{ $isBn ? 'নতুন টুলের অনুরোধ করা যাবে কি?' : 'Can I request a new tool?' }}
                        </p>
                        <p class="text-gray-500 leading-relaxed">
                            {{ $isBn ? 'অবশ্যই! পাশের ফর্মটি পূরণ করে যেকোনো প্রয়োজনীয় টুলের নাম পাঠিয়ে দিন।' : 'Yes! Send us the name or details of the tool you need via this form.' }}
                        </p>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
