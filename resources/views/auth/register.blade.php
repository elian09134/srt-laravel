<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - SRT Corp</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50">

    <div class="flex flex-col items-center justify-center min-h-screen p-4 sm:p-6 lg:p-8">
        <div class="w-full max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="p-8 sm:p-12">
                <div class="text-center">
                    <a href="{{ route('home') }}" class="text-3xl font-bold text-gray-900">SRT <span class="text-blue-700">Corp</span></a>
                    <h1 class="mt-6 text-3xl font-bold text-gray-900">Buat Akun Pelamar</h1>
                    <p class="mt-2 text-gray-600">Lengkapi data di bawah untuk memulai perjalanan karir Anda bersama kami.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="mt-10 space-y-12">
                    @csrf
                    
                    <!-- Bagian Informasi Akun -->
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">Informasi Akun</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                <input type="password" id="password" name="password" required autocomplete="new-password" class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Bagian Data Diri -->
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">Data Diri</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                             <div>
                                <label for="nickname" class="block text-sm font-medium text-gray-700">Nama Panggilan</label>
                                <input type="text" id="nickname" name="nickname" value="{{ old('nickname') }}" required class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-gray-700">Nomor HP</label>
                                <input type="tel" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="about_me" class="block text-sm font-medium text-gray-700">Tentang Saya</label>
                                <textarea id="about_me" name="about_me" rows="4" required class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('about_me') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Bagian Pendidikan -->
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">Pendidikan Terakhir</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div>
                                <label for="education_level" class="block text-sm font-medium text-gray-700">Jenjang</label>
                                <select id="education_level" name="education_level" required class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option>Pilih Jenjang</option>
                                    <option value="SMK/Sederajat" @if(old('education_level') == 'SMK/Sederajat') selected @endif>SMK/Sederajat</option>
                                    <option value="D3" @if(old('education_level') == 'D3') selected @endif>D3</option>
                                    <option value="S1" @if(old('education_level') == 'S1') selected @endif>S1</option>
                                    <option value="S2" @if(old('education_level') == 'S2') selected @endif>S2</option>
                                    <option value="S3" @if(old('education_level') == 'S3') selected @endif>S3</option>
                                </select>
                            </div>
                            <div>
                                <label for="institution" class="block text-sm font-medium text-gray-700">Nama Institusi</label>
                                <input type="text" id="institution" name="institution" value="{{ old('institution') }}" required class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="major" class="block text-sm font-medium text-gray-700">Jurusan</label>
                                <input type="text" id="major" name="major" value="{{ old('major') }}" required class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Bagian Pengalaman Kerja -->
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">Pengalaman Kerja</h2>
                        <div id="work-experience-container" class="space-y-6">
                            <!-- Pengalaman kerja akan ditambahkan di sini oleh JavaScript -->
                        </div>
                        <button type="button" id="add-experience-btn" class="mt-4 text-sm font-medium text-blue-600 hover:text-blue-800">
                            <i class="fas fa-plus mr-2"></i>Tambah Pengalaman Kerja
                        </button>
                    </div>

                    <!-- Bagian Skill & Kompetensi -->
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">Keahlian & Kompetensi</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="skills" class="block text-sm font-medium text-gray-700">Keahlian (pisahkan dengan koma)</label>
                                <input type="text" id="skills" name="skills" value="{{ old('skills') }}" placeholder="Contoh: PHP, JavaScript, Figma" class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="languages" class="block text-sm font-medium text-gray-700">Bahasa yang Dikuasai (pisahkan dengan koma)</label>
                                <input type="text" id="languages" name="languages" value="{{ old('languages') }}" placeholder="Contoh: Indonesia (Aktif), Inggris (Pasif)" class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="job_interest" class="block text-sm font-medium text-gray-700">Minat Kerja</label>
                                <input type="text" id="job_interest" name="job_interest" value="{{ old('job_interest') }}" placeholder="Contoh: Frontend Development, Project Management" class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Bagian Dokumen -->
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">Dokumen & Foto</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="cv" class="block text-sm font-medium text-gray-700">Unggah CV (PDF, maks 2MB)</label>
                                <input type="file" id="cv" name="cv" required accept=".pdf" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <x-input-error :messages="$errors->get('cv')" class="mt-2" />
                            </div>
                            <div>
                                <label for="photo" class="block text-sm font-medium text-gray-700">Unggah Foto (JPG/PNG, maks 1MB, opsional)</label>
                                <input type="file" id="photo" name="photo" accept="image/jpeg, image/png" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="pt-6">
                        <button type="submit"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Buat Akun
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-600">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                            Login di sini
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('work-experience-container');
            const addButton = document.getElementById('add-experience-btn');
            let experienceCount = 0;

            const addExperienceForm = () => {
                experienceCount++;
                const newExperience = document.createElement('div');
                newExperience.className = 'p-4 border rounded-md relative';
                newExperience.innerHTML = `
                    <button type="button" class="remove-experience-btn absolute top-2 right-2 text-gray-400 hover:text-red-500">&times;</button>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="company_${experienceCount}" class="block text-sm font-medium text-gray-700">Nama Perusahaan</label>
                            <input type="text" id="company_${experienceCount}" name="experience[${experienceCount}][company]" class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="duration_${experienceCount}" class="block text-sm font-medium text-gray-700">Waktu Bekerja</label>
                            <input type="text" id="duration_${experienceCount}" name="experience[${experienceCount}][duration]" placeholder="Contoh: 2022 - 2025" class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="sm:col-span-2">
                            <label for="jobdesk_${experienceCount}" class="block text-sm font-medium text-gray-700">Deskripsi Pekerjaan</label>
                            <textarea id="jobdesk_${experienceCount}" name="experience[${experienceCount}][jobdesk]" rows="3" class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                    </div>
                `;
                container.appendChild(newExperience);

                newExperience.querySelector('.remove-experience-btn').addEventListener('click', function () {
                    this.parentElement.remove();
                });
            };

            addExperienceForm();
            addButton.addEventListener('click', addExperienceForm);
        });
    </script>
</body>
</html>
