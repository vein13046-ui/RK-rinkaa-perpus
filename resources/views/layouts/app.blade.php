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
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ $isMobileDevice ? 'device-mobile-server' : 'device-desktop-server' }} {{ $isAndroidDevice ? 'device-android-server' : '' }} {{ $isIosDevice ? 'device-ios-server' : '' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>{{ config('app.name', 'RinKa Perpus') }} - @yield('title', 'Masuk')</title>
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
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        html, body {
            width: 100%;
            height: 100%;
        }
        body {
            font-family: 'Inter', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.22), transparent 28%),
                radial-gradient(circle at bottom right, rgba(15, 23, 42, 0.86), transparent 34%),
                linear-gradient(180deg, #0f172a 0%, #172554 55%, #e2e8f0 100%);
            background-attachment: fixed;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        #login-content {
            transition: opacity 1s ease-out !important;
        }
        #intro-screen {
            transition: opacity 1s ease-out !important;
        }
        .intro-element {
            transition: all 1s ease-out !important;
        }
        html.device-mobile-server body,
        html.device-mobile-active body {
            min-height: 100dvh;
            padding-left: max(0px, env(safe-area-inset-left));
            padding-right: max(0px, env(safe-area-inset-right));
        }
    </style>
</head>
<body class="min-h-screen text-slate-700 antialiased">
    <div class="absolute inset-0 overflow-hidden pointer-events-none" style="z-index: 0;">
        <div class="absolute -top-24 left-1/4 h-64 w-64 rounded-full bg-blue-400/20 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 h-80 w-80 rounded-full bg-indigo-300/20 blur-3xl"></div>
    </div>

    @yield('content')
</body>
</html>
