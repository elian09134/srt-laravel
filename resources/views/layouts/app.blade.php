<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SRT Corp') }}</title>

        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        
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
            {{ $slot }}
        </main>

        <!-- Footer Komponen -->
        <x-footer />
        
    </body>
</html>
