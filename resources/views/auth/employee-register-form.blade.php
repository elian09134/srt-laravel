<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Karyawan - SRT Corp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-50">
    <div class="flex flex-col items-center justify-center min-h-screen p-4 sm:p-6 lg:p-8">
        <div class="w-full max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="p-8 sm:p-12">
                <div class="text-center">
                    <a href="{{ route('home') }}" class="text-3xl font-bold text-gray-900">SRT <span class="text-blue-700">Corp</span></a>
                    <h1 class="mt-6 text-3xl font-bold text-gray-900">Lengkapi Data Karyawan</h1>
                    <p class="mt-2 text-gray-600">Selamat datang, {{ $invitation->full_name }}. Silakan lengkapi informasi di bawah ini.</p>
                </div>

                <form method="POST" action="{{ route('employee.register.store') }}" class="mt-10 space-y-12">
                    @csrf
                    <input type="hidden" name="invitation_code" value="{{ $invitation->invitation_code }}">

                    <!-- Informasi Akun -->
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold text-gray-800 border-b pb-3">Informasi Akun</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" value="{{ $invitation->email }}" readonly class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                <input type="password" id="password" name="password" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Pribadi -->
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold text-gray-800 border-b pb-3">Informasi Pribadi</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input type="text" name="full_name" value="{{ $invitation->full_name }}" readonly class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-gray-700">Nomor HP</label>
                                <input type="tel" id="phone_number" name="phone_number" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label for="place_of_birth" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                                <input type="text" id="place_of_birth" name="place_of_birth" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                <input type="date" id="date_of_birth" name="date_of_birth" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="current_address" class="block text-sm font-medium text-gray-700">Domisili Saat Ini</label>
                                <textarea id="current_address" name="current_address" rows="3" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="id_card_address" class="block text-sm font-medium text-gray-700">Alamat Sesuai KTP</label>
                                <textarea id="id_card_address" name="id_card_address" rows="3" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                            </div>
                             <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                <select id="gender" name="gender" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option>Pria</option>
                                    <option>Wanita</option>
                                </select>
                            </div>
                            <div>
                                <label for="religion" class="block text-sm font-medium text-gray-700">Agama</label>
                                <input type="text" id="religion" name="religion" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                             <div>
                                <label for="marital_status" class="block text-sm font-medium text-gray-700">Status Perkawinan</label>
                                <select id="marital_status" name="marital_status" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option>Belum Kawin</option>
                                    <option>Kawin</option>
                                    <option>Cerai Hidup</option>
                                    <option>Cerai Mati</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Pajak & Keluarga -->
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold text-gray-800 border-b pb-3">Informasi Pajak & Keluarga</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="id_card_number" class="block text-sm font-medium text-gray-700">NIK KTP</label>
                                <input type="text" id="id_card_number" name="id_card_number" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label for="npwp_number" class="block text-sm font-medium text-gray-700">NPWP (Opsional)</label>
                                <input type="text" id="npwp_number" name="npwp_number" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                             <div>
                                <label for="ptkp_status" class="block text-sm font-medium text-gray-700">Status PTKP</label>
                                <select id="ptkp_status" name="ptkp_status" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option>TK0 (Tanpa Tanggungan)</option>
                                    <option>TK1 (1 Tanggungan)</option>
                                    <option>TK2 (2 Tanggungan)</option>
                                    <option>TK3 (3 Tanggungan)</option>
                                    <option>K0 (Tanpa Tanggungan)</option>
                                    <option>K1 (1 Tanggungan)</option>
                                    <option>K2 (2 Tanggungan)</option>
                                    <option>K3 (3 Tanggungan)</option>
                                    <option>K/I/0 (Tanpa Tanggungan)</option>
                                    <option>K/I/1 (1 Tanggungan)</option>
                                    <option>K/I/2 (2 Tanggungan)</option>
                                    <option>K/I/3 (3 Tanggungan)</option>
                                </select>
                            </div>
                            <div>
                                <label for="father_name" class="block text-sm font-medium text-gray-700">Nama Ayah</label>
                                <input type="text" id="father_name" name="father_name" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                             <div>
                                <label for="mother_name" class="block text-sm font-medium text-gray-700">Nama Ibu</label>
                                <input type="text" id="mother_name" name="mother_name" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="spouse_name" class="block text-sm font-medium text-gray-700">Nama Suami/Istri (Opsional)</label>
                                <input type="text" id="spouse_name" name="spouse_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
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

                    <!-- Informasi Bank -->
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold text-gray-800 border-b pb-3">Informasi Bank</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                            <div>
                                <label for="bank_name" class="block text-sm font-medium text-gray-700">Nama Bank</label>
                                <input type="text" id="bank_name" name="bank_name" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                             <div>
                                <label for="account_number" class="block text-sm font-medium text-gray-700">Nomor Rekening</label>
                                <input type="text" id="account_number" name="account_number" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                             <div>
                                <label for="account_holder_name" class="block text-sm font-medium text-gray-700">Nama Pemilik Rekening</label>
                                <input type="text" id="account_holder_name" name="account_holder_name" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Kontak Darurat -->
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold text-gray-800 border-b pb-3">Kontak Darurat</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                            <div>
                                <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700">Nama</label>
                                <input type="text" id="emergency_contact_name" name="emergency_contact_name" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                             <div>
                                <label for="emergency_contact_phone" class="block text-sm font-medium text-gray-700">No. HP</label>
                                <input type="tel" id="emergency_contact_phone" name="emergency_contact_phone" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                             <div>
                                <label for="emergency_contact_relation" class="block text-sm font-medium text-gray-700">Hubungan</label>
                                <input type="text" id="emergency_contact_relation" name="emergency_contact_relation" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Riwayat Pendidikan -->
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold text-gray-800 border-b pb-3">Riwayat Pendidikan</h2>
                        <div id="education-history-container" class="space-y-6">
                            <!-- Form pendidikan akan ditambahkan di sini -->
                        </div>
                        <button type="button" id="add-education-btn" class="mt-4 text-sm font-medium text-blue-600 hover:text-blue-800">
                            <i class="fas fa-plus mr-2"></i>Tambah Riwayat Pendidikan
                        </button>
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700">
                            Selesaikan Pendaftaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
</body>
</html>
