<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use App\Models\TalentPool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with analytics.
     */
    public function index()
    {
        // 1. Mengambil data untuk Ringkasan Umum
        $total_applicants = Application::count();
        $total_jobs = Job::count();
        $total_talent_pool = TalentPool::count();

        // 2. Mengambil data untuk Chart Status Pelamar
        $status_distribution = Application::query()
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // 3. Ambil beberapa lowongan aktif beserta jumlah lamaran
        $active_jobs = Job::where('is_active', 1)
            ->withCount('applications')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Mengirim semua data ke view
        return view('admin.dashboard', [
            'total_applicants' => $total_applicants,
            'total_jobs' => $total_jobs,
            'total_talent_pool' => $total_talent_pool,
            'status_distribution' => $status_distribution,
            'active_jobs' => $active_jobs,
        ]);
    }
}
