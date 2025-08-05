<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBanned
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->is_banned) {
            auth()->logout();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akun Anda telah dibanned. Silakan hubungi admin.'
                ], 403);
            }
            
            return redirect()->route('login')->with('error', 'Akun Anda telah dibanned. Silakan hubungi admin.');
        }

        return $next($request);
    }
}