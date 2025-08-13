<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PostFoto;
use App\Models\Comment;
use App\Models\LikeFoto;
use App\Models\ReportPost;
use App\Models\ReportComment;
use App\Models\ReportUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialApiController extends Controller
{
    /**
     * Like a post
     */
    public function likePost($postId)
    {
        $post = PostFoto::findOrFail($postId);
        $user = Auth::user();

        // Check if already liked
        if ($post->likeFotos()->where('user_id', $user->id)->exists()) {
            return response()->json([
                'message' => 'Post already liked'
            ], 422);
        }

        $like = new LikeFoto([
            'user_id' => $user->id,
            'post_foto_id' => $postId
        ]);
        $like->save();

        return response()->json([
            'message' => 'Post liked successfully',
            'likes_count' => $post->likeFotos()->count()
        ]);
    }

    /**
     * Unlike a post
     */
    public function unlikePost($postId)
    {
        $post = PostFoto::findOrFail($postId);
        $user = Auth::user();

        $like = $post->likeFotos()->where('user_id', $user->id)->first();

        if (!$like) {
            return response()->json([
                'message' => 'Post not liked'
            ], 422);
        }

        $like->delete();

        return response()->json([
            'message' => 'Post unliked successfully',
            'likes_count' => $post->likeFotos()->count()
        ]);
    }

    /**
     * Add comment to post
     */
    public function addComment(Request $request, $postId)
    {
        $validated = $request->validate([
            'isi_komentar' => 'required|string|max:1000',
        ]);

        $post = PostFoto::findOrFail($postId);

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'post_foto_id' => $postId,
            'isi_komentar' => $validated['isi_komentar'],
        ]);

        return response()->json([
            'message' => 'Comment added successfully',
            'comment' => $comment->load('user')
        ], 201);
    }

    /**
     * Update comment
     */
    public function updateComment(Request $request, $commentId)
    {
        $comment = Comment::findOrFail($commentId);

        // Check if user owns the comment
        if ($comment->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'You can only update your own comments'
            ], 403);
        }

        $validated = $request->validate([
            'isi_komentar' => 'required|string|max:1000',
        ]);

        $comment->update([
            'isi_komentar' => $validated['isi_komentar']
        ]);

        return response()->json([
            'message' => 'Comment updated successfully',
            'comment' => $comment->fresh()->load('user')
        ]);
    }

    /**
     * Delete comment
     */
    public function deleteComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $user = Auth::user();

        // Check if user owns the comment or is admin
        if ($comment->user_id !== $user->id && !$user->hasRole('admin')) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        $comment->delete();

        return response()->json([
            'message' => 'Comment deleted successfully'
        ]);
    }

    /**
     * Report a post
     */
    public function reportPost(Request $request, $postId)
    {
        $validated = $request->validate([
            'alasan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        $post = PostFoto::findOrFail($postId);

        // Check if user already reported this post
        $existingReport = ReportPost::where('user_id', auth()->id())
            ->where('post_foto_id', $postId)
            ->first();

        if ($existingReport) {
            return response()->json([
                'message' => 'Post already reported'
            ], 422);
        }

        $report = ReportPost::create([
            'user_id' => auth()->id(),
            'post_foto_id' => $postId,
            'alasan' => $validated['alasan'],
            'deskripsi' => $validated['deskripsi'] ?? null,
        ]);

        return response()->json([
            'message' => 'Post reported successfully',
            'report' => $report
        ], 201);
    }

    /**
     * Report a comment
     */
    public function reportComment(Request $request, $commentId)
    {
        $validated = $request->validate([
            'alasan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        $comment = Comment::findOrFail($commentId);

        $report = ReportComment::create([
            'user_id' => auth()->id(),
            'comment_id' => $commentId,
            'alasan' => $validated['alasan'],
            'deskripsi' => $validated['deskripsi'] ?? null,
        ]);

        return response()->json([
            'message' => 'Comment reported successfully',
            'report' => $report
        ], 201);
    }

    /**
     * Report a user
     */
    public function reportUser(Request $request, $userId)
    {
        if ($userId == auth()->id()) {
            return response()->json([
                'message' => 'You cannot report yourself'
            ], 422);
        }

        $validated = $request->validate([
            'alasan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        $reportedUser = User::findOrFail($userId);

        $report = ReportUser::create([
            'reporter_id' => auth()->id(),
            'reported_user_id' => $userId,
            'alasan' => $validated['alasan'],
            'deskripsi' => $validated['deskripsi'] ?? null,
        ]);

        return response()->json([
            'message' => 'User reported successfully',
            'report' => $report
        ], 201);
    }

    /**
     * Get post comments
     */
    public function getPostComments($postId)
    {
        $post = PostFoto::findOrFail($postId);
        $comments = $post->comments()
            ->with('user')
            ->where('is_banned', false)
            ->latest()
            ->paginate(10);

        return response()->json($comments);
    }

    /**
     * Get post likes
     */
    public function getPostLikes($postId)
    {
        $post = PostFoto::findOrFail($postId);
        $likes = $post->likeFotos()
            ->with('user')
            ->latest()
            ->paginate(10);

        return response()->json($likes);
    }

    /**
     * Check if user liked a post
     */
    public function checkLikeStatus($postId)
    {
        $post = PostFoto::findOrFail($postId);
        $user = Auth::user();

        $isLiked = $post->likeFotos()->where('user_id', $user->id)->exists();

        return response()->json([
            'is_liked' => $isLiked,
            'likes_count' => $post->likeFotos()->count()
        ]);
    }
}
