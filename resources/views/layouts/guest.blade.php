<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <title>{{ config('app.name', 'Quickkaj') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('js/toast.js') }}"></script>
</head>
<body class="font-sans text-gray-900 antialiased bg-gradient-to-br from-blue-50 via-white to-violet-50 min-h-screen">

    <div class="min-h-screen flex flex-col items-center justify-center px-4 py-12">

        {{-- Logo --}}
        <a href="{{ url('/bn') }}" class="flex items-center gap-3 mb-8 group">
            <img src="{{ asset('images/logo-icon.png') }}" alt="Quickkaj" class="w-14 h-14 rounded-2xl shadow-lg group-hover:scale-105 transition-transform duration-200 object-contain">
            <span class="text-2xl font-extrabold bg-gradient-to-r from-blue-600 to-violet-600 bg-clip-text text-transparent">
                Quickkaj
            </span>
        </a>

        {{-- Card --}}
        <div class="w-full max-w-md bg-white rounded-3xl shadow-xl border border-gray-100 px-8 py-8">
            {{ $slot }}
        </div>

        <p class="mt-6 text-xs text-gray-400">
            &copy; {{ date('Y') }} Quickkaj. All rights reserved.
        </p>
    </div>

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

</body>
</html>

