@php
    $locale = app()->getLocale();
    $isBn   = $locale === 'bn';

    $services = [
        [
            'id'          => 'jobs',
            'badge'       => $isBn ? 'চাকরি' : 'Jobs',
            'title'       => $isBn ? 'চাকরির বিজ্ঞপ্তি' : 'Job Circulars',
            'desc'        => $isBn ? 'সরকারি ও বেসরকারি চাকরির সকল বিজ্ঞপ্তি, শিক্ষাগত যোগ্যতা ও অফিসিয়াল আবেদন লিংক এক জায়গায়।' : 'All government and private job circulars, requirements, and official application links.',
            'url'         => route('jobs.index', ['locale' => $locale]),
            'action'      => $isBn ? 'বিস্তারিত দেখুন' : 'Explore Jobs',
            'icon'        => 'fa-solid fa-briefcase',
            'theme'       => 'emerald',
            'icon_bg'     => 'bg-emerald-50 text-emerald-600 border-emerald-100',
            'badge_bg'    => 'bg-emerald-50/80 text-emerald-700 border-emerald-100',
            'blob_color'  => 'from-emerald-400/20 to-teal-400/10',
            'btn_color'   => 'text-emerald-600 hover:text-emerald-700',
            'is_featured' => false,
        ],
        [
            'id'          => 'citizen',
            'badge'       => $isBn ? 'জনসেবা' : 'Citizen Hub',
            'title'       => $isBn ? 'নাগরিক সেবা ও রেজাল্ট গাইড' : 'Citizen Services & Results',
            'desc'        => $isBn ? 'ই-পাসপোর্ট, NID সংশোধন, বোর্ড পরীক্ষার রেজাল্ট SMS কোড ও দরখাস্ত ফরম্যাট এক ক্লিকেই।' : 'E-Passport, NID correction guides, exam result SMS codes, and ready official application drafts.',
            'url'         => route('citizen.index', ['locale' => $locale]),
            'action'      => $isBn ? 'সেবা তালিকা দেখুন' : 'Explore Services',
            'icon'        => 'fa-solid fa-landmark-flag',
            'theme'       => 'amber',
            'icon_bg'     => 'bg-amber-50 text-amber-600 border-amber-100',
            'badge_bg'    => 'bg-amber-50/80 text-amber-700 border-amber-100',
            'blob_color'  => 'from-amber-400/20 to-orange-400/10',
            'btn_color'   => 'text-amber-600 hover:text-amber-700',
            'is_featured' => false,
        ],
        [
            'id'          => 'news',
            'badge'       => $isBn ? 'নিউজ' : 'News',
            'title'       => $isBn ? 'সর্বশেষ খবর' : 'Latest News & Articles',
            'desc'        => $isBn ? 'দেশ-বিদেশের আপডেট খবর, তথ্যবহুল আর্টিকেল, ক্যারিয়ার গাইড ও ট্রেন্ডিং বিষয়ের বিশ্লেষণ পড়ুন।' : 'National and international news updates, insightful career articles, and trending analysis.',
            'url'         => route('articles.index', ['locale' => $locale]),
            'action'      => $isBn ? 'বিস্তারিত দেখুন' : 'Read Articles',
            'icon'        => 'fa-solid fa-newspaper',
            'theme'       => 'blue',
            'icon_bg'     => 'bg-blue-50 text-blue-600 border-blue-100',
            'badge_bg'    => 'bg-blue-50/80 text-blue-700 border-blue-100',
            'blob_color'  => 'from-blue-400/20 to-sky-400/10',
            'btn_color'   => 'text-blue-600 hover:text-blue-700',
            'is_featured' => false,
        ],
        [
            'id'          => 'tools',
            'badge'       => $isBn ? 'টুলস' : 'Tools',
            'title'       => $isBn ? 'অনলাইন টুলস' : 'Free Online Tools',
            'desc'        => $isBn ? 'Word Counter, QR Generator, JSON Formatter, Password Generator সহ দৈনন্দিন দরকারি সব টুলস।' : 'Word counter, QR code generator, JSON formatter, and security tools free forever.',
            'url'         => route('tools.index'),
            'action'      => $isBn ? 'টুলস ব্যবহার করুন' : 'Use Tools',
            'icon'        => 'fa-solid fa-screwdriver-wrench',
            'theme'       => 'violet',
            'icon_bg'     => 'bg-violet-50 text-violet-600 border-violet-100',
            'badge_bg'    => 'bg-violet-50/80 text-violet-700 border-violet-100',
            'blob_color'  => 'from-violet-400/25 to-purple-400/15',
            'btn_color'   => 'text-violet-600 hover:text-violet-700',
            'is_featured' => true,
        ],
        [
            'id'          => 'shorten',
            'badge'       => $isBn ? 'লিংক' : 'Shortener',
            'title'       => 'URL Shortener',
            'desc'        => $isBn ? 'বড় ও জটিল লিংক ছোট করুন, সহজে যেকোনো প্ল্যাটফর্মে শেয়ার করুন এবং লাইভ ক্লিক অ্যানালিটিক্স দেখুন।' : 'Shorten long URLs, share cleanly anywhere, and track real-time click analytics.',
            'url'         => route('shorturl.index'),
            'action'      => $isBn ? 'লিংক ছোট করুন' : 'Shorten Link',
            'icon'        => 'fa-solid fa-link',
            'theme'       => 'rose',
            'icon_bg'     => 'bg-rose-50 text-rose-600 border-rose-100',
            'badge_bg'    => 'bg-rose-50/80 text-rose-700 border-rose-100',
            'blob_color'  => 'from-rose-400/20 to-pink-400/10',
            'btn_color'   => 'text-rose-600 hover:text-rose-700',
            'is_featured' => false,
        ],
        [
            'id'          => 'cv',
            'badge'       => $isBn ? 'ক্যারিয়ার' : 'Resume',
            'title'       => $isBn ? 'ফ্রি CV বিল্ডার' : 'Free CV Builder',
            'desc'        => $isBn ? 'চাকরির জন্য আকর্ষণীয় ও প্রফেশনাল CV তৈরি করুন সহজে এবং সাথে সাথেই হাই-কোয়ালিটি PDF ডাউনলোড করুন।' : 'Build professional modern resumes easily and export directly to print-ready PDF.',
            'url'         => route('tools.cv-builder'),
            'action'      => $isBn ? 'CV তৈরি করুন' : 'Create CV',
            'icon'        => 'fa-solid fa-file-invoice',
            'theme'       => 'amber',
            'icon_bg'     => 'bg-amber-50 text-amber-600 border-amber-100',
            'badge_bg'    => 'bg-amber-50/80 text-amber-700 border-amber-100',
            'blob_color'  => 'from-amber-400/20 to-orange-400/10',
            'btn_color'   => 'text-amber-600 hover:text-amber-700',
            'is_featured' => false,
        ],
        [
            'id'          => 'calc',
            'badge'       => $isBn ? 'হিসাব' : 'Calculators',
            'title'       => $isBn ? 'প্রয়োজনীয় ক্যালকুলেটর' : 'Utility Calculators',
            'desc'        => $isBn ? 'বয়স ক্যালকুলেটর, BMI, CGPA, বেতন হিসাব ও বিভিন্ন একক রূপান্তরের দ্রুত ও নির্ভুল সমাধান।' : 'Age calculator, BMI, CGPA, salary breakdown, and unit conversion calculators.',
            'url'         => route('tools.age-calculator'),
            'action'      => $isBn ? 'হিসাব করুন' : 'Calculate Now',
            'icon'        => 'fa-solid fa-calculator',
            'theme'       => 'cyan',
            'icon_bg'     => 'bg-cyan-50 text-cyan-600 border-cyan-100',
            'badge_bg'    => 'bg-cyan-50/80 text-cyan-700 border-cyan-100',
            'blob_color'  => 'from-cyan-400/20 to-teal-400/10',
            'btn_color'   => 'text-cyan-600 hover:text-cyan-700',
            'is_featured' => false,
        ],
        [
            'id'          => 'images',
            'badge'       => $isBn ? 'মিডিয়া' : 'Images',
            'title'       => $isBn ? 'ইমেজ কনভার্টার ও সাইজার' : 'Image Tools',
            'desc'        => $isBn ? 'ব্রাউজারেই সম্পূর্ণ নিরাপদে ছবির আকার কমান, রিসাইজ করুন ও WebP/PNG/JPG ফরম্যাটে রূপান্তর করুন।' : 'Compress images, resize dimensions, and convert to WebP/PNG securely in browser.',
            'url'         => route('tools.image-compressor'),
            'action'      => $isBn ? 'ইমেজ টুল খুলুন' : 'Use Image Tools',
            'icon'        => 'fa-solid fa-images',
            'theme'       => 'indigo',
            'icon_bg'     => 'bg-indigo-50 text-indigo-600 border-indigo-100',
            'badge_bg'    => 'bg-indigo-50/80 text-indigo-700 border-indigo-100',
            'blob_color'  => 'from-indigo-400/20 to-blue-400/10',
            'btn_color'   => 'text-indigo-600 hover:text-indigo-700',
            'is_featured' => false,
        ],
        [
            'id'          => 'pdf',
            'badge'       => 'PDF',
            'title'       => $isBn ? 'PDF মার্জ ও কনভার্টার' : 'PDF Tools & Merge',
            'desc'        => $isBn ? 'একাধিক PDF একসাথে মার্জ, পৃষ্ঠা আলাদা বা রোটেট করুন এবং ছবি থেকে PDF বানান এক ক্লিকেই।' : 'Merge, split, rotate PDF pages and convert JPG to PDF with zero file upload.',
            'url'         => route('tools.pdf-tools'),
            'action'      => $isBn ? 'PDF টুল খুলুন' : 'Use PDF Tools',
            'icon'        => 'fa-solid fa-file-pdf',
            'theme'       => 'rose',
            'icon_bg'     => 'bg-rose-50 text-rose-600 border-rose-100',
            'badge_bg'    => 'bg-rose-50/80 text-rose-700 border-rose-100',
            'blob_color'  => 'from-rose-400/20 to-red-400/10',
            'btn_color'   => 'text-rose-600 hover:text-rose-700',
            'is_featured' => false,
        ],
        [
            'id'          => 'resizer',
            'badge'       => $isBn ? '৩০০×৩০০ ক্রপ' : '300x300 Crop',
            'title'       => $isBn ? 'চাকরির ছবি ও স্বাক্ষর রিসাইজ' : 'Job Photo & Sign Resizer',
            'desc'        => $isBn ? 'টেলিটক ও সরকারি চাকরির ৩০০×৩০০ ছবি এবং ৩০০×৮০ স্বাক্ষর নিখুঁত সাইজ ও KB সীমার মধ্যে তৈরি করুন।' : 'Crop and resize 300x300 photos and 300x80 signatures for BD government applications.',
            'url'         => route('tools.image-resizer'),
            'action'      => $isBn ? 'ছবি রিসাইজ করুন' : 'Resize Photo',
            'icon'        => 'fa-solid fa-crop-simple',
            'theme'       => 'teal',
            'icon_bg'     => 'bg-teal-50 text-teal-600 border-teal-100',
            'badge_bg'    => 'bg-teal-50/80 text-teal-700 border-teal-100',
            'blob_color'  => 'from-teal-400/20 to-emerald-400/10',
            'btn_color'   => 'text-teal-600 hover:text-teal-700',
            'is_featured' => false,
        ],
    ];
