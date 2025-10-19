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


            <div class='row m-2'>
                <div class='col-xl-2'>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'> <i
                            class='fa fa-plus'></i> Tambah Data</button>
                </div>
                <div class='col-xl-10'></div>
            </div>


            <div class='ml-2 my-4'>
                <div class="col-xl-12">

                    <div class="col-xl-12">

                        @foreach ($group_by_ruang as $ruang => $siswa_list)
                            <!-- Header untuk Menampilkan Nama Ruangan -->
                            <x-kop-surat></x-kop-surat>
                            <h4 class='text-center'><b>DAFTAR HADIR</b></h4>
                            <h5 class='text-center'><b>RUANG {{ $ruang }}</b></h5>

                            <div class="page-break">
                                <table id="example1x" width="100%" class="table table-bordered table-hover">
                                    <thead>
                                        <tr class='text-center table-success'>
                                            <th>No</th>
                                            <th>NIS</th>
                                            <th>Nama</th>
                                            <th>Nomor Test</th>
                                            <th>Tanda Tangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($siswa_list as $index => $siswa)
                                            <tr>
                                                <td class='text-center'>{{ $index + 1 }}</td>
                                                <td class='text-center'>
                                                    {{ $siswa->PesertaTestToDetailSiswa->nis }}</td>
                                                <td class='text-left'>
                                                    {{ $siswa->PesertaTestToDetailSiswa->nama_siswa }}
                                                </td>
                                                <td class='text-center'>{{ $siswa->nomor_test }}</td>
                                                </td>
                                                <td class="{{ ($index + 1) % 2 == 0 ? 'text-right' : 'text-left' }}">
                                                    {{ $index + 1 }} {{ str_repeat('.', 30) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-2">
                                        Siswa Hadir <br>
                                        Siswa Tidak Hadir <br>
                                        Total Siswa <br>
                                    </div>
                                    <div class="col-8">
                                        :................................................ Siswa <br>
                                        :................................................ Siswa <br>
                                        :................................................ Siswa <br>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-1"></div>
                                <div class="col-xl-10 d-flex justify-content-between mx--5">
                                    <p>Kurikulum <br><br><br><br>( ............................ )</p>
                                    <p>Pengawas <br><br><br><br>( ............................ )</p>
                                </div>
                                <div class="col-xl-1"></div>

                            </div>
                            <hr class='bg-light' style='height: 3px;'>
                        @endforeach


                    </div>
                </div>
            </div>


        </div>

    </section>
</x-layout>
