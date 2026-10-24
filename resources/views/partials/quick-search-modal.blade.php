@php
    $locale = app()->getLocale() ?: 'bn';
    $isBn   = $locale === 'bn';

    $quickTools = [
        ['title' => $isBn ? 'ফ্রি CV বিল্ডার' : 'Free CV Builder', 'desc' => $isBn ? 'পেশাদার সিভি তৈরি ও PDF ডাউনলোড' : 'Professional resume maker', 'url' => route('tools.cv-builder'), 'icon' => 'fa-solid fa-file-invoice', 'category' => $isBn ? 'টুলস' : 'Tools', 'color' => 'text-blue-600 bg-blue-50', 'keywords' => 'cv resume bio data চাকরি আবেদন'],
        ['title' => $isBn ? 'ইমেজ রিসাইজার ও ক্রপার' : 'Image Resizer & Cropper', 'desc' => $isBn ? 'ফটোশপ স্টাইলে ছবির মাপ ও ক্রপ' : 'Interactive image crop & resize', 'url' => route('tools.image-resizer'), 'icon' => 'fa-solid fa-crop-simple', 'category' => $isBn ? 'টুলস' : 'Tools', 'color' => 'text-indigo-600 bg-indigo-50', 'keywords' => 'image resizer crop photoshop ফটোশপ সাইজ ক্রপ ছবি'],
        ['title' => $isBn ? 'ব্যাকগ্রাউন্ড রিমুভার' : 'Background Remover', 'desc' => $isBn ? 'ছবির ব্যাকগ্রাউন্ড রিমুভ ও সাদা/নীল ব্যাকগ্রাউন্ড' : 'Remove background, transparent PNG or solid color', 'url' => route('tools.background-remover'), 'icon' => 'fa-solid fa-wand-magic-sparkles', 'category' => $isBn ? 'টুলস' : 'Tools', 'color' => 'text-rose-600 bg-rose-50', 'keywords' => 'remove bg background remover transparent ব্যাকগ্রাউন্ড রিমুভ পিএনজি'],
        ['title' => $isBn ? 'ইমেজ কম্প্রেসার' : 'Image Compressor', 'desc' => $isBn ? 'ছবির সাইজ কমান সহজে' : 'Compress images online', 'url' => route('tools.image-compressor'), 'icon' => 'fa-solid fa-compress', 'category' => $isBn ? 'টুলস' : 'Tools', 'color' => 'text-violet-600 bg-violet-50', 'keywords' => 'image photo picture compress resize ছবি'],
        ['title' => $isBn ? 'URL শর্টনার' : 'URL Shortener', 'desc' => $isBn ? 'বড় লিংক ছোট ও শেয়ার করুন' : 'Shorten long web links', 'url' => route('shorturl.index'), 'icon' => 'fa-solid fa-link', 'category' => $isBn ? 'টুলস' : 'Tools', 'color' => 'text-rose-600 bg-rose-50', 'keywords' => 'url link shorten ছোট লিংক'],
        ['title' => $isBn ? 'বয়স ক্যালকুলেটর' : 'Age Calculator', 'desc' => $isBn ? 'সঠিক বয়স বছর মাস দিনে জানুন' : 'Exact age in years, months', 'url' => route('tools.age-calculator'), 'icon' => 'fa-solid fa-cake-candles', 'category' => $isBn ? 'হিসাব' : 'Tools', 'color' => 'text-emerald-600 bg-emerald-50', 'keywords' => 'age calculator জন্মদিন বয়স জন্ম তারিখ'],
        ['title' => $isBn ? 'QR কোড জেনারেটর' : 'QR Code Generator', 'desc' => $isBn ? 'যেকোনো লিংক বা টেক্সট থেকে QR' : 'Create custom QR codes', 'url' => route('tools.qr-generator'), 'icon' => 'fa-solid fa-qrcode', 'category' => $isBn ? 'টুলস' : 'Tools', 'color' => 'text-amber-600 bg-amber-50', 'keywords' => 'qr code কিউআর বারকোড'],
        ['title' => $isBn ? 'শব্দ গণনাকারী' : 'Word Counter', 'desc' => $isBn ? 'শব্দ, অক্ষর ও লাইন গণনা' : 'Count words and characters', 'url' => route('tools.word-counter'), 'icon' => 'fa-solid fa-pen-nib', 'category' => $isBn ? 'টুলস' : 'Tools', 'color' => 'text-sky-600 bg-sky-50', 'keywords' => 'word count character টেক্সট শব্দ'],
        ['title' => $isBn ? 'বেতন ক্যালকুলেটর' : 'Salary Calculator', 'desc' => $isBn ? 'মাসিক বেতন ও কর হিসাব' : 'Monthly salary and tax', 'url' => route('tools.salary-calculator'), 'icon' => 'fa-solid fa-bangladeshi-taka-sign', 'category' => $isBn ? 'হিসাব' : 'Tools', 'color' => 'text-orange-600 bg-orange-50', 'keywords' => 'salary tax বেতন টাকা কর'],
        ['title' => $isBn ? 'পাসওয়ার্ড জেনারেটর' : 'Password Generator', 'desc' => $isBn ? 'শক্তিশালী নিরাপদ পাসওয়ার্ড' : 'Strong random passwords', 'url' => route('tools.password-generator'), 'icon' => 'fa-solid fa-lock', 'category' => $isBn ? 'নিরাপত্তা' : 'Tools', 'color' => 'text-teal-600 bg-teal-50', 'keywords' => 'password security পাসওয়ার্ড সিকিউরিটি'],
    ];
