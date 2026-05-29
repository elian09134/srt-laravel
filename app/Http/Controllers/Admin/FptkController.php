<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fptk;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FptkController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'proses');
        $selectedDivision = $request->query('division');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Auto-complete: cek FPTK approved yang sudah fulfilled tapi belum ditandai completed
        $this->autoCompleteFulfilled();

        $query = Fptk::with(['user', 'completedByUser'])->orderBy('created_at', 'desc');

        // Apply Status Tab Filter
        if ($tab === 'selesai') {
            $query->selesai();
        } elseif ($tab === 'arsip') {
            $query->arsip();
        } else {
            $tab = 'proses';
            $query->proses();
        }

        // Apply Date Filter (Safe)
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        // Fetch results
        $fptks = $query->get();

        // Mapping Email ke Divisi sesuai data terbaru
        $emailToDivision = [
            'divisiminimarket@gmail.com' => 'MINIMARKET',
            'divisiwrapping@gmail.com' => 'WRAPPING',
            'hansmks.hlp@gmail.com' => 'HANS',
            'officefnb126@gmail.com' => 'FNB',
            'divisireflexology@gmail.com' => 'REFLEXIOLOGY',
            'businessdevelopment@srtcorp.id' => 'BUSINESS DEVELOPMENT',
            'cellulardivisi@gmail.com' => 'CELLULLER',
            'fat.holding24@gmail.com' => 'DIVISION FAT',
            'srtcreativedesign@gmail.com' => 'CREATIVE DESIGN',
            'valutamasjaya@gmail.com' => 'MONEY CHANGER',
        ];

        // Apply Division Filter on Collection based on Email Mapping
        if ($selectedDivision) {
            $fptks = $fptks->filter(function ($f) use ($selectedDivision, $emailToDivision) {
                $userEmail = $f->user->email ?? '';
                // Ambil divisi dari map email, jika tidak ada baru cek dari notes/kolom
                $mappedDiv = $emailToDivision[$userEmail] ?? ($f->notes_decoded['division'] ?? ($f->division ?? 'LAINNYA'));

                return strtoupper($mappedDiv) == strtoupper($selectedDivision);
            });
        }

        // Get divisions for dropdown primarily from the Email Map
        $divisions = collect(array_values($emailToDivision))
            ->merge($fptks->map(function ($f) use ($emailToDivision) {
                $userEmail = $f->user->email ?? '';

                return $emailToDivision[$userEmail] ?? ($f->notes_decoded['division'] ?? ($f->division ?? null));
            }))
            ->unique()
            ->filter()
            ->sort()
            ->values();

        // Hitung jumlah per tab untuk badge
        $countProses = Fptk::proses()->count();
        $countSelesai = Fptk::selesai()->count();
        $countArsip = Fptk::arsip()->count();

        return view('admin.fptk.index', compact('fptks', 'tab', 'countProses', 'countSelesai', 'countArsip', 'divisions', 'selectedDivision', 'startDate', 'endDate'));
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
            'admin_signature' => ['required', 'string', function ($attribute, $value, $fail) {
                if (! preg_match('/^data:image\/(png|jpeg|webp|gif);base64,/', $value)) {
                    $fail('Tanda tangan tidak valid — format data URL gambar tidak dikenali.');

                    return;
                }

                $base64 = preg_replace('/^data:image\/(png|jpeg|webp|gif);base64,/', '', $value);
                $decoded = base64_decode($base64, true);

                if ($decoded === false) {
                    $fail('Tanda tangan tidak valid — data base64 corrupt.');

                    return;
                }

                $size = strlen($decoded);

                if ($size < 200) {
                    $fail('Tanda tangan tidak valid — ukuran terlalu kecil, kemungkinan tandatangan kosong.');

                    return;
                }

                if ($size > 512000) {
                    $fail('Tanda tangan terlalu besar — maksimal 500KB.');

                    return;
                }
            }],
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
            'fulfilled_count' => $fptk->qty, // set penuh saat manual complete
            'completed_at' => now(),
            'completed_by' => Auth::id(),
        ]);

        return redirect()->route('admin.fptk.index', ['tab' => 'selesai'])->with('status', 'FPTK berhasil ditandai selesai.');
    }

    public function updateFulfilled(Request $request, Fptk $fptk)
    {
        $request->validate([
            'fulfilled_count' => 'required|integer|min:0|max:'.$fptk->qty,
        ]);

        $fptk->update([
            'fulfilled_count' => $request->input('fulfilled_count'),
        ]);

        // Auto-complete jika sudah terpenuhi
        if ($fptk->isFulfilled() && ! $fptk->isCompleted()) {
            $fptk->update([
                'completed_at' => now(),
                'completed_by' => null, // otomatis
            ]);

            return redirect()->route('admin.fptk.index', ['tab' => 'selesai'])->with('status', 'FPTK otomatis ditandai selesai — kebutuhan terpenuhi.');
        }

        return redirect()->route('admin.fptk.show', $fptk)->with('status', 'Progress pemenuhan berhasil diperbarui.');
    }

    public function archive(Fptk $fptk)
    {
        if ($fptk->isArchived()) {
            return redirect()->route('admin.fptk.show', $fptk)->with('status', 'FPTK sudah diarsipkan sebelumnya.');
        }

        $fptk->archived_at = now();
        $fptk->save();

        return redirect()->route('admin.fptk.index', ['tab' => 'arsip'])->with('status', 'FPTK berhasil dipindahkan ke arsip.');
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
                'date' => isset($notes['signature_date']) ? date('d F Y', strtotime($notes['signature_date'])) : date('d F Y', strtotime($fptk->created_at)),
            ];
        }

        // Admin signature data (HR Manager)
        $adminSignatureData = null;
        if ($fptk->admin_signature && $fptk->admin) {
            $adminSignatureData = [
                'name' => $fptk->admin->name,
                'signature' => $fptk->admin_signature,
                'date' => $fptk->updated_at ? date('d F Y', strtotime($fptk->updated_at)) : date('d F Y'),
            ];
        }

        $pdf = Pdf::loadView('admin.fptk.pdf', compact('fptk', 'notes', 'signatureData', 'adminSignatureData'));
        $pdf->setPaper('a4', 'portrait');

        $filename = 'FPTK-'.$fptk->id.'-'.str_replace(' ', '-', $fptk->position).'.pdf';

        return $pdf->download($filename);
    }

    /**
     * Auto-complete FPTK yang fulfilled_count >= qty.
     */
    private function autoCompleteFulfilled(): void
    {
        Fptk::where('status', 'approved')
            ->whereNull('completed_at')
            ->where('qty', '>', 0)
            ->whereColumn('fulfilled_count', '>=', 'qty')
            ->update([
                'completed_at' => now(),
                'completed_by' => null,
            ]);
    }
}
