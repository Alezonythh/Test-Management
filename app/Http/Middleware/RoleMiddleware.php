<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
      public function handle(Request $request, Closure $next, $role = null): Response
    {
        // Kalau route khusus admin
        if ($role === 'admin') {
            if (Auth::check() && Auth::user()->role === 'admin') {
                return $next($request);
            }
            abort(403, 'Hanya admin yang bisa mengakses.');
        }

        // Semua user login lain (guest) bisa akses route umum
        if (Auth::check()) {
            return $next($request);
        }

        // Kalau belum login
        abort(403, 'Hayo Mau Ngapain?');
    }
}
