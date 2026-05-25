<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - TERANG By SRT</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('images/terang.png') }}">
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50 font-sans" x-data="registerFlow()">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-block mb-4">
                <img src="{{ asset('images/terang.png') }}" alt="TERANG By SRT" class="h-16 w-auto mx-auto">
            </a>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Buat Akun Pelamar</h1>
            <p class="text-gray-600">Isi informasi Anda untuk mulai melamar pekerjaan</p>
        </div>

        <!-- Modal Popup: Sumber Info Lowongan -->
        <div x-cloak x-show="step === 'source'" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 p-8 max-w-md w-full mx-4" @click.away="if(referralSource) step='form'">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-info-circle text-blue-600 text-2xl"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">Darimana Anda Mengetahui Lowongan Ini?</h2>
                </div>
                <div class="space-y-3">
                    <label class="flex items-center p-4 rounded-xl border-2 cursor-pointer transition-all" :class="referralSource === 'Sosial Media' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300'" @click="selectSource('Sosial Media')">
                        <input type="radio" name="source_radio" value="Sosial Media" class="h-4 w-4 text-blue-600 focus:ring-blue-500" x-model="referralSource">
                        <div class="ml-3 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                                <i class="fab fa-instagram text-lg"></i>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-800">Sosial Media</span>
                                <p class="text-xs text-gray-500">Instagram, Facebook, LinkedIn, dll</p>
                            </div>
                        </div>
                    </label>
                    <label class="flex items-center p-4 rounded-xl border-2 cursor-pointer transition-all" :class="referralSource === 'M28' ? 'border-purple-500 bg-purple-50' : 'border-gray-200 hover:border-gray-300'" @click="selectSource('M28')">
                        <input type="radio" name="source_radio" value="M28" class="h-4 w-4 text-purple-600 focus:ring-purple-500" x-model="referralSource">
                        <div class="ml-3 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center text-purple-600">
                                <i class="fas fa-handshake text-lg"></i>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-800">M28</span>
                                <p class="text-xs text-gray-500">Kerjasama dengan M28 Outsourcing</p>
                            </div>
                        </div>
                    </label>
                    <label class="flex items-center p-4 rounded-xl border-2 cursor-pointer transition-all" :class="referralSource === 'other' && referralOther !== '' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-gray-300'" @click="selectSource('other')">
                        <input type="radio" name="source_radio" value="other" class="h-4 w-4 text-green-600 focus:ring-green-500" x-model="referralSource">
                        <div class="ml-3 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center text-green-600">
                                <i class="fas fa-pen text-lg"></i>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-800">Lainnya</span>
                                <p class="text-xs text-gray-500">Teman, Email, atau sumber lainnya</p>
                            </div>
                        </div>
                    </label>
                    <div x-show="referralSource === 'other'" x-cloak class="pl-4">
                        <input type="text" x-model="referralOther" placeholder="Sebutkan sumbernya..." class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-sm" @keyup.enter="if(referralOther) proceedToForm()">
                    </div>
                </div>
                <div class="mt-6">
                    <button @click="proceedToForm()" class="w-full px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:ring-blue-300 font-semibold shadow-lg transition-all" :disabled="!canProceed" :class="!canProceed ? 'opacity-60 cursor-not-allowed' : ''">
                        Lanjutkan <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div x-cloak x-show="step === 'form'" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <input type="hidden" name="referral_source" x-model="finalSource">

                @if ($errors->any())
                    <div class="p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-circle mt-0.5 mr-3 text-red-500"></i>
                            <div>
                                <p class="font-semibold mb-1">Terjadi beberapa kesalahan:</p>
                                <ul class="list-disc list-inside text-sm space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Sumber Informasi (read-only display) -->
                <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl border border-blue-200 p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center"
                                 :class="referralSource === 'M28' ? 'bg-purple-100 text-purple-600' : referralSource === 'Sosial Media' ? 'bg-blue-100 text-blue-600' : 'bg-green-100 text-green-600'">
                                <i class="fas" :class="referralSource === 'M28' ? 'fa-handshake' : referralSource === 'Sosial Media' ? 'fa-instagram' : 'fa-pen'"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Sumber Informasi</p>
                                <p class="font-semibold text-gray-800" x-text="displaySource"></p>
                            </div>
                        </div>
                        <button type="button" @click="openSourceModal()" class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                            <i class="fas fa-pencil-alt mr-1"></i>Ubah
                        </button>
                    </div>
                </div>

                <!-- Informasi Akun -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Informasi Akun</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <x-input-error :messages="$errors->get('name')" class="mt-1" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Panggilan</label>
                            <input type="text" name="nickname" value="{{ old('nickname') }}" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <x-input-error :messages="$errors->get('nickname')" class="mt-1" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
                            <input type="tel" name="phone_number" value="{{ old('phone_number') }}" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <x-input-error :messages="$errors->get('phone_number')" class="mt-1" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="password" name="password" required id="regPassword"
                                       class="block w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <button type="button" onclick="toggleRegPassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-600 transition-colors">
                                    <i class="fas fa-eye" id="regPwIcon"></i>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="password" name="password_confirmation" required id="regPasswordConfirm"
                                       class="block w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <button type="button" onclick="toggleRegPasswordConfirm()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-600 transition-colors">
                                    <i class="fas fa-eye" id="regPwConfirmIcon"></i>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                        </div>
                    </div>
                </div>

                <!-- Informasi Pribadi -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Informasi Pribadi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" required class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <x-input-error :messages="$errors->get('date_of_birth')" class="mt-1" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenjang Pendidikan <span class="text-red-500">*</span></label>
                            <select name="education_level" required class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <option value="">Pilih Jenjang</option>
                                <option value="SMK/Sederajat" @if(old('education_level')=='SMK/Sederajat') selected @endif>SMK/Sederajat</option>
                                <option value="D3" @if(old('education_level')=='D3') selected @endif>D3</option>
                                <option value="S1" @if(old('education_level')=='S1') selected @endif>S1</option>
                                <option value="S2" @if(old('education_level')=='S2') selected @endif>S2</option>
                                <option value="S3" @if(old('education_level')=='S3') selected @endif>S3</option>
                            </select>
                            <x-input-error :messages="$errors->get('education_level')" class="mt-1" />
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Institusi <span class="text-red-500">*</span></label>
                            <input type="text" name="institution" value="{{ old('institution') }}" required class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <x-input-error :messages="$errors->get('institution')" class="mt-1" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jurusan <span class="text-red-500">*</span></label>
                            <input type="text" name="major" value="{{ old('major') }}" required class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <x-input-error :messages="$errors->get('major')" class="mt-1" />
                        </div>
                    </div>
                </div>

                <!-- Riwayat Pekerjaan -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Riwayat Pekerjaan (Opsional)</h3>
                    <div class="space-y-4">
                        <!-- Work Experience 1 -->
                        <div class="p-5 border border-gray-200 rounded-xl bg-gray-50">
                            <p class="text-sm font-semibold text-gray-700 mb-3">Pekerjaan Terakhir</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Perusahaan</label>
                                    <input type="text" name="experience[0][company]" placeholder="Nama Perusahaan" value="{{ old('experience.0.company') }}" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Posisi</label>
                                    <input type="text" name="experience[0][position]" placeholder="Jabatan Anda" value="{{ old('experience.0.position') }}" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Durasi</label>
                                    <input type="text" name="experience[0][duration]" placeholder="Contoh: 2 tahun 3 bulan" value="{{ old('experience.0.duration') }}" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                                    <input type="text" name="experience[0][jobdesk]" placeholder="Tanggung jawab utama" value="{{ old('experience.0.jobdesk') }}" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                                </div>
                            </div>
                        </div>

                        <!-- Work Experience 2 -->
                        <div class="p-5 border border-gray-200 rounded-xl bg-gray-50">
                            <p class="text-sm font-semibold text-gray-700 mb-3">Pekerjaan Sebelumnya</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Perusahaan</label>
                                    <input type="text" name="experience[1][company]" placeholder="Nama Perusahaan" value="{{ old('experience.1.company') }}" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Posisi</label>
                                    <input type="text" name="experience[1][position]" placeholder="Jabatan Anda" value="{{ old('experience.1.position') }}" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Durasi</label>
                                    <input type="text" name="experience[1][duration]" placeholder="Contoh: 1 tahun 6 bulan" value="{{ old('experience.1.duration') }}" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                                    <input type="text" name="experience[1][jobdesk]" placeholder="Tanggung jawab utama" value="{{ old('experience.1.jobdesk') }}" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Tambahan -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Informasi Tambahan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="currently_employed" name="currently_employed" value="1" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" {{ old('currently_employed') ? 'checked' : '' }}>
                            <label for="currently_employed" class="ml-2 text-sm text-gray-700">Sedang bekerja saat ini</label>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ekspektasi Gaji (IDR/bulan) <span class="text-red-500">*</span></label>
                            <input type="number" name="expected_salary" value="{{ old('expected_salary') }}" required class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="5000000">
                            <x-input-error :messages="$errors->get('expected_salary')" class="mt-1" />
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tentang Saya</label>
                        <textarea name="about_me" rows="3" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Ceritakan sedikit tentang diri Anda...">{{ old('about_me') }}</textarea>
                    </div>
                </div>

                <!-- Upload Files -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Dokumen Pendukung</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Unggah CV (PDF) - Maks 2MB <span class="text-red-500">*</span></label>
                            <input type="file" name="cv" accept=".pdf" required class="block w-full text-sm text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                            <x-input-error :messages="$errors->get('cv')" class="mt-1" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pas Foto Formal - Maks 2MB <span class="text-red-500">*</span></label>
                            <input type="file" name="formal_photo" accept="image/*" required class="block w-full text-sm text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                            <x-input-error :messages="$errors->get('formal_photo')" class="mt-1" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto KTP - Maks 2MB <span class="text-red-500">*</span></label>
                            <input type="file" name="ktp" accept="image/*" required class="block w-full text-sm text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                            <x-input-error :messages="$errors->get('ktp')" class="mt-1" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Kartu Keluarga - Maks 2MB <span class="text-red-500">*</span></label>
                            <input type="file" name="kk" accept="image/*" required class="block w-full text-sm text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                            <x-input-error :messages="$errors->get('kk')" class="mt-1" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">NPWP (Opsional) - Maks 2MB</label>
                            <input type="file" name="npwp" accept="image/*" class="block w-full text-sm text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                            <x-input-error :messages="$errors->get('npwp')" class="mt-1" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ijazah Terakhir - Maks 2MB <span class="text-red-500">*</span></label>
                            <input type="file" name="ijazah" accept=".pdf,image/*" required class="block w-full text-sm text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                            <x-input-error :messages="$errors->get('ijazah')" class="mt-1" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sertifikat (opsional) - Maks 2MB</label>
                            <input type="file" name="certificate" accept=".pdf,image/*" class="block w-full text-sm text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                            <x-input-error :messages="$errors->get('certificate')" class="mt-1" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profil Bebas (opsional) - Maks 2MB</label>
                            <input type="file" name="photo" accept="image/*" class="block w-full text-sm text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                            <x-input-error :messages="$errors->get('photo')" class="mt-1" />
                        </div>
                    </div>
                </div>

                <!-- Agreement -->
                <div class="mt-4 text-sm text-gray-700">
                    <label class="inline-flex items-start space-x-3">
                        <input id="terms-agree" type="checkbox" name="terms" value="1" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mt-1">
                        <span>Saya menyetujui <a href="{{ route('terms') }}" target="_blank" class="text-blue-600 hover:underline">Syarat &amp; Ketentuan TERANG By SRT</a></span>
                    </label>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6">
                    <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-blue-600 transition">
                        <i class="fas fa-arrow-left mr-2"></i>Sudah punya akun? Login
                    </a>
                    <button id="register-button" type="submit" disabled class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:ring-blue-300 font-semibold shadow-lg hover:shadow-xl transition-all opacity-60 cursor-not-allowed">
                        <i class="fas fa-user-plus mr-2"></i>Buat Akun
                    </button>
                </div>
            </form>
        </div>

        <!-- Footer Link -->
        <div x-cloak x-show="step === 'form'" class="text-center mt-6 text-sm text-gray-600">
            <p>Dengan mendaftar, Anda menyetujui <a href="{{ route('terms') }}" class="text-blue-600 hover:underline">Syarat & Ketentuan</a> kami</p>
        </div>
        
        <script>
            function registerFlow() {
                return {
                    step: 'source',
                    referralSource: '',
                    referralOther: '',
                    get finalSource() {
                        if (this.referralSource === 'other') {
                            return this.referralOther;
                        }
                        return this.referralSource;
                    },
                    get displaySource() {
                        if (this.referralSource === 'other') {
                            return this.referralOther || 'Lainnya';
                        }
                        return this.referralSource;
                    },
                    get canProceed() {
                        if (this.referralSource === 'other') {
                            return this.referralOther.trim() !== '';
                        }
                        return this.referralSource !== '';
                    },
                    selectSource(source) {
                        this.referralSource = source;
                    },
                    proceedToForm() {
                        if (!this.canProceed) return;
                        this.step = 'form';
                        document.body.style.overflow = 'auto';
                    },
                    openSourceModal() {
                        this.step = 'source';
                        document.body.style.overflow = 'hidden';
                    }
                };
            }

            document.addEventListener('DOMContentLoaded', function () {
                const checkbox = document.getElementById('terms-agree');
                const button = document.getElementById('register-button');
                function update() {
                    if (checkbox && button) {
                        if (checkbox.checked) {
                            button.removeAttribute('disabled');
                            button.classList.remove('opacity-60', 'cursor-not-allowed');
                        } else {
                            button.setAttribute('disabled', 'disabled');
                            button.classList.add('opacity-60', 'cursor-not-allowed');
                        }
                    }
                }
                if (checkbox) checkbox.addEventListener('change', update);
                update();

                // Prevent ERR_UPLOAD_FILE_CHANGED on Mobile
                const form = document.querySelector('form');
                if (form) {
                    form.addEventListener('submit', async function(e) {
                        if (form.dataset.validating === "1") {
                            e.preventDefault();
                            return;
                        }
                        if (form.dataset.validated === "1") {
                            return;
                        }
                        e.preventDefault();
                        form.dataset.validating = "1";
                        
                        const fileInputs = form.querySelectorAll('input[type="file"]');
                        let hasError = false;
                        
                        const checkFile = (file) => {
                            return new Promise((resolve, reject) => {
                                const reader = new FileReader();
                                reader.onload = () => resolve(true);
                                reader.onerror = () => reject(reader.error);
                                reader.readAsArrayBuffer(file.slice(0, 1));
                            });
                        };

                        for (const input of fileInputs) {
                            if (input.files.length > 0) {
                                const file = input.files[0];
                                try {
                                    await checkFile(file);
                                } catch (err) {
                                    hasError = true;
                                    alert('Maaf, file "' + file.name + '" sudah tidak dapat diakses (mungkin dipindahkan atau dihapus oleh sistem HP Anda). Silakan pilih ulang file tersebut.');
                                    input.value = ''; // Reset the invalid file
                                }
                            }
                        }
                        
                        form.dataset.validating = "0";
                        if (!hasError) {
                            form.dataset.validated = "1";
                            if (button) {
                                button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mendaftar...';
                                button.classList.add('opacity-80', 'cursor-not-allowed');
                                button.setAttribute('disabled', 'disabled');
                            }
                            form.submit();
                        }
                    });
                }
            });
        </script>
        <script>
            function toggleRegPassword() {
                const input = document.getElementById('regPassword');
                const icon = document.getElementById('regPwIcon');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.className = 'fas fa-eye-slash';
                } else {
                    input.type = 'password';
                    icon.className = 'fas fa-eye';
                }
            }
            function toggleRegPasswordConfirm() {
                const input = document.getElementById('regPasswordConfirm');
                const icon = document.getElementById('regPwConfirmIcon');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.className = 'fas fa-eye-slash';
                } else {
                    input.type = 'password';
                    icon.className = 'fas fa-eye';
                }
            }
        </script>
    </div>
</body>
</html>
