<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 📌 Route: wakakurikikulum
|--------------------------------------------------------------------------
| Daftarkan route untuk modul wakakurikikulum di sini
|
*/

Route::prefix('wakakurikikulum')->group(function () {
    Route::get('/', function () {
        return "Ini route wakakurikikulum";
    });
});