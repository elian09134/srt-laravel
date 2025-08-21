<x-app-layout>
    <main>
        <!-- =================================================================== -->
        <!-- HERO SECTION -->
        <!-- =================================================================== -->
        <section id="home" class="bg-gradient-to-br from-[#0F4C81] to-[#1A2238] text-white">
            <div class="container mx-auto px-6 py-20 md:py-24 flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 text-center md:text-left">
                    <h1 class="text-4xl md:text-5xl font-extrabold leading-tight">
                        {{ $content['hero']['title'] ?? 'Judul Default' }}
                    </h1>
                    <p class="mt-4 text-lg text-gray-300 max-w-lg mx-auto md:mx-0">
                        {{ $content['hero']['description'] ?? 'Deskripsi default.' }}
                    </p>
                    <div class="mt-8 flex justify-center md:justify-start space-x-4">
                        <a href="/karir" class="px-8 py-3 font-semibold text-white bg-srt-orange rounded-md hover:bg-srt-orange-dark transform transition-transform duration-300 hover:scale-105 shadow-lg">Lihat Lowongan</a>
                        <a href="#about-us" class="px-8 py-3 font-semibold text-gray-800 bg-white rounded-md hover:bg-gray-100 transform transition-transform duration-300 hover:scale-105 shadow-lg">Tentang Kami</a>
                    </div>
                </div>
                <div class="md:w-1/2 mt-12 md:mt-0 flex justify-center">
                    <img src="{{ asset('storage/' . ($content['hero']['image'] ?? '')) }}" alt="Tim SRT Corp" class="rounded-lg shadow-2xl w-full max-w-md lg:max-w-lg object-cover">
                </div>
            </div>
        </section>

        <!-- =================================================================== -->
        <!-- DEPARTEMEN HR SECTION -->
        <!-- =================================================================== -->
        <section id="department-hr" class="py-20 md:py-24 bg-white">
            <div class="container mx-auto px-6">
                <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
                    <div class="lg:w-1/2">
                        <img src="{{ asset('storage/' . ($content['hr_department']['image'] ?? '')) }}" alt="Diskusi tim HR" class="rounded-lg shadow-2xl w-full object-cover">
                    </div>
                    <div class="lg:w-1/2">
                        <h2 class="text-3xl font-bold text-gray-900">{{ $content['hr_department']['title'] ?? 'Judul Default' }}</h2>
                        <p class="mt-4 text-gray-600">{{ $content['hr_department']['description'] ?? 'Deskripsi default.' }}</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- =================================================================== -->
        <!-- TENTANG SRT CORP SECTION -->
        <!-- =================================================================== -->
        <section id="about-us" class="py-20 md:py-24 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-gray-900">{{ $content['about_us']['title'] ?? 'Sekilas Tentang Kami' }}</h2>
                    <p class="mt-4 max-w-2xl mx-auto text-gray-600">{{ $content['about_us']['description'] ?? '' }}</p>
                </div>
                <div class="mt-12 flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
                    <div class="lg:w-5/12">
                        <img src="{{ asset('storage/' . ($content['about_us']['image'] ?? '')) }}" alt="Gedung kantor SRT Corp" class="rounded-lg shadow-2xl w-full">
                    </div>
                    <div class="lg:w-7/12">
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800">{{ $content['about_us']['history_title'] ?? 'Sejarah Singkat' }}</h3>
                                <p class="mt-2 text-gray-600">{{ $content['about_us']['history_text'] ?? 'Teks default.' }}</p>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800">{{ $content['about_us']['vision_title'] ?? 'Visi' }}</h3>
                                <p class="mt-2 text-gray-600">{{ $content['about_us']['vision_text'] ?? 'Teks default.' }}</p>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800">{{ $content['about_us']['mission_title'] ?? 'Misi' }}</h3>
                                <ul class="mt-2 list-disc list-inside text-gray-600 space-y-2">
                                    @foreach (json_decode($content['about_us']['mission_text'] ?? '[]') as $mission)
                                        <li>{{ $mission }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- =================================================================== -->
        <!-- LINGKUP BISNIS SECTION -->
        <!-- =================================================================== -->
        <section id="business-scope" class="py-20 md:py-24 bg-slate-50">
            <div class="container mx-auto px-6">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-gray-900">{{ $content['business_scope']['title'] ?? 'Judul Default' }}</h2>
                    <p class="mt-4 max-w-2xl mx-auto text-gray-600">{{ $content['business_scope']['description'] ?? 'Deskripsi default.' }}</p>
                </div>
                <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Kartu 1 -->
                    <div class="bg-white p-8 rounded-lg shadow-lg text-center transition-all duration-300 hover:shadow-2xl hover:-translate-y-2">
                        <div class="inline-block p-4 bg-blue-100 rounded-full"><i class="fas fa-code text-3xl text-blue-600"></i></div>
                        <h3 class="mt-6 text-xl font-bold text-gray-900">{{ $content['business_scope']['card1_title'] ?? 'Judul Default' }}</h3>
                        <p class="mt-2 text-gray-600">{{ $content['business_scope']['card1_desc'] ?? 'Deskripsi default.' }}</p>
                        <ul class="mt-6 text-left space-y-2">
                            @foreach (json_decode($content['business_scope']['card1_list'] ?? '[]') as $item)
                                <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-3"></i>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Kartu 2 -->
                    <div class="bg-white p-8 rounded-lg shadow-lg text-center transition-all duration-300 hover:shadow-2xl hover:-translate-y-2">
                        <div class="inline-block p-4 bg-blue-100 rounded-full"><i class="fas fa-chart-pie text-3xl text-blue-600"></i></div>
                        <h3 class="mt-6 text-xl font-bold text-gray-900">{{ $content['business_scope']['card2_title'] ?? 'Judul Default' }}</h3>
                        <p class="mt-2 text-gray-600">{{ $content['business_scope']['card2_desc'] ?? 'Deskripsi default.' }}</p>
                        <ul class="mt-6 text-left space-y-2">
                            @foreach (json_decode($content['business_scope']['card2_list'] ?? '[]') as $item)
                                <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-3"></i>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Kartu 3 -->
                    <div class="bg-white p-8 rounded-lg shadow-lg text-center transition-all duration-300 hover:shadow-2xl hover:-translate-y-2">
                        <div class="inline-block p-4 bg-blue-100 rounded-full"><i class="fas fa-bullhorn text-3xl text-blue-600"></i></div>
                        <h3 class="mt-6 text-xl font-bold text-gray-900">{{ $content['business_scope']['card3_title'] ?? 'Judul Default' }}</h3>
                        <p class="mt-2 text-gray-600">{{ $content['business_scope']['card3_desc'] ?? 'Deskripsi default.' }}</p>
                        <ul class="mt-6 text-left space-y-2">
                            @foreach (json_decode($content['business_scope']['card3_list'] ?? '[]') as $item)
                                <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-3"></i>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- =================================================================== -->
        <!-- LOWONGAN TERBARU SECTION -->
        <!-- =================================================================== -->
        <section id="latest-jobs" class="py-20 md:py-24 bg-slate-50">
            <div class="container mx-auto px-6">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-gray-900">Lowongan Terbaru</h2>
                    <p class="mt-4 max-w-2xl mx-auto text-gray-600">Bergabunglah dengan tim kami dan jadilah bagian dari perjalanan menuju kesuksesan bersama SRT Corp.</p>
                </div>
                <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
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
                        <p class="col-span-3 text-center text-gray-500">Saat ini belum ada lowongan yang tersedia.</p>
                    @endforelse
                </div>
                <div class="text-center mt-16">
                    <a href="/karir" class="px-8 py-3 font-semibold text-white bg-[#0F4C81] rounded-md hover:bg-[#1A2238] transition-colors">
                        Lihat Semua Lowongan <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </section>
        <!-- =================================================================== -->
        <!-- GALERI PERUSAHAAN SECTION -->
        <!-- =================================================================== -->
        <section id="gallery" class="py-20 md:py-24 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-gray-900">{{ $content['gallery']['title'] ?? 'Galeri Perusahaan' }}</h2>
                    <p class="mt-4 max-w-2xl mx-auto text-gray-600">{{ $content['gallery']['description'] ?? 'Deskripsi default galeri.' }}</p>
                </div>
                <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($gallery as $img)
                        <img src="{{ asset('storage/' . $img->file_path) }}" alt="{{ $img->alt_text }}" class="w-full h-64 object-cover rounded-lg shadow-md transition-transform duration-300 hover:scale-105">
                    @empty
                        <p class="col-span-full text-center text-gray-500">Galeri masih kosong.</p>
                    @endforelse
                </div>
            </div>
        </section>
    </main>
</x-app-layout>
