<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 📌 Route: wakakesiswaan
|--------------------------------------------------------------------------
| Daftarkan route untuk modul wakakesiswaan di sini
|
*/

Route::prefix('program')->group(function () {
    Route::prefix('pembina-osis')->group(
        function () {
            Route::resource('anggota-osis', \App\Http\Controllers\Program\PembinaOsis\AnggotaOsisController::class)->middleware(['auth', 'verified']);
            Route::resource('agenda-osis', \App\Http\Controllers\Program\PembinaOsis\AgendaOsisController::class)->middleware(['auth', 'verified']);
            Route::resource('pendaftaran-osis', \App\Http\Controllers\Program\PembinaOsis\PendaftaranOsisController::class)->middleware(['auth', 'verified']);
        }
    );
});
Route::prefix('wakakesiswaan')->group(function () {
    Route::get('/', function () {
        return "Ini route wakakesiswaan";
    });
});
