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

            <div class="row m-2">
                <div class="col-xl-2">
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'> <i
                            class="fa fa-plus"></i> Tambah Data</button>
                </div>
                <div class="col-xl-10">
                    <div class='card'>
                        <div class='card-header bg-info'>
                            <h3 class='card-title'><i class='fas fa-text-width'></i>Informasi Data Diteruskan</h3>
                        </div><!-- /.card-header -->
                        <div class='card-body'>
                            <dl>
                                <dt>Data Tersimpan</dt>
                                <dd>Data Diteruskan Ke Bagian / Guru yang bersangkutan</dd>
                                <dt></dt>
                                <dd></dd>
                                <dt></dt>
                                <dd></dd>
                            </dl>
                        </div><!-- /.card-body -->
                    </div>
                </div>
            </div>
            <div class='ml-2 my-4'>
                <div class="card">
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>Buku Tamu</h3>
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
                                        <td class='text-center'>
                                            {{ Carbon::create($data->created_at)->translatedformat('l, d F Y') }}
                                        </td>
                                        <td class='text-center'> {{ $data->nama }}</td>
                                        <td class='text-center'> {{ $data->nomor_surat }}</td>
                                        <td class='text-center'> {{ $data->keperluan }}</td>
                                        <td class='text-center'> {{ $data->Guru->nama_guru }}</td>
                                        <td width='10%'>
                                            <div class='gap-1 d-flex justify-content-center'>
                                                <!-- Button untuk mengedit -->
                                                <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                                    data-toggle='modal' data-target='#editModal{{ $data->id }}'><i
                                                        class='fa fa-edit'></i> </button>
                                                <!-- Form untuk menghapus -->
                                                <form id='delete-form-{{ $data->id }}'
                                                    action='{{ route('data-tamu.destroy', $data->id) }}' method='POST'
                                                    style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type='button' class='btn btn-danger btn-sm btn-equal-width'
                                                    onclick='confirmDelete({{ $data->id }})'> <i
                                                        class='fa fa-trash'></i> </button>
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
                                                    action='{{ route('data-tamu.update', $data->id) }}' method='POST'>
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class='m-2'>
                                                        {{-- blade-formatter-disable --}}
                                                         <x-inputallin>type:Nama Tamu:nomor_surat:nama:id_nama:{{ $data->nama }}:Required</x-inputallin>
                                                         <x-inputallin>type:Kontak:Kontak:kontak:id_kontak:{{ $data->kontak }}:Required</x-inputallin>
                                                         <div class="row">
                                                            <div class="col-xl-6">
                                                                <x-inputallin>type:Nomo Surat:Nomor Surat Pengantar:nomor_surat:id_nomor_surat:{{ $data->nomor_surat }}:Required</x-inputallin>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <x-inputallin>type:Instansi:Instansi Asal:instansi:id_instansi:{{ $data->instansi }}:Required</x-inputallin></div>
                                                         </div>
                                                         <div class='form-group'>
                                                             <label for='detailguru_id'>Nama Guru</label>
                                                             <select name='detailguru_id'  id='detailguru_id-{{$data->id}}' class='form-control' required>
                                                                <option value=''>--- Pilih Nama Guru ---</option>
                                                                @foreach($datagurus as $dataguru)
                                                                    <option value='{{$dataguru->id}}'>{{$dataguru->nama_guru}}</option>
                                                                @endforeach
                                                            </select>
                                                            <script>
                                                               $(document).ready(function() {
                                                                   // $('#semesteredit option[value='II']').prop('selected', true); // Single Select
                                                                   $('#detailguru_id-{{ $data->id }}').val(@json($data->detailguru_id)).trigger('change'); // Mutiple Select Select value in array json
                                                               });
                                                            </script>

                                                         </div>

                                                         <label for="keperluan">Keperluan</label>
                                                         <textarea name='keperluan' id='keperluan' rows='3' class='form-control' placeholder='Masukkan Keperluan Singkat'>{{$data->keperluan}}</textarea>
                                                         <div class="row">
                                                            <div class="col-xl-6">
                                                                <x-inputallin>type:Waktu Datang:Waktu Datang:waktu_kedatangan:id_waktu_kedatangan:{{ $data->waktu_kedatangan }}:Required</x-inputallin>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <x-inputallin>date:Waktu Pergi:Waktu Pulang:waktu_kepergian:id_waktu_kepergian:{{ $data->waktu_kepergian }}:Required</x-inputallin>
                                                         </div>

                                                    {{-- blade-formatter-enable --}}
                                                    </div>
                                                    <div class="form-group">
                                                        <label for='catatan'>Catatan :</label>
                                                        <textarea name='catatan' id='catatan' rows='4' class='form-control'
                                                            placeholder='Masukkan Catatan Pribadi Singkat'>{{ $data->catatan }}</textarea>
                                                    </div>
                                                    <button id='kirim' type='submit'
                                                        class='btn float-right btn-default bg-primary btn-xl mt-4 float-right'>
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
            </div>


        </div>

    </section>
</x-layout>
{{-- <button class='btn btn-warning btn-sm' onclick='TambahData()'><i class='fa fa-edit right'></i> Edit</button> --}}
{{--

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

                <form id='#id' action='' method='POST'>
                    @csrf
                    @method('POST')
                    {{-- blade-formatter-disable --}}
                        <x-inputallin>type:Nama Tamu:Nama Lengkap:nama:id_nama::Required</x-inputallin>
                        <x-inputallin>type:Kontak:Kontak:kontak:id_kontak::Required</x-inputallin>
                        <div class="row">
                            <div class="col-xl-6">
                                <x-inputallin>type:Nomo Surat:Nomor Surat Pengantar:nomor_surat:id_nomor_surat::</x-inputallin>
                            </div>
                            <div class="col-xl-6">
                                <x-inputallin>type:Instansi:Instansi Asal:instansi:id_instansi::</x-inputallin>
                            </div>
                        </div>
                        <div class='form-group'>
                             <label for='detailguru_id'>Nama Guru</label>
                             <select name='detailguru_id'  id='detailguru_id-{{$data->id}}' class='form-control' required>
                                <option value=''>--- Pilih Nama Guru ---</option>
                                @foreach($datagurus as $dataguru)
                                    <option value='{{$dataguru->id}}'>{{$dataguru->nama_guru}}</option>
                                @endforeach
                            </select>
                            <script>
                               $(document).ready(function() {
                                   // $('#semesteredit option[value='II']').prop('selected', true); // Single Select
                                   $('#detailguru_id-{{ $data->id }}').val(@json($data->detailguru_id)).trigger('change'); // Mutiple Select Select value in array json
                               });
                            </script>

                         </div>
                        <label for="keperluan">Keperluan</label>
                        <textarea name='keperluan' id='keperluan' rows='3' class='form-control' placeholder='Masukkan Keperluan Singkat'></textarea>
                        <div class="row">
                            <div class="col-xl-6">
                                <x-inputallin>date:Waktu Datang:Waktu Datang:waktu_kedatangan:id_waktu_kedatangan::</x-inputallin>
                            </div>
                            <div class="col-xl-6">
                            <x-inputallin>date:Waktu Pergi:Waktu Pulang:waktu_kepergian:id_waktu_kepergian::</x-inputallin></div>
                        </div>
                        <div class="form-group">
                           <div class="form-check">
                                <input type="checkbox" name="waSender" id="waSender" class="form-check-input">
                                <label class="form-check-label text-success" for="waSender">Kirim via WhatsApp</label>
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
