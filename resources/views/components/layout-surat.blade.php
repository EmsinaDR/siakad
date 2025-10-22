<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>{{ $data_judul }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 60px;
            position: relative;
        }

        .watermark {
            background-image: url('{{ asset('img/logo.png') }}');
            background-repeat: no-repeat;
            background-position: center;
            background-size: 400px;
            opacity: 0.04;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        .content {
            position: relative;
            z-index: 1;
        }

        .surat-header {
            margin-bottom: 20px;
        }

        .surat-header table {
            width: 100%;
            font-size: 14px;
        }

        .isi p {
            text-align: justify;
            font-size: 15px;
            line-height: 1.6;
        }

        .isi table {
            font-size: 14px;
            margin: 10px 0;
        }

        .ttd {
            margin-top: 50px;
            width: 100%;
        }

        .ttd td {
            text-align: center;
            vertical-align: top;
        }
    </style>
</head>

<body>
    <div class="watermark"></div>
    <div class="content">
        <section>{{ $slot }}</section>
    </div>
</body>

</html>
<div class="surat-header">
            <table>
                <tr>
                    <td style="width: 20%;">Nomor</td>
                    <td style="width: 2%;">:</td>
                    <td>{{ $data_nomor }}</td>
                </tr>
                <tr>
                    <td>Perihal</td>
                    <td>:</td>
                    <td>{{ $data_judul }}</td>
                </tr>
                <tr>
                    <td>Lampiran</td>
                    <td>:</td>
                    <td>{{ $data_lampiran }}</td>
                </tr>
            </table>
        </div>
        {{-- <div class="isi">
            <p>Yth. {{ $data_penerima }}</p>

            <p>{{ $data_paragraf1 }}</p>

            <p>{{ $data_paragraf2 }}</p>

            <table>
                <tr>
                    <td style="width: 30%;">Hari / Tanggal</td>
                    <td>: {{ $data_tanggal }}</td>
                </tr>
                <tr>
                    <td>Waktu</td>
                    <td>: {{ $data_waktu }}</td>
                </tr>
                <tr>
                    <td>Tempat</td>
                    <td>: {{ $data_tempat }}</td>
                </tr>
            </table>

            <p>{{ $data_paragraf3 }}</p>

            <p>{{ $data_paragraf_penutup }}</p>
        </div>

        <table class="ttd">
            <tr>
                <td style="width: 60%;"></td>
                <td>
                    {{ $data_tempat_surat }}, {{ $data_tanggal_surat }}<br />
                    {{ $data_jabatan_penandatangan }}<br /><br /><br /><br />
                    <u>{{ $data_nama_penandatangan }}</u><br />
                    NIP. {{ $data_nip_penandatangan }}
                </td>
            </tr>
        </table> --}}