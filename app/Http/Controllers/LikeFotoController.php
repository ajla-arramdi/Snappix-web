<?php

namespace App\Http\Controllers;

use App\Models\PostFoto;
use Illuminate\Http\Request;

class LikeFotoController extends Controller
{
    public function toggle(PostFoto $postFoto)
    {
        $user = auth()->user();
        
        $like = $postFoto->likeFotos()->where('user_id', $user->id)->first();
        
        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            $postFoto->likeFotos()->create(['user_id' => $user->id]);
            $liked = true;
        }
        
        return response()->json([
            'liked' => $liked,
            'likes_count' => $postFoto->likeFotos()->count()
        ]);
    }
}