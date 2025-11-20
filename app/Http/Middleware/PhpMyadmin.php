<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class PhpMyadmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user || $user->posisi !== 'admindev') {
            abort(403, 'Anda tidak memiliki akses ke phpMyAdmin.');
        }

        return $next($request);
    }
}
