<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Ban a comment.
     */
    public function ban(Request $request, Comment $comment)
    {
        $comment->update([
            'is_banned' => true,
            'banned_at' => now(),
            'banned_by' => auth()->id(),
            'ban_reason' => $request->ban_reason ?? 'Tidak ada alasan spesifik'
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil diban.');
    }

    /**
     * Unban a comment.
     */
    public function unban(Comment $comment)
    {
        $comment->update([
            'is_banned' => false,
            'banned_at' => null,
            'banned_by' => null,
            'ban_reason' => null
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil di-unban.');
    }

    /**
     * Delete a comment permanently.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->back()->with('success', 'Komentar berhasil dihapus.');
    }
}
