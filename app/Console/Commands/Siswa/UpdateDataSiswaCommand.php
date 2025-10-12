<?php

namespace App\Console\Commands\Siswa;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User\Siswa\Detailsiswa;

class UpdateDataSiswaCommand extends Command
{
    protected $signature = 'update:data-siswa';
    protected $description = 'Update data untuk siswa';

    public function handle()
    {
        // $SiswaInArray = [
        //     ['nis' => 240001, 'tanggal_lahir' => '15/08/2012'],
        //     ['nis' => 240002, 'tanggal_lahir' => '25/03/2012'],
        //     ['nis' => 240003, 'tanggal_lahir' => '11/07/2012'],
        //     ['nis' => 240004, 'tanggal_lahir' => '24/01/2012'],
        //     ['nis' => 240005, 'tanggal_lahir' => '15/06/2013'],
        //     ['nis' => 240006, 'tanggal_lahir' => '26/02/2009'],
        //     ['nis' => 240007, 'tanggal_lahir' => '05/05/2011'],
        //     ['nis' => 240008, 'tanggal_lahir' => '18/03/2012'],
        //     ['nis' => 240009, 'tanggal_lahir' => '09/05/2012'],
        //     ['nis' => 240010, 'tanggal_lahir' => '17/03/2012'],
        //     ['nis' => 240011, 'tanggal_lahir' => '13/12/2011'],
        //     ['nis' => 240012, 'tanggal_lahir' => '19/10/2011'],
        //     ['nis' => 240013, 'tanggal_lahir' => '02/03/2012'],
        //     ['nis' => 240014, 'tanggal_lahir' => '23/09/2011'],
        //     ['nis' => 240015, 'tanggal_lahir' => '29/04/2012'],
        //     ['nis' => 240016, 'tanggal_lahir' => '23/04/2012'],
        //     ['nis' => 240017, 'tanggal_lahir' => '02/02/2011'],
        //     ['nis' => 240018, 'tanggal_lahir' => '18/11/2011'],
        //     ['nis' => 240019, 'tanggal_lahir' => '16/03/2011'],
        //     ['nis' => 240062, 'tanggal_lahir' => '21/03/2012'],
        //     ['nis' => 240020, 'tanggal_lahir' => '19/11/2011'],
        //     ['nis' => 240021, 'tanggal_lahir' => '18/08/2012'],
        //     ['nis' => 240022, 'tanggal_lahir' => '02/06/2011'],
        //     ['nis' => 240023, 'tanggal_lahir' => '06/10/2012'],
        //     ['nis' => 240024, 'tanggal_lahir' => '20/04/2012'],
        //     ['nis' => 240025, 'tanggal_lahir' => '15/10/2012'],
        //     ['nis' => 240026, 'tanggal_lahir' => '12/11/2011'],
        //     ['nis' => 240027, 'tanggal_lahir' => '03/10/2011'],
        //     ['nis' => 240028, 'tanggal_lahir' => '18/06/2012'],
        //     ['nis' => 240029, 'tanggal_lahir' => '04/05/2012'],
        //     ['nis' => 240063, 'tanggal_lahir' => '00/01/1900'],
        //     ['nis' => 240064, 'tanggal_lahir' => '23/03/2011'],
        //     ['nis' => 240067, 'tanggal_lahir' => '28/08/2011'],
        //     ['nis' => 240031, 'tanggal_lahir' => '26/03/2012'],
        //     ['nis' => 240032, 'tanggal_lahir' => '31/07/2012'],
        //     ['nis' => 240033, 'tanggal_lahir' => '20/12/2012'],
        //     ['nis' => 240034, 'tanggal_lahir' => '03/01/2011'],
        //     ['nis' => 240035, 'tanggal_lahir' => '28/02/2012'],
        //     ['nis' => 240037, 'tanggal_lahir' => '09/12/2011'],
        //     ['nis' => 240038, 'tanggal_lahir' => '26/04/2012'],
        //     ['nis' => 4462, 'tanggal_lahir' => '13/03/2011'],
        //     ['nis' => 240066, 'tanggal_lahir' => '28/01/2010'],
        //     ['nis' => 240040, 'tanggal_lahir' => '26/06/2012'],
        //     ['nis' => 240041, 'tanggal_lahir' => '11/01/2012'],
        //     ['nis' => 240000, 'tanggal_lahir' => '21/06/2012'],
        //     ['nis' => 240043, 'tanggal_lahir' => '02/02/2012'],
        //     ['nis' => 240044, 'tanggal_lahir' => '26/04/2012'],
        //     ['nis' => 240045, 'tanggal_lahir' => '16/09/2013'],
        //     ['nis' => 240046, 'tanggal_lahir' => '28/05/2012'],
        //     ['nis' => 240047, 'tanggal_lahir' => '21/11/2011'],
        //     ['nis' => 240048, 'tanggal_lahir' => '06/02/2012'],
        //     ['nis' => 240050, 'tanggal_lahir' => '22/02/2011'],
        //     ['nis' => 240051, 'tanggal_lahir' => '08/10/2011'],
        //     ['nis' => 240052, 'tanggal_lahir' => '26/01/2012'],
        //     ['nis' => 240053, 'tanggal_lahir' => '03/01/2012'],
        //     ['nis' => 240065, 'tanggal_lahir' => '19/09/2011'],
        //     ['nis' => 2365, 'tanggal_lahir' => '10/11/2011'],
        //     ['nis' => 240054, 'tanggal_lahir' => '30/08/2012'],
        //     ['nis' => 240055, 'tanggal_lahir' => '01/12/2011'],
        //     ['nis' => 240056, 'tanggal_lahir' => '27/12/2012'],
        //     ['nis' => 240057, 'tanggal_lahir' => '13/02/2012'],
        //     ['nis' => 240058, 'tanggal_lahir' => '05/07/2012'],
        //     ['nis' => 240059, 'tanggal_lahir' => '17/09/2012'],
        //     ['nis' => 240060, 'tanggal_lahir' => '07/01/2012'],
        //     ['nis' => 240061, 'tanggal_lahir' => '05/05/2012'],


        // ];
        // foreach ($SiswaInArray as $Data):
        //     // dd(format_tanggal_lahir($Data['tanggal_lahir']));
        //     $Siswa = Detailsiswa::where('nis', $Data['nis'])->first();
        //     $Siswa->update(
        //         [
        //             'nama_siswa' => ucwords($Siswa->nama_siswa),
        //             'tanggal_lahir' => format_tanggal_lahir($Data['tanggal_lahir']),
        //             'tempat_lahir' => ucwords($Siswa->tempat_lahir),
        //         ]

        //     );
        //     $this->info("Command 'UpdateDataSiswaCommand' berhasil dijalankan. {$Data['nis']}\n");
        // // dd(Carbon::create($Siswa->tanggal_lahir)->translatedformat('l, d F Y'));
        // endforeach;
        // $SiswaInArray = Detailsiswa::get();
        // foreach ($SiswaInArray as $Data):
        //     // dd(format_tanggal_lahir($Data['tanggal_lahir']));
        //     $Siswa = Detailsiswa::where('nis', $Data['nis'])->first();
        //     $Siswa->update(
        //         [
        //             'nik' => str_replace("'", "", $Data->nik)
        //         ]

        //     );
        //     $this->info("Command 'UpdateDataSiswaCommand' berhasil dijalankan. {$Data->nik}\n");
        // // dd(Carbon::create($Siswa->tanggal_lahir)->translatedformat('l, d F Y'));
        // endforeach;


        // reset data

        // Hapus user dengan id > 20
        // User::where('id', '>', 20)->delete();

        // // // Hapus semua siswa
        // // Detailsiswa::truncate(); // lebih aman daripada delete() + reset AUTO_INCREMENT
        // DB::statement('ALTER TABLE users AUTO_INCREMENT = 16');
        // // DB::statement('ALTER TABLE detailsiswas AUTO_INCREMENT = 1');


        // // // Hapus semua siswa
        // // Detailsiswa::delete(); // atau DB::table('detailsiswas')->delete();

        // // // Reset AUTO_INCREMENT manual
        // // DB::statement('ALTER TABLE detailsiswas AUTO_INCREMENT = 1');


        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Detailsiswa::truncate(); // sekarang bisa
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Akhir reset Data


        $this->info("Command 'UpdateDataSiswaCommand' berhasil dijalankan.\n");
        // dd(Carbon::create($Siswa->tanggal_lahir)->translatedformat('l, d F Y'));


        // kirim karpel ke siswa
        $Siswas = Detailsiswa::with('KelasOne')->limit(5)->get();
        foreach ($Siswas as $siswa) {
            $sessions = 'GuruId';
            $filename = $siswa->nis . '.png';
            // CopyFileWa($filename, 'img/siswa')
            $cek = CopyFileWa($filename, 'img/karpel/' . $siswa->KelasOne->kelas);
            $filePath = base_path('whatsapp/uploads/' . $filename);
            $caption =
                "Mohon cek data karpel dan foto sudah benar atau belum";
            // dd($cek, $filePath);
            // $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $number, $caption, $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
            $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, '6285329860005', $caption, $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
        }


        $this->info("Command 'UpdateDataSiswaCommand' berhasil dijalankan. {}");
    }
}
