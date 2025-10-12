<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Surat Panggilan</title>
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
            /* float: right; */
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
    <div class="text-center" style="margin-top: 20px; font-weight: bold;">
        SURAT PANGGILAN ORANG TUA / WALI
    </div>

    <p class="text-center">Nomor: {{ $nomor_surat }}</p>

    <p>Dengan sehubungan ada permasalahan yang perlu diselesaikan bersama, maka dengan ini kami mengharapkan kehadiran
        Bapak / Ibu Wali Murid dari siswa ber :</p>
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
            <td class="label">Alamat</td>
            <td class="separator">:</td>
            <td>{{ $alamat_siswa }}</td>
        </tr>
        <tr>
            <td class="label">Orang Tua/Wali</td>
            <td class="separator">:</td>
            <td>{{ $nama_ortu }}</td>
        </tr>
    </table>

    <p>Untuk hadir ke sekolah pada:</p>
    <table class="table-data">
        <tr>
            <td class="label">Hari/Tanggal</td>
            <td class="separator">:</td>
            <td>{{ $hari_tanggal_kunjungan }}</td>
        </tr>
        <tr>
            <td class="label">Waktu</td>
            <td class="separator">:</td>
            <td>{{ $waktu_kunjungan }}</td>
        </tr>
        <tr>
            <td class="label">Tempat</td>
            <td class="separator">:</td>
            <td>{{ $tempat_kunjungan ?? 'Ruang BK / Ruang Kepala Sekolah' }}</td>
        </tr>
    </table>

    <p>Adapun maksud dari pemanggilan ini adalah untuk membahas hal-hal berikut:</p>
    @php
        $keperluans = explode(':', $keperluan);
    @endphp
    <ul>
        @foreach ($keperluans as $datakeperluan)
            <li><strong>{{ $datakeperluan }}</strong></li>
        @endforeach
    </ul>

    <p>Demikian surat panggilan ini kami sampaikan. Kami mengharapkan kehadiran Bapak/Ibu tepat pada waktunya demi
        kepentingan bersama.</p>

    <div class="ttd" style="margin-top: 40px;">
        <table width="100%" style="text-align: center;">
            <tr>
                <td width="50%">
                    Waka Kesiswaan<br><br><br><br>
                    <strong>{{ $nama_waka ?? '________________' }}</strong><br>
                    <b style='margin-left:-125px'>NIP. {{ $nip_waka ?? '__________' }}</b>
                </td>
                <td width="50%">
                    {{ $desa ?? '' }}, {{ date('d F Y') }}<br>
                    Wali Kelas<br><br><br><br>
                    <strong>{{ $nama_guru ?? '________________' }}</strong><br>
                    <b style='margin-left:-125px'>NIP. {{ $nip_guru ?? '__________' }}</b>
                </td>
            </tr>
        </table>
        <div style="text-align: center;">
            Mengetahui,<br>
            Kepala {{ $kedinasan }}<br><br><br><br>
            <strong>{{ $nama_kepala ?? '________________' }}</strong><br>
            <b style='margin-left:-155px'>NIP. {{ $nip_kepala ?? '__________' }}</b>
        </div>
    </div>

</body>


</html>
