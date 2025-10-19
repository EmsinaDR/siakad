<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Siswa A4 - Kartu Absensi</title>

    <style>
        @page {
            size: A4;
            margin: 5mm;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: #eee;
            margin: 0;
            padding: 0;
        }

        .container-print {
            padding: 10mm;
            background-color: #f5f5f5;
        }

        .page {
            width: 210mm;
            height: 297mm;
            background: white;
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            align-content: flex-start;
            padding: 5mm;
            box-sizing: border-box;
            page-break-after: always;
            border: 3px solid #ddd;
            margin-bottom: 10mm;
        }

        .page-header {
            width: 100%;
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5mm;
        }

        .card {
            background: #fff;
            width: 62mm;
            height: 87mm;
            /* sebelumnya 87mm */
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.1);
            margin: 2mm;
            padding: 5mm;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            text-align: center;
        }

        .qr-img {
            width: 125px;
            height: 125px;
            object-fit: cover;
        }

        .info {
            width: 100%;
            font-size: 11px;
            text-align: left;
        }

        .info h6 {
            text-align: center;
            margin-bottom: 5px;
        }

        .info table {
            width: 100%;
            font-size: 10px;
        }

        .info td {
            vertical-align: top;
            padding: 2px 0;
        }

        .page-break {
            page-break-before: always;
        }

        @media print {
            body {
                background: none;
            }

            .container-print {
                background: none;
                padding: 0;
            }

            .page {
                margin: 0;
                border: none;
            }
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <div class="container-print">
        @php
            $count = 0;
            $page = 1;
        @endphp

        @foreach ($QrSiswa->chunk(12) as $chunk)
            <div class="page">
                <div class="page-header">
                    Halaman {{ $loop->iteration }}
                </div>

                @foreach ($chunk as $siswa)
                    <div class="card">
                        <div class="qr-code mb-2">
                            @php
                                $qrPath = public_path('img/qrcode/nis/' . ($siswa->nis ?? '') . '.png');
                                $qrUrl = asset('img/qrcode/nis/' . ($siswa->nis ?? '') . '.png');
                            @endphp

                            @if (file_exists($qrPath))
                                <img src="{{ $qrUrl }}" alt="QR {{ $siswa->nama_siswa }}" class="qr-img">
                            @else
                                <img src="{{ asset('img/no_image.jpg') }}" alt="QR Tidak Ada" class="qr-img">
                            @endif
                        </div>

                        <div class="info">
                            <h6><u>{{ $siswa->nama_siswa }}</u></h6>
                            <table style='align:center' class='mx-4'>
                                <tr>
                                    <td style="width: 35%; font-weight: bold;">Kelas</td>
                                    <td>: {{ $siswa->KelasOne->kelas }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">NIS</td>
                                    <td>: {{ $siswa->nis }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach


        @if ($count > 0)
    </div> <!-- Tutup page terakhir -->
    @endif
    </div>
</body>

</html>
<script>
    window.onload = function() {
        window.print();

        window.onafterprint = function() {
            window.location.href = document.referrer || '/';
        };
    };
</script>
