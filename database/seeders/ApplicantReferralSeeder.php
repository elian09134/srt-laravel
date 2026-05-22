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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ApplicantReferralSeeder extends Seeder
{
    private array $applicants = [];

    private array $educations = [
        'S1 Teknik Informatika', 'S1 Manajemen', 'S1 Akuntansi', 'S1 Hukum',
        'S1 Psikologi', 'S1 Ilmu Komunikasi', 'D3 Teknik Elektro', 'S1 Ekonomi',
        'S1 Teknik Industri', 'S1 Desain Komunikasi Visual', 'S1 Sastra Inggris',
        'D3 Administrasi Perkantoran', 'S1 Sistem Informasi', 'S1 Teknik Sipil',
    ];

    private array $institutions = [
        'Universitas Indonesia', 'Universitas Gadjah Mada', 'Institut Teknologi Bandung',
        'Universitas Brawijaya', 'Universitas Padjadjaran', 'Universitas Diponegoro',
        'Politeknik Negeri Jakarta', 'Universitas Airlangga', 'Universitas Hasanuddin',
        'Universitas Gunadarma', 'Universitas Telkom', 'Institut Teknologi Sepuluh Nopember',
    ];

    private array $companies = [
        'PT Bank Mandiri (Persero) Tbk', 'PT Telkom Indonesia Tbk', 'PT GoTo Gojek Tokopedia Tbk',
        'PT Unilever Indonesia Tbk', 'PT Astra International Tbk', 'PT Kalbe Farma Tbk',
        'PT Bank Central Asia Tbk', 'PT Pertamina (Persero)', 'PT Perusahaan Listrik Negara (Persero)',
        'PT Semen Indonesia Tbk', 'PT Indofood Sukses Makmur Tbk', 'PT Sinar Mas Group',
        'PT Mayora Indah Tbk', 'PT Wijaya Karya Tbk', 'PT Bukalapak.com Tbk',
        'PT Bank Negara Indonesia Tbk', 'PT Bank Rakyat Indonesia Tbk',
    ];

    private array $jobDescs = [
        'Merancang dan mengembangkan fitur baru pada aplikasi web perusahaan menggunakan Laravel dan Vue.js.',
        'Mengelola pembukuan harian, rekonsiliasi bank, dan menyusun laporan keuangan bulanan untuk divisi.',
        'Memimpin tim kecil dalam pelaksanaan rekrutmen dan proses interview kandidat baru.',
        'Melakukan analisis data penjualan dan menyajikan laporan insight kepada manajemen setiap minggu.',
        'Menangani installasi, konfigurasi, dan maintenance infrastruktur jaringan kantor.',
        'Mengelola konten media sosial perusahaan dan menganalisis engagement metrics.',
        'Menangani pengadaan barang dan jasa serta negosiasi kontrak dengan vendor.',
        'Menyusun strategi pemasaran digital dan mengelola campaign Google Ads & Facebook Ads.',
        'Melakukan audit internal kepatuhan operasional terhadap standar perusahaan dan regulator.',
        'Mengelola database pelanggan dan mengembangkan sistem CRM berbasis web.',
    ];

    private array $positions = ['Staff', 'Senior Staff', 'Supervisor', 'Associate', 'Koordinator', 'Spesialis'];
    private array $fields = ['Teknik', 'Keuangan', 'Operasional', 'Pemasaran', 'SDM', 'TI', 'Administrasi'];

    private array $statusSequence = [
        'Baru' => ['Baru'],
        'Seleksi Berkas' => ['Baru', 'Seleksi Berkas'],
        'Interview HR' => ['Baru', 'Seleksi Berkas', 'Interview HR'],
        'Interview User' => ['Baru', 'Seleksi Berkas', 'Interview HR', 'Interview User'],
        'Psikotes' => ['Baru', 'Seleksi Berkas', 'Interview HR', 'Interview User', 'Psikotes'],
        'Offering' => ['Baru', 'Seleksi Berkas', 'Interview HR', 'Interview User', 'Psikotes', 'Offering'],
        'Diterima' => ['Baru', 'Seleksi Berkas', 'Interview HR', 'Interview User', 'Psikotes', 'Offering', 'Diterima'],
        'Ditolak (Berkas)' => ['Baru', 'Ditolak'],
        'Ditolak (HR)' => ['Baru', 'Seleksi Berkas', 'Ditolak'],
        'Ditolak (User)' => ['Baru', 'Seleksi Berkas', 'Interview HR', 'Ditolak'],
        'Ditolak (Psikotes)' => ['Baru', 'Seleksi Berkas', 'Interview HR', 'Interview User', 'Ditolak'],
    ];

    private array $ditolakStageMap = [
        'Ditolak (Berkas)' => 'Berkas lamaran tidak lengkap dan tidak sesuai dengan kualifikasi minimal yang dibutuhkan.',
        'Ditolak (HR)' => 'Hasil wawancara HR tidak memenuhi standar komunikasi dan budaya perusahaan.',
        'Ditolak (User)' => 'Kandidat tidak memenuhi ekspektasi teknis dari user department pada saat wawancara.',
        'Ditolak (Psikotes)' => 'Hasil psikotes tidak mencapai nilai minimum yang ditetapkan untuk posisi ini.',
    ];

    private array $months = [
        ['label' => 'Januari', 'year' => 2026, 'month' => 1],
        ['label' => 'Februari', 'year' => 2026, 'month' => 2],
        ['label' => 'Maret', 'year' => 2026, 'month' => 3],
        ['label' => 'April', 'year' => 2026, 'month' => 4],
        ['label' => 'Mei', 'year' => 2026, 'month' => 5],
    ];

    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        TalentPool::truncate();
        ApplicationStatusHistory::truncate();
        Application::truncate();
        WorkExperience::truncate();
        UserProfile::whereIn('user_id', User::where('role', 'applicant')->pluck('id'))->delete();
        User::where('role', 'applicant')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        if (Job::count() === 0) {
            $this->call(JobSeeder::class);
        }

        $admin = User::whereIn('role', ['admin', 'superadmin'])->first();
        $changedBy = $admin?->id ?? 1;
        $jobs = Job::all();

        $this->buildApplicantData();

        $totalCreated = 0;
        foreach ($this->applicants as $data) {
            $totalCreated += $this->createApplicant($data, $jobs, $changedBy) ? 1 : 0;
        }

        $this->command->info("$totalCreated applicants seeded (Januari 2026 – Mei 2026).");
    }

    private function buildApplicantData(): void
    {
        foreach ($this->months as $m) {
            $baseDate = now()->setDate($m['year'], $m['month'], 1);
            $isCurrentMonth = $m['year'] == now()->year && $m['month'] == now()->month;

            // Different volume per month for realism
            $counts = match ($m['month']) {
                1 => ['M28' => 4, 'Sosial Media' => 2, 'Lainnya' => 3],
                2 => ['M28' => 5, 'Sosial Media' => 3, 'Lainnya' => 3],
                3 => ['M28' => 6, 'Sosial Media' => 3, 'Lainnya' => 4],
                4 => ['M28' => 6, 'Sosial Media' => 3, 'Lainnya' => 4],
                5 => ['M28' => 5, 'Sosial Media' => 2, 'Lainnya' => 3],
            };

            foreach ($counts as $source => $count) {
                for ($i = 0; $i < $count; $i++) {
                    $dayOffset = rand(1, 25);
                    $createdAt = $baseDate->copy()->addDays($dayOffset);

                    if ($isCurrentMonth && $createdAt->isFuture()) {
                        $createdAt = now()->subDays(rand(0, 5));
                    }

                    $this->applicants[] = $this->generateApplicant($source, $createdAt, $m['month']);
                }
            }
        }
    }

    private function generateApplicant(string $source, \Carbon\Carbon $createdAt, int $monthNum): array
    {
        $names = $this->getNamesForMonth($monthNum);
        $name = $names[array_rand($names)];

        $status = $this->pickStatus($monthNum);
        $profile = rand(1, 10) > 1; // 80% have profile

        $subSources = [
            'Lainnya' => ['Facebook', 'Instagram', 'Twitter/X', 'LinkedIn', 'TikTok', 'JobStreet', 'Google', 'Teman', 'Keluarga', 'Email Marketing'],
        ][$source] ?? [];

        $referralSource = $source === 'Lainnya' ? $subSources[array_rand($subSources)] : $source;

        return compact('name', 'source', 'referralSource', 'status', 'profile', 'createdAt');
    }

    private function pickStatus(int $monthNum): string
    {
        // Earlier months: more progressed statuses; current month: more early-stage
        return match ($monthNum) {
            1 => $this->weightedRandom([
                'Diterima' => 2, 'Offering' => 1, 'Psikotes' => 1,
                'Ditolak (Berkas)' => 2, 'Ditolak (HR)' => 1, 'Ditolak (User)' => 1,
            ]),
            2 => $this->weightedRandom([
                'Interview User' => 1, 'Psikotes' => 2, 'Offering' => 1, 'Diterima' => 1,
                'Ditolak (HR)' => 2, 'Ditolak (User)' => 1, 'Ditolak (Psikotes)' => 1,
                'Seleksi Berkas' => 1, 'Interview HR' => 1,
            ]),
            3 => $this->weightedRandom([
                'Interview HR' => 2, 'Interview User' => 2, 'Psikotes' => 1,
                'Ditolak (Berkas)' => 2, 'Ditolak (User)' => 1, 'Diterima' => 1,
                'Baru' => 1, 'Seleksi Berkas' => 2,
            ]),
            4 => $this->weightedRandom([
                'Baru' => 2, 'Seleksi Berkas' => 2, 'Interview HR' => 2,
                'Ditolak (Berkas)' => 2, 'Ditolak (HR)' => 1, 'Interview User' => 1,
                'Psikotes' => 1, 'Offering' => 1,
            ]),
            5 => $this->weightedRandom([
                'Baru' => 3, 'Seleksi Berkas' => 3, 'Interview HR' => 2,
                'Ditolak (Berkas)' => 1, 'Ditolak (HR)' => 1,
            ]),
            default => 'Baru',
        };
    }

    private function weightedRandom(array $weights): string
    {
        $total = array_sum($weights);
        $rand = rand(1, $total);
        $cumulative = 0;
        foreach ($weights as $status => $weight) {
            $cumulative += $weight;
            if ($rand <= $cumulative) {
                return $status;
            }
        }
        return 'Baru';
    }

    private function getNamesForMonth(int $month): array
    {
        $all = [
            'Ahmad Fauzi', 'Rina Wulandari', 'Dimas Ardianto', 'Fitri Handayani', 'Gilang Permana',
            'Nurul Hidayah', 'Hendra Gunawan', 'Dian Permatasari', 'Reza Firmansyah', 'Sari Dewi',
            'Bayu Pratama', 'Mega Utami', 'Aditya Saputra', 'Putri Ayuningtyas', 'Fajar Nugroho',
            'Lilis Karlina', 'Andre Syahputra', 'Yuni Astuti', 'Rizky Ramadhan', 'Tari Kusuma',
            'Fanny Oktaviani', 'Irfan Maulana', 'Cindy Permata', 'Doni Lesmana', 'Gita Puspita',
            'Hadi Sucipto', 'Intan Nurhaliza', 'Joko Susilo', 'Karina Putri', 'Rangga Wiraguna',
            'Mentari Ayu', 'Bagas Prakoso', 'Winda Sari', 'Eka Prasetya', 'Nadia Rahmawati',
            'Yoga Pratama', 'Ratna Dewi', 'Teguh Wirawan', 'Bambang Santoso', 'Dewi Sartika',
            'Agus Wijaya', 'Sri Wahyuni', 'Eko Prasetyo', 'Ratna Sari', 'Herman Susanto',
            'Indah Lestari', 'Wawan Setiawan', 'Dwi Handayani', 'Rudi Hartono', 'Sinta Amelia',
            'Irwan Saputra', 'Maya Anggraini', 'Taufik Hidayat', 'Nia Kurniawati', 'Arif Budiman',
            'Desi Ratnasari', 'Cahyo Nugroho', 'Rina Marlina', 'Tri Wahyuni', 'Agung Laksono',
        ];
        shuffle($all);
        return array_slice($all, ($month - 1) * 10, 15);
    }

    private function createApplicant(array $data, $jobs, int $changedBy): bool
    {
        $name = $data['name'];
        $referralSource = $data['referralSource'];
        $rawStatus = $data['status'];
        $createdAt = $data['createdAt'];
        $profile = $data['profile'];

        $slug = Str::slug($name);
        $email = $slug . '.' . Str::slug($referralSource) . '@example.com';

        if (User::where('email', $email)->exists()) {
            $email = $slug . '.' . uniqid() . '@example.com';
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make('password'),
            'role' => 'applicant',
            'referral_source' => $referralSource,
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ]);

        $edu = $this->educations[array_rand($this->educations)];
        $inst = $this->institutions[array_rand($this->institutions)];
        $company = $this->companies[array_rand($this->companies)];
        $position = $this->positions[array_rand($this->positions)] . ' ' . $this->fields[array_rand($this->fields)];

        if ($profile) {
            UserProfile::create([
                'user_id' => $user->id,
                'phone_number' => '08' . rand(11, 13) . str_pad((string) rand(0, 99999999), 8, '0', STR_PAD_LEFT),
                'date_of_birth' => now()->subYears(rand(22, 45))->subDays(rand(1, 365)),
                'education_level' => $edu,
                'institution' => $inst,
                'last_company' => $company,
                'last_position' => $position,
                'skills' => implode(', ', array_rand(array_flip(['PHP', 'Laravel', 'JavaScript', 'Python', 'Excel', 'SAP', 'Public Speaking', 'Team Leadership', 'Analisa Data', 'Project Management', 'UI/UX Design', 'SEO', 'AWS', 'Docker', 'MySQL']), 3)),
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            WorkExperience::create([
                'user_id' => $user->id,
                'company_name' => $company,
                'duration' => rand(1, 5) . ' Tahun',
                'job_description' => $this->jobDescs[array_rand($this->jobDescs)],
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }

        $job = $jobs->random();
        $finalStatus = in_array($rawStatus, ['Ditolak (Berkas)', 'Ditolak (HR)', 'Ditolak (User)', 'Ditolak (Psikotes)']) ? 'Ditolak' : $rawStatus;

        $application = Application::create([
            'user_id' => $user->id,
            'job_id' => $job->id,
            'status' => $finalStatus,
            'applicant_name' => $name,
            'applicant_email' => $email,
            'applicant_phone' => '08' . rand(11, 13) . str_pad((string) rand(0, 99999999), 8, '0', STR_PAD_LEFT),
            'applicant_last_position' => $profile ? $position : $this->positions[array_rand($this->positions)] . ' ' . $this->fields[array_rand($this->fields)],
            'applicant_last_education' => $edu,
            'cover_letter' => "Dengan hormat,

Saya yang bertanda tangan di bawah ini:

Nama: $name
Pendidikan: $edu
Domisili: {$job->location} dan sekitarnya

Bersama dengan surat ini, saya mengajukan lamaran pekerjaan untuk posisi {$job->title} di SRT Corp. Informasi lowongan ini saya peroleh dari $referralSource.

Saya memiliki pengalaman di bidang yang relevan dan siap untuk berkontribusi secara maksimal. Besar harapan saya untuk dapat mengikuti tahapan seleksi selanjutnya.

Atas perhatian Bapak/Ibu, saya ucapkan terima kasih.

Hormat saya,
$name",
            'snapshot_data' => json_encode([
                'profile' => ['name' => $name, 'email' => $email],
                'referral' => $referralSource,
            ]),
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ]);

        $sequence = $this->statusSequence[$rawStatus] ?? $this->statusSequence['Ditolak (Berkas)'];

        foreach ($sequence as $seqIndex => $seqStatus) {
            $historyCreatedAt = $createdAt->copy()->addDays($seqIndex * rand(2, 5));
            if ($historyCreatedAt->isFuture()) {
                $historyCreatedAt = now();
            }

            if ($seqStatus === 'Baru') {
                $note = 'Pendaftaran online melalui website. (Referal ' . $referralSource . ')';
            } elseif ($seqStatus === 'Diterima') {
                $note = 'Kandidat dinyatakan lulus seluruh proses rekrutmen dan diterima.';
            } elseif ($seqStatus === 'Ditolak') {
                $note = $this->ditolakStageMap[$rawStatus] ?? 'Kandidat tidak memenuhi kualifikasi yang dibutuhkan.';
            } elseif ($seqStatus === 'Seleksi Berkas') {
                $note = 'Berkas lengkap dan sesuai kualifikasi, lanjut ke tahap interview HR.';
            } elseif ($seqStatus === 'Interview HR') {
                $note = 'Kandidat memiliki komunikasi yang baik dan sesuai dengan budaya perusahaan.';
            } elseif ($seqStatus === 'Interview User') {
                $note = 'Kandidat memenuhi ekspektasi teknis dari user department.';
            } elseif ($seqStatus === 'Psikotes') {
                $note = 'Hasil psikotes menunjukkan potensi yang baik untuk posisi yang dilamar.';
            } elseif ($seqStatus === 'Offering') {
                $note = 'Offering letter telah dikirimkan dan menunggu konfirmasi kandidat.';
            } else {
                $note = 'Kandidat tidak memenuhi kualifikasi yang dibutuhkan.';
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

        if (in_array($finalStatus, ['Diterima', 'Offering'])) {
            TalentPool::create([
                'user_id' => $user->id,
                'status' => 'Shortlist',
                'job_preferences' => $job->title . ', ' . ['Staff', 'Senior', 'Lead'][rand(0, 2)] . ' ' . ['Teknis', 'Manajerial', 'Operasional', 'Kreatif'][rand(0, 3)],
                'created_at' => $createdAt->copy()->addDays(rand(1, 3)),
                'updated_at' => $createdAt->copy()->addDays(rand(1, 3)),
            ]);
        }

        return true;
    }
}
