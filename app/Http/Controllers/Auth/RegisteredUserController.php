<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\WorkExperience;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

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
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi semua input dari form
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nickname' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:20'],
            'date_of_birth' => ['required', 'date'],
            'about_me' => ['required', 'string'],
            'education_level' => ['required', 'string'],
            'institution' => ['required', 'string', 'max:255'],
            'major' => ['required', 'string', 'max:255'],
            'cv' => ['required', 'file', 'mimes:pdf', 'max:2048'], // maks 2MB
            'photo' => ['nullable', 'file', 'mimes:jpg,png', 'max:1024'], // maks 1MB
        ]);

        // Memulai transaksi database untuk memastikan semua data aman
        DB::beginTransaction();

        try {
            // 2. Handle Upload File
            $cvPath = $request->file('cv')->store('cvs', 'public');
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('photos', 'public');
            }

            // 3. Buat User baru
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
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
                'skills' => $request->skills,
                'languages' => $request->languages,
                'job_interest' => $request->job_interest,
                'cv_path' => $cvPath,
                'photo_path' => $photoPath,
            ]);

            // 5. Simpan Pengalaman Kerja
            if ($request->has('experience')) {
                foreach ($request->experience as $exp) {
                    if (!empty($exp['company'])) {
                        WorkExperience::create([
                            'user_id' => $user->id,
                            'company_name' => $exp['company'],
                            'duration' => $exp['duration'],
                            'job_description' => $exp['jobdesk'],
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
            // Log::error($e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat pendaftaran. Silakan coba lagi.');
        }
    }
}
