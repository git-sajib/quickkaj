@extends('layouts.app')

@section('page_title', (app()->getLocale() === 'bn' ? 'গোপনীয়তা নীতি' : 'Privacy Policy') . ' — ' . __('ui.site_name'))
@section('seo_description', app()->getLocale() === 'bn' ? 'কুইককাজের গোপনীয়তা নীতি পড়ুন।' : 'Read Quickkaj Privacy Policy.')

@section('content')
@php $locale = app()->getLocale(); $isBn = $locale === 'bn'; @endphp
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <div class="card p-8 md:p-12">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-user-shield text-blue-600 text-lg"></i>
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">
                {{ $isBn ? 'গোপনীয়তা নীতি' : 'Privacy Policy' }}
            </h1>
        </div>
        <p class="text-sm text-gray-400 mb-8">
            <i class="fa-regular fa-calendar mr-1"></i>
            {{ $isBn ? 'সর্বশেষ আপডেট:' : 'Last updated:' }} {{ date('d F Y') }}
        </p>

        <div class="prose prose-gray max-w-none text-gray-600 leading-relaxed space-y-6">
            @if($isBn)
                <p><strong>কুইককাজ</strong> আপনার গোপনীয়তাকে সম্মান করে। এই নীতিতে আমরা কোন তথ্য সংগ্রহ করি এবং কীভাবে ব্যবহার করি তা বিস্তারিত জানানো হয়েছে।</p>
                <h2 class="text-lg font-bold text-gray-900 mt-6 flex items-center gap-2"><i class="fa-solid fa-database text-blue-500 text-sm"></i> আমরা কী তথ্য সংগ্রহ করি</h2>
                <ul class="list-none space-y-2">
                    <li class="flex items-start gap-2"><i class="fa-solid fa-circle-check text-emerald-500 mt-0.5 text-sm"></i> আপনার ব্রাউজার এবং ডিভাইসের তথ্য (IP ঠিকানা, ব্রাউজারের ধরন)</li>
                    <li class="flex items-start gap-2"><i class="fa-solid fa-circle-check text-emerald-500 mt-0.5 text-sm"></i> আপনি কোন পেজ ভিজিট করেছেন এবং কতক্ষণ ছিলেন</li>
                    <li class="flex items-start gap-2"><i class="fa-solid fa-circle-check text-emerald-500 mt-0.5 text-sm"></i> আপনি যদি অ্যাকাউন্ট খোলেন তাহলে নাম ও ইমেইল</li>
                </ul>
                <h2 class="text-lg font-bold text-gray-900 mt-6 flex items-center gap-2"><i class="fa-solid fa-shield-halved text-blue-500 text-sm"></i> কুকিজ</h2>
                <p>আমরা সাইটের সুষ্ঠু পরিচালনার জন্য কুকিজ ব্যবহার করি। Adsterra বিজ্ঞাপন নেটওয়ার্কও কুকিজ ব্যবহার করতে পারে।</p>
                <h2 class="text-lg font-bold text-gray-900 mt-6 flex items-center gap-2"><i class="fa-solid fa-rectangle-ad text-blue-500 text-sm"></i> বিজ্ঞাপন</h2>
                <p>আমরা Adsterra বিজ্ঞাপন নেটওয়ার্ক ব্যবহার করি। তারা আপনার ব্রাউজিং আচরণ অনুযায়ী বিজ্ঞাপন দেখাতে পারে।</p>
                <h2 class="text-lg font-bold text-gray-900 mt-6 flex items-center gap-2"><i class="fa-solid fa-envelope text-blue-500 text-sm"></i> যোগাযোগ</h2>
                <p>কোনো প্রশ্ন থাকলে <a href="mailto:hello@quickkaj.com" class="text-blue-600 hover:underline">hello@quickkaj.com</a> এ ইমেইল করুন।</p>
            @else
                <p><strong>Quickkaj</strong> respects your privacy. This policy explains what data we collect and how we use it.</p>
                <h2 class="text-lg font-bold text-gray-900 mt-6 flex items-center gap-2"><i class="fa-solid fa-database text-blue-500 text-sm"></i> What We Collect</h2>
                <ul class="list-none space-y-2">
                    <li class="flex items-start gap-2"><i class="fa-solid fa-circle-check text-emerald-500 mt-0.5 text-sm"></i> Browser and device information (IP address, browser type)</li>
                    <li class="flex items-start gap-2"><i class="fa-solid fa-circle-check text-emerald-500 mt-0.5 text-sm"></i> Pages visited and time spent</li>
                    <li class="flex items-start gap-2"><i class="fa-solid fa-circle-check text-emerald-500 mt-0.5 text-sm"></i> Name and email if you create an account</li>
                </ul>
                <h2 class="text-lg font-bold text-gray-900 mt-6 flex items-center gap-2"><i class="fa-solid fa-shield-halved text-blue-500 text-sm"></i> Cookies</h2>
                <p>We use cookies for site functionality. The Adsterra advertising network may also use cookies for ad personalization.</p>
                <h2 class="text-lg font-bold text-gray-900 mt-6 flex items-center gap-2"><i class="fa-solid fa-rectangle-ad text-blue-500 text-sm"></i> Advertising</h2>
                <p>We use the Adsterra ad network which may serve targeted ads based on your browsing behavior.</p>
                <h2 class="text-lg font-bold text-gray-900 mt-6 flex items-center gap-2"><i class="fa-solid fa-envelope text-blue-500 text-sm"></i> Contact</h2>
                <p>For any questions, email us at <a href="mailto:hello@quickkaj.com" class="text-blue-600 hover:underline">hello@quickkaj.com</a>.</p>
            @endif
        </div>
    </div>
</div>
@endsection
