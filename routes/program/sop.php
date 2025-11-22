<?php

use Illuminate\Support\Facades\Route;

Route::prefix('program/sop')->group(function () {
    // SOP
    Route::resource('data-sop', App\Http\Controllers\Program\SOP\DataSOPController::class);
});
