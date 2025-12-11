<?php
// App\Http\Middleware\CheckUserRole.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Cek apakah pengguna sudah login DAN memiliki peran yang sesuai
        if (! $request->user() || $request->user()->role !== $role) {
            // Jika tidak sesuai, tolak akses
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}