@endphp

{{-- ============================================================
     OUR SERVICES CAROUSEL SECTION
     ============================================================ --}}
<section class="pt-8 pb-14 sm:pt-10 sm:pb-16 bg-gradient-to-b from-blue-50/40 via-white to-violet-50/30 relative overflow-hidden">

    {{-- Subtle decorative background glow circles --}}
    <div class="absolute -top-32 left-1/4 w-96 h-96 bg-blue-400/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 right-1/4 w-96 h-96 bg-violet-400/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">

        {{-- Section Header inspired by reference --}}
        <div class="text-center max-w-3xl mx-auto mb-6 sm:mb-8">
            {{-- Top Badge --}}
            <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full text-xs font-semibold bg-white border border-blue-200/70 text-blue-700 shadow-2xs mb-2.5">
                <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                <span>{{ $isBn ? 'আমাদের সেবা সমূহ' : 'Our Services' }}</span>
            </div>

            {{-- Main Title --}}
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-950 tracking-tight leading-tight mb-2">
                {{ $isBn ? 'আপনার প্রয়োজন অনুযায়ী সব কিছু' : 'Everything You Need in' }}
                <span class="bg-gradient-to-r from-blue-600 via-indigo-600 to-violet-600 bg-clip-text text-transparent">
                    {{ $isBn ? 'এক জায়গায়' : 'One Platform' }}
                </span>
            </h2>

            {{-- Subtitle --}}
            <p class="text-xs sm:text-sm text-gray-500 leading-relaxed max-w-xl mx-auto">
                {{ $isBn
                    ? 'জীবনকে সহজ করতে দৈনন্দিন প্রয়োজনীয় সব অনলাইন সেবা ও ডিজিটাল টুলস এক ছাদের নিচে।'
                    : 'All essential digital utilities and online services under one roof.' }}
            </p>
        </div>

        {{-- Carousel Container with Floating Arrow Buttons --}}
        <div class="relative group/carousel">

            {{-- Prev Arrow Button --}}
            <button type="button" id="services-prev"
                    class="absolute -left-3 sm:-left-5 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white text-gray-700 shadow-md border border-gray-200/80 flex items-center justify-center hover:bg-gray-50 hover:text-blue-600 hover:scale-105 active:scale-95 transition-all duration-200 disabled:opacity-30 disabled:cursor-not-allowed disabled:hover:scale-100"
                    aria-label="{{ $isBn ? 'পূর্ববর্তী সেবা' : 'Previous service' }}">
                <i class="fa-solid fa-chevron-left text-sm"></i>
            </button>

            {{-- Next Arrow Button --}}
            <button type="button" id="services-next"
                    class="absolute -right-3 sm:-right-5 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white text-gray-700 shadow-md border border-gray-200/80 flex items-center justify-center hover:bg-gray-50 hover:text-blue-600 hover:scale-105 active:scale-95 transition-all duration-200 disabled:opacity-30 disabled:cursor-not-allowed disabled:hover:scale-100"
                    aria-label="{{ $isBn ? 'পরবর্তী সেবা' : 'Next service' }}">
                <i class="fa-solid fa-chevron-right text-sm"></i>
            </button>

            {{-- Carousel Track (Native Smooth Horizontal Scroll with Hidden Scrollbar) --}}
            <style>
                #services-track::-webkit-scrollbar {
                    display: none !important;
                    width: 0 !important;
                    height: 0 !important;
                }
                #services-track {
                    -ms-overflow-style: none !important;
                    scrollbar-width: none !important;
                }
            </style>
            <div id="services-track"
                 style="-ms-overflow-style: none; scrollbar-width: none;"
                 class="flex gap-5 overflow-x-auto no-scrollbar scroll-smooth snap-x snap-mandatory py-4 px-2 sm:px-3 focus:outline-none"
                 tabindex="0"
                 role="region"
                 aria-label="{{ $isBn ? 'সেবাসমূহ ক্যারোসেল' : 'Services Carousel' }}">

                @foreach($services as $idx => $svc)
                    <div class="service-card-item shrink-0 snap-start w-[275px] sm:w-[295px] md:w-[315px] flex flex-col justify-between rounded-3xl bg-white p-6 transition-all duration-300 relative overflow-hidden group
                                {{ $svc['is_featured']
                                    ? 'border-2 border-violet-400/80 shadow-lg shadow-violet-100/60 ring-4 ring-violet-500/10'
                                    : 'border border-gray-200/70 shadow-xs hover:shadow-xl hover:border-blue-200 hover:-translate-y-1.5' }}">

                        {{-- Subtle background gradient blob in bottom-right --}}
                        <div class="absolute -bottom-8 -right-8 w-32 h-32 rounded-full bg-gradient-to-br {{ $svc['blob_color'] }} blur-2xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

                        {{-- Top Row: Squircle Icon + Category Pill --}}
                        <div>
                            <div class="flex items-center justify-between mb-5">
                                {{-- Icon Squircle --}}
                                <div class="w-13 h-13 w-12 h-12 rounded-2xl flex items-center justify-center border shadow-2xs {{ $svc['icon_bg'] }} group-hover:scale-110 transition-transform duration-200">
                                    <i class="{{ $svc['icon'] }} text-xl"></i>
                                </div>

                                {{-- Category Pill --}}
                                <span class="text-[11px] font-bold px-2.5 py-1 rounded-full border {{ $svc['badge_bg'] }}">
                                    {{ $svc['badge'] }}
                                </span>
                            </div>

                            {{-- Title --}}
                            <h3 class="text-base sm:text-lg font-extrabold text-gray-900 mb-2 leading-snug group-hover:text-blue-600 transition-colors">
                                <a href="{{ $svc['url'] }}">
                                    {{ $svc['title'] }}
                                </a>
                            </h3>

                            {{-- Description --}}
                            <p class="text-xs text-gray-500 leading-relaxed min-h-[48px]">
                                {{ $svc['desc'] }}
                            </p>
                        </div>

                        {{-- Bottom Link with Animated Arrow --}}
                        <div class="pt-5 mt-3 border-t border-gray-100/80 flex items-center justify-between">
                            <a href="{{ $svc['url'] }}"
                               class="text-xs font-bold inline-flex items-center gap-1.5 {{ $svc['btn_color'] }} transition-all">
                                <span>{{ $svc['action'] }}</span>
                                <i class="fa-solid fa-arrow-right text-[10px] transform group-hover:translate-x-1 transition-transform duration-200"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Pagination Indicator Dots --}}
        <div class="flex items-center justify-center gap-2 mt-8" id="services-dots-container" role="tablist" aria-label="{{ $isBn ? 'পৃষ্ঠা নির্দেশক' : 'Pagination dots' }}">
            {{-- Generated dynamically by JS to match card count and scroll steps --}}
        </div>

    </div>
