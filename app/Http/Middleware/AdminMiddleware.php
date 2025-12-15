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
        // Check if user is logged in & admin (pakai Auth Laravel)
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cek role hanya jika user sudah login
        if (auth()->user() && auth()->user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'Akses ditolak. Anda bukan admin.');
        }

        return $next($request);
    }
}
