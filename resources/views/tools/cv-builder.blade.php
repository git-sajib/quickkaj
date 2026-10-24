@extends('layouts.app')

@php
    $isBn = app()->getLocale() === 'bn';
@endphp

@section('page_title', ($isBn ? 'প্রফেশনাল A4 সিভি মেকার — ছবি ও সিগনেচার সহ ফ্রি CV তৈরি' : 'Professional A4 CV Maker — Free Resume Builder with Photo') . ' — ' . __('ui.site_name'))
@section('seo_description', $isBn
    ? 'অনলাইন প্রফেশনাল ১-পেজের A4 সিভি মেকার। ছবি, এসএসসি ও এইচএসসি শিক্ষা বিবরণ, ব্যক্তিগত তথ্য, স্কিল ও সিগনেচার দিয়ে আকর্ষণীয় CV তৈরি ও সরাসরি প্রিন্ট/PDF ডাউনলোড করুন।'
    : 'Build a professional 1-page A4 CV with photo, career objective, SSC & HSC education, personal details, skills, and signature. Instant PDF download.')

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "WebApplication",
    "name": "{{ $isBn ? 'প্রফেশনাল A4 সিভি মেকার' : 'Professional A4 CV Maker' }}",
    "description": "{{ $isBn ? 'ছবি ও সিগনেচার সহ ১ পেজের পারফেক্ট A4 সিভি তৈরির ফ্রি টুল।' : 'Build and download a standard 1-page A4 professional CV in seconds.' }}",
    "url": "{{ url()->current() }}",
    "applicationCategory": "BusinessApplication",
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
            "name": "{{ $isBn ? 'তৈরি করা সিভি কি ঠিক এক পেজ (Single A4) থাকবে?' : 'Does the generated CV fit strictly on a single A4 page?' }}",
            "acceptedAnswer": {
                "@@type": "Answer",
                "text": "{{ $isBn ? 'হ্যাঁ, আমাদের লেআউটটি স্ট্যান্ডার্ড A4 (210 × 297 mm) পরিমাপে অপ্টিমাইজড, যাতে প্রিন্ট বা PDF ডাউনলোডে ২য় পেজে ভেঙে না যায়।' : 'Yes, the layout is calibrated to standard A4 (210 x 297 mm) specifications, ensuring zero spillover onto a second page.' }}"
            }
        },
        {
            "@@type": "Question",
            "name": "{{ $isBn ? 'এটি ব্যবহার করা কি সম্পূর্ণ ফ্রি?' : 'Is this CV builder completely free to use?' }}",
            "acceptedAnswer": {
                "@@type": "Answer",
                "text": "{{ $isBn ? 'হ্যাঁ, কোনো সাবস্ক্রিপশন বা সাইনআপ ছাড়াই শতভাগ বিনামূল্যে সিভি তৈরি ও ডাউনলোড করা যায়।' : 'Yes, 100% free with no watermark, sign-up, or hidden subscription fees.' }}"
            }
        }
    ]
}
</script>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7">
    @include('partials.tool-back')

    {{-- Top Action Header --}}
    <div class="mb-6 flex items-center justify-between flex-wrap gap-4 bg-white p-4 sm:p-5 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 bg-gradient-to-br from-blue-500 to-indigo-600 text-white rounded-xl flex items-center justify-center shadow-sm">
                <i class="fa-solid fa-file-invoice text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-extrabold text-gray-900">Professional A4 CV Builder</h1>
                <p class="text-gray-500 text-xs">Standard single A4 page with SSC &amp; HSC, personal details, job experience &amp; signature line.</p>
            </div>
        </div>
        <div class="flex items-center gap-2.5 flex-wrap">
            <div class="flex items-center gap-1.5 bg-gray-50 border border-gray-200 rounded-xl px-3 py-1.5">
                <i class="fa-solid fa-palette text-gray-400 text-xs"></i>
                <label for="template-select" class="text-xs text-gray-600 font-medium">Theme:</label>
                <select id="template-select" onchange="setTemplate(this.value)" class="bg-transparent text-xs font-semibold text-gray-800 focus:outline-none cursor-pointer">
                    <option value="modern">Modern (Sidebar)</option>
                    <option value="classic">Classic (Corporate)</option>
                    <option value="minimal">Minimal (Clean)</option>
                </select>
            </div>

            <button onclick="printCV()" class="btn-secondary text-xs px-3.5 py-2.5 inline-flex items-center gap-1.5">
                <i class="fa-solid fa-print"></i>
                <span>Print</span>
            </button>

            <button id="btn-download-pdf" onclick="downloadPDF()" class="btn-primary text-xs px-4 py-2.5 inline-flex items-center gap-1.5 shadow-md shadow-blue-500/20">
                <i class="fa-solid fa-file-arrow-down" id="pdf-icon"></i>
                <span id="pdf-btn-text">Download A4 PDF</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        {{-- ── Form Panel (Left) ── --}}
        <div class="lg:col-span-6 space-y-5 max-h-[88vh] overflow-y-auto pr-1 pb-16 custom-scrollbar">

            {{-- 1. Basic Info & Photo --}}
            <div class="card p-5">
                <h3 class="font-bold text-gray-900 text-sm mb-4 flex items-center justify-between">
                    <span class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-user text-blue-600"></i>
                        <span>Basic Information &amp; Photo</span>
                    </span>
                    <span class="text-[11px] font-normal text-gray-400">Required</span>
                </h3>

                {{-- Photo Upload Row --}}
                <div class="mb-4 p-3 bg-gray-50 rounded-xl border border-dashed border-gray-200 flex items-center gap-4">
                    <div id="photo-preview-box" class="w-14 h-14 rounded-full bg-blue-100 border-2 border-blue-400 overflow-hidden flex items-center justify-center shrink-0">
                        <i id="photo-placeholder-icon" class="fa-solid fa-user text-blue-600 text-xl"></i>
                        <img id="photo-preview-img" src="" alt="Photo" class="w-full h-full object-cover hidden">
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Profile Photo (Passport Size)</label>
                        <div class="flex items-center gap-2">
                            <input type="file" id="cv-photo-input" accept="image/*" class="hidden" onchange="handlePhotoUpload(this)">
                            <button type="button" onclick="document.getElementById('cv-photo-input').click()" class="text-xs bg-white hover:bg-gray-100 text-gray-700 px-3 py-1.5 rounded-lg border border-gray-200 font-medium inline-flex items-center gap-1.5 transition-colors">
                                <i class="fa-solid fa-camera text-blue-600"></i>
                                <span>Upload Photo</span>
                            </button>
                            <button type="button" id="btn-remove-photo" onclick="removePhoto()" class="text-xs text-red-500 hover:text-red-700 px-2 py-1.5 hidden font-medium">
                                <i class="fa-solid fa-trash-can mr-1"></i>Remove
                            </button>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="col-span-2">
                        <label class="block text-[11px] font-semibold text-gray-600 mb-1">Full Name</label>
                        <input type="text" id="cv-name" oninput="update()" value="Mohammad Abdullah" placeholder="e.g. Mohammad Abdullah" class="cv-input w-full">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-[11px] font-semibold text-gray-600 mb-1">Job Title / Designation</label>
                        <input type="text" id="cv-title" oninput="update()" value="Senior Software Engineer" placeholder="e.g. Senior Software Engineer" class="cv-input">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 mb-1">Email Address</label>
                        <input type="email" id="cv-email" oninput="update()" value="abdullah.dev@gmail.com" placeholder="yourname@gmail.com" class="cv-input">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 mb-1">Phone Number</label>
                        <input type="text" id="cv-phone" oninput="update()" value="+880 1712-345678" placeholder="+880 1712-000000" class="cv-input">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 mb-1">Present Address / City</label>
                        <input type="text" id="cv-location" oninput="update()" value="Mirpur-10, Dhaka, Bangladesh" placeholder="Mirpur, Dhaka, Bangladesh" class="cv-input">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 mb-1">LinkedIn Profile</label>
                        <input type="text" id="cv-linkedin" oninput="update()" value="linkedin.com/in/m-abdullah" placeholder="linkedin.com/in/username" class="cv-input">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-[11px] font-semibold text-gray-600 mb-1">Website / Portfolio</label>
                        <input type="text" id="cv-website" oninput="update()" value="https://abdullah.dev" placeholder="https://myportfolio.com" class="cv-input">
                    </div>
                </div>
            </div>

            {{-- 2. Personal Information (Detailed BD Format) --}}
            <div class="card p-5">
                <h3 class="font-bold text-gray-900 text-sm mb-3 flex items-center justify-between">
                    <span class="flex items-center gap-2">
                        <i class="fa-solid fa-id-card text-blue-600"></i>
                        <span>Personal Information</span>
                    </span>
                    <span class="text-[11px] text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full font-semibold">BD Standard</span>
                </h3>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 mb-1">Father's Name</label>
                        <input type="text" id="cv-father" oninput="update()" value="Mohammad Rafiqul Islam" placeholder="e.g. Mohammad Rafiqul Islam" class="cv-input">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 mb-1">Mother's Name</label>
                        <input type="text" id="cv-mother" oninput="update()" value="Jahanara Begum" placeholder="e.g. Jahanara Begum" class="cv-input">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 mb-1">Date of Birth</label>
                        <input type="text" id="cv-dob" oninput="update()" value="15 January 1998" placeholder="e.g. 15 January 1998" class="cv-input">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 mb-1">NID Card No</label>
                        <input type="text" id="cv-nid" oninput="update()" value="19982692512345678" placeholder="e.g. 19981234567890" class="cv-input">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 mb-1">Blood Group</label>
                        <select id="cv-blood" onchange="update()" class="cv-input cursor-pointer">
                            <option value="">Select Blood Group</option>
                            <option value="A+" selected>A+ (Positive)</option>
                            <option value="A-">A- (Negative)</option>
                            <option value="B+">B+ (Positive)</option>
                            <option value="B-">B- (Negative)</option>
                            <option value="O+">O+ (Positive)</option>
                            <option value="O-">O- (Negative)</option>
                            <option value="AB+">AB+ (Positive)</option>
                            <option value="AB-">AB- (Negative)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 mb-1">Religion</label>
                        <input type="text" id="cv-religion" oninput="update()" value="Islam" placeholder="e.g. Islam" class="cv-input">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 mb-1">Marital Status</label>
                        <select id="cv-marital" onchange="update()" class="cv-input cursor-pointer">
                            <option value="Single" selected>Single</option>
                            <option value="Married">Married</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 mb-1">Nationality</label>
                        <input type="text" id="cv-nationality" oninput="update()" value="Bangladeshi" placeholder="Bangladeshi" class="cv-input">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-[11px] font-semibold text-gray-600 mb-1">Permanent Address</label>
                        <input type="text" id="cv-permanent-address" oninput="update()" value="Vill: Rampur, P.O: Sadar, Dist: Cumilla" placeholder="Vill: Rampur, P.O: Sadar, Dist: Cumilla" class="cv-input">
                    </div>
                </div>
            </div>

            {{-- 3. Career Objective --}}
            <div class="card p-5">
                <h3 class="font-bold text-gray-900 text-sm mb-3 flex items-center gap-2">
                    <i class="fa-solid fa-bullseye text-blue-600"></i>
                    <span>Career Objective</span>
                </h3>
                <textarea id="cv-summary" oninput="update()" rows="3" placeholder="Write a brief, impactful career objective statement..." class="cv-input w-full resize-none">To secure a challenging position in a reputable organization where I can utilize my technical skills, experience, and education to contribute significantly toward company growth while expanding my professional capabilities.</textarea>
            </div>

            {{-- 4. Job Experience --}}
            <div class="card p-5">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                        <i class="fa-solid fa-briefcase text-blue-600"></i>
                        <span>Job Experience</span>
                    </h3>
                    <button type="button" onclick="addExp()" class="text-xs text-blue-600 font-semibold hover:text-blue-700 flex items-center gap-1">
                        <i class="fa-solid fa-circle-plus"></i>
                        <span>Add Experience</span>
                    </button>
                </div>
                <div id="exp-list" class="space-y-3"></div>
            </div>

            {{-- 5. Educational Qualification (SSC, HSC, Bachelor) --}}
            <div class="card p-5 space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                    <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                        <i class="fa-solid fa-graduation-cap text-blue-600"></i>
                        <span>Educational Qualification</span>
                    </h3>
                    <button type="button" onclick="addCustomEdu()" class="text-xs text-blue-600 font-semibold hover:text-blue-700 flex items-center gap-1">
                        <i class="fa-solid fa-circle-plus"></i>
                        <span>Add Masters / Other</span>
                    </button>
                </div>

                {{-- Bachelor / Graduation Degree --}}
                <div class="p-3 bg-gray-50/80 rounded-xl border border-gray-200/80 space-y-2">
                    <span class="text-[11px] font-bold text-blue-700 uppercase tracking-wider">1. Graduation / Bachelor Degree</span>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="text" id="edu-grad-degree" oninput="update()" value="B.Sc. in Computer Science &amp; Engineering" placeholder="Degree (e.g. B.Sc in CSE)" class="cv-input">
                        <input type="text" id="edu-grad-inst" oninput="update()" value="University of Dhaka" placeholder="University / College" class="cv-input">
                        <input type="text" id="edu-grad-year" oninput="update()" value="2020" placeholder="Passing Year (e.g. 2020)" class="cv-input">
                        <input type="text" id="edu-grad-gpa" oninput="update()" value="CGPA 3.85 / 4.00" placeholder="CGPA (e.g. 3.85 / 4.00)" class="cv-input">
                    </div>
                </div>

                {{-- HSC Section --}}
                <div class="p-3 bg-gray-50/80 rounded-xl border border-gray-200/80 space-y-2">
                    <span class="text-[11px] font-bold text-emerald-700 uppercase tracking-wider">2. Higher Secondary Certificate (H.S.C)</span>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="text" id="edu-hsc-degree" oninput="update()" value="H.S.C (Science)" placeholder="H.S.C (Science / Commerce / Arts)" class="cv-input">
                        <input type="text" id="edu-hsc-inst" oninput="update()" value="Dhaka College (Dhaka Board)" placeholder="College Name &amp; Board (e.g. Dhaka College, Dhaka Board)" class="cv-input">
                        <input type="text" id="edu-hsc-year" oninput="update()" value="2016" placeholder="Passing Year (e.g. 2016)" class="cv-input">
                        <input type="text" id="edu-hsc-gpa" oninput="update()" value="GPA 5.00 / 5.00" placeholder="GPA (e.g. 5.00 / 5.00)" class="cv-input">
                    </div>
                </div>

                {{-- SSC Section --}}
                <div class="p-3 bg-gray-50/80 rounded-xl border border-gray-200/80 space-y-2">
                    <span class="text-[11px] font-bold text-violet-700 uppercase tracking-wider">3. Secondary School Certificate (S.S.C)</span>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="text" id="edu-ssc-degree" oninput="update()" value="S.S.C (Science)" placeholder="S.S.C (Science / Commerce / Arts)" class="cv-input">
                        <input type="text" id="edu-ssc-inst" oninput="update()" value="Ideal School &amp; College (Dhaka Board)" placeholder="School Name &amp; Board (e.g. Ideal School, Dhaka Board)" class="cv-input">
                        <input type="text" id="edu-ssc-year" oninput="update()" value="2014" placeholder="Passing Year (e.g. 2014)" class="cv-input">
                        <input type="text" id="edu-ssc-gpa" oninput="update()" value="GPA 5.00 / 5.00" placeholder="GPA (e.g. 5.00 / 5.00)" class="cv-input">
                    </div>
                </div>

                {{-- Additional custom education entries if needed --}}
                <div id="custom-edu-list" class="space-y-3"></div>
            </div>

            {{-- 6. Computer Skills & Languages (Sidebar in Modern Template) --}}
            <div class="card p-5 space-y-4">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                            <i class="fa-solid fa-laptop-code text-blue-600"></i>
                            <span>Computer Skills</span>
                        </h3>
                        <span class="text-[11px] text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full font-semibold">Sidebar Section</span>
                    </div>
                    <p class="text-xs text-gray-400 mb-2">Separate skills with commas (e.g. MS Word, Excel, PowerPoint, Web Development, MySQL, Fast Typing)</p>
                    <input type="text" id="cv-skills" oninput="update()" value="MS Office (Word, Excel, PowerPoint), Web Development (PHP, Laravel, JS), Database (MySQL), Internet &amp; Email Operation, Fast Typing" placeholder="e.g. MS Office (Word, Excel, PPT), Web Development, Database Management, Typing" class="cv-input">
                </div>

                <div class="pt-3 border-t border-gray-100">
                    <h3 class="font-bold text-gray-900 text-sm mb-2 flex items-center gap-2">
                        <i class="fa-solid fa-language text-blue-600"></i>
                        <span>Languages</span>
                    </h3>
                    <input type="text" id="cv-languages" oninput="update()" value="English (Fluent), Bengali (Native)" placeholder="e.g. English (Fluent), Bengali (Native)" class="cv-input">
                </div>
            </div>

            {{-- 7. References --}}
            <div class="card p-5">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                        <i class="fa-solid fa-users text-blue-600"></i>
                        <span>References</span>
                    </h3>
                    <button type="button" onclick="addRef()" class="text-xs text-blue-600 font-semibold hover:text-blue-700 flex items-center gap-1">
                        <i class="fa-solid fa-circle-plus"></i>
                        <span>Add Reference</span>
                    </button>
                </div>
                <div id="ref-list" class="space-y-3"></div>
            </div>

            {{-- 8. Declaration & Signature --}}
            <div class="card p-5 space-y-4">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                            <i class="fa-solid fa-certificate text-blue-600"></i>
                            <span>Declaration</span>
                        </h3>
                        <label class="inline-flex items-center gap-1.5 text-xs text-gray-500 cursor-pointer">
                            <input type="checkbox" id="cv-declaration-toggle" checked onchange="update()" class="rounded text-blue-600 focus:ring-blue-500">
                            <span>Include</span>
                        </label>
                    </div>
                    <textarea id="cv-declaration" oninput="update()" rows="2" class="cv-input w-full resize-none text-xs">I hereby declare that the details and information given above are complete, true, and correct to the best of my knowledge and belief.</textarea>
                </div>

                <div class="pt-3 border-t border-gray-100">
                    <h3 class="font-bold text-gray-900 text-sm mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-signature text-blue-600"></i>
                        <span>Date &amp; Signature</span>
                    </h3>
                    <div class="grid grid-cols-2 gap-3 items-center">
                        <div>
                            <label class="block text-[11px] font-semibold text-gray-600 mb-1">Date</label>
                            <input type="text" id="cv-date" oninput="update()" value="{{ date('d M Y') }}" placeholder="{{ date('d M Y') }}" class="cv-input">
                        </div>
                        <div class="p-2.5 bg-blue-50/60 rounded-xl border border-blue-100 text-xs text-blue-800 leading-relaxed">
                            <i class="fa-solid fa-pen-nib mr-1 text-blue-600"></i>
                            <strong>Handwritten Signature:</strong> A blank space with a clean line above <em>Signature</em> is placed on the CV for physical pen signing after print.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Preview Panel (Right - Exact A4 Sheet) ── --}}
        <div class="lg:col-span-6 sticky top-20">
            <div class="cv-preview-wrapper bg-slate-200/80 p-2 sm:p-4 rounded-2xl border border-gray-300 shadow-inner flex flex-col items-center">
                <div class="w-full flex items-center justify-between mb-2 text-xs text-gray-600 px-1 font-semibold">
                    <span class="inline-flex items-center gap-1.5">
                        <i class="fa-solid fa-file-pdf text-red-500"></i>
                        <span>Live A4 Preview (210 &times; 297 mm)</span>
                    </span>
                    <span class="text-[11px] bg-white px-2 py-0.5 rounded shadow-2xs text-gray-500">
                        Exact 1 Page Fit
                    </span>
                </div>

                {{-- Printable A4 Container with Sheet Shadow & Responsive Scaler --}}
                <div id="cv-sheet-container" class="w-full flex justify-center py-1 overflow-hidden">
                    <div id="cv-preview-scaler" style="width:794px; transform-origin:top center; transition:transform 0.1s ease;">
                        <div id="cv-preview"
                             class="bg-white shadow-2xl rounded-xs overflow-hidden text-gray-900 border border-gray-200/80 relative"
                             style="font-family:'Inter',sans-serif; box-sizing:border-box; width:794px; min-width:794px; max-width:794px; height:1120px; min-height:1120px; max-height:1120px; overflow:hidden;">
                            {{-- Rendered dynamically by JS --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.tool-ad')
</div>

<style>
.cv-input { border:1px solid #e5e7eb; border-radius:0.625rem; padding:0.5rem 0.75rem; font-size:0.8rem; width:100%; outline:none; transition:box-shadow .15s, border-color .15s; background-color:#fafafa; }
.cv-input:focus { background-color:#fff; box-shadow:0 0 0 3px rgba(59, 130, 246, 0.15); border-color:#3b82f6; }
.custom-scrollbar::-webkit-scrollbar { width: 6px; }
.custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 999px; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 999px; }

@page {
    size: A4 portrait;
    margin: 0;
}
@media print {
    nav, footer, .no-print, header, .card:not(#cv-preview), .sticky, #mobile-menu, #quick-search-modal {
        display: none !important;
    }
    body, html {
        margin: 0 !important;
        padding: 0 !important;
        background: #fff !important;
        width: 100% !important;
    }
    .max-w-7xl, .grid {
        display: block !important;
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .lg\:col-span-6:first-child {
        display: none !important;
    }
    .lg\:col-span-6:last-child {
        display: block !important;
        width: 100% !important;
        position: static !important;
        padding: 0 !important;
    }
    .cv-preview-wrapper {
        background: transparent !important;
        padding: 0 !important;
        border: none !important;
        box-shadow: none !important;
    }
    .cv-preview-wrapper > div:first-child {
        display: none !important;
    }
    #cv-sheet-container {
        overflow: visible !important;
        padding: 0 !important;
        margin: 0 !important;
        display: block !important;
    }
    #cv-preview-scaler {
        transform: none !important;
        margin: 0 !important;
        width: 100% !important;
    }
    #cv-preview {
        box-shadow: none !important;
        border: none !important;
        border-radius: 0 !important;
        width: 210mm !important;
        max-width: 210mm !important;
        height: 297mm !important;
        max-height: 297mm !important;
        min-height: 297mm !important;
        margin: 0 !important;
        overflow: hidden !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
}
</style>

@push('scripts')
{{-- html2pdf CDN for 1-click True A4 PDF download --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
let tpl = 'modern';
let expIdx = 0, customEduIdx = 0, refIdx = 0;
let userPhotoBase64 = null;

function v(id){ return (document.getElementById(id)?.value || '').trim(); }

function handlePhotoUpload(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            userPhotoBase64 = e.target.result;
            document.getElementById('photo-preview-img').src = userPhotoBase64;
            document.getElementById('photo-preview-img').classList.remove('hidden');
            document.getElementById('photo-placeholder-icon').classList.add('hidden');
            document.getElementById('btn-remove-photo').classList.remove('hidden');
            update();
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function removePhoto() {
    userPhotoBase64 = null;
    document.getElementById('cv-photo-input').value = '';
    document.getElementById('photo-preview-img').src = '';
    document.getElementById('photo-preview-img').classList.add('hidden');
    document.getElementById('photo-placeholder-icon').classList.remove('hidden');
    document.getElementById('btn-remove-photo').classList.add('hidden');
    update();
}

function addExp(initial = null){
    const i = expIdx++;
    const d = document.createElement('div');
    d.className = 'border border-gray-200/80 rounded-xl p-3.5 space-y-2 bg-gray-50/70 relative';
    d.id = 'exp-' + i;
    const data = initial || { title: '', company: '', from: '', to: '', desc: '' };

    d.innerHTML = `
        <div class="flex items-center justify-between pb-1 mb-1 border-b border-gray-200/60">
            <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Experience #${i + 1}</span>
            <button type="button" onclick="document.getElementById('exp-${i}').remove(); update();" class="text-xs text-red-400 hover:text-red-600 inline-flex items-center gap-1 transition-colors">
                <i class="fa-solid fa-trash-can"></i>
                <span>Delete</span>
            </button>
        </div>
        <div class="grid grid-cols-2 gap-2">
            <input type="text" oninput="update()" value="${escapeHtml(data.title)}" placeholder="Job Title" class="cv-input exp-title">
            <input type="text" oninput="update()" value="${escapeHtml(data.company)}" placeholder="Company Name" class="cv-input exp-company">
            <input type="text" oninput="update()" value="${escapeHtml(data.from)}" placeholder="Start Year (e.g. 2022)" class="cv-input exp-from">
            <input type="text" oninput="update()" value="${escapeHtml(data.to)}" placeholder="End / Present" class="cv-input exp-to">
        </div>
        <textarea oninput="update()" rows="2" placeholder="Responsibilities & achievements..." class="cv-input w-full resize-none exp-desc">${escapeHtml(data.desc)}</textarea>
    `;
    document.getElementById('exp-list').appendChild(d);
}

function addCustomEdu(initial = null){
    const i = customEduIdx++;
    const d = document.createElement('div');
    d.className = 'border border-gray-200/80 rounded-xl p-3 space-y-2 bg-gray-50/70 relative';
    d.id = 'c-edu-' + i;
    const data = initial || { degree: '', inst: '', year: '', gpa: '' };

    d.innerHTML = `
        <div class="flex items-center justify-between pb-1 mb-1 border-b border-gray-200/60">
            <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Additional Degree</span>
            <button type="button" onclick="document.getElementById('c-edu-${i}').remove(); update();" class="text-xs text-red-400 hover:text-red-600 inline-flex items-center gap-1 transition-colors">
                <i class="fa-solid fa-trash-can"></i>
                <span>Delete</span>
            </button>
        </div>
        <div class="grid grid-cols-2 gap-2">
            <input type="text" oninput="update()" value="${escapeHtml(data.degree)}" placeholder="Degree (e.g. M.Sc in CSE)" class="cv-input c-edu-degree">
            <input type="text" oninput="update()" value="${escapeHtml(data.inst)}" placeholder="Institute / University" class="cv-input c-edu-inst">
            <input type="text" oninput="update()" value="${escapeHtml(data.year)}" placeholder="Year" class="cv-input c-edu-year">
            <input type="text" oninput="update()" value="${escapeHtml(data.gpa)}" placeholder="Result / GPA" class="cv-input c-edu-gpa">
        </div>
    `;
    document.getElementById('custom-edu-list').appendChild(d);
}

function addRef(initial = null){
    const i = refIdx++;
    const d = document.createElement('div');
    d.className = 'border border-gray-200/80 rounded-xl p-3 space-y-2 bg-gray-50/70 relative';
    d.id = 'ref-' + i;
    const data = initial || { name: '', title: '', phone: '', email: '' };

    d.innerHTML = `
        <div class="flex items-center justify-between pb-1 mb-1 border-b border-gray-200/60">
            <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Reference #${i + 1}</span>
            <button type="button" onclick="document.getElementById('ref-${i}').remove(); update();" class="text-xs text-red-400 hover:text-red-600 inline-flex items-center gap-1 transition-colors">
                <i class="fa-solid fa-trash-can"></i>
                <span>Delete</span>
            </button>
        </div>
        <div class="grid grid-cols-2 gap-2">
            <input type="text" oninput="update()" value="${escapeHtml(data.name)}" placeholder="Reference Name" class="cv-input ref-name">
            <input type="text" oninput="update()" value="${escapeHtml(data.title)}" placeholder="Designation & Organization" class="cv-input ref-title">
            <input type="text" oninput="update()" value="${escapeHtml(data.phone)}" placeholder="Phone Number" class="cv-input ref-phone">
            <input type="email" oninput="update()" value="${escapeHtml(data.email)}" placeholder="Email" class="cv-input ref-email">
        </div>
    `;
    document.getElementById('ref-list').appendChild(d);
}

function escapeHtml(str){
    if (!str) return '';
    return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

function getExp(){
    return [...document.querySelectorAll('#exp-list > div')].map(d => ({
        title: d.querySelector('.exp-title')?.value || '',
        company: d.querySelector('.exp-company')?.value || '',
        from: d.querySelector('.exp-from')?.value || '',
        to: d.querySelector('.exp-to')?.value || '',
        desc: d.querySelector('.exp-desc')?.value || ''
    })).filter(item => item.title || item.company);
}

function getEducationList(){
    const list = [];
    const gradDegree = v('edu-grad-degree');
    if (gradDegree) {
        list.push({ degree: gradDegree, inst: v('edu-grad-inst'), year: v('edu-grad-year'), gpa: v('edu-grad-gpa') });
    }
    const hscDegree = v('edu-hsc-degree');
    if (hscDegree) {
        list.push({ degree: hscDegree, inst: v('edu-hsc-inst'), year: v('edu-hsc-year'), gpa: v('edu-hsc-gpa') });
    }
    const sscDegree = v('edu-ssc-degree');
    if (sscDegree) {
        list.push({ degree: sscDegree, inst: v('edu-ssc-inst'), year: v('edu-ssc-year'), gpa: v('edu-ssc-gpa') });
    }
    [...document.querySelectorAll('#custom-edu-list > div')].forEach(d => {
        const deg = d.querySelector('.c-edu-degree')?.value || '';
        if (deg) {
            list.push({
                degree: deg,
                inst: d.querySelector('.c-edu-inst')?.value || '',
                year: d.querySelector('.c-edu-year')?.value || '',
                gpa: d.querySelector('.c-edu-gpa')?.value || ''
            });
        }
    });
    return list;
}

function getRefs(){
    return [...document.querySelectorAll('#ref-list > div')].map(d => ({
        name: d.querySelector('.ref-name')?.value || '',
        title: d.querySelector('.ref-title')?.value || '',
        phone: d.querySelector('.ref-phone')?.value || '',
        email: d.querySelector('.ref-email')?.value || ''
    })).filter(item => item.name);
}

function setTemplate(t){
    tpl = t;
    update();
}

const TEMPLATES = {
    modern: (data) => `
    <div style="display:flex;height:1120px;max-height:1120px;min-height:1120px;overflow:hidden;background:#ffffff;color:#1e293b;box-sizing:border-box;width:794px;">
        {{-- Left Sidebar: Photo, Contact, Personal Information, Computer Skills, Languages --}}
        <div style="width:255px;height:1120px;max-height:1120px;background:linear-gradient(180deg,#1e3a8a 0%,#2563eb 100%);color:#ffffff;padding:22px 16px;flex-shrink:0;-webkit-print-color-adjust:exact;print-color-adjust:exact;display:flex;flex-direction:column;justify-content:space-between;box-sizing:border-box;">
            <div>
                {{-- Photo or Monogram --}}
                <div style="width:90px;height:90px;border-radius:50%;border:3px solid rgba(255,255,255,0.9);margin:0 auto 12px;overflow:hidden;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,0.15);box-shadow:0 3px 8px rgba(0,0,0,0.18);">
                    ${data.photo ? `<img src="${data.photo}" style="width:100%;height:100%;object-fit:cover;" alt="Photo">` : `<span style="font-size:30px;font-weight:800;color:#fff;">${data.name ? data.name.charAt(0).toUpperCase() : 'CV'}</span>`}
                </div>
                <div style="font-size:15px;font-weight:700;text-align:center;margin-bottom:16px;line-height:1.3;color:#ffffff;">
                    ${data.name || 'Your Name'}
                </div>

                {{-- Contact Info --}}
                <div style="border-top:1px solid rgba(255,255,255,0.25);padding-top:12px;margin-bottom:16px;">
                    <div style="font-size:12px;font-weight:800;letter-spacing:0.08em;text-transform:uppercase;margin-bottom:8px;opacity:0.95;">
                        <i class="fa-solid fa-address-book" style="margin-right:6px;"></i>Contact
                    </div>
                    ${data.email ? `<div style="font-size:11px;margin-bottom:6px;word-break:break-all;line-height:1.4;"><i class="fa-solid fa-envelope" style="width:14px;opacity:0.85;margin-right:4px;"></i>${data.email}</div>` : ''}
                    ${data.phone ? `<div style="font-size:11px;margin-bottom:6px;line-height:1.4;"><i class="fa-solid fa-phone" style="width:14px;opacity:0.85;margin-right:4px;"></i>${data.phone}</div>` : ''}
                    ${data.location ? `<div style="font-size:11px;margin-bottom:6px;line-height:1.4;"><i class="fa-solid fa-location-dot" style="width:14px;opacity:0.85;margin-right:4px;"></i>${data.location}</div>` : ''}
                    ${data.linkedin ? `<div style="font-size:11px;margin-bottom:6px;word-break:break-all;line-height:1.4;"><i class="fa-brands fa-linkedin" style="width:14px;opacity:0.85;margin-right:4px;"></i>${data.linkedin.replace(/https?:\/\/(www\.)?/, '')}</div>` : ''}
                    ${data.website ? `<div style="font-size:11px;margin-bottom:6px;word-break:break-all;line-height:1.4;"><i class="fa-solid fa-globe" style="width:14px;opacity:0.85;margin-right:4px;"></i>${data.website.replace(/https?:\/\/(www\.)?/, '')}</div>` : ''}
                </div>

                {{-- Personal Information (BD Standard) --}}
                <div style="border-top:1px solid rgba(255,255,255,0.25);padding-top:12px;margin-bottom:16px;">
                    <div style="font-size:12px;font-weight:800;letter-spacing:0.08em;text-transform:uppercase;margin-bottom:8px;opacity:0.95;">
                        <i class="fa-solid fa-id-card" style="margin-right:6px;"></i>Personal Details
                    </div>
                    <div style="font-size:11px;line-height:1.5;opacity:0.95;display:flex;flex-direction:column;gap:4px;">
                        ${data.father ? `<div><span style="opacity:0.8;">Father:</span> ${data.father}</div>` : ''}
                        ${data.mother ? `<div><span style="opacity:0.8;">Mother:</span> ${data.mother}</div>` : ''}
                        ${data.dob ? `<div><span style="opacity:0.8;">DOB:</span> ${data.dob}</div>` : ''}
                        ${data.nid ? `<div><span style="opacity:0.8;">NID:</span> ${data.nid}</div>` : ''}
                        ${data.blood ? `<div><span style="opacity:0.8;">Blood:</span> <b style="color:#fee2e2;">${data.blood}</b></div>` : ''}
                        ${data.religion ? `<div><span style="opacity:0.8;">Religion:</span> ${data.religion}</div>` : ''}
                        ${data.marital ? `<div><span style="opacity:0.8;">Marital:</span> ${data.marital}</div>` : ''}
                        ${data.permanentAddress ? `<div><span style="opacity:0.8;">Permanent:</span> ${data.permanentAddress}</div>` : ''}
                    </div>
                </div>

                {{-- Computer Skills in Sidebar --}}
                ${data.skills.length ? `
                <div style="border-top:1px solid rgba(255,255,255,0.25);padding-top:12px;margin-bottom:16px;">
                    <div style="font-size:12px;font-weight:800;letter-spacing:0.08em;text-transform:uppercase;margin-bottom:8px;opacity:0.95;">
                        <i class="fa-solid fa-laptop-code" style="margin-right:6px;"></i>Computer Skills
                    </div>
                    <div style="display:flex;flex-direction:column;gap:4px;">
                        ${data.skills.map(s => `<div style="font-size:11px;background:rgba(255,255,255,0.16);padding:4px 8px;border-radius:4px;line-height:1.35;border:1px solid rgba(255,255,255,0.22);"><i class="fa-solid fa-check" style="font-size:9px;margin-right:5px;opacity:0.9;"></i>${s}</div>`).join('')}
                    </div>
                </div>` : ''}

                {{-- Languages in Sidebar --}}
                ${data.languages.length ? `
                <div style="border-top:1px solid rgba(255,255,255,0.25);padding-top:12px;">
                    <div style="font-size:12px;font-weight:800;letter-spacing:0.08em;text-transform:uppercase;margin-bottom:8px;opacity:0.95;">
                        <i class="fa-solid fa-language" style="margin-right:6px;"></i>Languages
                    </div>
                    <div style="display:flex;flex-direction:column;gap:3.5px;">
                        ${data.languages.map(l => `<div style="font-size:11px;opacity:0.95;line-height:1.45;"><i class="fa-solid fa-angle-right" style="font-size:9px;margin-right:5px;opacity:0.85;"></i>${l}</div>`).join('')}
                    </div>
                </div>` : ''}
            </div>
        </div>

        {{-- Main Body: Header -> Career Objective -> Job Experience -> Educational Qualification (SSC & HSC) -> References -> Declaration & Blank Signature --}}
        <div style="flex:1;width:539px;height:1120px;max-height:1120px;padding:22px 24px;box-sizing:border-box;display:flex;flex-direction:column;justify-content:space-between;">
            <div>
                {{-- Header --}}
                <div style="border-bottom:2px solid #e2e8f0;padding-bottom:12px;margin-bottom:18px;">
                    <h1 style="font-size:26px;font-weight:800;color:#1e3a8a;margin:0 0 3px 0;letter-spacing:-0.02em;">
                        ${data.name || 'Your Name'}
                    </h1>
                    <p style="font-size:14px;font-weight:600;color:#475569;margin:0;">
                        ${data.title || 'Job Title'}
                    </p>
                </div>

                {{-- 1. Career Objective --}}
                ${data.summary ? `
                <div style="margin-bottom:18px;">
                    <h2 style="font-size:13px;font-weight:800;color:#1e3a8a;text-transform:uppercase;letter-spacing:0.07em;margin:0 0 6px 0;display:flex;align-items:center;gap:6px;border-bottom:1.5px solid #e2e8f0;padding-bottom:3px;">
                        <i class="fa-solid fa-bullseye text-blue-600"></i>
                        <span>Career Objective</span>
                    </h2>
                    <p style="font-size:11.5px;color:#334155;line-height:1.6;margin:0;text-align:justify;">${data.summary}</p>
                </div>` : ''}

                {{-- 2. Job Experience --}}
                ${data.exp.length ? `
                <div style="margin-bottom:18px;">
                    <h2 style="font-size:13px;font-weight:800;color:#1e3a8a;text-transform:uppercase;letter-spacing:0.07em;margin:0 0 8px 0;display:flex;align-items:center;gap:6px;border-bottom:1.5px solid #e2e8f0;padding-bottom:3px;">
                        <i class="fa-solid fa-briefcase text-blue-600"></i>
                        <span>Job Experience</span>
                    </h2>
                    ${data.exp.map(e => `
                        <div style="margin-bottom:10px;">
                            <div style="display:flex;justify-content:space-between;align-items:baseline;">
                                <span style="font-weight:700;font-size:13px;color:#0f172a;">${e.title}</span>
                                <span style="font-size:11.5px;color:#64748b;font-weight:500;">${e.from}${e.to ? ' – ' + e.to : ''}</span>
                            </div>
                            <div style="font-size:12px;color:#2563eb;font-weight:600;margin-top:1.5px;">${e.company}</div>
                            ${e.desc ? `<div style="font-size:11.5px;color:#475569;margin-top:3px;line-height:1.55;text-align:justify;">${e.desc}</div>` : ''}
                        </div>
                    `).join('')}
                </div>` : ''}

                {{-- 3. Educational Qualification (SSC, HSC, Bachelor Table) --}}
                ${data.edu.length ? `
                <div style="margin-bottom:18px;">
                    <h2 style="font-size:13px;font-weight:800;color:#1e3a8a;text-transform:uppercase;letter-spacing:0.07em;margin:0 0 8px 0;display:flex;align-items:center;gap:6px;border-bottom:1.5px solid #e2e8f0;padding-bottom:3px;">
                        <i class="fa-solid fa-graduation-cap text-blue-600"></i>
                        <span>Educational Qualification</span>
                    </h2>
                    <table style="width:100%;border-collapse:collapse;font-size:11.5px;margin-top:4px;">
                        <thead>
                            <tr style="background:#f1f5f9;color:#0f172a;text-align:left;">
                                <th style="padding:6px 8px;border:1px solid #cbd5e1;font-weight:700;">Exam / Degree</th>
                                <th style="padding:6px 8px;border:1px solid #cbd5e1;font-weight:700;">Institute / Board</th>
                                <th style="padding:6px 8px;border:1px solid #cbd5e1;font-weight:700;width:60px;text-align:center;">Year</th>
                                <th style="padding:6px 8px;border:1px solid #cbd5e1;font-weight:700;width:95px;text-align:center;">Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${data.edu.map(e => `
                                <tr>
                                    <td style="padding:5px 8px;border:1px solid #e2e8f0;font-weight:600;color:#0f172a;">${e.degree}</td>
                                    <td style="padding:5px 8px;border:1px solid #e2e8f0;color:#334155;">${e.inst}</td>
                                    <td style="padding:5px 8px;border:1px solid #e2e8f0;text-align:center;color:#64748b;">${e.year}</td>
                                    <td style="padding:5px 8px;border:1px solid #e2e8f0;text-align:center;font-weight:700;color:#059669;">${e.gpa}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>` : ''}

                {{-- 4. References --}}
                ${data.refs.length ? `
                <div style="margin-bottom:16px;">
                    <h2 style="font-size:13px;font-weight:800;color:#1e3a8a;text-transform:uppercase;letter-spacing:0.07em;margin:0 0 8px 0;display:flex;align-items:center;gap:6px;border-bottom:1.5px solid #e2e8f0;padding-bottom:3px;">
                        <i class="fa-solid fa-users text-blue-600"></i>
                        <span>References</span>
                    </h2>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                        ${data.refs.map(r => `
                            <div style="background:#f8fafc;padding:7px 10px;border-radius:6px;border:1px solid #e2e8f0;">
                                <div style="font-weight:700;font-size:12px;color:#0f172a;">${r.name}</div>
                                <div style="font-size:11px;color:#475569;margin-top:1px;">${r.title}</div>
                                ${r.phone ? `<div style="font-size:10.5px;color:#64748b;margin-top:2px;"><i class="fa-solid fa-phone" style="font-size:9px;margin-right:4px;"></i>${r.phone}</div>` : ''}
                                ${r.email ? `<div style="font-size:10.5px;color:#64748b;"><i class="fa-solid fa-envelope" style="font-size:9px;margin-right:4px;"></i>${r.email}</div>` : ''}
                            </div>
                        `).join('')}
                    </div>
                </div>` : ''}
            </div>

            {{-- Declaration & Signature Section (Bottom of A4) --}}
            <div style="margin-top:14px;padding-top:12px;border-top:1px solid #e2e8f0;">
                ${data.hasDeclaration && data.declaration ? `
                <div style="margin-bottom:12px;">
                    <div style="font-size:11px;font-weight:700;color:#334155;text-transform:uppercase;margin-bottom:3px;">Declaration</div>
                    <p style="font-size:10.5px;color:#64748b;line-height:1.5;margin:0;font-style:italic;">"${data.declaration}"</p>
                </div>` : ''}

                <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-top:10px;">
                    <div>
                        <div style="font-size:11.5px;color:#64748b;">Date: <b style="color:#0f172a;">${data.date || '{{ date("d M Y") }}'}</b></div>
                    </div>
                    <div style="text-align:center;min-width:160px;">
                        {{-- Blank area for physical pen handwriting signature --}}
                        <div style="height:40px;"></div>
                        <div style="border-top:1.5px solid #0f172a;padding-top:4px;">
                            <span style="font-size:11.5px;color:#0f172a;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;">Signature</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>`,

    classic: (data) => `
    <div style="padding:28px 34px;font-family:Georgia,serif;background:#fff;color:#111827;height:1120px;max-height:1120px;min-height:1120px;overflow:hidden;width:794px;box-sizing:border-box;display:flex;flex-direction:column;justify-content:space-between;">
        <div>
            {{-- Top Header with Photo option --}}
            <div style="display:flex;justify-content:space-between;align-items:center;border-bottom:2px solid #111827;padding-bottom:12px;margin-bottom:18px;">
                <div style="flex:1;">
                    <h1 style="font-size:26px;font-weight:700;color:#111827;margin:0 0 3px 0;letter-spacing:0.02em;">${data.name || 'Your Name'}</h1>
                    <p style="font-size:14px;color:#4b5563;font-style:italic;margin:0 0 6px 0;">${data.title || ''}</p>
                    <p style="font-size:11.5px;color:#6b7280;margin:0;">
                        ${[data.email, data.phone, data.location].filter(Boolean).join(' &nbsp;•&nbsp; ')}
                    </p>
                </div>
                ${data.photo ? `
                <div style="width:80px;height:96px;border:1px solid #9ca3af;padding:2px;border-radius:4px;overflow:hidden;margin-left:16px;flex-shrink:0;">
                    <img src="${data.photo}" style="width:100%;height:100%;object-fit:cover;" alt="Photo">
                </div>` : ''}
            </div>

            {{-- 1. Career Objective --}}
            ${data.summary ? `
            <div style="margin-bottom:18px;">
                <h2 style="font-size:13px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:#111827;margin:0 0 6px 0;border-bottom:1.5px solid #d1d5db;padding-bottom:3px;">Career Objective</h2>
                <p style="font-size:11.5px;line-height:1.6;color:#374151;margin:0;">${data.summary}</p>
            </div>` : ''}

            {{-- 2. Job Experience --}}
            ${data.exp.length ? `
            <div style="margin-bottom:18px;">
                <h2 style="font-size:13px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:#111827;margin:0 0 8px 0;border-bottom:1.5px solid #d1d5db;padding-bottom:3px;">Job Experience</h2>
                ${data.exp.map(e => `
                    <div style="margin-bottom:10px;">
                        <div style="display:flex;justify-content:space-between;">
                            <span style="font-size:13px;font-weight:700;color:#111827;">${e.title}</span>
                            <span style="font-size:11.5px;color:#6b7280;">${e.from}${e.to ? ' – ' + e.to : ''}</span>
                        </div>
                        <div style="font-size:12px;color:#4b5563;font-style:italic;">${e.company}</div>
                        ${e.desc ? `<div style="font-size:11.5px;color:#4b5563;margin-top:2px;line-height:1.55;">${e.desc}</div>` : ''}
                    </div>
                `).join('')}
            </div>` : ''}

            {{-- 3. Educational Qualification (Academic Table with SSC & HSC) --}}
            ${data.edu.length ? `
            <div style="margin-bottom:18px;">
                <h2 style="font-size:13px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:#111827;margin:0 0 8px 0;border-bottom:1.5px solid #d1d5db;padding-bottom:3px;">Educational Qualification</h2>
                <table style="width:100%;border-collapse:collapse;font-size:11.5px;margin-top:4px;">
                    <thead>
                        <tr style="background:#f3f4f6;color:#111827;text-align:left;">
                            <th style="padding:6px 8px;border:1px solid #d1d5db;font-weight:700;">Exam / Degree</th>
                            <th style="padding:6px 8px;border:1px solid #d1d5db;font-weight:700;">Institute / Board</th>
                            <th style="padding:6px 8px;border:1px solid #d1d5db;font-weight:700;width:60px;text-align:center;">Year</th>
                            <th style="padding:6px 8px;border:1px solid #d1d5db;font-weight:700;width:95px;text-align:center;">Result</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${data.edu.map(e => `
                            <tr>
                                <td style="padding:5px 8px;border:1px solid #e5e7eb;font-weight:600;">${e.degree}</td>
                                <td style="padding:5px 8px;border:1px solid #e5e7eb;">${e.inst}</td>
                                <td style="padding:5px 8px;border:1px solid #e5e7eb;text-align:center;color:#6b7280;">${e.year}</td>
                                <td style="padding:5px 8px;border:1px solid #e5e7eb;text-align:center;font-weight:700;">${e.gpa}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>` : ''}

            {{-- 4. Personal Information (BD Standard) --}}
            <div style="margin-bottom:18px;">
                <h2 style="font-size:13px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:#111827;margin:0 0 8px 0;border-bottom:1.5px solid #d1d5db;padding-bottom:3px;">Personal Information</h2>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:4px 16px;font-size:11.5px;color:#374151;">
                    ${data.father ? `<div><b>Father's Name:</b> ${data.father}</div>` : ''}
                    ${data.mother ? `<div><b>Mother's Name:</b> ${data.mother}</div>` : ''}
                    ${data.dob ? `<div><b>Date of Birth:</b> ${data.dob}</div>` : ''}
                    ${data.nid ? `<div><b>NID No:</b> ${data.nid}</div>` : ''}
                    ${data.blood ? `<div><b>Blood Group:</b> ${data.blood}</div>` : ''}
                    ${data.religion ? `<div><b>Religion:</b> ${data.religion}</div>` : ''}
                    ${data.marital ? `<div><b>Marital Status:</b> ${data.marital}</div>` : ''}
                    <div><b>Nationality:</b> ${data.nationality || 'Bangladeshi'}</div>
                    ${data.permanentAddress ? `<div style="grid-column:span 2;"><b>Permanent Address:</b> ${data.permanentAddress}</div>` : ''}
                </div>
            </div>

            {{-- 5. Computer Skills & Languages --}}
            ${data.skills.length ? `
            <div style="margin-bottom:14px;">
                <h2 style="font-size:13px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:#111827;margin:0 0 6px 0;border-bottom:1.5px solid #d1d5db;padding-bottom:2px;">Computer Skills</h2>
                <p style="font-size:11.5px;color:#374151;margin:0;line-height:1.55;">${data.skills.join(' &nbsp;•&nbsp; ')}</p>
            </div>` : ''}

            ${data.languages.length ? `
            <div style="margin-bottom:14px;">
                <h2 style="font-size:13px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:#111827;margin:0 0 6px 0;border-bottom:1.5px solid #d1d5db;padding-bottom:2px;">Languages</h2>
                <p style="font-size:11.5px;color:#374151;margin:0;">${data.languages.join(' &nbsp;•&nbsp; ')}</p>
            </div>` : ''}

            {{-- 6. References --}}
            ${data.refs.length ? `
            <div style="margin-bottom:14px;">
                <h2 style="font-size:13px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:#111827;margin:0 0 8px 0;border-bottom:1.5px solid #d1d5db;padding-bottom:2px;">References</h2>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    ${data.refs.map(r => `
                        <div style="font-size:11.5px;">
                            <b>${r.name}</b>, <span style="color:#4b5563;">${r.title}</span><br>
                            <span style="color:#6b7280;">${r.phone} ${r.email ? ' · ' + r.email : ''}</span>
                        </div>
                    `).join('')}
                </div>
            </div>` : ''}
        </div>

        {{-- Declaration & Signature --}}
        <div style="margin-top:14px;border-top:1px solid #9ca3af;padding-top:12px;">
            ${data.hasDeclaration && data.declaration ? `
            <p style="font-size:10.5px;color:#4b5563;font-style:italic;margin:0 0 10px 0;">"${data.declaration}"</p>` : ''}
            <div style="display:flex;justify-content:space-between;align-items:flex-end;">
                <div style="font-size:11.5px;color:#4b5563;">Date: ${data.date || '{{ date("d M Y") }}'}</div>
                <div style="text-align:center;min-width:160px;">
                    <div style="height:40px;"></div>
                    <div style="border-top:1px solid #111827;padding-top:4px;">
                        <span style="font-size:11.5px;color:#111827;font-weight:700;text-transform:uppercase;letter-spacing:0.04em;">Signature</span>
                    </div>
                </div>
            </div>
        </div>
    </div>`,

    minimal: (data) => `
    <div style="padding:28px 32px;color:#0f172a;height:1120px;max-height:1120px;min-height:1120px;overflow:hidden;width:794px;box-sizing:border-box;background:#ffffff;display:flex;flex-direction:column;justify-content:space-between;">
        <div>
            <div style="display:flex;justify-content:space-between;align-items:flex-start;border-bottom:2px solid #0f172a;padding-bottom:12px;margin-bottom:18px;">
                <div style="display:flex;align-items:center;gap:14px;">
                    ${data.photo ? `
                    <div style="width:76px;height:76px;border-radius:8px;overflow:hidden;border:1px solid #cbd5e1;flex-shrink:0;">
                        <img src="${data.photo}" style="width:100%;height:100%;object-fit:cover;" alt="Photo">
                    </div>` : ''}
                    <div>
                        <h1 style="font-size:26px;font-weight:900;letter-spacing:-0.03em;margin:0 0 3px 0;">${data.name || 'Your Name'}</h1>
                        <p style="font-size:14px;color:#64748b;font-weight:600;margin:0;">${data.title || ''}</p>
                    </div>
                </div>
                <div style="text-align:right;font-size:11.5px;color:#64748b;line-height:1.45;">
                    ${data.email ? `<div>${data.email}</div>` : ''}
                    ${data.phone ? `<div>${data.phone}</div>` : ''}
                    ${data.location ? `<div>${data.location}</div>` : ''}
                </div>
            </div>

            {{-- 1. Career Objective --}}
            ${data.summary ? `
            <div style="margin-bottom:18px;">
                <p style="font-size:12.5px;font-weight:800;letter-spacing:0.1em;text-transform:uppercase;color:#64748b;margin:0 0 6px 0;">Career Objective</p>
                <p style="font-size:11.5px;line-height:1.6;color:#334155;margin:0;">${data.summary}</p>
            </div>` : ''}

            {{-- 2. Job Experience --}}
            ${data.exp.length ? `
            <div style="margin-bottom:18px;">
                <p style="font-size:12.5px;font-weight:800;letter-spacing:0.1em;text-transform:uppercase;color:#64748b;margin:0 0 8px 0;">Job Experience</p>
                ${data.exp.map(e => `
                    <div style="margin-bottom:10px;display:flex;gap:12px;">
                        <div style="width:90px;font-size:11.5px;color:#94a3b8;flex-shrink:0;padding-top:1px;">${e.from}<br>${e.to || 'Present'}</div>
                        <div style="flex:1;">
                            <p style="font-weight:700;font-size:13px;margin:0;color:#0f172a;">${e.title}</p>
                            <p style="font-size:12px;color:#2563eb;margin:1px 0 2px 0;">${e.company}</p>
                            ${e.desc ? `<p style="font-size:11.5px;color:#64748b;margin:0;line-height:1.55;">${e.desc}</p>` : ''}
                        </div>
                    </div>
                `).join('')}
            </div>` : ''}

            {{-- 3. Educational Qualification (SSC, HSC, Bachelor) --}}
            ${data.edu.length ? `
            <div style="margin-bottom:18px;">
                <p style="font-size:12.5px;font-weight:800;letter-spacing:0.1em;text-transform:uppercase;color:#64748b;margin:0 0 8px 0;">Educational Qualification</p>
                <table style="width:100%;border-collapse:collapse;font-size:11.5px;">
                    <thead>
                        <tr style="background:#f8fafc;color:#0f172a;text-align:left;">
                            <th style="padding:6px 8px;border:1px solid #e2e8f0;font-weight:700;">Degree</th>
                            <th style="padding:6px 8px;border:1px solid #e2e8f0;font-weight:700;">Institute / Board</th>
                            <th style="padding:6px 8px;border:1px solid #e2e8f0;font-weight:700;width:60px;text-align:center;">Year</th>
                            <th style="padding:6px 8px;border:1px solid #e2e8f0;font-weight:700;width:95px;text-align:center;">Result</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${data.edu.map(e => `
                            <tr>
                                <td style="padding:5px 8px;border:1px solid #e2e8f0;font-weight:600;">${e.degree}</td>
                                <td style="padding:5px 8px;border:1px solid #e2e8f0;color:#475569;">${e.inst}</td>
                                <td style="padding:5px 8px;border:1px solid #e2e8f0;text-align:center;color:#94a3b8;">${e.year}</td>
                                <td style="padding:5px 8px;border:1px solid #e2e8f0;text-align:center;font-weight:700;color:#059669;">${e.gpa}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>` : ''}

            {{-- 4. Personal Information --}}
            <div style="margin-bottom:18px;">
                <p style="font-size:12.5px;font-weight:800;letter-spacing:0.1em;text-transform:uppercase;color:#64748b;margin:0 0 8px 0;">Personal Information</p>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:4px 16px;font-size:11.5px;color:#334155;">
                    ${data.father ? `<div><b>Father's Name:</b> ${data.father}</div>` : ''}
                    ${data.mother ? `<div><b>Mother's Name:</b> ${data.mother}</div>` : ''}
                    ${data.dob ? `<div><b>Date of Birth:</b> ${data.dob}</div>` : ''}
                    ${data.nid ? `<div><b>NID No:</b> ${data.nid}</div>` : ''}
                    ${data.blood ? `<div><b>Blood Group:</b> ${data.blood}</div>` : ''}
                    ${data.religion ? `<div><b>Religion:</b> ${data.religion}</div>` : ''}
                    ${data.marital ? `<div><b>Marital Status:</b> ${data.marital}</div>` : ''}
                    <div><b>Nationality:</b> ${data.nationality || 'Bangladeshi'}</div>
                    ${data.permanentAddress ? `<div style="grid-column:span 2;"><b>Permanent Address:</b> ${data.permanentAddress}</div>` : ''}
                </div>
            </div>

            {{-- 5. Computer Skills --}}
            ${data.skills.length ? `
            <div style="margin-bottom:14px;">
                <p style="font-size:12.5px;font-weight:800;letter-spacing:0.1em;text-transform:uppercase;color:#64748b;margin:0 0 6px 0;">Computer Skills</p>
                <div style="display:flex;flex-wrap:wrap;gap:5px;">
                    ${data.skills.map(s => `<span style="background:#f1f5f9;color:#334155;padding:3px 9px;border-radius:4px;font-size:11px;font-weight:600;">${s}</span>`).join('')}
                </div>
            </div>` : ''}

            {{-- 6. References --}}
            ${data.refs.length ? `
            <div style="margin-bottom:14px;">
                <p style="font-size:12.5px;font-weight:800;letter-spacing:0.1em;text-transform:uppercase;color:#64748b;margin:0 0 8px 0;">References</p>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    ${data.refs.map(r => `
                        <div style="font-size:11.5px;color:#475569;">
                            <b>${r.name}</b> · ${r.title} (${r.phone})
                        </div>
                    `).join('')}
                </div>
            </div>` : ''}
        </div>

        {{-- Declaration & Signature --}}
        <div style="margin-top:14px;border-top:1px solid #e2e8f0;padding-top:12px;">
            ${data.hasDeclaration && data.declaration ? `
            <p style="font-size:10.5px;color:#64748b;margin:0 0 8px 0;font-style:italic;">"${data.declaration}"</p>` : ''}
            <div style="display:flex;justify-content:space-between;align-items:flex-end;">
                <div style="font-size:11.5px;color:#64748b;">Date: ${data.date || '{{ date("d M Y") }}'}</div>
                <div style="text-align:center;min-width:160px;">
                    <div style="height:40px;"></div>
                    <div style="border-top:1.5px solid #0f172a;padding-top:4px;">
                        <span style="font-size:11.5px;color:#0f172a;font-weight:700;text-transform:uppercase;letter-spacing:0.04em;">Signature</span>
                    </div>
                </div>
            </div>
        </div>
    </div>`
};

function getFormData(){
    return {
        photo: userPhotoBase64,
        name: v('cv-name'),
        title: v('cv-title'),
        email: v('cv-email'),
        phone: v('cv-phone'),
        location: v('cv-location'),
        linkedin: v('cv-linkedin'),
        website: v('cv-website'),
        father: v('cv-father'),
        mother: v('cv-mother'),
        dob: v('cv-dob'),
        nid: v('cv-nid'),
        blood: v('cv-blood'),
        religion: v('cv-religion'),
        marital: v('cv-marital'),
        nationality: v('cv-nationality') || 'Bangladeshi',
        permanentAddress: v('cv-permanent-address'),
        summary: v('cv-summary'),
        skills: v('cv-skills').split(',').map(s => s.trim()).filter(Boolean),
        languages: v('cv-languages').split(',').map(s => s.trim()).filter(Boolean),
        exp: getExp(),
        edu: getEducationList(),
        refs: getRefs(),
        hasDeclaration: document.getElementById('cv-declaration-toggle')?.checked ?? true,
        declaration: v('cv-declaration'),
        date: v('cv-date'),
    };
}

function fitPreview() {
    const container = document.getElementById('cv-sheet-container');
    const scaler = document.getElementById('cv-preview-scaler');
    if (!container || !scaler) return;
    const availableWidth = container.clientWidth - 8;
    if (availableWidth > 0 && availableWidth < 794) {
        const scale = availableWidth / 794;
        scaler.style.transform = `scale(${scale})`;
        scaler.style.marginBottom = `-${Math.round(1120 * (1 - scale))}px`;
    } else {
        scaler.style.transform = 'none';
        scaler.style.marginBottom = '0px';
    }
}
window.addEventListener('resize', fitPreview);

function update(){
    const data = getFormData();
    const previewEl = document.getElementById('cv-preview');
    if (previewEl && TEMPLATES[tpl]) {
        previewEl.innerHTML = TEMPLATES[tpl](data);
    }
    fitPreview();
}

async function downloadPDF(){
    const previewEl = document.getElementById('cv-preview');
    const scaler = document.getElementById('cv-preview-scaler');
    const btn = document.getElementById('btn-download-pdf');
    const icon = document.getElementById('pdf-icon');
    const btnText = document.getElementById('pdf-btn-text');

    const origText = btnText.textContent;
    btn.disabled = true;
    btnText.textContent = 'Downloading PDF...';
    icon.className = 'fa-solid fa-spinner animate-spin';

    const data = getFormData();
    const filename = (data.name ? data.name.trim().replace(/[^a-zA-Z0-9_]/g, '_') : 'Resume') + '_A4_CV.pdf';

    const prevTransform = scaler ? scaler.style.transform : '';
    const prevMargin = scaler ? scaler.style.marginBottom : '';

    try {
        if (scaler) {
            scaler.style.transform = 'none';
            scaler.style.marginBottom = '0';
        }

        if (typeof html2pdf !== 'undefined') {
            const opt = {
                margin: 0,
                filename: filename,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: {
                    scale: 2,
                    useCORS: true,
                    letterRendering: true,
                    scrollY: 0,
                    scrollX: 0,
                    width: 794,
                    height: 1120,
                    windowWidth: 794,
                    logging: false
                },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
                pagebreak: { mode: 'avoid-all' }
            };

            await html2pdf()
                .set(opt)
                .from(previewEl)
                .toPdf()
                .get('pdf')
                .then(function (pdf) {
                    // Enforce exactly 1 single A4 page
                    const totalPages = pdf.internal.getNumberOfPages();
                    for (let p = totalPages; p > 1; p--) {
                        pdf.deletePage(p);
                    }
                })
                .save();
        } else {
            printCV();
        }
    } catch (err) {
        console.error('PDF generation error, fallback direct save:', err);
        try {
            const fallbackOpt = {
                margin: 0,
                filename: filename,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, useCORS: true, scrollY: 0, scrollX: 0 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            await html2pdf().set(fallbackOpt).from(previewEl).save();
        } catch (fallbackErr) {
            console.error('Fallback failed:', fallbackErr);
            printCV();
        }
    } finally {
        if (scaler) {
            scaler.style.transform = prevTransform;
            scaler.style.marginBottom = prevMargin;
        }
        btn.disabled = false;
        btnText.textContent = origText;
        icon.className = 'fa-solid fa-file-arrow-down';
    }
}

function printCV(){
    const previewEl = document.getElementById('cv-preview');
    if (!previewEl) {
        window.print();
        return;
    }

    let printFrame = document.getElementById('cv-print-iframe');
    if (printFrame) printFrame.remove();

    printFrame = document.createElement('iframe');
    printFrame.id = 'cv-print-iframe';
    printFrame.style.position = 'fixed';
    printFrame.style.right = '0';
    printFrame.style.bottom = '0';
    printFrame.style.width = '0';
    printFrame.style.height = '0';
    printFrame.style.border = '0';
    document.body.appendChild(printFrame);

    const doc = printFrame.contentWindow.document;
    doc.open();
    const cvTitle = (v('cv-name') || 'Resume') + ' — CV';
    doc.write('<!DOCTYPE html><html><' + 'head>'
        + '<meta charset="UTF-8">'
        + '<title>' + cvTitle + '<' + '/title>'
        + '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">'
        + '<' + 'style>'
        + '@page { size: A4 portrait; margin: 0; }'
        + '* { box-sizing: border-box; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }'
        + 'html, body { margin: 0; padding: 0; background: #fff; font-family: Inter, sans-serif; width: 210mm; height: 297mm; max-height: 297mm; overflow: hidden; }'
        + '#cv-preview { width: 210mm !important; height: 297mm !important; max-height: 297mm !important; min-height: 297mm !important; margin: 0 !important; box-shadow: none !important; border: none !important; border-radius: 0 !important; overflow: hidden !important; }'
        + '<' + '/style>'
        + '<' + '/head>'
        + '<' + 'body>'
        + previewEl.outerHTML
        + '<' + '/body>'
        + '<' + '/html>');
    doc.close();

    printFrame.contentWindow.focus();
    setTimeout(() => {
        printFrame.contentWindow.print();
        setTimeout(() => printFrame.remove(), 2500);
    }, 400);
}

// Prefill rich standard BD English sample data & render initial preview
function initCV() {
    // Basic Info defaults if somehow cleared
    if (!v('cv-name')) document.getElementById('cv-name').value = 'Mohammad Abdullah';
    if (!v('cv-title')) document.getElementById('cv-title').value = 'Senior Software Engineer';
    if (!v('cv-email')) document.getElementById('cv-email').value = 'abdullah.dev@gmail.com';
    if (!v('cv-phone')) document.getElementById('cv-phone').value = '+880 1712-345678';
    if (!v('cv-location')) document.getElementById('cv-location').value = 'Mirpur-10, Dhaka, Bangladesh';
    if (!v('cv-linkedin')) document.getElementById('cv-linkedin').value = 'linkedin.com/in/m-abdullah';
    if (!v('cv-website')) document.getElementById('cv-website').value = 'https://abdullah.dev';

    // Personal Information (BD Standard)
    if (!v('cv-father')) document.getElementById('cv-father').value = 'Mohammad Rafiqul Islam';
    if (!v('cv-mother')) document.getElementById('cv-mother').value = 'Jahanara Begum';
    if (!v('cv-dob')) document.getElementById('cv-dob').value = '15 January 1998';
    if (!v('cv-nid')) document.getElementById('cv-nid').value = '19982692512345678';
    if (!v('cv-blood')) document.getElementById('cv-blood').value = 'A+';
    if (!v('cv-religion')) document.getElementById('cv-religion').value = 'Islam';
    if (!v('cv-marital')) document.getElementById('cv-marital').value = 'Single';
    if (!v('cv-nationality')) document.getElementById('cv-nationality').value = 'Bangladeshi';
    if (!v('cv-permanent-address')) document.getElementById('cv-permanent-address').value = 'Vill: Rampur, P.O: Sadar, Dist: Cumilla';

    if (!v('cv-summary')) {
        document.getElementById('cv-summary').value = 'To secure a challenging position in a reputable organization where I can utilize my technical skills, experience, and education to contribute significantly toward company growth while expanding my professional capabilities.';
    }

    // Educational Qualification (Bachelor, HSC, SSC)
    if (!v('edu-grad-degree')) document.getElementById('edu-grad-degree').value = 'B.Sc. in Computer Science & Engineering';
    if (!v('edu-grad-inst')) document.getElementById('edu-grad-inst').value = 'University of Dhaka';
    if (!v('edu-grad-year')) document.getElementById('edu-grad-year').value = '2020';
    if (!v('edu-grad-gpa')) document.getElementById('edu-grad-gpa').value = 'CGPA 3.85 / 4.00';

    if (!v('edu-hsc-degree')) document.getElementById('edu-hsc-degree').value = 'H.S.C (Science)';
    if (!v('edu-hsc-inst')) document.getElementById('edu-hsc-inst').value = 'Dhaka College (Dhaka Board)';
    if (!v('edu-hsc-year')) document.getElementById('edu-hsc-year').value = '2016';
    if (!v('edu-hsc-gpa')) document.getElementById('edu-hsc-gpa').value = 'GPA 5.00 / 5.00';

    if (!v('edu-ssc-degree')) document.getElementById('edu-ssc-degree').value = 'S.S.C (Science)';
    if (!v('edu-ssc-inst')) document.getElementById('edu-ssc-inst').value = 'Ideal School & College (Dhaka Board)';
    if (!v('edu-ssc-year')) document.getElementById('edu-ssc-year').value = '2014';
    if (!v('edu-ssc-gpa')) document.getElementById('edu-ssc-gpa').value = 'GPA 5.00 / 5.00';

    if (!v('cv-skills')) document.getElementById('cv-skills').value = 'MS Office (Word, Excel, PowerPoint), Web Development (PHP, Laravel, JS), Database (MySQL), Internet & Email Operation, Fast Typing';
    if (!v('cv-languages')) document.getElementById('cv-languages').value = 'English (Fluent), Bengali (Native)';
    if (!v('cv-date')) document.getElementById('cv-date').value = '{{ date("d M Y") }}';

    // Populate Job Experiences if list is empty
    const expList = document.getElementById('exp-list');
    if (expList && expList.children.length === 0) {
        addExp({
            title: 'Senior Software Engineer',
            company: 'NextGen Technologies Ltd',
            from: '2023',
            to: 'Present',
            desc: 'Lead web platform development, architected REST APIs, and managed payment gateways with cross-functional teams.'
        });

        addExp({
            title: 'Web Developer',
            company: 'IT Solutions BD',
            from: '2021',
            to: '2023',
            desc: 'Developed responsive user interfaces, integrated third-party APIs, and optimized relational database queries.'
        });
    }

    // Populate Reference if list is empty
    const refList = document.getElementById('ref-list');
    if (refList && refList.children.length === 0) {
        addRef({
            name: 'Dr. A. K. M. Rafiqul Islam',
            title: 'Professor, Dept of CSE, University of Dhaka',
            phone: '+880 1711-000000',
            email: 'rafiqul@univ.edu'
        });
    }

    // Render preview immediately
    update();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCV);
} else {
    initCV();
}
</script>
@endpush
@endsection
