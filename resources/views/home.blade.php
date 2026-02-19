<x-app-layout>
    <main>
        <!-- =================================================================== -->
        <!-- HERO SECTION -->
        <!-- =================================================================== -->
        <section id="home" class="relative bg-white text-slate-900 overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 lg:px-12 py-12 lg:py-20">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <!-- Content Left -->
                    <div class="flex flex-col items-start space-y-8 max-w-xl">
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 border border-primary/20">
                            <span class="text-primary text-sm font-bold">{{ $content['hero']['badge_text'] ?? '✨ Bergabung dengan Tim Terbaik' }}</span>
                        </div>
                        <h1 class="text-5xl lg:text-6xl font-extrabold leading-[1.15] text-slate-900 tracking-tight">
                            {!! $content['hero']['title'] ?? 'Bangun Karir <span class="text-primary">Impian Anda</span> Bersama SRT Corp' !!}
                        </h1>
                        <p class="text-lg text-slate-600 leading-relaxed font-normal">
                            {{ $content['hero']['description'] ?? 'Tempat terbaik untuk mengasah potensi dan membangun masa depan yang solid. Jelajahi peluang karier yang dirancang khusus untuk pertumbuhan profesional Anda.' }}
                        </p>
                        <div class="flex flex-wrap gap-4 w-full sm:w-auto">
                            <a href="/karir" class="flex-1 sm:flex-none px-8 py-4 bg-primary text-white font-bold rounded-lg shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all text-center">
                                {{ $content['hero']['button_text'] ?? 'Lihat Lowongan' }}
                            </a>
                            <a href="#about-us" class="flex-1 sm:flex-none px-8 py-4 bg-white border border-slate-200 text-slate-700 font-bold rounded-lg hover:bg-slate-50 transition-all text-center">
                                Tentang Kami
                            </a>
                        </div>
                        <!-- Stats/Social Proof (Embedded in Hero Grid) -->
                        <div class="pt-8 grid grid-cols-3 gap-6 w-full border-t border-slate-100">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2 text-primary">
                                    <span class="material-symbols-outlined text-xl">groups</span>
                                    <span class="text-2xl font-bold text-slate-900">{{ $content['hero']['stats_employees'] ?? '1000+' }}</span>
                                </div>
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Karyawan</p>
                            </div>
                            <div class="space-y-1 border-x border-slate-100 px-6">
                                <div class="flex items-center gap-2 text-primary">
                                    <span class="material-symbols-outlined text-xl">verified</span>
                                    <span class="text-xl font-bold text-slate-900 leading-none">{{ $content['hero']['stats_security'] ?? 'Terpercaya' }}</span>
                                </div>
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Keamanan</p>
                            </div>
                            <div class="space-y-1">
                                <div class="flex items-center gap-2 text-primary">
                                    <span class="material-symbols-outlined text-xl">public</span>
                                    <span class="text-xl font-bold text-slate-900 leading-none">{{ $content['hero']['stats_global'] ?? 'Global' }}</span>
                                </div>
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Jangkauan</p>
                            </div>
                        </div>
                    </div>
                    <!-- Hero Image Right -->
                    <div class="relative group">
                        <!-- Decorative background element -->
                        <div class="absolute -inset-4 bg-primary/5 rounded-2xl blur-2xl group-hover:bg-primary/10 transition-colors"></div>
                        <div class="relative overflow-hidden rounded-xl aspect-[4/3] shadow-2xl">
                             @php
                                $heroImage = !empty($content['hero']['image']) ? asset('storage/' . $content['hero']['image']) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuDIPs6WZqBK5ndm49ovZKlqcj99hWH-JxeJoNDXz8rxyxaAlJGnAKmE7KNiCyuChrkPPxO89LxDdMofmcIUEyjmzQCmYg78H5WeyPROkyR-dY2vQ31I_Vn53VS1aZBlphSOLdG9hUV3RFpt-ZWVpn9x42mlTh3VfWo5c6Cu3jxPIYCsbpXWfbi9sQi8D1mEkRNUwDh_UxN54jnkFxbuGXv2zA94oS-c27E1zNlBOPmqNBmay-NsVYaCg6AXoIQ7WO_efcvOlHP-kQc';
                            @endphp
                            <div class="w-full h-full bg-slate-200 bg-cover bg-center group-hover:scale-105 transition-transform duration-700" data-alt="Modern collaborative glass office building interior with professional growth vibe" style="background-image: url('{{ $heroImage }}');">
                            </div>
                            <!-- Floating Card Element -->
                            <div class="absolute bottom-6 left-6 right-6 p-4 bg-white/90 backdrop-blur-md rounded-lg border border-white/20 shadow-lg flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined">trending_up</span>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900">{{ $content['hero']['floating_card_title'] ?? 'Pertumbuhan Karir Cepat' }}</p>
                                    <p class="text-xs text-slate-500">{{ $content['hero']['floating_card_desc'] ?? 'Mulai perjalanan profesionalmu hari ini' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- =================================================================== -->
        <!-- SEKSI DEPARTEMEN HR -->
        <!-- =================================================================== -->
        <section id="hr-department" class="py-20 md:py-24 bg-white reveal" data-reveal>
            <div class="container mx-auto px-6">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-gray-900">{{ $content['hr_department']['team_title'] ?? $content['hr_department']['title'] ?? 'Meet Our Team' }}</h2>
                    <p class="mt-4 max-w-2xl mx-auto text-gray-600">{{ $content['hr_department']['description'] ?? '' }}</p>
                </div>
                <div class="mt-12">
                    <div class="w-full">
                        @php
                            $membersJson = $content['hr_department']['members'] ?? null;
                            try {
                                $members = (is_array($membersJson) ? $membersJson : json_decode($membersJson, true)) ?: [];
                            } catch (\Throwable $e) {
                                $members = [];
                            }
                        @endphp

                        @if(!empty($members))
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                                @foreach($members as $member)
                                    @php
                                        $photo = $member['photo'] ?? null;
                                        $photoUrl = $photo ? asset('storage/' . ltrim($photo, '/')) : asset('images/avatar-placeholder.png');
                                        $bio = $member['bio'] ?? '';
                                        $email = $member['email'] ?? '';
                                        $phone = $member['phone'] ?? '';
                                        $social = $member['social'] ?? [];
                                    @endphp
                                    <div class="group relative bg-gradient-to-br from-white via-blue-50/30 to-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden h-80 border border-blue-100/50">
                                        <!-- Decorative Elements -->
                                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-400/10 to-transparent rounded-bl-full"></div>
                                        <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-blue-400/10 to-transparent rounded-tr-full"></div>
                                        
                                        <!-- Front Card -->
                                        <div class="absolute inset-0 p-6 flex flex-col justify-center items-center text-center transition-opacity duration-300 group-hover:opacity-0">
                                            <div class="mx-auto w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-xl mb-4 ring-2 ring-blue-200/50">
                                                <img src="{{ $photoUrl }}" alt="{{ $member['name'] ?? 'Team' }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                                            </div>
                                            <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $member['name'] ?? '-' }}</h3>
                                            <p class="text-sm text-blue-600 font-medium">{{ $member['role'] ?? '' }}</p>
                                            <div class="mt-3 w-16 h-1 bg-gradient-to-r from-transparent via-blue-400 to-transparent rounded-full"></div>
                                        </div>
                                        
                                        <!-- Hover Card -->
                                        <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-blue-800 p-6 flex flex-col justify-start items-center text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300 overflow-y-auto">
                                            <div class="w-16 h-16 rounded-full overflow-hidden border-3 border-white mb-3 flex-shrink-0">
                                                <img src="{{ $photoUrl }}" alt="{{ $member['name'] ?? 'Team' }}" class="w-full h-full object-cover">
                                            </div>
                                            <h3 class="text-base font-bold flex-shrink-0">{{ $member['name'] ?? '-' }}</h3>
                                            <p class="text-xs opacity-90 mb-3 flex-shrink-0">{{ $member['role'] ?? '' }}</p>
                                            @if($bio)
                                                <p class="text-xs text-center mb-3 leading-relaxed">{{ $bio }}</p>
                                            @endif
                                            <div class="flex flex-col items-center space-y-1 mb-3 flex-shrink-0">
                                                @if($email)
                                                    <a href="mailto:{{ $email }}" class="text-xs hover:underline break-all">✉ {{ $email }}</a>
                                                @endif
                                                @if($phone)
                                                    <a href="tel:{{ $phone }}" class="text-xs hover:underline">📱 {{ $phone }}</a>
                                                @endif
                                            </div>
                                            @if(!empty($social['linkedin']) || !empty($social['instagram']) || !empty($social['twitter']))
                                                <div class="flex space-x-3 mt-auto pt-3 flex-shrink-0">
                                                    @if(!empty($social['linkedin']))
                                                        <a href="{{ $social['linkedin'] }}" target="_blank" class="text-white hover:text-blue-200 transition-colors">
                                                            <i class="fab fa-linkedin text-xl"></i>
                                                        </a>
                                                    @endif
                                                    @if(!empty($social['instagram']))
                                                        <a href="https://instagram.com/{{ ltrim($social['instagram'], '@') }}" target="_blank" class="text-white hover:text-blue-200 transition-colors">
                                                            <i class="fab fa-instagram text-xl"></i>
                                                        </a>
                                                    @endif
                                                    @if(!empty($social['twitter']))
                                                        <a href="{{ $social['twitter'] }}" target="_blank" class="text-white hover:text-blue-200 transition-colors">
                                                            <i class="fab fa-twitter text-xl"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500">Belum ada data anggota tim. Silakan tambahkan melalui admin panel.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- =================================================================== -->
        <!-- TENTANG TERANG SECTION -->
        <!-- =================================================================== -->
        <section id="about-us" class="py-20 md:py-24 bg-white reveal reveal-stagger" data-reveal>
            <div class="container mx-auto px-6">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-gray-900">{{ $content['about_us']['title'] ?? 'Sekilas Tentang Kami' }}</h2>
                    <p class="mt-4 max-w-2xl mx-auto text-gray-600">{{ $content['about_us']['description'] ?? '' }}</p>
                </div>
                <div class="mt-12 flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
                    <div class="lg:w-5/12">
                        @php
                            $aboutImage = !empty($content['about_us']['image']) ? asset('storage/' . $content['about_us']['image']) : asset('images/office_building.svg');
                        @endphp
                        <img src="{{ $aboutImage }}" alt="Gedung kantor TERANG" class="rounded-lg shadow-2xl w-full">
                    </div>
                    <div class="lg:w-7/12">
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800">{{ $content['about_us']['history_title'] ?? 'Sejarah Singkat' }}</h3>
                                <p class="text-justify mt-2 text-gray-600">{{ $content['about_us']['history_text'] ?? 'Teks default.' }}</p>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800">{{ $content['about_us']['vision_title'] ?? 'Visi' }}</h3>
                                <p class="text-justify mt-2 text-gray-600">{{ $content['about_us']['vision_text'] ?? 'Teks default.' }}</p>
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
        <section id="business-scope" class="py-20 md:py-24 bg-slate-50 reveal" data-reveal>
            <div class="container mx-auto px-6">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-gray-900">{{ $content['business_scope']['title'] ?? 'Scope Bisnis' }}</h2>
                    <p class="mt-4 max-w-2xl mx-auto text-gray-600">{{ $content['business_scope']['description'] ?? 'Lini Bisnis Kami' }}</p>
                </div>
                <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Kartu 1 -->
                    <div class="group bg-white p-8 rounded-2xl shadow-md border border-gray-100 text-center transition-all duration-300 hover:shadow-xl hover:-translate-y-2 hover:border-blue-200">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-code text-2xl text-white"></i>
                        </div>
                        <h3 class="mt-6 text-xl font-bold text-gray-900">{{ $content['business_scope']['card1_title'] ?? 'Judul Default' }}</h3>
                        <p class="mt-3 text-gray-600 text-sm leading-relaxed">{{ $content['business_scope']['card1_desc'] ?? 'Deskripsi default.' }}</p>
                        <ul class="mt-6 text-left space-y-3">
                            @foreach (json_decode($content['business_scope']['card1_list'] ?? '[]') as $item)
                                <li class="flex items-start"><i class="fas fa-check-circle text-blue-500 mr-3 mt-1 flex-shrink-0"></i><span class="text-sm text-gray-600">{{ $item }}</span></li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Kartu 2 -->
                    <div class="group bg-white p-8 rounded-2xl shadow-md border border-gray-100 text-center transition-all duration-300 hover:shadow-xl hover:-translate-y-2 hover:border-blue-200">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-chart-pie text-2xl text-white"></i>
                        </div>
                        <h3 class="mt-6 text-xl font-bold text-gray-900">{{ $content['business_scope']['card2_title'] ?? 'Judul Default' }}</h3>
                        <p class="mt-3 text-gray-600 text-sm leading-relaxed">{{ $content['business_scope']['card2_desc'] ?? 'Deskripsi default.' }}</p>
                        <ul class="mt-6 text-left space-y-3">
                            @foreach (json_decode($content['business_scope']['card2_list'] ?? '[]') as $item)
                                <li class="flex items-start"><i class="fas fa-check-circle text-purple-500 mr-3 mt-1 flex-shrink-0"></i><span class="text-sm text-gray-600">{{ $item }}</span></li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Kartu 3 -->
                    <div class="group bg-white p-8 rounded-2xl shadow-md border border-gray-100 text-center transition-all duration-300 hover:shadow-xl hover:-translate-y-2 hover:border-blue-200">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-2xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-bullhorn text-2xl text-white"></i>
                        </div>
                        <h3 class="mt-6 text-xl font-bold text-gray-900">{{ $content['business_scope']['card3_title'] ?? 'Judul Default' }}</h3>
                        <p class="mt-3 text-gray-600 text-sm leading-relaxed">{{ $content['business_scope']['card3_desc'] ?? 'Deskripsi default.' }}</p>
                        <ul class="mt-6 text-left space-y-3">
                            @foreach (json_decode($content['business_scope']['card3_list'] ?? '[]') as $item)
                                <li class="flex items-start"><i class="fas fa-check-circle text-cyan-500 mr-3 mt-1 flex-shrink-0"></i><span class="text-sm text-gray-600">{{ $item }}</span></li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Kartu 4 -->
                    <div class="group bg-white p-8 rounded-2xl shadow-md border border-gray-100 text-center transition-all duration-300 hover:shadow-xl hover:-translate-y-2 hover:border-blue-200">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-spa text-2xl text-white"></i>
                        </div>
                        <h3 class="mt-6 text-xl font-bold text-gray-900">{{ $content['business_scope']['card4_title'] ?? 'Judul Default' }}</h3>
                        <p class="mt-3 text-gray-600 text-sm leading-relaxed">{{ $content['business_scope']['card4_desc'] ?? 'Deskripsi default.' }}</p>
                        <ul class="mt-6 text-left space-y-3">
                            @foreach (json_decode($content['business_scope']['card4_list'] ?? '[]') as $item)
                                <li class="flex items-start"><i class="fas fa-check-circle text-green-500 mr-3 mt-1 flex-shrink-0"></i><span class="text-sm text-gray-600">{{ $item }}</span></li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Kartu 5 -->
                    <div class="group bg-white p-8 rounded-2xl shadow-md border border-gray-100 text-center transition-all duration-300 hover:shadow-xl hover:-translate-y-2 hover:border-blue-200">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-mobile-alt text-2xl text-white"></i>
                        </div>
                        <h3 class="mt-6 text-xl font-bold text-gray-900">{{ $content['business_scope']['card5_title'] ?? 'Judul Default' }}</h3>
                        <p class="mt-3 text-gray-600 text-sm leading-relaxed">{{ $content['business_scope']['card5_desc'] ?? 'Deskripsi default.' }}</p>
                        <ul class="mt-6 text-left space-y-3">
                            @foreach (json_decode($content['business_scope']['card5_list'] ?? '[]') as $item)
                                <li class="flex items-start"><i class="fas fa-check-circle text-amber-500 mr-3 mt-1 flex-shrink-0"></i><span class="text-sm text-gray-600">{{ $item }}</span></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- =================================================================== -->
        <!-- LOWONGAN TERBARU SECTION -->
        <!-- =================================================================== -->
        <section id="latest-jobs" class="py-20 md:py-24 bg-slate-50 reveal" data-reveal>
            <div class="container mx-auto px-6">
                <div class="text-center">
                    <div class="section-title justify-center">
                        <span class="dot"></span>
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900">Lowongan Terbaru</h2>
                            <p class="mt-2 max-w-2xl mx-auto text-gray-600">Bergabunglah dengan tim kami dan jadilah bagian dari perjalanan bersama TERANG.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($jobs as $job)
                        <div class="group bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-2 hover:border-blue-200 reveal">
                            <div class="p-4 bg-gradient-to-r from-blue-500 to-blue-600">
                                <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-sm text-white text-xs font-semibold rounded-full">{{ $job->type }}</span>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $job->title }}</h3>
                                <p class="text-blue-600 text-sm font-medium mt-1">{{ $job->division }}</p>
                                <ul class="mt-4 text-sm text-gray-600 space-y-1">
                                    <li><i class="fas fa-briefcase mr-2 text-blue-500"></i> {{ $job->employment_type ?? 'Full-time' }}</li>
                                    <li><i class="fas fa-clock mr-2 text-blue-500"></i> Closing: {{ optional($job->closing_date)->format('d M Y') ?? '-' }}</li>
                                </ul>
                                <div class="mt-4 space-y-2">
                                    <p class="text-gray-600 text-sm flex items-center"><i class="fas fa-map-marker-alt mr-2 text-blue-500"></i>{{ $job->location }}</p>
                                    @if(!empty($job->salary_range))
                                        <p class="text-gray-600 text-sm flex items-center"><i class="fas fa-money-bill-wave mr-2 text-blue-500"></i>{{ $job->salary_range }}</p>
                                    @endif
                                </div>
                                <a href="/karir/{{ $job->id }}" data-job-id="{{ $job->id }}" class="job-detail-btn mt-6 inline-flex items-center font-semibold text-blue-600 hover:text-blue-700 group">
                                    Lihat Detail <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="col-span-3 text-center text-gray-500">Saat ini belum ada lowongan yang tersedia.</p>
                    @endforelse
                </div>
                <div class="text-center mt-16">
                    <a href="/karir" class="inline-flex items-center px-8 py-4 font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl">
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
                <div class="mt-12">
                    @if($gallery->isNotEmpty())
                        <div class="gallery-masonry">
                            @php
                                // Sort gallery: prioritize horizontal/landscape images first
                                $sortedGallery = $gallery->sortByDesc(function($img) {
                                    $imagePath = storage_path('app/public/' . $img->file_path);
                                    if (file_exists($imagePath)) {
                                        list($width, $height) = getimagesize($imagePath);
                                        return $width / $height; // Higher ratio = more horizontal
                                    }
                                    return 1; // Default ratio if image not found
                                });
                            @endphp
                            
                            @foreach($sortedGallery as $img)
                                <figure class="gallery-item reveal" style="break-inside:avoid">
                                    <img src="{{ asset('storage/' . $img->file_path) }}" alt="{{ $img->alt_text }}">
                                    <figcaption class="gallery-overlay">
                                        <div>
                                            <h4>{{ $img->alt_text ?? 'TERANG Event' }}</h4>
                                        </div>
                                    </figcaption>
                                </figure>
                            @endforeach
                            {{-- Tambahkan selalu elemen HR Department di galeri agar tidak hilang --}}
                            <figure class="gallery-item reveal" style="break-inside:avoid">
                                @php
                                    $hrImage = !empty($content['hr_department']['image']) ? asset('storage/' . $content['hr_department']['image']) : asset('images/gallery/office2.svg');
                                @endphp
                                <img src="{{ $hrImage }}" alt="HR Department">
                                <figcaption class="gallery-overlay"><h4>{{ $content['hr_department']['title'] ?? 'HR Department' }}</h4></figcaption>
                            </figure>
                        </div>
                    @else
                        <div class="gallery-masonry">
                            <figure class="gallery-item">
                                <img src="{{ asset('images/gallery/office1.svg') }}" alt="Office team">
                                <figcaption class="gallery-overlay"><h4>Team brainstorming</h4></figcaption>
                            </figure>
                            {{-- HR Department element already ditampilkan di atas ketika galeri berisi item --}}
                            <figure class="gallery-item">
                                <img src="{{ asset('images/gallery/office3.svg') }}" alt="Meeting room">
                                <figcaption class="gallery-overlay"><h4>Meeting room</h4></figcaption>
                            </figure>
                            <figure class="gallery-item">
                                <img src="{{ asset('images/gallery/office4.svg') }}" alt="Rooftop event">
                                <figcaption class="gallery-overlay"><h4>Rooftop event</h4></figcaption>
                            </figure>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
</x-app-layout>
