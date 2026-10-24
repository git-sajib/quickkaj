@extends('layouts.app')

@php
    $isBn = app()->getLocale() === 'bn';
@endphp

@section('page_title', ($isBn ? 'ছবির ব্যাকগ্রাউন্ড রিমুভার — এক ক্লিকে সাদা বা নীল ব্যাকগ্রাউন্ড' : 'Free AI Background Remover — Change Background to White or Blue') . ' — ' . __('ui.site_name'))
@section('seo_description', $isBn
    ? 'মানুষের মুখ ও পোশাক অক্ষত রেখে পেছনের ব্যাকগ্রাউন্ড স্বয়ংক্রিয়ভাবে মুছে ফেলুন। সরকারি চাকরির জন্য সাদা বা নীল ব্যাকগ্রাউন্ড যোগ করুন ও পিএনজি ডাউনলোড করুন।'
    : 'Remove image background automatically without touching subject face or clothes. Add white or blue background for ID cards, job applications, and download HD PNG.')

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "WebApplication",
    "name": "{{ $isBn ? 'অনলাইন ব্যাকগ্রাউন্ড রিমুভার' : 'Online AI Background Remover' }}",
    "description": "{{ $isBn ? 'ছবির ব্যাকগ্রাউন্ড রিমুভ ও পাসপোর্ট ছবির ব্যাকগ্রাউন্ড চেঞ্জার।' : 'Remove image backgrounds automatically in your browser with zero data uploads.' }}",
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
            "name": "{{ $isBn ? 'সরকারি চাকরির আবেদনের জন্য নীল বা সাদা ব্যাকগ্রাউন্ড করা যাবে?' : 'Can I change the background to passport white or blue for job applications?' }}",
            "acceptedAnswer": {
                "@@type": "Answer",
                "text": "{{ $isBn ? 'হ্যাঁ! ব্যাকগ্রাউন্ড মোছার পর আপনি এক ক্লিকেই সাদা, নীল, হালকা আকাশী বা যেকোনো পছন্দের কালার ব্যাকগ্রাউন্ডে বসাতে পারবেন।' : 'Yes! After background removal, you can apply pure white, passport blue, or any custom color with one click.' }}"
            }
        }
    ]
}
</script>
@endsection

