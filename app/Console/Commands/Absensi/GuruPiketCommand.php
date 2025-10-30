<?php

namespace App\Console\Commands\Absensi;

use Carbon\Carbon;
use App\Models\GuruPiket;
use App\Models\Admin\Ekelas;
use App\Models\Absensi\Eabsen;
use Illuminate\Console\Command;
use App\Models\Whatsapp\WhatsApp;
use App\Models\Walkes\JadwalPiket;
use App\Models\User\Guru\Detailguru;
use App\Models\User\Siswa\Detailsiswa;

class GuruPiketCommand extends Command
{
    protected $signature = 'absensi:guru-piket';
    protected $description = 'Data guru piket sebagai pengingat absensi';

    public function handle()
    {
        // $senin =

        $Identitas = getIdentitas();
        $hari = strtolower(Carbon::now()->locale('id')->isoFormat('dddd'));

        if ($Identitas->paket === 'Premium') {
            $guruPiket = GuruPiket::with('guru')->where('hari', $hari)->get();
        } else {
            if (is_day('senin')) {
                $kodeGuruPiket = ['JM', 'SA'];
            } elseif (is_day('selasa')) {
                $kodeGuruPiket = ['DT', 'NQ'];
            } elseif (is_day('rabu')) {
                $kodeGuruPiket = ['ER', 'UN'];
            } elseif (is_day('kamis')) {
                $kodeGuruPiket = ['MA', 'CY'];
            } elseif (is_day('jumat')) {
                $kodeGuruPiket = ['IM', 'SZ'];
            } elseif (is_day('sabtu')) {
                $kodeGuruPiket = ['IZ'];
            } else {
                $kodeGuruPiket = [];
            }

            $guruPiket = Detailguru::whereIn('kode_guru', $kodeGuruPiket)->get();
        }

        // dd($Identitas->paket, $hari, $kodeGuruPiket ?? null, $guruPiket);

        // $eabsen = Eabsen::with('EabsentoDetailsiswa')
        //     ->whereDate('created_at', now())
        //     ->pluck('detailsiswa_id');
        $jenisAbsen = 'masuk';
        $eabsen = Eabsen::whereDate('waktu_absen', Carbon::today())
            ->where('jenis_absen', $jenisAbsen)
            ->pluck('detailsiswa_id')
            ->toArray();
        $siswaTidakAbsen = Detailsiswa::with('kelasOne')
            ->where('status_siswa', 'aktif')
            ->whereNotIn('id', $eabsen)
            ->get()
            ->groupBy(fn($siswa) => $siswa->kelasOne->kelas ?? 'Tidak Ada Kelas');
        // dd($eabsen);

        $namaSiswa = '';

        foreach ($siswaTidakAbsen as $kelas => $daftarSiswa) {
            $namaSiswa .= "🏫 *Kelas {$kelas}*\n";

            foreach ($daftarSiswa as $siswa) {
                $namaSiswa .= "- {$siswa->nama_siswa} -> {$siswa->id}\n";
            }

            $namaSiswa .= "\n"; // spasi antar kelas
        }
        foreach ($guruPiket as $piket):
            $nama = $piket->{$Identitas->paket === 'Premium' ? 'guru->nama_guru' : 'nama_guru'};
            $PesanIkiramn =
                "Mohon Bapak / Ibu {$nama} membantu kontrol siswa hari ini yang belum melakukan absensi digital dikelas sebelum pukul 08:30 WIB bersama guru di jam pelajaran pertama\n" .
                "Berikut Informasi Daftar Nama Siswa :\n" .
                "{$namaSiswa}\n" .
                "Kami sampaikan banyak Terima Kasih atas partisipasi dan kerjasamanya.\n";
            $sessions = config('whatsappSession.IdWaUtama');
            if (!config('whatsappSession.WhatsappDev')) {
                $NoTujuan = $piket->{$Identitas->paket === 'Premium' ? 'guru->no_hp' : 'no_hp'};;
            } else {
                $NoTujuan = config('whatsappSession.DevNomorTujuan');
            }
            $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, format_pesan('Informasi Guru Piket', $PesanIkiramn));
            $this->info("{$PesanIkiramn}");
        // $this->info("Command 'Guru Piket Hari {$PesanIkiramn}' berhasil dijalankan. Data: ");
        endforeach;

