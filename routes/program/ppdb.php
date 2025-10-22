<?php

use Illuminate\Support\Facades\Route;

Route::prefix('ppdb')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(
    function () {
        Route::resource('peserta-ppdb', App\Http\Controllers\WakaKesiswaan\PPDB\PPDBPesertaController::class);
        Route::resource('riwayat-ppdb', App\Http\Controllers\WakaKesiswaan\PPDB\RiwayatPendaftaranPPDBController::class);
        Route::resource('pengumuman-ppdb', App\Http\Controllers\WakaKesiswaan\PPDB\PengumumanPPDBController::class);
        Route::post('pengumuman-ppdb-bulk', [App\Http\Controllers\WakaKesiswaan\PPDB\PengumumanPPDBController::class, 'PengumumanPPDBBulk'])->name('pengumuman.ppdb.bulk');
        Route::resource('pembayaran-ppdb', App\Http\Controllers\WakaKesiswaan\PPDB\PembayaranPPDBController::class);
        Route::resource('pengaturan-ppdb', App\Http\Controllers\WakaKesiswaan\PPDB\PengaturanPPDBController::class);
        Route::resource('jadwal', App\Http\Controllers\WakaKesiswaan\PPDB\PPDBPesertaController::class);
        Route::get('formulir-ppdb', [App\Http\Controllers\WakaKesiswaan\PPDB\PPDBPesertaController::class, 'FormulirPPDB'])->name('formulir.ppdb');
        Route::resource('piket-ppdb', \App\Http\Controllers\WakaKesiswaan\PPDB\PiketPPDBController::class);
        // Target Peserta Sosialisasi PPDB
        Route::resource('target-peserta-sosialisasi', App\Http\Controllers\WakaKesiswaan\PPDB\DataSiswaTargetController::class)->middleware(['auth', 'verified']);
        // php artisan make:custom-controller FolderData/TargetPesertaController fillable
    }
);
Route::get('ppdb/formulir-ppdb-new', [App\Http\Controllers\WakaKesiswaan\PPDB\PPDBPesertaController::class, 'FormulirPPDBnew'])->name('formulir.ppdb.new');
