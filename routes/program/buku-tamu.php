<?php

use Illuminate\Support\Facades\Route;

Route::prefix('program/buku-tamu')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(
    function () {
        //routeres
        Route::resource('data-tamu', \App\Http\Controllers\Program\BukuTamu\BukuTamuController::class);
        Route::get('formulir-tamu', [\App\Http\Controllers\Program\BukuTamu\BukuTamuController::class, 'indexFormulirTamu'])->name('formulir-tamu.index');
        // Zf
    }
);
