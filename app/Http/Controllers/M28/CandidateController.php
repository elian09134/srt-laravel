<?php

namespace App\Http\Controllers\M28;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;

class CandidateController extends Controller
{
    public function index(Request $request)
    {
        $partner = Auth::user();
        $partnerName = $partner->name;

        $query = User::where('referral_source', $partnerName)
            ->with(['applications.job', 'applications.statusHistories', 'profile']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('status')) {
            $status = $request->status;
            $query->whereHas('applications', function ($q) use ($status) {
                $q->where('status', $status);
            });
        }

        $candidates = $query->latest()->paginate(15);

        $statuses = ['Baru', 'Seleksi Berkas', 'Interview HR', 'Interview User', 'Psikotes', 'Offering', 'Diterima', 'Ditolak'];

        return view('m28.candidates.index', [
            'candidates' => $candidates,
            'statuses' => $statuses,
        ]);
    }

    public function show(User $user)
    {
        $partner = Auth::user();
        $partnerName = $partner->name;

        if ($user->referral_source !== $partnerName) {
            abort(403);
        }

        $user->load(['profile', 'workExperiences', 'applications.job', 'applications.statusHistories']);

        return view('m28.candidates.show', [
            'candidate' => $user,
        ]);
    }

    public function export(Request $request)
    {
        $partner = Auth::user();
        $partnerName = $partner->name;

        $query = User::where('referral_source', $partnerName)
            ->with(['applications.job', 'applications.statusHistories', 'profile']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('status')) {
            $status = $request->status;
            $query->whereHas('applications', function ($q) use ($status) {
                $q->where('status', $status);
            });
        }

        $candidates = $query->latest()->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Kandidat M28');

        $headers = ['No', 'Nama', 'Email', 'No. HP', 'Sumber Info', 'Posisi Dilamar', 'Status', 'Tanggal Daftar', 'Update Terakhir'];
        $colLetters = range('A', 'I');

        foreach ($headers as $i => $header) {
            $cell = $colLetters[$i] . '1';
            $sheet->setCellValue($cell, $header);
        }

        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11, 'name' => 'Calibri'],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '7C3AED']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'FFFFFF']],
            ],
        ];
        $sheet->getStyle('A1:I1')->applyFromArray($headerStyle);

        $row = 2;
        foreach ($candidates as $i => $candidate) {
            $app = $candidate->applications->first();
            $lastHistory = $app?->statusHistories->last();
            $phone = optional($candidate->profile)->phone_number ?? '-';

            $sheet->setCellValue('A' . $row, $i + 1);
            $sheet->setCellValue('B' . $row, $candidate->name);
            $sheet->setCellValue('C' . $row, $candidate->email);
            $sheet->setCellValue('D' . $row, $phone);
            $sheet->setCellValue('E' . $row, $candidate->referral_source ?? '-');
            $sheet->setCellValue('F' . $row, $app?->job?->title ?? '-');
            $sheet->setCellValue('G' . $row, $app?->status ?? '-');
            $sheet->setCellValue('H' . $row, $candidate->created_at->format('d/m/Y'));
            $sheet->setCellValue('I' . $row, $lastHistory ? $lastHistory->created_at->format('d/m/Y H:i') : '-');

            $row++;
        }

        $lastRow = $row - 1;

        $bodyStyle = [
            'font' => ['size' => 10, 'name' => 'Calibri'],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'D1D5DB']],
            ],
        ];
        $sheet->getStyle('A2:I' . $lastRow)->applyFromArray($bodyStyle);

        $sheet->getStyle('A2:A' . $lastRow)
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('H2:I' . $lastRow)
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(18);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(28);
        $sheet->getColumnDimension('G')->setWidth(16);
        $sheet->getColumnDimension('H')->setWidth(16);
        $sheet->getColumnDimension('I')->setWidth(18);

        $sheet->getRowDimension('1')->setRowHeight(22);

        foreach (range(2, $lastRow) as $r) {
            $sheet->getRowDimension($r)->setRowHeight(20);
        }

        $sheet->setAutoFilter('A1:I' . $lastRow);

        $filename = 'kandidat-m28-' . now()->format('Y-m-d') . '.xlsx';

        ob_start();
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $content = ob_get_clean();

        return response($content, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'max-age=0',
        ]);
    }
}
