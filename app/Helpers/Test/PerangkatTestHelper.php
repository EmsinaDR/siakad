<?php

/*
    |----------------------------------------------------------------------
    | 📌 Helper PerangkatTestHelper
    |----------------------------------------------------------------------
    |
*/

use App\Models\User\Siswa\Detailsiswa;

if (!function_exists('bagiKeRuang')) {
    /**
     * Membagi seluruh siswa lintas kelas menjadi pasangan dan ruang
     *
     * @param  int  $jumlahRuang  Jumlah ruang yang diinginkan
     * @return array  Struktur data hasil pembagian (array bertingkat)
     */
    function bagiKeRuang(int $jumlahRuang): array
    {
        // 1️⃣ Ambil semua siswa urut berdasarkan kelas dan NIS
        $siswaList = DetailSiswa::with('kelas')
            ->SiswaAktif()
            ->orderBy('tingkat_id', 'asc')
            ->orderBy('nis', 'asc')
            ->get(); // ✅ ini penting, baru hasilnya collection
        // ->get(['nis', 'nama_siswa', 'tingkat_id']);


        // 2️⃣ Kelompokkan berdasarkan kelas
        $byKelas = $siswaList->groupBy('tingkat_id');

        // 3️⃣ Siapkan array untuk pairing lintas kelas
        $pasangan = [];

        // 4️⃣ Ubah tiap kelas jadi array untuk iterator
        $kelasArrays = [];
        foreach ($byKelas as $tingkat => $list) {
            $kelasArrays[$tingkat] = $list->values()->toArray();
        }

        $tingkatList = array_keys($kelasArrays);
        $indexKelas = array_fill_keys($tingkatList, 0);

        // 5️⃣ Loop buat pairing lintas kelas
        while (true) {
            $kelas1 = null;
            $kelas2 = null;

            foreach ($tingkatList as $tingkat) {
                if ($indexKelas[$tingkat] < count($kelasArrays[$tingkat])) {
                    if (!$kelas1) {
                        $kelas1 = $tingkat;
                    } elseif (!$kelas2) {
                        $kelas2 = $tingkat;
                        break;
                    }
                }
            }

            if (!$kelas1 || !$kelas2) {
                break; // Tidak cukup siswa untuk buat pasangan baru
            }

            $siswa1 = $kelasArrays[$kelas1][$indexKelas[$kelas1]++];
            $siswa2 = $kelasArrays[$kelas2][$indexKelas[$kelas2]++];
            $pasangan[] = [$siswa1, $siswa2];
        }

        // 6️⃣ Hitung pembagian per ruang
        $totalPasangan = count($pasangan);
        $pasanganPerRuang = ceil($totalPasangan / $jumlahRuang);

        // 7️⃣ Bagi ke dalam ruang
        $grupPasangan = array_chunk($pasangan, $pasanganPerRuang);

        return $grupPasangan;

        /*
        Cara akses :
        $ruang = 4; // misalnya mau dibagi jadi 4 ruang
        $hasil = bagiKeRuang($ruang);

        foreach ($hasil as $indexRuang => $grup) {
            echo "\n=====================\n";
            echo "🧩 Ruang " . ($indexRuang + 1) . "\n";
            echo "=====================\n";

            foreach ($grup as $indexPasangan => $pair) {
                $data1 = $pair[0];
                $data2 = $pair[1] ?? null; // kalau gak ada, kasih null

                echo "Pasangan " . str_pad($indexPasangan + 1, 2, '0', STR_PAD_LEFT) . ":";

                // tampilkan siswa pertama
                echo "  {$data1['nis']} - {$data1['nama_siswa']} (Kelas {$data1['kelas']['kelas']})";

                if ($data2) {
                    // kalau ada pasangan kedua
                    echo "  &  {$data2['nis']} - {$data2['nama_siswa']} (Kelas {$data2['kelas']['kelas']})";
                } else {
                    // kalau gak ada pasangan kedua
                    echo "  &  — (tidak ada pasangan)";
                }

                echo "\n";
            }

            echo "\n";
        }
            */
    }
}
// versi lain
if (!function_exists('bagiKelompokAB')) {
    /**
     * Bagi semua siswa aktif jadi dua kelompok (A & B),
     * lalu masukkan ke ruang-ruang (misal 15 A + 15 B per ruang),
     * dan buat pasangan di dalam masing-masing ruang.
     * Sekaligus tambahkan 'index_tingkat' yaitu urutan siswa di tingkatnya.
     *
     * @param  int  $jumlahPerKelompokPerRuang
     * @return array
     */
    function bagiKelompokAB(int $jumlahPerKelompokPerRuang = 15): array
    {
        // 1️⃣ Ambil semua siswa aktif
        $semua = DetailSiswa::with('kelas')
            ->SiswaAktif()
            ->orderBy('kelas_id', 'asc')
            ->orderBy('nis', 'asc')
            ->get()
            ->toArray();

        // 2️⃣ Hitung index urutan tiap tingkat (VII, VIII, IX)
        $indexPerTingkat = [
            '7' => 1,
            '8' => 1,
            '9' => 1,
        ];

        foreach ($semua as &$siswa) {
            // Ambil dua digit pertama dari NIS → tentukan tingkat
            $angkatan = substr($siswa['nis'], 0, 2);

            // Map tahun masuk → tingkat sekarang
            if ($angkatan == '25') {
                $tingkat = '7';
            } elseif ($angkatan == '24') {
                $tingkat = '8';
            } elseif ($angkatan == '23') {
                $tingkat = '9';
            } else {
                $tingkat = 'X'; // kalau format lain
            }

            $siswa['tingkat'] = $tingkat;
            $siswa['index_tingkat'] = $indexPerTingkat[$tingkat] ?? 0;

            // increment untuk tingkat itu
            if (isset($indexPerTingkat[$tingkat])) {
                $indexPerTingkat[$tingkat]++;
            }
        }
        unset($siswa);

        // 3️⃣ Bagi dua kelompok A dan B
        $total = count($semua);
        $setengah = ceil($total / 2);
        $kelompokA = array_slice($semua, 0, $setengah);
        $kelompokB = array_slice($semua, $setengah);

        // 4️⃣ Bagi masing-masing kelompok jadi ruang-ruang
        $ruangA = array_chunk($kelompokA, $jumlahPerKelompokPerRuang);
        $ruangB = array_chunk($kelompokB, $jumlahPerKelompokPerRuang);

        // 5️⃣ Gabungkan A & B per ruang → buat pasangan di dalamnya
        $jumlahRuang = max(count($ruangA), count($ruangB));
        $hasil = [];

        for ($i = 0; $i < $jumlahRuang; $i++) {
            $aList = $ruangA[$i] ?? [];
            $bList = $ruangB[$i] ?? [];

            $maks = max(count($aList), count($bList));
            $pasangan = [];

            for ($j = 0; $j < $maks; $j++) {
                $pasangan[] = [
                    $aList[$j] ?? null,
                    $bList[$j] ?? null,
                ];
            }

            $hasil[$i] = $pasangan;
        }

        return $hasil;

        /*
        Cara Akses
        $hasil = bagiKelompokAB(15);

        foreach ($hasil as $indexRuang => $grup) {
            echo "\n=====================\n";
            echo "🧩 Ruang " . ($indexRuang + 1) . "\n";
            echo "=====================\n";

            foreach ($grup as $indexPasangan => $pair) {
                $data1 = $pair[0];
                $data2 = $pair[1] ?? null;

                echo "Pasangan " . str_pad($indexPasangan + 1, 2, '0', STR_PAD_LEFT) . ":";

                if ($data1) {
                    echo "  {$data1['nis']} - {$data1['nama_siswa']} (Kelas {$data1['kelas']['kelas']})";
                } else {
                    echo "  — (kosong)";
                }

                if ($data2) {
                    echo "  &  {$data2['nis']} - {$data2['nama_siswa']} (Kelas {$data2['kelas']['kelas']})";
                } else {
                    echo "  &  — (tidak ada pasangan)";
                }

                echo "\n";
            }

            echo "\n";
            */
    }
}
