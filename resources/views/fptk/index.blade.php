@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Form Permintaan Tenaga Kerja (FPTK)</h1>

    @if(session('status'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-800">{{ session('status') }}</div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-800">
            <strong>Ada masalah saat menyimpan:</strong>
            <ul class="mt-2 list-disc ml-5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('fptk.store') }}" class="space-y-4 bg-white p-4 rounded shadow-sm">
        @csrf
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12">
                    <label class="block text-sm font-medium">Divisi</label>
                    <input name="division" class="mt-1 block w-full border rounded p-2">
                </div>

                <div class="col-span-12">
                    <label class="block text-sm font-medium">Dasar Permintaan</label>
                    <div class="mt-1 space-y-1">
                        <label class="inline-flex items-center"><input type="checkbox" name="dasar_permintaan[]" value="Penggantian (mengundurkan diri/mutasi)" class="mr-2"> Penggantian karyawan yang (MENGUNDURKAN DIRI/MUTASI/KERJA)</label>
                        <label class="inline-flex items-center"><input type="checkbox" name="dasar_permintaan[]" value="Penggantian SEMENTARA" class="mr-2"> Penggantian SEMENTARA (cuti/tugas belajar, dll)</label>
                        <label class="inline-flex items-center"><input type="checkbox" name="dasar_permintaan[]" value="Pengembangan perusahaan" class="mr-2"> Pengembangan perusahaan - Restrukturisasi organisasi</label>
                        <label class="inline-flex items-center"><input type="checkbox" name="dasar_permintaan[]" value="Lain-lain" class="mr-2"> Lain-lain</label>
                    </div>
                </div>

                <div class="col-span-6">
                    <label class="block text-sm font-medium">Posisi yang dibutuhkan</label>
                    <input name="position" class="mt-1 block w-full border rounded p-2" required>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium">Jumlah (Pria)</label>
                    <input name="qty" type="number" min="0" class="mt-1 block w-full border rounded p-2" value="0" required>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium">Jumlah (Wanita)</label>
                    <input name="qty_female" type="number" min="0" class="mt-1 block w-full border rounded p-2" value="0">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium">Tanggal Kebutuhan</label>
                    <input name="date_needed" type="date" class="mt-1 block w-full border rounded p-2">
                </div>

                <div class="col-span-6">
                    <label class="block text-sm font-medium">Status (Masa Percobaan / Kontrak)</label>
                    <input name="status_type" class="mt-1 block w-full border rounded p-2">
                </div>
                <div class="col-span-6">
                    <label class="block text-sm font-medium">Golongan &amp; Range Gaji</label>
                    <input name="golongan_gaji" class="mt-1 block w-full border rounded p-2">
                </div>

                <div class="col-span-6">
                    <label class="block text-sm font-medium">Penempatan</label>
                    <input name="penempatan" class="mt-1 block w-full border rounded p-2">
                </div>
                <div class="col-span-6">
                    <label class="block text-sm font-medium">Upah (Rp)</label>
                    <input name="gaji" class="mt-1 block w-full border rounded p-2">
                </div>

                <div class="col-span-12">
                    <h3 class="font-semibold mt-4">Spesifikasi Jabatan</h3>
                    <div class="grid grid-cols-3 gap-4 mt-2">
                        <div>
                            <label class="block text-sm font-medium">Usia</label>
                            <input name="usia" class="mt-1 block w-full border rounded p-2">

                    <script>
                    document.addEventListener('DOMContentLoaded', function(){
                        const kinput = document.querySelector('input[name="keterampilan"]');
                        if(!kinput) return;

                        kinput.addEventListener('paste', function(e){
                            const paste = (e.clipboardData || window.clipboardData).getData('text');
                            if(!paste) return;
                            // If paste contains newlines, convert them to comma-separated values
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
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Pendidikan Minimal</label>
                            <input name="pendidikan" class="mt-1 block w-full border rounded p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Kualifikasi / Keterampilan Khusus</label>
                            <input name="keterampilan" placeholder="Contoh: Excel, Analisis Data, Presentasi" class="mt-1 block w-full border rounded p-2">
                            <p class="mt-1 text-xs text-gray-500">Masukkan tiap kualifikasi sebagai poin, pisahkan dengan koma. Contoh: Excel, Analisis Data, Presentasi</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-3">
                        <div>
                            <label class="block text-sm font-medium">Pengalaman Kerja Minimal</label>
                            <input name="pengalaman" class="mt-1 block w-full border rounded p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Keterangan Lain</label>
                            <input name="notes" class="mt-1 block w-full border rounded p-2">
                        </div>
                    </div>
                </div>

                <div class="col-span-12">
                    <label class="block text-sm font-medium">Uraian Tugas dan Tanggung Jawab Utama</label>
                    <textarea name="uraian" rows="6" class="mt-1 block w-full border rounded p-2"></textarea>
                </div>

                <div class="col-span-12">
                    <button class="px-4 py-2 bg-blue-600 text-white rounded">Kirim FPTK</button>
                </div>
            </div>
    </form>
    
    <div class="mt-6">
        <h2 class="text-lg font-semibold mb-2">Riwayat Pengajuan Saya</h2>
        @php
            $subs = \App\Models\Fptk::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
        @endphp
        @if($subs->isEmpty())
            <div class="p-3 bg-gray-50 border">Belum ada pengajuan.</div>
        @else
            <div class="bg-white rounded shadow">
                <table class="w-full">
                    <thead>
                        <tr class="text-left"><th class="p-2">ID</th><th class="p-2">Posisi</th><th class="p-2">Kualifikasi</th><th class="p-2">Jumlah</th><th class="p-2">Status</th><th class="p-2">Tanggal</th></tr>
                    </thead>
                    <tbody>
                        @foreach($subs as $s)
                        @php
                            $k = null;
                            if(is_array($s->notes_decoded ?? null) && isset($s->notes_decoded['keterampilan'])){
                                $k = $s->notes_decoded['keterampilan'];
                            } elseif(!empty($s->keterampilan)){
                                $k = $s->keterampilan;
                            }
                            $items = [];
                            if($k){
                                $items = array_filter(array_map('trim', explode(',', $k)));
                            }
                        @endphp
                        <tr class="border-t">
                            <td class="p-2">{{ $s->id }}</td>
                            <td class="p-2">{{ $s->position }}</td>
                            <td class="p-2">
                                @if(count($items))
                                    @foreach($items as $it)
                                        <div class="text-sm">- {{ $it }}</div>
                                    @endforeach
                                @else
                                    <div class="text-sm text-gray-500">-</div>
                                @endif
                            </td>
                            <td class="p-2">{{ $s->qty }}</td>
                            <td class="p-2">{{ ucfirst($s->status) }}</td>
                            <td class="p-2">{{ $s->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
