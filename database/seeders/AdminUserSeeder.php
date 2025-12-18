<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'admin@example.test';

        if (User::where('email', $email)->exists()) {
            $this->command->info("Admin user already exists: {$email}");
            return;
        }

        User::create([
            'name' => 'Administrator',
            'email' => $email,
            'email_verified_at' => now(),
            'password' => Hash::make('Admin123!'),
            'role' => 'admin',
            'remember_token' => Str::random(10),
        ]);

        $this->command->info("Admin user created: {$email} (password: Admin123!)");
    }
}
