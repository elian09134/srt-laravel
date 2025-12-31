@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-3xl">
    <h1 class="text-2xl font-semibold mb-4">Detail Permintaan #{{ $request->id }}</h1>

    @if(session('status'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-800">{{ session('status') }}</div>
    @endif
    @if(session('warning'))
        <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 text-yellow-800">{{ session('warning') }}</div>
    @endif

    <div class="bg-white p-4 rounded-lg shadow-sm mb-4">
        <p><strong>Email:</strong> {{ $request->email ?? '-' }}</p>
        <p><strong>Phone:</strong> {{ $request->phone ?? $request->user?->profile?->phone_number ?? '-' }}</p>
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
        @if($request->temporary_password)
            <div class="flex items-start gap-3 mt-3">
                <form method="POST" action="{{ route('admin.password_requests.resend', $request) }}">
                    @csrf
                    <button class="px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Kirim Ulang Password ke Email</button>
                </form>

                @php
                    $rawPhone = $request->phone ?? $request->user?->profile?->phone_number ?? null;
                    $phoneDigits = $rawPhone ? preg_replace('/[^0-9]/', '', $rawPhone) : null;
                    if ($phoneDigits && str_starts_with($phoneDigits, '0')) {
                        $waNumber = '62' . ltrim($phoneDigits, '0');
                    } else {
                        $waNumber = $phoneDigits;
                    }
                    $waMessage = $request->temporary_password ? urlencode("Password sementara Anda: {$request->temporary_password}") : '';
                    $waLink = $waNumber ? "https://wa.me/{$waNumber}?text={$waMessage}" : null;
                @endphp

                @if($waLink)
                    <a href="{{ $waLink }}" target="_blank" class="inline-flex items-center px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        <i class="fab fa-whatsapp mr-2"></i> Kirim via WhatsApp
                    </a>
                @endif
            </div>
        @endif
    </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('admin.password_requests.index') }}" class="text-sm text-gray-600 hover:underline">Kembali ke daftar</a>
    </div>
</div>
@endsection
