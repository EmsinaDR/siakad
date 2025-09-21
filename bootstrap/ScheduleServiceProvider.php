<?php
if (config('session.dev')) {

    return [
        // Default Absensi dan Normalisasi
        App\Providers\AppServiceProvider::class,
        App\Providers\Program\FrontServiceProvider::class,
        App\Providers\RouteProviders::class,
        // Penjadwalan Pesan
        App\Providers\ScheduleServiceProviderClient::class,
    ];
} else {
    return [
        App\Providers\AppServiceProvider::class,
    ];
}
