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


            {{-- blade-formatter-disable --}}
               <div class='row m-2'>
                   <div class='col-xl-2'>
                       <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'> <i class='fa fa-plus'></i> Tambah Data</button>
                   </div>
                   <div class='col-xl-10'></div>
               </div>
               {{-- blade-formatter-enable --}}


            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        {{-- Catatan :
                          - Include Komponen Modal CRUD + Javascript / Jquery
                          - Perbaiki Onclick Tombol Modal Create, Edit
                          - Variabel Active Crud menggunakan ID User
                           --}}
                        <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                            <thead>
                                <tr class='table-primary text-center align-middle'>
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
                                        <td class='text-center'> {{ $data->DataKIBC->kode_ruangan }}</td>
                                        <td class='text-center'> {{ $data->DataKIBC->nama_ruangan }}</td>
                                        <td class='text-center'> {{ $data->DataKIBB->nama_barang }}</td>
                                        <td class='text-center'> {{ $data->jumlah }}</td>
                                        <td class='text-center'> {{ $data->kondisi }}</td>

                                        <td width='10%'>
                                            <div class='gap-1 d-flex justify-content-center'>
                                                <!-- Button untuk mengedit -->
                                                <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                                    data-toggle='modal' data-target='#editModal{{ $data->id }}'><i
                                                        class='fa fa-edit'></i> </button>
                                                <!-- Form untuk menghapus -->
                                                <form id='delete-form-{{ $data->id }}'
                                                    action='{{ route('inventaris-in-ruangan.destroy', $data->id) }}'
                                                    method='POST' style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type='button' class='btn btn-danger btn-sm btn-equal-width'
                                                    onclick='confirmDelete({{ $data->id }})'> <i
                                                        class='fa fa-trash'></i> </button>
                                            </div>
                                            {{-- Modal View Data Akhir --}}

                                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                                aria-labelledby='EditModalLabel' aria-hidden='true'>

                                                <x-edit-modal>
                                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                    <section>
                                                        <form id='updateurl'
                                                            action='{{ route('inventaris-in-ruangan.update', $data->id) }}'
                                                            method='POST'>
                                                            @csrf
                                                            @method('PATCH')
                                                            {{-- blade-formatter-disable --}}
                                                                <div class='form-group'>
                                                                    <label for='kibc_id'>Nama Ruangan</label>
                                                                    <select name='kibc_id' id='ruang-{{ $data->id }}' class='form-control' required>
                                                                        <option value=''>--- Pilih Nama Ruangan ---</option>
                                                                        @foreach ($dataRuangans as $dataRuangan)
                                                                            <option value='{{ $dataRuangan->id }}'>{{ $dataRuangan->nama_ruangan }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <script>
                                                                   $(document).ready(function() {
                                                                       // $('#semesteredit option[value='II']').prop('selected', true); // Single Select
                                                                       $('#ruang-{{ $data->id }}').val(@json($data->kibc_id)).trigger('change'); // Mutiple Select Select value in array json
                                                                   });
                                                                </script>

                                                                <div class='form-group'>
                                                                    <label for='inventaris_id'>Nama Barang</label>
                                                                    <select name='kibb_id' id='dataBrang-{{ $data->id }}' class='form-control' required>
                                                                        <option value=''>--- Pilih Nama Barang ---</option>
                                                                        @foreach ($DataBarangs as $DataBarang)
                                                                            <option value='{{ $DataBarang->id }}'>{{ $DataBarang->kode_barang }} - {{ $DataBarang->nama_barang }} - {{ $DataBarang->id }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <script>
                                                                   $(document).ready(function() {
                                                                       // $('#semesteredit option[value='II']').prop('selected', true); // Single Select
                                                                       $('#dataBrang-{{ $data->id }}').val(@json($data->kibb_id)).trigger('change'); // Mutiple Select Select value in array json
                                                                   });
                                                                </script>

                                                                <div class='card-header bg-primary'>
                                                                    <h3 class='card-title'>Kondisi</h3>
                                                                </div>
                                                                <div class="row">
                                                                    <div class='col-xl-6 form-group'>
                                                                        <label for='baik'>Baik</label>
                                                                        <input type='text' class='form-control' id='baik' name='baik' placeholder='Kondisi Baik' value='{{ $data->baik }}' required>
                                                                    </div>
                                                                    <div class='col-xl-6 form-group'>
                                                                        <label for='rusak'>Rusak</label>
                                                                        <input type='text' class='form-control' id='rusak' name='rusak' placeholder='Rusak' value='{{ $data->rusak }}'  required>
                                                                    </div>
                                                                </div>

                                                                <div class='modal-footer'>
                                                                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                                                    <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                                                                </div>
                                                                {{-- blade-formatter-enable --}}
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
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class='text-center align-middle'>
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
{{-- <button class='btn btn-warning btn-sm' onclick='TambahData()'><i class='fa fa-edit right'></i> Edit</button> --}}
{{--
onclick='TambahData()'
 --}}

<script>
    function TambahData(data) {
        var TambahData = new bootstrap.Modal(document.getElementById('TambahData'));
        TambahData.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='TambahData' tabindex='-1' aria-labelledby='LabelTambahData' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelTambahData'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <form id='#id' action='{{ route('inventaris-in-ruangan.store') }}' method='POST'>
                    @csrf
                    @method('POST')
                    {{-- blade-formatter-disable --}}
                    <div class='form-group'>
                        <label for='kibc_id'>Nama Ruangan</label>
                        <select name='kibc_id' id='id' class='form-control' required>
                            <option value=''>--- Pilih Nama Ruangan ---</option>
                            @foreach ($dataRuangans as $dataRuangan)
                                <option value='{{ $dataRuangan->id }}'>{{ $dataRuangan->kode_ruangan }} - {{ $dataRuangan->nama_ruangan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='form-group'>
                        <label for='inventaris_id'>Nama Barang</label>
                        <select name='kibb_id' id='id' class='form-control' required>
                            <option value=''>--- Pilih Nama Barang ---</option>
                            @foreach ($DataBarangs as $DataBarang)
                                <option value='{{ $DataBarang->id }}'>{{ $DataBarang->kode_barang }} - {{ $DataBarang->nama_barang }} - {{ $DataBarang->id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>Kondisi</h3>
                    </div>
                    <div class="row">
                        <div class='col-xl-6 form-group'>
                            <label for='baik'>Baik</label>
                            <input type='text' class='form-control' id='baik' name='baik' placeholder='Kondisi Baik' required>
                        </div>
                        <div class='col-xl-6 form-group'>
                            <label for='rusak'>Rusak</label>
                            <input type='text' class='form-control' id='rusak' name='rusak' placeholder='Rusak' required>
                        </div>
                    </div>
                    {{-- blade-formatter-enable --}}

                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>
<script>
    $(document).ready(function() {
        initDataTable('#example1', 'Data Inventaris Di Ruangan', '#example1_wrapper .col-md-6:eq(0)');
        initDataTable('#example2', 'Data Peserta Ekstra 2', '#example2_wrapper .col-md-6:eq(0)');
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
                    orientation: 'landscape', // Ubah ke 'portrait' jika ingin mode potrait
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
