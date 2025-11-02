<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Aktif</title>
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

    <x-kop-surat-cetak>{{ $logo }}</x-kop-surat-cetak>

    <h3 class="text-center"><u>SURAT KETERANGAN AKTIF</u></h3>
    <br>

    <p>Yang bertanda tangan di bawah ini, Kepala Sekolah {{ $nama_sekolah }}, menerangkan bahwa:</p>

    <table style="margin-left: 30px;">
        <tr>
            <td>Nama</td>
            <td>: <strong>{{ $nama_siswa ?? '....................' }}</strong></td>
        </tr>
        <tr>
            <td>NISN</td>
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
    </table>
    <br>
    <p class="text-justify">
        Benar bahwa yang bersangkutan adalah siswa aktif pada tahun pelajaran
        {{ $tahun_pelajaran ?? '....................' }} di {{ $nama_sekolah }}. Surat ini dibuat untuk keperluan
        <strong>{{ $keperluan ?? '....................' }}</strong>.
    </p>

    <p class="text-justify">
        Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.
    </p>

    <div class="ttd">
        <p>{{ $kabupaten }}, {{ date('d F Y') }}</p>
        Kepala {{$kedinasan}}<br><br><br><br>
        <br><br><br>
        <p><strong>{{ $nama_kepala ?? '' }}</strong><br></p>
        <b style='margin-left:-145px'>NIP. {{ $nip_kepala ?? '__________' }}</b>
    </div>

</body>

</html>
