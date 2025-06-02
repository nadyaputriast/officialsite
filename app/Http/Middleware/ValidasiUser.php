<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidasiUser
{
    public function handle(Request $request, Closure $next): Response
    {
        // Admin tetap bisa akses dashboard
        if (auth()->check() && auth()->user()->hasRole('admin')) {
            return $next($request);
        }

        // Jika user belum divalidasi, redirect ke halaman tunggu
        if (auth()->check() && !auth()->user()->status_validasi) {
            return redirect()->route('user.waiting');
        }

        return $next($request);
    }
}