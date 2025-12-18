@extends('layouts.app')

@section('title', 'Detail Lamaran')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <a href="{{ route('applications.index') }}" class="text-sm text-gray-600">&larr; Kembali ke Riwayat Lamaran</a>

    <div class="bg-white p-6 rounded-lg shadow-md mt-4">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-bold">{{ $application->job->title ?? 'Lowongan Dihapus' }}</h1>
                <div class="text-sm text-gray-500">{{ $application->job->location ?? '-' }} • {{ $application->created_at->format('d M Y') }}</div>
            </div>
            <div class="text-right">
                <div class="text-sm text-gray-500">Status</div>
                <div class="mt-1 font-semibold @if(in_array($application->status, ['Diterima','Offering Letter'])) text-green-600 @elseif(in_array($application->status, ['Tidak Lanjut','Ditolak'])) text-red-600 @else text-gray-800 @endif">{{ $application->status }}</div>
            </div>
        </div>

        <div class="mt-6">
            <h3 class="font-semibold">Surat Lamaran</h3>
            <div class="mt-2 bg-gray-50 border p-4 rounded text-sm text-gray-800 whitespace-pre-wrap">{{ $application->cover_letter ?? '—' }}</div>
        </div>

        <div class="mt-6">
            <h3 class="font-semibold">Data Pendaftaran (Snapshot)</h3>
            <div class="mt-2 text-sm text-gray-800 space-y-2">
                <div><strong>Nama saat daftar:</strong> {{ $application->applicant_name ?? (auth()->user()->name ?? '—') }}</div>
                <div><strong>Email saat daftar:</strong> {{ $application->applicant_email ?? (auth()->user()->email ?? '—') }}</div>
                <div><strong>Telepon saat daftar:</strong> {{ $application->applicant_phone ?? optional(auth()->user()->profile)->phone_number ?? '—' }}</div>
                <div><strong>Pendidikan terakhir saat daftar:</strong> {{ $application->applicant_last_education ?? optional(auth()->user()->profile)->education_level ?? '—' }}</div>
                <div><strong>Posisi terakhir saat daftar:</strong> {{ $application->applicant_last_position ?? optional(auth()->user()->profile)->last_position ?? '—' }}</div>
            </div>
        </div>

        <div class="mt-6">
            <h3 class="font-semibold">Timeline Status</h3>
            <div class="mt-3 space-y-3">
                @php
                    $steps = [
                        'Baru',
                        'Lamaran Dilihat',
                        'Psikotest',
                        'Wawancara HR',
                        'Wawancara User',
                        'Offering Letter',
                        'Shortlist',
                        'Diterima',
                        'Tidak Lanjut',
                    ];
                    $currentIndex = array_search($application->status, $steps);
                    if ($currentIndex === false) $currentIndex = -1;
                @endphp

                <ol class="border-l border-gray-200">
                    @foreach($steps as $i => $step)
                        @php
                            $state = 'future';
                            if ($i < $currentIndex) $state = 'done';
                            if ($i === $currentIndex) $state = 'current';
                        @endphp

                        <li class="mb-6 ml-6">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    @if($state === 'done')
                                        <div class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center text-white">✓</div>
                                    @elseif($state === 'current')
                                        <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white">●</div>
                                    @else
                                        <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-700">○</div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <div class="font-medium @if($state === 'current') text-blue-600 @elseif($state === 'done') text-gray-700 @else text-gray-500 @endif">{{ $step }}</div>
                                    @if($state === 'done' || $state === 'current')
                                        @php $h = $application->statusHistories->firstWhere('status', $step); @endphp
                                        @if($h)
                                            <div class="text-xs text-gray-500">{{ $h->created_at->format('d M Y H:i') }}{{ $h->changer ? ' — oleh ' . $h->changer->name : '' }}</div>
                                            @if($h->note)
                                                <div class="text-sm text-gray-700 mt-1">{{ $h->note }}</div>
                                            @endif
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>

    </div>
</div>
@endsection
