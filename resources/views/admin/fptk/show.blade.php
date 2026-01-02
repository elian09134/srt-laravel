<?php /* Blade view */ ?>
@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-7xl mx-auto">
    @php
        $notes = is_array($fptk->notes) ? $fptk->notes : (is_string($fptk->notes) ? json_decode($fptk->notes, true) : []);
        $notes = $notes ?: [];
        $das = $notes['dasar_permintaan'] ?? null;
        $dasList = is_array($das) ? $das : [];
        $k = $notes['keterampilan'] ?? null;
        $kList = $k ? array_filter(array_map('trim', explode(',', $k))) : [];
    @endphp

    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <div class="flex items-center space-x-3 mb-2">
                <a href="{{ route('admin.fptk.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-gray-800">Detail FPTK #{{ $fptk->id }}</h1>
            </div>
            <p class="text-gray-500 ml-9">Informasi lengkap permintaan tenaga kerja</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.fptk.pdf', $fptk->id) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition transform hover:scale-105">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"/>
                </svg>
                Export PDF
            </a>
            @if($fptk->status === 'pending')
                <span class="px-4 py-2 inline-flex items-center text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                    Menunggu Review
                </span>
            @elseif($fptk->status === 'approved')
                <span class="px-4 py-2 inline-flex items-center text-sm font-semibold rounded-full bg-green-100 text-green-800">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    Disetujui
                </span>
            @else
                <span class="px-4 py-2 inline-flex items-center text-sm font-semibold rounded-full bg-red-100 text-red-800">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                    Ditolak
                </span>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informasi Pengaju -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl shadow-sm p-6">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-100 rounded-lg p-2 mr-3">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Informasi Pengaju</h2>
                </div>
                <div class="bg-white rounded-lg p-4 space-y-3">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-lg">{{ strtoupper(substr($fptk->user->name, 0, 2)) }}</span>
                        </div>
                        <div class="ml-4">
                            <p class="text-lg font-semibold text-gray-900">{{ $fptk->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $fptk->user->email }}</p>
                        </div>
                    </div>
                    <div class="border-t pt-3">
                        <p class="text-sm text-gray-500">Diajukan pada</p>
                        <p class="text-gray-900 font-medium">{{ $fptk->created_at->format('d F Y, H:i') }} WIB</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $fptk->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>

            <!-- Informasi Posisi -->
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl shadow-sm p-6">
                <div class="flex items-center mb-4">
                    <div class="bg-purple-100 rounded-lg p-2 mr-3">
                        <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Informasi Posisi</h2>
                </div>
                <div class="bg-white rounded-lg p-4 space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Posisi yang Dibutuhkan</p>
                        <p class="text-xl font-bold text-gray-900">{{ $fptk->position }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Divisi</p>
                            <p class="font-semibold text-gray-900">{{ $notes['division'] ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Lokasi</p>
                            <p class="font-semibold text-gray-900">{{ $fptk->locations }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-2">Jumlah Kebutuhan</p>
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center space-x-2">
                                <span class="px-3 py-1.5 bg-blue-100 text-blue-800 rounded-lg font-semibold text-sm">♂ {{ $notes['qty_male'] ?? 0 }} Pria</span>
                                <span class="px-3 py-1.5 bg-pink-100 text-pink-800 rounded-lg font-semibold text-sm">♀ {{ $notes['qty_female'] ?? 0 }} Wanita</span>
                            </div>
                            <span class="text-gray-400">•</span>
                            <span class="text-lg font-bold text-gray-700">Total: {{ $fptk->qty }} orang</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Tanggal Kebutuhan</p>
                        <p class="font-semibold text-gray-900">{{ $notes['date_needed'] ? date('d F Y', strtotime($notes['date_needed'])) : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-2">Dasar Permintaan</p>
                        @if(count($dasList))
                            <div class="space-y-1.5">
                                @foreach($dasList as $d)
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-gray-700">{{ $d }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-400 italic">Tidak ada data</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Spesifikasi & Kualifikasi -->
            <div class="bg-gradient-to-r from-green-50 to-teal-50 rounded-xl shadow-sm p-6">
                <div class="flex items-center mb-4">
                    <div class="bg-green-100 rounded-lg p-2 mr-3">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Spesifikasi & Kualifikasi</h2>
                </div>
                <div class="bg-white rounded-lg p-4 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Golongan / Status</p>
                            <p class="font-semibold text-gray-900">{{ $notes['golongan_gaji'] ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Penempatan</p>
                            <p class="font-semibold text-gray-900">{{ $notes['penempatan'] ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Gaji</p>
                            <p class="font-semibold text-gray-900">{{ isset($notes['gaji']) ? 'Rp ' . number_format($notes['gaji'],0,',','.') : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Usia</p>
                            <p class="font-semibold text-gray-900">{{ $notes['usia'] ?? '-' }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Pendidikan</p>
                        <p class="font-semibold text-gray-900">{{ $notes['pendidikan'] ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Pengalaman</p>
                        <p class="font-semibold text-gray-900">{{ $notes['pengalaman'] ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-2">Kualifikasi / Keterampilan</p>
                        @if(count($kList))
                            <div class="grid grid-cols-1 gap-2">
                                @foreach($kList as $item)
                                    <div class="flex items-start bg-green-50 rounded-lg p-2">
                                        <svg class="w-5 h-5 text-green-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-gray-700">{{ $item }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-400 italic">Tidak ada data</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-2">Uraian Tugas</p>
                        <div class="bg-gray-50 rounded-lg p-3 text-gray-700 leading-relaxed">
                            {!! nl2br(e($notes['uraian'] ?? 'Tidak ada uraian')) !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Catatan -->
            @if(!empty($notes['notes_text']) || $fptk->admin_note)
            <div class="bg-gradient-to-r from-orange-50 to-yellow-50 rounded-xl shadow-sm p-6">
                <div class="flex items-center mb-4">
                    <div class="bg-orange-100 rounded-lg p-2 mr-3">
                        <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Catatan</h2>
                </div>
                <div class="bg-white rounded-lg p-4 space-y-3">
                    @if(!empty($notes['notes_text']))
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Catatan Pengaju</p>
                            <p class="text-gray-700">{{ $notes['notes_text'] }}</p>
                        </div>
                    @endif
                    @if($fptk->admin_note)
                        <div class="border-t pt-3">
                            <p class="text-sm text-gray-500 mb-1">Catatan Admin</p>
                            <p class="text-gray-700">{{ $fptk->admin_note }}</p>
                        </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar Actions -->
        <div class="lg:col-span-1">
            @if($fptk->status === 'pending')
            <div class="bg-white rounded-xl shadow-lg p-6 sticky top-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Tindakan</h3>
                <form method="POST" action="{{ route('admin.fptk.approve', $fptk->id) }}" class="mb-4">
                    @csrf
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (opsional)</label>
                    <textarea name="admin_note" rows="3" placeholder="Tambahkan catatan persetujuan..." class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent transition"></textarea>
                    <button type="submit" class="w-full mt-3 inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Setujui FPTK
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.fptk.reject', $fptk->id) }}">
                    @csrf
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan</label>
                    <textarea name="admin_note" rows="3" placeholder="Alasan penolakan (wajib)..." required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent transition"></textarea>
                    <button type="submit" class="w-full mt-3 inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        Tolak FPTK
                    </button>
                </form>
            </div>
            @else
            <div class="bg-white rounded-xl shadow-lg p-6 sticky top-6">
                <h3 class="text-lg font-bold text-gray-800 mb-3">Status</h3>
                <p class="text-gray-600 text-sm mb-4">FPTK ini sudah {{ $fptk->status === 'approved' ? 'disetujui' : 'ditolak' }}.</p>
                <a href="{{ route('admin.fptk.index') }}" class="block w-full text-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition">
                    Kembali ke Daftar
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
