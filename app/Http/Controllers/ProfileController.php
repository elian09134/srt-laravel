<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use App\Models\WorkExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Menampilkan form untuk mengedit profil user.
     */
    public function edit()
    {
        $user = Auth::user();
        // Memuat semua relasi yang dibutuhkan untuk user reguler
        $user->load(['profile', 'workExperiences']);

        return view('profile.edit', compact('user'));
    }

    /**
     * Memperbarui profil user reguler di database.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nickname' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'about_me' => 'required|string',
            'education_level' => 'required|string',
            'institution' => 'required|string|max:255',
            'major' => 'required|string|max:255',
            'last_company' => 'nullable|string|max:255',
            'last_position' => 'nullable|string|max:255',
            'last_company_duration' => 'nullable|string|max:255',
            'skills' => 'nullable|string',
            'languages' => 'nullable|string',
            'job_interest' => 'nullable|string',
            'photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // 1. Handle upload foto jika ada
            $photoPath = $user->profile->photo_path;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('photos', 'public');
            }

            // 2. Update profil user
            $user->profile->update([
                'nickname' => $request->nickname,
                'phone_number' => $request->phone_number,
                'date_of_birth' => $request->date_of_birth,
                'about_me' => $request->about_me,
                'education_level' => $request->education_level,
                'institution' => $request->institution,
                'major' => $request->major,
                'last_company' => $request->last_company,
                'last_position' => $request->last_position,
                'last_company_duration' => $request->last_company_duration,
                'skills' => $request->skills,
                'languages' => $request->languages,
                'job_interest' => $request->job_interest,
                'photo_path' => $photoPath,
            ]);

            // 3. Update pengalaman kerja jika ada
            if ($request->has('experience')) {
                // Hapus pengalaman kerja lama
                $user->workExperiences()->delete();

                // Tambahkan pengalaman kerja baru
                foreach ($request->experience as $exp) {
                    if (!empty($exp['company'])) {
                        $user->workExperiences()->create([
                            'company_name' => $exp['company'],
                            'position' => $exp['position'] ?? null,
                            'start_date' => $exp['start_date'] ?? null,
                            'end_date' => $exp['end_date'] ?? null,
                            'duration_months' => $exp['duration_months'] ?? null,
                            'description' => $exp['description'] ?? null,
                        ]);
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

    /**
     * Menghapus akun user reguler.
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'password' => 'required|string',
        ]);

        // Verifikasi password
        if (!Auth::guard('web')->validate([
            'email' => $user->email,
            'password' => $request->password,
        ])) {
            return back()->withErrors(['password' => 'Password yang dimasukkan salah.']);
        }

        DB::beginTransaction();
        try {
            // Hapus semua data terkait user
            $user->profile()->delete();
            $user->workExperiences()->delete();
            $user->talentPool()->delete();
            $user->applications()->delete();

            // Hapus user
            $user->delete();

            DB::commit();

            // Logout user
            Auth::logout();

            return redirect('/')->with('success', 'Akun Anda telah berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus akun: ' . $e->getMessage()]);
        }
    }
}
