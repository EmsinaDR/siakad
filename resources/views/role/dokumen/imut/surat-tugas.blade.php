{{-- View: imut/surat-tugas --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>SURAT TUGAS</title>
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

    <h3 class="text-center"><u>SURAT TUGAS</u></h3>
    <p class="text-center">{{$nomor_surat}}</p>
    <br>

    <div class="ttd">
        <p>{{ $kabupaten }}, {{ date('d F Y') }}</p>
        Kepala {{ $kedinasan }}<br><br><br><br>
        <p><strong>{{ $nama_kepala ?? '' }}</strong><br></p>
        <b style='margin-left:-145px'>NIP. {{ $nip_kepala ?? '__________' }}</b>
    </div>

</body>

</html>