<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 📌 Route: laboratorium
|--------------------------------------------------------------------------
| Daftarkan route untuk modul laboratorium di sini
|
*/

Route::prefix('laboratorium')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(
    function () {
        Route::resource('dashboard-laboratorium', App\Http\Controllers\Laboratorium\DashboardLaboratoriumController::class);
        Route::resource('inventaris-laboratorium', App\Http\Controllers\Laboratorium\InventarisLaboratoriumController::class);
        Route::resource('jadwal-laboratorium', App\Http\Controllers\Laboratorium\JadwalLaboratoriumController::class);
        Route::resource('peraturan-laboratorium', App\Http\Controllers\Laboratorium\PeraturanLaboratoriumController::class);
        // Route::resource('jadwal-laboratorium', App\Http\Controllers\Laboratorium\JadwalLaboratoriumController::class);
        Route::resource('pengaturan-laboratorium', App\Http\Controllers\Laboratorium\PengaturanLaboratoriumController::class);
    }
    // php artisan make:controller Laboratorium/DashboardLaboratoriumController -m Laboratorium/DashboardLaboratorium
    // php artisan make:controller Laboratorium/JadwalLaboratoriumController -m Laboratorium/JadwalLaboratorium
    // php artisan make:controller Laboratorium/InventarisLaboratoriumController -m Laboratorium/InventarisLaboratorium
    // php artisan make:controller Laboratorium/PengaturanLaboratoriumController -m Laboratorium/PengaturanLaboratorium
    // php artisan make:controller Laboratorium/PeraturanLaboratoriumController -m Laboratorium/PeraturanLaboratorium
);
