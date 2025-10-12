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
                   <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#AturJadwal'><i class='fa fa-plus'></i> Atur Jadwal</button>
                </div>
                <div class='col-xl-10'></div>
                {{-- blade-formatter-enable --}}
            </div>
            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <!-- Konten -->
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
                                        <td class='text-center'> {{ $data->hari }}</td>
                                        <td class='text-left'> {!! ambilNamaGuru($data->detailguru_id) !!}</td>

                                        <td width='10%'>
                                            {{-- blade-formatter-disable --}}
                                                   <div class='gap-1 d-flex justify-content-center'>
                                                       <!-- Button untuk mengedit -->
                                                       <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i> </button>
                                                       <!-- Form untuk menghapus -->
                                                       <form id='delete-form-{{ $data->id }}' action='{{ route('piket-ppdb.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                           @csrf
                                                           @method('DELETE')
                                                       </form>
                                                       <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i>  </button>
                                                   </div>
                                                   {{-- blade-formatter-enable --}}
                                            {{-- Modal View Data Akhir --}}

                                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                                aria-labelledby='EditModalLabel' aria-hidden='true'>

                                                <x-edit-modal>
                                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                    <section>
                                                        <form id='updateurl'
                                                            action='{{ route('piket-ppdb.update', $data->id) }}'
                                                            method='POST'>
                                                            @csrf
                                                            @method('PATCH')

                                                            {{-- blade-formatter-disable --}}

                                                                    <div class='form-group'>
                                                                        <label for='detailguru_id'>Nama Guru</label>
                                                                        <select name='detailguru_id[]' id='detailguru_id' multiple data-placeholder='Pilih Data Nama Guru' class='select2 form-control' required>
                                                                            <option value=''>--- Pilih Nama Guru ---</option>
                                                                            @php
                                                                                $selectedGuruIds = json_decode($data->detailguru_id, true) ?? [];
                                                                            @endphp
                                                                            @foreach($Gurus as $newGurus)
                                                                                <option value='{{$newGurus->id}}' {{ in_array($newGurus->id, $selectedGuruIds) ? 'selected' : '' }}>
                                                                                    {{$newGurus->nama_guru}}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    @php
                                                                    $Haris = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                                                                    @endphp
                                                                    <div class='form-group'>
                                                                        <label for='hari'>Hari</label>
                                                                        <select name='hari' id='hari' data-placeholder='Pilih Data Hari' class='select2 form-control' required>
                                                                                <option value=''>--- Pilih Hari ---</option>
                                                                            @foreach($Haris as $Hari)
                                                                                <option value='{{$Hari}}' @if($data->hari === $Hari) selected @endif>{{$Hari}}</option>
                                                                            @endforeach
                                                                        </select>
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

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='AturJadwal' tabindex='-1' aria-labelledby='LabelAturJadwal' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelAturJadwal'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <form id='AturJadwal-form' action='{{ route('piket-ppdb.store') }}' method='POST'>
                    @csrf
                    @method('POST')
                    <div class='form-group'>
                        <label for='detailguru_id'>Nama Guru</label>
                        <select name='detailguru_id[]' id='detailguru_id' multiple
                            data-placeholder='Pilih Data Nama Guru' class='select2 form-control' required>
                            <option value=''>--- Pilih Nama Guru ---</option>
                            @foreach ($Gurus as $newGurus)
                                <option value='{{ $newGurus->id }}'>{{ $newGurus->nama_guru }}</option>
                            @endforeach
                        </select>
                    </div>
                    @php
                        $Haris = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    @endphp
                    <div class='form-group'>
                        <label for='hari'>Hari</label>
                        <select name='hari' id='hari' data-placeholder='Pilih Data Hari'
                            class='select2 form-control' required>
                            <option value=''>--- Pilih Hari ---</option>
                            @foreach ($Haris as $Hari)
                                <option value='{{ $Hari }}'>{{ $Hari }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- blade-formatter-disable --}}
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                    </div>
                    {{-- blade-formatter-enable --}}

                </form>
            </div>

        </div>
    </div>

</div>
