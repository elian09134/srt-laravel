@extends('layouts.app')

@section('title', 'Riwayat Lamaran')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Riwayat Lamaran Saya</h1>
        <p class="text-sm text-slate-500 mt-1">Pantau status lamaran pekerjaan yang telah Anda kirimkan.</p>
    </div>

    @if($applications->isEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-12 text-center">
            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-file-lines text-2xl text-slate-400"></i>
            </div>
            <p class="text-slate-500 font-medium">Anda belum mengirimkan lamaran.</p>
            <a href="{{ route('karir') }}" class="mt-3 inline-flex items-center text-sm text-blue-600 hover:text-blue-700 font-medium">
                <i class="fas fa-briefcase mr-2"></i> Lihat Lowongan Tersedia
            </a>
        </div>
    @else
        <div class="space-y-3">
            @foreach($applications as $app)
                @php
                    $statusColors = [
                        'Baru' => 'bg-blue-100 text-blue-700 border-blue-200',
                        'Lamaran Dilihat' => 'bg-sky-100 text-sky-700 border-sky-200',
                        'Psikotest' => 'bg-amber-100 text-amber-700 border-amber-200',
                        'Wawancara HR' => 'bg-pink-100 text-pink-700 border-pink-200',
                        'Wawancara User' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                        'Offering Letter' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                        'Shortlist' => 'bg-purple-100 text-purple-700 border-purple-200',
                        'Diterima' => 'bg-green-100 text-green-700 border-green-200',
                        'Tidak Lanjut' => 'bg-red-100 text-red-700 border-red-200',
                    ];
                    $badgeClass = $statusColors[$app->status] ?? 'bg-slate-100 text-slate-700 border-slate-200';
                @endphp
                <a href="{{ route('applications.show', $app) }}" class="block bg-white rounded-2xl shadow-sm border border-slate-100 p-5 hover:shadow-md hover:border-blue-200 transition-all group">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="font-bold text-slate-800 truncate">{{ $app->job->title ?? 'Lowongan Dihapus' }}</h3>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $badgeClass }}">
                                    {{ $app->status }}
                                </span>
                            </div>
                            <p class="text-sm text-slate-500">
                                <i class="fas fa-map-marker-alt mr-1 text-slate-400"></i>{{ $app->job->location ?? '-' }}
                                <span class="mx-2">•</span>
                                <i class="fas fa-calendar-alt mr-1 text-slate-400"></i>{{ $app->created_at->format('d M Y') }}
                            </p>
                        </div>
                        <div class="ml-4 flex-shrink-0 text-slate-400 group-hover:text-blue-500 transition-colors">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $applications->links() }}
        </div>
    @endif
</div>
@endsection
