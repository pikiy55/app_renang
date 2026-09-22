<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PerkumpulanOnly
{
    /**
     * Handle an incoming request.
     * Hanya mengizinkan user dengan role 'perkumpulan' yang aktif.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check() || ! auth()->user()->isPerkumpulan()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk Perkumpulan/Klub.');
        }

        if (! auth()->user()->is_active) {
            abort(403, 'Akun Anda telah dinonaktifkan. Hubungi Admin.');
        }

        return $next($request);
    }
}
