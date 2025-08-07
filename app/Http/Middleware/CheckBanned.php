<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckBanned
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            if ($user->is_banned) {
                $banReason = $user->ban_reason ?? 'Akun Anda telah dibanned. Silakan hubungi admin.';
                
                // Force logout
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => $banReason,
                        'banned' => true
                    ], 403);
                }
                
                return redirect()->route('login')
                    ->with('error', $banReason)
                    ->with('banned', true);
            }
        }

        return $next($request);
    }
}

