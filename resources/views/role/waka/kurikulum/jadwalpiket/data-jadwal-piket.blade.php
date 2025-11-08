@php
    //content
    // use Illuminate\Support\Carbon;
    // \Carbon\Carbon::setLocale('id');
    //     $activecrud = collect([2,4, 6, 8])->search(Auth::user()->id);
    //     $jadwal-piket-gururoot = app('request')->root();
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
                <div class="card">
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>Daftar Guru Piket</h3>
                    </div>
                    <div class='card-body'>
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
                                        <td class='text-center'> {{ $data->Guru->nama_guru }}</td>
                                        {{-- <td class='text-center'> {{ $data->detailguru_id}}</td> --}}
                                        <td class='text-center'> {{ $data->hari }}</td>

                                        <td width='10%'>
                                            <div class='gap-1 d-flex justify-content-center'>
                                                <!-- Button untuk mengedit -->
                                                <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                                    data-toggle='modal' data-target='#editModal{{ $data->id }}'><i
                                                        class='fa fa-edit'></i> </button>
                                                <!-- Form untuk menghapus -->
                                                <form id='delete-form-{{ $data->id }}'
                                                    action='{{ route('jadwal-piket-guru.destroy', $data->id) }}'
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
                                                        <form id='updatejadwal-piket-guru'
                                                            action='{{ route('jadwal-piket-guru.update', $data->id) }}'
                                                            method='POST'>
                                                            @csrf
                                                            @method('PATCH')

                                                            {{-- blade-formatter-disable --}}
                                                            <div class='form-group'>
                                                                <label for='detailguru_id'>Nama Guru</label>
                                                                <select id='detailguru_id-{{ $data->id }}' name='detailguru_id' class='form-control' required>
                                                                    <option value=''>--- Pilih Nama Guru --- </option>
                                                                    @foreach ($DataGuru as $newDataGuru)
                                                                        <option value='{{ $newDataGuru->id }}'>{{ $newDataGuru->nama_guru }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <script>
                                                                $(document).ready(function() {
                                                                    $('#detailguru_id-{{ $data->id }}').val(@json($data->detailguru_id)).trigger('change'); // Mutiple Select Select value in array json
                                                                });
                                                            </script>
                                                            <div class='form-group'>
                                                                <label for='hari'>Hari</label>
                                                                <select id='select2_{{ $data->id }}' name='hari' class='form-control' required>
                                                                    <option value=''>--- Pilih Hari ---</option>
                                                                    @foreach ($hari_order as $newharipiket)
                                                                        <option value='{{ $newharipiket }}'> {{ $newharipiket }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <script>
                                                                $(document).ready(function() {
                                                                    $('#select2_{{ $data->id }}').val(@json($data->hari)).trigger('change'); // Mutiple Select Select value in array json
                                                                });
                                                            </script>
                                                            {{-- blade-formatter-enable --}}


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
            </div>


        </div>

    </section>
</x-layout>
{{-- <table id='example1' width='100%' class='table table-bordered table-hover'>
    <thead>
        <tr class='text-center align-middle'>
            <th>Hari</th>
            <th>Nama Guru</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datase as $hari => $jadwal)
            @php $rowspan = $jadwal->count(); @endphp <!-- Hitung jumlah baris per hari -->
            @foreach ($jadwal as $index => $data)
                <tr>
                    @if ($index == 0)
                        <td class='text-center align-middle' rowspan="{{ $rowspan }}">
                            {{ $hari }}</td>
                        <!-- Ditampilkan hanya sekali -->
                    @endif
                    <td class='text-center align-middle'>
                        {{ $data->Guru->nama_guru ?? 'Tidak Ada Guru' }}
                    </td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table> --}}
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
            <form id='#id' action='{{route('jadwal-piket-guru.store')}}' method='POST'>
                @csrf
                @method('POST')
                <div class='modal-body'>

                    {{-- blade-formatter-disable --}}
                    <div class='form-group'>
                        <label for='detailguru_id'>Nama Guru</label>
                        <select id='select2_1' name='detailguru_id[]' class='form-control' multiple='multiple' data-placeholder='Pilih Beberapa Nama' style='width: 100%;'>
                            <option value=''>--- Pilih Nama Guru --- </option>
                            @foreach ($DataGuru as $newDataGuru)
                                <option value='{{ $newDataGuru->id }}'>{{ $newDataGuru->nama_guru }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='form-group'>
                        <label for='hari'>Hari</label>
                        <select id='select2_2' name='hari' class='form-control' required>
                            <option value=''>--- Pilih Hari ---</option>
                            @foreach ($hari_order as $newharipiket)
                                <option value='{{ $newharipiket }}'> {{ $newharipiket }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- blade-formatter-enable --}}

                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                    <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>

</div>
