<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteContent;

class TeamMembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            [
                'name' => 'Ida Nuraida',
                'role' => 'HCM Manager',
                'department' => 'HCM',
                'bio' => 'Leading HCM strategies and organizational growth with over 10 years of leadership experience.',
                'email' => 'ida@example.com',
                'social' => ['linkedin' => 'https://linkedin.com'],
                'photo' => null
            ],
            [
                'name' => 'Elian Afriliana',
                'role' => 'IT Development',
                'department' => 'IT Development',
                'bio' => 'Driving digital transformation and high-performance IT solutions for modern business needs.',
                'email' => 'elian@example.com',
                'social' => ['linkedin' => 'https://linkedin.com'],
                'photo' => null
            ],
            [
                'name' => 'Robbi yanto',
                'role' => 'General Affair',
                'department' => 'General Affair',
                'bio' => 'Ensuring seamless workplace operations and efficient logistics for the entire team.',
                'email' => 'robbi@example.com',
                'social' => ['linkedin' => 'https://linkedin.com'],
                'photo' => null
            ],
            [
                'name' => 'Desiana Putri',
                'role' => 'Deputy Manager HCM',
                'department' => 'HCM',
                'bio' => 'Expert in human capital management, ensuring operational excellence across all departments.',
                'email' => 'desiana@example.com',
                'social' => ['linkedin' => 'https://linkedin.com'],
                'photo' => null
            ],
            [
                'name' => 'Galih Rully R.',
                'role' => 'General Affair',
                'department' => 'General Affair',
                'bio' => 'Dedicated to operational excellence, facilities management, and supportive environments.',
                'email' => 'galih@example.com',
                'social' => ['linkedin' => 'https://linkedin.com'],
                'photo' => null
            ]
        ];

        SiteContent::updateOrCreate(
            ['section_name' => 'hr_department', 'content_key' => 'members'],
            ['content_value' => json_encode($members)]
        );
    }
}
