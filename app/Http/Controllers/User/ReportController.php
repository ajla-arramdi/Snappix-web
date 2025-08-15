<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Models\PostFoto;
use App\Models\User;
use App\Models\Comment;
use App\Models\ReportPost;
use App\Models\ReportUser;
use App\Models\ReportComment;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // Report Post
    public function reportPost(Request $request, PostFoto $postFoto)
    {
        $request->validate([
            'alasan' => 'required|string',
            'deskripsi' => 'nullable|string|max:500'
        ]);

        $existingReport = ReportPost::where('user_id', auth()->id())
            ->where('post_foto_id', $postFoto->id)
            ->first();

        if ($existingReport) {
            return response()->json(['success' => false, 'message' => 'Sudah melaporkan postingan ini sebelumnya']);
        }

        ReportPost::create([
            'user_id' => auth()->id(),
            'post_foto_id' => $postFoto->id,
            'alasan' => $request->alasan,
            'deskripsi' => $request->deskripsi,
            'status' => 'pending'
        ]);

        return response()->json(['success' => true, 'message' => 'Laporan berhasil dikirim']);
    }

    // Report User
    public function reportUser(Request $request, User $user)
    {
        $request->validate([
            'alasan' => 'required|string',
            'deskripsi' => 'nullable|string|max:500'
        ]);

        if ($user->id === auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Tidak bisa melaporkan diri sendiri']);
        }

        $existingReport = ReportUser::where('reporter_id', auth()->id())
            ->where('reported_user_id', $user->id)
            ->first();

        if ($existingReport) {
            return response()->json(['success' => false, 'message' => 'Sudah melaporkan user ini sebelumnya']);
        }

        ReportUser::create([
            'reporter_id' => auth()->id(),
            'reported_user_id' => $user->id,
            'alasan' => $request->alasan,
            'deskripsi' => $request->deskripsi,
            'status' => 'pending'
        ]);

        return response()->json(['success' => true, 'message' => 'Laporan berhasil dikirim']);
    }

    // Report Comment
    public function reportComment(Request $request, Comment $comment)
    {
        $request->validate([
            'alasan' => 'required|string',
            'deskripsi' => 'nullable|string|max:500'
        ]);

        $existingReport = ReportComment::where('user_id', auth()->id())
            ->where('comment_id', $comment->id)
            ->first();

        if ($existingReport) {
            return response()->json(['success' => false, 'message' => 'Sudah melaporkan komentar ini sebelumnya']);
        }

        ReportComment::create([
            'user_id' => auth()->id(),
            'comment_id' => $comment->id,
            'alasan' => $request->alasan,
            'deskripsi' => $request->deskripsi,
            'status' => 'pending'
        ]);

        return response()->json(['success' => true, 'message' => 'Laporan berhasil dikirim']);
    }
}
