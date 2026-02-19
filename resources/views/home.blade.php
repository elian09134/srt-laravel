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
        <!-- MEMBER TIM SECTION -->
        <!-- =================================================================== -->
        @php
            $membersJson = $content['hr_department']['members'] ?? null; // Assuming 'hr_department' still holds the members data
            try {
                $members = (is_array($membersJson) ? $membersJson : json_decode($membersJson, true)) ?: [];
            } catch (\Throwable $e) {
                $members = [];
            }
        @endphp
        <section id="team" class="flex flex-col items-center text-center mb-20">
            <span class="text-primary font-bold tracking-[0.2em] uppercase text-[10px] mb-4 bg-primary/10 px-4 py-1.5 rounded-full">Our Excellence</span>
            <h1 class="text-slate-900 dark:text-white text-4xl md:text-6xl font-black leading-[1.1] tracking-tight mb-8 max-w-4xl">
                Meet the Minds Behind <span class="text-primary">TERANG By SRT</span>
            </h1>
            <p class="text-slate-500 dark:text-slate-400 text-xl font-medium leading-relaxed max-w-2xl">
                Our dedicated professionals are committed to driving innovation and excellence in every project, blending strategy with seamless execution.
            </p>
            
            <div class="mt-14 flex flex-wrap justify-center gap-3 w-full mb-12">
                <button onclick="filterTeam('all')" class="filter-btn active px-8 py-2.5 text-sm font-bold rounded-full transition-all border border-transparent shadow-lg shadow-primary/25 bg-primary text-white" data-filter="all">All Departments</button>
                <button onclick="filterTeam('HR')" class="filter-btn px-8 py-2.5 text-sm font-bold rounded-full transition-all border border-slate-100 text-slate-500 hover:text-primary hover:bg-slate-50" data-filter="HR">HR & HCM</button>
                <button onclick="filterTeam('Digital Technology')" class="filter-btn px-8 py-2.5 text-sm font-bold rounded-full transition-all border border-slate-100 text-slate-500 hover:text-primary hover:bg-slate-50" data-filter="Digital Technology">Digital Technology</button>
                <button onclick="filterTeam('General Affairs')" class="filter-btn px-8 py-2.5 text-sm font-bold rounded-full transition-all border border-slate-100 text-slate-500 hover:text-primary hover:bg-slate-50" data-filter="General Affairs">General Affairs</button>
                <button onclick="filterTeam('Legal')" class="filter-btn px-8 py-2.5 text-sm font-bold rounded-full transition-all border border-slate-100 text-slate-500 hover:text-primary hover:bg-slate-50" data-filter="Legal">Legal</button>
            </div>

            <!-- Team Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 lg:gap-12 w-full max-w-7xl px-6">
                @foreach($members as $member)
                    @php
                        $photo = $member['photo'] ?? null;
                        $photoUrl = $photo ? asset('storage/' . ltrim($photo, '/')) : asset('images/avatar-placeholder.png');
                        $department = $member['department'] ?? 'Other';
                    @endphp
                    <div class="team-member-card group relative bg-white/70 backdrop-blur-xl rounded-[2rem] p-8 transition-all duration-500 border border-white/50 hover:shadow-[0_20px_50px_rgba(6,123,249,0.15)] hover:-translate-y-3" data-department="{{ $department }}">
                        <div class="flex flex-col items-center text-center">
                            <div class="relative mb-8">
                                <div class="absolute inset-0 bg-primary/20 rounded-full blur-2xl group-hover:bg-primary/40 transition-all duration-500"></div>
                                <div class="size-40 rounded-full overflow-hidden border-[6px] border-white shadow-xl relative z-10">
                                    <img class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700" src="{{ $photoUrl }}" alt="{{ $member['name'] ?? 'Team Member' }}">
                                </div>
                            </div>
                            <h3 class="text-2xl font-black text-slate-900 mb-2">{{ $member['name'] ?? 'Nama Anggota' }}</h3>
                            <p class="text-primary font-bold text-xs tracking-widest uppercase mb-4">{{ $member['department'] ?? 'Departemen' }}</p>
                            
                            <!-- Bio & Social Container with Transition -->
                            <div class="relative w-full h-[80px] flex items-center justify-center">
                                <!-- Bio (Visible by default, hidden on hover) -->
                                <p class="text-slate-500 text-sm leading-relaxed px-4 font-medium absolute inset-0 transition-all duration-500 opacity-100 group-hover:opacity-0 group-hover:-translate-y-4 flex items-center justify-center">{{ $member['bio'] ?? 'Dedicated professional committed to excellence.' }}</p>
                                
                                <!-- Social Links (Hidden by default, visible on hover) -->
                                <div class="flex gap-4 absolute inset-0 items-center justify-center transition-all duration-500 opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0">
                                    @if(!empty($member['social']['linkedin']))
                                        <a href="{{ $member['social']['linkedin'] }}" target="_blank" class="w-11 h-11 flex items-center justify-center rounded-full bg-slate-100 text-slate-400 hover:bg-[#0077b5] hover:text-white transition-all duration-300" title="LinkedIn"><span class="material-symbols-outlined text-lg">work</span></a>
                                    @endif
                                    @if(!empty($member['social']['instagram']))
                                        <a href="https://instagram.com/{{ ltrim($member['social']['instagram'], '@') }}" target="_blank" class="w-11 h-11 flex items-center justify-center rounded-full bg-slate-100 text-slate-400 hover:bg-[#E1306C] hover:text-white transition-all duration-300" title="Instagram"><span class="material-symbols-outlined text-lg">photo_camera</span></a>
                                    @endif
                                    @if(!empty($member['email']))
                                        <a href="mailto:{{ $member['email'] }}" class="w-11 h-11 flex items-center justify-center rounded-full bg-slate-100 text-slate-400 hover:bg-red-500 hover:text-white transition-all duration-300" title="Email"><span class="material-symbols-outlined text-lg">mail</span></a>
                                    @endif
                                    @if(!empty($member['phone']))
                                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $member['phone'])) }}" target="_blank" class="w-11 h-11 flex items-center justify-center rounded-full bg-slate-100 text-slate-400 hover:bg-green-500 hover:text-white transition-all duration-300" title="WhatsApp/Phone"><span class="material-symbols-outlined text-lg">call</span></a>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
            
            @if(empty($members))
                <div class="text-center py-8 w-full">
                    <p class="text-gray-500">Belum ada data anggota tim. Silakan tambahkan melalui admin panel.</p>
                </div>
            @endif
        </section>

        <script>
            function filterTeam(category) {
                // Update buttons
                document.querySelectorAll('.filter-btn').forEach(btn => {
                    if (btn.dataset.filter === category) {
                        btn.className = 'filter-btn active px-8 py-2.5 text-sm font-bold rounded-full transition-all border border-transparent shadow-lg shadow-primary/25 bg-primary text-white';
                    } else {
                        btn.className = 'filter-btn px-8 py-2.5 text-sm font-bold rounded-full transition-all border border-slate-100 text-slate-500 hover:text-primary hover:bg-slate-50';
                    }
                });

                // Filter cards
                document.querySelectorAll('.team-member-card').forEach(card => {
                    const dept = card.dataset.department;
                    const isHR = category === 'HR' && (dept.includes('HR') || dept.includes('HCM') || dept.includes('Personalia'));
                    
                    if (category === 'all' || dept === category || isHR) {
                        card.style.display = 'block';
                        // Add animation class if needed
                        card.classList.add('animate-fade-in');
                    } else {
                        card.style.display = 'none';
                        card.classList.remove('animate-fade-in');
                    }
                });
            }
        </script>

        <!-- =================================================================== -->
        <!-- =================================================================== -->
        <!-- SECTION 1: SEJARAH SINGKAT (Asymmetrical Layout) -->
        <!-- =================================================================== -->
        <section id="about-us" class="py-24 bg-white dark:bg-slate-900/50 reveal">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid lg:grid-cols-12 gap-12 items-center">
                    <div class="lg:col-span-5 order-2 lg:order-1">
                        <div class="relative">
                            <div class="absolute -inset-4 bg-primary/10 rounded-xl -rotate-3"></div>
                            @php
                                $aboutImage = !empty($content['about_us']['image']) ? asset('storage/' . $content['about_us']['image']) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuBdl06xMZPdYLu3ENIliWEoihy8DQIbGXooFor8FDt5sB2MBvFmHkFWfXT7Gi15urmVf_51UqDYzKoda4X1qUM0VQXlQWA5HCnzOHvIA5OVnZAtPtepb2rlxERpuC24acGvj4vrxtDtWVnSBS45J6kyZKkqgSafm91dUMJHwGRKzSfo4tzOLxlsYqKospqKLoPyiUujxp4q8NnpVN24DaeoYrtUrbV9duJo75Ogf5OYZegq02y7SA0_YOkYemLWzpi5PG4Rs4eqtlg';
                            @endphp
                            <img alt="About Image" class="relative z-10 rounded-xl shadow-lg w-full" src="{{ $aboutImage }}">
                        </div>
                    </div>
                    <div class="lg:col-span-7 order-1 lg:order-2">
                        <h2 class="text-3xl font-bold mb-6 flex items-center gap-4 text-slate-900">
                            <span class="w-12 h-1 bg-primary rounded-full"></span>
                            {{ $content['about_us']['history_title'] ?? 'Sejarah Singkat' }}
                        </h2>
                        <div class="space-y-6 text-slate-600 dark:text-slate-400 text-lg leading-relaxed text-justify">
                           <p>{!! nl2br(e($content['about_us']['history_text'] ?? 'Berawal dari visi kecil untuk mempermudah akses energi di daerah berkembang, Terang By SRT didirikan sebagai penyedia solusi kelistrikan terintegrasi yang fokus pada efisiensi dan keberlanjutan.')) !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- =================================================================== -->
        <!-- SECTION 2: VISI (Minimalist Wide Section) -->
        <!-- =================================================================== -->
        <section class="relative py-32 bg-slate-900 text-white overflow-hidden reveal">
            <div class="absolute inset-0 opacity-20">
                <img alt="Airport Runway" class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1473862170180-84427c485aca?q=80&w=2070&auto=format&fit=crop">
            </div>
            <div class="max-w-4xl mx-auto px-6 relative z-10 text-center">
                <span class="material-symbols-outlined text-primary text-6xl mb-6">visibility</span>
                <h2 class="text-2xl font-bold tracking-widest uppercase text-primary/80 mb-8">{{ $content['about_us']['vision_title'] ?? 'Visi Kami' }}</h2>
                <blockquote class="text-3xl md:text-5xl font-extrabold italic leading-tight">
                    "{{ $content['about_us']['vision_text'] ?? 'Menjadi pionir solusi energi cerdas yang memberikan dampak nyata bagi pembangunan bangsa yang mandiri dan berkelanjutan.' }}"
                </blockquote>
            </div>
        </section>

        <!-- =================================================================== -->
        <!-- SECTION 3: MISI (Floating Cards) -->
        <!-- =================================================================== -->
        <section class="py-32 px-6 reveal">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-20 gap-8">
                    <div class="max-w-2xl">
                        <h2 class="text-4xl font-black mb-6 text-slate-900">{{ $content['about_us']['mission_title'] ?? 'Misi Perusahaan' }}</h2>
                        <p class="text-slate-600 dark:text-slate-400 text-lg">Langkah nyata kami untuk mewujudkan masa depan yang lebih terang melalui tiga pilar utama pelayanan.</p>
                        <!-- Dynamic Mission List (if available) -->
                    </div>
                    <div class="hidden md:block">
                        <span class="text-8xl font-black text-primary/5 select-none">MISSION</span>
                    </div>
                </div>
                
                <div class="grid md:grid-cols-3 gap-8">
                    @php
                        $missions = json_decode($content['about_us']['mission_text'] ?? '[]');
                        $icons = ['verified', 'handshake', 'eco', 'bolt', 'group', 'star'];
                    @endphp

                    @forelse($missions as $index => $mission)
                        <div class="group p-10 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 {{ $index > 0 ? 'md:mt-' . ($index % 2 == 0 ? '0' : '12') : '' }}">
                            <div class="size-16 bg-primary/10 rounded-xl flex items-center justify-center text-primary mb-8 group-hover:bg-primary group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-3xl">{{ $icons[$index % count($icons)] }}</span>
                            </div>
                            <h3 class="text-xl font-bold mb-4 text-slate-900">Misi {{ $index + 1 }}</h3>
                            <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                                {{ $mission }}
                            </p>
                        </div>
                    @empty
                        <!-- Fallback if no data -->
                         <div class="group p-10 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                            <div class="size-16 bg-primary/10 rounded-xl flex items-center justify-center text-primary mb-8 group-hover:bg-primary group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-3xl">precision_manufacturing</span>
                            </div>
                            <h3 class="text-xl font-bold mb-4 text-slate-900">Inovasi Teknologi</h3>
                            <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                                Mengintegrasikan teknologi kelistrikan terbaru untuk memberikan solusi yang lebih efisien, hemat energi, dan aman digunakan dalam jangka panjang.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- =================================================================== -->
        <!-- CLOSING CTA SECTION -->
        <!-- =================================================================== -->
        <section class="max-w-7xl mx-auto px-6 mb-24 reveal">
            <div class="relative rounded-3xl overflow-hidden bg-primary px-8 py-16 md:p-20 text-center">
                <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
                    <svg class="w-full h-full" preserveAspectRatio="none" viewBox="0 0 100 100">
                        <path d="M0 100 L100 0 L100 100 Z" fill="white"></path>
                    </svg>
                </div>
                <div class="relative z-10">
                    <h2 class="text-3xl md:text-5xl font-black text-white mb-8">Siap Memiliki Karir Baru?</h2>
                    <p class="text-white/80 text-lg mb-12 max-w-2xl mx-auto">
                        Bergabunglah dengan tim kami dan bangun masa depan yang lebih cerah bersama kami.
                    </p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="/contact" class="bg-white text-primary px-8 py-4 rounded-full font-bold shadow-xl hover:bg-slate-50 transition-colors">
                            Apply Sekarang
                        </a>
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
                    <div class="group bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 overflow-hidden hover:shadow-2xl hover:shadow-slate-200/50 dark:hover:shadow-none transition-all duration-300">
                        @if($job->show_image && $job->image)
                        <div class="relative aspect-video">
                            <img alt="{{ $job->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ Storage::url($job->image) }}" />
                            <span class="absolute top-3 left-3 px-3 py-1 bg-primary text-white text-[10px] font-bold uppercase rounded-md shadow-lg">{{ $job->division ?? 'Umum' }}</span>
                        </div>
                        @else
                        <!-- Fallback/No Image Header -->
                        <div class="bg-gradient-to-r from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-900 aspect-[3/1] relative overflow-hidden">
                             <span class="absolute top-3 left-3 px-3 py-1 bg-primary text-white text-[10px] font-bold uppercase rounded-md shadow-lg">{{ $job->division ?? 'Umum' }}</span>
                        </div>
                        @endif
                        
                        <div class="p-5 flex flex-col gap-4">
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors">{{ $job->title }}</h3>
                                <div class="flex items-center gap-1.5 mt-2 text-slate-500 dark:text-slate-400 text-sm">
                                    <span class="material-symbols-outlined text-base">location_on</span>
                                    {{ $job->location }}
                                </div>
                            </div>
                            
                            @if($job->salary_range)
                            <div class="flex items-center justify-between py-3 border-y border-slate-50 dark:border-slate-800">
                                <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Salary Range</span>
                                <span class="text-sm font-bold text-slate-900 dark:text-white">{{ $job->salary_range }}</span>
                            </div>
                            @endif

                            <a href="{{ route('karir.show', $job->id) }}" class="w-full py-3 bg-primary/10 text-primary font-bold rounded-xl group-hover:bg-primary group-hover:text-white transition-all text-center">Lihat Detail</a>
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
        {{-- 
            @section('gallery') --}}
        {{--
        <!-- =================================================================== -->
        <!-- GALERI PERUSAHAAN SECTION -->
        <!-- =================================================================== -->
        <section id="gallery" class="py-20 md:py-24 bg-white" style="display: none;">
            <div class="container mx-auto px-6">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-gray-900">{{ $content['gallery']['title'] ?? 'Galeri Perusahaan' }}</h2>
                    <p class="mt-4 max-w-2xl mx-auto text-gray-600">{{ $content['gallery']['description'] ?? 'Deskripsi default galeri.' }}</p>
                </div>
                <!-- ... content hidden ... -->
            </div>
        </section>
        --}}
    </main>
</x-app-layout>
