<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PostFoto;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $recentPosts = PostFoto::with(['user', 'likeFotos', 'komentarFotos'])
                              ->where('is_banned', false)
                              ->whereHas('user', function($query) {
                                  $query->where('is_banned', false);
                              })
                              ->latest()
                              ->take(20)
                              ->get();
        
        return view('user.dashboard', compact('recentPosts'));
    }
}




