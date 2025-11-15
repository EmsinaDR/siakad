<?php

use Illuminate\Support\Facades\Route;

Route::prefix('program')->group(function () {
    // Tambahkan route modul di sini
    Route::get('template-dokumen/search/{key}', [\App\Http\Controllers\Program\Template\TemplateDokumenController::class, 'TemplateKhusus'])->name('TemplateKhusus');
    Route::resource('template-dokumen', \App\Http\Controllers\Program\Template\TemplateDokumenController::class);
    Route::get('template-cetak/{id}', [\App\Http\Controllers\Program\Template\TemplateDokumenController::class, 'TemplateCetak'])->name('template.cetak');
});
