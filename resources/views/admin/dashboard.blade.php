@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-8">
        <h1 class="text-xl font-semibold text-slate-800">Selamat Datang, {{ auth()->user()->name }}</h1>
        <p class="text-sm text-slate-500 mt-1">{{ now()->translatedFormat('l, d F Y') }}</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <div class="bg-white rounded-xl border border-slate-100 p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600">
                    <i class="fas fa-users"></i>
                </div>
                <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">+12%</span>
            </div>
            <div class="text-2xl font-semibold text-slate-800">{{ number_format($total_applicants) }}</div>
            <div class="text-xs text-slate-400 mt-0.5">Total Pelamar</div>
        </div>

        <div class="bg-white rounded-xl border border-slate-100 p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-600">
                    <i class="fas fa-briefcase"></i>
                </div>
                <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Aktif</span>
            </div>
            <div class="text-2xl font-semibold text-slate-800">{{ number_format($total_jobs) }}</div>
            <div class="text-xs text-slate-400 mt-0.5">Lowongan Tersedia</div>
        </div>

        <div class="bg-white rounded-xl border border-slate-100 p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-violet-50 rounded-lg flex items-center justify-center text-violet-600">
                    <i class="fas fa-star"></i>
                </div>
                <span class="text-xs font-medium text-slate-500 bg-slate-50 px-2 py-0.5 rounded-full">Tersimpan</span>
            </div>
            <div class="text-2xl font-semibold text-slate-800">{{ number_format($total_talent_pool) }}</div>
            <div class="text-xs text-slate-400 mt-0.5">Talent Pool</div>
        </div>

        @php $pendingFptk = \App\Models\Fptk::where('status', 'pending')->count(); @endphp
        <div class="bg-white rounded-xl border border-slate-100 p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center text-amber-600">
                    <i class="fas fa-file-contract"></i>
                </div>
                @if($pendingFptk > 0)
                    <span class="text-xs font-medium text-red-600 bg-red-50 px-2 py-0.5 rounded-full">Butuh Aksi</span>
                @else
                    <span class="text-xs font-medium text-slate-400 bg-slate-50 px-2 py-0.5 rounded-full">Aman</span>
                @endif
            </div>
            <div class="text-2xl font-semibold text-slate-800">{{ $pendingFptk }}</div>
            <div class="text-xs text-slate-400 mt-0.5">Pending FPTK</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-semibold text-slate-800">Distribusi Status Lamaran</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Rasio perbandingan status pelamar</p>
                </div>
                <div class="relative">
                    <select class="appearance-none bg-slate-50 border border-slate-200 text-slate-600 text-xs font-medium rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-1.5 pr-7">
                        <option value="month">Bulan Ini</option>
                        <option value="year">Tahun Ini</option>
                        <option value="all">Semua</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 text-slate-400">
                        <i class="fas fa-chevron-down text-[10px]"></i>
                    </div>
                </div>
            </div>
            <div class="p-5 h-72">
                <canvas id="statusDistributionChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-100 overflow-hidden flex flex-col">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-semibold text-slate-800">Lowongan Aktif</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Berdasarkan jumlah pelamar</p>
                </div>
                <a href="{{ route('admin.jobs.index') }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-700 transition-colors">Lihat Semua</a>
            </div>

            <div class="flex-1 max-h-[350px] overflow-y-auto">
                <div class="divide-y divide-slate-50">
                    @forelse($active_jobs as $job)
                        <a href="{{ route('admin.jobs.show', $job->id) }}" class="block px-5 py-3.5 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center justify-between mb-1">
                                <h4 class="text-sm font-medium text-slate-800 truncate pr-3">{{ $job->title }}</h4>
                                <span class="shrink-0 text-[11px] text-slate-400">{{ $job->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium
                                    {{ $job->type === 'Full Time' ? 'bg-indigo-50 text-indigo-600' : 
                                       ($job->type === 'Part Time' ? 'bg-amber-50 text-amber-600' : 'bg-blue-50 text-blue-600') }}">
                                    {{ $job->type }}
                                </span>
                                <span class="text-[11px] text-slate-400">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    {{ \Illuminate\Support\Str::limit($job->location, 18) }}
                                </span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-medium text-slate-500">{{ $job->applications_count }} pelamar</span>
                                <div class="flex-1 h-1 bg-slate-100 rounded-full overflow-hidden">
                                    @php
                                        $percentage = min(100, max(5, ($job->applications_count / 50) * 100));
                                        $color = $percentage > 80 ? 'bg-emerald-500' : ($percentage > 30 ? 'bg-indigo-500' : 'bg-slate-300');
                                    @endphp
                                    <div class="h-full {{ $color }} rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="p-10 text-center">
                            <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mx-auto mb-3">
                                <i class="fas fa-folder-open"></i>
                            </div>
                            <p class="text-sm text-slate-500 mb-3">Tidak ada lowongan aktif</p>
                            <a href="{{ route('admin.jobs.create') }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-xs font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                                <i class="fas fa-plus mr-1.5"></i> Buat Lowongan
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            @if($active_jobs->count() > 0)
            <div class="px-5 py-3 bg-slate-50 border-t border-slate-100 text-center">
                <a href="{{ route('admin.jobs.index') }}" class="text-xs font-medium text-slate-500 hover:text-indigo-600 transition-colors">
                    Kelola Semua Lowongan <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('statusDistributionChart').getContext('2d');
            const rawData = JSON.parse('<?php echo json_encode($status_distribution); ?>');

            const colors = ['#6366f1', '#8b5cf6', '#10b981', '#f59e0b', '#ef4444', '#94a3b8'];

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: Object.keys(rawData),
                    datasets: [{
                        label: 'Kandidat',
                        data: Object.values(rawData),
                        backgroundColor: colors,
                        borderRadius: 6,
                        borderSkipped: false,
                        barThickness: 28,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleColor: '#f1f5f9',
                            bodyColor: '#cbd5e1',
                            padding: 10,
                            titleFont: { size: 12, weight: '600' },
                            bodyFont: { size: 12 },
                            cornerRadius: 8,
                            displayColors: true,
                            boxPadding: 3,
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.parsed.y + ' Kandidat';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            border: { display: false },
                            grid: { color: '#f1f5f9', drawTicks: false },
                            ticks: { color: '#94a3b8', font: { size: 11 }, padding: 8 }
                        },
                        x: {
                            border: { display: false },
                            grid: { display: false },
                            ticks: { color: '#64748b', font: { size: 11 }, padding: 8 }
                        }
                    },
                    animation: {
                        y: { duration: 800, easing: 'easeOutQuart' }
                    }
                }
            });
        });
    </script>
@endsection
