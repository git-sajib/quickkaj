@extends('layouts.app')
@php
    $isBn = app()->getLocale() === 'bn';
@endphp

@section('page_title', ($isBn ? 'ফ্রি অনলাইন টুলস ও ক্যালকুলেটর — প্রয়োজনীয় ডিজিটাল টুলস' : 'Free Online Utility Tools & Calculators') . ' — ' . __('ui.site_name'))
@section('seo_description', $isBn
    ? 'টেলিটক এসএমএস জেনারেটর, সরকারি চাকরির বয়স ক্যালকুলেটর, সিভি মেকার, ছবি ও স্বাক্ষর রিসাইজার ৩০০×৩০০, পিডিএফ মার্জ সহ দরকারি ফ্রি অনলাইন টুলস।'
    : 'Free online tools suite: Teletalk SMS generator, Govt age calculator, CV maker, PDF merge/split, 300x300 photo resizer, and more.')

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "CollectionPage",
    "name": "{{ $isBn ? 'ফ্রি অনলাইন টুলস ও ক্যালকুলেটর' : 'Free Online Utility Tools & Calculators' }}",
    "description": "{{ $isBn ? 'টেলিটক এসএমএস জেনারেটর, সরকারি চাকরির বয়স ক্যালকুলেটর, সিভি মেকার, ছবি ও স্বাক্ষর রিসাইজার ৩০০×৩০০ সহ দরকারি ফ্রি অনলাইন টুল।' : 'Suite of free privacy-focused online tools for documents, images, text, and calculators.' }}",
    "url": "{{ url()->current() }}",
    "inLanguage": "{{ $isBn ? 'bn-BD' : 'en-US' }}",
    "isPartOf": {
        "@@type": "WebSite",
        "name": "{{ config('app.name', 'Quickkaj') }}",
        "url": "{{ url('/') }}"
    }
}
</script>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center mb-12">
        <h1 class="section-header">{{ __('ui.tools_title') }}</h1>
        <p class="section-subtitle">{{ __('ui.tools_subtitle') }}</p>
        <div class="section-divider mx-auto"></div>
    </div>

    @php
    $groups = [
        [
            'label' => $isBn ? 'টেক্সট টুলস' : 'Text Tools',
            'icon'  => 'fa-pen-nib',
            'color' => 'text-blue-600',
            'tools' => [
                ['icon' => 'fa-calculator', 'bg' => 'bg-blue-100', 'ic' => 'text-blue-600',
                 'label' => __('ui.word_counter'), 'route' => 'tools.word-counter',
                 'desc' => $isBn ? 'শব্দ, অক্ষর ও লাইন গণনা করুন' : 'Count words, characters & lines'],
                ['icon' => 'fa-text-height', 'bg' => 'bg-violet-100', 'ic' => 'text-violet-600',
                 'label' => __('ui.case_converter'), 'route' => 'tools.case-converter',
                 'desc' => $isBn ? 'টেক্সট UPPER, lower, Title কেসে রূপান্তর' : 'Convert UPPER, lower, Title, camelCase'],
                ['icon' => 'fa-code', 'bg' => 'bg-emerald-100', 'ic' => 'text-emerald-600',
                 'label' => __('ui.json_formatter'), 'route' => 'tools.json-formatter',
                 'desc' => $isBn ? 'JSON ফরম্যাট ও ভ্যালিডেট করুন' : 'Format, beautify and validate JSON'],
                ['icon' => 'fa-link', 'bg' => 'bg-orange-100', 'ic' => 'text-orange-600',
                 'label' => __('ui.url_encoder'), 'route' => 'tools.url-encoder',
                 'desc' => $isBn ? 'URL এনকোড ও ডিকোড করুন' : 'Encode and decode URLs instantly'],
            ],
        ],
        [
            'label' => $isBn ? 'ইমেজ টুলস' : 'Image Tools',
            'icon'  => 'fa-image',
            'color' => 'text-violet-600',
            'tools' => [
                ['icon' => 'fa-compress', 'bg' => 'bg-blue-100', 'ic' => 'text-blue-600',
                 'label' => $isBn ? 'ইমেজ কম্প্রেসার' : 'Image Compressor', 'route' => 'tools.image-compressor',
                 'desc' => $isBn ? 'ব্রাউজারেই ছবির সাইজ কমান' : 'Compress images in your browser'],
                ['icon' => 'fa-crop', 'bg' => 'bg-violet-100', 'ic' => 'text-violet-600',
                 'label' => $isBn ? 'ইমেজ রিসাইজার ও ক্রপার' : 'Image Resizer & Cropper', 'route' => 'tools.image-resizer',
                 'desc' => $isBn ? 'ফটোশপ স্টাইলে ছবির উপর ড্র্যাগ করে সাইজ নির্ধারণ' : 'Crop & resize images with interactive drag handles'],
                ['icon' => 'fa-arrows-rotate', 'bg' => 'bg-emerald-100', 'ic' => 'text-emerald-600',
                 'label' => $isBn ? 'ইমেজ কনভার্টার' : 'Image Converter', 'route' => 'tools.image-converter',
                 'desc' => $isBn ? 'JPG, PNG, WebP ফরম্যাটে কনভার্ট' : 'Convert JPG, PNG, WebP formats'],
                ['icon' => 'fa-wand-magic-sparkles', 'bg' => 'bg-rose-100', 'ic' => 'text-rose-600',
                 'label' => $isBn ? 'ব্যাকগ্রাউন্ড রিমুভার' : 'Background Remover', 'route' => 'tools.background-remover',
                 'desc' => $isBn ? 'ছবির ব্যাকগ্রাউন্ড রিমুভ ও সাদা/নীল ব্যাকগ্রাউন্ড' : 'Remove background, make transparent or solid color'],
            ],
        ],
        [
            'label' => $isBn ? 'বাংলাদেশ ক্যালকুলেটর' : 'Bangladesh Calculators',
            'icon'  => 'fa-calculator',
            'color' => 'text-orange-600',
            'tools' => [
                ['icon' => 'fa-cake-candles', 'bg' => 'bg-blue-100', 'ic' => 'text-blue-600',
                 'label' => $isBn ? 'বয়স ও চাকরি ক্যালকুলেটর' : 'Age & Govt Job Calculator', 'route' => 'tools.age-calculator',
                 'desc' => $isBn ? 'সঠিক বয়স ও সরকারি চাকরির ৩২ বছর কোটা যোগ্যতা' : 'Calculate exact age & 32-year job quota eligibility', 'badge' => 'Updated'],
                ['icon' => 'fa-weight-scale', 'bg' => 'bg-emerald-100', 'ic' => 'text-emerald-600',
                 'label' => $isBn ? 'BMI ক্যালকুলেটর' : 'BMI Calculator', 'route' => 'tools.bmi-calculator',
                 'desc' => $isBn ? 'বডি মাস ইন্ডেক্স হিসাব করুন' : 'Calculate your Body Mass Index'],
                ['icon' => 'fa-graduation-cap', 'bg' => 'bg-violet-100', 'ic' => 'text-violet-600',
                 'label' => $isBn ? 'CGPA ক্যালকুলেটর' : 'CGPA Calculator', 'route' => 'tools.cgpa-calculator',
                 'desc' => $isBn ? '4.0 / 5.0 স্কেলে CGPA হিসাব' : '4.0 / 5.0 scale CGPA calculator'],
                ['icon' => 'fa-bangladeshi-taka-sign', 'bg' => 'bg-orange-100', 'ic' => 'text-orange-600',
                 'label' => $isBn ? 'বেতন ক্যালকুলেটর' : 'Salary Calculator', 'route' => 'tools.salary-calculator',
                 'desc' => $isBn ? 'মাসিক বেতন ও করের হিসাব' : 'Monthly salary & tax calculation'],
                ['icon' => 'fa-ruler-combined', 'bg' => 'bg-teal-100', 'ic' => 'text-teal-600',
                 'label' => $isBn ? 'ইউনিট কনভার্টার' : 'Unit Converter', 'route' => 'tools.unit-converter',
                 'desc' => $isBn ? 'দৈর্ঘ্য, ওজন, তাপমাত্রা রূপান্তর' : 'Length, weight, temperature, area'],
            ],
        ],
        [
            'label' => $isBn ? 'পিডিএফ ও ডকুমেন্ট টুলস' : 'PDF & Document Tools',
            'icon'  => 'fa-file-pdf',
            'color' => 'text-rose-600',
            'tools' => [
                ['icon' => 'fa-object-group', 'bg' => 'bg-rose-100', 'ic' => 'text-rose-600',
                 'label' => $isBn ? 'Merge PDF (একত্রীকরণ)' : 'Merge PDF', 'route' => 'tools.pdf-tools', 'hash' => '#merge',
                 'desc' => $isBn ? 'একাধিক PDF ফাইল একসাথে মার্জ করুন' : 'Combine multiple PDF files into one', 'badge' => 'Hot'],
                ['icon' => 'fa-scissors', 'bg' => 'bg-blue-100', 'ic' => 'text-blue-600',
                 'label' => $isBn ? 'Split PDF (আলাদা করুন)' : 'Split & Extract PDF', 'route' => 'tools.pdf-tools', 'hash' => '#split',
                 'desc' => $isBn ? 'পৃষ্ঠা আলাদা করুন বা রেঞ্জ এক্সট্র্যাক্ট করুন' : 'Extract custom page ranges or split all pages', 'badge' => 'New'],
                ['icon' => 'fa-arrows-rotate', 'bg' => 'bg-violet-100', 'ic' => 'text-violet-600',
                 'label' => $isBn ? 'Rotate & Delete Pages' : 'Rotate & Delete Pages', 'route' => 'tools.pdf-tools', 'hash' => '#rotate',
                 'desc' => $isBn ? 'পৃষ্ঠা ৯০°/১৮০° ঘুরান ও অপ্রয়োজনীয় পেজ ডিলিট' : 'Rotate orientation & remove unwanted pages'],
                ['icon' => 'fa-images', 'bg' => 'bg-emerald-100', 'ic' => 'text-emerald-600',
                 'label' => $isBn ? 'JPG to PDF কনভার্টার' : 'JPG to PDF Converter', 'route' => 'tools.pdf-tools', 'hash' => '#jpg-to-pdf',
                 'desc' => $isBn ? 'এক বা একাধিক ছবিকে PDF ডকুমেন্টে রূপান্তর' : 'Convert multiple images into clean PDF'],
                ['icon' => 'fa-file-image', 'bg' => 'bg-amber-100', 'ic' => 'text-amber-600',
                 'label' => $isBn ? 'PDF to JPG এক্সট্র্যাক্টর' : 'PDF to JPG Extractor', 'route' => 'tools.pdf-tools', 'hash' => '#pdf-to-jpg',
                 'desc' => $isBn ? 'PDF পৃষ্ঠাগুলোকে হাই-কোয়ালিটি ছবিতে রূপান্তর' : 'Extract sharp images from PDF pages'],
            ],
        ],
        [
            'label' => $isBn ? 'ক্যারিয়ার টুলস' : 'Career Tools',
            'icon'  => 'fa-briefcase',
            'color' => 'text-emerald-600',
            'tools' => [
                ['icon' => 'fa-file-lines', 'bg' => 'bg-blue-100', 'ic' => 'text-blue-600',
                 'label' => $isBn ? 'ফ্রি CV বিল্ডার' : 'Free CV Builder', 'route' => 'tools.cv-builder',
                 'desc' => $isBn ? '৩টি টেমপ্লেট — PDF হিসেবে ডাউনলোড' : '3 templates — download as PDF', 'badge' => 'Popular'],
                ['icon' => 'fa-comment-sms', 'bg' => 'bg-emerald-100', 'ic' => 'text-emerald-600',
                 'label' => $isBn ? 'টেলিটক SMS ফরম্যাট জেনারেটর' : 'Teletalk SMS Generator', 'route' => 'tools.teletalk-sms',
                 'desc' => $isBn ? '১৬২২২ ফি এসএমএস ও ইউজার আইডি/পিন রিকভারি' : 'Generate 16222 job fee & recovery SMS', 'badge' => 'New'],
                ['icon' => 'fa-qrcode', 'bg' => 'bg-rose-100', 'ic' => 'text-rose-600',
                 'label' => __('ui.qr_generator'), 'route' => 'tools.qr-generator',
                 'desc' => $isBn ? 'যেকোনো URL থেকে QR কোড তৈরি' : 'Generate QR codes from any URL or text'],
                ['icon' => 'fa-lock', 'bg' => 'bg-gray-100', 'ic' => 'text-gray-600',
                 'label' => __('ui.password_generator'), 'route' => 'tools.password-generator',
                 'desc' => $isBn ? 'শক্তিশালী পাসওয়ার্ড তৈরি করুন' : 'Generate strong random passwords'],
            ],
        ],
    ];
    @endphp

    @foreach($groups as $group)
        <div class="mb-12">
            <h2 class="flex items-center gap-2 text-lg font-extrabold text-gray-900 mb-5">
                <i class="fa-solid {{ $group['icon'] }} {{ $group['color'] }}"></i>
                {{ $group['label'] }}
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @foreach($group['tools'] as $tool)
                    <a href="{{ route($tool['route']) }}{{ $tool['hash'] ?? '' }}"
                       class="card p-5 group hover:shadow-lg hover:-translate-y-1 transition-all duration-200 block">
                        <div class="flex items-start gap-4">
                            <div class="{{ $tool['bg'] }} w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-200">
                                <i class="fa-solid {{ $tool['icon'] }} {{ $tool['ic'] }} text-lg"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <h3 class="font-bold text-gray-900 text-sm group-hover:text-blue-600 transition-colors">
                                        {{ $tool['label'] }}
                                    </h3>
                                    @if(!empty($tool['badge']))
                                        <span class="text-[10px] bg-blue-500 text-white px-1.5 py-0.5 rounded-full font-semibold">
                                            {{ $tool['badge'] }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-400 leading-relaxed">{{ $tool['desc'] }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach

    @include('partials.tool-ad')
</div>
@endsection
