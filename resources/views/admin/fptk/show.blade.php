<?php /* Blade view */ ?>
@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Detail FPTK #{{ $fptk->id }}</h1>

    <div class="bg-white p-4 rounded shadow">
        <p><strong>Pengaju:</strong> {{ $fptk->user->name }} ({{ $fptk->user->email }})</p>
        <p><strong>Posisi:</strong> {{ $fptk->position }}</p>
        <p><strong>Lokasi:</strong> {{ $fptk->locations }}</p>
        <p><strong>Jumlah (Pria/Wanita):</strong> {{ $fptk->qty_male ?? 0 }} / {{ $fptk->qty_female ?? 0 }} (Total: {{ $fptk->qty ?? (($fptk->qty_male ?? 0) + ($fptk->qty_female ?? 0)) }})</p>
        <p><strong>Divisi:</strong> {{ $fptk->division }}</p>
        <p><strong>Dasar Permintaan:</strong>
            @php $das = $fptk->dasar_permintaan_list ?? []; @endphp
            @if(count($das))
                <ul class="ml-4 list-disc">
                @foreach($das as $d)
                    <li>{{ $d }}</li>
                @endforeach
                </ul>
            @else
                -
            @endif
        </p>
        <p><strong>Tanggal Kebutuhan:</strong> {{ $fptk->date_needed ? $fptk->date_needed->format('Y-m-d') : '-' }}</p>
        <p><strong>Golongan / Gaji:</strong> {{ $fptk->golongan_gaji }} / {{ $fptk->gaji ? number_format($fptk->gaji,0,',','.') : '-' }}</p>
        <p><strong>Penempatan:</strong> {{ $fptk->penempatan }}</p>
        <p><strong>Pendidikan:</strong> {{ $fptk->pendidikan }}</p>
        <p><strong>Pengalaman:</strong> {{ $fptk->pengalaman }}</p>
        <p><strong>Kualifikasi / Keterampilan:</strong>
            @php $ks = $fptk->keterampilan_list ?? []; @endphp
            @if(count($ks))
                <ul class="ml-4 list-disc">
                @foreach($ks as $k)
                    <li>{{ $k }}</li>
                @endforeach
                </ul>
            @else
                -
            @endif
        </p>
        <p><strong>Uraian Tugas:</strong><br>{!! nl2br(e($fptk->uraian ?? '')) !!}</p>
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
