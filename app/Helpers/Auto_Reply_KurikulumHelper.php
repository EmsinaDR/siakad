<?php

use Carbon\Carbon;
use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use App\Models\Admin\Identitas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Console\Command;
use App\Models\Whatsapp\WhatsApp;
use Illuminate\Support\Facades\File;
use App\Models\User\Siswa\Detailsiswa;
use thiagoalessio\TesseractOCR\TesseractOCR;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Str;

/*
    |----------------------------------------------------------------------
    | 📌 Helper Auto_Reply_KurikulumHelper
    |----------------------------------------------------------------------
    |
*/

if (!function_exists('Auto_Reply_KurikulumHelper')) {
    function Auto_Reply_KurikulumHelper($Kode, $NoRequest, $message)
    {
        switch ($Kode) {
            //Konsep Untuk Kirim dan Buat Surat Lewat Whatsapp
            case 'Perangkat Test': // Perangkat Test / Kurikulum / nama test / Ruang#Siswa / Jumlah Ruang / Cetak
                $Identitas = getIdentitas();

                // Perangkat Test / Kurikulum / nama test / Ruang#Siswa / Jumlah Ruang / Cetak
                $message = 'Perangkat Test / Kurikulum / PTS / 2025-9-11 / Ruang / 15 / Cetak';
                $Identitas = getIdentitas();
                // $message = 'Perangkat Test / Kurikulum / PTS';
                $pesan = explode('/', $message); // Memecah Array yang yang telah diterima, lanjut fungsi loop fetch
                $sessions = config('whatsappSession.IdWaUtama');
                if (!config('whatsappSession.WhatsappDev')) {
                    //$NoTujuan = $siswa->no_hp;
                    //$NoTujuan = getNoTujuanOrtu($siswa);
                    $NoTujuan = config('whatsappSession.wakaKurikulum');
                } else {
                    $sessions = config('whatsappSession.IdWaUtama');
                    $NoTujuan = config('whatsappSession.DevNomorTujuan');
                }
                //    Daftar Peserta Test
                $hasil = bagiKelompokAB(15);
                $dataTambahan = [
                    'hasil' => $hasil,
                    'nama_test' => $pesan[2],
                    'bulan' => date('m'),
                    'tahun' => date('Y'),
                ];

                $folder = public_path('temp/perangkat-test');
                /*
                php artisan make:view role.waka.kurikulum.Perangkat.wa-kartu-test
                php artisan make:view role.waka.kurikulum.Perangkat.wa-test-dh
                php artisan make:view role.waka.kurikulum.Perangkat.wa-test-ba
                php artisan make:view role.waka.kurikulum.Perangkat.wa-test-ba
                php artisan make:view role.waka.kurikulum.Perangkat.wa-test-no-meja
                php artisan make:view role.waka.kurikulum.Perangkat.wa-test-no-ruangan

                */
                $view = 'role.waka.kurikulum.Perangkat.wa-peserta-test';
                $filename = 'peserta-test';
                // DomExport($filename, $dataTambahan, $view, $folder);

                // Kartu Test

                // Kumpulan kartu hasil render
                $kartuList = [];

                // Perangkat Test / Kurikulum / nama test / Ruang#Siswa / Jumlah Ruang / Cetak
                $Identitas = getIdentitas();
                $pesan = explode('/', $message); // Memecah Array yang yang telah diterima, lanjut fungsi loop fetch
                $tanggal = Carbon::create($pesan[3])->translatedformat('d F Y');
                // dd($tanggal);
                $sessions = config('whatsappSession.IdWaUtama');
                if (!config('whatsappSession.WhatsappDev')) {
                    //$NoTujuan = $siswa->no_hp;
                    //$NoTujuan = getNoTujuanOrtu($siswa);
                    $NoTujuan = config('whatsappSession.wakaKurikulum');
                } else {
                    $sessions = config('whatsappSession.IdWaUtama');
                    $NoTujuan = config('whatsappSession.DevNomorTujuan');
                }
                //    Daftar Peserta Test
                $hasil = bagiKelompokAB(15);
                $dataTambahan = [
                    'hasil' => $hasil,
                    'nama_test' => $pesan[2],
                    'bulan' => date('m'),
                    'tahun' => date('Y'),
                ];

                $folder = public_path('temp/perangkat-test');
                $view = 'role.waka.kurikulum.Perangkat.wa-peserta-test';
                $filename = 'peserta-test';
                DomExport($filename, $dataTambahan, $view, $folder);

                // Kartu Test
                // Kumpulan kartu hasil render
                $kartuList = [];


                foreach ($hasil as $indexRuang => $grup) {
                    $namaRuang = 'Ruang ' . ($indexRuang + 1);
                    $romawiRuang = angka_romawi($indexRuang + 1);
                    foreach ($grup as $pasangan) {
                        foreach ($pasangan as $siswa) {
                            if (!$siswa) continue;

                            $foto = $siswa['foto']
                                ? 'foto/' . $siswa['foto']
                                : 'img/dafault/blanko-foto.png';

                            $kelas = $siswa['kelas']['kelas'] ?? '-';

                            // 🔢 no_test sesuai format yang Bro minta
                            $no_test = str_pad($siswa['index_tingkat'], 3, '0', STR_PAD_LEFT)
                                . '/R' . $romawiRuang
                                . '/' . $kelas
                                . '/' . $dataTambahan['nama_test']
                                . '/' . $dataTambahan['bulan']
                                . '/' . $dataTambahan['tahun'];
                            $nama_siswa = strtoupper($siswa['nama_siswa']);
                            $text = " {$Identitas->namasek}\n{$dataTambahan['nama_test']}\n{$nama_siswa}\n{$kelas}\n{$no_test}";
                            $qrttd = qrttd($text, 300);
                            // 🧩 data untuk SVG
                            $data = [
                                'nama_siswa' => strtoupper($siswa['nama_siswa']),
                                'nama_sekolah' => strtoupper($Identitas->namasek),
                                'nama_kepala' => strtoupper($Identitas->namakepala),
                                'nis' => strtoupper($siswa['nis']),
                                'kelas' => $kelas,
                                'ruang' => $namaRuang,
                                'no_test' => $no_test,
                                'nama_test' => $dataTambahan['nama_test'],
                                'bulan' => $dataTambahan['bulan'],
                                'tahun' => $dataTambahan['tahun'],
                                'logo' => public_path('img/logo/logo.png'),
                                'stempel' => public_path('img/template/ttd/stempel.png'),
                                'ttd' => public_path('img/template/ttd/kepala.png'),
                                'qrttd' => $qrttd,
                                'nip_kepala' => $Identitas->nip_kepala ?? '-',
                                'penanggalan' => $Identitas->kecamatan . ", " . $tanggal,
                                'alamat_sekolah' => $Identitas->alamat,
                            ];

                            // 🔄 Subfolder dinamis berdasarkan jenis perangkat
                            $subFolder = 'perangkat-test/kartu';

                            // 🧠 Render SVG ke file dan dapatkan URL-nya
                            $svgUrl = render_svg_dynamic('kartu_test_1', $data, 'img/template/kartu_test', $subFolder);
                            // Convert ke PNG pakai ImageMagick
                            $pngDir = public_path('temp/perangkat-test/kartu/png');
                            if (!File::exists($pngDir)) {
                                File::makeDirectory($pngDir, 0755, true);
                            }

                            $tempSvg = public_path("temp/perangkat-test/kartu/{$siswa['nis']}.svg");
                            $outputPng = "$pngDir/{$siswa['nis']}.png";

                            $magick = '"C:\\Program Files\\ImageMagick-7.1.2-Q16-HDRI\\magick.exe"';
                            $command = "$magick -density 300 \"$tempSvg\" -background white -flatten -resize 1004x650 -quality 100 \"$outputPng\"";

                            exec($command . ' 2>&1', $output, $result);
                            echo implode("\n", $output);
                            if ($result !== 0) {
                                echo "Error konversi: $result\n";
                            } else {
                                echo "PNG tersimpan: $outputPng\n";
                            }
                        }
                    }
                }


                // Folder PNG dan PDF
                $pngFolder = public_path('temp/perangkat-test/kartu/png');
                $pdfFolder = public_path('temp/perangkat-test/pdf');

                if (!File::exists($pdfFolder)) {
                    File::makeDirectory($pdfFolder, 0777, true, true);
                }

                $pngFiles = File::files($pngFolder);
                if (empty($pngFiles)) {
                    // $this->info("❌ Tidak ada file PNG ditemukan di: $pngFolder");
                    return Command::SUCCESS;
                }

                $pngList = [];
                foreach ($pngFiles as $file) {
                    if (strtolower($file->getExtension()) === 'png') {
                        $pngList[] = $file->getPathname();
                    }
                }

                if (empty($pngList)) {
                    // $this->info('❌ Tidak ada file PNG valid.');
                    return Command::SUCCESS;
                }

                // $this->info("✅ Ditemukan " . count($pngList) . " file PNG.");

                $batch = [];
                $pdfIndex = 1;
                $perPdf = 8;

                foreach ($pngList as $i => $pngPath) {
                    $nama = pathinfo($pngPath, PATHINFO_FILENAME);
                    $batch[] = [
                        'svg' => $pngPath,
                        'nama_siswa' => $nama,
                        'kelas' => '-',
                        'ruang' => '-',
                    ];

                    if (count($batch) == $perPdf || $i == count($pngList) - 1) {
                        $filename = "kartu-test-{$pdfIndex}.pdf";
                        $filepath = $pdfFolder . '/' . $filename;
                        $dataView = ['kartuList' => $batch];

                        try {
                            Pdf::loadView('role.waka.kurikulum.Perangkat.wa-kartu-test', $dataView)
                                ->setPaper([0, 0, 612, 396])
                                ->save($filepath);
                            // $this->info("✅ PDF tersimpan: $filename");
                        } catch (\Exception $e) {
                            // $this->error("❌ Gagal buat $filename: " . $e->getMessage());
                        }

                        $batch = [];
                        $pdfIndex++;
                    }
                }
                // Setelah loop selesai
                // use setasign\Fpdi\Fpdi;
                // Merge pdf
                $pdfFolder = public_path('temp/perangkat-test/pdf');
                $pdfFiles = File::files($pdfFolder);

                if (!empty($pdfFiles)) {
                    $mergedFilePath = $pdfFolder . '/kartu-test-merged.pdf';
                    $pdf = new Fpdi();

                    foreach ($pdfFiles as $file) {
                        if (strtolower($file->getExtension()) === 'pdf') {
                            $pageCount = $pdf->setSourceFile($file->getPathname());
                            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                                $tplIdx = $pdf->importPage($pageNo);

                                // 🔍 Ambil ukuran asli halaman
                                $size = $pdf->getTemplateSize($tplIdx);

                                // 📏 Buat halaman baru dengan ukuran sama persis
                                $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);

                                // 🧩 Gunakan template dengan ukuran asli
                                $pdf->useTemplate($tplIdx, 0, 0, $size['width'], $size['height']);
                            }
                        }
                    }


                    $pdf->Output($mergedFilePath, 'F');
                    echo "✅ PDF gabungan tersimpan: $mergedFilePath\n";
                }

                $PesanKirim =
                    "isiPesan \n" .
                    "\n";

                // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, format_pesan('Perangkat Test', $PesanKirim));
                break;
            //case 'Siswa':
            //break;
            default:
                $pesanKiriman = "Kode Pesan anda *$Kode* Tidak ditemukan";
                break;
        }
    }
}
