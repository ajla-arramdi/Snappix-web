<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['postFotos', 'albums', 'roles']);
        return view('admin.user-detail', compact('user'));
    }

    public function ban(User $user)
    {
        $user->update([
            'is_banned' => true,
            'banned_at' => now(),
            'banned_by' => auth()->id(),
            'ban_reason' => 'Dibanned oleh admin'
        ]);

        // Force logout if user is currently logged in
        if (Auth::id() === $user->id) {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
        }

        return back()->with('success', 'User berhasil dibanned');
    }

    public function unban(User $user)
    {
        $user->update([
            'is_banned' => false,
            'banned_at' => null,
            'banned_by' => null,
            'ban_reason' => null
        ]);

        return back()->with('success', 'User berhasil di-unban');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus');
    }

    public function makeAdmin(User $user)
    {
        $user->removeRole('user');
        $user->assignRole('admin');
        
        return back()->with('success', 'User berhasil dijadikan admin');
    }

    public function removeAdmin(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus role admin sendiri');
        }

        $user->removeRole('admin');
        $user->assignRole('user');
        
        return back()->with('success', 'Role admin berhasil dihapus');
    }
}

