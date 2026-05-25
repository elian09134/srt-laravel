<?php /* Blade view */ ?>
@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-slate-800">Manajemen FPTK</h1>
        <p class="text-sm text-slate-500 mt-1">Kelola permintaan tenaga kerja dari seluruh divisi</p>
    </div>

    @if(session('status'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-center gap-3" role="alert">
            <i class="fas fa-check-circle text-emerald-500"></i>
            <span class="text-sm font-medium text-emerald-800">{{ session('status') }}</span>
        </div>
    @endif

    <!-- Tab Navigation -->
    <div class="mb-6 border-b border-slate-200">
        <nav class="flex space-x-6" aria-label="Tabs">
            {{-- Tab: FPTK Proses --}}
            <a href="{{ route('admin.fptk.index', ['tab' => 'proses']) }}"
               class="inline-flex items-center px-1 py-3 border-b-2 text-sm font-medium transition-colors
                      {{ $tab === 'proses' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}">
                <i class="fas fa-clock mr-2 text-xs {{ $tab === 'proses' ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                FPTK Proses
                <span class="ml-2 px-2 py-0.5 rounded-full text-xs font-medium {{ $tab === 'proses' ? 'bg-indigo-50 text-indigo-600' : 'bg-slate-50 text-slate-500' }}">
                    {{ $countProses }}
                </span>
            </a>

            {{-- Tab: FPTK Selesai --}}
            <a href="{{ route('admin.fptk.index', ['tab' => 'selesai']) }}"
               class="inline-flex items-center px-1 py-3 border-b-2 text-sm font-medium transition-colors
                      {{ $tab === 'selesai' ? 'border-emerald-600 text-emerald-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}">
                <i class="fas fa-check-circle mr-2 text-xs {{ $tab === 'selesai' ? 'text-emerald-600' : 'text-slate-400' }}"></i>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                FPTK Selesai
                <span class="ml-2 px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $tab === 'selesai' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                    {{ $countSelesai }}
                </span>
            </a>

            {{-- Tab: Arsip FPTK --}}
            <a href="{{ route('admin.fptk.index', ['tab' => 'arsip']) }}"
               class="group inline-flex items-center px-5 py-3 border-b-2 font-medium text-sm transition-colors
                      {{ $tab === 'arsip' ? 'border-amber-600 text-amber-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <svg class="w-5 h-5 mr-2 {{ $tab === 'arsip' ? 'text-amber-600' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                </svg>
                Arsip FPTK
                <span class="ml-2 px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $tab === 'arsip' ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-600' }}">
                    {{ $countArsip }}
                </span>
            </a>
        </nav>
    <!-- Filter Section -->
    <div class="mb-6 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
        <form action="{{ route('admin.fptk.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
            <input type="hidden" name="tab" value="{{ $tab }}">
            
            {{-- Filter Divisi --}}
            <div class="flex-1 min-w-[200px]">
                <label for="division" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Divisi</label>
                <select name="division" id="division" class="w-full bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    <option value="">Semua Divisi</option>
                    @foreach($divisions as $div)
                        <option value="{{ $div }}" {{ $selectedDivision == $div ? 'selected' : '' }}>{{ $div }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Tanggal Mulai --}}
            <div class="w-full sm:w-auto">
                <label for="start_date" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Dari Tanggal</label>
                <input type="date" name="start_date" id="start_date" value="{{ $startDate }}"
                       class="bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            {{-- Filter Tanggal Selesai --}}
            <div class="w-full sm:w-auto">
                <label for="end_date" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Sampai Tanggal</label>
                <input type="date" name="end_date" id="end_date" value="{{ $endDate }}"
                       class="bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-2">
                <button type="submit" class="inline-flex items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-sm transition transform hover:scale-105 text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filter
                </button>
                @if($selectedDivision || $startDate || $endDate)
                    <a href="{{ route('admin.fptk.index', ['tab' => $tab]) }}" class="inline-flex items-center px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold rounded-lg shadow-sm transition text-sm">
                        Bereskan
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b-2 border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pengaju</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Posisi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kualifikasi</th>
                        @if($tab === 'proses')
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Progress</th>
                        @elseif($tab === 'selesai')
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Selesai Pada</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tipe</th>
                        @else
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Diarsipkan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status Asal</th>
                        @endif
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($fptks as $f)
                    @php
                        $notes = is_array($f->notes) ? $f->notes : (is_string($f->notes) ? json_decode($f->notes, true) : []);
                        $k = $notes['keterampilan'] ?? null;
                        $ks = $k ? array_filter(array_map('trim', explode(',', $k))) : [];
                    @endphp
                    <tr class="hover:bg-blue-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 text-blue-800 font-bold text-sm">#{{ $f->id }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-semibold text-sm">{{ strtoupper(substr($f->user->name ?? '-', 0, 2)) }}</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $f->user->name ?? '-' }}</p>
                                    <p class="text-xs text-gray-500">{{ $f->user->email ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $f->position }}</div>
                            <div class="text-xs text-gray-500">{{ $notes['division'] ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2 text-sm">
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">&#9794; {{ $notes['qty_male'] ?? 0 }}</span>
                                <span class="px-2 py-1 bg-pink-100 text-pink-800 rounded-full text-xs font-medium">&#9792; {{ $notes['qty_female'] ?? 0 }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            @if(count($ks))
                                <div class="space-y-1">
                                    @foreach(array_slice($ks,0,2) as $it)
                                        <div class="flex items-center text-xs">
                                            <svg class="w-3 h-3 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                            {{ $it }}
                                        </div>
                                    @endforeach
                                    @if(count($ks) > 2)
                                        <div class="text-xs text-gray-400 italic">+{{ count($ks) - 2 }} lainnya</div>
                                    @endif
                                </div>
                            @else
                                <span class="text-gray-400 italic">Tidak ada</span>
                            @endif
                        </td>

                        @if($tab === 'proses')
                            {{-- Status column --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($f->status === 'pending')
                                    <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                                        Pending
                                    </span>
                                @elseif($f->status === 'approved')
                                    <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        Disetujui
                                    </span>
                                @endif
                            </td>
                            {{-- Progress column --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($f->status === 'approved')
                                    <div class="flex items-center space-x-2">
                                        <div class="w-20 bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-blue-600 h-2.5 rounded-full transition-all" style="width: {{ $f->fulfilled_percent }}%"></div>
                                        </div>
                                        <span class="text-xs font-bold text-gray-700">{{ $f->fulfilled_count }}/{{ $f->qty }}</span>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 italic">Menunggu approval</span>
                                @endif
                            </td>

                        @elseif($tab === 'selesai')
                            {{-- Selesai Pada column --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div>{{ $f->completed_at ? $f->completed_at->format('d M Y') : '-' }}</div>
                                <div class="text-xs text-gray-400">{{ $f->completed_at ? $f->completed_at->diffForHumans() : '' }}</div>
                            </td>
                            {{-- Tipe column --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($f->completed_by)
                                    <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        Manual
                                    </span>
                                    <div class="text-xs text-gray-400 mt-1">oleh {{ $f->completedByUser->name ?? '-' }}</div>
                                @else
                                    <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-teal-100 text-teal-800">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Otomatis
                                    </span>
                                    <div class="text-xs text-gray-400 mt-1">Kebutuhan terpenuhi</div>
                                @endif
                            </td>

                        @else {{-- arsip --}}
                            {{-- Diarsipkan column --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div>{{ $f->archived_at ? $f->archived_at->format('d M Y') : '-' }}</div>
                                <div class="text-xs text-gray-400">{{ $f->archived_at ? $f->archived_at->diffForHumans() : '' }}</div>
                            </td>
                            {{-- Status asal column --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($f->isCompleted())
                                    <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        Selesai
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                                        Diarsipkan Manual
                                    </span>
                                @endif
                            </td>
                        @endif

                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.fptk.show', $f->id) }}" class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-sm hover:shadow-md transition transform hover:scale-105 text-xs">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
                                    Detail
                                </a>
                                @if($tab === 'proses' || $tab === 'selesai')
                                    <form method="POST" action="{{ route('admin.fptk.archive', $f->id) }}" onsubmit="return confirm('Pindahkan FPTK ini ke arsip?')" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-medium rounded-lg shadow-sm hover:shadow-md transition transform hover:scale-105 text-xs">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                                            Arsipkan
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-gray-500 font-medium">
                                    @if($tab === 'proses')
                                        Tidak ada FPTK yang sedang diproses.
                                    @elseif($tab === 'selesai')
                                        Belum ada FPTK yang selesai.
                                    @else
                                        Belum ada FPTK yang diarsipkan.
                                    @endif
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
