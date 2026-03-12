@extends('layouts.admin')

@section('title', 'Kandidat: ' . $user->name . ' - TERANG')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Breadcrumbs & Actions -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.talent_pool.index') }}" class="inline-flex items-center text-sm font-bold text-slate-400 hover:text-blue-600 transition-colors uppercase tracking-widest">
                        <i class="fas fa-users mr-2"></i>
                        Talent Pool
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-slate-300 text-[10px] mx-2"></i>
                        <span class="text-sm font-bold text-slate-900 uppercase tracking-widest">Detail Kandidat</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="flex items-center space-x-3">
            <a href="mailto:{{ $user->email }}" class="flex items-center justify-center bg-white border border-slate-100 p-2.5 rounded-xl shadow-sm hover:shadow-md hover:border-blue-100 text-slate-600 hover:text-blue-600 transition-all group">
                <i class="far fa-envelope text-lg group-hover:scale-110 transition-transform"></i>
            </a>
            @if($profile && $profile->phone_number)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile->phone_number) }}" target="_blank" class="flex items-center justify-center bg-white border border-slate-100 p-2.5 rounded-xl shadow-sm hover:shadow-md hover:border-green-100 text-slate-600 hover:text-green-600 transition-all group">
                    <i class="fab fa-whatsapp text-lg group-hover:scale-110 transition-transform"></i>
                </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left Column: Profile Card -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden sticky top-8 transition-all hover:shadow-xl hover:shadow-slate-200/50">
                <!-- Cover/Header -->
                <div class="h-32 bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 relative">
                    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-white/40 via-transparent to-transparent"></div>
                </div>
                
                <!-- Profile Image -->
                <div class="px-6 -mt-16 relative z-10 text-center">
                    <div class="inline-block p-1.5 bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/80">
                        <div class="w-32 h-32 rounded-[2rem] bg-slate-100 overflow-hidden flex items-center justify-center border-4 border-white">
                            @if($profile && $profile->photo_path)
                                <img src="{{ asset('storage/' . $profile->photo_path) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-4xl font-black text-blue-600">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Info -->
                <div class="px-8 pt-6 pb-10 text-center">
                    <h2 class="text-2xl font-black text-slate-900 leading-tight">{{ $user->name }}</h2>
                    <p class="text-slate-500 font-medium text-sm mt-1 mb-6 flex items-center justify-center">
                        <i class="far fa-envelope mr-2 opacity-40"></i>
                        {{ $user->email }}
                    </p>
                    
                    <div class="grid grid-cols-2 gap-3 mb-8">
                        <div class="bg-slate-50/80 rounded-2xl p-3 text-center transition-colors hover:bg-blue-50/50">
                            <div class="text-[10px] uppercase font-black text-slate-400 tracking-widest mb-1">Status</div>
                            @php
                                $statusColors = [
                                    'invited' => 'text-emerald-600 bg-emerald-100/50',
                                    'available' => 'text-blue-600 bg-blue-100/50',
                                    'contacted' => 'text-amber-600 bg-amber-100/50',
                                    'hired' => 'text-indigo-600 bg-indigo-100/50',
                                    'shortlist' => 'text-slate-600 bg-slate-100/50',
                                ];
                                $statusStyle = $statusColors[strtolower($talent->status)] ?? 'text-slate-600 bg-slate-100/50';
                            @endphp
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest {{ $statusStyle }}">
                                {{ $talent->status }}
                            </span>
                        </div>
                        <div class="bg-slate-50/80 rounded-2xl p-3 text-center">
                            <div class="text-[10px] uppercase font-black text-slate-400 tracking-widest mb-1">Terdaftar</div>
                            <span class="text-xs font-bold text-slate-800">{{ $talent->created_at->format('d M Y') }}</span>
                        </div>
                    </div>

                    @if($profile && $profile->cv_path)
                        <a href="{{ asset('storage/' . $profile->cv_path) }}" target="_blank" class="w-full py-4 bg-slate-900 text-white rounded-2xl font-bold flex items-center justify-center space-x-3 transition-all hover:bg-blue-600 hover:shadow-lg hover:shadow-blue-500/30 group">
                            <i class="far fa-file-pdf text-lg group-hover:scale-110 transition-transform"></i>
                            <span>Lihat CV / Resume</span>
                        </a>
                    @else
                        <div class="w-full py-4 bg-slate-100 text-slate-400 rounded-2xl font-bold flex items-center justify-center cursor-not-allowed opacity-60">
                            <i class="fas fa-file-excel text-lg mr-3"></i>
                            <span>CV Belum Tersedia</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column: Content -->
        <div class="lg:col-span-8 space-y-8">
            <!-- Personal Summary -->
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8 md:p-10 transition-all hover:border-blue-100">
                <div class="flex items-center space-x-4 mb-8">
                    <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600">
                        <i class="fas fa-user-tie text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 leading-none">Ringkasan Profil</h3>
                        <p class="text-slate-400 font-bold text-xs uppercase tracking-widest mt-1">Personal Details & Contacts</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Lengkap</label>
                        <p class="text-slate-900 font-bold">{{ $user->name }}</p>
                    </div>
                    @if($profile && $profile->nickname)
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Panggilan</label>
                        <p class="text-slate-900 font-bold">{{ $profile->nickname }}</p>
                    </div>
                    @endif
                    @if($profile && $profile->phone_number)
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">No. Whatsapp / Telpon</label>
                        <p class="text-slate-900 font-bold">{{ $profile->phone_number }}</p>
                    </div>
                    @endif
                    @if($profile && $profile->date_of_birth)
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal Lahir</label>
                        <p class="text-slate-900 font-bold">{{ $profile->formatted_date_of_birth }}</p>
                    </div>
                    @endif
                </div>

                @if($profile && $profile->about_me)
                <div class="bg-slate-50/50 rounded-3xl p-6 border border-slate-100">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Tentang Kandidat</label>
                    <p class="text-slate-600 font-medium leading-relaxed whitespace-pre-line">{{ $profile->about_me }}</p>
                </div>
                @endif
            </div>

            <!-- Education & Job Preferences -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Education -->
                <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8 transition-all hover:border-blue-100">
                    <h4 class="text-lg font-black text-slate-900 mb-6 flex items-center">
                        <div class="w-8 h-8 mr-3 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                            <i class="fas fa-graduation-cap text-sm"></i>
                        </div>
                        Pendidikan
                    </h4>
                    @if($profile && ($profile->education_level || $profile->institution))
                        <div class="space-y-4">
                            <div>
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Tingkat / Gelar</label>
                                <p class="text-slate-900 font-bold italic">{{ $profile->education_level ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Institusi</label>
                                <p class="text-slate-900 font-bold">{{ $profile->institution ?? '-' }}</p>
                            </div>
                            @if($profile->major)
                            <div>
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Jurusan / Program Studi</label>
                                <p class="text-slate-800 font-medium">{{ $profile->major }}</p>
                            </div>
                            @endif
                        </div>
                    @else
                        <p class="text-slate-400 italic text-sm py-4">Informasi pendidikan belum tersedia.</p>
                    @endif
                </div>

                <!-- Job Preferences -->
                <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8 transition-all hover:border-blue-100">
                    <h4 class="text-lg font-black text-slate-900 mb-6 flex items-center">
                        <div class="w-8 h-8 mr-3 bg-amber-50 rounded-xl flex items-center justify-center text-amber-600">
                            <i class="fas fa-briefcase text-sm"></i>
                        </div>
                        Preferensi Pekerjaan
                    </h4>
                    <div class="space-y-4">
                         <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Bidang Minat</label>
                            <p class="text-slate-900 font-bold italic">
                                @if($workExperiences && $workExperiences->count() > 0)
                                    @php
                                        $jobDesc = $workExperiences->first()->job_description;
                                        $position = $jobDesc ? explode(' — ', $jobDesc)[0] : '-';
                                    @endphp
                                    {{ $position }}
                                @else
                                    {{ $talent->job_preferences ?? '-' }}
                                @endif
                            </p>
                        </div>
                        @if($profile && $profile->job_interest)
                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Minat Karir Spesifik</label>
                            <p class="text-slate-800 font-medium">{{ $profile->job_interest }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Work Experiences -->
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8 md:p-10 transition-all hover:border-blue-100">
                <h3 class="text-xl font-black text-slate-900 mb-8 flex items-center">
                    <div class="w-12 h-12 mr-4 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 font-bold">
                        <i class="fas fa-history"></i>
                    </div>
                    Pengalaman Kerja
                </h3>

                @if($workExperiences && $workExperiences->count() > 0)
                    <div class="relative space-y-10 before:absolute before:inset-y-0 before:left-6 before:w-[2px] before:bg-slate-100">
                        @foreach($workExperiences as $experience)
                        @php
                            $jobDesc = $experience->job_description;
                            $parts = $jobDesc ? explode(' — ', $jobDesc, 2) : ['-', ''];
                            $position = $parts[0] ?? '-';
                            $description = $parts[1] ?? '';
                        @endphp
                        <div class="relative pl-16 group/exp">
                            <!-- Dot Indicator -->
                            <div class="absolute left-[18px] top-1.5 w-3.5 h-3.5 bg-white border-2 border-emerald-500 rounded-full z-10 group-hover/exp:scale-125 transition-transform"></div>
                            
                            <div class="bg-slate-50/50 p-6 rounded-3xl border border-slate-50 group-hover/exp:bg-white group-hover/exp:border-emerald-100 group-hover/exp:shadow-lg group-hover/exp:shadow-slate-100 transition-all">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-2 mb-4">
                                    <h5 class="text-lg font-black text-slate-900 leading-tight">{{ $position }}</h5>
                                    <span class="inline-flex items-center px-3 py-1 bg-white shadow-sm border border-slate-100 rounded-xl text-[10px] font-black text-emerald-600 uppercase tracking-widest">
                                        <i class="far fa-clock mr-1.5"></i>
                                        {{ $experience->duration ?? '-' }}
                                    </span>
                                </div>
                                <div class="flex items-center text-slate-600 font-bold mb-4">
                                    <div class="w-6 h-6 mr-2 bg-slate-200/50 rounded-lg flex items-center justify-center text-[10px]">
                                        <i class="fas fa-building italic"></i>
                                    </div>
                                    {{ $experience->company_name ?? '-' }}
                                </div>
                                @if($description)
                                    <div class="text-slate-600 text-sm leading-relaxed border-t border-slate-200 mt-4 pt-4">
                                        {{ $description }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-12 text-center bg-slate-50/50 rounded-3xl border border-dashed border-slate-200">
                        <div class="w-16 h-16 mx-auto bg-white rounded-2xl shadow-sm flex items-center justify-center text-slate-200 text-2xl mb-4">
                             <i class="fas fa-history"></i>
                        </div>
                        <p class="text-slate-400 font-bold text-sm tracking-tight px-6 uppercase">Belum ada riwayat pengalaman kerja yang terdaftar.</p>
                    </div>
                @endif
            </div>

            <!-- Documents -->
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8 md:p-10 transition-all hover:border-blue-100">
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
                     <h3 class="text-xl font-black text-slate-900 flex items-center">
                        <div class="w-12 h-12 mr-4 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-600 font-bold">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        Dokumen Kandidat
                    </h3>
                    @if($profile && $profile->expected_salary)
                        <div class="mt-4 md:mt-0 px-4 py-2 bg-slate-50 border border-slate-100 rounded-xl text-center md:text-right">
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Ekspektasi Gaji</div>
                            <div class="text-sm font-black text-green-600 tracking-tight">{{ number_format($profile->expected_salary,0,',','.') }} <span class="text-xs text-slate-400 font-medium">IDR</span></div>
                        </div>
                    @endif
                </div>

                @php
                    $docs = [
                        ['title' => 'Foto Formal', 'path' => optional($profile)->formal_photo_path, 'icon' => 'fa-id-badge', 'color' => 'text-blue-500', 'bg' => 'bg-blue-50'],
                        ['title' => 'KTP', 'path' => optional($profile)->ktp_path, 'icon' => 'fa-address-card', 'color' => 'text-indigo-500', 'bg' => 'bg-indigo-50'],
                        ['title' => 'Kartu Keluarga (KK)', 'path' => optional($profile)->kk_path, 'icon' => 'fa-users', 'color' => 'text-purple-500', 'bg' => 'bg-purple-50'],
                        ['title' => 'NPWP', 'path' => optional($profile)->npwp_path, 'icon' => 'fa-file-invoice-dollar', 'color' => 'text-emerald-500', 'bg' => 'bg-emerald-50'],
                        ['title' => 'Ijazah Terakhir', 'path' => optional($profile)->ijazah_path, 'icon' => 'fa-graduation-cap', 'color' => 'text-amber-500', 'bg' => 'bg-amber-50'],
                        ['title' => 'Sertifikat', 'path' => optional($profile)->certificate_path, 'icon' => 'fa-certificate', 'color' => 'text-rose-500', 'bg' => 'bg-rose-50'],
                    ];
                @endphp
                
                <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4">
                    @foreach($docs as $doc)
                        @if($doc['path'])
                            <a href="{{ asset('storage/' . $doc['path']) }}" target="_blank" 
                               class="group flex flex-col items-center p-4 bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-blue-200 transition-all text-center">
                                <div class="w-12 h-12 {{ $doc['bg'] }} {{ $doc['color'] }} rounded-xl flex items-center justify-center text-xl mb-3 group-hover:scale-110 transition-transform">
                                    <i class="fas {{ $doc['icon'] }}"></i>
                                </div>
                                <h5 class="text-xs font-bold text-slate-700 leading-tight">{{ $doc['title'] }}</h5>
                                <span class="text-[10px] text-blue-500 font-medium mt-1 opacity-0 group-hover:opacity-100 transition-opacity">Tinjau Dokumen &rarr;</span>
                            </a>
                        @else
                            <div class="flex flex-col items-center p-4 bg-slate-50/50 rounded-2xl border border-dashed border-slate-200 text-center opacity-60">
                                <div class="w-12 h-12 bg-slate-100 text-slate-300 rounded-xl flex items-center justify-center text-xl mb-3">
                                    <i class="fas {{ $doc['icon'] }}"></i>
                                </div>
                                <h5 class="text-xs font-medium text-slate-500 leading-tight">{{ $doc['title'] }}</h5>
                                <span class="text-[10px] text-slate-400 mt-1">Belum Tersedia</span>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Skills & Languages -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pb-10">
                @if($profile && $profile->skills)
                <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8 transition-all hover:border-blue-100">
                    <h4 class="text-lg font-black text-slate-900 mb-6 flex items-center uppercase tracking-tighter">
                        <i class="fas fa-bolt text-blue-500 mr-3"></i> Skills
                    </h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach(explode(',', $profile->skills) as $skill)
                            <span class="px-4 py-2 bg-blue-50 text-blue-600 text-[10px] font-black rounded-xl uppercase tracking-widest border border-blue-100/50">
                                {{ trim($skill) }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($profile && $profile->languages)
                <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8 transition-all hover:border-blue-100">
                     <h4 class="text-lg font-black text-slate-900 mb-6 flex items-center uppercase tracking-tighter">
                        <i class="fas fa-language text-purple-500 mr-3"></i> Languages
                    </h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach(explode(',', $profile->languages) as $lang)
                            <span class="px-4 py-2 bg-purple-50 text-purple-600 text-[10px] font-black rounded-xl uppercase tracking-widest border border-purple-100/50">
                                {{ trim($lang) }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection