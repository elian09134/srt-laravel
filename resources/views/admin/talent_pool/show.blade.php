@extends('layouts.admin')

@section('title', 'Detail Kandidat - ' . $user->name)

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white rounded-xl p-6 shadow">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">{{ $user->name }}</h3>
                    <p class="text-gray-600">{{ $user->email }}</p>
                    <p class="text-sm text-gray-500">Bergabung: {{ $user->created_at->format('d M Y') }}</p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        {{ $talent->status == 'available' ? 'bg-green-100 text-green-800' :
                           ($talent->status == 'contacted' ? 'bg-blue-100 text-blue-800' :
                           ($talent->status == 'hired' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-700')) }}">
                        {{ ucfirst($talent->status) }}
                    </span>
                    <a href="{{ route('admin.talent_pool.index') }}" class="text-gray-600 hover:text-gray-900">
                        ← Kembali ke Talent Pool
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Profile Information -->
            <div class="lg:col-span-2 space-y-6">
                @if($profile)
                <!-- Personal Information -->
                <div class="bg-white rounded-xl p-6 shadow">
                    <h4 class="text-lg font-semibold mb-4">Informasi Pribadi</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($profile->nickname)
                        <div>
                            <label class="text-sm font-medium text-gray-700">Nama Panggilan</label>
                            <p class="text-gray-900">{{ $profile->nickname }}</p>
                        </div>
                        @endif
                        @if($profile->date_of_birth)
                        <div>
                            <label class="text-sm font-medium text-gray-700">Tanggal Lahir</label>
                            <p class="text-gray-900">{{ $profile->formatted_date_of_birth }}</p>
                        </div>
                        @endif
                        @if($profile->phone_number)
                        <div>
                            <label class="text-sm font-medium text-gray-700">No. Telepon</label>
                            <p class="text-gray-900">{{ $profile->phone_number }}</p>
                        </div>
                        @endif
                        @if($profile->address)
                        <div class="md:col-span-2">
                            <label class="text-sm font-medium text-gray-700">Alamat</label>
                            <p class="text-gray-900">{{ $profile->address }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Education -->
                @if($profile->education_level || $profile->institution)
                <div class="bg-white rounded-xl p-6 shadow">
                    <h4 class="text-lg font-semibold mb-4">Pendidikan</h4>
                    <div class="space-y-2">
                        @if($profile->education_level)
                        <div>
                            <label class="text-sm font-medium text-gray-700">Tingkat Pendidikan</label>
                            <p class="text-gray-900">{{ $profile->education_level }}</p>
                        </div>
                        @endif
                        @if($profile->institution)
                        <div>
                            <label class="text-sm font-medium text-gray-700">Institusi</label>
                            <p class="text-gray-900">{{ $profile->institution }}</p>
                        </div>
                        @endif
                        @if($profile->major)
                        <div>
                            <label class="text-sm font-medium text-gray-700">Jurusan</label>
                            <p class="text-gray-900">{{ $profile->major }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Skills & Interests -->
                @if($profile->skills || $profile->languages || $profile->job_interest)
                <div class="bg-white rounded-xl p-6 shadow">
                    <h4 class="text-lg font-semibold mb-4">Keterampilan & Minat</h4>
                    <div class="space-y-4">
                        @if($profile->skills)
                        <div>
                            <label class="text-sm font-medium text-gray-700">Keterampilan</label>
                            <p class="text-gray-900">{{ $profile->skills }}</p>
                        </div>
                        @endif
                        @if($profile->languages)
                        <div>
                            <label class="text-sm font-medium text-gray-700">Bahasa</label>
                            <p class="text-gray-900">{{ $profile->languages }}</p>
                        </div>
                        @endif
                        @if($profile->job_interest)
                        <div>
                            <label class="text-sm font-medium text-gray-700">Minat Pekerjaan</label>
                            <p class="text-gray-900">{{ $profile->job_interest }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- About Me -->
                @if($profile->about_me)
                <div class="bg-white rounded-xl p-6 shadow">
                    <h4 class="text-lg font-semibold mb-4">Tentang Saya</h4>
                    <p class="text-gray-700 leading-relaxed">{{ $profile->about_me }}</p>
                </div>
                @endif

                <!-- Last Job Information -->
                @if($profile->last_company || $profile->last_position || $profile->last_company_duration)
                <div class="bg-white rounded-xl p-6 shadow">
                    <h4 class="text-lg font-semibold mb-4">Pekerjaan Terakhir</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($profile->last_company)
                        <div>
                            <label class="text-sm font-medium text-gray-700">Perusahaan</label>
                            <p class="text-gray-900">{{ $profile->last_company }}</p>
                        </div>
                        @endif
                        @if($profile->last_position)
                        <div>
                            <label class="text-sm font-medium text-gray-700">Posisi</label>
                            <p class="text-gray-900">{{ $profile->last_position }}</p>
                        </div>
                        @endif
                        @if($profile->last_company_duration)
                        <div class="md:col-span-2">
                            <label class="text-sm font-medium text-gray-700">Lama Bekerja</label>
                            <p class="text-gray-900">{{ $profile->last_company_duration }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Work Experience -->
                @if($workExperiences->count() > 0)
                <div class="bg-white rounded-xl p-6 shadow">
                    <h4 class="text-lg font-semibold mb-4">Pengalaman Kerja</h4>
                    <div class="space-y-4">
                        @foreach($workExperiences as $experience)
                        <div class="border-l-4 border-blue-500 pl-4">
                            <h5 class="font-medium text-gray-900">{{ $experience->position }}</h5>
                            <p class="text-gray-600">{{ $experience->company }}</p>
                            <p class="text-sm text-gray-500">
                                {{ $experience->start_date->format('M Y') }} -
                                {{ $experience->end_date ? $experience->end_date->format('M Y') : 'Sekarang' }}
                                @if($experience->duration_months)
                                ({{ $experience->duration_months }} bulan)
                                @endif
                            </p>
                            @if($experience->description)
                            <p class="text-gray-700 mt-2">{{ $experience->description }}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                @else
                <div class="bg-white rounded-xl p-6 shadow">
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada profil</h3>
                        <p class="mt-1 text-sm text-gray-500">Kandidat ini belum melengkapi informasi profilnya.</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Talent Pool Info -->
                <div class="bg-white rounded-xl p-6 shadow">
                    <h4 class="text-lg font-semibold mb-4">Status Talent Pool</h4>
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm font-medium text-gray-700">Status</label>
                            <p class="text-gray-900">{{ ucfirst($talent->status) }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">Ditambahkan</label>
                            <p class="text-gray-900">{{ $talent->created_at->format('d M Y H:i') }}</p>
                        </div>
                        @if($talent->job_preferences)
                        <div>
                            <label class="text-sm font-medium text-gray-700">Preferensi Pekerjaan</label>
                            <p class="text-gray-900">{{ $talent->job_preferences }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Files -->
                @if($profile && ($profile->cv_path || $profile->photo_path))
                <div class="bg-white rounded-xl p-6 shadow">
                    <h4 class="text-lg font-semibold mb-4">File Lampiran</h4>
                    <div class="space-y-3">
                        @if($profile->photo_path)
                        <div>
                            <label class="text-sm font-medium text-gray-700">Foto Profil</label>
                            <div class="mt-1">
                                <img src="{{ asset('storage/' . $profile->photo_path) }}" alt="Profile Photo" class="w-20 h-20 rounded-lg object-cover">
                            </div>
                        </div>
                        @endif
                        @if($profile->cv_path)
                        <div>
                            <label class="text-sm font-medium text-gray-700">CV/Resume</label>
                            <div class="mt-1">
                                <a href="{{ asset('storage/' . $profile->cv_path) }}" target="_blank" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Lihat CV
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection