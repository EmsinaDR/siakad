<?php

use Illuminate\Support\Facades\Route;

Route::prefix('waka-sarpras')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(
    function () {
        Route::resource('dashboard-sarpras', App\Http\Controllers\WakaSarpras\WakaSarprasController::class);
        Route::resource('inventaris-sarpras', App\Http\Controllers\WakaSarpras\Inventaris\EinventarisController::class);
        Route::resource('inventaris-vendor', App\Http\Controllers\WakaSarpras\Inventaris\InventarisVendorController::class);
        Route::resource('inventaris-ruangan', App\Http\Controllers\WakaSarpras\Inventaris\InventarisRuanganController::class);
        Route::resource('inventaris-kiba', App\Http\Controllers\WakaSarpras\Inventaris\KIBAController::class);
        Route::resource('inventaris-kibb', App\Http\Controllers\WakaSarpras\Inventaris\KIBBController::class);
        Route::resource('inventaris-kibc', App\Http\Controllers\WakaSarpras\Inventaris\KIBCController::class);
        Route::resource('inventaris-kibd', App\Http\Controllers\WakaSarpras\Inventaris\KIBDController::class);
        Route::resource('inventaris-kibe', App\Http\Controllers\WakaSarpras\Inventaris\KIBEController::class);
        Route::resource('inventaris-kibf', App\Http\Controllers\WakaSarpras\Inventaris\KIBFController::class);
        Route::resource('inventaris-vendor', App\Http\Controllers\WakaSarpras\Inventaris\InventarisVendorController::class);
        Route::resource('inventaris-in-ruangan', App\Http\Controllers\WakaSarpras\Inventaris\InventarisInRuanganController::class);
        Route::resource('pengajuan-inventaris-sarpras', App\Http\Controllers\WakaSarpras\Inventaris\InventarisPengajuanController::class);
    }
);