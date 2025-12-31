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
            'phone' => ['required','string','max:50'],
            'reason' => ['nullable','string','max:1000'],
        ]);

        // try find user by phone stored in user profile
        $phone = preg_replace('/[^0-9+]/', '', $data['phone']);
        $user = User::whereHas('profile', function($q) use ($phone) {
            $q->where('phone_number', $phone)->orWhere('phone_number', ltrim($phone, '+'));
        })->first();

        $pr = PasswordResetRequest::create([
            'email' => $user?->email,
            'phone' => $data['phone'],
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
