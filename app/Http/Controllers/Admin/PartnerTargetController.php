<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\PartnerTarget;
use App\Models\PartnerTargetPosition;
use App\Models\User;
use Illuminate\Http\Request;

class PartnerTargetController extends Controller
{
    public function index()
    {
        $partners = User::where('role', 'partner')
            ->with(['partnerTargets.positions'])
            ->orderBy('name')
            ->get();

        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        $currentYear = now()->year;
        $availablePositions = Job::select('title')->distinct()->orderBy('title')->pluck('title');

        $positionProgress = [];

        foreach ($partners as $partner) {
            $partnerName = $partner->name;
            foreach ($partner->partnerTargets as $target) {
                if ($target->month === null) {
                    continue;
                }

                foreach ($target->positions as $posTarget) {
                    $actual = User::where('referral_source', $partnerName)
                        ->whereYear('created_at', $target->year)
                        ->whereMonth('created_at', $target->month)
                        ->whereHas('applications.job', function ($q) use ($posTarget) {
                            $q->where('title', $posTarget->position);
                        })
                        ->count();

                    $pct = $posTarget->target_count > 0
                        ? round(($actual / $posTarget->target_count) * 100)
                        : 0;

                    $positionProgress[$target->id][$posTarget->id] = [
                        'actual' => $actual,
                        'pct' => $pct,
                    ];
                }
            }
        }

        return view('admin.partner-targets.index', compact(
            'partners', 'months', 'currentYear',
            'availablePositions', 'positionProgress'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'year' => 'required|integer|min:2020|max:2099',
            'month' => 'nullable|integer|min:1|max:12',
            'target_count' => 'nullable|integer|min:1',
            'positions' => 'nullable|array',
            'positions.*.position' => 'required|string|max:255',
            'positions.*.target_count' => 'required|integer|min:1',
        ]);

        $targetCount = $validated['target_count'] ?? 0;

        if ($request->has('positions')) {
            $sumPositions = collect($validated['positions'])->sum('target_count');
            if ($sumPositions > 0) {
                $targetCount = $sumPositions;
            }
        }

        $partnerTarget = PartnerTarget::updateOrCreate(
            [
                'user_id' => $validated['user_id'],
                'year' => $validated['year'],
                'month' => $validated['month'],
            ],
            ['target_count' => $targetCount]
        );

        if ($request->has('positions')) {
            $partnerTarget->positions()->delete();

            foreach ($validated['positions'] as $pos) {
                $partnerTarget->positions()->create([
                    'position' => $pos['position'],
                    'target_count' => $pos['target_count'],
                ]);
            }
        }

        return redirect()->route('admin.partner-targets.index')
            ->with('success', 'Target berhasil disimpan.');
    }

    public function destroy(PartnerTarget $partnerTarget)
    {
        $partnerTarget->delete();

        return redirect()->route('admin.partner-targets.index')
            ->with('success', 'Target berhasil dihapus.');
    }

    public function storePosition(Request $request, PartnerTarget $partnerTarget)
    {
        $validated = $request->validate([
            'position' => 'required|string|max:255',
            'target_count' => 'required|integer|min:1',
        ]);

        PartnerTargetPosition::updateOrCreate(
            [
                'partner_target_id' => $partnerTarget->id,
                'position' => $validated['position'],
            ],
            ['target_count' => $validated['target_count']]
        );

        return redirect()->route('admin.partner-targets.index')
            ->with('success', 'Target posisi berhasil disimpan.');
    }

    public function destroyPosition(PartnerTargetPosition $partnerTargetPosition)
    {
        $partnerTargetPosition->delete();

        return redirect()->route('admin.partner-targets.index')
            ->with('success', 'Target posisi berhasil dihapus.');
    }
}
