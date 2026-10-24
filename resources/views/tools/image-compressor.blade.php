@extends('layouts.app')

@php
    $isBn = app()->getLocale() === 'bn';
@endphp

@section('page_title', ($isBn ? 'অনলাইন ছবির সাইজ কমান — কোয়ালিটি না কমিয়ে Image Compress' : 'Online Image Compressor — Reduce Image Size in KB') . ' — ' . __('ui.site_name'))
@section('seo_description', $isBn
    ? 'ছবির কোয়ালিটি অক্ষত রেখে ফাইলের সাইজ KB-তে কমান। কোনো আপলোড ছাড়াই সরাসরি ব্রাউজারে JPG, PNG ও WebP ছবি কম্প্রেস করুন।'
    : 'Compress images directly in your browser without quality loss. Reduce JPG, PNG, and WebP file size in KB 100% free with instant preview.')

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "WebApplication",
    "name": "{{ $isBn ? 'অনলাইন ইমেজ কম্প্রেসার' : 'Online Image Compressor' }}",
    "description": "{{ $isBn ? 'ব্রাউজারেই ছবির সাইজ কমানোর ফ্রি টুল।' : 'Free online tool to compress image file size without losing visual quality.' }}",
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
@endsection

@section('content')
@php $isBn = app()->getLocale() === 'bn'; @endphp
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    @include('partials.tool-back')
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-compress text-blue-600 text-lg"></i>
            </div>
            <h1 class="text-2xl font-extrabold text-gray-900">
                {{ $isBn ? 'ইমেজ কম্প্রেসার' : 'Image Compressor' }}
            </h1>
        </div>
        <p class="text-gray-500 text-sm ml-13">{{ $isBn ? 'ব্রাউজারেই ছবির সাইজ কমান। কোনো সার্ভারে আপলোড হয় না।' : 'Compress images in your browser. Nothing is uploaded to any server.' }}</p>
    </div>

    {{-- Drop zone --}}
    <div id="drop-zone" class="card border-2 border-dashed border-blue-200 p-12 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-all mb-6">
        <i class="fa-solid fa-cloud-arrow-up text-blue-400 text-4xl mb-3"></i>
        <p class="font-semibold text-gray-700 mb-1">{{ $isBn ? 'ছবি টেনে আনুন অথবা ক্লিক করুন' : 'Drag & drop an image or click to select' }}</p>
        <p class="text-xs text-gray-400">JPG, PNG, WebP, GIF — {{ $isBn ? 'সর্বোচ্চ ২০ MB' : 'max 20 MB' }}</p>
        <input type="file" id="file-input" accept="image/*" class="hidden">
    </div>

    {{-- Quality slider --}}
    <div class="card p-5 mb-6 hidden" id="controls">
        <label class="block text-sm font-semibold text-gray-700 mb-3">
            {{ $isBn ? 'মান (Quality):' : 'Quality:' }}
            <span id="quality-val" class="text-blue-600 font-bold">80%</span>
        </label>
        <input type="range" id="quality" min="10" max="100" value="80" class="w-full accent-blue-600">

        <div class="grid grid-cols-2 gap-4 mt-4 text-sm">
            <div class="bg-gray-50 rounded-lg p-3">
                <p class="text-gray-500 text-xs mb-1">{{ $isBn ? 'মূল সাইজ' : 'Original size' }}</p>
                <p id="orig-size" class="font-bold text-gray-900">—</p>
            </div>
            <div class="bg-green-50 rounded-lg p-3">
                <p class="text-gray-500 text-xs mb-1">{{ $isBn ? 'কম্প্রেসড সাইজ' : 'Compressed size' }}</p>
                <p id="comp-size" class="font-bold text-emerald-600">—</p>
            </div>
        </div>

        <div class="mt-4 flex flex-col sm:flex-row gap-3 items-start">
            <div class="flex-1">
                <img id="preview" class="rounded-xl max-h-64 object-contain border border-gray-100 w-full hidden" alt="Preview">
            </div>
        </div>

        <button id="download-btn" class="btn-primary mt-4 w-full hidden">
            <i class="fa-solid fa-download mr-2"></i>
            {{ $isBn ? 'কম্প্রেসড ছবি ডাউনলোড করুন' : 'Download Compressed Image' }}
        </button>
    </div>

    <canvas id="canvas" class="hidden"></canvas>

    @include('partials.tool-ad')
</div>

@push('scripts')
<script>
const dropZone   = document.getElementById('drop-zone');
const fileInput  = document.getElementById('file-input');
const controls   = document.getElementById('controls');
const qualSlider = document.getElementById('quality');
const qualVal    = document.getElementById('quality-val');
const origSize   = document.getElementById('orig-size');
const compSize   = document.getElementById('comp-size');
const preview    = document.getElementById('preview');
const canvas     = document.getElementById('canvas');
const dlBtn      = document.getElementById('download-btn');

let currentFile = null;
let currentImg  = null;
const ctx       = canvas.getContext('2d');

function fmtSize(bytes) {
    if (bytes < 1024) return bytes + ' B';
    if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
    return (bytes / (1024 * 1024)).toFixed(2) + ' MB';
}

function compress() {
    if (!currentImg) return;
    const quality = qualSlider.value / 100;
    canvas.width  = currentImg.naturalWidth;
    canvas.height = currentImg.naturalHeight;
    ctx.drawImage(currentImg, 0, 0);

    canvas.toBlob(blob => {
        const url = URL.createObjectURL(blob);
        preview.src = url;
        preview.classList.remove('hidden');
        compSize.textContent = fmtSize(blob.size);

        dlBtn.classList.remove('hidden');
        dlBtn.onclick = () => {
            const a = document.createElement('a');
            a.href = url;
            a.download = 'compressed_' + (currentFile?.name ?? 'image.jpg');
            a.click();
        };
    }, 'image/jpeg', quality);
}

function loadFile(file) {
    if (!file || !file.type.startsWith('image/')) return;
    currentFile = file;
    origSize.textContent = fmtSize(file.size);
    const reader = new FileReader();
    reader.onload = e => {
        const img = new Image();
        img.onload = () => { currentImg = img; controls.classList.remove('hidden'); compress(); };
        img.src = e.target.result;
    };
    reader.readAsDataURL(file);
}

dropZone.addEventListener('click', () => fileInput.click());
dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('border-blue-500'); });
dropZone.addEventListener('dragleave', () => dropZone.classList.remove('border-blue-500'));
dropZone.addEventListener('drop', e => { e.preventDefault(); loadFile(e.dataTransfer.files[0]); });
fileInput.addEventListener('change', e => loadFile(e.target.files[0]));
qualSlider.addEventListener('input', () => { qualVal.textContent = qualSlider.value + '%'; compress(); });
</script>
@endpush
@endsection
