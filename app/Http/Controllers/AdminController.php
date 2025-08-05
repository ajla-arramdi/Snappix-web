<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalAdmins = User::role('admin')->count();
        $totalBannedUsers = User::where('is_banned', true)->count();
        
        return view('admin.dashboard', compact('totalUsers', 'totalAdmins', 'totalBannedUsers'));
    }

    public function users()
    {
        $users = User::with('roles')->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function banUser(User $user)
    {
        $user->update([
            'is_banned' => true,
            'banned_at' => now(),
            'banned_by' => auth()->id(),
            'ban_reason' => 'Dibanned oleh admin'
        ]);

        return back()->with('success', 'User berhasil dibanned');
    }

    public function unbanUser(User $user)
    {
        $user->update([
            'is_banned' => false,
            'banned_at' => null,
            'banned_by' => null,
            'ban_reason' => null
        ]);

        return back()->with('success', 'User berhasil di-unban');
    }
}