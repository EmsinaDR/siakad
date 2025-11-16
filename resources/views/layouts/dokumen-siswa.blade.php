<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel Cetak Dokumen')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 5px;
            background: #f9f9f9;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        .dokumen-item {
            margin-bottom: 10px;
        }

        .break {
            margin-bottom: 15px;
            border-bottom: 1px dashed #ccc;
        }

        .dokumen-page {
            page-break-after: always;
            /* Ini rahasia pindah halaman */
            padding: 10px;
            background: white;
            border: 1px solid #ccc;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .dokumen-page:last-child {
            page-break-after: auto;
            /* Jangan break terakhir */
        }

        .cover-page {
            page-break-after: always;
            text-align: center;
            padding-top: 200px;
            background: white;
        }

        .cover-page h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .cover-page h2 {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .cover-page p {
            font-size: 20px;
            margin-bottom: 5px;
        }

        .dokumen-page {
            page-break-after: always;
            padding: 30px;
            background: white;
            border: 1px solid #ccc;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .dokumen-page:last-child {
            page-break-after: auto;
        }

        .suket-aktif {
            page-break-after: always;
            padding: 50px;
            font-family: 'Times New Roman', Times, serif;
            font-size: 16px;
            background: white;
        }

        .suket-aktif table td {
            padding: 4px 8px;
        }

        /* Garis normal kalau dilihat di browser */
        .kop-sekolah hr {
            border: 1px solid black;
        }


            /* Pastikan elemen-elemen lainnya tetap bersih */
            .kop-surat img {
                width: 120px !important;
                height: 120px !important;
            }

            /* Sembunyikan footer di semua halaman */
            .footer-siswa {
                display: none !important;
            }



            /* Pastikan konten lain (cover, dokumen) terlihat saat print */
            .dokumen-page,
            .cover-page {
                page-break-after: always;
            }
        /* SEMUA footer default disembunyikan */

        /* Tapi kalau mode cetak (print), garisnya diilangin */
        /* Hapus border kotak dan elemen border lainnya saat cetak */
        @media print {

            html,
            body {
                background: white !important;
            }

            /* Menghilangkan background abu-abu di seluruh halaman */
            body,
            .container,
            .dokumen-page {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                background: white !important;
                /* Pastikan tidak ada background */
            }

            /* Hapus border lainnya di bagian dokumen */
            .container,
            .dokumen-item,
            .dokumen-page,
            .cover-page,
            .suket-aktif {
                border: none !important;
            }

            .container {
                padding: 5px;
            }

            .suket-aktif {
                page-break-after: always;
                padding: 0;
                font-family: 'Times New Roman', Times, serif;
                font-size: 16px;
                background: white;
            }

            /* Menghilangkan garis pemisah selain di kop surat */
            .dokumen-item,
            .break {
                display: none !important;
                background: transparent !important;
            }

            /* Menjaga kop surat tetap tampil dengan garis bawah */
            .kop-surat {
                border-bottom: 3px solid #000 !important;
                margin-bottom: 25px !important;
                margin-top: 0 !important;
            }

            /* Menjaga garis <hr> pada kop surat tetap muncul saat cetak */
            .kop-surat hr {
                border: 3px solid black !important;
                margin-top: -8px !important;
                margin-bottom: 16px !important;
            }

        }
    </style>

</head>

<body>

    <div class="container">
        @yield('content')
    </div>

</body>

</html>
