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
            'qty' => 'nullable|integer|min:0',
            'qty_female' => 'nullable|integer|min:0',
            // additional fields saved into notes as JSON
            'division' => 'nullable|string|max:255',
            'dasar_permintaan' => 'nullable|array',
            'dasar_permintaan.*' => 'string|max:1000',
            'date_needed' => 'nullable|date',
            'status_type' => 'nullable|string|max:100',
            'golongan_gaji' => 'nullable|string|max:255',
            'penempatan' => 'nullable|string|max:255',
            'gaji' => 'nullable|numeric',
            'usia' => 'nullable|string|max:255',
            'pendidikan' => 'nullable|string|max:255',
            'keterampilan' => 'nullable|string|max:2000',
            'pengalaman' => 'nullable|string|max:2000',
            'uraian' => 'nullable|string|max:4000',
            'notes' => 'nullable|string|max:2000',
        ]);

        // Pack all extra fields into notes JSON temporarily until ALTER TABLE is run
        $male = isset($data['qty']) ? (int) $data['qty'] : 0;
        $female = isset($data['qty_female']) ? (int) $data['qty_female'] : 0;
        
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
            'qty_male' => $male,
            'qty_female' => $female,
            'notes_text' => $data['notes'] ?? null,
        ];

        $fptk = Fptk::create([
            'user_id' => $user->id,
            'position' => $data['position'],
            'locations' => $data['locations'] ?? null,
            'qty' => ($male + $female),
            'status' => 'pending',
        ]);

        return back()->with('status', 'FPTK berhasil dikirim ke tim HR. (Status: pending)');
    }
}
