<?php


use Mpdf\Mpdf;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Ekaldik;
use App\Mail\KirimEmail;
use App\Models\Admin\Ekelas;
use App\Models\Admin\Emapel;
use App\Models\Admin\Etapel;
use App\Models\Dokumenttest;
use Illuminate\Http\Request;
use App\Models\Admin\Identitas;
use App\Models\Learning\Emengajar;
use App\Models\Program\CBT\BankSoal;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Program\PKKS\DataPKKS;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;
use App\Models\User\Siswa\Detailsiswa;
use App\Http\Controllers\ExcelController;
use App\Models\Bendahara\BendaharaKomite;
use App\Http\Controllers\bk\EbkController;
use App\Http\Controllers\EkaldikController;
use App\Http\Controllers\ProfileController;
use App\Models\Program\Tupoksi\DataTupoksi;
use App\Http\Controllers\TestpageController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\UploadFileController;
use App\Models\Program\Surat\SuratKlasifikasi;
use App\Models\User\Alumni\PengajuanLegalisir;
use App\Http\Controllers\Admin\EkelasController;
use App\Http\Controllers\Admin\EmapelController;
use App\Http\Controllers\Admin\EtapelController;
use App\Models\Laboratorium\RiwayatLaboratorium;
use App\Models\Program\Template\TemplateDokumen;
use App\Models\Aplikasi\Tetntang\TentangAplikasi;
use App\Models\Tools\Template\TemplateSertifikat;
use App\Http\Controllers\AdminDev\TokenController;
use App\Http\Controllers\Admin\IdentitasController;
use App\Http\Controllers\Admin\PeraturanController;
use App\Models\Program\Dokumentasi\DataDokumentasi;
use App\Models\Program\Supervisi\SupervisiInstrument;
use App\Http\Controllers\Learning\EmengajarController;
use Database\Seeders\Program\Tagline\DataTaglineSeeder;
use App\Http\Controllers\User\Guru\DetailguruController;
use App\Http\Controllers\Program\SetingPenggunaController;
use App\Http\Controllers\User\Karyawan\KaryawanController;
use App\Http\Controllers\User\Siswa\DetailsiswaController;
use App\Http\Controllers\Program\Rapat\DataRapatController;
use App\Http\Controllers\User\Alumni\DetailAlumniController;
use App\Http\Controllers\Admin\Cetak\CetakQrAbsensiController;
use App\Http\Controllers\Laboratorium\ElaboratoriumController;
use App\Http\Controllers\Program\SetingPenggunaKaTUController;
use App\Http\Controllers\Program\Tagline\DataTaglineController;
use App\Http\Controllers\Registrasi\RegistrasiSekolahController;
use App\Http\Controllers\Bendahara\RencanaAnggaranListController;
use App\Http\Controllers\Program\Proker\DataProgramKerjaController;
use App\Http\Controllers\Program\Template\TemplateDokumenController;
use App\Http\Controllers\Aplikasi\Tetntang\TentangAplikasiController;
use App\Http\Controllers\Tools\Template\TemplateSertifikatController;
use App\Http\Controllers\Program\Dokumentasi\DataDokumentasiController;


