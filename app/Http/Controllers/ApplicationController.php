<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        if ($exists) {
            return redirect()->back()->with('error', 'Anda telah mengirimkan lamaran untuk posisi ini.');
        }

        $profile = $user->profile ?? null;

        Application::create([
            'user_id' => $user->id,
            'job_id' => $job->id,
            'status' => 'Baru',
            'cover_letter' => $request->cover_letter,
            'applicant_name' => $user->name,
            'applicant_email' => $user->email,
            'applicant_phone' => $profile->phone ?? null,
            'applicant_last_position' => $profile->last_position ?? null,
            'applicant_last_education' => $profile->last_education ?? null,
        ]);

        return redirect()->back()->with('success', 'Lamaran berhasil dikirim. Terima kasih!');
    }
}
