@extends('layouts.admin')

@section('title', 'Data Pelamar')

@section('content')
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-slate-800">Data Pelamar</h1>
        <p class="text-sm text-slate-500 mt-1">Kelola dan review lamaran kerja kandidat</p>
    </div>

    <div class="mb-6 bg-white rounded-xl border border-slate-100 p-5">
        <form action="{{ route('admin.applicants.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-4">
            <div class="lg:col-span-1">
                <label for="search" class="block text-xs font-medium text-slate-500 mb-1">Cari Kandidat</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                        <i class="fas fa-search text-xs"></i>
                    </span>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Nama / Posisi..." class="pl-9 w-full rounded-lg border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>
            <div>
                <label for="job_id" class="block text-xs font-medium text-slate-500 mb-1">Lowongan</label>
                <select name="job_id" id="job_id" class="w-full rounded-lg border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Semua Lowongan</option>
                    @foreach($jobs as $job)
                        <option value="{{ $job->id }}" {{ request('job_id') == $job->id ? 'selected' : '' }}>
                            {{ $job->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="status" class="block text-xs font-medium text-slate-500 mb-1">Status</label>
                <select name="status" id="status" class="w-full rounded-lg border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Semua Status</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="referral_source" class="block text-xs font-medium text-slate-500 mb-1">Sumber Info</label>
                <select name="referral_source" id="referral_source" class="w-full rounded-lg border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Semua Sumber</option>
                    @foreach ($referralSources as $source)
                        <option value="{{ $source }}" {{ request('referral_source') == $source ? 'selected' : '' }}>
                            {{ $source }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end gap-2 lg:col-span-2">
                <button type="submit" class="flex-1 lg:flex-none px-5 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                    Filter
                </button>
                <a href="{{ route('admin.applicants.index') }}" class="flex-1 lg:flex-none px-5 py-2 bg-slate-50 text-slate-500 text-sm font-medium rounded-lg hover:bg-slate-100 transition-colors text-center">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 text-xs text-slate-400 font-medium">
                        <th class="px-5 py-3.5">Kandidat</th>
                        <th class="px-5 py-3.5">Lowongan Dilamar</th>
                        <th class="px-5 py-3.5">Status & Update</th>
                        <th class="px-5 py-3.5">Sumber Info</th>
                        <th class="px-5 py-3.5">Tanggal Masuk</th>
                        <th class="px-5 py-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($applications as $app)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-5 py-4">
                                <div class="flex items-center">
                                    <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 text-sm font-medium border border-slate-200 mr-3 shrink-0">
                                        {{ substr($app->user->name ?? $app->applicant_name, 0, 1) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-sm font-medium text-slate-800 truncate">{{ $app->user->name ?? $app->applicant_name }}</div>
                                        <div class="text-xs text-slate-400 truncate">{{ $app->user->email ?? $app->applicant_email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="text-sm text-slate-700">{{ $app->job->title }}</div>
                                <div class="text-[11px] text-slate-400 mt-0.5">{{ $app->job->type }} &middot; {{ $app->created_at->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-5 py-4">
                                <form action="{{ route('admin.applicants.updateStatus', $app) }}" method="POST" class="flex flex-col gap-1.5">
                                    @csrf
                                    @method('PATCH')
                                    @php
                                        $statusColors = [
                                            'Baru'            => 'bg-blue-50 text-blue-600 border-blue-200',
                                            'Lamaran Dilihat' => 'bg-sky-50 text-sky-600 border-sky-200',
                                            'Psikotest'       => 'bg-amber-50 text-amber-600 border-amber-200',
                                            'Wawancara HR'    => 'bg-pink-50 text-pink-600 border-pink-200',
                                            'Wawancara User'  => 'bg-indigo-50 text-indigo-600 border-indigo-200',
                                            'Offering Letter' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                            'Shortlist'       => 'bg-purple-50 text-purple-600 border-purple-200',
                                            'Diterima'        => 'bg-green-50 text-green-600 border-green-200',
                                            'Tidak Lanjut'    => 'bg-red-50 text-red-600 border-red-200',
                                        ];
                                        $badgeClass = $statusColors[$app->status] ?? 'bg-slate-50 text-slate-600 border-slate-200';
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium border {{ $badgeClass }}">
                                        {{ $app->status }}
                                    </span>
                                    <select name="status" class="w-full max-w-[150px] border-slate-200 rounded-lg py-1 px-2 text-xs focus:ring-indigo-500 focus:border-indigo-500" onchange="this.form.submit()">
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status }}" {{ $app->status == $status ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td class="px-5 py-4">
                                @php
                                    $source = optional($app->user)->referral_source;
                                    $sourceColors = [
                                        'Sosial Media' => 'bg-blue-50 text-blue-600',
                                        'M28' => 'bg-purple-50 text-purple-600',
                                    ];
                                    $sourceBadgeClass = $sourceColors[$source] ?? 'bg-slate-50 text-slate-600';
                                @endphp
                                @if($source)
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-medium {{ $sourceBadgeClass }}">
                                        {{ $source }}
                                    </span>
                                @else
                                    <span class="text-slate-300 text-xs">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="text-sm text-slate-500">
                                    @if($app->status == 'Diterima')
                                        {{ $app->join_date ? \Carbon\Carbon::parse($app->join_date)->format('d M Y') : '-' }}
                                    @else
                                        <span class="text-slate-300 text-xs">—</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-1">
                                    <form action="{{ route('admin.applicants.addToTalentPool', $app) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-purple-600 hover:bg-purple-50 rounded-md transition-colors" title="Masukkan ke Talent Pool">
                                            <i class="fas fa-star text-xs"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.applicants.show', $app) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-md transition-colors" title="Lihat Detail">
                                        <i class="fas fa-arrow-right text-xs"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-slate-400">
                                <i class="fas fa-user-slash text-3xl text-slate-200 mb-3"></i>
                                <p class="text-sm font-medium text-slate-500">Tidak ada pelamar ditemukan</p>
                                <p class="text-xs mt-1">Coba sesuaikan filter atau pencarian Anda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($applications, 'links'))
            <div class="px-5 py-3 border-t border-slate-100 bg-slate-50/50">
                {{ $applications->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection
