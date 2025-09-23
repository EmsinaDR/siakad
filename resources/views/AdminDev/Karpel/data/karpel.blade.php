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
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal'
                        data-target='#GenerateKartuGuru'><i class='fa fa-plus'></i> Generate K. Guru</button>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal'
                        data-target='#GenerateKartuSiswa'><i class='fa fa-plus'></i> Generate Kartu Siswa</button>

                    <button type="button" class="btn btn-block btn-default bg-secondary btn-md"
                        onclick='window.location.href="{{ route('tokenapp.index') }}"'>
                        <i class="fa fa-undo"></i> Kembali
                    </button>
                </div>
                <div class='col-xl-10'></div>
            </div>
            <div class="row p-2">
                <div class="col-xl-12">

                </div>
            </div>


            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>Data Kartu</h3>
                    </div>
                    <div class='card-body'>
                        <div class="row">
                            <div class="col-xl-6">xxxxxxx</div>
                            <div class="col-xl-6">
                                <table id='example1' width='100%' class='table table-bordered table-hover'>
                                    <thead>
                                        <tr class='table-primary text-center align-middle'>
                                            <th>ID</th>
                                            <th>Data</th>
                                            <th>Jumlah</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class='text-center'>1</td>
                                            <td class='text-center'>Guru</td>
                                            <td class='text-center'>{{ $Gurus->count() }} Orang</td>
                                            <td class='text-center'>Rp. {{ number_format($Gurus->count() * 18000, 2) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class='text-center'>2</td>
                                            <td class='text-center'>Siswa</td>
                                            <td class='text-center'>{{ $Siswas->count() }} Orang</td>
                                            <td class='text-center'>Rp. {{ number_format($Siswas->count() * 18000, 2) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class='table-primary text-center align-middle'>
                                            <th>ID</th>
                                            <th>Data</th>
                                            <th>Jumlah</th>
                                            <th>Total</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </section>
</x-layout>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='GenerateKarpel' tabindex='-1' aria-labelledby='LabelGenerateKarpel' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelGenerateKarpel'>
                    Generate Karpel
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <form id='GenerateKarpel-form' action='{{ route('generate.karpel') }}' method='POST'>
                    @csrf
                    @method('POST')

                    <div class='form-group'>
                        <label for='halaman_siswa'>Pilih Halaman Siswa</label>
                        <select name='halaman_siswa' id='halaman_siswa' class='select2 form-control' required>
                            <option value=''>--- Pilih Halaman ---</option>

                            @foreach ($Siswas->chunk(10) as $index => $chunk)
                                <option value='{{ $chunk->pluck('id')->sort()->join(',') }}'>
                                    Halaman {{ $index + 1 }}
                                </option>
                            @endforeach
                        </select>
                    </div>
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

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='GenerateKartuGuru' tabindex='-1' aria-labelledby='LabelGenerateKartuGuru'
    aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelGenerateKartuGuru'>
                    Generate Kartu Guru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <form id='GenerateKartuGuru-form' action='{{ route('generate.kartu.guru') }}' method='POST'>
                    @csrf
                    @method('POST')
                    {{-- <div class='form-group'>
                        <label for='detailguru_id'>Data Guru</label>
                        <select name='detailguru_id[]' id='detailguru_id' multiple
                            data-placeholder='Pilih Data Data Guru' class='select2 form-control' required>
                            <option value=''>--- Pilih Data Guru ---</option>
                            @foreach ($Gurus as $newGurus)
                                <option value='{{ $newGurus->id }}'>{{ $newGurus->nama_guru }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    {{-- <div class='form-group'>
                        <label for='detailguru_id'>Data Guru</label>
                        <select name='detailguru_id[]' id='detailguru_id' multiple data-placeholder='Pilih Data Guru'
                            class='select2 form-control' required>
                            <option value=''>--- Pilih Data Guru ---</option>

                            @foreach ($Gurus->chunk(10) as $index => $chunk)
                                <optgroup label="Halaman {{ $index + 1 }}">
                                    @foreach ($chunk as $guru)
                                        <option value='{{ $guru->id }}'>{{ $guru->nama_guru }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div> --}}
                    <div class='form-group'>
                        <label for='halaman_guru'>Pilih Halaman Guru</label>
                        <select name='halaman_guru' id='halaman_guru' class='select2 form-control' required>
                            <option value=''>--- Pilih Halaman ---</option>

                            @foreach ($Gurus->chunk(10) as $index => $chunk)
                                <option value='{{ $chunk->pluck('id')->sort()->join(',') }}'>
                                    Halaman {{ $index + 1 }}
                                </option>
                            @endforeach
                        </select>
                    </div>


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

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='GenerateKartuSiswa' tabindex='-1' aria-labelledby='LabelGenerateKartuSiswa'
    aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelGenerateKartuSiswa'>
                    Generate Kartu Siswa
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <form id='GenerateKartuSiswa-form' action='{{ route('all.in.kartu') }}' method='POST'>
                    @csrf
                    @method('POST')
                    @php
                        $kartus = ['Kartu Pelajar', 'Kartu NISN', 'Kartu Pembayaran', 'Kartu Perpustakaan'];
                        $Templates = range(1, 10);
                    @endphp
                    <div class='form-group'>
                        <label for='jenis_kartu'>Jenis Kartu</label>
                        <select name='jenis_kartu' id='id' class='select2 form-control' required>
                            <option value=''>--- Pilih Jenis Kartu ---</option>
                            @foreach ($kartus as $kartu)
                                <option value='{{ $kartu }}'>{{ $kartu }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='form-group'>
                        <label for='template_id'>Template</label>
                        <select name='template_id' id='id' class='select2 form-control' required>
                            <option value=''>--- Pilih Template ---</option>
                            @foreach ($Templates as $Template)
                                <option value='{{ $Template }}'>Template {{ $Template }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='form-group'>
                        <label for='halaman_siswa'>Pilih Halaman Siswa</label>
                        <select name='halaman_siswa' id='halaman_siswa' class='select2 form-control' required>
                            <option value=''>--- Pilih Halaman ---</option>
                            @foreach ($Siswas->chunk(10) as $index => $chunk)
                                <option value='{{ $chunk->pluck('id')->sort()->join(',') }}'>
                                    Halaman {{ $index + 1 }}
                                </option>
                            @endforeach
                        </select>
                    </div>

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
