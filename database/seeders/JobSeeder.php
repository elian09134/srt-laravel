<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobs = [
            [
                'title' => 'Senior Frontend Developer',
                'location' => 'Jakarta, Indonesia',
                'type' => 'Full-time',
                'division' => 'Digital Technology',
                'jobdesk' => "We are looking for an experienced Frontend Developer to join our team.\n\n".
                             "- Develop new user-facing features\n".
                             "- Build reusable code and libraries for future use\n".
                             '- Ensure the technical feasibility of UI/UX designs',
                'requirement' => json_encode(['- Proficient in React.js and Vue.js', '- Experience with Tailwind CSS', '- Understanding of server-side CSS pre-processing platforms']),
                'benefits' => json_encode(['- Competitive salary', '- Health insurance', '- Flexible working hours']),
                'salary_range' => 'Rp 15.000.000 - Rp 25.000.000',
                'is_active' => true,
            ],
            [
                'title' => 'Human Capital Manager',
                'location' => 'Surabaya, Indonesia',
                'type' => 'Full-time',
                'division' => 'HCM',
                'jobdesk' => "We are seeking a Human Capital Manager to oversee our HR department.\n\n".
                             "- Develop and implement HR strategies and initiatives\n".
                             "- Bridge management and employee relations\n".
                             '- Manage the recruitment and selection process',
                'requirement' => json_encode(['- Proven working experience as HR Manager', '- People oriented and results driven', '- Knowledge of HR systems and databases']),
                'benefits' => json_encode(['- Leadership training', '- Performance bonus', '- Private office']),
                'salary_range' => 'Rp 20.000.000 - Rp 35.000.000',
                'is_active' => true,
            ],
            [
                'title' => 'Finance Staff',
                'location' => 'Jakarta, Indonesia',
                'type' => 'Full-time',
                'division' => 'Finance',
                'jobdesk' => "We are looking for a Finance Staff to manage our financial transactions.\n\n".
                             "- Manage all accounting transactions\n".
                             "- Publish financial statements in time\n".
                             '- Handle monthly, quarterly and annual closings',
                'requirement' => json_encode(['- Work experience as an Accountant', '- Excellent knowledge of accounting regulations and procedures', '- Hands-on experience with accounting software']),
                'benefits' => json_encode(['- Meal allowance', '- Transport allowance']),
                'salary_range' => 'Rp 8.000.000 - Rp 12.000.000',
                'is_active' => true,
            ],
            [
                'title' => 'IT Support Specialist',
                'location' => 'Bandung, Indonesia',
                'type' => 'Contract',
                'division' => 'Digital Technology',
                'jobdesk' => "We are looking for an IT Support Specialist to provide technical assistance.\n\n".
                             "- Install and configure computer hardware operating systems and applications\n".
                             "- Monitor and maintain computer systems and networks\n".
                             '- Troubleshoot system and network problems',
                'requirement' => json_encode(['- Proven experience as IT Support Specialist', '- Basic understanding of networking concepts', '- Good problem-solving skills']),
                'benefits' => json_encode(['- Technical certification support', '- Career growth']),
                'salary_range' => 'Rp 6.000.000 - Rp 9.000.000',
                'is_active' => true,
            ],
        ];

        foreach ($jobs as $jobData) {
            Job::create($jobData);
        }
    }
}
