<?php

use Illuminate\Support\Facades\Route;

Route::prefix('tools')->group(
    function () {


        // Route::prefix('program/tools')->group(function () {
        // Tambahkan route modul di sini
        Route::resource('template-sertifikat', \App\Http\Controllers\Tools\Template\TemplateSertifikatController::class);
        Route::resource('pengaturan-sertifikat', \App\Http\Controllers\Tools\Template\PengaturanTemplateSertifikatController::class);
        Route::post('cetak-sertifikat', [\App\Http\Controllers\Tools\Template\PengaturanTemplateSertifikatController::class, 'CetakSertifikat'])->name('cetak.sertifikat');
        // Image Compress
        Route::resource('image', \App\Http\Controllers\ImageController::class);
        Route::post('image-indexing', [\App\Http\Controllers\ImageController::class, 'indexImage'])->name('tools.compress.img');
        Route::post('image/compress', [\App\Http\Controllers\ImageController::class, 'compress'])->name('image.compress');
        Route::get('image/download/{id}', [\App\Http\Controllers\ImageController::class, 'download'])->name('image.download');
        Route::post('/image/delete-selected', [\App\Http\Controllers\ImageController::class, 'deleteSelected'])->name('image.delete.selected');
        Route::get('/images/download/all', [\App\Http\Controllers\ImageController::class, 'downloadAll'])->name('image.download.all');
        // CoCard
        Route::resource('cocard', \App\Http\Controllers\Tools\Template\Cocard\CocardController::class);
        Route::post('cocard-generate', [\App\Http\Controllers\Tools\Template\Cocard\CocardController::class, 'GenerateCocard'])->name('cocard.generate');
        // Foto Digital
        Route::resource('foto-digital-siswa', \App\Http\Controllers\Tools\Foto\FotoSiswaController::class);
        Route::get('foto-digital-guru', [\App\Http\Controllers\Tools\Photo\AmbilFotoController::class, 'FotoDigitalGuru'])->name('foto.digital.guru');
        Route::post('foto-digital-guru-store', [\App\Http\Controllers\Tools\Photo\AmbilFotoController::class, 'storeFotoGuru'])->name('foto.digital.guru.store');
        // Qr Generator
        Route::resource('generator-qrcode', \App\Http\Controllers\Tools\Qr\GeneratorQrController::class);
        // });

    }
);
