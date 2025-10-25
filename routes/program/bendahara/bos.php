<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 📌 Route: bos
|--------------------------------------------------------------------------
| Daftarkan route untuk modul bos di sini
|
*/

Route::prefix('bos')->group(function () {
    Route::get('/', function () {
        return "Ini route bos";
    });
});