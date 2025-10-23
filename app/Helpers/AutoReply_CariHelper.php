<?php

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use App\Models\Admin\Identitas;
use App\Models\Whatsapp\WhatsApp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use App\Models\User\Siswa\Detailsiswa;

/*
        |--------------------------------------------------------------------------
        | 📌 AutoReply_CariHelper :
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
if (!function_exists('Auto_reply_CariKode')) {
    function Auto_reply_CariKode($Kode, $Siswa, $NoRequest, $message)
    {
        $Identitas = Identitas::first();
        $data = explode('/', $message);
        $sessions = config('whatsappSession.IdWaUtama');
        switch ($Kode) {
            // $data = explode('/', $message);
            case 'Siswa':
                // Konsep Untuk Kirim dan Buat Surat Lewat Whatsapp
                // Format perintah:
                // Siswa/Cari/key/pencarian
                // Contoh:
                // Siswa/Cari/kelas/VII A
                // Siswa/Cari/nama/xxxx
                // Siswa/Cari/alamat/xxxx
                // Siswa/Cari/nis/2025xx
                // Siswa/Cari/statusytm/yatim:piatu:yatim piatu:lengkap
                // Siswa/Cari/umur/11
                // Siswa/Cari/desa/11
                // Siswa/Cari/bantuan1/aktif
                // Siswa / Cari / pindahan / 7
                // Siswa/Cari/pekerjaan ayah/Wakil Rektor
                // Siswa/Cari/pekerjaan ibu/Wakil Rektor
                // Cari/Siswa

                $field = $data[2] ?? ''; // ambil field pencarian
                if ($field === 'kelas') {
                    // khusus pencarian kelas (karena kelas pakai ID)
                    $etapels = Etapel::where('aktiv', 'Y')->first();
                    $kelasId = Ekelas::where('tapel_id', $etapels->id)->where('kelas', $data[3])->first();
                    $keyword = $kelasId->id ?? ''; // jika kelas tidak ditemukan → kosong
                } else {
                    $keyword = $data[3] ?? ''; // ambil keyword pencarian
                }

                // mapping field agar aman (hindari SQL injection dan typo)
                $field = strtolower(trim($data[2] ?? '')); // bikin case-insensitive dan hapus spasi
                $keyword = trim($data[3] ?? '');

                $fieldMap = [
                    'nama' => 'nama_siswa',
                    'nis' => 'nis',
                    'alamat' => 'alamat_siswa',
                    'kelas' => 'kelas_id',
                    'statusytm' => 'status_yatim_piatu',
                    'desa' => 'desa',
                    'bantuan1' => 'kartu_bantuan_1',
                    'bantuan2' => 'kartu_bantuan_2',
                    'bantuan3' => 'kartu_bantuan_3',
                    'bantuan4' => 'kartu_bantuan_4',
                    'bantuan5' => 'kartu_bantuan_5',
                    'jabatan' => 'jabatan_kelas',
                    'pindahan' => 'asal_pindahan',
                    'piket' => 'piket_kelas',
                    'darah' => 'golongan_darah',
                    'penyakit' => 'riwayat_penyakit',
                    'cita-cita' => 'cita_cita',
                    'hobi' => 'hobi',
                    'tinggal' => 'tinggal_bersama',
                    'pekerjaan ayah' => 'ayah_pekerjaan',
                    'pekerjaan ibu' => 'ibu_pekerjaan',
                ];

                if (str_starts_with($field, 'bantuan') && $keyword != '') {
                    // cari siswa yang punya isi di kartu_bantuan_X dan status sesuai keyword
                    $dbField = $fieldMap[$field] ?? null;

                    if ($dbField) {
                        $Caris = Detailsiswa::with('KelasOne')
                            ->whereNotNull($dbField)
                            ->where($dbField, '!=', '')
                            ->where('status_siswa', $keyword)
                            ->get();
                    } else {
                        $Caris = collect();
                    }

                    $jumlahData = $Caris->count();

                    // format hasil pencarian
                    $isiSiswa = '';
                    foreach ($Caris as $siswa) {
                        $kelas = $siswa->kelas->kelas ?? '-'; // ambil nama kelas
                        $nis = $siswa->nis ?? '-'; // ambil NIS
                        $umur = umursiswa($siswa->tanggal_lahir); // fungsi helper hitung umur
                        // $isiSiswa .= "📝 {$siswa->nama_siswa} ({$kelas} - {$nis}) | {$umur} th}\n";
                        $isiSiswa .= "📝 {$siswa->nama_siswa} ({$kelas} - {$nis})\n";
                    }

                    // pesan kiriman ke WhatsApp
                    $pesanKiriman =
                        ($isiSiswa ?: "⚠️ Tidak ada data ditemukan.\n") . // fallback kalau kosong
                        "\n" . str_repeat("─", 25) . "\n\n" .
                        ("Jumlah Tersedia : {$jumlahData} Siswa\n") . // fallback kalau kosong
                        "\n\n";
                } elseif ($field === 'umur' && $keyword != '') {
                    $Caris = Detailsiswa::with('KelasOne')
                        ->where('status_siswa', 'aktif')
                        ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) = ?', [$keyword])
                        ->get();


                    // format hasil pencarian
                    $isiSiswa = '';
                    foreach ($Caris as $siswa) {
                        $kelas = $siswa->kelas->kelas ?? '-'; // ambil nama kelas
                        $nis = $siswa->nis ?? '-'; // ambil NIS
                        $umur = umursiswa($siswa->tanggal_lahir); // fungsi helper hitung umur
                        // $isiSiswa .= "📝 {$siswa->nama_siswa} ({$kelas} - {$nis}) | {$umur} th}\n";
                        $isiSiswa .= "📝 {$siswa->nama_siswa} ({$kelas} - {$nis})\n";
                    }

                    $jumlahData = $Caris->count();
                    // pesan kiriman ke WhatsApp
                    $pesanKiriman =
                        ($isiSiswa ?: "⚠️ Tidak ada data ditemukan.\n") . // fallback kalau kosong
                        "\n" . str_repeat("─", 25) . "\n\n" .
                        ("Jumlah Tersedia : {$jumlahData} Siswa\n") . // fallback kalau kosong
                        "\n\n";
                } elseif ($field === 'kelas' && $keyword != '') {
                    // 🧭 Contoh: Siswa/Cari/kelas/VII A
                    $etapels = Etapel::where('aktiv', 'Y')->first();

                    // Cari kelas berdasarkan tapel aktif dan nama kelas (case-insensitive)
                    $kelas = Ekelas::where('tapel_id', $etapels->id ?? null)
                        ->whereRaw('LOWER(kelas) = ?', [strtolower($keyword)])
                        ->first();

                    if ($kelas) {
                        // Ambil siswa aktif dengan kelas_id tsb
                        $Caris = Detailsiswa::with('KelasOne')
                            ->where('status_siswa', 'aktif')
                            ->where('kelas_id', $kelas->id)
                            ->get();

                        $jumlahData = $Caris->count();

                        // Format hasil
                        $isiSiswa = '';
                        foreach ($Caris as $siswa) {
                            $kelasNama = $siswa->kelas->kelas ?? '-';
                            $nis = $siswa->nis ?? '-';
                            $isiSiswa .= "📝 {$siswa->nama_siswa} ({$kelasNama} - {$nis})\n";
                        }

                        // Kirim ke WhatsApp
                        $pesanKiriman =
                            ($isiSiswa ?: "⚠️ Tidak ada data ditemukan.\n") .
                            "\n" . str_repeat("─", 25) . "\n\n" .
                            ("Jumlah Tersedia : {$jumlahData} Siswa\n") .
                            "\n\n";
                    } else {
                        // Kalau nama kelas tidak ditemukan di DB
                        $pesanKiriman = "⚠️ Kelas '{$keyword}' tidak ditemukan di tapel aktif.";
                    }
                } elseif (array_key_exists($field, $fieldMap) && $keyword != '') {
                    $dbField = $fieldMap[$field];
                    if ($field === 'jabatan') {
                        // Siswa/Cari/jabatan/Ketua Kelas
                        $Caris = Detailsiswa::with('KelasOne')
                            ->where('status_siswa', 'aktif')
                            ->where($dbField, 'like', '%' . $keyword . '%')
                            ->get();
                        $jumlahData = $Caris->count();

                        // urutan custom sesuai jabatan umum di kelas
                        $kategoriCaris = Detailsiswa::select('jabatan_kelas', DB::raw('COUNT(*) as total'))
                            ->groupBy('jabatan_kelas')
                            ->orderByRaw("
                                FIELD(
                                    COALESCE(jabatan_kelas, 'Tanpa Keterangan'),
                                    'Tanpa Keterangan',
                                    'Ketua Kelas',
                                    'Wakil Ketua',
                                    'Anggota',
                                    'Bendahara',
                                    'Sekretaris',
                                    'Sie. Keamanan',
                                    'Sie. Kebersihan'
                                )
                            ")
                            ->get();

                        $listkategori = "📊 Data kategori *Jabatan Kelas* siswa tersedia {$kategoriCaris->count()} jenis:\n\n";

                        foreach ($kategoriCaris as $index => $kategori) {
                            $datakategori = $kategori->jabatan_kelas ?? 'Tanpa Keterangan';
                            $jumlah = $kategori->total;
                            $listkategori .= ($index + 1) . ". {$datakategori} → {$jumlah} siswa\n";
                        }

                        // format hasil pencarian
                        $isiSiswa = '';
                        foreach ($Caris as $siswa) {
                            $kelas = $siswa->kelas->kelas ?? '-';
                            $nis = $siswa->nis ?? '-';
                            $isiSiswa .= "📝 {$siswa->nama_siswa} ({$kelas} - {$nis})\n";
                        }

                        // kirim pesan
                        $pesanKiriman =
                            ($isiSiswa ?: "⚠️ Tidak ada data ditemukan.\n") .
                            "\n" . str_repeat("─", 25) . "\n\n" .
                            ("Jumlah Tersedia : {$jumlahData} Siswa\n") .
                            ("\n{$listkategori}\n") .
                            "\n\n";
                    } elseif ($field === 'pindahan') {
                        // Siswa/Cari/pindahan/keluar/7
                        // Siswa/Cari/pindahan/masuk#keluar/7
                        if ($data[3] === 'masuk') {
                            $Caris = Detailsiswa::where('status_siswa', 'aktif')
                                ->whereNotNull('asal_pindahan')
                                ->get();
                            if (isset($data[4]) && trim($data[4]) !== '') {
                                $Caris = $Caris->where('tingkat_id', $data[4]);
                            }
                        } else {
                            $Caris = Detailsiswa::where('status_siswa', 'pindah')
                                ->get();
                        }
                        $jumlahData = $Caris->count();

                        $kategoriCaris = Detailsiswa::select('status_siswa', DB::raw('COUNT(*) as total'))
                            ->groupBy('status_siswa')
                            ->orderBy('status_siswa')
                            ->get();

                        $listkategori = "📊 Data kategori *Golongan Darah* siswa tersedia {$kategoriCaris->count()} jenis:\n\n";

                        foreach ($kategoriCaris as $index => $kategori) {
                            $datakategori = $kategori->status_siswa ?? 'Tanpa Keterangan';
                            $jumlah = $kategori->total;
                            $listkategori .= ($index + 1) . ". {$datakategori} → {$jumlah} siswa\n";
                        }


                        // format hasil pencarian
                        $isiSiswa = '';
                        foreach ($Caris as $siswa) {
                            $kelas = $siswa->kelas->kelas ?? '-'; // ambil nama kelas
                            $nis = $siswa->nis ?? '-'; // ambil NIS
                            $umur = umursiswa($siswa->tanggal_lahir); // fungsi helper hitung umur
                            // $isiSiswa .= "📝 {$siswa->nama_siswa} ({$kelas} - {$nis}) | {$umur} th}\n";
                            $isiSiswa .= "📝 {$siswa->nama_siswa} ({$kelas} - {$nis})\n";
                        }

                        // pesan kiriman ke WhatsApp
                        $pesanKiriman =
                            ($isiSiswa ?: "⚠️ Tidak ada data ditemukan.\n") . // fallback kalau kosong
                            "\n" . str_repeat("─", 25) . "\n\n" .
                            ("Jumlah Tersedia : {$jumlahData} Siswa\n") .
                            ("\n{$listkategori}\n") .
                            "\n\n";
                    } elseif ($field === 'piket') {
                        // Siswa/Cari/piket/Senin

                        $Caris = Detailsiswa::where('status_siswa', 'aktif')
                            ->where('piket_kelas', $data[3])
                            ->get();
                        $jumlahData = $Caris->count();
                        $kategoriCaris = Detailsiswa::select('piket_kelas', DB::raw('COUNT(*) as total'))
                            ->groupBy('piket_kelas')
                            ->orderByRaw("
                                    FIELD(LOWER(piket_kelas),
                                        'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'jum\\'at', 'sabtu'
                                    )
                                ")
                            ->get();

                        $listkategori = "📊 Data kategori *Piket Siswa* tersedia {$kategoriCaris->count()} jenis:\n\n";

                        foreach ($kategoriCaris as $index => $kategori) {
                            $datakategori = $kategori->piket_kelas ?? 'Tanpa Keterangan';
                            $jumlah = $kategori->total;
                            $listkategori .= ($index + 1) . ". {$datakategori} → {$jumlah} siswa\n";
                        }


                        // format hasil pencarian
                        $isiSiswa = '';
                        foreach ($Caris as $siswa) {
                            $kelas = $siswa->kelas->kelas ?? '-'; // ambil nama kelas
                            $nis = $siswa->nis ?? '-'; // ambil NIS
                            $umur = umursiswa($siswa->tanggal_lahir); // fungsi helper hitung umur
                            // $isiSiswa .= "📝 {$siswa->nama_siswa} ({$kelas} - {$nis}) | {$umur} th}\n";
                            $isiSiswa .= "📝 {$siswa->nama_siswa} ({$kelas} - {$nis})\n";
                        }

                        // pesan kiriman ke WhatsApp
                        $pesanKiriman =
                            ($isiSiswa ?: "⚠️ Tidak ada data ditemukan.\n") . // fallback kalau kosong
                            "\n" . str_repeat("─", 25) . "\n\n" .
                            ("Jumlah Tersedia : {$jumlahData} Siswa\n") .
                            ("\n{$listkategori}\n") .
                            "\n\n";
                    } elseif ($field === 'penyakit') {
                        // Siswa/Cari/penyakit/Maag
                        $PesanKirim =
                            "isi_pesan \n" .
                            "\n\n";
                        $Caris = Detailsiswa::where('status_siswa', 'aktif')
                            ->where('riwayat_penyakit', 'like', '%' . $keyword . '%')
                            ->get();
                        $jumlahData = $Caris->count();

                        $kategoriCaris = Detailsiswa::select('riwayat_penyakit', DB::raw('COUNT(*) as total'))
                            ->groupBy('riwayat_penyakit')
                            ->orderBy('riwayat_penyakit')
                            ->get();

                        $listkategori = "📊 Data kategori *Golongan Darah* siswa tersedia {$kategoriCaris->count()} jenis:\n\n";

                        foreach ($kategoriCaris as $index => $kategori) {
                            $datakategori = $kategori->riwayat_penyakit ?? 'Tanpa Keterangan';
                            $jumlah = $kategori->total;
                            $listkategori .= ($index + 1) . ". {$datakategori} → {$jumlah} siswa\n";
                        }
                        // format hasil pencarian
                        $isiSiswa = '';
                        foreach ($Caris as $siswa) {
                            $kelas = $siswa->kelas->kelas ?? '-'; // ambil nama kelas
                            $nis = $siswa->nis ?? '-'; // ambil NIS
                            $umur = umursiswa($siswa->tanggal_lahir); // fungsi helper hitung umur
                            // $isiSiswa .= "📝 {$siswa->nama_siswa} ({$kelas} - {$nis}) | {$umur} th}\n";
                            $isiSiswa .= "📝 {$siswa->nama_siswa} ({$kelas} - {$nis})\n";
                        }

                        // pesan kiriman ke WhatsApp
                        $pesanKiriman =
                            ($isiSiswa ?: "⚠️ Tidak ada data ditemukan.\n") . // fallback kalau kosong
                            "\n" . str_repeat("─", 25) . "\n\n" .
                            ("Jumlah Tersedia : {$jumlahData} Siswa\n") . // fallback kalau kosong
                            ("\n{$listkategori}\n") .
                            "\n\n";
                    } elseif ($field === 'darah') {
                        // Siswa/Cari/darah/O/aktif

                        $Caris = Detailsiswa::where('golongan_darah', 'like', '%' . $keyword . '%')
                            ->get();
                        if (isset($data[4])) {
                            $Caris =  $Caris->where('status_siswa', $data[4]);
                        }
                        $jumlahData = $Caris->count();

                        $kategoriCaris = Detailsiswa::select('golongan_darah', DB::raw('COUNT(*) as total'))
                            ->groupBy('golongan_darah')
                            ->orderBy('golongan_darah')
                            ->get();

                        $listkategori = "📊 Data kategori *Golongan Darah* siswa tersedia {$kategoriCaris->count()} jenis:\n\n";

                        foreach ($kategoriCaris as $index => $kategori) {
                            $datakategori = $kategori->golongan_darah ?? 'Tanpa Keterangan';
                            $jumlah = $kategori->total;
                            $listkategori .= ($index + 1) . ". {$datakategori} → {$jumlah} siswa\n";
                        }



                        // format hasil pencarian
                        $isiSiswa = '';
                        foreach ($Caris as $siswa) {
                            $kelas = $siswa->kelas->kelas ?? '-'; // ambil nama kelas
                            $nis = $siswa->nis ?? '-'; // ambil NIS
                            $umur = umursiswa($siswa->tanggal_lahir); // fungsi helper hitung umur
                            // $isiSiswa .= "📝 {$siswa->nama_siswa} ({$kelas} - {$nis}) | {$umur} th}\n";
                            $isiSiswa .= "📝 {$siswa->nama_siswa} ({$kelas} - {$nis})\n";
                        }

                        // pesan kiriman ke WhatsApp
                        $pesanKiriman =
                            ($isiSiswa ?: "⚠️ Tidak ada data ditemukan.\n") . // fallback kalau kosong
                            "\n" . str_repeat("─", 25) . "\n\n" .
                            ("Jumlah Tersedia : {$jumlahData} Siswa\n") . // fallback kalau kosong
                            ("\n{$listkategori}\n") . // fallback kalau kosong
                            "\n\n";
                    } elseif ($field === 'cita-cita') {
                        // Siswa/Cari/cita-cita/guru
                        $Caris = Detailsiswa::where('cita_cita', 'like', '%' . $keyword . '%')
                            ->get();
                        $jumlahData = $Caris->count();

                        $kategoriCaris = Detailsiswa::select('hobi', DB::raw('COUNT(*) as total'))
                            ->groupBy('hobi')
                            ->orderBy('hobi')
                            ->get();

                        $listkategori = "📊 Data kategori *Cita - Cita* siswa tersedia {$kategoriCaris->count()} jenis:\n\n";

                        foreach ($kategoriCaris as $index => $kategori) {
                            $datakategori = $kategori->cita_cita ?? 'Tanpa Keterangan';
                            $jumlah = $kategori->total;
                            $listkategori .= ($index + 1) . ". {$datakategori} → {$jumlah} siswa\n";
                        }

                        // format hasil pencarian
                        $isiSiswa = '';
                        foreach ($Caris as $siswa) {
                            $kelas = $siswa->kelas->kelas ?? '-'; // ambil nama kelas
                            $nis = $siswa->nis ?? '-'; // ambil NIS
                            $umur = umursiswa($siswa->tanggal_lahir); // fungsi helper hitung umur
                            // $isiSiswa .= "📝 {$siswa->nama_siswa} ({$kelas} - {$nis}) | {$umur} th}\n";
                            $isiSiswa .= "📝 {$siswa->nama_siswa} ({$kelas} - {$nis})\n";
                        }

                        // pesan kiriman ke WhatsApp
                        $pesanKiriman =
                            ($isiSiswa ?: "⚠️ Tidak ada data ditemukan.\n") . // fallback kalau kosong
                            "\n" . str_repeat("─", 25) . "\n\n" .
                            ("Jumlah Tersedia : {$jumlahData} Siswa\n") . // fallback kalau kosong
                            ("\n{$listkategori}\n") .
                            "\n\n";
                    } elseif ($field === 'hobi') {
                        // Siswa/Cari/hobi/menulis
                        $Caris = Detailsiswa::where('hobi', 'like', '%' . $keyword . '%')
                            ->get();
                        $jumlahData = $Caris->count();
                        $kategoriCaris = Detailsiswa::select('hobi', DB::raw('COUNT(*) as total'))
                            ->groupBy('hobi')
                            ->orderBy('hobi')
                            ->get();

                        $listkategori = "📊 Data kategori *Hobi* siswa tersedia {$kategoriCaris->count()} jenis:\n\n";

                        foreach ($kategoriCaris as $index => $kategori) {
                            $datakategori = $kategori->hobi ?? 'Tanpa Keterangan';
                            $jumlah = $kategori->total;
                            $listkategori .= ($index + 1) . ". {$datakategori} → {$jumlah} siswa\n";
                        }
                        // format hasil pencarian
                        $isiSiswa = '';
                        foreach ($Caris as $siswa) {
                            $kelas = $siswa->kelas->kelas ?? '-'; // ambil nama kelas
                            $nis = $siswa->nis ?? '-'; // ambil NIS
                            $umur = umursiswa($siswa->tanggal_lahir); // fungsi helper hitung umur
                            // $isiSiswa .= "📝 {$siswa->nama_siswa} ({$kelas} - {$nis}) | {$umur} th}\n";
                            $isiSiswa .= "📝 {$siswa->nama_siswa} ({$kelas} - {$nis})\n";
                        }

                        // pesan kiriman ke WhatsApp
                        $pesanKiriman =
                            "Berikut data yang diminta :\n" .
                            ($isiSiswa ?: "⚠️ Tidak ada data ditemukan.\n") . // fallback kalau kosong
                            "\n" . str_repeat("─", 25) . "\n\n" .
                            ("Jumlah Tersedia : {$jumlahData} Siswa\n") . // fallback kalau kosong
                            ("\n{$listkategori}\n") . // fallback kalau kosong
                            "\n\n";
                    } elseif ($field === 'tinggal') {
                        // Siswa/Cari/tinggal/Nenek#Orang Tua#Kakek dan Nenek#Paman dan Bibi
                        $Caris = Detailsiswa::where('tinggal_bersama', 'like', '%' . $keyword . '%')
                            ->get();
                        $jumlahData = $Caris->count();
                        $kategoriCaris = Detailsiswa::select('tinggal_bersama', DB::raw('COUNT(*) as total'))
                            ->groupBy('tinggal_bersama')
                            ->orderBy('tinggal_bersama')
                            ->get();

                        $listkategori = "📊 Data kategori *Tinggal Bersama* siswa tersedia {$kategoriCaris->count()} jenis:\n\n";

                        foreach ($kategoriCaris as $index => $kategori) {
                            $datatinggal = $kategori->tinggal_bersama ?? 'Tanpa Keterangan';
                            $jumlah = $kategori->total;
                            $listkategori .= ($index + 1) . ". {$datatinggal} → {$jumlah} siswa\n";
                        }


                        // format hasil pencarian
                        $isiSiswa = '';
                        foreach ($Caris as $siswa) {
                            $kelas = $siswa->kelas->kelas ?? '-'; // ambil nama kelas
                            $nis = $siswa->nis ?? '-'; // ambil NIS
                            $umur = umursiswa($siswa->tanggal_lahir); // fungsi helper hitung umur
                            // $isiSiswa .= "📝 {$siswa->nama_siswa} ({$kelas} - {$nis}) | {$umur} th}\n";
                            $isiSiswa .= "📝 {$siswa->nama_siswa} ({$kelas} - {$nis})\n";
                        }

                        // pesan kiriman ke WhatsApp
                        $pesanKiriman =
                            "Berikut data yang diminta :\n" .
                            ($isiSiswa ?: "⚠️ Tidak ada data ditemukan.\n") . // fallback kalau kosong
                            "\n" . str_repeat("─", 25) . "\n\n" .
                            ("Jumlah Tersedia : {$jumlahData} Siswa\n") . // fallback kalau kosong
                            ("\n{$listkategori}\n") . // fallback kalau kosong
                            "\n\n";
                    } elseif ($field === 'desa') {
                        // Siswa / Cari / desa / sari
                        // Siswa / Cari / desa / sari / rt / rw
                        if (isset($data[4])) {
                            $Caris = Detailsiswa::with('KelasOne')
                                ->where('status_siswa', 'aktif')
                                ->where('desa', $keyword)
                                ->where('rt', '=', $data[4])
                                ->where('rw', '=', $data[5])
                                ->get();
                            $jumlahData = $Caris->count();
                        } else {
                            $Caris = Detailsiswa::with('KelasOne')
                                ->where('status_siswa', 'aktif')
                                ->where('desa', 'like', '%' . $keyword . '%')
                                ->get();
                            $jumlahData = $Caris->count();
                        }

                        // format hasil pencarian
                        $isiSiswa = '';
                        foreach ($Caris as $siswa) {
                            $kelas = $siswa->kelas->kelas ?? '-'; // ambil nama kelas
                            $nis = $siswa->nis ?? '-'; // ambil NIS
                            $umur = umursiswa($siswa->tanggal_lahir); // fungsi helper hitung umur
                            // $isiSiswa .= "📝 {$siswa->nama_siswa} ({$kelas} - {$nis}) | {$umur} th}\n";
                            $isiSiswa .= "📝 {$siswa->nama_siswa} ({$kelas} - {$nis})\n";
                        }

                        // pesan kiriman ke WhatsApp
                        $pesanKiriman =
                            ($isiSiswa ?: "⚠️ Tidak ada data ditemukan.\n") . // fallback kalau kosong
                            "\n" . str_repeat("─", 25) . "\n\n" .
                            ("Jumlah Tersedia : {$jumlahData} Siswa\n") . // fallback kalau kosong
                            "\n\n";
                    } elseif ($field === 'sekolah') {
                        // Siswa/Cari/sekolah/SDN Kubangwungu 02/7
                        if (isset($data[4])) {
                            $Caris = Detailsiswa::with('KelasOne')
                                ->where('status_siswa', 'aktif')
                                ->where('tingkat_id', '=', $data[4])
                                ->where('namasek_asal', $keyword)
                                ->get();
                            $jumlahData = $Caris->count();
                        } else {
                            $Caris = Detailsiswa::with('KelasOne')
                                ->where('status_siswa', 'aktif')
                                ->where('namasek_asal', $keyword)
                                ->get();
                            $jumlahData = $Caris->count();
                        }


                        // format hasil pencarian
                        $isiSiswa = '';
                        foreach ($Caris as $siswa) {
                            $kelas = $siswa->kelas->kelas ?? '-'; // ambil nama kelas
                            $nis = $siswa->nis ?? '-'; // ambil NIS
                            $umur = umursiswa($siswa->tanggal_lahir); // fungsi helper hitung umur
                            // $isiSiswa .= "📝 {$siswa->nama_siswa} ({$kelas} - {$nis}) | {$umur} th}\n";
                            $isiSiswa .= "📝 {$siswa->nama_siswa} ({$kelas} - {$nis})\n";
                        }

                        // pesan kiriman ke WhatsApp
                        $pesanKiriman =
                            ($isiSiswa ?: "⚠️ Tidak ada data ditemukan.\n") . // fallback kalau kosong
                            "\n" . str_repeat("─", 25) . "\n\n" .
                            ("Jumlah Tersedia : {$jumlahData} Siswa\n") . // fallback kalau kosong
                            "\n\n";
                    } else {
                        $Caris = Detailsiswa::with('KelasOne')
                            ->where('status_siswa', 'aktif')
                            ->where($dbField, 'like', '%' . $keyword . '%')
                            ->get();
                        $jumlahData = $Caris->count();


                        // format hasil pencarian
                        $isiSiswa = '';
                        foreach ($Caris as $siswa) {
                            $kelas = $siswa->kelas->kelas ?? '-'; // ambil nama kelas
                            $nis = $siswa->nis ?? '-'; // ambil NIS
                            $umur = umursiswa($siswa->tanggal_lahir); // fungsi helper hitung umur
                            // $isiSiswa .= "📝 {$siswa->nama_siswa} ({$kelas} - {$nis}) | {$umur} th}\n";
                            $isiSiswa .= "📝 {$siswa->nama_siswa} ({$kelas} - {$nis})\n";
                        }

                        // pesan kiriman ke WhatsApp
                        $pesanKiriman =
                            ($isiSiswa ?: "⚠️ Tidak ada data ditemukan.\n") . // fallback kalau kosong
                            "\n" . str_repeat("─", 25) . "\n\n" .
                            ("Jumlah Tersedia : {$jumlahData} Siswa\n") . // fallback kalau kosong
                            "\n\n";
                    }
                } else {

                    $Caris = collect();


                    $jumlahData = $Caris->count();
                    // format hasil pencarian
                    $isiSiswa = '';
                    foreach ($Caris as $siswa) {
                        $kelas = $siswa->kelas->kelas ?? '-'; // ambil nama kelas
                        $nis = $siswa->nis ?? '-'; // ambil NIS
                        $umur = umursiswa($siswa->tanggal_lahir); // fungsi helper hitung umur
                        // $isiSiswa .= "📝 {$siswa->nama_siswa} ({$kelas} - {$nis}) | {$umur} th}\n";
                        $isiSiswa .= "📝 {$siswa->nama_siswa} ({$kelas} - {$nis})\n";
                    }

                    // pesan kiriman ke WhatsApp
                    $pesanKiriman =
                        ($isiSiswa ?: "⚠️ Tidak ada data ditemukan.\n") . // fallback kalau kosong
                        "\n" . str_repeat("─", 25) . "\n\n" .
                        ("Jumlah Tersedia : {$jumlahData} Siswa\n") . // fallback kalau kosong
                        "\n\n";
                }


                // kirim ke WhatsApp Gateway
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan("Data {$Kode}", $pesanKiriman));
                break;

            default:
                $pesanKiriman = "Kode Pesan anda *$Kode* Tidak ditemukan";
                break;
        }
    }
}
