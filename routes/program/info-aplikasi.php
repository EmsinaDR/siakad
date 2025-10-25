<?php

use Illuminate\Support\Facades\Route;

Route::resource('admindev/modul', \App\Http\Controllers\AdminDev\ModulController::class);
Route::prefix('/aplikasi')->group(
    function () {
        Route::resource('tentang-aplikasi', \App\Http\Controllers\Aplikasi\Tentang\TentangAplikasiController::class);
        Route::resource('dokumentasi-aplikasi', \App\Http\Controllers\Aplikasi\Tentang\DokumentasiAplikasiController::class);
    }
);
