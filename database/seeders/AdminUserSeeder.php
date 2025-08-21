<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'HRD SRT CORP',
            'email' => 'rekrutmensrt@gmail.com',
            'password' => Hash::make('hrdsrt2025'), // Ganti 'password' dengan password yang aman
            'role' => 'admin',
        ]);
    }
}