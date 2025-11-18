<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

class CheckRouteIntegrity
{
    public function handle($request, Closure $next)
    {
        $allowedRoutes = [
            'dashboard',
            'notaktiv',
            'login',
            'logout',
            'profil',
            'siswa.index',
            'guru.index',
            'admin.seting',
            'lockscreen',
            'admindev.tokenapp',
            'tokenapp.index',
            // Tambahkan route aman di sini
        ];

        $currentRoute = Route::currentRouteName();
        if (!in_array($currentRoute, $allowedRoutes)) {
            return redirect()->route('lockscreen');
        }

        return $next($request);
    }
}

// Versi Lock tapi daftarkan route manual
// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Support\Facades\Route;

// class CheckRouteIntegrity
// {
//     public function handle($request, Closure $next)
//     {
//         // Ini daftar semua route yang resmi di aplikasi Anda
//         $allowedRoutes = [
//             'dashboard',
//             'login',
//             'logout',
//             'profil',
//             'siswa.index',
//             'guru.index',
//             'admin.settings',
//             'lockscreen',
//             // tambah terus daftar ini sesuai aplikasi Anda
//         ];

//         // Ambil semua nama route yang terdaftar di Laravel
//         $allRegisteredRoutes = collect(Route::getRoutes())->map(function ($route) {
//             return $route->getName();
//         })->filter(); // Buang route yang tidak punya nama

//         foreach ($allRegisteredRoutes as $routeName) {
//             if (!in_array($routeName, $allowedRoutes)) {
//                 // Jika ada route baru yang tidak dikenali -> Lock aplikasi
//                 abort(403, 'Aplikasi dikunci: Ditemukan route tidak sah.');
//             }
//         }

//         return $next($request);
//     }
// }
