<?php

namespace App\Providers\Program;

use Illuminate\Support\ServiceProvider;

class PembinaOsisServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(base_path('routes/program/pembina-osis.php'));
    }
}