<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PostFoto;
use Illuminate\Http\Request;

class ExploreController extends Controller
{
    public function index()
    {
        $posts = PostFoto::with(['user', 'likeFotos', 'komentarFotos.user'])
                         ->where('is_banned', false)
                         ->whereHas('user', function($query) {
                             $query->where('is_banned', false);
                         })
                         ->latest()
                         ->paginate(12);
        
        return view('explore', compact('posts'));
    }
}

