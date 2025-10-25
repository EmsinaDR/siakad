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


            {{-- <div class='row m-2'>
                <div class='col-xl-2'>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'> <i  class='fa fa-plus'></i> Tambah Data</button>
                </div>
                <div class='col-xl-10'></div>
            </div> --}}


            <div class='ml-2 my-4'>

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
                                    {{ Carbon::create($data->tanggal_pelaksanaan)->translatedformat('l, d F Y') }}
                                </td>
                                <td class='text-left'> {{ $data->nama_rapat }}</td>
                                <td class='text-left'> {!! $data->perihal !!}</td>
                                <td class='text-center'> {{ $data->jam_mulai }} - {{ $data->jam_selesai }}</td>
                                <td class='text-center'> {{ $data->tempat }}</td>
                                @php
                                    $votes = json_decode($data->vote_id ?? '[]');
                                @endphp
                                <td class="text-center">{{ count($votes) }}</td>


                                <td width='10%'>
                                    <div class='gap-1 d-flex justify-content-center'>
                                        {{-- blade-formatter-disable --}}
                                        {{-- <a href="{{ route('berita-acara-rapat.show', $data->id) }}"><button type='button' class='btn btn-success btn-sm btn-equal-width' data-toggle='modal' ><i class='fa fa-eye'></i> </button></a> --}}
                                        <a href="{{ route('daftar-hadir-rapat.show', $data->id) }}"><button type='button' class='btn btn-success btn-sm btn-equal-width' data-toggle='modal' ><i class='fa fa-eye'></i> </button></a>
                                        {{-- blade-formatter-enable --}}
                                    </div>
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

    </section>
</x-layout>
