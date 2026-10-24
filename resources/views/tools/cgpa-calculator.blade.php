@extends('layouts.app')

@php
    $isBn = app()->getLocale() === 'bn';
@endphp

@section('page_title', ($isBn ? 'CGPA ক্যালকুলেটর — বিশ্ববিদ্যালয় ও জাতীয় বিশ্ববিদ্যালয় CGPA হিসাব' : 'CGPA Calculator — University & College CGPA Calculator') . ' — ' . __('ui.site_name'))
@section('seo_description', $isBn
    ? 'ফ্রি অনলাইন CGPA ক্যালকুলেটর। বাংলাদেশের পাবলিক, প্রাইভেট ও জাতীয় বিশ্ববিদ্যালয়ের ৪.০০ ও ৫.০০ স্কেলে সেমিস্টার CGPA ও GPA সহজেই হিসাব করুন।'
    : 'Calculate university semester CGPA and GPA on 4.00 and 5.00 grading scale with multiple courses and credit hours.')

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "WebApplication",
    "name": "{{ $isBn ? 'অনলাইন CGPA ক্যালকুলেটর' : 'Online CGPA Calculator' }}",
    "description": "{{ $isBn ? 'বিশ্ববিদ্যালয় গ্রেডিং স্কেলে CGPA হিসাবের অনলাইন ক্যালকুলেটর।' : 'Online calculator for university students to calculate semester CGPA and GPA.' }}",
    "url": "{{ url()->current() }}",
    "applicationCategory": "EducationalApplication",
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
<div class="max-w-2xl mx-auto px-4 sm:px-6 py-10">
    @include('partials.tool-back')
    <div class="mb-8 flex items-center gap-3">
        <div class="w-10 h-10 bg-violet-100 rounded-xl flex items-center justify-center">
            <i class="fa-solid fa-graduation-cap text-violet-600 text-lg"></i>
        </div>
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">{{ $isBn ? 'CGPA ক্যালকুলেটর' : 'CGPA Calculator' }}</h1>
            <p class="text-gray-500 text-sm">{{ $isBn ? 'বাংলাদেশ বিশ্ববিদ্যালয়ের জন্য CGPA হিসাব করুন।' : 'Calculate CGPA for Bangladesh university grading system.' }}</p>
        </div>
    </div>

    <div class="card p-6">
        {{-- Scale selector --}}
        <div class="flex gap-3 mb-5">
            <label class="flex items-center gap-2 text-sm cursor-pointer">
                <input type="radio" name="scale" value="4" checked onchange="updateScale(this.value)" class="accent-violet-600"> 4.00 {{ $isBn ? 'স্কেল' : 'scale' }}
            </label>
            <label class="flex items-center gap-2 text-sm cursor-pointer">
                <input type="radio" name="scale" value="5" onchange="updateScale(this.value)" class="accent-violet-600"> 5.00 {{ $isBn ? 'স্কেল' : 'scale' }}
            </label>
        </div>

        <div id="courses" class="space-y-3 mb-4">
            {{-- Rows added by JS --}}
        </div>

        <button onclick="addRow()" class="w-full border-2 border-dashed border-gray-200 rounded-xl py-2.5 text-sm text-gray-400 hover:border-violet-400 hover:text-violet-500 transition-colors">
            <i class="fa-solid fa-plus mr-1"></i> {{ $isBn ? 'কোর্স যোগ করুন' : 'Add Course' }}
        </button>

        <button onclick="calcCGPA()" class="btn-primary w-full mt-4">
            <i class="fa-solid fa-calculator mr-2"></i>{{ $isBn ? 'CGPA হিসাব করুন' : 'Calculate CGPA' }}
        </button>

        <div id="res" class="hidden mt-5 bg-gradient-to-br from-violet-50 to-blue-50 rounded-2xl p-6 text-center border border-violet-100">
            <p class="text-5xl font-extrabold text-violet-700 mb-1" id="cgpa-val">—</p>
            <p class="text-gray-500 text-sm" id="cgpa-info">—</p>
        </div>
    </div>

    @include('partials.tool-ad')
</div>
@push('scripts')
<script>
const isBn = document.documentElement.lang === 'bn';
let maxScale = 4;
let rowIdx = 0;
function updateScale(v){ maxScale = parseFloat(v); }
function addRow(){
    const i = rowIdx++;
    const div = document.createElement('div');
    div.className = 'grid grid-cols-3 gap-2 items-center';
    div.id = 'row-'+i;
    div.innerHTML = `
        <input type="text" placeholder="${isBn?'কোর্সের নাম':'Course name'}" class="col-span-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-violet-400">
        <input type="number" step="0.01" min="0" max="5" placeholder="${isBn?'গ্রেড পয়েন্ট':'Grade point'}" class="grade border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-violet-400">
        <div class="flex gap-2">
            <input type="number" step="0.5" min="0.5" max="6" value="3" placeholder="${isBn?'ক্রেডিট':'Credits'}" class="credit flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-violet-400">
            <button onclick="document.getElementById('row-${i}').remove()" class="text-gray-300 hover:text-red-400 px-2 text-sm"><i class="fa-solid fa-xmark"></i></button>
        </div>`;
    document.getElementById('courses').appendChild(div);
}
function calcCGPA(){
    const grades = document.querySelectorAll('.grade');
    const credits = document.querySelectorAll('.credit');
    let totalPts = 0, totalCred = 0;
    grades.forEach((g,i)=>{
        const gp = parseFloat(g.value), cr = parseFloat(credits[i]?.value||3);
        if(!isNaN(gp) && gp >= 0 && gp <= maxScale && cr > 0){ totalPts += gp*cr; totalCred += cr; }
    });
    if(totalCred === 0) return;
    const cgpa = (totalPts/totalCred).toFixed(2);
    document.getElementById('cgpa-val').textContent = cgpa;
    document.getElementById('cgpa-info').textContent = isBn
        ? `মোট ক্রেডিট: ${totalCred} | স্কেল: ${maxScale}`
        : `Total credits: ${totalCred} | Scale: ${maxScale}`;
    document.getElementById('res').classList.remove('hidden');
}
// Start with 3 rows
addRow(); addRow(); addRow();
</script>
@endpush
@endsection
