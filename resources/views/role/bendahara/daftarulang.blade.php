<x-layout>
    @php
    $activecrud = collect([2,4, 6, 8])->search(Auth::user()->id);
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
        <div class='card'>
            {{-- Papan Informasi --}}
            <div class='card-body'>
                <div class='row float-right'>
                    <x-btn>submit/Tambah Data/fa fa-plus/btn btn-primary btn-xl bg-primary btn-app/TambahMapel()</x-btn>
                </div>
            </div>
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->


            <div class='ml-2'>
                {{--Catatan :
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
                                       {{-- @if($activecrud === 1)
                                      {{-- @endif--}}
                                   </tr>
                            </thead>
                            <tbody>
                                   @foreach ($datas as $data)
                                   <tr>
                                       <td class='text-center'>{{ $loop->iteration }}</td>
                                       <td class='text-center'> {{ $data->kegiatan}}</td>

                                       <td width='10%'>
                                           <div class='gap-1 d-flex justify-content-center'>
                                               <!-- Button untuk mengedit -->
                                               <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                                   data-toggle='modal' data-target='#editModal{{ $data->id }}'><i
                                                       class='fa fa-edit'></i> </button>
                                               <!-- Form untuk menghapus -->
                                               <form id='delete-form-{{ $data->id }}'
                                                   action='{{ route('daftar-ulangdestroy', $data->id) }}' method='POST'
                                                   style='display: inline-block;'>
                                                   @csrf
                                                   @method('DELETE')
                                               </form>
                                               <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i>  </button>
                                           </div>
                                              {{-- Modal View Data Akhir --}}

                                              <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1' aria-labelledby='EditModalLabel' aria-hidden='true'>

                                                  <x-edit-modal>
                                                      <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                      <section>
                                                             <form id='updateurl' action='{{ route('daftar-ulangupdate', $data->id) }}' method='POST'>
                                                                 @csrf
                                                                 @method('PATCH')

                                                                    contentEdit

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
                                       {{-- @if($activecrud === 1)--}}
                                       <th class='text-center'>Action</th>
                                       {{-- @endif--}}
                                   </tr>
                            </tfoot>
                        </table>
            </div>

        </div>

    </section>
</x-layout>