// Route::prefix('program/front')->group(function () {
// Tambahkan route modul di sini
Route::GET('/', function () {
    $breadcrumb = 'Home / Dasboard User';

    // info Dashboard
    $etapel = App\Models\Admin\Etapel::select('id')->where('aktiv', 'Y')->first();
    $jumlah_siswa = Cache::tags(['chace_jumlah_siswa'])->remember('remember_jumlah_siswa', now()->addHours(2), function () {
        return \Illuminate\Foundation\Auth\User::where('posisi', 'Siswa')->count();
    });

    HapusCacheDenganTag('jumlah_alumni');
    HapusCacheDenganTag('jumlah_alumni');
    $jumlah_alumni = Cache::tags(['Cache_jumlah_alumni'])->remember('Remember_jumlah_alumni', now()->addMinutes(10), function () {
        return \App\Models\User\Siswa\Detailsiswa::where('status_siswa', 'lulus')->get()->count();
        // return 5;
    });

    HapusCacheDenganTag('TAG_USER_SISWA');
    $jumlah_guru = Cache::tags(['jumlah_guruchace'])->remember('jumlah_gururemember', now()->addHours(2), function () {
        return \Illuminate\Foundation\Auth\User::where('posisi', 'Guru')->count();
    });

    HapusCacheDenganTag('TAG_USER_SISWA');
    $jumlah_karyawan = Cache::tags(['jumlah_karyawanchace'])->remember('jumlah_karyawanremember', now()->addHours(2), function () {
        return User::where('posisi', 'Karyawan')->count();;
    });

    HapusCacheDenganTag('TAG_USER_SISWA');

    $etapel = Etapel::select('id')->where('aktiv', 'Y')->first();
    $emapels = Cache::tags(['emapelschace'])->remember('emapelsremember', now()->addHours(2), function () use ($etapel) {
        return Emengajar::where('tapel_id', $etapel->id)->select('mapel_id')->distinct('mapel_id')->count();;
    });

    $jumlah_kelas = Cache::tags(['jumlahKelaschace'])->remember('jumlahKelasremember', now()->addHours(2), function () use ($etapel) {
        return Ekelas::where('tapel_id', $etapel->id)->get()->count();
    });

    $jumlah_laboratorium = Cache::tags(['jumlahlabschace'])->remember('jumlahlabsremember', now()->addHours(2), function () use ($etapel) {
        return App\Models\Laboratorium\RiwayatLaboratorium::where('tapel_id', $etapel->id)->where('aktiv', 'Y')->get()->count();
    });
    $info =  $jumlah_siswa . '/' . $jumlah_guru . '/' . $jumlah_karyawan . '/' . $emapels  . '/' . $jumlah_kelas  . '/' . $jumlah_laboratorium  . '/' . $jumlah_alumni;
    $title = 'Dasboard';
    $identitas = Identitas::first();
    $dataUserDasboard = Cache::tags(['chace_dataUserDasboard'])->remember('remember_dataUserDasboard', now()->addHours(2), function () {
        return User::where('posisi', 'Siswa')->get();
    });
    //Untuk Hapusnya :
    return view('dasboard', compact(
        'title',
        'breadcrumb',
        'dataUserDasboard',
        'info',
        'identitas',
    ));
})->middleware(['auth', 'CekDataSekolah', 'token.check', 'CheckAktivated'])->name('Dashborad');
Route::middleware(['auth', 'Is_guru'])->get('/dashboard', function () {
    return view('dasboard');
});
Route::middleware('auth')->group(function () {
    Route::GET('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::prefix('/admin/seting')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(function () {

    Route::resource('siswa', App\Http\Controllers\User\Siswa\DetailsiswaController::class);
    Route::get('siswa-cetak/{id}', [App\Http\Controllers\User\Siswa\DetailsiswaController::class, 'SiswaCetak'])->name('siswa.cetak');

    Route::resource('guru', App\Http\Controllers\User\Guru\DetailguruController::class);
    Route::resource('karyawan', App\Http\Controllers\User\Karyawan\KaryawanController::class);
    Route::resource('alumni', App\Http\Controllers\User\Alumni\DetailAlumniController::class);
    Route::resource('etapel', App\Http\Controllers\Admin\EtapelController::class);
    Route::resource('kelas', App\Http\Controllers\Admin\EkelasController::class);
    Route::post('pindah-kelas', [\App\Http\Controllers\Admin\EkelasController::class, 'PindahKelas'])->name('ekelas.pindah');
    Route::resource('emapel', App\Http\Controllers\Admin\EmapelController::class);
    Route::resource('emengajar', App\Http\Controllers\Learning\EmengajarController::class);
    Route::resource('laboratorium', App\Http\Controllers\Laboratorium\ElaboratoriumController::class);

    Route::post('/emapel/mapelaktivkan', [\App\Http\Controllers\Admin\EmapelController::class, 'mapelaktivkan'])->name('Emapel.mapelaktivkan');
    Route::post('/emapel/tambahmapel', [\App\Http\Controllers\Admin\EmapelController::class, 'TambahMapel'])->name('emapel.TambahMapel');

    Route::resource('role-guru', App\Http\Controllers\Admin\RoleController::class);
    Route::get('role-siswa', [App\Http\Controllers\Admin\RoleController::class, 'role_siswa_index'])->name('role-siswa.index');
    Route::post('role-siswa', [App\Http\Controllers\Admin\RoleController::class, 'role_siswa_store'])->name('role-siswa.store');
    Route::patch('role-siswa', [App\Http\Controllers\Admin\RoleController::class, 'role_siswa_update'])->name('role-siswa.update');
    Route::delete('role-siswa', [App\Http\Controllers\Admin\RoleController::class, 'role_siswa_destroy'])->name('role-siswa.destroy');
    Route::put('role-siswa-reseter', [App\Http\Controllers\Admin\RoleController::class, 'role_siswa_reseter'])->name('role-siswa.reseter');
    Route::put('role-siswa', [App\Http\Controllers\Admin\RoleController::class, 'role_siswa_lock'])->name('role-siswa.lock');

    Route::resource('peraturan', App\Http\Controllers\Admin\PeraturanController::class);

    // Identitas: Perlu tambahan CheckAdmin
    Route::resource('identitas', App\Http\Controllers\Admin\IdentitasController::class)->middleware(['CheckAdmin']);

    // Seting Pengguna
    Route::resource('seting-pengguna-program', \App\Http\Controllers\Program\SetingPenggunaController::class);
    Route::resource('seting-pengguna-program-katu', \App\Http\Controllers\Program\SetingPenggunaKaTUController::class);

    // Kartu QR: Beberapa hanya butuh auth & verified
    Route::resource('kartu-qr', \App\Http\Controllers\Admin\Cetak\CetakQrAbsensiController::class)->middleware(['auth', 'verified']);
    Route::get('kartu-qr-cetak-siswa', [\App\Http\Controllers\Admin\Cetak\CetakQrAbsensiController::class, 'Cetaksiswa'])->name('cetak.kartu.absensi.siswa');
    Route::get('kartu-qr-cetak-guru', [\App\Http\Controllers\Admin\Cetak\CetakQrAbsensiController::class, 'CetakGuru'])->name('cetak-kartu.absensi.guru');

    // Ajax
    Route::post('emengajar/UpdateMengajar', [App\Http\Controllers\Learning\EmengajarController::class, 'UpdateMengajar'])->name('UpdateMengajar');

    Route::resource('reset-password', \App\Http\Controllers\Admin\ResetPasswordController::class)
        ->middleware(['auth', 'verified']);
});
Route::get('login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])
    ->middleware('CekDataSekolah')->name('login'); // Pastikan hanya middleware ini yang diterapkan untuk login

Route::get('/lockscreen', [\App\Http\Controllers\LockscreenController::class, 'index'])->name('lockscreen');
Route::get('/admin/token', [\App\Http\Controllers\Admin\TokenController::class, 'index'])->name('admin.token.index');
Route::post('/admin/token/update', [\App\Http\Controllers\Admin\TokenController::class, 'update'])->name('admin.token.update');

// Khusus untuk admindev, gunakan middleware is_admindev tanpa token
Route::middleware(['auth', 'CekDataSekolah', 'verified', 'is_admindev'])->prefix('admindev')->group(function () {
    // Route::resource('tokenapp', TokenController::class);
    Route::get('/tokenapp', [\App\Http\Controllers\AdminDev\TokenController::class, 'index'])->name('tokenapp.index')->middleware(['auth', 'CekDataSekolah', 'verified']);
    Route::post('/tokenapp', [\App\Http\Controllers\AdminDev\TokenController::class, 'update'])->name('tokenapp.update')->middleware(['auth', 'CekDataSekolah', 'verified']);
    Route::resource('control-program', \App\Http\Controllers\AdminDev\ControlMenuController::class)->middleware(['auth', 'verified']);
    Route::post('control-program/{control_program}', [\App\Http\Controllers\AdminDev\ControlMenuController::class, 'update'])->middleware(['auth', 'CekDataSekolah', 'verified'])->name('admindev.update.control');
    Route::PATCH('control-program-user/{id}', [\App\Http\Controllers\AdminDev\ControlMenuController::class, 'updateUser'])->middleware(['auth', 'CekDataSekolah', 'verified'])->name('admindev.user');
    Route::resource('progres-aplikasi', \App\Http\Controllers\AdminDev\ProgresAplikasiController::class)->middleware(['auth', 'verified']);
    Route::get('copy-fitur/{progres_aplikasi}', [\App\Http\Controllers\AdminDev\ProgresAplikasiController::class, 'CopyData'])->name('copy-fitur');
    Route::resource('svg-to-png', \App\Http\Controllers\AdminDev\SvgPngController::class)->middleware(['auth', 'verified']);
    Route::get('generate-karpel', [\App\Http\Controllers\AdminDev\SvgPngController::class, 'GenerateKarpel'])->name('generate.karpel');
    Route::get('generate-nisn', [\App\Http\Controllers\AdminDev\SvgPngController::class, 'GenerateNisn'])->name('generate.nisn');
    Route::get('generate-nisn-array', [\App\Http\Controllers\AdminDev\SvgPngController::class, 'GenerateNisnArray'])->name('generate.nisn.array');
    Route::get('generate-cocard', [\App\Http\Controllers\AdminDev\SvgPngController::class, 'GenerateCoCard'])->name('generate.cocard');
    Route::get('generate-sertifikat', [\App\Http\Controllers\AdminDev\SvgPngController::class, 'GenerateSertifikat'])->name('generate.sertifikat');

    Route::resource('control-program', \App\Http\Controllers\AdminDev\ControlMenuController::class)->middleware(['auth', 'verified']);
    Route::resource('data-kerjasama', \App\Http\Controllers\Paket\Kerjasama\DataKerjasamaController::class)->middleware(['auth', 'verified']);
    Route::resource('harga-paket', \App\Http\Controllers\Paket\Kerjasama\HargaPaketController::class)->middleware(['auth', 'verified']);
});

//Kerjasama
Route::middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->prefix('kerjasama')->group(
    function () {
        // php artisan make:view JurnalMengajar
        Route::resource('adm-buku', \App\Http\Controllers\Paket\Kerjasama\BukuAdmController::class)->middleware(['auth', 'verified']);
        // Route::get('buku-wali-kelas', [App\Http\Controllers\Paket\Kerjasama\BukuAdmController::class, 'BukuWaliKelas'])->name('buku.wali.kelas');
        Route::POST('buku-wali-kelas-cetak', [App\Http\Controllers\Paket\Kerjasama\BukuAdmController::class, 'BukuWaliKelasCetak'])->name('buku.wali.kelas.cetak');
        // Route::get('buku-wali-kelas-landscape', [App\Http\Controllers\Paket\Kerjasama\BukuAdmController::class, 'BukuWaliKelas'])->name('buku.wali.kelas');
        // Route::get('buku-wali-kelas-potrait', [App\Http\Controllers\Paket\Kerjasama\BukuAdmController::class, 'BukuWaliKelasPotrait'])->name('buku.wali.kelas.potrait');
        Route::get('buku-guru', [App\Http\Controllers\Paket\Kerjasama\BukuAdmController::class, 'BukuGuru'])->name('buku.guru');
        Route::get('buku-kepala', [App\Http\Controllers\Paket\Kerjasama\BukuAdmController::class, 'BukuKepala'])->name('buku.kepala');
        Route::get('buku-uks', [App\Http\Controllers\Paket\Kerjasama\BukuAdmController::class, 'BukuUks'])->name('buku.uks');
        Route::get('buku-piket', [App\Http\Controllers\Paket\Kerjasama\BukuAdmController::class, 'BukuPiket'])->name('buku.piket');
        Route::get('buku-induk', [App\Http\Controllers\Paket\Kerjasama\BukuAdmController::class, 'BukuInduk'])->name('buku.induk');
        Route::get('buku-catatan-siswa', [App\Http\Controllers\Paket\Kerjasama\BukuAdmController::class, 'BukuCatatanSiswa'])->name('buku.catatan.siswa');
        Route::POST('buku-rapat', [App\Http\Controllers\Paket\Kerjasama\BukuAdmController::class, 'BukuRapat'])->name('buku.rapat');
        Route::get('buku-sertifikat', [App\Http\Controllers\Paket\Kerjasama\BukuAdmController::class, 'bukusertifikat'])->name('buku.sertifikat');
        Route::get('/cetak-buku/{id}', [App\Http\Controllers\Paket\Kerjasama\BukuAdmController::class, 'exportWord'])->name('cetak.buku');
        Route::POST('/master-dokumen', [App\Http\Controllers\Paket\Kerjasama\BukuAdmController::class, 'masterDokumen'])->name('master.dokumen');
    }
);