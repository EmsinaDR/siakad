<?php

use Carbon\Carbon;
use App\Models\Whatsapp\WhatsApp;
use Faker\Factory as Faker;
use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use App\Models\Absensi\Eabsen;
use App\Models\Admin\Identitas;
use Illuminate\Database\Seeder;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Http;
use App\Models\User\Siswa\Detailsiswa;
use App\Models\Bendahara\BendaharaTabungan;
use App\Models\Program\Tahfidz\RiwayatHafalanTahfidz;
use App\Models\WakaKesiswaan\Ekstra\Ekstra;
use App\Models\WakaKesiswaan\Ekstra\PesertaEkstra;
use App\Models\WakaKesiswaan\Ekstra\RiwayatEkstra;

// $Identitas = Identitas::first();

if (!function_exists('PesanDataSiswa')) {
    function PesanDataSiswa($id) // AutoReply_SiswaHelper
    {
        $faker = Faker::create(); //Simpan didalam code run
        $Identitas = Identitas::first();
        $Siswa = Detailsiswa::with('Detailsiswatokelas')->find($id);
        if (!$Siswa) {
            return ['status' => 'error', 'message' => '❌ Data siswa tidak ditemukan'];
        }
        $Kami = $faker->randomElement(['Kami', 'Sekolah']);
        $Ucapkan = $faker->randomElement(['ucapkan', 'haturkan', 'sampaikan']);
        $Menyampaikan = $faker->randomElement(['menyampaikan', 'informasikan', 'beritahukan']);
        $Disiplin = $faker->randomElement(['disiplin waktu', 'disiplin', 'tepat waktu']);
        $nama = $Siswa->nama_siswa ?? '*Tidak Terisi*';
        $nis = $Siswa->nis ?? '*Tidak Terisi*';
        $nisn = $Siswa->nisn ?? '*Tidak Terisi*';
        $alamat_siswa = $Siswa->alamat_siswa ?? '*Tidak Terisi*';
        $rt = $Siswa->rt ?? '*Tidak Terisi*';
        $rw = $Siswa->rw ?? '*Tidak Terisi*';
        $desa = $Siswa->desa ?? '*Tidak Terisi*';
        $tempat_lahir = $Siswa->tempat_lahir ?? '*Tidak Terisi*';
        $tanggal_lahir = Carbon::create($Siswa->tanggal_lahir)->translatedformat('d F Y');
        $nohp_siswa = $Siswa->nohp_siswa ?? '*Tidak Terisi*';

        $ayah_nama = $Siswa->ayah_nama ?? '*Tidak Terisi*';
        $ayah_pekerjaan = $Siswa->ayah_pekerjaan ?? '*Tidak Terisi*';
        $ayah_nohp = $Siswa->ayah_nohp ?? '*Tidak Terisi*';

        $ibu_nama = $Siswa->ibu_nama ?? '*Tidak Terisi*';
        $ibu_pekerjaan = $Siswa->ibu_pekerjaan ?? '*Tidak Terisi*';
        $ibu_nohp = $Siswa->ibu_nohp ?? '*Tidak Terisi*';


        $kelas = optional($Siswa->Detailsiswatokelas)->kelas ?? '-';
        $tanggal = Carbon::now()->translatedformat('l, d F Y');
        $jam = $Siswa->created_at->translatedFormat('H:i:s');
        $message =
            "==================================\n" .
            "📌 *Data Siswa*\n" .
            "==================================\n\n" .
            "📝 Nama\t\t\t\t: $nama\n" .
            "🏫 Kelas\t\t\t\t: $kelas\n" .
            "🎓 NIS\t\t\t\t\t: $nis\n" .
            "🎓 NISN\t\t\t\t\t: $nisn\n" .
            "📅 Tempat & Tanggal Lahir\t: $tempat_lahir, $tanggal_lahir\n" .
            "🏡 Alamat\t\t\t\t: $alamat_siswa\n" .
            "📍 RT\t\t\t\t\t: $rt\n" .
            "📍 RW\t\t\t\t\t: $rw\n" .
            "🏘️ Desa\t\t\t\t: $desa\n" .
            "📱 No HP\t\t\t\t: $nohp_siswa\n" .
            "==================================\n\n" .
            "📌 *Data Ayah*\n" .
            "==================================\n\n" .
            "👨 Nama Ayah\t\t\t: $ayah_nama\n" .
            "💼 Pekerjaan Ayah\t\t: $ayah_pekerjaan\n" .
            "📞 Nomor HP Ayah\t\t: $ayah_nohp\n" .
            "==================================\n\n" .
            "📌 *Data Ibu*\n" .
            "==================================\n\n" .
            "👩 Nama Ibu\t\t\t: $ibu_nama\n" .
            "💼 Pekerjaan Ibu\t\t: $ibu_pekerjaan\n" .
            "📞 Nomor HP Ibu\t\t: $ibu_nohp\n" .
            "==================================\n" .
            "\n" . str_repeat("─", 25) . "\n" .
            "✍️ Dikirim oleh:\n" .
            "   *Boot Assiten Pelayanan {$Identitas->namasek}*\n";

        return $message;
    }
}


