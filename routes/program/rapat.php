<?php

use Illuminate\Support\Facades\Route;



// Tambahkan route modul di sini
// Erapat
Route::prefix('program/rapat')->group(
    function () {
        Route::resource('data-rapat', App\Http\Controllers\Program\Rapat\DataRapatController::class);
        Route::resource('berita-acara-rapat', App\Http\Controllers\Program\Rapat\BeritaAcaraRapatController::class);
        Route::resource('daftar-hadir-rapat', App\Http\Controllers\Program\Rapat\DaftarHadirRapatController::class);
        Route::get('data-rapat-cetak/{id}', [\App\Http\Controllers\Program\Rapat\DataRapatController::class, 'CetakDataRapat'])->name('data.rapat.cetak');
    }
);