@section('content')
@php $isBn = app()->getLocale() === 'bn'; @endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @include('partials.tool-back')

    {{-- Header --}}
    <div class="mb-6 flex items-center justify-between flex-wrap gap-4 bg-white p-5 rounded-2xl border border-gray-100 shadow-xs">
        <div class="flex items-center gap-3.5">
            <div class="w-11 h-11 bg-gradient-to-br from-rose-500 to-pink-600 text-white rounded-xl flex items-center justify-center shadow-xs">
                <i class="fa-solid fa-wand-magic-sparkles text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-gray-900 flex items-center gap-2">
                    <span>{{ $isBn ? 'স্বয়ংক্রিয় এআই ব্যাকগ্রাউন্ড রিমুভার' : 'AI Auto Background Remover' }}</span>
                </h1>
                <p class="text-gray-500 text-xs sm:text-sm">
                    {{ $isBn ? 'মানুষের চেহারা ও পোশাক ১০০% অক্ষত রেখে পেছনের ব্যাকগ্রাউন্ড স্বয়ংক্রিয়ভাবে মুছে ফেলুন।' : 'Isolate subject accurately without touching face or clothes.' }}
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
    <div id="drop-zone" class="card border-2 border-dashed border-rose-200 hover:border-rose-500 bg-rose-50/30 hover:bg-rose-50/70 p-12 sm:p-16 text-center cursor-pointer transition-all duration-200 rounded-3xl group mb-6">
        <div class="w-16 h-16 mx-auto bg-white rounded-2xl border border-rose-100 flex items-center justify-center shadow-xs mb-4 group-hover:scale-105 transition-transform">
            <i class="fa-solid fa-wand-magic-sparkles text-rose-600 text-2xl"></i>
        </div>
        <p class="text-base font-bold text-gray-800 mb-1">{{ $isBn ? 'ছবি টেনে এনে ড্রপ করুন অথবা ক্লিক করুন' : 'Drag & drop photo here, or click to browse' }}</p>
        <p class="text-xs text-gray-500 mb-4">{{ $isBn ? 'আপলোড করলেই স্বয়ংক্রিয়ভাবে ব্যাকগ্রাউন্ড মুছে যাবে (১০০% নিরাপদ ও ফ্রি)' : 'Auto-removes background with zero user effort (100% private in browser)' }}</p>
        <span class="inline-flex items-center gap-1.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold px-4 py-2 rounded-xl shadow-xs transition-colors">
            <i class="fa-solid fa-cloud-arrow-up"></i>
            <span>{{ $isBn ? 'ছবি সিলেক্ট করুন' : 'Select Photo' }}</span>
        </span>
        <input type="file" id="file-input" accept="image/*" class="hidden">
    </div>

    {{-- Main Workspace (Hidden until image loaded) --}}
    <div id="workspace" class="hidden grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        {{-- Left: Interactive Canvas Workspace --}}
        <div class="lg:col-span-8 space-y-3">

            {{-- Clean Minimal Toolbar --}}
            <div class="bg-white p-2.5 rounded-2xl border border-gray-100 shadow-xs flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <button type="button" onclick="toggleEraserMode()" id="btn-toggle-erase" class="action-btn text-xs font-semibold">
                        <i class="fa-solid fa-eraser text-orange-500 mr-1"></i>
                        <span>{{ $isBn ? 'ইরেজার' : 'Eraser' }}</span>
                    </button>
                    <button type="button" onclick="undo()" id="btn-undo" disabled title="{{ $isBn ? 'Undo' : 'Undo' }}" class="action-btn disabled:opacity-40">
                        <i class="fa-solid fa-arrow-rotate-left"></i>
                    </button>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" id="btn-show-original" class="action-btn select-none text-xs font-semibold" title="{{ $isBn ? 'ধরে রেখে মূল ছবি দেখুন' : 'Hold to view original' }}">
                        <i class="fa-solid fa-eye text-gray-500 mr-1"></i>
                        <span>{{ $isBn ? 'মূল ছবি' : 'Original' }}</span>
                    </button>
                    <button type="button" onclick="resetToOriginal()" class="action-btn text-rose-600 hover:text-rose-700 text-xs font-semibold" title="{{ $isBn ? 'রিসেট' : 'Reset' }}">
                        <i class="fa-solid fa-arrow-rotate-right mr-1"></i>
                        <span>{{ $isBn ? 'রিসেট' : 'Reset' }}</span>
                    </button>
                </div>
            </div>

            {{-- Interactive Canvas Container --}}
            <div class="bg-slate-900 rounded-2xl p-2 sm:p-4 border border-gray-200 shadow-inner overflow-hidden flex items-center justify-center min-h-[440px] max-h-[660px] relative">
                {{-- Canvas Wrapper (Displays selected color or checkerboard) --}}
                <div id="canvas-wrapper" class="relative max-w-full max-h-[600px] flex items-center justify-center overflow-auto rounded-xl shadow-lg border border-slate-700 transition-colors duration-200">
                    <canvas id="main-canvas" class="block max-w-full max-h-[580px] cursor-default transition-colors duration-200"></canvas>
                </div>

                {{-- AI Progress Overlay --}}
                <div id="ai-loading-overlay" class="absolute inset-0 bg-slate-950/85 backdrop-blur-md rounded-2xl flex flex-col items-center justify-center p-6 text-white z-20 hidden">
                    <div class="w-14 h-14 bg-gradient-to-tr from-rose-500 to-pink-500 rounded-2xl flex items-center justify-center mb-4 shadow-xl shadow-rose-500/30 animate-pulse">
                        <i class="fa-solid fa-wand-magic-sparkles text-2xl text-white"></i>
                    </div>
                    <h4 class="text-base font-bold mb-1" id="ai-status-title">{{ $isBn ? 'ব্যাকগ্রাউন্ড রিমুভ হচ্ছে...' : 'Removing Background...' }}</h4>
                    <p class="text-xs text-slate-300 mb-4 max-w-xs text-center" id="ai-status-subtitle">{{ $isBn ? 'মুখ ও পোশাক অক্ষত রেখে ব্যাকগ্রাউন্ড কাটা হচ্ছে...' : 'Isolating person & clothes from background...' }}</p>

                    <div class="w-64 bg-slate-800 rounded-full h-2 overflow-hidden border border-slate-700">
                        <div id="ai-progress-bar" class="bg-gradient-to-r from-rose-500 to-pink-500 h-full w-0 transition-all duration-300"></div>
                    </div>
                    <span id="ai-progress-percent" class="text-[11px] text-slate-400 mt-2 font-mono">0%</span>
                </div>

                {{-- Hint Overlay --}}
                <div id="canvas-hint" class="absolute bottom-6 left-1/2 -translate-x-1/2 bg-slate-900/85 backdrop-blur-md text-white text-xs px-3.5 py-1.5 rounded-full border border-slate-700 flex items-center gap-2 pointer-events-none shadow-lg">
                    <i class="fa-solid fa-wand-magic-sparkles text-rose-400"></i>
                    <span id="canvas-hint-text">{{ $isBn ? 'ব্যাকগ্রাউন্ড এআই দিয়ে স্বয়ংক্রিয়ভাবে আলাদা করা হয়েছে' : 'Background auto-removed by AI' }}</span>
                </div>
            </div>

            {{-- Status Bar --}}
            <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 flex items-center justify-between text-xs text-gray-600 flex-wrap gap-2">
                <span class="flex items-center gap-1.5">
                    <i class="fa-solid fa-image text-gray-400"></i>
                    <span>{{ $isBn ? 'রেজোলিউশন:' : 'Resolution:' }} <strong id="res-dims-text" class="text-gray-800">—</strong></span>
                </span>
                <span class="flex items-center gap-1.5">
                    <i class="fa-solid fa-layer-group text-blue-600"></i>
                    <span>{{ $isBn ? 'ব্যাকগ্রাউন্ড:' : 'Background:' }} <strong id="current-bg-text" class="text-blue-600 font-bold">{{ $isBn ? 'স্বচ্ছ (Transparent)' : 'Transparent' }}</strong></span>
                </span>
            </div>
        </div>

        {{-- Right: Essential Controls (Only 2 Simple Cards) --}}
        <div class="lg:col-span-4 space-y-4">

            {{-- Card 1: Essential Background Colors --}}
            <div class="card p-5 space-y-3.5">
                <div class="flex items-center justify-between">
                    <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                        <i class="fa-solid fa-palette text-blue-600"></i>
                        <span>{{ $isBn ? 'ব্যাকগ্রাউন্ড কালার' : 'Background Color' }}</span>
                    </h3>
                    <span class="text-[10px] font-bold bg-blue-50 text-blue-700 px-2 py-0.5 rounded-full">{{ $isBn ? 'ছবিতে লাইভ' : 'Live' }}</span>
                </div>

                <div class="grid grid-cols-4 gap-2 text-xs">
                    {{-- Transparent --}}
                    <button type="button" onclick="setBackgroundColor('transparent')" id="bg-btn-transparent" class="bg-color-btn active" title="{{ $isBn ? 'স্বচ্ছ' : 'Transparent' }}">
                        <div class="w-full h-9 rounded-lg border border-gray-300 checkerboard-sm"></div>
                        <span class="text-[10px] font-bold text-gray-700 mt-1 block truncate">{{ $isBn ? 'স্বচ্ছ' : 'Clear' }}</span>
                    </button>

                    {{-- White --}}
                    <button type="button" onclick="setBackgroundColor('#ffffff')" id="bg-btn-white" class="bg-color-btn" title="{{ $isBn ? 'সাদা (চাকরি/পাসপোর্ট)' : 'White' }}">
                        <div class="w-full h-9 rounded-lg border border-gray-300 bg-white"></div>
                        <span class="text-[10px] font-bold text-gray-700 mt-1 block truncate">{{ $isBn ? 'সাদা' : 'White' }}</span>
                    </button>

                    {{-- Blue --}}
                    <button type="button" onclick="setBackgroundColor('#0284c7')" id="bg-btn-blue" class="bg-color-btn" title="{{ $isBn ? 'নীল (আইডি কার্ড)' : 'Blue' }}">
                        <div class="w-full h-9 rounded-lg border border-blue-400 bg-sky-600"></div>
                        <span class="text-[10px] font-bold text-gray-700 mt-1 block truncate">{{ $isBn ? 'নীল' : 'Blue' }}</span>
                    </button>

                    {{-- Custom Color Picker --}}
                    <label class="bg-color-btn cursor-pointer" title="{{ $isBn ? 'কাস্টম রঙ' : 'Pick Color' }}">
                        <input type="color" id="custom-bg-color" value="#cbd5e1" onchange="setBackgroundColor(this.value)" class="sr-only">
                        <div id="custom-color-preview" class="w-full h-9 rounded-lg border border-gray-300 bg-slate-300 flex items-center justify-center">
                            <i class="fa-solid fa-eye-dropper text-xs text-gray-600"></i>
                        </div>
                        <span class="text-[10px] font-bold text-gray-700 mt-1 block truncate">{{ $isBn ? 'কাস্টম' : 'Custom' }}</span>
                    </label>
                </div>
            </div>

            {{-- Card 2: Essential Download Card --}}
            <div class="card p-5 space-y-4">
                <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                    <i class="fa-solid fa-download text-emerald-600"></i>
                    <span>{{ $isBn ? 'ডাউনলোড' : 'Download' }}</span>
                </h3>

                {{-- Size Selection Pills --}}
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-700 block">{{ $isBn ? 'সাইজ নির্বাচন করুন:' : 'Select Size:' }}</label>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <button type="button" onclick="setDownloadPreset('original')" id="preset-btn-original" class="preset-pill active text-left">
                            <span class="font-bold text-gray-800 block">{{ $isBn ? 'মূল সাইজ' : 'Original Size' }}</span>
                            <span class="text-[10px] text-gray-500 block truncate" id="preset-orig-dims">ফুল রেজোলিউশন</span>
                        </button>
                        <button type="button" onclick="setDownloadPreset('govt_photo')" id="preset-btn-govt" class="preset-pill text-left">
                            <span class="font-bold text-gray-800 block">{{ $isBn ? 'সরকারি চাকরি' : 'Govt Job' }}</span>
                            <span class="text-[10px] text-gray-500 block">৩০০ × ৩০০ px</span>
                        </button>
                    </div>
                </div>

                {{-- Format Toggle (PNG vs JPG) --}}
                <div class="flex items-center justify-between text-xs pt-1 border-t border-gray-100">
                    <span class="font-semibold text-gray-700">{{ $isBn ? 'ফরম্যাট:' : 'Format:' }}</span>
                    <div class="inline-flex bg-gray-100 p-0.5 rounded-lg text-xs">
                        <button type="button" onclick="setDownloadFormat('png')" id="fmt-btn-png" class="px-3 py-1 rounded-md font-bold transition-all bg-white shadow-xs text-blue-600">PNG</button>
                        <button type="button" onclick="setDownloadFormat('jpg')" id="fmt-btn-jpg" class="px-3 py-1 rounded-md font-bold transition-all text-gray-600 hover:text-gray-900">JPG</button>
                    </div>
                </div>

                {{-- Single Primary Download Button --}}
                <button type="button" onclick="executeDownload()" class="w-full btn-primary py-3.5 text-sm font-bold inline-flex items-center justify-center gap-2 shadow-lg shadow-blue-500/20">
                    <i class="fa-solid fa-download"></i>
                    <span id="download-btn-label">{{ $isBn ? 'ছবি ডাউনলোড করুন' : 'Download Photo' }}</span>
                </button>

                {{-- Minimal Signature Clean Helper (Only when needed) --}}
                <div class="pt-2 border-t border-gray-100 flex items-center justify-between text-xs">
                    <button type="button" onclick="autoSignatureClean()" class="text-gray-500 hover:text-blue-600 font-medium inline-flex items-center gap-1.5 transition-colors">
                        <i class="fa-solid fa-signature text-blue-500"></i>
                        <span>{{ $isBn ? 'স্বাক্ষরের কাগজ পরিষ্কার করুন' : 'Clean signature paper' }}</span>
                    </button>
                    <button type="button" onclick="downloadGovtJobPreset(300, 80)" class="text-blue-600 hover:underline font-semibold text-[11px]">
                        {{ $isBn ? '৩০০ × ৮০ সাইন' : '300×80 Sign' }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    @include('partials.tool-ad')
</div>

<style>
.checkerboard-sm {
    background-image: repeating-conic-gradient(#cbd5e1 0% 25%, #f8fafc 0% 50%) !important;
    background-size: 14px 14px !important;
}
.mode-pill {
    padding: 0.4rem 0.65rem;
    border-radius: 0.625rem;
    font-size: 0.75rem;
    font-weight: 600;
    color: #475569;
    background-color: #f8fafc;
    border: 1px solid #e2e8f0;
    transition: all 0.15s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    cursor: pointer;
}
.mode-pill:hover {
    background-color: #f1f5f9;
    border-color: #cbd5e1;
    color: #0f172a;
}
.mode-pill.active {
    background-color: #fff1f2;
    border-color: #f43f5e;
    color: #be123c;
    box-shadow: 0 0 0 2px rgba(244, 63, 94, 0.15);
}
.action-btn {
    padding: 0.4rem 0.65rem;
    border-radius: 0.5rem;
    font-size: 0.8rem;
    color: #475569;
    background-color: #f8fafc;
    border: 1px solid #e2e8f0;
    transition: all 0.15s ease;
    display: inline-flex;
    align-items: center;
    cursor: pointer;
}
.action-btn:hover:not(:disabled) {
    background-color: #f1f5f9;
    color: #0f172a;
    border-color: #cbd5e1;
}
.bg-color-btn {
    padding: 0.35rem;
    border-radius: 0.75rem;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    text-align: center;
    transition: all 0.15s ease;
    cursor: pointer;
}
.bg-color-btn:hover {
    border-color: #93c5fd;
}
.bg-color-btn.active {
    border-color: #2563eb;
    background: #eff6ff;
    box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
.preset-pill {
    padding: 0.65rem 0.75rem;
    border-radius: 0.75rem;
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    transition: all 0.15s ease;
    cursor: pointer;
}
.preset-pill:hover {
    border-color: #93c5fd;
    background: #f8fafc;
}
.preset-pill.active {
    border-color: #2563eb;
    background: #eff6ff;
    box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.15);
}
</style>

{{-- MediaPipe Selfie Segmentation via CDN --}}
<script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@mediapipe/selfie_segmentation/selfie_segmentation.js" crossorigin="anonymous"></script>

@push('scripts')
<script>
let originalImage = null;
let originalFileName = 'image';
let currentMode = 'magic'; // 'magic', 'erase', 'restore'
let brushSize = 30;
let isDrawing = false;
let currentBgColor = 'transparent'; // 'transparent' or hex color

// History for Undo/Redo
const historyStack = [];
let historyIndex = -1;
const MAX_HISTORY = 12;

const isBn = @json($isBn);
const dropZone = document.getElementById('drop-zone');
const fileInput = document.getElementById('file-input');
const workspace = document.getElementById('workspace');
const btnReupload = document.getElementById('btn-reupload');
const canvasWrapper = document.getElementById('canvas-wrapper');
const mainCanvas = document.getElementById('main-canvas');
const mainCtx = mainCanvas.getContext('2d', { willReadFrequently: true });

// Hidden buffer canvases:
// origCanvas: holds the original untouched image
const origCanvas = document.createElement('canvas');
const origCtx = origCanvas.getContext('2d', { willReadFrequently: true });

// cutoutCanvas: holds the segmented subject with transparent background
const cutoutCanvas = document.createElement('canvas');
const cutoutCtx = cutoutCanvas.getContext('2d', { willReadFrequently: true });

// AI Loading elements
const aiLoadingOverlay = document.getElementById('ai-loading-overlay');
const aiProgressBar = document.getElementById('ai-progress-bar');
const aiProgressPercent = document.getElementById('ai-progress-percent');
const aiStatusTitle = document.getElementById('ai-status-title');
const aiStatusSubtitle = document.getElementById('ai-status-subtitle');

// Drop & File Listeners
dropZone.addEventListener('click', () => fileInput.click());
dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('border-rose-500', 'bg-rose-100/50'); });
dropZone.addEventListener('dragleave', () => dropZone.classList.remove('border-rose-500', 'bg-rose-100/50'));
dropZone.addEventListener('drop', e => {
    e.preventDefault();
    dropZone.classList.remove('border-rose-500', 'bg-rose-100/50');
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
        alert(isBn ? 'অনুগ্রহ করে একটি ছবি ফাইল নির্বাচন করুন।' : 'Please select an image file.');
        return;
    }

    originalFileName = file.name.substring(0, file.name.lastIndexOf('.')) || 'image';

    const reader = new FileReader();
    reader.onload = e => {
        const img = new Image();
        img.onload = () => {
            originalImage = img;
            initWorkspace(img);

            setTimeout(() => triggerAiRemoval(), 150);
        };
        img.src = e.target.result;
    };
    reader.readAsDataURL(file);
}

