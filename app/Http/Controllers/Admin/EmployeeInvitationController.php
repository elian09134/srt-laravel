<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use chillerlan\QRCode\QRCode; // <-- Impor library QR Code

class EmployeeInvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invitations = EmployeeInvitation::latest()->get();
        $qrcodes = [];

        // Buat QR code untuk setiap undangan
        foreach ($invitations as $invitation) {
            // URL ini akan menjadi isi dari QR code
            $url = route('employee.register.code', ['code' => $invitation->invitation_code]);
            $qrcodes[$invitation->id] = (new QRCode)->render($url);
        }

        return view('admin.invitations.index', compact('invitations', 'qrcodes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20|unique:employee_invitations,phone_number',
        ]);

        EmployeeInvitation::create([
            'full_name' => $request->full_name,
            'phone_number' => $request->phone_number,
            'invitation_code' => 'SRT-' . Str::upper(Str::random(8)),
        ]);

        return redirect()->route('admin.invitations.index')->with('success', 'Undangan berhasil dibuat.');
    }
}
