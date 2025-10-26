<?php

use App\Http\Middleware\Is_guru;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Foundation\Application;
use App\Http\Middleware\CheckAktivated;
use App\Http\Middleware\CheckActiveUser;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))

    ->withRouting(
        web: __DIR__ . '/../routes/web.php',

        api: __DIR__ . '/../routes/api.php',   // 🔥 tambahin ini
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',

    )

    ->withMiddleware(function (Middleware $middleware) {
        // Belum jelas!!!
        $middleware->append(\App\Http\Middleware\forcetoHTTPS::class);
        $middleware->group('api', [
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Illuminate\Routing\Middleware\ThrottleRequests::class . ':api',
        ]);

        // custom group: premium (tanpa session/CSRF, hanya contoh)
        $middleware->group('premium', [
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            // tambahin middleware lain jika perlu (auth/token, throttle, dsb)
        ]);
        // Belum jelas!!!

        $middleware->alias(
            [
                // 'csrf' => \App\Http\Middleware\VerifyCsrfToken::class, // CSRF middleware
                'cors' => \Illuminate\Http\Middleware\HandleCors::class, // CORS middleware
                'CheckAdmin' => \App\Http\Middleware\CheckAdmin::class,
                'CheckAktivated' => \App\Http\Middleware\CheckAktivated::class,
                'Is_guru' => \App\Http\Middleware\Is_guru::class,
                'CekDataSekolah' => \App\Http\Middleware\CekIdentitasSekolah::class, // Cek identitas sekolah
                'check.route.integrity' => \App\Http\Middleware\CheckRouteIntegrity::class, // Middleware cek integritas route
                'is_admindev' => \App\Http\Middleware\CheckAdminDev::class, // Middleware admin dev
                'token.check' => \App\Http\Middleware\CheckTokenMiddleware::class, // Middleware token
                'phpMyadmin' => \App\Http\Middleware\PhpMyadmin::class, // Middleware token



            ]
        );
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
