
    @php
    // use Illuminate\Support\Carbon;
     use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
        $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
        $urlroot = app('request')->root();
    @endphp<x-layout>
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
        <div class='card'>
            {{-- Papan Informasi --}}
            <div class='card-body'>
                <div class='row float-right'>
                    <x-btnjs>submit/Tambah Data/fa fa-plus/btn btn-primary btn-xl bg-primary
                        btn-app/namaModal()</x-btnjs>
                </div>
            </div>
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->


            <div class='ml-2 my-4'>
                {{-- bendahara.RiwayatStudyTour.index --}}
                <div class="row ">
                    <div class="col-xl-12">
                        <div class="row p-2">
                            <div class="col-xl-3">
                                {{-- Info --}}
                                {{-- blade-formatter-disable --}}
                                <div class='small-box bg-warning'>
                                    <h3 class='m-2'>Pemasukkan</h3>
                                    <div class='inner'>
                                        <div class=" d-flex justify-content-between">
                                            <span><i class="fa fa-money-bill-alt mr-1"></i> Total Terbayar </span><span>Rp. {{number_format($total_terbayar, 2)}}</span>
                                        </div>
                                        <div class=" d-flex justify-content-between">
                                            <span><i class="fa fa-user mr-1"></i> Total Siswa </span><span>{{$total_siswa}}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span><i class="fa fa-money-bill-alt mr-1"></i> Pembayaran </span>
                                            <span>Rp. {{ number_format(($riwayat_study_tour->nominal ?? 0) * ($total_siswa ?? 0), 2) }}</span>

                                        </div>
                                    </div>
                                    <div class='icon'>
                                        <i class='fa fa-dollar-sign'></i>
                                    </div>
                                    <a href='#' class='small-box-footer'>More info <i class='fas fa-arrow-circle-right'></i></a>
                                </div>
                                {{-- blade-formatter-enable --}}
                            </div>
                            <div class="col-xl-6">
                                <div class="col-xl-12 p-2">
                                    <div class='alert alert-info alert-dismissible'>
                                        <h3><i class='icon fas fa-info'></i> <b>Information</b> !</h3>
                                        <hr class='bg-light' style='height: 3px;'>

                                        {{-- blade-formatter-disable --}}
                                @php
                                $data_study_tour = App\Models\Bendahara\RiwayatStudytour::where('tapel_id', 8)->first();
                                @endphp
                                {{-- blade-formatter-enable --}}
                                        <div class="row">
                                            <div class="col-xl-3">
                                                Nominal Pembayaran <br>
                                                Tujuan <br>
                                                Objek Wisana <br>
                                                Biro <br>
                                            </div>
                                        <div class="col-xl-9">
                                            : Rp. {{ optional($data_study_tour)->nominal !== null ? number_format(optional($data_study_tour)->nominal, 2) : 'Data Tidak Ada' }} <br>
                                            : {{ optional($data_study_tour)->tujuan_wisata ?? 'Data Tidak Ada' }} <br>
                                            : {{ optional($data_study_tour)->objek_wisata ?? 'Data Tidak Ada' }} <br>
                                            : {{ optional($data_study_tour)->nama_biro ?? 'Data Tidak Ada' }} <br>
                                        </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                {{-- Info --}}
                                {{-- blade-formatter-disable --}}
                                <div class='small-box bg-success'>
                                    <h3 class='m-2'>Pemasukkan</h3>
                                    <div class='inner'>
                                        <div class=" d-flex justify-content-between">
                                            <span><i class="fa fa-money-bill-alt mr-1"></i> Total Terbayar </span><span>Rp. {{number_format($total_terbayar, 2)}}</span>
                                        </div>
                                        <div class=" d-flex justify-content-between">
                                            <span><i class="fa fa-user mr-1"></i> Total Siswa </span><span>{{$total_siswa}}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span><i class="fa fa-money-bill-alt mr-1"></i> Pembayaran </span><span>Rp. {{number_format(optional($riwayat_study_tour)->nominal * $total_siswa, 2)}}</span>
                                        </div>
                                    </div>
                                    <div class='icon'>
                                        <i class='fa fa-dollar-sign'></i>
                                    </div>
                                    <a href='#' class='small-box-footer'>More info <i class='fas fa-arrow-circle-right'></i></a>
                                </div>
                                {{-- blade-formatter-enable --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class='card-header bg-primary'>
                            <h3 class='card-title'>Data Riwayat Pembayaran Study Tour</h3>
                        </div>
                        <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                            <thead>
                                <tr class='text-center'>
                                    <th width='1%'>ID</th>
                                    @foreach ($arr_ths as $arr_th)
                                        <th class='text-center'> {{ $arr_th }}</th>
                                    @endforeach
                                    <th>Action</th>

                                    {{-- @if ($activecrud === 1)
                                              {{-- @endif --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        <td class='text-center'>{{ $loop->iteration }}</td>
                                        <td class='text-center'> {{ $data->nis }}</td>
                                        <td class='text-center'> {{ $data->DetailsiswatoKelas->kelas }}</td>
                                        <td class='text-center'>
                                            {{ $data->nama_siswa }}</td>
                                        {{-- blade-formatter-disable --}}
                                        @php
                                            $total_terbayar = App\Models\Bendahara\BendaharaStudytour::select('nominal',)
                                                ->where('detailsiswa_id', $data->id)
                                                ->sum('nominal');
                                            // dd($total_terbayara);
                                        @endphp
                                        {{-- blade-formatter-enable --}}
                                        <td class='text-center'>Rp. {{ number_format($total_terbayar, 2) }} / Rp.
                                            {{ number_format(optional($riwayat_study_tour)->nominal, 2) }}</td>

                                        {{-- blade-formatter-disable --}}
                                        @if (optional($riwayat_study_tour)->nominal - $total_terbayar !== 0)
                                            <td class='text-center'>
                                                Rp. {{ number_format(($riwayat_study_tour->nominal ?? 0) - ($total_terbayar ?? 0), 2) }}
                                            </td>

                                        @else
                                            <td class='text-center'><span class='bg-success p-2'><i class="fa fa-check-circle"></i> Lunas</span></td>
                                        @endif
                                        {{-- blade-formatter-enable --}}

                                        <td width='20%'>
                                            {{-- blade-formatter-disable --}}
                                            <div class='gap-1 d-flex justify-content-center'>
                                                <!-- Button untuk melihat -->
                                                <button type='button' class='btn btn-success btn-sm btn-equal-width' data-toggle='modal' data-target='#viewModal{{ $data->id }}'> <i class='fa fa-eye'></i> Lihat </button>
                                                <!-- Button untuk mengedit -->
                                                <button type='button' class='btn btn-warning btn-sm btn mr-2' data-toggle='modal' data-target='#editModal{{ $data->id }}'> <i class='fa fa-plus'></i> Tambah</button>
                                                <!-- Form untuk menghapus -->

                                            </div>
                                           {{-- blade-formatter-enable --}}
                                            <div class='modal fade' id='viewModal{{ $data->id }}' tabindex='-1'
                                                aria-labelledby='ViewModalLabel' aria-hidden='true'>

                                                <x-view-modal>
                                                    <x-slot:titleviewModal>{{ $titleviewModal }}</x-slot:titleviewModal>
                                                    <section>
                                                {{-- blade-formatter-disable --}}
                                                @php
                                                    $data_pembayarans = App\Models\Bendahara\BendaharaStudytour::where('detailsiswa_id', $data->id)->get();
                                                    // dd($data_pembayarans);
                                                @endphp
                                                <div class="row mb-4">
                                                    <div class="col-xl-1"></div>
                                                    <div class="col-xl-2 p-2 d-flex justify-content-center">
                                                        <img src='{{ app('request')->root() }}/img/siswa/user-siswa.png' alt='#' style='width:200px;heght:auto'>
                                                    </div>
                                                    <div class="col-xl-1"></div>
                                                    <div class="col-xl-8 p-2">
                                                        <div class='card-header bg-primary'>
                                                            <h3 class='card-title'>Data Siswa</h3>
                                                        </div>
                                                        <x-inputallin>readonly:Nama Siswa:Nama Siswa:nama_siswa:id_nama_siswa:{{ $data->nama_siswa }}:readonly</x-inputallin>
                                                        <x-inputallin>readonly:NIS:NIS:nis:id_nis:{{ $data->nis }}:readonly</x-inputallin>
                                                        <x-inputallin>readonly:Kelas:Kelas:kelas_id:id_kelas_id:{{ $data->Detailsiswatokelas->kelas }}:readonly</x-inputallin>
                                                    </div>
                                                    <div class="col-xl-2"></div>
                                                </div>
                                                {{-- blade-formatter-enable --}}
                                                        <table id='example-intd-{{ $loop->index }}' width='100%'
                                                            class='table table-bordered table-hover'>
                                                            <thead>
                                                                <tr class='text-center align-middle'>
                                                                    <th>ID</th>
                                                                    <th>No Pembayaran</th>
                                                                    <th>Tanggal Pembayaran</th>
                                                                    <th>Nominal</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($data_pembayarans as $data_pembayaran)
                                                                    <tr>
                                                                        <td class='text-center'>{{ $loop->iteration }}
                                                                        </td>

                                                                        <td class='text-center'> {{ $data_pembayaran->nomor_pembayaran }} </td>
                                                                        <td class='text-center'> {{Carbon::create($data_pembayaran->created_at)->translatedformat('l, d F Y')}} </td>
                                                                        <td class='text-center'>Rp. {{ number_format($data_pembayaran->nominal, 2)
                                                                         }} </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th>ID</th>
                                                                    <th>No Pembayaran</th>
                                                                    <th>Tanggal Pembayaran</th>
                                                                    <th>Nominal</th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                        @foreach ($data_pembayarans as $data_pembayaran)
                                                        @endforeach

                                                    </section>
                                                </x-view-modal>
                                            </div>
                                        </td>
                                    </tr>
                                    <script>
                                        $(document).ready(function() {
                                            var tableId = '#example-intd-{{ $loop->index }}';
                                            if ($.fn.DataTable.isDataTable(tableId)) {
                                                $(tableId).DataTable().destroy();
                                            }

                                            $(tableId).DataTable({
                                                'paging': true, // Mengaktifkan paginasi
                                                'lengthChange': true, // Mengizinkan perubahan jumlah baris per halaman
                                                'pageLength': 10, // Menampilkan 25 item per halaman
                                                'lengthMenu': [5, 10, 25, 50, 100], // Pilihan jumlah baris yang ditampilkan
                                                'searching': true, // Mengaktifkan fitur pencarian
                                                'ordering': true, // Mengaktifkan pengurutan
                                                'info': true, // Menampilkan informasi halaman
                                            });
                                        });
                                    </script>
                                    {{-- Modal Edit Data Akhir --}}
                                    {{-- Modal View --}}

                                    {{-- Modal View Akhir --}}
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class='text-center'>
                                    <th width='1%'>ID</th>

                                    @foreach ($arr_ths as $arr_th)
                                        <th class='text-center'> {{ $arr_th }}</th>
                                    @endforeach

                                    {{-- @if ($activecrud === 1) --}}
                                    <th class='text-center'>Action</th>
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

<button class='btn btn-warning btn-sm' onclick='FNnamaModal()'><i class='fa fa-edit right'></i> Edit</button>

<script>
    function namaModal(data) {
        var namaModal = new bootstrap.Modal(document.getElementById('namaModal'));
        namaModal.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='namaModal' tabindex='-1' aria-labelledby='LabelnamaModal' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelnamaModal'>
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
