<?php

namespace App\Http\Controllers;

use App\Models\PasswordResetRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasswordResetRequestController extends Controller
{
    /** Store a password reset request for admin review */
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => ['required','email','max:255'],
            'reason' => ['nullable','string','max:1000'],
        ]);

        $user = User::where('email', $data['email'])->first();

        $pr = PasswordResetRequest::create([
            'email' => $data['email'],
            'user_id' => $user?->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'reason' => $data['reason'] ?? null,
            'status' => 'pending',
        ]);

        // Optional: notify admins via mail/notification (not implemented here)

        return back()->with('status', 'Permintaan Anda telah dikirim. Admin akan meninjau dalam 24 jam kerja.');
    }
}
