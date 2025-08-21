<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeEducation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Menampilkan form untuk mengedit profil karyawan.
     */
    public function edit()
    {
        $user = Auth::user();
        // Memuat semua relasi yang dibutuhkan
        $user->load(['employee', 'educationHistory']);

        return view('profile.edit', compact('user'));
    }

    /**
     * Memperbarui profil karyawan di database.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $employee = $user->employee;

        $request->validate([
            'phone_number' => 'required|string|max:20',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'current_address' => 'required|string',
            'id_card_address' => 'required|string',
            'gender' => 'required|string',
            'religion' => 'required|string',
            'marital_status' => 'required|string',
            'ptkp_status' => 'required|string',
            'id_card_number' => 'required|string|max:255|unique:employees,id_card_number,' . $employee->id,
            'father_name' => 'required|string',
            'mother_name' => 'required|string',
            'bank_name' => 'required|string',
            'account_number' => 'required|string',
            'account_holder_name' => 'required|string',
            'emergency_contact_name' => 'required|string',
            'emergency_contact_phone' => 'required|string',
            'emergency_contact_relation' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            // 1. Update profil user
            $user->profile->update([
                'phone_number' => $request->phone_number,
            ]);

            // 2. Update data karyawan
            $employee->update($request->except(['_token', '_method', 'education']));

            // 3. Hapus riwayat pendidikan lama dan masukkan yang baru
            $user->educationHistory()->delete();
            if ($request->has('education')) {
                foreach ($request->education as $edu) {
                    if (!empty($edu['institution_name']) && !empty($edu['graduation_year'])) {
                        $user->educationHistory()->create($edu);
                    }
                }
            }

            DB::commit();

            return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
