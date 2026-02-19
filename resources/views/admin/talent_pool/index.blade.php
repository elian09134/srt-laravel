@extends('layouts.admin')

@section('title', 'Talent Pool - TERANG By SRT')

@section('content')
    <!-- Header Page -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Talent Pool</h1>
            <p class="text-slate-500 mt-1 font-medium italic">Database kandidat potensial untuk masa depan perusahaan.</p>
        </div>
        <div class="flex items-center space-x-3">
             <div class="bg-white px-4 py-2.5 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-3 transition-all hover:shadow-md">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <div class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Total Talent</div>
                    <div class="text-sm font-bold text-slate-900">{{ $items->total() }} Kandidat</div>
                </div>
             </div>
        </div>
    </div>

    <!-- Filters & Table Card -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden mb-8 transition-all hover:border-blue-100">
        <!-- Table Search/Filter -->
        <div class="p-6 border-b border-slate-50 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <h2 class="text-lg font-bold text-slate-800 flex items-center">
                <span class="w-1.5 h-6 bg-blue-600 rounded-full mr-3"></span>
                Daftar Kandidat
            </h2>
            <form action="{{ route('admin.talent_pool.index') }}" method="GET" class="relative w-full md:w-96 group">
                <input type="text" name="search" value="{{ request('search') }}" 
                       class="w-full pl-11 pr-4 py-3 bg-slate-50 border-transparent rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:bg-white focus:border-blue-500/20 transition-all text-sm font-medium" 
                       placeholder="Cari nama, email, atau keahlian...">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors">
                    <i class="fas fa-search"></i>
                </div>
                @if(request('search'))
                    <a href="{{ route('admin.talent_pool.index') }}" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-red-500">
                        <i class="fas fa-times-circle"></i>
                    </a>
                @endif
            </form>
        </div>

        <!-- Desktop Table View -->
        <div class="overflow-x-auto min-h-[400px]">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-4 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">#</th>
                        <th class="px-6 py-4 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Profil Kandidat</th>
                        <th class="px-6 py-4 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Latar Belakang / Keahlian</th>
                        <th class="px-6 py-4 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Status</th>
                        <th class="px-6 py-4 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Terdaftar</th>
                        <th class="px-6 py-4 text-center text-[11px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($items as $item)
                        <tr class="hover:bg-blue-50/30 transition-colors group">
                            <td class="px-6 py-5 whitespace-nowrap text-xs font-bold text-slate-300">
                                {{ $loop->iteration + ($items->currentPage() - 1) * $items->perPage() }}
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 p-[2px] shadow-sm group-hover:shadow-md transition-all">
                                        <div class="h-full w-full rounded-[14px] bg-white flex items-center justify-center overflow-hidden">
                                            @if($item->user && $item->user->profile && $item->user->profile->photo_path)
                                                <img class="h-full w-full object-cover" src="{{ asset('storage/' . $item->user->profile->photo_path) }}" alt="{{ $item->user->name }}">
                                            @else
                                                <span class="text-blue-600 font-bold text-lg uppercase">{{ substr($item->user->name ?? '?', 0, 1) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-slate-900 group-hover:text-blue-600 transition-colors">
                                            {{ $item->user->name ?? '—' }}
                                        </div>
                                        <div class="text-xs text-slate-500 font-medium flex items-center mt-0.5">
                                            <i class="far fa-envelope mr-1.5 opacity-50"></i>
                                            {{ $item->user->email ?? '—' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-sm font-bold text-slate-700">
                                    @php
                                        $workExps = $item->user->workExperiences ?? collect();
                                        if ($workExps->count() > 0) {
                                            $jobDesc = $workExps->first()->job_description;
                                            $position = $jobDesc ? explode(' — ', $jobDesc)[0] : '-';
                                            echo Str::limit($position, 40);
                                        } else {
                                            echo Str::limit($item->job_preferences ?? '—', 40);
                                        }
                                    @endphp
                                </div>
                                <div class="inline-flex items-center text-[10px] font-bold text-blue-500 bg-blue-50 px-2 py-0.5 rounded-lg mt-1 group-hover:bg-white group-hover:shadow-sm transition-all uppercase tracking-tighter">
                                    <i class="fas fa-graduation-cap mr-1"></i>
                                    {{ $item->user->profile->education_level ?? 'Data Pendidikan (-) ' }}
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                @php
                                    $statusClasses = [
                                        'invited' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'available' => 'bg-sky-50 text-sky-600 border-sky-100',
                                        'contacted' => 'bg-amber-50 text-amber-600 border-amber-100',
                                        'hired' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                        'shortlist' => 'bg-slate-50 text-slate-600 border-slate-100',
                                    ];
                                    $currentStatus = strtolower($item->status);
                                    $badgeStyle = $statusClasses[$currentStatus] ?? 'bg-slate-50 text-slate-600 border-slate-100';
                                @endphp
                                <span class="px-3 py-1.5 rounded-xl text-[10px] font-black border {{ $badgeStyle }} uppercase tracking-widest shadow-sm group-hover:shadow transition-all">
                                    <i class="fas fa-circle text-[6px] mr-1.5 mb-[1px]"></i>
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-700">
                                    {{ $item->created_at->translatedFormat('d M Y') }}
                                </div>
                                <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-0.5">
                                    {{ $item->created_at->diffForHumans() }}
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-center">
                                <a href="{{ route('admin.talent_pool.show', $item) }}" 
                                   class="inline-flex items-center justify-center h-10 px-4 space-x-2 rounded-2xl bg-slate-50 text-slate-600 hover:bg-blue-600 hover:text-white hover:shadow-lg hover:shadow-blue-500/30 transition-all font-bold group/btn">
                                    <span class="text-xs uppercase tracking-widest">Detail</span>
                                    <i class="fas fa-chevron-right text-[10px] group-hover/btn:translate-x-1 transition-transform"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-24 text-center">
                                <div class="max-w-xs mx-auto flex flex-col items-center">
                                    <div class="relative mb-6">
                                        <div class="w-24 h-24 bg-slate-50 rounded-[40px] flex items-center justify-center">
                                            <i class="fas fa-user-astronaut text-slate-200 text-4xl animate-bounce"></i>
                                        </div>
                                        <div class="absolute -right-2 -bottom-2 w-10 h-10 bg-white shadow-lg rounded-2xl flex items-center justify-center text-red-100">
                                            <i class="fas fa-search"></i>
                                        </div>
                                    </div>
                                    <h3 class="text-slate-900 font-black text-lg mb-2">Talent Tidak Ditemukan</h3>
                                    <p class="text-slate-500 text-sm font-medium leading-relaxed">Kami tidak dapat menemukan data kandidat yang Anda cari. Coba gunakan kata kunci lain.</p>
                                    <a href="{{ route('admin.talent_pool.index') }}" class="mt-6 px-6 py-2 bg-blue-600 text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-500/20 transition-all">Reset Pencarian</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($items->hasPages())
            <div class="px-8 py-8 border-t border-slate-50 bg-slate-50/20 flex flex-col md:flex-row items-center justify-between">
                <p class="text-xs font-bold text-slate-400 mb-4 md:mb-0 uppercase tracking-widest">Menampilkan {{ $items->count() }} dari {{ $items->total() }} kandidat</p>
                <div class="pagination-modern">
                    {{ $items->onEachSide(1)->links() }}
                </div>
            </div>
        @endif
    </div>

    <style>
        .pagination-modern nav > div:first-child { display: none; }
        .pagination-modern nav span, .pagination-modern nav a {
            @apply border-none bg-white rounded-xl mx-0.5 text-xs font-black text-slate-500 shadow-sm transition-all flex items-center justify-center w-9 h-9;
        }
        .pagination-modern nav span[aria-current="page"] {
            @apply bg-blue-600 text-white shadow-lg shadow-blue-500/20;
        }
    </style>
@endsection