function initWorkspace(img) {
    dropZone.classList.add('hidden');
    workspace.classList.remove('hidden');
    btnReupload.classList.remove('hidden');

    const w = img.naturalWidth || img.width;
    const h = img.naturalHeight || img.height;

    mainCanvas.width = w;
    mainCanvas.height = h;
    origCanvas.width = w;
    origCanvas.height = h;
    cutoutCanvas.width = w;
    cutoutCanvas.height = h;

    origCtx.drawImage(img, 0, 0);
    cutoutCtx.drawImage(img, 0, 0);

    document.getElementById('res-dims-text').textContent = `${w} × ${h} px`;
    if (document.getElementById('preset-orig-dims')) {
        document.getElementById('preset-orig-dims').textContent = `${w} × ${h} px`;
    }

    // Start with transparent background
    currentBgColor = 'transparent';
    updateBgColorUI('transparent');

    // Clear history
    historyStack.length = 0;
    historyIndex = -1;
    saveState();

    renderCanvas();
    currentMode = 'none';
    mainCanvas.style.cursor = 'default';
}

/**
 * Central Canvas Renderer:
 * Renders the chosen background color directly onto mainCanvas, then draws the cutout person on top.
 * This guarantees the chosen color is physically visible on the picture in real time!
 */
function renderCanvas() {
    if (!originalImage) return;

    mainCtx.clearRect(0, 0, mainCanvas.width, mainCanvas.height);

    if (currentBgColor !== 'transparent') {
        // Draw the background color directly on the canvas behind the subject
        mainCtx.fillStyle = currentBgColor;
        mainCtx.fillRect(0, 0, mainCanvas.width, mainCanvas.height);

        // Adjust wrapper for solid background
        canvasWrapper.classList.remove('checkerboard-sm');
        canvasWrapper.style.backgroundColor = currentBgColor;
        mainCanvas.style.backgroundColor = currentBgColor;
    } else {
        // Transparent checkerboard
        canvasWrapper.classList.add('checkerboard-sm');
        canvasWrapper.style.backgroundColor = 'transparent';
        mainCanvas.style.backgroundColor = 'transparent';
    }

    // Draw the cutout subject on top
    mainCtx.drawImage(cutoutCanvas, 0, 0);
}

