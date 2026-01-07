<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - TERANG By SRT</title>
    
    <!-- Vite-built CSS/JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Fonts: Inter (kept as fallback) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .bg-grid-pattern {
            background-image: 
                linear-gradient(to right, rgba(59, 130, 246, 0.1) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(59, 130, 246, 0.1) 1px, transparent 1px);
            background-size: 40px 40px;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-blue-50 relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>

    <div class="flex min-h-screen relative z-10">
        <!-- Kolom Kiri (Formulir) -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12">
            <div class="w-full max-w-md">
                <div class="flex justify-center mb-6">
                    <a href="{{ route('home') }}" class="inline-block">
                        <img src="{{ asset('images/terang.png') }}" alt="{{ config('app.name', 'TERANG By SRT') }}" class="h-20 w-auto">
                    </a>
                </div>
                
                <h1 class="mt-4 text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">Selamat Datang Kembali</h1>
                <p class="mt-2 text-gray-600">Silakan masuk untuk melanjutkan.</p>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6" id="loginForm">
                    @csrf

                    <!-- Error Alert (hidden by default) -->
                    <div id="errorAlert" class="hidden bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl relative" role="alert">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-circle mt-0.5 mr-2"></i>
                            <div>
                                <strong class="font-semibold">Error!</strong>
                                <span class="block sm:inline" id="errorMessage"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Email') }}</label>
                        <input id="email" class="block w-full px-4 py-3 border border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                         <div class="flex justify-between items-center mb-2">
                            <label for="password" class="block text-sm font-semibold text-gray-700">{{ __('Password') }}</label>
                            @if (Route::has('password.request'))
                                <a class="text-sm font-medium text-blue-600 hover:text-blue-700" href="{{ route('password.request') }}">
                                    {{ __('Lupa password?') }}
                                </a>
                            @endif
                        </div>
                        <input id="password" class="block w-full px-4 py-3 border border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                        type="password"
                                        name="password"
                                        required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
                        </label>
                    </div>

                    <div class="mt-4">
                        <button type="submit"
                                class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 hover:shadow-xl">
                            {{ __('Log in') }}
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Bagi pelamar, belum punya akun?
                        <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700">
                            Daftar sekarang
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan (Gambar) -->
        <div class="hidden lg:block lg:w-1/2 bg-cover bg-center relative" style="background-image: url('https://images.unsplash.com/photo-1517048676732-d65bc937f952?q=80&w=2070&auto=format&fit=crop');">
            <div class="w-full h-full bg-gradient-to-br from-blue-900/80 to-blue-800/70 flex items-center justify-center">
                <div class="text-center text-white p-12">
                    <h2 class="text-4xl font-bold mb-4">Bergabunglah Bersama Kami</h2>
                    <p class="text-lg text-blue-100">Temukan peluang karir yang menginspirasi dan berkembang bersama tim profesional</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add error handling for login form
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');
            const errorAlert = document.getElementById('errorAlert');
            const errorMessage = document.getElementById('errorMessage');
            const submitButton = form.querySelector('button[type="submit"]');
            
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Show loading state
                const originalText = submitButton.innerHTML;
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Logging in...';
                
                // Hide previous errors
                errorAlert.classList.add('hidden');
                
                // Get form data
                const formData = new FormData(form);
                
                // Get fresh CSRF token from meta tag
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                // Send AJAX request
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    credentials: 'same-origin',
                    cache: 'no-cache'
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    console.log('Response headers:', [...response.headers.entries()]);
                    
                    // Log response for debugging
                    return response.text().then(text => {
                        console.log('Response body:', text);
                        
                        // Try to parse as JSON, otherwise use text
                        try {
                            const data = JSON.parse(text);
                            return { ok: response.ok, status: response.status, data: data, text: text };
                        } catch (e) {
                            return { ok: response.ok, status: response.status, data: null, text: text };
                        }
                    });
                })
                .then(result => {
                    console.log('Parsed result:', result);
                    
                    if (result.ok) {
                        // Success - redirect
                        if (result.data && result.data.redirect) {
                            window.location.href = result.data.redirect;
                        } else {
                            window.location.href = '/dashboard';
                        }
                    } else {
                        // Error - show message
                        let errorMsg = 'Login failed. ';
                        
                        if (result.status === 419) {
                            errorMsg += 'Session expired. Please refresh the page and try again.';
                            console.error('CSRF Token Error - Page needs refresh');
                        } else if (result.status === 500) {
                            errorMsg += 'Server error (500). Check server logs. ';
                            if (result.text) {
                                console.error('Server error details:', result.text);
                                // Try to extract error message from HTML
                                const parser = new DOMParser();
                                const doc = parser.parseFromString(result.text, 'text/html');
                                const errorTitle = doc.querySelector('.exception-message, h1');
                                if (errorTitle) {
                                    errorMsg += errorTitle.textContent;
                                }
                            }
                        } else if (result.data && result.data.message) {
                            errorMsg += result.data.message;
                        } else if (result.data && result.data.errors) {
                            errorMsg += Object.values(result.data.errors).flat().join(' ');
                        } else {
                            errorMsg += `HTTP ${result.status} error. Check console for details.`;
                        }
                        
                        errorMessage.textContent = errorMsg;
                        errorAlert.classList.remove('hidden');
                        
                        // Restore button
                        submitButton.disabled = false;
                        submitButton.innerHTML = originalText;
                    }
                })
                .catch(error => {
                    console.error('Network error:', error);
                    errorMessage.textContent = 'Network error: ' + error.message + '. Check your connection and server status.';
                    errorAlert.classList.remove('hidden');
                    
                    // Restore button
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalText;
                });
            });
        });
    </script>
</body>
</html>
