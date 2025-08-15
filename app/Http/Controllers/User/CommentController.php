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
            'isi_komentar' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'user_id'      => auth()->id(),
            'post_foto_id' => $postId,
            'isi_komentar' => $request->isi_komentar,
        ]);

        // Load the user relationship for the response
        $comment->load('user');

        // Jika request dari AJAX, balikin JSON
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil ditambahkan.',
                'comment' => [
                    'id'      => $comment->id,
                    'user'    => $comment->user->name,
                    'isi_komentar' => $comment->isi_komentar,
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
        try {
            $this->authorize('update', $comment);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki izin untuk mengubah komentar ini.',
                ], 403);
            }
            
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengubah komentar ini.');
        }

        $request->validate([
            'isi_komentar' => 'required|string|max:1000',
        ]);

        $comment->update([
            'isi_komentar' => $request->isi_komentar,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil diubah.',
                'isi_komentar' => $comment->isi_komentar,
            ]);
        }

        return redirect()->back()->with('success', 'Komentar berhasil diubah.');
    }

    /**
     * Delete a comment.
     */
    public function destroy(Request $request, Comment $comment)
    {
        try {
            $this->authorize('delete', $comment);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki izin untuk menghapus komentar ini.',
                ], 403);
            }
            
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus komentar ini.');
        }

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
