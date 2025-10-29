<?php

namespace App\Providers\Program;

use Illuminate\Support\ServiceProvider;

class DokumenSekolahServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(base_path('routes/program/dokumen-sekolah.php'));
    }
}