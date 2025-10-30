<?php

namespace App\Http;

use App\Http\Middleware\Is_guru;
use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\CheckAktivated;
use App\Http\Middleware\CheckActiveUser;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Console\Scheduling\Schedule;
use App\Http\Middleware\CekIdentitasSekolah;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Middleware\TrustProxies;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // Middleware global yang dijalankan pada setiap request
        TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \App\Http\Middleware\CheckAktivated::class,
        \App\Http\Middleware\CheckAdmin::class,
        // Middleware custom untuk cek identitas sekolah
        \App\Http\Middleware\CekIdentitasSekolah::class,
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string>
     */
    protected $routeMiddleware = [
        'auth' => Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => RedirectIfAuthenticated::class,
        'CekDataSekolah' => \App\Http\Middleware\CekIdentitasSekolah::class, // Alias untuk middleware cek identitas
        'checkActiveUser' => \App\Http\Middleware\CheckActiveUser::class,
        'isGuru' => \App\Http\Middleware\Is_guru::class,
        'admin' => \App\Http\Middleware\CheckAdmin::class,

    ];

    /**
     * The application's middleware groups.
     *
     * These middleware groups may be assigned to routes or controllers.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('whatsapp:kirim-jadwal')->everyMinute(); // bisa ubah ke ->dailyAt('08:00'), dll
    }
}
