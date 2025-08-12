<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\ReportComment;
use Illuminate\Http\Request;

class ReportCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Comment $comment)
    {
        $request->validate([
            'alasan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        if (ReportComment::whereUserId(auth()->id())->whereCommentId($comment->id)->exists()) {
            return back()->with('error', 'Anda sudah melaporkan komentar ini.');
        }

        ReportComment::create([
            'user_id' => auth()->id(),
            'comment_id' => $comment->id,
            'alasan' => $request->alasan,
            'deskripsi' => $request->deskripsi,
        ]);

        return back()->with('success', 'Laporan komentar berhasil dikirim.');
    }
}