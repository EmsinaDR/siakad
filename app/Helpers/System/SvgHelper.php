<?php

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Whatsapp\WhatsApp;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use App\Models\User\Siswa\Detailsiswa;

/*
        |--------------------------------------------------------------------------
        | 📌 SvgHelper :
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
if (!function_exists('wrap_text_to_tspans')) {
    function wrap_text_to_tspans($text, $maxChars = 42, $x = 13418.62, $lineHeight = 750)
    {
        $lines = wordwrap($text, $maxChars, "\n", true);
        $lines = explode("\n", $lines);
        $tspans = '';
        foreach ($lines as $i => $line) {
            $dy = $i === 0 ? 0 : $lineHeight;
            $bullet = $i === 0 ? '• ' : '  ';
            $tspans .= '<tspan x="' . $x . '" dy="' . $dy . '">' . $bullet . htmlspecialchars($line) . '</tspan>' . "\n";
        }
        return [$tspans, count($lines)];
    }
}
if (!function_exists('generate_personalized_svg')) {
    function generate_personalized_svg($data)
    {
        $templatePath = public_path('img/template/cocard/' . $data->kode . '.svg');

        if (!file_exists($templatePath)) {
            return null;
        }

        $svg = file_get_contents($templatePath);

        // Ganti placeholder
        $replacements = [
            '{nama}'       => $data->nama,
            '{kode}'       => $data->kode,
            '{kelas}'      => $data->kelas ?? '',
            '{keterangan}' => $data->keterangan ?? '',
            // Tambahkan jika perlu
        ];

        foreach ($replacements as $key => $value) {
            $svg = str_replace($key, $value, $svg);
        }

        // Buat folder jika belum ada
        $outputDir = storage_path('app/public/tmp');
        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0777, true);
        }

        // Auto hapus file lama (lebih dari 5 menit)
        foreach (glob($outputDir . '/cocard-*.svg') as $file) {
            if (filemtime($file) < time() - 300) {
                unlink($file);
            }
        }

        // Simpan hasil SVG ke file baru
        $outputPath = $outputDir . '/cocard-' . $data->kode . '.svg';
        file_put_contents($outputPath, $svg);

        // Kembalikan URL yang bisa dipakai di <img>
        return asset('storage/tmp/cocard-' . $data->kode . '.svg');
    }
}
if (!function_exists('render_svg_inline')) {
    function render_svg_inline($kode, $variables = [])
    {
        $templatePath = public_path('img/template/cocard/' . $kode . '.svg');

        if (!file_exists($templatePath)) {
            return '<!-- SVG template not found -->';
        }

        $svg = file_get_contents($templatePath);

        foreach ($variables as $key => $value) {
            $svg = str_replace('{' . $key . '}', e($value), $svg); // `e()` buat amankan isi
        }

        return $svg; // nanti ditampilkan pakai `{!! ... !!}`
    }
}
if (!function_exists('render_svg_base64')) {
    function render_svg_base64($kode, $variables = [])
    {
        $templatePath = public_path('img/template/cocard/' . $kode . '.svg');

        if (!file_exists($templatePath)) {
            return '';
        }

        $svg = file_get_contents($templatePath);

        foreach ($variables as $key => $value) {
            // Cek apakah value adalah path gambar (png, jpg, jpeg, svg)
            if (is_string($value) && preg_match('/\.(png|jpe?g|svg)$/i', $value)) {
                $imagePath = public_path($value);
                if (file_exists($imagePath)) {
                    $mime = mime_content_type($imagePath);
                    $imageData = base64_encode(file_get_contents($imagePath));

                    // Default ukuran & posisi (bisa diganti kalau mau)
                    $value = 'data:' . $mime . ';base64,' . $imageData;
                } else {
                    $value = '<!-- Gambar ' . $key . ' tidak ditemukan -->';
                }
            } else {
                // Teks biasa
                $value = e($value);
            }

            $svg = str_replace('{' . $key . '}', $value, $svg);
        }

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }
}
if (!function_exists('svghaji')) {
    function svghaji($index, $data, $templateName = 'template.svg', $backgroundName = 'background.png')
    {
        // Path template SVG
        $templatePath = public_path('img/template/haji/' . $templateName);
        if (!file_exists($templatePath)) {
            return null;
        }

        $svg = file_get_contents($templatePath);

        // Background embed Base64
        $backgroundPath = public_path('img/template/haji/' . $backgroundName);
        $background = file_exists($backgroundPath)
            ? 'data:image/png;base64,' . preg_replace('/\s+/', '', base64_encode(file_get_contents($backgroundPath)))
            : '';

        // Foto peserta embed Base64
        $namafoto = $data['foto'];
        $fotoPath = public_path("img/template/haji/foto/" . $namafoto);
        $foto = file_exists($fotoPath)
            ? 'data:image/jpeg;base64,' . preg_replace('/\s+/', '', base64_encode(file_get_contents($fotoPath)))
            : '';

        // Replacements
        $replacements = [
            '{nama}'       => $data['nama'] ?? '',
            '{kabupaten}'  => $data['kabupaten'] ?? '',
            '{passport}'   => $data['passport'] ?? '',
            '{alamat}'     => $data['alamat'] ?? '',
            '{no_hp}'      => $data['no_hp'] ?? '',
            '{kecamatan}'  => $data['kecamatan'] ?? '',
            '{kode_pos}'   => $data['kode_pos'] ?? '',
            '{background}' => $background,
            '{foto}'       => $foto,
        ];

        // Replace: teks di-escape, foto & background langsung
        foreach ($replacements as $key => $value) {
            if (in_array($key, ['{foto}', '{background}'])) {
                $svg = str_replace($key, $value, $svg); // langsung Base64
            } else {
                $svg = str_replace($key, htmlspecialchars($value, ENT_QUOTES), $svg);
            }
        }

        // Folder output
        $outputDir = storage_path('app/public/tmp');
        if (!file_exists($outputDir)) mkdir($outputDir, 0777, true);
        if (!file_exists("$outputDir/png")) mkdir("$outputDir/png", 0777, true);

        // Nama file output
        $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $data['nama'] ?? 'noname');
        $baseName = pathinfo($templateName, PATHINFO_FILENAME);
        $outputName = "{$baseName}-{$safeName}.svg";
        $outputPath = $outputDir . '/' . $outputName;

        // Simpan SVG final
        file_put_contents($outputPath, $svg);

        // Path PNG
        $tempSvg = "$outputDir/{$outputName}";
        $outputPng = "$outputDir/png/{$safeName}.png";

        // Convert ke PNG pakai ImageMagick
        $magick = '"C:\\Program Files\\ImageMagick-7.1.2-Q16-HDRI\\magick.exe"';
        $command = "$magick -density 300 \"$tempSvg\" -background white -flatten -resize 1004x650 -quality 100 \"$outputPng\"";
        exec($command . ' 2>&1', $output, $result);

        return [
            'svg'      => asset('storage/tmp/' . basename($outputPath)),
            'png'      => asset('storage/tmp/png/' . $safeName . '.png'),
            'path'     => $outputDir,
            'namafile' => $outputName,
        ];
    }
}


/*
penggunaan :
$url = replacesvgvariabel([
    'nama'            => 'H. Rudi Mahendra',
    'passport'        => 'C7788123',
    'alamat'          => 'Jl. Kenanga No. 3, Bandung',
    'template_path'   => public_path('img/template/haji/template.svg'),

    // Gambar dinamis (sebanyak apapun bisa)
    'foto'            => public_path('img/foto/rudi.png'),
    'img_qrcode'      => public_path('img/qrcode/rudi.png'),
    'img_logo'        => 'https://example.com/logo.png',
    'img_ttd'         => public_path('img/stempel/ttd.png'),
    'img_cap'         => public_path('img/stempel/cap.png'),
    'background'      => public_path('img/template/haji/background.png'),
], 'haji_');


*/
if (!function_exists('replacesvgvariabel')) {
    /**
     * Render SVG dengan data dan gambar dinamis.
     *
     * @param array  $data           Data berisi key => value untuk menggantikan placeholder {key}.
     *                               Bisa juga berisi path gambar (local path, base64, atau URL).
     * @param string $outputPrefix   Prefix nama file output (opsional).
     *
     * @return string|null URL hasil SVG (asset), atau null jika gagal.
     */
    function replacesvgvariabel(array $data, string $outputPrefix = '')
    {
        // Pastikan ada template_path
        if (empty($data['template_path']) || !file_exists($data['template_path'])) {
            return null;
        }

        $svg = file_get_contents($data['template_path']);

        // ==========================================
        // 🔧 Helper untuk encode gambar (file/base64/url)
        // ==========================================
        $encodeImage = function ($source) {
            if (!$source) return '';

            // Jika sudah base64, langsung kembalikan
            if (preg_match('/^data:image\/[a-zA-Z]+;base64,/', $source)) {
                return $source;
            }

            // Jika URL (http/https), ambil kontennya
            if (preg_match('/^https?:\/\//', $source)) {
                $imageData = @file_get_contents($source);
                if ($imageData === false) return '';
                $ext = strtolower(pathinfo(parse_url($source, PHP_URL_PATH), PATHINFO_EXTENSION));
                $mime = $ext === 'jpg' ? 'jpeg' : $ext;
                return 'data:image/' . $mime . ';base64,' . base64_encode($imageData);
            }

            // Jika path file lokal
            if (file_exists($source)) {
                $ext = strtolower(pathinfo($source, PATHINFO_EXTENSION));
                $mime = $ext === 'jpg' ? 'jpeg' : $ext;
                return 'data:image/' . $mime . ';base64,' . base64_encode(file_get_contents($source));
            }

            return '';
        };

        // ==========================================
        // 🔁 Loop semua data jadi replacement
        // ==========================================
        $replacements = [];

        foreach ($data as $key => $value) {
            // Lewatkan template_path agar tidak ditulis ke SVG
            if ($key === 'template_path') continue;

            // Jika value adalah gambar (deteksi dari key atau ekstensi)
            if (
                str_starts_with($key, 'img_') ||
                str_starts_with($key, 'foto') ||
                str_starts_with($key, 'gambar') ||
                str_starts_with($key, 'icon') ||
                preg_match('/\.(png|jpg|jpeg|gif|svg)$/i', (string) $value)
            ) {
                $value = $encodeImage($value);
            }

            // Simpan placeholder
            $replacements['{' . $key . '}'] = htmlspecialchars((string)$value, ENT_QUOTES);
        }

        // ==========================================
        // 🔄 Ganti semua placeholder di SVG
        // ==========================================
        $svg = strtr($svg, $replacements);

        // ==========================================
        // 💾 Simpan hasil render
        // ==========================================
        $outputDir = storage_path('app/public/tmp');
        if (!file_exists($outputDir)) mkdir($outputDir, 0777, true);

        $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $data['nama'] ?? 'noname');
        $baseName = pathinfo($data['template_path'], PATHINFO_FILENAME);
        $outputName = "{$outputPrefix}{$baseName}-{$safeName}.svg";

        $outputPath = $outputDir . '/' . $outputName;
        file_put_contents($outputPath, $svg);

        return asset('storage/tmp/' . basename($outputPath));
    }
}

