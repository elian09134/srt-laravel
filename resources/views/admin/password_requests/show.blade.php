@extends('layouts.admin')

@section('title', 'Detail Permintaan Reset Password')

@section('content')
    <div class="max-w-3xl">
        <div class="mb-6">
            <a href="{{ route('admin.password_requests.index') }}" class="text-slate-400 hover:text-indigo-600 text-sm inline-flex items-center transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
            </a>
            <h1 class="text-xl font-semibold text-slate-800 mt-1">Detail Permintaan #{{ $request->id }}</h1>
        </div>

        @if(session('status'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-center gap-3" role="alert">
                <i class="fas fa-check-circle text-emerald-500"></i>
                <span class="text-sm font-medium text-emerald-800">{{ session('status') }}</span>
            </div>
        @endif
        @if(session('warning'))
            <div class="mb-6 bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-center gap-3" role="alert">
                <i class="fas fa-exclamation-triangle text-amber-500"></i>
                <span class="text-sm font-medium text-amber-800">{{ session('warning') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-xl border border-slate-100 p-5 space-y-3 mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                <div><span class="text-slate-400">Email:</span> <span class="text-slate-700 ml-2">{{ $request->email ?? '-' }}</span></div>
                <div><span class="text-slate-400">Phone:</span> <span class="text-slate-700 ml-2">{{ $request->phone ?? $request->user?->profile?->phone_number ?? '-' }}</span></div>
                <div><span class="text-slate-400">User ID:</span> <span class="text-slate-700 ml-2">{{ $request->user_id ?? '-' }}</span></div>
                <div><span class="text-slate-400">Status:</span>
                    @php
                        $statusClass = match($request->status) {
                            'pending' => 'bg-amber-50 text-amber-600',
                            'approved' => 'bg-emerald-50 text-emerald-600',
                            'rejected' => 'bg-red-50 text-red-600',
                            default => 'bg-slate-50 text-slate-600',
                        };
                    @endphp
                    <span class="inline-flex px-2 py-0.5 rounded-full text-[11px] font-medium {{ $statusClass }} ml-2">{{ ucfirst($request->status) }}</span>
                </div>
                <div class="sm:col-span-2"><span class="text-slate-400">IP:</span> <span class="text-slate-700 ml-2">{{ $request->ip_address }}</span></div>
                <div class="sm:col-span-2"><span class="text-slate-400">User Agent:</span> <span class="text-slate-500 ml-2 text-xs">{{ $request->user_agent }}</span></div>
                <div class="sm:col-span-2"><span class="text-slate-400">Alasan:</span> <span class="text-slate-700 ml-2">{{ $request->reason ?? '-' }}</span></div>
            </div>
        </div>

        @if($request->status === 'pending')
            <div class="bg-white rounded-xl border border-slate-100 p-5 space-y-6 mb-6">
                <form method="POST" action="{{ route('admin.password_requests.approve', $request) }}">
                    @csrf
                    <label class="block text-sm font-medium text-slate-600 mb-1">Catatan admin (opsional)</label>
                    <textarea name="admin_note" class="w-full border border-slate-200 rounded-lg p-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500" rows="2"></textarea>
                    <button class="mt-3 inline-flex items-center px-4 py-2 bg-emerald-500 text-white text-sm font-medium rounded-lg hover:bg-emerald-600 transition-colors">
                        <i class="fas fa-check mr-1.5"></i> Approve & Kirim Password
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.password_requests.reject', $request) }}">
                    @csrf
                    <label class="block text-sm font-medium text-slate-600 mb-1">Alasan penolakan (opsional)</label>
                    <textarea name="admin_note" class="w-full border border-slate-200 rounded-lg p-2.5 text-sm focus:ring-red-500 focus:border-red-500" rows="2"></textarea>
                    <button class="mt-3 inline-flex items-center px-4 py-2 bg-red-500 text-white text-sm font-medium rounded-lg hover:bg-red-600 transition-colors">
                        <i class="fas fa-times mr-1.5"></i> Tolak Permintaan
                    </button>
                </form>
            </div>
        @else
            <div class="bg-white rounded-xl border border-slate-100 p-5 space-y-3 mb-6">
                <div class="text-sm"><span class="text-slate-400">Diproses oleh admin:</span> <span class="text-slate-700 ml-2">{{ $request->admin?->name ?? $request->admin_id }}</span></div>
                <div class="text-sm"><span class="text-slate-400">Catatan admin:</span> <span class="text-slate-700 ml-2">{{ $request->admin_note ?? '-' }}</span></div>
                <div class="text-sm"><span class="text-slate-400">Temporary password:</span> <span class="text-slate-700 ml-2 font-mono">{{ $request->temporary_password ?? '-' }}</span></div>
                @if($request->temporary_password)
                    <div class="flex items-start gap-3 pt-3 border-t border-slate-50">
                        <form method="POST" action="{{ route('admin.password_requests.resend', $request) }}">
                            @csrf
                            <button class="inline-flex items-center px-3 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                                <i class="fas fa-envelope mr-1.5"></i> Kirim Ulang ke Email
                            </button>
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
                            <a href="{{ $waLink }}" target="_blank" class="inline-flex items-center px-3 py-2 bg-emerald-500 text-white text-sm font-medium rounded-lg hover:bg-emerald-600 transition-colors">
                                <i class="fab fa-whatsapp mr-1.5"></i> Kirim via WhatsApp
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        @endif
    </div>
@endsection
