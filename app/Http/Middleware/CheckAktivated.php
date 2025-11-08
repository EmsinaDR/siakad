<?php

namespace App\Http\Middleware;

use App\Models\User as ModelsUser;
use Closure;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAktivated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->aktiv !== 'Y') {
            return redirect()->route('notaktiv');
        }
        //  elseif ($user->status == 'mahasiswa') {
        //     return redirect()->route('inactive');
        // }
        // }
        // if (Auth::user()->aktiv !== 'N') {
        //     return redirect('home')->with('error', 'You must be 18 years or older.');
        // }

        return $next($request);
    }
}
