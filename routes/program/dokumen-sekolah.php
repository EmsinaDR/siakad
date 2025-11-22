<?php

use Illuminate\Support\Facades\Route;

Route::prefix('dokumen-sekolah')->group(function () {
    // Tambahkan route modul di sini
    // php artisan make:custom-controller Modul\Dokumen/Imut/AllIndokumenController nama_dokumen/slug/keterangan  dokumen-siswa
    Route::resource('dokumen-imut', \App\Http\Controllers\Modul\Dokumen\Imut\AllIndokumenController::class)->middleware(['auth', 'verified']); //Belum

});
