<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LikeFoto;
use App\Models\PostFoto;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(PostFoto $post)
    {
        $user = auth()->user();
        
        // Cek apakah sudah like
        $like = LikeFoto::where('user_id', $user->id)
                        ->where('post_foto_id', $post->id)
                        ->first();

        if ($like) {
            // Unlike
            $like->delete();
            $liked = false;
        } else {
            // Like
            LikeFoto::create([
                'user_id' => $user->id,
                'post_foto_id' => $post->id
            ]);
            $liked = true;
        }

        // Refresh count dari database
        $count = $post->likeFotos()->count();

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'count' => $count
        ]);
    }
}


