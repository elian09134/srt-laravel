<x-app-layout>
    <main class="container mx-auto p-6 md:p-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Lengkapi Profil Karyawan</h1>
            <p class="text-gray-600 mb-8">Data Anda akan digunakan untuk keperluan administrasi HR. Harap isi dengan lengkap dan benar.</p>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" class="bg-white p-8 rounded-lg shadow-md space-y-12">
                @csrf
                @method('patch')

                <!-- Informasi Pribadi -->
                <div class="space-y-6">
                    <h2 class="text-xl font-semibold text-gray-800 border-b pb-3">Informasi Pribadi</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" value="{{ $user->name }}" readonly class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-gray-700">Nomor HP</label>
                            <input type="tel" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->profile->phone_number ?? '') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label for="place_of_birth" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                            <input type="text" id="place_of_birth" name="place_of_birth" value="{{ old('place_of_birth', $user->employee->place_of_birth ?? '') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                            <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $user->employee->date_of_birth ?? '') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div class="sm:col-span-2">
                            <label for="current_address" class="block text-sm font-medium text-gray-700">Domisili Saat Ini</label>
                            <textarea id="current_address" name="current_address" rows="3" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('current_address', $user->employee->current_address ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                 <!-- Informasi Pekerjaan -->
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold text-gray-800 border-b pb-3">Informasi Pekerjaan</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                             <div>
                                <label for="department" class="block text-sm font-medium text-gray-700">Divisi Penempatan</label>
                                <select id="department" name="department" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">Pilih Divisi</option>
                                    <option value="Wrapping">Wrapping</option>
                                    <option value="Reflexiology">Reflexiology</option>
                                    <option value="Cellular">Cellular</option>
                                    <option value="Minimarket">Minimarket</option>
                                    <option value="Hans">Hans</option>
                                    <option value="F&B">F&B</option>
                                    <option value="Human Resources Development">Human Resources Development</option>
                                    <option value="Bussiness Development">Bussiness Development</option>
                                    <option value="Finance Accountiing & Tax">Finance Accounting & Tax</option>
                                    <option value="training & Development">Training & Development</option>
                                    <option value="Internal Keuangan">Project</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div id="location-container" class="hidden">
                                <label for="location" class="block text-sm font-medium text-gray-700">Lokasi Penempatan</label>
                                <select id="location" name="location" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <!-- Opsi lokasi akan diisi oleh JavaScript -->
                                </select>
                            </div>
                            <div>
                                <label for="position" class="block text-sm font-medium text-gray-700">Jabatan</label>
                                <select id="position" name="position" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option>Direktur Utama</option>
                                    <option>Direktur Operasional</option>
                                    <option>Direktur Keuangan</option>
                                    <option>Konsultan</option>
                                    <option>Manager Non-Operational</option>
                                    <option>Manager Operational</option>
                                    <option>Manager Keuangan</option>
                                    <option>Assisstant Manager</option>
                                    <option>Supervisor</option>
                                    <option>Team Leader</option>
                                    <option>Staff Office</option>
                                    <option>Crew/Staff Operational</option>
                                    <option>Cleaning Service</option>
                                    <option>Security</option>
                                    <option>Teknisi</option>
                                    <option>Cook</option>
                                    <option>Helper/Janitor</option>
                                    <option>Waitress/server</option>
                                    <option>Kasir</option>
                                    <option>Terapis</option>
                                    <option>Handling Passenger</option>
                                    <option>Yang Lain</option>
                                </select>
                            </div>
                            <div>
                                <label for="join_date" class="block text-sm font-medium text-gray-700">Tanggal Bergabung</label>
                                <input type="date" id="join_date" name="join_date" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                             <div>
                                <label for="employment_status" class="block text-sm font-medium text-gray-700">Status Kepegawaian</label>
                                <select id="employment_status" name="employment_status" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option>Karyawan Tetap</option>
                                    <option>Karyawan Kontrak</option>
                                    <option>Magang</option>
                                </select>
                            </div>
                             <div>
                                <label for="direct_supervisor_name" class="block text-sm font-medium text-gray-700">Nama Atasan Langsung</label>
                                <input type="text" id="direct_supervisor_name" name="direct_supervisor_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                             <div>
                                <label for="direct_supervisor_position" class="block text-sm font-medium text-gray-700">Jabatan Atasan Langsung</label>
                                <input type="text" id="direct_supervisor_position" name="direct_supervisor_position" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                        </div>
                    </div>


                <!-- Riwayat Pendidikan -->
                <div class="space-y-6">
                    <h2 class="text-xl font-semibold text-gray-800 border-b pb-3">Riwayat Pendidikan</h2>
                    <div id="education-history-container" class="space-y-6">
                        @forelse ($user->educationHistory as $index => $edu)
                            <div class="p-4 border rounded-md relative">
                                <button type="button" class="remove-education-btn absolute top-2 right-2 text-gray-400 hover:text-red-500">&times;</button>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Jenjang</label>
                                        <select name="education[{{ $index }}][level]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                            <option @if($edu->level == 'SD') selected @endif>SD</option>
                                            <option @if($edu->level == 'SMP') selected @endif>SMP</option>
                                            <option @if($edu->level == 'SMA/SMK') selected @endif>SMA/SMK</option>
                                            <option @if($edu->level == 'D3') selected @endif>D3</option>
                                            <option @if($edu->level == 'S1') selected @endif>S1</option>
                                            <option @if($edu->level == 'S2') selected @endif>S2</option>
                                            <option @if($edu->level == 'S3') selected @endif>S3</option>
                                        </select>
                                    </div>
                                    <div class="lg:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Nama Institusi</label>
                                        <input type="text" name="education[{{ $index }}][institution_name]" value="{{ $edu->institution_name }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Tahun Lulus</label>
                                        <input type="text" name="education[{{ $index }}][graduation_year]" value="{{ $edu->graduation_year }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    </div>
                                    <div class="lg:col-span-4">
                                        <label class="block text-sm font-medium text-gray-700">Jurusan (opsional)</label>
                                        <input type="text" name="education[{{ $index }}][major]" value="{{ $edu->major }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    </div>
                                </div>
                            </div>
                        @empty
                            <!-- Form pendidikan akan ditambahkan di sini jika kosong -->
                        @endforelse
                    </div>
                    <button type="button" id="add-education-btn" class="mt-4 text-sm font-medium text-blue-600 hover:text-blue-800">
                        <i class="fas fa-plus mr-2"></i>Tambah Riwayat Pendidikan
                    </button>
                </div>
                
                <div class="mt-8 pt-6 border-t">
                    <button type="submit" class="w-full px-8 py-3 font-semibold text-white bg-blue-600 rounded-md hover:bg-blue-700">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Logika dropdown lokasi dinamis
            const departmentSelect = document.getElementById('department');
            const locationContainer = document.getElementById('location-container');
            const locationSelect = document.getElementById('location');
            const locations = {
                'Wrapping': ['WRAPPING FIRST', 'WRAPPING CGK GALAXY PORT TERMINAL 2E', 'WRAPPING HLP KINGTECH', 'WRAPPING CGK KINGTECH TERMINAL 2D', 'WRAPPING CGK PIONER TERMINAL 3', 'WRAPPING CGK ROBUST PACK TERMINAL 2F', 'WRAPPING CGK STAR WRAP TERMINAL 2D', 'WRAPPING CGK TERMINAL 2F', 'WRAPPING CGK TERMINAL 3A', 'WRAPPING CGK TERMINAL 3B', 'WRAPPING CGK TERMINAL 3E', 'LAINNYA' ],
                'Hans': ['HANS PREMIUM CGK', 'HANS CONCIERGE HLP', 'HANS CONCIERGE CGK', 'HANS PREMIUM HLP', 'LAINNYA'],
                'Cellular': ['DATA CELL TERMINAL 2F', 'DATA CELL TERMINAL 3', 'KING CELL TERMINAL 2F', 'POINT CELL TERMINAL 3', 'LAINNYA'],
                'Minimarket': ['AMBIL BEKAL YUK TERMINAL 2D', 'LATTE STORY TERMINAL 2D', 'M-MART', 'PAPI MART BALI DOMESTIK', 'PAPI MART BALI INTERNASIONAL', 'PAPI MART PDG', 'PAPI MART G28', 'PAPI MART TERMINAL 2E', 'POINT ONE', 'STORY LATTE TERMINAL 1A', 'STORY LATTE TERMINAL 2E', 'STORY LATTE TERMINAL 2F', 'URBAN T2E', 'LAINNYA'],
                'Reflexology': ['Reflexiology HLP', 'Reflexiology CGK Terminal 3 Gate 14', 'Reflexiology CGK Terminal 2F', 'Reflexiology CGK Terminal 3 Gate 17', 'LAINNYA'],
                'F&B': ['Baso Zuro', 'BLTS Atas', 'BLTS Bawah', 'Dapur BLTS', 'Dapur Produksi Tangerang', 'Kantin T3i', 'Massuro T3i', 'Maximun 600', 'Tungtau', 'Head Office', 'LAINNYA' ],
                'Head Office': ['HEAD OFFICE TANGERANG']
            };

            departmentSelect.addEventListener('change', function() {
                const selectedDepartment = this.value;
                locationSelect.innerHTML = '';
                if (selectedDepartment && locations[selectedDepartment]) {
                    locationContainer.classList.remove('hidden');
                    locations[selectedDepartment].forEach(location => {
                        const option = document.createElement('option');
                        option.value = location;
                        option.textContent = location;
                        locationSelect.appendChild(option);
                    });
                } else {
                    locationContainer.classList.add('hidden');
                }
            });

            // Logika form riwayat pendidikan dinamis
            const eduContainer = document.getElementById('education-history-container');
            const addEduButton = document.getElementById('add-education-btn');
            let eduCount = 0;

            const addEducationForm = () => {
                eduCount++;
                const newEdu = document.createElement('div');
                newEdu.className = 'p-4 border rounded-md relative';
                newEdu.innerHTML = `
                    <button type="button" class="remove-education-btn absolute top-2 right-2 text-gray-400 hover:text-red-500">&times;</button>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jenjang</label>
                            <select name="education[${eduCount}][level]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option>SD</option><option>SMP</option><option>SMA/SMK</option><option>D3</option><option>S1</option><option>S2</option><option>S3</option>
                            </select>
                        </div>
                        <div class="lg:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Nama Institusi</label>
                            <input type="text" name="education[${eduCount}][institution_name]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tahun Lulus</label>
                            <input type="text" name="education[${eduCount}][graduation_year]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div class="lg:col-span-4">
                            <label class="block text-sm font-medium text-gray-700">Jurusan (opsional)</label>
                            <input type="text" name="education[${eduCount}][major]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>
                `;
                eduContainer.appendChild(newEdu);
                newEdu.querySelector('.remove-education-btn').addEventListener('click', function() { this.parentElement.remove(); });
            };

            addEduButton.addEventListener('click', addEducationForm);
            // Tambahkan satu form pendidikan secara default
            addEducationForm();
        });
    </script>
</x-app-layout>