/**
 * MediaPipe Selfie Segmentation:
 * Specifically built to detect human faces, hair, clothes, and skin, isolating them completely from the background.
 */
let selfieSegmentationInstance = null;

function getSelfieSegmenter() {
    if (selfieSegmentationInstance) return selfieSegmentationInstance;

    if (typeof SelfieSegmentation === 'undefined') {
        return null;
    }

    try {
        selfieSegmentationInstance = new SelfieSegmentation({
            locateFile: (file) => `https://cdn.jsdelivr.net/npm/@mediapipe/selfie_segmentation/${file}`
        });

        // modelSelection: 0 is the accurate general portrait/body model (high edge detail)
        selfieSegmentationInstance.setOptions({
            modelSelection: 0,
        });

        return selfieSegmentationInstance;
    } catch (e) {
        console.warn('Failed to initialize SelfieSegmentation:', e);
        return null;
    }
}

/**
 * Deep Learning Person Segmentation:
 * Keeps face, hair, and clothes 100% untouched while removing the background.
 */
async function triggerAiRemoval() {
    if (!originalImage) return;

    aiLoadingOverlay.classList.remove('hidden');
    aiProgressBar.style.width = '20%';
    aiProgressPercent.textContent = '20%';
    aiStatusTitle.textContent = isBn ? 'এআই মানুষ ও পোশাক শনাক্ত করছে...' : 'Detecting person & clothes...';
    aiStatusSubtitle.textContent = isBn ? 'মুখ, চুল ও জামাকাপড় অক্ষত রেখে পেছনের ব্যাকগ্রাউন্ড মুছে ফেলা হচ্ছে...' : 'Preserving face, clothes & hair intact...';

    try {
        let segmenter = getSelfieSegmenter();

        // If MediaPipe script is still downloading, wait up to 6 seconds
        let waitCount = 0;
        while (!segmenter && waitCount < 30) {
            await new Promise(r => setTimeout(r, 200));
            segmenter = getSelfieSegmenter();
            waitCount++;
            aiProgressBar.style.width = `${Math.min(60, 20 + waitCount * 1.5)}%`;
            aiProgressPercent.textContent = `${Math.round(Math.min(60, 20 + waitCount * 1.5))}%`;
        }

        if (segmenter) {
            aiProgressBar.style.width = '75%';
            aiProgressPercent.textContent = '75%';

            const results = await new Promise((resolve, reject) => {
                const timer = setTimeout(() => reject(new Error('Segmentation timeout')), 15000);
                segmenter.onResults(res => {
                    clearTimeout(timer);
                    resolve(res);
                });
                segmenter.send({ image: origCanvas }).catch(err => {
                    clearTimeout(timer);
                    reject(err);
                });
            });

            if (results && results.segmentationMask) {
                applyMediaPipeMask(results.segmentationMask);
                aiProgressBar.style.width = '100%';
                aiProgressPercent.textContent = '100%';
                document.getElementById('canvas-hint-text').textContent = isBn ? 'মুখ ও পোশাক অক্ষত রেখে ব্যাকগ্রাউন্ড নিখুঁতভাবে রিমুভ করা হয়েছে!' : 'Background auto-removed preserving face & clothes!';
                saveState();
                renderCanvas();
                return;
            }
        }

        // Fallback: Smart Human Subject Contour Segmentation
        runSmartSubjectSegmentation();
        saveState();
        renderCanvas();
        document.getElementById('canvas-hint-text').textContent = isBn ? 'স্মার্ট ফিল্টার দিয়ে ব্যাকগ্রাউন্ড আলাদা করা হয়েছে' : 'Background separated with smart filter';

    } catch (err) {
        console.warn('AI segmentation fallback:', err);
        runSmartSubjectSegmentation();
        saveState();
        renderCanvas();
    } finally {
        setTimeout(() => {
            aiLoadingOverlay.classList.add('hidden');
        }, 350);
    }
}

