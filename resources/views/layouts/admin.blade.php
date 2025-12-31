<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1280, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - TERANG</title>
    <!-- Vite-built CSS/JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome (kept as CDN for admin icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* Admin panel: disable mobile responsive, min-width for desktop */
        body {
            min-width: 1280px;
            overflow-x: auto;
        }
        
        .bg-grid-pattern {
            background-image: 
                linear-gradient(to right, rgba(59, 130, 246, 0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(59, 130, 246, 0.05) 1px, transparent 1px);
            background-size: 40px 40px;
        }
        
        /* Ensure admin layout is fixed width on small screens */
        @media (max-width: 1279px) {
            html {
                min-width: 1280px;
            }
        }
    </style>
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: true }">
    <div class="flex min-h-screen" :class="{ 'overflow-hidden': sidebarOpen === false }">
        <!-- Sidebar -->
        <aside class="w-56 bg-gradient-to-b from-gray-900 via-gray-800 to-gray-900 text-white flex-shrink-0 h-screen sticky top-0 shadow-2xl">
            <div class="p-4">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/terang.png') }}" alt="TERANG Admin" class="h-10 w-auto">
                    <div>
                        <span class="text-xl font-bold block">TERANG Admin</span>
                        <span class="text-xs text-blue-400">Management Panel</span>
                    </div>
                </div>
            </div>
            <nav class="mt-4">
                @php
                    $pendingPasswordRequests = \App\Models\PasswordResetRequest::where('status', 'pending')->count();
                @endphp
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3.5 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white border-l-4 border-blue-400' : 'text-gray-400 hover:bg-gray-700/50' }} hover:text-white transition-all duration-200">
                    <i class="fas fa-tachometer-alt mr-3 w-5"></i> <span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('admin.applicants.index') }}" class="flex items-center px-6 py-3.5 {{ request()->routeIs('admin.applicants.index') ? 'bg-blue-600 text-white border-l-4 border-blue-400' : 'text-gray-400 hover:bg-gray-700/50' }} hover:text-white transition-all duration-200">
                    <i class="fas fa-users mr-3 w-5"></i> <span class="font-medium">Data Pelamar</span>
                </a>
                <a href="{{ route('admin.jobs.index') }}" class="flex items-center px-6 py-3.5 {{ request()->routeIs('admin.jobs.*') ? 'bg-blue-600 text-white border-l-4 border-blue-400' : 'text-gray-400 hover:bg-gray-700/50' }} hover:text-white transition-all duration-200">
                    <i class="fas fa-briefcase mr-3 w-5"></i> <span class="font-medium">Kelola Lowongan</span>
                </a>
                <a href="{{ route('admin.content.edit') }}" class="flex items-center px-6 py-3.5 {{ request()->routeIs('admin.content.edit') ? 'bg-blue-600 text-white border-l-4 border-blue-400' : 'text-gray-400 hover:bg-gray-700/50' }} hover:text-white transition-all duration-200">
                    <i class="fas fa-edit mr-3 w-5"></i> <span class="font-medium">Kelola Konten</span>
                </a>
                <a href="{{ route('admin.images.index') }}" class="flex items-center px-6 py-3.5 {{ request()->routeIs('admin.images.index') ? 'bg-blue-600 text-white border-l-4 border-blue-400' : 'text-gray-400 hover:bg-gray-700/50' }} hover:text-white transition-all duration-200">
                    <i class="fas fa-images mr-3 w-5"></i> <span class="font-medium">Kelola Gambar</span>
                </a>
                <a href="{{ route('admin.talent_pool.index') }}" class="flex items-center px-6 py-3.5 {{ request()->routeIs('admin.talent_pool.*') ? 'bg-blue-600 text-white border-l-4 border-blue-400' : 'text-gray-400 hover:bg-gray-700/50' }} hover:text-white transition-all duration-200">
                    <i class="fas fa-user-circle mr-3 w-5"></i> <span class="font-medium">Talent Pool</span>
                </a>

                <a href="{{ route('admin.password_requests.index') }}" class="flex items-center px-6 py-3.5 {{ request()->routeIs('admin.password_requests.*') ? 'bg-blue-600 text-white border-l-4 border-blue-400' : 'text-gray-400 hover:bg-gray-700/50' }} hover:text-white transition-all duration-200">
                    <i class="fas fa-key mr-3 w-5"></i>
                    <span class="font-medium">Permintaan Reset Password</span>
                    @if($pendingPasswordRequests > 0)
                        <span class="ml-auto inline-flex items-center justify-center px-2 py-0.5 text-xs font-semibold bg-red-600 text-white rounded-full">{{ $pendingPasswordRequests }}</span>
                    @endif
                </a>

                <!-- Employee invitation feature removed: recruitment-only site -->
                <!-- Employee management removed: recruitment-only site -->
                
                <div class="border-t border-gray-700 mt-6 pt-6">
                    <a href="{{ route('home') }}" class="flex items-center px-6 py-3.5 text-gray-400 hover:bg-gray-700/50 hover:text-white transition-all duration-200">
                        <i class="fas fa-arrow-left mr-3 w-5"></i> <span class="font-medium">Kembali ke Website</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-grow bg-gradient-to-br from-blue-50/30 via-white to-blue-50/30 relative">
            <div class="absolute inset-0 bg-grid-pattern opacity-30"></div>
            <div class="relative z-10 max-w-7xl mx-auto w-full p-6 sm:p-8 lg:pl-12">
                <!-- Topbar -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-4">
                        <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-md bg-white/40 hover:bg-white text-gray-700 lg:hidden">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div>
                            <h2 class="text-2xl font-semibold text-gray-900">@yield('title', 'Admin Panel')</h2>
                            <p class="text-sm text-gray-600">Kontrol panel perekrutan & manajemen lowongan</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="hidden md:block">
                            <input type="search" placeholder="Cari pelamar atau lowongan..." class="px-3 py-2 rounded-lg border border-gray-200 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="text-sm text-gray-600">Hello, <strong>{{ auth()->user()->name ?? 'Admin' }}</strong></div>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-sm text-red-600 hover:text-red-700">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                        </div>
                    </div>
                </div>
                
                @if(session('success'))
                    <div class="bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500 text-green-800 p-4 mb-6 rounded-xl shadow-sm" role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-3 text-green-500"></i>
                            <p class="font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>
    @yield('scripts')
</body>
</html>
