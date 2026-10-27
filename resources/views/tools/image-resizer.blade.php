@extends('layouts.app')

@php
    $isBn = app()->getLocale() === 'bn';
@endphp

@section('page_title', ($isBn ? 'ছবি ও স্বাক্ষর রিসাইজার — সরকারি চাকরির ৩০০×৩০০ ছবি ও ৩০০×৮০ সাইন' : 'Image Resizer & Cropper — 300x300 Photo & 300x80 Signature') . ' — ' . __('ui.site_name'))
@section('seo_description', $isBn
    ? 'সরকারি ও ব্যাংক চাকরির আবেদনের জন্য ছবি ৩০০×৩০০ পিক্সেল এবং স্বাক্ষর ৩০০×৮০ পিক্সেলে নিখুঁতভাবে রিসাইজ ও ক্রপ করুন। ১০০% ফ্রি ও ইনস্ট্যান্ট ডাউনলোড।'
    : 'Interactively crop and resize photos for BD government job applications (300x300 pixel photo & 300x80 signature), passport size, and social media.')

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "WebApplication",
    "name": "{{ $isBn ? 'অনলাইন ছবি ও স্বাক্ষর রিসাইজার' : 'Online Image Resizer & Cropper' }}",
    "description": "{{ $isBn ? 'সরকারি চাকরির ৩০০×৩০০ ছবি ও ৩০০×৮০ স্বাক্ষর রিসাইজের অনলাইন টুল।' : 'Interactive photo and signature cropper for job applications.' }}",
    "url": "{{ url()->current() }}",
    "applicationCategory": "MultimediaApplication",
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
            "name": "{{ $isBn ? 'সরকারি চাকরির টেলিটক (Teletalk) আবেদনের জন্য কি এই সাইজ গ্রহণযোগ্য?' : 'Is this 300x300 format accepted on Teletalk government job portals?' }}",
            "acceptedAnswer": {
                "@@type": "Answer",
                "text": "{{ $isBn ? 'হ্যাঁ! আমাদের প্রিসেট বাটন ক্লিক করলেই ছবি স্বয়ংক্রিয়ভাবে এক্স্যাক্ট ৩০০×৩০০ পিক্সেল (১০০ KB এর নিচে) এবং সাইন ৩০০×৮০ পিক্সেলে (৬০ KB এর নিচে) সেভ হয়।' : 'Yes! The 300x300 and 300x80 presets strictly comply with Teletalk and all Bangladesh government recruitment portal constraints.' }}"
            }
        }
    ]
}
</script>
@endsection

