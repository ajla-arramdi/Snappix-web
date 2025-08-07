<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function users(Request $request)
    {
        $query = $request->get('q');
        
        if (strlen($query) < 2) {
            return response()->json(['users' => []]);
        }
        
        $users = User::where('is_banned', false)
                    ->where('id', '!=', auth()->id())
                    ->where(function($q) use ($query) {
                        $q->where('name', 'LIKE', "%{$query}%")
                          ->orWhere('email', 'LIKE', "%{$query}%");
                    })
                    ->withCount('postFotos')
                    ->limit(10)
                    ->get(['id', 'name', 'email', 'avatar']);
        
        return response()->json(['users' => $users]);
    }
}