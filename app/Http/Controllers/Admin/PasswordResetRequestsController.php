<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use App\Mail\AdminGeneratedPasswordMail;

class PasswordResetRequestsController extends Controller
{
    public function index()
    {
        $requests = PasswordResetRequest::orderBy('created_at','desc')->paginate(20);
        return view('admin.password_requests.index', compact('requests'));
    }

    public function show(PasswordResetRequest $passwordRequest)
    {
        return view('admin.password_requests.show', ['request' => $passwordRequest]);
    }

    public function approve(Request $request, PasswordResetRequest $passwordRequest)
    {
        if ($passwordRequest->status !== 'pending') {
            return back()->withErrors(['already' => 'Permintaan sudah diproses.']);
        }

        $user = User::where('email', $passwordRequest->email)->first();
        if (! $user) {
            return back()->withErrors(['missing' => 'User dengan email ini tidak ditemukan.']);
        }

        // generate temporary password
        $temp = bin2hex(random_bytes(6)); // 12 chars

        $user->password = Hash::make($temp);
        // optional: add must_change_password flag if exists
        if (Schema::hasColumn('users', 'must_change_password')) {
            $user->must_change_password = true;
        }
        $user->save();

        $passwordRequest->status = 'approved';
        $passwordRequest->admin_id = Auth::id();
        $passwordRequest->processed_at = now();
        $passwordRequest->save();

        // send email to user with temp password
        Mail::to($user->email)->send(new AdminGeneratedPasswordMail($user, $temp));

        return redirect()->route('admin.password_requests.index')->with('status', 'Permintaan disetujui dan password dikirim.');
    }

    public function reject(Request $request, PasswordResetRequest $passwordRequest)
    {
        $passwordRequest->status = 'rejected';
        $passwordRequest->admin_id = Auth::id();
        $passwordRequest->admin_note = $request->input('admin_note');
        $passwordRequest->processed_at = now();
        $passwordRequest->save();

        // optional: notify user about rejection

        return redirect()->route('admin.password_requests.index')->with('status', 'Permintaan ditolak.');
    }
}
