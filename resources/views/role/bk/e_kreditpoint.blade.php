<style>
    .main-footer{

        margin-top: 100px;
    }
    /* CSS Upload File */
    .file-label {
        cursor: pointer;
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        display: inline-block;
        text-align: center;
    }

    .file-label i {
        margin-right: 10px;
    }

    .file-input {
        opacity: 0; /* Menyembunyikan input file */
        position: absolute; /* Memastikan input file tetap ada di layout */
        z-index: -1; /* Menempatkan input file di belakang label */
        cursor: pointer;
        width: 100%; /* Memperbesar area klik sesuai ukuran label */
        height: 100%;
    }
</style>
<x-layout>
    @php
        $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
        $urlroot = app('request')->root();
    @endphp
    <style>
        textarea {
            resize: none,
        }
    </style>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>
    <section class='content mx-2'>
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
                    <form id='uploadForm' action="{{route('uploadkreditpoint')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label for="file" class="btn btn-primary btn-xl bg-success btn-app">
                            <i class="fas fa-upload"></i> Upload File
                        </label>
                        <input type="file" name="file" id="file" required class="file-input">
                        {{-- <button type="submit">Upload</button> --}}
                    </form>
                </div>
            </div>
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->


            <div class='ml-2 my-4'>
                <table id='example1' width='100%' class='table table-responsive table-bordered table-hover my-4'>
                    <thead>
                        <tr class='text-center'>
                            <th width='1%'>ID</th>
                            @foreach ($arr_ths as $arr_th)
                                <th class='text-center'> {{ $arr_th }}</th>
                            @endforeach
                            {{-- @if ($activecrud === 1) --}}
                            <th width='20%'>Action</th>
                            {{-- @endif --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataKreditPoint as $data)
                            <tr>
                                <td class='text-center'>{{ $loop->iteration }}</td>
                                <td class='text-center'> {{ ucwords($data->kategori) }}</td>
                                <td class='text-justify'> {{ $data->pelanggaran }}</td>
                                <td class='text-center'width='3%'> {{ $data->point }}</td>

                                <td>
                                    <div class='gap-1 d-flex justify-content-center'>
                                        <!-- Button untuk melihat -->
                                        <button type='button' class='btn btn-success btn-sm btn-equal-width'
                                            data-toggle='modal' data-target='#viewModal{{ $data->id }}'>
                                            <i class='fa fa-eye'></i>
                                        </button>
                                        <!-- Button untuk mengedit -->
                                        <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                            data-toggle='modal' data-target='#editModal{{ $data->id }}'>
                                            <i class='fa fa-edit'></i>
                                        </button>
                                        <!-- Form untuk menghapus -->
                                        <form id='delete-form-{{ $data->id }}' action='{{ route('kredit-point.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i>  </button>
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
                                            action='{{ route('kredit-point.update', ['kredit_point' => $data->id]) }}'
                                            method='POST'>
                                            @csrf
                                            @method('PATCH')
                                            <div class='form-group'>
                                                <label for='kategori'>Kategori</label>
                                                <select name='kategori' id='id_kategori' class='select2 form-control' required>
                                                    <option value=''>--- Pilih Kategori ---</option>
                                                    @foreach($dataKreditPoint->unique('kategori') as $Kategori)
                                                    <option value='{{ $Kategori->kategori}}' @if($Kategori->kategori === $data->kategori) selected @endif >{{ ucwords($Kategori->kategori)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class='form-group'>
                                               <label for='pelanggaran'>Pelanggaran</label>
                                               <input type='text' class='form-control' id='pelanggaran' name='pelanggaran' placeholder='placeholder' value='{{$data->pelanggaran}}' required>
                                            </div>
                                            <div class='form-group'>
                                               <label for='point'>Point</label>
                                               <input type='text' class='form-control' id='point' name='point' placeholder='placeholder' value='{{$data->point}}' required>
                                            </div>
                                            <div class="col-4">
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

<button class='btn btn-warning btn-sm' onclick='tambahData()'><i class='fa fa-edit right'></i> Edit</button>

<script>
    function tambahData(data) {
        var tambahData = new bootstrap.Modal(document.getElementById('tambahData'));
        tambahData.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='tambahData' tabindex='-1' aria-labelledby='tambahdataLabel' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='tambahdataLabel'>
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
<button class='btn btn-warning btn-sm' onclick='FNUploadKreditPoints()'><i class='fa fa-edit right'></i> Edit</button>

<script>
    function UploadKreditPoint(data) {
        var UploadKreditPoint = new bootstrap.Modal(document.getElementById('UploadKreditPoint'));
        UploadKreditPoint.show();
        document.getElementById('Eid').value = data.id;
    }
</script>
{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='UploadKreditPoint' tabindex='-1' aria-labelledby='LabelUploadKreditPoint'
    aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelUploadKreditPoint'>
                    Upload Data Kredit Point
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>



 <form id='uploadForm' action="uploadForm" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="file" class="file-label">
        <i class="fas fa-upload"></i> Upload File
    </label>
    <input type="file" name="name" id="file" required class="file-input">
    {{-- <button type="submit">Upload</button> --}}
</form>
<script>
    $(document).ready(function() {
        // Ketika file dipilih, kirim form secara otomatis
        $('#file').change(function() {
            $('#uploadForm').submit();
        });
    });
</script>

            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
            </div>
        </div>
    </div>

</div>
