@extends('m28.layouts.admin')

@section('title', 'Kandidat Saya')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Kandidat Saya</h1>
        <p class="text-sm text-slate-500">Daftar kandidat yang merekomendasikan {{ auth()->user()->name }}</p>
    </div>
</div>

<div class="mb-6 bg-white p-4 rounded-xl shadow-sm border border-slate-200">
    <form action="{{ route('m28.candidates.index') }}" method="GET" class="flex flex-wrap gap-3">
        <div class="flex-1 min-w-[200px]">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                    <i class="fas fa-search text-xs"></i>
                </span>
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="pl-9 w-full rounded-lg border-slate-300 text-sm focus:border-purple-500 focus:ring-purple-500 shadow-sm">
            </div>
        </div>
        <select name="status" class="rounded-lg border-slate-300 text-sm focus:border-purple-500 focus:ring-purple-500 shadow-sm">
            <option value="">Semua Status</option>
            @foreach($statuses as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ $s }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-6 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors shadow-sm">
            Filter
        </button>
        @if(request('search') || request('status'))
            <a href="{{ route('m28.candidates.index') }}" class="px-6 py-2 bg-slate-100 text-slate-600 text-sm font-medium rounded-lg hover:bg-slate-200 text-center transition-colors">
                Reset
            </a>
        @endif
        <a href="{{ route('m28.candidates.export', request()->only(['search', 'status'])) }}" class="px-6 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-colors shadow-sm inline-flex items-center gap-2">
            <i class="fas fa-download"></i> Download Excell
        </a>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-xs uppercase tracking-wider text-slate-500 font-semibold">
                    <th class="px-6 py-4">Kandidat</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Sumber Info</th>
                    <th class="px-6 py-4">Posisi Dilamar</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Tanggal Daftar</th>
                    <th class="px-6 py-4">Update Terakhir</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($candidates as $candidate)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-bold border border-purple-200 mr-3">
                                    {{ substr($candidate->name, 0, 1) }}
                                </div>
                                <div class="font-bold text-slate-800">{{ $candidate->name }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">{{ $candidate->email }}</td>
                        <td class="px-6 py-4">
                            @php
                                $sourceColors = [
                                    'M28' => 'bg-purple-100 text-purple-700',
                                    'Sosial Media' => 'bg-blue-100 text-blue-700',
                                    'Facebook' => 'bg-indigo-100 text-indigo-700',
                                    'Instagram' => 'bg-pink-100 text-pink-700',
                                    'Twitter/X' => 'bg-sky-100 text-sky-700',
                                    'LinkedIn' => 'bg-cyan-100 text-cyan-700',
                                    'TikTok' => 'bg-rose-100 text-rose-700',
                                    'Google' => 'bg-green-100 text-green-700',
                                    'JobStreet' => 'bg-orange-100 text-orange-700',
                                    'Teman' => 'bg-teal-100 text-teal-700',
                                    'Keluarga' => 'bg-amber-100 text-amber-700',
                                    'Email Marketing' => 'bg-slate-100 text-slate-700',
                                ];
                                $source = $candidate->referral_source ?? '-';
                                $badgeClass = $sourceColors[$source] ?? 'bg-slate-100 text-slate-700';
                            @endphp
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold {{ $badgeClass }}">
                                {{ $source }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @forelse($candidate->applications as $app)
                                <span class="inline-block text-slate-700">{{ $app->job?->title ?? '-' }}</span>
                            @empty
                                <span class="text-slate-400">Belum melamar</span>
                            @endforelse
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $status = $candidate->applications->first()?->status ?? '-';
                                $colors = ['Baru' => 'bg-blue-100 text-blue-700', 'Lamaran Dilihat' => 'bg-yellow-100 text-yellow-700', 'Psikotest' => 'bg-amber-100 text-amber-700', 'Wawancara HR' => 'bg-indigo-100 text-indigo-700', 'Wawancara User' => 'bg-purple-100 text-purple-700', 'Shortlist' => 'bg-teal-100 text-teal-700', 'Offering Letter' => 'bg-emerald-100 text-emerald-700', 'Diterima' => 'bg-green-100 text-green-700', 'Tidak Lanjut' => 'bg-red-100 text-red-700'];
                                $badgeClass = $colors[$status] ?? 'bg-slate-100 text-slate-700';
                            @endphp
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold {{ $badgeClass }}">
                                {{ $status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-xs">
                            {{ $candidate->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-xs">
                            @php
                                $lastHistory = $candidate->applications->first()?->statusHistories->last();
                            @endphp
                            @if($lastHistory)
                                {{ $lastHistory->created_at->format('d M Y') }}
                                <span class="text-slate-400 ml-1">{{ $lastHistory->created_at->format('H:i') }}</span>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('m28.candidates.show', $candidate) }}" class="inline-flex items-center px-4 py-2 bg-purple-50 text-purple-600 text-xs font-bold rounded-lg hover:bg-purple-100 transition-colors">
                                Detail <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="text-slate-400">
                                <i class="fas fa-users text-3xl mb-3 block"></i>
                                <p class="font-medium">Belum ada kandidat</p>
                                <p class="text-xs mt-1">Kandidat yang memilih {{ auth()->user()->name }} sebagai sumber info akan muncul di sini.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($candidates->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $candidates->links() }}
        </div>
    @endif
</div>
@endsection
