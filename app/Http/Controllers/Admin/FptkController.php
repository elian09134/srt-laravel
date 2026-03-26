<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fptk;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class FptkController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'proses');

        // Auto-complete: cek FPTK approved yang sudah fulfilled tapi belum ditandai completed
        $this->autoCompleteFulfilled();

        $query = Fptk::with(['user', 'job.applications'])->orderBy('created_at', 'desc');

        if ($tab === 'selesai') {
            $fptks = $query->selesai()->get();
        } elseif ($tab === 'arsip') {
            $fptks = $query->get();
        } else {
            $tab = 'proses';
            $fptks = $query->proses()->get();
        }

        // Hitung jumlah per tab untuk badge
        $countProses = Fptk::proses()->count();
        $countSelesai = Fptk::selesai()->count();
        $countArsip = Fptk::count();

        return view('admin.fptk.index', compact('fptks', 'tab', 'countProses', 'countSelesai', 'countArsip'));
    }

    public function show(Fptk $fptk)
    {
        $fptk->load(['user', 'admin', 'completedByUser', 'job.applications']);
        return view('admin.fptk.show', compact('fptk'));
    }

    public function approve(Request $request, Fptk $fptk)
    {
        $request->validate([
            'admin_note' => 'nullable|string|max:2000',
            'admin_signature' => 'required|string'
        ]);

        $fptk->status = 'approved';
        $fptk->admin_id = Auth::id();
        $fptk->admin_note = $request->input('admin_note');
        $fptk->admin_signature = $request->input('admin_signature');
        $fptk->save();

        return redirect()->route('admin.fptk.index')->with('status', 'FPTK berhasil disetujui.');
    }

    public function reject(Request $request, Fptk $fptk)
    {
        $request->validate(['admin_note' => 'nullable|string|max:2000']);
        $fptk->status = 'rejected';
        $fptk->admin_id = Auth::id();
        $fptk->admin_note = $request->input('admin_note');
        $fptk->save();
        return redirect()->route('admin.fptk.index')->with('status', 'FPTK ditolak.');
    }

    public function complete(Request $request, Fptk $fptk)
    {
        if ($fptk->isCompleted()) {
            return redirect()->route('admin.fptk.show', $fptk)->with('status', 'FPTK sudah ditandai selesai sebelumnya.');
        }

        $fptk->update([
            'completed_at' => now(),
            'completed_by' => Auth::id(),
        ]);

        return redirect()->route('admin.fptk.index', ['tab' => 'selesai'])->with('status', 'FPTK berhasil ditandai selesai.');
    }

    public function exportPdf(Fptk $fptk)
    {
        $notes = is_array($fptk->notes) ? $fptk->notes : (is_string($fptk->notes) ? json_decode($fptk->notes, true) : []);
        $notes = $notes ?: [];

        // Extract signature data from notes (pengaju)
        $signatureData = null;
        if (isset($notes['signature']) && isset($notes['signer_name'])) {
            $signatureData = [
                'name' => $notes['signer_name'],
                'signature' => $notes['signature'],
                'date' => isset($notes['signature_date']) ? date('d F Y', strtotime($notes['signature_date'])) : date('d F Y', strtotime($fptk->created_at))
            ];
        }

        // Admin signature data (HR Manager)
        $adminSignatureData = null;
        if ($fptk->admin_signature && $fptk->admin) {
            $adminSignatureData = [
                'name' => $fptk->admin->name,
                'signature' => $fptk->admin_signature,
                'date' => $fptk->updated_at ? date('d F Y', strtotime($fptk->updated_at)) : date('d F Y')
            ];
        }

        $pdf = Pdf::loadView('admin.fptk.pdf', compact('fptk', 'notes', 'signatureData', 'adminSignatureData'));
        $pdf->setPaper('a4', 'portrait');

        $filename = 'FPTK-' . $fptk->id . '-' . str_replace(' ', '-', $fptk->position) . '.pdf';
        return $pdf->download($filename);
    }

    /**
     * Auto-complete FPTK yang sudah fulfilled (accepted >= qty).
     */
    private function autoCompleteFulfilled(): void
    {
        $fptkApproved = Fptk::where('status', 'approved')
            ->whereNull('completed_at')
            ->where('qty', '>', 0)
            ->with('job.applications')
            ->get();

        foreach ($fptkApproved as $fptk) {
            if ($fptk->isFulfilled()) {
                $fptk->update([
                    'completed_at' => now(),
                    'completed_by' => null, // null = otomatis
                ]);
            }
        }
    }
}
