<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $email = 'm28@partner.com';

        if (!User::where('email', $email)->exists()) {
            User::create([
                'name' => 'M28',
                'email' => $email,
                'email_verified_at' => now(),
                'password' => Hash::make('partner123'),
                'role' => 'partner',
                'remember_token' => Str::random(10),
            ]);
            $this->command->info("Partner user M28 created: {$email} (password: partner123)");
        } else {
            $this->command->info("Partner user already exists: {$email}");
        }

        $partner = User::where('email', $email)->first();
    }
}