@push('styles')
{{-- Cropper.js CSS (CDN + Local Fallback) --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css" integrity="sha512-UtLOu9C7NuthZmxr20QVstfc3jjLtu6SE54iLJwyNWitYT3A8s+63ZywgkTamjsr1FXNxBRChx8annboKI01DA==" crossorigin="anonymous" referrerpolicy="no-referrer">
<link rel="stylesheet" href="{{ asset('css/cropper.min.css') }}">
<style>
    /* Full Inlined Cropper CSS to guarantee 100% zero display/double-image bugs */
    .cropper-container { position: relative; font-size: 0; line-height: 0; direction: ltr; user-select: none; touch-action: none; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; }
    .cropper-container img { display: block; min-width: 0 !important; min-height: 0 !important; max-width: none !important; max-height: none !important; width: 100%; height: 100%; image-orientation: 0deg; backface-visibility: hidden; }
    .cropper-wrap-box, .cropper-canvas, .cropper-drag-box, .cropper-crop-box, .cropper-modal { position: absolute; top: 0; right: 0; bottom: 0; left: 0; }
    .cropper-wrap-box, .cropper-canvas { overflow: hidden; }
    .cropper-drag-box { opacity: 0; background-color: #fff; }
    .cropper-modal { opacity: 0.65; background-color: #0b1120; }
    .cropper-view-box { display: block; overflow: hidden; width: 100%; height: 100%; outline: 2px solid #2563eb; outline-color: rgba(37, 99, 235, 0.95); user-select: none; }
    .cropper-dashed { position: absolute; display: block; opacity: 0.75; border: 0 dashed #ffffff; }
    .cropper-dashed.dashed-h { top: 33.33333%; left: 0; width: 100%; height: 33.33333%; border-top-width: 1px; border-bottom-width: 1px; }
    .cropper-dashed.dashed-v { top: 0; left: 33.33333%; width: 33.33333%; height: 100%; border-right-width: 1px; border-left-width: 1px; }
    .cropper-center { position: absolute; top: 50%; left: 50%; display: block; width: 0; height: 0; opacity: 0.85; }
    .cropper-center:before, .cropper-center:after { position: absolute; display: block; content: " "; background-color: #ffffff; }
    .cropper-center:before { top: 0; left: -4px; width: 9px; height: 1px; }
    .cropper-center:after { top: -4px; left: 0; width: 1px; height: 9px; }
    .cropper-face, .cropper-line, .cropper-point { position: absolute; display: block; width: 100%; height: 100%; opacity: 0.1; }
    .cropper-face { top: 0; left: 0; background-color: #fff; cursor: move; }
    .cropper-line { background-color: #2563eb; }
    .cropper-line.line-e { top: 0; right: -5px; width: 10px; cursor: ew-resize; }
    .cropper-line.line-n { top: -5px; left: 0; height: 10px; cursor: ns-resize; }
    .cropper-line.line-w { top: 0; left: -5px; width: 10px; cursor: ew-resize; }
    .cropper-line.line-s { bottom: -5px; left: 0; height: 10px; cursor: ns-resize; }
    .cropper-point {
        width: 13px !important;
        height: 13px !important;
        opacity: 1 !important;
        background-color: #2563eb !important;
        border: 2px solid #ffffff !important;
        border-radius: 3px !important;
        box-shadow: 0 1px 5px rgba(0,0,0,0.45) !important;
    }
    .cropper-point.point-e { top: 50%; right: -6px; margin-top: -6px; cursor: ew-resize; }
    .cropper-point.point-n { top: -6px; left: 50%; margin-left: -6px; cursor: ns-resize; }
    .cropper-point.point-w { top: 50%; left: -6px; margin-top: -6px; cursor: ew-resize; }
    .cropper-point.point-s { bottom: -6px; left: 50%; margin-left: -6px; cursor: ns-resize; }
    .cropper-point.point-ne { top: -6px; right: -6px; cursor: nesw-resize; }
    .cropper-point.point-nw { top: -6px; left: -6px; cursor: nwse-resize; }
    .cropper-point.point-sw { bottom: -6px; left: -6px; cursor: nesw-resize; }
    .cropper-point.point-se { right: -7px; bottom: -7px; width: 16px !important; height: 16px !important; cursor: nwse-resize; opacity: 1 !important; }
    
    /* Critical hide classes to prevent double image display */
    .cropper-hide {
        display: block !important;
        height: 0 !important;
        position: absolute !important;
        width: 0 !important;
        overflow: hidden !important;
        opacity: 0 !important;
    }
    .cropper-hidden {
        display: none !important;
    }
    .cropper-invisible { opacity: 0; }
    .cropper-bg { background-image: repeating-conic-gradient(#f1f5f9 0% 25%, #ffffff 0% 50%) !important; background-size: 16px 16px !important; }
    .cropper-auto-crop { cursor: crosshair; }
    .cropper-crop { cursor: crosshair; }
    .cropper-move { cursor: move; }

    /* Mobile-optimized touch handles for easy resizing */
    @media (max-width: 768px) {
        .cropper-point {
            width: 20px !important;
            height: 20px !important;
            border-radius: 4px !important;
        }
        .cropper-point.point-e { right: -10px; margin-top: -10px; }
        .cropper-point.point-n { top: -10px; margin-left: -10px; }
        .cropper-point.point-w { left: -10px; margin-top: -10px; }
        .cropper-point.point-s { bottom: -10px; margin-left: -10px; }
        .cropper-point.point-ne { top: -10px; right: -10px; }
        .cropper-point.point-nw { top: -10px; left: -10px; }
        .cropper-point.point-sw { bottom: -10px; left: -10px; }
        .cropper-point.point-se {
            right: -10px;
            bottom: -10px;
            width: 26px !important;
            height: 26px !important;
        }
        .cropper-line.line-e { right: -8px; width: 16px; }
        .cropper-line.line-n { top: -8px; height: 16px; }
        .cropper-line.line-w { left: -8px; width: 16px; }
        .cropper-line.line-s { bottom: -8px; height: 16px; }
    }
</style>
@endpush

@section('content')
@php $isBn = app()->getLocale() === 'bn'; @endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @include('partials.tool-back')

    {{-- Header --}}
    <div class="mb-6 flex items-center justify-between flex-wrap gap-4 bg-white p-5 rounded-2xl border border-gray-100 shadow-xs">
        <div class="flex items-center gap-3.5">
            <div class="w-11 h-11 bg-gradient-to-br from-violet-500 to-indigo-600 text-white rounded-xl flex items-center justify-center shadow-xs">
                <i class="fa-solid fa-crop-simple text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-gray-900">
                    {{ $isBn ? 'ইমেজ রিসাইজার ও ক্রপার' : 'Image Resizer & Cropper' }}
                </h1>
                <p class="text-gray-500 text-xs sm:text-sm">
                    {{ $isBn ? 'ছবির উপর সরাসরি বক্স টেনে ছোট-বড় করে সরকারি চাকরি (৩০০×৩০০ ছবি, ৩০০×৮০ স্বাক্ষর) সহ যেকোনো সাইজে রূপান্তর করুন।' : 'Drag handles over image to resize and crop for BD Govt job (300x300, 300x80) and custom sizes.' }}
                </p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button id="btn-reupload" onclick="document.getElementById('file-input').click()" class="btn-secondary text-xs px-3.5 py-2 inline-flex items-center gap-1.5 hidden">
                <i class="fa-solid fa-arrow-rotate-right"></i>
                <span>{{ $isBn ? 'নতুন ছবি আপলোড' : 'Upload New' }}</span>
            </button>
        </div>
    </div>

    {{-- Drop Zone (Initial State) --}}
    <div id="drop-zone" class="card border-2 border-dashed border-violet-200 hover:border-violet-500 bg-violet-50/30 hover:bg-violet-50/70 p-12 sm:p-16 text-center cursor-pointer transition-all duration-200 rounded-3xl group mb-6">
        <div class="w-16 h-16 mx-auto bg-white rounded-2xl border border-violet-100 flex items-center justify-center shadow-xs mb-4 group-hover:scale-105 transition-transform">
            <i class="fa-solid fa-cloud-arrow-up text-violet-600 text-2xl"></i>
        </div>
        <p class="text-base font-bold text-gray-800 mb-1">{{ $isBn ? 'ছবি টেনে এনে ড্রপ করুন অথবা ক্লিক করুন' : 'Drag & drop your image here, or click to browse' }}</p>
        <p class="text-xs text-gray-500 mb-4">{{ $isBn ? 'JPG, PNG, WEBP সাপোর্ট করে (কোনো সার্ভারে আপলোড হয় না, ১০০% নিরাপদ)' : 'Supports JPG, PNG, WEBP (100% private in browser)' }}</p>
        <span class="inline-flex items-center gap-1.5 bg-violet-600 text-white text-xs font-semibold px-4 py-2 rounded-xl shadow-xs">
            <i class="fa-solid fa-folder-open"></i>
            <span>{{ $isBn ? 'ডিভাইস থেকে ছবি নির্বাচন করুন' : 'Select Image from Device' }}</span>
        </span>
        <input type="file" id="file-input" accept="image/*" class="hidden">
    </div>

    {{-- Main Workspace (Hidden until image loaded) --}}
    <div id="workspace" class="hidden grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        {{-- Left: Interactive Image Canvas --}}
        <div class="lg:col-span-8 space-y-3">
            {{-- Toolbar Actions --}}
            <div class="bg-white p-2.5 rounded-2xl border border-gray-100 shadow-xs flex items-center justify-between flex-wrap gap-2">
                <div class="flex items-center gap-1">
                    <button type="button" onclick="rotateLeft()" title="{{ $isBn ? 'বাম দিকে ৯০° ঘোরান' : 'Rotate Left 90°' }}" class="tool-btn">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span class="hidden sm:inline text-xs ml-1">{{ $isBn ? 'ঘোরান' : 'Rotate' }}</span>
                    </button>
                    <button type="button" onclick="rotateRight()" title="{{ $isBn ? 'ডান দিকে ৯০° ঘোরান' : 'Rotate Right 90°' }}" class="tool-btn">
                        <i class="fa-solid fa-rotate-right"></i>
                    </button>
                    <div class="h-5 w-px bg-gray-200 mx-1"></div>
                    <button type="button" onclick="flipH()" title="{{ $isBn ? 'অনুভূমিক উল্টান' : 'Flip Horizontal' }}" class="tool-btn">
                        <i class="fa-solid fa-arrows-left-right"></i>
                        <span class="hidden sm:inline text-xs ml-1">{{ $isBn ? 'ফ্লিপ H' : 'Flip H' }}</span>
                    </button>
                    <button type="button" onclick="flipV()" title="{{ $isBn ? 'উল্লম্ব উল্টান' : 'Flip Vertical' }}" class="tool-btn">
                        <i class="fa-solid fa-arrows-up-down"></i>
                        <span class="hidden sm:inline text-xs ml-1">{{ $isBn ? 'ফ্লিপ V' : 'Flip V' }}</span>
                    </button>
                </div>

                <div class="flex items-center gap-1">
                    <button type="button" onclick="zoomIn()" title="{{ $isBn ? 'জুম ইন' : 'Zoom In' }}" class="tool-btn">
                        <i class="fa-solid fa-magnifying-glass-plus"></i>
                    </button>
                    <button type="button" onclick="zoomOut()" title="{{ $isBn ? 'জুম আউট' : 'Zoom Out' }}" class="tool-btn">
                        <i class="fa-solid fa-magnifying-glass-minus"></i>
                    </button>
                    <button type="button" onclick="resetCrop()" title="{{ $isBn ? 'রিসেট' : 'Reset' }}" class="tool-btn text-amber-600 hover:text-amber-700">
                        <i class="fa-solid fa-arrow-rotate-left"></i>
                        <span class="text-xs ml-1">{{ $isBn ? 'রিসেট' : 'Reset' }}</span>
                    </button>
                </div>
            </div>

            {{-- Canvas Box with Container --}}
            <div class="bg-slate-900 rounded-2xl p-2 sm:p-4 border border-gray-200 shadow-inner overflow-hidden flex items-center justify-center min-h-[300px] sm:min-h-[420px] max-h-[620px]">
                <div id="cropper-image-container" class="w-full max-h-[580px] flex items-center justify-center">
                    {{-- Dynamically populated with <img> upon file selection --}}
                </div>
            </div>

            {{-- Live Size Banner --}}
            <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 flex items-center justify-between text-xs text-gray-600 flex-wrap gap-2">
                <span class="flex items-center gap-1.5">
                    <i class="fa-solid fa-image text-gray-400"></i>
                    <span>{{ $isBn ? 'মূল সাইজ:' : 'Original:' }} <strong id="orig-dims-text" class="text-gray-800">—</strong></span>
                </span>
                <span class="flex items-center gap-1.5">
                    <i class="fa-solid fa-crop text-blue-600"></i>
                    <span>{{ $isBn ? 'সিলেক্টেড বক্স:' : 'Crop Box:' }} <strong id="crop-dims-text" class="text-blue-600">—</strong></span>
                </span>
                <span class="flex items-center gap-1.5">
                    <i class="fa-solid fa-file-export text-emerald-600"></i>
                    <span>{{ $isBn ? 'আউটপুট সাইজ:' : 'Final Export:' }} <strong id="export-dims-text" class="text-emerald-700">—</strong></span>
                </span>
            </div>
        </div>

        {{-- Right: Settings & Export Panel --}}
        <div class="lg:col-span-4 space-y-4">

            {{-- Bangladesh Government Job Special Presets (Top Focus) --}}
            <div class="card p-5 space-y-3 bg-gradient-to-br from-blue-50/60 to-indigo-50/40 border-blue-200">
                <div class="flex items-center justify-between">
                    <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                        <i class="fa-solid fa-award text-blue-600"></i>
                        <span>{{ $isBn ? 'সরকারি চাকরি স্পেশাল' : 'BD Govt Job Presets' }}</span>
                    </h3>
                    <span class="text-[10px] font-bold bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">Teletalk / BPSC</span>
                </div>
                <p class="text-[11px] text-gray-600 leading-relaxed">
                    {{ $isBn ? 'সরকারি চাকরির আবেদনের জন্য ছবি ৩০০×৩০০ পিক্সেল (১০০ KB) এবং স্বাক্ষর ৩০০×৮০ পিক্সেল (৬০ KB) আবশ্যক।' : 'Required standards: Photo 300×300 px (100KB) and Signature 300×80 px (60KB).' }}
                </p>

                <div class="grid grid-cols-2 gap-2 text-xs pt-1">
                    <button type="button" onclick="setPreset(300, 300, 1/1, 'govt-photo')" id="preset-govt-photo" class="preset-pill bg-white">
                        <span class="font-bold text-blue-700">{{ $isBn ? 'সরকারি চাকরি ছবি' : 'Govt Job Photo' }}</span>
                        <span class="text-[10px] text-gray-500 font-semibold">300 × 300 px</span>
                    </button>
                    <button type="button" onclick="setPreset(300, 80, 300/80, 'govt-sign')" id="preset-govt-sign" class="preset-pill bg-white">
                        <span class="font-bold text-indigo-700">{{ $isBn ? 'সরকারি চাকরি স্বাক্ষর' : 'Govt Job Sign' }}</span>
                        <span class="text-[10px] text-gray-500 font-semibold">300 × 80 px</span>
                    </button>
                </div>
            </div>

            {{-- Custom Size (Target Pixels) --}}
            <div class="card p-5 space-y-3.5">
                <div class="flex items-center justify-between">
                    <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                        <i class="fa-solid fa-up-right-and-down-left-from-center text-blue-600"></i>
                        <span>{{ $isBn ? 'আউটপুট সাইজ (পিক্সেল)' : 'Target Size (px)' }}</span>
                    </h3>
                    <span class="text-[11px] text-gray-400">{{ $isBn ? 'সরাসরি সাইজ দিন' : 'Enter dimensions' }}</span>
                </div>

                <div class="grid grid-cols-2 gap-3 items-center">
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 mb-1">{{ $isBn ? 'প্রস্থ (Width px)' : 'Width (px)' }}</label>
                        <input type="number" id="input-target-w" min="10" max="10000" oninput="onCustomDimensionsChange('w')" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm font-semibold text-gray-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 mb-1">{{ $isBn ? 'উচ্চতা (Height px)' : 'Height (px)' }}</label>
                        <input type="number" id="input-target-h" min="10" max="10000" oninput="onCustomDimensionsChange('h')" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm font-semibold text-gray-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                </div>

                <div class="flex items-center justify-between pt-1">
                    <label class="inline-flex items-center gap-2 text-xs font-medium text-gray-700 cursor-pointer">
                        <input type="checkbox" id="lock-aspect" checked onchange="toggleLockAspect()" class="rounded text-blue-600 focus:ring-blue-500">
                        <span>{{ $isBn ? 'অনুপাত লক রাখুন (Lock Ratio)' : 'Lock Aspect Ratio' }}</span>
                    </label>
                    <button type="button" onclick="applyInputsToCropBox()" class="text-xs text-blue-600 hover:text-blue-700 font-semibold inline-flex items-center gap-1">
                        <i class="fa-solid fa-check"></i>
                        <span>{{ $isBn ? 'বক্সে প্রয়োগ করুন' : 'Apply to Box' }}</span>
                    </button>
                </div>
            </div>

            {{-- Quick Presets --}}
            <div class="card p-5 space-y-3">
                <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                    <i class="fa-solid fa-sliders text-violet-600"></i>
                    <span>{{ $isBn ? 'অন্যান্য সাইজ প্রিসেট' : 'Other Presets' }}</span>
                </h3>

                <div class="grid grid-cols-2 gap-2 text-xs">
                    <button type="button" onclick="setPreset(null, null, 1/1, '1-1')" id="preset-1-1" class="preset-pill">
                        <span class="font-bold">{{ $isBn ? '১:১ বর্গাকার' : '1:1 Square' }}</span>
                        <span class="text-[10px] text-gray-400">Instagram / Profile</span>
                    </button>
                    <button type="button" onclick="setPreset(1280, 720, 16/9, '16-9')" id="preset-16-9" class="preset-pill">
                        <span class="font-bold">{{ $isBn ? '১৬:৯ এইচডি' : '16:9 HD' }}</span>
                        <span class="text-[10px] text-gray-400">1280 × 720 px</span>
                    </button>
                    <button type="button" onclick="setPreset(820, 312, 820/312, 'fb-cover')" id="preset-fb-cover" class="preset-pill">
                        <span class="font-bold">{{ $isBn ? 'ফেসবুক কভার' : 'Facebook Cover' }}</span>
                        <span class="text-[10px] text-gray-400">820 × 312 px</span>
                    </button>
                    <button type="button" onclick="setFreeform()" id="preset-free" class="preset-pill">
                        <span class="font-bold">{{ $isBn ? 'ফ্রিফর্ম (আনলক)' : 'Freeform' }}</span>
                        <span class="text-[10px] text-gray-400">{{ $isBn ? 'যে কোনো অনুপাত' : 'Any ratio' }}</span>
                    </button>
                </div>
            </div>

            {{-- Export Options (Format & Quality) --}}
            <div class="card p-5 space-y-3.5">
                <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                    <i class="fa-solid fa-file-image text-emerald-600"></i>
                    <span>{{ $isBn ? 'ফরম্যাট ও কোয়ালিটি' : 'Format & Quality' }}</span>
                </h3>

                <div>
                    <label class="block text-[11px] font-semibold text-gray-600 mb-1">{{ $isBn ? 'ফাইল ফরম্যাট' : 'File Format' }}</label>
                    <div class="grid grid-cols-3 gap-2">
                        <label class="format-radio-label">
                            <input type="radio" name="export-format" value="image/jpeg" checked class="hidden" onchange="updateFormat()">
                            <span>JPEG (.jpg)</span>
                        </label>
                        <label class="format-radio-label">
                            <input type="radio" name="export-format" value="image/png" class="hidden" onchange="updateFormat()">
                            <span>PNG (.png)</span>
                        </label>
                        <label class="format-radio-label">
                            <input type="radio" name="export-format" value="image/webp" class="hidden" onchange="updateFormat()">
                            <span>WEBP (.webp)</span>
                        </label>
                    </div>
                </div>

                <div id="quality-row">
                    <div class="flex items-center justify-between text-[11px] font-semibold text-gray-600 mb-1">
                        <span>{{ $isBn ? 'ছবির মান (Quality)' : 'Image Quality' }}</span>
                        <span id="quality-val" class="text-blue-600 font-bold">95%</span>
                    </div>
                    <input type="range" id="input-quality" min="50" max="100" value="95" oninput="document.getElementById('quality-val').textContent = this.value + '%'" class="w-full accent-blue-600 cursor-pointer">
                </div>

                {{-- Download Button --}}
                <div class="pt-2">
                    <button type="button" id="btn-download" onclick="downloadCropped()" class="btn-primary w-full py-3 text-sm inline-flex items-center justify-center gap-2 shadow-md shadow-blue-500/20 font-bold">
                        <i class="fa-solid fa-download"></i>
                        <span id="btn-download-text">{{ $isBn ? 'রিসাইজ ও ক্রপ করে ডাউনলোড করুন' : 'Download Resized Image' }}</span>
                    </button>
                    <p class="text-[11px] text-center text-gray-400 mt-2">{{ $isBn ? 'সরাসরি ব্রাউজারে তৈরি হবে, সর্বোচ্চ নিখুঁত রেজোলিউশনে সেভ হবে।' : 'High quality canvas rendering, saved instantly.' }}</p>
                </div>
            </div>
        </div>
    </div>

    @include('partials.tool-ad')
</div>

<style>
.tool-btn {
    padding: 0.4rem 0.65rem;
    border-radius: 0.5rem;
    font-size: 0.85rem;
    color: #475569;
    background-color: #f8fafc;
    border: 1px solid #e2e8f0;
    transition: all 0.15s ease;
    display: inline-flex;
    align-items: center;
}
.tool-btn:hover {
    background-color: #f1f5f9;
    color: #0f172a;
    border-color: #cbd5e1;
}
.preset-pill {
    padding: 0.5rem 0.6rem;
    border-radius: 0.75rem;
    border: 1px solid #e2e8f0;
    background-color: #f8fafc;
    text-align: left;
    display: flex;
    flex-direction: column;
    gap: 1px;
    transition: all 0.15s ease;
    cursor: pointer;
}
.preset-pill:hover {
    border-color: #93c5fd;
    background-color: #eff6ff;
}
.preset-pill.active {
    border-color: #2563eb;
    background-color: #eff6ff;
    box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
}
.preset-pill.active span.font-bold {
    color: #1d4ed8;
}
.format-radio-label {
    border: 1px solid #e2e8f0;
    border-radius: 0.625rem;
    padding: 0.4rem 0.3rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-align: center;
    color: #475569;
    background: #f8fafc;
    cursor: pointer;
    transition: all 0.15s ease;
    display: block;
}
.format-radio-label:has(input:checked) {
    border-color: #2563eb;
    background-color: #eff6ff;
    color: #1d4ed8;
    box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.15);
}
</style>

@push('scripts')
{{-- Cropper.js Script (CDN with Local Fallback) --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js" integrity="sha512-JyCZjCOZoyeQZSd5+WY48MS5G/jJZPBiNxd+evPPbQGCIcdpnLfPHWC72mlzqn3BAE0xnl65fqy9KEvmbgk3YA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
if (typeof Cropper === 'undefined') {
    document.write('<script src="{{ asset('js/cropper.min.js') }}"><\/script>');
}
</script>

<script>
let cropper = null;
let originalFileName = 'image';
let origNaturalW = 0;
let origNaturalH = 0;
let scaleX = 1;
let scaleY = 1;
const isBn = @json($isBn);

const dropZone = document.getElementById('drop-zone');
const fileInput = document.getElementById('file-input');
const workspace = document.getElementById('workspace');
const inputTargetW = document.getElementById('input-target-w');
const inputTargetH = document.getElementById('input-target-h');
const lockAspect = document.getElementById('lock-aspect');

const origDimsText = document.getElementById('orig-dims-text');
const cropDimsText = document.getElementById('crop-dims-text');
const exportDimsText = document.getElementById('export-dims-text');
const btnReupload = document.getElementById('btn-reupload');

// Initialize Drop Listeners
dropZone.addEventListener('click', () => fileInput.click());
dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('border-violet-500', 'bg-violet-100/50'); });
dropZone.addEventListener('dragleave', () => dropZone.classList.remove('border-violet-500', 'bg-violet-100/50'));
dropZone.addEventListener('drop', e => {
    e.preventDefault();
    dropZone.classList.remove('border-violet-500', 'bg-violet-100/50');
    if (e.dataTransfer.files && e.dataTransfer.files[0]) {
        loadFile(e.dataTransfer.files[0]);
    }
});
fileInput.addEventListener('change', e => {
    if (e.target.files && e.target.files[0]) {
        loadFile(e.target.files[0]);
    }
});

function loadFile(file) {
    if (!file.type.startsWith('image/')) {
        alert(isBn ? 'অনুগ্রহ করে একটি ছবি ফাইল নির্বাচন করুন।' : 'Please select a valid image file.');
        return;
    }

    originalFileName = file.name.substring(0, file.name.lastIndexOf('.')) || 'image';

    const reader = new FileReader();
    reader.onload = e => {
        const src = e.target.result;

        // Show Workspace FIRST so elements have computed dimensions in the DOM
        dropZone.classList.add('hidden');
        workspace.classList.remove('hidden');
        btnReupload.classList.remove('hidden');

        // Destroy previous cropper instance
        if (cropper) {
            try { cropper.destroy(); } catch (err) {}
            cropper = null;
        }

        // Re-inject a clean img element (without hardcoded inline display:block which interferes with .cropper-hide)
        const container = document.getElementById('cropper-image-container');
        container.innerHTML = `<img id="cropper-image" src="${src}" alt="Workspace" style="max-width:100%; max-height:540px;" />`;

        const newImg = document.getElementById('cropper-image');
        scaleX = 1;
        scaleY = 1;

        // Ensure Cropper is initialized whether img is instantly loaded from data URL or asynchronous
        function startCropper() {
            origNaturalW = newImg.naturalWidth || newImg.width;
            origNaturalH = newImg.naturalHeight || newImg.height;
            origDimsText.textContent = `${origNaturalW} × ${origNaturalH} px`;

            // Default target inputs to original size
            inputTargetW.value = origNaturalW;
            inputTargetH.value = origNaturalH;

            if (typeof Cropper === 'undefined') {
                console.error('Cropper is not loaded!');
                alert(isBn ? 'ক্রপার লাইব্রেরি লোড হতে পারেনি। পেজটি রিফ্রেশ দিন।' : 'Cropper library failed to load. Please refresh.');
                return;
            }

            cropper = new Cropper(newImg, {
                viewMode: 1, // Constrain crop box within canvas
                dragMode: 'crop',
                aspectRatio: NaN, // Freeform initially - user can freely expand & shrink
                autoCrop: true, // Always show crop box initially
                autoCropArea: 0.85,
                responsive: true,
                restore: false,
                guides: true, // Rule-of-thirds grid lines
                center: true,
                highlight: true,
                cropBoxMovable: true, // Can drag box directly on image
                cropBoxResizable: true, // Can resize box smaller/bigger with 8 handles
                toggleDragModeOnDblclick: false,
                touchDragZoom: true,
                zoomOnTouch: true,
                minContainerWidth: 260,
                minContainerHeight: 260,
                ready() {
                    updateCropMetrics();
                },
                crop(event) {
                    updateCropMetrics();
                }
            });

            setActivePreset('preset-free');
        }

        if (newImg.complete && newImg.naturalWidth > 0) {
            startCropper();
        } else {
            newImg.onload = startCropper;
        }
    };
    reader.readAsDataURL(file);
}

function updateCropMetrics() {
    if (!cropper) return;
    const data = cropper.getData(true);
    const w = Math.round(data.width);
    const h = Math.round(data.height);

    cropDimsText.textContent = `${w} × ${h} px`;

    // Target export size
    const exportW = parseInt(inputTargetW.value) || w;
    const exportH = parseInt(inputTargetH.value) || h;
    exportDimsText.textContent = `${exportW} × ${exportH} px`;
}

// When user edits Width / Height directly in inputs
function onCustomDimensionsChange(changedField) {
    const w = parseInt(inputTargetW.value);
    const h = parseInt(inputTargetH.value);

    if (lockAspect.checked && w > 0 && h > 0) {
        const ratio = w / h;
        if (cropper) {
            cropper.setAspectRatio(ratio);
        }
    }

    clearPresetActive();
    updateCropMetrics();
}

function toggleLockAspect() {
    if (!cropper) return;
    if (lockAspect.checked) {
        const w = parseInt(inputTargetW.value) || 1;
        const h = parseInt(inputTargetH.value) || 1;
        cropper.setAspectRatio(w / h);
    } else {
        cropper.setAspectRatio(NaN);
        setActivePreset('preset-free');
    }
}

// Apply the entered width & height to the crop box ratio immediately
function applyInputsToCropBox() {
    if (!cropper) return;
    const w = parseInt(inputTargetW.value);
    const h = parseInt(inputTargetH.value);

    if (w > 0 && h > 0) {
        lockAspect.checked = true;
        cropper.setAspectRatio(w / h);
        updateCropMetrics();
    }
}

// Quick Presets
function setPreset(fixedW, fixedH, ratio, presetId) {
    if (!cropper) return;

    if (fixedW && fixedH) {
        inputTargetW.value = fixedW;
        inputTargetH.value = fixedH;
    } else if (ratio) {
        // Keep current width and calculate proportional height
        const currentW = parseInt(inputTargetW.value) || origNaturalW;
        inputTargetW.value = currentW;
        inputTargetH.value = Math.round(currentW / ratio);
    }

    lockAspect.checked = true;
    cropper.setAspectRatio(ratio);

    setActivePreset('preset-' + presetId);
    updateCropMetrics();
}

function setFreeform() {
    if (!cropper) return;
    lockAspect.checked = false;
    cropper.setAspectRatio(NaN);
    setActivePreset('preset-free');
    updateCropMetrics();
}

function setActivePreset(id) {
    clearPresetActive();
    const btn = document.getElementById(id);
    if (btn) btn.classList.add('active');
}

function clearPresetActive() {
    document.querySelectorAll('.preset-pill').forEach(b => b.classList.remove('active'));
}

// Toolbar Actions
function rotateLeft() {
    if (cropper) cropper.rotate(-90);
}
function rotateRight() {
    if (cropper) cropper.rotate(90);
}
function flipH() {
    if (!cropper) return;
    scaleX = -scaleX;
    cropper.scaleX(scaleX);
}
function flipV() {
    if (!cropper) return;
    scaleY = -scaleY;
    cropper.scaleY(scaleY);
}
function zoomIn() {
    if (cropper) cropper.zoom(0.1);
}
function zoomOut() {
    if (cropper) cropper.zoom(-0.1);
}
function resetCrop() {
    if (!cropper) return;
    scaleX = 1;
    scaleY = 1;
    cropper.reset();
    inputTargetW.value = origNaturalW;
    inputTargetH.value = origNaturalH;
    setFreeform();
}

// Format toggle
function updateFormat() {
    const selectedFormat = document.querySelector('input[name="export-format"]:checked')?.value || 'image/jpeg';
    const qualityRow = document.getElementById('quality-row');
    if (selectedFormat === 'image/png') {
        qualityRow.classList.add('opacity-40', 'pointer-events-none');
    } else {
        qualityRow.classList.remove('opacity-40', 'pointer-events-none');
    }
}

// High-Quality Export & Download
async function downloadCropped() {
    if (!cropper) return;

    const btn = document.getElementById('btn-download');
    const btnText = document.getElementById('btn-download-text');
    const origText = btnText.textContent;
    btn.disabled = true;
    btnText.textContent = isBn ? 'প্রসেসিং হচ্ছে...' : 'Processing...';

    try {
        const targetW = parseInt(inputTargetW.value);
        const targetH = parseInt(inputTargetH.value);

        const canvasOptions = {
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        };

        // If user specified custom dimensions, render canvas at exact dimensions
        if (targetW > 0 && targetH > 0) {
            canvasOptions.width = targetW;
            canvasOptions.height = targetH;
        }

        const croppedCanvas = cropper.getCroppedCanvas(canvasOptions);
        if (!croppedCanvas) {
            alert(isBn ? 'ছবি রেন্ডার করতে সমস্যা হয়েছে।' : 'Could not generate cropped canvas.');
            return;
        }

        const format = document.querySelector('input[name="export-format"]:checked')?.value || 'image/jpeg';
        const quality = (parseInt(document.getElementById('input-quality').value) || 95) / 100;

        let ext = 'jpg';
        if (format === 'image/png') ext = 'png';
        else if (format === 'image/webp') ext = 'webp';

        const outputFileName = `${originalFileName}_${croppedCanvas.width}x${croppedCanvas.height}.${ext}`;

        croppedCanvas.toBlob(blob => {
            if (!blob) return;
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = outputFileName;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            setTimeout(() => URL.revokeObjectURL(url), 2000);
        }, format, quality);

    } catch (err) {
        console.error('Resize download error:', err);
        alert(isBn ? 'ডাউনলোড করতে ব্যর্থ হয়েছে।' : 'Failed to download image.');
    } finally {
        btn.disabled = false;
        btnText.textContent = origText;
    }
}
</script>
@endpush
@endsection
