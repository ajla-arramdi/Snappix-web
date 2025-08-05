<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PostFoto;
use App\Models\KomentarFoto;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function users()
    {
        $users = User::with('roles')->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function posts()
    {
        $posts = PostFoto::with(['user', 'komentarFotos', 'likeFotos'])
                         ->orderBy('created_at', 'desc')
                         ->paginate(10);
        
        return view('admin.posts', compact('posts'));
    }

    public function postDetail($id)
    {
        $post = PostFoto::with(['user', 'komentarFotos.user', 'likeFotos.user'])
                        ->findOrFail($id);
        
        return view('admin.post-detail', compact('post'));
    }

    public function banPost(PostFoto $post)
    {
        $post->update([
            'is_banned' => true,
            'banned_at' => now(),
            'banned_by' => auth()->id(),
            'ban_reason' => 'Dibanned oleh admin'
        ]);

        return back()->with('success', 'Postingan berhasil dibanned');
    }

    public function unbanPost(PostFoto $post)
    {
        $post->update([
            'is_banned' => false,
            'banned_at' => null,
            'banned_by' => null,
            'ban_reason' => null
        ]);

        return back()->with('success', 'Postingan berhasil di-unban');
    }

    public function deletePost(PostFoto $post)
    {
        $post->delete();
        return back()->with('success', 'Postingan berhasil dihapus');
    }

    public function banComment(KomentarFoto $comment)
    {
        $comment->update([
            'is_banned' => true,
            'banned_at' => now(),
            'banned_by' => auth()->id(),
            'ban_reason' => 'Dibanned oleh admin'
        ]);

        return back()->with('success', 'Komentar berhasil dibanned');
    }

    public function deleteComment(KomentarFoto $comment)
    {
        $comment->delete();
        return back()->with('success', 'Komentar berhasil dihapus');
    }

    public function reports()
    {
        // Untuk sementara return view kosong, nanti akan kita isi
        return view('admin.reports');
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

    public function deleteUser(User $user)
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






