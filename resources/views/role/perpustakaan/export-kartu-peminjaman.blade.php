<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Kartu Peminjaman Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 0;
        }

        .card-header {
            background-color: #0d6efd;
            color: white;
            padding: 0.5rem 1rem;
            border-bottom: 1px solid #dee2e6;
        }

        .card-title {
            font-size: 16px;
            margin: 0;
        }

        .card-body {
            padding: 1rem;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2px;
            line-height: 1.5pt;
        }

        .table th,
        .table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: center;
        }

        .table th {
            background-color: #cfe2ff;
        }

        img.logo {
            max-width: 90%;
            height: auto;
        }

        .text-center {
            text-align: center;
        }

        p {
            margin: 0.2rem 0;
        }

        td {
            height: 20px;
        }
    </style>
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        .page-break {
            page-break-after: always;
        }

        .card-wrapper {
            width: 45%;
            display: inline-block;
            vertical-align: top;
            margin: 1%;
            box-sizing: border-box;
            border: 1px solid #ccc;
            padding: 10px;
        }

        .card-header {
            background-color: #0d6efd;
            color: white;
            padding: 4px 8px;
            font-size: 14px;
            text-align: center;
        }

        .card-body {
            font-size: 11px;
        }

        .info-table td {
            padding: 2px 2px;
        }

        .borrow-table th,
        .borrow-table td {
            border: 1px solid #000;
            font-size: 10px;
            padding: 2px;
            text-align: center;
        }
    </style>

</head>
<style>
    @media print {
        .page-break {
            page-break-after: always;
        }
    }
</style>

<body>
    <div class="row">
        @foreach ($datas_kartubuku->chunk(4) as $group)
            <div class="page-break">
                <div class="COL">
                    @foreach ($group as $data)
                        <div class="card-wrapper">
                            <div class="card-header">
                                Kartu Buku {{ $data->judul_buku }}
                            </div>
                            <div class="card-body">
                                <table class="info-table">
                                    <tr>
                                        <td><strong>Nama</strong></td>
                                        <td>: {{ $data->nama_siswa ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>NIS</strong></td>
                                        <td>: {{ $data->nis ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>NISN</strong></td>
                                        <td>: {{ $data->nisn ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Kelas</strong></td>
                                        <td>: {{ $data->kelas->kelas ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tingkat</strong></td>
                                        <td>: {{ $data->kelas->tingkat ?? '' }}</td>
                                    </tr>
                                </table>

                                <table class="borrow-table mt-2" width="100%" cellspacing="0" cellpadding="0">
                                    <thead>
                                        <tr>
                                            <th>Judul Buku</th>
                                            <th>Tanggal Pinjam</th>
                                            <th>Tanggal Kembali</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($i = 0; $i < 23; $i++)
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach


    </div>

</body>

</html>
