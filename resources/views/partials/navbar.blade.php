@php
    $locale    = app()->getLocale() ?: config('app.locale', 'bn');
    $isBn      = $locale === 'bn';
    $altLocale = $locale === 'bn' ? 'en' : 'bn';
    $altLabel  = $locale === 'bn' ? 'English' : 'বাংলা';

    // Build alternate-locale URL — replace leading locale prefix, or preserve path under alt locale
    $currentPath = request()->path();
    if (preg_match('#^(bn|en)(/.*|$)#', $currentPath)) {
        $altUrl = '/' . preg_replace('#^(bn|en)#', $altLocale, $currentPath);
    } else {
        $trimmed = ltrim($currentPath, '/');
        $altUrl = $trimmed === '' ? ('/' . $altLocale) : ('/' . $altLocale . '/' . $trimmed);
    }
    if ($queryString = request()->getQueryString()) {
        $altUrl .= '?' . $queryString;
    }
@endphp

<nav class="bg-white/95 backdrop-blur-sm shadow-sm border-b border-gray-100 sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('home', ['locale' => $locale]) }}" class="flex items-center gap-2.5 group">
                <img src="{{ asset('images/logo-icon.png') }}" alt="{{ __('ui.site_name') }}" class="w-9 h-9 rounded-xl shadow-md group-hover:scale-105 transition-transform duration-200 object-contain">
                <span class="text-xl font-extrabold bg-gradient-to-r from-blue-600 to-violet-600 bg-clip-text text-transparent">
                    {{ __('ui.site_name') }}
                </span>
            </a>

            {{-- Desktop Nav --}}
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('home', ['locale' => $locale]) }}"
                   class="nav-link {{ request()->routeIs('home') ? 'nav-link-active' : '' }}">
                    {{ __('ui.home') }}
                </a>
                {{-- Jobs Dropdown --}}
                <div class="relative group/jobs py-3">
                    <a href="{{ route('jobs.index', ['locale' => $locale]) }}"
                       class="nav-link inline-flex items-center gap-1.5 {{ request()->routeIs('jobs.*') ? 'nav-link-active' : '' }}">
                        <i class="fa-solid fa-briefcase text-xs text-emerald-600"></i>
                        <span>{{ __('ui.jobs') }}</span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-gray-400 group-hover/jobs:rotate-180 group-hover/jobs:text-emerald-600 transition-transform duration-200"></i>
                    </a>

                    {{-- Dropdown Menu (Desktop) --}}
                    <div class="absolute left-0 top-full w-64 bg-white rounded-2xl shadow-xl border border-gray-100 p-2 opacity-0 invisible translate-y-2 group-hover/jobs:opacity-100 group-hover/jobs:visible group-hover/jobs:translate-y-0 transition-all duration-200 z-50 pointer-events-none group-hover/jobs:pointer-events-auto">
                        <ul class="space-y-1">
                            <li>
                                <a href="{{ route('jobs.index', ['locale' => $locale]) }}"
                                   class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-blue-50/70 text-gray-700 hover:text-blue-600 transition-colors group/item">
                                    <div class="w-7 h-7 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-xs flex-shrink-0 group-hover/item:scale-110 transition-transform">
                                        <i class="fa-solid fa-briefcase"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-900 group-hover/item:text-blue-600 transition-colors">
                                            {{ $isBn ? 'সকল চাকরির বিজ্ঞপ্তি' : 'All Job Circulars' }}
                                        </p>
                                        <p class="text-[10px] text-gray-400">{{ $isBn ? 'সর্বশেষ প্রকাশিত চাকরি' : 'Latest opportunities' }}</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('jobs.index', ['locale' => $locale, 'q' => 'সরকারি']) }}"
                                   class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-emerald-50/70 text-gray-700 hover:text-emerald-600 transition-colors group/item">
                                    <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs flex-shrink-0 group-hover/item:scale-110 transition-transform">
                                        <i class="fa-solid fa-landmark"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-900 group-hover/item:text-emerald-600 transition-colors flex items-center gap-1.5">
                                            <span>{{ $isBn ? 'সরকারি চাকরি' : 'Government Jobs' }}</span>
                                            <span class="text-[9px] bg-emerald-500 text-white px-1.5 py-0.2 rounded-full font-bold">Top</span>
                                        </p>
                                        <p class="text-[10px] text-gray-400">{{ $isBn ? 'মন্ত্রণালয় ও অধিদপ্তর' : 'Govt & Ministry' }}</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('jobs.index', ['locale' => $locale, 'q' => 'ব্যাংক']) }}"
                                   class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-violet-50/70 text-gray-700 hover:text-violet-600 transition-colors group/item">
                                    <div class="w-7 h-7 rounded-lg bg-violet-100 text-violet-600 flex items-center justify-center text-xs flex-shrink-0 group-hover/item:scale-110 transition-transform">
                                        <i class="fa-solid fa-building-columns"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-900 group-hover/item:text-violet-600 transition-colors">
                                            {{ $isBn ? 'ব্যাংক চাকরি' : 'Bank Jobs' }}
                                        </p>
                                        <p class="text-[10px] text-gray-400">{{ $isBn ? 'সরকারি ও বেসরকারি ব্যাংক' : 'Public & Private Banks' }}</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('jobs.index', ['locale' => $locale, 'deadline_within' => 7]) }}"
                                   class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-amber-50/70 text-gray-700 hover:text-amber-600 transition-colors group/item">
                                    <div class="w-7 h-7 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center text-xs flex-shrink-0 group-hover/item:scale-110 transition-transform">
                                        <i class="fa-solid fa-clock"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-900 group-hover/item:text-amber-600 transition-colors flex items-center gap-1.5">
                                            <span>{{ $isBn ? 'দ্রুত ডেডলাইন' : 'Closing Soon' }}</span>
                                            <span class="text-[9px] bg-amber-500 text-white px-1.5 py-0.2 rounded-full font-bold">৭ দিন</span>
                                        </p>
                                        <p class="text-[10px] text-gray-400">{{ $isBn ? 'আবেদনের শেষ সময় আসন্ন' : 'Expiring in 7 days' }}</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('jobs.saved', ['locale' => $locale]) }}"
                                   class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-rose-50/70 text-gray-700 hover:text-rose-600 transition-colors group/item">
                                    <div class="w-7 h-7 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center text-xs flex-shrink-0 group-hover/item:scale-110 transition-transform">
                                        <i class="fa-solid fa-bookmark"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-900 group-hover/item:text-rose-600 transition-colors">
                                            {{ $isBn ? 'সেভ করা চাকরি' : 'Saved Jobs' }}
                                        </p>
                                        <p class="text-[10px] text-gray-400">{{ $isBn ? 'আপনার বুকমার্ক করা তালিকা' : 'Your saved list' }}</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <a href="{{ route('citizen.index', ['locale' => $locale]) }}"
                   class="nav-link inline-flex items-center gap-1.5 {{ request()->routeIs('citizen.*') ? 'nav-link-active' : '' }}">
                    <i class="fa-solid fa-landmark-flag text-xs text-amber-600"></i>
                    <span>{{ $isBn ? 'নাগরিক সেবা' : 'Citizen Services' }}</span>
                </a>
                <a href="{{ route('articles.index', ['locale' => $locale]) }}"
                   class="nav-link {{ request()->routeIs('articles.*') ? 'nav-link-active' : '' }}">
                    {{ __('ui.news') }}
                </a>

                {{-- Tools Mega Dropdown Menu --}}
                <div class="relative group/tools py-3">
                    <a href="{{ route('tools.index', ['locale' => $locale]) }}"
                       class="nav-link inline-flex items-center gap-1.5 {{ request()->routeIs('tools.*') || request()->routeIs('shorturl.*') ? 'nav-link-active' : '' }}">
                        <i class="fa-solid fa-toolbox text-xs text-blue-600"></i>
                        <span>{{ __('ui.tools') }}</span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-gray-400 group-hover/tools:rotate-180 group-hover/tools:text-blue-600 transition-transform duration-200"></i>
                    </a>

                    {{-- Mega Flyout Menu (Desktop) --}}
                    <div class="absolute left-1/2 -translate-x-1/2 top-full w-[720px] max-w-[92vw] bg-white rounded-3xl shadow-2xl border border-gray-100 p-6 opacity-0 invisible translate-y-2 group-hover/tools:opacity-100 group-hover/tools:visible group-hover/tools:translate-y-0 transition-all duration-200 z-50 pointer-events-none group-hover/tools:pointer-events-auto">
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">

                            {{-- Col 1: Resume & PDF --}}
                            <div>
                                <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2.5 flex items-center gap-1.5">
                                    <i class="fa-solid fa-file-pdf text-rose-500"></i>
                                    <span>{{ $isBn ? 'ডকুমেন্ট ও সিভি' : 'Docs & Resume' }}</span>
                                </h4>
                                <ul class="space-y-1">
                                    <li>
                                        <a href="{{ route('tools.cv-builder') }}" class="group/item flex items-start gap-2.5 p-2 rounded-xl hover:bg-blue-50/70 transition-colors">
                                            <div class="w-7 h-7 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-xs flex-shrink-0 group-hover/item:scale-110 transition-transform">
                                                <i class="fa-solid fa-file-invoice"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-800 group-hover/item:text-blue-600 transition-colors flex items-center gap-1.5">
                                                    <span>{{ $isBn ? 'ফ্রি CV বিল্ডার' : 'CV Builder' }}</span>
                                                    <span class="text-[9px] bg-rose-500 text-white px-1.5 py-0.2 rounded-full font-bold">Hot</span>
                                                </p>
                                                <p class="text-[10px] text-gray-400 line-clamp-1">{{ $isBn ? '৩টি টেমপ্লেট ও PDF' : '3 Templates & PDF' }}</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tools.pdf-tools') }}" class="group/item flex items-start gap-2.5 p-2 rounded-xl hover:bg-rose-50/70 transition-colors">
                                            <div class="w-7 h-7 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center text-xs flex-shrink-0 group-hover/item:scale-110 transition-transform">
                                                <i class="fa-solid fa-object-group"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-800 group-hover/item:text-rose-600 transition-colors flex items-center gap-1.5">
                                                    <span>{{ $isBn ? 'Merge ও Split PDF' : 'PDF Tools' }}</span>
                                                    <span class="text-[9px] bg-blue-500 text-white px-1.5 py-0.2 rounded-full font-bold">New</span>
                                                </p>
                                                <p class="text-[10px] text-gray-400 line-clamp-1">{{ $isBn ? 'মার্জ ও পৃষ্ঠা আলাদা' : 'Merge & Split' }}</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tools.pdf-tools') }}#jpg-to-pdf" class="group/item flex items-start gap-2.5 p-2 rounded-xl hover:bg-emerald-50/70 transition-colors">
                                            <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs flex-shrink-0 group-hover/item:scale-110 transition-transform">
                                                <i class="fa-solid fa-images"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-800 group-hover/item:text-emerald-600 transition-colors">
                                                    {{ $isBn ? 'JPG to PDF' : 'JPG to PDF' }}
                                                </p>
                                                <p class="text-[10px] text-gray-400 line-clamp-1">{{ $isBn ? 'ছবি থেকে সাজানো PDF' : 'Images to PDF' }}</p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            {{-- Col 2: Images & Photo --}}
                            <div>
                                <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2.5 flex items-center gap-1.5">
                                    <i class="fa-solid fa-image text-violet-500"></i>
                                    <span>{{ $isBn ? 'ইমেজ ও ফটো' : 'Images & Photo' }}</span>
                                </h4>
                                <ul class="space-y-1">
                                    <li>
                                        <a href="{{ route('tools.image-resizer') }}" class="group/item flex items-start gap-2.5 p-2 rounded-xl hover:bg-teal-50/70 transition-colors">
                                            <div class="w-7 h-7 rounded-lg bg-teal-100 text-teal-600 flex items-center justify-center text-xs flex-shrink-0 group-hover/item:scale-110 transition-transform">
                                                <i class="fa-solid fa-crop-simple"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-800 group-hover/item:text-teal-600 transition-colors flex items-center gap-1.5">
                                                    <span>{{ $isBn ? 'ছবি রিসাইজ' : 'Photo Resizer' }}</span>
                                                    <span class="text-[9px] bg-amber-500 text-white px-1.5 py-0.2 rounded-full font-bold">300x300</span>
                                                </p>
                                                <p class="text-[10px] text-gray-400 line-clamp-1">{{ $isBn ? 'সরকারি চাকরি ও টেলিটক' : 'Teletalk & Govt Job' }}</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tools.background-remover') }}" class="group/item flex items-start gap-2.5 p-2 rounded-xl hover:bg-violet-50/70 transition-colors">
                                            <div class="w-7 h-7 rounded-lg bg-violet-100 text-violet-600 flex items-center justify-center text-xs flex-shrink-0 group-hover/item:scale-110 transition-transform">
                                                <i class="fa-solid fa-wand-magic-sparkles"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-800 group-hover/item:text-violet-600 transition-colors flex items-center gap-1.5">
                                                    <span>{{ $isBn ? 'ব্যাকগ্রাউন্ড রিমুভ' : 'BG Remover' }}</span>
                                                    <span class="text-[9px] bg-violet-500 text-white px-1.5 py-0.2 rounded-full font-bold">AI</span>
                                                </p>
                                                <p class="text-[10px] text-gray-400 line-clamp-1">{{ $isBn ? 'পাসপোর্ট সাইজ ও স্বচ্ছ' : 'Passport Blue/White' }}</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tools.image-compressor') }}" class="group/item flex items-start gap-2.5 p-2 rounded-xl hover:bg-blue-50/70 transition-colors">
                                            <div class="w-7 h-7 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-xs flex-shrink-0 group-hover/item:scale-110 transition-transform">
                                                <i class="fa-solid fa-compress"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-800 group-hover/item:text-blue-600 transition-colors">
                                                    {{ $isBn ? 'ইমেজ কম্প্রেসার' : 'Compressor' }}
                                                </p>
                                                <p class="text-[10px] text-gray-400 line-clamp-1">{{ $isBn ? 'ছবির সাইজ কমান' : 'Reduce KB size' }}</p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            {{-- Col 3: Calculators --}}
                            <div>
                                <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2.5 flex items-center gap-1.5">
                                    <i class="fa-solid fa-calculator text-blue-500"></i>
                                    <span>{{ $isBn ? 'ক্যালকুলেটর' : 'Calculators' }}</span>
                                </h4>
                                <ul class="space-y-1">
                                    <li>
                                        <a href="{{ route('tools.age-calculator') }}" class="group/item flex items-start gap-2.5 p-2 rounded-xl hover:bg-emerald-50/70 transition-colors">
                                            <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs flex-shrink-0 group-hover/item:scale-110 transition-transform">
                                                <i class="fa-solid fa-cake-candles"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-800 group-hover/item:text-emerald-600 transition-colors">
                                                    {{ $isBn ? 'বয়স ক্যালকুলেটর' : 'Age Calculator' }}
                                                </p>
                                                <p class="text-[10px] text-gray-400 line-clamp-1">{{ $isBn ? 'চাকরির বয়স হিসাব' : 'Years, Months, Days' }}</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tools.cgpa-calculator') }}" class="group/item flex items-start gap-2.5 p-2 rounded-xl hover:bg-indigo-50/70 transition-colors">
                                            <div class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs flex-shrink-0 group-hover/item:scale-110 transition-transform">
                                                <i class="fa-solid fa-graduation-cap"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-800 group-hover/item:text-indigo-600 transition-colors">
                                                    {{ $isBn ? 'CGPA ক্যালকুলেটর' : 'CGPA Calculator' }}
                                                </p>
                                                <p class="text-[10px] text-gray-400 line-clamp-1">{{ $isBn ? '৪.০ ও ৫.০ স্কেল' : '4.0 / 5.0 scale' }}</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tools.salary-calculator') }}" class="group/item flex items-start gap-2.5 p-2 rounded-xl hover:bg-orange-50/70 transition-colors">
                                            <div class="w-7 h-7 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center text-xs flex-shrink-0 group-hover/item:scale-110 transition-transform">
                                                <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-800 group-hover/item:text-orange-600 transition-colors">
                                                    {{ $isBn ? 'বেতন ও ট্যাক্স' : 'Salary & Tax' }}
                                                </p>
                                                <p class="text-[10px] text-gray-400 line-clamp-1">{{ $isBn ? 'পে-স্কেল ও আয়কর হিসাব' : 'NBR Income Tax' }}</p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            {{-- Col 4: Utilities & Link --}}
                            <div>
                                <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2.5 flex items-center gap-1.5">
                                    <i class="fa-solid fa-screwdriver-wrench text-amber-500"></i>
                                    <span>{{ $isBn ? 'ইউটিলিটি ও লিংক' : 'Utilities & Links' }}</span>
                                </h4>
                                <ul class="space-y-1">
                                    <li>
                                        <a href="{{ route('shorturl.index') }}" class="group/item flex items-start gap-2.5 p-2 rounded-xl hover:bg-amber-50/70 transition-colors">
                                            <div class="w-7 h-7 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center text-xs flex-shrink-0 group-hover/item:scale-110 transition-transform">
                                                <i class="fa-solid fa-link"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-800 group-hover/item:text-amber-600 transition-colors flex items-center gap-1.5">
                                                    <span>{{ $isBn ? 'URL শর্টনার' : 'URL Shortener' }}</span>
                                                    <span class="text-[9px] bg-emerald-500 text-white px-1.5 py-0.2 rounded-full font-bold">Fast</span>
                                                </p>
                                                <p class="text-[10px] text-gray-400 line-clamp-1">{{ $isBn ? 'লিংক ছোট ও ট্র্যাকিং' : 'Short link & stats' }}</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tools.qr-generator') }}" class="group/item flex items-start gap-2.5 p-2 rounded-xl hover:bg-rose-50/70 transition-colors">
                                            <div class="w-7 h-7 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center text-xs flex-shrink-0 group-hover/item:scale-110 transition-transform">
                                                <i class="fa-solid fa-qrcode"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-800 group-hover/item:text-rose-600 transition-colors">
                                                    {{ $isBn ? 'QR জেনারেটর' : 'QR Generator' }}
                                                </p>
                                                <p class="text-[10px] text-gray-400 line-clamp-1">{{ $isBn ? 'কাস্টম QR কোড তৈরি' : 'Color QR Code' }}</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tools.word-counter') }}" class="group/item flex items-start gap-2.5 p-2 rounded-xl hover:bg-blue-50/70 transition-colors">
                                            <div class="w-7 h-7 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-xs flex-shrink-0 group-hover/item:scale-110 transition-transform">
                                                <i class="fa-solid fa-pen-nib"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-800 group-hover/item:text-blue-600 transition-colors">
                                                    {{ $isBn ? 'ওয়ার্ড কাউন্টার' : 'Word Counter' }}
                                                </p>
                                                <p class="text-[10px] text-gray-400 line-clamp-1">{{ $isBn ? 'শব্দ ও অক্ষর গণনা' : 'Words & Characters' }}</p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                        </div>

                        {{-- Mega Menu Footer --}}
                        <div class="mt-4 pt-3.5 border-t border-gray-100 flex items-center justify-between text-xs bg-gray-50/80 -mx-6 -mb-6 px-6 py-3 rounded-b-3xl">
                            <span class="text-gray-500 font-medium flex items-center gap-1.5">
                                <i class="fa-solid fa-shield-check text-emerald-500"></i>
                                <span>{{ $isBn ? '১৮টি ডিজিটাল টুলস • ১০০% নিরাপদ ও ক্লায়েন্ট-সাইড' : '18 Free Digital Tools • 100% Privacy' }}</span>
                            </span>
                            <a href="{{ route('tools.index', ['locale' => $locale]) }}" class="text-blue-600 hover:text-blue-700 font-bold flex items-center gap-1 group/all">
                                <span>{{ $isBn ? 'সব ১৮টি টুলস দেখুন' : 'Browse All 18 Tools' }}</span>
                                <i class="fa-solid fa-arrow-right text-[10px] group-hover/all:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: language switcher + auth --}}
            <div class="flex items-center gap-3">

                {{-- Language Toggle --}}
                <a href="{{ $altUrl }}"
                   class="text-xs font-semibold px-3 py-1.5 rounded-full bg-gray-100 hover:bg-blue-50 text-gray-600 hover:text-blue-600 transition-colors border border-gray-200 whitespace-nowrap inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-globe text-blue-600"></i>
                    <span>{{ $altLabel }}</span>
                </a>

                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                           class="text-xs font-semibold px-3 py-1.5 rounded-full bg-violet-50 hover:bg-violet-100 text-violet-700 transition-colors border border-violet-200 inline-flex items-center gap-1.5">
                            <i class="fa-solid fa-gear text-violet-600"></i>
                            <span>{{ __('ui.admin') }}</span>
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xs text-gray-500 hover:text-red-500 transition-colors">
                            {{ __('ui.logout') }}
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-primary text-sm">{{ __('ui.login') }}</a>
                @endauth

                {{-- Mobile hamburger button --}}
                <button id="mobile-menu-btn"
                        type="button"
                        class="md:hidden w-9 h-9 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors text-gray-700 focus:outline-none"
                        aria-label="Toggle menu"
                        aria-expanded="false">
                    <i id="mobile-menu-icon" class="fa-solid fa-bars text-lg"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Floating Overlay Drawer --}}
    <div id="mobile-menu"
         class="md:hidden hidden absolute top-full left-0 right-0 w-full bg-white/95 backdrop-blur-md shadow-2xl border-b border-gray-100 z-50 transition-all duration-200">
        <div class="max-w-7xl mx-auto px-4 py-3 flex flex-col gap-1">
            <a href="{{ route('home', ['locale' => $locale]) }}" class="mobile-nav-link flex items-center gap-2.5 {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">
                <i class="fa-solid fa-house w-4 text-center text-blue-600"></i>
                <span>{{ __('ui.home') }}</span>
            </a>
            {{-- Mobile Jobs Accordion --}}
            <div>
                <button type="button" id="mobile-jobs-toggle"
                        class="mobile-nav-link w-full flex items-center justify-between {{ request()->routeIs('jobs.*') ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-briefcase w-4 text-center text-emerald-600"></i>
                        <span>{{ __('ui.jobs') }}</span>
                    </div>
                    <i id="mobile-jobs-chevron" class="fa-solid fa-chevron-down text-xs text-gray-400 transition-transform duration-200"></i>
                </button>
                <div id="mobile-jobs-list" class="hidden pl-6 pr-2 py-2 space-y-2 bg-gray-50/70 rounded-xl mt-1 text-xs">
                    <a href="{{ route('jobs.index', ['locale' => $locale]) }}" class="flex items-center justify-between py-1 text-gray-700 hover:text-blue-600">
                        <span>{{ $isBn ? 'সকল চাকরির বিজ্ঞপ্তি' : 'All Job Circulars' }}</span>
                    </a>
                    <a href="{{ route('jobs.index', ['locale' => $locale, 'q' => 'সরকারি']) }}" class="flex items-center justify-between py-1 text-gray-700 hover:text-emerald-600">
                        <span>{{ $isBn ? 'সরকারি চাকরি' : 'Government Jobs' }}</span>
                        <span class="text-[9px] bg-emerald-500 text-white px-1.5 py-0.2 rounded-full font-bold">Top</span>
                    </a>
                    <a href="{{ route('jobs.index', ['locale' => $locale, 'q' => 'ব্যাংক']) }}" class="flex items-center justify-between py-1 text-gray-700 hover:text-violet-600">
                        <span>{{ $isBn ? 'ব্যাংক চাকরি' : 'Bank Jobs' }}</span>
                    </a>
                    <a href="{{ route('jobs.index', ['locale' => $locale, 'deadline_within' => 7]) }}" class="flex items-center justify-between py-1 text-gray-700 hover:text-amber-600">
                        <span>{{ $isBn ? 'দ্রুত ডেডলাইন' : 'Closing Soon' }}</span>
                        <span class="text-[9px] bg-amber-500 text-white px-1.5 py-0.2 rounded-full font-bold">{{ $isBn ? '৭ দিন' : '7 days' }}</span>
                    </a>
                    <a href="{{ route('jobs.saved', ['locale' => $locale]) }}" class="flex items-center justify-between py-1 text-gray-700 hover:text-rose-600">
                        <span>{{ $isBn ? 'সেভ করা চাকরি' : 'Saved Jobs' }}</span>
                        <i class="fa-solid fa-bookmark text-rose-500 text-[10px]"></i>
                    </a>
                </div>
            </div>
            <a href="{{ route('citizen.index', ['locale' => $locale]) }}" class="mobile-nav-link flex items-center gap-2.5 {{ request()->routeIs('citizen.*') ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">
                <i class="fa-solid fa-landmark-flag w-4 text-center text-amber-600"></i>
                <span>{{ $isBn ? 'নাগরিক সেবা ও রেজাল্ট' : 'Citizen Services & Results' }}</span>
            </a>
            <a href="{{ route('articles.index', ['locale' => $locale]) }}" class="mobile-nav-link flex items-center gap-2.5 {{ request()->routeIs('articles.*') ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">
                <i class="fa-solid fa-newspaper w-4 text-center text-blue-600"></i>
                <span>{{ __('ui.news') }}</span>
            </a>

            {{-- Mobile Tools Accordion --}}
            <div class="border-y border-gray-100 my-1 py-1">
                <button type="button" id="mobile-tools-toggle"
                        class="mobile-nav-link w-full flex items-center justify-between {{ request()->routeIs('tools.*') || request()->routeIs('shorturl.*') ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-toolbox w-4 text-center text-violet-600"></i>
                        <span>{{ __('ui.tools') }}</span>
                    </div>
                    <i id="mobile-tools-chevron" class="fa-solid fa-chevron-down text-xs text-gray-400 transition-transform duration-200"></i>
                </button>
                <div id="mobile-tools-list" class="hidden pl-6 pr-2 py-2 space-y-2 bg-gray-50/70 rounded-xl mt-1 text-xs">
                    <a href="{{ route('tools.cv-builder') }}" class="flex items-center justify-between py-1 text-gray-700 hover:text-blue-600">
                        <span>{{ $isBn ? 'ফ্রি CV বিল্ডার' : 'Free CV Builder' }}</span>
                        <span class="text-[9px] bg-rose-500 text-white px-1.5 py-0.2 rounded-full font-bold">Hot</span>
                    </a>
                    <a href="{{ route('tools.pdf-tools') }}" class="flex items-center justify-between py-1 text-gray-700 hover:text-blue-600">
                        <span>{{ $isBn ? 'PDF মার্জ ও স্প্লিট' : 'PDF Merge & Split' }}</span>
                        <span class="text-[9px] bg-blue-500 text-white px-1.5 py-0.2 rounded-full font-bold">New</span>
                    </a>
                    <a href="{{ route('tools.image-resizer') }}" class="flex items-center justify-between py-1 text-gray-700 hover:text-blue-600">
                        <span>{{ $isBn ? 'ছবি রিসাইজ ৩০০×৩০০' : 'Photo Resizer 300x300' }}</span>
                        <span class="text-[9px] bg-amber-500 text-white px-1.5 py-0.2 rounded-full font-bold">300x300</span>
                    </a>
                    <a href="{{ route('tools.background-remover') }}" class="flex items-center justify-between py-1 text-gray-700 hover:text-blue-600">
                        <span>{{ $isBn ? 'ব্যাকগ্রাউন্ড রিমুভার' : 'Background Remover' }}</span>
                    </a>
                    <a href="{{ route('tools.age-calculator') }}" class="flex items-center justify-between py-1 text-gray-700 hover:text-blue-600">
                        <span>{{ $isBn ? 'চাকরির বয়স ক্যালকুলেটর' : 'Age Calculator' }}</span>
                    </a>
                    <a href="{{ route('tools.cgpa-calculator') }}" class="flex items-center justify-between py-1 text-gray-700 hover:text-blue-600">
                        <span>{{ $isBn ? 'CGPA ক্যালকুলেটর' : 'CGPA Calculator' }}</span>
                    </a>
                    <a href="{{ route('shorturl.index') }}" class="flex items-center justify-between py-1 text-gray-700 hover:text-blue-600">
                        <span>{{ $isBn ? 'URL শর্টনার' : 'URL Shortener' }}</span>
                        <span class="text-[9px] bg-emerald-500 text-white px-1.5 py-0.2 rounded-full font-bold">Fast</span>
                    </a>
                    <a href="{{ route('tools.qr-generator') }}" class="flex items-center justify-between py-1 text-gray-700 hover:text-blue-600">
                        <span>{{ __('ui.qr_generator') }}</span>
                    </a>
                    <a href="{{ route('tools.index', ['locale' => $locale]) }}" class="block pt-2 border-t border-gray-200 font-bold text-blue-600 hover:text-blue-700">
                        {{ $isBn ? 'সব ১৮টি ডিজিটাল টুলস দেখুন →' : 'Browse All 18 Tools →' }}
                    </a>
                </div>
            </div>
            <a href="{{ route('page.about', ['locale' => $locale]) }}" class="mobile-nav-link flex items-center gap-2.5 {{ request()->routeIs('page.about') ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">
                <i class="fa-solid fa-circle-info w-4 text-center text-indigo-600"></i>
                <span>{{ $locale === 'bn' ? 'আমাদের সম্পর্কে' : 'About Us' }}</span>
            </a>
            <a href="{{ route('page.contact', ['locale' => $locale]) }}" class="mobile-nav-link flex items-center gap-2.5 {{ request()->routeIs('page.contact') ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">
                <i class="fa-solid fa-envelope w-4 text-center text-rose-600"></i>
                <span>{{ $locale === 'bn' ? 'যোগাযোগ' : 'Contact Us' }}</span>
            </a>
            <div class="pt-2 mt-1 border-t border-gray-100 flex items-center justify-between">
                <a href="{{ $altUrl }}" class="mobile-nav-link font-semibold text-blue-600 flex items-center gap-2">
                    <i class="fa-solid fa-globe"></i>
                    <span>{{ $altLabel }}</span>
                </a>
            </div>
        </div>
    </div>