/*
|--------------------------------------------------------------------------
| 📌 generate_svg_base64()
|--------------------------------------------------------------------------
|
| Fitur :
| - Mengubah string SVG menjadi base64 data URL.
|
| Tujuan :
| - Embed SVG inline ke dalam HTML atau PDF.
|
| Penggunaan :
| - $svg = '<svg>...</svg>';
| - echo '<img src="' . generate_svg_base64($svg) . '">';
|
*/
if (!function_exists('generate_svg_base64')) {
    function generate_svg_base64(string $svg): string
    {
        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }
}

/*
versi lain dari generate_svg_base64()
SVG to Base64
Dari file SVG di storage/public/tmp:
$svgPath = storage_path('app/public/tmp/haji_0_template-Idham_Mahdiana.svg');
$svgBase64 = svgtobase64($svgPath);
echo "<img src='{$svgBase64}' width='300'>";

Dari hasil replacesvgvariabel() langsung:
$url = replacesvgvariabel($data, 'haji_');
$svgFile = str_replace(asset('storage/tmp/'), storage_path('app/public/tmp/'), $url);
$base64 = svgtobase64($svgFile);
echo "<img src='{$base64}' width='200'>";

Atau langsung dari string SVG (tanpa file):
$svgString = '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200">
    <rect width="200" height="200" fill="gold"/>
    <text x="20" y="100" font-size="20" fill="black">Assalamualaikum</text>
</svg>';

echo '<img src="' . svgtobase64($svgString) . '" />';



*/

if (!function_exists('svgtobase64')) {
    /**
     * Ubah file SVG atau string SVG menjadi Base64 inline image.
     *
     * @param string $svgSource Path ke file SVG atau string SVG langsung
     * @return string Base64 data URI untuk <img src="...">
     */
    function svgtobase64(string $svgSource): string
    {
        // Jika input berupa path file
        if (file_exists($svgSource)) {
            $svgContent = file_get_contents($svgSource);
        } else {
            // Jika input langsung berupa isi SVG
            $svgContent = $svgSource;
        }

        // Bersihkan spasi berlebih
        $svgContent = trim($svgContent);

        // Encode ke Base64
        $base64 = base64_encode($svgContent);

        // Return data URI siap pakai
        return 'data:image/svg+xml;base64,' . $base64;
    }
}
