<?php
if (config('session.client_server')) {

    return [
        // Default Absensi dan Normalisasi
        App\Providers\AppServiceProvider::class,
        App\Providers\Program\FrontServiceProvider::class,
        App\Providers\RouteProviders::class,
        // Penjadwalan Pesan
        App\Providers\ScheduleServiceProvider::class,
    ];
} else {
    return [
        App\Providers\AppServiceProvider::class,
        // App\Providers\ScheduleServiceProvider::class,
    ];
}
