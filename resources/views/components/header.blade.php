<header class="bg-white/95 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-gray-100">
    <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                <span class="text-white font-bold text-lg">S</span>
            </div>
            <span class="text-xl font-bold">
                <span class="bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">SRT</span>
                <span class="text-gray-700"> Corp</span>
            </span>
        </a>
        
        <!-- Menu Utama (Desktop) -->
        <div class="hidden md:flex items-center space-x-8">
            <a href="{{ route('home') }}#home" class="text-sm font-medium {{ request()->routeIs('home') ? 'text-blue-600' : 'text-gray-600' }} hover:text-blue-600 transition-colors relative group">
                Home
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 group-hover:w-full transition-all duration-300"></span>
            </a>
            <a href="{{ route('home') }}#about-us" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors relative group">
                Profile
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 group-hover:w-full transition-all duration-300"></span>
            </a>
            <a href="{{ route('home') }}#business-scope" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors relative group">
                Scope Bisnis
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 group-hover:w-full transition-all duration-300"></span>
            </a>
            <a href="{{ route('karir') }}" class="text-sm font-medium {{ request()->routeIs('karir') ? 'text-blue-600' : 'text-gray-600' }} hover:text-blue-600 transition-colors relative group">
                Karir
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 group-hover:w-full transition-all duration-300"></span>
            </a>
        </div>

        <!-- Tombol CTA (Desktop) -->
        <div class="hidden md:flex items-center space-x-3">
                @auth
                @if(auth()->user()->role == 'admin')
                    <!-- Tampilan jika admin login -->
                    <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-green-600 to-green-700 rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-300 hover:shadow-lg">Admin Panel</a>
                @else
                    <!-- Tampilan jika user biasa login -->
                    <a href="/profile" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors">Profil Saya</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-red-600 bg-red-50 rounded-xl hover:bg-red-100 transition-all duration-300">Logout</button>
                </form>
            @else
                <!-- Tampilan jika belum login -->
                <a href="/login" class="px-5 py-2.5 text-sm font-semibold text-blue-600 bg-blue-50 rounded-xl hover:bg-blue-100 transition-all duration-300">Login</a>
                <a href="/karir" class="px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 hover:shadow-lg">Lihat Lowongan</a>
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
                          <a href="{{ route('admin.dashboard') }}" class="block text-center py-2 font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">Admin Panel</a>
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