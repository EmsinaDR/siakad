<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 📌 Route: dokumentasi
|--------------------------------------------------------------------------
| Daftarkan route untuk modul dokumentasi di sini
|
*/

Route::prefix('program')->group(function () {
    Route::prefix('dokumentasi')->group(
        function () {
            Route::resource('data-dokumentasi', App\Http\Controllers\Program\Dokumentasi\DataDokumentasiController::class);
        }
    );
});
