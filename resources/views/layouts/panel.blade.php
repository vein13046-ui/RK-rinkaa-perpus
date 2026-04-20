@php
    $requestUserAgent = strtolower((string) request()->userAgent());
    $secChUaMobile = strtolower((string) request()->header('sec-ch-ua-mobile'));
    $isAndroidDevice = str_contains($requestUserAgent, 'android');
    $isIosDevice = str_contains($requestUserAgent, 'iphone') || str_contains($requestUserAgent, 'ipad') || str_contains($requestUserAgent, 'ipod');
    $isMobileDevice = $secChUaMobile === '?1'
        || $isAndroidDevice
        || $isIosDevice
        || str_contains($requestUserAgent, 'mobile');
@endphp

<!DOCTYPE html>
<html lang="id" class="{{ $isMobileDevice ? 'device-mobile-server' : 'device-desktop-server' }} {{ $isAndroidDevice ? 'device-android-server' : '' }} {{ $isIosDevice ? 'device-ios-server' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>RinKa Perpus - @yield('page-title', 'Dashboard')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <script>
        (function () {
            const ua = navigator.userAgent || '';
            const isAndroid = /Android/i.test(ua);
            const isIos = /(iPhone|iPad|iPod)/i.test(ua);
            const isMobileUa = /(Mobi|Mobile|Android|iPhone|iPad|iPod|Opera Mini|IEMobile)/i.test(ua);
            const isTouchDevice = (navigator.maxTouchPoints || 0) > 0 || 'ontouchstart' in window;
            const minViewportSide = Math.min(window.innerWidth || 0, window.innerHeight || 0);
            const isCompactViewport = minViewportSide > 0 && minViewportSide <= 1024;
            const isMobile = isMobileUa || (isTouchDevice && isCompactViewport);

            const root = document.documentElement;
            root.classList.toggle('device-mobile-active', isMobile);
            root.classList.toggle('device-desktop-active', !isMobile);
            root.classList.toggle('device-android-active', isAndroid);
            root.classList.toggle('device-ios-active', isIos);
            root.setAttribute('data-device-mobile', isMobile ? '1' : '0');
            root.setAttribute('data-device-platform', isAndroid ? 'android' : (isIos ? 'ios' : 'desktop'));
        })();
    </script>
    <script>
        (function () {
            try {
                if (localStorage.getItem('rinka-theme') === 'dark') {
                    document.documentElement.classList.add('theme-dark');
                }
            } catch (e) {}
        })();
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            color-scheme: light;
        }
        html.theme-dark {
            color-scheme: dark;
            --dm-bg: #0f141d;
            --dm-surface: #151c28;
            --dm-surface-2: #1b2432;
            --dm-soft: #222d3f;
            --dm-border: #2d394d;
            --dm-text: #edf2fa;
            --dm-muted: #aab6c9;
            --dm-accent: #4f77ff;
            --dm-accent-soft: #273857;
            --dm-accent-text: #dbe6ff;
        }
        body {
            font-family: 'Inter', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.12), transparent 32%),
                radial-gradient(circle at top right, rgba(16, 185, 129, 0.10), transparent 28%),
                linear-gradient(180deg, #f8fafc 0%, #eef4ff 100%);
            transition: background 0.25s ease, color 0.25s ease;
        }
        html.theme-dark body {
            color: var(--dm-text);
            background: var(--dm-bg);
        }
        html.theme-dark .bg-white,
        html.theme-dark .bg-white\/85,
        html.theme-dark .bg-white\/75 {
            background-color: var(--dm-surface) !important;
        }
        html.theme-dark .bg-slate-50,
        html.theme-dark .bg-slate-50\/70,
        html.theme-dark .bg-slate-50\/80,
        html.theme-dark .bg-slate-100 {
            background-color: var(--dm-surface-2) !important;
        }
        html.theme-dark .bg-blue-50,
        html.theme-dark .bg-emerald-50,
        html.theme-dark .bg-amber-50,
        html.theme-dark .bg-rose-100,
        html.theme-dark .bg-violet-100 {
            background-color: var(--dm-accent-soft) !important;
        }
        html.theme-dark .border-slate-100,
        html.theme-dark .border-slate-200,
        html.theme-dark .border-slate-200\/80,
        html.theme-dark .border-emerald-200,
        html.theme-dark .border-amber-200,
        html.theme-dark .border-rose-200 {
            border-color: var(--dm-border) !important;
        }
        html.theme-dark .text-slate-900,
        html.theme-dark .text-slate-800,
        html.theme-dark .text-slate-700 {
            color: var(--dm-text) !important;
        }
        html.theme-dark .text-slate-600,
        html.theme-dark .text-slate-500,
        html.theme-dark .text-slate-400 {
            color: var(--dm-muted) !important;
        }
        html.theme-dark input,
        html.theme-dark select,
        html.theme-dark textarea {
            background-color: #101828 !important;
            border-color: var(--dm-border) !important;
            color: var(--dm-text) !important;
        }
        html.theme-dark input::placeholder,
        html.theme-dark textarea::placeholder {
            color: #7f8ca1 !important;
        }
        html.theme-dark [class*="shadow"] {
            box-shadow: none !important;
        }
        html.theme-dark .backdrop-blur-xl {
            backdrop-filter: none !important;
        }
        html.theme-dark .animate-pulse {
            animation: none !important;
        }
        html.theme-dark .bg-gradient-to-r,
        html.theme-dark .bg-gradient-to-br,
        html.theme-dark .bg-gradient-to-l,
        html.theme-dark .bg-gradient-to-t {
            background-image: none !important;
            background-color: var(--dm-surface-2) !important;
        }
        html.theme-dark .bg-blue-600,
        html.theme-dark .bg-cyan-600,
        html.theme-dark .bg-indigo-700,
        html.theme-dark .bg-indigo-600 {
            background-color: var(--dm-accent) !important;
        }
        html.theme-dark .bg-amber-100 {
            background-color: rgba(245, 158, 11, 0.16) !important;
        }
        html.theme-dark .bg-emerald-100 {
            background-color: rgba(16, 185, 129, 0.16) !important;
        }
        html.theme-dark .bg-blue-100 {
            background-color: rgba(59, 130, 246, 0.16) !important;
        }
        html.theme-dark .bg-violet-100 {
            background-color: rgba(139, 92, 246, 0.16) !important;
        }
        html.theme-dark .bg-violet-50 {
            background-color: rgba(0, 0, 0, 0.1) !important;
        }
        html.theme-dark .bg-sky-100 {
            background-color: rgba(56, 189, 248, 0.16) !important;
        }
        html.theme-dark .bg-rose-100 {
            background-color: rgba(244, 63, 94, 0.16) !important;
        }
        html.theme-dark .hover\:bg-blue-50:hover,
        html.theme-dark .hover\:bg-slate-50:hover,
        html.theme-dark .hover\:bg-slate-50\/50:hover,
        html.theme-dark .hover\:bg-slate-50\/70:hover,
        html.theme-dark .hover\:bg-slate-50\/80:hover,
        html.theme-dark .hover\:bg-white\/20:hover,
        html.theme-dark .hover\:bg-cyan-50:hover,
        html.theme-dark .hover\:bg-rose-50:hover {
            background-color: var(--dm-soft) !important;
        }
        html.theme-dark .text-blue-700,
        html.theme-dark .text-blue-600,
        html.theme-dark .text-cyan-700,
        html.theme-dark .text-indigo-600,
        html.theme-dark .text-emerald-600,
        html.theme-dark .text-violet-600,
        html.theme-dark .text-amber-700,
        html.theme-dark .text-rose-600 {
            color: var(--dm-accent-text) !important;
        }
        html.theme-dark .hover\:text-blue-700:hover,
        html.theme-dark .hover\:text-blue-800:hover,
        html.theme-dark .hover\:text-rose-600:hover {
            color: #ffffff !important;
        }
        html.theme-dark .ring-white {
            --tw-ring-color: var(--dm-border) !important;
        }
        html.theme-dark .bg-black\/15 {
            background-color: rgba(15, 20, 29, 0.35) !important;
        }
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #e2e8f0;
        }
        ::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 999px;
        }
        html.theme-dark ::-webkit-scrollbar-track {
            background: #18202e;
        }
        html.theme-dark ::-webkit-scrollbar-thumb {
            background: #3a4a61;
        }
        .mobile-nav-shell {
            display: none;
        }
        html.device-mobile-server .mobile-nav-shell,
        html.device-mobile-active .mobile-nav-shell {
            display: block;
            position: fixed;
            left: 0.75rem;
            right: 0.75rem;
            bottom: max(0.65rem, env(safe-area-inset-bottom));
            z-index: 60;
        }
        html.device-mobile-server main,
        html.device-mobile-active main {
            padding-bottom: 6.8rem !important;
        }
        .mobile-nav-link {
            min-height: 3.25rem;
        }
        @media (min-width: 1024px) {
            .mobile-nav-shell {
                display: none !important;
            }
            html.device-mobile-server main,
            html.device-mobile-active main {
                padding-bottom: 2rem !important;
            }
        }
    </style>
