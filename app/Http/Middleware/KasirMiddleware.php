<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class KasirMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
public function handle(Request $request, Closure $next): Response
{
    // Memeriksa apakah pengguna sudah login
    if (Auth::check()) {
        // Memeriksa apakah pengguna memiliki peran 'kasir'
        if (Auth::user()->role == 'kasir') {
            // Jika ya, lanjutkan ke request berikutnya
            return $next($request);
        } else {
            // Jika bukan kasir, simpan URL yang diakses untuk redirect setelah login
            session()->put('url.intended', url()->current());

            // Menampilkan pesan error kepada pengguna
            session()->flash('error', 'Anda tidak memiliki akses ke halaman ini!');

            // Redirect pengguna kembali ke halaman sebelumnya
            return redirect()->back();
        }
    }

    // Jika pengguna belum login, redirect kembali ke halaman sebelumnya
    return redirect()->back();
}
}