/**
 * Applies the MediaPipe mask onto cutoutCanvas:
 * Uses source-in to keep the original image only where the person exists.
 */
function applyMediaPipeMask(maskElement) {
    const w = origCanvas.width;
    const h = origCanvas.height;

    const maskCanvas = document.createElement('canvas');
    maskCanvas.width = w;
    maskCanvas.height = h;
    const maskCtx = maskCanvas.getContext('2d');
    maskCtx.drawImage(maskElement, 0, 0, w, h);

    // MediaPipe mask may store confidence in red or alpha channel. Ensure alpha has the mask.
    const imgData = maskCtx.getImageData(0, 0, w, h);
    const m = imgData.data;
    let allAlphaOpaque = true;
    for (let i = 3; i < Math.min(m.length, 2000); i += 4) {
        if (m[i] < 240) { allAlphaOpaque = false; break; }
    }

    if (allAlphaOpaque) {
        // Red channel carries the confidence
        for (let i = 0; i < m.length; i += 4) {
            const conf = m[i]; // 0 (bg) to 255 (person)
            // Smooth thresholding: protect subject face & clothes
            if (conf > 160) {
                m[i + 3] = 255;
            } else if (conf < 40) {
                m[i + 3] = 0;
            } else {
                m[i + 3] = Math.round(((conf - 40) / 120) * 255);
            }
        }
        maskCtx.putImageData(imgData, 0, 0);
    }

    // Now composite on cutoutCanvas:
    cutoutCtx.clearRect(0, 0, w, h);
    cutoutCtx.drawImage(maskCanvas, 0, 0);
    cutoutCtx.globalCompositeOperation = 'source-in';
    cutoutCtx.drawImage(origCanvas, 0, 0);
    cutoutCtx.globalCompositeOperation = 'source-over';
}

/**
 * Intelligent Fallback Subject Segmentation:
 * Detects outer background border pixels and removes them without touching skin tones or the central person.
 */
