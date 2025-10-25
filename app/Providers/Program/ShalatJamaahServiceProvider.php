<?php

namespace App\Providers\Program;

use Illuminate\Support\ServiceProvider;

class ShalatJamaahServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(base_path('routes/program/shalat-jamaah.php'));
    }
}