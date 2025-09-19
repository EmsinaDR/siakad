<?php

namespace App\Console\Commands\System;

use Illuminate\Console\Command;

class SynGitHubCommand extends Command
{
    protected $signature = 'update:SynGitHub';
    protected $description = 'Sinkron kode dari GitHub ke local (cek update dulu, pull jika ada)';

    public function handle()
    {
        $this->info("Mulai sinkron GitHub...");

        $projectPath = base_path(); // folder project Laravel
        $repoUrl = 'git@github.com:username/repo.git'; // ganti dengan repo-mu
        $branch = 'main'; // ganti branch sesuai repo

        // // Jika repo belum ada, lakukan clone
        // if (!file_exists($projectPath . '/.git')) {
        //     $this->info("Repo belum ada, mulai clone...");
        //     exec("git clone -b {$branch} {$repoUrl} {$projectPath}", $output, $returnVar);
        //     $this->line(implode("\n", $output));

        //     if ($returnVar === 0) {
        //         $this->info("Clone selesai! Repo sudah siap digunakan.");
        //     } else {
        //         $this->error("Gagal clone repo. Cek URL atau koneksi.");
        //     }

        //     return $returnVar;
        // }

        // // Repo sudah ada → cek update dari GitHub
        // $this->info("Repo sudah ada, memeriksa update...");

        // // Ambil info terbaru dari remote
        // exec("cd {$projectPath} && git fetch origin {$branch}", $fetchOutput, $fetchReturn);

        // if ($fetchReturn !== 0) {
        //     $this->error("Gagal fetch dari GitHub. Cek koneksi atau branch.");
        //     return $fetchReturn;
        // }

        // // Cek apakah ada perbedaan
        // exec("cd {$projectPath} && git status -uno", $statusOutput, $statusReturn);

        // $statusText = implode("\n", $statusOutput);

        // if (strpos($statusText, 'up to date') !== false || strpos($statusText, 'up-to-date') !== false) {
        //     $this->info("Tidak ada update dari GitHub. Repo sudah up-to-date.");
        //     return 0;
        // }

        // // Ada update → lakukan pull
        // $this->info("Update tersedia, mulai pull...");
        // exec("cd {$projectPath} && git pull origin {$branch}", $pullOutput, $pullReturn);
        // $this->line(implode("\n", $pullOutput));

        // if ($pullReturn === 0) {
        //     $this->info("Sinkronisasi selesai! Semua update dari GitHub sudah diterapkan.");
        // } else {
        //     $this->error("Gagal melakukan pull dari GitHub. Cek koneksi atau branch.");
        // }

        // return $pullReturn;

        $sessions = config('whatsappSession.IdWaUtama');
        $NoRequest = config('whatsappSession.IdWaUtama');
        $pesan =
            "System update otomatisa telah dijalankan";

        $result = run_bat("executor\whatsapp\update.bat");
        $result = run_bat("executor\siakad\update.bat");
        $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Data Vendor', $pesan));
    }
}
