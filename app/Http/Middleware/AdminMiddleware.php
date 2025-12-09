<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in
        if (!session()->has('user')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Check if user is admin
        if (session('user.role') !== 'admin') {
            return redirect()->route('home')->with('error', 'Akses ditolak. Anda bukan admin.');
        }

        return $next($request);
    }
}
