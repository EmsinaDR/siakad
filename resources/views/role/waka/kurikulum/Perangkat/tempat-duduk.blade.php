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
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TempatDuduk()'> <i class='fa fa-print'></i> Bulk Print Data</button>
                </div>
                <div class='col-xl-10'></div>
            </div>
            {{-- blade-formatter-enable --}}


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
                        @php $no = 1; @endphp
                        @foreach ($datas as $index => $data)
                            <tr>
                                <td class='align-middle text-center'>{{ $loop->iteration }}</td>
                                <td class='align-middle text-center'>Ruang {{ $data->nomor_ruangan }}</td>
                                <td class='align-middle text-center'>{{ $data->jumlah_siswa }}</td>
                                <td class='align-middle text-center'>
                                    <a href="{{ route('tempat-duduk.index') }}/{{ $data->nomor_ruangan }}"><button
                                            type='button' class='btn btn-default bg-success btn-md'><i
                                                class="fa fa-print"></i></button></a>
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
{{-- <button class='btn btn-warning btn-sm' onclick='TempatDuduk()'><i class='fa fa-edit right'></i> Edit</button> --}}
{{--

 --}}

<script>
    function TempatDuduk(data) {
        var TempatDuduk = new bootstrap.Modal(document.getElementById('TempatDuduk'));
        TempatDuduk.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='TempatDuduk' tabindex='-1' aria-labelledby='LabelTempatDuduk' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelTempatDuduk'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <div class="col-xl-12">
                    @foreach ($paired_data as $ruang => $pairs)
                        <h3>Ruangan: {{ $ruang }}</h3>
                        <table id="example1" width="100%" class="table table-bordered table-hover">
                            <tr class='text-center table-success'>
                                <th class='text-center'>No</th>
                                <th class='text-center'>Nama Peserta</th>
                                <th class='text-center'>No Test</th>
                                <th class='text-center'>Kelas</th>
                                <th class='text-center'>Nama Peserta</th>
                                <th class='text-center'>No Test</th>
                                <th class='text-center'>Kelas</th>
                            </tr>
                            @foreach ($pairs as $pair)
                                <tr>
                                    <td class='text-center'>{{ $loop->iteration }}</td>
                                    <td class='text-center'>
                                        {{ $pair['first']->PesertaTestToDetailSiswa->nama_siswa }}</td>
                                    <td class='text-center'>{{ $pair['first']->nomor_test }}</td>
                                    <td class='text-center'>
                                        {{ $pair['first']->PesertaTestToKelas->kelas }}</td>

                                    <td class='text-center'>
                                        {{ $pair['second'] ? $pair['second']->PesertaTestToDetailSiswa->nama_siswa : '-' }}
                                    </td>
                                    <td class='text-center'>
                                        {{ $pair['second'] ? $pair['second']->nomor_test : '-' }}</td>
                                    <td class='text-center'>
                                        {{ $pair['second'] ? $pair['second']->PesertaTestToKelas->kelas : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @endforeach

                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                    <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                </div>
            </div>
        </div>

    </div>
