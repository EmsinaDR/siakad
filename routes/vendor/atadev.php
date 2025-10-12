<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 📌 Route: atadev
|--------------------------------------------------------------------------
| Daftarkan route untuk modul atadev di sini
|
*/

Route::prefix('atadev')->group(function () {
    Route::get('/', function () {
        return "Ini route atadev";
    });
});
Route::resource('modul', \App\Http\Controllers\AdminDev\ModulController::class)->middleware(['auth', 'verified']); //Belum
// php artisan make:custom-controller AdminDev/ModulController modul/is_aktiv  modul-controll

// Khusus untuk admindev, gunakan middleware is_admindev tanpa token
Route::middleware(['auth', 'CekDataSekolah', 'verified', 'is_admindev'])->prefix('admindev')->group(function () {
    // Route::resource('tokenapp', TokenController::class);
    Route::get('/tokenapp', [\App\Http\Controllers\AdminDev\TokenController::class, 'index'])->name('tokenapp.index')->middleware(['auth', 'CekDataSekolah', 'verified']);
    Route::post('/tokenapp', [\App\Http\Controllers\AdminDev\TokenController::class, 'update'])->name('tokenapp.update')->middleware(['auth', 'CekDataSekolah', 'verified']);
    Route::resource('control-program', \App\Http\Controllers\AdminDev\ControlMenuController::class)->middleware(['auth', 'verified']);
    Route::post('control-program/{control_program}', [\App\Http\Controllers\AdminDev\ControlMenuController::class, 'update'])->middleware(['auth', 'CekDataSekolah', 'verified'])->name('admindev.update.control');
    Route::PATCH('control-program-user/{id}', [\App\Http\Controllers\AdminDev\ControlMenuController::class, 'updateUser'])->middleware(['auth', 'CekDataSekolah', 'verified'])->name('admindev.user');
    Route::resource('progres-aplikasi', \App\Http\Controllers\AdminDev\ProgresAplikasiController::class)->middleware(['auth', 'verified']);
    Route::get('copy-fitur/{progres_aplikasi}', [\App\Http\Controllers\AdminDev\ProgresAplikasiController::class, 'CopyData'])->name('copy-fitur');
    Route::resource('svg-to-png', \App\Http\Controllers\AdminDev\SvgPngController::class)->middleware(['auth', 'verified']);
    Route::get('generate-karpel', [\App\Http\Controllers\AdminDev\SvgPngController::class, 'GenerateKarpel'])->name('generate.karpel');
    Route::get('generate-nisn', [\App\Http\Controllers\AdminDev\SvgPngController::class, 'GenerateNisn'])->name('generate.nisn');
    Route::get('generate-nisn-array', [\App\Http\Controllers\AdminDev\SvgPngController::class, 'GenerateNisnArray'])->name('generate.nisn.array');
    Route::get('generate-cocard', [\App\Http\Controllers\AdminDev\SvgPngController::class, 'GenerateCoCard'])->name('generate.cocard');
    Route::get('generate-sertifikat', [\App\Http\Controllers\AdminDev\SvgPngController::class, 'GenerateSertifikat'])->name('generate.sertifikat');

    Route::resource('control-program', \App\Http\Controllers\AdminDev\ControlMenuController::class)->middleware(['auth', 'verified']);
    Route::resource('data-kerjasama', \App\Http\Controllers\Paket\Kerjasama\DataKerjasamaController::class)->middleware(['auth', 'verified']);
    Route::resource('harga-paket', \App\Http\Controllers\Paket\Kerjasama\HargaPaketController::class)->middleware(['auth', 'verified']);
});