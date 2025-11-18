<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 📌 Route: wakakurikikulum
|--------------------------------------------------------------------------
| Daftarkan route untuk modul wakakurikikulum di sini
|
*/


//Waka Kurikulum
Route::prefix('/waka-kurikulum')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(
    function () {
        Route::resource('nilai-siswa', App\Http\Controllers\Learning\EnilaiController::class);
        Route::resource('kaldik', \App\Http\Controllers\EkaldikController::class);
        Route::resource('jurnal-mengajar', App\Http\Controllers\WakaKurikulum\Elearning\KurikulumJurnalMengajarController::class);
        Route::resource('materi-ajar', App\Http\Controllers\WakaKurikulum\Elearning\KurikulumMateriAjarController::class);
        Route::resource('kkm', App\Http\Controllers\Learning\EmateriController::class);
        Route::resource('data-kkm', App\Http\Controllers\WakaKurikulum\Elearning\KurikulumDataKKMController::class);
        Route::post('/data-kkm/update', [App\Http\Controllers\WakaKurikulum\Elearning\KurikulumDataKKMController::class, 'updateKKM'])->name('waka.kurikulum.update-kkm');
        //Daftar Nilai
        Route::resource('data-nilai-uh', App\Http\Controllers\WakaKurikulum\Elearning\Nilai\KurikulumNilaiUHController::class);
        Route::get('data-nilai-uh/{mapel_id}/{kelas_id}', [App\Http\Controllers\WakaKurikulum\Elearning\Nilai\KurikulumNilaiUHController::class, 'show'])->name('data-nilai-uh.show');
        Route::resource('data-nilai-tugas', App\Http\Controllers\WakaKurikulum\Elearning\Nilai\KurikulumNilaiTugasController::class);
        Route::get('data-nilai-tugas/{mapel_id}/{kelas_id}', [App\Http\Controllers\WakaKurikulum\Elearning\Nilai\KurikulumNilaiTugasController::class, 'show'])->name('data-nilai-tugas.show');
        Route::resource('data-nilai-pts-pas', App\Http\Controllers\WakaKurikulum\Elearning\Nilai\KurikulumNilaiPTSPASController::class);
        Route::resource('data-nilai-ujian', App\Http\Controllers\WakaKurikulum\Elearning\Nilai\KurikulumNilaiUjianController::class);
        Route::delete('data-nilai-ujian', [App\Http\Controllers\WakaKurikulum\Elearning\Nilai\KurikulumNilaiUjianController::class, 'destroy'])->name('data-nilai-ujian.destroy');
        Route::resource('data-peserta-ujian', \App\Http\Controllers\WakaKurikulum\Elearning\Nilai\KurulumDataPesertaUjianController::class);
        Route::delete('hapus-semua-nilai-ujian', [App\Http\Controllers\WakaKurikulum\Elearning\Nilai\KurulumDataPesertaUjianController::class, 'HapusSemuaPeserta'])->name('hapus-semua-nilai-ujian.destroy');

        Route::resource('jadwal-pelajaran', App\Http\Controllers\Jadwal\JadwalPelajaranController::class);
        Route::get('/jadwal-pelajaran-blanko', [App\Http\Controllers\Jadwal\JadwalPelajaranController::class, 'JadwalBlank'])->name('jadwal.blanko');
        Route::get('/jadwal-pelajaran-duplikat', [App\Http\Controllers\Jadwal\JadwalPelajaranController::class, 'JadwalDuplikat'])->name('jadwal.duplikat');
        Route::post('/update-jadwal/{id}', [App\Http\Controllers\Jadwal\JadwalPelajaranController::class, 'updateJadwal']);

        //Perangkat Test
        Route::resource('perangkat-test', App\Http\Controllers\WakaKurikulum\Perangkat\PerangkatTestController::class);
        // Route::resource('peserta-test', App\Http\Controllers\WakaKurikulum\Perangkat\PesertaTestController::class);
        Route::resource('peserta-test', App\Http\Controllers\WakaKurikulum\Perangkat\PesertaTestController::class);
        Route::resource('tempat-duduk-test', App\Http\Controllers\WakaKurikulum\Perangkat\TempatDudukTestController::class);
        Route::resource('kartu-test', App\Http\Controllers\WakaKurikulum\Perangkat\KartuTestController::class);
        Route::resource('berita-acara', App\Http\Controllers\WakaKurikulum\Perangkat\PerangkatBeritaAcaraController::class);
        Route::resource('daftar-hadir', App\Http\Controllers\WakaKurikulum\Perangkat\PerangkatDaftarHadirController::class);
        Route::resource('tempat-duduk', App\Http\Controllers\WakaKurikulum\Perangkat\PerangkatTempatDudukController::class);
        Route::get('bulk-tempat-duduk', [App\Http\Controllers\WakaKurikulum\Perangkat\PesertaTestController::class, 'BulkTempatDuduk'])->name('bulk.tempat.duduk');
        Route::resource('nomor-meja', App\Http\Controllers\WakaKurikulum\Perangkat\PerangkatNomorMejaController::class);
        Route::resource('jadwal-test', App\Http\Controllers\WakaKurikulum\Perangkat\JadwalTestController::class);
        Route::post('jadwal-test/update', [App\Http\Controllers\WakaKurikulum\Perangkat\JadwalTestController::class, 'update'])->name('waka.jadwal.update');
        Route::get('jadwal-reset', [App\Http\Controllers\WakaKurikulum\Perangkat\JadwalTestController::class, 'Resset'])->name('waka.jadwal.Resset');
        Route::delete('jadwal-test/{jadwal_test}', [\App\Http\Controllers\WakaKurikulum\Perangkat\JadwalTestController::class, 'destroy'])->name('jadwal-test.destroy');
        Route::resource('peraturan-test', App\Http\Controllers\WakaKurikulum\Perangkat\PeraturanTestController::class);
        Route::resource('ruang-test', App\Http\Controllers\WakaKurikulum\Perangkat\PerangkatRuangTestController::class);
        Route::post('update-ruang', [App\Http\Controllers\WakaKurikulum\Perangkat\PerangkatRuangTestController::class, 'UpdateRuangan'])->name('update.ruangan.test');
        Route::get('reset-ruang', [App\Http\Controllers\WakaKurikulum\Perangkat\PerangkatRuangTestController::class, 'resetRuangan'])->name('reset.ruangan.test');
        Route::match(['get'], 'peserta-test-copy', [App\Http\Controllers\WakaKurikulum\Perangkat\PesertaTestController::class, 'PesertaTest'])->name('PesertaTest');
        //Update jax Ruangann
        Route::post('update-ruang-test', [App\Http\Controllers\WakaKurikulum\Perangkat\PesertaTestController::class, 'updateRuangTest'])->name('update.ruang.test');
        //Perangkat Guru Piket
        Route::resource('jadwal-piket-guru', App\Http\Controllers\WakaKurikulum\JadwalPiket\DataJadwalPiketController::class);
        Route::resource('tugas-piket-guru', App\Http\Controllers\WakaKurikulum\JadwalPiket\TugasGuruController::class);
        Route::get('tugas-piket-guru-sekarang', [App\Http\Controllers\WakaKurikulum\JadwalPiket\TugasGuruController::class, 'TugasNow'])->name('tugas.guru,sekarang');
        // Perangkat Kelulusan
        Route::prefix('kelulusan')->group(
            function () {
                Route::resource('peserta-kelulusan', App\Http\Controllers\WakaKurikulum\Kelulusan\PesertaKelulusanController::class);
                Route::post('peserta-kelulusan', [App\Http\Controllers\WakaKurikulum\Kelulusan\PesertaKelulusanController::class, 'updatePesertaKelulusan'])->name('update.peserta.kelulusan');
                Route::post('reset-kelulusan', [App\Http\Controllers\WakaKurikulum\Kelulusan\PesertaKelulusanController::class, 'resetPesertaKelulusan'])->name('reset.peserta.kelulusan');
                Route::post('ubah-status-kelulusan', [App\Http\Controllers\WakaKurikulum\Kelulusan\PesertaKelulusanController::class, 'StatusPesertaKelulusan'])->name('status.peserta.kelulusan');
                Route::post('tanggal-kelulusan', [App\Http\Controllers\WakaKurikulum\Kelulusan\PesertaKelulusanController::class, 'tanggalKelulusan'])->name('tanggal.kelulusan');
                Route::resource('pengumuman-kelulusan', \App\Http\Controllers\WakaKesiswaan\Pengumuman\PengumumanKelulusanController::class);
                Route::resource('surat-kelulusan', \App\Http\Controllers\WakaKurikulum\Surat\SuratKelulusanController::class);
                Route::resource('nilai-raport-kelulusan', App\Http\Controllers\WakaKurikulum\Kelulusan\NilaiSemesterKelulusanController::class);
                Route::get('/nilai-raport-kelulusan/{detailsiswa_id}', [App\Http\Controllers\WakaKurikulum\Kelulusan\NilaiSemesterKelulusanController::class, 'show'])->name('raport.show');
            }
        );

        Route::resource('e-ijazah', \App\Http\Controllers\Program\EIjazah\EIjazahSiswaController::class)->middleware(['auth', 'verified']);
    }
);