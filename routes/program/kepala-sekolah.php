<?php

use Illuminate\Support\Facades\Route;

Route::prefix('kepala-sekolah')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(
    function () {
        Route::resource('/surat-keputusan', \App\Http\Controllers\KepalaSekolah\SuratKeputusanController::class);
        Route::get('surat-keputusan-view/{id}', [\App\Http\Controllers\KepalaSekolah\SuratKeputusanController::class, 'skview'])->name('skview');
        Route::resource('/agenda-kepala', \App\Http\Controllers\KepalaSekolah\SuratKeputusanController::class);
        Route::resource('pembinaan', \App\Http\Controllers\KepalaSekolah\PembinaanController::class)->middleware(['auth', 'verified']);
    }
);