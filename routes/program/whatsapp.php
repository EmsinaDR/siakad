<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->prefix('whatsapp')->group(
    // Route::prefix('whatsapp')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(
    function () {
        Route::post('start-session', [\App\Http\Controllers\Whatsapp\WhatsAppSessionController::class, 'storeSessionin']); //aslinya storeSession jika startsession gagal dikembalikan
        Route::post('update-session', [\App\Http\Controllers\Whatsapp\WhatsAppSessionController::class, 'updateSession']);
        // Proses
        Route::post('cek-pembayaran', [\App\Http\Controllers\Whatsapp\WhatsAppController::class, 'CekPembayaran'])->name('whatsapp.cek.pembayaran');
        Route::post('cek-kehadiran', [\App\Http\Controllers\Whatsapp\WhatsAppController::class, 'CekPembayaran'])->name('whatsapp.cek.kehadiran');
        Route::post('cek-nilai', [\App\Http\Controllers\Whatsapp\WhatsAppController::class, 'CekPembayaran'])->name('whatsapp.cek.nilai');
        Route::post('cek-tabungan', [\App\Http\Controllers\Whatsapp\WhatsAppController::class, 'CekPembayaran'])->name('whatsapp.cek.tabungan');

        Route::resource('whatsapp-control', \App\Http\Controllers\Whatsapp\WhatsappLogController::class);
        Route::resource('whatsapp-akun', \App\Http\Controllers\Whatsapp\WhatsAppSessionController::class);
        Route::post('/run-wa-server', [\App\Http\Controllers\Whatsapp\WhatsAppSessionController::class, 'runSilent']);
    }
);
Route::middleware(['web'])->post('kirim-media-grup', [\App\Http\Controllers\Whatsapp\WhatsAppController::class, 'SendGroupMedia'])->name('kirim.media.grup'); // Menghapus sesi
Route::middleware(['web'])->get('/get-groups-by-session', [\App\Http\Controllers\Whatsapp\WhatsAppController::class, 'getGroupsBySession'])->name('get.groups.by.session');

Route::middleware(['web'])->post('/run-wa-server', [\App\Http\Controllers\Whatsapp\WhatsAppSessionController::class, 'runServer'])->name('whatsapp.runserver'); //Mengaktifkan server dengan bat
Route::middleware(['web'])->post('/restart-wa-server', [\App\Http\Controllers\Whatsapp\WhatsAppSessionController::class, 'restartServer'])->name('whatsapp.restartserver'); //Mengaktifkan server dengan bat
Route::middleware(['web'])->post('/hapus-sesi-wa', [\App\Http\Controllers\Whatsapp\WhatsAppSessionController::class, 'hapusSession'])->name('whatsapp.hapussession'); // Menghapus sesi
Route::middleware(['web'])->post('membuat-akun-baru', [\App\Http\Controllers\Whatsapp\WhatsAppSessionController::class, 'AkaunBaru'])->name('AkaunBaru'); // Menghapus sesi
Route::middleware('web')->get('/whatsapp/auto-reply', [\App\Http\Controllers\Whatsapp\WhatsAppController::class, 'testAutoReply'])->name('whatsapp.autoreply');
// Route::middleware(['web'])->resource('whatsapp/penjadwalan', \App\Http\Controllers\Whatsapp\PenjadwalanPesanController::class); // Penjadwalan internal
Route::middleware(['web'])->resource('whatsapp/penjadwalan-ppdb', \App\Http\Controllers\Whatsapp\PenjadwalanWhatsappPPDBController::class); // Penjadwalan Sosialisasi
// Route untuk ambil data siswa via AJAX (berdasarkan NIS)
Route::post('/siswa/scan', [\App\Http\Controllers\User\Siswa\DetailsiswaController::class, 'getByNis'])->name('siswa.scan');
Route::resource('whatsapp/komunikasi', \App\Http\Controllers\Whatsapp\WhatsappKomunikasiController::class);
Route::GET('whatsapp/komunikasi-jemputan', [\App\Http\Controllers\Whatsapp\WhatsappKomunikasiController::class, 'jemputansiswa'])->name('whatsapp.jemputan.siswa'); // Menghapus sesi
Route::post('start-session', [\App\Http\Controllers\Whatsapp\WhatsAppSessionController::class, 'storeSession'])->name('whatsapp.start.session');
Route::middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->get('whatsapp-qrcode', [\App\Http\Controllers\Whatsapp\WhatsAppController::class, 'whatsappqrcode'])->name('whatsappqrcode');
Route::middleware(['web'])->post('get-anggota-group', [\App\Http\Controllers\Whatsapp\WhatsAppController::class, 'GetMember'])->name('whatsapp.member');
Route::middleware(['web'])->get('start-session', [\App\Http\Controllers\Whatsapp\WhatsAppController::class, 'createSession'])->name('createSession');
Route::middleware(['web'])->get('kirim-pesan', [\App\Http\Controllers\Whatsapp\WhatsAppController::class, 'kirimpesan'])->name('kirimpesan');
Route::middleware(['web'])->get('kirim-pesan-masal', [\App\Http\Controllers\Whatsapp\WhatsAppController::class, 'kirimpesan'])->name('kirimpesan.masal');
Route::middleware(['web'])->get('status', [\App\Http\Controllers\Whatsapp\WhatsAppController::class, 'getStatus'])->name('wa.status');
Route::middleware(['web'])->get('respon-aktif', [\App\Http\Controllers\Whatsapp\WhatsAppController::class, 'ResponAktif'])->name('wa.respon.aktif');
