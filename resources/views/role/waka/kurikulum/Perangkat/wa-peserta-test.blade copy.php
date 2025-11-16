<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Peserta Test</title>
    <style>
        @page {
            margin: 30px 25px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11.5px;
            line-height: 1.4;
        }

        h2,
        h3 {
            text-align: center;
            margin: 0;
            padding: 0;
        }

        h3 {
            margin-bottom: 20px;
            font-weight: normal;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #f0f0f0;
            font-weight: bold;
        }

        .judul-ruang {
            background: #ddd;
            font-weight: bold;
            text-align: left;
            padding: 6px;
        }

        .footer {
            text-align: right;
            font-size: 10px;
            margin-top: 30px;
            color: #555;
        }
    </style>
</head>

<body>

    <h2>🧩 Daftar Pasangan Peserta Test</h2>
    <h3>TEST : {{ $nama_test ?? '-' }}</h3>
    @foreach ($hasil as $indexRuang => $dataRuang)
        <table>
            <tr>
                <th colspan="3" class="judul-ruang">🧩 Ruang {{ $dataRuang['ruang'] }}</th>
            </tr>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 45%;">Peserta 1</th>
                <th style="width: 45%;">Peserta 2</th>
            </tr>

            @foreach ($dataRuang['pasangan'] as $indexPasangan => $pair)
                @php
                    $data1 = $pair['A'] ?? null;
                    $data2 = $pair['B'] ?? null;
                @endphp
                <tr>
                    <td style="text-align:center;">{{ str_pad($indexPasangan + 1, 2, '0', STR_PAD_LEFT) }}</td>
                    <td>
                        @if ($data1)
                            <strong>{{ $data1['nama_siswa'] }}</strong><br>
                            <span style="font-size: 0.9em; color: #555;">
                                {{ $data1['notest'] }}
                            </span>
                        @else
                            — (kosong)
                        @endif
                    </td>
                    <td>
                        @if ($data2)
                            <strong>{{ $data2['nama_siswa'] }}</strong><br>
                            <span style="font-size: 0.9em; color: #555;">
                                {{ $data2['notest'] }}
                            </span>
                        @else
                            — (tidak ada pasangan)
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    @endforeach

    <div class="footer">
        Dicetak pada {{ now()->format('d/m/Y H:i') }}
    </div>

</body>

</html>
