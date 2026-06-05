<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - TERANG</title>
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

        {{-- Sidebar --}}
        <aside class="fixed inset-y-0 left-0 z-50 bg-white border-r border-slate-200 transition-all duration-300 flex flex-col"
               :class="sidebarOpen ? 'w-56' : 'w-16'">

            <div class="flex items-center h-16 px-3 border-b border-slate-100"
                 :class="sidebarOpen ? 'justify-between' : 'justify-center'">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
                    <div class="w-7 h-7 bg-indigo-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="font-bold text-white text-sm">T</span>
                    </div>
                    <span x-show="sidebarOpen" class="text-base font-semibold text-slate-800 whitespace-nowrap">TERANG<span class="text-indigo-600">ADMIN</span></span>
                </a>
            </div>

            <nav class="flex-1 overflow-y-auto sidebar-scroll py-4 space-y-0.5"
                 :class="sidebarOpen ? 'px-3' : 'px-2'">
                <div x-show="sidebarOpen" class="px-3 pb-1.5 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Main</div>
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center rounded-lg transition-all duration-200 group text-sm"
                   :class="[
                       sidebarOpen
                           ? 'px-3 py-2 ' + ({{ request()->routeIs('admin.dashboard') ? 'true' : 'false' }} ? 'nav-link-active' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700')
                           : 'px-2 py-2 justify-center ' + ({{ request()->routeIs('admin.dashboard') ? 'true' : 'false' }} ? 'nav-link-icon-only' : 'text-slate-500 hover:bg-slate-50')
                   ]">
                    <i class="fas fa-home w-5 text-center text-sm flex-shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-500' }}"></i>
                    <span x-show="sidebarOpen" class="ml-3 font-medium whitespace-nowrap">Dashboard</span>
                </a>

                <div x-show="sidebarOpen" class="mt-5 px-3 pb-1.5 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Recruitment</div>
                <a href="{{ route('admin.jobs.index') }}"
                   class="flex items-center rounded-lg transition-all duration-200 group text-sm"
                   :class="[
                       sidebarOpen
                           ? 'px-3 py-2 ' + ({{ request()->routeIs('admin.jobs.*') ? 'true' : 'false' }} ? 'nav-link-active' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700')
                           : 'px-2 py-2 justify-center ' + ({{ request()->routeIs('admin.jobs.*') ? 'true' : 'false' }} ? 'nav-link-icon-only' : 'text-slate-500 hover:bg-slate-50')
                   ]">
                    <i class="fas fa-briefcase w-5 text-center text-sm flex-shrink-0 {{ request()->routeIs('admin.jobs.*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-500' }}"></i>
                    <span x-show="sidebarOpen" class="ml-3 font-medium whitespace-nowrap">Lowongan Kerja</span>
                </a>
                <a href="{{ route('admin.applicants.index') }}"
                   class="flex items-center rounded-lg transition-all duration-200 group text-sm"
                   :class="[
                       sidebarOpen
                           ? 'px-3 py-2 ' + ({{ request()->routeIs('admin.applicants.*') ? 'true' : 'false' }} ? 'nav-link-active' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700')
                           : 'px-2 py-2 justify-center ' + ({{ request()->routeIs('admin.applicants.*') ? 'true' : 'false' }} ? 'nav-link-icon-only' : 'text-slate-500 hover:bg-slate-50')
                   ]">
                    <i class="fas fa-users w-5 text-center text-sm flex-shrink-0 {{ request()->routeIs('admin.applicants.*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-500' }}"></i>
                    <span x-show="sidebarOpen" class="ml-3 font-medium whitespace-nowrap">Pelamar</span>
                </a>
                <a href="{{ route('admin.talent_pool.index') }}"
                   class="flex items-center rounded-lg transition-all duration-200 group text-sm"
                   :class="[
                       sidebarOpen
                           ? 'px-3 py-2 ' + ({{ request()->routeIs('admin.talent_pool.*') ? 'true' : 'false' }} ? 'nav-link-active' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700')
                           : 'px-2 py-2 justify-center ' + ({{ request()->routeIs('admin.talent_pool.*') ? 'true' : 'false' }} ? 'nav-link-icon-only' : 'text-slate-500 hover:bg-slate-50')
                   ]">
                    <i class="fas fa-address-book w-5 text-center text-sm flex-shrink-0 {{ request()->routeIs('admin.talent_pool.*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-500' }}"></i>
                    <span x-show="sidebarOpen" class="ml-3 font-medium whitespace-nowrap">Talent Pool</span>
                </a>

                <div x-show="sidebarOpen" class="mt-5 px-3 pb-1.5 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Management</div>
                @php
                    $pendingFptk = \App\Models\Fptk::where('status', 'pending')->count();
                @endphp
                <a href="{{ route('admin.fptk.index') }}"
                   class="flex items-center rounded-lg transition-all duration-200 group text-sm"
                   :class="[
                       sidebarOpen
                           ? 'px-3 py-2 ' + ({{ request()->routeIs('admin.fptk.*') ? 'true' : 'false' }} ? 'nav-link-active' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700')
                           : 'px-2 py-2 justify-center ' + ({{ request()->routeIs('admin.fptk.*') ? 'true' : 'false' }} ? 'nav-link-icon-only' : 'text-slate-500 hover:bg-slate-50')
                   ]">
                    <i class="fas fa-file-contract w-5 text-center text-sm flex-shrink-0 {{ request()->routeIs('admin.fptk.*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-500' }}"></i>
                    <span x-show="sidebarOpen" class="ml-3 font-medium whitespace-nowrap">FPTK</span>
                    @if($pendingFptk > 0)
                        <span x-show="sidebarOpen" class="ml-auto bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full min-w-[18px] text-center">{{ $pendingFptk }}</span>
                    @endif
                </a>
                {{-- <a href="{{ route('admin.partner-targets.index') }}"
                   class="flex items-center rounded-lg transition-all duration-200 group text-sm"
                   :class="[
                       sidebarOpen
                           ? 'px-3 py-2 ' + ({{ request()->routeIs('admin.partner-targets.*') ? 'true' : 'false' }} ? 'nav-link-active' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700')
                           : 'px-2 py-2 justify-center ' + ({{ request()->routeIs('admin.partner-targets.*') ? 'true' : 'false' }} ? 'nav-link-icon-only' : 'text-slate-500 hover:bg-slate-50')
                   ]">
                    <i class="fas fa-bullseye w-5 text-center text-sm flex-shrink-0 {{ request()->routeIs('admin.partner-targets.*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-500' }}"></i>
                    <span x-show="sidebarOpen" class="ml-3 font-medium whitespace-nowrap">Target Mitra</span>
                </a> --}}

                <div x-show="sidebarOpen" class="mt-5 px-3 pb-1.5 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Content & System</div>
                <a href="{{ route('admin.content.edit') }}"
                   class="flex items-center rounded-lg transition-all duration-200 group text-sm"
                   :class="[
                       sidebarOpen
                           ? 'px-3 py-2 ' + ({{ request()->routeIs('admin.content.edit') ? 'true' : 'false' }} ? 'nav-link-active' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700')
                           : 'px-2 py-2 justify-center ' + ({{ request()->routeIs('admin.content.edit') ? 'true' : 'false' }} ? 'nav-link-icon-only' : 'text-slate-500 hover:bg-slate-50')
                   ]">
                    <i class="fas fa-pen-nib w-5 text-center text-sm flex-shrink-0 {{ request()->routeIs('admin.content.edit') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-500' }}"></i>
                    <span x-show="sidebarOpen" class="ml-3 font-medium whitespace-nowrap">Konten Website</span>
                </a>
                <a href="{{ route('admin.images.index') }}"
                   class="flex items-center rounded-lg transition-all duration-200 group text-sm"
                   :class="[
                       sidebarOpen
                           ? 'px-3 py-2 ' + ({{ request()->routeIs('admin.images.index') ? 'true' : 'false' }} ? 'nav-link-active' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700')
                           : 'px-2 py-2 justify-center ' + ({{ request()->routeIs('admin.images.index') ? 'true' : 'false' }} ? 'nav-link-icon-only' : 'text-slate-500 hover:bg-slate-50')
                   ]">
                    <i class="fas fa-images w-5 text-center text-sm flex-shrink-0 {{ request()->routeIs('admin.images.index') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-500' }}"></i>
                    <span x-show="sidebarOpen" class="ml-3 font-medium whitespace-nowrap">Galeri Gambar</span>
                </a>

                @php
                    $pendingPasswordRequests = \App\Models\PasswordResetRequest::where('status', 'pending')->count();
                @endphp
                <a href="{{ route('admin.password_requests.index') }}"
                   class="flex items-center rounded-lg transition-all duration-200 group text-sm"
                   :class="[
                       sidebarOpen
                           ? 'px-3 py-2 ' + ({{ request()->routeIs('admin.password_requests.*') ? 'true' : 'false' }} ? 'nav-link-active' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700')
                           : 'px-2 py-2 justify-center ' + ({{ request()->routeIs('admin.password_requests.*') ? 'true' : 'false' }} ? 'nav-link-icon-only' : 'text-slate-500 hover:bg-slate-50')
                   ]">
                    <i class="fas fa-key w-5 text-center text-sm flex-shrink-0 {{ request()->routeIs('admin.password_requests.*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-500' }}"></i>
                    <span x-show="sidebarOpen" class="ml-3 font-medium whitespace-nowrap">Reset Password</span>
                    @if($pendingPasswordRequests > 0)
                        <span x-show="sidebarOpen" class="ml-auto bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full min-w-[18px] text-center">{{ $pendingPasswordRequests }}</span>
                    @endif
                </a>
            </nav>

            <div class="border-t border-slate-100"
                 :class="sidebarOpen ? 'p-3' : 'p-2'">
                <a href="{{ route('home') }}" class="flex items-center rounded-lg transition-colors"
                   :class="sidebarOpen ? 'px-3 py-2 text-sm text-slate-400 hover:text-slate-600 hover:bg-slate-50 justify-center' : 'p-2 text-slate-400 hover:text-slate-600 justify-center'">
                    <i class="fas fa-globe mr-0 flex-shrink-0"></i>
                    <span x-show="sidebarOpen" class="ml-2">Website Utama</span>
                </a>
            </div>
        </aside>

        {{-- Overlay for mobile --}}
        <div x-show="sidebarOpen" @@click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black/20 lg:hidden"></div>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden transition-all duration-300"
             :class="sidebarOpen ? 'lg:ml-56' : 'lg:ml-16'">
            <header class="h-16 flex items-center justify-between px-6 bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-30">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-slate-400 hover:text-slate-600 focus:outline-none transition-colors">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                    <h2 class="text-sm font-medium text-slate-500 hidden md:block">
                        @yield('title', 'Dashboard')
                    </h2>
                </div>

                <div class="flex items-center gap-4">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2.5 focus:outline-none group">
                            <div class="text-right hidden md:block">
                                <div class="text-sm font-medium text-slate-700 group-hover:text-slate-900 transition-colors">{{ auth()->user()->name }}</div>
                                <div class="text-[11px] text-slate-400 capitalize">{{ auth()->user()->role ?? 'Admin' }}</div>
                            </div>
                            <div class="w-8 h-8 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 text-sm font-semibold border border-indigo-100">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <i class="fas fa-chevron-down text-[10px] text-slate-300 group-hover:text-slate-400 transition-colors"></i>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 py-1.5 z-50">
                            <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-colors">
                                <i class="fas fa-user-circle mr-2.5 w-4 text-slate-400"></i> Profile
                            </a>
                            <div class="border-t border-slate-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-500 hover:bg-red-50 transition-colors">
                                    <i class="fas fa-sign-out-alt mr-2.5 w-4"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-auto bg-slate-50 p-6 lg:p-8">
                @if(session('success'))
                    <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-start gap-3" role="alert">
                        <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                        <div>
                            <p class="font-medium text-emerald-800 text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 flex items-start gap-3" role="alert">
                        <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                        <div>
                            <p class="font-medium text-red-800 text-sm">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 flex items-start gap-3" role="alert">
                        <i class="fas fa-exclamation-circle text-red-500 mt-0.5 shrink-0"></i>
                        <div>
                            <p class="font-medium text-red-800 text-sm mb-1">Terjadi Kesalahan</p>
                            <ul class="text-sm text-red-700 space-y-0.5 list-disc list-inside">
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
