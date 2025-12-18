<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeEducation;
use App\Models\EmployeeInvitation;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\TalentPool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class EmployeeRegisterController extends Controller
{
    /**
     * Menampilkan form untuk memasukkan kode undangan.
     */
    public function showCodeForm()
    {
        return view('auth.employee-register-code');
    }

    /**
     * Memverifikasi kode undangan.
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'invitation_code' => 'required|string|exists:employee_invitations,invitation_code',
        ]);

        $invitation = EmployeeInvitation::where('invitation_code', $request->invitation_code)->first();

        // Cek apakah kode sudah digunakan
        if ($invitation->used_at) {
            return back()->withErrors(['invitation_code' => 'Kode undangan ini sudah digunakan.']);
        }

        // Jika valid, arahkan ke form pendaftaran lengkap dengan membawa kode
        return redirect()->route('employee.register.form', ['code' => $invitation->invitation_code]);
    }

    /**
     * Menampilkan formulir pendaftaran lengkap.
     */
    public function showRegistrationForm($code)
    {
        $invitation = EmployeeInvitation::where('invitation_code', $code)->whereNull('used_at')->firstOrFail();
        return view('auth.employee-register-form', compact('invitation'));
    }

    /**
     * Menyimpan data pendaftaran karyawan baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'invitation_code' => 'required|string|exists:employee_invitations,invitation_code',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number' => 'required|string|max:20',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'current_address' => 'required|string',
            'id_card_address' => 'required|string',
            'gender' => 'required|string',
            'religion' => 'required|string',
            'marital_status' => 'required|string',
            'ptkp_status' => 'required|string',
            'id_card_number' => 'required|string|max:255|unique:employees,id_card_number',
            'father_name' => 'required|string',
            'mother_name' => 'required|string',
            'department' => 'required|string',
            'location' => 'required|string',
            'position' => 'required|string',
            'join_date' => 'required|date',
            'employment_status' => 'required|string',
            'bank_name' => 'required|string',
            'account_number' => 'required|string',
            'account_holder_name' => 'required|string',
            'emergency_contact_name' => 'required|string',
            'emergency_contact_phone' => 'required|string',
            'emergency_contact_relation' => 'required|string',
        ]);

        $invitation = EmployeeInvitation::where('invitation_code', $request->invitation_code)->whereNull('used_at')->firstOrFail();

        DB::beginTransaction();
        try {
            // 1. Buat user baru dengan role 'employee'
            $user = User::create([
                'name' => $invitation->full_name,
                'email' => $invitation->email,
                'password' => Hash::make($request->password),
                'role' => 'employee',
            ]);

            // 2. Buat profil user
            UserProfile::create([
                'user_id' => $user->id,
                'phone_number' => $request->phone_number,
            ]);

            // 2.1. Tambahkan user ke Talent Pool untuk rekrutmen mendatang
            TalentPool::create([
                'user_id' => $user->id,
                'status' => 'available',
                'job_preferences' => $request->job_interest ?? $request->position ?? null,
            ]);

            // 3. Buat data karyawan lengkap
            Employee::create($request->except(['_token', 'password', 'password_confirmation', 'education']) + ['user_id' => $user->id]);

            // 4. Simpan riwayat pendidikan
            if ($request->has('education')) {
                foreach ($request->education as $edu) {
                    if (!empty($edu['institution_name']) && !empty($edu['graduation_year'])) {
                        EmployeeEducation::create([
                            'user_id' => $user->id,
                            'level' => $edu['level'],
                            'institution_name' => $edu['institution_name'],
                            'major' => $edu['major'],
                            'graduation_year' => $edu['graduation_year'],
                        ]);
                    }
                }
            }

            // 5. Tandai undangan sebagai sudah digunakan
            $invitation->used_at = now();
            $invitation->save();

            DB::commit();

            Auth::login($user);

            return redirect('/dashboard');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
