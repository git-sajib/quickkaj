<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Google Analytics (gtag.js) --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-8622VZ0624"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-8622VZ0624');
    </script>

    {{-- OneSignal Web Push SDK --}}
    <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
    <script>
      window.OneSignalDeferred = window.OneSignalDeferred || [];
      OneSignalDeferred.push(async function(OneSignal) {
        await OneSignal.init({
          appId: "ad494923-3b51-440f-8492-d5ee702df0b6",
        });
      });
    </script>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    {{-- SEO Meta --}}
    <title>@yield('page_title', __('ui.site_name') . ' — ' . __('ui.site_tagline'))</title>
    <meta name="description" content="@yield('seo_description', __('ui.site_tagline'))">
    <meta name="robots" content="@yield('robots', 'index,follow')">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    {{-- Hreflang --}}
    @yield('hreflang')
    @unless($__env->hasSection('hreflang'))
        @php
            $canonicalPath = request()->path();
            $pathWithoutLocale = preg_replace('#^(bn|en)(/.*|$)#', '$2', $canonicalPath);
            $cleanLocalePath = ltrim($pathWithoutLocale, '/');
            $bnCanonicalUrl = url('/bn' . ($cleanLocalePath !== '' ? '/' . $cleanLocalePath : ''));
            $enCanonicalUrl = url('/en' . ($cleanLocalePath !== '' ? '/' . $cleanLocalePath : ''));
        @endphp
        <link rel="alternate" hreflang="bn" href="{{ $bnCanonicalUrl }}">
        <link rel="alternate" hreflang="en" href="{{ $enCanonicalUrl }}">
        <link rel="alternate" hreflang="x-default" href="{{ $bnCanonicalUrl }}">
    @endunless

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('og_title', __('ui.site_name'))">
    <meta property="og:description" content="@yield('og_description', __('ui.site_tagline'))">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:locale" content="{{ app()->getLocale() === 'bn' ? 'bn_BD' : 'en_US' }}">
    <meta name="twitter:card" content="summary_large_image">

    {{-- Google Fonts: Noto Sans Bengali for Bengali, Inter for English --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@300;400;500;600;700&family=Hind+Siliguri:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Font Awesome 6 Free — replaces emojis with professional icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">

    {{-- Tailwind CSS + App JS via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Toast notification system (Sonner-style) --}}
    <script src="{{ asset('js/toast.js') }}"></script>

</head>
<body class="bg-neutral-50 text-gray-900 font-body antialiased">

    {{-- Adsterra Header Banner (728x90) — toggled from Admin > Ad Placements --}}
    @if(!empty($headerAd))
        <div class="text-center bg-gray-50 py-1 border-b border-gray-100 flex items-center justify-center overflow-hidden min-h-[90px]">
            {!! $headerAd->html_code !!}
        </div>
    @endif

    {{-- Navigation --}}
    @include('partials.navbar')

    {{-- Universal Quick Search Modal (Cmd+K / Search button) --}}
    @include('partials.quick-search-modal')

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')

    {{-- Adsterra Footer Banner (728x90) --}}
    @php $footerAd = \App\Models\AdPlacement::getSlot('footer-banner'); @endphp
    @if(!empty($footerAd))
        <div class="text-center bg-gray-50 border-t border-gray-100 py-2">
            {!! $footerAd->html_code !!}
        </div>
    @endif

    {{-- Adsterra Social Bar / In-Page Push (global script — highest CTR format) --}}
    @if(!empty($socialBarAd))
        {!! $socialBarAd->html_code !!}
    @endif

    {{-- Adsterra Popunder / OnClick Script (Highest eCPM global format) --}}
    @php $popunderAd = \App\Models\AdPlacement::getSlot('popunder'); @endphp
    @if(!empty($popunderAd))
        {!! $popunderAd->html_code !!}
    @endif

    {{-- Fire session flash toasts --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        window.__plFlushSessionToasts({
            success: @json(session('success')),
            error:   @json(session('error') ?? ($errors->any() ? $errors->first() : null)),
            warning: @json(session('warning')),
            info:    @json(session('info')),
        });
    });
    </script>

    @stack('scripts')
</body>
</html>
