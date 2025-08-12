<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\User;
use App\Models\PostFoto;
use App\Models\ReportPost;
use App\Models\ReportComment;
use App\Models\ReportUser;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalAdmins = User::role('admin')->count();
        $totalBannedUsers = User::where('is_banned', true)->count();
        $totalPosts = \App\Models\PostFoto::count();
        $totalComments = \App\Models\Comment::count();
        $totalReports = \App\Models\ReportPost::count();
        
        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalAdmins', 
            'totalBannedUsers',
            'totalPosts',
            'totalComments',
            'totalReports'
        ));
    }

    public function users()
    {
        $users = User::with('roles')->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function posts()
    {
        $posts = PostFoto::with(['user', 'comments', 'likeFotos'])
                         ->orderBy('created_at', 'desc')
                         ->paginate(10);
        
        return view('admin.posts', compact('posts'));
    }

    public function postDetail($id)
    {
        $post = PostFoto::with(['user', 'comments.user', 'likeFotos.user'])
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

    public function banComment(Comment $comment)
    {
        $comment->update([
            'is_banned' => true,
            'banned_at' => now(),
            'banned_by' => auth()->id(),
            'ban_reason' => 'Dibanned oleh admin'
        ]);

        return back()->with('success', 'Komentar berhasil dibanned');
    }

    public function unbanComment(Comment $comment)
    {
        $comment->update([
            'is_banned' => false,
            'banned_at' => null,
            'banned_by' => null,
            'ban_reason' => null
        ]);

        return back()->with('success', 'Komentar berhasil di-unban');
    }

    public function deleteComment(Comment $comment)
    {
        $comment->delete();
        return back()->with('success', 'Komentar berhasil dihapus');
    }

    public function reports()
    {
        $reportPosts = ReportPost::with(['user', 'postFoto.user', 'admin'])
                                ->orderBy('created_at', 'desc')
                                ->paginate(10);
        
        $reportComments = ReportComment::with(['user', 'comment.user', 'admin'])
                                     ->orderBy('created_at', 'desc')
                                     ->paginate(10);
        
        $reportUsers = ReportUser::with(['reporter', 'reportedUser', 'admin'])
                                ->orderBy('created_at', 'desc')
                                ->paginate(10);
        
        return view('admin.reports', compact('reportPosts', 'reportComments', 'reportUsers'));
    }

    public function reviewPostReport($id, $action)
    {
        $report = ReportPost::findOrFail($id);
        
        if (!in_array($action, ['approve', 'reject'])) {
            return back()->with('error', 'Aksi tidak valid.');
        }

        $report->update([
            'status' => $action === 'approve' ? 'approved' : 'rejected',
            'admin_id' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        // Jika approve, ban post
        if ($action === 'approve' && $report->postFoto) {
            $report->postFoto->update([
                'is_banned' => true,
                'banned_at' => now(),
                'banned_by' => auth()->id(),
                'ban_reason' => 'Dilaporkan & disetujui admin',
            ]);
        }

        return back()->with('success', 'Laporan post berhasil diproses.');
    }

    public function reviewCommentReport($id, $action)
    {
        $report = ReportComment::findOrFail($id);
        
        if (!in_array($action, ['approve', 'reject'])) {
            return back()->with('error', 'Aksi tidak valid.');
        }

        $report->update([
            'status' => $action === 'approve' ? 'approved' : 'rejected',
            'admin_id' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        // Jika approve, ban comment
        if ($action === 'approve' && $report->comment) {
            $report->comment->update([
                'is_banned' => true,
                'banned_at' => now(),
                'banned_by' => auth()->id(),
                'ban_reason' => 'Dilaporkan & disetujui admin',
            ]);
        }

        return back()->with('success', 'Laporan komentar berhasil diproses.');
    }

    public function reviewUserReport($id, $action)
    {
        $report = ReportUser::findOrFail($id);
        
        if (!in_array($action, ['approve', 'reject'])) {
            return back()->with('error', 'Aksi tidak valid.');
        }

        $report->update([
            'status' => $action === 'approve' ? 'approved' : 'rejected',
            'admin_id' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        // Jika approve, ban user
        if ($action === 'approve' && $report->reportedUser) {
            $report->reportedUser->update([
                'is_banned' => true,
                'banned_at' => now(),
                'banned_by' => auth()->id(),
                'ban_reason' => 'Dilaporkan & disetujui admin',
            ]);
        }

        return back()->with('success', 'Laporan user berhasil diproses.');
    }

    private function getReportModel($type)
    {
        return match($type) {
            'post' => \App\Models\ReportPost::class,
            'comment' => \App\Models\ReportComment::class,
            'user' => \App\Models\ReportUser::class,
            default => throw new \InvalidArgumentException('Invalid report type')
        };
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
















