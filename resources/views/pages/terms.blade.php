@extends('layouts.app')

@section('page_title', (app()->getLocale() === 'bn' ? 'ব্যবহারের শর্ত' : 'Terms of Use') . ' — ' . __('ui.site_name'))
@section('seo_description', app()->getLocale() === 'bn' ? 'কুইককাজ ব্যবহারের শর্তাবলী পড়ুন।' : 'Read Quickkaj Terms of Use.')

@section('content')
@php $locale = app()->getLocale(); $isBn = $locale === 'bn'; @endphp
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <div class="card p-8 md:p-12">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-10 h-10 bg-violet-100 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-file-contract text-violet-600 text-lg"></i>
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">
                {{ $isBn ? 'ব্যবহারের শর্ত' : 'Terms of Use' }}
            </h1>
        </div>
        <p class="text-sm text-gray-400 mb-8">
            <i class="fa-regular fa-calendar mr-1"></i>
            {{ $isBn ? 'সর্বশেষ আপডেট:' : 'Last updated:' }} {{ date('d F Y') }}
        </p>

        <div class="prose prose-gray max-w-none text-gray-600 leading-relaxed space-y-6">
            @if($isBn)
                <p>কুইককাজ ব্যবহার করে আপনি নিচের শর্তগুলোতে সম্মতি দিচ্ছেন।</p>
                <h2 class="text-lg font-bold text-gray-900 mt-6 flex items-center gap-2"><i class="fa-solid fa-circle-info text-violet-500 text-sm"></i> সাইটের উদ্দেশ্য</h2>
                <p>কুইককাজ চাকরির সংবাদ, প্রযুক্তি বিষয়ক তথ্য, অনলাইন টুলস এবং URL শর্টেনার সেবা প্রদান করে।</p>
                <h2 class="text-lg font-bold text-gray-900 mt-6 flex items-center gap-2"><i class="fa-solid fa-ban text-violet-500 text-sm"></i> নিষিদ্ধ কার্যক্রম</h2>
                <ul class="list-none space-y-2">
                    <li class="flex items-start gap-2"><i class="fa-solid fa-xmark text-red-400 mt-0.5 text-sm"></i> অবৈধ বা ক্ষতিকর কন্টেন্ট শেয়ার করা</li>
                    <li class="flex items-start gap-2"><i class="fa-solid fa-xmark text-red-400 mt-0.5 text-sm"></i> স্বয়ংক্রিয় বট দিয়ে সাইটে আঘাত করা</li>
                    <li class="flex items-start gap-2"><i class="fa-solid fa-xmark text-red-400 mt-0.5 text-sm"></i> অন্যের তথ্য চুরি করা</li>
                </ul>
                <h2 class="text-lg font-bold text-gray-900 mt-6 flex items-center gap-2"><i class="fa-solid fa-triangle-exclamation text-violet-500 text-sm"></i> দায়বদ্ধতা</h2>
                <p>কুইককাজে প্রকাশিত তথ্য শুধুমাত্র সাধারণ তথ্যের জন্য। কোনো সিদ্ধান্তের আগে বিশেষজ্ঞের পরামর্শ নিন।</p>
                <h2 class="text-lg font-bold text-gray-900 mt-6 flex items-center gap-2"><i class="fa-solid fa-envelope text-violet-500 text-sm"></i> যোগাযোগ</h2>
                <p>কোনো প্রশ্ন থাকলে <a href="mailto:hello@quickkaj.com" class="text-blue-600 hover:underline">hello@quickkaj.com</a> এ ইমেইল করুন।</p>
            @else
                <p>By using Quickkaj, you agree to the following terms.</p>
                <h2 class="text-lg font-bold text-gray-900 mt-6 flex items-center gap-2"><i class="fa-solid fa-circle-info text-violet-500 text-sm"></i> Purpose</h2>
                <p>Quickkaj provides job news, technology articles, online tools, and URL shortening services.</p>
                <h2 class="text-lg font-bold text-gray-900 mt-6 flex items-center gap-2"><i class="fa-solid fa-ban text-violet-500 text-sm"></i> Prohibited Activities</h2>
                <ul class="list-none space-y-2">
                    <li class="flex items-start gap-2"><i class="fa-solid fa-xmark text-red-400 mt-0.5 text-sm"></i> Sharing illegal or harmful content</li>
                    <li class="flex items-start gap-2"><i class="fa-solid fa-xmark text-red-400 mt-0.5 text-sm"></i> Attacking the site with automated bots</li>
                    <li class="flex items-start gap-2"><i class="fa-solid fa-xmark text-red-400 mt-0.5 text-sm"></i> Stealing others' data</li>
                </ul>
                <h2 class="text-lg font-bold text-gray-900 mt-6 flex items-center gap-2"><i class="fa-solid fa-triangle-exclamation text-violet-500 text-sm"></i> Disclaimer</h2>
                <p>Content on Quickkaj is for informational purposes only. Consult an expert before making decisions.</p>
                <h2 class="text-lg font-bold text-gray-900 mt-6 flex items-center gap-2"><i class="fa-solid fa-envelope text-violet-500 text-sm"></i> Contact</h2>
                <p>For questions, email <a href="mailto:hello@quickkaj.com" class="text-blue-600 hover:underline">hello@quickkaj.com</a>.</p>
            @endif
        </div>
    </div>
</div>
@endsection
