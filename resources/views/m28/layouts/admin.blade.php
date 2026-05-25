<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - M28 Panel</title>
    <meta name="theme-color" content="#581c87">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .nav-link-active {
            background: #f5f3ff;
            border-right: 3px solid #7c3aed;
            color: #6d28d9;
        }
        .nav-link-active i {
            color: #7c3aed;
        }
        .nav-link-icon-only {
            background: #f5f3ff;
            color: #6d28d9;
            border-radius: 0.5rem;
        }
        .nav-link-icon-only i {
            color: #7c3aed;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased" x-data="{ sidebarOpen: true }">
    <div class="flex h-screen overflow-hidden">
        <aside class="fixed inset-y-0 left-0 z-50 bg-white border-r border-slate-200 transition-all duration-300 flex flex-col"
               :class="sidebarOpen ? 'w-56' : 'w-16'">
            <div class="flex items-center h-16 px-3 border-b border-slate-100"
                 :class="sidebarOpen ? 'justify-between' : 'justify-center'">
                <a href="{{ route('m28.dashboard') }}" class="flex items-center gap-2.5">
                    <div class="w-7 h-7 bg-purple-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="font-bold text-white text-sm">M</span>
                    </div>
                    <span x-show="sidebarOpen" class="text-base font-semibold text-slate-800 whitespace-nowrap">M28<span class="text-purple-600">PANEL</span></span>
                </a>
            </div>
            <nav class="flex-1 overflow-y-auto sidebar-scroll py-4 space-y-0.5"
                 :class="sidebarOpen ? 'px-3' : 'px-2'">
                <div x-show="sidebarOpen" class="px-3 pb-1.5 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Main</div>
                <a href="{{ route('m28.dashboard') }}"
                   class="flex items-center rounded-lg transition-all duration-200 group text-sm"
                   :class="[
                       sidebarOpen
                           ? 'px-3 py-2 ' + ({{ request()->routeIs('m28.dashboard') ? 'true' : 'false' }} ? 'nav-link-active' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700')
                           : 'px-2 py-2 justify-center ' + ({{ request()->routeIs('m28.dashboard') ? 'true' : 'false' }} ? 'nav-link-icon-only' : 'text-slate-500 hover:bg-slate-50')
                   ]">
                    <i class="fas fa-home w-5 text-center text-sm flex-shrink-0 {{ request()->routeIs('m28.dashboard') ? 'text-purple-600' : 'text-slate-400 group-hover:text-slate-500' }}"></i>
                    <span x-show="sidebarOpen" class="ml-3 font-medium whitespace-nowrap">Dashboard</span>
                </a>
                <a href="{{ route('m28.candidates.index') }}"
                   class="flex items-center rounded-lg transition-all duration-200 group text-sm"
                   :class="[
                       sidebarOpen
                           ? 'px-3 py-2 ' + ({{ request()->routeIs('m28.candidates.*') ? 'true' : 'false' }} ? 'nav-link-active' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700')
                           : 'px-2 py-2 justify-center ' + ({{ request()->routeIs('m28.candidates.*') ? 'true' : 'false' }} ? 'nav-link-icon-only' : 'text-slate-500 hover:bg-slate-50')
                   ]">
                    <i class="fas fa-users w-5 text-center text-sm flex-shrink-0 {{ request()->routeIs('m28.candidates.*') ? 'text-purple-600' : 'text-slate-400 group-hover:text-slate-500' }}"></i>
                    <span x-show="sidebarOpen" class="ml-3 font-medium whitespace-nowrap">Kandidat Saya</span>
                </a>
            </nav>
            <div class="p-3 border-t border-slate-100"
                 :class="sidebarOpen ? 'p-3' : 'p-2'">
                <a href="{{ route('home') }}" class="flex items-center rounded-lg transition-colors"
                   :class="sidebarOpen ? 'px-4 py-2 text-sm font-medium text-slate-500 bg-slate-50 hover:bg-slate-100 hover:text-slate-700 justify-center' : 'p-2 text-slate-400 hover:text-slate-600 justify-center'">
                    <i class="fas fa-globe mr-0 flex-shrink-0"></i>
                    <span x-show="sidebarOpen" class="ml-2">Website Utama</span>
                </a>
            </div>
        </aside>
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black/20 lg:hidden"></div>
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden transition-all duration-300"
             :class="sidebarOpen ? 'lg:ml-56' : 'lg:ml-16'">
                <header class="h-16 flex items-center justify-between px-6 bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-30">
                    <div class="flex items-center gap-3">
                        <button @click="sidebarOpen = !sidebarOpen" class="text-slate-400 hover:text-slate-600 focus:outline-none transition-colors">
                            <i class="fas fa-bars text-lg"></i>
                        </button>
                        <h2 class="text-sm font-medium text-slate-500 hidden md:block">@yield('title', 'Dashboard')</h2>
                    </div>
                <div class="flex items-center gap-4">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-3 focus:outline-none">
                            <div class="text-right hidden md:block">
                                <div class="text-sm font-semibold text-slate-800">{{ auth()->user()->name }}</div>
                                <div class="text-xs text-slate-500 capitalize">Partner</div>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-bold border border-purple-200 uppercase">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <i class="fas fa-chevron-down text-xs text-slate-400"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 py-2 z-50">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <i class="fas fa-sign-out-alt mr-2 w-4"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>
            <main class="flex-1 overflow-auto bg-slate-50 p-6 lg:p-8">
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                        <div>
                            <p class="font-medium text-green-800">Berhasil!</p>
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif
                @if($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm flex items-start">
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
