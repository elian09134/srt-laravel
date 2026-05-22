<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartnerTarget;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartnerTargetController extends Controller
{
    public function index()
    {
        $partners = User::where('role', 'partner')
            ->with('partnerTargets')
            ->orderBy('name')
            ->get();

        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        $currentYear = now()->year;

        return view('admin.partner-targets.index', compact('partners', 'months', 'currentYear'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'year' => 'required|integer|min:2020|max:2099',
            'month' => 'nullable|integer|min:1|max:12',
            'target_count' => 'required|integer|min:1',
        ]);

        PartnerTarget::updateOrCreate(
            [
                'user_id' => $validated['user_id'],
                'year' => $validated['year'],
                'month' => $validated['month'],
            ],
            ['target_count' => $validated['target_count']]
        );

        return redirect()->route('admin.partner-targets.index')
            ->with('success', 'Target berhasil disimpan.');
    }

    public function destroy(PartnerTarget $partnerTarget)
    {
        $partnerTarget->delete();

        return redirect()->route('admin.partner-targets.index')
            ->with('success', 'Target berhasil dihapus.');
    }
}
