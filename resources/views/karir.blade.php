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
                        <div class="group bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-2 hover:border-blue-200">
                            <div class="p-4 bg-gradient-to-r from-blue-500 to-blue-600">
                                <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-sm text-white text-xs font-semibold rounded-full">{{ $job->type }}</span>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $job->title }}</h3>
                                <p class="text-blue-600 text-sm font-medium mt-1">{{ $job->division }}</p>
                                <div class="mt-4 space-y-2">
                                    <p class="text-gray-600 text-sm flex items-center"><i class="fas fa-map-marker-alt mr-2 text-blue-500"></i>{{ $job->location }}</p>
                                    @if(!empty($job->salary_range))
                                        <p class="text-gray-600 text-sm flex items-center"><i class="fas fa-money-bill-wave mr-2 text-blue-500"></i>{{ $job->salary_range }}</p>
                                    @endif
                                </div>
                                <a href="{{ route('karir.show', $job) }}" class="mt-6 inline-flex items-center font-semibold text-blue-600 hover:text-blue-700 group">
                                    Lihat Detail <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="col-span-3 text-center text-gray-500">Tidak ada lowongan yang cocok dengan pencarian Anda.</p>
                    @endforelse
                </div>
            </div>
        </section>
    </main>
</x-app-layout>
