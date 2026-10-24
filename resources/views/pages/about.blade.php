@extends('layouts.app')

@php
    $locale = app()->getLocale();
    $isBn   = $locale === 'bn';
@endphp

@section('page_title', ($isBn ? 'আমাদের সম্পর্কে — ' . config('app.name', 'Quickkaj') : 'About Us — ' . config('app.name', 'Quickkaj')))
@section('seo_description', $isBn
    ? 'কুইককাজ সম্পর্কে বিস্তারিত জানুন। ক্যারিয়ার সুযোগ, সর্বশেষ সংবাদ ও ১৮টি প্রয়োজনীয় ফ্রি ডিজিটাল টুলস এক জায়গায়।'
    : 'Learn about Quickkaj. Smart career circulars, verified news, and 18+ free browser-based digital utilities.')

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "AboutPage",
    "name": "{{ $isBn ? 'আমাদের সম্পর্কে' : 'About Us' }}",
    "description": "{{ $isBn ? 'কুইককাজ প্ল্যাটফর্মের উদ্দেশ্য, সেবা ও গোপনীয়তার অঙ্গীকার।' : 'The mission, services and privacy commitment of Quickkaj platform.' }}",
    "url": "{{ url()->current() }}"
}
</script>
@endsection

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs text-gray-500 mb-6">
        <a href="{{ route('home', ['locale' => $locale]) }}" class="hover:text-blue-600 transition-colors">
            <i class="fa-solid fa-house"></i>
            <span>{{ __('ui.home') }}</span>
        </a>
        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
        <span class="text-gray-900 font-semibold">{{ $isBn ? 'আমাদের সম্পর্কে' : 'About Us' }}</span>
    </nav>

    {{-- Hero Header --}}
    <div class="text-center max-w-3xl mx-auto mb-14">
        <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full text-xs font-semibold bg-blue-50 border border-blue-200/80 text-blue-700 shadow-2xs mb-3">
            <i class="fa-solid fa-circle-info text-blue-600 text-xs"></i>
            <span>{{ $isBn ? 'আমাদের মিশন ও পরিচিতি' : 'Our Mission & Story' }}</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-gray-950 tracking-tight leading-tight mb-4">
            {{ $isBn ? 'স্মার্ট ক্যারিয়ার, সত্য সংবাদ ও প্রয়োজনীয় ডিজিটাল টুলস —' : 'Smart Career, Verified News & Digital Utilities —' }}
            <span class="bg-gradient-to-r from-blue-600 via-indigo-600 to-violet-600 bg-clip-text text-transparent">
                {{ $isBn ? 'সব এক ছাদের নিচে' : 'All in One Place' }}
            </span>
        </h1>
        <p class="text-sm sm:text-base text-gray-600 leading-relaxed max-w-2xl mx-auto">
            {{ $isBn
                ? 'কুইককাজ একটি বহুমুখী ডিজিটাল সেবা প্ল্যাটফর্ম। চাকরিপ্রার্থী, শিক্ষার্থী, পেশাজীবী ও সাধারণ মানুষের দৈনন্দিন জীবনের জটিল কাজগুলোকে সহজ ও সময়সাশ্রয়ী করাই আমাদের মূল লক্ষ্য।'
                : 'Quickkaj is an all-in-one digital utility and information hub. We simplify complex daily tasks for job seekers, students, and professionals with instant, privacy-focused tools.' }}
        </p>
    </div>

    {{-- Highlight Stats Row --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-16">
        <div class="card p-5 text-center bg-gradient-to-br from-blue-50/50 to-white border-blue-100">
            <p class="text-2xl sm:text-3xl font-black text-blue-600 mb-1">১৮+</p>
            <p class="text-xs font-semibold text-gray-600">{{ $isBn ? 'ফ্রি ডিজিটাল টুলস' : 'Free Digital Tools' }}</p>
        </div>
        <div class="card p-5 text-center bg-gradient-to-br from-emerald-50/50 to-white border-emerald-100">
            <p class="text-2xl sm:text-3xl font-black text-emerald-600 mb-1">১০০%</p>
            <p class="text-xs font-semibold text-gray-600">{{ $isBn ? 'ব্রাউজার প্রাইভেসিবান্ধব' : 'Client-Side Privacy' }}</p>
        </div>
        <div class="card p-5 text-center bg-gradient-to-br from-violet-50/50 to-white border-violet-100">
            <p class="text-2xl sm:text-3xl font-black text-violet-600 mb-1">০৳</p>
            <p class="text-xs font-semibold text-gray-600">{{ $isBn ? 'সম্পূর্ণ বিনামূল্যে' : 'Always Free to Use' }}</p>
        </div>
        <div class="card p-5 text-center bg-gradient-to-br from-amber-50/50 to-white border-amber-100">
            <p class="text-2xl sm:text-3xl font-black text-amber-600 mb-1">২৪/৭</p>
            <p class="text-xs font-semibold text-gray-600">{{ $isBn ? 'ইনস্ট্যান্ট অ্যাক্সেস' : 'Instant Web Access' }}</p>
        </div>
    </div>

    {{-- What We Do / Core Services --}}
    <div class="mb-16">
        <div class="text-center mb-10">
            <h2 class="section-header text-gray-900">{{ $isBn ? 'আমরা কী কী সেবা প্রদান করি?' : 'What Services Do We Provide?' }}</h2>
            <p class="section-subtitle">{{ $isBn ? 'কুইককাজ প্ল্যাটফর্মের ৪টি প্রধান মূল স্তম্ভ' : 'The four core pillars of Quickkaj platform' }}</p>
            <div class="section-divider mx-auto"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Pillar 1 --}}
            <div class="card p-6 sm:p-7 flex gap-4 hover:shadow-lg transition-all duration-200">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl flex-shrink-0 border border-emerald-100">
                    <i class="fa-solid fa-briefcase"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-base sm:text-lg mb-2">
                        {{ $isBn ? 'চাকরির বিজ্ঞপ্তি ও ক্যারিয়ার সাপোর্ট' : 'Job Circulars & Career Support' }}
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                        {{ $isBn
                            ? 'বাংলাদেশ সরকারি, ব্যাংক ও শীর্ষ কর্পোরেট প্রতিষ্ঠানের হালনাগাদ সার্কুলার, শিক্ষাগত যোগ্যতা, বয়সসীমা ও অফিশিয়াল আবেদন লিংক প্রকাশ করা হয় কোনো প্রকার বিভ্রান্তি ছাড়াই।'
                            : 'Verified circulars for government, banking, and private sectors with application deadlines, eligibility criteria, and direct application links.' }}
                    </p>
                </div>
            </div>

            {{-- Pillar 2 --}}
            <div class="card p-6 sm:p-7 flex gap-4 hover:shadow-lg transition-all duration-200">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl flex-shrink-0 border border-blue-100">
                    <i class="fa-solid fa-toolbox"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-base sm:text-lg mb-2">
                        {{ $isBn ? '১৮+ আধুনিক ডিজিটাল অনলাইন টুলস' : '18+ Modern Online Utility Tools' }}
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                        {{ $isBn
                            ? 'ফ্রি প্রফেশনাল CV তৈরি, PDF মার্জ ও স্প্লিট, সরকারি চাকরির ৩০০×৩০০ ছবি রিসাইজ, ব্যাকগ্রাউন্ড রিমুভার, বয়স ও CGPA ক্যালকুলেটর সহ নিত্যপ্রয়োজনীয় সব টুলস।'
                            : 'Free professional CV builder, PDF merge/split suite, 300x300 photo crop for Teletalk, background remover, and university CGPA calculators.' }}
                    </p>
                </div>
            </div>

            {{-- Pillar 3 --}}
            <div class="card p-6 sm:p-7 flex gap-4 hover:shadow-lg transition-all duration-200">
                <div class="w-12 h-12 rounded-2xl bg-violet-50 text-violet-600 flex items-center justify-center text-xl flex-shrink-0 border border-violet-100">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-base sm:text-lg mb-2">
                        {{ $isBn ? 'ব্যবহারকারীর গোপনীয়তার পূর্ণ নিশ্চয়তা' : '100% Client-Side Privacy Guarantee' }}
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                        {{ $isBn
                            ? 'অন্যান্য অনলাইন সাইটের মতো আপনার আপলোডকৃত ছবি বা সংবেদনশীল PDF ফাইল আমরা সার্ভারে সেভ করি না। ব্রাউজারের আধুনিক প্রযুক্তি দিয়ে সব ফাইল আপনার ডিভাইসেই প্রসেস হয়।'
                            : 'Unlike other online converters, your documents, photos, and resumes are processed entirely in your browser memory and never uploaded to our servers.' }}
                    </p>
                </div>
            </div>

            {{-- Pillar 4 --}}
            <div class="card p-6 sm:p-7 flex gap-4 hover:shadow-lg transition-all duration-200">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl flex-shrink-0 border border-amber-100">
                    <i class="fa-solid fa-newspaper"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-base sm:text-lg mb-2">
                        {{ $isBn ? 'তথ্যবহুল সংবাদ ও ক্যারিয়ার গাইড' : 'Insightful Articles & News' }}
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                        {{ $isBn
                            ? 'চাকরির পরীক্ষার প্রস্তুতি, ইন্টারভিউ টিপস, প্রযুক্তি জগতের খবর এবং বাস্তবভিত্তিক দিকনির্দেশনা প্রদান করি যা পাঠকদের ভবিষ্যৎ গড়তে সহায়তা করে।'
                            : 'Timely updates on career preparation, interview guidelines, technology trends, and analytical articles to keep you ahead.' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Why Choose Us / Values --}}
    <div class="card p-8 sm:p-10 mb-16 bg-gradient-to-br from-slate-900 to-slate-950 text-white rounded-3xl relative overflow-hidden">
        <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-blue-600/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-3xl">
            <span class="text-blue-400 font-bold text-xs uppercase tracking-widest mb-2 block">
                {{ $isBn ? 'আমাদের অঙ্গীকার' : 'Our Commitment' }}
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-white mb-4 leading-snug">
                {{ $isBn ? 'কোনো হিডেন চার্জ নেই, কোনো বাধ্যতামূলক রেজিস্ট্রেশন নেই' : 'No Hidden Charges, No Forced Signups' }}
            </h2>
            <p class="text-slate-300 text-xs sm:text-sm leading-relaxed mb-6">
                {{ $isBn
                    ? 'আমরা ইন্টারনেটের তথ্য ও সেবাকে সবার জন্য সহজলভ্য করতে বিশ্বাসী। আপনি কোনো সফটওয়্যার কেনা বা ইন্সটল না করেই সেকেন্ডের মধ্যে যেকোনো ডকুমেন্ট বা ইমেজ সম্পর্কিত কাজ সম্পন্ন করতে পারবেন।'
                    : 'We believe the web should empower everyone without paywalls or restrictive barriers. Access all tools and job circulars freely with zero friction.' }}
            </p>

            <div class="flex flex-wrap gap-4 text-xs font-semibold">
                <div class="flex items-center gap-2 bg-slate-800/80 px-3.5 py-1.5 rounded-full border border-slate-700">
                    <i class="fa-solid fa-check text-emerald-400"></i>
                    <span>{{ $isBn ? 'সবার জন্য উন্মুক্ত' : 'Open for Everyone' }}</span>
                </div>
                <div class="flex items-center gap-2 bg-slate-800/80 px-3.5 py-1.5 rounded-full border border-slate-700">
                    <i class="fa-solid fa-check text-emerald-400"></i>
                    <span>{{ $isBn ? 'কোনো ওয়াটারমার্ক নেই' : 'Zero Watermarks' }}</span>
                </div>
                <div class="flex items-center gap-2 bg-slate-800/80 px-3.5 py-1.5 rounded-full border border-slate-700">
                    <i class="fa-solid fa-check text-emerald-400"></i>
                    <span>{{ $isBn ? 'মোবাইল ও পিসিতে পারফেক্ট' : 'Fully Responsive' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Contact CTA Box --}}
    <div class="card p-8 text-center bg-gradient-to-r from-blue-50 via-indigo-50/40 to-violet-50 border-blue-200/80">
        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2">
            {{ $isBn ? 'আপনার কোনো প্রশ্ন বা মতামত আছে?' : 'Have Questions or Suggestions?' }}
        </h3>
        <p class="text-xs sm:text-sm text-gray-600 max-w-xl mx-auto mb-6">
            {{ $isBn
                ? 'আমরা প্রতিনিয়ত আমাদের প্ল্যাটফর্মকে উন্নত করছি। নতুন কোনো টুলের অনুরোধ বা পরামর্শ থাকলে সরাসরি আমাদের মেসেজ পাঠান।'
                : 'We are constantly improving our platform. If you have feature requests, tool ideas, or questions, reach out to us.' }}
        </p>
        <a href="{{ route('page.contact', ['locale' => $locale]) }}"
           class="btn-primary inline-flex items-center gap-2 px-6 py-2.5 text-sm sm:text-base font-bold shadow-md shadow-blue-600/20">
            <i class="fa-solid fa-envelope"></i>
            <span>{{ $isBn ? 'যোগাযোগ করুন' : 'Contact Us' }}</span>
        </a>
    </div>

</div>
@endsection