// Pesan Ekstra
if (!function_exists('PesanEkstra')) {
    function PesanEkstra($id) // AutoReply_SiswaHelper
    {
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $Identitas = Identitas::first();
        //$etapels->id
        //where('tapel_id', $etapels->id)->
        $Ekstras = RiwayatEkstra::where('tapel_id', $etapels->id)->get();
        // $Ekstras = Ekstra::get();
        if (!$Ekstras) {
            return 'Data tidak ditemukan';
        }
        $pesanKiriman =
            "==================================\n" .
            "📌 *Data Jadwal Ekstra Siswa*\n" .
            "==================================\n\n";

        $pesanKiriman .=
            "*Assalamualaikum Wr.Wb*\n" .
            "Berikut kami sampaikan data *jadwal ekstra* yang tersedia :\n\n";
        foreach ($Ekstras as $index => $ekstra) {
            $datake = $index + 1;
            $pesanKiriman .=
                // "==================================\n" .
                "📌 *Jadwal Ekstrakurikuler Ke-{$datake}*\n" .
                "🏫 Nama Ekstra\t\t\t: {$ekstra->Ekstra->ekstra}\n" .
                "👨‍🏫 Pembina\t\t\t\t\t: {$ekstra->Detailguru->nama_guru},{$ekstra->Detailguru->gelar}\n" .
                "🤾‍♂️ Pelatih\t\t\t\t\t\t: {$ekstra->pelatih}\n" .
                "📅 Hari\t\t\t\t\t\t\t\t: {$ekstra->jadwal}\n" .
                "⏰ Jam\t\t\t\t\t\t\t\t: -\n" .
                "==================================\n\n";
        }

        // Fetch Data Eksrta
        // $Siswa = DataSIswa($nis);
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $PesertaEkstra = PesertaEkstra::with('Siswa', 'EkstraNew')
            ->where('tapel_id', $etapels->id)
            ->where('detailsiswa_id', $id)
            ->get();

        if ($PesertaEkstra->isNotEmpty()) {
            $namaSiswa = $PesertaEkstra->first()->Siswa->nama_siswa;
            $listEkstra = $PesertaEkstra->pluck('EkstraNew.ekstra')->filter()->toArray();

            $pesanKiriman .= "Kami sampaikan beberapa ekstra yang diikuti *Ananda {$namaSiswa}* saat ini :\n";
            foreach ($listEkstra as $ekstra) {
                $pesanKiriman .= "- {$ekstra}\n";
            }
            $pesanKiriman .= "*Catatan :*\nUntuk jadwal bisa dilihat dari daftar diatas.\n";
        } else {
            // Misalnya ambil nama siswa dari DetailSiswa langsung
            $namaSiswa = DetailSiswa::find($id)?->nama_siswa ?? 'Siswa';
            $pesanKiriman .= "Mohon maaf, *Ananda {$namaSiswa}* saat ini tidak mengikuti kegiatan ekstra apapun.\n";
            $pesanKiriman .= "Kami sangat berharap *Ananda {$namaSiswa}* aktif dalam kegiatan sekolah untuk mengembangkan minat dan bakatnya.\n";
        }

        $pesanKiriman .=
            "\nTerima kasih atas keaktifannya dalam penggunaan layanan sekolah dan pemantaun putra/putri.\n" .
            "*Wassalamualaikum Wr.Wb*\n\n";
        $pesanKiriman .=
            "\n" . str_repeat("─", 25) . "\n" .
            "✍️ Dikirim oleh:\n" .
            "   *Boot Assiten Pelayanan {$Identitas->namasek}*\n";

        return $pesanKiriman;
    }
}

