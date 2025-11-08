<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Admin\Identitas;
use Illuminate\Support\Facades\Auth;

class CekIdentitasSekolah
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
        $identitasSekolah = cache()->remember('identitas_sekolah', 3600, function () {
            return \App\Models\Admin\Identitas::first();
        });

        if (!$identitasSekolah) {
            return redirect()->route('registrasi-sekolah.index');
        }

        return $next($request);
    }
}
