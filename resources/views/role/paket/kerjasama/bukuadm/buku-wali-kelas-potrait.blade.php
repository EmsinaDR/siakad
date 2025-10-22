<x-layout-potrait>
    @foreach ($DataPerKelas as $group => $daftarSiswa)
        @php
            $kelasObjek = $daftarSiswa->first()->kelasOne;
            $haris = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum"at', 'Sabtu'];
        @endphp
        {{-- Cover --}}
        <div class="row">
            <h2 class='text-center'>{{ strtoupper($Identitas->namasek) }}</h2>
            <h4 class='text-center'>TERAKREDITASI {{ strtoupper($Identitas->akreditasi) }}</h4>
            <div class="col-md-3 text-center"></div>
            <div class="col-md-6 text-center">
                <h4 class="fw-bold text-center my-4">BUKU WALI KELAS</h4>
                <table id='example1' width='100%' class='table table-bordered table-hover'>
                    <tr class='text-center align-middle'>
                        <th>Nama Wali Kelas</th>
                        <th>:</th>
                        <th>{{ $kelasObjek->kelastoDetailguru->nama_guru ?? '-' }}</th>
                    </tr>
                    <tr class='text-center align-middle'>
                        <th>Kelas</th>
                        <th>:</th>
                        <th>{{ $kelasObjek->kelas ?? '-' }}</th>
                    </tr>
                    <tr class='text-center align-middle'>
                        <th>Jumlah Siswa</th>
                        <th>:</th>
                        <th>{{ count($daftarSiswa) }}</th>
                    </tr>
                    <tr class='text-center align-middle'>
                        <th>Tahun Pelajaran</th>
                        <th>:</th>
                        <th>{{ $Tapels->tapel }} / {{ $Tapels->tapel + 1 }}</th>
                    </tr>
                </table>

            </div>
            <div class="col-md-3 text-center"></div>
        </div>
        <div class='page-break'></div>
        {{-- JURNAL KELAS --}}
        <h4 class="fw-bold text-center my-4">JURNAL KELAS</h4>
        <div class="row info-header gx-2 gy-1">
            <div class="col-md-4 col-12">
                <table class="table table-sm table-borderless align-middle w-100">
                    <tr>
                        <td class="text-start" style="width: 30%;">Wali Kelas</td>
                        <td style="width: 5%;">:</td>
                        <td class="text-start">{{ $kelasObjek->kelastoDetailguru->nama_guru ?? '-' }}
                        </td>

                    </tr>
                    <tr>
                        <td class="text-start">Kelas</td>
                        <td>:</td>
                        <td class="text-start">{{ $kelasObjek->kelas }}</td>
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
        <div class="row justify-content-center">
            <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                <thead>
                    <tr class='table-primary text-center align-middle'>
                        <th class='text-center align-middle'>ID</th>
                        <th class='text-center align-middle'>Pelajaran</th>
                        <th class='text-center align-middle'>Guru</th>
                        <th class='text-center align-middle'>Materi</th>
                        <th class='text-center align-middle'>Absensi</th>
                        <th class='text-center align-middle'>Tanda Tangan</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 1; $i <= 10; $i++)
                        <tr>
                            <td class='text-center align-middle'>{{ $i }}</td>
                            @for ($j = 1; $j <= 4; $j++)
                                <td></td>
                            @endfor
                            <td class="{{ $i % 2 == 1 ? 'text-start' : 'text-center' }}">
                                {{ $i }}.........................
                            </td>

                        </tr>
                    @endfor
                </tbody>
                <tfoot>
                    <tr class='table-primary text-center align-middle'>
                        <th>ID</th>
                        <th>Pelaajran</th>
                        <th>Guru</th>
                        <th>Materi</th>
                        <th>Absensi</th>
                        <th>Tanda Tangan</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class='page-break'></div>
        {{-- JADWAL PELAJARAN --}}
        <h4 class="fw-bold text-center my-4">JADWAL PELAJARAN</h4>
        <div class="row justify-content-center">
            @foreach ($haris as $hari)
                <div class="card col-xl-4 col-md-4 col-print-3">
                    <div class='card-header bg-success my-2'>
                        <h5 class='card-title m-2 text-white'>{{ $hari }}</h5>
                    </div>
                    <div class='card-body'>
                        @for ($i = 1; $i <= 6; $i++)
                            {{ $i }} </br>
                        @endfor
                    </div>
                </div>
            @endforeach
        </div>
        <div class='page-break'></div>
        {{-- DATA PIKET --}}
        <h4 class="fw-bold text-center my-4">JADWAL PIKETT</h4>
        <div class="row justify-content-center">
            @foreach ($haris as $hari)
                <div class="card col-xl-4 col-md-4 col-print-3">
                    <div class='card-header bg-success my-2'>
                        <h5 class='card-title m-2 text-white'>{{ $hari }}</h5>
                    </div>
                    <div class='card-body'>
                        @for ($i = 1; $i <= 6; $i++)
                            {{ $i }} </br>
                        @endfor
                    </div>
                </div>
            @endforeach
        </div>

        <div class='page-break'></div>
        {{-- HOME VISIT --}}
        {{-- <h4 class="fw-bold text-center my-4">DATA HOME VISIT</h4>
        <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
            <thead>
                <tr class='text-center align-middle'>
                    <th class='text-center align-middle'>ID</th>
                    <th class='text-center align-middle'>Hari Tanggal</th>
                    <th class='text-center align-middle'>Nama Siswa</th>
                    <th class='text-center align-middle'>Permasalahan</th>
                    <th class='text-center align-middle'>Tindak Lanjut</th>
                    <th class='text-center align-middle'>Tanda Tangan Orang Tua</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 1; $i <= 26; $i++)
                    <tr class='text-center'>
                        <td>{{ $i }}</td>
                        @for ($j = 1; $j <= 5; $j++)
                            <td></td>
                        @endfor
                    </tr>
                @endfor
            </tbody>
        </table>
        <div class='page-break'></div> --}}
        {{-- CATATAN KEPRIBADIAN SISWA --}}
        {{-- <h4 class="fw-bold text-center my-4">CATATAN KEPRIBADIAN SISWA</h4>
        <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
            <thead>
                <tr class='text-center align-middle'>
                    <th colspan='1' rowspan='2'>ID</th>
                    <th colspan='1' rowspan='2'>Nama Siswa</th>
                    <th colspan='3' rowspan='1'>Semester Gasal</th>
                    <th colspan='3' rowspan='1'>Semester Genap</th>
                </tr>

                @for ($i = 1; $i <= 2; $i++)
                    <th class='text-center align-middle' colspan='1' rowspan='1'>A</th>
                    <th class='text-center align-middle' colspan='1' rowspan='1'>B</th>
                    <th class='text-center align-middle' colspan='1' rowspan='1'>C</th>
                @endfor

            </thead>
            <tbody>
                @foreach ($daftarSiswa as $i => $siswa)
                    <tr>
                        <td class="text-center align-middle">{{ $loop->iteration }}</td>
                        <td class="text-left align-middle">{{ $siswa->nama_siswa }}</td>
                        @for ($i = 1; $i <= 6; $i++)
                            <th class='text-center align-middle' colspan='1' rowspan='1'></th>
                        @endfor
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class='page-break'></div> --}}
        {{-- DATA KEHADIRAN SISWA --}}
        {{-- <h4 class="fw-bold text-center my-4">DATA KEHADIRAN SISWA</h4>
        <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
            <thead>
                <tr class='text-center align-middle'>
                    <th colspan='1' rowspan='3'>ID</th>
                    <th colspan='1' rowspan='3'>Nama Siswa</th>
                    <th colspan='18' rowspan='1'>Semester Gasal</th>
                    <th colspan='3' rowspan='2'>Total</th>
                    <th colspan='18' rowspan='1'>Semester Genap</th>
                    <th colspan='3' rowspan='2'>Total</th>
                </tr>

                <tr class='text-center align-middle'>
                    @for ($i = 7; $i <= 12; $i++)
                        <th colspan='3' rowspan='1' class='text-center align-middle' colspan='1'
                            rowspan='1'>{{ $i }}</th>
                    @endfor
                    @for ($i = 1; $i <= 6; $i++)
                        <th colspan='3' rowspan='1' class='text-center align-middle' colspan='1'
                            rowspan='1'>{{ $i }}</th>
                    @endfor
                </tr>
                @for ($i = 1; $i <= 14; $i++)
                    <th class='text-center align-middle' colspan='1' rowspan='1'>S</th>
                    <th class='text-center align-middle' colspan='1' rowspan='1'>I</th>
                    <th class='text-center align-middle' colspan='1' rowspan='1'>A</th>
                @endfor
            </thead>
            <tbody>
                @foreach ($daftarSiswa as $i => $siswa)
                    <tr>
                        <td class="text-left align-middle">{{ $loop->iteration }}</td>
                        <td class="text-left align-middle">{{ $siswa->nama_siswa }}</td>
                        @for ($i = 1; $i <= 42; $i++)
                            <th class='text-center align-middle' colspan='1' rowspan='1'></th>
                        @endfor
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class='page-break'></div> --}}
        {{-- DATA KEHADIRAN SISWA --}}
        <h4 class="fw-bold text-center my-4">DATA KEHADIRAN SISWA</h4>
        <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
            <thead>
                <tr class='text-center align-middle'>
                    <th colspan='1' rowspan='3'>ID</th>
                    <th colspan='1' rowspan='3'>Nama Siswa</th>
                    <th colspan='18' rowspan='1'>Semester Gasal</th>
                    <th colspan='3' rowspan='2'>Total</th>
                </tr>

                <tr class='text-center align-middle'>
                    @for ($i = 7; $i <= 12; $i++)
                        <th colspan='3' rowspan='1' class='text-center align-middle' colspan='1'
                            rowspan='1'>{{ $i }}</th>
                    @endfor
                    {{-- @for ($i = 1; $i <= 3; $i++)
                        <th colspan='3' rowspan='1' class='text-center align-middle' colspan='1'
                            rowspan='1'>{{ $i }}</th>
                    @endfor --}}
                </tr>
                @for ($i = 1; $i <= 7; $i++)
                    <th class='text-center align-middle' colspan='1' rowspan='1'>S</th>
                    <th class='text-center align-middle' colspan='1' rowspan='1'>I</th>
                    <th class='text-center align-middle' colspan='1' rowspan='1'>A</th>
                @endfor
            </thead>
            <tbody>
                @foreach ($daftarSiswa as $i => $siswa)
                    <tr>
                        <td class="text-left align-middle">{{ $loop->iteration }}</td>
                        <td class="text-left align-middle">{{ $siswa->nama_siswa }}</td>
                        @for ($i = 1; $i <= 21; $i++)
                            <th class='text-center align-middle' colspan='1' rowspan='1'></th>
                        @endfor
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class='page-break'></div>
        {{-- <h4 class="fw-bold text-center my-4">DATA KEHADIRAN SISWA</h4> --}}
        {{-- CATATAN KEPRIBADIAN SISWA --}}
        {{-- <h4 class="fw-bold text-center my-4">CATATAN KEPRIBADIAN SISWA</h4>
            <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                <thead>
                    <tr class='text-center align-middle'>
                        <th colspan='1' rowspan='2'>ID</th>
                        <th colspan='1' rowspan='2'>Nama Siswa</th>
                        <th colspan='3' rowspan='1'>Semester Gasal</th>
                        <th colspan='3' rowspan='1'>Semester Genap</th>
                    </tr>

                    @for ($i = 1; $i <= 2; $i++)
                        <th class='text-center align-middle' colspan='1' rowspan='1'>A</th>
                        <th class='text-center align-middle' colspan='1' rowspan='1'>B</th>
                        <th class='text-center align-middle' colspan='1' rowspan='1'>C</th>
                    @endfor

                </thead>
                <tbody>
                    @foreach ($daftarSiswa as $i => $siswa)
                        <tr>
                            <td class="text-center align-middle">{{ $loop->iteration }}</td>
                            <td class="text-left align-middle">{{ $siswa->nama_siswa }}</td>
                            @for ($i = 1; $i <= 6; $i++)
                                <th class='text-center align-middle' colspan='1' rowspan='1'></th>
                            @endfor
                        </tr>
                    @endforeach
                </tbody>
            </table> --}}
        {{-- <div class='page-break'></div> --}}
        {{-- DATA MUTASI SISWA --}}
        {{-- <h4 class="fw-bold text-center my-4">DATA MUTASI SISWA</h4>
        <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
            <thead>
                <tr class='text-center align-middle'>
                    <th colspan='1' rowspan='2'>ID</th>
                    <th colspan='1' rowspan='2'>No Induk</th>
                    <th colspan='1' rowspan='2'>NISN</th>
                    <th colspan='1' rowspan='2'>Nama Siswa</th>
                    <th colspan='5' rowspan='1'>Terhitung</th>
                    <th colspan='1' rowspan='2'>Alasan</th>
                </tr>
                <th class='text-center align-middle' colspan='1' rowspan='1'>Keluar</th>
                <th class='text-center align-middle' colspan='1' rowspan='1'>Pindah</th>
                <th class='text-center align-middle' colspan='1' rowspan='1'>Masuk</th>
                <th class='text-center align-middle' colspan='1' rowspan='1'>Tanggal</th>
                <th class='text-center align-middle' colspan='1' rowspan='1'>Semester</th>
            </thead>
            <tbody>
                @for ($i = 1; $i <= 26; $i++)
                    <tr class='text-center'>
                        <td>{{ $i }}</td>
                        @for ($j = 1; $j <= 9; $j++)
                            <td></td>
                        @endfor
                    </tr>
                @endfor
            </tbody>
        </table>

        <div class='page-break'></div> --}}

        {{-- DATA PRESTASI --}}
        {{-- <h4 class="fw-bold text-center mt-4">DATA PRESTASI</h4>
        <div class="row">
            <div class="col-md-6 col-6">
                <h4 class="fw-bold text-center">DATA PRESTASI AKADMIK</h4>
                <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                    <thead>
                        <tr class='table-success text-center align-middle'>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Jenis Prestasi</th>
                            <th>Semester</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 1; $i <= 15; $i++)
                            <tr class='text-center'>
                                <td>{{ $i }}</td>
                                @for ($j = 1; $j <= 4; $j++)
                                    <td></td>
                                @endfor
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
            <div class="col-md-6 col-6">
                <h4 class="fw-bold text-center">DATA PRESTASI NON AKADMIK</h4>
                <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                    <thead>
                        <tr class='table-success text-center align-middle'>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Jenis Prestasi</th>
                            <th>Semester</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 1; $i <= 15; $i++)
                            <tr class='text-center'>
                                <td>{{ $i }}</td>
                                @for ($j = 1; $j <= 4; $j++)
                                    <td></td>
                                @endfor
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
        <div class='page-break'></div> --}}
        {{-- DATA KONDISI SISWA --}}
        <h4 class="fw-bold text-center">DATA KONDISI SISWA</h4>
        <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
            <thead>
                <tr class='table-success text-center align-middle'>
                    <th>ID</th>
                    <th>Bulan</th>
                    <th>L</th>
                    <th>P</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $Bulan = [
                        'Juli',
                        'Agustus',
                        'September',
                        'Oktober',
                        'November',
                        'Desember',
                        'Januari',
                        'Februari',
                        'Maret',
                        'April',
                        'Mei',
                        'Juni',
                    ];
                @endphp
                @foreach ($Bulan as $DataBulan)
                    <tr class='text-center'>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $DataBulan }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class='page-break'></div>

        {{-- DATA EKSTRA --}}


        {{-- <h5 class="fw-bold text-center">DAFTAR SISWA MENGIKUTI EKSTRAKULIKULER</h5>
        <h5 class="fw-bold text-center">{{ strtoupper($Identitas->namasek) }}</h5>
        <div class="row info-header gx-2 gy-1">
            <div class="col-md-4 col-12">
                <table class="table table-sm table-borderless align-middle w-100">
                    <tr>
                        <td class="text-start" style="width: 30%;">Wali Kelas</td>
                        <td style="width: 5%;">:</td>
                        <td class="text-start">{{ $kelasObjek->kelastoDetailguru->nama_guru ?? '-' }}
                        </td>

                    </tr>
                    <tr>
                        <td class="text-start">Kelas</td>
                        <td>:</td>
                        <td class="text-start">{{ $kelasObjek->kelas }}</td>
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
        @php
            $Ekstras = ['Pramuka', 'Osis', 'Drumband', 'PMR', 'PKS', 'Hadroh'];
        @endphp
        <table class="table table-sm table-bordered align-middle w-100">
            <thead class="table-light">
                <tr>
                    <th class="text-center align-middle" rowspan="2">NO. Urut</th>
                    <th class="text-center align-middle" rowspan="2">Nama</th>
                    <th class="text-center align-middle" colspan="{{ count($Ekstras) }}">Jenis Ekstra Kurikuler
                        yang
                        Diikuti</th>
                    <th class="text-center align-middle" colspan="4">Penilaian</th>
                </tr>
                @foreach ($Ekstras as $ekstra)
                    <td class="text-center align-middle">{{ $ekstra }}</td>
                @endforeach
                <td class="text-center align-middle">A</td>
                <td class="text-center align-middle">B</td>
                <td class="text-center align-middle">C</td>
                <td class="text-center align-middle">D</td>
            </thead>
            <tbody>
                @foreach ($daftarSiswa as $i => $siswa)
                    <tr>
                        <td class="text-center align-middle">{{ $i + 1 }}</td>
                        <td class="text-left align-middle">{{ $siswa->nama_siswa }}</td>
                        @for ($i = 1; $i <= count($Ekstras) + 4; $i++)
                            <td class="text-left align-middle"></td>
                        @endfor
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class='page-break'></div> --}}
        {{-- DATA SISWA --}}
        @php
            $kelasObjek = $daftarSiswa->first()->kelasOne;
        @endphp

        @if (!$loop->first)
            <div class="page-break"></div>
        @endif

        {{-- <h5 class="fw-bold text-center">DAFTAR SISWA</h5>
        <h5 class="fw-bold text-center">{{ strtoupper($Identitas->namasek) }}</h5>
        <div class="row info-header gx-2 gy-1">
            <div class="col-md-4 col-12">
                <table class="table table-sm table-borderless align-middle w-100">
                    <tr>
                        <td class="text-start" style="width: 30%;">Wali Kelas</td>
                        <td style="width: 5%;">:</td>
                        <td class="text-start">{{ $kelasObjek->kelastoDetailguru->nama_guru ?? '-' }}</td>

                    </tr>
                    <tr>
                        <td class="text-start">Kelas</td>
                        <td>:</td>
                        <td class="text-start">{{ $kelasObjek->kelas }}</td>
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

        <table class="table table-sm table-bordered align-middle w-100">
            <thead class="table-light">
                <tr>
                    <th class="text-center align-middle" rowspan="2">NO. Urut</th>
                    <th class="text-center align-middle" rowspan="2">Nama</th>
                    <th class="text-center align-middle" rowspan="2">Alamat</th>
                    <th class="text-center align-middle" colspan="6">Orang Tua</th>
                </tr>
                <tr>
                    <th class="text-center align-middle">Nama Ayah</th>
                    <th class="text-center align-middle">No HP</th>
                    <th class="text-center align-middle">Pekerjaan</th>
                    <th class="text-center align-middle">Nama Ibu</th>
                    <th class="text-center align-middle">No HP</th>
                    <th class="text-center align-middle">Pekerjaan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($daftarSiswa as $i => $siswa)
                    <tr>
                        <td class="text-center align-middle">{{ $i + 1 }}</td>
                        <td class="text-left align-middle">{{ $siswa->nama_siswa }}</td>
                        <td class="text-left align-middle">{{ $siswa->alamat_siswa }}, RT / RW :
                            {{ $siswa->rt }}
                            /
                            {{ $siswa->rw }}, Ds. {{ $siswa->desa }}, Kec. {{ $siswa->kecamatan }}
                        </td>
                        <td class="text-left align-middle">{{ $siswa->ayah_nama }}</td>
                        <td class="text-left align-middle">{{ $siswa->ayah_nohp }}</td>
                        <td class="text-left align-middle">{{ $siswa->ayah_pekerjaan }}</td>
                        <td class="text-left align-middle">{{ $siswa->ibu_nama }}</td>
                        <td class="text-left align-middle">{{ $siswa->ibu_nohp }}</td>
                        <td class="text-left align-middle">{{ $siswa->ibu_pekerjaan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class='page-break'></div> --}}
    @endforeach
    </x-layout-landscape>
