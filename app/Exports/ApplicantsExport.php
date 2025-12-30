<?php

namespace App\Exports;

use App\Models\Application;

class ApplicantsExport
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * Get the data to export
     */
    public function getData()
    {
        $query = Application::with(['user.profile', 'user.workExperiences', 'job']);

        // Apply filters
        if (!empty($this->filters['job_id'])) {
            $query->where('job_id', $this->filters['job_id']);
        }
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        $applications = $query->latest()->get();

        // Transform data for export
        return $applications->map(function ($application) {
            return [
                'Nama Lengkap' => $application->user->name ?? '-',
                'Email' => $application->user->email ?? '-',
                'No. HP' => $application->user->profile->phone_number ?? '-',
                'Posisi yang Dilamar' => $application->job->title ?? '-',
                'Status' => $application->status ?? 'Baru',
                'Tanggal Lahir' => $application->user->profile->date_of_birth ?? '-',
                'Pendidikan' => $application->user->profile->education_level ?? '-',
                'Institusi' => $application->user->profile->institution ?? '-',
                'Jurusan' => $application->user->profile->major ?? '-',
                'Pengalaman Terakhir' => $application->user->workExperiences->first()->company ?? '-',
                'Ekspektasi Gaji' => $application->user->profile->expected_salary 
                    ? 'Rp ' . number_format($application->user->profile->expected_salary, 0, ',', '.') 
                    : '-',
                'Tanggal Melamar' => $application->created_at->format('d/m/Y H:i'),
            ];
        });
    }
}