function runSmartSubjectSegmentation() {
    const w = origCanvas.width;
    const h = origCanvas.height;
    const srcData = origCtx.getImageData(0, 0, w, h);
    const src = srcData.data;

    const outData = cutoutCtx.createImageData(w, h);
    const out = outData.data;

    // Sample border corners to determine background colors
    const bgSamples = [];
    const samplePoints = [
        [2, 2], [w - 3, 2], [2, h - 3], [w - 3, h - 3],
        [Math.floor(w / 2), 2], [2, Math.floor(h / 2)], [w - 3, Math.floor(h / 2)]
    ];

    for (const [sx, sy] of samplePoints) {
        const idx = (sy * w + sx) * 4;
        bgSamples.push([src[idx], src[idx + 1], src[idx + 2]]);
    }

    const centerX = w / 2;
    const centerY = h / 2;
    const maxRadius = Math.hypot(centerX, centerY);

    for (let y = 0; y < h; y++) {
        for (let x = 0; x < w; x++) {
            const i = (y * w + x) * 4;
            const r = src[i];
            const g = src[i + 1];
            const b = src[i + 2];
            const a = src[i + 3];

            out[i] = r;
            out[i + 1] = g;
            out[i + 2] = b;

            // Skin tone detection check (protects human face & hands)
            const isSkin = (r > 95 && g > 40 && b > 20 &&
                           (Math.max(r, g, b) - Math.min(r, g, b) > 15) &&
                           Math.abs(r - g) > 15 && r > g && r > b);

            // Center proximity (people are usually centered)
            const distFromCenter = Math.hypot(x - centerX, y - centerY) / maxRadius;

            // Distance to sampled background colors
            let minBgDist = 999;
            for (const [br, bg, bb] of bgSamples) {
                const d = Math.hypot(r - br, g - bg, b - bb);
                if (d < minBgDist) minBgDist = d;
            }

            if (isSkin && distFromCenter < 0.7) {
                // Keep skin 100% untouched
                out[i + 3] = a;
            } else if (minBgDist < 35 && distFromCenter > 0.4) {
                // Outer background matching corner color
                out[i + 3] = 0;
            } else if (minBgDist < 25) {
                out[i + 3] = 0;
            } else {
                out[i + 3] = a;
            }
        }
    }

    cutoutCtx.putImageData(outData, 0, 0);
}

/**
 * Background Color Replacement:
 * Immediately updates the picture canvas with the selected color!
 */
function setBackgroundColor(color) {
    currentBgColor = color;
    updateBgColorUI(color);
    renderCanvas();
}

function updateBgColorUI(color) {
    document.querySelectorAll('.bg-color-btn').forEach(b => b.classList.remove('active'));
    const bgText = document.getElementById('current-bg-text');

    if (color === 'transparent') {
        document.getElementById('bg-btn-transparent')?.classList.add('active');
        bgText.textContent = isBn ? 'স্বচ্ছ (Transparent)' : 'Transparent';
    } else if (color === '#ffffff') {
        document.getElementById('bg-btn-white')?.classList.add('active');
        bgText.textContent = isBn ? 'সাদা (White — সরকারি চাকরি/পাসপোর্ট)' : 'White (Govt Job/Passport)';
    } else if (color === '#0284c7') {
        document.getElementById('bg-btn-blue')?.classList.add('active');
        bgText.textContent = isBn ? 'নীল (Blue — আইডি কার্ড/লাইসেন্স)' : 'Blue (ID Card)';
    } else if (color === '#bae6fd') {
        document.getElementById('bg-btn-skyblue')?.classList.add('active');
        bgText.textContent = isBn ? 'আকাশি নীল (Sky Blue)' : 'Sky Blue';
    } else if (color === '#e2e8f0') {
        document.getElementById('bg-btn-gray')?.classList.add('active');
        bgText.textContent = isBn ? 'হালকা ধূসর (Light Gray)' : 'Light Gray';
    } else {
        const preview = document.getElementById('custom-color-preview');
        if (preview) preview.style.backgroundColor = color;
        bgText.textContent = color.toUpperCase();
    }
}

// State History (Undo / Redo) operates on cutoutCanvas
function saveState() {
    if (historyIndex < historyStack.length - 1) {
        historyStack.splice(historyIndex + 1);
    }
    historyStack.push(cutoutCtx.getImageData(0, 0, cutoutCanvas.width, cutoutCanvas.height));
    if (historyStack.length > MAX_HISTORY) {
        historyStack.shift();
    } else {
        historyIndex++;
    }
    updateHistoryButtons();
}

function undo() {
    if (historyIndex > 0) {
        historyIndex--;
        cutoutCtx.putImageData(historyStack[historyIndex], 0, 0);
        renderCanvas();
        updateHistoryButtons();
    }
}

function redo() {
    if (historyIndex < historyStack.length - 1) {
        historyIndex++;
        cutoutCtx.putImageData(historyStack[historyIndex], 0, 0);
        renderCanvas();
        updateHistoryButtons();
    }
}

function updateHistoryButtons() {
    const undoBtn = document.getElementById('btn-undo');
    if (undoBtn) undoBtn.disabled = (historyIndex <= 0);
    const redoBtn = document.getElementById('btn-redo');
    if (redoBtn) redoBtn.disabled = (historyIndex >= historyStack.length - 1);
}

function resetToOriginal() {
    if (!originalImage) return;
    cutoutCtx.drawImage(origCanvas, 0, 0);
    saveState();
    renderCanvas();
}

// Compare (Show Original on hold)
const btnOrig = document.getElementById('btn-show-original');
if (btnOrig) {
    btnOrig.addEventListener('mousedown', () => {
        if (originalImage) {
            mainCtx.clearRect(0, 0, mainCanvas.width, mainCanvas.height);
            mainCtx.drawImage(origCanvas, 0, 0);
        }
    });
    btnOrig.addEventListener('mouseup', () => renderCanvas());
    btnOrig.addEventListener('mouseleave', () => renderCanvas());
    btnOrig.addEventListener('touchstart', (e) => {
        e.preventDefault();
        if (originalImage) {
            mainCtx.clearRect(0, 0, mainCanvas.width, mainCanvas.height);
            mainCtx.drawImage(origCanvas, 0, 0);
        }
    });
    btnOrig.addEventListener('touchend', () => renderCanvas());
}

