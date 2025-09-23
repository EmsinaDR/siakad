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
        | 📌 KartuHelper :
        |--------------------------------------------------------------------------
        |
        | Fitur :
        | - Pembuatan Kartu NISN
        | - Pembuatan Kartu Karpel
        |
        | Tujuan :
        | - membuadahkan generate kartu
        |
        | Penggunaan :
        | - id siswa, dan kode karpel
        |
    */

// Proses Coding
if (!function_exists('generatekarpel_depan')) {
    function generatekarpel_depan($id, $template, $folder)
    {
        $Identitas = Identitas::first();

        $Siswa = Detailsiswa::find($id);

        if (!$Siswa) {
            return false;
        }
        //Jl. Makensi Kec. Banjarharjo Kab Brebes 52265
        $lebar = 3570.28 / 2;
        if (!$Siswa->jalan) {
            $jalan = $Siswa->jalan;
        } else {
            $jalan = $Siswa->jalan . ' ';
        }
        if (!$Siswa->desa) {
            $desa = '';
        } else {
            $desa = ' Desa ' . $Siswa->desa;
        }
        $data = [
            'logo' => 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/logo.png'))),
            'tutwuri'     => 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/template/nisn/img/tutwuri.png'))),
            'stempel'     => 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/template/ttd/stempel.png'))),
            'ttd_kepala'     => 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/template/ttd/kepala.png'))),
            'nama_sekolah' => strtoupper($Identitas->namasek),
            'nama_kepala' => strtoupper($Identitas->namakepala),
            'akreditasi_sekolah' => $Identitas->akreditasi,
            'alamat_sekolah' => $Identitas->jalan . ' Kec. ' . $Identitas->kecamatan . ' Kab. ' . $Identitas->kabupaten . ' ' . $Identitas->kode_pos,
            'nama_siswa' => $Siswa->nama_siswa,
            'alamat_siswa' => $Siswa->alamat_siswa,
            'nis' => $Siswa->nis,
            'nisn' => $Siswa->nisn,
            'tempat_lahir' => $Siswa->tempat_lahir,
            'tanggal_lahir' => \Carbon\Carbon::create($Siswa->tanggal_lahir)->translatedFormat('d F Y'),
            'alamat' => $jalan . 'Rt ' . $Siswa->rt . ' Rw ' . $Siswa->rw . $desa,
            'kecamatan' => $Siswa->kecamatan,
            'kabupaten' => $Siswa->kabupaten,
            'kode_pos' => $Siswa->kode_pos,
            'lebar' => $lebar,
            // img\template\karpel\data
            'foto'     => 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/template/akun-fake.png'))),
        ];

        $svgPath = public_path($folder . '/karpel_' . $template . '.svg');
        if (!file_exists($svgPath)) {
            return false;
        }

        $templateSvg = file_get_contents($svgPath);
        foreach ($data as $key => $value) {
            $templateSvg = str_replace('{{' . $key . '}}', htmlspecialchars($value), $templateSvg);
        }

        $basePath = base_path('public/temp');
        if (!file_exists($basePath)) {
            mkdir($basePath, 0777, true);
        }

        $filename = $Siswa->nis;
        $tempSvg = "$basePath/{$filename}.svg";
        $outputPng = "$basePath/{$filename}.png";

        file_put_contents($tempSvg, $templateSvg);

        $magick = '"C:\\Program Files\\ImageMagick-7.1.2-Q16-HDRI\\magick.exe"';
        $command = "$magick -density 300 \"$tempSvg\" -resize 1004x650 -quality 100 \"$outputPng\"";
        exec($command . ' 2>&1', $output, $result);

        if ($result !== 0 || !file_exists($outputPng)) {
            return false;
        }

        $savePath = public_path("img/karpel/{$filename}.png");

        if (!rename($outputPng, $savePath)) {
            return false;
        }

        return [
            'path' => $savePath,
            'url' => asset("img/karpel/{$filename}.png"),
            'filename' => "{$filename}.png"
        ];
        // controller tambahkan untuk download return response()->download($result['path'], $result['filename'])->deleteFileAfterSend(false);
    }
}
if (!function_exists('generatekarpel_belakang')) {
    function generatekarpel_belakang($id, $template, $folder)
    {
        $Identitas = Identitas::first();
        $Siswa = Detailsiswa::find($id);

        if (!$Siswa) {
            return false;
        }

        // QR Code
        $QrBase64 = QrBase64($Siswa->nis, 300, 'png');
        $qrcode = $QrBase64;
        // Daftar poin
        $items = [
            'Meningkatkan sopan santun di lingkungan',
            'Membudayakan sapa, salam, senyum di sekolah',
            'Disiplin dan bertanggung jawab',
        ];
        // Buat text SVG poin
        $x = 13418.62; //" class="fil6 fnt3"
        // $x = 61419.94; // 2
        // $y = 12000.2;
        $y = 11000.2; // 2
        $lineHeight = 750;
        $wrappedText = '';
        if ($template === 1 || $template === 2) {
            $classtyle = 'fil7 fnt3';
        } else {
            $classtyle = 'text-list';
        }
        foreach ($items as $item) {
            list($tspans, $lineCount) = wrap_text_to_tspans($item, 42, $x, $lineHeight); // <= 42 karakter max!
            $wrappedText .= '<text x="' . $x . '" y="' . $y . '" class="' . $classtyle . '">' . "\n";
            $wrappedText .= $tspans;
            $wrappedText .= "</text>\n";
            $y += $lineCount * $lineHeight + 300; // spacing antar poin
        }
        // Data pengganti template
        $data = [
            'logo' => 'img/logo.png',
            // 'nama_sekolah' => 'Manarul Huda Padakaton',
            'nama_sekolah' => $Identitas->namasek,
            'akreditasi_sekolah' => $Identitas->akreditasi,
            'alamat_sekolah' => $Identitas->jalan . ' Kec.' . $Identitas->kecamatan . ' Kab.' . $Identitas->kabupaten . ' ' . $Identitas->kode_pos,
            'nama_siswa' => $Siswa->nama_siswa,
            'nis' => $Siswa->nis,
            'nisn' => $Siswa->nisn,
            'tempat_lahir' => $Siswa->tempat_lahir,
            'tanggal_lahir' => \Carbon\Carbon::create($Siswa->tanggal_lahir)->translatedFormat('d F Y'),
            'alamat' => $Siswa->jalan . ' Rt ' . $Siswa->rt . ' Rw ' . $Siswa->rw . ' Desa ' . $Siswa->desa,
            'kecamatan' => $Siswa->kecamatan,
            'kabupaten' => $Siswa->kabupaten,
            'kode_pos' => $Siswa->kode_pos,
            'qrcode' => $qrcode,
            'daftar_poin' => $wrappedText,
        ];
        // dd($qrcode);

        // Baca file SVG template
        $svgPath = public_path($folder . '/back_' . $template . '.svg');
        if (!file_exists($svgPath)) {
            return false;
        }

        $templateSvg = file_get_contents($svgPath);

        // Ganti variabel dengan konten, kecuali beberapa dibiarkan raw
        $rawKeys = ['daftar_poin'];
        foreach ($data as $key => $value) {
            $templateSvg = str_replace(
                '{{' . $key . '}}',
                in_array($key, $rawKeys) ? $value : htmlspecialchars($value),
                $templateSvg
            );
        }

        // Simpan file SVG sementara
        $basePath = base_path('public/temp');
        if (!file_exists($basePath)) {
            mkdir($basePath, 0777, true);
        }

        $filename = $Siswa->nis;
        $tempSvg = "$basePath/{$filename}.svg";
        $outputPng = "$basePath/{$filename}.png";

        file_put_contents($tempSvg, $templateSvg);

        // Convert ke PNG pakai ImageMagick
        $magick = '"C:\\Program Files\\ImageMagick-7.1.2-Q16-HDRI\\magick.exe"';
        $command = "$magick -density 300 \"$tempSvg\" -resize 1004x650 -quality 100 \"$outputPng\"";
        exec($command . ' 2>&1', $output, $result);

        if ($result !== 0 || !file_exists($outputPng)) {
            return false;
        }

        $savePath = public_path("img/karpel/belakang_{$filename}.png");

        if (!rename($outputPng, $savePath)) {
            return false;
        }

        return [
            'path' => $savePath,
            'url' => asset("img/karpel/belakang_{$filename}.png"),
            'filename' => "{$filename}.png"
        ];
    }
}
// GenerateNISN
// Proses Coding
if (!function_exists('generateNisn')) {
    function generateNisn($IdSiswa, $template, $folder)
    {
        $Identitas = Identitas::first();
        $Siswa = Detailsiswa::find($IdSiswa);

        // $dataqr = $dataSiswa['nisn'] . "\n" . $dataSiswa['nama_siswa'] . "\nMI Nurul Huda Cikandang";
        $gambar = [
            'logodapodik' => 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/template/nisn/img/logodapodik.png'))),
            'logodinas'   => 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/template/nisn/img/logodinas.png'))),
            'masking'     => 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/template/nisn/img/masking.png'))),
            'tutwuri'     => 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/template/nisn/img/tutwuri.png'))),
            'logonisn'     => 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/template/nisn/img/logonisn.png'))),
            // 'foto'     => 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/template/Foto/' . $dataSiswa['nama_siswa'] . '.jpg'))),
            'foto'     => 'data:image/jpeg;base64,' . base64_encode(file_get_contents(public_path('img/template/Foto/' . $Siswa->nis . '.jpg'))),
            // 'foto' => 'data:image/jpeg;base64,' . base64_encode(file_get_contents(public_path('img/template/Foto/001.jpg'))),
            'nis'               => $Siswa->nis,
            'nisn'              => $Siswa->nisn,
            'tanggal_lahir'     => $Siswa->tanggal_lahir,
            'tempat_lahir'      => $Siswa->tempat_lahir,
            'alamat_siswa'      => $Siswa->alamat_siswa,
            'qrcode'            => qrttd($Siswa->nis),
        ];
        // dd($gambar['foto']);
        $data = array_merge($gambar);

        $svgPath = public_path($folder . '/nisn_depan' . $template . '.svg');
        if (!file_exists($svgPath)) {
            return false;
        }

        $templateSvg = file_get_contents($svgPath);

        foreach ($data as $key => $value) {
            $safeValue = str_starts_with($value, 'data:image/') ? $value : htmlspecialchars($value);
            $templateSvg = str_replace('{{' . $key . '}}', $safeValue, $templateSvg);
        }

        $basePath = base_path('public/temp');
        if (!file_exists($basePath)) {
            mkdir($basePath, 0777, true);
        }

        $filename = $data['nama_siswa'] . '_nisn_depan';
        $tempSvg = "$basePath/{$filename}.svg";
        $outputPng = "$basePath/{$filename}.png";

        file_put_contents($tempSvg, $templateSvg);

        $magick = '"C:\\Program Files\\ImageMagick-7.1.2-Q16-HDRI\\magick.exe"';
        $command = "$magick -density 300 \"$tempSvg\" -resize 1004x650 -quality 100 \"$outputPng\"";
        exec($command . ' 2>&1', $output, $result);

        if ($result !== 0 || !file_exists($outputPng)) {
            return false;
        }

        $savePath = public_path("img/nisn/{$filename}.png");

        if (!rename($outputPng, $savePath)) {
            return false;
        }

        return [
            'path'     => $savePath,
            'url'      => asset("img/nisn/{$filename}.png"),
            'filename' => "{$filename}.png"
        ];
    }
}

