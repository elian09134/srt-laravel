<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\WorkExperience;
use App\Models\TalentPool;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TalentPoolSeeder extends Seeder
{
    public function run(): void
    {
        $talents = [
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'role' => 'applicant',
                'phone' => '081234567810',
                'education' => 'S1 Teknik Informatika',
                'institution' => 'Universitas Indonesia',
                'last_company' => 'Tech Corp',
                'last_position' => 'Senior Developer',
                'status' => 'Shortlist',
                'job_preferences' => 'Backend Developer, System Architect',
                'experiences' => [
                    ['company' => 'Tech Corp', 'duration' => '3 Years', 'desc' => 'Led the backend team and implemented microservices.'],
                    ['company' => 'Web Start', 'duration' => '2 Years', 'desc' => 'Fullstack developer focusing on Laravel and React.'],
                ]
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'role' => 'applicant',
                'phone' => '081234567811',
                'education' => 'S1 Akuntansi',
                'institution' => 'Universitas Gadjah Mada',
                'last_company' => 'Finance Solutions',
                'last_position' => 'Accountant',
                'status' => 'Shortlist',
                'job_preferences' => 'Finance Manager, Financial Analyst',
                'experiences' => [
                    ['company' => 'Finance Solutions', 'duration' => '4 Years', 'desc' => 'Managed company financial records and audits.'],
                ]
            ],
            [
                'name' => 'Alex Johnson',
                'email' => 'alex.j@example.com',
                'role' => 'applicant',
                'phone' => '081234567812',
                'education' => 'S1 Hukum',
                'institution' => 'Universitas Padjadjaran',
                'last_company' => 'Legal Firm ABC',
                'last_position' => 'Legal Counsel',
                'status' => 'Shortlist',
                'job_preferences' => 'Legal Manager, Corporate Lawyer',
                'experiences' => [
                    ['company' => 'Legal Firm ABC', 'duration' => '5 Years', 'desc' => 'Expert in corporate law and contract drafting.'],
                ]
            ],
            [
                'name' => 'Siti Rohmah',
                'email' => 'siti.rohmah@example.com',
                'role' => 'applicant',
                'phone' => '081234567813',
                'education' => 'S1 Psikologi',
                'institution' => 'Universitas Indonesia',
                'last_company' => 'HR Agency',
                'last_position' => 'Senior Recruiter',
                'status' => 'Shortlist',
                'job_preferences' => 'HR Manager, Talent Acquisition',
                'experiences' => [
                    ['company' => 'HR Agency', 'duration' => '3 Years', 'desc' => 'Specialized in tech recruitment and executive search.'],
                ]
            ],
            [
                'name' => 'Bambang Sudarmono',
                'email' => 'bambang.s@example.com',
                'role' => 'applicant',
                'phone' => '081234567814',
                'education' => 'D3 Teknik Elektro',
                'institution' => 'Politeknik Negeri Jakarta',
                'last_company' => 'Power Plant X',
                'last_position' => 'Electrical Technician',
                'status' => 'Shortlist',
                'job_preferences' => 'Electrical Engineer, Technician',
                'experiences' => [
                    ['company' => 'Power Plant X', 'duration' => '6 Years', 'desc' => 'Maintenance of high voltage electrical systems.'],
                ]
            ],
        ];

        foreach ($talents as $data) {
            // Create User
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => $data['role'],
            ]);

            // Create User Profile
            UserProfile::create([
                'user_id' => $user->id,
                'phone_number' => $data['phone'],
                'education_level' => $data['education'],
                'institution' => $data['institution'],
                'last_company' => $data['last_company'],
                'last_position' => $data['last_position'],
            ]);

            // Create Work Experiences
            foreach ($data['experiences'] as $exp) {
                WorkExperience::create([
                    'user_id' => $user->id,
                    'company_name' => $exp['company'],
                    'duration' => $exp['duration'],
                    'job_description' => $exp['desc'],
                ]);
            }

            // Create Talent Pool Entry
            TalentPool::create([
                'user_id' => $user->id,
                'status' => $data['status'],
                'job_preferences' => $data['job_preferences'],
            ]);
        }

        $this->command->info('Seed Talent Pool Data successful.');
    }
}
