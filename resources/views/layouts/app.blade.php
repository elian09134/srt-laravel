<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TERANG By SRT') }}</title>
        
        <!-- PWA Meta Tags -->
        <meta name="theme-color" content="#2563eb">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="apple-mobile-web-app-title" content="TERANG SRT">
        <meta name="description" content="Sistem Rekrutmen dan Manajemen Talent PT. Mandala Karya Sentosa">
        
        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="{{ config('app.name', 'TERANG By SRT') }}">
        <meta property="og:description" content="Sistem Rekrutmen dan Manajemen Talent PT. Mandala Karya Sentosa">
        <meta property="og:site_name" content="PT. Mandala Karya Sentosa">
        <meta property="og:image" content="{{ asset('images/terang.png') }}">
        
        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ url()->current() }}">
        <meta property="twitter:title" content="{{ config('app.name', 'TERANG By SRT') }}">
        <meta property="twitter:description" content="Sistem Rekrutmen dan Manajemen Talent PT. Mandala Karya Sentosa">
        <meta property="twitter:image" content="{{ asset('images/terang.png') }}">
        
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

        <!-- Tailwind CSS should be built via Vite; do not use CDN in production -->
        
        <!-- Google Fonts: Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        
        <!-- Font Awesome for Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

        <!-- Vite Scripts (Biarkan untuk masa depan) -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
            .bg-srt-orange {
                background-color: #f56565;
            }
            .hover\:bg-srt-orange-dark:hover {
                background-color: #e53e3e;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-white text-gray-800">
        
        <!-- Header Komponen -->
        <x-header />

        <!-- Konten Halaman Utama -->
        <main>
            @isset($slot)
                {{ $slot }}
            @endisset

            @yield('content')
        </main>

        <!-- Footer Komponen -->
        <x-footer />
        
        <!-- PWA Service Worker Registration -->
        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', () => {
                    navigator.serviceWorker.register('/sw.js')
                        .then(registration => {
                            console.log('Service Worker registered successfully:', registration.scope);
                            
                            // Check for updates
                            registration.addEventListener('updatefound', () => {
                                const newWorker = registration.installing;
                                newWorker.addEventListener('statechange', () => {
                                    if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                        // New update available
                                        if (confirm('Update tersedia! Refresh halaman untuk mendapatkan versi terbaru?')) {
                                            window.location.reload();
                                        }
                                    }
                                });
                            });
                        })
                        .catch(error => {
                            console.log('Service Worker registration failed:', error);
                        });
                });
            }

            // PWA Install Prompt
            let deferredPrompt;
            window.addEventListener('beforeinstallprompt', (e) => {
                e.preventDefault();
                deferredPrompt = e;
                
                // Show install banner/button (optional)
                const installBtn = document.getElementById('pwa-install-btn');
                if (installBtn) {
                    installBtn.style.display = 'block';
                    installBtn.addEventListener('click', () => {
                        deferredPrompt.prompt();
                        deferredPrompt.userChoice.then((choiceResult) => {
                            if (choiceResult.outcome === 'accepted') {
                                console.log('User accepted the install prompt');
                            }
                            deferredPrompt = null;
                        });
                    });
                }
            });

            // Detect if app is installed
            window.addEventListener('appinstalled', () => {
                console.log('PWA installed successfully');
                deferredPrompt = null;
            });

            // Online/Offline detection
            window.addEventListener('online', () => {
                console.log('Back online');
                // Show notification or update UI
            });

            window.addEventListener('offline', () => {
                console.log('Connection lost');
                // Show offline notification
            });
        </script>
    </body>
</html>
