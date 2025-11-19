<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page {
            margin: 0;
            size: 396pt 612pt; /* portrait */
        }
        html, body {
            margin: 0;
            padding: 0;
            width: 396pt;
            height: 612pt;
        }
        .page {
            position: relative;
            width: 396pt;
            height: 612pt;
            overflow: hidden;
            page-break-inside: avoid;
            background: #fff;
        }

        .kartu {
            position: absolute;
            width: calc(50% - 4pt); /* 2 kolom, gap kecil total 4pt */
            height: calc(25% - 4pt); /* 4 baris, gap kecil total 4pt */
            text-align: center;
            box-sizing: border-box;
            background: #fff;
            padding: 2pt;
            border: 0.3pt dashed #ccc; /* garis bantu potong tipis */
        }

        .kartu img {
            width: 100%;
            height: auto;
            display: block;
        }

        .nama {
            font-size: 8pt;
            margin-top: 2pt;
            line-height: 1;
        }
    </style>
</head>
<body>
    <div class="page">
        @foreach($kartuList as $index => $kartu)
            @php
                $row = floor($index / 2); // 4 baris
                $col = $index % 2;        // 2 kolom
                $gapX = 4; // jarak horizontal antar kartu (pt)
                $gapY = 4; // jarak vertikal antar kartu (pt)

                $kartuW = (396 / 2); // lebar kolom (198pt)
                $kartuH = (612 / 4); // tinggi baris (153pt)

                $left = ($col * $kartuW) + ($gapX / 2);
                $top = ($row * $kartuH) + ($gapY / 2);
            @endphp

            <div class="kartu" style="top: {{ $top }}pt; left: {{ $left }}pt;">
                <img src="{{ $kartu['svg'] }}">
            </div>
        @endforeach
    </div>
</body>
</html>
