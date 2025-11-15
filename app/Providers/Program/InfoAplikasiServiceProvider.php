<?php

namespace App\Providers\Program;

use Illuminate\Support\ServiceProvider;

class InfoAplikasiServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(base_path('routes/program/info-aplikasi.php'));
    }
}