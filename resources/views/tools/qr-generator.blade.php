@extends('layouts.app')

@php
    $isBn = app()->getLocale() === 'bn';
@endphp

@section('page_title', ($isBn ? 'ফ্রি অনলাইন QR কোড জেনারেটর — লিংক ও টেক্সট থেকে QR তৈরি' : 'Free Online QR Code Generator — Create & Download PNG') . ' — ' . __('ui.site_name'))
@section('seo_description', $isBn
    ? 'সহজেই যেকোনো ওয়েবসাইট লিংক, টেক্সট বা ফোন নম্বরের জন্য হাই-রেজোলিউশন QR কোড তৈরি ও বিনামূল্যে PNG ডাউনলোড করুন।'
    : 'Generate free high-resolution QR codes from URLs or text instantly. Download PNG format with custom pixel dimensions.')

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "WebApplication",
    "name": "{{ $isBn ? 'ফ্রি অনলাইন QR কোড জেনারেটর' : 'Free Online QR Code Generator' }}",
    "description": "{{ $isBn ? 'যেকোনো লিংক বা টেক্সটের জন্য ফ্রি হাই-কোয়ালিটি QR কোড তৈরির টুল।' : 'Instant high-resolution QR code generator for URLs, text, and contacts.' }}",
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
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "FAQPage",
    "mainEntity": [
        {
            "@@type": "Question",
            "name": "{{ $isBn ? 'এই QR কোড কি কখনো এক্সপায়ার বা মেয়াদোত্তীর্ণ হবে?' : 'Do these QR codes ever expire?' }}",
            "acceptedAnswer": {
                "@@type": "Answer",
                "text": "{{ $isBn ? 'না, এগুলো স্ট্যান্ডার্ড স্ট্যাটিক QR কোড। এর কোনো মেয়াদ শেষ হয় না এবং আজীবন স্ক্যান করা যায়।' : 'No, these are standard static QR codes. They never expire and can be scanned permanently.' }}"
            }
        },
        {
            "@@type": "Question",
            "name": "{{ $isBn ? 'আমি কি প্রিন্ট বা কমার্শিয়াল কাজে ব্যবহার করতে পারব?' : 'Can I use the generated QR code for printing and commercial purposes?' }}",
            "acceptedAnswer": {
                "@@type": "Answer",
                "text": "{{ $isBn ? 'হ্যাঁ, আপনি বিজনেস কার্ড, ব্যানার, পোস্টার বা পণ্যের প্যাকেজিংয়ে সর্বোচ্চ সাইজে প্রিন্ট করতে পারবেন।' : 'Yes, download in up to 500x500px resolution for sharp, scannable printing on business cards, posters, and flyers.' }}"
            }
        }
    ]
}
</script>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    @include('partials.tool-back')
    <h1 class="section-header mb-2 flex items-center justify-center gap-2">
        <i class="fa-solid fa-qrcode text-rose-600"></i>
        <span>{{ __('ui.qr_generator') }}</span>
    </h1>
    <p class="section-subtitle mb-8">{{ $isBn ? 'যেকোনো URL বা টেক্সট থেকে QR কোড তৈরি করুন।' : 'Generate a QR code from any URL or text instantly.' }}</p>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Input --}}
        <div class="card p-6">
            <div class="form-group">
                <label class="form-label">{{ app()->getLocale() === 'bn' ? 'URL বা টেক্সট:' : 'URL or Text:' }}</label>
                <input type="text" id="qr-text" class="form-input" value="https://quickkaj.com"
                       placeholder="{{ app()->getLocale() === 'bn' ? 'https://উদাহরণ.com বা যেকোনো টেক্সট' : 'https://example.com or any text' }}">
            </div>

            <div class="form-group">
                <label class="form-label">{{ app()->getLocale() === 'bn' ? 'আকার (px):' : 'Size (px):' }}</label>
                <input type="range" id="qr-size" min="150" max="500" value="300" class="w-full accent-blue-600">
                <div class="flex justify-between text-xs text-gray-400 mt-1"><span>150</span><span id="size-label" class="font-semibold text-blue-600">300px</span><span>500</span></div>
            </div>

            <button id="btn-generate-qr" class="btn-primary w-full inline-flex items-center justify-center gap-2">
                <i class="fa-solid fa-qrcode"></i>
                <span>{{ app()->getLocale() === 'bn' ? 'QR কোড তৈরি করুন' : 'Generate QR Code' }}</span>
            </button>
            <p id="qr-error" class="text-red-500 text-sm mt-2 hidden"></p>
        </div>

        {{-- Output --}}
        <div class="card p-6 flex flex-col items-center justify-center min-h-64">
            <div id="qr-placeholder" class="text-center text-gray-300">
                <div class="w-16 h-16 bg-rose-50 text-rose-400 rounded-2xl flex items-center justify-center mx-auto mb-3 text-2xl">
                    <i class="fa-solid fa-qrcode"></i>
                </div>
                <p class="text-sm text-gray-400">{{ app()->getLocale() === 'bn' ? 'QR কোড এখানে দেখাবে' : 'QR code will appear here' }}</p>
            </div>
            <div id="qr-result" class="hidden text-center">
                <img id="qr-img" src="" alt="QR Code" class="rounded-xl shadow-lg border border-gray-100 mx-auto">
                <a id="qr-download" href="#" download="qrcode.png"
                   class="btn-primary mt-4 inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-download"></i>
                    <span>{{ app()->getLocale() === 'bn' ? 'ডাউনলোড' : 'Download PNG' }}</span>
                </a>
            </div>
            <div id="qr-loading" class="hidden">
                <div class="w-12 h-12 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin"></div>
                <p class="text-sm text-gray-400 mt-3">{{ app()->getLocale() === 'bn' ? 'তৈরি হচ্ছে...' : 'Generating...' }}</p>
            </div>
        </div>
    </div>

    @include('partials.tool-ad')
