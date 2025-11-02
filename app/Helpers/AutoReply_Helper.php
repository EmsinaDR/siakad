<?php

use App\Models\Admin\Identitas;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Whatsapp\WhatsApp;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use App\Models\User\Siswa\Detailsiswa;

/*
        |--------------------------------------------------------------------------
        | 📌 AutoReply_Helper :
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
function Indetitas()
{
    return Identitas::first();
}

if (!function_exists('HelpPesan')) {
    function HelpPesan($message, $NoRequest)
    {
        $Identitas = Indetitas(); // ambil data identitas sekali panggil di sini
        // $Guru = Detailguru::where('no_hp', $NoRequest)->first();
        // if (!config('whatsappSession.WhatsappDev')) {
        //     //$sessions = getWaSession($siswa->tingkat_id); // by tingkat ada di dalamnya
        //     //$sessions = config('whatsappSession.IdWaUtama');
        //     //$NoTujuan = getNoTujuanOrtu($siswa)
        //     $NoTujuan = $Guru->no_hp;
        // } else {
        //     $sessions = config('whatsappSession.IdWaUtama');
        //     $NoTujuan = config('whatsappSession.DevNomorTujuan');
        // }
        // $DevNomor = config('whatsappSession.DevNomorTujuan');
        // if ($NoRequest !== $DevNomor) {
        //     if (!$Guru || $NoRequest !== $Guru->no_hp) {
        //         // Cek No Ortu
        //         $NoOrtu = getAllNoHpSiswa();
        //         if (!in_array($NoRequest, $NoOrtu)) {
        //             WhatsApp::sendMessage($sessions, $NoRequest, "Maaf anda tidak diijinkan akses disini");
        //             return false;
        //         }
        //         return true; // ✅ kalau valid ortu, izinkan
        //     }
        //     return true; // ✅ kalau valid guru, izinkan
        // }
        $paket = $Identitas->paket;
        switch ($message) {
            case 'Assalamu\'alaikum':
                $pesanKiriman =
                    "*Waalaikumussalam Wr.Wb*\n" .
                    "Mohon maaf ada yang bisa dibantu???\n" .
                    "Silahkan tuliskan pesan sesuai format yang ditentukan\n" .
                    "*Terima Kasih*\n" .
                    "\n";
                return format_pesan('Jawaban', $pesanKiriman);
                break;
            case 'Selamat Pagi':
                $pesanKiriman =
                    "*Selamat Pagi Juga*\n" .
                    "Mohon maaf ada yang bisa dibantu???\n" .
                    "Silahkan tuliskan pesan sesuai format yang ditentukan\n" .
                    "*Terima Kasih*\n" .
                    "\n";
                return format_pesan('Jawaban', $pesanKiriman);
                break;

            case 'Help':
                $pesanKiriman =  "" .
                    "Informasi bantuan :\n" .
                    "- Help Guru\n" .
                    "- Help Siswa\n" .
                    "- Help Operator\n" .
                    "- Help Surat\n" .
                    // "- Help Ijin\n" .
                    // "- Help Dokumen\n" .
                    "- Help Pencarian\n" .
                    "- Help Control\n" .
                    "- Help Kepala\n" .
                    "- Help Ekstrakurikuler ( _Premium Only_ )\n" .
                    "- Help Elearning ( _Premium Only_ )\n" .
                    "- Help PPDB ( _Premium Only_ )\n" .
                    "- Help BK ( _Premium Only_ )\n" .
                    "- Help Perpustakaan ( _Premium Only_ )\n" .
                    "- Help Pembayaran Siswa ( _Premium Only_ )\n" .
                    "\n";
                return format_pesan('INFORMASI HELP', $pesanKiriman);
                break;
            case 'Help Kepala':
                $pesanKiriman =  "" .
                    "Informasi bantuan :\n" .
                    "- Laporan Absensi/Kepala\n" .
                    "- EAG/Kepala/Kode Guru/Bulan\n" .
                    "- EAGS/Kepala/array_kode_guru/Bulan\n" .
                    "- LABG/Kepala/Kode Guru/Bulan\n" .
                    "\t\tLABG/Kepala/Kode Guru.\n\t\tArtinya bulan ini\n" .
                    "\t\tBulan 1 -9\n" .
                    "- Absen Now/Kepala/Kode Guru/absen/Keterangan\n" .
                    "- Wali Kelas / Kepala\n" .
                    "- Guru Piket / Kepala\n" .
                    "\n";
                return format_pesan('INFORMASI HELP KEPALA', $pesanKiriman);
                break;
            case 'Help Database':
                $pesanKiriman =  "" .
                    "Informasi bantuan :\n" .
                    "- Save/nis/\n" .
                    "\n";
                return format_pesan('INFORMASI HELP DATABASE', $pesanKiriman);
                break;
            case 'Help Surat':
                // FiturPaket($paket, $NoRequest);
                $pesanKiriman =  "" .
                    "*Surat Aktif*\n" .
                    "Surat Aktif\t\t\t\t\t:Surat Aktif/Surat/nis/format/keperluan\n" .
                    "Contoh\t\t\t\t\t\t\t: Surat Aktif/Surat/nis/jpg/keperluan\n\n" .
                    "Format\t\t\t\t\t\t\t: jpg / pdf\n\n" .
                    "\n" . str_repeat("─", 25) . "\n" .

                    "*Surat Ijin* : Belum tersedia\n" .
                    "Surat Aktif\t\t\t\t\t: Surat Ijin/NIS/Tujuan\n" .
                    "Contoh\t\t\t\t\t\t\t: Surat Ijin/NIS/Lomba Cerdas Cermat\n" .
                    "\n" . str_repeat("─", 25) . "\n" .

                    "*Surat Pindah* : \n" .
                    "Surat Pindah\t\t\t\t\t: Surat Pindah / Surat / NIS / sekolah tujuan / alamat sekolah tujuan/alasan pindah\n" .
                    "Contoh\t\t\t\t\t\t\t: Surat Pindah/Surat/2025001/SMP N 1 Cirebon/Jl. Cendrawasih No 145 Gang Merdeka/Mengikuti pindah domisili orang tua\n" .
                    "\n" . str_repeat("─", 25) . "\n" .

                    "*Surat Tidak Mampu* : \n" .
                    "Surat Tidak Mampu\t\t\t\t\t: Surat Tidak Mampu / Surat / nis / keperluan\n" .
                    "Contoh\t\t\t\t\t\t\t: Surat Tidak Mampu / Surat / 2025001 / Pendaftaran beasiswa pendidikan\n" .
                    "\n" . str_repeat("─", 25) . "\n" .

                    "*Surat Home Visit* : \n" .
                    "Surat Home Visit\t\t\t\t\t: Surat Home Visit/Surat/Kode Guru/Jabatan/NIS/tujuan/Tanggal Datang/Jam Datang\n" .
                    "Contoh\t\t\t\t\t\t\t: Surat Home Visit/Surat/DR/Wali Kelas/2025001/Kehadiran dan Keaktifan Siswa/2/08:00 WIB\n" .
                    "Tanggal Datang : 2 artinya 2 hari kedepan\n" .
                    "\n" . str_repeat("─", 25) . "\n" .

                    "*Surat Panggilan* : \n" .
                    "Surat Panggilant\t\t\t\t\t: Surat Panggilan/Surat/kode guru waka/kode wali kelas/NIS/keperluan/+Hari/Waktu/\n" .
                    "Contoh\t\t\t\t\t\t\t: Surat Panggilan/Surat/CA/CA/NIS/keperluan/+Hari/Waktu/\n" .
                    "Tanggal Datang : 2 artinya 2 hari kedepan\n" .
                    "\n" .
                    "*Surat Custom Via Template Sekolah :*\n" .
                    "*Home Visit* : \n" .
                    "Home Visit Custom / Surat / 2025:SPPD / 2 / AS:DR / Guru BK:Wali Kelas / 2 / 08:30 / Rumah Siswa / 250001 / Ya#No\n\n" .
                    "*Surat SPPD* : \n" .
                    "Surat SPPD Custom / Surat / 225:SPPD / 2 / kode_guru / jabatan_guru / tempat_tujuan / tanggal_berangkat / tanggal_pulang / kendaraan / tujuan_perjalanan\n\n" .
                    "*Surat Tugas* : \n" .
                    "*Surat Penerimaan Pindah* : \nSurat Penerimaan Pindah / Surat / nomor_surat / tgl_surat / nama_siswa / tempat_tanggal_lahir / kelas / alamat_siswa\n\n" .
                    "*Surat Ket PIP* : \n" .
                    "*Surat Aksioma* : \n" .
                    "\n";
                return format_pesan('INFORMASI HELP SURAT', $pesanKiriman);
                break;
            case 'Help Dokumen':
                $pesanKiriman =  "" .
                    "*Dokumen Rapat*\n" .
                    "Surat Rapat\t\t\t\t\t: Dokumen Rapat/Rapat/Judul/Tanggal/Pembahasan\n" .
                    "Contoh\t\t\t\t\t\t\t: Dokumen Rapat/Rapat/Judul/Tanggal/Pembahasan\n\n" .
                    "Dokumen Rapat :\n\n" .
                    "- Daftar Hadir\n\n" .
                    "- Undangan\n\n" .
                    "- Notulen : Blanko\n\n" .
                    "- Berita Acara : Blanko\n\n" .
                    "\n";
                return format_pesan('INFORMASI TERKAIT DOKUMEN', $pesanKiriman);
                break;
            case 'Help Walkes':
                $pesanKiriman =  "" .
                    "*Berikut informasi yang bisa diakses oleh wali kelas*\n" .
                    "*Rekap Absensi : Export Absensi / Walkes/VII A*\n" .
                    "*Program Kerja : ( _Premium Only_ )*\n" .
                    "*Jadwal Piket : ( _Premium Only_ )*\n" .
                    "*Data Siswa : ( _Premium Only_ )*\n" .
                    "*Statistik Siswa : ( _Premium Only_ )*\n" .
                    "*Struktur Oraganisasi* : ( _Premium Only_ )*\n" .
                    "*Petugas Upacara* : ( _Premium Only_ )*\n" .
                    "*Peraturan Kelas* : ( _Premium Only_ )*\n" .
                    "*Peraturan Sekolah* : ( _Premium Only_ )*\n" .
                    "*Catatan BK* : ( _Premium Only_ )*\n" .
                    "*Data Pembayaran* : ( _Premium Only_ )*\n" .
                    "*Data Tabungan* : ( _Premium Only_ )*\n" .
                    "*Data PIP* : ( _Premium Only_ )*\n" .
                    "*Data Perpustakaan* : ( _Premium Only_ )*\n" .
                    "*Denah Tempat Duduk* : ( _Premium Only_ )*\n" .
                    "*Daftar Peserta Ekstra* : ( _Premium Only_ )*\n" .
                    "\n";
                return format_pesan('INFORMASI WALI KELAS', $pesanKiriman);
                break;
            case 'Help Ijin':
                $pesanKiriman =  "" .
                    "*Ijin Siswa*\n" .
                    "Ijin Siswa\t\t\t\t\t: Ijin Siswa/Siswa/NIS/Sakit/Keterangan\n" .
                    "Contoh\t\t\t\t\t\t\t: Ijin Siswa/Siswa/2025001/Sakit/Demam\n\n" .
                    "\n" . str_repeat("─", 25) . "\n" .
                    "*Ijin Guru*\n" .
                    "Ijin Siswa\t\t\t\t\t: Ijin Guru/Guru/Kode Guru/Sakit/Keterangan\n" .
                    "Contoh\t\t\t\t\t\t\t: Ijin Guru/Guru/JA/Sakit/Demam\n\n" .
                    "\n";
                return format_pesan('INFORMASI TERKAIT IJIN DIGITAL', $pesanKiriman);
                break;

            case 'Help Siswa':
                $pesanKiriman = "" .
                    "================================\n" .
                    "📌 *TERKAIT SISWA*\n" .
                    "================================\n\n" .
                    "Butuh bantuan terkait Siswa?\n" .
                    "Ketikkan Kode/Siswa/NIS\n" .
                    "Contoh : *Data Siswa/Siswa/NIS*\n\n" .
                    "Kode yang ada :\n" .
                    "- Data Siswa : Data Siswa/Siswa/NIS\n" .
                    "- Register : Register/Siswa/nis/nosiswa:noayah:noibu\n" .
                    "- Cek Absnensi : Absensi / Siswa / nis\n" .
                    "- Cek 1 Bulan Absnensi : Absensi Bulanan/ Siswa / nis / bulan ( 1 - 12 )\n" .
                    "- Data BK : Data Point/BK/NIS *(_Premium Only_)*\n" .
                    "- Data Kredit Point : Data Kredit Point/BK/NIS *(_Premium Only_)*\n" .
                    "- Bimbingan : Bimbingan/BK/Kode Guru/NIS/Masalah *(_Premium Only_)*\n" .
                    "- Jadwal Ekstra : Jadwal Ekstra/Siswa/NIS *(_Premium Only_)*\n" .
                    "- Pembayaran : Pembayaran/Siswa/NIS  *(_Premium Only_)*\n" .
                    "- Tabungan : Tabungan/Siswa/25001 *(_Premium Only_)*\n" .
                    "\n" . str_repeat("─", 25) . "\n" .
                    "✍️ Dikirim oleh:\nWhatsappBot Sekolah *{$Identitas->namasek}*";
                return $pesanKiriman;
                break;

            case 'Help Pencarian':
                $pesanKiriman =  "" .
                    "================================\n" .
                    "📌 *INFORMASI PENCARIAN*\n" .
                    "================================\n\n" .
                    "Informasi Pencarian Data :\n" .

                    "Siswa/Cari/key/pencarian \n" .
                    "Contoh :\n" .

                    "*Berdasarkan Kelas :* \n" .
                    "Siswa/Cari/kelas/VII A \n\n" .

                    "*Berdasarkan Status Siswa :* \n" .
                    "Siswa/Cari/pindahan/keluar/7 \n\n" .

                    "*Berdasarkan Nama :* \n" .
                    "Siswa/Cari/nama/Dany \n\n" .

                    "*Berdasarkan Alamat :* \n" .
                    "Siswa/Cari/alamat/xxxx \n\n" .

                    "*Berdasarkan nis :* \n" .
                    "Siswa/Cari/nis/2025xx \n\n" .

                    "*Berdasarkan status :* \n" .
                    "Siswa/Cari/statusytm/yatim:piatu:yatim piatu:lengkap \n\n" .

                    "*Berdasarkan Desa :* \n" .
                    "Siswa/Cari/desa/desa \n\n" .
                    "Siswa/Cari/desa/kubangwungu \n\n" .

                    "Siswa/Cari/desa/desa/rt/rw \n\n" .
                    "Siswa/Cari/desa/kubangwungu/002/003 \n\n" .

                    "*Berdasarkan Umur :* \n" .
                    "Siswa/Cari/umur/11 \n\n" .

                    "*Berdasarkan Jabatan Kelas :* \n" .
                    "Siswa/Cari/jabatan/Ketua Kelas \n\n" .

                    "*Berdasarkan Bantuan :* \n" .
                    "Siswa/Cari/bantuan1/lulus#aktif#drop_out \n\n" .

                    "*Berdasarkan Asal Sekolah :* \n" .
                    "Siswa/Cari/sekolah/nama sd \n" .
                    "Siswa/Cari/sekolah/SD Negeri 01 Kubangwungu \n\n" .
                    "Siswa/Cari/sekolah/nama sd \n" .
                    "Siswa/Cari/sekolah/SD Negeri 01 Kubangwungu/7 \n\n" .

                    "*Berdasarkan Pindahan :* \n" .
                    "Siswa/Cari/sekolah/pindahan/tingkat \n\n" .
                    "Siswa / Cari / pindahan / 7 \n\n" .

                    "*Berdasarkan Piket :* \n" .
                    "Siswa/Cari/piket/Senin \n\n" .

                    "*Berdasarkan Penyakit :* \n" .
                    "Siswa/Cari/penyakit/Maag \n\n" .

                    "*Berdasarkan Golongan Darah :* \n" .
                    "Siswa/Cari/darah/O/aktif#lulus#drop out \n\n" .

                    "*Berdasarkan Cita - Cita :* \n" .
                    "Siswa/Cari/cita-cita/guru \n\n" .

                    "*Berdasarkan Hobi :* \n" .
                    "Siswa/Cari/hobi/menulis \n\n" .

                    "*Berdasarkan Tinggal Bersama :* \n" .
                    "Siswa/Cari/tinggal/Nenek#Orang Tua#Kakek dan Nenek#Paman dan Bibi \n\n" .

                    "\n" . str_repeat("─", 25) . "\n" .
                    "✍️ Dikirim oleh:\nWhatsappBot Sekolah *{$Identitas->namasek}*";
                return $pesanKiriman;
                break;
            case 'Help Guru':
                $pesanKiriman =  "" .
                    "================================\n" .
                    "📌 *INFORMASI GURU*\n" .
                    "================================\n\n" .
                    "Informasi Khusus Guru :\n" .
                    "- *Kode Guru* : Kode Guru\n" .
                    "- *Data Guru* : Data Guru/Guru/Kode Guru\n" .
                    "- *Jumlah Siswa* : Jumlah Siswa/Guru/Kode Guru\n" .
                    "- *Laporan Guru Siswa Bolos* : Laporan Guru/Guru/Kode_Guru/Mapel/Jam ke/arraynis/Keterangan\n" .
                    "- *Teruskan* : Teruskan/Guru/Kode Guru/ArrayNis/ortu # siswa/Isi Pesan/Call\n" .
                    "- *Link Absen* : Link Absen / Guru / Kode Guru\n" .
                    "- *Data Sekolah* : Data Sekolah/Guru/Kode_Guru\n" .
                    "- *Kontak Sekolah* : Kontak Sekolah/Guru/Kode Guru\n" .
                    "- *Kontak Kosong* : Kontak Kosong/Guru/Kode Guru\n" .
                    "- *Cek Server* : Cek Server/Guru/Kode Guru\n" .
                    "- *Dokumen Siswa* : Dokumen Siswa / Guru / NIS / karpel#foto#kk#nisn#ktp#ijazah#kia#bantuan 1#bantuan 2#bantuan 3#bantuan 4#bantuan 5\n" .
                    "- *Statistik Siswa*:Statistik Siswa/Guru/23:24:25/pdf/cetak \n\n" .
                    // "- *Registrasi Guru* : Registrasi Guru/Guru/Kode Guru ( Belum Tersedia )\n" .
                    "\n" . str_repeat("─", 25) . "\n" .
                    "✍️ Dikirim oleh:\nWhatsappBot Sekolah *{$Identitas->namasek}*";
                return $pesanKiriman;
                break;
            case 'Help Alumni':
                $pesanKiriman =  "" .
                    "================================\n" .
                    "📌 *INFORMASI Alumni*\n" .
                    "================================\n\n" .
                    "Informasi Khusus Guru :\n" .
                    "- *Data Alumni*: Data Alumni/Alumni/25/pdf\n" .
                    // "- *Registrasi Guru* : Registrasi Guru/Guru/Kode Guru ( Belum Tersedia )\n" .
                    "\n" . str_repeat("─", 25) . "\n" .
                    "✍️ Dikirim oleh:\nWhatsappBot Sekolah *{$Identitas->namasek}*";
                return $pesanKiriman;
                break;
            case 'Kode Guru':
                $pesanKiriman = KodeGuru(); // fungsi langsung, tidak perlu teks
                return $pesanKiriman;
                break;
            case 'Help Control':
                // Auto_Reply_ControlHelper
                $pesanKiriman =  "" .
                    "Informasi Control :\n" .
                    "- Restart Service/Control\n" .
                    "- Restart PC/Control\n" .
                    "- Shutdown Service/Control\n" .
                    "- Shutdown PC/Control\n" .
                    "- Cek Service/Control\n" .
                    "\n";
                return format_pesan_group("Informasi {$message}", $pesanKiriman);
                break;
            case 'Help Operator':
                // Auto_Reply_ControlHelper
                $pesanKiriman =  "" .
                    "Informasi Operator :\n" .
                    "- Ubah Status Siswa : Ubah Status Siswa / Operator / arraynis / Status aktif#drop out#meninggal#lulus#pindah#mengundurkan diri#tidak dikenal \n" .
                    "- Field Data Siswa / Operator \n" .
                    "- Field Data Guru / Operator (_Belum Tersedia_) \n" .
                    "- Export Data / Operator / Siswa / id:nama_siswa:nis:kelas_id \n" .
                    "- Export Data Emis / Operator / Siswa\n" .
                    "- Export Alumni / Operator / Alumni / 2024 / nama_siswa \n\n" .
                    "- Sekolah Asal / Operator \n" .
                    "- Sekolah Asal / Operator / tingkat \n".
                    "- Compare Sekolah Asal / Operator / 7:8\n" .
                    "- Pekerjaan / Operator / Ibu:Ayah\n" .
                    "- Pekerjaan / Operator / Ibu:Ayah / 8\n" .
                    "- Pekerjaan / Operator / Ibu:Ayah / 7:8:9\n" .
                    "- Hobi / Operator\n" .
                    "- Hobi / Operator / 7\n" .
                    "\n";
                return format_pesan_group("Informasi {$message}", $pesanKiriman);
                break;
            case 'Help PPDB':
                FiturPaket($paket, $NoRequest);
                $pesanKiriman =
                    "Peserta/PPDB\n" .
                    "Sebaran Data/PPDB\n" .
                    "Petugas Piket/PPDB\n" .
                    "Formulir/PPDB\n" .
                    "Formulir/PPDB\n" .
                    "\n\n";
                return format_pesan_group('Informasi PPDB', $pesanKiriman);
                break;
            case 'Help Wali Kelas':
                FiturPaket($paket, $NoRequest);
                $pesanKiriman =
                    "Peserta/PPDB\n" .
                    "Sebaran Data/PPDB\n" .
                    "Petugas Piket/PPDB\n" .
                    "Formulir/PPDB\n" .
                    "Formulir/PPDB\n" .
                    "\n\n";
                return format_pesan_group("Informasi {$message}", $pesanKiriman);
                break;
            case 'Help Media':
                //  Auto_Reply_VendorHelper
                $pesanKiriman =  "" .
                    "Pada bagian ini bapak / ibu bisa menyimpan file / dokumen untuk data dokumentasi sekolah sesuai keterangan / folder masing masing\n" .
                    "Penggunaan nya kirim media dengan caption text\n" .
                    "*Contoh Caption:*\n" .
                    "PPDB/Sosialisasi/SDN 1 Banjarharjo\n\n" .
                    "Semua terdiri dari 3 folder, jadi garis */* merupakan folder yang akan dibuat\n" .
                    "Jika penulisan PPDB, artinya 1 folder saja dan \n" .
                    "- Shutdown Service\Help Control\n";
                return format_pesan("Penyimpanan Media", $pesanKiriman);
                break;
            case 'Help Vendor':
                //  Auto_Reply_VendorHelper
                $pesanKiriman =  "" .
                    "Informasi bantuan :\n" .
                    "*Data Vendor*\n" .
                    "- Data Vendor/Vendor\n" .
                    "- Fitur Aplikasi/Vendor\n" .
                    "- Teruskan/Vendor\n\n" .
                    "*Service dan PC Control*\n" .
                    "- Cek Service/Vendor\n" .
                    "- Restart Service/Vendor\n" .
                    "- Restart PC/Vendor\n" .
                    "- Shutdown Service/Vendor\n" .
                    "- Shutdown PC/Vendor\n" .
                    "- Update Whatsapp/Vendor\n" .
                    "- Update Modul/Vendor\n" .
                    "- Update Siakad/Vendor\n" .
                    "*Database*\n" .
                    "- Siswa/Vendor\n" .
                    "- Guru/Vendor\n" .
                    "- Info Update Siswa / Vendor / nis\n" .
                    "- Bagian Update Siswa\n" .
                    "Update Siswa/Vendor/250001/\n" .
                    "status_tempat_tinggal:Milik Sendiri\n\n" .
                    "- Info Update Data Ayah / Vendor / nis\n" .
                    "- Info Update Data Ibu / Vendor / nis\n" .
                    "- Info Update Data Wali / Vendor / nis\n" .
                    "- Info Update Data Bantuan / Vendor / nis\n" .
                    "*Command :*\n" .
                    "- Command / Vendor/ namacommand (signature)\n" .
                    "     Command / Vendor/ siakad:cobabuat\n" .
                    "*Daftar Commands :*\n" .
                    "xxxxxxxxxxxxx\n" .
                    "absensi:cetak-absensi\n" .
                    "\n";
                return format_pesan_group("Informasi {$message}", $pesanKiriman);
                break;
            case 'Help Command':
                //  Auto_Reply_VendorHelper
                $pesanKiriman =  "" .
                    "Informasi bantuan :\n" .
                    "- siakad:pengingat-pembayaran-siswa\n" .
                    "- absensi:rekap-bulanan\n" .

                    "\n";
                return format_pesan_group("Informasi {$message}", $pesanKiriman);
                break;
            case 'Help Cetak':
                $pesanKiriman =  "" .
                    "*Bagian 1 :*\n" .
                    "Cetak langsung dokumen\n" .
                    "Silahkan tambahkan */cetak* pada bagian akhir pesan pesan di akhir maka akan mencetak ke printer secara langsung pada printer yang sudah terhubung dengan server\n" .
                    "Untuk Bagian satu tidak semua bisa menggunakan metode ini, baru aktif di beberapa format :\n" .
                    "- EAG/Kepala/AS/9/cetak\n" .
                    "- Dokumen pdf / Guru / AS/ 230019 /karpel : foto/cetak\n" .
                    "- EAGS / Kepala / DT:JM / 10 / cetak\n" .
                    "\n" .
                    "*Bagian 2 :*\n" .
                    "Bagian ini hampir sama dengan bagian satu, tetapi perangkat hp harus menginstal aplikasi di google play melalui link\n" .
                    "👇\n" .
                    "Nama Aplikasi : *Mobility Print*\n" .
                    "Link Instalasi : 👉 https://play.google.com/store/apps/details?id=com.papercut.projectbanksia\n" .
                    "\n" .
                    "Langkah Langkah Seting : \n" .
                    "- Instal Aplikasi Mobility Print\n" .
                    "- Buka dokumen 📑 👉 misalkan pdf\n" .
                    "- Pilih cetak 🖨️ ( Biasanya ada di titik tiga )\n" .
                    "- Pilih printer 🖨️ yang terhubung dengan server dan ukuran kertas disesuaikan\n" .
                    "\n";
                return format_pesan_group("Informasi {$message}", $pesanKiriman);
                break;
            case 'Media File':
                //  Auto_Reply_VendorHelper
                // $pesanKiriman =  "" .
                //     "Media telah tersimpan di server\n" .
                //     "\n\n";
                // return format_pesan("Penyimpanan Media", $pesanKiriman);
                break;
            default:
                $pesanKiriman =
                    "Mohon maaf tidak ada referensi terkait ' *$message* '?\n" .
                    "Silahkan gunakan *format dan data* yang sesuai\n\n" .
                    "Terima Kasih\n" .
                    "\n";
                $pesanKiriman =
                    "Mohon maaf tidak ada referensi terkait ' *$message* '?\n" .
                    "Silahkan gunakan *format dan data* yang sesuai\n\n" .
                    "Terima Kasih\n" .
                    "\n";
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage('GuruId', '6285329860005', "Ada pesan dari {$NoRequest}\nIsi Pesan :\n{$message}");
                // return format_pesan_group("Informasi {$message}", $pesanKiriman);
                return false;
                break;
        }
    }
}
if (!function_exists('HelpGroup')) {
    function HelpGroup($message)
    {
        //Isi Fungsi
        $Identitas = Indetitas(); // ambil data identitas sekali panggil di sini
        switch (ucfirst($message)) {
            case 'Assalamu\'alaikum':
                $pesanKiriman =
                    "*Waalaikumussalam Wr.Wb*\n" .
                    "Mohon maaf ada yang bisa dibantu???\n" .
                    "Silahkan tuliskan pesan sesuai format yang ditentukan\n" .
                    "*Terima Kasih*\n" .
                    "\n\n";
                return format_pesan_group("Informasi {$message}", $pesanKiriman);
                break;
            case 'Info Kelulusan':
                $pesanKiriman =
                    "Mohon untuk saat ini belum ada informasi berhubungan dengan kelulusan\n";
                return format_pesan_group("Informasi {$message}", $pesanKiriman);
                break;
            case 'Info PPDB':
                $pesanKiriman =
                    "Mohon untuk saat ini belum ada informasi berhubungan dengan kelulusan\n";
                return format_pesan_group("Informasi {$message}", $pesanKiriman);
                break;
            default:
                $pesanKiriman =
                    "Mohon maaf tidak ada referensi terkait ' *$message* '?\n\n" .
                    "Silahkan gunakan *format dan data* yang sesuai\n\n" .
                    "\n\n";
                return format_pesan_group("Informasi", $pesanKiriman);
                break;
        }
    }
}
