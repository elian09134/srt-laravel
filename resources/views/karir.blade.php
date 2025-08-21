<x-app-layout>
    <main>
        <!-- =================================================================== -->
        <!-- HERO SECTION HALAMAN KARIR -->
        <!-- =================================================================== -->
        <section class="bg-gradient-to-br from-[#0F4C81] to-[#1A2238] text-white text-center py-20">
            <div class="container mx-auto px-6">
                <h1 class="text-4xl md:text-5xl font-extrabold">Temukan Karir Impian Anda</h1>
                <p class="mt-4 text-lg text-blue-200 max-w-2xl mx-auto">Jadilah bagian dari tim kami yang inovatif dan bertalenta. Lihat lowongan yang tersedia di bawah ini.</p>
            </div>
        </section>

        <!-- =================================================================== -->
        <!-- DAFTAR SEMUA LOWONGAN -->
        <!-- =================================================================== -->
        <section id="all-jobs" class="py-20 md:py-24">
            <div class="container mx-auto px-6">
                <!-- Filter -->
                <form action="{{ route('karir') }}" method="GET" class="mb-12 flex flex-col sm:flex-row gap-4">
                    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Cari posisi..." class="flex-grow px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <select name="location" class="px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="all">Semua Lokasi</option>
                        @foreach($locations as $location)
                            <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>
                                {{ $location }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-6 py-3 font-semibold text-white bg-[#0F4C81] rounded-md hover:bg-[#1A2238] transition-colors">Cari</button>
                </form>

                <!-- Grid Lowongan -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($jobs as $job)
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2">
                            <div class="p-4 bg-[#0F4C81] text-white text-sm font-semibold">{{ $job->type }}</div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900">{{ $job->title }}</h3>
                                <p class="text-gray-500 text-sm mt-1">{{ $job->division }}</p>
                                <p class="text-gray-600 text-sm mt-4 flex items-center"><i class="fas fa-map-marker-alt mr-2"></i>{{ $job->location }}</p>
                                @if(!empty($job->salary_range))
                                    <p class="text-gray-600 text-sm mt-2 flex items-center"><i class="fas fa-money-bill-wave mr-2"></i>{{ $job->salary_range }}</p>
                                @endif
                                <a href="#" data-job-id="{{ $job->id }}" class="job-detail-btn mt-6 inline-block font-semibold text-blue-600 hover:text-blue-800 group">
                                    Lihat Detail <i class="fas fa-arrow-right ml-1 transform group-hover:translate-x-1 transition-transform"></i>
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
