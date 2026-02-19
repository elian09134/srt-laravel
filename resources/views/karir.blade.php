<x-app-layout>
    <main>
        <!-- =================================================================== -->
        <!-- HERO SECTION HALAMAN KARIR -->
        <!-- =================================================================== -->
        <section class="relative bg-gradient-to-br from-blue-50 via-white to-blue-50 text-center py-20 overflow-hidden">
            <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
            <div class="container mx-auto px-6 relative z-10">
                <div class="inline-block px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold mb-6">
                    🚀 Karir & Peluang
                </div>
                <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">Temukan Karir Impian Anda</h1>
                <p class="mt-6 text-lg text-gray-600 max-w-2xl mx-auto">Jadilah bagian dari tim kami yang inovatif dan bertalenta. Lihat lowongan yang tersedia di bawah ini.</p>
            </div>
        </section>

        <!-- =================================================================== -->
        <!-- DAFTAR SEMUA LOWONGAN -->
        <!-- =================================================================== -->
        <section id="all-jobs" class="py-20 md:py-24">
            <div class="container mx-auto px-6">
                <!-- Filter -->
                <form action="{{ route('karir') }}" method="GET" class="mb-12 bg-white rounded-2xl shadow-md border border-gray-100 p-6">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Cari posisi..." class="flex-grow px-5 py-3 border border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        <select name="location" class="px-5 py-3 border border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="all">Semua Lokasi</option>
                            @foreach($locations as $location)
                                <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>
                                    {{ $location }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="px-8 py-3 font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 hover:shadow-lg">Cari</button>
                    </div>
                </form>

                <!-- Grid Lowongan -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($jobs as $job)
                        <div class="group bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 overflow-hidden hover:shadow-2xl hover:shadow-slate-200/50 dark:hover:shadow-none transition-all duration-300">
                            {{-- Header Image / Fallback --}}
                            @if($job->show_image && $job->image)
                                <div class="relative aspect-video overflow-hidden">
                                    <img alt="{{ $job->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ Storage::url($job->image) }}" />
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                                    <span class="absolute top-4 left-4 px-3 py-1 bg-primary text-white text-[10px] font-bold uppercase rounded-md shadow-lg backdrop-blur-sm bg-opacity-90">{{ $job->division ?? 'Umum' }}</span>
                                    <span class="absolute bottom-4 right-4 px-3 py-1 bg-white/90 backdrop-blur-sm text-primary text-[10px] font-bold uppercase rounded-md shadow-sm">{{ $job->type }}</span>
                                </div>
                            @else
                                <div class="bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-900 aspect-[3/1] relative overflow-hidden">
                                     <div class="absolute inset-0 opacity-10">
                                         <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                                             <path d="M0 100 L100 0 L100 100 Z" fill="currentColor"></path>
                                         </svg>
                                     </div>
                                     <span class="absolute top-4 left-4 px-3 py-1 bg-primary text-white text-[10px] font-bold uppercase rounded-md shadow-lg">{{ $job->division ?? 'Umum' }}</span>
                                     <span class="absolute bottom-4 right-4 px-3 py-1 bg-slate-400/20 backdrop-blur-sm text-slate-600 dark:text-slate-300 text-[10px] font-bold uppercase rounded-md">{{ $job->type }}</span>
                                </div>
                            @endif
                            
                            <div class="p-6 flex flex-col gap-5">
                                <div>
                                    <h3 class="text-xl font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors line-clamp-2 min-h-[3.5rem]">{{ $job->title }}</h3>
                                    <div class="flex items-center gap-2 mt-3 text-slate-500 dark:text-slate-400 text-sm font-medium">
                                        <span class="material-symbols-outlined text-lg text-primary/70">location_on</span>
                                        {{ $job->location }}
                                    </div>
                                </div>
                                
                                @if($job->salary_range)
                                <div class="flex items-center justify-between py-4 border-y border-slate-50 dark:border-slate-800">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-2 py-1 bg-slate-50 dark:bg-slate-800/50 rounded-md">Expected Range</span>
                                    <span class="text-sm font-black text-slate-900 dark:text-white">{{ $job->salary_range }}</span>
                                </div>
                                @endif

                                <div class="flex items-center gap-3">
                                    <a href="{{ route('karir.show', $job->id) }}" class="flex-1 py-3.5 bg-primary/10 text-primary font-bold rounded-xl group-hover:bg-primary group-hover:text-white transition-all text-center text-sm shadow-sm group-hover:shadow-primary/20">
                                        Lihat Detail
                                    </a>
                                    <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-400 group-hover:text-primary transition-colors shadow-sm">
                                        <span class="material-symbols-outlined">trending_flat</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-20 text-center bg-slate-50 rounded-3xl border-2 border-dashed border-slate-100">
                            <div class="w-20 h-20 bg-white rounded-2xl flex items-center justify-center text-slate-200 text-3xl mx-auto mb-6 shadow-sm">
                                <span class="material-symbols-outlined text-4xl">search_off</span>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 mb-2">Pencarian Tidak Ditemukan</h3>
                            <p class="text-slate-500 text-sm max-w-xs mx-auto mb-8">Maaf, kami tidak menemukan lowongan yang sesuai dengan kata kunci atau lokasi tersebut.</p>
                            <a href="{{ route('karir') }}" class="px-8 py-3 bg-white text-primary font-bold rounded-xl border border-primary/20 hover:bg-primary hover:text-white transition-all shadow-sm">Reset Filter</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </main>
</x-app-layout>
