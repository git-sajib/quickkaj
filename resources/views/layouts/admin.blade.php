<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <title>@yield('page_title', 'Admin') — {{ __('ui.site_name') }}</title>

    {{-- Google Fonts: Noto Sans Bengali + Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@300;400;500;600;700&family=Hind+Siliguri:wght@300;400;500;600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Font Awesome 6 (Primary + Fallback CDNs) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Toast notification system --}}
    <script src="{{ asset('js/toast.js') }}"></script>

    <style>
        /* Bengali font for admin panel */
        :lang(bn), [lang="bn"] { font-family: 'Noto Sans Bengali', 'Hind Siliguri', sans-serif; }
        body { font-family: 'Inter', 'Noto Sans Bengali', 'Hind Siliguri', sans-serif; }
        .fa-solid, .fa-regular, .fa-brands, .fas, .far, .fab, [class*="fa-"] {
            font-family: 'Font Awesome 6 Free', 'Font Awesome 6 Brands', sans-serif !important;
        }
        .admin-sidebar-link { display:flex; align-items:center; gap:10px; padding:9px 12px; border-radius:10px; font-size:0.82rem; font-weight:500; color:#4b5563; transition:all .15s; text-decoration:none; }
        .admin-sidebar-link:hover { background:#f3f4f6; color:#111827; }
        .admin-sidebar-link-active { background:#eff6ff; color:#1d4ed8; font-weight:600; }
        .admin-sidebar-link .nav-icon { width:18px; height:18px; flex-shrink:0; text-align:center; display:inline-flex; align-items:center; justify-content:center; }
    </style>
</head>
<body class="bg-gray-100 antialiased text-gray-800">
<div class="flex min-h-screen">

    {{-- Mobile Drawer Backdrop --}}
    <div id="admin-sidebar-backdrop" class="fixed inset-0 bg-black/40 z-30 hidden lg:hidden transition-opacity duration-200"></div>

    {{-- Sidebar (Desktop + Mobile Slide-over) --}}
    <aside id="admin-sidebar" class="w-64 bg-white border-r border-gray-200 flex flex-col shadow-sm fixed inset-y-0 left-0 z-40 transform -translate-x-full lg:translate-x-0 transition-transform duration-200 ease-in-out">
        {{-- Logo --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <div class="flex items-center gap-2.5">
                <img src="{{ asset('images/logo-icon.png') }}" alt="{{ __('ui.site_name') }}" class="w-8 h-8 rounded-lg shadow-xs object-contain">
                <div>
                    <span class="font-extrabold text-gray-900 text-sm tracking-tight">{{ __('ui.site_name') }}</span>
                    <span class="block text-[10px] uppercase font-semibold tracking-wider text-blue-600">Admin Control</span>
                </div>
            </div>
            {{-- Close button on mobile --}}
            <button id="admin-sidebar-close" class="lg:hidden text-gray-400 hover:text-gray-600 p-1.5 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="admin-sidebar-link {{ request()->routeIs('admin.dashboard') ? 'admin-sidebar-link-active' : '' }}">
                <span class="nav-icon text-blue-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/></svg>
                </span>
                <span>{{ __('ui.dashboard') }}</span>
            </a>
            <a href="{{ route('admin.analytics.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.analytics.*') ? 'admin-sidebar-link-active' : '' }}">
                <span class="nav-icon text-violet-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </span>
                <span>{{ app()->getLocale() === 'bn' ? 'অ্যানালিটিক্স' : 'Analytics' }}</span>
            </a>

            <div class="pt-4 pb-1.5 px-3 text-[11px] font-bold text-gray-400 uppercase tracking-wider">{{ app()->getLocale() === 'bn' ? 'কন্টেন্ট ম্যানেজমেন্ট' : 'Content Management' }}</div>
            <a href="{{ route('admin.jobs.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.jobs.*') ? 'admin-sidebar-link-active' : '' }}">
                <span class="nav-icon text-emerald-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </span>
                <span>{{ __('ui.manage_jobs') }}</span>
            </a>
            <a href="{{ route('admin.articles.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.articles.*') ? 'admin-sidebar-link-active' : '' }}">
                <span class="nav-icon text-amber-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </span>
                <span>{{ __('ui.manage_articles') }}</span>
            </a>
            <a href="{{ route('admin.categories.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.categories.*') ? 'admin-sidebar-link-active' : '' }}">
                <span class="nav-icon text-teal-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                </span>
                <span>{{ __('ui.manage_categories') }}</span>
            </a>
            <a href="{{ route('admin.tags.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.tags.*') ? 'admin-sidebar-link-active' : '' }}">
                <span class="nav-icon text-indigo-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </span>
                <span>{{ __('ui.manage_tags') }}</span>
            </a>

            <div class="pt-4 pb-1.5 px-3 text-[11px] font-bold text-gray-400 uppercase tracking-wider">{{ app()->getLocale() === 'bn' ? 'টুলস ও বিজ্ঞাপন' : 'Tools & Ads' }}</div>
            <a href="{{ route('admin.short-urls.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.short-urls.*') ? 'admin-sidebar-link-active' : '' }}">
                <span class="nav-icon text-sky-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                </span>
                <span>{{ __('ui.manage_urls') }}</span>
            </a>
            <a href="{{ route('admin.ad-placements.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.ad-placements.*') ? 'admin-sidebar-link-active' : '' }}">
                <span class="nav-icon text-rose-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                </span>
                <span>{{ __('ui.manage_ads') }}</span>
            </a>

            <div class="pt-4 pb-1.5 px-3 text-[11px] font-bold text-gray-400 uppercase tracking-wider">{{ app()->getLocale() === 'bn' ? 'যোগাযোগ' : 'Inquiries' }}</div>
            <a href="{{ route('admin.contact-messages.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.contact-messages.*') ? 'admin-sidebar-link-active' : '' }}">
                <span class="nav-icon text-rose-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </span>
                <span class="flex-1">{{ app()->getLocale() === 'bn' ? 'কন্টাক্ট মেসেজ' : 'Contact Messages' }}</span>
                @php
                    $unreadMessagesCount = \App\Models\ContactMessage::where('is_read', false)->count();
                @endphp
                @if($unreadMessagesCount > 0)
                    <span class="text-[10px] font-bold bg-rose-500 text-white px-2 py-0.5 rounded-full">{{ $unreadMessagesCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.job-alerts.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.job-alerts.*') ? 'admin-sidebar-link-active' : '' }}">
                <span class="nav-icon text-emerald-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </span>
                <span class="flex-1">{{ app()->getLocale() === 'bn' ? 'জব অ্যালার্ট গ্রাহক' : 'Job Alert Subscribers' }}</span>
                @php
                    $activeJobAlertsCount = \App\Models\JobAlert::where('is_active', true)->count();
                @endphp
                <span class="text-[10px] font-bold bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full">{{ $activeJobAlertsCount }}</span>
            </a>

            <div class="pt-4 pb-1.5 px-3 text-[11px] font-bold text-gray-400 uppercase tracking-wider">{{ app()->getLocale() === 'bn' ? 'সিস্টেম' : 'System' }}</div>
            <a href="{{ route('admin.users.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.users.*') ? 'admin-sidebar-link-active' : '' }}">
                <span class="nav-icon text-blue-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </span>
                <span>{{ __('ui.users') }}</span>
            </a>
            <a href="{{ route('admin.settings.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.settings.*') ? 'admin-sidebar-link-active' : '' }}">
                <span class="nav-icon text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </span>
                <span>{{ __('ui.settings') }}</span>
            </a>
        </nav>

        {{-- User footer --}}
        <div class="border-t border-gray-100 px-4 py-3 bg-gray-50/50">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-8 h-8 bg-blue-100 text-blue-700 rounded-full flex items-center justify-center font-bold text-xs shrink-0">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="truncate">
                        <p class="text-xs font-semibold text-gray-800 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-gray-400 capitalize">{{ auth()->user()->role ?? 'admin' }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-7 h-7 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 flex items-center justify-center transition-colors" title="{{ __('ui.logout') }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Main area --}}
    <div class="flex-1 lg:ml-64 flex flex-col min-w-0">
        {{-- Top bar --}}
        <header class="bg-white border-b border-gray-200 px-4 sm:px-6 py-3 flex items-center justify-between sticky top-0 z-20 shadow-xs">
            <div class="flex items-center gap-3">
                {{-- Hamburger for mobile --}}
                <button id="admin-mobile-toggle" class="lg:hidden p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div>
                    <h1 class="text-base font-bold text-gray-900 leading-tight">@yield('page_title', __('ui.dashboard'))</h1>
                    @yield('breadcrumb')
                </div>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('home', ['locale' => 'bn']) }}" target="_blank"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    <span>{{ app()->getLocale() === 'bn' ? 'সাইট দেখুন' : 'View Site' }}</span>
                </a>
            </div>
        </header>

        {{-- Page content --}}
        <main class="flex-1 p-4 sm:p-6">
            @yield('admin-content')
        </main>
    </div>
</div>

{{-- Mobile Sidebar Drawer Toggle Script --}}
<script>
(function () {
    const sidebar  = document.getElementById('admin-sidebar');
    const backdrop = document.getElementById('admin-sidebar-backdrop');
    const toggle   = document.getElementById('admin-mobile-toggle');
    const closeBtn = document.getElementById('admin-sidebar-close');

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        backdrop.classList.remove('hidden');
    }
    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        backdrop.classList.add('hidden');
    }

    if (toggle) toggle.addEventListener('click', openSidebar);
    if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
    if (backdrop) backdrop.addEventListener('click', closeSidebar);
})();
</script>

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
