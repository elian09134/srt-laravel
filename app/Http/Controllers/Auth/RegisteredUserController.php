<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\TalentPool;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\WorkExperience;
use App\Services\FileUploadService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request, FileUploadService $fileUploadService): RedirectResponse
    {
        // Memulai transaksi database untuk memastikan semua data aman
        DB::beginTransaction();

        try {
            // 2. Handle Upload File securely via FileUploadService into private storage
            $cvPath = $fileUploadService->storeApplicantDocument($request->file('cv'), 'cvs');
            $formalPhotoPath = $fileUploadService->storeApplicantDocument($request->file('formal_photo'), 'formal_photos');
            $ktpPath = $fileUploadService->storeApplicantDocument($request->file('ktp'), 'ktps');
            $kkPath = $fileUploadService->storeApplicantDocument($request->file('kk'), 'kks');

            $npwpPath = null;
            if ($request->hasFile('npwp')) {
                $npwpPath = $fileUploadService->storeApplicantDocument($request->file('npwp'), 'npwps');
            }

            $ijazahPath = $fileUploadService->storeApplicantDocument($request->file('ijazah'), 'ijazahs');

            $certificatePath = $request->hasFile('certificate')
                ? $fileUploadService->storeApplicantDocument($request->file('certificate'), 'certificates')
                : null;

            $photoPath = null;
            if ($request->hasFile('photo')) {
                try {
                    $photoPath = $fileUploadService->storeApplicantDocument($request->file('photo'), 'photos');
                } catch (\Exception $e) {
                    return back()->withErrors(['photo' => 'The photo failed to upload. Please try again.']);
                }
            }

            // 3. Buat User baru
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'referral_source' => $request->referral_source,
            ]);

            // 4. Buat Profil User
            UserProfile::create([
                'user_id' => $user->id,
                'nickname' => $request->nickname,
                'phone_number' => $request->phone_number,
                'date_of_birth' => $request->date_of_birth,
                'about_me' => $request->about_me,
                'education_level' => $request->education_level,
                'institution' => $request->institution,
                'major' => $request->major,
                'last_company' => $request->last_company ?? null,
                'last_position' => $request->last_position ?? null,
                'last_company_duration' => $request->last_company_duration ?? null,
                'currently_employed' => $request->boolean('currently_employed', false),
                'expected_salary' => $request->expected_salary,
                'skills' => $request->skills,
                'languages' => $request->input('languages'),
                'job_interest' => $request->job_interest,
                'cv_path' => $cvPath,
                'photo_path' => $photoPath,
                'formal_photo_path' => $formalPhotoPath,
                'ktp_path' => $ktpPath,
                'kk_path' => $kkPath,
                'npwp_path' => $npwpPath,
                'ijazah_path' => $ijazahPath,
                'certificate_path' => $certificatePath,
            ]);

            // 5. Tambahkan user ke Talent Pool untuk rekrutmen mendatang (kecuali admin)
            if ($user->role !== 'admin') {
                // Prioritas: last_position -> job_interest -> skills
                $jobPreferences = $request->last_position ?? $request->job_interest ?? $request->skills ?? null;

                TalentPool::create([
                    'user_id' => $user->id,
                    'status' => 'available',
                    'job_preferences' => $jobPreferences,
                ]);
            }

            // 6. Simpan Pengalaman Kerja
            if ($request->has('experience')) {
                foreach ($request->experience as $exp) {
                    if (! empty($exp['company'])) {
                        // Combine position and jobdesk into job_description
                        $parts = [];
                        if (! empty($exp['position'])) {
                            $parts[] = trim($exp['position']);
                        }
                        if (! empty($exp['jobdesk'])) {
                            $parts[] = trim($exp['jobdesk']);
                        }
                        $jobDescription = $parts ? implode(' — ', $parts) : null;

                        WorkExperience::create([
                            'user_id' => $user->id,
                            'company_name' => $exp['company'],
                            'duration' => $exp['duration'] ?? null,
                            'job_description' => $jobDescription,
                        ]);
                    }
                }
            }

            // Jika semua berhasil, commit transaksi
            DB::commit();

            event(new Registered($user));

            Auth::login($user);

            return redirect(route('dashboard', absolute: false));

        } catch (\Exception $e) {
            // Jika ada error, batalkan semua perubahan
            DB::rollBack();

            // (Opsional) Log error
            \Illuminate\Support\Facades\Log::error('Registration Error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return back()->with('error', 'Terjadi kesalahan saat pendaftaran: ' . $e->getMessage());
        }
    }
}
