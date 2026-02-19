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
                return redirect()->intended('dashboard');
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'avatar' => $user->avatar,
                    'password' => Hash::make(Str::random(16)), // Better than dummy password
                    'role' => 'karyawan', // Default role for social login
                ]);

                Auth::login($newUser);
                return redirect()->intended('dashboard');
            }
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal masuk dengan Google: ' . $e->getMessage());
        }
    }
}
