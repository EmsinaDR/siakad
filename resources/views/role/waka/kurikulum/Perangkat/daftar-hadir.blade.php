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
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'> <i class='fa fa-print'></i> Bulk Print Data</button>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TemplateA()'> <i class='fa fa-eye'></i> Tempale A Data</button>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TemplateB()'> <i class='fa fa-eye'></i> Tempale B Data</button>
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
                                    <button type='button' class='btn btn-default bg-success btn-md'><i
                                            class="fa fa-print"></i></button>
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
{{-- <button class='btn btn-warning btn-sm' onclick='TemplateA()'><i class='fa fa-edit right'></i> Edit</button> --}}
{{--

 --}}

<script>
    function TemplateA(data) {
        var TemplateA = new bootstrap.Modal(document.getElementById('TemplateA'));
        TemplateA.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='TemplateA' tabindex='-1' aria-labelledby='TemplateA' aria-hidden='true'>
    <div class='modal-dialog modal-xl'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='TemplateA'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                @php
                    $etapels = App\Models\Admin\Etapel::where('aktiv', 'Y')->first();
                    $pesertaTest = App\Models\WakaKurikulum\Perangkat\PesertaTest::where('nomor_ruangan', 1)->get();
                @endphp
                <!-- Header untuk Menampilkan Nama Ruangan -->
                <x-kop-surat></x-kop-surat>
                <h4 class='text-center'><b>DAFTAR HADIR</b></h4>
                <table id='example1' width='100%' class='table table-bordered table-hover'>
                    <thead>
                        <tr class='text-center align-middle'>
                            <th class='align-middle text-center' rowspan='2'>ID</th>
                            <th class='align-middle text-center' rowspan='2'>No Test</th>
                            <th class='align-middle text-center' rowspan='2'>Nama Siswa</th>
                            <th class='align-middle text-center' colspan='{{ $MeplTest + 1 }}'>Tanda Tangan</th>
                        </tr>
                        @for ($i = 1; $i < $MeplTest + 1; $i++)
                            <th class='align-middle text-center'>{{ $i }}</th>
                        @endfor

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pesertaTest as $data)
                            <tr>
                                <td class='align-middle text-center'>{{ $loop->iteration }}</td>
                                <td class='align-middle text-center'>{{ $data->nomor_test }}</td>
                                <td>{{ $data->Siswa->nama_siswa }}</td>
                                @for ($i = 1; $i < $MeplTest + 1; $i++)
                                    <td> </td>
                                @endfor

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="col-xl-12 mb-4">
                    <div class="row">
                        <div class="col-xl-1"></div>
                        <div class="col-xl-10 d-flex justify-content-between mx--5">
                            <p>Kurikulum <br><br><br><br>( ............................ )</p>
                            <p>Pengawas <br><br><br><br>( ............................ )</p>
                        </div>
                        <div class="col-xl-1"></div>

                    </div>
                    <hr class='bg-light' style='height: 3px;'>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    function TemplateB(data) {
        var TemplateB = new bootstrap.Modal(document.getElementById('TemplateB'));
        TemplateB.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='TemplateB' tabindex='-1' aria-labelledby='LabelTemplateB' aria-hidden='true'>
    <div class='modal-dialog modal-xl'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelTemplateB'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <div class="col-xl-12">

                    <!-- Header untuk Menampilkan Nama Ruangan -->
                    <x-kop-surat></x-kop-surat>
                    <h4 class='text-center'><b>DAFTAR HADIR</b></h4>

                    <div class="row my-3">
                        <div class="col-xl-3">
                            Nama Pengawas <br>
                            Ruang <br>

                        </div>
                        <div class="caol-xl-5">
                            : Dany Rosepta <br>
                            : 1
                        </div>
                    </div>
                    <div class="page-break">
                        <table id="example1x" width="100%" class="table table-bordered table-hover">
                            <thead>
                                <tr class='text-center table-success'>
                                    <th>No</th>
                                    <th>Nomor Test</th>
                                    <th>Nama</th>
                                    <th>Tanda Tangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pesertaTest as $siswa_list)
                                    <tr>
                                        <td class='text-center'>{{ $loop->iteration }}</td>
                                        <td class='text-center'>
                                            {{ $siswa_list->nomor_test }}</td>
                                        <td class='text-left'>
                                            {{ $siswa_list->Siswa->nama_siswa }}
                                        </td>
                                        <td class="{{ $loop->iteration % 2 == 0 ? 'text-right' : 'text-left' }}">
                                            {{ $loop->iteration }} {{ str_repeat('.', 30) }}
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


                </div>

            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
            </div>
        </div>
    </div>

</div>
