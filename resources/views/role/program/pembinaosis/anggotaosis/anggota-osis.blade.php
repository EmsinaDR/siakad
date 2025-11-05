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
            <!--Card Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</h3>
            </div>
            <!--Card Header-->
            <div class='row m-2'>
                {{-- blade-formatter-disable --}}
                <div class='col-xl-2'>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#namaModal'><i class='fa fa-plus'></i> Tambah Anggota</button>
                </div>
                <div class='col-xl-10'>
                    <table id='example2' width='100%' class='table table-bordered table-hover'>
                        <thead>
                            <tr class='table-primary text-center align-middle'>
                                <th>Tahun Masuk</th>
                                <th>Jumlah Anggota</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datasAnggota as $data)
                                <tr class="text-center">
                                    <td>{{ $data->tahun_masuk }}</td>
                                    <td>{{ $data->total }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class='table-primary text-center align-middle'>
                                <th>Tahun Masuk</th>
                                <th>Jumlah Anggota</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                {{-- blade-formatter-enable --}}
            </div>
            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <table id='example1' width='100%' class='my-datatable table table-responsive table-bordered table-hover'>
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
                                        <td class='text-left'> {{ $data->Siswa->nama_siswa }}</td>
                                        <td class='text-center'> {{ $data->Kelas->kelas }}</td>
                                        <td class='text-center'> {{ $data->jabatan }}</td>
                                        <td class='text-center'> {{ $data->tahun_masuk }}</td>

                                        <td width='10%'>
                                            {{-- blade-formatter-disable --}}
                                            <div class='gap-1 d-flex justify-content-center'>
                                                <!-- Button untuk mengedit -->
                                                <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i> </button>
                                                <!-- Form untuk menghapus -->
                                                <form id='delete-form-{{ $data->id }}' action='{{ route('anggota-osis.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i> </button>
                                            </div>
                                            {{-- blade-formatter-enable --}}
                                            {{-- Modal View Data Akhir --}}

                                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                                aria-labelledby='EditModalLabel' aria-hidden='true'>

                                                <x-edit-modal>
                                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                    <section>
                                                        {{-- blade-formatter-disable --}}
                                                        <form id='updateurl' action='{{ route('anggota-osis.update', $data->id) }}' method='POST'>
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class='form-group'>
                                                                <label for='detailsiswa_id'>Nama Siswa</label>
                                                                <select name='detailsiswa_id[]' id='detailsiswa_id' multiple data-placeholder='Pilih siswa' class='select2 form-control' disabled >
                                                                    <option value=''>--- Pilih Nama Siswa ---</option>
                                                                    @foreach ($Siswas as $newSiswas)
                                                                        <option value='{{ $newSiswas->id }}' @if($data->detailsiswa_id === $newSiswas->id) selected @endif> {{ $newSiswas->nama_siswa }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        @php
                                                            $jabatans = ['Ketua', 'Sekretaris', 'Bendahara', 'Anggota'];
                                                        @endphp
                                                            <div class='form-group'>
                                                                <label for='jabatan'>Jabatan</label>
                                                                <select name='jabatan' id='jabatan' class='select2 form-control' required>
                                                                    <option value=''>--- Pilih Jabatan ---</option>
                                                                    @foreach ($jabatans as $newjabatans)
                                                                        <option value='{{ $newjabatans }}' @if($data->jabatan === $newjabatans) selected @endif> {{ $newjabatans }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'>Kirim</button>
                                                        </form>
                                                        {{-- blade-formatter-enable --}}
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
                                    <th class='text-center'>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
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

                {{-- blade-formatter-disable --}}
                <form id='#id' action='{{ route('anggota-osis.store') }}' method='POST'>
                    @csrf
                    @method('POST')
                    <div class='form-group'>
                        <label for='detailsiswa_id'>Nama Siswa</label>
                        <select name='detailsiswa_id[]' id='detailsiswa_id' multiple data-placeholder='Pilih siswa' class='select2 form-control' required>
                            <option value=''>--- Pilih Nama Siswa ---</option>
                            @foreach ($Siswas as $newSiswas)
                                <option value='{{ $newSiswas->id }}'>{{ $newSiswas->nama_siswa }}</option>
                            @endforeach
                        </select>
                    </div>
                    @php
                        $jabatans = ['Ketua', 'Sekretaris', 'Bendahara', 'Anggota'];
                    @endphp
                    <div class='form-group'>
                        <label for='jabatan'>Jabatan</label>
                        <select name='jabatan' id='jabatan' class='select2 form-control' required>
                            <option value=''>--- Pilih Jabatan ---</option>
                            @foreach ($jabatans as $newjabatans)
                                <option value='{{ $newjabatans }}'>{{ $newjabatans }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                    </div>
                </form>
                {{-- blade-formatter-enable --}}
            </div>

        </div>
    </div>

</div>
<script>
    $(document).ready(function() {
        initDataTable('#example1', 'Data Peserta Tahfidz', '#example1_wrapper .col-md-6:eq(0)', 2);
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