// Canvas Coordinates
function getCanvasCoords(e) {
    const rect = mainCanvas.getBoundingClientRect();
    const scaleX = mainCanvas.width / rect.width;
    const scaleY = mainCanvas.height / rect.height;
    const clientX = e.clientX ?? (e.touches && e.touches[0]?.clientX) ?? 0;
    const clientY = e.clientY ?? (e.touches && e.touches[0]?.clientY) ?? 0;
    return {
        x: Math.round((clientX - rect.left) * scaleX),
        y: Math.round((clientY - rect.top) * scaleY)
    };
}

mainCanvas.addEventListener('mousedown', e => {
    if (currentMode !== 'erase') return;
    const { x, y } = getCanvasCoords(e);
    isDrawing = true;
    applyBrush(x, y);
});

mainCanvas.addEventListener('mousemove', e => {
    if (!isDrawing || currentMode !== 'erase') return;
    const { x, y } = getCanvasCoords(e);
    applyBrush(x, y);
});

window.addEventListener('mouseup', () => {
    if (isDrawing) {
        isDrawing = false;
        saveState();
        renderCanvas();
    }
});

// Touch support
mainCanvas.addEventListener('touchstart', e => {
    if (currentMode !== 'erase') return;
    const { x, y } = getCanvasCoords(e);
    isDrawing = true;
    applyBrush(x, y);
}, { passive: false });

mainCanvas.addEventListener('touchmove', e => {
    if (!isDrawing || currentMode !== 'erase') return;
    e.preventDefault();
    const { x, y } = getCanvasCoords(e);
    applyBrush(x, y);
}, { passive: false });

mainCanvas.addEventListener('touchend', () => {
    if (isDrawing) {
        isDrawing = false;
        saveState();
        renderCanvas();
    }
});

// Brush tool (Eraser or Restore applied to cutoutCanvas)
function applyBrush(x, y) {
    const r = Math.round(brushSize / 2);
    if (currentMode === 'erase') {
        cutoutCtx.save();
        cutoutCtx.globalCompositeOperation = 'destination-out';
        cutoutCtx.beginPath();
        cutoutCtx.arc(x, y, r, 0, Math.PI * 2);
        cutoutCtx.fill();
        cutoutCtx.restore();
    } else if (currentMode === 'restore') {
        cutoutCtx.save();
        cutoutCtx.beginPath();
        cutoutCtx.arc(x, y, r, 0, Math.PI * 2);
        cutoutCtx.clip();
        cutoutCtx.drawImage(origCanvas, 0, 0);
        cutoutCtx.restore();
    }
    renderCanvas();
}

// Magic Wand / Color Distance Algorithm on cutoutCanvas
function removeColorAt(targetX, targetY) {
    const w = cutoutCanvas.width;
    const h = cutoutCanvas.height;
    if (targetX < 0 || targetX >= w || targetY < 0 || targetY >= h) return;

    const imgData = cutoutCtx.getImageData(0, 0, w, h);
    const data = imgData.data;

    const targetIdx = (targetY * w + targetX) * 4;
    const tr = data[targetIdx];
    const tg = data[targetIdx + 1];
    const tb = data[targetIdx + 2];
    const ta = data[targetIdx + 3];

    if (ta === 0) return;

    const tolerance = parseInt(document.getElementById('tolerance-slider')?.value) || 25;

    function colorMatch(idx) {
        const r = data[idx];
        const g = data[idx + 1];
        const b = data[idx + 2];
        const a = data[idx + 3];
        if (a === 0) return false;
        const dist = Math.hypot(r - tr, g - tg, b - tb);
        return dist <= (tolerance * 2.5);
    }

    const visited = new Uint8Array(w * h);
    const queue = [targetX + targetY * w];
    visited[targetX + targetY * w] = 1;

    while (queue.length > 0) {
        const pos = queue.pop();
        const px = pos % w;
        const py = Math.floor(pos / w);
        const idx = pos * 4;

        data[idx + 3] = 0;

        const neighbors = [
            px > 0 ? pos - 1 : -1,
            px < w - 1 ? pos + 1 : -1,
            py > 0 ? pos - w : -1,
            py < h - 1 ? pos + w : -1
        ];

        for (const n of neighbors) {
            if (n !== -1 && !visited[n] && colorMatch(n * 4)) {
                visited[n] = 1;
                queue.push(n);
            }
        }
    }

    cutoutCtx.putImageData(imgData, 0, 0);
    saveState();
    renderCanvas();
}

// Signature Paper Cleaner with Adaptive Otsu Thresholding & Ink Contrast Boost
function autoSignatureClean() {
    const w = cutoutCanvas.width;
    const h = cutoutCanvas.height;
    const imgData = origCtx.getImageData(0, 0, w, h);
    const data = imgData.data;
    const totalPixels = w * h;

    // 1. Build luminance histogram
    const histogram = new Int32Array(256);
    for (let i = 0; i < data.length; i += 4) {
        const lum = Math.round(0.299 * data[i] + 0.587 * data[i + 1] + 0.114 * data[i + 2]);
        histogram[lum]++;
    }

    // 2. Otsu's bimodal threshold calculation (finds exact boundary between paper and ink)
    let sum = 0;
    for (let t = 0; t < 256; t++) sum += t * histogram[t];

    let sumB = 0;
    let wB = 0;
    let wF = 0;
    let varMax = 0;
    let optimalT = 175;

    for (let t = 0; t < 256; t++) {
        wB += histogram[t];
        if (wB === 0) continue;
        wF = totalPixels - wB;
        if (wF === 0) break;

        sumB += t * histogram[t];
        const mB = sumB / wB;
        const mF = (sum - sumB) / wF;
        const varBetween = wB * wF * (mB - mF) * (mB - mF);

        if (varBetween > varMax) {
            varMax = varBetween;
            optimalT = t;
        }
    }

    // Adapt threshold slightly to ensure all background paper haze is removed
    const threshold = Math.max(140, Math.min(225, optimalT + 12));

    for (let i = 0; i < data.length; i += 4) {
        const r = data[i];
        const g = data[i + 1];
        const b = data[i + 2];
        const lum = 0.299 * r + 0.587 * g + 0.114 * b;

        if (lum >= threshold) {
            // Paper background: 100% transparent
            data[i + 3] = 0;
        } else {
            // Ink: smooth anti-aliased edge + boosted contrast
            const ratio = (threshold - lum) / threshold;
            const alpha = Math.min(255, Math.round(ratio * 340));
            data[i + 3] = alpha;

            // Deepen ink color (crisp black/blue)
            data[i] = Math.max(0, r - 35);
            data[i + 1] = Math.max(0, g - 35);
            data[i + 2] = Math.max(0, b - 35);
        }
    }

    cutoutCtx.putImageData(imgData, 0, 0);
    saveState();
    renderCanvas();

    document.getElementById('canvas-hint-text').textContent = isBn ? 'স্বাক্ষরের পেছনের কাগজ ও ছায়া সফলভাবে পরিষ্কার করা হয়েছে!' : 'Signature paper background cleaned successfully!';
}

