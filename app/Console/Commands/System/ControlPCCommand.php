<?php

namespace App\Console\Commands\System;

use Illuminate\Console\Command;

class ControlPCCommand extends Command
{
    protected $signature = 'contro:control-pc';
    protected $description = 'Mengatur server restart, shutdown';

    public function handle()
    {
        $this->info("Command 'ControlPCCommand' berhasil dijalankan.");
    }
}