<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            
            $finduser = User::where('google_id', $user->id)
                            ->orWhere('email', $user->email)
                            ->first();

            if($finduser){
                // Update google_id if it's not set but email matches
                if (!$finduser->google_id) {
                    $finduser->update([
                        'google_id' => $user->id,
                        'avatar' => $user->avatar,
                    ]);
                }
                
                Auth::login($finduser);
                
                // Redirect based on role
                if (in_array($finduser->role, ['admin', 'superadmin'])) {
                    return redirect()->intended(route('admin.dashboard'));
                }
                
                return redirect()->intended(route('home'));
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'avatar' => $user->avatar,
                    'password' => Hash::make(Str::random(16)),
                    'role' => 'karyawan',
                ]);

                Auth::login($newUser);
                return redirect()->intended(route('home'));
            }
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal masuk dengan Google: ' . $e->getMessage());
        }
    }
}
