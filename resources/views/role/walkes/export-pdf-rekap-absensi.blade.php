<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $judul ?? 'Rekap Absensi' }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
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
            padding: 5px;
            text-align: center;
        }

        th {
            background: #eee;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header img {
            width: 70px;
            height: auto;
        }
    </style>
</head>

<body>
    <div class='ml-2 my-4'>
        {{-- Catatan :
                - Include Komponen Modal CRUD + Javascript / Jquery
                - Perbaiki Onclick Tombol Modal Create, Edit
                - Variabel Active Crud menggunakan ID User
                 --}}
        <x-kop-surat-cetak>{{ $logo }}</x-kop-surat-cetak>
        <div class="col-xl-12">
            <table id='example1' width='100%' class='table table-responsive table-bordered table-hover mr-2'>
                <thead>
                    <tr class="text-center align-middle">
                        <th width="1%" rowspan="3">ID</th>
                        @foreach ($arr_ths as $arr_th)
                            <th rowspan="3">{{ $arr_th }}</th>
                        @endforeach

                        {{-- Hitung total kolom bulan --}}
                        <th colspan="{{ count($bulanArray) * 3 }}">Bulan</th>

                        {{-- Total per jenis absen (S, I, A) --}}
                        <th colspan="3" rowspan="2">Total</th>

                        {{-- Total keseluruhan --}}
                        <th width="5%" rowspan="3" class="text-wrap">Total Tidak Hadir</th>
                    </tr>

                    {{-- Nama Bulan --}}
                    <tr class="text-center align-middle">
                        @foreach ($bulanArray as $bulan)
                            @php
                                $bulanName = \Carbon\Carbon::create()->month($bulan)->locale('id')->isoFormat('MMM');
                            @endphp
                            <th colspan="3" class="text-center text-uppercase">{{ $bulanName }}</th>
                        @endforeach
                    </tr>

                    {{-- Subkolom: S, I, A --}}
                    <tr class="text-center align-middle">
                        @foreach ($bulanArray as $bulan)
                            <th class="table-warning">S</th>
                            <th>I</th>
                            <th class="table-danger">A</th>
                        @endforeach

                        <th class="table-warning">S</th>
                        <th>I</th>
                        <th class="table-danger">A</th>
                    </tr>
                </thead>


                <tbody>
                    @foreach ($datas as $data)
                        @php
                            $data_siswa = App\Models\User\Siswa\Detailsiswa::find($data['detailsiswa_id']);
                        @endphp
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $data_siswa->nis }}</td>
                            <td class="text-left">{{ $data_siswa->nama_siswa }}</td>

                            @php
                                $totalS = 0;
                                $totalI = 0;
                                $totalA = 0;
                            @endphp

                            @foreach ($bulanArray as $bulan)
                                @php
                                    $bulanName = \Carbon\Carbon::create()->month($bulan)->format('M');
                                    $S = $data['S_' . $bulanName] ?? 0;
                                    $I = $data['I_' . $bulanName] ?? 0;
                                    $A = $data['A_' . $bulanName] ?? 0;
                                    $totalS += $S;
                                    $totalI += $I;
                                    $totalA += $A;
                                @endphp

                                <td class="text-center table-warning">{{ $S }}</td>
                                <td class="text-center">{{ $I }}</td>
                                <td class="text-center table-danger">{{ $A }}</td>
                            @endforeach

                            {{-- Total per siswa --}}
                            <td class="text-center">{{ $totalS }}</td>
                            <td class="text-center">{{ $totalI }}</td>
                            <td class="text-center">{{ $totalA }}</td>
                            <td class="text-center">{{ $totalS + $totalI + $totalA }}</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</body>

</html>
