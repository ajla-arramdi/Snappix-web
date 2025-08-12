<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a new comment.
     */
    public function store(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'user_id'      => auth()->id(),
            'post_foto_id' => $postId,
            'content'      => $request->content,
        ]);

        // Jika request dari AJAX, balikin JSON
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil ditambahkan.',
                'comment' => [
                    'id'      => $comment->id,
                    'user'    => $comment->user->name,
                    'content' => $comment->content,
                    'time'    => $comment->created_at->diffForHumans(),
                ],
            ]);
        }

        // Jika bukan AJAX, tetap redirect
        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    /**
     * Update an existing comment.
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->update([
            'content' => $request->content,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil diubah.',
                'content' => $comment->content,
            ]);
        }

        return redirect()->back()->with('success', 'Komentar berhasil diubah.');
    }

    /**
     * Delete a comment.
     */
    public function destroy(Request $request, Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil dihapus.',
            ]);
        }

        return redirect()->back()->with('success', 'Komentar berhasil dihapus.');
    }
}
