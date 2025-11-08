<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Izin Pulang Cepat</title>
    <style>
        @page {
            size: A4;
            margin: 2cm;
        }

        html,
        body {
            height: 100%;
            overflow: hidden;
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.5;
            box-sizing: border-box;
        }

        .text-center {
            text-align: center;
        }

        .text-justify {
            text-align: justify;
        }

        .kop {
            display: flex;
            align-items: center;
            border-bottom: 3px double black;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .kop img {
            height: 80px;
            margin-right: 15px;
        }

        .ttd {
            float: right;
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>

<body>

    <x-kop-surat-cetak></x-kop-surat-cetak>

    <h3 class="text-center"><u>SURAT IZIN PULANG CEPAT</u></h3>
    <br>

    <p>Yang bertanda tangan di bawah ini, {{ $jabatan}} pada {{ $nama_sekolah }}, dengan ini memberikan izin kepada:</p>

    <table style="margin-left: 30px;">
        <tr>
            <td>Nama</td>
            <td>: <strong>{{ $nama_siswa ?? '....................' }}</strong></td>
        </tr>
        <tr>
            <td>NIS / NISN</td>
            <td>: {{ $nis ?? '....................' }}</td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>: {{ $kelas ?? '....................' }}</td>
        </tr>
        <tr>
            <td>Alasan</td>
            <td>: {{ $alasan ?? '....................' }}</td>
        </tr>
        <tr>
            <td>Waktu Pulang</td>
            <td>: {{ $waktu_pulang ?? '....................' }}</td>
        </tr>
    </table>

    <p class="text-justify">
        Surat izin ini diberikan atas permintaan siswa/orangtua karena alasan tersebut di atas. Diharapkan siswa kembali mengikuti kegiatan pembelajaran seperti biasa pada hari berikutnya.
    </p>

    <p class="text-justify">
        Demikian surat izin ini dibuat untuk dipergunakan sebagaimana mestinya.
    </p>

    <div class="ttd">
        <p>Kota Edukasi, {{ date('d F Y') }}</p>
        <p>{{ $jabatan}}</p>
        <br><br><br>
        <p><strong>{{ $nama_guru ?? '....................' }}</strong><br>NIP. {{ $nip_guru ?? '....................' }}</p>
    </div>

</body>

</html>
@php
$data = [
    // Sekolah
    'nama_sekolah'   => 'xxxxx',
    'nama_siswa'     => 'xxxxx',
    // Data Guru
    'nama_guru'      => 'xxxxx',
    'nip_guru'       => 'xxxxx',
    // Data Siswa
    'nis'            => 'xxxxx',
    'kelas'          => 'xxxxx',
    // Data Surat Ijin / Dispensasi
    'jabatan'        => 'xxxxx',
    'alasan'         => 'xxxxx',
    'waktu_pulang'   => 'xxxxx',
];
@endphp