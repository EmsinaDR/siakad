@php
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Str;

    $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
    $urlroot = app('request')->root();
    \Carbon\Carbon::setLocale('id');
@endphp
<x-layout>
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
        {{-- Papan Informasi --}}

        {{-- Papan Informasi --}}

        <!--Car Header-->
        <div class='card-header bg-primary mx-2'>
            <h3 class='card-title'>{{ $title }}</H3>
        </div>
        <!--Car Header-->


        <div class='ml-2 my-4'>
            <div class="card">
                <div class="row m-2">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-xl-4">
                                {{-- Info --}}
                                <div class='small-box bg-info'>
                                    <h3 class='m-2'>Pemasukkan</h3>
                                    <div class='inner'>
                                        <div class=" d-flex justify-content-between">
                                            <span><i class="fa fa-user mr-1"></i> Kelas
                                                VII</span><span>Rp. {{ number_format($kelas_vii_in, 2) }}</span>
                                        </div>
                                        <div class=" d-flex justify-content-between">
                                            <span><i class="fa fa-user mr-1"></i> Kelas
                                                VIII</span><span>Rp. {{ number_format($kelas_viii_in, 2) }}</span>
                                        </div>
                                        <div class=" d-flex justify-content-between">
                                            <span><i class="fa fa-user mr-1"></i> Kelas
                                                IX</span><span>Rp. {{ number_format($kelas_ix_in, 2) }}</span>
                                        </div>
                                        <hr class='bg-light' style='height: 2px;'>

                                        <div class=" d-flex justify-content-between">
                                            <span><i class="fa fa-coins mr-1"></i> Total </span><span>Rp.
                                                {{ number_format($kelas_vii_in + $kelas_viii_in + $kelas_ix_in, 2) }}</span>
                                        </div>
                                    </div>

                                    <div class='icon'>
                                        <i class='fa fa-dollar-sign'></i>
                                    </div>
                                    <a href='#' class='small-box-footer'>More info <i
                                            class='fas fa-arrow-circle-right'></i></a>
                                </div>
                                {{-- Info Akhir --}}
                            </div>
                            <div class="col-xl-4">
                                <div class='small-box bg-brown'>
                                    <h3 class='m-2'>Pengeluaran</h3>
                                    <div class='inner'>
                                        <div class=" d-flex justify-content-between">
                                            <span><i class="fa fa-user mr-1"></i> Kelas
                                                VII</span><span>Rp. {{ number_format($kelas_vii_out, 2) }}</span>
                                        </div>
                                        <div class=" d-flex justify-content-between">
                                            <span><i class="fa fa-user mr-1"></i> Kelas
                                                VIII</span><span>Rp. {{ number_format($kelas_viii_out, 2) }}</span>
                                        </div>
                                        <div class=" d-flex justify-content-between">
                                            <span><i class="fa fa-user mr-1"></i> Kelas
                                                IX</span><span>Rp. {{ number_format($kelas_ix_out, 2) }}</span>
                                        </div>
                                        <hr class="bg-light" style="height: 2px;">
                                        <div class=" d-flex justify-content-between">
                                            <span><i class="fa fa-coins mr-1"></i> Total </span><span>Rp.
                                                {{ number_format($kelas_vii_out + $kelas_viii_out + $kelas_ix_out, 2) }}</span>
                                        </div>
                                    </div>

                                    <div class='icon'>
                                        <i class='fa fa-money-bill'></i>
                                    </div>
                                    <a href='#' class='small-box-footer'>More info <i
                                            class='fas fa-arrow-circle-right'></i></a>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class='small-box bg-warning'>
                                    <h3 class='m-2'>Sisa</h3>
                                    <div class='inner'>
                                        <div class=" d-flex justify-content-between">
                                            <span><i class="fa fa-user mr-1"></i> Kelas
                                                VII</span><span>Rp.
                                                {{ number_format($kelas_vii_in - $kelas_vii_out, 2) }}</span>
                                        </div>
                                        <div class=" d-flex justify-content-between">
                                            <span><i class="fa fa-user mr-1"></i> Kelas
                                                VIII</span><span>Rp.
                                                {{ number_format($kelas_viii_in - $kelas_viii_out, 2) }}</span>
                                        </div>
                                        <div class=" d-flex justify-content-between">
                                            {{-- <span>Kelas IX</span><span>155 Orang</span> --}}
                                            <span><i class="fa fa-user mr-1"></i> Kelas
                                                IX</span><span>Rp.
                                                {{ number_format($kelas_ix_in - $kelas_ix_out, 2) }}</span>
                                        </div>
                                        <hr class="bg-light" style="height: 2px;">
                                        <div class=" d-flex justify-content-between">
                                            <span><i class="fa fa-coins mr-1"></i> Total </span><span>Rp.
                                                {{ number_format($kelas_vii_in - $kelas_vii_out + $kelas_viii_in - $kelas_viii_out + $kelas_ix_in - $kelas_ix_out, 2) }}</span>
                                        </div>
                                    </div>

                                    <div class='icon'>
                                        <i class='fa fa-wallet'></i>
                                    </div>
                                    <a href='#' class='small-box-footer'>More info <i
                                            class='fas fa-arrow-circle-right'></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <table id='example0' width='100%' class='table table-responsive table-bordered table-hover'>
                            <thead>
                                <tr class='text-center align-middle table-success'>
                                    <th class='align-middle' rowspan='2' width='1%'>ID</th>
                                    @foreach ($arr_ths as $arr_th)
                                        <th class='align-middle' rowspan='2' class='text-center'>
                                            {{ $arr_th }}
                                        </th>
                                    @endforeach
                                    <th class='align-middle' colspan='2'>Nominal</th>
                                    <th class='align-middle' rowspan='2'>Sisa</th>
                                    <th class='align-middle' rowspan='2'>Action</th>
                                </tr>
                                <th class='text-center align-middle table-success'>Pemasukkan</th>
                                <th class='text-center align-middle table-success'>Pengeluaran</th>
                            </thead>
                            <tbody>
                                @foreach ($datasiswas as $data)
                                    <tr>
                                        <td class='text-center'>{{ $loop->iteration }}

                                        </td>
                                        <td class='text-center'>
                                            {{ $data->nis }} / {{ $data->id }}
                                        </td>
                                        <td class='text-center'>
                                            {{ $data->nama_siswa }}
                                        </td>
                                        <td class='text-center'>
                                            {{ $data->Detailsiswatokelas->kelas }}
                                        </td>
                                        <td class='text-center'>
                                            {{-- blade-formatter-disable --}}
                                            @php
                                                $total_pemasukkan = $find_BendaharaTabungan = App\Models\Bendahara\BendaharaTabungan::select('nominal', )
                                                    ->where('detailsiswa_id', $data->id)
                                                    ->where('type', 'pemasukkan')
                                                    ->sum('nominal');
                                                $total_pengeluaran = App\Models\Bendahara\BendaharaTabungan::select('nominal')
                                                    ->where('detailsiswa_id', $data->id)
                                                    ->where('type', 'pengeluaran')
                                                    ->sum('nominal');
                                            @endphp
                                            {{-- blade-formatter-enable --}}
                                            Rp. {{ number_format($total_pemasukkan, 2) }}
                                        </td>
                                        <td class='text-center'>
                                            Rp. {{ number_format($total_pengeluaran, 2) }}
                                        </td>
                                        <td class='text-center'>
                                            Rp. {{ number_format($total_pemasukkan - $total_pengeluaran, 2) }}
                                        </td>
                                        <td width=''>
                                            {{-- blade-formatter-disable --}}
                                            <div class='gap-1 d-flex justify-content-center'>
                                                <!-- Button untuk melihat -->
                                                <button type='button' class='btn btn-info btn-sm mr-2'  data-toggle='modal' data-target='#viewModal{{ $data->id }}'> <i class='fa fa-eye'></i></button>
                                                {{-- <button type='button' class='btn btn-success btn-sm mr-2'  data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-print'></i></button> --}}
                                            </div>
                                            {{-- blade-formatter-enable --}}
                                            <div class='modal fade' id='viewModal{{ $data->id }}' tabindex='-1'  aria-labelledby='ViewModalLabel' aria-hidden='true'>
                                                @php
                                                    $data_tabungans = App\Models\Bendahara\BendaharaTabungan::where('detailsiswa_id', $data->id)->get();
                                                @endphp
                                                <x-view-modal>
                                                    <x-slot:titleviewModal>{{ $titleviewModal }} -
                                                        {{ $data->nama_siswa }}</x-slot:titleviewModal>
                                                    <section>
                                                                    {{-- blade-formatter-disable --}}
                                                        <div class="card shadow p-3 mb-5 bg-white rounded my-4">
                                                            <div class="col">
                                                                <div class="row gap-2">
                                                                    <div
                                                                        class="col-xl-3 d-flex justify-content-center align-items-center">
                                                                        <img class="img-fluid" src='{{ app('request')->root() }}/img/siswa/user-siswa.png' alt='' style='width:150px;height:225px;'>
                                                                    </div>
                                                                    <div class="col-xl-9">
                                                                        <i class="fa fa-user m-1"></i><x-inputallin>readonly:Nama Siswa:Placeholder:nama_siswa:id_nama_siswa:{{ $data->nama_siswa }}:readonly</x-inputallin>
                                                                        <i class="fa fa-address-card m-1"></i><x-inputallin>readonly:NIS Siswa:Placeholder:nama_siswa:id_nama_siswa:{{ $data->nis }}:readonly</x-inputallin>
                                                                        <i class="fa fa-house-user m-1"></i><x-inputallin>readonly:Kelas Siswa:Placeholder:nama_siswa:id_nama_siswa:{{ $data->detailsiswatokelas->kelas }}:readonly</x-inputallin>
                                                                        <div class="row gap-2 d-flex justify-content-between align-items-center">
                                                                            <div class="col-xl-6 d-flex align-items-center">
                                                                                <span class="bg-success mr-2 mt-2"><i class="fa fa-check-circle m-2"></i></span>
                                                                                <span>Pemasukkan</span>
                                                                            </div>
                                                                            <div class="col-xl-6 d-flex align-items-center">
                                                                                <span class="bg-danger mr-2 mt-2"><i class="fa fa-times-circle m-2"></i></span>
                                                                                <span>Pengeluaran</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    {{-- blade-formatter-enable --}}

                                                                </div>
                                                                <div class="col-xl-12 mt-3">
                                                                    <table id='example-intd-{{ $loop->index }}'
                                                                        width='100%'
                                                                        class='table table-bordered table-hover'>
                                                                        <thead>
                                                                            <tr
                                                                                class='text-center table-info align-middle'>
                                                                                <th width='1%'>ID</th>
                                                                                <th>Type</th>
                                                                                <th>Tanggal</th>
                                                                                <th>Nominal</th>
                                                                            </tr>
                                                                        </thead>
                                                                        {{-- blade-formatter-disable --}}
                                                                        <tbody>
                                                                            @if ($data_tabungans->isEmpty())
                                                                                <tr>
                                                                                    <td colspan="4" class="text-center"> Data tidak ditemukan.</td>
                                                                                </tr>
                                                                            @else
                                                                                @foreach ($data_tabungans as $datatabungan)
                                                                                    <tr>
                                                                                        <td class='text-center'>{{ $loop->iteration }} </td>
                                                                                        <td width='20%'
                                                                                            class='text-center'>
                                                                                            @if ($datatabungan->type !== 'pemasukkan')
                                                                                                <span class="p-2 bg-danger"><i class="fa fa-times-circle m-2"></i></span>
                                                                                            @else
                                                                                                <span class="p-2 bg-success"><i class="fa fa-check-circle m-2"></i></span>
                                                                                            @endif
                                                                                        </td>

                                                                                        <td width='50%'class='text-center'> {{ Carbon::create($datatabungan->created_at)->translatedformat('l, d F Y') }}</td>
                                                                                        <td class='text-center'> Rp. {{ number_format($datatabungan->nominal, 2) }} </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            @endif

                                                                        </tbody>
                                                                        <tfoot>
                                                                            <tr>
                                                                            <tr class='text-center table-info align-middle'>
                                                                                <th>ID</th>
                                                                                <th>Type</th>
                                                                                <th>Tanggal</th>
                                                                                <th>Nominal</th>
                                                                            </tr>
                                                                        </tfoot>
                                                                        {{-- blade-formatter-enable --}}
                                                                    </table>
                                                                </div>


                                                                <script>
                                                                    $(document).ready(function() {
                                                                        var tableId = '#example-intd-{{ $loop->index }}';
                                                                        if ($.fn.DataTable.isDataTable(tableId)) {
                                                                            $(tableId).DataTable().destroy();
                                                                        }

                                                                        $(tableId).DataTable({
                                                                            "paging": true, // Mengaktifkan paginasi
                                                                            "lengthChange": true, // Mengizinkan perubahan jumlah baris per halaman
                                                                            "pageLength": 10, // Menampilkan 25 item per halaman
                                                                            "lengthMenu": [5, 10, 25, 50, 100], // Pilihan jumlah baris yang ditampilkan
                                                                            "searching": true, // Mengaktifkan fitur pencarian
                                                                            "ordering": true, // Mengaktifkan pengurutan
                                                                            "info": true, // Menampilkan informasi halaman
                                                                        });
                                                                    });
                                                                </script>
                                                            </div>

                                                    </section>
                                                </x-view-modal>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class='text-center table-success'>
                                    <th width='1%'>ID</th>

                                    @foreach ($arr_ths as $arr_th)
                                        <th class='text-center'> {{ $arr_th }}</th>
                                    @endforeach

                                    {{-- @if ($activecrud === 1) --}}
                                    <th>Pemasukkan</th>
                                    <th>Pengeluaran</th>
                                    <th class='align-middle'>Sisa</th>
                                    <th class='align-middle'>Action</th>
                                    {{-- @endif --}}
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </section>
</x-layout>
