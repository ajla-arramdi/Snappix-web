<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReportPost;
use App\Models\ReportUser;
use App\Models\ReportComment;
use App\Models\PostFoto;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // Menampilkan semua laporan
    public function index()
    {
        $reportPosts = ReportPost::with(['user', 'postFoto.user'])->orderBy('created_at', 'desc')->paginate(10);
        $reportComments = ReportComment::with(['user', 'comment.user'])->orderBy('created_at', 'desc')->paginate(10);
        $reportUsers = ReportUser::with(['reporter', 'reportedUser'])->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.reports', compact('reportPosts', 'reportComments', 'reportUsers'));
    }

    // Approve atau ban sesuai tipe
    public function handleReport(Request $request, $type, $id)
    {
        $model = $this->getReportModel($type);
        $report = $model::findOrFail($id);

        $report->update([
            'status' => 'approved',
            'admin_id' => auth()->id(),
            'admin_notes' => $request->admin_notes,
            'reviewed_at' => now()
        ]);

        // Jika report post/comment/user, bisa langsung banned
        switch ($type) {
            case 'post':
                $post = PostFoto::find($report->post_foto_id);
                if ($post) $post->update(['is_banned' => true]);
                break;
            case 'comment':
                $comment = Comment::find($report->comment_id);
                if ($comment) $comment->update(['is_banned' => true]);
                break;
            case 'user':
                $user = User::find($report->reported_user_id);
                if ($user) $user->update(['is_banned' => true]);
                break;
        }

        return back()->with('success', 'Laporan berhasil ditangani');
    }

    private function getReportModel($type)
    {
        return match ($type) {
            'post' => ReportPost::class,
            'comment' => ReportComment::class,
            'user' => ReportUser::class,
            default => throw new \InvalidArgumentException('Tipe laporan tidak valid')
        };
    }
}
