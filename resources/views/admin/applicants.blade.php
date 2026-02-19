@extends('layouts.admin')

@section('title', 'Data Pelamar')

@section('content')
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Data Pelamar</h1>
            <p class="text-sm text-slate-500">Kelola dan review lamaran kerja kandidat</p>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="mb-8 bg-white p-6 rounded-xl shadow-sm border border-slate-200">
        <form action="{{ route('admin.applicants.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-4">
            <div class="lg:col-span-1">
                <label for="search" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Cari Kandidat</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                        <i class="fas fa-search text-xs"></i>
                    </span>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Nama / Posisi..." class="pl-9 w-full rounded-lg border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                </div>
            </div>
            <div>
                <label for="job_id" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Lowongan</label>
                <select name="job_id" id="job_id" class="w-full rounded-lg border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                    <option value="">Semua Lowongan</option>
                    @foreach($jobs as $job)
                        <option value="{{ $job->id }}" {{ request('job_id') == $job->id ? 'selected' : '' }}>
                            {{ $job->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="status" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Status</label>
                <select name="status" id="status" class="w-full rounded-lg border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                    <option value="">Semua Status</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end space-x-2 lg:col-span-2">
                <button type="submit" class="flex-1 lg:flex-none px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                    Filter
                </button>
                <a href="{{ route('admin.applicants.index') }}" class="flex-1 lg:flex-none px-6 py-2 bg-slate-100 text-slate-600 text-sm font-medium rounded-lg hover:bg-slate-200 text-center transition-colors">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Tabel Data Pelamar -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs uppercase tracking-wider text-slate-500 font-semibold">
                        <th class="px-6 py-4">Kandidat</th>
                        <th class="px-6 py-4">Lowongan Dilamar</th>
                        <th class="px-6 py-4">Status & Update</th>
                        <th class="px-6 py-4">Tanggal Masuk</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($applications as $app)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 font-bold border border-slate-200 mr-3">
                                        {{ substr($app->user->name ?? $app->applicant_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-800">{{ $app->user->name ?? $app->applicant_name }}</div>
                                        <div class="text-xs text-slate-500">{{ $app->user->email ?? $app->applicant_email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-slate-700 font-medium">{{ $app->job->title }}</div>
                                <div class="text-[10px] text-slate-400 mt-0.5 uppercase tracking-tighter">{{ $app->job->type }} • {{ $app->created_at->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('admin.applicants.updateStatus', $app) }}" method="POST" class="flex flex-col gap-1.5">
                                    @csrf
                                    @method('PATCH')
                                    <div class="flex items-center">
                                        @php
                                            $statusColors = [
                                                'Baru' => 'bg-blue-100 text-blue-700 border-blue-200',
                                                'Diterima' => 'bg-green-100 text-green-700 border-green-200',
                                                'Ditolak' => 'bg-red-100 text-red-700 border-red-200',
                                                'Shortlist' => 'bg-purple-100 text-purple-700 border-purple-200',
                                                'Offering' => 'bg-amber-100 text-amber-700 border-amber-200',
                                            ];
                                            $badgeClass = $statusColors[$app->status] ?? 'bg-slate-100 text-slate-700 border-slate-200';
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $badgeClass }}">
                                            {{ strtoupper($app->status) }}
                                        </span>
                                    </div>
                                    <select name="status" class="w-full max-w-[150px] border-slate-200 rounded-lg py-1 px-2 text-[11px] focus:ring-blue-500 focus:border-blue-500 shadow-sm" onchange="this.form.submit()">
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status }}" {{ $app->status == $status ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-slate-600">
                                    @if($app->status == 'Diterima')
                                        {{ $app->join_date ? \Carbon\Carbon::parse($app->join_date)->format('d M Y') : '-' }}
                                    @else
                                        <span class="text-slate-300 text-xs italic">Belum ditentukan</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center space-x-2">
                                    <form action="{{ route('admin.applicants.addToTalentPool', $app) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="p-2 text-slate-400 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-colors" title="Masukkan ke Talent Pool">
                                            <i class="fas fa-star"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.applicants.show', $app) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat Detail">
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-user-slash text-4xl text-slate-200 mb-3"></i>
                                    <p class="text-base font-medium">Tidak ada pelamar ditemukan</p>
                                    <p class="text-sm mt-1">Coba sesuaikan filter atau pencarian Anda.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-6 text-center">
        {{ $applications->appends(request()->query())->links() }}
    </div>
@endsection
