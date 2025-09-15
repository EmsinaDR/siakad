<?php

namespace App\Providers\Program;

use Illuminate\Support\ServiceProvider;

class BukuTamuServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(base_path('routes/program/buku-tamu.php'));
    }
}