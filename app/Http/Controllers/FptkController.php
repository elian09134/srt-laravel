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
            // additional fields saved into notes as JSON
            'division' => 'nullable|string|max:255',
            'dasar_permintaan' => 'nullable|string|max:1000',
            'date_needed' => 'nullable|date',
            'status_type' => 'nullable|string|max:100',
            'golongan_gaji' => 'nullable|string|max:255',
            'penempatan' => 'nullable|string|max:255',
            'gaji' => 'nullable|string|max:255',
            'usia' => 'nullable|string|max:255',
            'pendidikan' => 'nullable|string|max:255',
            'keterampilan' => 'nullable|string|max:2000',
            'pengalaman' => 'nullable|string|max:2000',
            'uraian' => 'nullable|string|max:4000',
            'notes' => 'nullable|string|max:2000',
        ]);

        // pack extra fields into notes as JSON so DB schema doesn't need change
        $extra = [
            'division' => $data['division'] ?? null,
            'dasar_permintaan' => $data['dasar_permintaan'] ?? null,
            'date_needed' => $data['date_needed'] ?? null,
            'status_type' => $data['status_type'] ?? null,
            'golongan_gaji' => $data['golongan_gaji'] ?? null,
            'penempatan' => $data['penempatan'] ?? null,
            'gaji' => $data['gaji'] ?? null,
            'usia' => $data['usia'] ?? null,
            'pendidikan' => $data['pendidikan'] ?? null,
            'keterampilan' => $data['keterampilan'] ?? null,
            'pengalaman' => $data['pengalaman'] ?? null,
            'uraian' => $data['uraian'] ?? null,
            'notes' => $data['notes'] ?? null,
        ];

        $fptk = Fptk::create([
            'user_id' => $user->id,
            'position' => $data['position'],
            'locations' => $data['locations'] ?? null,
            'qty' => $data['qty'],
            'notes' => json_encode($extra, JSON_UNESCAPED_UNICODE),
            'status' => 'pending',
        ]);

        return back()->with('status', 'FPTK berhasil dikirim ke tim HR. (Status: pending)');
    }
}
