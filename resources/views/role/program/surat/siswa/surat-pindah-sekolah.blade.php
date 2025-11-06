<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Surat Pindah Sekolah</title>
    <style>
        @page {
            size: A4;
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

        p {
            font-size: 12pt;
        }

        .text-center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
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

        .table-data {
            width: 100%;
            border-collapse: collapse;
            font-size: 12pt;

        }

        .table-data td,
        .table-data th {
            font-size: 12pt;
        }

        .table-data td {
            vertical-align: top;
            padding: 2px 4px;
        }

        .table-data td.label {
            width: 150px;
            white-space: nowrap;
        }

        .table-data td.separator {
            width: 10px;
        }
    </style>
</head>

<body style="font-family: Arial, sans-serif; font-size: 12pt;">
    <x-kop-surat-cetak></x-kop-surat-cetak>

    <div class="text-center bold">
        SURAT KETERANGAN PINDAH SEKOLAH
    </div>

    <p class="text-center">Nomor: {{ $nomor_surat }}</p>

    <p>Yang bertanda tangan di bawah ini:</p>
<table class="table-data" style="font-size: 12pt; font-family: Arial, sans-serif;">
        <tr>
            <td class="label">Nama</td>
            <td class="separator">:</td>
            <td>{{ $nama_kepala }}</td>
        </tr>
        <tr>
            <td class="label">NIP</td>
            <td class="separator">:</td>
            <td>{{ $nip_kepala }}</td>
        </tr>
        <tr>
            <td class="label">Jabatan</td>
            <td class="separator">:</td>
            <td>Kepala Sekolah {{ $nama_sekolah }}</td>
        </tr>
    </table>

    <p>Dengan ini menerangkan bahwa:</p>
    <table class="table-data">
        <tr>
            <td class="label">Nama Siswa</td>
            <td class="separator">:</td>
            <td>{{ $nama_siswa }}</td>
        </tr>
        <tr>
            <td class="label">NIS</td>
            <td class="separator">:</td>
            <td>{{ $nis }}</td>
        </tr>
        <tr>
            <td class="label">Kelas</td>
            <td class="separator">:</td>
            <td>{{ $kelas }}</td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td class="separator">:</td>
            <td>{{ $alamat_siswa }}</td>
        </tr>
        <tr>
            <td class="label">Nama Orang Tua/Wali</td>
            <td class="separator">:</td>
            <td>{{ $nama_ortu }}</td>
        </tr>
    </table>

    <p>Telah mengajukan permohonan pindah sekolah dengan alasan: <b>{{ $alasan_pindah }}</b>.

    <p>Siswa tersebut akan melanjutkan pendidikan di:</p>
    <table class="table-data">
        <tr>
            <td class="label">Nama Sekolah</td>
            <td class="separator">:</td>
            <td>{{ $sekolah_tujuan }}</td>
        </tr>
        <tr>
            <td class="label">Alamat Sekolah</td>
            <td class="separator">:</td>
            <td>{{ $alamat_sekolah_tujuan }}</td>
        </tr>
    </table>

    <p>Demikian surat keterangan ini dibuat untuk dapat digunakan sebagaimana mestinya.</p>

    <div class="ttd">
        <p>{{ $desa ?? '' }}, {{ date('d F Y') }}</p>
        <p>Kepala Sekolah</p>
        <br><br><br>
        <p><strong>{{ $nama_kepala ?? '' }}</strong></p>
        <p style='margin-left:-155px'>NIP. {{ $nip_kepala ?? '' }}</p>
    </div>
</body>

</html>