if (!function_exists('JumlahSiswa')) {
    function JumlahSiswa($id = null) // AutoReply_SiswaHelper
    {
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $Identitas = Identitas::first();

        // Ambil semua data siswa yang sudah digabung dengan relasi kelasOne
        $kelasList = Detailsiswa::with('kelasOne')
            ->orderBy('kelas_id')
            ->where('status_siswa', 'aktif')
            ->whereNotNull('kelas_id')
            ->get()
            ->groupBy('kelas_id');

        $pesanKiriman =
            "==================================\n" .
            "📌 *Rekap Jumlah Siswa per Kelas*\n" .
            "==================================\n\n";

        foreach ($kelasList as $kelasId => $siswaPerKelas) {
            $Wali_kelas = $siswaPerKelas->first()->kelasOne->Guru->nama_guru;
            $namaKelas = $siswaPerKelas->first()->kelasOne->kelas ?? 'Tidak diketahui';
            $jumlah = $siswaPerKelas->whereNotNull('kelas_id')->where('status_siswa', 'aktif')->count();
            $countYatim = $siswaPerKelas->where('status_yatim_piatu', 'yatim')->count();
            $countPiatu = $siswaPerKelas->where('status_yatim_piatu', 'Piatu')->count();
            $countYatimPiatu = $siswaPerKelas->where('status_yatim_piatu', 'Yatim Piatu')->count();
            // Hitung jumlah laki-laki dan perempuan
            $jumlahL = $siswaPerKelas->where('jenis_kelamin', 'Laki-laki')->count();
            $jumlahP = $siswaPerKelas->where('jenis_kelamin', 'Perempuan')->count();

            $pesanKiriman .=
                "🏫 Kelas\t\t\t\t\t\t\t: {$namaKelas}\n" .
                "👨‍🏫 Wali Kelas\t\t\t\t: {$Wali_kelas}\n" .
                "👥 Total Siswa\t\t\t: {$jumlah}\n" .
                "🧑‍🦱 Laki-laki\t\t\t\t\t\t: {$jumlahL}\n" .
                "👩 Perempuan\t\t\t: {$jumlahP}\n" .
                "👩 Yatim\t\t\t\t\t\t\t: {$countYatim}\n" .
                "👩  Piatu\t\t\t\t\t\t\t: {$countPiatu}\n" .
                "👩 Yatim Piatu\t\t\t: {$countYatimPiatu}\n" .
                "\n" . str_repeat("─", 25) . "\n\n";
        }
        $TotalSiswa = Detailsiswa::with('kelasOne')
            ->where('status_siswa', 'aktif')
            ->whereNotNull('kelas_id')
            ->orderBy('kelas_id')
            ->get();
        $SiswaL = $TotalSiswa->where('jenis_kelamin', 'Laki-laki')->count();
        $SiswaP = $TotalSiswa->where('jenis_kelamin', 'Perempuan')->count();
        $TotalFull = $SiswaL + $SiswaP;
        $pesanKiriman .=
            "==================================\n" .
            "📌 *Rekap Jumlah Siswa Total*\n" .
            "==================================\n\n" .
            "🧑‍🦱 Laki-laki\t\t\t\t\t\t: {$SiswaL}\n" .
            "👩 Perempuan\t\t\t: {$SiswaP}\n" .
            "👩 Total \t\t\t\t\t\t\t: {$TotalFull}\n";
        $pesanKiriman .=
            "\n" . str_repeat("─", 25) . "\n" .
            "✍️ Dikirim oleh:\n" .
            "   *Boot Asisten Pelayanan {$Identitas->namasek}*\n";

        return $pesanKiriman;
    }
}