        // Guru Jam Pertama

        $kode_kelas = 1;

        // Definisikan jadwal guru per hari dan per kelas

        /*
        Guru Jam Pertama :
            senin :  7A : IZ, 7B : NA, 8a: AH, 8b: RA, 9: NQ
            Rabu : 7a: SA, 7b: AU, 8a: RA, 8b: UN, 9: AS
            Kamis : 7a: JM, 7b: Ah, 8a: cy, 8b: AU, 9: ER
            Jum'at : 7a: Er, 7b: jm, 8a: IM, 8b: dt, 9: RA
            Sabtu : 7a: sz, 7b: iz, 8a: jm, 8b: NQ, 9: ah
        */
        $jadwalHari = [
            // senin :  7A : IZ, 7B : NA, 8a: AH, 8b: RA, 9: NQ
            'senin' => [
                ['kode_kelas' => $kode_kelas,     'kode_guru' => ['IZ']],
                ['kode_kelas' => $kode_kelas + 1, 'kode_guru' => ['NA']],
                ['kode_kelas' => $kode_kelas + 2, 'kode_guru' => ['AH']],
                ['kode_kelas' => $kode_kelas + 3, 'kode_guru' => ['RA']],
                ['kode_kelas' => $kode_kelas + 4, 'kode_guru' => ['NQ']],
            ],
            // selasa : 7a: Sz, 7b: SA, 8a: NA, 8b: Jm, 9: IM
            'selasa' => [
                ['kode_kelas' => $kode_kelas,     'kode_guru' => ['SZ']],
                ['kode_kelas' => $kode_kelas + 1, 'kode_guru' => ['SA']],
                ['kode_kelas' => $kode_kelas + 2, 'kode_guru' => ['NA']],
                ['kode_kelas' => $kode_kelas + 3, 'kode_guru' => ['JM']],
                ['kode_kelas' => $kode_kelas + 4, 'kode_guru' => ['IM']],
            ],
            // Rabu : 7a: SA, 7b: AU, 8a: RA, 8b: UN, 9: AS
            'rabu' => [
                ['kode_kelas' => $kode_kelas,     'kode_guru' => ['SA']],
                ['kode_kelas' => $kode_kelas + 1, 'kode_guru' => ['AU']],
                ['kode_kelas' => $kode_kelas + 2, 'kode_guru' => ['RA']],
                ['kode_kelas' => $kode_kelas + 3, 'kode_guru' => ['UN']],
                ['kode_kelas' => $kode_kelas + 4, 'kode_guru' => ['AS']],
            ],
            // Kamis : 7a: JM, 7b: Ah, 8a: cy, 8b: AU, 9: ER
            'kamis' => [
                ['kode_kelas' => $kode_kelas,     'kode_guru' => ['JM']],
                ['kode_kelas' => $kode_kelas + 1, 'kode_guru' => ['Ah']],
                ['kode_kelas' => $kode_kelas + 2, 'kode_guru' => ['CY']],
                ['kode_kelas' => $kode_kelas + 3, 'kode_guru' => ['AU']],
                ['kode_kelas' => $kode_kelas + 4, 'kode_guru' => ['ER']],
            ],
            // Jum 'at : 7a: Er, 7b: jm, 8a: IM, 8b: dt, 9: RA
            'jumat' => [
                ['kode_kelas' => $kode_kelas,     'kode_guru' => ['ER']],
                ['kode_kelas' => $kode_kelas + 1, 'kode_guru' => ['JM']],
                ['kode_kelas' => $kode_kelas + 2, 'kode_guru' => ['IM']],
                ['kode_kelas' => $kode_kelas + 3, 'kode_guru' => ['DT']],
                ['kode_kelas' => $kode_kelas + 4, 'kode_guru' => ['RA']],
            ],
            // Sabtu : 7a: sz, 7b: iz, 8a: jm, 8b: NQ, 9: ah
            'sabtu' => [
                ['kode_kelas' => $kode_kelas,     'kode_guru' => ['SZ']],
                ['kode_kelas' => $kode_kelas + 1, 'kode_guru' => ['IZ']],
                ['kode_kelas' => $kode_kelas + 2, 'kode_guru' => ['JM']],
                ['kode_kelas' => $kode_kelas + 3, 'kode_guru' => ['NQ']],
                ['kode_kelas' => $kode_kelas + 4, 'kode_guru' => ['AH']],
            ],
        ];

