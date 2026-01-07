<header class="bg-white/95 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-gray-100">
    <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
            <img src="{{ asset('images/terang.png') }}" alt="TERANG By SRT" class="h-12 w-auto transform group-hover:scale-105 transition-transform duration-300">
            <div class="hidden lg:block">
                <span class="text-xl font-bold text-gray-900">TERANG <span class="text-blue-600">By SRT</span></span>
            </div>
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
                @elseif(auth()->user()->role == 'operasional')
                    <!-- Tampilan jika operasional login -->
                    <a href="{{ route('fptk.my') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-all duration-300">FPTK Saya</a>
                    <a href="{{ route('fptk.index') }}" class="px-5 py-2.5 text-sm font-semibold text-blue bg-gradient-to-r from-yellow-600 to-yellow-700 rounded-xl hover:from-yellow-700 hover:to-yellow-800 transition-all duration-300 hover:shadow-lg">Buat FPTK</a>
                @else
                    <!-- Tampilan jika user biasa login -->
                    <a href="/profile" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors">Profil Saya</a>
                    <a href="{{ route('applications.index') }}" class="ml-4 text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors">Riwayat Lamaran</a>
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
            
            <!-- PWA Install Button (hidden by default, shown when installable) -->
            <button id="pwa-install-btn" style="display: none;" class="px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-purple-600 to-blue-600 rounded-xl hover:from-purple-700 hover:to-blue-700 transition-all duration-300 hover:shadow-lg flex items-center gap-2">
                <i class="fas fa-download"></i>
                <span>Install App</span>
            </button>
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
                @elseif(auth()->user()->role == 'operasional')
                          <a href="{{ route('fptk.my') }}" class="block text-center py-2 font-medium text-gray-700 border border-gray-400 rounded-lg hover:bg-gray-50 mb-2">FPTK Saya</a>
                          <a href="{{ route('fptk.index') }}" class="block text-center py-2 font-medium text-white bg-yellow-600 rounded-lg hover:bg-yellow-700">Buat FPTK</a>
                @else
                 <a href="/profile" class="block text-center py-2 font-medium text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50">Profil Saya</a>
                 <a href="{{ route('applications.index') }}" class="block mt-2 text-center py-2 font-medium text-gray-700 rounded-lg hover:bg-gray-50">Riwayat Lamaran</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full mt-2 text-center py-2 font-medium text-red-600 border border-red-600 rounded-lg hover:bg-red-50">Logout</button>
                </form>
            @else
                <a href="/login" class="block text-center py-2 font-medium text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50">Login</a>
                <a href="/karir" class="block mt-2 text-center py-2 font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">Lihat Lowongan</a>
            @endauth
            
            <!-- PWA Install Button (Mobile, hidden by default) -->
            <button id="pwa-install-btn-mobile" style="display: none;" class="mt-2 w-full text-center py-2 font-medium text-white bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg hover:from-purple-700 hover:to-blue-700 flex items-center justify-center gap-2">
                <i class="fas fa-download"></i>
                <span>Install App</span>
            </button>
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
        
        // PWA Install Button Handler
        let deferredPrompt;
        const installBtn = document.getElementById('pwa-install-btn');
        const installBtnMobile = document.getElementById('pwa-install-btn-mobile');
        
        window.addEventListener('beforeinstallprompt', (e) => {
            // Prevent the mini-infobar from appearing on mobile
            e.preventDefault();
            // Stash the event so it can be triggered later
            deferredPrompt = e;
            // Update UI notify the user they can install the PWA
            if (installBtn) {
                installBtn.style.display = 'flex';
            }
            if (installBtnMobile) {
                installBtnMobile.style.display = 'flex';
            }
        });
        
        // Handle install button click
        const handleInstallClick = async () => {
            if (!deferredPrompt) {
                return;
            }
            // Show the install prompt
            deferredPrompt.prompt();
            // Wait for the user to respond to the prompt
            const { outcome } = await deferredPrompt.userChoice;
            // We've used the prompt, and can't use it again, throw it away
            deferredPrompt = null;
            // Hide the install button
            if (installBtn) {
                installBtn.style.display = 'none';
            }
            if (installBtnMobile) {
                installBtnMobile.style.display = 'none';
            }
        };
        
        if (installBtn) {
            installBtn.addEventListener('click', handleInstallClick);
        }
        if (installBtnMobile) {
            installBtnMobile.addEventListener('click', handleInstallClick);
        }
        
        // Hide button when PWA is installed
        window.addEventListener('appinstalled', () => {
            if (installBtn) {
                installBtn.style.display = 'none';
            }
            if (installBtnMobile) {
                installBtnMobile.style.display = 'none';
            }
            deferredPrompt = null;
        });
    });
</script>