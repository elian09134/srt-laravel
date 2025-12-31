<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetRequest;
use App\Models\User;
use App\Mail\AdminGeneratedPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class PasswordRequestController extends Controller
{
    public function index()
    {
        $requests = PasswordResetRequest::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.password_requests.index', compact('requests'));
    }

    public function show(PasswordResetRequest $passwordRequest)
    {
        return view('admin.password_requests.show', ['request' => $passwordRequest]);
    }

    public function approve(Request $request, PasswordResetRequest $passwordRequest)
    {
        if ($passwordRequest->status !== 'pending') {
            return back()->with('error', 'Permintaan tidak dalam status pending.');
        }

        $temp = bin2hex(random_bytes(6)); // 12 chars

        $user = $passwordRequest->user;
        if (! $user) {
            // try to find by email and create minimal user? we'll abort
            return back()->with('error', 'User tidak ditemukan untuk email ini.');
        }

        $user->password = Hash::make($temp);
        $user->save();

        $passwordRequest->status = 'approved';
        $passwordRequest->admin_id = Auth::id();
        $passwordRequest->admin_note = $request->input('admin_note');
        $passwordRequest->temporary_password = $temp;
        $passwordRequest->processed_at = now();
        $passwordRequest->save();

        // send email to user with temporary password
        Mail::to($user->email)->send(new AdminGeneratedPassword($user, $temp));

        return redirect()->route('admin.password_requests.index')->with('status', 'Permintaan disetujui dan password sementara telah dikirim.');
    }

    public function reject(Request $request, PasswordResetRequest $passwordRequest)
    {
        if ($passwordRequest->status !== 'pending') {
            return back()->with('error', 'Permintaan tidak dalam status pending.');
        }

        $passwordRequest->status = 'rejected';
        $passwordRequest->admin_id = Auth::id();
        $passwordRequest->admin_note = $request->input('admin_note');
        $passwordRequest->processed_at = now();
        $passwordRequest->save();

        // optional: notify user about rejection (not implemented)

        return redirect()->route('admin.password_requests.index')->with('status', 'Permintaan ditolak.');
    }
}
