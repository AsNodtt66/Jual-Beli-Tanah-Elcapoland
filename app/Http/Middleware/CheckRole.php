<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Periksa apakah pengguna sudah login
        if ($request->user()) {
            // Pastikan role pengguna sesuai dengan yang diizinkan
            if (!in_array($request->user()->role, $roles)) {
                abort(403, 'Unauthorized action.');
            }
        } else {
            // Jika pengguna belum login, arahkan ke halaman login
            return redirect()->route('login')->withErrors(['message' => 'Please login first.']);
        }

        return $next($request);
    }
}