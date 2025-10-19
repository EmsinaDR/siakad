<?php

use App\Http\Controllers\Perpustakaan\PerpustakaanKategoriBukuController;
use App\Models\Perpustakaan\PerpustakaanKategoriBuku;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 📌 Route: perpustakaan
|--------------------------------------------------------------------------
| Daftarkan route untuk modul perpustakaan di sini
|
*/

Route::prefix('perpustakaan')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(
    function () {

        Route::resource('katalog-buku', App\Http\Controllers\Perpustakaan\EperpuskatalogController::class);
        //Sumber : https://ebook.uimedan.ac.id/home/bidangilmu/bahasa-indonesia
        //https://sikurma.kemenag.go.id/portal/Buku/data_buku?ref_katbook=ZWJnQUlNTDdwZDN6a1pFZjFnTHl0UT09
        //https://smp.itikurih-hibarna.sch.id/katalog-buku-2/
        //https://www.mtsn1balangan.sch.id/p/download-buku-digital-madrasah.html
        //https://smpn4pakem.sch.id/buku-sekolah-elektronik-kelas-78/
        Route::resource('kategori-buku', PerpustakaanKategoriBukuController::class);
        Route::resource('katalog-ebook', App\Http\Controllers\Perpustakaan\EbookController::class);
        Route::resource('peminjaman-buku', App\Http\Controllers\Perpustakaan\EperpuspeminjamController::class);
        Route::resource('pengunjung', App\Http\Controllers\Perpustakaan\EperpuspengunjungController::class);
        Route::resource('pengaturan-perpustakaan', App\Http\Controllers\Perpustakaan\PengaturanPerpustakaanController::class);
        Route::resource('peraturan', App\Http\Controllers\Admin\PeraturanController::class);
        Route::resource('kartu-buku', App\Http\Controllers\Perpustakaan\KartuBukuController::class);
        Route::get('export-kartu-buku', [App\Http\Controllers\Perpustakaan\KartuBukuController::class, 'exportBuKuKartu'])->name('export.kartu.buku');
        Route::get('export-kartu-peminjaman', [App\Http\Controllers\Perpustakaan\KartuBukuController::class, 'exportPdfKartuPeminjaman'])->name('export.kartu.peminjaman.siswa');
        Route::get('kartu-peminjaman', [App\Http\Controllers\Perpustakaan\KartuBukuController::class, 'KartuPeminjaman'])->name('KartuPeminjaman');
        // Route::match(['get', 'post','destroy','update'], 'peraturan', [PengaturanPerpustakaanController::class, 'PeraturanPerpustakaan'])->name('perpustakaan.peraturan');
        Route::get('ajax-peminjam-buku/{siswa_id}', [App\Http\Controllers\Perpustakaan\EperpuspeminjamController::class, 'AjaxPeminjam'])->name('AjaxPeminjam');
    }
);
