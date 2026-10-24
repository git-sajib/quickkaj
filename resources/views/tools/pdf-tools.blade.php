@extends('layouts.app')

@php
    $isBn = app()->getLocale() === 'bn';
@endphp

@section('page_title', ($isBn ? 'পিডিএফ ও ডকুমেন্ট টুলস' : 'All-in-One PDF & Document Tools') . ' — ' . __('ui.site_name'))
@section('seo_description', $isBn
    ? 'একাধিক PDF মার্জ, স্প্লিট, পেজ ঘুরানো ও ডিলিট, ছবি থেকে PDF এবং PDF থেকে JPG কনভার্ট করুন ১০০% বিনামূল্যে ও ব্রাউজারে সুরক্ষিতভাবে।'
    : 'Merge, split, rotate, delete pages, JPG to PDF and PDF to JPG 100% free and securely in your browser.')

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "WebApplication",
    "name": "{{ $isBn ? 'অল-ইন-ওয়ান পিডিএফ ও ডকুমেন্ট টুলস' : 'All-in-One PDF & Document Tools' }}",
    "description": "{{ $isBn ? 'PDF মার্জ, স্প্লিট, পেজ ডিলিট, ও JPG রূপান্তরের ১০০% ফ্রি ব্রাউজার টুল।' : 'Merge, split, rotate, delete pages, and convert JPG to PDF 100% locally in your browser.' }}",
    "url": "{{ url()->current() }}",
    "applicationCategory": "UtilitiesApplication",
    "operatingSystem": "All",
    "inLanguage": "{{ $isBn ? 'bn-BD' : 'en-US' }}",
    "offers": {
        "@@type": "Offer",
        "price": "0",
        "priceCurrency": "USD"
    }
}
</script>
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "FAQPage",
    "mainEntity": [
        {
            "@@type": "Question",
            "name": "{{ $isBn ? 'আমার পিডিএফ ফাইল কি সার্ভারে আপলোড করা হয়?' : 'Are my PDF files uploaded to any server?' }}",
            "acceptedAnswer": {
                "@@type": "Answer",
                "text": "{{ $isBn ? 'না! আমাদের PDF টুলস সম্পূর্ণ ক্লায়েন্ট-সাইড (WebAssembly/PDF-lib) প্রযুক্তিতে চলে। ফাইল কোথাও আপলোড হয় না, আপনার ডিভাইসেই প্রসেস হয়।' : 'No! All processing runs 100% locally in your browser via client-side WebAssembly. Your documents never leave your device.' }}"
            }
        },
        {
            "@@type": "Question",
            "name": "{{ $isBn ? 'কোনো ফাইল সাইজ বা পেজ লিমিট আছে কি?' : 'Are there file size or page restrictions?' }}",
            "acceptedAnswer": {
                "@@type": "Answer",
                "text": "{{ $isBn ? 'না, যেকোনো সাইজের পিডিএফ আনলিমিটেড পেজ মার্জ বা স্প্লিট করতে পারবেন সম্পূর্ণ ফ্রিতে।' : 'No artificial caps or page restrictions. Merge or split files of any length for free.' }}"
            }
        }
    ]
}
</script>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @include('partials.tool-back')

    {{-- Top Header --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-gradient-to-br from-red-500 via-rose-600 to-pink-600 text-white rounded-2xl flex items-center justify-center shadow-md shadow-rose-500/20 flex-shrink-0">
                <i class="fa-solid fa-file-pdf text-2xl"></i>
            </div>
            <div>
                <div class="flex items-center gap-2 flex-wrap">
                    <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">
                        {{ $isBn ? 'পিডিএফ ও ডকুমেন্ট টুলস' : 'All-in-One PDF & Document Tools' }}
                    </h1>
                    <span class="inline-flex items-center gap-1 text-[11px] font-bold bg-rose-50 text-rose-600 border border-rose-200/80 px-2.5 py-0.5 rounded-full">
                        <i class="fa-solid fa-sparkles text-[10px]"></i>
                        {{ $isBn ? '৫টি প্রয়োজনীয় টুল' : '5-in-1 Suite' }}
                    </span>
                </div>
                <p class="text-gray-500 text-xs sm:text-sm mt-0.5">
                    {{ $isBn ? 'Merge, Split, Rotate, Delete Pages, JPG to PDF ও PDF to JPG — সম্পূর্ণ বিনামূল্যে ও প্রাইভেট।' : 'Merge, split, rotate, delete pages, JPG to PDF & PDF to JPG — 100% free and private.' }}
                </p>
            </div>
        </div>

        {{-- Privacy Badge --}}
        <div class="flex items-center gap-2 bg-emerald-50 border border-emerald-200/70 text-emerald-800 text-xs px-3.5 py-2 rounded-xl self-start md:self-center">
            <i class="fa-solid fa-shield-halved text-emerald-600 text-sm"></i>
            <div>
                <div class="font-bold text-[11px] leading-tight text-emerald-900">{{ $isBn ? '১০০% ব্রাউজার প্রসেসিং' : '100% Client-Side Privacy' }}</div>
                <div class="text-[10px] text-emerald-700/90 leading-tight">{{ $isBn ? 'ফাইল কোথাও আপলোড হয় না' : 'Files never leave your device' }}</div>
            </div>
        </div>
    </div>

    {{-- Mode Navigation Tabs --}}
    <div class="mb-8">
        <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none border-b border-gray-200">
            <button type="button" onclick="switchTab('merge')" id="tab-btn-merge"
                    class="tab-btn active inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition-all whitespace-nowrap">
                <i class="fa-solid fa-object-group text-sm"></i>
                <span>{{ $isBn ? 'Merge PDF (একত্রীকরণ)' : 'Merge PDF' }}</span>
            </button>

            <button type="button" onclick="switchTab('split')" id="tab-btn-split"
                    class="tab-btn inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition-all whitespace-nowrap">
                <i class="fa-solid fa-scissors text-sm"></i>
                <span>{{ $isBn ? 'Split / Extract Pages' : 'Split & Extract' }}</span>
            </button>

            <button type="button" onclick="switchTab('rotate')" id="tab-btn-rotate"
                    class="tab-btn inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition-all whitespace-nowrap">
                <i class="fa-solid fa-arrows-rotate text-sm"></i>
                <span>{{ $isBn ? 'Rotate & Delete Pages' : 'Rotate & Delete' }}</span>
            </button>

            <button type="button" onclick="switchTab('jpg-to-pdf')" id="tab-btn-jpg-to-pdf"
                    class="tab-btn inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition-all whitespace-nowrap">
                <i class="fa-solid fa-images text-sm"></i>
                <span>{{ $isBn ? 'JPG to PDF (ছবি থেকে PDF)' : 'JPG to PDF' }}</span>
            </button>

            <button type="button" onclick="switchTab('pdf-to-jpg')" id="tab-btn-pdf-to-jpg"
                    class="tab-btn inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition-all whitespace-nowrap">
                <i class="fa-solid fa-file-image text-sm"></i>
                <span>{{ $isBn ? 'PDF to JPG (পৃষ্ঠা ছবি করুন)' : 'PDF to JPG' }}</span>
            </button>
        </div>
    </div>

    {{-- Status Banner / Alerts --}}
    <div id="pdf-alert" class="hidden mb-6 p-4 rounded-xl text-xs sm:text-sm font-medium flex items-center justify-between gap-3">
        <div class="flex items-center gap-2.5">
            <i id="pdf-alert-icon" class="fa-solid fa-circle-info text-base"></i>
            <span id="pdf-alert-text"></span>
        </div>
        <button type="button" onclick="hideAlert()" class="opacity-70 hover:opacity-100 text-base">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════
         TAB 1: MERGE PDF
         ═══════════════════════════════════════════════════════════════════════ --}}
    <div id="tab-content-merge" class="tab-pane space-y-6">
        <div class="card p-6 sm:p-8 bg-white border border-gray-100 rounded-2xl shadow-sm">
            <div class="max-w-3xl mx-auto">
                {{-- Dropzone --}}
                <div id="merge-dropzone" class="border-2 border-dashed border-gray-300 hover:border-rose-400 bg-gray-50/70 hover:bg-rose-50/30 rounded-2xl p-8 sm:p-10 text-center transition-all cursor-pointer">
                    <input type="file" id="merge-file-input" accept="application/pdf" multiple class="hidden">
                    <div class="w-16 h-16 bg-rose-100 text-rose-600 rounded-2xl mx-auto flex items-center justify-center mb-4 text-2xl shadow-inner">
                        <i class="fa-solid fa-file-circle-plus"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-1">
                        {{ $isBn ? 'একাধিক PDF ফাইল নির্বাচন করুন বা এখানে ড্রপ করুন' : 'Select multiple PDF files or drag & drop here' }}
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-500 mb-4">
                        {{ $isBn ? '২ বা ততোধিক PDF ফাইল যোগ করে একটি ফাইলে মার্জ করুন।' : 'Combine 2 or more PDF files into a single document.' }}
                    </p>
                    <button type="button" onclick="document.getElementById('merge-file-input').click()" class="btn-primary text-xs sm:text-sm px-5 py-2.5 inline-flex items-center gap-2">
                        <i class="fa-solid fa-folder-open"></i>
                        <span>{{ $isBn ? 'PDF ফাইল সিলেক্ট করুন' : 'Choose PDF Files' }}</span>
                    </button>
                </div>

                {{-- Selected Files List --}}
                <div id="merge-list-container" class="mt-6 hidden">
                    <div class="flex items-center justify-between mb-3 px-1">
                        <h4 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                            <span>{{ $isBn ? 'নির্বাচিত ফাইলসমূহ' : 'Selected Files' }}</span>
                            <span id="merge-count-badge" class="bg-gray-100 text-gray-700 text-xs px-2 py-0.5 rounded-full font-bold">0</span>
                        </h4>
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="document.getElementById('merge-file-input').click()" class="text-xs font-semibold text-rose-600 hover:text-rose-700 inline-flex items-center gap-1">
                                <i class="fa-solid fa-plus"></i>
                                <span>{{ $isBn ? 'আরও ফাইল যোগ করুন' : 'Add More' }}</span>
                            </button>
                            <span class="text-gray-300">|</span>
                            <button type="button" onclick="clearMergeList()" class="text-xs font-semibold text-gray-400 hover:text-red-500">
                                {{ $isBn ? 'মুছে ফেলুন' : 'Clear All' }}
                            </button>
                        </div>
                    </div>

                    <div id="merge-files-list" class="space-y-2.5">
                        {{-- Items injected dynamically via JS --}}
                    </div>

                    {{-- Actions Row --}}
                    <div class="mt-6 pt-5 border-t border-gray-100 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
                        <div class="flex-1 max-w-sm">
                            <label class="block text-xs font-semibold text-gray-600 mb-1">
                                {{ $isBn ? 'আউটপুট ফাইলের নাম:' : 'Output File Name:' }}
                            </label>
                            <input type="text" id="merge-output-name" value="Merged_Document.pdf"
                                   class="w-full text-xs sm:text-sm px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-rose-500 focus:bg-white">
                        </div>

                        <button type="button" id="btn-merge-action" onclick="runMergePDF()"
                                class="btn-primary text-sm px-7 py-3 inline-flex items-center justify-center gap-2 shadow-lg shadow-rose-500/20 bg-rose-600 hover:bg-rose-700">
                            <i class="fa-solid fa-object-group" id="merge-btn-icon"></i>
                            <span id="merge-btn-text">{{ $isBn ? 'মার্জ করে ডাউনলোড করুন' : 'Merge & Download PDF' }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════
         TAB 2: SPLIT & EXTRACT
         ═══════════════════════════════════════════════════════════════════════ --}}
    <div id="tab-content-split" class="tab-pane hidden space-y-6">
        <div class="card p-6 sm:p-8 bg-white border border-gray-100 rounded-2xl shadow-sm">
            <div class="max-w-4xl mx-auto">
                {{-- Dropzone --}}
                <div id="split-dropzone" class="border-2 border-dashed border-gray-300 hover:border-blue-400 bg-gray-50/70 hover:bg-blue-50/30 rounded-2xl p-8 sm:p-10 text-center transition-all cursor-pointer">
                    <input type="file" id="split-file-input" accept="application/pdf" class="hidden">
                    <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl mx-auto flex items-center justify-center mb-4 text-2xl shadow-inner">
                        <i class="fa-solid fa-scissors"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-1">
                        {{ $isBn ? 'যে PDF ফাইলটি স্প্লিট করবেন তা নির্বাচন করুন' : 'Select a PDF to split or extract pages' }}
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-500 mb-4">
                        {{ $isBn ? 'নির্দিষ্ট পৃষ্ঠাগুলো আলাদা করুন অথবা সব পৃষ্ঠা আলাদা ফাইলে সংরক্ষণ করুন।' : 'Extract custom page ranges or split each page into a separate file.' }}
                    </p>
                    <button type="button" onclick="document.getElementById('split-file-input').click()" class="btn-primary text-xs sm:text-sm px-5 py-2.5 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700">
                        <i class="fa-solid fa-file-pdf"></i>
                        <span>{{ $isBn ? 'PDF নির্বাচন করুন' : 'Select PDF File' }}</span>
                    </button>
                </div>

                {{-- Split Options & Visual Page Grid --}}
                <div id="split-details-container" class="mt-6 hidden">
                    <div class="p-4 bg-blue-50/60 rounded-xl border border-blue-100 flex items-center justify-between flex-wrap gap-3 mb-6">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-file-lines text-blue-600 text-2xl"></i>
                            <div>
                                <h4 id="split-doc-name" class="font-bold text-sm text-gray-900">Document.pdf</h4>
                                <p id="split-doc-meta" class="text-xs text-gray-500">Total 0 Pages</p>
                            </div>
                        </div>
                        <button type="button" onclick="resetSplitDoc()" class="text-xs text-red-500 hover:text-red-700 font-semibold">
                            <i class="fa-solid fa-rotate-left mr-1"></i>{{ $isBn ? 'অন্য ফাইল নির্বাচন' : 'Change File' }}
                        </button>
                    </div>

                    {{-- Mode Switch: Extract Range vs Individual Pages --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <label class="p-4 rounded-xl border border-gray-200 cursor-pointer flex items-start gap-3 bg-white hover:border-blue-500 transition-all has-checked:border-blue-600 has-checked:bg-blue-50/20">
                            <input type="radio" name="split-mode" value="extract" checked onchange="toggleSplitMode(this.value)" class="mt-1 text-blue-600 focus:ring-blue-500">
                            <div>
                                <div class="font-bold text-sm text-gray-900">{{ $isBn ? 'নির্দিষ্ট পৃষ্ঠা এক্সট্র্যাক্ট করুন' : 'Extract Specific Pages' }}</div>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $isBn ? 'পছন্দের পৃষ্ঠাগুলো সিলেক্ট করুন বা রেঞ্জ লিখুন (যেমন: 1-3, 5)।' : 'Select pages below or type page ranges (e.g. 1-3, 5).' }}</p>
                            </div>
                        </label>

                        <label class="p-4 rounded-xl border border-gray-200 cursor-pointer flex items-start gap-3 bg-white hover:border-blue-500 transition-all has-checked:border-blue-600 has-checked:bg-blue-50/20">
                            <input type="radio" name="split-mode" value="separate" onchange="toggleSplitMode(this.value)" class="mt-1 text-blue-600 focus:ring-blue-500">
                            <div>
                                <div class="font-bold text-sm text-gray-900">{{ $isBn ? 'প্রতিটি পৃষ্ঠা আলাদা ফাইলে ভাগ করুন' : 'Split Every Page Separately' }}</div>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $isBn ? 'সবগুলো পৃষ্ঠা একক PDF ফাইলে রূপান্তরিত হয়ে ZIP হিসেবে ডাউনলোড হবে।' : 'Every page becomes a standalone PDF, downloaded in a ZIP.' }}</p>
                            </div>
                        </label>
                    </div>

                    {{-- Range Input Box --}}
                    <div id="split-range-box" class="mb-6 p-4 bg-gray-50 rounded-xl border border-gray-200 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                        <div class="flex-1">
                            <label class="block text-xs font-bold text-gray-700 mb-1">
                                {{ $isBn ? 'পৃষ্ঠা রেঞ্জ লিখুন (যেমন: 1-3, 5, 8):' : 'Page Range (e.g. 1-3, 5, 8):' }}
                            </label>
                            <input type="text" id="split-range-input" oninput="applyRangeInput(this.value)" placeholder="e.g. 1-3, 5"
                                   class="w-full text-xs sm:text-sm px-3.5 py-2 bg-white border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div class="flex items-center gap-2 self-end sm:self-center">
                            <button type="button" onclick="selectAllSplitPages(true)" class="btn-secondary text-xs px-3 py-2">
                                {{ $isBn ? 'সব সিলেক্ট' : 'Select All' }}
                            </button>
                            <button type="button" onclick="selectAllSplitPages(false)" class="btn-secondary text-xs px-3 py-2">
                                {{ $isBn ? 'ক্লিয়ার' : 'Deselect All' }}
                            </button>
                        </div>
                    </div>

                    {{-- Visual Thumbnails Grid --}}
                    <div class="mb-6">
                        <h5 class="text-xs font-bold text-gray-600 uppercase tracking-wider mb-3">
                            {{ $isBn ? 'পৃষ্ঠা নির্বাচন করুন (ক্লিক করে সিলেক্ট/আনসিলেক্ট করুন):' : 'Click pages to toggle selection:' }}
                        </h5>
                        <div id="split-pages-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 max-h-[50vh] overflow-y-auto p-1 custom-scrollbar">
                            {{-- Thumbnails rendered via pdf.js --}}
                        </div>
                    </div>

                    {{-- Action Button --}}
                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <button type="button" id="btn-split-action" onclick="runSplitPDF()"
                                class="btn-primary text-sm px-7 py-3 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-500/20">
                            <i class="fa-solid fa-scissors" id="split-btn-icon"></i>
                            <span id="split-btn-text">{{ $isBn ? 'স্প্লিট করে ডাউনলোড করুন' : 'Split & Download' }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════
         TAB 3: ROTATE & DELETE PAGES
         ═══════════════════════════════════════════════════════════════════════ --}}
    <div id="tab-content-rotate" class="tab-pane hidden space-y-6">
        <div class="card p-6 sm:p-8 bg-white border border-gray-100 rounded-2xl shadow-sm">
            <div class="max-w-4xl mx-auto">
                {{-- Dropzone --}}
                <div id="rotate-dropzone" class="border-2 border-dashed border-gray-300 hover:border-violet-400 bg-gray-50/70 hover:bg-violet-50/30 rounded-2xl p-8 sm:p-10 text-center transition-all cursor-pointer">
                    <input type="file" id="rotate-file-input" accept="application/pdf" class="hidden">
                    <div class="w-16 h-16 bg-violet-100 text-violet-600 rounded-2xl mx-auto flex items-center justify-center mb-4 text-2xl shadow-inner">
                        <i class="fa-solid fa-arrows-rotate"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-1">
                        {{ $isBn ? 'PDF আপলোড করে পৃষ্ঠা ঘুরান বা অপ্রয়োজনীয় পেজ ডিলিট করুন' : 'Upload PDF to rotate or delete pages' }}
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-500 mb-4">
                        {{ $isBn ? 'যেকোনো পৃষ্ঠা ৯০°, ১৮০° বা ২৭০° ঘুরিয়ে সোজা করুন অথবা অপ্রয়োজনীয় পৃষ্ঠা বাদ দিন।' : 'Rotate pages 90°, 180°, or delete unwanted pages with real-time visual preview.' }}
                    </p>
                    <button type="button" onclick="document.getElementById('rotate-file-input').click()" class="btn-primary text-xs sm:text-sm px-5 py-2.5 inline-flex items-center gap-2 bg-violet-600 hover:bg-violet-700">
                        <i class="fa-solid fa-file-pdf"></i>
                        <span>{{ $isBn ? 'PDF নির্বাচন করুন' : 'Select PDF File' }}</span>
                    </button>
                </div>

                {{-- Rotate Grid & Controls --}}
                <div id="rotate-details-container" class="mt-6 hidden">
                    <div class="p-4 bg-violet-50/60 rounded-xl border border-violet-100 flex items-center justify-between flex-wrap gap-3 mb-6">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-file-pdf text-violet-600 text-2xl"></i>
                            <div>
                                <h4 id="rotate-doc-name" class="font-bold text-sm text-gray-900">Document.pdf</h4>
                                <p id="rotate-doc-meta" class="text-xs text-gray-500">0 Pages</p>
                            </div>
                        </div>

                        {{-- Bulk Toolbar --}}
                        <div class="flex items-center gap-2 flex-wrap">
                            <button type="button" onclick="rotateAllPages(90)" class="btn-secondary text-xs px-3 py-1.5 inline-flex items-center gap-1.5">
                                <i class="fa-solid fa-rotate-right text-violet-600"></i>
                                <span>{{ $isBn ? 'সব ৯০° ডানে' : 'Rotate All 90°' }}</span>
                            </button>
                            <button type="button" onclick="rotateAllPages(180)" class="btn-secondary text-xs px-3 py-1.5 inline-flex items-center gap-1.5">
                                <i class="fa-solid fa-arrows-spin text-violet-600"></i>
                                <span>{{ $isBn ? 'সব ১৮০°' : 'Rotate All 180°' }}</span>
                            </button>
                            <button type="button" onclick="resetAllRotations()" class="btn-secondary text-xs px-3 py-1.5 text-gray-600 hover:text-red-600">
                                <i class="fa-solid fa-arrow-rotate-left"></i>
                                <span>{{ $isBn ? 'রিসেট' : 'Reset' }}</span>
                            </button>
                        </div>
                    </div>

                    {{-- Interactive Page Thumbnails --}}
                    <div class="mb-6">
                        <div id="rotate-pages-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 max-h-[55vh] overflow-y-auto p-1 custom-scrollbar">
                            {{-- Interactive cards injected here --}}
                        </div>
                    </div>

                    {{-- Save Action --}}
                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <button type="button" id="btn-rotate-action" onclick="runSaveRotatedPDF()"
                                class="btn-primary text-sm px-7 py-3 inline-flex items-center gap-2 bg-violet-600 hover:bg-violet-700 shadow-lg shadow-violet-500/20">
                            <i class="fa-solid fa-floppy-disk" id="rotate-btn-icon"></i>
                            <span id="rotate-btn-text">{{ $isBn ? 'সেভ করে ডাউনলোড করুন' : 'Save & Download PDF' }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════
         TAB 4: JPG TO PDF
         ═══════════════════════════════════════════════════════════════════════ --}}
    <div id="tab-content-jpg-to-pdf" class="tab-pane hidden space-y-6">
        <div class="card p-6 sm:p-8 bg-white border border-gray-100 rounded-2xl shadow-sm">
            <div class="max-w-4xl mx-auto">
                {{-- Dropzone --}}
                <div id="img2pdf-dropzone" class="border-2 border-dashed border-gray-300 hover:border-emerald-400 bg-gray-50/70 hover:bg-emerald-50/30 rounded-2xl p-8 sm:p-10 text-center transition-all cursor-pointer">
                    <input type="file" id="img2pdf-file-input" accept="image/jpeg,image/png,image/webp" multiple class="hidden">
                    <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-2xl mx-auto flex items-center justify-center mb-4 text-2xl shadow-inner">
                        <i class="fa-solid fa-images"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-1">
                        {{ $isBn ? 'ছবি নির্বাচন করুন (JPG, PNG, WebP)' : 'Select images to convert to PDF' }}
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-500 mb-4">
                        {{ $isBn ? 'এক বা একাধিক ছবি একসাথে যুক্ত করে সুন্দর A4 PDF ফাইল তৈরি করুন।' : 'Convert single or multiple images into a clean, printable PDF document.' }}
                    </p>
                    <button type="button" onclick="document.getElementById('img2pdf-file-input').click()" class="btn-primary text-xs sm:text-sm px-5 py-2.5 inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700">
                        <i class="fa-solid fa-folder-open"></i>
                        <span>{{ $isBn ? 'ছবি সিলেক্ট করুন' : 'Choose Images' }}</span>
                    </button>
                </div>

                {{-- Settings & Image Gallery --}}
                <div id="img2pdf-details-container" class="mt-6 hidden">
                    {{-- Controls Bar --}}
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 grid grid-cols-1 sm:grid-cols-3 gap-3 mb-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isBn ? 'পেজ ওরিয়েন্টেশন:' : 'Page Orientation:' }}</label>
                            <select id="img2pdf-orientation" class="w-full text-xs px-3 py-2 bg-white border border-gray-300 rounded-lg">
                                <option value="portrait">{{ $isBn ? 'Portrait (লম্বালম্বি)' : 'Portrait' }}</option>
                                <option value="landscape">{{ $isBn ? 'Landscape (আড়াআড়ি)' : 'Landscape' }}</option>
                                <option value="auto">{{ $isBn ? 'Auto (ছবির মাপ অনুযায়ী)' : 'Auto Fit' }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isBn ? 'মার্জিন:' : 'Margins:' }}</label>
                            <select id="img2pdf-margin" class="w-full text-xs px-3 py-2 bg-white border border-gray-300 rounded-lg">
                                <option value="none">{{ $isBn ? 'কোনো মার্জিন নেই (Full Page)' : 'No Margin (Full Page)' }}</option>
                                <option value="small" selected>{{ $isBn ? 'ছোট মার্জিন (10mm)' : 'Small Margin (10mm)' }}</option>
                                <option value="normal">{{ $isBn ? 'স্ট্যান্ডার্ড মার্জিন (20mm)' : 'Standard Margin (20mm)' }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isBn ? 'আউটপুট ফাইলের নাম:' : 'File Name:' }}</label>
                            <input type="text" id="img2pdf-filename" value="Images_Document.pdf"
                                   class="w-full text-xs px-3 py-2 bg-white border border-gray-300 rounded-lg">
                        </div>
                    </div>

                    {{-- Image Thumbnails Grid with Reorder/Delete --}}
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-3">
                            <h5 class="text-xs font-bold text-gray-600 uppercase tracking-wider">
                                {{ $isBn ? 'নির্বাচিত ছবিসমূহ (ক্রম পরিবর্তন করতে ডানে-বামে বাটন ব্যবহার করুন):' : 'Selected Images (Reorder or Remove):' }}
                            </h5>
                            <button type="button" onclick="document.getElementById('img2pdf-file-input').click()" class="text-xs text-emerald-600 font-semibold hover:underline">
                                <i class="fa-solid fa-plus mr-1"></i>{{ $isBn ? 'আরও ছবি যোগ করুন' : 'Add More' }}
                            </button>
                        </div>
                        <div id="img2pdf-preview-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 max-h-[50vh] overflow-y-auto p-1 custom-scrollbar">
                            {{-- Image cards injected here --}}
                        </div>
                    </div>

                    {{-- Action Button --}}
                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <button type="button" id="btn-img2pdf-action" onclick="runConvertImagesToPDF()"
                                class="btn-primary text-sm px-7 py-3 inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-500/20">
                            <i class="fa-solid fa-file-pdf" id="img2pdf-btn-icon"></i>
                            <span id="img2pdf-btn-text">{{ $isBn ? 'PDF তৈরি ও ডাউনলোড করুন' : 'Create & Download PDF' }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════
         TAB 5: PDF TO JPG
         ═══════════════════════════════════════════════════════════════════════ --}}
    <div id="tab-content-pdf-to-jpg" class="tab-pane hidden space-y-6">
        <div class="card p-6 sm:p-8 bg-white border border-gray-100 rounded-2xl shadow-sm">
            <div class="max-w-4xl mx-auto">
                {{-- Dropzone --}}
                <div id="pdf2img-dropzone" class="border-2 border-dashed border-gray-300 hover:border-amber-400 bg-gray-50/70 hover:bg-amber-50/30 rounded-2xl p-8 sm:p-10 text-center transition-all cursor-pointer">
                    <input type="file" id="pdf2img-file-input" accept="application/pdf" class="hidden">
                    <div class="w-16 h-16 bg-amber-100 text-amber-600 rounded-2xl mx-auto flex items-center justify-center mb-4 text-2xl shadow-inner">
                        <i class="fa-solid fa-file-image"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-1">
                        {{ $isBn ? 'PDF ফাইল নির্বাচন করুন' : 'Select PDF to convert to images' }}
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-500 mb-4">
                        {{ $isBn ? 'PDF-এর প্রতিটা পৃষ্ঠা হাই-কোয়ালিটি JPG/PNG ছবিতে রূপান্তর করে ডাউনলোড করুন।' : 'Convert every page of your PDF into high-resolution JPG or PNG images.' }}
                    </p>
                    <button type="button" onclick="document.getElementById('pdf2img-file-input').click()" class="btn-primary text-xs sm:text-sm px-5 py-2.5 inline-flex items-center gap-2 bg-amber-600 hover:bg-amber-700">
                        <i class="fa-solid fa-file-pdf"></i>
                        <span>{{ $isBn ? 'PDF ফাইল বাছাই করুন' : 'Choose PDF File' }}</span>
                    </button>
                </div>

                {{-- Converted Images Gallery --}}
                <div id="pdf2img-details-container" class="mt-6 hidden">
                    <div class="p-4 bg-amber-50/60 rounded-xl border border-amber-100 flex items-center justify-between flex-wrap gap-3 mb-6">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-images text-amber-600 text-2xl"></i>
                            <div>
                                <h4 id="pdf2img-doc-name" class="font-bold text-sm text-gray-900">Document.pdf</h4>
                                <p id="pdf2img-doc-meta" class="text-xs text-gray-500">Converting pages...</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <button type="button" id="btn-download-all-zip" onclick="downloadAllImagesZip()"
                                    class="btn-primary text-xs px-4 py-2 bg-amber-600 hover:bg-amber-700 inline-flex items-center gap-1.5 shadow-sm">
                                <i class="fa-solid fa-file-zipper"></i>
                                <span>{{ $isBn ? 'সব ছবি ZIP হিসেবে ডাউনলোড' : 'Download All as ZIP' }}</span>
                            </button>
                        </div>
                    </div>

                    {{-- Image Cards Grid --}}
                    <div id="pdf2img-results-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 max-h-[60vh] overflow-y-auto p-1 custom-scrollbar">
                        {{-- Rendered page canvases / image downloads --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════
         Informative Note on Office Word/Excel Conversions
         ═══════════════════════════════════════════════════════════════════════ --}}
    <div class="mt-12 bg-white rounded-2xl border border-gray-100 p-6 shadow-xs">
        <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                <i class="fa-solid fa-circle-question text-lg"></i>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 text-sm mb-1">
                    {{ $isBn ? 'PDF to Word ও Excel সংক্রান্ত গুরুত্বপূর্ণ তথ্য' : 'Important Note: PDF to Word & Excel Conversion' }}
                </h4>
                <p class="text-xs text-gray-500 leading-relaxed">
                    {{ $isBn
                        ? 'DOCX এবং Excel ফাইল অত্যন্ত জটিল মাইক্রোসফট XML বাইনারি ফরম্যাট। টেক্সট ও টেবিলের নিখুঁত লেআউট বজায় রেখে ব্রাউজার-সাইডে শতভাগ নির্ভুল Word/Excel রূপান্তর করা নিরাপদ নয় এবং এর জন্য ভারী সার্ভার প্রসেসিং (LibreOffice / Microsoft API) প্রয়োজন হয়। ব্যবহারকারীর ব্যক্তিগত ডকুমেন্টের নিরাপত্তা বজায় রাখতে আমরা ফাইল সার্ভারে আপলোড না করে আপনার ডিভাইসের ব্রাউজারেই সরাসরি ১০০% প্রাইভেট পিডিএফ টুলস প্রদান করছি।'
                        : 'DOCX and Excel files are complex Microsoft XML formats requiring server-side conversion binaries to preserve precise font and table layouts. To protect user privacy and avoid uploading confidential documents to remote servers, Quickkaj operates all PDF merging, splitting, page rotations, and JPG conversions 100% locally on your device.'
                    }}
                </p>
            </div>
        </div>
    </div>

    @include('partials.tool-ad')
