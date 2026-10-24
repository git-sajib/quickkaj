@extends('layouts.app')

@php
    $isBn = app()->getLocale() === 'bn';
@endphp

@section('page_title', ($isBn ? 'সঠিক বয়স ক্যালকুলেটর — চাকরির বয়স হিসাব ও দিন-মাস গণনা' : 'Exact Age Calculator — Years, Months & Days') . ' — ' . __('ui.site_name'))
@section('seo_description', $isBn
    ? 'অনলাইন বয়স ক্যালকুলেটর। জন্মতারিখ দিয়ে বছর, মাস ও দিনে নিখুঁত বয়স বের করুন। সরকারি ও বেসরকারি চাকরির বয়সসীমা যাচাইয়ের সহজ উপায়।'
    : 'Free online age calculator. Calculate your exact age in years, months, and days from your date of birth instantly.')

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "WebApplication",
    "name": "{{ $isBn ? 'অনলাইন বয়স ক্যালকুলেটর' : 'Online Age Calculator' }}",
    "description": "{{ $isBn ? 'জন্মতারিখ থেকে বছর, মাস ও দিন হিসাবের ফ্রি টুল।' : 'Calculate exact age in years, months, and days online.' }}",
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
@endsection

@section('content')
<div class="max-w-xl mx-auto px-4 sm:px-6 py-10">
    @include('partials.tool-back')
    <div class="mb-8 flex items-center gap-3">
        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
            <i class="fa-solid fa-cake-candles text-blue-600 text-lg"></i>
        </div>
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">{{ $isBn ? 'বয়স ক্যালকুলেটর' : 'Age Calculator' }}</h1>
            <p class="text-gray-500 text-sm">{{ $isBn ? 'জন্মতারিখ দিন, সঠিক বয়স জানুন।' : 'Enter your date of birth to calculate your exact age.' }}</p>
        </div>
    </div>

    <div class="card p-6 space-y-5">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">{{ $isBn ? 'জন্মতারিখ' : 'Date of Birth' }}</label>
            <input type="date" id="dob" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">{{ $isBn ? 'তারিখ অনুযায়ী' : 'As of date' }}</label>
            <input type="date" id="ref" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
        </div>
        <button onclick="calc()" class="btn-primary w-full">
            <i class="fa-solid fa-calculator mr-2"></i>{{ $isBn ? 'হিসাব করুন' : 'Calculate' }}
        </button>

        <div id="result" class="hidden bg-gradient-to-br from-blue-50 to-violet-50 rounded-2xl p-6 text-center border border-blue-100">
            <p class="text-4xl font-extrabold text-blue-700 mb-1" id="years">0</p>
            <p class="text-gray-500 text-sm" id="detail">—</p>
        </div>
    </div>

    @include('partials.tool-ad')
</div>
@push('scripts')
<script>
document.getElementById('ref').valueAsDate = new Date();
function calc(){
    const dob = new Date(document.getElementById('dob').value);
    const ref = new Date(document.getElementById('ref').value || new Date());
    if(isNaN(dob) || dob > ref) return;
    let y = ref.getFullYear() - dob.getFullYear();
    let m = ref.getMonth() - dob.getMonth();
    let d = ref.getDate() - dob.getDate();
    if(d < 0){ m--; d += new Date(ref.getFullYear(), ref.getMonth(), 0).getDate(); }
    if(m < 0){ y--; m += 12; }
    const totalDays = Math.floor((ref - dob) / 86400000);
    const isBn = document.documentElement.lang === 'bn';
    document.getElementById('years').textContent = y + (isBn ? ' বছর' : ' years');
    document.getElementById('detail').textContent =
        (isBn ? `${m} মাস, ${d} দিন • মোট ${totalDays.toLocaleString()} দিন` : `${m} months, ${d} days • Total ${totalDays.toLocaleString()} days`);
    document.getElementById('result').classList.remove('hidden');
}
</script>
@endpush
@endsection
