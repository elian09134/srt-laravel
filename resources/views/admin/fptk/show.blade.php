<?php /* Blade view */ ?>
@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Detail FPTK #{{ $fptk->id }}</h1>

    <div class="bg-white p-4 rounded shadow">
        <p><strong>Pengaju:</strong> {{ $fptk->user->name }} ({{ $fptk->user->email }})</p>
        <p><strong>Posisi:</strong> {{ $fptk->position }}</p>
        <p><strong>Lokasi:</strong> {{ $fptk->locations }}</p>
        <p><strong>Jumlah:</strong> {{ $fptk->qty }}</p>
        <p><strong>Catatan:</strong><br>{{ $fptk->notes }}</p>
        <p class="mt-2"><strong>Status:</strong> {{ ucfirst($fptk->status) }}</p>
        @if($fptk->admin_note)
            <p><strong>Catatan Admin:</strong><br>{{ $fptk->admin_note }}</p>
        @endif

        <div class="mt-4">
            @if($fptk->status === 'pending')
            <form method="POST" action="{{ route('admin.fptk.approve', $fptk->id) }}" class="inline-block mr-2">
                @csrf
                <textarea name="admin_note" placeholder="Catatan (opsional)" class="block w-96 mb-2 border p-2"></textarea>
                <button class="px-4 py-2 bg-green-600 text-white rounded">Approve</button>
            </form>
            <form method="POST" action="{{ route('admin.fptk.reject', $fptk->id) }}" class="inline-block">
                @csrf
                <input type="hidden" name="admin_note" value="Ditolak oleh admin" />
                <button class="px-4 py-2 bg-red-600 text-white rounded">Reject</button>
            </form>
            @endif
            <a href="{{ route('admin.fptk.index') }}" class="ml-4 text-sm text-gray-600">Kembali</a>
        </div>
    </div>
</div>
@endsection
