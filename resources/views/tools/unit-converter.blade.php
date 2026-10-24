@extends('layouts.app')

@php
    $isBn = app()->getLocale() === 'bn';
@endphp

@section('page_title', ($isBn ? 'অল-ইন-ওয়ান ইউনিট কনভার্টার — দৈর্ঘ্য, ওজন, ক্ষেত্রফল ও তাপমাত্রা' : 'All-in-One Unit Converter — Length, Weight, Area, Temp') . ' — ' . __('ui.site_name'))
@section('seo_description', $isBn
    ? 'ফ্রি অনলাইন ইউনিট কনভার্টার। মিটার, কিলোমিটার, ইঞ্চি, ফুট, কেজি, পাউন্ড, একর, সেলসিয়াস ও ডেটা সাইজ নিমিষেই রূপান্তর করুন।'
    : 'Convert units of measurement instantly. Supports length, weight, temperature, land area, and digital data storage with real-time conversion.')

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "WebApplication",
    "name": "{{ $isBn ? 'অল-ইন-ওয়ান ইউনিট কনভার্টার' : 'All-in-One Unit Converter' }}",
    "description": "{{ $isBn ? 'দৈর্ঘ্য, ওজন, তাপমাত্রা ও ক্ষেত্রফল রূপান্তরের ফ্রি অনলাইন টুল।' : 'Free online tool to convert length, weight, temperature, and area units.' }}",
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
        <div class="w-10 h-10 bg-teal-100 rounded-xl flex items-center justify-center">
            <i class="fa-solid fa-ruler-combined text-teal-600 text-lg"></i>
        </div>
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">{{ $isBn ? 'ইউনিট কনভার্টার' : 'Unit Converter' }}</h1>
            <p class="text-gray-500 text-sm">{{ $isBn ? 'দৈর্ঘ্য, ওজন, তাপমাত্রা ইত্যাদি রূপান্তর করুন।' : 'Convert length, weight, temperature, area and more.' }}</p>
        </div>
    </div>

    <div class="card p-6 space-y-4">
        {{-- Category tabs --}}
        <div class="flex flex-wrap gap-2 mb-2">
            @foreach(['length'=>['fa-ruler','Length','দৈর্ঘ্য'],'weight'=>['fa-weight-hanging','Weight','ওজন'],'temperature'=>['fa-thermometer-half','Temp','তাপমাত্রা'],'area'=>['fa-vector-square','Area','ক্ষেত্রফল'],'data'=>['fa-database','Data','ডেটা']] as $cat=>[$icon,$en,$bn])
            <button onclick="setCategory('{{ $cat }}')" id="tab-{{ $cat }}"
                    class="tab-btn px-3 py-1.5 text-xs rounded-lg border border-gray-200 hover:bg-teal-50 hover:border-teal-400 transition-colors flex items-center gap-1.5">
                <i class="fa-solid {{ $icon }}"></i>{{ $isBn ? $bn : $en }}
            </button>
            @endforeach
        </div>

        <div class="grid grid-cols-3 gap-2 items-end">
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1" id="from-label">{{ $isBn ? 'থেকে' : 'From' }}</label>
                <select id="from-unit" onchange="conv()" class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-teal-400 focus:outline-none"></select>
            </div>
            <div class="flex flex-col items-center">
                <input type="number" id="from-val" value="1" oninput="conv()" class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-teal-400 focus:outline-none text-center">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">{{ $isBn ? 'যেতে' : 'To' }}</label>
                <select id="to-unit" onchange="conv()" class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-teal-400 focus:outline-none"></select>
            </div>
        </div>

        <div class="bg-teal-50 rounded-2xl p-5 text-center border border-teal-100">
            <p class="text-3xl font-extrabold text-teal-700" id="result">—</p>
        </div>
    </div>

    @include('partials.tool-ad')
</div>
@push('scripts')
<script>
const CATS = {
    length:{ units:{ m:1, km:0.001, cm:100, mm:1000, ft:3.28084, inch:39.3701, yard:1.09361, mile:0.000621371 }, labels:{m:'Meter (m)',km:'Kilometer (km)',cm:'Centimeter (cm)',mm:'Millimeter (mm)',ft:'Foot (ft)',inch:'Inch (in)',yard:'Yard',mile:'Mile'} },
    weight:{ units:{ kg:1, g:1000, mg:1e6, lb:2.20462, oz:35.274, ton:0.001 }, labels:{kg:'Kilogram (kg)',g:'Gram (g)',mg:'Milligram (mg)',lb:'Pound (lb)',oz:'Ounce (oz)',ton:'Metric Ton'} },
    temperature:{ custom:true, units:['Celsius','Fahrenheit','Kelvin'] },
    area:{ units:{ m2:1, km2:1e-6, cm2:10000, ft2:10.7639, acre:0.000247105, hectare:0.0001 }, labels:{m2:'m²',km2:'km²',cm2:'cm²',ft2:'ft²',acre:'Acre',hectare:'Hectare'} },
    data:{ units:{ B:1, KB:1/1024, MB:1/1048576, GB:1/1073741824, TB:1/1099511627776 }, labels:{B:'Byte (B)',KB:'Kilobyte (KB)',MB:'Megabyte (MB)',GB:'Gigabyte (GB)',TB:'Terabyte (TB)'} },
};
let currentCat = 'length';

function buildSelects(cat){
    const c = CATS[cat];
    const f = document.getElementById('from-unit'), t = document.getElementById('to-unit');
    f.innerHTML = ''; t.innerHTML = '';
    if(c.custom && cat==='temperature'){
        c.units.forEach(u=>{ f.add(new Option(u,u)); t.add(new Option(u,u)); });
        f.value='Celsius'; t.value='Fahrenheit';
    } else {
        Object.keys(c.units).forEach(k=>{
            const lbl = c.labels?.[k]||k;
            f.add(new Option(lbl,k)); t.add(new Option(lbl,k));
        });
        const keys=Object.keys(c.units);
        f.value=keys[0]; t.value=keys[1]||keys[0];
    }
}
function setCategory(cat){
    currentCat=cat;
    document.querySelectorAll('.tab-btn').forEach(b=>b.classList.remove('bg-teal-100','border-teal-400','text-teal-700'));
    document.getElementById('tab-'+cat).classList.add('bg-teal-100','border-teal-400','text-teal-700');
    buildSelects(cat); conv();
}
function conv(){
    const v=parseFloat(document.getElementById('from-val').value)||0;
    const fv=document.getElementById('from-unit').value;
    const tv=document.getElementById('to-unit').value;
    const c=CATS[currentCat];
    let res;
    if(c.custom && currentCat==='temperature'){
        let celsius;
        if(fv==='Celsius') celsius=v;
        else if(fv==='Fahrenheit') celsius=(v-32)*5/9;
        else celsius=v-273.15;
        if(tv==='Celsius') res=celsius;
        else if(tv==='Fahrenheit') res=celsius*9/5+32;
        else res=celsius+273.15;
    } else {
        res = (v / c.units[fv]) * c.units[tv];
    }
    const str = Math.abs(res)>=0.001&&Math.abs(res)<1e9 ? parseFloat(res.toPrecision(8)).toString() : res.toExponential(4);
    document.getElementById('result').textContent = str + ' ' + (c.labels?.[tv]||tv);
}
setCategory('length');
</script>
@endpush
@endsection
