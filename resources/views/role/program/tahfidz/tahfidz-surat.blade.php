
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
            {{-- Papan Informasi --}}

            {{-- Papan Informasi --}}

                   <!--Car Header-->
                   <div class='card-header bg-primary mx-2'>
                       <h3 class='card-title'>{{ $title }}</H3>
                   </div>
                   <!--Car Header-->


            <div class='ml-2 my-4'>
                   <div class="card">
                    <div class='card-header bg-primary'><h3 class='card-title'>Data Surat Hafalan</h3></div>
                    <div class='card-body'>
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
                                               <td class='text-center'> {{ $data->nama_surat}}</td>
                                               <td class='text-center'> {{ $data->jumlah_ayat}}</td>

                                               <td width='20%'>
                                                     <div class='gap-1 d-flex justify-content-center'>

                                                            <!-- Button untuk melihat -->
                                                            <!-- <button type='button' class='btn btn-success btn-sm btn-equal-width' data-toggle='modal' data-target='#viewModal{{ $data->id }}'><i class='fa fa-eye'></i> Lihat</button> -->
                                                            <!-- Button untuk mengedit -->
                                                            <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i> Edit</button>
                                                            <!-- Form untuk menghapus -->
                                                            <form action='{{ route('surat-tahfidz.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type='submit' class='btn btn-danger btn-sm btn-equal-width' onclick=`return confirm('Apakah Anda yakin ingin menghapus data ini?');`><i class='fa fa-trash'></i> Hapus</button>
                                                            </form>

                                                     </div>
                                                </td>
                                             </tr>
                                             {{-- Modal View Data Akhir --}}

                                             <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1' aria-labelledby='EditModalLabel' aria-hidden='true'>

                                                 <x-edit-modal>
                                                     <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                     <section>
                                                            <form id='updateurl' action='{{ route('surat-tahfidz.update', $data->id) }}' method='POST'>
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