</div>

<style>
.tab-btn {
    color: #475569;
    background: transparent;
    border: 1px solid transparent;
}
.tab-btn:hover {
    color: #0f172a;
    background: #f1f5f9;
}
.tab-btn.active {
    color: #e11d48;
    background: #fff1f2;
    border-color: #fecdd3;
    box-shadow: 0 1px 2px rgba(225, 29, 72, 0.08);
}
.custom-scrollbar::-webkit-scrollbar { width: 6px; }
.custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 999px; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 999px; }
</style>

@push('scripts')
{{-- Modern CDN scripts for PDF-Lib, PDF.js, and JSZip --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<script>
// Configure pdf.js worker
if (typeof pdfjsLib !== 'undefined') {
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
}

const IS_BN = {{ $isBn ? 'true' : 'false' }};

// State variables
let activeTab = 'merge';
let mergeFiles = []; // array of { file, name, size, pageCount, bytes }
let splitDocData = null; // { file, name, bytes, pdfLibDoc, pageCount, selectedPages: Set }
let rotateDocData = null; // { file, name, bytes, pdfLibDoc, pageCount, pageRotations: [], excludedPages: Set }
let img2pdfFiles = []; // array of { file, name, dataUrl }
let pdf2imgData = null; // { file, name, images: [{ pageNum, dataUrl, width, height }] }

function showAlert(msg, type = 'info') {
    const el = document.getElementById('pdf-alert');
    const text = document.getElementById('pdf-alert-text');
    const icon = document.getElementById('pdf-alert-icon');
    if (!el || !text) return;

    text.textContent = msg;
    el.classList.remove('hidden', 'bg-red-50', 'text-red-800', 'border-red-200', 'bg-emerald-50', 'text-emerald-800', 'border-emerald-200', 'bg-blue-50', 'text-blue-800', 'border-blue-200');

    if (type === 'error') {
        el.classList.add('bg-red-50', 'text-red-800', 'border', 'border-red-200');
        icon.className = 'fa-solid fa-triangle-exclamation text-red-600 text-base';
    } else if (type === 'success') {
        el.classList.add('bg-emerald-50', 'text-emerald-800', 'border', 'border-emerald-200');
        icon.className = 'fa-solid fa-circle-check text-emerald-600 text-base';
    } else {
        el.classList.add('bg-blue-50', 'text-blue-800', 'border', 'border-blue-200');
        icon.className = 'fa-solid fa-circle-info text-blue-600 text-base';
    }
}
function hideAlert() {
    document.getElementById('pdf-alert')?.classList.add('hidden');
}

// ─────────────────────────────────────────────────────────────────────────────
// TAB SWITCHING
// ─────────────────────────────────────────────────────────────────────────────
function switchTab(tabId) {
    activeTab = tabId;
    hideAlert();

    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-pane').forEach(p => p.classList.add('hidden'));

    const btn = document.getElementById('tab-btn-' + tabId);
    const pane = document.getElementById('tab-content-' + tabId);
    if (btn) btn.classList.add('active');
    if (pane) pane.classList.remove('hidden');

    if (history.replaceState) {
        history.replaceState(null, null, '#' + tabId);
    }
}

// Check initial hash on load
window.addEventListener('DOMContentLoaded', () => {
    const hash = window.location.hash.replace('#', '');
    if (['merge', 'split', 'rotate', 'jpg-to-pdf', 'pdf-to-jpg'].includes(hash)) {
        switchTab(hash);
    }
});

// Helper for download
function triggerDownload(blob, filename) {
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    document.body.appendChild(a);
    a.click();
    setTimeout(() => {
        URL.revokeObjectURL(url);
        a.remove();
    }, 1000);
}

function formatBytes(bytes) {
    if (!bytes || bytes === 0) return '0 B';
    const k = 1024, dm = 1;
    const sizes = ['B', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}

// ─────────────────────────────────────────────────────────────────────────────
// TAB 1: MERGE PDF
// ─────────────────────────────────────────────────────────────────────────────
const mergeInput = document.getElementById('merge-file-input');
const mergeDropzone = document.getElementById('merge-dropzone');

mergeInput?.addEventListener('change', (e) => handleMergeFiles(e.target.files));
mergeDropzone?.addEventListener('dragover', (e) => { e.preventDefault(); mergeDropzone.classList.add('border-rose-500'); });
mergeDropzone?.addEventListener('dragleave', () => mergeDropzone.classList.remove('border-rose-500'));
mergeDropzone?.addEventListener('drop', (e) => {
    e.preventDefault();
    mergeDropzone.classList.remove('border-rose-500');
    if (e.dataTransfer.files) handleMergeFiles(e.dataTransfer.files);
});

async function handleMergeFiles(files) {
    if (!files || !files.length) return;
    hideAlert();

    for (const f of Array.from(files)) {
        if (f.type !== 'application/pdf' && !f.name.toLowerCase().endsWith('.pdf')) {
            showAlert(IS_BN ? 'শুধুমাত্র PDF ফাইল আপলোড করুন।' : 'Only PDF files are supported.', 'error');
            continue;
        }

        try {
            const buf = await f.arrayBuffer();
            let pageCount = 1;
            if (typeof PDFLib !== 'undefined') {
                const doc = await PDFLib.PDFDocument.load(buf, { ignoreEncryption: true });
                pageCount = doc.getPageCount();
            }
            mergeFiles.push({
                file: f,
                name: f.name,
                size: f.size,
                pageCount: pageCount,
                bytes: buf
            });
        } catch (err) {
            console.error('Error reading PDF:', err);
            showAlert((IS_BN ? 'ফাইল পড়তে সমস্যা হয়েছে: ' : 'Failed to read PDF: ') + f.name, 'error');
        }
    }

    renderMergeList();
    mergeInput.value = '';
}

function renderMergeList() {
    const container = document.getElementById('merge-list-container');
    const list = document.getElementById('merge-files-list');
    const badge = document.getElementById('merge-count-badge');
    if (!container || !list) return;

    if (mergeFiles.length === 0) {
        container.classList.add('hidden');
        return;
    }

    container.classList.remove('hidden');
    badge.textContent = mergeFiles.length;
    list.innerHTML = '';

    mergeFiles.forEach((item, idx) => {
        const row = document.createElement('div');
        row.className = 'p-3 bg-white border border-gray-200 rounded-xl flex items-center justify-between gap-3 shadow-2xs hover:border-rose-300 transition-colors';
        row.innerHTML = `
            <div class="flex items-center gap-3 min-w-0">
                <span class="w-6 h-6 rounded-full bg-rose-50 text-rose-700 text-xs font-extrabold flex items-center justify-center shrink-0">
                    ${idx + 1}
                </span>
                <i class="fa-solid fa-file-pdf text-rose-500 text-lg shrink-0"></i>
                <div class="min-w-0">
                    <div class="text-xs sm:text-sm font-bold text-gray-900 truncate" title="${item.name}">${item.name}</div>
                    <div class="text-[11px] text-gray-400 flex items-center gap-2">
                        <span>${item.pageCount} ${IS_BN ? 'টি পৃষ্ঠা' : 'Pages'}</span>
                        <span>•</span>
                        <span>${formatBytes(item.size)}</span>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-1 shrink-0">
                <button type="button" onclick="moveMergeItem(${idx}, -1)" ${idx === 0 ? 'disabled' : ''} class="w-7 h-7 rounded-lg hover:bg-gray-100 text-gray-500 disabled:opacity-30 disabled:pointer-events-none flex items-center justify-center text-xs" title="Move Up">
                    <i class="fa-solid fa-arrow-up"></i>
                </button>
                <button type="button" onclick="moveMergeItem(${idx}, 1)" ${idx === mergeFiles.length - 1 ? 'disabled' : ''} class="w-7 h-7 rounded-lg hover:bg-gray-100 text-gray-500 disabled:opacity-30 disabled:pointer-events-none flex items-center justify-center text-xs" title="Move Down">
                    <i class="fa-solid fa-arrow-down"></i>
                </button>
                <button type="button" onclick="removeMergeItem(${idx})" class="w-7 h-7 rounded-lg hover:bg-red-50 text-red-500 flex items-center justify-center text-xs ml-1" title="Delete">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </div>
        `;
        list.appendChild(row);
    });
}

function moveMergeItem(idx, dir) {
    const target = idx + dir;
    if (target < 0 || target >= mergeFiles.length) return;
    const temp = mergeFiles[idx];
    mergeFiles[idx] = mergeFiles[target];
    mergeFiles[target] = temp;
    renderMergeList();
}

function removeMergeItem(idx) {
    mergeFiles.splice(idx, 1);
    renderMergeList();
}

function clearMergeList() {
    mergeFiles = [];
    renderMergeList();
}

async function runMergePDF() {
    if (mergeFiles.length < 2) {
        showAlert(IS_BN ? 'মার্জ করার জন্য কমপক্ষে ২টি PDF ফাইল যোগ করুন।' : 'Please add at least 2 PDF files to merge.', 'error');
        return;
    }

    const btn = document.getElementById('btn-merge-action');
    const icon = document.getElementById('merge-btn-icon');
    const text = document.getElementById('merge-btn-text');
    const origText = text.textContent;

    btn.disabled = true;
    text.textContent = IS_BN ? 'মার্জ করা হচ্ছে...' : 'Merging PDFs...';
    icon.className = 'fa-solid fa-spinner animate-spin';

    try {
        const mergedPdf = await PDFLib.PDFDocument.create();

        for (const item of mergeFiles) {
            const donorPdf = await PDFLib.PDFDocument.load(item.bytes, { ignoreEncryption: true });
            const pageIndices = donorPdf.getPageIndices();
            const copiedPages = await mergedPdf.copyPages(donorPdf, pageIndices);
            copiedPages.forEach(p => mergedPdf.addPage(p));
        }

        const mergedBytes = await mergedPdf.save();
        const blob = new Blob([mergedBytes], { type: 'application/pdf' });
        const outName = (document.getElementById('merge-output-name').value || 'Merged_Document.pdf').trim();
        triggerDownload(blob, outName.endsWith('.pdf') ? outName : outName + '.pdf');

        showAlert(IS_BN ? 'সফলভাবে মার্জ করে ডাউনলোড করা হয়েছে!' : 'PDF merged and downloaded successfully!', 'success');
    } catch (err) {
        console.error('Merge error:', err);
        showAlert((IS_BN ? 'মার্জ করতে সমস্যা হয়েছে: ' : 'Failed to merge PDFs: ') + err.message, 'error');
    } finally {
        btn.disabled = false;
        text.textContent = origText;
        icon.className = 'fa-solid fa-object-group';
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// TAB 2: SPLIT & EXTRACT
// ─────────────────────────────────────────────────────────────────────────────
const splitInput = document.getElementById('split-file-input');
const splitDropzone = document.getElementById('split-dropzone');

splitInput?.addEventListener('change', (e) => {
    if (e.target.files && e.target.files[0]) handleSplitDoc(e.target.files[0]);
});
splitDropzone?.addEventListener('dragover', (e) => { e.preventDefault(); splitDropzone.classList.add('border-blue-500'); });
splitDropzone?.addEventListener('dragleave', () => splitDropzone.classList.remove('border-blue-500'));
splitDropzone?.addEventListener('drop', (e) => {
    e.preventDefault();
    splitDropzone.classList.remove('border-blue-500');
    if (e.dataTransfer.files && e.dataTransfer.files[0]) handleSplitDoc(e.dataTransfer.files[0]);
});

async function handleSplitDoc(file) {
    if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf')) {
        showAlert(IS_BN ? 'শুধুমাত্র PDF ফাইল আপলোড করুন।' : 'Only PDF files are supported.', 'error');
        return;
    }

    hideAlert();
    try {
        const buf = await file.arrayBuffer();
        const pdfDoc = await PDFLib.PDFDocument.load(buf, { ignoreEncryption: true });
        const count = pdfDoc.getPageCount();

        splitDocData = {
            file: file,
            name: file.name,
            bytes: buf,
            pdfLibDoc: pdfDoc,
            pageCount: count,
            selectedPages: new Set(Array.from({ length: count }, (_, i) => i + 1)) // default select all
        };

        document.getElementById('split-dropzone').classList.add('hidden');
        document.getElementById('split-details-container').classList.remove('hidden');
        document.getElementById('split-doc-name').textContent = file.name;
        document.getElementById('split-doc-meta').textContent = `${count} ${IS_BN ? 'টি পৃষ্ঠা' : 'Pages'} • ${formatBytes(file.size)}`;

        renderSplitThumbnails();
    } catch (err) {
        console.error('Error loading split PDF:', err);
        showAlert(IS_BN ? 'PDF লোড করতে সমস্যা হয়েছে।' : 'Failed to load PDF.', 'error');
    }
}

function resetSplitDoc() {
    splitDocData = null;
    document.getElementById('split-details-container').classList.add('hidden');
    document.getElementById('split-dropzone').classList.remove('hidden');
    splitInput.value = '';
}

function toggleSplitMode(mode) {
    const rangeBox = document.getElementById('split-range-box');
    const grid = document.getElementById('split-pages-grid');
    if (mode === 'separate') {
        rangeBox.classList.add('opacity-40', 'pointer-events-none');
        grid.parentElement.classList.add('opacity-40', 'pointer-events-none');
        document.getElementById('split-btn-text').textContent = IS_BN ? 'প্রতিটি পৃষ্ঠা আলাদা করুন (ZIP)' : 'Split All Pages (ZIP)';
    } else {
        rangeBox.classList.remove('opacity-40', 'pointer-events-none');
        grid.parentElement.classList.remove('opacity-40', 'pointer-events-none');
        document.getElementById('split-btn-text').textContent = IS_BN ? 'স্প্লিট করে ডাউনলোড করুন' : 'Extract & Download PDF';
    }
}

async function renderSplitThumbnails() {
    const grid = document.getElementById('split-pages-grid');
    if (!grid || !splitDocData) return;
    grid.innerHTML = '<div class="col-span-full py-6 text-center text-xs text-gray-400"><i class="fa-solid fa-spinner animate-spin mr-2"></i>Rendering thumbnails...</div>';

    try {
        const loadingTask = pdfjsLib.getDocument({ data: splitDocData.bytes.slice(0) });
        const pdf = await loadingTask.promise;
        grid.innerHTML = '';

        for (let i = 1; i <= pdf.numPages; i++) {
            const page = await pdf.getPage(i);
            const viewport = page.getViewport({ scale: 0.35 });

            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            canvas.width = viewport.width;
            canvas.height = viewport.height;
            await page.render({ canvasContext: ctx, viewport: viewport }).promise;

            const card = document.createElement('div');
            card.id = `split-page-card-${i}`;
            const isSelected = splitDocData.selectedPages.has(i);
            card.className = `p-2 rounded-xl border-2 transition-all cursor-pointer flex flex-col items-center bg-white ${isSelected ? 'border-blue-600 bg-blue-50/20 shadow-xs' : 'border-gray-200 opacity-60'}`;
            card.onclick = () => toggleSplitPage(i);

            card.innerHTML = `
                <div class="w-full flex items-center justify-between mb-1.5 px-0.5">
                    <span class="text-[11px] font-bold text-gray-700">p. ${i}</span>
                    <input type="checkbox" ${isSelected ? 'checked' : ''} class="text-blue-600 rounded pointer-events-none" id="split-chk-${i}">
                </div>
                <div class="w-full bg-gray-50 border border-gray-100 rounded overflow-hidden flex items-center justify-center">
                    <img src="${canvas.toDataURL('image/jpeg', 0.8)}" class="w-full h-auto object-contain" alt="Page ${i}">
                </div>
            `;
            grid.appendChild(card);
        }
    } catch (err) {
        console.error('Thumbnail render error:', err);
    }
}

function toggleSplitPage(pageNo) {
    if (!splitDocData) return;
    if (splitDocData.selectedPages.has(pageNo)) {
        splitDocData.selectedPages.delete(pageNo);
    } else {
        splitDocData.selectedPages.add(pageNo);
    }

    const card = document.getElementById(`split-page-card-${pageNo}`);
    const chk = document.getElementById(`split-chk-${pageNo}`);
    const isSelected = splitDocData.selectedPages.has(pageNo);

    if (card) {
        card.className = `p-2 rounded-xl border-2 transition-all cursor-pointer flex flex-col items-center bg-white ${isSelected ? 'border-blue-600 bg-blue-50/20 shadow-xs' : 'border-gray-200 opacity-60'}`;
    }
    if (chk) chk.checked = isSelected;
}

function selectAllSplitPages(select) {
    if (!splitDocData) return;
    if (select) {
        splitDocData.selectedPages = new Set(Array.from({ length: splitDocData.pageCount }, (_, i) => i + 1));
    } else {
        splitDocData.selectedPages.clear();
    }
    for (let i = 1; i <= splitDocData.pageCount; i++) {
        const card = document.getElementById(`split-page-card-${i}`);
        const chk = document.getElementById(`split-chk-${i}`);
        if (card) card.className = `p-2 rounded-xl border-2 transition-all cursor-pointer flex flex-col items-center bg-white ${select ? 'border-blue-600 bg-blue-50/20 shadow-xs' : 'border-gray-200 opacity-60'}`;
        if (chk) chk.checked = select;
    }
}

function applyRangeInput(val) {
    if (!splitDocData || !val.trim()) return;
    const pages = new Set();
    const parts = val.split(',');
    parts.forEach(part => {
        const trimmed = part.trim();
        if (trimmed.includes('-')) {
            const [start, end] = trimmed.split('-').map(Number);
            if (!isNaN(start) && !isNaN(end)) {
                for (let p = Math.max(1, start); p <= Math.min(splitDocData.pageCount, end); p++) {
                    pages.add(p);
                }
            }
        } else {
            const p = Number(trimmed);
            if (!isNaN(p) && p >= 1 && p <= splitDocData.pageCount) {
                pages.add(p);
            }
        }
    });

    if (pages.size > 0) {
        splitDocData.selectedPages = pages;
        for (let i = 1; i <= splitDocData.pageCount; i++) {
            const card = document.getElementById(`split-page-card-${i}`);
            const chk = document.getElementById(`split-chk-${i}`);
            const isSelected = pages.has(i);
            if (card) card.className = `p-2 rounded-xl border-2 transition-all cursor-pointer flex flex-col items-center bg-white ${isSelected ? 'border-blue-600 bg-blue-50/20 shadow-xs' : 'border-gray-200 opacity-60'}`;
            if (chk) chk.checked = isSelected;
        }
    }
}

async function runSplitPDF() {
    if (!splitDocData) return;
    const mode = document.querySelector('input[name="split-mode"]:checked')?.value || 'extract';

    const btn = document.getElementById('btn-split-action');
    const icon = document.getElementById('split-btn-icon');
    const text = document.getElementById('split-btn-text');
    const origText = text.textContent;

    btn.disabled = true;
    text.textContent = IS_BN ? 'প্রসেসিং হচ্ছে...' : 'Processing...';
    icon.className = 'fa-solid fa-spinner animate-spin';

    try {
        if (mode === 'separate') {
            // Split into individual pages and package in ZIP
            const zip = new JSZip();
            const baseName = splitDocData.name.replace(/\.pdf$/i, '');

            for (let i = 0; i < splitDocData.pageCount; i++) {
                const singleDoc = await PDFLib.PDFDocument.create();
                const [copiedPage] = await singleDoc.copyPages(splitDocData.pdfLibDoc, [i]);
                singleDoc.addPage(copiedPage);
                const bytes = await singleDoc.save();
                zip.file(`${baseName}_Page_${i + 1}.pdf`, bytes);
            }

            const zipContent = await zip.generateAsync({ type: 'blob' });
            triggerDownload(zipContent, `${baseName}_All_Pages.zip`);
            showAlert(IS_BN ? 'সবগুলো পৃষ্ঠা ZIP হিসেবে ডাউনলোড হয়েছে!' : 'All pages split and downloaded as ZIP!', 'success');
        } else {
            // Extract selected pages into one new PDF
            const selectedArr = Array.from(splitDocData.selectedPages).sort((a, b) => a - b);
            if (selectedArr.length === 0) {
                showAlert(IS_BN ? 'অনুগ্রহ করে অন্তত ১টি পৃষ্ঠা সিলেক্ট করুন।' : 'Please select at least 1 page to extract.', 'error');
                return;
            }

            const newDoc = await PDFLib.PDFDocument.create();
            const indices = selectedArr.map(p => p - 1);
            const copiedPages = await newDoc.copyPages(splitDocData.pdfLibDoc, indices);
            copiedPages.forEach(p => newDoc.addPage(p));

            const bytes = await newDoc.save();
            const blob = new Blob([bytes], { type: 'application/pdf' });
            const baseName = splitDocData.name.replace(/\.pdf$/i, '');
            triggerDownload(blob, `${baseName}_Extracted.pdf`);
            showAlert(IS_BN ? 'নির্বাচিত পৃষ্ঠাগুলো সফলভাবে এক্সট্র্যাক্ট করা হয়েছে!' : 'Selected pages extracted successfully!', 'success');
        }
    } catch (err) {
        console.error('Split error:', err);
        showAlert((IS_BN ? 'স্প্লিট করতে সমস্যা হয়েছে: ' : 'Failed to split: ') + err.message, 'error');
    } finally {
        btn.disabled = false;
        text.textContent = origText;
        icon.className = 'fa-solid fa-scissors';
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// TAB 3: ROTATE & DELETE PAGES
// ─────────────────────────────────────────────────────────────────────────────
const rotateInput = document.getElementById('rotate-file-input');
const rotateDropzone = document.getElementById('rotate-dropzone');

rotateInput?.addEventListener('change', (e) => {
    if (e.target.files && e.target.files[0]) handleRotateDoc(e.target.files[0]);
});
rotateDropzone?.addEventListener('dragover', (e) => { e.preventDefault(); rotateDropzone.classList.add('border-violet-500'); });
rotateDropzone?.addEventListener('dragleave', () => rotateDropzone.classList.remove('border-violet-500'));
rotateDropzone?.addEventListener('drop', (e) => {
    e.preventDefault();
    rotateDropzone.classList.remove('border-violet-500');
    if (e.dataTransfer.files && e.dataTransfer.files[0]) handleRotateDoc(e.dataTransfer.files[0]);
});

async function handleRotateDoc(file) {
    if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf')) {
        showAlert(IS_BN ? 'শুধুমাত্র PDF ফাইল আপলোড করুন।' : 'Only PDF files are supported.', 'error');
        return;
    }

    hideAlert();
    try {
        const buf = await file.arrayBuffer();
        const pdfDoc = await PDFLib.PDFDocument.load(buf, { ignoreEncryption: true });
        const count = pdfDoc.getPageCount();

        rotateDocData = {
            file: file,
            name: file.name,
            bytes: buf,
            pdfLibDoc: pdfDoc,
            pageCount: count,
            pageRotations: new Array(count).fill(0), // rotation deltas (0, 90, 180, 270)
            excludedPages: new Set() // pages marked for deletion
        };

        document.getElementById('rotate-dropzone').classList.add('hidden');
        document.getElementById('rotate-details-container').classList.remove('hidden');
        document.getElementById('rotate-doc-name').textContent = file.name;
        document.getElementById('rotate-doc-meta').textContent = `${count} ${IS_BN ? 'টি পৃষ্ঠা' : 'Pages'} • ${formatBytes(file.size)}`;

        renderRotateThumbnails();
    } catch (err) {
        console.error('Rotate doc error:', err);
        showAlert(IS_BN ? 'PDF লোড করতে সমস্যা হয়েছে।' : 'Failed to load PDF.', 'error');
    }
}

async function renderRotateThumbnails() {
    const grid = document.getElementById('rotate-pages-grid');
    if (!grid || !rotateDocData) return;
    grid.innerHTML = '<div class="col-span-full py-6 text-center text-xs text-gray-400"><i class="fa-solid fa-spinner animate-spin mr-2"></i>Loading pages...</div>';

    try {
        const loadingTask = pdfjsLib.getDocument({ data: rotateDocData.bytes.slice(0) });
        const pdf = await loadingTask.promise;
        grid.innerHTML = '';

        for (let i = 1; i <= pdf.numPages; i++) {
            const page = await pdf.getPage(i);
            const viewport = page.getViewport({ scale: 0.35 });

            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            canvas.width = viewport.width;
            canvas.height = viewport.height;
            await page.render({ canvasContext: ctx, viewport: viewport }).promise;

            const card = document.createElement('div');
            card.id = `rotate-page-card-${i}`;
            card.className = 'p-3 rounded-2xl border border-gray-200 bg-white flex flex-col items-center justify-between gap-2 shadow-2xs hover:shadow-sm transition-all relative overflow-hidden';

            card.innerHTML = `
                <div class="w-full flex items-center justify-between text-xs">
                    <span class="font-bold text-gray-700">p. ${i}</span>
                    <button type="button" onclick="toggleExcludeRotatePage(${i})" id="btn-del-page-${i}"
                            class="w-6 h-6 rounded-md hover:bg-red-50 text-gray-400 hover:text-red-500 flex items-center justify-center transition-colors" title="Delete this page">
                        <i class="fa-solid fa-trash-can text-xs"></i>
                    </button>
                </div>
                <div class="w-full h-36 bg-gray-50 border border-gray-100 rounded-xl overflow-hidden flex items-center justify-center p-1">
                    <img id="rotate-img-${i}" src="${canvas.toDataURL('image/jpeg', 0.8)}"
                         style="transform: rotate(0deg); transition: transform 0.2s ease; max-height: 100%; object-fit: contain;" alt="Page ${i}">
                </div>
                <div class="flex items-center gap-1.5 w-full justify-center pt-1 border-t border-gray-100">
                    <button type="button" onclick="rotateSinglePage(${i}, -90)" class="w-8 h-7 rounded-lg bg-gray-100 hover:bg-violet-100 text-gray-600 hover:text-violet-700 flex items-center justify-center text-xs" title="Rotate -90°">
                        <i class="fa-solid fa-rotate-left"></i>
                    </button>
                    <span id="rotate-deg-label-${i}" class="text-[10px] font-bold text-gray-500 w-8 text-center">0°</span>
                    <button type="button" onclick="rotateSinglePage(${i}, 90)" class="w-8 h-7 rounded-lg bg-gray-100 hover:bg-violet-100 text-gray-600 hover:text-violet-700 flex items-center justify-center text-xs" title="Rotate +90°">
                        <i class="fa-solid fa-rotate-right"></i>
                    </button>
                </div>
                <div id="rotate-del-overlay-${i}" class="absolute inset-0 bg-red-900/60 text-white flex flex-col items-center justify-center gap-1 backdrop-blur-2xs hidden">
                    <i class="fa-solid fa-trash text-lg"></i>
                    <span class="text-[11px] font-bold uppercase tracking-wider">Deleted</span>
                    <button type="button" onclick="toggleExcludeRotatePage(${i})" class="text-[10px] underline hover:text-red-200 mt-1">Undo</button>
                </div>
            `;
            grid.appendChild(card);
        }
    } catch (err) {
        console.error('Render error:', err);
    }
}

function rotateSinglePage(pageNum, angleDelta) {
    if (!rotateDocData) return;
    const idx = pageNum - 1;
    rotateDocData.pageRotations[idx] = (rotateDocData.pageRotations[idx] + angleDelta + 360) % 360;

    const img = document.getElementById(`rotate-img-${pageNum}`);
    const label = document.getElementById(`rotate-deg-label-${pageNum}`);
    if (img) img.style.transform = `rotate(${rotateDocData.pageRotations[idx]}deg)`;
    if (label) label.textContent = `${rotateDocData.pageRotations[idx]}°`;
}

function rotateAllPages(angleDelta) {
    if (!rotateDocData) return;
    for (let i = 1; i <= rotateDocData.pageCount; i++) {
        rotateSinglePage(i, angleDelta);
    }
}

function resetAllRotations() {
    if (!rotateDocData) return;
    for (let i = 1; i <= rotateDocData.pageCount; i++) {
        rotateDocData.pageRotations[i - 1] = 0;
        const img = document.getElementById(`rotate-img-${i}`);
        const label = document.getElementById(`rotate-deg-label-${i}`);
        if (img) img.style.transform = 'rotate(0deg)';
        if (label) label.textContent = '0°';
    }
}

function toggleExcludeRotatePage(pageNum) {
    if (!rotateDocData) return;
    const overlay = document.getElementById(`rotate-del-overlay-${pageNum}`);
    if (rotateDocData.excludedPages.has(pageNum)) {
        rotateDocData.excludedPages.delete(pageNum);
        overlay?.classList.add('hidden');
    } else {
        rotateDocData.excludedPages.add(pageNum);
        overlay?.classList.remove('hidden');
    }
}

async function runSaveRotatedPDF() {
    if (!rotateDocData) return;

    const btn = document.getElementById('btn-rotate-action');
    const icon = document.getElementById('rotate-btn-icon');
    const text = document.getElementById('rotate-btn-text');
    const origText = text.textContent;

    btn.disabled = true;
    text.textContent = IS_BN ? 'সংরক্ষণ করা হচ্ছে...' : 'Saving PDF...';
    icon.className = 'fa-solid fa-spinner animate-spin';

    try {
        const newDoc = await PDFLib.PDFDocument.create();
        const pagesToKeep = [];

        for (let i = 1; i <= rotateDocData.pageCount; i++) {
            if (!rotateDocData.excludedPages.has(i)) {
                pagesToKeep.push(i - 1);
            }
        }

        if (pagesToKeep.length === 0) {
            showAlert(IS_BN ? 'সবগুলো পৃষ্ঠা মুছে ফেলা হয়েছে! অন্তত ১টি পৃষ্ঠা রাখুন।' : 'All pages are deleted! Please keep at least 1 page.', 'error');
            return;
        }

        const copiedPages = await newDoc.copyPages(rotateDocData.pdfLibDoc, pagesToKeep);

        copiedPages.forEach((page, index) => {
            const origPageNum = pagesToKeep[index] + 1;
            const extraRotation = rotateDocData.pageRotations[origPageNum - 1] || 0;
            const currentRotation = page.getRotation().angle;
            const finalAngle = (currentRotation + extraRotation + 360) % 360;
            page.setRotation(PDFLib.degrees(finalAngle));
            newDoc.addPage(page);
        });

        const bytes = await newDoc.save();
        const blob = new Blob([bytes], { type: 'application/pdf' });
        const baseName = rotateDocData.name.replace(/\.pdf$/i, '');
        triggerDownload(blob, `${baseName}_Organized.pdf`);

        showAlert(IS_BN ? 'ঘোরানো ও পেজ সাজানো PDF সফলভাবে ডাউনলোড হয়েছে!' : 'Rotated & organized PDF downloaded successfully!', 'success');
    } catch (err) {
        console.error('Save rotated error:', err);
        showAlert((IS_BN ? 'সেভ করতে সমস্যা হয়েছে: ' : 'Failed to save: ') + err.message, 'error');
    } finally {
        btn.disabled = false;
        text.textContent = origText;
        icon.className = 'fa-solid fa-floppy-disk';
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// TAB 4: JPG / IMAGES TO PDF
// ─────────────────────────────────────────────────────────────────────────────
const img2pdfInput = document.getElementById('img2pdf-file-input');
const img2pdfDropzone = document.getElementById('img2pdf-dropzone');

img2pdfInput?.addEventListener('change', (e) => handleImageFiles(e.target.files));
img2pdfDropzone?.addEventListener('dragover', (e) => { e.preventDefault(); img2pdfDropzone.classList.add('border-emerald-500'); });
img2pdfDropzone?.addEventListener('dragleave', () => img2pdfDropzone.classList.remove('border-emerald-500'));
img2pdfDropzone?.addEventListener('drop', (e) => {
    e.preventDefault();
    img2pdfDropzone.classList.remove('border-emerald-500');
    if (e.dataTransfer.files) handleImageFiles(e.dataTransfer.files);
});

async function handleImageFiles(files) {
    if (!files || !files.length) return;
    hideAlert();

    for (const f of Array.from(files)) {
        if (!f.type.startsWith('image/')) continue;
        const reader = new FileReader();
        reader.onload = function(e) {
            img2pdfFiles.push({
                file: f,
                name: f.name,
                dataUrl: e.target.result
            });
            renderImageGallery();
        };
        reader.readAsDataURL(f);
    }
    img2pdfInput.value = '';
}

function renderImageGallery() {
    const container = document.getElementById('img2pdf-details-container');
    const grid = document.getElementById('img2pdf-preview-grid');
    if (!container || !grid) return;

    if (img2pdfFiles.length === 0) {
        container.classList.add('hidden');
        return;
    }

    container.classList.remove('hidden');
    grid.innerHTML = '';

    img2pdfFiles.forEach((item, idx) => {
        const card = document.createElement('div');
        card.className = 'p-2 rounded-xl border border-gray-200 bg-white flex flex-col items-center justify-between gap-2 shadow-2xs relative';
        card.innerHTML = `
            <div class="w-full h-32 bg-gray-50 rounded-lg overflow-hidden flex items-center justify-center">
                <img src="${item.dataUrl}" class="w-full h-full object-cover" alt="${item.name}">
            </div>
            <div class="w-full flex items-center justify-between text-xs px-1">
                <span class="font-bold text-gray-500 text-[11px] truncate max-w-[80px]" title="${item.name}">${idx + 1}. ${item.name}</span>
                <div class="flex items-center gap-1">
                    <button type="button" onclick="moveImgItem(${idx}, -1)" ${idx === 0 ? 'disabled' : ''} class="w-6 h-6 rounded bg-gray-100 hover:bg-gray-200 text-gray-600 disabled:opacity-30 text-[10px]">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                    <button type="button" onclick="moveImgItem(${idx}, 1)" ${idx === img2pdfFiles.length - 1 ? 'disabled' : ''} class="w-6 h-6 rounded bg-gray-100 hover:bg-gray-200 text-gray-600 disabled:opacity-30 text-[10px]">
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                    <button type="button" onclick="removeImgItem(${idx})" class="w-6 h-6 rounded bg-red-50 hover:bg-red-100 text-red-500 text-[10px]">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        grid.appendChild(card);
    });
}

function moveImgItem(idx, dir) {
    const target = idx + dir;
    if (target < 0 || target >= img2pdfFiles.length) return;
    const temp = img2pdfFiles[idx];
    img2pdfFiles[idx] = img2pdfFiles[target];
    img2pdfFiles[target] = temp;
    renderImageGallery();
}

function removeImgItem(idx) {
    img2pdfFiles.splice(idx, 1);
    renderImageGallery();
}

async function runConvertImagesToPDF() {
    if (img2pdfFiles.length === 0) {
        showAlert(IS_BN ? 'অন্তত ১টি ছবি সিলেক্ট করুন।' : 'Please add at least 1 image.', 'error');
        return;
    }

    const btn = document.getElementById('btn-img2pdf-action');
    const icon = document.getElementById('img2pdf-btn-icon');
    const text = document.getElementById('img2pdf-btn-text');
    const origText = text.textContent;

    btn.disabled = true;
    text.textContent = IS_BN ? 'PDF তৈরি হচ্ছে...' : 'Creating PDF...';
    icon.className = 'fa-solid fa-spinner animate-spin';

    try {
        const orientation = document.getElementById('img2pdf-orientation').value;
        const marginChoice = document.getElementById('img2pdf-margin').value;
        const marginPt = marginChoice === 'none' ? 0 : (marginChoice === 'small' ? 28.3 : 56.7); // 0, 10mm (28.3pt), 20mm (56.7pt)

        const pdfDoc = await PDFLib.PDFDocument.create();

        for (const item of img2pdfFiles) {
            let embeddedImg;
            if (item.file.type === 'image/png') {
                embeddedImg = await pdfDoc.embedPng(item.dataUrl);
            } else {
                // For JPEG / WebP (draw to canvas to convert to JPEG array buffer)
                const img = new Image();
                img.src = item.dataUrl;
                await new Promise((resolve) => { img.onload = resolve; });

                const canvas = document.createElement('canvas');
                canvas.width = img.naturalWidth;
                canvas.height = img.naturalHeight;
                const ctx = canvas.getContext('2d');
                ctx.fillStyle = '#ffffff';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(img, 0, 0);

                const jpegDataUrl = canvas.toDataURL('image/jpeg', 0.92);
                embeddedImg = await pdfDoc.embedJpg(jpegDataUrl);
            }

            const imgWidth = embeddedImg.width;
            const imgHeight = embeddedImg.height;

            // Page dimensions in points: A4 portrait is 595.28 x 841.89
            let pageWidth = 595.28;
            let pageHeight = 841.89;

            if (orientation === 'landscape') {
                pageWidth = 841.89;
                pageHeight = 595.28;
            } else if (orientation === 'auto') {
                if (imgWidth > imgHeight) {
                    pageWidth = 841.89;
                    pageHeight = 595.28;
                }
            }

            const availableWidth = pageWidth - (marginPt * 2);
            const availableHeight = pageHeight - (marginPt * 2);

            // Scale image proportionally to fit available area
            const scaleFactor = Math.min(availableWidth / imgWidth, availableHeight / imgHeight);
            const drawWidth = imgWidth * scaleFactor;
            const drawHeight = imgHeight * scaleFactor;

            const x = marginPt + (availableWidth - drawWidth) / 2;
            const y = marginPt + (availableHeight - drawHeight) / 2;

            const page = pdfDoc.addPage([pageWidth, pageHeight]);
            page.drawImage(embeddedImg, {
                x: x,
                y: y,
                width: drawWidth,
                height: drawHeight
            });
        }

        const bytes = await pdfDoc.save();
        const blob = new Blob([bytes], { type: 'application/pdf' });
        const filename = (document.getElementById('img2pdf-filename').value || 'Images_Document.pdf').trim();
        triggerDownload(blob, filename.endsWith('.pdf') ? filename : filename + '.pdf');

        showAlert(IS_BN ? 'ছবি থেকে PDF সফলভাবে তৈরি ও ডাউনলোড হয়েছে!' : 'Images converted to PDF successfully!', 'success');
    } catch (err) {
        console.error('Image to PDF error:', err);
        showAlert((IS_BN ? 'PDF তৈরিতে সমস্যা হয়েছে: ' : 'Failed to create PDF: ') + err.message, 'error');
    } finally {
        btn.disabled = false;
        text.textContent = origText;
        icon.className = 'fa-solid fa-file-pdf';
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// TAB 5: PDF TO JPG
// ─────────────────────────────────────────────────────────────────────────────
const pdf2imgInput = document.getElementById('pdf2img-file-input');
const pdf2imgDropzone = document.getElementById('pdf2img-dropzone');

pdf2imgInput?.addEventListener('change', (e) => {
    if (e.target.files && e.target.files[0]) handlePdfToImgDoc(e.target.files[0]);
});
pdf2imgDropzone?.addEventListener('dragover', (e) => { e.preventDefault(); pdf2imgDropzone.classList.add('border-amber-500'); });
pdf2imgDropzone?.addEventListener('dragleave', () => pdf2imgDropzone.classList.remove('border-amber-500'));
pdf2imgDropzone?.addEventListener('drop', (e) => {
    e.preventDefault();
    pdf2imgDropzone.classList.remove('border-amber-500');
    if (e.dataTransfer.files && e.dataTransfer.files[0]) handlePdfToImgDoc(e.dataTransfer.files[0]);
});

async function handlePdfToImgDoc(file) {
    if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf')) {
        showAlert(IS_BN ? 'শুধুমাত্র PDF ফাইল আপলোড করুন।' : 'Only PDF files are supported.', 'error');
        return;
    }

    hideAlert();
    document.getElementById('pdf2img-dropzone').classList.add('hidden');
    document.getElementById('pdf2img-details-container').classList.remove('hidden');
    document.getElementById('pdf2img-doc-name').textContent = file.name;
    document.getElementById('pdf2img-doc-meta').textContent = IS_BN ? 'পৃষ্ঠাগুলো রূপান্তর হচ্ছে...' : 'Rendering pages into high-res images...';

    const grid = document.getElementById('pdf2img-results-grid');
    grid.innerHTML = '<div class="col-span-full py-8 text-center text-xs text-amber-600"><i class="fa-solid fa-spinner animate-spin text-xl mb-2 block"></i>Converting pages...</div>';

    try {
        const buf = await file.arrayBuffer();
        const loadingTask = pdfjsLib.getDocument({ data: buf });
        const pdf = await loadingTask.promise;

        pdf2imgData = {
            file: file,
            name: file.name,
            images: []
        };

        grid.innerHTML = '';
        document.getElementById('pdf2img-doc-meta').textContent = `${pdf.numPages} ${IS_BN ? 'টি পৃষ্ঠা সফলভাবে রূপান্তর হয়েছে' : 'Pages ready to download'}`;

        for (let i = 1; i <= pdf.numPages; i++) {
            const page = await pdf.getPage(i);
            const viewport = page.getViewport({ scale: 2.0 }); // High-DPI 2x scale for sharp output

            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            canvas.width = viewport.width;
            canvas.height = viewport.height;

            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            await page.render({ canvasContext: ctx, viewport: viewport }).promise;

            const dataUrl = canvas.toDataURL('image/jpeg', 0.95);
            pdf2imgData.images.push({
                pageNum: i,
                dataUrl: dataUrl,
                width: canvas.width,
                height: canvas.height
            });

            const card = document.createElement('div');
            card.className = 'p-3 bg-white border border-gray-200 rounded-2xl flex flex-col items-center justify-between gap-2.5 shadow-2xs hover:shadow-md transition-all';
            card.innerHTML = `
                <div class="w-full flex items-center justify-between text-xs font-bold text-gray-700 px-1">
                    <span>${IS_BN ? 'পৃষ্ঠা' : 'Page'} ${i}</span>
                    <span class="text-[10px] text-gray-400 font-normal">${canvas.width}×${canvas.height}px</span>
                </div>
                <div class="w-full h-44 bg-gray-50 border border-gray-100 rounded-xl overflow-hidden flex items-center justify-center p-1">
                    <img src="${dataUrl}" class="max-h-full max-w-full object-contain" alt="Page ${i}">
                </div>
                <button type="button" onclick="downloadSinglePageImg(${i})"
                        class="w-full btn-secondary text-xs py-2 inline-flex items-center justify-center gap-1.5 hover:bg-amber-50 hover:text-amber-700 hover:border-amber-300">
                    <i class="fa-solid fa-download"></i>
                    <span>${IS_BN ? 'JPG ডাউনলোড' : 'Download JPG'}</span>
                </button>
            `;
            grid.appendChild(card);
        }
    } catch (err) {
        console.error('PDF to IMG error:', err);
        showAlert(IS_BN ? 'PDF ছবি করতে সমস্যা হয়েছে।' : 'Failed to convert PDF to images.', 'error');
    }
}

function downloadSinglePageImg(pageNum) {
    if (!pdf2imgData) return;
    const item = pdf2imgData.images.find(img => img.pageNum === pageNum);
    if (!item) return;

    const baseName = pdf2imgData.name.replace(/\.pdf$/i, '');
    const a = document.createElement('a');
    a.href = item.dataUrl;
    a.download = `${baseName}_Page_${pageNum}.jpg`;
    document.body.appendChild(a);
    a.click();
    a.remove();
}

async function downloadAllImagesZip() {
    if (!pdf2imgData || !pdf2imgData.images.length) return;

    const btn = document.getElementById('btn-download-all-zip');
    const origHtml = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = `<i class="fa-solid fa-spinner animate-spin"></i> <span>${IS_BN ? 'ZIP তৈরি হচ্ছে...' : 'Creating ZIP...'}</span>`;

    try {
        const zip = new JSZip();
        const baseName = pdf2imgData.name.replace(/\.pdf$/i, '');

        pdf2imgData.images.forEach(img => {
            const base64Data = img.dataUrl.split(',')[1];
            zip.file(`${baseName}_Page_${img.pageNum}.jpg`, base64Data, { base64: true });
        });

        const zipBlob = await zip.generateAsync({ type: 'blob' });
        triggerDownload(zipBlob, `${baseName}_All_Images_JPG.zip`);
    } catch (err) {
        console.error('ZIP error:', err);
        showAlert(IS_BN ? 'ZIP তৈরি করতে সমস্যা হয়েছে।' : 'Failed to generate ZIP.', 'error');
    } finally {
        btn.disabled = false;
        btn.innerHTML = origHtml;
    }
}
</script>
@endpush
@endsection
