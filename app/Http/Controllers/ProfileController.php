<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileDestroyRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Services\FileUploadService;
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

        if ($user->role === 'partner') {
            return redirect()->route('m28.dashboard')->with('error', 'Halaman profil tidak tersedia untuk mitra.');
        }

        if (!$user->profile) {
            $user->profile()->create();
            $user->load('profile');
        }

        // Memuat semua relasi yang dibutuhkan untuk user reguler
        $user->load(['profile', 'workExperiences']);

        return view('profile.edit', compact('user'));
    }

    /**
     * Memperbarui profil user reguler di database.
     */
    public function update(ProfileUpdateRequest $request, FileUploadService $fileUploadService)
    {
        $user = Auth::user();

        if ($user->role === 'partner') {
            return redirect()->route('m28.dashboard')->with('error', 'Halaman profil tidak tersedia untuk mitra.');
        }

        if (!$user->profile) {
            $user->profile()->create();
            $user->load('profile');
        }

        DB::beginTransaction();
        try {
            // Update User fields if provided
            if ($request->filled('name')) {
                $user->name = $request->name;
            }
            if ($request->filled('email')) {
                $user->email = $request->email;
            }

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            $user->save();

            // 1. Handle upload berkas/foto secara aman via FileUploadService ke private storage
            $photoPath = $user->profile->photo_path;
            if ($request->hasFile('photo')) {
                $fileUploadService->deleteFile($photoPath);
                $photoPath = $fileUploadService->storeApplicantDocument($request->file('photo'), 'photos');
            }

            $formalPhotoPath = $user->profile->formal_photo_path;
            if ($request->hasFile('formal_photo')) {
                $fileUploadService->deleteFile($formalPhotoPath);
                $formalPhotoPath = $fileUploadService->storeApplicantDocument($request->file('formal_photo'), 'formal_photos');
            }

            $ktpPath = $user->profile->ktp_path;
            if ($request->hasFile('ktp')) {
                $fileUploadService->deleteFile($ktpPath);
                $ktpPath = $fileUploadService->storeApplicantDocument($request->file('ktp'), 'ktps');
            }

            $kkPath = $user->profile->kk_path;
            if ($request->hasFile('kk')) {
                $fileUploadService->deleteFile($kkPath);
                $kkPath = $fileUploadService->storeApplicantDocument($request->file('kk'), 'kks');
            }

            $npwpPath = $user->profile->npwp_path;
            if ($request->hasFile('npwp')) {
                $fileUploadService->deleteFile($npwpPath);
                $npwpPath = $fileUploadService->storeApplicantDocument($request->file('npwp'), 'npwps');
            }

            $ijazahPath = $user->profile->ijazah_path;
            if ($request->hasFile('ijazah')) {
                $fileUploadService->deleteFile($ijazahPath);
                $ijazahPath = $fileUploadService->storeApplicantDocument($request->file('ijazah'), 'ijazahs');
            }

            $certificatePath = $user->profile->certificate_path;
            if ($request->hasFile('certificate')) {
                $fileUploadService->deleteFile($certificatePath);
                $certificatePath = $fileUploadService->storeApplicantDocument($request->file('certificate'), 'certificates');
            }

            $cvPath = $user->profile->cv_path;
            if ($request->hasFile('cv')) {
                $fileUploadService->deleteFile($cvPath);
                $cvPath = $fileUploadService->storeApplicantDocument($request->file('cv'), 'cvs');
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
                'languages' => $request->input('languages'),
                'job_interest' => $request->job_interest,
                'expected_salary' => $request->expected_salary,
                'photo_path' => $photoPath,
                'formal_photo_path' => $formalPhotoPath,
                'ktp_path' => $ktpPath,
                'kk_path' => $kkPath,
                'npwp_path' => $npwpPath,
                'ijazah_path' => $ijazahPath,
                'certificate_path' => $certificatePath,
                'cv_path' => $cvPath,
            ]);

            // 3. Update pengalaman kerja jika ada
            if ($request->has('experience')) {
                // Hapus pengalaman kerja lama
                $user->workExperiences()->delete();

                // Tambahkan pengalaman kerja baru
                foreach ($request->experience as $exp) {
                    if (! empty($exp['company'])) {
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

            return back()->withErrors(['error' => 'Terjadi kesalahan: '.$e->getMessage()]);
        }
    }

    /**
     * Menghapus akun user reguler.
     */
    public function destroy(ProfileDestroyRequest $request)
    {
        $user = Auth::user();

        if ($user->role === 'partner') {
            return redirect()->route('m28.dashboard')->with('error', 'Halaman profil tidak tersedia untuk mitra.');
        }

        // Verifikasi password
        if (! Auth::guard('web')->validate([
            'email' => $user->email,
            'password' => $request->password,
        ])) {
            return back()->withErrors(['password' => 'Password yang dimasukkan salah.'], 'userDeletion');
        }

        DB::beginTransaction();
        try {
            // Logout user before deleting to prevent remember_token re-saving
            Auth::logout();

            // Hapus semua data terkait user
            $user->profile()->delete();
            $user->workExperiences()->delete();
            $user->talentPool()->delete();
            $user->applications()->delete();

            // Hapus user
            $user->delete();

            DB::commit();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/')->with('success', 'Akun Anda telah berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus akun: '.$e->getMessage()]);
        }
    }
}
