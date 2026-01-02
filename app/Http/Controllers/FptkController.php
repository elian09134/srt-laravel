<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fptk;

class FptkController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if (! $user || $user->role !== 'operasional') {
            abort(403);
        }

        return view('fptk.index');
    }

    public function store(Request $request)
    {
        $user = $request->user();
        if (! $user || $user->role !== 'operasional') {
            abort(403);
        }

        $data = $request->validate([
            'position' => 'required|string|max:255',
            'locations' => 'nullable|string|max:255',
            'qty' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:2000',
        ]);

        // Persist to DB
        $fptk = Fptk::create([
            'user_id' => $user->id,
            'position' => $data['position'],
            'locations' => $data['locations'] ?? null,
            'qty' => $data['qty'],
            'notes' => $data['notes'] ?? null,
            'status' => 'pending',
        ]);

        return back()->with('status', 'FPTK berhasil dikirim ke tim HR. (Status: pending)');
    }
}