@endphp

{{-- Spotlight Universal Quick Search Modal --}}
<div id="quick-search-modal"
     class="fixed inset-0 z-50 hidden flex items-start justify-center pt-16 sm:pt-24 px-4 bg-slate-950/60 backdrop-blur-sm transition-opacity duration-150"
     role="dialog"
     aria-modal="true"
     aria-label="{{ $isBn ? 'কুইক সার্চ' : 'Quick Search' }}">

    <div class="w-full max-w-xl bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden transform transition-all duration-150 scale-95 opacity-0"
         id="quick-search-box">

        {{-- Search Input Header --}}
        <div class="relative flex items-center px-4 py-3.5 border-b border-gray-100">
            <i class="fa-solid fa-magnifying-glass text-gray-400 text-sm mr-3"></i>
            <input type="text"
                   id="quick-search-input"
                   placeholder="{{ $isBn ? 'চাকরি, সংবাদ বা যেকোনো টুল খুঁজুন...' : 'Search jobs, articles, or tools...' }}"
                   class="w-full bg-transparent text-gray-900 placeholder-gray-400 text-sm focus:outline-none font-medium"
                   autocomplete="off"
                   autocorrect="off"
                   spellcheck="false">
            <button type="button"
                    onclick="window.closeQuickSearch()"
                    class="text-xs text-gray-400 hover:text-gray-600 px-2 py-1 rounded bg-gray-100 border border-gray-200">
                ESC
            </button>
        </div>

        {{-- Dynamic Search Destinations (Jobs & Articles Search) --}}
        <div id="quick-search-destinations" class="hidden p-2 border-b border-gray-100 bg-gray-50/60 space-y-1">
            <a id="search-dest-jobs" href="#" class="flex items-center justify-between p-2.5 rounded-xl hover:bg-blue-50 text-gray-700 hover:text-blue-700 transition-colors group">
                <span class="inline-flex items-center gap-2.5 text-xs font-semibold">
                    <span class="w-7 h-7 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-briefcase"></i>
                    </span>
                    <span>{{ $isBn ? 'চাকরিতে খুঁজুন: ' : 'Search jobs for: ' }}<strong id="dest-jobs-query" class="text-blue-600"></strong></span>
                </span>
                <i class="fa-solid fa-arrow-right text-xs text-gray-300 group-hover:text-blue-600 transition-colors"></i>
            </a>

            <a id="search-dest-news" href="#" class="flex items-center justify-between p-2.5 rounded-xl hover:bg-indigo-50 text-gray-700 hover:text-indigo-700 transition-colors group">
                <span class="inline-flex items-center gap-2.5 text-xs font-semibold">
                    <span class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-newspaper"></i>
                    </span>
                    <span>{{ $isBn ? 'সংবাদে খুঁজুন: ' : 'Search news for: ' }}<strong id="dest-news-query" class="text-indigo-600"></strong></span>
                </span>
                <i class="fa-solid fa-arrow-right text-xs text-gray-300 group-hover:text-indigo-600 transition-colors"></i>
            </a>
        </div>

        {{-- Tools / Quick Items List --}}
        <div class="max-h-72 overflow-y-auto p-2" id="quick-search-list">
            <div class="px-3 py-1.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider" id="quick-search-section-label">
                {{ $isBn ? 'জনপ্রিয় টুলস ও সেবা' : 'Popular Tools & Services' }}
            </div>

            @foreach($quickTools as $t)
                <a href="{{ $t['url'] }}"
                   class="quick-search-item flex items-center justify-between p-2.5 rounded-xl hover:bg-gray-50 transition-colors group"
                   data-title="{{ strtolower($t['title']) }}"
                   data-keywords="{{ strtolower($t['keywords']) }}">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg {{ $t['color'] }} flex items-center justify-center text-xs">
                            <i class="{{ $t['icon'] }}"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-800 group-hover:text-blue-600 transition-colors">{{ $t['title'] }}</p>
                            <p class="text-[11px] text-gray-400">{{ $t['desc'] }}</p>
                        </div>
                    </div>
                    <span class="text-[10px] font-semibold text-gray-400 bg-gray-100 px-2 py-0.5 rounded">{{ $t['category'] }}</span>
                </a>
            @endforeach
        </div>

        {{-- Footer hint --}}
        <div class="px-4 py-2 bg-gray-50 border-t border-gray-100 text-[11px] text-gray-400 flex items-center justify-between">
            <span>{{ $isBn ? 'Enter চাপুন সিলেক্ট করতে' : 'Press Enter to select' }}</span>
            <span><kbd class="font-mono bg-white px-1.5 py-0.5 rounded border border-gray-200">ESC</kbd> {{ $isBn ? 'বন্ধ করুন' : 'to close' }}</span>
        </div>
    </div>
