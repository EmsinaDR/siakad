<?php

use Illuminate\Support\Facades\Route;

Route::prefix('program')->group(function () {
    // Tambahkan route modul di sini
    Route::resource('kepala-tata-usaha', \App\Http\Controllers\Program\TataUsaha\KepalaTataUsahaController::class)->middleware(['auth', 'verified']);
    Route::resource('legalisir-ijazah', \App\Http\Controllers\User\Alumni\PengajuanLegalisirController::class);
});
