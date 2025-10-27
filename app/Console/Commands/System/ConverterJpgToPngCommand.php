<?php

namespace App\Console\Commands\System;

use Illuminate\Console\Command;

class ConverterJpgToPngCommand extends Command
{
    protected $signature = 'convert:jpg-to-png';
    protected $description = 'Merubah jpg ke png system siakad';

    public function handle()
    {

        // ===== Contoh penggunaan =====

        // Ijazah
        $srcFolder = public_path('img/siswa/ijazah');
        $outputFolder = public_path('img/siswa/ijazah');
        $this->info("📂 Memproses folder: img/siswa/ijazah");
        convertFolderJpgToPngAndBackupJpg($srcFolder, $outputFolder);

        // Ijazah SD
        $srcFolder = public_path('img/siswa/ijazah-sd');
        $outputFolder = public_path('img/siswa/ijazah-sd');
        $this->info("📂 Memproses folder: img/siswa/ijazah-sd");
        convertFolderJpgToPngAndBackupJpg($srcFolder, $outputFolder);

        // KK
        $srcFolder = public_path('img/siswa/kk');
        $outputFolder = public_path('img/siswa/kk');
        $this->info("📂 Memproses folder: img/siswa/kk");
        convertFolderJpgToPngAndBackupJpg($srcFolder, $outputFolder);

        // KTP ORTU (sementara nonaktif karena ada bug)
        $this->info("⚠️ Folder ktp-ortu dilewati sementara (ada duplikasi file).");
        // $srcFolder = public_path('img/siswa/ktp-ortu');
        // $outputFolder = public_path('img/siswa/ktp-ortu');
        // $this->info("📂 Memproses folder: img/siswa/ktp-ortu");
        // convertFolderJpgToPngAndBackupJpg($srcFolder, $outputFolder);

        // SKL
        $srcFolder = public_path('img/siswa/skl');
        $outputFolder = public_path('img/siswa/skl');
        $this->info("📂 Memproses folder: img/siswa/skl");
        convertFolderJpgToPngAndBackupJpg($srcFolder, $outputFolder);

        // AKTE
        $srcFolder = public_path('img/siswa/akte');
        $outputFolder = public_path('img/siswa/akte');
        $this->info("📂 Memproses folder: img/siswa/akte");
        convertFolderJpgToPngAndBackupJpg($srcFolder, $outputFolder);

        $this->info("✅ Semua folder sudah diproses.");





        $this->info("Command 'ConverterJpgToPngCommand' berhasil dijalankan.");
    }
}
