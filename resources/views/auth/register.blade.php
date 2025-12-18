<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - SRT Corp</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .auth-illustration { background-image: linear-gradient(135deg, rgba(59,130,246,0.08) 0%, rgba(96,165,250,0.06) 100%); }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50 font-sans">
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-lg overflow-hidden grid grid-cols-1 md:grid-cols-2">
            <!-- Left: Illustration / Branding -->
            <div class="hidden md:flex flex-col justify-center items-start p-10 auth-illustration">
                <div class="mb-6">
                    <a href="{{ route('home') }}" class="inline-flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center">
                            <span class="text-white font-bold text-xl">S</span>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-gray-900">SRT <span class="text-gray-600">Corp</span></div>
                            <div class="text-sm text-gray-500">Karir & Rekrutmen</div>
                        </div>
                    </a>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Buat Akun Pelamar</h2>
                <p class="text-gray-600">Isi detail Anda untuk mulai melamar. Unggah CV dan foto untuk meningkatkan peluang Anda.</p>
            </div>

            <!-- Right: Form -->
            <div class="p-8 md:p-10">
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    @if ($errors->any())
                        <div class="p-3 bg-red-50 border border-red-100 text-red-700 rounded">
                            <strong class="font-semibold">Terjadi beberapa kesalahan:</strong>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="mt-1 block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Panggilan</label>
                            <input type="text" name="nickname" value="{{ old('nickname') }}" class="mt-1 block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <x-input-error :messages="$errors->get('nickname')" class="mt-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nomor HP</label>
                            <input type="tel" name="phone_number" value="{{ old('phone_number') }}" class="mt-1 block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" required class="mt-1 block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" required class="mt-1 block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" required class="mt-1 block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jenjang Pendidikan</label>
                            <select name="education_level" required class="mt-1 block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih Jenjang</option>
                                <option value="SMK/Sederajat" @if(old('education_level')=='SMK/Sederajat') selected @endif>SMK/Sederajat</option>
                                <option value="D3" @if(old('education_level')=='D3') selected @endif>D3</option>
                                <option value="S1" @if(old('education_level')=='S1') selected @endif>S1</option>
                                <option value="S2" @if(old('education_level')=='S2') selected @endif>S2</option>
                                <option value="S3" @if(old('education_level')=='S3') selected @endif>S3</option>
                            </select>
                            <x-input-error :messages="$errors->get('education_level')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Institusi</label>
                            <input type="text" name="institution" value="{{ old('institution') }}" required class="mt-1 block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <x-input-error :messages="$errors->get('institution')" class="mt-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jurusan</label>
                            <input type="text" name="major" value="{{ old('major') }}" required class="mt-1 block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <x-input-error :messages="$errors->get('major')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Perusahaan Terakhir</label>
                            <input type="text" name="last_company" value="{{ old('last_company') }}" class="mt-1 block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <x-input-error :messages="$errors->get('last_company')" class="mt-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Posisi Terakhir</label>
                            <input type="text" name="last_position" value="{{ old('last_position') }}" class="mt-1 block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <x-input-error :messages="$errors->get('last_position')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Lama Bekerja (contoh: 2 tahun 3 bulan)</label>
                        <input type="text" name="last_company_duration" value="{{ old('last_company_duration') }}" class="mt-1 block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <x-input-error :messages="$errors->get('last_company_duration')" class="mt-2" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tentang Saya</label>
                        <textarea name="about_me" rows="3" class="mt-1 block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('about_me') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Unggah CV (PDF) - Maks 2MB</label>
                            <input type="file" name="cv" accept=".pdf" class="mt-1 block w-full text-sm text-gray-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Unggah Foto (opsional) - Maks 2MB</label>
                            <input type="file" name="photo" accept="image/*" class="mt-1 block w-full text-sm text-gray-500">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:underline">Sudah punya akun? Login</a>
                        <button type="submit" class="ml-4 inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Buat Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // small enhancement: highlight inputs with value
        document.querySelectorAll('input,textarea').forEach(el => {
            el.addEventListener('input', () => el.classList.toggle('has-value', !!el.value));
        });
    </script>
</body>
</html>
