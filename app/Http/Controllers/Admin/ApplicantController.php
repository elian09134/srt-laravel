<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use App\Models\TalentPool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicantController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data untuk filter dropdown
        $jobs = Job::orderBy('title')->get();
        $statuses = [
            'Baru',
            'Lamaran Dilihat',
            'Psikotest',
            'Wawancara HR',
            'Wawancara User',
            'Offering Letter',
            'Shortlist',
            'Diterima',
            'Tidak Lanjut',
        ];

        // Query dasar untuk mengambil data lamaran
        $query = Application::with(['user.profile', 'job']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('applicant_name', 'like', '%'.$search.'%')
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', '%'.$search.'%');
                    })
                    ->orWhereHas('job', function ($jq) use ($search) {
                        $jq->where('title', 'like', '%'.$search.'%');
                    });
            });
        }

        if ($request->filled('job_id')) {
            $query->where('job_id', $request->job_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('referral_source')) {
            $query->whereHas('user', function ($uq) use ($request) {
                $uq->where('referral_source', $request->referral_source);
            });
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $applications = $query->latest()->paginate(15);

        $referralSources = \App\Models\User::whereNotNull('referral_source')
            ->distinct()
            ->pluck('referral_source')
            ->toArray();

        return view('admin.applicants', [
            'applications' => $applications,
            'jobs' => $jobs,
            'statuses' => $statuses,
            'referralSources' => $referralSources,
        ]);
    }

    /**
     * Show the detail for a single application.
     */
    public function show(Application $application)
    {
        $application->load(['user.profile', 'user.workExperiences', 'job', 'statusHistories']);

        // Jika status masih 'Baru' atau kosong, tandai sebagai 'Lamaran Dilihat' saat detail dibuka
        if (empty($application->status) || $application->status === 'Baru') {
            $application->update(['status' => 'Lamaran Dilihat']);
            // catat ke history
            \App\Models\ApplicationStatusHistory::create([
                'application_id' => $application->id,
                'status' => 'Lamaran Dilihat',
                'note' => 'Dilihat oleh tim rekrutmen',
                'changed_by' => Auth::id(),
            ]);
            // reload to reflect change
            $application->refresh();
            $application->load('statusHistories');
        }

        return view('admin.applicants.show', [
            'application' => $application,
        ]);
    }

    public function updateStatus(Request $request, Application $application)
    {
        $request->validate(['status' => 'required|string', 'join_date' => 'nullable|date']);

        $oldStatus = $application->status;
        $newStatus = $request->status;

        // Jika akan menerima kandidat, cek kuota FPTK
        if ($newStatus === 'Diterima' && $oldStatus !== 'Diterima') {
            $fptk = $application->job?->fptk;
            if ($fptk && $fptk->isFulfilled()) {
                return back()->with('error', 'Kuota FPTK untuk posisi ini sudah terpenuhi ('.$fptk->fulfilled_count.'/'.$fptk->qty.'). Tidak dapat menerima lebih banyak kandidat.');
            }

            // Cek partner target (M28) — limit jumlah user Diterima per posisi per bulan
            /*
            $referralSource = $application->user?->referral_source;
            if ($referralSource) {
                $partner = \App\Models\User::where('name', $referralSource)->where('role', 'partner')->first();
                if ($partner) {
                    $userDate = $application->user->created_at;
                    $year = $userDate->year;
                    $month = $userDate->month;
                    $positionTitle = $application->job?->title;

                    if ($positionTitle) {
                        $positionTarget = \App\Models\PartnerTargetPosition::whereHas('partnerTarget', function ($q) use ($partner, $year, $month) {
                            $q->where('user_id', $partner->id)->where('year', $year)->where('month', $month);
                        })->where('position', $positionTitle)->first();

                        if ($positionTarget) {
                            $diterimaUsers = \App\Models\User::where('referral_source', $referralSource)
                                ->whereYear('created_at', $year)
                                ->whereMonth('created_at', $month)
                                ->whereHas('applications', function ($q) use ($positionTitle) {
                                    $q->where('status', 'Diterima')
                                        ->whereHas('job', fn ($j) => $j->where('title', $positionTitle));
                                })
                                ->count();

                            if ($diterimaUsers >= $positionTarget->target_count) {
                                return back()->with('error', 'Target M28 untuk posisi '.$positionTitle.' bulan ini sudah terpenuhi ('.$diterimaUsers.'/'.$positionTarget->target_count.').');
                            }
                        }
                    }
                }
            }
            */
        }

        $data = ['status' => $newStatus];
        if ($newStatus === 'Diterima' && $request->filled('join_date')) {
            $data['join_date'] = $request->join_date;
        }

        $application->update($data);

        // Auto-increment fulfilled_count jika baru diterima
        if ($newStatus === 'Diterima' && $oldStatus !== 'Diterima') {
            $fptk = $application->job?->fptk;
            if ($fptk) {
                $fptk->increment('fulfilled_count');
            }
        }

        // Decrement fulfilled_count jika berubah dari Diterima ke status lain
        if ($oldStatus === 'Diterima' && $newStatus !== 'Diterima') {
            $fptk = $application->job?->fptk;
            if ($fptk && $fptk->fulfilled_count > 0) {
                $fptk->decrement('fulfilled_count');
            }
        }

        // create history entry
        \App\Models\ApplicationStatusHistory::create([
            'application_id' => $application->id,
            'status' => $newStatus,
            'note' => ($newStatus === 'Diterima' && $request->filled('join_date')) ? 'Join date: '.$request->join_date : null,
            'changed_by' => Auth::id(),
        ]);

        return back()->with('success', 'Status lamaran berhasil diperbarui.');
    }

    public function addToTalentPool(Application $application)
    {
        // Jika status sebelumnya Diterima, decrement fulfilled_count
        if ($application->status === 'Diterima') {
            $fptk = $application->job?->fptk;
            if ($fptk && $fptk->fulfilled_count > 0) {
                $fptk->decrement('fulfilled_count');
            }
        }

        // Cek apakah sudah ada, jika belum, tambahkan
        TalentPool::firstOrCreate(['user_id' => $application->user_id]);

        // Update status lamaran menjadi Shortlist
        $application->update(['status' => 'Shortlist']);

        // record history
        \App\Models\ApplicationStatusHistory::create([
            'application_id' => $application->id,
            'status' => 'Shortlist',
            'note' => 'Ditambahkan ke Talent Pool',
            'changed_by' => Auth::id(),
        ]);

        return back()->with('success', 'Kandidat berhasil ditambahkan ke Talent Pool.');
    }
}
