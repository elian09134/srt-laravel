<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        // TODO: persist FPTK to DB (new model/migration) or send notification to admin.

        return back()->with('status', 'FPTK berhasil dikirim ke tim HR.');
    }
}
