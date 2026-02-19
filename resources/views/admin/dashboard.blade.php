@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Stat Card 1 -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-start justify-between hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Total Pelamar</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ number_format($total_applicants) }}</h3>
                <p class="text-xs text-green-600 mt-1 flex items-center">
                    <i class="fas fa-arrow-up mr-1"></i> <span class="font-medium">+12%</span> <span class="text-slate-400 ml-1">bulan ini</span>
                </p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                <i class="fas fa-users"></i>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-start justify-between hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Lowongan Aktif</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ number_format($total_jobs) }}</h3>
                <p class="text-xs text-slate-400 mt-1">Posisi tersedia</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                <i class="fas fa-briefcase"></i>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-start justify-between hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Talent Pool</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ number_format($total_talent_pool) }}</h3>
                <p class="text-xs text-slate-400 mt-1">Kandidat potensial</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-xl">
                <i class="fas fa-star"></i>
            </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-start justify-between hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Pending FPTK</p>
                @php $pendingFptk = \App\Models\Fptk::where('status', 'pending')->count(); @endphp
                <h3 class="text-2xl font-bold text-slate-800">{{ $pendingFptk }}</h3>
                 <p class="text-xs text-orange-500 mt-1 font-medium">Butuh approval</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center text-xl">
                <i class="fas fa-file-contract"></i>
            </div>
        </div>
    </div>

    <!-- Main Grid: Chart & Active Jobs -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column: Chart (Main Focus) -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-slate-800">Distribusi Status Pelamar</h3>
                 <select class="text-sm border-slate-200 rounded-lg text-slate-600 focus:ring-blue-500 focus:border-blue-500">
                    <option>Bulan Ini</option>
                    <option>Tahun Ini</option>
                </select>
            </div>
            <div class="h-80 w-full">
                <canvas id="statusDistributionChart"></canvas>
            </div>
        </div>

        <!-- Right Column: Recent/Active List -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 flex flex-col">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-800">Lowongan Populer</h3>
                <a href="{{ route('admin.jobs.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Lihat Semua</a>
            </div>
            <div class="p-0 flex-1 overflow-y-auto max-h-[400px]">
                @forelse($active_jobs as $job)
                <div class="p-4 border-b border-slate-50 hover:bg-slate-50 transition-colors group">
                    <div class="flex justify-between items-start mb-1">
                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">{{ $job->type }}</span>
                        <span class="text-xs text-slate-400">{{ $job->created_at->diffForHumans() }}</span>
                    </div>
                    <a href="{{ route('admin.jobs.show', $job->id) }}" class="block font-semibold text-slate-800 group-hover:text-blue-600 transition-colors mb-1">
                        {{ $job->title }}
                    </a>
                    <div class="flex items-center justify-between mt-2">
                        <span class="text-xs text-slate-500"><i class="fas fa-map-marker-alt mr-1"></i> {{ \Illuminate\Support\Str::limit($job->location, 20) }}</span>
                        <div class="flex items-center text-xs font-medium text-slate-700 bg-slate-100 px-2 py-1 rounded-md">
                            <i class="fas fa-user-friends mr-1.5 text-slate-400"></i> {{ $job->applications_count }}
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-slate-500">
                    <p>Belum ada lowongan aktif.</p>
                </div>
                @endforelse
            </div>
             <div class="p-4 bg-slate-50 rounded-b-xl border-t border-slate-100 text-center">
                <button onclick="window.location.href='{{ route('admin.jobs.create') }}'" class="w-full py-2 bg-white border border-slate-300 text-slate-700 font-medium rounded-lg hover:bg-slate-50 transition-colors shadow-sm text-sm">
                    <i class="fas fa-plus mr-2 text-slate-400"></i> Buat Lowongan Baru
                </button>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('statusDistributionChart').getContext('2d');
            const statusData = JSON.parse('<?php echo json_encode($status_distribution); ?>');

            // Custom Chart Colors (Professional Palette)
            const colors = {
                bg: ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ef4444', '#64748b'], // Blue, Emerald, Amber, Violet, Red, Slate
            };

            new Chart(ctx, {
                type: 'bar', // Changed to bar for cleaner professional look
                data: {
                    labels: Object.keys(statusData),
                    datasets: [{
                        label: 'Jumlah Pelamar',
                        data: Object.values(statusData),
                        backgroundColor: colors.bg,
                        borderRadius: 6,
                        barThickness: 40,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }, // Hide legend for cleaner look
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 12,
                            titleFont: { size: 13 },
                            bodyFont: { size: 14 },
                            cornerRadius: 8,
                            displayColors: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderDash: [2, 2],
                                color: '#e2e8f0'
                            },
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        });
    </script>
@endsection
