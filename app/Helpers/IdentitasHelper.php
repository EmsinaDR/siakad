<?php
// app/Helpers/IdentitasHelper.php

use App\Models\Admin\Etapel;
use App\Models\Admin\Identitas;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Cache;

if (!function_exists('getIdentitas')) {
    function getIdentitas()
    {
        return Cache::remember('identitas_data', now()->addDay(), function () {
            return Identitas::first();
        });
    }
}
if (!function_exists('DataIdentitas')) {
    function DataIdentitas()
    {
        $Identitas = Identitas::first();
        $Tapels = Etapel::where('aktiv', 'Y')->first();

        // Cegah error kalau data tidak ada
        if (!$Identitas || !$Tapels) {
            return [];
        }

        $Kedinasan = in_array($Identitas->jenjang ?? '', [
            'MTS S',
            'MTs S',
            'MTS N',
            'MTs N'
        ]) ? 'Madrasah' : 'Sekolah';

        return [
            'nama_sekolah'     => $Identitas->namasek ?? '-',
            'alamat_sekolah'   => $Identitas->alamat ?? '-',
            'kabupaten'        => $Identitas->kabupaten ?? '-',
            'kecamatan'        => $Identitas->kecamatan ?? '-',
            'desa'             => $Identitas->desa ?? '-',
            'nama_kepala'      => $Identitas->namakepala ?? '-',
            'nip_kepala'       => $Identitas->nip_kepala ?? '-',
            'tempat_kunjungan' => $Identitas->namasek ?? '-',
            'tahun_pelajaran'  => $Tapels->tapel . '-' . ($Tapels->tapel + 1),
            'kedinasan'        => $Kedinasan,
            'nomor_surat'      => '..../' . $Identitas->namasingkat . '/' . bulanRomawi(date('m')) . '/' . date('Y'),
        ];
    }
}

if (!function_exists('DataSekolah')) {
    function DataSekolah($kode_guru)
    {
        //Isi Fungsi
        $gurus = Detailguru::where('kode_guru', $kode_guru)->first();
        if (!$gurus) {
            return  "Maaf kode guru tidak ditemukan";
        }
        $Identitas = Identitas::first();
        $fields = [

            "🏫 Nama Sekolah"           => $Identitas->namasek ?? '',
            "⭐ Akreditasi"             => $Identitas->akreditasi ?? '',
            "📧 Email"                  => $Identitas->email ?? '',
            "📍 Alamat"                  => $Identitas->alamat ?? '',
            "👤 Nama Kepala"            => $Identitas->namakepala ?? '',
            "🆔 NIP Kepala"             => $Identitas->nip ?? '',
            "🎯 Visi"                   => $Identitas->visi ?? '-',
            "💡 Misi"                   => $Identitas->misi ?? '-',
            "🌐 Website"                => $Identitas->website ?? '',
            "👥 Facebook Group"         => $Identitas->facebook_group ?? '',
            "📘 Facebook Fanspage"      => $Identitas->facebook_fanspage ?? '',
            "🐦 Twitter"                => $Identitas->twiter ?? '',
            "📸 Instagram"              => $Identitas->instagram ?? '',
            "💬 WhatsApp Group Guru"    => $Identitas->whatsap_group_guru ?? '',
            "🌐 Internet"               => $Identitas->internet ?? '',
            "⚡ Speed"                  => $Identitas->speed ?? '',
            // "⚡ Laboratorium"           => $Identitas->laboratorium ?? '',
        ];
        if ($gurus && $gurus->jenis_kelamin === 'Perempuan') {
            $sapaan = 'Ibu';
        } else {
            $sapaan = 'Bapak';
        }
        $Isi = "Berikut data sekolah yang bisa dikirim ke *{$sapaan} {$gurus->nama_guru}*:\n\n";
        $Isi .= implode("\n", array_map(
            fn($label, $value) => "$label : $value",
            array_keys($fields),
            $fields
        ));
        $Isi .= "\n\n🙏 Terima kasih";

        $PesanKiriman = format_pesan('Data Sekolah', $Isi);

        return $PesanKiriman;
    }
}

if (!function_exists('kontakSekolah')) {
    function kontakSekolah()
    {
        //Isi Fungsi
        $baseUrl = config('app.url'); // Pastikan sudah termasuk "http://" atau "https://"
        $identitas = getIdentitas();
        $isiPesan =
            "📬 *Berikut informasi kontak kami:*\n\n" .
            "🌐 *Website:*\n {$identitas->website}\n" .
            "📘 *Facebook Fanspage:*\n {$identitas->facebook_fanspage}\n" .
            "👥 *Facebook Group:*\n {$identitas->facebook_group}\n" .
            "🐦 *Twitter:*\n {$identitas->twiter}\n" .
            "📸 *Instagram:*\n {$identitas->instagram}\n" .
            "▶️ *YouTube:*\n {$identitas->youtube}\n" .
            "🏠 *Localhost:*\n {$baseUrl}\n" .

            "\n\n";
        return $isiPesan;
    }
}
