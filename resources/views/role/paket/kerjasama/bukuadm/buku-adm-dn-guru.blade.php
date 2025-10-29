<x-layout-cetak>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @media print {
            @page {
                size: landscape;
                /* margin: 1cm; */
                margin-top: 10px;
            }

            body {
                /* -webkit-print-color-adjust: exact;
                print-color-adjust: exact; */
            }

            table.table-sm {
                font-size: 11px;
                /* kamu bisa ubah ke 10px, 12px, dst */
            }

            table.table-sm {
                font-size: 9px;
                /* ukuran lebih kecil saat print kalau perlu */
            }

            .page-break {
                page-break-before: always;
                break-before: page;
            }

            .info-header {
                display: flex !important;
                flex-wrap: nowrap !important;
                gap: 0;
                margin-bottom: 0.5rem;
            }

            .info-header>div {
                flex: 1 1 0;
                max-width: 33.33%;
                padding-left: 5px;
                padding-right: 5px;
            }

            .table-sm td {
                padding: 0.2rem 0.3rem;
                font-size: 10px;
            }
        }
    </style>

    @foreach ($DataPerKelas as $group => $daftarSiswa)
        @php
            $namaKelas = $daftarSiswa->first()->kelasOne->kelas ?? 'Tanpa Kelas';
        @endphp

        <div class="block-kelas">
            <h5 class="fw-bold text-center">DAFTAR NILAI</h5>
            <h5 class="fw-bold text-center">{{ strtoupper($Identitas->namasek) }} </h5>
            <div class="row ">
                <div class="col-md-3">
                    <table class="table table-sm table-borderless align-middle w-100">
                        <tr>
                            <td class="text-start" style="width: 30%;">Mata Pelajaran</td>
                            <td style="width: 5%;">:</td>
                            <td class="text-start">.........................</td>
                        </tr>
                        <tr>
                            <td class="text-start">Kelas</td>
                            <td>:</td>
                            <td class="text-start">{{ $namaKelas }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-3">
                </div>

                <div class="col-md-3">
                    <table class="table table-sm table-borderless align-middle w-100">
                        <tr>
                            <td class="text-start" style="width: 30%;">Tahun Pelajaran</td>
                            <td style="width: 5%;">:</td>
                            <td class="text-start">{{ $Tapels->tapel }} / {{ $Tapels->tapel + 1 }}</td>
                        </tr>
                        <tr>
                            <td class="text-start">Semester</td>
                            <td>:</td>
                            <td class="text-start">
                                {{ $Tapels->semester == 'II' ? 'Genap' : 'Ganjil' }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <table class="table-sm text-center align-middle table table-bordered w-100">
                <thead class="table-light">
                    <tr>
                        <th class='text-center align-middle' rowspan="3">NO. URUT</th>
                        <th class='text-center align-middle' rowspan="3">NAMA</th>
                        <th class='text-center align-middle' colspan="20">FORMATIF</th>
                        <th class='text-center align-middle' colspan="5" rowspan="2">SUMATIF LINGKUP MATERI</th>
                        <th class='text-center align-middle' rowspan="3" style="white-space: normal;">SUMATIF AKHIR
                        </th>
                    </tr>
                    <tr>
                        <th colspan="4">LM 1</th>
                        <th colspan="4">LM 2</th>
                        <th colspan="4">LM 3</th>
                        <th colspan="4">LM 4</th>
                        <th colspan="4">LM 5</th>
                    </tr>
                    <tr>
                        @for ($i = 1; $i <= 5; $i++)
                            <th>TP1</th>
                            <th>TP2</th>
                            <th>TP3</th>
                            <th>TP4</th>
                        @endfor
                        <th>LM1</th>
                        <th>LM2</th>
                        <th>LM3</th>
                        <th>LM4</th>
                        <th>LM5</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($daftarSiswa as $i => $siswa)
                        <tr>
                            <td class='text-center align-middle'>{{ $i + 1 }}</td>
                            <td class='text-left align-middle'>{{ $siswa->nama_siswa }}</td>

                            {{-- 20 kolom formatif --}}
                            @for ($j = 0; $j < 20; $j++)
                                <td class='text-center align-middle'></td>
                            @endfor

                            {{-- 5 sumatif --}}
                            @for ($k = 0; $k < 5; $k++)
                                <td class='text-center align-middle'></td>
                            @endfor

                            {{-- 1 akhir semester --}}
                            <td class='text-center align-middle'></td>
                        </tr>
                    @endforeach

                    {{-- Tambahan baris kosong untuk cadangan siswa pindahan --}}
                    @for ($z = 1; $z <= 3; $z++)
                        <tr>
                            <td class='text-center align-middle'>{{ $daftarSiswa->count() + $z }}</td>
                            <td class='text-left align-middle'></td>

                            {{-- 20 kolom formatif --}}
                            @for ($j = 0; $j < 20; $j++)
                                <td class='text-center align-middle'></td>
                            @endfor

                            {{-- 5 sumatif --}}
                            @for ($k = 0; $k < 5; $k++)
                                <td class='text-center align-middle'></td>
                            @endfor

                            {{-- 1 akhir semester --}}
                            <td class='text-center align-middle'></td>
                        </tr>
                    @endfor

                </tbody>
            </table>
        </div>
        <div class='page-break'></div>

        <div class="block-kelas">
            <h5 class="fw-bold text-center">DAFTAR ABSENSI SISWA</h5>
            <h5 class="fw-bold text-center">{{ strtoupper($Identitas->namasek) }} </h5>
            <div class="row info-header gx-2 gy-1">
                <div class="col-md-4 col-12">
                    <table class="table table-sm table-borderless align-middle w-100">
                        <tr>
                            <td class="text-start" style="width: 30%;">Mata Pelajaran</td>
                            <td style="width: 5%;">:</td>
                            <td class="text-start">.........................</td>
                        </tr>
                        <tr>
                            <td class="text-start">Kelas</td>
                            <td>:</td>
                            <td class="text-start">{{ $namaKelas }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4 col-12">
                </div>

                <div class="col-md-4 col-12">
                    <table class="table table-sm table-borderless align-middle w-100">
                        <tr>
                            <td class="text-start" style="width: 30%;">Tahun Pelajaran</td>
                            <td style="width: 5%;">:</td>
                            <td class="text-start">{{ $Tapels->tapel }} / {{ $Tapels->tapel + 1 }}</td>
                        </tr>
                        <tr>
                            <td class="text-start">Semester</td>
                            <td>:</td>
                            <td class="text-start">
                                {{ $Tapels->semester == 'II' ? 'Genap' : 'Ganjil' }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <table class="table-sm text-center align-middle table table-bordered w-100">
                <thead class="table-light">
                    @php
                        $KolomHadir = 31;
                    @endphp
                    <tr>
                        <th class='text-center align-middle' rowspan="2">NO. URUT</th>
                        <th class='text-center align-middle' rowspan="2">NAMA</th>
                        <th class='text-center align-middle' colspan="{{ $KolomHadir }}">PERTEMUAN KE</th>
                        <th class='text-center align-middle' rowspan="2">TOTAL KEHADIRAN</th>
                    </tr>
                    <tr>
                        @for ($i = 0; $i < $KolomHadir; $i++)
                            <th>{{ $i + 1 }}</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @foreach ($daftarSiswa as $i => $siswa)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class='text-left align-middle'>{{ $siswa->nama_siswa }}</td>

                            {{-- 20 kolom formatif --}}
                            @for ($j = 0; $j < $KolomHadir; $j++)
                                <td class='text-center align-middle'></td>
                            @endfor

                            {{-- 1 akhir semester --}}
                            <td class='text-center align-middle'></td>
                        </tr>
                    @endforeach

                    {{-- Tambahan baris kosong untuk cadangan siswa pindahan --}}
                    @for ($z = 1; $z <= 3; $z++)
                        <tr>
                            <td class='text-center align-middle'>{{ $daftarSiswa->count() + $z }}</td>
                            <td class='text-left align-middle'></td>

                            {{-- 20 kolom formatif --}}
                            @for ($j = 0; $j < $KolomHadir; $j++)
                                <td class='text-center align-middle'></td>
                            @endfor


                            {{-- 1 akhir semester --}}
                            <td class='text-center align-middle'></td>
                        </tr>
                    @endfor

                </tbody>
            </table>
        </div>
        <div class='page-break'></div>
    @endforeach

</x-layout-cetak>
