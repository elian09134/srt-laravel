<?php

namespace App\Http\Controllers;

use App\Http\Requests\Fptk\StoreFptkRequest;
use App\Models\Fptk;
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

    public function myFptk(Request $request)
    {
        $user = $request->user();
        if (! $user || $user->role !== 'operasional') {
            abort(403);
        }

        $fptks = Fptk::where('user_id', $user->id)
            ->with(['job.applications'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('fptk.my-fptk', compact('fptks'));
    }

    public function showDetail(Request $request, Fptk $fptk)
    {
        $user = $request->user();
        if (! $user || $user->role !== 'operasional') {
            abort(403);
        }

        // Ensure user can only view their own FPTK
        if ($fptk->user_id !== $user->id) {
            abort(403);
        }

        return view('fptk.detail', compact('fptk'));
    }

    public function store(StoreFptkRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

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
            'signature' => $data['signature'],
            'signer_name' => $data['signer_name'],
            'signature_date' => now()->format('Y-m-d'),
        ];

        $fptk = Fptk::create([
            'user_id' => $user->id,
            'position' => $data['position'],
            'locations' => $data['locations'] ?? null,
            'qty' => ($male + $female),
            'notes' => json_encode($extra, JSON_UNESCAPED_UNICODE),
            'status' => 'pending',
        ]);

        return back()->with('status', 'FPTK berhasil dikirim ke tim HR. (Status: pending)');
    }
}
