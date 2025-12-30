@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-semibold mb-4">Permintaan #{{ $request->id }}</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="p-4 border rounded">
            <p><strong>Email:</strong> {{ $request->email }}</p>
            <p><strong>Status:</strong> {{ ucfirst($request->status) }}</p>
            <p><strong>Dibuat:</strong> {{ $request->created_at }}</p>
            <p><strong>IP:</strong> {{ $request->ip_address }}</p>
            <p><strong>User agent:</strong> <small>{{ $request->user_agent }}</small></p>
        </div>
        <div class="p-4 border rounded">
            <p><strong>Alasan:</strong></p>
            <p class="text-sm text-gray-700">{{ $request->reason }}</p>
        </div>
    </div>

    @if($request->status === 'pending')
    <div class="flex gap-3">
        <form method="POST" action="{{ route('admin.password_requests.approve', $request) }}">
            @csrf
            <button class="px-4 py-2 bg-green-600 text-white rounded">Approve & Kirim Password</button>
        </form>
        <form method="POST" action="{{ route('admin.password_requests.reject', $request) }}">
            @csrf
            <input type="hidden" name="admin_note" value="Ditolak oleh admin">
            <button class="px-4 py-2 bg-red-600 text-white rounded">Reject</button>
        </form>
    </div>
    @else
        <div class="p-3 bg-gray-50">Permintaan sudah diproses pada {{ $request->processed_at }}</div>
    @endif

    <div class="mt-6">
        <a href="{{ route('admin.password_requests.index') }}" class="text-sm text-gray-600">Kembali</a>
    </div>
</div>
@endsection
