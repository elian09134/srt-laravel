<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fptk;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class FptkController extends Controller
{
    public function index()
    {
        $fptks = Fptk::orderBy('created_at', 'desc')->get();
        return view('admin.fptk.index', compact('fptks'));
    }

    public function show(Fptk $fptk)
    {
        return view('admin.fptk.show', compact('fptk'));
    }

    public function approve(Request $request, Fptk $fptk)
    {
        $request->validate(['admin_note' => 'nullable|string|max:2000']);
        $fptk->status = 'approved';
        $fptk->admin_id = Auth::id();
        $fptk->admin_note = $request->input('admin_note');
        $fptk->save();
        return redirect()->route('admin.fptk.index')->with('status', 'FPTK approved');
    }

    public function reject(Request $request, Fptk $fptk)
    {
        $request->validate(['admin_note' => 'nullable|string|max:2000']);
        $fptk->status = 'rejected';
        $fptk->admin_id = Auth::id();
        $fptk->admin_note = $request->input('admin_note');
        $fptk->save();
        return redirect()->route('admin.fptk.index')->with('status', 'FPTK rejected');
    }

    public function exportPdf(Fptk $fptk)
    {
        $notes = is_array($fptk->notes) ? $fptk->notes : (is_string($fptk->notes) ? json_decode($fptk->notes, true) : []);
        $notes = $notes ?: [];
        
        // Extract signature data from notes
        $signatureData = null;
        if (isset($notes['signature']) && isset($notes['signer_name'])) {
            $signatureData = [
                'name' => $notes['signer_name'],
                'signature' => $notes['signature'],
                'date' => isset($notes['signature_date']) ? date('d F Y', strtotime($notes['signature_date'])) : date('d F Y', strtotime($fptk->created_at))
            ];
        }
        
        $pdf = Pdf::loadView('admin.fptk.pdf', compact('fptk', 'notes', 'signatureData'));
        $pdf->setPaper('a4', 'portrait');
        
        $filename = 'FPTK-' . $fptk->id . '-' . str_replace(' ', '-', $fptk->position) . '.pdf';
        return $pdf->download($filename);
    }
}
