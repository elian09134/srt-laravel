@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-3xl">
    <h1 class="text-2xl font-semibold mb-4">Detail Permintaan #{{ $request->id }}</h1>

    @if(session('status'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-800">{{ session('status') }}</div>
    @endif

    <div class="bg-white p-4 rounded-lg shadow-sm mb-4">
        <p><strong>Email:</strong> {{ $request->email }}</p>
        <p><strong>User ID:</strong> {{ $request->user_id ?? '-' }}</p>
        <p><strong>Status:</strong> {{ ucfirst($request->status) }}</p>
        <p><strong>IP:</strong> {{ $request->ip_address }}</p>
        <p><strong>User Agent:</strong> <small class="text-gray-600">{{ $request->user_agent }}</small></p>
        <p><strong>Alasan:</strong> {{ $request->reason ?? '-' }}</p>
    </div>

    @if($request->status === 'pending')
    <form method="POST" action="{{ route('admin.password_requests.approve', $request) }}" class="mb-3">
        @csrf
        <label class="block text-sm mb-2">Catatan admin (opsional)</label>
        <textarea name="admin_note" class="block w-full border rounded p-2 mb-3" rows="3"></textarea>
        <button class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Approve & Kirim Password</button>
    </form>

    <form method="POST" action="{{ route('admin.password_requests.reject', $request) }}">
        @csrf
        <label class="block text-sm mb-2">Alasan penolakan (opsional)</label>
        <textarea name="admin_note" class="block w-full border rounded p-2 mb-3" rows="3"></textarea>
        <button class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Tolak Permintaan</button>
    </form>
    @else
    <div class="p-4 bg-gray-50 rounded">
        <p><strong>Diproses oleh admin:</strong> {{ $request->admin?->name ?? $request->admin_id }}</p>
        <p><strong>Catatan admin:</strong> {{ $request->admin_note ?? '-' }}</p>
        <p><strong>Temporary password:</strong> {{ $request->temporary_password ?? '-' }}</p>
    </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('admin.password_requests.index') }}" class="text-sm text-gray-600 hover:underline">Kembali ke daftar</a>
    </div>
</div>
@endsection
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
