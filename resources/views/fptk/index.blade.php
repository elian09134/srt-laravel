@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Form Permintaan Tenaga Kerja</h1>
        <p class="text-gray-600">Silakan lengkapi form di bawah untuk mengajukan permintaan tenaga kerja baru</p>
    </div>

    @if(session('status'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <span class="font-medium">{{ session('status') }}</span>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r">
            <div class="flex items-start">
                <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                <div>
                    <strong class="font-medium">Ada masalah saat menyimpan:</strong>
                    <ul class="mt-2 list-disc ml-5 text-sm">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('fptk.store') }}" class="space-y-6 bg-white rounded-lg shadow-md overflow-hidden">
        @csrf
        
        <!-- Section: Informasi Dasar -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/></svg>
                Informasi Dasar
            </h2>
        </div>
        
        <div class="p-6 space-y-5">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Divisi <span class="text-red-500">*</span></label>
                    <input name="division" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="Contoh: IT, Marketing, Finance">
                </div>

                <div class="col-span-12 md:col-span-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Posisi yang Dibutuhkan <span class="text-red-500">*</span></label>
                    <input name="position" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="Contoh: Software Engineer, Marketing Manager">
                </div>
                
                <div class="col-span-12 md:col-span-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi Penempatan</label>
                    <input name="locations" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="Contoh: Jakarta, Surabaya">
                </div>
            </div>
        </div>

        <!-- Section: Dasar Permintaan -->
        <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-6 border-y border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                <svg class="w-5 h-5 mr-2 text-purple-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
                Dasar Permintaan
            </h2>
        </div>
        
        <div class="p-6 space-y-4">
            <div class="space-y-3">
                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition">
                    <input type="checkbox" name="dasar_permintaan[]" value="Penggantian (mengundurkan diri/mutasi)" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                    <span class="ml-3 text-sm text-gray-700">Penggantian karyawan yang <strong>(MENGUNDURKAN DIRI/MUTASI/KONTRAK HABIS)</strong></span>
                </label>
                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition">
                    <input type="checkbox" name="dasar_permintaan[]" value="Penggantian SEMENTARA" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                    <span class="ml-3 text-sm text-gray-700">Penggantian <strong>SEMENTARA</strong> (cuti/tugas belajar, dll)</span>
                </label>
                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition">
                    <input type="checkbox" name="dasar_permintaan[]" value="Pengembangan perusahaan" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                    <span class="ml-3 text-sm text-gray-700">Pengembangan perusahaan - Restrukturisasi organisasi</span>
                </label>
                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition">
                    <input type="checkbox" name="dasar_permintaan[]" value="Lain-lain" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                    <span class="ml-3 text-sm text-gray-700">Lain-lain</span>
                </label>
            </div>
        </div>

        <!-- Section: Kebutuhan -->
        <div class="bg-gradient-to-r from-green-50 to-teal-50 p-6 border-y border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/></svg>
                Kebutuhan Tenaga Kerja
            </h2>
        </div>
        
        <div class="p-6 space-y-5">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-6 md:col-span-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Pria</label>
                    <input name="qty" type="number" min="0" value="0" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>
                <div class="col-span-6 md:col-span-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Wanita</label>
                    <input name="qty_female" type="number" min="0" value="0" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>
                <div class="col-span-12 md:col-span-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kebutuhan</label>
                    <input name="date_needed" type="date" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>

                <div class="col-span-12 md:col-span-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Karyawan</label>
                    <input name="status_type" placeholder="Contoh: Masa Percobaan / Kontrak" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>
                <div class="col-span-12 md:col-span-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Golongan & Range Gaji</label>
                    <input name="golongan_gaji" placeholder="Contoh: III/A - Rp 5.000.000" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>

                <div class="col-span-12 md:col-span-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Penempatan</label>
                    <input name="penempatan" placeholder="Contoh: Kantor Pusat" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>
                <div class="col-span-12 md:col-span-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upah (Rp)</label>
                    <input name="gaji" type="number" placeholder="5000000" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>
            </div>
        </div>

        <!-- Section: Spesifikasi Jabatan -->
        <div class="bg-gradient-to-r from-orange-50 to-yellow-50 p-6 border-y border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                <svg class="w-5 h-5 mr-2 text-orange-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"/><path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"/></svg>
                Spesifikasi Jabatan
            </h2>
        </div>
        
        <div class="p-6 space-y-5">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 md:col-span-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Usia</label>
                    <input name="usia" placeholder="Contoh: 25-35 tahun" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>
                <div class="col-span-12 md:col-span-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pendidikan Minimal</label>
                    <input name="pendidikan" placeholder="Contoh: S1 Teknik Informatika" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>
                <div class="col-span-12 md:col-span-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pengalaman Kerja Minimal</label>
                    <input name="pengalaman" placeholder="Contoh: 2 tahun" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>

                <div class="col-span-12">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kualifikasi / Keterampilan Khusus</label>
                    <input name="keterampilan" placeholder="Contoh: Excel, Analisis Data, Presentasi" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    <p class="mt-1.5 text-xs text-gray-500 flex items-start">
                        <svg class="w-4 h-4 mr-1 mt-0.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                        Masukkan tiap kualifikasi dipisahkan dengan koma
                    </p>
                </div>

                <div class="col-span-12">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Uraian Tugas dan Tanggung Jawab Utama</label>
                    <textarea name="uraian" rows="5" placeholder="Jelaskan tugas dan tanggung jawab utama untuk posisi ini..." class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"></textarea>
                </div>

                <div class="col-span-12">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Tambahan (Opsional)</label>
                    <textarea name="notes" rows="3" placeholder="Catatan atau informasi tambahan..." class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"></textarea>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 px-6 py-4 flex justify-end border-t border-gray-200">
            <button type="button" onclick="openSignatureModal()" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform transition hover:scale-105 shadow-md">
                <span class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/></svg>
                    Kirim Permohonan FPTK
                </span>
            </button>
        </div>
    </form>
    
    <!-- Section: Riwayat Pengajuan -->
    <div class="mt-8 bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-gray-100 to-gray-200 px-6 py-4 border-b border-gray-300">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                <svg class="w-6 h-6 mr-2 text-gray-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                Riwayat Pengajuan Saya
            </h2>
        </div>
        
        @php
            $subs = \App\Models\Fptk::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
        @endphp
        
        @if($subs->isEmpty())
            <div class="p-8 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <p class="text-gray-500 text-lg">Belum ada pengajuan FPTK</p>
                <p class="text-gray-400 text-sm mt-1">Pengajuan Anda akan muncul di sini setelah Anda mengirimkan form</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posisi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kualifikasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($subs as $s)
                        @php
                            $notes = is_array($s->notes) ? $s->notes : (is_string($s->notes) ? json_decode($s->notes, true) : []);
                            $k = $notes['keterampilan'] ?? null;
                            $items = [];
                            if($k){
                                $items = array_filter(array_map('trim', explode(',', $k)));
                            }
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $s->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <div class="font-medium">{{ $s->position }}</div>
                                <div class="text-gray-500 text-xs">{{ $notes['division'] ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                @if(count($items))
                                    <div class="space-y-1">
                                        @foreach(array_slice($items,0,2) as $it)
                                            <div class="flex items-center">
                                                <svg class="w-3 h-3 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                                {{ $it }}
                                            </div>
                                        @endforeach
                                        @if(count($items) > 2)
                                            <div class="text-xs text-gray-400">+{{ count($items) - 2 }} lainnya</div>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $s->qty }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($s->status === 'pending')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                                        Pending
                                    </span>
                                @elseif($s->status === 'approved')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        Disetujui
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                                        Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $s->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function(){
        const kinput = document.querySelector('input[name="keterampilan"]');
        if(!kinput) return;

        kinput.addEventListener('paste', function(e){
            const paste = (e.clipboardData || window.clipboardData).getData('text');
            if(!paste) return;
            if(/\r|\n/.test(paste)){
                e.preventDefault();
                const normalized = paste.replace(/\s*\r?\n\s*/g, ', ').replace(/,+\s*/g, ', ');
                const start = kinput.selectionStart || 0;
                const end = kinput.selectionEnd || 0;
                kinput.value = kinput.value.slice(0,start) + normalized + kinput.value.slice(end);
            }
        });
    });
    </script>

    <!-- Signature Modal -->
    <div id="signatureModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-t-xl p-4">
                <h3 class="text-xl font-bold text-white">Tanda Tangan Digital</h3>
                <p class="text-blue-100 text-sm mt-1">Bubuhkan tanda tangan Anda untuk mengajukan FPTK</p>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" id="signerName" value="{{ Auth::user()->name }}" readonly class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-50">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanda Tangan</label>
                    <div class="border-2 border-gray-300 rounded-lg overflow-hidden">
                        <canvas id="signaturePad" width="400" height="200" class="w-full touch-none" style="cursor: crosshair;"></canvas>
                    </div>
                    <div class="flex justify-between mt-2">
                        <button type="button" onclick="clearSignature()" class="text-sm text-gray-600 hover:text-gray-800">
                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                            </svg>
                            Bersihkan
                        </button>
                        <span class="text-xs text-gray-500">Gambar tanda tangan di area kotak</span>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <button type="button" onclick="closeSignatureModal()" class="flex-1 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition">
                        Batal
                    </button>
                    <button type="button" onclick="submitWithSignature()" class="flex-1 px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg transition">
                        Kirim FPTK
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
    <script>
    let signaturePad;
    const fptkForm = document.querySelector('form[action="{{ route("fptk.store") }}"]');

    function openSignatureModal() {
        // Validate form first
        if (!fptkForm.checkValidity()) {
            fptkForm.reportValidity();
            return;
        }

        const modal = document.getElementById('signatureModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        if (!signaturePad) {
            const canvas = document.getElementById('signaturePad');
            signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)',
                penColor: 'rgb(0, 0, 0)'
            });
        }
    }

    function closeSignatureModal() {
        const modal = document.getElementById('signatureModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function clearSignature() {
        if (signaturePad) {
            signaturePad.clear();
        }
    }

    function submitWithSignature() {
        if (signaturePad.isEmpty()) {
            alert('Silakan bubuhkan tanda tangan Anda terlebih dahulu!');
            return;
        }
        
        const signatureData = signaturePad.toDataURL('image/png');
        
        // Add signature data to form
        let sigInput = document.createElement('input');
        sigInput.type = 'hidden';
        sigInput.name = 'signature';
        sigInput.value = signatureData;
        fptkForm.appendChild(sigInput);

        let nameInput = document.createElement('input');
        nameInput.type = 'hidden';
        nameInput.name = 'signer_name';
        nameInput.value = document.getElementById('signerName').value;
        fptkForm.appendChild(nameInput);
        
        // Submit form
        fptkForm.submit();
    }

    // Close modal when clicking outside
    document.getElementById('signatureModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeSignatureModal();
        }
    });
    </script>
</div>
@endsection
