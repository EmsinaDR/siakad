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


            {{-- blade-formatter-disable --}}
               <div class='row m-2'>
                   <div class='col-xl-2'>
                       <a href="{{route('template-dokumen.create')}}"><button type='button' class='btn btn-block btn-default bg-primary btn-md'> <i class='fa fa-plus'></i> Tambah Template</button></a>
                       {{-- <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#DataSK'><i class='fa fa-plus'></i> Data SK</button> --}}
                   </div>
                   <div class='col-xl-10'></div>
               </div>
               <div class="row p-2">
                <div class="col-xl-12">
{{-- <x-inputallin>readonly:Nama Dokumen::::{{$DataPPKS->nama_dokumen}}:readonly</x-inputallin> --}}
                </div>
               </div>
               {{-- blade-formatter-enable --}}


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
                                @foreach ($datas as $data)
                                    <tr>
                                        <td class='text-center'>{{ $loop->iteration }}</td>
                                        <td class='text-left'> {{ $data->kategori }} / id {{ $data->id }}</td>
                                        <td class='text-left'> {{ $data->nama_dokumen }}</td>

                                        <td width='10%'>
                                            <div class='gap-1 d-flex justify-content-center'>
                                                {{-- blade-formatter-disable --}}
                                                <!-- Button untuk mengedit -->
                                                <a href="{{route('template-dokumen.show', $data->id)}}"><button type='button' class='btn btn-warning btn-sm btn-equal-width' ><i class='fa fa-edit'></i> </button></a>
                                                <!-- Form untuk menghapus -->
                                                <form id='delete-form-{{ $data->id }}'
                                                    action='{{ route('template-dokumen.destroy', $data->id) }}' method='POST'
                                                    style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i> </button>
                                                {{-- blade-formatter-enable --}}
                                            </div>
                                            {{-- Modal View Data Akhir --}}
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
<div class='modal fade' id='DataSK' tabindex='-1' aria-labelledby='LabelDataSK' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelDataSK'>
                    Data SK
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                    <thead>
                        <tr class='table-primary text-center align-middle'>
                            <th>ID</th>
                            <th>Jabatan</th>
                            <th>Penerima</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class='text-center'>Waka</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class='table-primary text-center align-middle'>
                            <th>ID</th>
                            <th>Jabatan</th>
                        </tr>
                    </tfoot>
                </table>

                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                    <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                </div>
            </div>

        </div>
    </div>

</div>
