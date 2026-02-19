<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1280, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - TERANG</title>

    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#0f172a">
    <title>Admin Dashboard</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vite-built CSS/JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        
        /* Custom Scrollbar for Sidebar */
        .sidebar-scroll::-webkit-scrollbar { width: 5px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover { background: #475569; }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 antialiased" x-data="{ sidebarOpen: true }">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-white transition-transform duration-300 transform lg:translate-x-0 lg:static lg:inset-0 flex flex-col shadow-2xl"
               :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
            
            <!-- Logo area -->
            <div class="flex items-center justify-center h-16 bg-slate-950 shadow-md">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <span class="font-bold text-white text-lg">T</span>
                    </div>
                    <span class="text-lg font-bold tracking-wide">TERANG<span class="text-blue-500">ADMIN</span></span>
                </a>
            </div>

            <!-- Nav Links -->
            <nav class="flex-1 overflow-y-auto sidebar-scroll py-4 px-3 space-y-1">
                
                <div class="pl-3 pr-2 py-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    Main
                </div>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fas fa-home w-6 text-center {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-500 group-hover:text-white transition-colors' }}"></i>
                    <span class="ml-2 font-medium">Dashboard</span>
                </a>

                <div class="mt-6 mb-2 pl-3 pr-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    Recruitment
                </div>
                <a href="{{ route('admin.jobs.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('admin.jobs.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fas fa-briefcase w-6 text-center {{ request()->routeIs('admin.jobs.*') ? 'text-white' : 'text-slate-500 group-hover:text-white transition-colors' }}"></i>
                    <span class="ml-2 font-medium">Lowongan Kerja</span>
                </a>
                <a href="{{ route('admin.applicants.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('admin.applicants.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fas fa-users w-6 text-center {{ request()->routeIs('admin.applicants.*') ? 'text-white' : 'text-slate-500 group-hover:text-white transition-colors' }}"></i>
                    <span class="ml-2 font-medium">Pelamar</span>
                </a>
                <a href="{{ route('admin.talent_pool.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('admin.talent_pool.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fas fa-address-book w-6 text-center {{ request()->routeIs('admin.talent_pool.*') ? 'text-white' : 'text-slate-500 group-hover:text-white transition-colors' }}"></i>
                    <span class="ml-2 font-medium">Talent Pool</span>
                </a>

                 <div class="mt-6 mb-2 pl-3 pr-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    Management
                </div>
                @php
                    $pendingFptk = \App\Models\Fptk::where('status', 'pending')->count();
                @endphp
                <a href="{{ route('admin.fptk.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('admin.fptk.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fas fa-file-contract w-6 text-center {{ request()->routeIs('admin.fptk.*') ? 'text-white' : 'text-slate-500 group-hover:text-white transition-colors' }}"></i>
                    <span class="ml-2 font-medium">FPTK</span>
                    @if($pendingFptk > 0)
                        <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-md">{{ $pendingFptk }}</span>
                    @endif
                </a>

                <div class="mt-6 mb-2 pl-3 pr-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    Content & System
                </div>
                <a href="{{ route('admin.content.edit') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('admin.content.edit') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fas fa-pen-nib w-6 text-center {{ request()->routeIs('admin.content.edit') ? 'text-white' : 'text-slate-500 group-hover:text-white transition-colors' }}"></i>
                    <span class="ml-2 font-medium">Konten Website</span>
                </a>
                 <a href="{{ route('admin.images.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('admin.images.index') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fas fa-images w-6 text-center {{ request()->routeIs('admin.images.index') ? 'text-white' : 'text-slate-500 group-hover:text-white transition-colors' }}"></i>
                    <span class="ml-2 font-medium">Galeri Gambar</span>
                </a>
                
                @php
                    $pendingPasswordRequests = \App\Models\PasswordResetRequest::where('status', 'pending')->count();
                @endphp
                <a href="{{ route('admin.password_requests.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('admin.password_requests.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fas fa-key w-6 text-center {{ request()->routeIs('admin.password_requests.*') ? 'text-white' : 'text-slate-500 group-hover:text-white transition-colors' }}"></i>
                    <span class="ml-2 font-medium">Reset Password</span>
                     @if($pendingPasswordRequests > 0)
                        <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-md">{{ $pendingPasswordRequests }}</span>
                    @endif
                </a>
            </nav>

            <!-- Bottom Action -->
            <div class="p-4 border-t border-slate-800 bg-slate-950">
                 <a href="{{ route('home') }}" class="flex items-center justify-center w-full px-4 py-2 text-sm text-slate-400 bg-slate-800 hover:bg-slate-700 hover:text-white rounded-lg transition-colors">
                    <i class="fas fa-globe mr-2"></i> Website Utama
                </a>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            
            <!-- Top Navbar -->
            <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-6 sticky top-0 z-40 bg-white/80 backdrop-blur-md">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-slate-500 hover:text-slate-700 lg:hidden focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <!-- Breadcrumbs could go here -->
                    <h2 class="ml-4 text-lg font-semibold text-slate-800 hidden md:block">@yield('title', 'Dashboard')</h2>
                </div>

                <div class="flex items-center gap-4">
                     <!-- Search Bar (Optional) -->
                    <div class="hidden md:block relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="pl-10 pr-4 py-2 border border-slate-200 rounded-full text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all w-64" placeholder="Cari data...">
                    </div>

                    <!-- User Menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-3 focus:outline-none">
                            <div class="text-right hidden md:block">
                                <div class="text-sm font-semibold text-slate-800">{{ auth()->user()->name }}</div>
                                <div class="text-xs text-slate-500 capitalize">{{ auth()->user()->role ?? 'Admin' }}</div>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold border border-blue-200">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                             <i class="fas fa-chevron-down text-xs text-slate-400"></i>
                        </button>

                        <!-- Dropdown -->
                        <div x-show="open" @click.away="open = false" x-transition 
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 py-2 z-50">
                            
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-blue-600">
                                <i class="fas fa-user-circle mr-2 w-4"></i> Profile
                            </a>
                            <div class="border-t border-slate-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt mr-2 w-4"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-auto bg-slate-50 p-6 lg:p-8">
                <!-- Notifications -->
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm flex items-start" role="alert">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                        <div>
                            <p class="font-medium text-green-800">Berhasil!</p>
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif
                
                @if($errors->any())
                     <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm flex items-start" role="alert">
                        <i class="fas fa-exclamation-circle text-red-500 mt-1 mr-3"></i>
                        <div>
                            <p class="font-medium text-red-800">Terjadi Kesalahan</p>
                            <ul class="mt-1 list-disc list-inside text-sm text-red-700">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @yield('scripts')
    @stack('scripts')
</body>

</html>