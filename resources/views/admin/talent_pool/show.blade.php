@extends('layouts.admin')

@section('title', 'Detail Talent: ' . $user->name)

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.talent_pool.index') }}" class="text-slate-500 hover:text-blue-600 text-sm mb-2 inline-flex items-center transition-colors">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Talent Pool
    </a>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mt-2">
        <h1 class="text-2xl font-bold text-slate-800">Detail Talent: {{ $user->name }}</h1>
        <div class="flex items-center gap-3">
             <a href="mailto:{{ $user->email }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors shadow-sm text-sm font-medium">
                <i class="far fa-envelope mr-2"></i> Email Profil
            </a>
            @if($profile && $profile->phone_number)
                @php
                    $num = preg_replace('/\D+/', '', $profile->phone_number);
                    if (strlen($num) > 0 && $num[0] === '0') $num = '62' . substr($num, 1);
                @endphp
                <a href="https://wa.me/{{ $num }}" target="_blank" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors shadow-sm text-sm font-medium">
                    <i class="fab fa-whatsapp mr-2 text-lg"></i> Hubungi WA
                </a>
            @endif
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 pb-12">
    <!-- Left Column: Profile Card & Status -->
    <div class="lg:col-span-1 space-y-6">
        
        <!-- Profile Info Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="h-24 bg-gradient-to-br from-indigo-500 to-purple-700"></div>
            <div class="px-6 pb-6">
                <div class="relative flex justify-center -mt-12 mb-4">
                    @if($profile && $profile->photo_path)
                        <img class="h-24 w-24 rounded-2xl object-cover ring-4 ring-white shadow-md bg-white border border-slate-100" src="{{ asset('storage/' . $profile->photo_path) }}" alt="{{ $user->name }}">
                    @else
                        <div class="h-24 w-24 rounded-2xl bg-slate-100 ring-4 ring-white shadow-md flex items-center justify-center text-slate-400 font-bold text-3xl border border-slate-200">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                
                <div class="text-center">
                    <h2 class="text-xl font-bold text-slate-800">{{ $user->name }}</h2>
                    <p class="text-sm text-slate-500 mt-1">{{ collect([$profile->last_position ?? null, $profile->institution ?? null])->filter()->join(' di ') ?: 'Talent' }}</p>
                </div>

                <div class="mt-6 flex flex-col gap-3">
                    <div class="flex items-center text-sm text-slate-600 bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                        <i class="far fa-envelope w-6 text-slate-400 text-center"></i>
                        <span class="truncate">{{ $user->email }}</span>
                    </div>
                    @if($profile && $profile->phone_number)
                    <div class="flex items-center text-sm text-slate-600 bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                        <i class="fas fa-phone w-6 text-slate-400 text-center"></i>
                        <span>{{ $profile->phone_number }}</span>
                    </div>
                    @endif
                    @if($profile && $profile->date_of_birth)
                     <div class="flex items-center text-sm text-slate-600 bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                        <i class="fas fa-birthday-cake w-6 text-slate-400 text-center"></i>
                        <span>{{ $profile->formatted_date_of_birth }}</span>
                    </div>
                    @endif
                    @if($profile && $profile->address)
                     <div class="flex items-start text-sm text-slate-600 bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                        <i class="fas fa-map-marker-alt w-6 text-slate-400 text-center mt-0.5"></i>
                        <span class="leading-relaxed">{{ $profile->address }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Talent Status Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Informasi Talent Pool</h3>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-50">
                    <span class="text-sm text-slate-500">Status Kandidat</span>
                    @php
                        $statusColors = [
                            'invited' => 'bg-emerald-100 text-emerald-700',
                            'available' => 'bg-blue-100 text-blue-700',
                            'contacted' => 'bg-amber-100 text-amber-700',
                            'hired' => 'bg-purple-100 text-purple-700',
                            'shortlist' => 'bg-slate-100 text-slate-700',
                        ];
                        $badgeClass = $statusColors[strtolower($talent->status)] ?? 'bg-slate-100 text-slate-700';
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold uppercase tracking-wider {{ $badgeClass }}">
                        {{ $talent->status }}
                    </span>
                </div>
                
                <div class="flex items-center justify-between pb-3 border-b border-slate-50">
                    <span class="text-sm text-slate-500">Masuk Talent Pool</span>
                    <span class="text-sm font-medium text-slate-800">{{ $talent->created_at->format('d M Y') }}</span>
                </div>

                @if($profile && $profile->expected_salary)
                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-500">Ekspektasi Gaji</span>
                    <span class="text-sm font-bold text-green-600">{{ number_format($profile->expected_salary, 0, ',', '.') }} IDR</span>
                </div>
                @endif
            </div>
        </div>
        
         <!-- Skills & Languages (Moved to Sidebar if short, or right if long. Sidebar fits nicely) -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 space-y-6">
            @if($profile && $profile->skills)
            <div>
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 flex items-center">
                    <i class="fas fa-tools mr-2 text-slate-300"></i> Keahlian (Skills)
                </h4>
                <div class="flex flex-wrap gap-2">
                    @foreach(explode(',', $profile->skills) as $skill)
                        <span class="px-3 py-1 bg-slate-50 text-slate-700 text-xs font-medium rounded-lg border border-slate-200">
                            {{ trim($skill) }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endif

            @if($profile && $profile->languages)
            <div>
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 flex items-center">
                    <i class="fas fa-language mr-2 text-slate-300"></i> Bahasa
                </h4>
                <div class="flex flex-wrap gap-2">
                    @foreach(explode(',', $profile->languages) as $lang)
                        <span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded-lg border border-blue-100">
                            {{ trim($lang) }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

    </div>

    <!-- Right Column: Detail Content -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- About / Ringkasan -->
        @if($profile && $profile->about_me)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
            <h3 class="text-lg font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3 flex items-center">
                <i class="far fa-user-circle text-blue-500 mr-2"></i> Tentang Kandidat
            </h3>
            <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">{{ $profile->about_me }}</p>
        </div>
        @endif

        <!-- Education & Job Pref -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h3 class="text-base font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3 flex items-center">
                    <i class="fas fa-graduation-cap text-indigo-500 mr-2"></i> Pendidikan
                </h3>
                @if($profile && ($profile->education_level || $profile->institution))
                    <div class="space-y-3">
                        <div>
                            <span class="block text-xs text-slate-400 font-medium mb-0.5">Institusi</span>
                            <span class="block text-sm font-bold text-slate-800">{{ $profile->institution ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs text-slate-400 font-medium mb-0.5">Tingkat Gelar</span>
                            <span class="block text-sm font-medium text-slate-700">{{ $profile->education_level ?? '-' }}</span>
                        </div>
                        @if($profile->major)
                        <div>
                            <span class="block text-xs text-slate-400 font-medium mb-0.5">Jurusan / Prodi</span>
                            <span class="block text-sm font-medium text-slate-700">{{ $profile->major }}</span>
                        </div>
                        @endif
                    </div>
                @else
                    <p class="text-sm text-slate-400 italic">Data pendidikan belum dilengkapi.</p>
                @endif
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                 <h3 class="text-base font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3 flex items-center">
                    <i class="fas fa-briefcase text-amber-500 mr-2"></i> Preferensi Kerja
                </h3>
                <div class="space-y-3">
                     <div>
                        <span class="block text-xs text-slate-400 font-medium mb-0.5">Bidang Minat Utama</span>
                        <span class="block text-sm font-bold text-slate-800">
                             @if($workExperiences && $workExperiences->count() > 0)
                                @php
                                    $jobDesc = $workExperiences->first()->job_description;
                                    $position = $jobDesc ? explode(' — ', $jobDesc)[0] : '-';
                                @endphp
                                {{ $position }}
                            @else
                                {{ $talent->job_preferences ?? '-' }}
                            @endif
                        </span>
                    </div>
                    @if($profile && $profile->job_interest)
                    <div>
                        <span class="block text-xs text-slate-400 font-medium mb-0.5">Minat Spesifik</span>
                        <span class="block text-sm font-medium text-slate-700">{{ $profile->job_interest }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Work History Timeline -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
            <h3 class="text-lg font-bold text-slate-800 mb-6 border-b border-slate-100 pb-3 flex items-center">
                <i class="fas fa-history text-emerald-500 mr-2"></i> Pengalaman Kerja
            </h3>

            @if($workExperiences && $workExperiences->count() > 0)
                <div class="relative pl-4 space-y-6 before:content-[''] before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-100">
                    @foreach($workExperiences as $experience)
                    @php
                        $jobDesc = $experience->job_description;
                        $parts = $jobDesc ? explode(' — ', $jobDesc, 2) : ['-', ''];
                        $position = $parts[0] ?? '-';
                        $description = $parts[1] ?? '';
                    @endphp
                    <div class="relative">
                        <div class="absolute -left-[25px] top-1.5 h-3 w-3 rounded-full border-2 border-white bg-emerald-500 ring-4 ring-emerald-50 shadow-sm"></div>
                        <div class="bg-slate-50/50 p-4 rounded-xl border border-slate-100 hover:border-emerald-100 transition-colors">
                            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-1 mb-2">
                                <div>
                                    <h4 class="text-base font-bold text-slate-800 leading-tight">{{ $position }}</h4>
                                    <div class="text-sm font-medium text-slate-600 flex items-center mt-1">
                                        <i class="far fa-building w-4 text-center mr-1 text-slate-400"></i>
                                        {{ $experience->company_name ?? '-' }}
                                    </div>
                                </div>
                                <span class="inline-flex items-center text-[11px] font-bold text-slate-500 bg-white px-2 py-1 rounded-md border border-slate-200 whitespace-nowrap">
                                    <i class="far fa-calendar-alt mr-1.5"></i> {{ $experience->duration ?? '-' }}
                                </span>
                            </div>
                            
                            @if($description)
                                <div class="text-sm text-slate-600 leading-relaxed mt-3 pt-3 border-t border-slate-200">
                                    {{ $description }}
                                </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 bg-slate-50/50 rounded-xl border border-dashed border-slate-200">
                    <div class="inline-flex w-12 h-12 rounded-full bg-white shadow-sm items-center justify-center text-slate-300 mb-3 text-xl">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <p class="text-slate-500 text-sm font-medium">Belum ada riwayat pengalaman kerja.</p>
                </div>
            @endif
        </div>

        <!-- Dokumen Kandidat Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
            <h3 class="text-lg font-bold text-slate-800 mb-6 border-b border-slate-100 pb-3 flex items-center">
                <i class="fas fa-folder-open text-rose-500 mr-2"></i> Dokumen Pendukung Kandidat
            </h3>

            @php
                 $docs = [
                    ['title' => 'CV / Resume', 'path' => optional($profile)->cv_path, 'icon' => 'fa-file-pdf', 'color' => 'text-blue-600', 'bg' => 'bg-blue-50'],
                    ['title' => 'Foto Formal', 'path' => optional($profile)->formal_photo_path, 'icon' => 'fa-id-badge', 'color' => 'text-blue-500', 'bg' => 'bg-blue-50'],
                    ['title' => 'KTP', 'path' => optional($profile)->ktp_path, 'icon' => 'fa-address-card', 'color' => 'text-indigo-500', 'bg' => 'bg-indigo-50'],
                    ['title' => 'Kartu Keluarga', 'path' => optional($profile)->kk_path, 'icon' => 'fa-users', 'color' => 'text-purple-500', 'bg' => 'bg-purple-50'],
                    ['title' => 'NPWP', 'path' => optional($profile)->npwp_path, 'icon' => 'fa-file-invoice-dollar', 'color' => 'text-emerald-500', 'bg' => 'bg-emerald-50'],
                    ['title' => 'Ijazah Terakhir', 'path' => optional($profile)->ijazah_path, 'icon' => 'fa-graduation-cap', 'color' => 'text-amber-500', 'bg' => 'bg-amber-50'],
                    ['title' => 'Sertifikat', 'path' => optional($profile)->certificate_path, 'icon' => 'fa-certificate', 'color' => 'text-rose-500', 'bg' => 'bg-rose-50'],
                ];
            @endphp
            
            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach($docs as $doc)
                    @if($doc['path'])
                        <a href="{{ asset('storage/' . $doc['path']) }}" target="_blank" 
                           class="group flex flex-col items-center p-4 bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-md hover:border-blue-300 transition-all text-center">
                            <div class="w-10 h-10 {{ $doc['bg'] }} {{ $doc['color'] }} rounded-lg flex items-center justify-center text-lg mb-2 group-hover:scale-110 transition-transform">
                                <i class="fas {{ $doc['icon'] }}"></i>
                            </div>
                            <h5 class="text-xs font-bold text-slate-700 leading-tight mb-1">{{ $doc['title'] }}</h5>
                            <span class="text-[10px] text-blue-500 font-medium mt-auto opacity-0 group-hover:opacity-100 transition-opacity">Lihat &rarr;</span>
                        </a>
                    @else
                        <div class="flex flex-col items-center p-4 bg-slate-50/50 rounded-xl border border-dashed border-slate-200 text-center opacity-75">
                            <div class="w-10 h-10 bg-slate-100 text-slate-300 rounded-lg flex items-center justify-center text-lg mb-2">
                                <i class="fas {{ $doc['icon'] }}"></i>
                            </div>
                            <h5 class="text-xs font-medium text-slate-500 leading-tight">{{ $doc['title'] }}</h5>
                            <span class="text-[10px] text-slate-400 mt-1">Kosong</span>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection