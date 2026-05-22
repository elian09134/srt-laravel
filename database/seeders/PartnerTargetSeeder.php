<?php

namespace Database\Seeders;

use App\Models\PartnerTarget;
use App\Models\User;
use Illuminate\Database\Seeder;

class PartnerTargetSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'm28@partner.com')->first();
        if (!$user) {
            $this->command->error('M28 user not found. Run PartnerSeeder first.');
            return;
        }

        $targets = [
            ['year' => 2026, 'month' => 1, 'target_count' => 4],
            ['year' => 2026, 'month' => 2, 'target_count' => 8],
            ['year' => 2026, 'month' => 3, 'target_count' => 10],
            ['year' => 2026, 'month' => 4, 'target_count' => 12],
            ['year' => 2026, 'month' => 5, 'target_count' => 10],
        ];

        $count = 0;
        foreach ($targets as $data) {
            PartnerTarget::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'year' => $data['year'],
                    'month' => $data['month'],
                ],
                ['target_count' => $data['target_count']]
            );
            $count++;
        }

        $this->command->info("$count monthly targets seeded for M28 (Jan 2026 – Mei 2026).");
    }
}
