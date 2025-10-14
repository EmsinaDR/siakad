<?php

namespace App\Console\Commands\System;

use Illuminate\Console\Command;

class UpdateSiakadCommand extends Command
{
    protected $signature = 'update:siakad';
    protected $description = 'Update siakad from server';

    public function handle()
    {
        run_bat("executor\siakad\update.exe");
        $this->info("Command 'UpdateSiakadCommand' berhasil dijalankan.");
    }
}
