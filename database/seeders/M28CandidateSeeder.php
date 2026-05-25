<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\ApplicationStatusHistory;
use App\Models\Job;
use App\Models\TalentPool;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\WorkExperience;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class M28CandidateSeeder extends Seeder
{
    public function run(): void
    {
        if (Job::count() === 0) {
            $this->call(JobSeeder::class);
        }

        $admin = User::whereIn('role', ['admin', 'superadmin'])->first();
        $changedBy = $admin?->id ?? 1;

        $jobs = Job::all();

        $candidates = [
            // 1-3: Baru (just applied)
            ['name' => 'Ahmad Fauzi', 'status' => 'Baru', 'profile' => true],
            ['name' => 'Rina Wulandari', 'status' => 'Baru', 'profile' => true],
            ['name' => 'Dimas Ardianto', 'status' => 'Baru', 'profile' => false],

            // 4-6: Seleksi Berkas
            ['name' => 'Fitri Handayani', 'status' => 'Seleksi Berkas', 'profile' => true],
            ['name' => 'Gilang Permana', 'status' => 'Seleksi Berkas', 'profile' => false],
            ['name' => 'Nurul Hidayah', 'status' => 'Seleksi Berkas', 'profile' => true],

            // 7-9: Interview HR
            ['name' => 'Hendra Gunawan', 'status' => 'Interview HR', 'profile' => true],
            ['name' => 'Dian Permatasari', 'status' => 'Interview HR', 'profile' => true],
            ['name' => 'Reza Firmansyah', 'status' => 'Interview HR', 'profile' => false],

            // 10-12: Interview User
            ['name' => 'Sari Dewi', 'status' => 'Interview User', 'profile' => true],
            ['name' => 'Bayu Pratama', 'status' => 'Interview User', 'profile' => true],
            ['name' => 'Mega Utami', 'status' => 'Interview User', 'profile' => false],

            // 13-14: Psikotes
            ['name' => 'Aditya Saputra', 'status' => 'Psikotes', 'profile' => true],
            ['name' => 'Putri Ayuningtyas', 'status' => 'Psikotes', 'profile' => true],

            // 15-16: Offering
            ['name' => 'Fajar Nugroho', 'status' => 'Offering', 'profile' => true],
            ['name' => 'Lilis Karlina', 'status' => 'Offering', 'profile' => false],

            // 17-18: Diterima
            ['name' => 'Andre Syahputra', 'status' => 'Diterima', 'profile' => true],
            ['name' => 'Yuni Astuti', 'status' => 'Diterima', 'profile' => true],

            // 19-20: Ditolak
            ['name' => 'Rizky Ramadhan', 'status' => 'Ditolak', 'profile' => false],
            ['name' => 'Tari Kusuma', 'status' => 'Ditolak', 'profile' => true],
        ];

        $statusSequence = [
            'Baru' => ['Baru'],
            'Seleksi Berkas' => ['Baru', 'Seleksi Berkas'],
            'Interview HR' => ['Baru', 'Seleksi Berkas', 'Interview HR'],
            'Interview User' => ['Baru', 'Seleksi Berkas', 'Interview HR', 'Interview User'],
            'Psikotes' => ['Baru', 'Seleksi Berkas', 'Interview HR', 'Interview User', 'Psikotes'],
            'Offering' => ['Baru', 'Seleksi Berkas', 'Interview HR', 'Interview User', 'Psikotes', 'Offering'],
            'Diterima' => ['Baru', 'Seleksi Berkas', 'Interview HR', 'Interview User', 'Psikotes', 'Offering', 'Diterima'],
            'Ditolak' => ['Baru', 'Seleksi Berkas', 'Interview HR', 'Interview User', 'Ditolak'],
        ];

        $notesMap = [
            'Baru' => 'Pendaftaran online melalui website. (Referal M28)',
            'Seleksi Berkas' => 'Berkas lengkap dan sesuai kualifikasi, lanjut ke tahap interview HR.',
            'Interview HR' => 'Kandidat memiliki komunikasi yang baik dan sesuai dengan budaya perusahaan.',
            'Interview User' => 'Kandidat memenuhi ekspektasi teknis dari user department.',
            'Psikotes' => 'Hasil psikotes menunjukkan potensi yang baik untuk posisi yang dilamar.',
            'Offering' => 'Offering letter telah dikirimkan dan menunggu konfirmasi kandidat.',
            'Diterima' => 'Kandidat diterima dan akan bergabung sesuai tanggal yang disepakati.',
            'Ditolak' => 'Kandidat tidak memenuhi kualifikasi yang dibutuhkan.',
        ];

        $educations = [
            'S1 Teknik Informatika', 'S1 Manajemen', 'S1 Akuntansi', 'S1 Hukum',
            'S1 Psikologi', 'S1 Ilmu Komunikasi', 'D3 Teknik Elektro', 'S1 Ekonomi',
        ];

        $institutions = [
            'Universitas Indonesia', 'Universitas Gadjah Mada', 'Institut Teknologi Bandung',
            'Universitas Brawijaya', 'Universitas Padjadjaran', 'Universitas Diponegoro',
            'Politeknik Negeri Jakarta', 'Universitas Airlangga',
        ];

        foreach ($candidates as $i => $data) {
            $email = Str::slug($data['name']).'.m28@example.com';
            $daysAgo = rand(5, 60);

            $user = User::create([
                'name' => $data['name'],
                'email' => $email,
                'password' => Hash::make('password'),
                'role' => 'applicant',
                'referral_source' => 'M28',
                'created_at' => now()->subDays($daysAgo),
                'updated_at' => now()->subDays($daysAgo),
            ]);

            if ($data['profile']) {
                $edu = $educations[array_rand($educations)];
                $inst = $institutions[array_rand($institutions)];

                UserProfile::create([
                    'user_id' => $user->id,
                    'phone_number' => '0813'.str_pad((string) rand(0, 99999999), 8, '0', STR_PAD_LEFT),
                    'date_of_birth' => now()->subYears(rand(22, 45))->subDays(rand(1, 365)),
                    'education_level' => $edu,
                    'institution' => $inst,
                    'last_company' => 'PT '.Str::random(6).' '.['Tbk', 'Indonesia', 'Abadi'][rand(0, 2)],
                    'last_position' => ['Staff', 'Senior Staff', 'Supervisor', 'Associate'][rand(0, 3)].' '.['Teknis', 'Administrasi', 'Keuangan', 'Operasional'][rand(0, 3)],
                    'skills' => implode(', ', array_rand(array_flip(['PHP', 'Laravel', 'JavaScript', 'Python', 'Excel', 'SAP', 'Public Speaking', 'Team Leadership', 'Analisa Data', 'Project Management']), 3)),
                    'created_at' => now()->subDays($daysAgo),
                    'updated_at' => now()->subDays($daysAgo),
                ]);

                WorkExperience::create([
                    'user_id' => $user->id,
                    'company_name' => 'PT '.Str::random(8).' Corp',
                    'duration' => rand(1, 5).' Tahun',
                    'job_description' => 'Bertanggung jawab atas '.['operasional harian', 'pengembangan sistem', 'pelaporan keuangan', 'rekrutmen dan training'][rand(0, 3)].' di perusahaan.',
                    'created_at' => now()->subDays($daysAgo),
                    'updated_at' => now()->subDays($daysAgo),
                ]);
            }

            $job = $jobs->random();
            $finalStatus = $data['status'];
            $appCreatedAt = now()->subDays($daysAgo);

            $application = Application::create([
                'user_id' => $user->id,
                'job_id' => $job->id,
                'status' => $finalStatus,
                'applicant_name' => $data['name'],
                'applicant_email' => $email,
                'applicant_phone' => '0813'.str_pad((string) rand(0, 99999999), 8, '0', STR_PAD_LEFT),
                'applicant_last_position' => $data['profile']
                    ? UserProfile::where('user_id', $user->id)->value('last_position')
                    : 'Staff '.Str::random(5),
                'applicant_last_education' => $data['profile']
                    ? UserProfile::where('user_id', $user->id)->value('education_level')
                    : $educations[array_rand($educations)],
                'cover_letter' => 'Saya, '.$data['name'].', mengajukan lamaran untuk posisi '.$job->title.'. Saya mendapatkan informasi lowongan ini dari M28 dan sangat tertarik untuk bergabung dengan SRT Corp.',
                'snapshot_data' => json_encode([
                    'profile' => ['name' => $data['name'], 'email' => $email],
                    'referral' => 'M28',
                ]),
                'created_at' => $appCreatedAt,
                'updated_at' => $appCreatedAt,
            ]);

            $sequence = $statusSequence[$finalStatus];
            foreach ($sequence as $seqIndex => $seqStatus) {
                $historyCreatedAt = $appCreatedAt->copy()->addDays($seqIndex * rand(2, 5));
                if ($historyCreatedAt->isFuture()) {
                    $historyCreatedAt = now();
                }

                $note = $notesMap[$seqStatus];
                if ($seqStatus === $finalStatus && $finalStatus === 'Diterima') {
                    $note = 'Kandidat dinyatakan lulus seluruh proses rekrutmen dan diterima.';
                }
                if ($seqStatus === $finalStatus && $finalStatus === 'Ditolak') {
                    $note = 'Kandidat tidak memenuhi kualifikasi pada tahap '.$sequence[$seqIndex - 1].'.';
                    if ($seqIndex === 0) {
                        $note = 'Berkas lamaran tidak memenuhi persyaratan dasar.';
                    }
                }

                ApplicationStatusHistory::create([
                    'application_id' => $application->id,
                    'status' => $seqStatus,
                    'note' => $note,
                    'changed_by' => $changedBy,
                    'created_at' => $historyCreatedAt,
                    'updated_at' => $historyCreatedAt,
                ]);
            }

            // Some accepted candidates go to talent pool
            if ($finalStatus === 'Diterima' || ($finalStatus === 'Offering' && rand(0, 1))) {
                TalentPool::create([
                    'user_id' => $user->id,
                    'status' => 'Shortlist',
                    'job_preferences' => $job->title.', '.['Staff', 'Senior', 'Lead'][rand(0, 2)].' '.['Teknis', 'Manajerial', 'Operasional'][rand(0, 2)],
                    'created_at' => now()->subDays(rand(1, 3)),
                    'updated_at' => now()->subDays(rand(1, 3)),
                ]);
            }
        }

        $this->command->info('20 M28-referred candidates seeded successfully.');
    }
}
