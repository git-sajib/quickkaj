@extends('layouts.app')

@php
    $isBn = app()->getLocale() === 'bn';
@endphp

@section('page_title', ($isBn ? 'BMI ক্যালকুলেটর — বডি মাস ইনডেক্স ও আদর্শ ওজন নির্ণয়' : 'BMI Calculator — Body Mass Index & Ideal Weight') . ' — ' . __('ui.site_name'))
@section('seo_description', $isBn
    ? 'ফ্রি অনলাইন BMI ক্যালকুলেটর। আপনার উচ্চতা ও ওজন দিয়ে সহজে বডি মাস ইনডেক্স ও আদর্শ স্বাস্থ্য ক্যাটাগরি জানুন।'
    : 'Calculate your Body Mass Index (BMI) instantly. Find out if you are underweight, normal weight, or overweight with personalized healthy weight tips.')

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "WebApplication",
    "name": "{{ $isBn ? 'অনলাইন BMI ক্যালকুলেটর' : 'Online BMI Calculator' }}",
    "description": "{{ $isBn ? 'বডি মাস ইনডেক্স ও স্বাস্থ্য ঝুঁকি যাচাইয়ের অনলাইন ক্যালকুলেটর।' : 'Free online body mass index calculator and health category evaluator.' }}",
    "url": "{{ url()->current() }}",
    "applicationCategory": "HealthApplication",
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
<div class="max-w-xl mx-auto px-4 sm:px-6 py-10">
    @include('partials.tool-back')
    <div class="mb-8 flex items-center gap-3">
        <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
            <i class="fa-solid fa-weight-scale text-emerald-600 text-lg"></i>
        </div>
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">{{ $isBn ? 'BMI ক্যালকুলেটর' : 'BMI Calculator' }}</h1>
            <p class="text-gray-500 text-sm">{{ $isBn ? 'বডি মাস ইন্ডেক্স হিসাব করুন।' : 'Calculate your Body Mass Index.' }}</p>
        </div>
    </div>
    <div class="card p-6 space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">{{ $isBn ? 'উচ্চতা (cm)' : 'Height (cm)' }}</label>
                <input type="number" id="h" min="50" max="300" placeholder="170" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-400 focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">{{ $isBn ? 'ওজন (kg)' : 'Weight (kg)' }}</label>
                <input type="number" id="w" min="10" max="500" placeholder="60" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-400 focus:outline-none">
            </div>
        </div>
        <button onclick="calc()" class="btn-primary w-full">
            <i class="fa-solid fa-calculator mr-2"></i>{{ $isBn ? 'হিসাব করুন' : 'Calculate BMI' }}
        </button>

        <div id="res" class="hidden rounded-2xl p-6 text-center border">
            <p class="text-5xl font-extrabold mb-2" id="bmi-val">—</p>
            <p class="font-bold text-lg mb-1" id="bmi-cat">—</p>
            <p class="text-sm text-gray-500" id="bmi-tip">—</p>
        </div>

        {{-- BMI scale --}}
        <div class="mt-4 text-xs">
            <div class="flex rounded-lg overflow-hidden h-4 mb-1">
                <div class="flex-1 bg-blue-300"></div>
                <div class="flex-1 bg-emerald-400"></div>
                <div class="flex-1 bg-yellow-400"></div>
                <div class="flex-1 bg-red-400"></div>
            </div>
            <div class="flex text-gray-400">
                <span class="flex-1">{{ $isBn ? 'কম ওজন' : 'Underweight' }} &lt;18.5</span>
                <span class="flex-1 text-center">{{ $isBn ? 'স্বাভাবিক' : 'Normal' }} 18.5–25</span>
                <span class="flex-1 text-center">{{ $isBn ? 'বেশি' : 'Overweight' }} 25–30</span>
                <span class="flex-1 text-right">{{ $isBn ? 'স্থূলকায়' : 'Obese' }} &gt;30</span>
            </div>
        </div>
    </div>

    @include('partials.tool-ad')
</div>
@push('scripts')
<script>
const isBn = document.documentElement.lang === 'bn';
function calc(){
    const h = parseFloat(document.getElementById('h').value) / 100;
    const w = parseFloat(document.getElementById('w').value);
    if(!h||!w||h<=0) return;
    const bmi = (w / (h * h)).toFixed(1);
    let cat, tip, cls;
    if(bmi < 18.5){ cat=isBn?'কম ওজন':'Underweight'; tip=isBn?'ওজন বাড়ানো দরকার।':'Consider gaining weight.'; cls='text-blue-600 bg-blue-50 border-blue-100'; }
    else if(bmi < 25){ cat=isBn?'স্বাভাবিক':'Normal'; tip=isBn?'আপনি সুস্বাস্থ্যে আছেন।':'You have a healthy weight.'; cls='text-emerald-600 bg-emerald-50 border-emerald-100'; }
    else if(bmi < 30){ cat=isBn?'অতিরিক্ত ওজন':'Overweight'; tip=isBn?'খাদ্যাভ্যাস ও ব্যায়ামে মনোযোগ দিন।':'Focus on diet and exercise.'; cls='text-yellow-700 bg-yellow-50 border-yellow-100'; }
    else{ cat=isBn?'স্থূলকায়':'Obese'; tip=isBn?'একজন চিকিৎসকের পরামর্শ নিন।':'Consult a doctor.'; cls='text-red-600 bg-red-50 border-red-100'; }
    const res = document.getElementById('res');
    res.className = `rounded-2xl p-6 text-center border ${cls}`;
    document.getElementById('bmi-val').textContent = bmi;
    document.getElementById('bmi-cat').textContent = cat;
    document.getElementById('bmi-tip').textContent = tip;
    res.classList.remove('hidden');
}
</script>
@endpush
@endsection
