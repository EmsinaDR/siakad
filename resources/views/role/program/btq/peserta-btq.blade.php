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
                <div class='col-xl-2'>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'> <i
                            class='fa fa-plus'></i> Tambah Data</button>
                </div>
                <div class='col-xl-10'></div>
            </div>


            <div class='ml-2 my-4'>
                {{-- Catatan :
                   - Include Komponen Modal CRUD + Javascript / Jquery
                   - Perbaiki Onclick Tombol Modal Create, Edit
                   - Variabel Active Crud menggunakan ID User
                    --}}
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
                                <td class='text-center'> {{ $data->SiswaOne->nama_siswa }}</td>
                                <td class='text-center'> {{ $data->kelas->kelas }}</td>
                                <td class='text-center'> {{ $data->Guru->nama_guru }}</td>
                                <td class='text-center'> {{ $data->hari_bimbingan }}</td>

                                <td width='10%'>
                                    <div class='gap-1 d-flex justify-content-center'>
                                        <!-- Button untuk mengedit -->
                                        <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                            data-toggle='modal' data-target='#editModal{{ $data->id }}'><i
                                                class='fa fa-edit'></i> </button>
                                        <!-- Form untuk menghapus -->
                                        <form id='delete-form-{{ $data->id }}'
                                            action='{{ route('peserta-btq.destroy', $data->id) }}' method='POST'
                                            style='display: inline-block;'>
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button type='button' class='btn btn-danger btn-sm btn-equal-width'
                                            onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i>
                                        </button>
                                    </div>
                                    {{-- Modal View Data Akhir --}}

                                    <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                        aria-labelledby='EditModalLabel' aria-hidden='true'>

                                        <x-edit-modal>
                                            <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                            <section>
                                                <form id='updateurl'
                                                    action='{{ route('peserta-btq.update', $data->id) }}'
                                                    method='POST'>
                                                    @csrf
                                                    @method('PATCH')
                                                    {{-- blade-formatter-disable --}}
                                                    <div class='form-group'>
                                                        <label for='detailsiswa_id'>Nama Siswa</label>
                                                        <select name='detailsiswa_id' id='detailsiswa_id-{{ $data->id }}' class='form-control' disabled>
                                                            @foreach ($datas as $DataSiswa)
                                                                <option value='{{ $DataSiswa->id }}'>{{ $DataSiswa->kelas->kelas }} - {{ $DataSiswa->SiswaOne->nama_siswa }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <script>
                                                       $(document).ready(function() {
                                                           // $('#semesteredit option[value='II']').prop('selected', true); // Single Select
                                                           $('#detailsiswa_id-{{ $data->id }}').val(@json($data->id)).trigger('change'); // Mutiple Select Select value in array json
                                                       });
                                                    </script>

                                                    <div class='form-group'>
                                                        <label for='pembimbimbing_id'>Data Pembimbing</label>
                                                        <select name='pembimbing_id' id='pembimbing_id-{{ $data->id }}' class='form-control' required>
                                                            <option value=''>--- Pilih Data Pembimbing ---</option>
                                                            @foreach ($Pembimbings as $Pembimbing)
                                                                <option value='{{ $Pembimbing->id }}'>{{ $Pembimbing->nama_guru }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <script>
                                                       $(document).ready(function() {
                                                           // $('#semesteredit option[value='II']').prop('selected', true); // Single Select
                                                           $('#pembimbing_id-{{ $data->id }}').val(@json($data->pembimbing_id)).trigger('change'); // Mutiple Select Select value in array json
                                                       });
                                                    </script>

                                                    <div class='form-group'>
                                                        @php
                                                            $hari_indonesia = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                                                        @endphp
                                                        <label for='hari_bimbingan'>Hari</label>
                                                        <select name='hari_bimbingan' id='hari_bimbingan-{{ $data->id }}' class='form-control' required>
                                                            <option value=''>--- Pilih Hari ---</option>
                                                            @foreach ($hari_indonesia as $hari)
                                                                <option value='{{ $hari }}'>{{ $hari }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <script>
                                                       $(document).ready(function() {
                                                           // $('#semesteredit option[value='II']').prop('selected', true); // Single Select
                                                           $('#hari_bimbingan-{{ $data->id }}').val(@json($data->hari_bimbingan)).trigger('change'); // Mutiple Select Select value in array json
                                                       });
                                                    </script>


                                                    <button id='kirim' type='submit'
                                                        class='btn float-right btn-default bg-primary btn-xl mt-4'>
                                                        Kirim</button>
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

                <form id='#id' action='{{route('peserta-btq.store')}}' method='POST'>
                    @csrf
                    @method('POST')
                    {{-- blade-formatter-disable --}}
                    <div class='form-group'>
                        <label for='detailsiswa_id'>Nama Siswa</label>
                        <select name='detailsiswa_id' id='detailsiswa_id' class='form-control'>
                            @foreach ($DataSiswas as $DataSiswa)
                                <option value='{{ $DataSiswa->id }}'>{{ $DataSiswa->KelasOne->kelas }} -{{ $DataSiswa->nama_siswa }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='form-group'>
                        <label for='pembimbimbing_id'>Data Pembimbing</label>
                        <select name='pembimbing_id' id='pembimbing_id' class='form-control' required>
                            <option value=''>--- Pilih Data Pembimbing ---</option>
                            @foreach ($Pembimbings as $Pembimbing)
                                <option value='{{ $Pembimbing->id }}'>{{ $Pembimbing->nama_guru }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='form-group'>
                        @php
                            $hari_indonesia = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                        @endphp
                        <label for='hari_bimbingan'>Hari</label>
                        <select name='hari_bimbingan' id='hari_bimbingan' class='form-control'  required>
                            <option value=''>--- Pilih Hari ---</option>
                            @foreach ($hari_indonesia as $hari)
                                <option value='{{ $hari }}'>{{ $hari }}</option>
                            @endforeach
                        </select>
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
        initDataTable('#example1', 'Data Peserta BTQ', '#example1_wrapper .col-md-6:eq(0)', 2);
    });

    function initDataTable(tableId, exportTitle, buttonContainer, groupByColumn) {
        if ($.fn.DataTable.isDataTable(tableId)) {
            $(tableId).DataTable().destroy();
        }

        var table = $(tableId).DataTable({
            lengthChange: true,
            autoWidth: false,
            responsive: true,
            ordering: true,
            searching: true,
            //searchCols: [
            //    null,  // Kolom 0 (ID)
             //   { search: '' }, // Kolom 1 (Nama Siswa)
            //    { search: '' }, // Kolom 2 (Kelas)
            //    { search: '' }, // Kolom 3 (Pembimbing)
             //   { search: '' }  // Kolom 4 (Hari Bimbingan)
            //],
            buttons: [
                { extend: 'copy', title: exportTitle },
                { extend: 'excel', title: exportTitle },
                { extend: 'pdf', title: exportTitle, exportOptions: { columns: ':visible:not(.noprint)' }},
                { extend: 'colvis', titleAttr: 'Pilih Kolom' }
            ],
            columnDefs: [
                { targets: [], visible: false }, // Sembunyikan kolom Action jika perlu
                //{ targets: groupByColumn, visible: true } // Pastikan kolom yang dikelompokkan tetap terlihat
            ],
            //rowGroup: { dataSrc: groupByColumn }
        });

        table.buttons().container().appendTo(buttonContainer);
 $('#example1_filter input').attr('placeholder', 'Tuliskan nama...');

        // ✅ Pencarian yang bekerja termasuk untuk tombol 'X'
        $('#example1_filter input').on('input', function() {
            var value = this.value.trim();
            table.column(1).search(value).draw();//Kolom Pencarian

            // Jika input kosong, reset pencarian
            if (value === '') {
                table.search('').columns().search('').draw();
            }
        });
    }
</script>