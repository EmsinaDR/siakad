<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Sertifikat</title>
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
            font-size: 36px;
            font-weight: bold;
        }
        .nama_kegiatan {
            font-size: 24px;
            font-weight: bold;
        }

        .no-sertifikat {
            margin-top: -0.75cm;
            margin-bottom: 2cm;
            font-size: 24px;
            font-weight: bold;
        }

        .nama {
            font-size: 30px;
            font-weight: bold;
            margin: 20px 0;
        }

        .qr {
            position: absolute;
            bottom: 3cm;
            /* naik 1 cm */
            right: -1cm;
            width: 200px;
            height: 200px;
            z-index: 1;
        }

        .ttd {
            position: absolute;
            bottom: 2cm;
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
            height: 80px;
            position: absolute;
            top: -0.5cm;
            left: 0.5cm;
        }

        p {
            font-size: 18px;
        }
        table, th, td {
            font-size: 18px;
        }
        .ttd_kanan {
            margin-left:30px;
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
    <div class="wrapper">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents($data['background'])) }}" class="bg-img" />
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents($data['logo'])) }}" class='logo' />

        <div class="isi">
            <p class="judul"><text x="50%" y="200" text-anchor="middle" font-size="48" fill="#2c3e50">PIAGAM
                    PENGHARGAAN</text></p>
            <p class="no_sertifikat">Nomor: {{ $data['nomor'] }}</p>
            <p>Diberikan kepada:</p>
            <p class="nama">{{ $data['nama'] }}</p>
            <p >Sebagai <strong>{{ $data['peran'] }}</strong> dalam kegiatan</p>
            <p class='nama_kegiatan'><em>"{{ $data['judul'] }}"</em></p>
            <p>Diselenggarakan pada tanggal {{ $data['tanggal'] }} di {{ $data['lokasi'] }}.</p>
        </div>

        <div class="qr">
            <img
                src="data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(125)->generate($data['qr_data'])) }}" />
        </div>

        {{-- <table style="position: absolute; bottom: 4cm; left: 2cm; right: 8cm; width: calc(100% - 10cm);"> --}}
        <table style="position: absolute; bottom: 4cm; left: 2cm; right: 25cm; width: calc(100% - 6cm);">
            <tr>
                <td style="text-align: center;">
                    Kepala Sekolah <br>
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents($data['ttd_kepsek'])) }}"
                        style="height: 70px;"><br>
                    <strong>{{ $data['nama_kepsek'] }}</strong><br>

                </td>
                <td width='40%'></td>
                <td style="text-align: center;">
                    Ketua Panitia <br>
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents($data['ttd_panitia'])) }}"
                        style="height: 70px;"><br>
                    <strong>{{ $data['nama_panitia'] }}</strong><br>
                </td>
            </tr>
        </table>



    </div>
</body>

</html>
