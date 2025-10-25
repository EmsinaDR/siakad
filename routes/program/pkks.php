<?php

use Illuminate\Support\Facades\Route;

Route::prefix('program/pkks')->group(
    function () {
        Route::resource('data-pkks', \App\Http\Controllers\Program\PKKS\DataPKKSController::class);
        Route::get('data-view-pkks/id_{id}', [\App\Http\Controllers\Program\PKKS\Data\ViewPKKSIDController::class, 'show'])->name('data-view-pkks');
        Route::get('upload', function () {
            $datas = \App\Models\Program\PKKS\DataPKKS::all(); // Mengambil data untuk dropdown atau list
            return view('program.pkks.upload', compact('datas'));
        });
        Route::post('upload', [\App\Http\Controllers\Program\PKKS\DataPKKSController::class, 'upload']);
        Route::resource('progres-pkks', \App\Http\Controllers\Program\PKKS\ProgresPKKSController::class);
        Route::resource('/visi-misi', \App\Http\Controllers\Program\VisiMisi\DataVisiMisiController::class);
    }
);
