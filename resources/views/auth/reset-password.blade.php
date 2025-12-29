<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-lock text-green-600 text-2xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900">Reset Password</h2>
        <p class="mt-2 text-sm text-gray-600">
            Masukkan password baru untuk akun Anda.
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ request()->route('token') }}">

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-envelope text-gray-400 mr-2"></i>Email
            </label>
            <input id="email" type="email" name="email" value="{{ old('email', request('email')) }}" required autofocus autocomplete="username"
                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-gray-50 @error('email') border-red-500 @enderror"
                   readonly>
            @error('email')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-key text-gray-400 mr-2"></i>Password Baru
            </label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('password') border-red-500 @enderror"
                   placeholder="Minimal 8 karakter">
            @error('password')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-check-circle text-gray-400 mr-2"></i>Konfirmasi Password
            </label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                   placeholder="Ulangi password baru">
        </div>

        <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold rounded-lg hover:from-green-700 hover:to-green-800 focus:ring-4 focus:ring-green-200 transition-all transform hover:scale-[1.02] active:scale-100">
            <i class="fas fa-save mr-2"></i>Reset Password
        </button>
    </form>
</x-guest-layout>
