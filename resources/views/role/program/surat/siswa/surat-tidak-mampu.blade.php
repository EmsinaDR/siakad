<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Tidak Mampu</title>
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

    <h3 class="text-center"><u>SURAT KETERANGAN TIDAK MAMPU</u></h3>
    <p class="text-center">Nomor: {{ $nomor_surat ?? '...../...../.....' }}</p>

    <p>Yang bertanda tangan di bawah ini, Kepala Sekolah {{ $nama_sekolah }}, menerangkan bahwa:</p>

    <table style="margin-left: 30px;">
        <tr>
            <td>Nama</td>
            <td>: <strong>{{ $nama_siswa ?? '....................' }}</strong></td>
        </tr>
        <tr>
            <td>NIS</td>
            <td>: {{ $nis ?? '....................' }}</td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>: {{ $kelas ?? '....................' }}</td>
        </tr>
        <tr>
            <td>Tempat, Tanggal Lahir</td>
            <td>: {{ $tempat_lahir ?? '....................' }}, {{ $tanggal_lahir ?? '....................' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ $alamat_siswa ?? '....................' }}</td>
        </tr>
        <tr>
            <td>Nama Orang Tua/Wali</td>
            <td>: {{ $nama_ortu ?? '....................' }}</td>
        </tr>
    </table>

    <p class="text-justify">
        Berdasarkan data yang ada pada sekolah dan hasil observasi, benar bahwa yang bersangkutan berasal dari keluarga
        yang kurang mampu secara ekonomi.
    </p>

    <p class="text-justify">
        Surat keterangan ini dibuat sebagai syarat
        <strong>{{ $keperluan ?? 'pengajuan bantuan / beasiswa / keperluan administrasi lainnya' }}</strong>.
    </p>

    <p class="text-justify">
        Demikian surat keterangan ini dibuat untuk dapat digunakan sebagaimana mestinya.
    </p>

    <div class="ttd">
        <p>{{ $desa ?? 'Kota Edukasi' }}, {{ date('d F Y') }}</p>
        <p>Kepala Sekolah</p>
        <br><br><br>
        <p><strong>{{ $nama_kepala ?? '........................' }}</strong>
        </p>
        <p style='margin-left:-155px'>NIP. {{ $nip_kepala ?? '' }}</p>
    </div>

</body>

</html>
