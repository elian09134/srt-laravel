<?php

namespace Database\Seeders;

use App\Models\Fptk;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Database\Seeder;

class FptkSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = 1;

        // Reset existing FPTK links and records
        Job::query()->update(['fptk_id' => null]);
        Fptk::query()->delete();

        $jobConfigs = [
            ['title' => 'Senior Frontend Developer', 'qty' => 5],
            ['title' => 'Human Capital Manager', 'qty' => 3],
            ['title' => 'Finance Staff', 'qty' => 3],
            ['title' => 'IT Support Specialist', 'qty' => 5],
        ];

        foreach ($jobConfigs as $config) {
            $job = Job::where('title', $config['title'])->first();
            if (!$job) continue;

            $diterimaCount = Application::where('job_id', $job->id)
                ->where('status', 'Diterima')
                ->count();

            $fptk = Fptk::create([
                'user_id' => $adminId,
                'position' => $config['title'],
                'qty' => $config['qty'],
                'status' => 'approved',
                'fulfilled_count' => min($diterimaCount, $config['qty']),
                'admin_id' => $adminId,
                'admin_signature' => 'data:image/png;base64,seeded',
                'notes' => json_encode(['division' => $job->division ?? 'General']),
            ]);

            $job->update(['fptk_id' => $fptk->id]);
        }

        $this->command->info(count($jobConfigs) . ' FPTK records created and linked to jobs.');
    }
}