        // Ambil hari ini dalam bahasa Indonesia (pastikan fungsi is_day bekerja dengan lowercase)
        $hariIni = strtolower(now()->locale('id')->translatedFormat('l'));

        if (is_day('senin')) {
            $jadwalHariIni = $jadwalHari['senin'];
        } elseif (is_day('selasa')) {
            $jadwalHariIni = $jadwalHari['selasa'];
        } elseif (is_day('rabu')) {
            $jadwalHariIni = $jadwalHari['rabu'];
        } elseif (is_day('kamis')) {
            $jadwalHariIni = $jadwalHari['kamis'];
        } elseif (is_day('jumat')) {
            $jadwalHariIni = $jadwalHari['jumat'];
        } elseif (is_day('sabtu')) {
            $jadwalHariIni = $jadwalHari['sabtu'];
        } else {
            $jadwalHariIni = [];
        }

        foreach ($jadwalHariIni as $jadwal) {
            $kodeKelas = $jadwal['kode_kelas'];
            $kodeGurus = $jadwal['kode_guru'];

            $GuruPertama = Detailguru::whereIn('kode_guru', $kodeGurus)->get();
            $kelas = Ekelas::find($kodeKelas);

            foreach ($GuruPertama as $guru) {
                $siswaTidakAbsen = Detailsiswa::with('kelasOne')
                    ->where('status_siswa', 'aktif')
                    ->whereNotIn('id', $eabsen)
                    ->where('kelas_id', $kelas->id)
                    ->get();

                $namaSiswa = $siswaTidakAbsen->pluck('nama_siswa')->implode("\n- ");
                $namaSiswa = $namaSiswa ? "- " . $namaSiswa : "(Semua siswa sudah absen 🎉)";

                $PesanIkiramn =
                    "Mohon Bapak/Ibu *{$guru->nama_guru}* membantu kontrol siswa hari ini " .
                    "yang belum melakukan absensi digital di kelas *{$kelas->kelas}* sebelum pukul 08:30 WIB.\n\n" .
                    "*Daftar siswa belum absen:*\n{$namaSiswa}\n\n" .
                    "_Terima kasih atas partisipasi dan kerjasamanya._";

                $sessions = config('whatsappSession.IdWaUtama');


                if (!config('whatsappSession.WhatsappDev')) {
                    $NoTujuan = $piket->{$Identitas->paket === 'Premium' ? 'guru->no_hp' : 'no_hp'};;
                } else {
                    $NoTujuan = config('whatsappSession.DevNomorTujuan');
                }

                \App\Models\Whatsapp\WhatsApp::sendMessage(
                    $sessions,
                    $NoTujuan,
                    format_pesan('Informasi Guru Piket', $PesanIkiramn)
                );

                $this->info("Pesan dikirim ke {$guru->nama_guru} ({$NoTujuan}) untuk kelas {$kelas->kelas}\n {$namaSiswa}");
            }
        }

        $this->info("Command Guru Piket selesai dijalankan untuk hari " . strtoupper($hariIni ?? '???'));
        $this->info("Command Guru Piket selesai dijalankan untuk hari {$hariIni}.");

        $this->info("Command 'Guru Piket' berhasil dijalankan.");
    }
}
