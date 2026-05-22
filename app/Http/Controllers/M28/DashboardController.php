<?php

namespace App\Http\Controllers\M28;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Application;
use App\Models\ApplicationStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $partner = Auth::user();
        $partnerName = $partner->name;

        $bulan = $request->input('bulan', now()->format('Y-m'));

        if ($bulan === 'all') {
            $userQuery = User::where('referral_source', $partnerName);
            $appQuery = Application::whereHas('user', fn($q) => $q->where('referral_source', $partnerName));
        } else {
            $selectedDate = \Carbon\Carbon::parse($bulan . '-01');
            $monthStart = $selectedDate->copy()->startOfMonth();
            $monthEnd = $selectedDate->copy()->endOfMonth();

            $userQuery = User::where('referral_source', $partnerName)
                ->whereBetween('created_at', [$monthStart, $monthEnd]);

            $appQuery = Application::whereHas('user', function ($q) use ($partnerName, $monthStart, $monthEnd) {
                $q->where('referral_source', $partnerName)
                  ->whereBetween('created_at', [$monthStart, $monthEnd]);
            });
        }

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

        $allAppIds = Application::whereHas('user', fn($q) => $q->where('referral_source', $partnerName))->pluck('id');
        $candidateAppIds = $allAppIds;

        $funnelStages = ['Baru', 'Seleksi Berkas', 'Interview HR', 'Interview User', 'Psikotes', 'Offering', 'Diterima'];
        $funnelColors = ['#3b82f6', '#8b5cf6', '#f59e0b', '#ec4899', '#14b8a6', '#10b981', '#22c55e'];
        $funnelData = [];
        $prevFunnelData = [];
        $selectedMonth = 'Keseluruhan';
        $prevMonth = '';

        if ($bulan === 'all') {
            foreach ($funnelStages as $i => $stage) {
                $count = ApplicationStatusHistory::whereIn('application_id', $candidateAppIds)
                    ->where('status', $stage)
                    ->distinct('application_id')
                    ->count('application_id');

                $funnelData[] = [
                    'stage' => $stage,
                    'count' => $count,
                    'color' => $funnelColors[$i],
                ];
                $prevFunnelData[] = [
                    'stage' => $stage,
                    'count' => 0,
                    'color' => $funnelColors[$i],
                ];
            }
        } else {
            $selectedDate = \Carbon\Carbon::parse($bulan . '-01');
            $prevDate = $selectedDate->copy()->subMonth();

            $monthStart = $selectedDate->copy()->startOfMonth();
            $monthEnd = $selectedDate->copy()->endOfMonth();
            $prevMonthStart = $prevDate->copy()->startOfMonth();
            $prevMonthEnd = $prevDate->copy()->endOfMonth();

            foreach ($funnelStages as $i => $stage) {
                $count = ApplicationStatusHistory::whereIn('application_id', $candidateAppIds)
                    ->where('status', $stage)
                    ->whereBetween('created_at', [$monthStart, $monthEnd])
                    ->distinct('application_id')
                    ->count('application_id');

                $prevCount = ApplicationStatusHistory::whereIn('application_id', $candidateAppIds)
                    ->where('status', $stage)
                    ->whereBetween('created_at', [$prevMonthStart, $prevMonthEnd])
                    ->distinct('application_id')
                    ->count('application_id');

                $funnelData[] = [
                    'stage' => $stage,
                    'count' => $count,
                    'color' => $funnelColors[$i],
                ];
                $prevFunnelData[] = [
                    'stage' => $stage,
                    'count' => $prevCount,
                    'color' => $funnelColors[$i],
                ];
            }

            $selectedMonth = $selectedDate->isoFormat('MMMM Y');
            $prevMonth = $prevDate->isoFormat('MMMM Y');
        }

        $mainMax = max(array_column($funnelData, 'count')) ?: 1;
        $prevMax = max(array_column($prevFunnelData, 'count')) ?: 1;
        $maxCount = max($mainMax, $prevMax);

        for ($i = 0; $i < count($funnelData); $i++) {
            $firstCount = $funnelData[0]['count'] ?: 1;
            $funnelData[$i]['pct'] = round(($funnelData[$i]['count'] / $firstCount) * 100);
            $funnelData[$i]['bar_pct'] = round(($funnelData[$i]['count'] / $maxCount) * 100);

            $drop = $i > 0 && $funnelData[$i - 1]['count'] > 0
                ? round((($funnelData[$i - 1]['count'] - $funnelData[$i]['count']) / $funnelData[$i - 1]['count']) * 100)
                : 0;
            $funnelData[$i]['drop'] = $drop;

            $prevFirstCount = $prevFunnelData[0]['count'] ?: 1;
            $prevFunnelData[$i]['pct'] = round(($prevFunnelData[$i]['count'] / $prevFirstCount) * 100);
            $prevFunnelData[$i]['bar_pct'] = round(($prevFunnelData[$i]['count'] / $maxCount) * 100);

            $prevDrop = $i > 0 && $prevFunnelData[$i - 1]['count'] > 0
                ? round((($prevFunnelData[$i - 1]['count'] - $prevFunnelData[$i]['count']) / $prevFunnelData[$i - 1]['count']) * 100)
                : 0;
            $prevFunnelData[$i]['drop'] = $prevDrop;
        }

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

        $targetYearly = \DB::table('partner_targets')
            ->where('user_id', $partner->id)
            ->where('year', now()->year)
            ->whereNull('month')
            ->value('target_count');

        $yearlyActual = User::where('referral_source', $partnerName)
            ->whereYear('created_at', now()->year)
            ->count();

        $yearlyPct = $targetYearly > 0 ? round(($yearlyActual / $targetYearly) * 100) : 0;

        $monthlyBreakdown = \DB::table('partner_targets')
            ->where('user_id', $partner->id)
            ->where('year', now()->year)
            ->whereNotNull('month')
            ->orderBy('month')
            ->get()
            ->map(function ($target) use ($partnerName) {
                $actual = User::where('referral_source', $partnerName)
                    ->whereYear('created_at', $target->year)
                    ->whereMonth('created_at', $target->month)
                    ->count();
                $target->actual = $actual;
                $target->pct = $target->target_count > 0 ? round(($actual / $target->target_count) * 100) : 0;
                return $target;
            });

        $monthNames = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'];

        return view('m28.dashboard', [
            'totalCandidates' => $totalCandidates,
            'totalApplications' => $totalApplications,
            'statusDistribution' => $statusDistribution,
            'recentCandidates' => $recentCandidates,
            'funnelData' => $funnelData,
            'prevFunnelData' => $prevFunnelData,
            'bulan' => $bulan,
            'monthOptions' => $monthOptions,
            'selectedMonth' => $selectedMonth,
            'prevMonth' => $prevMonth,
            'targetYearly' => $targetYearly,
            'yearlyActual' => $yearlyActual,
            'yearlyPct' => $yearlyPct,
            'funnelColors' => $funnelColors,
            'monthlyBreakdown' => $monthlyBreakdown,
            'monthNames' => $monthNames,
        ]);
    }
}
