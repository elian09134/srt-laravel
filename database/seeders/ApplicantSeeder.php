<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ApplicantSeeder extends Seeder
{
    public function run(): void
    {
        $email = 'pelamar@example.com';

        if (User::where('email', $email)->exists()) {
            $this->command->info("Applicant user already exists: {$email}");

            return;
        }

        User::create([
            'name' => 'Pelamar',
            'email' => $email,
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'applicant',
            'remember_token' => Str::random(10),
        ]);

        $this->command->info("Applicant user created: {$email} (password: password)");
    }
}
