<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdminDev
{
    public function handle($request, Closure $next)
    {
        // Pengecualian untuk route admindev
        // Ini midelwar Url
        // dd(Auth::user()->posisi);

        // Jika bukan AdminDev, redirect ke halaman lain (misalnya home)
        // Cek apakah user login dan route-nya menuju area khusus admindev
        if ($request->is('admindev/*')) {
            if (!Auth::check() || Auth::user()->posisi !== 'Admindev') {
                return redirect('/'); // Atau abort(403);
            }
        }

        return $next($request);
    }
}
