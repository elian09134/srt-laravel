<section>
    <header class="mb-8">
        <div class="flex items-center gap-3 mb-3">
            <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    Informasi Profil
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Perbarui informasi profil Anda untuk melamar pekerjaan
                </p>
            </div>
        </div>
    </header>

    @if(session('success'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/50 border-l-4 border-green-500 p-4 rounded-r-lg">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-green-700 dark:text-green-300 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('patch')

        <!-- Informasi Dasar Section -->
        <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                </svg>
                Informasi Dasar
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="name" :value="__('Nama Lengkap')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label for="nickname" :value="__('Nama Panggilan')" />
                    <x-text-input id="nickname" name="nickname" type="text" class="mt-1 block w-full" :value="old('nickname', $user->profile->nickname ?? '')" required />
                    <x-input-error class="mt-2" :messages="$errors->get('nickname')" />
                </div>
            </div>
        </div>

        <!-- Informasi Kontak Section -->
        <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                </svg>
                Informasi Kontak
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <div>
                    <x-input-label for="phone_number" :value="__('Nomor Telepon')" />
                    <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full" :value="old('phone_number', $user->profile->phone_number ?? '')" required />
                    <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
                </div>
            </div>
        </div>

        <!-- Informasi Pribadi Section -->
        <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1z" clip-rule="evenodd"></path>
                </svg>
                Informasi Pribadi
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="date_of_birth" :value="__('Tanggal Lahir')" />
                    <x-text-input id="date_of_birth" name="date_of_birth" type="date" class="mt-1 block w-full" :value="old('date_of_birth', $user->profile->date_of_birth ? $user->profile->date_of_birth->format('Y-m-d') : '')" required />
                    <x-input-error class="mt-2" :messages="$errors->get('date_of_birth')" />
                </div>

                <div>
                    <x-input-label for="photo" :value="__('Foto Profil')" />
                    <div class="mt-2">
                        @if($user->profile && $user->profile->photo_path)
                            <div class="flex items-center gap-4">
                                <img src="{{ asset('storage/' . $user->profile->photo_path) }}" 
                                     alt="Current Photo" 
                                     class="w-24 h-24 rounded-xl object-cover border-2 border-gray-200 dark:border-gray-600 shadow-md">
                                <div class="flex-1">
                                    <input type="file" 
                                           id="photo" 
                                           name="photo" 
                                           accept="image/*" 
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-blue-900/50 file:text-blue-700 dark:file:text-blue-300 hover:file:bg-blue-100 dark:hover:file:bg-blue-900 transition-colors" />
                                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Maksimal 2MB (JPG, PNG)</p>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-4">
                                <div class="w-24 h-24 rounded-xl bg-gray-200 dark:bg-gray-700 flex items-center justify-center border-2 border-gray-300 dark:border-gray-600">
                                    <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <input type="file" 
                                           id="photo" 
                                           name="photo" 
                                           accept="image/*" 
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-blue-900/50 file:text-blue-700 dark:file:text-blue-300 hover:file:bg-blue-100 dark:hover:file:bg-blue-900 transition-colors" />
                                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Maksimal 2MB (JPG, PNG)</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('photo')" />
                </div>
            </div>
        </div>

        <!-- Tentang Saya Section -->
        <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                </svg>
                Tentang Saya
            </h3>
            <div>
                <textarea id="about_me" 
                          name="about_me" 
                          rows="5" 
                          class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 rounded-lg shadow-sm transition-colors" 
                          placeholder="Ceritakan tentang diri Anda, pengalaman, dan tujuan karir..."
                          required>{{ old('about_me', $user->profile->about_me ?? '') }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('Tentang Saya')" />
            </div>
        </div>

        <!-- Informasi Pendidikan Section -->
        <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                </svg>
                Pendidikan
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <x-input-label for="education_level" :value="__('Jenjang Pendidikan')" />
                    <select id="education_level" name="education_level" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                        <option value="">Pilih Tingkat Pendidikan</option>
                        <option value="SMA" {{ old('education_level', $user->profile->education_level ?? '') == 'SMA' ? 'selected' : '' }}>SMA</option>
                        <option value="D3" {{ old('education_level', $user->profile->education_level ?? '') == 'D3' ? 'selected' : '' }}>D3</option>
                        <option value="S1" {{ old('education_level', $user->profile->education_level ?? '') == 'S1' ? 'selected' : '' }}>S1</option>
                        <option value="S2" {{ old('education_level', $user->profile->education_level ?? '') == 'S2' ? 'selected' : '' }}>S2</option>
                        <option value="S3" {{ old('education_level', $user->profile->education_level ?? '') == 'S3' ? 'selected' : '' }}>S3</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('education_level')" />
                </div>

                <div>
                    <x-input-label for="institution" :value="__('Institusi')" />
                    <x-text-input id="institution" name="institution" type="text" class="mt-1 block w-full" :value="old('institution', $user->profile->institution ?? '')" required />
                    <x-input-error class="mt-2" :messages="$errors->get('institusi')" />
                </div>

                <div>
                    <x-input-label for="major" :value="__('Jurusan/Bidang Studi')" />
                    <x-text-input id="major" name="major" type="text" class="mt-1 block w-full" :value="old('major', $user->profile->major ?? '')" required />
                    <x-input-error class="mt-2" :messages="$errors->get('major')" />
                </div>
            </div>
        </div>

        <!-- Pengalaman Kerja Section -->
        <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"></path>
                </svg>
                Pengalaman Kerja Terakhir
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <x-input-label for="last_company" :value="__('Perusahaan Terakhir')" />
                    <x-text-input id="last_company" name="last_company" type="text" class="mt-1 block w-full" :value="old('last_company', $user->profile->last_company ?? '')" />
                    <x-input-error class="mt-2" :messages="$errors->get('last_company')" />
                </div>

                <div>
                    <x-input-label for="last_position" :value="__('Posisi Terakhir')" />
                    <x-text-input id="last_position" name="last_position" type="text" class="mt-1 block w-full" :value="old('last_position', $user->profile->last_position ?? '')" />
                    <x-input-error class="mt-2" :messages="$errors->get('last_position')" />
                </div>

                <div>
                    <x-input-label for="last_company_duration" :value="__('Durasi Bekerja')" />
                    <x-text-input id="last_company_duration" name="last_company_duration" type="text" class="mt-1 block w-full" :value="old('last_company_duration', $user->profile->last_company_duration ?? '')" placeholder="contoh: 2 tahun 3 bulan" />
                    <x-input-error class="mt-2" :messages="$errors->get('last_company_duration')" />
                </div>
            </div>
        </div>

        <!-- Keterampilan & Minat Section -->
        <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
                Keterampilan & Minat
            </h3>
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="skills" :value="__('Skills')" />
                        <x-text-input id="skills" name="skills" type="text" class="mt-1 block w-full" :value="old('skills', $user->profile->skills ?? '')" placeholder="contoh: PHP, JavaScript, MySQL" />
                        <x-input-error class="mt-2" :messages="$errors->get('skills')" />
                    </div>

                    <div>
                        <x-input-label for="languages" :value="__('Bahasa')" />
                        <x-text-input id="languages" name="languages" type="text" class="mt-1 block w-full" :value="old('languages', $user->profile->languages ?? '')" placeholder="contoh: English, Indonesian" />
                        <x-input-error class="mt-2" :messages="$errors->get('languages')" />
                    </div>
                </div>

                <div>
                    <x-input-label for="job_interest" :value="__('Minat Pekerjaan')" />
                    <x-text-input id="job_interest" name="job_interest" type="text" class="mt-1 block w-full" :value="old('job_interest', $user->profile->job_interest ?? '')" placeholder="contoh: Web Developer, Software Engineer" />
                    <x-input-error class="mt-2" :messages="$errors->get('job_interest')" />
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-4">
                <button type="submit" 
                        class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    {{ __('Simpan Perubahan') }}
                </button>

                @if (session('status') === 'profile-updated')
                    <div x-data="{ show: true }" 
                         x-show="show" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-90"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-init="setTimeout(() => show = false, 3000)" 
                         class="flex items-center gap-2 px-4 py-2 bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-700 rounded-lg">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm font-medium text-green-600 dark:text-green-400">Tersimpan!</span>
                    </div>
                @endif
            </div>
        </div>
    </form>
</section>
