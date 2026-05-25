<?php

namespace App\Http\Controllers\M28;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $partner = Auth::user();
        $partnerName = $partner->name;

        $bulan = $request->input('bulan', now()->format('Y-m'));
        $posisi = $request->input('posisi');

        if ($bulan === 'all') {
            $userQuery = User::where('referral_source', $partnerName);
            $appQuery = Application::whereHas('user', fn ($q) => $q->where('referral_source', $partnerName));
        } else {
            $selectedDate = \Carbon\Carbon::parse($bulan.'-01');
            $monthStart = $selectedDate->copy()->startOfMonth();
            $monthEnd = $selectedDate->copy()->endOfMonth();

            $userQuery = User::where('referral_source', $partnerName)
                ->whereBetween('created_at', [$monthStart, $monthEnd]);

            $appQuery = Application::whereHas('user', function ($q) use ($partnerName, $monthStart, $monthEnd) {
                $q->where('referral_source', $partnerName)
                    ->whereBetween('created_at', [$monthStart, $monthEnd]);
            });
        }

        if ($posisi) {
            $userQuery->whereHas('applications', fn ($q) => $q->whereHas('job', fn ($j) => $j->where('title', $posisi)));
            $appQuery->whereHas('job', fn ($j) => $j->where('title', $posisi));
        }

        $positionOptions = \App\Models\Job::orderBy('title')->pluck('title');

        $totalCandidates = (clone $userQuery)->count();

        $totalApplications = (clone $appQuery)->count();

        $statusDistribution = (clone $appQuery)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $recentCandidates = (clone $userQuery)
            ->with(['applications.job', 'profile'])
            ->latest()
            ->take(5)
            ->get();

        $monthOptions = [
            ['value' => 'all', 'label' => 'Semua Bulan'],
        ];
        for ($m = 5; $m >= 0; $m--) {
            $date = now()->subMonths($m);
            $monthOptions[] = [
                'value' => $date->format('Y-m'),
                'label' => $date->isoFormat('MMMM Y'),
            ];
        }

        $yearlyActual = User::where('referral_source', $partnerName)
            ->whereYear('created_at', now()->year)
            ->when($posisi, function ($q) use ($posisi) {
                $q->whereHas('applications', fn ($app) => $app->whereHas('job', fn ($j) => $j->where('title', $posisi)));
            })
            ->count();

        $targetYearly = DB::table('partner_targets')
            ->where('user_id', $partner->id)
            ->where('year', now()->year)
            ->whereNull('month')
            ->value('target_count');

        $yearlyPct = $targetYearly > 0 ? round(($yearlyActual / $targetYearly) * 100) : 0;

        $targetMonthlyRows = DB::table('partner_targets')
            ->where('user_id', $partner->id)
            ->where('year', now()->year)
            ->whereNotNull('month')
            ->orderBy('month')
            ->get();

        $monthlyBreakdown = $targetMonthlyRows->map(function ($target) use ($partnerName, $posisi, $bulan) {
            if ($bulan !== 'all' && $target->month !== (int) \Carbon\Carbon::parse($bulan.'-01')->month) {
                return null;
            }

            $positionTargets = DB::table('partner_target_positions')
                ->where('partner_target_id', $target->id)
                ->when($posisi, fn ($q) => $q->where('position', $posisi))
                ->get();

            $positionProgress = [];
            $filteredMonthlyTarget = 0;
            $filteredMonthlyActual = 0;

            foreach ($positionTargets as $pt) {
                $posActual = User::where('referral_source', $partnerName)
                    ->whereYear('created_at', $target->year)
                    ->whereMonth('created_at', $target->month)
                    ->whereHas('applications', function ($q) use ($pt) {
                        $q->whereHas('job', fn ($j) => $j->where('title', $pt->position));
                    })
                    ->count();

                $posPct = $pt->target_count > 0 ? round(($posActual / $pt->target_count) * 100) : 0;
                $positionProgress[] = [
                    'position' => $pt->position,
                    'target' => $pt->target_count,
                    'actual' => $posActual,
                    'pct' => $posPct,
                ];

                $filteredMonthlyTarget += $pt->target_count;
                $filteredMonthlyActual += $posActual;
            }

            if ($posisi) {
                $target->target_count = $filteredMonthlyTarget;
                $target->actual = $filteredMonthlyActual;
            } else {
                $target->actual = User::where('referral_source', $partnerName)
                    ->whereYear('created_at', $target->year)
                    ->whereMonth('created_at', $target->month)
                    ->count();
            }

            $target->pct = $target->target_count > 0 ? round(($target->actual / $target->target_count) * 100) : 0;
            $target->positionProgress = $positionProgress;

            return $target;
        })->filter()->values();

        $monthNames = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'];

        return view('m28.dashboard', [
            'totalCandidates' => $totalCandidates,
            'totalApplications' => $totalApplications,
            'statusDistribution' => $statusDistribution,
            'recentCandidates' => $recentCandidates,
            'bulan' => $bulan,
            'monthOptions' => $monthOptions,
            'targetYearly' => $targetYearly,
            'yearlyActual' => $yearlyActual,
            'yearlyPct' => $yearlyPct,
            'monthlyBreakdown' => $monthlyBreakdown,
            'monthNames' => $monthNames,
            'posisi' => $posisi,
            'positionOptions' => $positionOptions,
        ]);
    }
}
