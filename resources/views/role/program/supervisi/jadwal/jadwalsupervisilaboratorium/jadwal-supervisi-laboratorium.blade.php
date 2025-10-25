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
            <div class='row m-2'>
                <div class='col-xl-2'>
                    {{-- <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'> <i class='fa fa-plus'></i> Tambah Data </button> --}}
                </div>
                <div class='col-xl-10'></div>
            </div>
            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <!-- Konten -->
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
                                               <td class='text-center'> {{ $data->LaboratoriumOne->nama_laboratorium}}</td>
                                               <td class='text-center'> {{ $data->Guru->nama_guru}}</td>
                                               <td class='text-center'>
                                               @php
                                               $Jadwal_SLabs = \App\Models\Program\Supervisi\Jadwal\JadwalSupervisiLaboratorium::where('tapel_id', $Tapels->id)->where('laboratorium_id', $data->laboratorium_id)->where('petugas_id', $data->detailguru_id)->first();
                                               @endphp
                                                {!! $Jadwal_SLabs && $Jadwal_SLabs->tanggal_pelaksanaan
    ? \Carbon\Carbon::parse($Jadwal_SLabs->tanggal_pelaksanaan)->translatedFormat('l, d F Y')
    : '<i class="fas fa-times text-danger"></i>' !!}

                                               </td>

                                               <td width='10%'>
                                                   <div class='gap-1 d-flex justify-content-center'>
                                                       <!-- Button untuk mengedit -->
                                                       <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                                           data-toggle='modal' data-target='#editModal{{ $data->id }}'><i
                                                               class='fa fa-edit'></i> </button>
                                                       <!-- Form untuk menghapus -->
                                                       <form id='delete-form-{{ $data->id }}'
                                                           action='{{ route('jadwal-supervisi-laboratorium.destroy', $Jadwal_SLabs ? $Jadwal_SLabs->id : '') }}' method='POST'
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
                                                                     <form id='updateurl' action='{{ route('jadwal-supervisi-laboratorium.store', $Jadwal_SLabs ? $Jadwal_SLabs->id : '') }}' method='POST'>
    @csrf
    @method('POST') {{-- Menggunakan PATCH untuk update --}}

    {{-- blade-formatter-disable --}}
    <div class="form-group">
        <label for="nama_laboratorium">Nama Laboratorium</label>
        <input type="text" class="form-control" id="nama_laboratorium" name="nama_laboratorium" value="{{ $data->LaboratoriumOne->nama_laboratorium }}" readonly style="background-color:#fff;">
    </div>

    <div class="form-group">
        <label for="nama_guru">Nama Guru</label>
        <input type="text" class="form-control" id="nama_guru" name="nama_guru" value="{{ $data->Guru->nama_guru }}" readonly style="background-color:#fff;">
    </div>

    <div class="form-group">
        <label for="tanggal_pelaksanaan">Jadwal Pelaksanaan</label>
        <input type="date" class="form-control" id="tanggal_pelaksanaan" name="tanggal_pelaksanaan" placeholder="Jadwal Pelaksanaan" value="{{ old('tanggal_pelaksanaan', $Jadwal_SLabs ? $Jadwal_SLabs->tanggal_pelaksanaan : '') }}" required>
    </div>

    {{-- Hidden fields for petugas_id and laboratorium_id --}}
    <input type="hidden" name="petugas_id" value="{{ $data->detailguru_id }}">
    <input type="hidden" name="laboratorium_id" value="{{ $data->laboratorium_id }}">

    <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'> Kirim</button>
</form>

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