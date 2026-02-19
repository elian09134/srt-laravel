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
                'jobdesk' => "We are looking for an experienced Frontend Developer to join our team.\n\n" . 
                             "- Develop new user-facing features\n" .
                             "- Build reusable code and libraries for future use\n" .
                             "- Ensure the technical feasibility of UI/UX designs",
                'requirement' => "- Proficient in React.js and Vue.js\n" .
                                 "- Experience with Tailwind CSS\n" .
                                 "- Understanding of server-side CSS pre-processing platforms",
                'benefits' => "- Competitive salary\n- Health insurance\n- Flexible working hours",
                'salary_range' => 'Rp 15.000.000 - Rp 25.000.000',
                'is_active' => true,
            ],
            [
                'title' => 'Human Capital Manager',
                'location' => 'Surabaya, Indonesia', 
                'type' => 'Full-time',
                'division' => 'HCM',
                'jobdesk' => "We are seeking a Human Capital Manager to oversee our HR department.\n\n" . 
                             "- Develop and implement HR strategies and initiatives\n" .
                             "- Bridge management and employee relations\n" .
                             "- Manage the recruitment and selection process",
                'requirement' => "- Proven working experience as HR Manager\n" .
                                 "- People oriented and results driven\n" .
                                 "- Knowledge of HR systems and databases",
                'benefits' => "- Leadership training\n- Performance bonus\n- Private office",
                'salary_range' => 'Rp 20.000.000 - Rp 35.000.000',
                'is_active' => true,
            ],
            [
                'title' => 'Finance Staff',
                'location' => 'Jakarta, Indonesia',
                'type' => 'Full-time', 
                'division' => 'Finance',
                'jobdesk' => "We are looking for a Finance Staff to manage our financial transactions.\n\n" . 
                             "- Manage all accounting transactions\n" .
                             "- Publish financial statements in time\n" .
                             "- Handle monthly, quarterly and annual closings",
                'requirement' => "- Work experience as an Accountant\n" .
                                 "- Excellent knowledge of accounting regulations and procedures\n" .
                                 "- Hands-on experience with accounting software",
                'benefits' => "- Meal allowance\n- Transport allowance",
                'salary_range' => 'Rp 8.000.000 - Rp 12.000.000', 
                'is_active' => true,
            ],
             [
                'title' => 'IT Support Specialist',
                'location' => 'Bandung, Indonesia',
                'type' => 'Contract',
                'division' => 'Digital Technology',
                'jobdesk' => "We are looking for an IT Support Specialist to provide technical assistance.\n\n" . 
                             "- Install and configure computer hardware operating systems and applications\n" .
                             "- Monitor and maintain computer systems and networks\n" .
                             "- Troubleshoot system and network problems",
                'requirement' => "- Proven experience as IT Support Specialist\n" .
                                 "- Basic understanding of networking concepts\n" .
                                 "- Good problem-solving skills",
                'benefits' => "- Technical certification support\n- Career growth",
                'salary_range' => 'Rp 6.000.000 - Rp 9.000.000',
                'is_active' => true,
            ],
        ];

        foreach ($jobs as $jobData) {
            Job::create($jobData);
        }
    }
}
