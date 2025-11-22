<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Is_guru
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->posisi !== 'Guru') {
            $request->attributes->set('Is_guru', false);
            // $is_guru = False;
            return redirect()->route('Dashborad');
        }
        $request->attributes->set('Is_guru', true);
        return $next($request);
    }
}
