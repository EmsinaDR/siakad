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
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#TambahData'><i class='fa fa-plus'></i> Tambah Data</button>
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
                   @foreach ($DataSekolahSMP as $data)
                   <tr>
                       <td class='text-center'>{{ $loop->iteration }}</td>
                       <td class='text-center'> {{ $data->ceklist}}</td><td class='text-center'> {{ $data->tanggal_kunjungan}}</td><td class='text-center'> {{ $data->nsm}}</td><td class='text-center'> {{ $data->npsn}}</td><td class='text-center'> {{ $data->akreditasi}}</td><td class='text-center'> {{ $data->nama_sekolah}}</td><td class='text-center'> {{ $data->alamat}}</td><td class='text-center'> {{ $data->kecamatan}}</td><td class='text-center'> {{ $data->kelurahan}}</td><td class='text-center'> {{ $data->status}}</td><td class='text-center'> {{ $data->siswa_l}}</td><td class='text-center'> {{ $data->siswa_p}}</td><td class='text-center'> {{ $data->nama_kepala}}</td><td class='text-center'> {{ $data->nohp_kepala}}</td><td class='text-center'> {{ $data->nama_operator}}</td>

                       <td width='10%'>
                                            {{-- blade-formatter-disable --}}
                                            <div class='d-flex justify-content-center'>
                                                <!-- Button untuk mengedit -->
                                                <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i> </button>
                                                <!-- Form untuk menghapus -->
                                                <form id='delete-form-{{ $data->id }}' action='{{ route('data-referensi-sekolah-tingkat-smp.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i>  </button>
                                            </div>
                                            {{-- blade-formatter-enable --}}
                              {{-- Modal View Data Akhir --}}
                              <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1' aria-labelledby='EditModalLabel' aria-hidden='true'>
                                  <x-edit-modal>
                                      <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                      <section>
                                             <form id='update-data-referensi-sekolah-tingkat-smp' action='{{ route('data-referensi-sekolah-tingkat-smp.update', $data->id) }}' method='POST'>
                                                 @csrf
                                                 @method('PATCH')

                                                    <div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' value='{{ $data->ceklist}}' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' value='{{ $data->tanggal_kunjungan}}' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' value='{{ $data->nsm}}' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' value='{{ $data->npsn}}' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' value='{{ $data->akreditasi}}' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' value='{{ $data->nama_sekolah}}' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' value='{{ $data->alamat}}' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' value='{{ $data->kecamatan}}' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' value='{{ $data->kelurahan}}' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' value='{{ $data->status}}' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' value='{{ $data->siswa_l}}' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' value='{{ $data->siswa_p}}' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' value='{{ $data->nama_kepala}}' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' value='{{ $data->nohp_kepala}}' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' value='{{ $data->nama_operator}}' required></div>

                                                 <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'> Kirim</button>
                                             </form>
                                      </section>
                                  </x-edit-modal>
                              </div>
                              {{-- Modal Edit Data Akhir --}}
                              {{-- Modal View --}}
                              <div class='modal fade' id='viewModal{{ $data->id }}' tabindex='-1' aria-labelledby='ViewModalLabel' aria-hidden='true'>
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
<button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#TambahData'><i class='fa fa-plus'></i> Tambah Data</button>

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

                   <form id='TambahData-form' action='{{route('data-referensi-sekolah-tingkat-smp.store')}}' method='POST'>
                          @csrf
                          @method('POST')
                         <div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' required></div>

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