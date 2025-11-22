<?php

namespace App\Providers\Program;

use Illuminate\Support\ServiceProvider;

class TemplateDokumenServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(base_path('routes/program/template-dokumen.php'));
    }
}