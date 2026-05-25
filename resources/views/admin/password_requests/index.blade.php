@extends('layouts.admin')

@section('title', 'Permintaan Reset Password')

@section('content')
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-slate-800">Permintaan Reset Password</h1>
        <p class="text-sm text-slate-500 mt-1">Kelola permintaan reset password dari pengguna</p>
    </div>

    @if(session('status'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-center gap-3" role="alert">
            <i class="fas fa-check-circle text-emerald-500"></i>
            <span class="text-sm font-medium text-emerald-800">{{ session('status') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-xl border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 text-xs text-slate-400 font-medium">
                        <th class="px-5 py-3.5">ID</th>
                        <th class="px-5 py-3.5">Email</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5">Dibuat</th>
                        <th class="px-5 py-3.5">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($requests as $r)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-5 py-4 text-sm text-slate-500">{{ $r->id }}</td>
                            <td class="px-5 py-4 text-sm text-slate-700">{{ $r->email }}</td>
                            <td class="px-5 py-4">
                                @php
                                    $statusClass = match($r->status) {
                                        'pending' => 'bg-amber-50 text-amber-600 border-amber-200',
                                        'approved' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                        'rejected' => 'bg-red-50 text-red-600 border-red-200',
                                        default => 'bg-slate-50 text-slate-600 border-slate-200',
                                    };
                                @endphp
                                <span class="inline-flex px-2 py-0.5 rounded-full text-[11px] font-medium border {{ $statusClass }}">
                                    {{ ucfirst($r->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-sm text-slate-500">{{ $r->created_at->format('d M Y H:i') }}</td>
                            <td class="px-5 py-4">
                                <a href="{{ route('admin.password_requests.show', $r) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-indigo-600 hover:bg-indigo-50 rounded-md transition-colors">
                                    Detail <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-slate-400">
                                <i class="fas fa-key text-3xl text-slate-200 mb-3"></i>
                                <p class="text-sm font-medium text-slate-500">Tidak ada permintaan reset password</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($requests, 'links'))
            <div class="px-5 py-3 border-t border-slate-100 bg-slate-50/50">
                {{ $requests->links() }}
            </div>
        @endif
    </div>
@endsection