if (!function_exists('KodeGuru')) {
    function KodeGuru()
    {
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $Identitas = Identitas::first();
        // Kode Guru
        $DataGuru = Detailguru::whereNotIn('id', [1, 2, 3])->get();
        $pesanKiriman =
            "==================================\n" .
            "📌 *Data Guru*\n" .
            "==================================\n\n";

        foreach ($DataGuru as $Index => $Guru) {
            $No = $Index + 1;
            $pesanKiriman .=
                "==================================\n" .
                "📌 *Data Guru : Ke {$No}*\n" .
                "🏫 Nama \t\t\t: {$Guru->nama_guru}, {$Guru->gelar}\n" .
                "👨‍🏫 kode_guru\t\t: {$Guru->kode_guru}\n" .
                "==================================\n\n";
        }
        $pesanKiriman .=
            "\n" . str_repeat("─", 25) . "\n" .
            "✍️ Dikirim oleh:\n" .
            "   *Boot Assiten Pelayanan {$Identitas->namasek}*\n";

        return $pesanKiriman;
    }
}
if (!function_exists('DataKodeGuru')) {
    function DataKodeGuru($id)
    {
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $Identitas = Identitas::first();
        // Kode Guru
        $DataGuru = Detailguru::where('id', $id)->first();
        $tmt = tglall($DataGuru->tmt_mengajar, 'long');
        $LamaMengajar = date('Y') - Carbon::create($DataGuru->tmt_mengajar)->translatedformat('Y');
        $tglLahir = tglall($DataGuru->tanggal_lahir, 'long');
        $umurGuru = umurGuru($DataGuru->tanggal_lahir);
        $pesanKiriman =
            "==============================\n" .
            "📌 *Data Guru*\n" .
            "==============================\n\n" .
            "📛 Nama : {$DataGuru->nama_guru}, {$DataGuru->gelar}\n" .
            "🆔 NIP : {$DataGuru->nip}\n" .
            "🆔 NUPTK : {$DataGuru->nuptk}\n" .
            "📱 No HP : {$DataGuru->no_hp}\n" .
            "📆 Tahun Sertifikasi : {$DataGuru->tahun_sertifikasi}\n" .
            "🏫 TMT Mengajar : $tmt\n" .
            "📊 Status : {$DataGuru->status}\n" .
            "⏳ Lama Mengajar : {$LamaMengajar} th\n" .
            "📍 Alamat : {$DataGuru->alamat}\n" .
            "📍 Tempat : {$DataGuru->tempat_lahir}\n" .
            "🎂 Tanggal Lahir : {$tglLahir}\n" .
            "📈 Usia : {$umurGuru} Tahun\n" .
            "🎓 Pendidikan : {$DataGuru->pendidikan}\n" .
            "📚 Jurusan : {$DataGuru->jurusan}\n" .
            "📚 Lulusan : {$DataGuru->lulusan}\n" .

            "\n" . str_repeat("─", 25) . "\n" .
            "✍️ Dikirim oleh:\n" .
            "*Boot Assistant Pelayanan {$Identitas->namasek}*";


        return $pesanKiriman;
    }
}
if (!function_exists('format_pesan')) {
    function format_pesan($title, $isi)
    {
        //Isi Fungsi

        $Identitas = Identitas::first();
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $pesan =
            "==============================\n" .
            "📌 *{$title}*\n" .
            "==============================\n\n" .
            "*Assalamu'alaikum Wr.Wb.*\n" .
            $isi .
            "\n\n" .
            "*Wassalamu'alaikum Wr.Wb.*\n" .
            "\n" . str_repeat("─", 25) . "\n" .
            "✍️ Dikirim oleh:\n" .
            "*Boot Assistant Pelayanan {$Identitas->namasek}*";
        return $pesan;
    }
}
if (!function_exists('format_pesan_gb')) {
    function format_pesan_gb($title, $isi)
    {
        //Isi Fungsi

        $Identitas = Identitas::first();
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $pesan =
            "==========================\n" .
            "📌 *{$title}*\n" .
            "==========================\n\n" .
            "*Assalamu'alaikum Wr.Wb.*\n" .
            $isi .
            "\n\n" .
            "*Wasssalamu'alaikum Wr.Wb.*\n" .
            "\n" . str_repeat("─", 20) . "\n" .
            "✍️ Dikirim oleh:\n" .
            "*Boot Assistant Pelayanan {$Identitas->namasek}*";
        return $pesan;
    }
}
if (!function_exists('format_pesan_media')) {
    function format_pesan_media($title, $isi)
    {
        //Isi Fungsi

        $Identitas = Identitas::first();
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $pesan =
            "==========================\n" .
            "📌 *{$title}*\n" .
            "==========================\n\n" .
            "*Assalamu'alaikum Wr.Wb.*\n" .
            $isi .
            "\n\n" .
            "*Wasssalamu'alaikum Wr.Wb.*\n" .
            "\n" . str_repeat("─", 20) . "\n" .
            "✍️ Dikirim oleh:\n" .
            "*Boot Assistant Pelayanan {$Identitas->namasek}*";
        return $pesan;
    }
}
if (!function_exists('format_pesan_group')) {
    function format_pesan_group($title, $isi)
    {
        //Isi Fungsi

        $Identitas = Identitas::first();
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $pesan =
            "\n" . str_repeat("=", 20) . "\n" .
            "📌 *{$title}*" .
            "\n" . str_repeat("=", 20) . "\n\n" .
            "*Assalamu'alaikum Wr.Wb.*\n" .
            $isi .
            "\n" .
            "*Wasssalamu'alaikum Wr.Wb.*\n" .
            "\n" . str_repeat("─", 20) . "\n" .
            "✍️ Dikirim oleh:\n" .
            "*Boot Assistant Pelayanan {$Identitas->namasek}*";
        return $pesan;
    }
}

