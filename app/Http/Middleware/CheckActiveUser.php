<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckActiveUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah pengguna login dan aktif
        if (Auth::check() && !Auth::user()->aktiv) {
            // Redirect ke halaman tertentu jika pengguna tidak aktif
            return redirect()->route('inactive');
        }

        return $next($request);
    }
}
