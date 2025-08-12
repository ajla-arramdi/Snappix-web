<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    // Api register
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|string|email',
            'password' => 'required'
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('user');

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Register berhasil',
            'data' => [
                'user'       => $user,
                'token'      => $token,
                'token_type' => 'Bearer'
            ]
        ], 201);
    }

    // API Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah'
            ], 401);
        }

        // Buat token baru
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer'
            ]
        ]);
    }

    // API Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ]);
    }

    // Get User Profile
    public function profile(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->user()
        ]);
    }
}
