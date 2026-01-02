@extends('layouts.app')

@section('title', 'Detail FPTK #' . $fptk->id)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @php
            $notes = is_array($fptk->notes) ? $fptk->notes : (is_string($fptk->notes) ? json_decode($fptk->notes, true) : []);
            $notes = $notes ?: [];
        @endphp

        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-3 mb-2">
                <a href="{{ route('fptk.my') }}" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                    Detail FPTK #{{ $fptk->id }}
                </h1>
            </div>
            <p class="text-gray-600 ml-9">{{ $fptk->position }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informasi Dasar -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white">Informasi Dasar</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-semibold text-gray-600">Posisi</label>
                                <p class="text-gray-800 font-medium">{{ $fptk->position }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-semibold text-gray-600">Lokasi Penempatan</label>
                                <p class="text-gray-800 font-medium">{{ $fptk->locations ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-semibold text-gray-600">Jumlah Kebutuhan</label>
                                <p class="text-gray-800 font-medium">{{ $fptk->qty }} orang</p>
                            </div>
                            <div>
                                <label class="text-sm font-semibold text-gray-600">Divisi</label>
                                <p class="text-gray-800 font-medium">{{ $notes['division'] ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-semibold text-gray-600">Tanggal Dibutuhkan</label>
                                <p class="text-gray-800 font-medium">{{ isset($notes['date_needed']) ? date('d M Y', strtotime($notes['date_needed'])) : '-' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-semibold text-gray-600">Status Karyawan</label>
                                <p class="text-gray-800 font-medium">{{ $notes['status_type'] ?? '-' }}</p>
                            </div>
                        </div>

                        @if(isset($notes['dasar_permintaan']) && is_array($notes['dasar_permintaan']) && count($notes['dasar_permintaan']) > 0)
                            <div class="pt-4 border-t">
                                <label class="text-sm font-semibold text-gray-600 mb-2 block">Dasar Permintaan</label>
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach($notes['dasar_permintaan'] as $dasar)
                                        <li class="text-gray-700">{{ $dasar }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Kualifikasi -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white">Kualifikasi & Persyaratan</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-semibold text-gray-600">Usia</label>
                                <p class="text-gray-800">{{ $notes['usia'] ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-semibold text-gray-600">Pendidikan</label>
                                <p class="text-gray-800">{{ $notes['pendidikan'] ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-semibold text-gray-600">Golongan Gaji</label>
                                <p class="text-gray-800">{{ $notes['golongan_gaji'] ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-semibold text-gray-600">Gaji</label>
                                <p class="text-gray-800">{{ isset($notes['gaji']) ? 'Rp ' . number_format($notes['gaji'], 0, ',', '.') : '-' }}</p>
                            </div>
                        </div>

                        @if(isset($notes['keterampilan']))
                            <div class="pt-4 border-t">
                                <label class="text-sm font-semibold text-gray-600 mb-2 block">Keterampilan</label>
                                <p class="text-gray-700 whitespace-pre-line">{{ $notes['keterampilan'] }}</p>
                            </div>
                        @endif

                        @if(isset($notes['pengalaman']))
                            <div class="pt-4 border-t">
                                <label class="text-sm font-semibold text-gray-600 mb-2 block">Pengalaman</label>
                                <p class="text-gray-700 whitespace-pre-line">{{ $notes['pengalaman'] }}</p>
                            </div>
                        @endif

                        @if(isset($notes['uraian']))
                            <div class="pt-4 border-t">
                                <label class="text-sm font-semibold text-gray-600 mb-2 block">Uraian Pekerjaan</label>
                                <p class="text-gray-700 whitespace-pre-line">{{ $notes['uraian'] }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Catatan Tambahan -->
                @if(isset($notes['notes_text']) && $notes['notes_text'])
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
                            <h2 class="text-xl font-bold text-white">Catatan Tambahan</h2>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-700 whitespace-pre-line">{{ $notes['notes_text'] }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Status -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Status</h3>
                    @if($fptk->status === 'pending')
                        <div class="flex items-center space-x-2 text-yellow-600 mb-4">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-semibold">Menunggu Review</span>
                        </div>
                    @elseif($fptk->status === 'approved')
                        <div class="flex items-center space-x-2 text-green-600 mb-4">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-semibold">Disetujui</span>
                        </div>
                    @else
                        <div class="flex items-center space-x-2 text-red-600 mb-4">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-semibold">Ditolak</span>
                        </div>
                    @endif

                    <div class="text-sm text-gray-600 space-y-2">
                        <p><span class="font-semibold">Diajukan:</span> {{ $fptk->created_at->format('d M Y H:i') }}</p>
                        @if($fptk->updated_at != $fptk->created_at)
                            <p><span class="font-semibold">Diperbarui:</span> {{ $fptk->updated_at->format('d M Y H:i') }}</p>
                        @endif
                    </div>
                </div>

                <!-- Admin Note -->
                @if($fptk->admin_note)
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-3">Catatan Admin</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-700">{{ $fptk->admin_note }}</p>
                        </div>
                        @if($fptk->admin)
                            <p class="text-xs text-gray-500 mt-2">oleh {{ $fptk->admin->name }}</p>
                        @endif
                    </div>
                @endif

                <!-- Job Posting Info -->
                @if($fptk->status === 'approved' && $fptk->job)
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl shadow-lg p-6 border border-blue-200">
                        <h3 class="text-lg font-bold text-gray-800 mb-3">Job Posting Terkait</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $fptk->job->title }}</p>
                                <p class="text-sm text-gray-600">{{ $fptk->job->location }}</p>
                            </div>
                            <div class="flex items-center justify-between pt-3 border-t border-blue-200">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-1 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                    </svg>
                                    <span class="text-lg font-bold text-blue-700">{{ $fptk->job->applications->count() }}</span>
                                    <span class="text-xs text-gray-600 ml-1">pelamar</span>
                                </div>
                                <a href="{{ route('karir.show', $fptk->job->id) }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 underline flex items-center">
                                    Lihat Job
                                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @elseif($fptk->status === 'approved')
                    <div class="bg-yellow-50 rounded-xl shadow-lg p-6 border border-yellow-200">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-yellow-800 mb-1">Job Posting Sedang Diproses</p>
                                <p class="text-xs text-yellow-700">Admin sedang memproses job posting untuk FPTK ini</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <a href="{{ route('fptk.my') }}" class="block w-full text-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition">
                        Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
