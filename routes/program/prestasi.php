<?php

use Illuminate\Support\Facades\Route;

Route::prefix('program')->group(function () {
    // Tambahkan route modul di sini
    Route::resource('prestasi', App\Http\Controllers\Program\Prestasi\DataPrestasiController::class)->middleware(['auth', 'verified']);
});
