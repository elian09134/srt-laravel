<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-key text-blue-600 text-2xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900">Lupa Password?</h2>
        <p class="mt-2 text-sm text-gray-600">
            Masukkan nomor HP yang terdaftar (contoh: 0812...) — permintaan akan dikirim ke administrator. Jika disetujui, administrator akan menghubungi Anda melalui WhatsApp atau email.
        </p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-600 mr-3"></i>
                <p class="text-sm text-green-800">{{ session('status') }}</p>
            </div>
        </div>
    @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Phone Number -->
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-phone text-gray-400 mr-2"></i>Nomor HP
            </label>
            <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required autofocus
                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('phone') border-red-500 @enderror"
                   placeholder="081234567890">
            @error('phone')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </p>
            @enderror
        </div>

            <div class="space-y-4">
            <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:ring-blue-200 transition-all transform hover:scale-[1.02] active:scale-100">
                <i class="fas fa-paper-plane mr-2"></i>Kirim Permintaan Reset Password
            </button>
            
            <a href="{{ route('login') }}" class="block text-center text-sm text-gray-600 hover:text-blue-600 transition-colors">
                <i class="fas fa-arrow-left mr-1"></i>Kembali ke Login
            </a>
        </div>
    </form>
</x-guest-layout>
