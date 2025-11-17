<?php

use Illuminate\Support\Facades\Route;

Route::prefix('program/bendahara')->group(function () {
    // Tambahkan route modul di sini
    // Bendahara Daftar Ulang
    Route::resource('rencana-anggaran-list', \App\Http\Controllers\Bendahara\RencanaAnggaran\RencanaAnggaranListController::class);
    Route::resource('rencana-anggaran-sekolah', \App\Http\Controllers\Bendahara\RencanaAnggaran\RencanaAnggaranSekolahController::class);
    Route::post('rencana-anggaran-sekolah-ubah-kategori', [\App\Http\Controllers\Bendahara\RencanaAnggaran\RencanaAnggaranSekolahController::class, 'UbahKategori'])->name('kategori.ubah');
    Route::resource('daftar-ulang', App\Http\Controllers\Bendahara\BendaharaDaftarUlangController::class);
    Route::resource('rincian-daftar-ulang', \App\Http\Controllers\Bendahara\BendaharaDaftarUlang\RincianDaftarUlangController::class);
    // php artisan make:custom-controller Bendahara/BendaharaDaftarUlang/RincianDaftarUlangController
    //Komite
    Route::resource('dasboard-komite', App\Http\Controllers\Bendahara\BendaharaKomiteController::class);
    // Pemasukkan Komite
    Route::get('/input-komite', [\App\Http\Controllers\Bendahara\BendaharaKomiteController::class, 'InputKomite'])->name('InputKomite');
    Route::resource('/pengeluaran-komite', App\Http\Controllers\Bendahara\KomitePengeluaranController::class);
    Route::POST('/copy-komite', [\App\Http\Controllers\Bendahara\BendaharaKomiteController::class, 'CopyKomite'])->name('CopyKomite');
    Route::POST('/reset-komite', [\App\Http\Controllers\Bendahara\BendaharaKomiteController::class, 'ResetKomite'])->name('ResetKomite');
    Route::POST('/bulk-update-komite', [\App\Http\Controllers\Bendahara\KeuanganRiwayatListController::class, 'BulkUpdate'])->name('BulkUpdate');
    Route::get('/list-komite', [\App\Http\Controllers\Bendahara\BendaharaKomiteController::class, 'ListDana'])->name('ListDana');
    Route::get('/pengaturan-komite', [\App\Http\Controllers\Bendahara\BendaharaKomiteController::class, 'PengaturanKomite'])->name('PengaturanKomite');
    Route::post('/list-komite', [\App\Http\Controllers\Bendahara\BendaharaKomiteController::class, 'ListDana'])->name('ListDana');
    // Pembayaran Tunggakan
    Route::get('/tunggakan-komite', [\App\Http\Controllers\Bendahara\BendaharaKomiteController::class, 'TunggakanSiswa'])->name('TunggakanSiswa');
    Route::POST('/tunggakan-komite', [\App\Http\Controllers\Bendahara\BendaharaKomiteController::class, 'TunggakanSiswa'])->name('TunggakanSiswa');
    Route::POST('/pembayaran-tunggakan-komite', [\App\Http\Controllers\Bendahara\BendaharaKomiteController::class, 'PembayaranTunggakanKomite'])->name('PembayaranTunggakanKomite');
    Route::resource('/dokumen-komite', App\Http\Controllers\Bendahara\KomiteDokumenController::class);
    Route::resource('/buku-kas-komite', App\Http\Controllers\Bendahara\BukukasKomiteController::class);
    // BOS
    Route::resource('pemasukkan-bos', App\Http\Controllers\Bendahara\BendaharaBosController::class);
    Route::resource('pengeluaran-bos', \App\Http\Controllers\Bendahara\BOS\TransaksaksiPengeluaranBOSController::class)->middleware(['auth', 'verified']);
    Route::resource('buku-kas-bos', \App\Http\Controllers\Bendahara\BOS\BukuKasBOSController::class)->middleware(['auth', 'verified']);
    // PIP
    Route::resource('pemasukkan-pip', \App\Http\Controllers\Bendahara\PIP\PemasukkanBendaharaPipController::class)->middleware(['auth', 'verified']);
    Route::POST('pemasukkan-pip-anggaran', [\App\Http\Controllers\Bendahara\PIP\PemasukkanBendaharaPipController::class, 'PIPAnggaran'])->name('pip.anggaran.update');
    Route::resource('pengeluaran-pip', \App\Http\Controllers\Bendahara\PIP\PengeluaranBendaharaPipController::class)->middleware(['auth', 'verified']);
    Route::resource('penerima-pip', \App\Http\Controllers\Bendahara\PIP\DataPenerimaPipController::class)->middleware(['auth', 'verified']);
    Route::delete('/penerima-pip/{penerima_pip}', [\App\Http\Controllers\Bendahara\PIP\DataPenerimaPipController::class, 'DeletPenerima'])->name('penerima.pip.delete');

    // CSR
    Route::resource('pemasukkan-csr', \App\Http\Controllers\Bendahara\CSR\PemasukkanCSRController::class)->middleware(['auth', 'verified']);
    Route::resource('pengeluaran-csr', \App\Http\Controllers\Bendahara\CSR\PengeluaranCSRController::class)->middleware(['auth', 'verified']);
    Route::resource('buku-kas-csr', \App\Http\Controllers\Bendahara\CSR\BukuKasCSRController::class)->middleware(['auth', 'verified']);
    //KAS Umum
    Route::resource('/buku-kas-umum', App\Http\Controllers\Bendahara\KasUmum\BendaharaKasUmumController::class); // Belum
    Route::POSt('laporan-buku-kas-umum', [\App\Http\Controllers\Bendahara\KasUmum\BendaharaKasUmumController::class, 'LaporanKasUmum'])->name('laporan.buku.kas.umum');
    // Tabungan
    Route::prefix('/tabungan')->group(
        function () {
            Route::resource('', App\Http\Controllers\Bendahara\BendaharaTabunganController::class)->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->names([
                'index' => 'bendahara.tabungan.index',
                'create' => 'bendahara.tabungan.create',
                'store' => 'bendahara.tabungan.store',
                'show' => 'bendahara.tabungan.show',
                'edit' => 'bendahara.tabungan.edit',
                'update' => 'bendahara.tabungan.update',
                'destroy' => 'bendahara.tabungan.destroy',
            ]);
            Route::get('/tabungan-siswa', [App\Http\Controllers\Bendahara\BendaharaTabunganController::class, 'TabunganSiswa'])->name('TabunganSiswa');
            Route::get('/data-tabungan', [App\Http\Controllers\Bendahara\BendaharaTabunganController::class, 'DataTabungan'])->name('DataTabungan');
            Route::get('/transfer-pembayaran', [App\Http\Controllers\Bendahara\BendaharaTabunganController::class, 'TransferPembayaran'])->name('TransferTabungan');
            Route::get('/laporan', [App\Http\Controllers\Bendahara\BendaharaTabunganController::class, 'LaporanTabungan'])->name('LaporanTabungan');
            Route::POST('/laporan', [App\Http\Controllers\Bendahara\BendaharaTabunganController::class, 'LaporanBulananTabungan'])->name('LaporanBulananTabungan');
            Route::POST('/laporan/bulanan', [App\Http\Controllers\Bendahara\BendaharaTabunganController::class, 'LaporanBulananTabungan'])->name('LaporanBulananTabungan');
            Route::POST('/laporan/bulanan/ajax', [App\Http\Controllers\Bendahara\BendaharaTabunganController::class, 'LaporanBulananTabunganajax'])->name('LaporanBulananTabunganajax');
            Route::POST('/laporan/bulanan/siswa-ajax', [App\Http\Controllers\Bendahara\BendaharaTabunganController::class, 'LaporanBulananTabunganSiswaajax'])->name('LaporanBulananTabunganSiswaajax');
            Route::get('/riwayat-tabungan/{id}', [App\Http\Controllers\Bendahara\BendaharaTabunganController::class, 'RiwayatTabungan'])->name('RiwayatTabungan');
            Route::get('/cetak', [App\Http\Controllers\Bendahara\BendaharaTabunganController::class, 'CetakPdf'])->name('CetakPdf');
        }
    );
    Route::prefix('/study-tour')->group(
        function () {
            Route::resource('data-study-tour', App\Http\Controllers\Bendahara\BendaharaStudyTourController::class)
                ->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])
                ->parameters(['' => 'study_tour']) // Tambahkan nama parameter
                ->names([
                    'index' => 'bendahara.studytour.index',
                    'create' => 'bendahara.studytour.create',
                    'store' => 'bendahara.studytour.store',
                    'show' => 'bendahara.studytour.show',
                    'edit' => 'bendahara.studytour.edit',
                    'update' => 'bendahara.studytour.update',
                    'destroy' => 'bendahara.studytour.destroy',
                ]);
            Route::resource('/riwayat', App\Http\Controllers\Bendahara\RiwayatStudyTourController::class)->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->names([
                'index' => 'RiwayatStudyTour.index',
                'create' => 'RiwayatStudyTour.create',
                'store' => 'RiwayatStudyTour.store',
                'show' => 'RiwayatStudyTour.show',
                'edit' => 'RiwayatStudyTour.edit',
                'update' => 'RiwayatStudyTour.update',
                'destroy' => 'RiwayatStudyTour.destroy',
            ]);

            Route::get('study-tour-setting', [App\Http\Controllers\Bendahara\BendaharaStudyTourController::class, 'SettingStudyTour'])->name('SettingStudyTour');
            Route::get('input-study-tour', [App\Http\Controllers\Bendahara\BendaharaStudyTourController::class, 'InputStudyTour'])->name('InputStudyTour');
            Route::get('data-pembayaran-study-tour', [App\Http\Controllers\Bendahara\BendaharaStudyTourController::class, 'DataStudyTour'])->name('DataStudyTour');
        }


    );
    // Riwayat dan List Pembayaran Komite
    Route::resource('keuangan-riwayat-list', App\Http\Controllers\Bendahara\KeuanganRiwayatListController::class);
    Route::resource('keuangan-list', App\Http\Controllers\Bendahara\KeuanganListController::class);
    // Route::POST('/keungan-insert-list', [\App\Http\Controllers\Bendahara\KeuanganListController::class, 'KeuanganInsertList'])->name('KeuanganInsertList');
    Route::resource('transfer-pembayaran', \App\Http\Controllers\Bendahara\Transfer\TransferPembayaranController::class)->middleware(['auth', 'verified']);
});
