<header class="bg-white shadow-md sticky top-0 z-50">
    <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="text-2xl font-bold text-gray-900">SRT <span class="text-blue-700">Corp</span></a>
        
        <!-- Menu Utama (Desktop) -->
        <div class="hidden md:flex items-center space-x-8">
            <a href="{{ route('home') }}#home" class="pb-1 border-b-2 {{ request()->routeIs('home') ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600' }} hover:text-blue-600 hover:border-blue-600 transition-colors font-semibold">Home</a>
            <a href="{{ route('home') }}#about-us" class="pb-1 border-b-2 border-transparent text-gray-600 hover:text-blue-600 hover:border-blue-600 transition-colors">Profile</a>
            <a href="{{ route('home') }}#business-scope" class="pb-1 border-b-2 border-transparent text-gray-600 hover:text-blue-600 hover:border-blue-600 transition-colors">Scope Bisnis</a>
            <a href="{{ route('karir') }}" class="pb-1 border-b-2 {{ request()->routeIs('karir') ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600' }} hover:text-blue-600 hover:border-blue-600 transition-colors font-semibold">Karir</a>
        </div>

        <!-- Tombol CTA (Desktop) -->
        <div class="hidden md:flex items-center space-x-4">
            @auth
                @if(auth()->user()->role == 'admin')
                    <!-- Tampilan jika admin login -->
                    <a href="/admin" class="px-5 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 transition-colors">Admin Panel</a>
                @else
                    <!-- Tampilan jika user biasa login -->
                    <a href="/profile" class="text-sm font-medium text-gray-600 hover:text-blue-600">Profil Saya</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-5 py-2 text-sm font-medium text-red-600 bg-white border border-red-600 rounded-md hover:bg-red-50 transition-colors">Logout</button>
                </form>
            @else
                <!-- Tampilan jika belum login -->
                <a href="/login" class="px-5 py-2 text-sm font-medium text-blue-600 bg-white border border-blue-600 rounded-md hover:bg-blue-50 transition-colors">Login</a>
                <a href="/karir" class="px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300">Lihat Lowongan</a>
            @endauth
        </div>

        <!-- Tombol Menu (Mobile) -->
        <button id="mobile-menu-button" class="md:hidden text-gray-600 focus:outline-none">
            <i class="fas fa-bars fa-lg"></i>
        </button>
    </nav>
    
    <!-- Mobile Menu (Hidden by default) -->
    <div id="mobile-menu" class="hidden md:hidden px-6 pb-4">
        <a href="{{ route('home') }}#home" class="block py-2 text-blue-600 font-semibold">Home</a>
        <a href="{{ route('home') }}#about-us" class="block py-2 text-gray-600 hover:text-blue-600">Profile</a>
        <a href="{{ route('home') }}#business-scope" class="block py-2 text-gray-600 hover:text-blue-600">Scope Bisnis</a>
        <a href="{{ route('karir') }}" class="block py-2 text-gray-600 hover:text-blue-600">Karir</a>
        <div class="mt-4 pt-4 border-t">
            @auth
                 @if (auth()->user()->role == 'admin')
                    <a href="/admin" class="block text-center py-2 font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">Admin Panel</a>
                @else
                     <a href="/profile" class="block text-center py-2 font-medium text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50">Profil Saya</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full mt-2 text-center py-2 font-medium text-red-600 border border-red-600 rounded-lg hover:bg-red-50">Logout</button>
                </form>
            @else
                <a href="/login" class="block text-center py-2 font-medium text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50">Login</a>
                <a href="/karir" class="block mt-2 text-center py-2 font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">Lihat Lowongan</a>
            @endauth
        </div>
    </div>
</header>

<script>
    // Pastikan skrip berjalan setelah halaman dimuat sepenuhnya
    document.addEventListener('DOMContentLoaded', function () {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }
    });
</script>