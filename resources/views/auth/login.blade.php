<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk | {{ config('app.name', 'Terang By SRT') }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&amp;display=swap" rel="stylesheet"/>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .custom-checkbox:checked {
            background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3e%3c/svg%3e");
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-[#0f1923] text-slate-900 dark:text-slate-100 min-h-screen">
<div class="flex min-h-screen w-full">
    <!-- Left Side: Visual/Branding -->
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-primary/10">
        <div class="absolute inset-0 z-10 bg-gradient-to-tr from-primary/40 to-transparent"></div>
        <img alt="Modern professional office interior" class="absolute inset-0 object-cover w-full h-full" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD0zp-PT_MIhV0wEsSuEmtXuFE-ovyn1eIqLvL2mCcUmnOKCS7c_WFUf2o9qgVIqyPadx1VXldSOTo16wXG97dbFHtQWjFVuLOBaSPN_b1Xv9ITvKnPR3jz-8_zkYSvoUCMXKMUH9Shi--9iLzokE7JyOwCnYqi4mlvOMXNmRIAPkNJQWtDGhlQnoaa2jGKmVKFvQfMCUQ7bG4FrcLEUMoJuGrV59qNjy-VAqVZ4mB876HU2fPYtNlLNsrpr4JOHCU2p1zuV_CFgH8"/>
        
        <div class="relative z-20 flex flex-col justify-between p-12 text-white h-full">
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="flex items-center gap-3 p-2 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 transition-transform hover:scale-105">
                    <img src="{{ asset('images/terang.png') }}" alt="Terang Logo" class="h-10 w-auto bg-white rounded-lg p-1">
                    <span class="text-2xl font-black tracking-tight drop-shadow-sm">Terang By SRT</span>
                </a>
            </div>
            <div>
                <h2 class="text-5xl font-black leading-tight mb-6 max-w-lg drop-shadow-lg">
                    Menerangi Langkah Bisnis Anda dengan Solusi Terpadu.
                </h2>
                <p class="text-xl text-slate-100 max-w-md font-medium leading-relaxed opacity-90">
                    Akses akun Anda untuk memantau status lamaran dan update peluang karir terbaru secara real-time.
                </p>
            </div>
            <div class="text-sm font-bold opacity-60 uppercase tracking-widest">
                © {{ date('Y') }} Terang By SRT. PT. Mandala Karya Sentosa.
            </div>
        </div>
    </div>

    <!-- Right Side: Login Form -->
    <div class="flex flex-col w-full lg:w-1/2 justify-center items-center p-6 sm:p-12 lg:p-24 bg-white dark:bg-[#0f1923]">
        <div class="w-full max-w-md">
            <!-- Mobile Logo -->
            <div class="flex lg:hidden items-center gap-3 mb-12 justify-center">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/terang.png') }}" alt="Logo" class="h-12 w-auto">
                    <span class="text-2xl font-black tracking-tight text-slate-900 dark:text-white">Terang By SRT</span>
                </a>
            </div>

            <div class="mb-10 text-center lg:text-left">
                <h1 class="text-4xl font-black text-slate-900 dark:text-white mb-3 tracking-tight">Selamat Datang Kembali</h1>
                <p class="text-slate-500 dark:text-slate-400 font-medium">Silakan masukkan kredensial Anda untuk mengakses akun Terang By SRT.</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-6" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6" id="loginForm">
                @csrf

                <!-- Error Alert -->
                @if ($errors->any())
                <div class="bg-red-50 border border-red-100 text-red-600 p-4 rounded-2xl flex items-start gap-3 shadow-sm mb-6 animate-pulse">
                    <span class="material-symbols-outlined shrink-0">error</span>
                    <p class="text-sm font-bold">{{ $errors->first() }}</p>
                </div>
                @endif

                <!-- Email Field -->
                <div class="space-y-2">
                    <label for="email" class="text-sm font-bold text-slate-700 dark:text-slate-300 ml-1 uppercase tracking-wider text-[10px]">Alamat Email</label>
                    <div class="relative flex items-center group">
                        <input id="email" 
                               name="email" 
                               type="email" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus 
                               autocomplete="username"
                               class="w-full pl-12 pr-4 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-4 focus:ring-primary/10 transition-all outline-none text-slate-900 dark:text-white font-medium">
                    </div>
                </div>

                <!-- Password Field -->
                <div class="space-y-2">
                    <div class="flex justify-between items-center px-1">
                        <label for="password" class="text-sm font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider text-[10px]">Kata Sandi</label>
                        @if (Route::has('password.request'))
                            <a class="text-[10px] font-black text-primary hover:underline uppercase tracking-widest" href="{{ route('password.request') }}">
                                Lupa Kata Sandi?
                            </a>
                        @endif
                    </div>
                    <div class="relative flex items-center group">                      
                        <input id="password" 
                               name="password" 
                               type="password" 
                               required 
                               autocomplete="current-password"
                               class="w-full pl-12 pr-12 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-4 focus:ring-primary/10 transition-all outline-none text-slate-900 dark:text-white font-medium">
                        <button type="button" onclick="togglePassword()" class="absolute right-4 text-slate-400 hover:text-primary transition-colors">
                            <span class="material-symbols-outlined" id="pwIcon">visibility</span>
                        </button>
                    </div>
                </div>

                <!-- Options Row -->
                <div class="flex items-center px-1">
                    <label for="remember_me" class="flex items-center gap-3 cursor-pointer group">
                        <input id="remember_me" name="remember" type="checkbox" class="h-5 w-5 rounded-lg border-slate-300 dark:border-slate-600 text-primary focus:ring-primary/20 transition-colors cursor-pointer bg-slate-50 dark:bg-slate-800">
                        <span class="text-sm font-bold text-slate-500 dark:text-slate-400 group-hover:text-primary transition-colors">Ingat saya</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="submitBtn" class="w-full bg-primary hover:shadow-2xl hover:shadow-primary/30 text-white font-black py-5 rounded-2xl shadow-xl shadow-primary/20 transform active:scale-[0.98] transition-all flex justify-center items-center gap-2 uppercase tracking-widest text-sm">
                    <span>Masuk</span>
                </button>
            </form>

            <div class="relative my-10">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-100 dark:border-slate-800"></div>
                </div>
                <div class="relative flex justify-center text-[10px] uppercase font-black tracking-widest">
                    <span class="px-6 bg-white dark:bg-[#0f1923] text-slate-400">Pilihan Masuk Lainnya</span>
                </div>
            </div>

            <!-- Social Logins (Temporarily Hidden) -->
            {{-- 
            <div class="grid grid-cols-1 gap-4">
                <a href="{{ route('auth.google') }}" class="flex items-center justify-center gap-3 py-4 px-4 bg-slate-50 hover:bg-white dark:bg-slate-800 dark:hover:bg-slate-700 border border-transparent hover:border-slate-200 dark:hover:border-slate-600 rounded-2xl transition-all font-bold text-slate-700 dark:text-slate-300 shadow-sm">
                    <svg class="w-5 h-5" viewbox="0 0 24 24">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"></path>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"></path>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"></path>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"></path>
                    </svg>
                    <span class="text-sm">Lanjutkan dengan Google</span>
                </a>
            </div>
            --}}

            <p class="mt-12 text-center text-sm font-bold text-slate-400">
                Belum punya akun? 
                <a class="text-primary hover:underline font-black ml-1" href="{{ route('register') }}">Daftar sekarang</a>
            </p>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('pwIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerText = 'visibility_off';
        } else {
            input.type = 'password';
            icon.innerText = 'visibility';
        }
    }

    document.getElementById('loginForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.classList.add('opacity-50', 'cursor-not-allowed');
        btn.querySelector('span:first-child').innerText = 'Memproses...';
    });
</script>
</body>
</html>
