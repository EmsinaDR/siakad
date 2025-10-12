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
        $srcFolder = public_path('img/dokumen-siswa/ijazah');   // folder sumber
        $outputFolder = public_path('img/dokumen-siswa/ijazah'); // folder output
        convertFolderJpgToPngAndBackupJpg($srcFolder, $outputFolder);
        // ijazah-sd
        $srcFolder = public_path('img/dokumen-siswa/ijazah-sd');   // folder sumber
        $outputFolder = public_path('img/dokumen-siswa/ijazah-sd'); // folder output
        convertFolderJpgToPngAndBackupJpg($srcFolder, $outputFolder);
        // ijazah-sd
        $srcFolder = public_path('img/dokumen-siswa/kk');   // folder sumber
        $outputFolder = public_path('img/dokumen-siswa/kk'); // folder output
        convertFolderJpgToPngAndBackupJpg($srcFolder, $outputFolder);
        // ktp-ortu
        $srcFolder = public_path('img/dokumen-siswa/ktp-ortu');   // folder sumber
        $outputFolder = public_path('img/dokumen-siswa/ktp-ortu'); // folder output
        convertFolderJpgToPngAndBackupJpg($srcFolder, $outputFolder);
        // skl
        $srcFolder = public_path('img/dokumen-siswa/skl');   // folder sumber
        $outputFolder = public_path('img/dokumen-siswa/skl'); // folder output
        convertFolderJpgToPngAndBackupJpg($srcFolder, $outputFolder);

        // akte
        $srcFolder = public_path('img/dokumen-siswa/akte');   // folder sumber
        $outputFolder = public_path('img/dokumen-siswa/akte'); // folder output
        convertFolderJpgToPngAndBackupJpg($srcFolder, $outputFolder);




        $this->info("Command 'ConverterJpgToPngCommand' berhasil dijalankan.");
    }
}
