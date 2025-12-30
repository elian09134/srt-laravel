<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - TERANG By SRT</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('images/terang.png') }}">
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50 font-sans">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-block mb-4">
                <img src="{{ asset('images/terang.png') }}" alt="TERANG By SRT" class="h-16 w-auto mx-auto">
            </a>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Buat Akun Pelamar</h1>
            <p class="text-gray-600">Isi informasi Anda untuk mulai melamar pekerjaan</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

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
                            <input type="password" name="password" required class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password_confirmation" required class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
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
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ekspektasi Gaji (IDR/bulan)</label>
                            <input type="number" name="expected_salary" value="{{ old('expected_salary') }}" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="5000000">
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
                            <label class="block text-sm font-medium text-gray-700 mb-2">Unggah CV (PDF) - Maks 2MB</label>
                            <input type="file" name="cv" accept=".pdf" class="block w-full text-sm text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Unggah Foto (opsional) - Maks 2MB</label>
                            <input type="file" name="photo" accept="image/*" class="block w-full text-sm text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4">
                    <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-blue-600 transition">
                        <i class="fas fa-arrow-left mr-2"></i>Sudah punya akun? Login
                    </a>
                    <button id="register-button" type="submit" disabled class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:ring-blue-300 font-semibold shadow-lg hover:shadow-xl transition-all opacity-60 cursor-not-allowed">
                        <i class="fas fa-user-plus mr-2"></i>Buat Akun
                    </button>
                </div>
            </form>
        </div>

                <!-- Agreement -->
                <div class="mt-4 text-sm text-gray-700">
                    <label class="inline-flex items-start space-x-3">
                        <input id="terms-agree" type="checkbox" name="terms" value="1" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mt-1">
                        <span>Saya menyetujui <a href="{{ route('terms') }}" target="_blank" class="text-blue-600 hover:underline">Syarat &amp; Ketentuan TERANG By SRT</a></span>
                    </label>
                </div>

        <!-- Footer Link -->
        <div class="text-center mt-6 text-sm text-gray-600">
            <p>Dengan mendaftar, Anda menyetujui <a href="{{ route('terms') }}" class="text-blue-600 hover:underline">Syarat & Ketentuan</a> kami</p>
        </div>
        
        <script>
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
            });
        </script>
    </div>
</body>
</html>
