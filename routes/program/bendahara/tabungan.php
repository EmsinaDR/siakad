<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 📌 Route: tabungan
|--------------------------------------------------------------------------
| Daftarkan route untuk modul tabungan di sini
|
*/

Route::prefix('tabungan')->group(function () {
    Route::get('/', function () {
        return "Ini route tabungan";
    });
});