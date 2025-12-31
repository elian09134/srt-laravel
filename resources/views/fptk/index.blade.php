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
</div>
@endsection
