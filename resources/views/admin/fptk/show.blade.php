<?php /* Blade view */ ?>
@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Detail FPTK #{{ $fptk->id }}</h1>

    <div class="bg-white p-4 rounded shadow">
        @php
            $notes = is_array($fptk->notes) ? $fptk->notes : (is_string($fptk->notes) ? json_decode($fptk->notes, true) : []);
            $notes = $notes ?: [];
        @endphp
        <p><strong>Pengaju:</strong> {{ $fptk->user->name }} ({{ $fptk->user->email }})</p>
        <p><strong>Posisi:</strong> {{ $fptk->position }}</p>
        <p><strong>Lokasi:</strong> {{ $fptk->locations }}</p>
        <p><strong>Jumlah (Pria/Wanita):</strong> {{ $notes['qty_male'] ?? 0 }} / {{ $notes['qty_female'] ?? 0 }} (Total: {{ $fptk->qty }})</p>
        <p><strong>Divisi:</strong> {{ $notes['division'] ?? '-' }}</p>
        <p><strong>Dasar Permintaan:</strong>
            @php 
                $das = $notes['dasar_permintaan'] ?? null;
                $dasList = is_array($das) ? $das : [];
            @endphp
            @if(count($dasList))
                <ul class="ml-4 list-disc">
                @foreach($dasList as $d)
                    <li>{{ $d }}</li>
                @endforeach
                </ul>
            @else
                -
            @endif
        </p>
        <p><strong>Tanggal Kebutuhan:</strong> {{ $notes['date_needed'] ?? '-' }}</p>
        <p><strong>Golongan / Gaji:</strong> {{ $notes['golongan_gaji'] ?? '-' }} / {{ isset($notes['gaji']) ? 'Rp ' . number_format($notes['gaji'],0,',','.') : '-' }}</p>
        <p><strong>Penempatan:</strong> {{ $notes['penempatan'] ?? '-' }}</p>
        <p><strong>Pendidikan:</strong> {{ $notes['pendidikan'] ?? '-' }}</p>
        <p><strong>Pengalaman:</strong> {{ $notes['pengalaman'] ?? '-' }}</p>
        <p><strong>Kualifikasi / Keterampilan:</strong>
            @php 
                $k = $notes['keterampilan'] ?? null;
                $kList = $k ? array_filter(array_map('trim', explode(',', $k))) : [];
            @endphp
            @if(count($kList))
                <ul class="ml-4 list-disc">
                @foreach($kList as $item)
                    <li>{{ $item }}</li>
                @endforeach
                </ul>
            @else
                -
            @endif
        </p>
        <p><strong>Uraian Tugas:</strong><br>{!! nl2br(e($notes['uraian'] ?? '')) !!}</p>
        @if(!empty($notes['notes_text']))
            <p><strong>Catatan Pengaju:</strong><br>{{ $notes['notes_text'] }}</p>
        @endif
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
