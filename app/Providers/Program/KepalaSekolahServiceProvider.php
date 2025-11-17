<?php

namespace App\Providers\Program;

use Illuminate\Support\ServiceProvider;

class KepalaSekolahServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(base_path('routes/program/kepala-sekolah.php'));
    }
}