if (!function_exists('Perpustakaan_Pengembalian_Buku')) {
    function Perpustakaan_Pengembalian_Buku($peminjaman)
    {

        $Identitas = Identitas::first();
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //Isi Fungsi
        $pesanKiriman =

            "==============================\n" .
            "📌 *Data Perpustakaan*\n" .
            "==============================\n\n" .
            "*Assalamu'alaikum Wr.Wb.*\n" .
            "Diberitahukan kepada *Anada {$peminjaman->siswa->nama_siswa}* jangan lupa besok pagi adalah jadwal pengembalian *buku {$peminjaman->buku->judul_buku}*. \nDimohon ananda *{$peminjaman->siswa->nama_siswa}* untuk mempersiapkan buku secepatnya agar tidak lupa.\n" .
            "Atas perhatiannya, disampaikan terima kasih.\n" .

            "*Wasssalamu'alaikum Wr.Wb.*\n" .
            "\n" . str_repeat("─", 25) . "\n" .
            "✍️ Dikirim oleh:\n" .
            "*Boot Assistant Pelayanan {$Identitas->namasek}*";

        return $pesanKiriman;
    }
}
if (!function_exists('pengingat_ekstra')) {
    function pengingat_ekstra($PesertaInEkstra, $data)
    {
        //Isi Fungsi
        $pesanKiriman =
            "================================\n" .
            "📌 *INFORMASI EKSTRAKURIKULER*\n" .
            "================================\n\n" .
            "*Assalamu'alaikum Wr.Wb.*\n" .
            "Kami informasikan untuk *Ananda {$PesertaInEkstra->Siswa->nama_siswa}* merupakan anggota *Ekstra {$PesertaInEkstra->EkstraNew->ekstra}* dan hari ini *{$data['hari']}* ada jadwal latihan rutin dengan informasi ekstra :\n\n" .
            "📚 Nama Ekstra\t\t\t : {$PesertaInEkstra->EkstraNew->ekstra}\n" .
            "⏰ Jam\t\t\t\t\t\t\t\t : Sesuai Jadwal\n" .
            "👨‍🏫 Nama Pembina\t : {$data['pembina']}\n" .
            "🏅 Nama Pelatih\t\t : {$data['pelatih']}\n\n" .
            "Demikian informasi yang dapat kami sampaikan, jika ada perubahan akan kami informasikan segera. \nAtas segala perhatian dan kerjasamanya kami sampaikan banyak terima kasih.\n\n" .
            "*Wassalamu'alaikum Wr.Wb.*\n" .
            "\n" . str_repeat("─", 25) . "\n" .
            "✍️ Dikirim oleh: " .
            "*Boot Assistant Pelayanan {$data['nama_sekolah']}*";
        return $pesanKiriman;
    }
}
if (!function_exists('riwayat_tahfidz')) {
    function riwayat_tahfidz($Siswa)
    {
        $riwayats = RiwayatHafalanTahfidz::with('surat')
            ->where('detailsiswa_id', $Siswa->id)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->unique('surat_id'); // Ambil 1 surat sekali saja

        // $pesanKiriman = "📢 *Riwayat Hafalan Tahfidz Ananda {$Siswa->nama_siswa}* :\n\n";
        $pesanKiriman = "Berikut ini, kami sampaikan informasi riwayat tahfidz *Ananda {$Siswa->nama_siswa}* dalam mengikuti program disekolah :\n\n";

        foreach ($riwayats as $riwayat) {
            $pesanKiriman .= "📖 Surat\t\t\t: {$riwayat->surat->arab}\n";
            $pesanKiriman .= "📝 Ayat\t\t\t\t: {$riwayat->ayat}\n\n";
        }

        $pesanKiriman .= "✨ Dengan keaktifan *Ananda {$Siswa->nama_siswa}* dalam program Tahfidz di sekolah, semoga menjadi bekal Dunia dan Akhirat bagi Ananda dan keluarga. Aamiin 🙏\n\n";
        $pesanKiriman .= "🤝 Kami menghimbau orang tua wali, khususnya wali dari *Ananda {$Siswa->nama_siswa}*, untuk terus memberikan suport dan dukungan agar Ananda terus aktif dalam kegiatan.\n\n";
        $pesanKiriman .= "🙏 Atas segala perhatian dan kerjasamanya, kami ucapkan banyak terima kasih.\n";

        return $pesanKiriman;
    }
}


