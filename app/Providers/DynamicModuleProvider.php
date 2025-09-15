<?php

namespace App\Providers;

use App\Models\AdminDev\Modul;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class DynamicModuleProvider extends ServiceProvider
{
    public function register()
    {
        // Simpan modul aktif sebagai singleton (lazy)
        $this->app->singleton('modul-loader', function () {
            return Modul::where('is_active', 1)->get();
        });
    }

    public function boot()
    {
        if (Schema::hasTable('modul')) {
            $modular = Modul::where('is_active', 1)->get();

            foreach ($modular as $mod) {
                $mdlr = str_replace('-', '', strtolower($mod->modul));
                $routePath = base_path("routes/program/{$mod->modul}.php");

                if (file_exists($routePath)) {
                    $this->loadRoutesFrom($routePath);
                }
            }
        }
    }
}


/*



php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear
cls



php artisan migrate:fresh --seed


composer dump-autoload

*/