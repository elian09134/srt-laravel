<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Application;
use App\Models\User;
use App\Models\Job;
use App\Models\ApplicationStatusHistory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $jobs = Job::all();
        if ($jobs->isEmpty()) {
            $this->command->info('Please seed Jobs first.');
            return;
        }

        $names = [
            'Budi Santoso', 'Siti Aminah', 'Andi Wijaya', 'Dewi Lestari', 
            'Eko Prasetyo', 'Rina Mutia', 'Agus Setiawan', 'Maya Indah',
            'Hendra Kurniawan', 'Larasati Putri', 'Rahmat Hidayat', 'Indah Permata'
        ];

        $statuses = ['Baru', 'Seleksi Berkas', 'Interview HR', 'Interview User', 'Psikotes', 'Offering', 'Diterima', 'Ditolak'];

        foreach ($names as $index => $name) {
            $email = Str::slug($name) . '@example.com';
            
            // Create user for applicant
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('password'),
                'role' => 'applicant',
            ]);

            // Assign to random job
            $job = $jobs->random();
            $status = ($index < 3) ? 'Baru' : $statuses[array_rand($statuses)];

            $application = Application::create([
                'user_id' => $user->id,
                'job_id' => $job->id,
                'status' => $status,
                'applicant_name' => $name,
                'applicant_email' => $email,
                'applicant_phone' => '0812' . rand(10000000, 99999999),
                'applicant_last_position' => 'Staff ' . Str::random(5),
                'applicant_last_education' => ['S1 Teknik', 'S1 Ekonomi', 'S1 Hukum', 'D3 Informatika'][rand(0, 3)],
                'cover_letter' => 'Saya sangat tertarik dengan posisi ' . $job->title . ' di perusahaan Anda. Saya memiliki pengalaman yang relevan dan motivasi yang tinggi.',
                'snapshot_data' => json_encode([
                    'profile' => [
                        'name' => $name,
                        'email' => $email,
                    ]
                ]),
                'created_at' => now()->subDays(rand(1, 30)),
            ]);

            // Create initial history
            ApplicationStatusHistory::create([
                'application_id' => $application->id,
                'status' => 'Baru',
                'note' => 'Pendaftaran online melalui website.',
                'changed_by' => 1, // Super Admin
            ]);

            // If status is not Baru, create another history
            if ($status !== 'Baru') {
                ApplicationStatusHistory::create([
                    'application_id' => $application->id,
                    'status' => $status,
                    'note' => 'Status diperbarui oleh sistem seeder.',
                    'changed_by' => 1,
                    'created_at' => $application->created_at->addDays(1),
                ]);
            }
        }

        $this->command->info('Seed Applicant Data successful.');
    }
}
