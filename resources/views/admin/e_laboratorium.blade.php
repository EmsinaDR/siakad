@php
    $activecrud = collect([1, 2, 6, 8])->search(Auth::user()->id);
@endphp
<style>
</style>

<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>
    <section class='content mx-2'>
        <div class='card'>
            {{-- Papan Informasi --}}
            {{-- blade-formatter-disable --}}
            {{-- blade-formatter-enable --}}
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->
            {{-- blade-formatter-disable --}}
            <div class="row p-2">
                <div class="col-xl-2">
                    <button class='btn btn-block btn-primary btn-sm' onclick='CreateModal()'><i class='fa fa-edit right'></i> Tambah Data</button>
                    <button class='btn btn-block btn-success btn-sm' onclick='TabelLaboratorium()'><i class='fa fa-computer right'></i> Cek Data Lab</button>
                </div>
                <div class="col-xl-10"></div>
            </div>
            {{-- blade-formatter-enable --}}
            <div class='card-body mr-2 ml-2'>
                <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                    <thead>
                        <tr class='text-center'>

                            <th width='1%'>ID</th>
                            @foreach ($arr_ths as $arr_th)
                                <th> {{ $arr_th }}</th>
                            @endforeach

                            @if ($activecrud === 1 or $activecrud === 0)
                                <th width='20%'>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayat_lab as $data)
                            <tr>
                                <td class='text-center'>{{ $loop->iteration }}</td>
                                <td> {{ $data->kode_ruangan }}</td>
                                <td> {{ $data->LaboratoriumOne->nama_laboratorium }}</td>
                                <td> {{ $data->Guru->nama_guru }}</td>

                                <td>
                                    {{-- blade-formatter-disable --}}
                                    <div class='gap-1 d-flex justify-content-center'>
                                        <!-- Button untuk melihat -->
                                        <button type='button' class='btn btn-success btn-sm btn-equal-width' data-toggle='modal' data-target='#viewModal{{ $data->id }}'><i class='fa fa-eye'></i> </button>
                                        <!-- Button untuk mengedit -->
                                        <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'> <i class='fa fa-edit'></i></button>
                                        <!-- Form untuk menghapus -->
                                        <form id='delete-form-{{ $data->id }}' action='{{ route('laboratorium.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i>  </button>
                                    </div>
                                    {{-- blade-formatter-enable --}}
                                </td>
                            </tr>
                            {{-- Modal View Data Akhir --}}
                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                aria-labelledby='EditModalLabel' aria-hidden='true'>
                                <x-edit-modal>
                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                    <form id='updateEtugas' action='{{ route('laboratorium.update', $data->id) }}'
                                        method='POST'>
                                        @csrf
                                        @method('PUT')

                                        <section>
                                            {{-- blade-formatter-disable --}}
                                            <div class='form-group'>
                                            <label for='laboratorium_id'>Laboratorium</label>
                                                <select name='laboratorium_id'  id='laboran_id{{$data->id}}' class='select2 form-control' required>
                                                        <option value=''>--- Pilih Laboratorium ---</option>
                                                    @foreach($Laboratoriums as $Laboratorium)
                                                        <option value='{{ $Laboratorium->id }}' >{{ $Laboratorium->nama_laboratorium }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <script>
                                               $(document).ready(function() {
                                                   // $('#semesteredit option[value='II']').prop('selected', true); // Single Select
                                                   $('#laboran_id{{ $data->id }}').val(@json($data->laboratorium_id)).trigger('change'); // Mutiple Select Select value in array json
                                               });
                                            </script>


                                            <div class='form-group'>
                                                <label for='detailguru_id'>Penanggung Jawab</label>
                                                <select name='detailguru_id' id='detailguru_id{{ $data->id }}' class='select2 form-control' required>
                                                    <option value=''>--- Pilih Penanggung Jawab ---</option>
                                                    @foreach($Gurus as $Guru)
                                                        <option value='{{$Guru->id}}' @if($Guru->id === $Laboratorium->detailguru_id) selected @endif>{{$Guru->nama_guru}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'>Kirim</button>
                                            {{-- blade-formatter-enable --}}

                                        </section>
                                    </form>


                                </x-edit-modal>
                            </div>
                            {{-- Modal Edit Data Akhir --}}
                            {{-- Modal View --}}
                            <div class='modal fade' id='viewModal{{ $data->id }}' tabindex='-1'
                                aria-labelledby='ViewModalLabel' aria-hidden='true'>
                                <x-view-modal>
                                    <x-slot:titleviewModal>{{ $titleviewModal }}</x-slot:titleviewModal>
                                    <section>
                                        <x-inputallin>:Nama
                                            Laboratorium::name:name:{{ $data->LaboratoriumOne->nama_laboratorium }}:Disabled</x-inputallin>
                                        <x-inputallin>:Nama Penanggung
                                            Jawab::detailguru_id:detailguru_id:{{ $data->Guru->nama_guru }}:Disabled</x-inputallin>
                                    </section>
                                </x-view-modal>
                            </div>
                            {{-- Modal View Akhir --}}

                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class='text-center'>
                            <th width='1%'>ID</th>
                            @foreach ($arr_ths as $arr_th)
                                <th> {{ $arr_th }}</th>
                            @endforeach
                            @if ($activecrud === 1 or $activecrud === 0)
                                <th>Action</th>
                            @endif
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </section>

</x-layout>

{{-- {{ JavaScript Awal Modal}} --}}
<script>
    function CreateModal(data) {
        // Show Modal Create Data
        var CreateteModal = new bootstrap.Modal(document.getElementById('createModal'));
        CreateteModal.show();
        // Kirim Nilai Ke Modal byID
        document.getElementById('ctapel_id').value = data.tapel_id;
    }
</script>
{{-- {{ JavaScript Modal Akhir }} --}}

{{-- Modal Create Data Awal --}}
<div class='modal fade' id='createModal' tabindex='-1' aria-labelledby='CreateModalLabel' aria-hidden='true'>
    <x-create-modal>
        <form id='#id' action='{{ route('laboratorium.store') }}' method='POST'>
            @csrf
            <x-slot:titlecreateModal>{{ $titlecreateModal }}</x-slot:titlecreateModal>
            <section>
                {{-- blade-formatter-disable --}}
                    <div class='form-group'>
                        <label for='kode_ruangan'>Kode Ruang</label>
                        <input type='text' class='form-control' id='kode_ruangan' name='kode_ruangan' value='' placeholder='Kode Ruangan' readonly>
                    </div>

                    <div class='form-group'>
                        <label for='laboratorium_id'>Nama Laboratorium</label>
                        <select name='laboratorium_id' id='laboratorium_id' class='select2 form-control' required>
                            <option value=''>--- Pilih Nama Laboratorium ---</option>
                            @foreach ($Laboratoriums as $Laboratorium)
                                <option value='{{ $Laboratorium->id }}' data-kode="{{ $Laboratorium->kode_ruangan }}">
                                    {{ $Laboratorium->nama_laboratorium }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $('#laboratorium_id').on('change', function() {
                                let kode = $(this).find(':selected').data('kode') || '';
                                $('#kode_ruangan').val(kode);
                            });
                        });
                    </script>


                    <div class='form-group'>
                        <label for='user_id'>Penanggung Jawab</label>
                        <select name='detailguru_id' class='select2 form-control' required>
                            <option value=''>--- Pilih Penanggung Jawab ---</option>
                            @foreach ($Gurus as $user)
                                <option value='{{ $user->id }}'>{{ $user->nama_guru }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- blade-formatter-enable --}}
            </section>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
            </div>
        </form>
    </x-create-modal>
