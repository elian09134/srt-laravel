<?php /* Blade view */ ?>
@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Manajemen FPTK</h1>

    @if(session('status'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-800">{{ session('status') }}</div>
    @endif

    <div class="bg-white shadow rounded">
                <table class="w-full table-auto">
            <thead>
                <tr class="text-left">
                    <th class="p-3">#</th>
                    <th class="p-3">Pengaju</th>
                    <th class="p-3">Posisi</th>
                    <th class="p-3">Jumlah (M/W)</th>
                    <th class="p-3">Kualifikasi</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Dibuat</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($fptks as $f)
                <tr class="border-t">
                    <td class="p-3">{{ $f->id }}</td>
                    <td class="p-3">{{ $f->user->name }} &lt;{{ $f->user->email }}&gt;</td>
                    <td class="p-3">{{ $f->position }}</td>
                    <td class="p-3">{{ ($f->qty_male ?? 0) }} / {{ ($f->qty_female ?? 0) }} ({{ $f->qty ?? (($f->qty_male ?? 0) + ($f->qty_female ?? 0)) }})</td>
                    <td class="p-3 text-sm">
                        @php $ks = $f->keterampilan_list ?? []; @endphp
                        @if(count($ks))
                            @foreach(array_slice($ks,0,3) as $it)
                                <div>- {{ $it }}</div>
                            @endforeach
                            @if(count($ks) > 3)
                                <div class="text-gray-500">+{{ count($ks) - 3 }} lainnya</div>
                            @endif
                        @else
                            <div class="text-gray-500">-</div>
                        @endif
                    </td>
                    <td class="p-3">{{ ucfirst($f->status) }}</td>
                    <td class="p-3">{{ $f->created_at->diffForHumans() }}</td>
                    <td class="p-3">
                        <a href="{{ route('admin.fptk.show', $f->id) }}" class="px-3 py-1 bg-blue-600 text-white rounded">Lihat</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