</nav>

{{-- Mobile Overlay Backdrop --}}
<div id="mobile-menu-backdrop" class="fixed inset-0 top-16 bg-black/30 backdrop-blur-[2px] z-30 hidden md:hidden"></div>

<script>
(() => {
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    const backdrop = document.getElementById('mobile-menu-backdrop');
    const icon = document.getElementById('mobile-menu-icon');
    const jobsToggle = document.getElementById('mobile-jobs-toggle');
    const jobsList = document.getElementById('mobile-jobs-list');
    const jobsChevron = document.getElementById('mobile-jobs-chevron');
    const toolsToggle = document.getElementById('mobile-tools-toggle');
    const toolsList = document.getElementById('mobile-tools-list');
    const toolsChevron = document.getElementById('mobile-tools-chevron');

    function toggleMenu() {
        const isOpen = !menu.classList.contains('hidden');
        if (isOpen) {
            closeMenu();
        } else {
            openMenu();
        }
    }

    function openMenu() {
        menu.classList.remove('hidden');
        backdrop.classList.remove('hidden');
        btn.setAttribute('aria-expanded', 'true');
        icon.classList.remove('fa-bars');
        icon.classList.add('fa-xmark');
    }

    function closeMenu() {
        menu.classList.add('hidden');
        backdrop.classList.add('hidden');
        btn.setAttribute('aria-expanded', 'false');
        icon.classList.remove('fa-xmark');
        icon.classList.add('fa-bars');
    }

    btn?.addEventListener('click', toggleMenu);
    backdrop?.addEventListener('click', closeMenu);

    // Mobile Jobs Accordion
    jobsToggle?.addEventListener('click', (e) => {
        e.preventDefault();
        const isHidden = jobsList.classList.contains('hidden');
        if (isHidden) {
            jobsList.classList.remove('hidden');
            jobsChevron.classList.add('rotate-180');
        } else {
            jobsList.classList.add('hidden');
            jobsChevron.classList.remove('rotate-180');
        }
    });

    // Mobile Tools Accordion
    toolsToggle?.addEventListener('click', (e) => {
        e.preventDefault();
        const isHidden = toolsList.classList.contains('hidden');
        if (isHidden) {
            toolsList.classList.remove('hidden');
            toolsChevron.classList.add('rotate-180');
        } else {
            toolsList.classList.add('hidden');
            toolsChevron.classList.remove('rotate-180');
        }
    });

    // Close when clicking any nav link inside drawer (except accordion button)
    menu?.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', closeMenu);
    });
})();
</script>
