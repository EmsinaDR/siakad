@php
    //content
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


            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->


            <div class='row m-2'>
                {{-- blade-formatter-disable --}}
                   <div class='col-xl-2'>
                       {{-- <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'> <i class='fa fa-print'></i> Cetak Data</button> --}}
                       <a href="{{route('tugas.guru,sekarang')}}"><button type='button' class='btn btn-block btn-default bg-primary btn-md' > <i class='fa fa-eye'></i> Data Tugas Hari ini</button></a>
                   </div>
                   {{-- blade-formatter-enable --}}
                <div class='col-xl-10'>
                    <div class='container-fluid'>
                        <div class='row'>
                            <div class='col'>
                                <!-- Papan Informasi  -->
                                <div class='row mx-2'>
                                    <div class='col-lg-4 col-6'>
                                        <!-- small box / Data BOX-->
                                        <div class='small-box bg-info'><!-- Background -->
                                            <h3 class='m-2'>Data Tugas Hari Ini</h3><!-- Judul -->
                                            <div class='inner'><!-- Isi Kontent -->
                                                <div class='d-flex justify-content-between'>
                                                    <span>Tugas Tersedia</span><span>{{ $jumlahTugas->count() }}</span>
                                                </div>
                                                <div class='d-flex justify-content-between'>
                                                    <span>Guru Pemberi
                                                        Tugas</span><span>{{ $jumlahTugas->distinct('detailguru_id')->count() }}</span>
                                                </div>
                                                <div class='d-flex justify-content-between'>
                                                    <span>Kelas
                                                        Tugas</span><span>{{ $jumlahTugas->distinct('kelas_id')->count() }}</span>
                                                </div>
                                            </div>
                                            <div class='icon'>
                                                <i class='fa fa-task'></i><!-- Icon -->
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
                </div>
            </div>


            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>Data Tugas Guru</h3>
                    </div>
                    <div class='card-body'>
                        {{-- Catatan :
                          - Include Komponen Modal CRUD + Javascript / Jquery
                          - Perbaiki Onclick Tombol Modal Create, Edit
                          - Variabel Active Crud menggunakan ID User
                           --}}
                        <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                            <thead>
                                <tr class='table-success text-center'>
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
                                        <td class='text-center'>
                                            {{ Carbon::create($data->created_at)->translatedformat('l, d F Y') }}</td>
                                        <td class='text-center'> {{ $data->Kelas->kelas }}</td>
                                        <td class='text-center'> {{ $data->Guru->nama_guru }}</td>
                                        <td class='text-center'> {{ $data->Mapel->mapel }}</td>
                                        <td class='text-center'> {{ $data->keterangan }}</td>
                                        <td width='10%'>
                                            <div class='gap-1 d-flex justify-content-center'>
                                                <!-- Button untuk mengedit -->
                                                <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                                    data-toggle='modal' data-target='#editModal{{ $data->id }}'><i
                                                        class='fa fa-edit'></i> </button>
                                                <!-- Form untuk menghapus -->
                                                <form id='delete-form-{{ $data->id }}'
                                                    action='{{ route('tugas-piket-guru.destroy', $data->id) }}'
                                                    method='POST' style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type='button' class='btn btn-danger btn-sm btn-equal-width'
                                                    onclick='confirmDelete({{ $data->id }})'> <i
                                                        class='fa fa-trash'></i> </button>
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- Modal View Data Akhir --}}

                                    <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                        aria-labelledby='EditModalLabel' aria-hidden='true'>

                                        <x-edit-modal>
                                            <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                            <section>
                                                <form id='updateurl'
                                                    action='{{ route('tugas-piket-guru.update', $data->id) }}'
                                                    method='POST'>
                                                    @csrf
                                                    @method('PATCH')

                                                    contentEdit

                                                    <button id='kirim' type='submit'
                                                        class='btn float-right btn-default bg-primary btn-xl mt-4'>
                                                        Kirim</button>
                                                </form>

                                            </section>
                                        </x-edit-modal>
                                    </div>
                                    {{-- Modal Edit Data Akhir --}}
                                    {{-- Modal View --}}

                                    <div class='modal fade' id='viewModal{{ $data->id }}' tabindex='-1'
                                        aria-labelledby='ViewModalLabel' aria-hidden='true'>


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
            </div>


        </div>

    </section>
</x-layout>
<script>
    $(document).ready(function() {
        initDataTable('#example1', 'Data Tugas Guru', '#example1_wrapper .col-md-6:eq(0)');
        initDataTable('#example2', 'x', '#example2_wrapper .col-md-6:eq(0)');
    });

    // Fungsi untuk inisialisasi DataTable
    function initDataTable(tableId, exportTitle, buttonContainer) {
        // Hancurkan DataTable jika sudah ada
        $(tableId).DataTable().destroy();

        // Inisialisasi DataTable
        var table = $(tableId).DataTable({
            lengthChange: true, //False jika ingin dilengkapi dropdown
            autoWidth: false,
            responsive: true, // Membuat tabel menjadi responsif agar bisa menyesuaikan dengan ukuran layar
            lengthChange: true, // Menampilkan dropdown untuk mengatur jumlah data per halaman
            autoWidth: false, // Mencegah DataTables mengatur lebar kolom secara otomatis agar tetap sesuai dengan CSS
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
                    orientation: 'portrait',
                    exportOptions: {
                        columns: ':visible:not(.noprint)'
                    }
                },
                {
                    extend: 'colvis',
                    titleAttr: 'Pilih Kolom'
                }
            ],
            columnDefs: [{
                targets: -1, // Kolom terakhir (Action) bisgunkan array contoh [-1, -2, -4]
                visible: false // Menyembunyikan kolom Action
            }],
            rowGroup: {
                dataSrc: 0
            } // Mengelompokkan berdasarkan kolom pertama (index 0)
        });

        // Menambahkan tombol-tombol di atas tabel
        table.buttons().container().appendTo(buttonContainer);
    }
</script>