</section>

{{-- Carousel Controller Script --}}
@push('scripts')
<script>
(function () {
    const track = document.getElementById('services-track');
    const prevBtn = document.getElementById('services-prev');
    const nextBtn = document.getElementById('services-next');
    const dotsContainer = document.getElementById('services-dots-container');

    if (!track || !prevBtn || !nextBtn || !dotsContainer) return;

    const cards = track.querySelectorAll('.service-card-item');
    const totalCards = cards.length;
    if (totalCards === 0) return;

    // Calculate scroll step dynamically based on visible width and card width
    function getCardStep() {
        const firstCard = cards[0];
        const gap = 20; // 5rem = 20px
        return (firstCard ? firstCard.offsetWidth : 300) + gap;
    }

    // Scroll handlers
    prevBtn.addEventListener('click', function () {
        track.scrollBy({ left: -getCardStep(), behavior: 'smooth' });
    });

    nextBtn.addEventListener('click', function () {
        track.scrollBy({ left: getCardStep(), behavior: 'smooth' });
    });

    // Keyboard navigation (Left / Right arrow keys)
    track.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowLeft') {
            track.scrollBy({ left: -getCardStep(), behavior: 'smooth' });
            e.preventDefault();
        } else if (e.key === 'ArrowRight') {
            track.scrollBy({ left: getCardStep(), behavior: 'smooth' });
            e.preventDefault();
        }
    });

    // Generate indicator dots
    dotsContainer.innerHTML = '';
    cards.forEach((card, idx) => {
        const dot = document.createElement('button');
        dot.type = 'button';
        dot.className = idx === 0
            ? 'h-2 w-6 rounded-full bg-blue-600 transition-all duration-300'
            : 'h-2 w-2 rounded-full bg-blue-200 hover:bg-blue-300 transition-all duration-300';
        dot.setAttribute('aria-label', 'Slide ' + (idx + 1));
        dot.addEventListener('click', () => {
            const leftPos = idx * getCardStep();
            track.scrollTo({ left: leftPos, behavior: 'smooth' });
        });
        dotsContainer.appendChild(dot);
    });

    // Update active dot and arrow disabled state on scroll
    let scrollTimeout;
    track.addEventListener('scroll', function () {
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(updateState, 40);
    });

    function updateState() {
        const step = getCardStep();
        const currentIdx = Math.min(
            totalCards - 1,
            Math.max(0, Math.round(track.scrollLeft / step))
        );

        // Update dots
        const dots = dotsContainer.querySelectorAll('button');
        dots.forEach((dot, i) => {
            if (i === currentIdx) {
                dot.className = 'h-2 w-6 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 transition-all duration-300 shadow-2xs';
            } else {
                dot.className = 'h-2 w-2 rounded-full bg-blue-200 hover:bg-blue-300 transition-all duration-300';
            }
        });

        // Update button states
        prevBtn.disabled = track.scrollLeft <= 5;
        const maxScroll = track.scrollWidth - track.clientWidth - 5;
        nextBtn.disabled = track.scrollLeft >= maxScroll;
    }

    // Initial check
    setTimeout(updateState, 100);
    window.addEventListener('resize', updateState);
})();
</script>
@endpush
