<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 📌 Route: wakasarpras
|--------------------------------------------------------------------------
| Daftarkan route untuk modul wakasarpras di sini
|
*/

Route::prefix('wakasarpras')->group(function () {
    Route::get('/', function () {
        return "Ini route wakasarpras";
    });
});