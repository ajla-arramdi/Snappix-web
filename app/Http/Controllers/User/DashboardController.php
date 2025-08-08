<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PostFoto;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $allPosts = PostFoto::all();
        
        $posts = PostFoto::where('is_banned', false)->whereHas('user', function($query) {
                    $query->where('is_banned', false);
                })->with(['user', 'komentarFotos' => function($query) {
                    $query->where('is_banned', false)->with('user');
                }, 'likeFotos.user'])
                ->latest()
                ->paginate(12);

        return view('user.dashboard', compact('posts'));
    }
}