</div>
{{-- Modal Create Data Akhir --}}
<script>
    $(document).ready(function() {
        initDataTable('#example1', 'Data Laboratorium', '#example1_wrapper .col-md-6:eq(0)');
        initDataTable('#example2', 'Database Laboratorium', '#example2_wrapper .col-md-6:eq(0)');
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

{{-- <button class='btn btn-warning btn-sm' onclick='TabelLaboratorium()'><i class='fa fa-edit right'></i> Edit</button> --}}
{{--
onclick='TabelLaboratorium()'
 --}}

<script>
    function TabelLaboratorium(data) {
        var TabelLaboratorium = new bootstrap.Modal(document.getElementById('TabelLaboratorium'));
        TabelLaboratorium.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='TabelLaboratorium' tabindex='-1' aria-labelledby='LabelTabelLaboratorium'
    aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelTabelLaboratorium'>
                    Cek Data Ketersedian Laboratorium
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <table id='example2' width='100%' class='table table-bordered table-hover'>
                    <thead>
                        <tr class='table-primary text-center align-middle'>
                            <th>ID</th>
                            <th>Kode</th>
                            <th>Nama Lab</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Laboratoriums as $data)
                            <tr class='text-center'>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->kode_ruangan }}</td>
                                <td>{{ $data->nama_laboratorium }}</td>
                                <td class='align-middle text-left'>{{ $data->keterangan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class='table-primary text-center align-middle'>
                            <th>ID</th>
                            <th>Kode</th>
                            <th>Nama Lab</th>
                            <th>Keterangan</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>

</div>
