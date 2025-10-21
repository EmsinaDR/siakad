<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $title }} - {{ $SiswaTujuan->nama_siswa }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }

        h3 {
            margin-bottom: 0;
        }
    </style>
</head>

<body>
    <h3>{{ $title }}</h3>
    <p>Nama: {{ $SiswaTujuan->nama_siswa }} | Kelas: {{ $SiswaTujuan->KelasOne->kelas ?? '-' }}</p>
    <p>Periode: {{ $tanggal_awal }} s/d {{ $tanggal_akhir }}</p>

    <h4>Detail Absensi</h4>
    <table>
        <thead>
            <tr>
                @foreach ($arr_ths as $th)
                    <th>{{ $th }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($DataSiswa as $absen)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($absen->waktu_absen)->translatedFormat('l, d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($absen->created_at)->format('H:i') }}</td>
                    <td>{{ ucfirst($absen->absen) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Rekap Bulanan</h4>
    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Hadir</th>
                <th>Sakit</th>
                <th>Ijin</th>
                <th>Alpa</th>
                <th>Total</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($RekapBulanan as $rekap)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($rekap['bulan'] . '-01')->translatedFormat('F Y') }}</td>
                    <td>{{ $rekap['hadir'] }}</td>
                    <td>{{ $rekap['sakit'] }}</td>
                    <td>{{ $rekap['ijin'] }}</td>
                    <td>{{ $rekap['alpa'] }}</td>
                    <td>{{ $rekap['jumlah_total'] }}</td>
                    <td>{{ number_format($rekap['hadir'] / $rekap['jumlah_total'], 2) * 100 }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
