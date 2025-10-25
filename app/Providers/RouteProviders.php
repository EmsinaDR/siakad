<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteProviders extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->routes(function () {
            $admin = 1;
            Route::middleware('web')->group(base_path('routes/web.php'));
            if ($admin === 1) {
                Route::middleware('web')->group(base_path('routes/webx.php'));
            }
            Route::middleware('web')->group(base_path('routes/program/whatsapp.php'));
            $datamodul = \App\Models\AdminDev\Modul::where('is_active', 1)->get();
            foreach ($datamodul as $dm) {
                // dd($dm->slug);
                Route::middleware('web')->group(base_path('routes/program/' . $dm->slug . '.php'));
            }
        });
    }
}

            // Route::middleware('web')->group(base_path('routes/program/perpustakaan.php')); // 👈 load file tambahan
            // Route::middleware('web')->group(base_path('routes/program/bk.php'));
            // Route::middleware('web')->group(base_path('routes/program/bendahara/komite.php'));
            // Route::middleware('web')->group(base_path('routes/program/bendahara/bos.php'));
            // Route::middleware('web')->group(base_path('routes/program/bendahara/tabungan.php'));

            // Route::middleware('web')->group(base_path('routes/program/laboratorium.php'));
            // Route::middleware('web')->group(base_path('routes/program/ekstrakurikuler.php'));
            // Route::middleware('web')->group(base_path('routes/program/walikelas.php'));
            // Route::middleware('web')->group(base_path('routes/vendor/atadev.php'));
            // Route::middleware('web')->group(base_path('routes/program/absensi.php'));
            // Route::middleware('web')->group(base_path('routes/program/admin.php'));
            // Route::middleware('web')->group(base_path('routes/program/admindev.php'));
            // Route::middleware('web')->group(base_path('routes/program/tools.php'));
            // Route::middleware('web')->group(base_path('routes/program/bukutamu.php'));
            // Route::middleware('web')->group(base_path('routes/program/dokumentasi.php'));
            // Route::middleware('web')->group(base_path('routes/program/whatsapp.php'));
            // Route::middleware('web')->group(base_path('routes/program/rapat.php'));
            // Route::middleware('web')->group(base_path('routes/program/wakakurikikulum.php'));
            // Route::middleware('web')->group(base_path('routes/program/waka/wakakurikikulum.php'));
            // Route::middleware('web')->group(base_path('routes/program/waka/wakakesiswaan.php'));
            // Route::middleware('web')->group(base_path('routes/program/waka/wakasarpras.php'));
            // Route::middleware('web')->group(base_path('routes/program/ppdb.php'));
            // Route::middleware('web')->group(base_path('routes/program/kelulusan.php'));
            // Route::middleware('web')->group(base_path('routes/program/info-aplikasi.php'));
            // Route::middleware('web')->group(base_path('routes/program/surat.php'));
            // Route::middleware('web')->group(base_path('routes/api.php'));
            // $this->loadRoutesFrom(base_path('routes/program/bk.php'));
            // $this->loadRoutesFrom(base_path('routes/program/bendahara/komite.php'));
            // $this->loadRoutesFrom(base_path('routes/program/bendahara/bos.php'));
            // $this->loadRoutesFrom(base_path('routes/program/bendahara/tabungan.php'));

            // $this->loadRoutesFrom(base_path('routes/program/laboratorium.php'));
            // $this->loadRoutesFrom(base_path('routes/program/ekstrakurikuler.php'));
            // $this->loadRoutesFrom(base_path('routes/program/walikelas.php'));
            // $this->loadRoutesFrom(base_path('routes/vendor/atadev.php'));
            // $this->loadRoutesFrom(base_path('routes/program/absensi.php'));
            // $this->loadRoutesFrom(base_path('routes/program/admin.php'));
            // $this->loadRoutesFrom(base_path('routes/program/tools.php'));
            // $this->loadRoutesFrom(base_path('routes/program/bukutamu.php'));
            // $this->loadRoutesFrom(base_path('routes/program/dokumentasi.php'));
            // $this->loadRoutesFrom(base_path('routes/program/whatsapp.php'));
            // $this->loadRoutesFrom(base_path('routes/program/rapat.php'));
            // $this->loadRoutesFrom(base_path('routes/program/wakakurikikulum.php'));
            // $this->loadRoutesFrom(base_path('routes/program/waka/wakakurikikulum.php'));
            // $this->loadRoutesFrom(base_path('routes/program/waka/wakakesiswaan.php'));
            // $this->loadRoutesFrom(base_path('routes/program/waka/wakasarpras.php'));
            // $this->loadRoutesFrom(base_path('routes/program/ppdb.php'));
            // $this->loadRoutesFrom(base_path('routes/program/kelulusan.php'));
            // $this->loadRoutesFrom(base_path('routes/api.php'));