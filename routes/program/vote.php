<?php

use Illuminate\Support\Facades\Route;

Route::prefix('program/vote')->group(
    function () {
        Route::resource('pertanyaan-vote', \App\Http\Controllers\Program\Vote\PertanyaanVoteController::class);
        Route::resource('hasil-vote', \App\Http\Controllers\Progtam\Vote\DataJawabanVoteController::class);
        Route::resource('jawaban-vote', \App\Http\Controllers\Program\Vote\DataJawabanVoteController::class);
        // php artisan make:custom-controller Program/Vote/DataJawabanVoteController
        // php artisan make:custom-controller Program/Vote/PertanyaanVoteController
    }
);
