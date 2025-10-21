@php
    //content
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
@endphp
<x-layout>
    <style>
        textarea {
            resize: none;
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
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'><i class='fa fa-plus'></i> Tambah Data</button>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#DataModul'><i class="fa fa-key"></i> Aktivasi</button>

                </div>
                {{-- blade-formatter-enable --}}
                <div class='col-xl-10'></div>
            </div>
            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <!-- Konten -->
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
                                @foreach ($Moduls as $data)
                                    <tr>
                                        <td class='text-center'>{{ $loop->iteration }}</td>
                                        <td class='text-center'> {{ $data->modul ?? '' }}</td>
                                        <td class='text-left'> {{ $data->provider_class ?? '' }}</td>
                                        <td class='text-center'> {{ $data->slug ?? '' }}</td>
                                        <td class='text-center'>
                                            @if ($data->is_active == 1)
                                                <i class="fa fa-check text-success"></i>
                                            @endif
                                        </td>

                                        <td width='10%'>
                                            {{-- blade-formatter-disable --}}
                                            <div class='d-flex justify-content-center'>
                                                <!-- Button untuk mengedit -->
                                                <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i> </button>
                                                {{-- <!-- Form untuk menghapus -->
                                                <form id='delete-form-{{ $data->id }}' action='{{ route('modul.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i>  </button> --}}
                                            </div>
                                            {{-- blade-formatter-enable --}}
                                            {{-- Modal View Data Akhir --}}
                                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                                aria-labelledby='EditModalLabel' aria-hidden='true'>
                                                <x-edit-modal>
                                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                    <section>
                                                        <form id='update-modul'
                                                            action='{{ route('modul.update', $data->id) }}'
                                                            method='POST'>
                                                            @csrf
                                                            @method('PATCH')
                                                            @php
                                                                $aktivasis = ['1' => 'Aktif', '0' => 'Tidak Aktif'];
                                                            @endphp
                                                            <div class='form-group'>
                                                                <label for='modul'>Modul</label>
                                                                <input type='text' class='form-control'
                                                                    id='modul' name='modul'
                                                                    placeholder='placeholder'
                                                                    value='{{ $data->modul }}' required>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="is_active">Aktivasi</label>
                                                                <select name="is_active"
                                                                    id="is_active{{ $data->id }}"
                                                                    class="select2 form-control" required>
                                                                    <option value="">--- Pilih Aktivasi ---
                                                                    </option>
                                                                    @foreach ($aktivasis as $key => $value)
                                                                        <option value="{{ $key }}"
                                                                            @if ($key === $data->is_active) selected @endif>
                                                                            {{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <script>
                                                                $('#is_active{{ $data->id }}').select2({
                                                                    dropdownParent: $('#modalEdit{{ $data->id }}')
                                                                });
                                                            </script>

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
<div class='modal fade' id='DataModul' tabindex='-1' aria-labelledby='LabelDataModul' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelDataModul'>
                    Aktivasi Modul
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <form id='DataModul-form' action='{{ route('modul.ubah.masal') }}' method='POST'>
                    @csrf
                    @method('POST')
                    <div class='form-group'>
                       <label for='modul'>Modul</label>
                       <select name='modul[]' id='modul' data-placeholder='Pilih Data Modul' multiple class='select2 form-control' required>
                               <option value=''>--- Pilih Modul ---</option>
                           @foreach($Moduls as $newkey)
                               <option value='{{$newkey->id}}'>{{$newkey->modul}}</option>
                           @endforeach
                       </select>
                    </div>
                    <div class='form-group'>
                       <label for='aktivasi'>Aktiv / Tidak</label>
                       <select name='aktivasi' id='aktivasi' data-placeholder='Pilih Data Aktiv / Tidak' class='select2 form-control' required>
                               <option value=''>--- Pilih Aktiv / Tidak ---</option>
                           @foreach(['Aktiv','Tidak'] as $newkey)
                               <option value='{{$newkey}}'>{{ucfirst($newkey)}}</option>
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
