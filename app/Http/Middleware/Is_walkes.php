<?php

namespace App\Http\Middleware;

use App\Models\Admin\Ekelas;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Is_walkes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $cekwalkes = Ekelas::where('detailguru_id', Auth::user()->detailguru_id)->first();
        if (Auth::user()->posisi !== 'Guru') {
            $request->attributes->set('Is_walkes', false);
            // $is_guru = False;
            return redirect()->route('Dashborad');
        }
        $request->attributes->set('Is_walkes', true);
        return $next($request);
    }
}
