<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Cari user berdasarkan email
        $user = User::where('email', $googleUser->getEmail())->first();

        // Jika belum ada, buat user baru
        if (!$user) {
            $user = User::create([
                'name'     => $googleUser->getName(),
                'email'    => $googleUser->getEmail(),
                'password' => bcrypt('password'), // bisa random
                'google_id'=> $googleUser->getId(),
            ]);
        }

        // Login user
        Auth::login($user);

        return redirect('/home'); // arahkan ke dashboard
    }
}
