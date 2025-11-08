<?php

use Illuminate\Support\Facades\Route;

Route::prefix('program/shalat-jamaah')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(
    function () {
        //routeres
        Route::resource('jadwal-shalat', App\Http\Controllers\Program\Shalat\JadwalShalatController::class);
        // Route::get('formulir-tamu', [\App\Http\Controllers\Program\BukuTamu\BukuTamuController::class, 'indexFormulirTamu'])->name('formulir-tamu.index');
        // Zf
    }
);
