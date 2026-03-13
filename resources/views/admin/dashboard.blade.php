@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <!-- Dashboard Header Area -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">
                Selamat Datang, {{ auth()->user()->name }} 👋
            </h1>
            <p class="text-sm font-medium text-slate-500 mt-1">
                Berikut adalah ringkasan aktivitas rekrutmen hingga hari ini: <span class="font-bold text-slate-700">{{ now()->translatedFormat('d F Y') }}</span>
            </p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="window.location.reload()" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 transition-colors shadow-sm text-sm font-bold flex items-center group">
                <i class="fas fa-sync-alt mr-2 text-slate-400 group-hover:rotate-180 transition-transform duration-500"></i> Segarkan Data
            </button>
            <a href="{{ route('admin.jobs.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors shadow-md shadow-blue-500/30 text-sm font-bold flex items-center">
                <i class="fas fa-plus mr-2"></i> Lowongan Baru
            </a>
        </div>
    </div>

    <!-- Stats Grid (Flowbite Style Cards) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Stat Card 1: Total Pelamar -->
        <div class="relative bg-white rounded-2xl shadow-sm border border-slate-100 p-6 overflow-hidden group hover:border-blue-200 transition-colors">
            <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-br from-blue-50 to-blue-100 rounded-bl-full -mr-4 -mt-4 z-0 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center text-white text-xl shadow-md shadow-blue-500/30">
                        <i class="fas fa-users"></i>
                    </div>
                    <span class="bg-green-100 text-green-700 text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-lg flex items-center">
                        <i class="fas fa-arrow-up mr-1"></i> 12%
                    </span>
                </div>
                <div>
                    <h3 class="text-3xl font-black text-slate-800 tracking-tight mb-1">{{ number_format($total_applicants) }}</h3>
                    <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">Total Pelamar</p>
                </div>
            </div>
        </div>

        <!-- Stat Card 2: Lowongan Aktif -->
        <div class="relative bg-white rounded-2xl shadow-sm border border-slate-100 p-6 overflow-hidden group hover:border-emerald-200 transition-colors">
            <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-bl-full -mr-4 -mt-4 z-0 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center text-white text-xl shadow-md shadow-emerald-500/30">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <span class="bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-lg flex items-center border border-emerald-100">
                        Aktif
                    </span>
                </div>
                <div>
                    <h3 class="text-3xl font-black text-slate-800 tracking-tight mb-1">{{ number_format($total_jobs) }}</h3>
                    <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">Lowongan Tersedia</p>
                </div>
            </div>
        </div>

        <!-- Stat Card 3: Talent Pool -->
        <div class="relative bg-white rounded-2xl shadow-sm border border-slate-100 p-6 overflow-hidden group hover:border-purple-200 transition-colors">
            <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-br from-purple-50 to-purple-100 rounded-bl-full -mr-4 -mt-4 z-0 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center text-white text-xl shadow-md shadow-purple-500/30">
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="bg-slate-50 text-slate-500 text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-lg flex items-center border border-slate-100">
                        Tersimpan
                    </span>
                </div>
                <div>
                    <h3 class="text-3xl font-black text-slate-800 tracking-tight mb-1">{{ number_format($total_talent_pool) }}</h3>
                    <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">Talent Pool</p>
                </div>
            </div>
        </div>

        <!-- Stat Card 4: Pending FPTK -->
        @php $pendingFptk = \App\Models\Fptk::where('status', 'pending')->count(); @endphp
        <div class="relative bg-white rounded-2xl shadow-sm border border-slate-100 p-6 overflow-hidden group hover:border-amber-200 transition-colors">
            <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-br from-amber-50 to-amber-100 rounded-bl-full -mr-4 -mt-4 z-0 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center text-white text-xl shadow-md shadow-amber-500/30">
                        <i class="fas fa-file-contract"></i>
                    </div>
                     @if($pendingFptk > 0)
                        <span class="bg-red-100 text-red-600 text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-lg flex items-center border border-red-200 animate-pulse">
                            Butuh Aksi
                        </span>
                    @else
                        <span class="bg-slate-50 text-slate-400 text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-lg border border-slate-100">
                            Aman
                        </span>
                    @endif
                </div>
                <div>
                    <h3 class="text-3xl font-black text-slate-800 tracking-tight mb-1">{{ $pendingFptk }}</h3>
                    <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">Pending FPTK</p>
                </div>
            </div>
        </div>
    </div>

    <!-- AI Smart Candidate Filter Section -->
    <div class="mb-8" x-data="smartFilter()">
        <div class="bg-gradient-to-r from-slate-900 to-slate-800 rounded-2xl shadow-lg border border-slate-700 overflow-hidden relative">
            <!-- Decorative background elements -->
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
            
            <div class="p-6 md:p-8 relative z-10">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-robot text-purple-400 text-xl animate-pulse"></i>
                            <h2 class="text-xl font-black text-white tracking-tight">AI Smart Candidate Matcher</h2>
                        </div>
                        <p class="text-sm font-medium text-slate-400">Pilih lowongan spesifik dan biarkan Groq Llama AI menyeleksi 5 kandidat paling cocok secara instan berdasarkan keahlian dan pengalaman.</p>
                        
                        <div class="mt-6 flex flex-col sm:flex-row gap-4">
                            <div class="flex-1">
                                <label for="job_select" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Pilih Lowongan Aktif</label>
                                <select id="job_select" x-model="selectedJobId" class="bg-slate-800 border-slate-600 text-white text-sm font-semibold rounded-xl focus:ring-purple-500 focus:border-purple-500 block w-full px-4 py-3 cursor-pointer transition-colors shadow-inner">
                                    <option value="">-- Pilih Lowongan --</option>
                                    @foreach($active_jobs as $job)
                                        <option value="{{ $job->id }}">{{ $job->title }} ({{ $job->applications_count }} Pelamar)</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="sm:self-end">
                                <button @click="analyze()" :disabled="!selectedJobId || isLoading" 
                                    class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-bold rounded-xl hover:from-purple-500 hover:to-blue-500 transition-all shadow-lg shadow-purple-500/30 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                                    <span x-show="!isLoading"><i class="fas fa-magic"></i> Analisis Sekarang</span>
                                    <span x-show="isLoading" x-cloak><i class="fas fa-spinner fa-spin"></i> AI Sedang Berpikir...</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Validation Error Alert -->
            <div x-show="error" x-cloak class="px-6 md:px-8 pb-6 relative z-10">
                <div class="bg-red-500/10 border border-red-500/20 rounded-xl p-4 flex items-start">
                    <i class="fas fa-exclamation-circle text-red-400 mt-0.5 mr-3"></i>
                    <div>
                        <h4 class="text-sm font-bold text-red-400">Terjadi Kesalahan</h4>
                        <p class="text-xs text-red-300 mt-1" x-text="error"></p>
                    </div>
                </div>
            </div>

            <!-- Loading Skeleton -->
            <div x-show="isLoading" x-cloak class="border-t border-slate-700/50 bg-slate-800/50 p-6 md:p-8 relative z-10">
                <div class="animate-pulse flex items-center gap-3 mb-6">
                    <div class="h-4 w-4 bg-purple-500/50 rounded-full"></div>
                    <div class="h-4 w-48 bg-slate-700 rounded-full"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    <template x-for="i in 3">
                        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700">
                            <div class="flex gap-4">
                                <div class="w-12 h-12 bg-slate-700 rounded-full shrink-0"></div>
                                <div class="flex-1 py-1">
                                    <div class="h-3 bg-slate-700 rounded w-3/4 mb-3"></div>
                                    <div class="h-2 bg-slate-700 rounded w-1/2 mb-4"></div>
                                    <div class="h-16 bg-slate-700 rounded w-full"></div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Results Area -->
            <div x-show="results.length > 0 && !isLoading" x-cloak class="border-t border-slate-700/50 bg-slate-800/80 p-6 md:p-8 relative z-10">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-sm font-bold text-slate-300 uppercase tracking-widest"><i class="fas fa-trophy text-yellow-400 mr-2"></i> Top Kandidat Rekomendasi AI</h3>
                    <span class="text-xs text-slate-500 font-medium hidden sm:block">Berdasarkan data profil vs standar <span x-text="jobTitle" class="text-white font-bold"></span></span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    <template x-for="(candidate, index) in results" :key="candidate.user_id">
                        <div class="bg-slate-900 rounded-xl p-5 border border-slate-700 relative overflow-hidden group hover:border-purple-500/50 transition-colors">
                            <div class="absolute top-0 right-0 w-1 h-full bg-slate-700 group-hover:bg-purple-500 transition-colors"></div>
                            <div class="flex gap-4">
                                <div class="w-12 h-12 rounded-full overflow-hidden shrink-0 border-2 border-slate-700 bg-slate-800">
                                    <template x-if="candidate.photo">
                                        <img :src="candidate.photo" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!candidate.photo">
                                        <div class="w-full h-full flex items-center justify-center text-slate-500 font-bold text-lg" x-text="candidate.name.charAt(0)"></div>
                                    </template>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start mb-1">
                                        <h4 class="text-base font-bold text-white truncate pr-2" x-text="candidate.name"></h4>
                                        <span class="shrink-0 inline-flex items-center px-2 py-0.5 rounded text-[10px] font-black"
                                            :class="candidate.match_score >= 80 ? 'bg-green-500/20 text-green-400 border border-green-500/30' : (candidate.match_score >= 50 ? 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30')">
                                            <i class="fas fa-fire mr-1" x-show="candidate.match_score >= 80"></i>
                                            <span x-text="candidate.match_score + '% Fit'"></span>
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-400 font-medium mb-3 truncate"><i class="fas fa-briefcase opacity-50 mr-1"></i> <span x-text="candidate.last_position"></span></p>
                                    
                                    <div class="bg-slate-800 rounded-lg p-3 border border-slate-700/50 mb-3">
                                        <div class="flex items-start gap-2">
                                            <i class="fas fa-quote-left text-slate-600 text-[10px] mt-0.5"></i>
                                            <p class="text-xs text-slate-300 leading-relaxed italic" x-text="candidate.reasoning"></p>
                                        </div>
                                    </div>

                                    <a :href="'/admin/applicants/' + candidate.user_id" class="block text-center w-full py-2 bg-slate-800 hover:bg-slate-700 border border-slate-600 font-semibold text-xs text-white rounded-lg transition-colors">
                                        Lihat Detail Profil
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Rank Badge -->
                            <div class="absolute -top-3 -left-3 w-10 h-10 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-full flex items-center justify-center shadow-lg border-2 border-slate-900 z-10">
                                <span class="text-white font-black text-xs" x-text="'#' + (index + 1)"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area: Chart & List -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column: Chart Area (Flowbite Design) -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col">
            <div class="px-6 py-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/50">
                <div>
                    <h3 class="text-lg font-black text-slate-800">Distribusi Status Lamaran</h3>
                    <p class="text-xs font-semibold text-slate-400 mt-1">Lacak rasio perbandingan status dari semua pelamar</p>
                </div>
                
                <!-- Flowbite-style dropdown trigger wrapper -->
                <div class="relative">
                    <select class="appearance-none bg-white border border-slate-200 text-slate-700 text-sm font-bold rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5 pr-8 shadow-sm hover:bg-slate-50 cursor-pointer transition-colors">
                        <option value="month">Laporan Bulan Ini</option>
                        <option value="year">Laporan Tahun Ini</option>
                        <option value="all">Semua Waktu</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>
            
            <div class="p-6 flex-1 w-full relative min-h-[350px]">
                <canvas id="statusDistributionChart" class="absolute inset-6 w-[calc(100%-3rem)] h-[calc(100%-3rem)]"></canvas>
            </div>
        </div>

        <!-- Right Column: Active Jobs List (Flowbite Clean List Component) -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h3 class="text-lg font-black text-slate-800">Lowongan Aktif Populer</h3>
                    <p class="text-xs font-semibold text-slate-400 mt-1">Berdasarkan data pelamar terbanyak</p>
                </div>
                <a href="{{ route('admin.jobs.index') }}" class="text-sm font-bold text-blue-600 hover:text-blue-700 hover:underline transition-all">
                    Lihat Semua
                </a>
            </div>
            
            <div class="flex-1 overflow-y-auto max-h-[450px]">
                <ul class="divide-y divide-slate-100">
                    @forelse($active_jobs as $job)
                        <li class="p-5 hover:bg-slate-50 transition-colors group cursor-pointer" onclick="window.location.href='{{ route('admin.jobs.show', $job->id) }}'">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="text-sm font-black text-slate-800 group-hover:text-blue-600 transition-colors line-clamp-1 pr-4">
                                    {{ $job->title }}
                                </h4>
                                <span class="shrink-0 text-[10px] font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap">
                                    {{ $job->created_at->diffForHumans() }}
                                </span>
                            </div>
                            
                            <div class="flex items-center gap-3 mb-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-black border uppercase tracking-widest
                                    {{ $job->type === 'Full Time' ? 'bg-indigo-50 text-indigo-600 border-indigo-100' : 
                                      ($job->type === 'Part Time' ? 'bg-amber-50 text-amber-600 border-amber-100' : 'bg-blue-50 text-blue-600 border-blue-100') }}">
                                    {{ $job->type }}
                                </span>
                                <span class="text-xs font-semibold text-slate-500 flex items-center truncate">
                                    <i class="fas fa-map-marker-alt text-slate-400 mr-1.5 w-3 text-center"></i>
                                    {{ \Illuminate\Support\Str::limit($job->location, 20) }}
                                </span>
                            </div>

                            <!-- Flowbite Progress Bar Style for Applications -->
                            <div class="flex items-center justify-between mt-2">
                                <div class="text-xs font-bold text-slate-600 flex items-center">
                                    <div class="w-6 h-6 rounded-full bg-slate-100 border border-white flex items-center justify-center text-slate-400 mr-2 -ml-1 text-[10px]">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    {{ $job->applications_count }} Pelamar
                                </div>
                                <div class="w-24 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                     @php
                                        // Fake progress bar purely for aesthetic visual context based on count
                                        $percentage = min(100, max(5, ($job->applications_count / 50) * 100));
                                        $color = $percentage > 80 ? 'bg-emerald-500' : ($percentage > 30 ? 'bg-blue-500' : 'bg-slate-300');
                                     @endphp
                                    <div class="h-full {{ $color }} rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="p-10 text-center flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-4 text-2xl border border-dashed border-slate-200">
                                <i class="fas fa-folder-open"></i>
                            </div>
                            <h5 class="text-sm font-black text-slate-700 mb-1">Tidak Ada Lowongan Aktif</h5>
                            <p class="text-xs text-slate-500">Buat lowongan pekerjaan baru untuk mulai menerima pelamar.</p>
                            <a href="{{ route('admin.jobs.create') }}" class="mt-4 px-4 py-2 bg-slate-900 text-white text-xs font-bold rounded-lg hover:bg-slate-800 transition-colors">
                                Buat Lowongan
                            </a>
                        </li>
                    @endforelse
                </ul>
            </div>
            
            @if($active_jobs->count() > 0)
            <div class="p-4 bg-slate-50 border-t border-slate-100 text-center rounded-b-2xl">
                <a href="{{ route('admin.jobs.index') }}" class="text-xs font-bold text-slate-600 hover:text-blue-600 uppercase tracking-widest transition-colors flex items-center justify-center group">
                    Kelola Semua Lowongan <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Alpine.js Smart Filter Component Details -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('smartFilter', () => ({
                selectedJobId: '',
                isLoading: false,
                results: [],
                jobTitle: '',
                error: null,

                async analyze() {
                    if (!this.selectedJobId) return;
                    
                    this.isLoading = true;
                    this.error = null;
                    this.results = [];
                    
                    try {
                        const response = await fetch('/admin/api/smart-filter', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                job_id: this.selectedJobId
                            })
                        });
                        
                        const data = await response.json();
                        
                        if (data.success) {
                            this.results = data.candidates;
                            this.jobTitle = data.job_title;
                        } else {
                            this.error = data.message || 'Terjadi kesalahan saat parsing data AI.';
                        }
                    } catch (err) {
                        this.error = 'Gagal terhubung ke server/API Groq. Pastikan koneksi internet stabil.';
                        console.error(err);
                    } finally {
                        this.isLoading = false;
                    }
                }
            }));
        });
    </script>

    <!-- Chart.js Configuration -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('statusDistributionChart').getContext('2d');
            const rawData = JSON.parse('<?php echo json_encode($status_distribution); ?>');

            // Flowbite/Tailwind Premium Color Palette
            const brandColors = [
                '#3b82f6', // blue-500 (Baru)
                '#8b5cf6', // violet-500 (Tahap Lanjut)
                '#10b981', // emerald-500 (Diterima)
                '#f59e0b', // amber-500 (Shortlist)
                '#ef4444', // red-500 (Ditolak)
                '#64748b'  // slate-500 (Lainnya)
            ];

            const chart = new Chart(ctx, {
                type: 'bar', // Bar charts look more professional in modern dashboards
                data: {
                    labels: Object.keys(rawData),
                    datasets: [{
                        label: 'Total Kandidat',
                        data: Object.values(rawData),
                        backgroundColor: brandColors,
                        borderRadius: 8, // Rounded bars for Flowbite aesthetic
                        borderSkipped: false,
                        barThickness: 32, // Sleek, slightly thinner bars
                        hoverBackgroundColor: brandColors.map(color => color + 'E6') // Slightly transparent on hover
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { 
                            display: false // Hide default legend
                        }, 
                        tooltip: {
                            backgroundColor: '#1e293b', // slate-800
                            titleColor: '#f1f5f9', // slate-100
                            bodyColor: '#cbd5e1', // slate-300
                            padding: 12,
                            titleFont: { size: 13, family: "'Inter', sans-serif", weight: 'bold' },
                            bodyFont: { size: 14, family: "'Inter', sans-serif" },
                            cornerRadius: 12,
                            displayColors: true,
                            boxPadding: 4,
                            usePointStyle: true,
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
                            grid: {
                                color: '#f1f5f9', // slate-100
                                drawTicks: false,
                            },
                            ticks: {
                                color: '#94a3b8', // slate-400
                                font: { family: "'Inter', sans-serif", size: 11, weight: '600' },
                                padding: 10
                            }
                        },
                        x: {
                            border: { display: false },
                            grid: { display: false },
                            ticks: {
                                color: '#64748b', // slate-500
                                font: { family: "'Inter', sans-serif", size: 11, weight: 'bold' },
                                padding: 10
                            }
                        }
                    },
                    animation: {
                        y: {
                            duration: 1000,
                            easing: 'easeOutQuart'
                        }
                    }
                }
            });
        });
    </script>
@endsection
