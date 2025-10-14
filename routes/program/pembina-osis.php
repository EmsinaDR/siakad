<?php

use Illuminate\Support\Facades\Route;

Route::prefix('program/pembina-osis')->group(
    function () {
        Route::resource('anggota-osis', \App\Http\Controllers\Program\PembinaOsis\AnggotaOsisController::class)->middleware(['auth', 'verified']);
        Route::resource('agenda-osis', \App\Http\Controllers\Program\PembinaOsis\AgendaOsisController::class)->middleware(['auth', 'verified']);
        Route::resource('pendaftaran-osis', \App\Http\Controllers\Program\PembinaOsis\PendaftaranOsisController::class)->middleware(['auth', 'verified']);
        // php artisan make:custom-controller Program/PembinaOsis/AnggotaOsisController
        // php artisan make:custom-controller Program/PembinaOsis/AgendaOsisController
        // php artisan make:custom-controller Program/PembinaOsis/PendaftaranOsisController
    }
);
