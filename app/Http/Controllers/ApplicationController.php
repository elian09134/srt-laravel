<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ApplicationStatusHistory;
use Illuminate\Support\Facades\Log;

class ApplicationController extends Controller
{
    /**
     * Store a newly created application in storage.
     */
    public function store(Job $job, Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'cover_letter' => 'nullable|string|max:2000',
        ]);

        // Prevent duplicate applications
        $exists = Application::where('job_id', $job->id)
            ->where('user_id', $user->id)
            ->exists();

        // Check verification limit (Max 2 active applications)
        $applicationCount = Application::where('user_id', $user->id)->count();
        if ($applicationCount >= 2) {
            return redirect()->back()->with('error', 'Anda hanya dapat melamar maksimal 2 lowongan pekerjaan.');
        }

        if ($exists) {
            return redirect()->back()->with('error', 'Anda telah mengirimkan lamaran untuk posisi ini.');
        }

        $profile = $user->profile ?? null;
        $workExperiences = $user->workExperiences ?? collect();

        // Ambil pengalaman kerja terakhir
        $lastExperience = $workExperiences->first();

        // Build snapshot data lengkap
        $snapshotData = [
            'name' => $user->name,
            'email' => $user->email,
            'phone_number' => $profile?->phone_number,
            'date_of_birth' => $profile?->date_of_birth,
            'education_level' => $profile?->education_level,
            'institution' => $profile?->institution,
            'major' => $profile?->major,
            'skills' => $profile?->skills,
            'languages' => $profile?->languages,
            'about_me' => $profile?->about_me,
            'currently_employed' => $profile?->currently_employed ?? false,
            'expected_salary' => $profile?->expected_salary,
            'cv_path' => $profile?->cv_path,
            'photo_path' => $profile?->photo_path,
            'work_experiences' => $workExperiences->map(function ($exp) {
                return [
                    'company_name' => $exp->company_name,
                    'duration' => $exp->duration,
                    'job_description' => $exp->job_description,
                ];
            })->toArray(),
        ];

        $application = Application::create([
            'user_id' => $user->id,
            'job_id' => $job->id,
            'status' => 'Baru',
            'cover_letter' => $request->cover_letter,
            'applicant_name' => $user->name,
            'applicant_email' => $user->email,
            'applicant_phone' => $profile?->phone_number ?? '-',
            'applicant_last_position' => \Illuminate\Support\Str::limit($lastExperience?->job_description ?? ($profile?->last_position ?? '-'), 250),
            'applicant_last_education' => $profile?->education_level ?? ($profile?->last_education ?? '-'),
            'snapshot_data' => json_encode($snapshotData),
        ]);

        // record initial status history
        ApplicationStatusHistory::create([
            'application_id' => $application->id,
            'status' => 'Baru',
            'note' => 'Lamaran dikirim oleh pelamar',
            'changed_by' => $user->id,
        ]);

        Log::info('User applied for job', [
            'user_id' => $user->id,
            'email' => $user->email,
            'job_id' => $job->id,
            'job_title' => $job->title,
            'application_id' => $application->id
        ]);

        return redirect()->back()->with('success', 'Lamaran berhasil dikirim. Terima kasih!');
    }
}
