<?php

namespace App\Console\Commands\System;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RessetAndReseed extends Command
{
    protected $signature = 'db:reset-seed';
    protected $description = 'Menghapus isi tabel dan menjalankan ulang seeder';

    public function handle()
    {
        $this->info('Disabling foreign key checks...');
        Schema::disableForeignKeyConstraints();

        $this->info('Truncating all tables...');

        // Ambil semua nama tabel di database aktif (MySQL)
        $tables = DB::select('SHOW TABLES');
        $dbName = DB::getDatabaseName();
        $tableKey = 'Tables_in_' . $dbName;

        foreach ($tables as $tableObj) {
            $table = $tableObj->$tableKey;
            DB::table($table)->truncate();
            $this->line("✔ Truncated table: $table");
        }

        $this->info('Re-enabling foreign key checks...');
        Schema::enableForeignKeyConstraints();

        $this->info('Running seeders...');
        try {
            $this->call('db:seed');
            $this->info('✅ Seeder sukses!');
        } catch (\Throwable $e) {
            $this->error('❌ Seeder gagal: ' . $e->getMessage());
        }

        return 0;
    }
}
