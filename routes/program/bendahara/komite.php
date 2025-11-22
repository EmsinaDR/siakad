<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 📌 Route: komite
|--------------------------------------------------------------------------
| Daftarkan route untuk modul komite di sini
|
*/

Route::prefix('komite')->group(function () {
    Route::get('/', function () {
        return "Ini route komite";
    });
});