// if (!function_exists('DataWaliKelas')) {
//     function DataWaliKelas()
//     {
//         $etapels = Etapel::where('aktiv', 'Y')->first();
//         $Identitas = Identitas::first();
//         // Kode Guru
//         $kelasList = Ekelas::with('Guru')->where('tapel_id', $etapels->id)->get();

//         $pesanKiriman =
//             "==============================\n" .
//             "📌 *Data Guru*\n" .
//             "==============================\n\n";
//         foreach ($kelasList as $kelasId => $siswaPerKelas) {
//             $namaKelas = $siswaPerKelas->first()->kelasOne->kelas ?? 'Tidak diketahui';
//             $jumlah = $siswaPerKelas->whereNotNull('kelas_id')->where('status_siswa', 'aktif')->count();

//             // Hitung jumlah laki-laki dan perempuan
//             $jumlahL = $siswaPerKelas->where('jenis_kelamin', 'Laki-laki')->count();
//             $jumlahP = $siswaPerKelas->where('jenis_kelamin', 'Perempuan')->count();

//             $pesanKiriman .=
//                 "🏫 Kelas\t\t\t\t\t\t\t: {$namaKelas}\n" .
//                 "👥 Total Siswa\t\t\t: {$jumlah}\n" .
//                 "🧑‍🦱 Laki-laki\t\t\t\t\t\t: {$jumlahL}\n" .
//                 "👩 Perempuan\t\t\t: {$jumlahP}\n" .
//                 "\n" . str_repeat("─", 25) . "\n\n";
//         };


//             "\n" . str_repeat("─", 25) . "\n" .
//             "✍️ Dikirim oleh:\n" .
//             "*Boot Assistant Pelayanan {$Identitas->namasek}*";


//         return $pesanKiriman;
//     }
// }
if (!function_exists('registerNoHp')) {
    function registerNoHp($Siswa, $message, $NoRequest)
    {
        $pesan = explode('/', $message);
        $DataHp = isset($pesan[3]) ? explode(':', $pesan[3]) : [];

        if (count($DataHp) < 3) {
            return 'Format data HP tidak sesuai';
        }

        $DataSiswa = Detailsiswa::where('nis', $Siswa->nis)->first();
        if (!$DataSiswa) {
            return 'Maaf anda tidak berhak mengisi dan mengirim data ini';
        }
        if ($NoRequest === config('whatsappSession.DevNomorTujuan')) {

            $HpSiswa = format_no_hp($DataHp[0]);
            $HpAyah   = format_no_hp($DataHp[1]);
            $HpIbu    = format_no_hp($DataHp[2]);

            // Hanya update kalau kosong/null kalau sudah ada isinya tidak akan berubah
            $DataSiswa->update([
                'nohp_siswa' => $DataSiswa->nohp_siswa ?: $HpSiswa,
                'ayah_nohp'  => $DataSiswa->ayah_nohp  ?: $HpAyah,
                'ibu_nohp'   => $DataSiswa->ibu_nohp   ?: $HpIbu,
            ]);

            return 'Data Sudah tersimpan';
        }

        if ($NoRequest !== $DataSiswa->nohp_siswa) {
            $noGuru = Detailguru::where('no_hp', $NoRequest)->exists();
            if (!$noGuru) {
                return 'Maaf anda tidak berhak mengisi dan mengirim data ini';
            }

            $HpSiswa = format_no_hp($DataHp[0]);
            $HpAyah = format_no_hp($DataHp[1]);
            $Hpibu = format_no_hp($DataHp[2]);
            $DataSiswa->update([
                'nohp_siswa' => $HpSiswa,
                'ayah_nohp' => $HpSiswa,
                'ibu_nohp' => $Hpibu,
            ]);

            return 'Data Sudah tersimpan';
        }

        return 'Nomor sudah terdaftar atau tidak ada perubahan';
    }
}
