@extends('layouts.app')

@php
    $isBn = app()->getLocale() === 'bn';
@endphp

@section('page_title', ($isBn ? 'বেতন ও আয়কর ক্যালকুলেটর — বাংলাদেশে মাসিক বেতন ও ট্যাক্স হিসাব' : 'Salary & Tax Calculator Bangladesh — Monthly & Annual Salary') . ' — ' . __('ui.site_name'))
@section('seo_description', $isBn
    ? 'বাংলাদেশে মাসিক গ্রস বেতন থেকে বেসিক, বাড়িভাড়া ও বার্ষিক আয়কর বাদ দিয়ে নেট ইন-হ্যান্ড বেতন হিসাবের ফ্রি অনলাইন ক্যালকুলেটর।'
    : 'Calculate monthly and annual net in-hand salary, basic pay, allowances, and estimated Bangladesh income tax breakdown online.')

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "WebApplication",
    "name": "{{ $isBn ? 'অনলাইন বেতন ক্যালকুলেটর' : 'Online Salary & Tax Calculator' }}",
    "description": "{{ $isBn ? 'বাংলাদেশে ইন-হ্যান্ড বেতন ও আয়কর হিসাবের ক্যালকুলেটর।' : 'Calculate net salary and income tax breakdown in Bangladesh.' }}",
    "url": "{{ url()->current() }}",
    "applicationCategory": "FinanceApplication",
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
        <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
            <i class="fa-solid fa-bangladeshi-taka-sign text-orange-600 text-lg"></i>
        </div>
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">{{ $isBn ? 'বেতন ক্যালকুলেটর' : 'Salary Calculator' }}</h1>
            <p class="text-gray-500 text-sm">{{ $isBn ? 'মাসিক/বার্ষিক বেতন ও করযোগ্য আয় হিসাব করুন।' : 'Calculate monthly/annual salary and estimated tax for Bangladesh.' }}</p>
        </div>
    </div>

    <div class="card p-6 space-y-4">
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1">{{ $isBn ? 'মোট মাসিক বেতন (৳)' : 'Gross Monthly Salary (৳)' }}</label>
            <input type="number" id="gross" min="0" placeholder="50000" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-orange-400 focus:outline-none">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">{{ $isBn ? 'বাড়ি ভাড়া (%)' : 'House Rent (%)' }}</label>
                <input type="number" id="hr" value="50" min="0" max="100" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-orange-400 focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">{{ $isBn ? 'যাতায়াত ভাতা (৳)' : 'Transport Allowance (৳)' }}</label>
                <input type="number" id="ta" value="5000" min="0" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-orange-400 focus:outline-none">
            </div>
        </div>

        <button onclick="calc()" class="btn-primary w-full">
            <i class="fa-solid fa-calculator mr-2"></i>{{ $isBn ? 'হিসাব করুন' : 'Calculate' }}
        </button>

        <div id="res" class="hidden space-y-3">
            @foreach([['gross-m','মোট মাসিক বেতন','Gross Monthly','gray'],['basic-m','মূল বেতন','Basic','blue'],['hr-m','বাড়ি ভাড়া','House Rent','blue'],['ta-m','যাতায়াত ভাতা','Transport','blue'],['annual','বার্ষিক বেতন','Annual Salary','violet'],['tax-m','আনুমানিক কর/মাস','Est. Tax/Month','red'],['net-m','নেট মাসিক বেতন','Net Monthly','emerald']] as [$id,$bn,$en,$color])
            <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-0">
                <span class="text-sm text-gray-600">{{ $isBn ? $bn : $en }}</span>
                <span class="font-bold text-{{ $color }}-700" id="{{ $id }}">৳—</span>
            </div>
            @endforeach
        </div>
    </div>

    <p class="text-xs text-gray-400 mt-4 text-center">
        <i class="fa-solid fa-circle-info mr-1"></i>
        {{ $isBn ? '* এটি একটি আনুমানিক হিসাব। সঠিক কর জানতে NBR বা CA-এর সাথে যোগাযোগ করুন।' : '* Estimated figures only. Consult NBR or a CA for accurate tax calculation.' }}
    </p>

    @include('partials.tool-ad')
</div>
@push('scripts')
<script>
const isBn = document.documentElement.lang === 'bn';
const fmt = n => '৳' + Math.round(n).toLocaleString('en');
function calc(){
    const gross = parseFloat(document.getElementById('gross').value)||0;
    const hrPct = parseFloat(document.getElementById('hr').value)||50;
    const ta    = parseFloat(document.getElementById('ta').value)||0;

    const basic   = gross * 0.50;
    const hr      = gross * (hrPct / 100);
    const annual  = gross * 12;

    // BD simplified tax: 0% up to 350000/yr, 5% up to 100000, 10% up to 300000, 15% above
    let taxable = annual - 350000;
    let tax = 0;
    if(taxable > 0){ tax += Math.min(taxable, 100000) * 0.05; taxable -= 100000; }
    if(taxable > 0){ tax += Math.min(taxable, 300000) * 0.10; taxable -= 300000; }
    if(taxable > 0){ tax += Math.min(taxable, 400000) * 0.15; taxable -= 400000; }
    if(taxable > 0){ tax += taxable * 0.20; }
    const taxM = tax / 12;
    const netM = gross - taxM;

    document.getElementById('gross-m').textContent = fmt(gross);
    document.getElementById('basic-m').textContent = fmt(basic);
    document.getElementById('hr-m').textContent    = fmt(hr);
    document.getElementById('ta-m').textContent    = fmt(ta);
    document.getElementById('annual').textContent  = fmt(annual);
    document.getElementById('tax-m').textContent   = fmt(taxM);
    document.getElementById('net-m').textContent   = fmt(netM);
    document.getElementById('res').classList.remove('hidden');
}
</script>
@endpush
@endsection
