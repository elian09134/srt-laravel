@extends('m28.layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-black text-slate-800 tracking-tight">
            Selamat Datang, {{ auth()->user()->name }} 👋
        </h1>
        <p class="text-sm font-medium text-slate-500 mt-1">
            Ringkasan kandidat yang Anda rekomendasikan
        </p>
    </div>
</div>

@php
    $diterima = $statusDistribution['Diterima'] ?? 0;
    $ditolak = $statusDistribution['Ditolak'] ?? 0;
    $proses = $totalApplications - $diterima - $ditolak;
@endphp

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="relative bg-white rounded-2xl shadow-sm border border-slate-100 p-6 overflow-hidden group hover:border-purple-200 transition-colors">
        <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-br from-purple-50 to-purple-100 rounded-bl-full -mr-4 -mt-4 z-0 transition-transform group-hover:scale-110"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center text-white text-xl shadow-md shadow-purple-500/30">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div>
                <h3 class="text-3xl font-black text-slate-800 tracking-tight mb-1">{{ number_format($totalCandidates) }}</h3>
                <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">Total Kandidat</p>
            </div>
        </div>
    </div>

    <div class="relative bg-white rounded-2xl shadow-sm border border-slate-100 p-6 overflow-hidden group hover:border-amber-200 transition-colors">
        <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-br from-amber-50 to-amber-100 rounded-bl-full -mr-4 -mt-4 z-0 transition-transform group-hover:scale-110"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center text-white text-xl shadow-md shadow-amber-500/30">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
            <div>
                <h3 class="text-3xl font-black text-slate-800 tracking-tight mb-1">{{ number_format($proses) }}</h3>
                <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">Dalam Proses</p>
            </div>
        </div>
    </div>

    <div class="relative bg-white rounded-2xl shadow-sm border border-slate-100 p-6 overflow-hidden group hover:border-green-200 transition-colors">
        <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-br from-green-50 to-green-100 rounded-bl-full -mr-4 -mt-4 z-0 transition-transform group-hover:scale-110"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center text-white text-xl shadow-md shadow-green-500/30">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <div>
                <h3 class="text-3xl font-black text-slate-800 tracking-tight mb-1">{{ number_format($diterima) }}</h3>
                <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">Diterima</p>
            </div>
        </div>
    </div>

    <div class="relative bg-white rounded-2xl shadow-sm border border-slate-100 p-6 overflow-hidden group hover:border-red-200 transition-colors">
        <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-br from-red-50 to-red-100 rounded-bl-full -mr-4 -mt-4 z-0 transition-transform group-hover:scale-110"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center text-white text-xl shadow-md shadow-red-500/30">
                    <i class="fas fa-times-circle"></i>
                </div>
            </div>
            <div>
                <h3 class="text-3xl font-black text-slate-800 tracking-tight mb-1">{{ number_format($ditolak) }}</h3>
                <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">Ditolak</p>
            </div>
        </div>
    </div>
</div>

@if($targetYearly)
<div class="max-w-sm mb-8">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <div class="flex items-center justify-between mb-3">
            <div>
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest">Target Tahunan</h3>
                <p class="text-xs text-slate-400">{{ now()->year }}</p>
            </div>
            <div class="text-right">
                <span class="text-2xl font-black text-slate-800">{{ $yearlyActual }}</span>
                <span class="text-sm text-slate-400">/ {{ $targetYearly }}</span>
            </div>
        </div>
        <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden">
            @php
                $yearColor = $yearlyPct >= 100 ? 'bg-green-500' : ($yearlyPct >= 50 ? 'bg-amber-500' : 'bg-blue-500');
                $yearBarPct = max($yearlyActual, $targetYearly) > 0 ? round(($yearlyActual / max($yearlyActual, $targetYearly)) * 100) : 0;
            @endphp
            <div class="h-full rounded-full transition-all {{ $yearColor }}" style="width: {{ $yearBarPct }}%"></div>
        </div>
        <p class="text-xs {{ $yearlyPct >= 100 ? 'text-green-600 font-bold' : 'text-slate-400' }} mt-2">{{ $yearlyPct }}% tercapai</p>
    </div>
</div>
@endif

@if($monthlyBreakdown->isNotEmpty())
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-8">
    <div class="flex items-center gap-3 mb-5">
        <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600">
            <i class="fas fa-bullseye"></i>
        </div>
        <div>
            <h3 class="text-lg font-bold text-slate-800">Capaian Target Per Bulan</h3>
            <p class="text-xs text-slate-400 mt-0.5">Perbandingan target vs realisasi kandidat {{ now()->year }}</p>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500 font-semibold">
                    <th class="px-4 py-3 text-left">Bulan</th>
                    <th class="px-4 py-3 text-center">Target</th>
                    <th class="px-4 py-3 text-center">Realisasi</th>
                    <th class="px-4 py-3 text-center">Progress</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($monthlyBreakdown as $mb)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-4 py-3 font-semibold text-slate-700">{{ $monthNames[$mb->month] ?? $mb->month }}</td>
                        <td class="px-4 py-3 text-center text-slate-600">{{ $mb->target_count }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="font-bold {{ $mb->actual >= $mb->target_count ? 'text-green-600' : 'text-amber-600' }}">
                                {{ $mb->actual }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="flex-1 h-2.5 bg-slate-100 rounded-full overflow-hidden">
                                    @php
                                        $barColor = $mb->pct >= 100 ? 'bg-green-500' : ($mb->pct >= 50 ? 'bg-amber-500' : 'bg-blue-500');
                                    @endphp
                                    <div class="h-full rounded-full transition-all {{ $barColor }}" style="width: {{ min($mb->pct, 100) }}%"></div>
                                </div>
                                <span class="text-xs font-bold text-slate-500 w-12 text-right {{ $mb->pct >= 100 ? 'text-green-600' : '' }}">{{ $mb->pct }}%</span>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Filter + Alur Seleksi --}}
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Alur Seleksi Kandidat</h3>
            <p class="text-xs text-slate-400 mt-0.5">{{ $bulan === 'all' ? 'Rekapitulasi seluruh kandidat' : 'Perbandingan antara bulan terpilih vs bulan sebelumnya' }}</p>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600">
                <i class="fas fa-chart-simple"></i>
            </div>
            <form method="GET" action="{{ route('m28.dashboard') }}" class="flex items-center gap-2">
                <select name="bulan" onchange="this.form.submit()"
                        class="rounded-lg border-slate-300 text-sm focus:border-purple-500 focus:ring-purple-500 shadow-sm py-2 px-3">
                    @foreach($monthOptions as $opt)
                        <option value="{{ $opt['value'] }}" {{ $bulan === $opt['value'] ? 'selected' : '' }}>
                            {{ $opt['label'] }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    <div class="overflow-x-auto -mx-2">
        <div class="min-w-[600px] px-2 space-y-4">
            {{-- Header --}}
            <div class="flex items-center text-xs text-slate-400 font-semibold uppercase tracking-wider pb-2 border-b border-slate-100">
                <div class="w-[130px] flex-shrink-0">Tahap</div>
                <div class="flex-1 text-center">{{ $selectedMonth }}</div>
                @if($bulan !== 'all')
                <div class="w-10 flex-shrink-0 text-center">vs</div>
                <div class="flex-1 text-center">{{ $prevMonth }}</div>
                @endif
            </div>

            @foreach($funnelData as $i => $f)
                @php $prev = $prevFunnelData[$i]; @endphp
                <div>
                    <div class="flex items-center justify-between text-sm mb-1.5">
                        <div class="w-[130px] flex-shrink-0 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background: {{ $funnelColors[$i] }}"></span>
                            <span class="font-semibold text-slate-700 truncate">{{ $f['stage'] }}</span>
                        </div>

                        {{-- Main bar --}}
                        <div class="flex-1 flex items-center gap-2 min-w-0">
                            <div class="flex-1 h-4 bg-slate-50 rounded overflow-hidden relative">
                                <div class="h-full rounded transition-all absolute inset-0" style="width: {{ max($f['bar_pct'], 1) }}%; background: {{ $funnelColors[$i] }};"></div>
                            </div>
                            <span class="text-xs font-bold text-slate-700 w-6 text-right flex-shrink-0">{{ $f['count'] }}</span>
                        </div>

                        @if($bulan !== 'all')
                        <div class="w-10 flex-shrink-0 text-center">
                            @if($f['count'] > $prev['count'])
                                <span class="text-green-600 text-xs"><i class="fas fa-arrow-up"></i></span>
                            @elseif($f['count'] < $prev['count'])
                                <span class="text-red-500 text-xs"><i class="fas fa-arrow-down"></i></span>
                            @else
                                <span class="text-slate-300 text-xs">-</span>
                            @endif
                        </div>

                        {{-- Previous month bar --}}
                        <div class="flex-1 flex items-center gap-2 min-w-0">
                            <div class="flex-1 h-4 bg-slate-50 rounded overflow-hidden relative">
                                <div class="h-full rounded transition-all absolute inset-0 opacity-40" style="width: {{ max($prev['bar_pct'], 1) }}%; background: {{ $funnelColors[$i] }};"></div>
                            </div>
                            <span class="text-xs text-slate-500 w-6 text-right flex-shrink-0">{{ $prev['count'] }}</span>
                        </div>
                        @endif
                    </div>

                    {{-- Drop info --}}
                    @if($f['drop'] > 0)
                    <div class="flex items-center text-[10px] text-slate-400 pl-[130px]">
                        <div class="flex-1">
                            <span class="text-red-400">↓ {{ $f['drop'] }}%</span>
                        </div>
                        @if($bulan !== 'all' && $prev['drop'] > 0)
                        <div class="w-10 flex-shrink-0"></div>
                        <div class="flex-1">
                            <span class="text-red-300">↓ {{ $prev['drop'] }}%</span>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            @endforeach

            {{-- Legend --}}
            <div class="flex items-center gap-6 pt-3 text-xs text-slate-400 border-t border-slate-100">
                <div class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded" style="background: #8b5cf6;"></span>
                    <span>{{ $selectedMonth }}</span>
                </div>
                @if($bulan !== 'all')
                <div class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded opacity-40" style="background: #8b5cf6;"></span>
                    <span>{{ $prevMonth }}</span>
                </div>
                @endif
                <div class="flex items-center gap-1.5 text-red-400">
                    <i class="fas fa-arrow-down text-[9px]"></i>
                    <span>Drop</span>
                </div>
            </div>
        </div>
    </div>
</div>

@if($recentCandidates->isNotEmpty())
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100">
        <h3 class="text-lg font-bold text-slate-800">Kandidat Terbaru</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500 font-semibold">
                    <th class="px-6 py-4 text-left">Nama</th>
                    <th class="px-6 py-4 text-left">Email</th>
                    <th class="px-6 py-4 text-left">Posisi</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-left">Tanggal Daftar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($recentCandidates as $candidate)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <a href="{{ route('m28.candidates.show', $candidate) }}" class="font-bold text-purple-600 hover:text-purple-700 transition-colors">
                            {{ $candidate->name }}
                        </a>
                    </td>
                    <td class="px-6 py-4 text-slate-600">{{ $candidate->email }}</td>
                    <td class="px-6 py-4 text-slate-600">
                        @foreach($candidate->applications as $app)
                            <span class="inline-block">{{ $app->job?->title ?? '-' }}</span>
                        @endforeach
                        @if($candidate->applications->isEmpty())
                            <span class="text-slate-400">Belum melamar</span>
                        @endif
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
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-slate-100 text-right">
        <a href="{{ route('m28.candidates.index') }}" class="text-sm font-bold text-purple-600 hover:text-purple-700 transition-colors">
            Lihat Semua Kandidat <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
</div>
@else
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-12 text-center">
    <div class="w-16 h-16 bg-purple-50 rounded-full flex items-center justify-center mx-auto mb-4">
        <i class="fas fa-users text-purple-400 text-2xl"></i>
    </div>
    <h3 class="text-lg font-bold text-slate-700 mb-2">Belum Ada Kandidat</h3>
    <p class="text-sm text-slate-500">Kandidat yang merekomendasikan M28 sebagai sumber info akan muncul di sini.</p>
</div>
@endif
@endsection
