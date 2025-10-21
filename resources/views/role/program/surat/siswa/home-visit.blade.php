<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Surat Home Visit</title>
    <style>
        @page {
            size: A4;
            /* margin: 2cm; */
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

        .bold {
            font-weight: bold;
        }

        .text-justify {
            text-align: justify;
        }

        td .label {
            width: 45%;
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

<body>
    <x-kop-surat-cetak></x-kop-surat-cetak>
    <div class="text-center">
        SURAT TUGAS HOME VISIT SISWA
    </div>

    <p class="text-center">Nomor: {{ $nomor_surat }}</p>
    {{-- <p>Tanggal: {{ $tanggal_surat }}</p> --}}

    <p>Yang bertanda tangan di bawah ini:</p>
    <table class="table-data">
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

    <p>Dengan ini memberikan tugas kepada:</p>
    <table class="table-data">
        <tr>
            <td class="label">Nama Guru</td>
            <td class="separator">:</td>
            <td>{{ $nama_guru }}</td>
        </tr>
        <tr>
            <td class="label">NIP</td>
            <td class="separator">:</td>
            <td>{{ $nip_guru }}</td>
        </tr>
        <tr>
            <td class="label">Jabatan</td>
            <td class="separator">:</td>
            <td>{{ $jabatan }}</td>
        </tr>
    </table>

    <p>Untuk melaksanakan kegiatan <b>Home Visit</b> kepada siswa dengan data berikut:</p>
    <table class="table-data">
        <tr>
            <td class="label">Nama Siswa</td>
            <td class="separator">:</td>
            <td>{{ $nama_siswa }}</td>
        </tr>
        <tr>
            <td class="label">Kelas</td>
            <td class="separator">:</td>
            <td>{{ $kelas }}</td>
        </tr>
        <tr>
            <td class="label">Alamat Siswa</td>
            <td class="separator">:</td>
            <td>{{ $alamat_siswa }}</td>
        </tr>
        <tr>
            <td class="label">Orang Tua/Wali</td>
            <td class="separator">:</td>
            <td>{{ $nama_ortu }}</td>
        </tr>
        <tr>
            <td class="label">Alasan Home Visit</td>
            <td class="separator">:</td>
            <td>{{ $alasan_homevisit }}</td>
        </tr>
    </table>

    <p>Tujuan kunjungan ini adalah menjalin komunikasi antara pihak sekolah dan keluarga, guna mendukung perkembangan
        akademik dan non-akademik siswa tersebut.</p>

    <p>Kegiatan Home Visit ini direncanakan pada:</p>
    <table class="table-data">
        <tr>
            <td class="label">Hari/Tanggal</td>
            <td class="separator">:</td>
            <td> {{ $hari_tanggal_kunjungan }}</td>
        </tr>
        <tr>
            <td class="label">Waktu</td>
            <td class="separator">:</td>
            <td> {{ $waktu_kunjungan }}</td>
        </tr>
    </table>

    <p>Demikian surat tugas ini dibuat agar dapat dilaksanakan sebagaimana mestinya. Atas perhatian dan kerjasamanya,
        kami ucapkan terima kasih.</p>

    <div class="ttd">
        <p>{{ $desa ?? '' }}, {{ date('d F Y') }}</p>
        <p>Kepala Sekolah</p>
        <br><br><br>
        <p><strong>{{ $nama_kepala ?? '' }}</strong></p>
        <p style='margin-left:-155px'>NIP. {{ $nip_kepala ?? '' }}</p>
    </div>
</body>

</html>
