<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ ucwords($datas[0]['judul_sertifikat']) }} {{ $datas[0]['nama_kegiatana'] }}</title>
    <style>
        /* body {
            margin: 0;
            font-family: 'Georgia', serif;
            color: #2c3e50;
        } */
        body {
            /* background-image: url('data:image/jpeg;base64,...'); */
        }

        .bg-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 29.7cm;
            height: 21cm;
            object-fit: cover;
            margin-top: -1.2cm;
            margin-left: -1.2cm;
            /* atau contain */
            z-index: -1;
        }

        .wrapper {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .isi {
            position: absolute;
            top: 1cm;
            left: 2cm;
            right: 2cm;
            bottom: 2cm;
            text-align: center;
        }

        .judul {
            font-size: 40px;
            font-weight: bold;
            font-family: 'Arial', sans-serif;
        }

        .nama_kegiatan {
            font-size: 24px;
            font-weight: bold;
        }

        .no_sertifikat {
            margin-top: -0.75cm;
            margin-bottom: 1.5cm;
            font-size: 20px;
            font-weight: bold;
        }

        .nama {
            font-size: 30px;
            font-weight: bold;
            margin: 20px 0;
        }

        .qr {
            position: absolute;
            /* position: relative; */
            bottom: 2.5cm;
            /* naik 1 cm */
            right: -1.5cm;
            width: 200px;
            height: 200px;
            z-index: 1;
        }

        .ttd {
            position: absolute;
            bottom: 2.5cm;
            left: 2cm;
            right: 2cm;
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            text-align: center;
        }

        .ttd img {
            max-height: 70px;
        }

        .logo {
            width: 100px;
            height: auto;
            position: absolute;
            top: -0.30cm;
            /* Sedikit turun agar lebih pas */
            left: 0.25cm;
            /* Geser sedikit dari tepi kiri */
        }

        .logow {
            width: 120px;
            height: auto;
            position: absolute;
            top: -0.25cm;
            /* Sama tinggi dengan .logo */
            right: 0.25cm;
            /* Geser dari tepi kanan */
        }


        p {
            font-size: 18px;
        }

        table,
        th,
        td {
            font-size: 18px;
        }


        .page-break {
            page-break-after: always;
            /* width: 29.7cm;
            height: 21cm;
            position: relative; */
        }

        @media print {
            @page {
                size: A4 landscape;
                margin: 0;
            }

            html,
            body {
                margin: 0 !important;
                padding: 0 !important;
                width: 29.7cm;
                height: 21cm;
                overflow: hidden;
                -webkit-print-color-adjust: exact;
                /* ✅ penting agar warna/background tercetak */
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>
    @foreach ($datas as $data)
        <div class="wrapper">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents($data['background'])) }}" class="bg-img" />
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents($data['logo_sekolah'])) }}"
                class='logo' />
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents($data['logo_dinas'])) }}" class='logow' />

            <div class="isi">
                <p class="judul"><text x="50%" y="200" text-anchor="middle" font-size="48" fill="#2c3e50">{{ strtoupper($data['judul_sertifikat']) }}</text></p>
                <p class="no_sertifikat">Nomor: {{ $data['nomor'] }}</p>
                <p>Diberikan kepada:</p>
                <p class="nama">{{ $data['nama'] }}</p>
                <p>Sebagai <strong>{{ $data['peran'] }}</strong> dalam kegiatan</p>
                <p class='nama_kegiatan'><em>"{{ $data['nama_kegiatana'] }}"</em></p>
                <p>Diselenggarakan pada hari {{ $data['tanggal'] }} di {{ $data['lokasi'] }}.</p>
                {{-- <table style="position: absolute; bottom: 4cm; left: 2cm; right: 8cm; width: calc(100% - 10cm);"> --}}
                <div class="qr">
                    <img
                        src="data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(150)->margin(2)->generate($data['qr_data'])) }}" />
                </div>

                <div class="ttd">
                    <table style="width: 100%;">
                        <tr>
                            <td style="text-align: center;">
                                Kepala {{ $Identitas->namasek }}<br>
                                @if (!empty($data['ttd_kepsek']))
                                    <img src="{{ $data['ttd_kepsek'] }}" class="my-2" style="height: 70px;"><br>
                                @else
                                    <span class="text-muted"></span><br><br><br><br>
                                @endif

                                <strong>{{ $data['nama_kepsek'] }}</strong><br>
                            </td>
                            <td></td>
                            <td style="text-align: center;">
                                Ketua Panitia <br>
                                @if (!empty($data['ttd_panitia']))
                                    <img src="{{ $data['ttd_panitia'] }}" class="my-2" style="height: 70px;"><br>
                                @else
                                    <span class="text-muted"></span><br><br><br><br>
                                @endif

                                <strong>{{ $data['nama_panitia'] }}</strong><br>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        {{-- <div class="page-break"></div> --}}
    @endforeach
</body>

</html>
