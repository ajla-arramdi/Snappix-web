<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PostFoto;
use App\Models\KomentarFoto;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification as NotificationsNotification;

class CommentController extends Controller
{
    public function store(Request $request, PostFoto $post)
    {
        try {
            // Validasi
            $request->validate([
                'isi_komentar' => 'required|string|max:500'
            ]);

            $comment = KomentarFoto::create([
                'user_id' => auth()->id(),
                'post_foto_id' => $post->id,
                'isi_komentar' => $request->isi_komentar
            ]);

            return response()->json([
                'success' => true,
                'comment' => [
                    'id' => $comment->id,
                    'isi_komentar' => $comment->isi_komentar,
                    'user_name' => auth()->user()->name,
                    'created_at' => 'just now',
                    'can_delete' => true
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            \Log::error('Comment creation failed', [
                'error' => $e->getMessage(),
                'post_id' => $post->id,
                'user_id' => auth()->id()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create comment'
            ], 500);
        }
    }

    public function destroy(KomentarFoto $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Hapus notifikasi comment juga
        // Notification::where('komentar_foto_id', $comment->id)->delete();

        $comment->delete();
        return response()->json(['success' => true]);
    }
}





