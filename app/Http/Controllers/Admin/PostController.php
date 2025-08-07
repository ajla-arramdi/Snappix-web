<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostFoto;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = PostFoto::with(['user', 'komentarFotos', 'likeFotos'])
                         ->orderBy('created_at', 'desc')
                         ->paginate(10);
        
        return view('admin.posts', compact('posts'));
    }

    public function show($id)
    {
        $post = PostFoto::with(['user', 'komentarFotos.user', 'likeFotos.user'])
                        ->findOrFail($id);
        
        return view('admin.post-detail', compact('post'));
    }
}