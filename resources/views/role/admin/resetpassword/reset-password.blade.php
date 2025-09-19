@php
//content
use Illuminate\Support\Carbon;
\Carbon\Carbon::setLocale('id');
    $activecrud = collect([2,4, 6, 8])->search(Auth::user()->id);
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
            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
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
                                           @foreach ($RessetPassword as $data)
                                           <tr>
                                               <td class='text-center'>{{ $loop->iteration }}</td>
                                               <td class='text-left'> {{ $data->name}}</td>
                                               <td class='text-left'> {{ $data->email}}</td>

                                               <td width='10%'>
                                                   <div class='gap-1 d-flex justify-content-center'>
                                                       <!-- Button untuk mengedit -->
                                                       <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                                           data-toggle='modal' data-target='#editModal{{ $data->id }}'><i
                                                               class='fa fa-edit'></i> </button>
                                                   </div>
                                                      {{-- Modal View Data Akhir --}}

                                                      <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1' aria-labelledby='EditModalLabel' aria-hidden='true'>

                                                          <x-edit-modal>
                                                              <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                              <section>
                                                                     <form id='updateurl' action='{{ route('reset-password.update', $data->id) }}' method='POST'>
                                                                         @csrf
                                                                         @method('PATCH')

                                                                            <div class='form-group'>
                                                                            <label for='nama'>Nama Pengguna</label>
                                                                            <input type='text' class='form-control' id='nama' name='nama' placeholder='Nama Pengguna' value='{{$data->name}}' disabled>
                                                                            </div>
                                                                            <div class='form-group'>
                                                                            <label for='email'>Email</label>
                                                                            <input type='text' class='form-control' id='email' name='email' placeholder='Email' value='{{$data->email}}' disabled>
                                                                            </div>
                                                                            <div class='form-group'>
                                                                            <label for='password'>Password Baru</label>
                                                                            <input type='text' class='form-control' id='password' name='password' placeholder='Password Baru' required>
                                                                            </div>

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
            </div>
        </div>
    </section>
</x-layout>