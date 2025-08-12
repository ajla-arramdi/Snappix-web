<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\PostFoto;
use App\Models\ReportComment;
use App\Models\ReportPost;
use App\Models\ReportUser;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function reportPost(Request $request, PostFoto $postFoto)
    {
        $request->validate([
            'alasan' => 'required|string',
            'deskripsi' => 'nullable|string|max:500'
        ]);

        // Cek apakah user sudah pernah report post ini
        $existingReport = ReportPost::where('user_id', auth()->id())
            ->where('post_foto_id', $postFoto->id)
            ->first();

        if ($existingReport) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melaporkan postingan ini sebelumnya'
            ]);
        }

        ReportPost::create([
            'user_id' => auth()->id(),
            'post_foto_id' => $postFoto->id,
            'alasan' => $request->alasan,
            'deskripsi' => $request->deskripsi
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil dikirim'
        ]);
    }

    public function reportComment(Request $request, Comment $comment)
    {
        $request->validate([
            'alasan' => 'required|string',
            'deskripsi' => 'nullable|string|max:500'
        ]);

        // Cek apakah user sudah pernah report comment ini
        $existingReport = ReportComment::where('user_id', auth()->id())
            ->where('comment_id', $comment->id)
            ->first();

        if ($existingReport) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melaporkan komentar ini sebelumnya'
            ]);
        }

        ReportComment::create([
            'user_id' => auth()->id(),
            'comment_id' => $comment->id,
            'alasan' => $request->alasan,
            'deskripsi' => $request->deskripsi
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil dikirim'
        ]);
    }

    public function reportUser(Request $request, User $user)
    {
        $request->validate([
            'alasan' => 'required|string',
            'deskripsi' => 'nullable|string|max:500'
        ]);

        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat melaporkan diri sendiri'
            ]);
        }

        // Cek apakah user sudah pernah report user ini
        $existingReport = ReportUser::where('reporter_id', auth()->id())
            ->where('reported_user_id', $user->id)
            ->first();

        if ($existingReport) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melaporkan user ini sebelumnya'
            ]);
        }

        ReportUser::create([
            'reporter_id' => auth()->id(),
            'reported_user_id' => $user->id,
            'alasan' => $request->alasan,
            'deskripsi' => $request->deskripsi
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil dikirim'
        ]);
    }

    public function index()
    {
        $reportPosts = ReportPost::with(['user', 'postFoto.user', 'admin'])
            ->orderBy('created_at', 'desc')->paginate(10);

        $reportComments = ReportComment::with(['user', 'comment.user', 'admin'])
            ->orderBy('created_at', 'desc')->paginate(10);

        $reportUsers = ReportUser::with(['reporter', 'reportedUser', 'admin'])
            ->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.reports', compact('reportPosts', 'reportComments', 'reportUsers'));
    }

    public function approveReport(Request $request, $type, $id)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:500'
        ]);

        $model = $this->getReportModel($type);
        $report = $model::findOrFail($id);

        $report->update([
            'status' => 'approved',
            'admin_id' => auth()->id(),
            'admin_notes' => $request->admin_notes,
            'reviewed_at' => now()
        ]);

        return back()->with('success', 'Laporan berhasil disetujui');
    }

    public function rejectReport(Request $request, $type, $id)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:500'
        ]);

        $model = $this->getReportModel($type);
        $report = $model::findOrFail($id);

        $report->update([
            'status' => 'rejected',
            'admin_id' => auth()->id(),
            'admin_notes' => $request->admin_notes,
            'reviewed_at' => now()
        ]);

        return back()->with('success', 'Laporan berhasil ditolak');
    }

    private function getReportModel($type)
    {
        return match ($type) {
            'post' => ReportPost::class,
            'comment' => ReportComment::class,
            'user' => ReportUser::class,
            default => throw new \InvalidArgumentException('Invalid report type')
        };
    }

    public function getReports()
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
        
        return response()->json([
            'reportPosts' => $reportPosts,
            'reportComments' => $reportComments,
            'reportUsers' => $reportUsers
        ]);
    }
}
