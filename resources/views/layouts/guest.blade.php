<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TERANG By SRT') }}</title>
        
        <!-- PWA Meta Tags -->
        <meta name="theme-color" content="#2563eb">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="apple-mobile-web-app-title" content="TERANG SRT">
        <meta name="description" content="Sistem Rekrutmen dan Manajemen Talent PT Sarana Reksa Tama">
        
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/terang.png') }}">
        <link rel="shortcut icon" href="{{ asset('images/terang.png') }}">
        
        <!-- PWA Manifest -->
        <link rel="manifest" href="{{ asset('manifest.json') }}">
        
        <!-- Apple Touch Icons -->
        <link rel="apple-touch-icon" href="{{ asset('images/icon-192x192.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('images/icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/icon-192x192.png') }}">
        <link rel="apple-touch-icon" sizes="167x167" href="{{ asset('images/icon-192x192.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div>
                <a href="/" class="flex items-center">
                    <img src="{{ asset('images/terang.png') }}" alt="TERANG By SRT" class="h-16 w-auto">
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
        
        <!-- PWA Service Worker Registration -->
        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', () => {
                    navigator.serviceWorker.register('/sw.js')
                        .then(registration => console.log('SW registered'))
                        .catch(error => console.log('SW registration failed:', error));
                });
            }
        </script>
    </body>
</html>
