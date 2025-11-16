<?php

namespace App\Console\Commands\System;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Exception; // 🔥 ini penting!
class CekaTabelDatabaseCommand extends Command
{
    protected $signature = 'Cek:tabel-database';
    protected $description = 'Menampilkan daftar tabel dan field dalam database beserta tipe datanya';

    public function handle()
    {
        // $tables = list_tables();

        // if (empty($tables)) {
        //     $this->error("Tidak ada tabel ditemukan di database.");
        //     return;
        // }

        // $this->info("📋 Daftar Tabel & Field di Database:");
        // $this->line(str_repeat('-', 70));

        // foreach ($tables as $table) {
        //     $this->info("🧱 Tabel: {$table}");

        //     $fields = list_fields($table);

        //     if (!empty($fields)) {
        //         // Loop field => type
        //         foreach ($fields as $field => $type) {
        //             $this->line("   - {$field} ({$type})");
        //         }
        //     } else {
        //         $this->warn("   (Tidak ada field ditemukan)");
        //     }

        //     $this->line(str_repeat('-', 70));
        // }

        // $this->newLine();
        // $this->comment("✅ Command 'Cek:tabel-database' selesai dijalankan.");

        $tableName = 'detailsiswas';
        $fieldName = 'ayah_tempat_lahir';
        $detailsiswa = cek_tabel($tableName);
        $detailsiswa = cek_field($tableName, $fieldName);
        if ($detailsiswa) {
            $this->comment("✅ Tabel Ada");
        } else {

            $this->comment("✅ Tidak Tabel Ada");
        }

        // Perbaiki auto Increament
        // $tables = list_tables(); // pakai helper Bro
        // $bar = $this->output->createProgressBar(count($tables));
        // $bar->start();

        // foreach ($tables as $table) {
        //     try {
        //         // Cek apakah tabel punya kolom id
        //         if (!Schema::hasColumn($table, 'id')) {
        //             $bar->advance();
        //             continue;
        //         }

        //         // Cek apakah kolom id sudah auto_increment
        //         $info = DB::selectOne("
        //             SELECT EXTRA
        //             FROM INFORMATION_SCHEMA.COLUMNS
        //             WHERE TABLE_SCHEMA = DATABASE()
        //             AND TABLE_NAME = ?
        //             AND COLUMN_NAME = 'id'
        //         ", [$table]);

        //         $isAuto = isset($info->EXTRA) && str_contains($info->EXTRA, 'auto_increment');

        //         if (!$isAuto) {
        //             DB::statement("
        //                 ALTER TABLE `{$table}`
        //                 MODIFY `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
        //             ");
        //             $this->line("\n✔ Kolom id di tabel `{$table}` diperbaiki.");
        //         }
        //     } catch (Exception $e) {
        //         $this->warn("\n⚠ Gagal di tabel `{$table}`: {$e->getMessage()}");
        //     }

        //     $bar->advance();
        // }

        // $bar->finish();
        // $this->info("\n\n✅ Selesai perbaiki auto_increment semua tabel.");
        // return Command::SUCCESS;

        $hasil = fix_auto_ids();

        if ($hasil) {
            echo "✅ Kolom ID berhasil diperbaiki di tabel:\n";
            foreach ($hasil as $t) echo " - {$t}\n";
        } else {
            echo "🎉 Semua tabel sudah OK.\n";
        }
    }
}
