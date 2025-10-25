@php
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
    $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
    $urlroot = app('request')->root();
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
        <div class='card'>
            {{-- Papan Informasi --}}
            <div class='container-fluid'>
                <div class='row'>
                    <div class='col'>
                        <!-- Papan Informasi  -->
                        <div class='row mx-2'>
                            <div class='col-lg-3 col-6'>
                                <!-- small box / Data BOX-->
                                <div class='small-box bg-info'><!-- Background -->
                                    <h3 class='m-2'>Data Siswa</h3><!-- Judul -->
                                    <div class='inner'><!-- Isi Kontent -->
                                        <div class='d-flex justify-content-between'>
                                            VII</span><span>{{ $jumlahSiswa->where('tingkat_id', 7)->count() }}</span>
                                        </div>
                                        <div class='d-flex justify-content-between'>
                                            VIII</span><span>{{ $jumlahSiswa->where('tingkat_id', 8)->count() }}</span>
                                        </div>
                                        <div class='d-flex justify-content-between'>
                                            IX</span><span>{{ $jumlahSiswa->where('tingkat_id', 9)->count() }}</span>
                                        </div>
                                    </div>
                                    <div class='icon'>
                                        <i class='fa fa-wallet'></i><!-- Icon -->
                                    </div>
                                    <a href='#' class='small-box-footer'>More info <i
                                            class='fas fa-arrow-circle-right'></i></a>
                                </div>
                                <!-- small box -->
                            </div>
                            <!-- ./col -->
                        </div>
                        <!-- Papan Informasi  -->
                        {{-- <x-footer></x-footer> --}}


                    </div>
                </div>
            </div>
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->


            <div class='ml-2 my-4'>

                <div class='row'>
                    {{-- blade-formatter-disable --}}
                    <div class="col-xl-2">
                        <button type='button' class='btn  btn-default bg-primary btn-md' onClick='TambahPeserta()'><i class='fa fa-plus-circle  text-white'></i> Tambah Peserta</button>
                        <button type='button' class='btn  btn-default bg-primary btn-md' onclick='DataSiswaNotEkstra()'><i class='fa fa-plus-circle  text-white'></i> Data Tidak Ekstra</button>
                    </div>
                    {{-- blade-formatter-enable --}}
                    <div class="col-xl-10"></div>

                </div>

                <div class='card-header bg-primary'><h3 class='card-title'>Data Ekstra</h3></div>
                <table id='example3' width='100%' class='table table-responsive table-bordered table-hover'>
                    <thead>
                        <tr class='table-primary text-center'>
                            <th width='1%'>ID</th>
                            @foreach ($arr_thsX as $arr_th)
                                <th class='text-center'> {{ $arr_th }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datasEkstra as $data)
                            <tr>
                                <td class='text-center'>{{ $loop->iteration }}</td>
                                <td class='text-center'> {{ $data->Ekstra->ekstra }}</td>
                                <td class='text-center'> {{ $data->Detailguru->nama_guru }}</td>
                                <td class='text-center'> {{ $data->pelatih }}</td>
                                <td class='text-center'> {{ $data->jadwal }}</td>
                                <td class='text-center'>
                                    @php
                                        $JumlahAnggota = App\Models\WakaKesiswaan\Ekstra\PesertaEkstra::where(
                                            'ekstra_id',
                                            $data->id,
                                        )->get();
                                    @endphp


                                    <a href="{{app('request')->root()}}/waka-kesiswaan/peserta-ekstrakurikuler/{{$data->id}}"><span class="p-2 bg-success">{{ $JumlahAnggota->count() }}</span></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class='text-center'>
                            <th width='1%'>ID</th>
                            @foreach ($arr_thsX as $arr_th)
                                <th class='text-center'> {{ $arr_th }}</th>
                            @endforeach
                    </tfoot>
                </table>
                <div class='card-header bg-success'><h3 class='card-title'>Data Semua Peserta Ekstra</h3></div>

                <table id='example1' width='100%' class='table table-bordered table-hover'>
                    <thead>
                        <tr class='table-success text-center'>
                            <th width='1%'>ID</th>
                            @foreach ($arr_ths as $arr_th)
                                <th class='text-center'> {{ $arr_th }}</th>
                            @endforeach
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr>
                                <td class='text-center'>{{ $loop->iteration }}</td>
                                <td class='text-center'> {{ $data->Siswa->nis }}</td>
                                <td class='text-center'> {{ $data->Siswa->nama_siswa }}</td>
                                <td class='text-center'> {{ $data->Kelas->kelas }}</td>
                                <td class='text-center'> {{ $data->EkstraOne->ekstra }}</td>

                                <td width='20%'>
                                    <div class='gap-1 d-flex justify-content-center'>
                                        {{-- blade-formatter-disable --}}
                                                       <!-- Button untuk melihat -->
                                                       <!-- <button type='button' class='btn btn-success btn-sm btn-equal-width' data-toggle='modal' data-target='#viewModal{{ $data->id }}'><i class='fa fa-eye'></i> Lihat</button> -->
                                                       <!-- Button untuk mengedit -->
                                                       <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i> Edit</button>
                                                       <!-- Form untuk menghapus -->
                                                       <form action='{{ route('peserta-ekstra.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                           @csrf
                                                           @method('DELETE')
                                                           <button type='submit' class='btn btn-danger btn-sm btn-equal-width' onclick=`return confirm('Apakah Anda yakin ingin menghapus data ini?');`><i class='fa fa-trash'></i> Hapus</button>
                                                       </form>
                                                       {{-- blade-formatter-enable --}}
                                    </div>
                                </td>
                            </tr>
                            {{-- Modal View Data Akhir --}}
                            {{-- blade-formatter-disable --}}
                                        <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1' aria-labelledby='EditModalLabel' aria-hidden='true'>
                                        {{-- blade-formatter-enable --}}
                            <x-edit-modal>
                                <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                <section>
                                    <form id='updateurl' action='{{ route('peserta-ekstra.update', $data->id) }}'
                                        method='POST'>
                                        @csrf
                                        @method('PATCH')

                                        contentEdit

                                        <button id='kirim' type='submit'
                                            class='btn float-right btn-default bg-primary btn-xl mt-4'> Kirim</button>
                                    </form>

                                </section>
                            </x-edit-modal>
            </div>
            {{-- Modal Edit Data Akhir --}}
            {{-- Modal View --}}
            {{-- blade-formatter-disable --}}
                                        <div class='modal fade' id='viewModal{{ $data->id }}' tabindex='-1' aria-labelledby='ViewModalLabel' aria-hidden='true'>
                                        {{-- blade-formatter-enable --}}

            <x-view-modal>
                <x-slot:titleviewModal>{{ $titleviewModal }}</x-slot:titleviewModal>
                <section>
                    //Content View
                </section>
            </x-view-modal>
        </div>
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

    </section>
