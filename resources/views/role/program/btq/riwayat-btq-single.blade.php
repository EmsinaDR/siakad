@php
    dump($datas);
@endphp


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
                                <td class='text-center'>
                                    @php
                                        $Halamans = json_decode($data->halaman, true);
                                    @endphp
                                    @foreach ($Halamans as $key => $Halaman)
                                        {{ $Halaman }}@if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach

                                </td>

                                <td width='10%'>
                                    <div class='gap-1 d-flex justify-content-center'>
                                        <!-- Button untuk mengedit -->
                                        <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                            data-toggle='modal' data-target='#editModal{{ $data->id }}'><i
                                                class='fa fa-edit'></i> </button>
                                        <!-- Form untuk menghapus -->
                                        <form id='delete-form-{{ $data->id }}'
                                            action='{{ route('riwayat-btq.destroy', $data->id) }}' method='POST'
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
                                                    action='{{ route('riwayat-btq.update', $data->id) }}'
                                                    method='POST'>
                                                    @csrf
                                                    @method('PATCH')
                                                    @php
                                                        $Halamans = range(1, 100);
                                                        $update = json_decode($data->halaman, true);
                                                    @endphp

                                                    <div class='form-group'>
                                                        <label for='halaman'>Halaman</label>
                                                        <select name='halaman[]' id='select2-{{ $data->id }}'
                                                            class='form-control' multiple required>
                                                            @foreach ($Halamans as $Halaman)
                                                                <option value='{{ $Halaman }}'>
                                                                    {{ $Halaman }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <script>
                                                        $(document).ready(function() {
                                                            // $('#semesteredit option[value='II']').prop('selected', true); // Single Select
                                                            $('#select2-{{ $data->id }}').val(@json($update)).trigger(
                                                                'change'); // Mutiple Select Select value in array json
                                                        });
                                                    </script>

                                                    <div class='form-group'>
                                                        <i class='fas fa-sticky-note'></i><label
                                                            for='keterangan'>Keterangan</label>
                                                        <textarea name='keterangan' id='keterangan' rows='3' class='form-control'
                                                            placeholder='Masukkan Keterangan Singkat'>{{ $data->keterangan }}</textarea>
                                                    </div>
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
<script>
    $(document).ready(function() {
        initDataTable('#example1', 'Data Riwayat BTQ Siswa', '#example1_wrapper .col-md-6:eq(0)', 2);
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
            buttons: [{
                    extend: 'copy',
                    title: exportTitle
                },
                {
                    extend: 'excel',
                    title: exportTitle
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
                    targets: [],
                    visible: false
                }, // Sembunyikan kolom Action jika perlu
                //{ targets: groupByColumn, visible: true } // Pastikan kolom yang dikelompokkan tetap terlihat
            ],
            //rowGroup: { dataSrc: groupByColumn }
        });

        table.buttons().container().appendTo(buttonContainer);
        $('#example1_filter input').attr('placeholder', 'Tuliskan nama...');

        // ✅ Pencarian yang bekerja termasuk untuk tombol 'X'
        $('#example1_filter input').on('input', function() {
            var value = this.value.trim();
            table.column(1).search(value).draw(); //Kolom Pencarian

            // Jika input kosong, reset pencarian
            if (value === '') {
                table.search('').columns().search('').draw();
            }
        });
    }
</script>
