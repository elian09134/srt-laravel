<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - SRT Corp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white flex-shrink-0 h-screen sticky top-0">
            <div class="p-6 text-2xl font-bold">SRT <span class="text-blue-400">Admin</span></div>
            <nav class="mt-8">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : 'text-gray-400' }} hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                </a>
                <a href="{{ route('admin.applicants.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('admin.applicants.index') ? 'bg-gray-700' : 'text-gray-400' }} hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-users mr-3"></i> Data Pelamar
                </a>
                <a href="{{ route('admin.jobs.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('admin.jobs.*') ? 'bg-gray-700' : 'text-gray-400' }} hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-briefcase mr-3"></i> Kelola Lowongan
                </a>
                <a href="{{ route('admin.content.edit') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('admin.content.edit') ? 'bg-gray-700' : 'text-gray-400' }} hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-edit mr-3"></i> Kelola Konten
                </a>
                <a href="{{ route('admin.images.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('admin.images.index') ? 'bg-gray-700' : 'text-gray-400' }} hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-images mr-3"></i> Kelola Gambar
                </a>
                
                {{-- Tautan untuk fitur selanjutnya --}}
                {{-- 
                <a href="#" class="flex items-center px-6 py-3 text-gray-400 hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-database mr-3"></i> Talent Community
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-400 hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-comments mr-3"></i> Kelola Forum
                </a> 
                --}}

                <a href="{{ route('admin.invitations.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('admin.invitations.index') ? 'bg-gray-700' : 'text-gray-400' }} hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-paper-plane mr-3"></i> Undang Karyawan
                </a>
                <a href="{{ route('admin.employees.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('admin.employees.*') ? 'bg-gray-700' : 'text-gray-400' }} hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-id-card mr-3"></i> Kelola Karyawan
                </a>
                
                 <a href="{{ route('home') }}" class="flex items-center px-6 py-3 mt-4 text-gray-400 hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-arrow-left mr-3"></i> Kembali ke Website
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-grow p-8">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>