</div>

@push('scripts')
<script>
const sizeInput = document.getElementById('qr-size');
const sizeLabel = document.getElementById('size-label');
sizeInput.addEventListener('input', () => sizeLabel.textContent = sizeInput.value + 'px');

document.getElementById('btn-generate-qr').addEventListener('click', async () => {
    const text = document.getElementById('qr-text').value.trim();
    const size = sizeInput.value;
    const errEl = document.getElementById('qr-error');

    if (!text) { errEl.textContent = '{{ app()->getLocale() === "bn" ? "অনুগ্রহ করে টেক্সট লিখুন।" : "Please enter text or URL." }}'; errEl.classList.remove('hidden'); return; }
    errEl.classList.add('hidden');

    document.getElementById('qr-placeholder').classList.add('hidden');
    document.getElementById('qr-result').classList.add('hidden');
    document.getElementById('qr-loading').classList.remove('hidden');

    try {
        const res = await fetch('{{ route("tools.qr-generator.generate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'image/png',
            },
            body: JSON.stringify({ text, size: parseInt(size) }),
        });

        if (!res.ok) throw new Error('Server error');

        const blob = await res.blob();
        const url = URL.createObjectURL(blob);
        document.getElementById('qr-img').src = url;
        document.getElementById('qr-download').href = url;
        document.getElementById('qr-loading').classList.add('hidden');
        document.getElementById('qr-result').classList.remove('hidden');
    } catch(e) {
        document.getElementById('qr-loading').classList.add('hidden');
        document.getElementById('qr-placeholder').classList.remove('hidden');
        errEl.textContent = '{{ app()->getLocale() === "bn" ? "QR কোড তৈরি হয়নি।" : "Failed to generate QR code." }}';
        errEl.classList.remove('hidden');
    }
});
</script>
@endpush
@endsection
