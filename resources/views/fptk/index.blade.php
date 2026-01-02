@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Form Permintaan Tenaga Kerja (FPTK)</h1>

    @if(session('status'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-800">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('fptk.store') }}" class="space-y-4 bg-white p-4 rounded shadow-sm">
        @csrf
        <div>
            <label class="block text-sm font-medium">Posisi yang dibutuhkan</label>
            <input name="position" class="mt-1 block w-full border rounded p-2" required>
        </div>
        <div>
            <label class="block text-sm font-medium">Lokasi</label>
            <input name="locations" class="mt-1 block w-full border rounded p-2">
        </div>
        <div>
            <label class="block text-sm font-medium">Jumlah</label>
            <input name="qty" type="number" min="1" class="mt-1 block w-32 border rounded p-2" required>
        </div>
        <div>
            <label class="block text-sm font-medium">Catatan / Kualifikasi</label>
            <textarea name="notes" class="mt-1 block w-full border rounded p-2" rows="4"></textarea>
        </div>
        <div>
            <button class="px-4 py-2 bg-blue-600 text-white rounded">Kirim FPTK</button>
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
                        <tr class="text-left"><th class="p-2">ID</th><th class="p-2">Posisi</th><th class="p-2">Jumlah</th><th class="p-2">Status</th><th class="p-2">Tanggal</th></tr>
                    </thead>
                    <tbody>
                        @foreach($subs as $s)
                        <tr class="border-t">
                            <td class="p-2">{{ $s->id }}</td>
                            <td class="p-2">{{ $s->position }}</td>
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
