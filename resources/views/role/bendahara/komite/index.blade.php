<x-layout>
    @php
        $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
        $urlroot = app('request')->root();
    @endphp
    <style>
        textarea {
            resize: none,
        }
    </style>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>
    <section class='content mx-2 my-4'>
        {{-- Validator --}}
        @if ($errors->any())
            <div class='alert alert-danger'>
                <ul class='mb-0'>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- Validator --}}
        <div class=''>
            {{-- Papan Informasi --}}
            <div class='card-body'>

            </div>
            {{-- <x-informasi-bendahara>{{ $info }}</x-informasi-bendahara> --}}
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->
            <div class='mx-2 my-4'>
                <div class="row gap-2">
                    <div class="col-xl-8 mb-2">
                        <div class="card">
                            {{-- <div class='card-header bg-primary'>
                            <h3 class='card-title'>Data Pemasukkan</h3>
                        </div> --}}
                            <div class='card-body'>
                                <table id='example1' width='100%'
                                    class='table table-table-success bordered table-striped table-hover'>
                                    <thead>
                                        <tr class='text-center align-middle'>
                                            <th>ID</th>
                                            <th>Tahun Pelajaran</th>
                                            <th>Semester</th>
                                            <th>Pemasukkan</th>
                                            <th>Pengeluaran</th>
                                            <th>Sisa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $tapels = App\Models\Admin\Etapel::orderBy('id', 'DESC')->get();
                                        @endphp
                                        @foreach ($tapels as $tapel)
                                        @php
                                        //\App\Models\Bendahara\
                                        $CekPemasukkan = \App\Models\Bendahara\BendaharaKomite::where('tapel_id', $tapel->id)->pluck('nominal')->sum();
                                        $CekPengeluaran = \App\Models\Bendahara\KomitePengeluaran::where('tapel_id', $tapel->id)->pluck('nominal')->sum();
                                        // $CekPengeluaranx = \App\Models\Bendahara\KomitePengeluaran::where('tapel_id', $tapel->id)->pluck('nominal')->toArray();
                                        // dump($CekPengeluaranx);
                                        @endphp
                                            <tr>
                                                <td class='text-center'>{{ $loop->iteration }}</td>
                                                <td class='text-center'>{{ $tapel->tapel }} - {{ $tapel->tapel + 1 }}
                                                </td>
                                                <td class='text-center'>{{ $tapel->semester }}</td>
                                                <td class='text-center'>Rp. {{ number_format($CekPemasukkan, 0)}}</td>
                                                <td class='text-center'>Rp. {{ number_format($CekPengeluaran, 0)}}</td>
                                                <td class='text-center'>Rp. {{number_format($CekPemasukkan - $CekPengeluaran, 0)}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class='text-center align-middle'>
                                            <th>ID</th>
                                            <th>Tahun Pelajaran</th>
                                            <th>Semester</th>
                                            <th>Pemasukkan</th>
                                            <th>Pengeluaran</th>
                                            <th>Sisa</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 mb-2">
                        <div class="card mx-2 ">
                            <div class="card-body mx-2 ">
                                {{-- <x-grafik>{{ implode(',', $label_grafik) }}/{{ implode(',', $data_grafik) }}/pie/50%,50%/GarfikKeungangan,Keungan Komite</x-grafik> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 my-2">
                        <div class="card">
                            <div class='card-header bg-warning'>
                                <h3 class='card-title'>Pemasukkan Kelas Pada Tapel {{$Tapels->tapel}} - {{$Tapels->semester}}</h3>
                            </div>
                            <div class='card-body'>
                                <table id='example2' width='100%' class='table table-bordered table-hover'>
                                    <thead>
                                        <tr class='text-center table-warning align-middle'>
                                            <th>ID</th>
                                            <th>Kelas</th>
                                            <th>Jumlah Siswa</th>
                                            <th>Terbayar</th>
                                            <th>Sisa</th>
                                            <th>Persentase</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datapemasukkan_kelass as $data)
                                            {{-- blade-formatter-disable --}}
                                            @php
                                                $JumlahSiswa = \App\Models\User\Siswa\Detailsiswa::where('kelas_id', $data->id)->count();
                                            @endphp
                                            {{-- blade-formatter-enable --}}
                                            <tr class='text-center'>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->kelas }}</td>
                                                <td>{{ $JumlahSiswa }}</td>
                                                <td class='text-center'>
                                                    {{-- blade-formatter-disable --}}
                                                    {{-- Terbayar --}}
                                                    @php
                                                        //Menghitung Pembayaran disetiap kelas
                                                        $total_pembayaran_kelas = App\Models\Bendahara\BendaharaKomite::where('tapel_id', $Tapels->id)
                                                            ->where('kelas_id', $data->id)
                                                            ->sum('nominal');
                                                    @endphp
                                                    {{-- blade-formatter-enable --}}
                                                    Rp. {{ number_format($total_pembayaran_kelas) }}</td>
                                                <td class='text-center'>
                                                   {{-- blade-formatter-disable --}}
                                                   {{-- Sisa --}}
                                                    @php
                                                        //Menghitung pembayaran di tiap tingkat
                                                        $total_pembayaran_tingkat = App\Models\Bendahara\KeuanganRiwayatList::where('tapel_id', $Tapels->id)->where('tingkat_id',  $data->tingkat_id)->sum('nominal');
                                                        $total_pemasukkan_kelas = $total_pembayaran_tingkat * $JumlahSiswa;
                                                    @endphp
                                                   {{-- blade-formatter-enable --}}
                                                    {{-- Total harus terbayar - total pembyaran disetiap kelas --}}
                                                    Rp.
                                                    {{ number_format($total_pemasukkan_kelas - $total_pembayaran_kelas, 0) }}
                                                    {{-- Harus : Rp. {{ number_format($total_pemasukkan_kelas, 0) }} --}}
                                                </td>
                                                <td class='text-center'>
                                                   {{-- blade-formatter-disable --}}
                                                    @if ($total_pemasukkan_kelas === 0)
                                                        Belum Ada Pemasukkan
                                                    @else
                                                        @if ($total_pembayaran_kelas / $total_pemasukkan_kelas <= 60 / 100)
                                                            <span class='bg-danger p-2'>{{ number_format(($total_pembayaran_kelas / $total_pemasukkan_kelas) * 100, 1) }}%</span>
                                                        @elseif($total_pembayaran_kelas / $total_pemasukkan_kelas <= 80 / 100)
                                                            <span class='bg-warning p-2'>{{ number_format(($total_pembayaran_kelas / $total_pemasukkan_kelas) * 100, 1) }}%</span>
                                                        @else
                                                            <span class='bg-success p-2'>{{ number_format(($total_pembayaran_kelas / $total_pemasukkan_kelas) * 100, 1) }}%</span>
                                                        @endif
                                                    @endif
                                                   {{-- blade-formatter-enable --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class='text-center align-middle'>
                                            <th>ID</th>
                                            <th>Kelas</th>
                                            <th>Jumlah Siswa</th>
                                            <th>Terbayar</th>
                                            <th>Sisa</th>
                                            <th>Persentase</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 my-2">
                        <div class="card">
                            <div class='card-header bg-primary'>
                                <h3 class='card-title'>Riwayat Transaksi</h3>
                            </div>
                            <div class='card-body'>
                                <table id='example3' width='100%' class='table table-bordered table-hover'>
                                    <thead>
                                        <tr class='text-center table-primary align-middle'>
                                            <th width='1%'>ID</th>
                                            <th>No Transaksi</th>
                                            <th>Jenis Pembayaran</th>
                                            <th>Nama Siswa</th>
                                            <th>Nominal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datapemasukkan_kelas as $data)
                                            <tr>
                                                {{-- <td></td> --}}
                                                <td class='text-center'>{{ $loop->iteration }}</td>
                                                <td class='text-left'>{{ $data->nomor_pembayaran }}</td>
                                                <td class='text-left'>{{ $data->KeuanganRiwayat->jenis_pembayaran }}
                                                </td>
                                                {{-- <td class='text-center'>{{ $data->BendaharaKomiteToDetailsiswa->nis }}</td> --}}
                                                <td class='text-left'>
                                                    {{ $data->BendaharaKomiteToDetailsiswa->nama_siswa }} /
                                                    {{ $data->BendaharaKomiteToDetailsiswa->kelas_id }}</td>
                                                <td class='text-left'>
                                                    Rp. {{ number_format($data->nominal, 0) }}
                                                    {{-- Pengecekan Lunas --}}

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class='text-center table-primary align-middle'>
                                            <th>ID</th>
                                            <th>No Transaksi</th>
                                            <th>Jenis Pembayaran</th>
                                            <th>Nama Siswa</th>
                                            <th>Nominal</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>
</x-layout>

<button class='btn btn-warning btn-sm' onclick='()'><i class='fa fa-edit right'></i> Edit</button>

<script>
    functio(data) {
            va = new bootstrap.Modal(document.getElementById '));
                .show(); document.getElementById('Eid').value = data.id;
            }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' tabindex='-1' aria-labelledby='Lab' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='Lab'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                content

            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
            </div>
        </div>
    </div>

</div>
