<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user) {
            $role = $user->role->name; // Mengambil nama role

            // Menggunakan switch agar lebih rapi dan mudah dikembangkan
            switch ($role) {
    case 'admin':
        if ($request->routeIs('admin.*')) {
            return $next($request);
        }
        return redirect()->route('admin.dashboard');

    case 'dosen':
        if ($request->routeIs('dosen.*')) {
            return $next($request);
        }
        return redirect()->route('dosen.dashboard');

    case 'mahasiswa':
        if ($request->routeIs('mahasiswa.*')) {
            return $next($request);
        }
        // Pastikan nama route ini benar (semua huruf kecil)
        return redirect()->route('mahasiswa.dashboard');
    
    default:
        return $next($request);
}
        }

        // Jika tidak ada user yang login, lanjutkan ke tujuan awal (biasanya halaman login)
        return $next($request);
    }
}