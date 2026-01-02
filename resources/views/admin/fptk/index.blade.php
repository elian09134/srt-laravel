<?php /* Blade view */ ?>
@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl shadow-lg p-6">
        <div class="flex items-center">
            <div class="bg-white bg-opacity-20 rounded-lg p-3 mr-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-white">Manajemen FPTK</h1>
                <p class="text-blue-100 mt-1">Kelola permintaan tenaga kerja dari seluruh divisi</p>
            </div>
        </div>
    </div>
    
    <div class="mb-6">
        <p class="text-gray-600 mt-1">Kelola pengajuan Form Permintaan Tenaga Kerja dari tim operasional</p>
    </div>

    @if(session('status'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <span class="font-medium">{{ session('status') }}</span>
            </div>
        </div>
    @endif

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
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Dibuat</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($fptks as $f)
                    @php 
                        $notes = is_array($f->notes) ? $f->notes : (is_string($f->notes) ? json_decode($f->notes, true) : []);
                        $k = $notes['keterampilan'] ?? null;
                        $ks = $k ? array_filter(array_map('trim', explode(',', $k))) : [];
                        $male = $notes['qty_male'] ?? 0;
                        $female = $notes['qty_female'] ?? 0;
                    @endphp
                    <tr class="hover:bg-blue-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 text-blue-800 font-bold text-sm">#{{ $f->id }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-semibold text-sm">{{ strtoupper(substr($f->user->name, 0, 2)) }}</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $f->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $f->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $f->position }}</div>
                            <div class="text-xs text-gray-500">{{ $notes['division'] ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2 text-sm">
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">♂ {{ $notes['qty_male'] ?? 0 }}</span>
                                <span class="px-2 py-1 bg-pink-100 text-pink-800 rounded-full text-xs font-medium">♀ {{ $notes['qty_female'] ?? 0 }}</span>
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
                            @else
                                <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                                    Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div>{{ $f->created_at->format('d M Y') }}</div>
                            <div class="text-xs text-gray-400">{{ $f->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.fptk.show', $f->id) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-sm hover:shadow-md transition transform hover:scale-105">
                                <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
                                Detail
                            </a>
                        </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