</x-layout>
<button class='btn btn-warning btn-sm' onclick='TambahPeserta()'><i class='fa fa-edit right'></i> Edit</button>

<script>
    function TambahPeserta(data) {
        var TambahPeserta = new bootstrap.Modal(document.getElementById('TambahPeserta'));
        TambahPeserta.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='TambahPeserta' tabindex='-1' aria-labelledby='TambahPeserta' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='TambahPeserta'>
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

<script>
    function DataSiswaNotEkstra(data) {
        var DataSiswaNotEkstra = new bootstrap.Modal(document.getElementById('DataSiswaNotEkstra'));
        DataSiswaNotEkstra.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='DataSiswaNotEkstra' tabindex='-1' aria-labelledby='LabelDataSiswaNotEkstra'
    aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelDataSiswaNotEkstra'>
                    Data Siswa Tidak Mengikuti Ekstra
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <table id='example2' width='100%' class='table table-bordered table-hover'>
                    <thead>
                        <tr class='text-center align-middle'>
                            <th>ID</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswaTidakEkstra as $data)
                            <tr class='text-center'>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->nis }}</td>
                                <td>{{ $data->nama_siswa }}</td>
                                <td>{{ $data->KelasOne->kelas }}</td>
                                {{-- <td>{{ $CekEkstra }}</td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class='text-center align-middle'>
                            <th>ID</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                        </tr>
                    </tfoot>
                </table>

                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                    <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                </div>
            </div>

        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        initDataTable('#example1', 'Data Peserta Ekstra', '#example1_wrapper .col-md-6:eq(0)');
        initDataTable('#example2', 'Data Peserta Tidak Mengikuti Ekstra', '#example2_wrapper .col-md-6:eq(0)');
    });

    // Fungsi untuk inisialisasi DataTable
    function initDataTable(tableId, exportTitle, buttonContainer) {
        // Hancurkan DataTable jika sudah ada
        $(tableId).DataTable().destroy();

        // Inisialisasi DataTable
        var table = $(tableId).DataTable({
            responsive: true,
            lengthChange: true,
            autoWidth: false,
            //lengthChange: true,
            //autoWidth: false,
            //paging: true,
            //pageLength: 25,
            //ordering: true,
            //order: [[1, 'desc']],
            //searching: true,
            //fixedHeader: true,
            //scrollX: true,
            buttons: [{
                    extend: 'copy',
                    title: exportTitle,
                    exportOptions: {
                        columns: ':visible:not(.noprint)'
                    }
                },
                {
                    extend: 'excel',
                    title: exportTitle,
                    exportOptions: {
                        columns: ':visible:not(.noprint)'
                    }
                },
                {
                    extend: 'pdf',
                    title: exportTitle,
                    exportOptions: {
                        columns: ':visible:not(.noprint)'
                    }
                },
                {
                    extend: 'colvis',
                    titleAttr: 'Pilih Kolom'
                }
            ],
            rowGroup: {
                dataSrc: 0
            } // Mengelompokkan berdasarkan kolom pertama (index 0)
        });

        // Menambahkan tombol-tombol di atas tabel
        table.buttons().container().appendTo(buttonContainer);
    }
</script>
