<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use App\Models\TalentPool;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data untuk filter dropdown
        $jobs = Job::orderBy('title')->get();
        $statuses = ["Baru", "Lamaran Dilihat", "Psikotest", "Wawancara", "Offering Letter", "Diterima", "Tidak Lanjut", "Shortlist"];

        // Query dasar untuk mengambil data lamaran
        $query = Application::with(['user.profile', 'job']);

        // Terapkan filter jika ada
        if ($request->filled('job_id')) {
            $query->where('job_id', $request->job_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $applications = $query->latest()->paginate(15);

        return view('admin.applicants', [
            'applications' => $applications,
            'jobs' => $jobs,
            'statuses' => $statuses,
        ]);
    }

    /**
     * Show the detail for a single application.
     */
    public function show(Application $application)
    {
        $application->load(['user.profile', 'user.workExperiences', 'job']);

        // Jika status masih 'Baru' atau kosong, tandai sebagai 'Lamaran Dilihat' saat detail dibuka
        if (empty($application->status) || $application->status === 'Baru') {
            $application->update(['status' => 'Lamaran Dilihat']);
            // reload to reflect change
            $application->refresh();
        }

        return view('admin.applicants.show', [
            'application' => $application,
        ]);
    }

    public function updateStatus(Request $request, Application $application)
    {
        $request->validate(['status' => 'required|string']);
        $application->update(['status' => $request->status]);
        return back()->with('success', 'Status lamaran berhasil diperbarui.');
    }

    public function addToTalentPool(Application $application)
    {
        // Cek apakah sudah ada, jika belum, tambahkan
        TalentPool::firstOrCreate(['user_id' => $application->user_id]);
        
        // Update status lamaran menjadi Shortlist
        $application->update(['status' => 'Shortlist']);

        return back()->with('success', 'Kandidat berhasil ditambahkan ke Talent Pool.');
    }
}