</head>
<body class="text-slate-700 antialiased min-h-screen">
    @php
        $user = Auth::user();
        $isAdmin = ($user->role ?? 'user') === 'admin';
        $activeDashboard = request()->routeIs('dashboard');
        $activeBooks = request()->routeIs('admin.books.*');
        $activeUsers = request()->routeIs('admin.users.*');
        $activeUserBooks = request()->routeIs('user.books');
        $activeBorrowStatus = request()->routeIs('borrow.user.index') || request()->routeIs('admin.borrow.*');
        $activeHistory = request()->routeIs('borrow.history');
        $activeSupport = request()->routeIs('support.*');
        $activeProfile = request()->routeIs('profile');
        $borrowNotificationCount = $borrowNotificationCount ?? 0;
        $borrowNotifications = $borrowNotifications ?? collect();
        $supportUnreadCount = $supportUnreadCount ?? 0;
    @endphp

    <div class="min-h-screen flex">
        <aside class="hidden lg:flex w-80 h-screen sticky top-0 flex-col overflow-y-auto border-r border-slate-200/80 bg-white/85 backdrop-blur-xl shadow-[12px_0_40px_rgba(15,23,42,0.04)]">
            <div class="px-8 py-7 border-b border-slate-100">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 text-white flex items-center justify-center font-black text-xl shadow-lg shadow-blue-200">
                        RK
                    </div>
                    <div>
                        <p class="text-sm uppercase  tracking-[0.24em] text-slate-400 font-semibold">Library Suite</p>
                        <h1 class="text-xl font-extrabold text-slate-900 leading-tight">RinKa <span class="text-blue-600">Perpus</span></h1>
                    </div>
                </a>
            </div>

            <nav class="flex-1 px-5 py-6 space-y-2">
                <p class="px-3 mb-3 text-[11px] font-bold uppercase tracking-[0.24em] text-slate-400">Menu Utama</p>

                <a href="{{ route('dashboard') }}" class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ $activeDashboard ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-700' }}">
                    <span class="w-10 h-10 rounded-xl flex items-center justify-center {{ $activeDashboard ? 'bg-black/15' : 'bg-blue-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </span>
                    <span class="font-semibold">Dashboard</span>
                </a>

                @if ($isAdmin)
                    <a href="{{ route('admin.books.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ $activeBooks ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-700' }}">
                        <span class="w-10 h-10 rounded-xl flex items-center justify-center {{ $activeBooks ? 'bg-black/15' : 'bg-blue-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </span>
                        <span class="font-semibold">Data Buku</span>
                    </a>
                    <a href="{{ route('admin.books.create') }}" class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('admin.books.create') ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-700' }}">
                        <span class="w-10 h-10 rounded-xl flex items-center justify-center {{ request()->routeIs('admin.books.create') ? 'bg-black/15' : 'bg-emerald-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </span>
                        <span class="font-semibold">Tambah Buku</span>
                    </a>
                @else
                    <a href="{{ route('user.books') }}" class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ $activeUserBooks ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-700' }}">
                        <span class="w-10 h-10 rounded-xl flex items-center justify-center {{ $activeUserBooks ? 'bg-black/15' : 'bg-blue-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </span>
                        <span class="font-semibold">Daftar Buku</span>
                    </a>
                @endif

                @if ($isAdmin)
                    <a href="{{ route('admin.borrow.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ $activeBorrowStatus ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-700' }}">
                        <span class="w-10 h-10 rounded-xl flex items-center justify-center {{ $activeBorrowStatus ? 'bg-black/15' : 'bg-amber-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </span>
                        <span class="font-semibold">Status Peminjaman</span>
                        @if ($borrowNotificationCount > 0)
                            <span class="ml-auto inline-flex items-center rounded-full bg-rose-100 px-2.5 py-1 text-[11px] font-bold text-rose-600">{{ number_format($borrowNotificationCount) }}</span>
                        @endif
                    </a>
                    <a href="{{ route('borrow.history') }}" class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ $activeHistory ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-700' }}">
                        <span class="w-10 h-10 rounded-xl flex items-center justify-center {{ $activeHistory ? 'bg-black/15' : 'bg-slate-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </span>
                        <span class="font-semibold">Riwayat Peminjaman</span>
                    </a>
                    <a href="{{ route('support.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ $activeSupport ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-700' }}">
                        <span class="relative w-10 h-10 rounded-xl flex items-center justify-center {{ $activeSupport ? 'bg-black/15' : 'bg-cyan-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12a8 8 0 018-8h0a8 8 0 018 8v2a4 4 0 01-4 4h-1l-2 3v-3H8a4 4 0 01-4-4v-2z"></path>
                            </svg>
                            @if ($supportUnreadCount > 0)
                                <span class="absolute -top-1 -right-1 inline-flex min-w-5 h-5 items-center justify-center rounded-full bg-rose-500 px-1 text-[10px] font-bold text-white ring-2 ring-white">{{ $supportUnreadCount > 9 ? '9+' : $supportUnreadCount }}</span>
                            @endif
                        </span>
                        <span class="font-semibold">Customer Service</span>
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ $activeUsers ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-700' }}">
                        <span class="w-10 h-10 rounded-xl flex items-center justify-center {{ $activeUsers ? 'bg-black/15' : 'bg-violet-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </span>
                        <span class="font-semibold">Daftar Pengguna</span>
                    </a>
                @else
                    <a href="{{ route('borrow.user.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ $activeBorrowStatus ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-700' }}">
                        <span class="w-10 h-10 rounded-xl flex items-center justify-center {{ $activeBorrowStatus ? 'bg-black/15' : 'bg-amber-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </span>
                        <span class="font-semibold">Status Peminjaman</span>
                        @if ($borrowNotificationCount > 0)
                            <span class="ml-auto inline-flex items-center rounded-full bg-rose-100 px-2.5 py-1 text-[11px] font-bold text-rose-600">{{ number_format($borrowNotificationCount) }}</span>
                        @endif
                    </a>
                    <a href="{{ route('borrow.history') }}" class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ $activeHistory ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-700' }}">
                        <span class="w-10 h-10 rounded-xl flex items-center justify-center {{ $activeHistory ? 'bg-black/15' : 'bg-slate-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </span>
                        <span class="font-semibold">Riwayat Peminjaman</span>
                    </a>
                    <a href="{{ route('support.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ $activeSupport ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-700' }}">
                        <span class="relative w-10 h-10 rounded-xl flex items-center justify-center {{ $activeSupport ? 'bg-black/15' : 'bg-cyan-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12a8 8 0 018-8h0a8 8 0 018 8v2a4 4 0 01-4 4h-1l-2 3v-3H8a4 4 0 01-4-4v-2z"></path>
                            </svg>
                            @if ($supportUnreadCount > 0)
                                <span class="absolute -top-1 -right-1 inline-flex min-w-5 h-5 items-center justify-center rounded-full bg-rose-500 px-1 text-[10px] font-bold text-white ring-2 ring-white">{{ $supportUnreadCount > 9 ? '9+' : $supportUnreadCount }}</span>
                            @endif
                        </span>
                        <span class="font-semibold">Customer Service</span>
                    </a>
                @endif
            </nav>

            <div class="px-5 pb-6">
                <div class="rounded-3xl border border-slate-200 bg-gradient-to-br from-slate-50 to-white p-5 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl overflow-hidden ring-2 ring-white shadow-md">
                            <img src="{{ $user->profilePhotoUrl() }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-bold text-slate-900 truncate">{{ $user->name }}</p>
                            <p class="text-xs text-slate-500 capitalize">{{ $user->role }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="mt-4">
                        @csrf
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="flex-1 min-w-0">
            <header class="sticky top-0 z-20 border-b border-slate-200/80 bg-white/75 backdrop-blur-xl">
                <div class="px-4 sm:px-6 lg:px-8 min-h-20 py-3 flex items-start sm:items-center justify-between gap-3 sm:gap-4">
                    <div class="min-w-0 flex-1">
                        <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-slate-400">RinKa Perpus</p>
                        <h2 class="text-xl sm:text-2xl font-black tracking-tight text-slate-900 truncate">@yield('page-title', 'Dashboard')</h2>
                        @hasSection('page-description')
                            <p class="hidden sm:block text-sm text-slate-500 mt-1 truncate">@yield('page-description')</p>
                        @endif
                    </div>

                    <div class="flex shrink-0 items-center gap-2 sm:gap-3">
                        <button id="themeToggle" type="button" class="inline-flex h-12 w-12 items-center justify-center rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:border-blue-200 hover:shadow-md" aria-label="Aktifkan mode gelap" title="Mode gelap">
                            <svg id="themeIconMoon" class="h-5 w-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z"></path>
                            </svg>
                            <svg id="themeIconSun" class="hidden h-5 w-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364 6.364l-1.414-1.414M7.05 7.05 5.636 5.636m12.728 0L16.95 7.05M7.05 16.95l-1.414 1.414M12 8a4 4 0 100 8 4 4 0 000-8z"></path>
                            </svg>
                        </button>

                        <div class="relative">
                            <button id="notifBtn" type="button" class="relative inline-flex items-center justify-center h-12 w-12 rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:border-blue-200 hover:shadow-md" aria-label="Notifikasi">
                                <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                                @if ($borrowNotificationCount > 0)
                                    <span class="absolute top-2.5 right-2.5 h-2.5 w-2.5 rounded-full bg-rose-500 ring-2 ring-white"></span>
                                @endif
                            </button>

                            <div id="notifDropdown" class="absolute right-0 mt-3 w-[min(20rem,calc(100vw-1rem))] sm:w-80 rounded-3xl border border-slate-200 bg-white p-2 shadow-2xl opacity-0 invisible scale-95 origin-top-right transition-all duration-200 z-50">
                                <div class="px-4 py-4 border-b border-slate-100">
                                    <p class="text-sm font-bold text-slate-900">Notifikasi</p>
                                    <p class="text-xs text-slate-500 mt-1">{{ $isAdmin ? 'Permintaan peminjaman yang menunggu konfirmasi' : 'Status peminjaman terbaru dari akunmu' }}</p>
                                </div>
                                <div class="space-y-1 py-2 max-h-80 overflow-y-auto">
                                    @forelse ($borrowNotifications as $notification)
                                        <div class="rounded-2xl px-4 py-3 hover:bg-slate-50 transition">
                                            @if ($isAdmin)
                                                <p class="text-sm font-semibold text-slate-900">{{ $notification->borrower_name }}</p>
                                                <p class="text-xs text-slate-500 mt-1">{{ $notification->book->judul ?? 'Buku' }} - {{ $notification->borrow_days }} hari</p>
                                                <p class="text-xs text-amber-600 mt-1">{{ $notification->status === 'return_pending' ? 'Menunggu persetujuan pengembalian' : 'Menunggu konfirmasi peminjaman' }}</p>
                                            @else
                                                <p class="text-sm font-semibold text-slate-900">{{ $notification->book->judul ?? 'Buku' }}</p>
                                                <p class="text-xs text-slate-500 mt-1">Status: <span class="font-semibold capitalize text-slate-700">{{ $notification->status_label }}</span></p>
                                                @if ($notification->status === 'approved' && $notification->pickup_deadline)
                                                    <p class="text-xs text-amber-600 mt-1">Segera ambil dalam 8 jam</p>
                                                @elseif ($notification->status === 'return_pending')
                                                    <p class="text-xs text-violet-600 mt-1">Menunggu admin menyetujui pengembalian</p>
                                                @endif
                                            @endif
                                        </div>
                                    @empty
                                        <div class="rounded-2xl px-4 py-8 text-center text-sm text-slate-500">
                                            {{ $isAdmin ? 'Belum ada permintaan pinjam baru.' : 'Belum ada status peminjaman.' }}
                                        </div>
                                    @endforelse
                                </div>
                                <div class="p-2 border-t border-slate-100">
                                    <a href="{{ $isAdmin ? route('admin.borrow.index') : route('borrow.user.index') }}" class="flex items-center justify-center rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                                        Buka Halaman Status
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="relative">
                            <button id="profileBtn" class="flex max-w-[14rem] items-center gap-3 rounded-2xl border border-slate-200 bg-white px-3 py-2.5 shadow-sm transition hover:border-blue-200 hover:shadow-md">
                                <img src="{{ $user->profilePhotoUrl() }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-xl object-cover">
                                <div class="hidden lg:block min-w-0 text-left">
                                    <p class="text-sm font-semibold text-slate-900 leading-tight truncate">{{ $user->name }}</p>
                                    <p class="text-xs text-slate-500 capitalize">{{ $user->role }}</p>
                                </div>
                            </button>

                            <div id="profileDropdown" class="absolute right-0 mt-3 w-[min(18rem,calc(100vw-1rem))] sm:w-72 rounded-3xl border border-slate-200 bg-white p-2 shadow-2xl opacity-0 invisible scale-95 origin-top-right transition-all duration-200 z-50">
                                <div class="px-4 py-4 border-b border-slate-100">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $user->profilePhotoUrl() }}" alt="{{ $user->name }}" class="w-12 h-12 rounded-2xl object-cover shadow-sm">
                                        <div class="min-w-0">
                                            <p class="font-bold text-slate-900 truncate">{{ $user->name }}</p>
                                            <p class="text-sm text-slate-500 truncate">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('profile') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-blue-50 hover:text-blue-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Buka Profil
                                </a>
                                <a href="{{ route('app.info') }}" class="w-full flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-blue-50 hover:text-blue-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z"></path>
                                    </svg>
                                    Info Aplikasi
                                </a>
                                <a href="{{ route('support.index') }}" class="w-full flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-cyan-50 hover:text-cyan-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12a8 8 0 018-8h0a8 8 0 018 8v2a4 4 0 01-4 4h-1l-2 3v-3H8a4 4 0 01-4-4v-2z"></path>
                                    </svg>
                                    Customer Service
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="mt-1 border-t border-slate-100">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-rose-50 hover:text-rose-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="px-4 sm:px-6 lg:px-8 py-6 lg:py-8 pb-28 lg:pb-8">
                @yield('content')
            </main>

            <nav class="mobile-nav-shell lg:hidden" aria-label="Navigasi Mobile">
                <div class="grid grid-cols-4 items-center gap-1 rounded-3xl border border-slate-200/90 bg-white/95 p-2 shadow-2xl shadow-slate-900/10 backdrop-blur-md">
                    <a href="{{ route('dashboard') }}" class="mobile-nav-link flex flex-col items-center justify-center gap-1 rounded-2xl px-2 text-[11px] font-semibold transition {{ $activeDashboard ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-600 hover:bg-slate-100' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span>Home</span>
                    </a>

                    <a href="{{ $isAdmin ? route('admin.books.index') : route('user.books') }}" class="mobile-nav-link flex flex-col items-center justify-center gap-1 rounded-2xl px-2 text-[11px] font-semibold transition {{ ($isAdmin ? $activeBooks : $activeUserBooks) ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-600 hover:bg-slate-100' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span>Buku</span>
                    </a>

                    <a href="{{ $isAdmin ? route('admin.borrow.index') : route('borrow.user.index') }}" class="mobile-nav-link relative flex flex-col items-center justify-center gap-1 rounded-2xl px-2 text-[11px] font-semibold transition {{ $activeBorrowStatus ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-600 hover:bg-slate-100' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Status</span>
                        @if ($borrowNotificationCount > 0)
                            <span class="absolute right-3 top-2 inline-flex h-2.5 w-2.5 rounded-full bg-rose-500 ring-2 ring-white"></span>
                        @endif
                    </a>

                    <a href="{{ route('profile') }}" class="mobile-nav-link flex flex-col items-center justify-center gap-1 rounded-2xl px-2 text-[11px] font-semibold transition {{ $activeProfile ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-600 hover:bg-slate-100' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Profil</span>
                    </a>
                </div>
            </nav>
        </div>
    </div>

    <script>
        const themeToggle = document.getElementById('themeToggle');
        const themeIconMoon = document.getElementById('themeIconMoon');
        const themeIconSun = document.getElementById('themeIconSun');
        const themeStorageKey = 'rinka-theme';
        const notifBtn = document.getElementById('notifBtn');
        const notifDropdown = document.getElementById('notifDropdown');
        const profileBtn = document.getElementById('profileBtn');
        const dropdown = document.getElementById('profileDropdown');

        function refreshDeviceProfileClass() {
            const ua = navigator.userAgent || '';
            const isAndroid = /Android/i.test(ua);
            const isIos = /(iPhone|iPad|iPod)/i.test(ua);
            const isMobileUa = /(Mobi|Mobile|Android|iPhone|iPad|iPod|Opera Mini|IEMobile)/i.test(ua);
            const isTouchDevice = (navigator.maxTouchPoints || 0) > 0 || 'ontouchstart' in window;
            const minViewportSide = Math.min(window.innerWidth || 0, window.innerHeight || 0);
            const isCompactViewport = minViewportSide > 0 && minViewportSide <= 1024;
            const isMobile = isMobileUa || (isTouchDevice && isCompactViewport);

            const root = document.documentElement;
            root.classList.toggle('device-mobile-active', isMobile);
            root.classList.toggle('device-desktop-active', !isMobile);
            root.classList.toggle('device-android-active', isAndroid);
            root.classList.toggle('device-ios-active', isIos);
            root.setAttribute('data-device-mobile', isMobile ? '1' : '0');
            root.setAttribute('data-device-platform', isAndroid ? 'android' : (isIos ? 'ios' : 'desktop'));
        }

        refreshDeviceProfileClass();
        window.addEventListener('resize', refreshDeviceProfileClass, { passive: true });
        window.addEventListener('orientationchange', refreshDeviceProfileClass);

        function applyTheme(mode) {
            const isDark = mode === 'dark';
            document.documentElement.classList.toggle('theme-dark', isDark);

            if (themeIconMoon && themeIconSun) {
                themeIconMoon.classList.toggle('hidden', isDark);
                themeIconSun.classList.toggle('hidden', !isDark);
            }

            if (themeToggle) {
                const label = isDark ? 'Aktifkan mode terang' : 'Aktifkan mode gelap';
                const title = isDark ? 'Mode terang' : 'Mode gelap';
                themeToggle.setAttribute('aria-label', label);
                themeToggle.setAttribute('title', title);
            }
        }

        try {
            const savedTheme = localStorage.getItem(themeStorageKey);
            applyTheme(savedTheme === 'dark' ? 'dark' : 'light');
        } catch (e) {
            applyTheme('light');
        }

        if (themeToggle) {
            themeToggle.addEventListener('click', function () {
                const isDark = document.documentElement.classList.contains('theme-dark');
                const nextMode = isDark ? 'light' : 'dark';
                applyTheme(nextMode);
                try {
                    localStorage.setItem(themeStorageKey, nextMode);
                } catch (e) {}
            });
        }

        if (notifBtn && notifDropdown) {
            notifBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                notifDropdown.classList.toggle('opacity-100');
                notifDropdown.classList.toggle('invisible');
                notifDropdown.classList.toggle('scale-100');
                notifDropdown.classList.toggle('opacity-0');
                notifDropdown.classList.toggle('scale-95');
            });
        }

        if (profileBtn && dropdown) {
            profileBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                dropdown.classList.toggle('opacity-100');
                dropdown.classList.toggle('invisible');
                dropdown.classList.toggle('scale-100');
                dropdown.classList.toggle('opacity-0');
                dropdown.classList.toggle('scale-95');
            });

            document.addEventListener('click', function () {
                if (notifDropdown) {
                    notifDropdown.classList.add('opacity-0', 'invisible', 'scale-95');
                    notifDropdown.classList.remove('opacity-100', 'scale-100');
                }
                dropdown.classList.add('opacity-0', 'invisible', 'scale-95');
                dropdown.classList.remove('opacity-100', 'scale-100');
            });
        }

        function initializeSearchInputs() {
            document.querySelectorAll('.search-input').forEach(function (input) {
                var targetSelector = input.dataset.searchTarget;
                var rowsSelector = input.dataset.searchRows;
                if (!targetSelector || !rowsSelector) {
                    return;
                }

                var target = document.querySelector(targetSelector);
                var wrapper = input.closest('.relative') || input.parentElement;
                var popup = wrapper?.querySelector('.search-popup');
                var popupOverlay = wrapper?.querySelector('.search-popup-overlay');
                var closeButton = wrapper?.querySelector('.search-close');
                var count = popup?.querySelector('.search-count');
                var status = wrapper?.querySelector('.search-status');
                var button = wrapper?.querySelector('.search-button') || input.nextElementSibling;
                var hidePopupTimer = null;

                function buildPopupResults(matches) {
                    if (!popup) {
                        return;
                    }

                    var body = popup.querySelector('.search-popup-body');
                    var head = popup.querySelector('.search-popup-head');
                    if (!body) {
                        return;
                    }

                    body.innerHTML = '';
                    if (head) {
                        var targetHead = target.querySelector('thead');
                        if (targetHead) {
                            head.innerHTML = targetHead.innerHTML;
                        } else {
                            head.innerHTML = '<tr><th class="px-3 py-3 text-left text-xs uppercase tracking-[0.18em] text-slate-400">Hasil</th></tr>';
                        }
                    }

                    if (matches.length === 0) {
                        body.innerHTML = '<tr><td class="px-3 py-3 text-sm text-slate-500">Tidak ada hasil yang cocok.</td></tr>';
                        return;
                    }

                    matches.forEach(function (row) {
                        if (row.tagName && row.tagName.toLowerCase() === 'tr') {
                            var clone = row.cloneNode(true);
                            clone.style.display = '';
                            body.appendChild(clone);
                        } else {
                            var text = row.textContent.trim().replace(/\s+/g, ' ');
                            var tr = document.createElement('tr');
                            var td = document.createElement('td');
                            td.setAttribute('colspan', '100');
                            td.className = 'px-3 py-3 text-sm text-slate-700';
                            td.textContent = text;
                            tr.appendChild(td);
                            body.appendChild(tr);
                        }
                    });
                }

                function hidePopup() {
                    if (hidePopupTimer) {
                        clearTimeout(hidePopupTimer);
                        hidePopupTimer = null;
                    }

                    if (popup) {
                        popup.classList.add('opacity-0', 'scale-95');
                        popup.classList.remove('opacity-100', 'scale-100');
                        hidePopupTimer = setTimeout(function () {
                            popup.classList.add('hidden');
                            hidePopupTimer = null;
                        }, 250);
                    }
                    if (popupOverlay) {
                        popupOverlay.classList.add('hidden');
                    }
                }

                function showPopup() {
                    if (hidePopupTimer) {
                        clearTimeout(hidePopupTimer);
                        hidePopupTimer = null;
                    }

                    if (popupOverlay) {
                        popupOverlay.classList.remove('hidden');
                    }
                    if (popup) {
                        popup.classList.remove('hidden');
                        requestAnimationFrame(function () {
                            popup.classList.remove('opacity-0', 'scale-95');
                            popup.classList.add('opacity-100', 'scale-100');
                        });
                    }
                }

                function updateSearch(openPopup) {
                    var query = input.value.trim().toLowerCase();
                    var matchedRows = [];
                    if (!target) {
                        return;
                    }

                    target.querySelectorAll(rowsSelector).forEach(function (row) {
                        var key = (row.dataset.searchKey || '').toLowerCase();
                        var visible = !query || key.indexOf(query) !== -1;
                        row.style.display = visible ? '' : 'none';
                        if (visible) {
                            matchedRows.push(row);
                        }
                    });

                    if (status) {
                        if (query && matchedRows.length === 0) {
                            status.textContent = 'Data tidak ditemukan untuk "' + query + '". Mohon cek kata kunci lagi.';
                            status.classList.remove('hidden');
                        } else {
                            status.classList.add('hidden');
                        }
                    }

                    if (popup && count) {
                        if (!query || !openPopup) {
                            hidePopup();
                        } else {
                            showPopup();
                            count.textContent = matchedRows.length > 0
                                ? 'Menampilkan ' + matchedRows.length + ' hasil untuk "' + query + '"'
                                : 'Tidak ada hasil untuk "' + query + '"';
                            buildPopupResults(matchedRows);
                        }
                    }
                }

                input.addEventListener('input', function () {
                    updateSearch(true);
                });

                input.addEventListener('keydown', function (event) {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        updateSearch(true);
                    }
                });

                if (button) {
                    button.addEventListener('click', function () {
                        updateSearch(true);
                        input.focus();
                    });
                }

                if (popupOverlay) {
                    popupOverlay.addEventListener('click', function () {
                        hidePopup();
                    });
                }

                if (closeButton) {
                    closeButton.addEventListener('click', function () {
                        hidePopup();
                    });
                }

                document.addEventListener('click', function (event) {
                    if (popup && !input.contains(event.target) && !popup.contains(event.target) && !button?.contains(event.target) && !popupOverlay?.contains(event.target)) {
                        hidePopup();
                    }
                });
            });
        }

        initializeSearchInputs();
    </script>
    @stack('scripts')
</body>
</html>
