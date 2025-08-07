<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;

class ProfileController extends Controller
{
    // Profile user lain (public)
    public function show(User $user)
    {
        if ($user->is_banned) {
            abort(404);
        }
        
        $posts = $user->postFotos()
                     ->where('is_banned', false)
                     ->latest()
                     ->paginate(12);
        
        return view('user.profile-public', compact('user', 'posts'));
    }
    
    // Profile sendiri
    public function profile()
    {
        $user = auth()->user();
        return view('user.profile', compact('user'));
    }
}