if (!function_exists('generateNisnBelakang')) {
    function generateNisnBelakang($dataSiswa, $template, $folder)
    {
        $gambar = [
            'logodapodik' => 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/template/nisn/img/logodapodik.png'))),
            'logodinas'   => 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/template/nisn/img/logodinas.png'))),
            'masking'     => 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/template/nisn/img/masking.png'))),
            'tutwuri'     => 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/template/nisn/img/tutwuri.png'))),
            'logonisn'     => 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/template/nisn/img/logonisn.png'))),
            'foto'     => 'data:image/jpeg;base64,' . base64_encode(file_get_contents(public_path('img/template/Foto/' . $dataSiswa['nama_siswa'] . '.jpg'))),
            // 'foto'     => 'data:image/jpeg;base64,' . base64_encode(file_get_contents(public_path('img/template/Foto/001.jpg'))),
            // 'foto' => 'data:image/jpeg;base64,' . base64_encode(file_get_contents(public_path('img/template/Foto/001.jpg'))),

            'qrcode'     => qrttd($dataSiswa['nisn']),
        ];
        // dd($gambar['foto']);
        $data = array_merge($dataSiswa, $gambar);

        $svgPath = public_path($folder . '/nisn_belakang' . $template . '.svg');
        if (!file_exists($svgPath)) {
            return false;
        }

        $templateSvg = file_get_contents($svgPath);

        foreach ($data as $key => $value) {
            $safeValue = str_starts_with($value, 'data:image/') ? $value : htmlspecialchars($value);
            $templateSvg = str_replace('{{' . $key . '}}', $safeValue, $templateSvg);
        }

        $basePath = base_path('public/temp');
        if (!file_exists($basePath)) {
            mkdir($basePath, 0777, true);
        }

        $filename = $data['nama_siswa'] . '_nisn_belakang';
        $tempSvg = "$basePath/{$filename}.svg";
        $outputPng = "$basePath/{$filename}.png";

        file_put_contents($tempSvg, $templateSvg);

        $magick = '"C:\\Program Files\\ImageMagick-7.1.2-Q16-HDRI\\magick.exe"';
        $command = "$magick -density 300 \"$tempSvg\" -resize 1004x650 -quality 100 \"$outputPng\"";
        exec($command . ' 2>&1', $output, $result);

        if ($result !== 0 || !file_exists($outputPng)) {
            return false;
        }

        $savePath = public_path("img/nisn/{$filename}.png");
        if (!rename($outputPng, $savePath)) {
            return false;
        }

        return [
            'path'     => $savePath,
            'url'      => asset("img/nisn/{$filename}.png"),
            'filename' => "{$filename}.png"
        ];
    }
}
// Kartu Pembayaran
if (!function_exists('KartuPembayaran')) {
    function KartuPembayaran($id, $template_id, $folder)
    {
        $Identitas = Identitas::first();

        $Siswa = Detailsiswa::with('kelasOne')->find($id);
        if (!$Siswa) {
            return false;
        }
        //Jl. Makensi Kec. Banjarharjo Kab Brebes 52265
        $lebar = 3570.28 / 2;
        if (!$Siswa->jalan) {
            $jalan = $Siswa->jalan;
        } else {
            $jalan = $Siswa->jalan . ' ';
        }
        if (!$Siswa->desa) {
            $desa = '';
        } else {
            $desa = ' Desa ' . $Siswa->desa;
        }
        $kelas = $Siswa->kelasOne->kelas;
        if (dinas() === 'kemenag') {
            $logomasking = public_path('img/logo/mask-kemenag.png');
        } else {
            $logomasking = public_path('img/logo/mask-dinas.png');
        }
        $data = [
            'logo' => 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/logo.png'))),
            'tutwuri'     => 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/template/nisn/img/tutwuri.png'))),
            'masking'     => 'data:image/png;base64,' . base64_encode(file_get_contents($logomasking)),
            'nama_sekolah' => strtoupper($Identitas->namasek),
            'akreditasi_sekolah' => $Identitas->akreditasi,
            'alamat_sekolah' => $Identitas->jalan . ' Kec. ' . $Identitas->kecamatan . ' Kab. ' . $Identitas->kabupaten . ' ' . $Identitas->kode_pos,
            'nama_siswa' => $Siswa->nama_siswa,
            'kelas' => $kelas,
            'nis' => $Siswa->nis,
            'nisn' => $Siswa->nisn,
            'tempat_lahir' => $Siswa->tempat_lahir,
            'foto'     => 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('img/template/karpel/data/foto.png'))),
            'qrcode'     => qrttd($Siswa['nisn']),
        ];
        // dd($data['logor']);
        $svgPath = public_path($folder . '/kartu_pembayaran_0' . $template_id . '.svg');

        // dd($svgPath);
        if (!file_exists($svgPath)) {
            return false;
        }

        $templateSvg = file_get_contents($svgPath);

        foreach ($data as $key => $value) {
            $safeValue = str_starts_with($value, 'data:image/') ? $value : htmlspecialchars($value);
            $templateSvg = str_replace('{{' . $key . '}}', $safeValue, $templateSvg);
        }

        $basePath = base_path('public/temp');
        if (!file_exists($basePath)) {
            mkdir($basePath, 0777, true);
        }


        $filename = $Siswa->nis;
        $tempSvg = "$basePath/{$filename}.svg";
        $outputPng = "$basePath/{$filename}.png";

        file_put_contents($tempSvg, $templateSvg);



        $magick = '"C:\\Program Files\\ImageMagick-7.1.2-Q16-HDRI\\magick.exe"';
        $command = "$magick -density 300 \"$tempSvg\" -quality 100 \"$outputPng\"";
        exec($command . ' 2>&1', $output, $result);


        if ($result !== 0 || !file_exists($outputPng)) {
            return false;
        }

        $savePath = public_path("img/kartu-pembarayan/{$filename}.png");

        if (!rename($outputPng, $savePath)) {
            return false;
        }

        return [
            'path' => $tempSvg,
            'url' => asset("img/kartu-pembarayan/{$filename}.png"),
            'filename' => "{$filename}.png"
        ];
        // controller tambahkan untuk download return response()->download($result['path'], $result['filename'])->deleteFileAfterSend(false);
    }
}
// Kartu Pembayaran
if (!function_exists('kartu_perputakaan')) {
    function kartu_perputakaan($id, $template, $folder)
    {
        //Isi Fungsi
    }
}
