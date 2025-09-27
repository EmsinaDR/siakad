<?php

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Whatsapp\WhatsApp;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use App\Models\User\Siswa\Detailsiswa;

/*
        |--------------------------------------------------------------------------
        | 📌 Auto_Reply_OperatorHelper :
        |--------------------------------------------------------------------------
        |
        | Fitur :
        | - xxxxxxxxxxx
        | - xxxxxxxxxxx
        |
        | Tujuan :
        | - xxxxxxxxxxx
        |
        | Penggunaan :
        | - xxxxxxxxxxx
        |
    */

// Proses Coding
if (!function_exists('Auto_Reply_OperatorHelper')) {
    function Auto_Reply_OperatorHelper($Kode, $NoRequest, $message)
    {
        // TODO: Implement your helper logic here
        // Khusus Operator
        $baris = preg_replace("/\r\n|\n|\r/", "/", $message);
        if (!config('whatsappSession.WhatsappDev')) {
            //$sessions = getWaSession($siswa->tingkat_id); // by tingkat ada di dalamnya
            //$sessions = config('whatsappSession.IdWaUtama');
            //$NoTujuan = getNoTujuanOrtu($siswa)
            // $NoTujuan = $NoRequest;
        } else {
            $sessions = config('whatsappSession.IdWaUtama');
            $NoRequest = config('whatsappSession.DevNomorTujuan');
        }
        $sessions = config('whatsappSession.IdWaUtama');
        switch (ucfirst($Kode)) {
            case 'Tester':
                //Tester / Guru / Kode Guru / xxxxxxxxxx
                $isiPesan =
                    "isikiriman\n" .
                    "{$baris}\n" .
                    " \n ";
                $pesanKiriman = format_pesan('Data Link Website Saat Ini', $isiPesan);
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                break;
            case 'Info Nomor Bantuan':
                //Tester / Guru / Kode Guru / xxxxxxxxxx
                $isiPesan =
                    "Berikut data No Bantuan yang bisa di isi :\n" .
                    "Bantuan 1 : PIP\n" .
                    "Bantuan 2 : KIP\n" .
                    "Bantuan 3 : Beasiswa Prestasi / Akademik\n" .
                    "Bantuan 4 : Program Khusus / Yayasan / CSR\n" .
                    "Bantuan 5 : -\n" .
                    " \n ";
                $pesanKiriman = format_pesan('Data Link Website Saat Ini', $isiPesan);
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                break;
            case 'Field Nomor Bantuan':
                //Case / Operator / nis
                //_____________________________________________________________________________________
                //Dump Pesan Wa
                $message = $baris;
                $keyMessage = 'Case / bagian / nis / no_think / kartu_bantuan_1 / kartu_bantuan_2 / kartu_bantuan_3 / kartu_bantuan_4 / kartu_bantuan_5';
                $dataPesan = combine_format_pesan($keyMessage, $message);
                // $pesan = [];
                // foreach ($dataPesan as $key => $value) {
                //     $pesan[$key] => $value;
                // }

                // foreach ($dataPesan as $key => $value) {
                //     $data[$key] = $value;
                // }

                // $datasiswa = Detailsiswa::where('nis', $data['nis'])->first()->toArray();
                $siswa = Detailsiswa::where('nis', $dataPesan['nis'])->first();
                // $siswa['kartu_bantuan_1'] = $dataPesan['kartu_bantuan_1'];
                $siswa->kartu_bantuan_1 = empty($dataPesan['kartu_bantuan_1']) ? null : $dataPesan['kartu_bantuan_1'];
                $siswa->save(); // simpan perubahan

                $data = array_merge($dataPesan);
                $pesan =
                    // "{json_encode($siswa}\n";
                    // "{json_encode($siswaArray)}\n";
                    // "{json_encode($dataPesan)}\n";
                    "{ddddddddd}\n" .
                    "{$dataPesan['nis']}\n" .
                    "xxxx\n";
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesan . "\n" . json_encode($siswa)  . "\n" .  json_encode($data));
                // return false;
                //_____________________________________________________________________________________
                $isiPesan =
                    "kartu_bantuan_1 : \n" .
                    "kartu_bantuan_2 : \n" .
                    "kartu_bantuan_3 : \n" .
                    "kartu_bantuan_4 : \n" .
                    "kartu_bantuan_5 : \n" .
                    " \n ";
                $pesanKiriman = format_pesan('Data Link Website Saat Ini', $isiPesan);
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $isiPesan);
                break;
            case 'Update Nomor Bantuan':
                //Tester / Guru / Kode Guru / xxxxxxxxxx
                $isiPesan =
                    "Berikut data No Bantuan yang bisa di isi :\n" .
                    "kartu_bantuan_1 : PIP\n" .
                    "kartu_bantuan_2 : KIP\n" .
                    "kartu_bantuan_3 : Beasiswa Prestasi / Akademik\n" .
                    "kartu_bantuan_4 : Program Khusus / Yayasan / CSR\n" .
                    "kartu_bantuan_5 : -\n" .
                    " \n ";
                $pesanKiriman = format_pesan('Data Link Website Saat Ini', $isiPesan);
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                break;
            case 'Update NB':
                //Tester / Guru / Kode Guru / xxxxxxxxxx
                // $message = "Case / bagian / 250001 / / kartu_bantuan_1:1000 / kartu_bantuan_2: / kartu_bantuan_3:500 / kartu_bantuan_4: / kartu_bantuan_5:200";
                $message = $message;
                $baris = preg_replace("/\r\n|\n|\r/", "/", $message);
                // $message = $baris;


                // 1️⃣ Split pesan per `/` lalu trim spasi
                $parts = array_map('trim', explode('/', $baris));
                // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $baris);

                // 2️⃣ Hapus 4 bagian pertama
                $kartuParts = array_slice($parts, 4);
                $siswa = Detailsiswa::where('nis', $parts[2])->first();
                foreach ($kartuParts as $k) {
                    if (str_contains($k, ':')) {
                        [$key, $value] = explode(':', $k, 2); //memecah string $k menjadi array maksimal 2 elemen, dipisahkan oleh tanda
                        $value = trim($value);
                        if ($value !== '') {
                            $siswa->{$key} = $value; // assign ke properti model
                        }
                    }
                }

                $siswa->save(); // baru simpan model

                // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, json_encode($kartuParts));


                $isiPesan =
                    "Berikut data No Bantuan yang bisa di isi :\n" .
                    "kartu_bantuan_1 : PIP\n" .
                    "kartu_bantuan_2 : KIP\n" .
                    "kartu_bantuan_3 : Beasiswa Prestasi / Akademik\n" .
                    "kartu_bantuan_4 : Program Khusus / Yayasan / CSR\n" .
                    "kartu_bantuan_5 :zzzzzzzzzzzz\n" .
                    "-\n" .
                    // "{$message}\n" .
                    // "json_encode($kartuData)-\n" .
                    " \n ";
                $pesanKiriman = format_pesan('Data Link Website Saat Ini', $isiPesan);
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                return $result;
                break;
            default:
                $pesanKiriman = "Kode Pesan anda *$Kode* Tidak ditemukan";
                break;
        }
    }
}