</div>

<script>
(() => {
    const modal = document.getElementById('quick-search-modal');
    const box = document.getElementById('quick-search-box');
    const input = document.getElementById('quick-search-input');
    const destBox = document.getElementById('quick-search-destinations');
    const destJobs = document.getElementById('search-dest-jobs');
    const destNews = document.getElementById('search-dest-news');
    const queryJobs = document.getElementById('dest-jobs-query');
    const queryNews = document.getElementById('dest-news-query');
    const items = document.querySelectorAll('.quick-search-item');

    const jobsBaseUrl = @json(route('jobs.index', ['locale' => $locale]));
    const newsBaseUrl = @json(route('articles.index', ['locale' => $locale]));

    window.openQuickSearch = function() {
        modal.classList.remove('hidden');
        setTimeout(() => {
            box.classList.remove('scale-95', 'opacity-0');
            box.classList.add('scale-100', 'opacity-100');
            input.focus();
        }, 10);
    };

    window.closeQuickSearch = function() {
        box.classList.remove('scale-100', 'opacity-100');
        box.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            input.value = '';
            filter('');
        }, 120);
    };

    modal?.addEventListener('click', (e) => {
        if (e.target === modal) window.closeQuickSearch();
    });

    window.addEventListener('keydown', (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
            e.preventDefault();
            if (modal.classList.contains('hidden')) window.openQuickSearch();
            else window.closeQuickSearch();
        } else if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            window.closeQuickSearch();
        }
    });

    input?.addEventListener('input', (e) => {
        filter(e.target.value.trim());
    });

    input?.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            const q = input.value.trim();
            if (q) {
                window.location.href = jobsBaseUrl + '?search=' + encodeURIComponent(q);
            }
        }
    });

    function filter(q) {
        const query = q.toLowerCase();
        if (query.length > 0) {
            destBox.classList.remove('hidden');
            queryJobs.textContent = `"${q}"`;
            queryNews.textContent = `"${q}"`;
            destJobs.href = jobsBaseUrl + '?search=' + encodeURIComponent(q);
            destNews.href = newsBaseUrl + '?search=' + encodeURIComponent(q);
        } else {
            destBox.classList.add('hidden');
        }

        items.forEach(item => {
            const title = item.dataset.title || '';
            const kw = item.dataset.keywords || '';
            if (!query || title.includes(query) || kw.includes(query)) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        });
    }
})();
</script>
