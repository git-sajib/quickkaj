@extends('layouts.app')

@php
    $isBn = app()->getLocale() === 'bn';
@endphp

@section('page_title', ($isBn ? 'অনলাইন ছবি কনভার্টার — JPG, PNG, WebP রূপান্তর' : 'Online Image Converter — Convert JPG, PNG, WebP Free') . ' — ' . __('ui.site_name'))
@section('seo_description', $isBn
    ? 'ফ্রি অনলাইন ইমেজ ফরম্যাট কনভার্টার। কোনো সফটওয়্যার বা আপলোড ছাড়াই ব্রাউজারে JPG থেকে PNG, PNG থেকে JPG, এবং WebP ফরম্যাটে রূপান্তর করুন।'
    : 'Convert images between JPG, PNG, and WebP formats 100% free directly in your browser. Fast client-side conversion without uploading files.')

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "WebApplication",
    "name": "{{ $isBn ? 'অনলাইন ছবি কনভার্টার' : 'Online Image Converter' }}",
    "description": "{{ $isBn ? 'JPG, PNG, WebP ছবি রূপান্তরের ফ্রি ব্রাউজার টুল।' : 'Free browser tool to convert images between JPG, PNG, and WebP.' }}",
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
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    @include('partials.tool-back')
    <div class="mb-8 flex items-center gap-3">
        <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
            <i class="fa-solid fa-arrows-rotate text-emerald-600 text-lg"></i>
        </div>
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">{{ $isBn ? 'ইমেজ ফরম্যাট কনভার্টার' : 'Image Format Converter' }}</h1>
            <p class="text-gray-500 text-sm">{{ $isBn ? 'JPG, PNG, WebP — যেকোনো ফরম্যাটে কনভার্ট করুন।' : 'Convert images between JPG, PNG, WebP and more.' }}</p>
        </div>
    </div>

    <div id="drop-zone" class="card border-2 border-dashed border-emerald-200 p-12 text-center cursor-pointer hover:border-emerald-400 transition-all mb-6">
        <i class="fa-solid fa-image text-emerald-400 text-4xl mb-3"></i>
        <p class="font-semibold text-gray-700">{{ $isBn ? 'ছবি টেনে আনুন বা ক্লিক করুন' : 'Drag & drop or click to select' }}</p>
        <input type="file" id="fi" accept="image/*" class="hidden">
    </div>

    <div id="controls" class="card p-6 hidden">
        <label class="block text-sm font-semibold text-gray-700 mb-3">{{ $isBn ? 'আউটপুট ফরম্যাট' : 'Output Format' }}</label>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-5">
            @foreach(['image/jpeg' => 'JPG', 'image/png' => 'PNG', 'image/webp' => 'WebP', 'image/gif' => 'GIF'] as $mime => $label)
            <label class="flex items-center justify-center gap-2 border rounded-xl py-3 cursor-pointer hover:border-emerald-500 has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50 transition-colors">
                <input type="radio" name="fmt" value="{{ $mime }}" class="hidden" {{ $mime === 'image/jpeg' ? 'checked' : '' }}>
                <span class="font-bold text-sm">{{ $label }}</span>
            </label>
            @endforeach
        </div>

        <label class="block text-xs font-semibold text-gray-500 mb-1">{{ $isBn ? 'মান (JPG/WebP)' : 'Quality (JPG/WebP)' }}: <span id="qv">90%</span></label>
        <input type="range" id="q" min="10" max="100" value="90" class="w-full accent-emerald-600 mb-5">

        <img id="prev" class="rounded-xl max-h-56 object-contain border border-gray-100 w-full hidden mb-4" alt="">
        <button id="dl" class="btn-primary w-full hidden">
            <i class="fa-solid fa-download mr-2"></i>{{ $isBn ? 'কনভার্টেড ছবি ডাউনলোড করুন' : 'Download Converted Image' }}
        </button>
    </div>
    <canvas id="cnv" class="hidden"></canvas>

    @include('partials.tool-ad')
</div>
@push('scripts')
<script>
const drop=document.getElementById('drop-zone'),fi=document.getElementById('fi'),ctrl=document.getElementById('controls');
const prev=document.getElementById('prev'),cnv=document.getElementById('cnv'),dl=document.getElementById('dl');
const qSlider=document.getElementById('q'),qv=document.getElementById('qv');
const ctx=cnv.getContext('2d');
let img=null,fname='converted';

function convert(){
    if(!img)return;
    const fmt=document.querySelector('input[name=fmt]:checked')?.value||'image/jpeg';
    const q=parseInt(qSlider.value)/100;
    cnv.width=img.naturalWidth; cnv.height=img.naturalHeight;
    ctx.drawImage(img,0,0);
    cnv.toBlob(blob=>{
        const url=URL.createObjectURL(blob);
        prev.src=url; prev.classList.remove('hidden');
        const ext=fmt.split('/')[1].replace('jpeg','jpg');
        dl.classList.remove('hidden');
        dl.onclick=()=>{const a=document.createElement('a');a.href=url;a.download=fname+'.'+ext;a.click();};
    },fmt,q);
}
function load(file){
    if(!file?.type.startsWith('image/'))return;
    fname=file.name.replace(/\.[^.]+$/,'');
    const r=new FileReader();
    r.onload=e=>{img=new Image();img.onload=()=>{ctrl.classList.remove('hidden');convert();};img.src=e.target.result;};
    r.readAsDataURL(file);
}
drop.addEventListener('click',()=>fi.click());
drop.addEventListener('dragover',e=>e.preventDefault());
drop.addEventListener('drop',e=>{e.preventDefault();load(e.dataTransfer.files[0]);});
fi.addEventListener('change',e=>load(e.target.files[0]));
document.querySelectorAll('input[name=fmt]').forEach(r=>r.addEventListener('change',convert));
qSlider.addEventListener('input',()=>{qv.textContent=qSlider.value+'%';convert();});
</script>
@endpush
@endsection
