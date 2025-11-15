<?php

use Illuminate\Support\Facades\Route;

Route::prefix('ekstrakurikuler')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(function () {
    // Resource routes
    Route::resource('peserta-ekstra', App\Http\Controllers\WakaKesiswaan\Ekstra\PesertaEkstraController::class);
    Route::resource('absensi-ekstra', App\Http\Controllers\WakaKesiswaan\Ekstra\DaftarHadirEkstraController::class);
    Route::resource('pengaturan-ekstra', App\Http\Controllers\WakaKesiswaan\Ekstra\PengaturanEkstraController::class);
    Route::resource('materi-ekstra', App\Http\Controllers\WakaKesiswaan\Ekstra\MateriEkstraController::class);
    Route::resource('jurnal-ekstra', App\Http\Controllers\WakaKesiswaan\Ekstra\JurnalEkstraController::class);

    // Routes untuk AJAX data
    Route::get('get-materi', [App\Http\Controllers\WakaKesiswaan\Ekstra\MateriEkstraController::class, 'getMateri']);
    Route::get('get-sub-materi/{materi}', [App\Http\Controllers\WakaKesiswaan\Ekstra\MateriEkstraController::class, 'getSubMateri']);
    Route::get('get-indikator-materi/{subMateri}', [App\Http\Controllers\WakaKesiswaan\Ekstra\MateriEkstraController::class, 'getIndikatorMateri']);
});