// Export & Download
function downloadImage(format) {
    if (!originalImage) return;

    const exportCanvas = document.createElement('canvas');
    exportCanvas.width = mainCanvas.width;
    exportCanvas.height = mainCanvas.height;
    const expCtx = exportCanvas.getContext('2d');

    // Fill background color if selected
    if (currentBgColor !== 'transparent') {
        expCtx.fillStyle = currentBgColor;
        expCtx.fillRect(0, 0, exportCanvas.width, exportCanvas.height);
    } else if (format === 'jpg') {
        expCtx.fillStyle = '#ffffff';
        expCtx.fillRect(0, 0, exportCanvas.width, exportCanvas.height);
    }

    // Draw cutout image on top
    expCtx.drawImage(cutoutCanvas, 0, 0);

    const mime = (format === 'png' && currentBgColor === 'transparent') ? 'image/png' : 'image/jpeg';
    const ext = format === 'png' ? 'png' : 'jpg';

    exportCanvas.toBlob(blob => {
        if (!blob) return;
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `${originalFileName}_nobg.${ext}`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        setTimeout(() => URL.revokeObjectURL(url), 2000);
    }, mime, 0.96);
}

// Download Govt Job Preset (300 x 300 px)
function downloadGovtJobPreset(targetWidth, targetHeight) {
    if (!originalImage) return;

    const presetCanvas = document.createElement('canvas');
    presetCanvas.width = targetWidth;
    presetCanvas.height = targetHeight;
    const pCtx = presetCanvas.getContext('2d');

    // Fill chosen color or default to white
    pCtx.fillStyle = currentBgColor !== 'transparent' ? currentBgColor : '#ffffff';
    pCtx.fillRect(0, 0, targetWidth, targetHeight);

    // Draw scaled cutout centered
    pCtx.drawImage(cutoutCanvas, 0, 0, targetWidth, targetHeight);

    presetCanvas.toBlob(blob => {
        if (!blob) return;
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        setTimeout(() => URL.revokeObjectURL(url), 2000);
    }, 'image/jpeg', 0.96);
}

// Download Preset & Format Selection
let currentDownloadPreset = 'original'; // 'original' or 'govt_photo'
let currentDownloadFormat = 'png'; // 'png' or 'jpg'

function setDownloadPreset(preset) {
    currentDownloadPreset = preset;
    document.getElementById('preset-btn-original')?.classList.toggle('active', preset === 'original');
    document.getElementById('preset-btn-govt')?.classList.toggle('active', preset === 'govt_photo');

    const label = document.getElementById('download-btn-label');
    if (preset === 'govt_photo') {
        label.textContent = isBn ? '৩০০ × ৩০০ px ছবি ডাউনলোড' : 'Download 300 × 300 px Photo';
    } else {
        label.textContent = isBn ? 'ছবি ডাউনলোড করুন' : 'Download Photo';
    }
}

function setDownloadFormat(fmt) {
    currentDownloadFormat = fmt;
    const btnPng = document.getElementById('fmt-btn-png');
    const btnJpg = document.getElementById('fmt-btn-jpg');

    if (fmt === 'png') {
        btnPng.className = 'px-3 py-1 rounded-md font-bold transition-all bg-white shadow-xs text-blue-600';
        btnJpg.className = 'px-3 py-1 rounded-md font-bold transition-all text-gray-600 hover:text-gray-900';
    } else {
        btnJpg.className = 'px-3 py-1 rounded-md font-bold transition-all bg-white shadow-xs text-blue-600';
        btnPng.className = 'px-3 py-1 rounded-md font-bold transition-all text-gray-600 hover:text-gray-900';
    }
}

function executeDownload() {
    if (currentDownloadPreset === 'govt_photo') {
        downloadGovtJobPreset(300, 300);
    } else {
        downloadImage(currentDownloadFormat);
    }
}

let isEraserActive = false;
function toggleEraserMode() {
    isEraserActive = !isEraserActive;
    const btn = document.getElementById('btn-toggle-erase');
    if (isEraserActive) {
        currentMode = 'erase';
        btn.classList.add('bg-orange-50', 'text-orange-700', 'border-orange-300');
        mainCanvas.style.cursor = 'crosshair';
        document.getElementById('canvas-hint-text').textContent = isBn ? 'মাউস টেনে বাড়তি দাগ মুছে ফেলুন' : 'Click & drag to erase';
    } else {
        currentMode = 'none';
        btn.classList.remove('bg-orange-50', 'text-orange-700', 'border-orange-300');
        mainCanvas.style.cursor = 'default';
        document.getElementById('canvas-hint-text').textContent = isBn ? 'ব্যাকগ্রাউন্ড এআই দিয়ে স্বয়ংক্রিয়ভাবে আলাদা করা হয়েছে' : 'Background auto-removed by AI';
    }
}
</script>
@endpush
@endsection
