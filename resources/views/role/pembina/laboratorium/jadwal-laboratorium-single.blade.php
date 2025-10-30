@php
    //Jadwal Laboratorium
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
    <x-slot:title>{{ $title }} - {{ $DataLab->LaboratoriumOne->nama_laboratorium }}</x-slot:title>
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


            <div class='ml-2 my-4'>
                <div class="row">
                    <div class="col-xl-2">
                        <button type='button' class='btn btn-block btn-default bg-primary btn-md'
                            onclick='TambahData()'><i class="fa fa-plus"></i> Tambah Data</button>
                    </div>
                    <div class="col-xl-10"></div>
                </div>
                <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                    <thead>
                        <tr class='text-center'>
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
                                <td class='text-center'> {{ $data->Detailguru->nama_guru }}</td>
                                <td class='text-center'>
                                    {{ Carbon::create($data->tanggal_penggunaan)->translatedformat('l, d F Y') }}</td>
                                <td class='text-left'> {{ $data->tujuan }}</td>

                                <td width='10%'>
                                    {{-- blade-formatter-disable --}}
                                    <div class='gap-1 d-flex justify-content-center'>
                                        <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i> </button>
                                        <!-- Form untuk menghapus -->
                                        <form id='delete-form-{{ $data->id }}' action='{{ route('jadwal-laboratorium.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button type='button' class='btn btn-danger btn-sm btn-equal-width'
                                            onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i>
                                        </button>

                                    </div>
                                    {{-- blade-formatter-enable --}}
                                </td>
                            </tr>
                            {{-- Modal View Data Akhir --}}

                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                aria-labelledby='EditModalLabel' aria-hidden='true'>

                                <x-edit-modal>
                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                    <section>
                                            {{-- blade-formatter-disable --}}
                                            <form id='#id' action='{{ route('jadwal-laboratorium.update', $data->id) }}' method='POST'>
                                                @csrf
                                                @method('PATCH')
                                                <div class='modal-body'>
                                                    <div class='form-group'>
                                                        <label for='detailguru_id'>Nama Guru</label>
                                                        <select name='detailguru_id' id='detailguru-{{ $data->id }}' class='form-control' required>
                                                            <option value=''>--- Pilih Nama Guru ---</option>
                                                            @foreach ($DataGurus as $DataGuru)
                                                                <option value='{{ $DataGuru->id }}'>{{ $DataGuru->nama_guru }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <script>
                                                       $(document).ready(function() {
                                                           // $('#semesteredit option[value='II']').prop('selected', true); // Single Select
                                                           $('#detailguru-{{ $data->id }}').val(@json($data->detailguru_id)).trigger('change'); // Mutiple Select Select value in array json
                                                       });
                                                    </script>
                                                    <div class='form-group'>
                                                        <label for='tanggal_penggunaan'>Tanggal Penggunaan</label>
                                                        <input type='date' class='form-control' id='tanggal_penggunaan' name='tanggal_penggunaan' placeholder='Tangal' value='{{$data->tanggal_penggunaan}}' required>
                                                    </div>
                                                    <div class='form-group'>
                                                        <label for='tujuan_penggunaan'>Tujuan Penggunaan</label>
                                                        <input type='text' class='form-control' id='tujuan_penggunaan' name='tujuan' placeholder='Tujuan Penggunaan' value='{{$data->tujuan}}' required>
                                                    </div>

                                                    <div class='modal-footer'>
                                                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                                        <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                                                    </div>
                                                </div>
                                            </form>
                                            {{-- blade-formatter-enable --}}

                                    </section>
                                </x-edit-modal>
                            </div>
                            {{-- Modal Edit Data Akhir --}}
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
            {{-- blade-formatter-disable --}}
            <form id='#id' action='{{ route('jadwal-laboratorium.store') }}' method='POST'>
                @csrf
                @method('POST')
                <div class='modal-header bg-primary'>
                    <h5 class='modal-title' id='LabelTambahData'>
                        Tambah Data Baru
                    </h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <input type="text" value='{{request()->segment(3)}}' name='laboratorium_id'>
                <div class='modal-body'>
                    <div class='form-group'>
                        <label for='detailguru_id'>Nama Guru</label>
                        <select name='detailguru_id' id='id' class='form-control' required>
                            <option value=''>--- Pilih Nama Guru ---</option>
                            @foreach ($DataGurus as $DataGuru)
                                <option value='{{ $DataGuru->id }}'>{{ $DataGuru->nama_guru }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class='form-group'>
                        <label for='tanggal_penggunaan'>Tanggal Penggunaan</label>
                        <input type='date' class='form-control' id='tanggal_penggunaan' name='tanggal_penggunaan' placeholder='Tangal' required>
                    </div>
                    <div class='form-group'>
                        <label for='tujuan_penggunaan'>Tujuan Penggunaan</label>
                        <input type='text' class='form-control' id='tujuan_penggunaan' name='tujuan' placeholder='Tujuan Penggunaan' required>
                    </div>

                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                    </div>
                </div>
            </form>
            {{-- blade-formatter-enable --}}

        </div>
    </div>

</div>
<script>
    $(document).ready(function() {
        initDataTable('#example1', 'Jadwal Penggunaan Laboratorium', '#example1_wrapper .col-md-6:eq(0)');
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
                targets: [], // Kolom terakhir (Action) bisgunkan array contoh [-1, -2, -4]
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
