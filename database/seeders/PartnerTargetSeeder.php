<?php

namespace Database\Seeders;

use App\Models\PartnerTarget;
use App\Models\PartnerTargetPosition;
use App\Models\User;
use Illuminate\Database\Seeder;

class PartnerTargetSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'm28@partner.com')->first();
        if (! $user) {
            $this->command->error('M28 user not found. Run PartnerSeeder first.');

            return;
        }

        $targets = [
            [
                'year' => 2026, 'month' => null, 'target_count' => 44, 'positions' => [],
            ],
            [
                'year' => 2026, 'month' => 1, 'target_count' => 4,
                'positions' => [
                    ['position' => 'Senior Frontend Developer', 'target_count' => 2],
                    ['position' => 'Human Capital Manager', 'target_count' => 1],
                    ['position' => 'Finance Staff', 'target_count' => 1],
                ],
            ],
            [
                'year' => 2026, 'month' => 2, 'target_count' => 8,
                'positions' => [
                    ['position' => 'Senior Frontend Developer', 'target_count' => 3],
                    ['position' => 'Human Capital Manager', 'target_count' => 2],
                    ['position' => 'Finance Staff', 'target_count' => 2],
                    ['position' => 'IT Support Specialist', 'target_count' => 1],
                ],
            ],
            [
                'year' => 2026, 'month' => 3, 'target_count' => 10,
                'positions' => [
                    ['position' => 'Senior Frontend Developer', 'target_count' => 4],
                    ['position' => 'Human Capital Manager', 'target_count' => 3],
                    ['position' => 'Finance Staff', 'target_count' => 2],
                    ['position' => 'IT Support Specialist', 'target_count' => 1],
                ],
            ],
            [
                'year' => 2026, 'month' => 4, 'target_count' => 12,
                'positions' => [
                    ['position' => 'Senior Frontend Developer', 'target_count' => 5],
                    ['position' => 'Human Capital Manager', 'target_count' => 3],
                    ['position' => 'Finance Staff', 'target_count' => 2],
                    ['position' => 'IT Support Specialist', 'target_count' => 2],
                ],
            ],
            [
                'year' => 2026, 'month' => 5, 'target_count' => 10,
                'positions' => [
                    ['position' => 'Senior Frontend Developer', 'target_count' => 4],
                    ['position' => 'Human Capital Manager', 'target_count' => 3],
                    ['position' => 'Finance Staff', 'target_count' => 2],
                    ['position' => 'IT Support Specialist', 'target_count' => 1],
                ],
            ],
        ];

        $count = 0;
        foreach ($targets as $data) {
            $target = PartnerTarget::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'year' => $data['year'],
                    'month' => $data['month'],
                ],
                ['target_count' => $data['target_count']]
            );

            foreach ($data['positions'] as $posData) {
                PartnerTargetPosition::updateOrCreate(
                    [
                        'partner_target_id' => $target->id,
                        'position' => $posData['position'],
                    ],
                    ['target_count' => $posData['target_count']]
                );
            }

            $count++;
        }

        $this->command->info("$count monthly targets with positions seeded for M28 (Jan 2026 – Mei 2026).");
    }
}
