@extends('layouts.app')

@section('title', 'Detail Lamaran')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4">
    <a href="{{ route('applications.index') }}" class="inline-flex items-center text-sm text-slate-500 hover:text-blue-600 transition-colors mb-6">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Riwayat Lamaran
    </a>

    <!-- Header -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-5">
            <div class="flex items-start justify-between">
                <div class="text-white">
                    <h1 class="text-xl font-bold">{{ $application->job->title ?? 'Lowongan Dihapus' }}</h1>
                    <p class="text-blue-100 text-sm mt-1">
                        <i class="fas fa-map-marker-alt mr-1"></i>{{ $application->job->location ?? '-' }}
                        <span class="mx-2">•</span>
                        <i class="fas fa-calendar-alt mr-1"></i>{{ optional($application->created_at)->format('d M Y') ?? '-' }}
                    </p>
                </div>
                <div class="flex-shrink-0">
                    @php
                        $statusColors = [
                            'Baru' => 'bg-white/20 text-white border-white/30',
                            'Lamaran Dilihat' => 'bg-sky-500/20 text-sky-100 border-sky-300/30',
                            'Psikotest' => 'bg-amber-500/20 text-amber-100 border-amber-300/30',
                            'Wawancara HR' => 'bg-pink-500/20 text-pink-100 border-pink-300/30',
                            'Wawancara User' => 'bg-indigo-500/20 text-indigo-100 border-indigo-300/30',
                            'Offering Letter' => 'bg-emerald-500/20 text-emerald-100 border-emerald-300/30',
                            'Shortlist' => 'bg-purple-500/20 text-purple-100 border-purple-300/30',
                            'Diterima' => 'bg-green-500/30 text-green-100 border-green-300/40',
                            'Tidak Lanjut' => 'bg-red-500/20 text-red-100 border-red-300/30',
                        ];
                        $badgeClass = $statusColors[$application->status] ?? 'bg-white/10 text-white border-white/20';
                    @endphp
                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold border backdrop-blur-sm {{ $badgeClass }}">
                        {{ strtoupper($application->status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Cover Letter -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                <i class="fas fa-envelope"></i>
            </div>
            <h3 class="font-bold text-slate-800">Surat Lamaran</h3>
        </div>
        <div class="bg-slate-50 rounded-xl p-5 text-sm text-slate-700 whitespace-pre-wrap border border-slate-100 leading-relaxed">
            {{ $application->cover_letter ?? 'Tidak ada surat lamaran dilampirkan.' }}
        </div>
    </div>

    <!-- Snapshot Data -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <h3 class="font-bold text-slate-800">Data Pendaftaran</h3>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider mb-1">Nama Lengkap</p>
                <p class="text-sm font-medium text-slate-800">{{ $application->applicant_name ?? (auth()->user()->name ?? '—') }}</p>
            </div>
            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider mb-1">Email</p>
                <p class="text-sm font-medium text-slate-800">{{ $application->applicant_email ?? (auth()->user()->email ?? '—') }}</p>
            </div>
            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider mb-1">Telepon</p>
                <p class="text-sm font-medium text-slate-800">{{ $application->applicant_phone ?? optional(auth()->user()->profile)->phone_number ?? '—' }}</p>
            </div>
            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider mb-1">Pendidikan Terakhir</p>
                <p class="text-sm font-medium text-slate-800">{{ $application->applicant_last_education ?? optional(auth()->user()->profile)->education_level ?? '—' }}</p>
            </div>
            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 sm:col-span-2">
                <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider mb-1">Posisi Terakhir</p>
                <p class="text-sm font-medium text-slate-800">{{ $application->applicant_last_position ?? optional(auth()->user()->profile)->last_position ?? '—' }}</p>
            </div>
        </div>
    </div>

    <!-- Timeline -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600">
                <i class="fas fa-clock-rotate-left"></i>
            </div>
            <h3 class="font-bold text-slate-800">Timeline Status</h3>
        </div>

        @php
            $steps = [
                'Baru' => ['icon' => 'fa-file', 'color' => 'blue'],
                'Lamaran Dilihat' => ['icon' => 'fa-eye', 'color' => 'sky'],
                'Psikotest' => ['icon' => 'fa-pencil', 'color' => 'amber'],
                'Wawancara HR' => ['icon' => 'fa-handshake', 'color' => 'pink'],
                'Wawancara User' => ['icon' => 'fa-users', 'color' => 'indigo'],
                'Offering Letter' => ['icon' => 'fa-file-signature', 'color' => 'emerald'],
                'Shortlist' => ['icon' => 'fa-list-check', 'color' => 'purple'],
                'Diterima' => ['icon' => 'fa-check-circle', 'color' => 'green'],
                'Tidak Lanjut' => ['icon' => 'fa-xmark', 'color' => 'red'],
            ];
            $currentIndex = array_search($application->status, array_keys($steps));
            if ($currentIndex === false) $currentIndex = -1;
        @endphp

        <div class="relative">
            <div class="absolute left-5 top-0 bottom-0 w-0.5 bg-slate-200"></div>
            <div class="space-y-0">
                @foreach($steps as $stepKey => $stepConfig)
                    @php
                        $stepIndex = array_search($stepKey, array_keys($steps));
                        $state = 'future';
                        if ($stepIndex < $currentIndex) $state = 'done';
                        if ($stepIndex === $currentIndex) $state = 'current';

                        $doneColors = [
                            'icon' => 'text-green-600', 'bg' => 'bg-green-100', 'ring' => 'ring-green-200',
                            'text' => 'text-green-800', 'line' => 'bg-green-300',
                        ];
                        $currentColors = [
                            'icon' => 'text-blue-600', 'bg' => 'bg-blue-100', 'ring' => 'ring-blue-300',
                            'text' => 'text-blue-700', 'line' => 'bg-blue-300',
                        ];
                        $futureColors = [
                            'icon' => 'text-slate-300', 'bg' => 'bg-slate-100', 'ring' => 'ring-slate-200',
                            'text' => 'text-slate-400', 'line' => 'bg-slate-200',
                        ];

                        $colors = $state === 'done' ? $doneColors : ($state === 'current' ? $currentColors : $futureColors);
                    @endphp

                    <div class="relative flex items-start pb-2 last:pb-0">
                        <div class="relative z-10 flex-shrink-0">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center ring-4 ring-white transition-all {{ $colors['bg'] }} {{ $colors['icon'] }}">
                                @if($state === 'done')
                                    <i class="fas fa-check text-sm"></i>
                                @else
                                    <i class="fas {{ $stepConfig['icon'] }} text-sm"></i>
                                @endif
                            </div>
                        </div>
                        <div class="ml-4 flex-1 pb-6 border-b border-slate-100 last:border-b-0">
                            <div class="flex items-center justify-between">
                                <h4 class="text-sm font-bold {{ $colors['text'] }}">{{ $stepKey }}</h4>
                                @php $h = $application->statusHistories->firstWhere('status', $stepKey); @endphp
                                @if($h)
                                    <span class="text-[10px] text-slate-400 font-medium">{{ optional($h->created_at)->format('d M, H:i') }}</span>
                                @endif
                            </div>
                            @if($h && $h->note)
                                <p class="text-xs text-slate-500 mt-1 italic leading-relaxed bg-slate-50 p-2 rounded-lg border-l-2 border-slate-200">{{ $h->note }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endSection
