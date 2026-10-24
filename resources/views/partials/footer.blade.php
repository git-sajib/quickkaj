@php $locale = app()->getLocale(); @endphp

<footer class="bg-gray-900 text-gray-300 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10">

            {{-- Brand --}}
            <div class="md:col-span-4">
                <div class="flex items-center gap-2.5 mb-4">
                    <img src="{{ asset('images/logo-icon.png') }}" alt="{{ __('ui.site_name') }}" class="w-9 h-9 rounded-xl shadow-lg object-contain">
                    <span class="text-white text-xl font-extrabold tracking-tight">{{ __('ui.site_name') }}</span>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed mb-5">
                    {{ \App\Models\Setting::getValue('footer_text_' . $locale, __('ui.site_tagline')) }}
                </p>

                {{-- Social Links --}}
                <div class="flex gap-3">
                    @if($fb = \App\Models\Setting::getValue('facebook_url'))
                        <a href="{{ $fb }}" target="_blank" rel="noopener noreferrer"
                           class="w-9 h-9 bg-gray-800 hover:bg-blue-600 rounded-lg flex items-center justify-center transition-colors"
                           aria-label="Facebook">
                            <i class="fa-brands fa-facebook-f text-sm"></i>
                        </a>
                    @else
                        <a href="https://facebook.com" target="_blank" rel="noopener noreferrer"
                           class="w-9 h-9 bg-gray-800 hover:bg-blue-600 rounded-lg flex items-center justify-center transition-colors"
                           aria-label="Facebook">
                            <i class="fa-brands fa-facebook-f text-sm"></i>
                        </a>
                    @endif
                    @if($yt = \App\Models\Setting::getValue('youtube_url'))
                        <a href="{{ $yt }}" target="_blank" rel="noopener noreferrer"
                           class="w-9 h-9 bg-gray-800 hover:bg-red-600 rounded-lg flex items-center justify-center transition-colors"
                           aria-label="YouTube">
                            <i class="fa-brands fa-youtube text-sm"></i>
                        </a>
                    @endif
                    @if($tw = \App\Models\Setting::getValue('twitter_url'))
                        <a href="{{ $tw }}" target="_blank" rel="noopener noreferrer"
                           class="w-9 h-9 bg-gray-800 hover:bg-sky-500 rounded-lg flex items-center justify-center transition-colors"
                           aria-label="Twitter/X">
                            <i class="fa-brands fa-x-twitter text-sm"></i>
                        </a>
                    @endif
                    @if($tg = \App\Models\Setting::getValue('telegram_url'))
                        <a href="{{ $tg }}" target="_blank" rel="noopener noreferrer"
                           class="w-9 h-9 bg-gray-800 hover:bg-sky-400 rounded-lg flex items-center justify-center transition-colors"
                           aria-label="Telegram">
                            <i class="fa-brands fa-telegram text-sm"></i>
                        </a>
                    @endif
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="md:col-span-2">
                <h4 class="text-white font-semibold mb-4 text-xs uppercase tracking-widest">
                    <i class="fa-solid fa-bars-staggered mr-1.5 text-blue-400"></i>
                    {{ $locale === 'bn' ? 'লিংক' : 'Links' }}
                </h4>
                <ul class="space-y-2.5 text-sm">
                    <li>
                        <a href="{{ route('home', ['locale' => $locale]) }}" class="hover:text-white transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-house text-gray-500 w-3.5 text-center"></i>{{ __('ui.home') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('jobs.index', ['locale' => $locale]) }}" class="hover:text-white transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-briefcase text-gray-500 w-3.5 text-center"></i>{{ __('ui.jobs') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('articles.index', ['locale' => $locale]) }}" class="hover:text-white transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-newspaper text-gray-500 w-3.5 text-center"></i>{{ __('ui.news') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('citizen.index', ['locale' => $locale]) }}" class="hover:text-white transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-landmark-flag text-gray-500 w-3.5 text-center"></i>{{ $locale === 'bn' ? 'নাগরিক সেবা ও রেজাল্ট' : 'Citizen Services' }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('tools.index') }}" class="hover:text-white transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-toolbox text-gray-500 w-3.5 text-center"></i>{{ __('ui.tools') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('page.about', ['locale' => $locale]) }}" class="hover:text-white transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-circle-info text-gray-500 w-3.5 text-center"></i>{{ $locale === 'bn' ? 'আমাদের সম্পর্কে' : 'About Us' }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('page.contact', ['locale' => $locale]) }}" class="hover:text-white transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-envelope text-gray-500 w-3.5 text-center"></i>{{ $locale === 'bn' ? 'যোগাযোগ' : 'Contact Us' }}
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Tools --}}
            <div class="md:col-span-3">
                <h4 class="text-white font-semibold mb-4 text-xs uppercase tracking-widest">
                    <i class="fa-solid fa-toolbox mr-1.5 text-blue-400"></i>
                    {{ __('ui.tools') }}
                </h4>
                <ul class="space-y-2.5 text-sm">
                    <li>
                        <a href="{{ route('tools.cv-builder') }}" class="hover:text-white transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-file-invoice text-gray-500 w-3.5 text-center"></i>{{ $locale === 'bn' ? 'ফ্রি CV বিল্ডার' : 'Free CV Builder' }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('tools.pdf-tools') }}" class="hover:text-white transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-file-pdf text-gray-500 w-3.5 text-center"></i>{{ $locale === 'bn' ? 'PDF মার্জ ও স্প্লিট' : 'PDF Merge & Split' }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('tools.image-resizer') }}" class="hover:text-white transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-crop-simple text-gray-500 w-3.5 text-center"></i>{{ $locale === 'bn' ? 'ছবি রিসাইজ ৩০০×৩০০' : 'Photo Resizer 300x300' }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('tools.age-calculator') }}" class="hover:text-white transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-cake-candles text-gray-500 w-3.5 text-center"></i>{{ $locale === 'bn' ? 'চাকরির বয়স ক্যালকুলেটর' : 'Age Calculator' }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('tools.qr-generator') }}" class="hover:text-white transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-qrcode text-gray-500 w-3.5 text-center"></i>{{ __('ui.qr_generator') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('shorturl.index') }}" class="hover:text-white transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-link text-gray-500 w-3.5 text-center"></i>{{ __('ui.shorten') }}
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Legal & Contact --}}
            <div class="md:col-span-3">
                <h4 class="text-white font-semibold mb-4 text-xs uppercase tracking-widest">
                    <i class="fa-solid fa-shield-halved mr-1.5 text-blue-400"></i>
                    {{ $locale === 'bn' ? 'আইনি ও নীতিমালা' : 'Legal & Trust' }}
                </h4>
                <ul class="space-y-2.5 text-sm">
                    <li>
                        <a href="{{ route('page.privacy', ['locale' => $locale]) }}" class="hover:text-white transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-user-shield text-gray-500 w-3.5 text-center"></i>
                            {{ $locale === 'bn' ? 'গোপনীয়তা নীতি' : 'Privacy Policy' }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('page.terms', ['locale' => $locale]) }}" class="hover:text-white transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-file-contract text-gray-500 w-3.5 text-center"></i>
                            {{ $locale === 'bn' ? 'ব্যবহারের শর্ত' : 'Terms of Use' }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('page.contact', ['locale' => $locale]) }}" class="hover:text-white transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-envelope text-gray-500 w-3.5 text-center"></i>
                            {{ $locale === 'bn' ? 'যোগাযোগ ও সাপোর্ট' : 'Contact & Support' }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('sitemap') }}" class="hover:text-white transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-sitemap text-gray-500 w-3.5 text-center"></i>
                            Sitemap
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="border-t border-gray-800 mt-10 pt-6 flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-gray-500">
            <p class="flex items-center gap-1.5">
                <i class="fa-regular fa-copyright"></i>
                {{ date('Y') }} {{ __('ui.site_name') }}.
                {{ $locale === 'bn' ? 'সর্বস্বত্ব সংরক্ষিত।' : 'All rights reserved.' }}
            </p>
            <p class="flex items-center gap-1">
                {{ $locale === 'bn' ? 'তৈরি করা হয়েছে' : 'Made with' }}
                <i class="fa-solid fa-heart text-red-400 mx-1"></i>
                {{ $locale === 'bn' ? 'বাংলাদেশে' : 'in Bangladesh' }}
            </p>
        </div>
    </div>
</footer>
