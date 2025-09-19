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
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md'
                        onclick='ModalBeritaAcara()'> <i class='fa fa-plus'></i> Contoh Blanko</button>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md'><i
                            class="fa fa-print"></i> Bulk Blanko</button>
                </div>
                <div class='col-xl-10'></div>
            </div>


            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        {{-- Catatan :
                          - Include Komponen Modal CRUD + Javascript / Jquery
                          - Perbaiki Onclick Tombol Modal Create, Edit
                          - Variabel Active Crud menggunakan ID User
                           --}}
                        <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                            <thead>
                                <tr class='text-center'>
                                    <th  rowspan='2' width='1%'>ID</th>
                                    @foreach ($arr_ths as $arr_th)
                                        <th rowspan='2' class='text-center'> {{ $arr_th }}</th>
                                    @endforeach
                                    <th colspan='2'>Ceklist</th>
                                    <th rowspan='2' >Action</th>
                                </tr>
                                    <th>Absensi</th>
                                    <th>Keterangan</th>

                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        <td class='text-center'>{{ $loop->iteration }}</td>
                                        <td class='text-center'> {{ $data->nomor_ruangan }}</td>
                                        <td class='text-center'>
                                            {{ Carbon::create($data->tanggal_pelaksanaan)->translatedformat('l, d F Y') }}
                                        </td>
                                        <td class='text-center'> {{ $data->Mapel->mapel }}</td>
                                        <td class='text-center'> {{ $data->durasi }}"</td>
                                        <td class='text-center'> {{ $data->Guru->nama_guru }}</td>
                                        <td class='text-center'>
                                            @if (is_null($data->keterangan))
                                                <i class="fa fa-times-circle text-red-500 text-danger"></i>
                                            @else
                                                <i class="fa fa-check-circle text-success"></i>
                                            @endif
                                        </td>
                                        </td>
                                        <td class='text-center'>
                                            @if (is_null($data->keterangan))
                                                <i class="fa fa-times-circle text-red-500 text-danger"></i>
                                            @else
                                                <i class="fa fa-check-circle text-success"></i>
                                            @endif
                                        </td>
                                        <td width='10%'>
                                            <div class='gap-1 d-flex justify-content-center'>
                                                <!-- Button untuk mengedit -->
                                                <button type='button' class='btn btn-success btn-sm btn-equal-width'
                                                    data-toggle='modal' data-target='#viewModal{{ $data->id }}'><i
                                                        class='fa fa-eye'></i> </button>
                                                <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                                    data-toggle='modal' data-target='#editModal{{ $data->id }}'><i
                                                        class='fa fa-edit'></i> </button>
                                                <!-- Form untuk menghapus -->
                                                <form id='delete-form-{{ $data->id }}'
                                                    action='{{ route('berita-acara.destroy', $data->id) }}'
                                                    method='POST' style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type='button' class='btn btn-danger btn-sm btn-equal-width'
                                                    onclick='confirmDelete({{ $data->id }})'> <i
                                                        class='fa fa-trash'></i> </button>
                                            </div>
                                            {{-- Modal View Data Akhir --}}

                                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                                aria-labelledby='EditModalLabel' aria-hidden='true'>

                                                <x-edit-modal>
                                                    <x-slot:titleeditModal>{{ $titleeditModal }} Ruang {{ $data->nomor_ruangan }} - {{ $data->Mapel->mapel }}</x-slot:titleeditModal>
                                                    <section>
                                                        <form id='updateurl'
                                                            action='{{ route('berita-acara.update', $data->id) }}'
                                                            method='POST'>
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="card">
                                                                <div class='card-body'>
                                                                    <div class='form-group'>
                                                                        <!-- Jika menggunakan multiple select2 tambahkan id dengan id berbeda -->
                                                                        @php
                                                                            $siswaIdsx =
                                                                                json_decode(
                                                                                    $data->detailsiswa_id,
                                                                                    true,
                                                                                ) ?? [];
                                                                        @endphp
                                                                        {{-- blade-formatter-disable --}}
                                                                        <i class='fa fa-users'></i><label>Siswa Tidak Hadir</label>
                                                                        <select id='select2-{{ $loop->iteration }}' class='select2' name='detailsiswa_id[]' multiple='multiple' data-placeholder='Pilih siswa tidak hadir' style='width: 100%;'>
                                                                            <option value=''>--- Pilih Siswa Tidak
                                                                                Hadir ----</option>
                                                                            @foreach ($dataPesertas->where('nomor_ruangan', $data->nomor_ruangan) as $dataPeserta)
                                                                                <option
                                                                                    value='{{ $dataPeserta->detailsiswa_id }}'>
                                                                                    {{ $dataPeserta->Siswa->nama_siswa }}
                                                                                </option>
                                                                            @endforeach
                                                                            <script>
                                                                               $(document).ready(function() {
                                                                                   // $('#semesteredit option[value='II']').prop('selected', true); // Single Select
                                                                                   $('#select2-{{ $loop->iteration }}').val(@json($siswaIdsx)).trigger('change'); // Mutiple Select Select value in array json
                                                                               });
                                                                            </script>
                                                                        </select>
                                                                        {{-- blade-formatter-enable --}}
                                                                        <div class='form-group'>
                                                                            <i class='fas fa-sticky-note'></i><label
                                                                                for='keterangan'>Keterangan</label>
                                                                            <textarea name='keterangan' id='keterangan' rows='3' class='form-control'
                                                                                placeholder='Masukkan Keterangan Singkat'>{{ $data->keterangan }}</textarea>
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <button id='kirim' type='submit'
                                                                class='btn float-right btn-default bg-primary btn-xl mt-4'>
                                                                Kirim</button>
                                                        </form>

                                                    </section>
                                                </x-edit-modal>
                                            </div>
                                            {{-- Modal Edit Data Akhir --}}
                                            {{-- Modal View --}}

                                            <div class='modal fade' id='viewModal{{ $data->id }}' tabindex='-1'
                                                aria-labelledby='ViewModalLabel' aria-hidden='true'>
                                                <x-view-modal>
                                                    <x-slot:titleviewModal>{{ $titleviewModal }}</x-slot:titleviewModal>
                                                    <section>
                                                        <style>
                                                            .data-berita-acara {
                                                                line-height: 45px;
                                                            }
                                                        </style>
                                                        @php
                                                            $find_Etaples = App\Models\Admin\Etapel::where(
                                                                'aktiv',
                                                                'Y',
                                                            )->first();
                                                            // dd($find_Etaples);
                                                        @endphp
                                                        <h3>Berita Acara</h3>
                                                        <div class="data-berita-acara col-xl-12">
                                                            <x-kop-surat></x-kop-surat>
                                                            <div class="col-xl-12 mb-2">
                                                                <h4 class="text-center mt-3"><b>BERITA ACARA
                                                                        TEST</b></h4>
                                                                <h5 class="text-center"><b>TAHUN PELAJARAN
                                                                        {{ $find_Etaples->tapel }} -
                                                                        {{ $find_Etaples->tapel + 1 }}</b></h5>
                                                            </div>
                                                            <div class="col-xl-12 mb-2 mt-4">

                                                                <p>Pada Hari <b>
                                                                        {{ \Carbon\Carbon::parse($data->tanggal_pelaksanaan)->translatedFormat('l') }}</b>
                                                                    anggal
                                                                    <b>{{ \Carbon\Carbon::parse($data->tanggal_pelaksanaan)->translatedFormat('d M Y') }}</b>
                                                                    telah dilaksanakan test
                                                                    {{ $data->Mapel->mapel }} tahun pelajaran
                                                                    {{ $find_Etaples->tapel }} -
                                                                    {{ $find_Etaples->tapel + 1 }} dengan rincian
                                                                    sebagai berikut :
                                                                </p>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-xl-4 mb-2">
                                                                    <p>
                                                                        Mata Pelajaran <br>
                                                                        Ruang <br>
                                                                        Tanggal Ujian <br>
                                                                        Waktu Ujian <br>
                                                                        Jumlah Peserta Seharusnya <br>
                                                                        Peserta Tidak Hadir <br>
                                                                    </p>
                                                                </div>
                                                                <div class="col-xl-8">
                                                                    <p>
                                                                        @php
                                                                            $PesertaSeharusnya = App\Models\WakaKurikulum\Perangkat\PesertaTest::where(
                                                                                'nomor_ruangan',
                                                                                $data->nomor_ruangan,
                                                                            )->count();
                                                                        @endphp
                                                                        : {{ $data->Mapel->mapel }} <br>
                                                                        : {{ $data->nomor_ruangan }} <br>
                                                                        :
                                                                        {{ \Carbon\Carbon::parse($data->tanggal_pelaksanaan)->translatedFormat('l, d M Y') }}
                                                                        <br>
                                                                        : {{ $data->durasi }} <br>

                                                                        : {{ $PesertaSeharusnya }} <br>
                                                                        :
                                                                        {{-- @php
                                                                            $siswaIds = json_decode( $data->detailsiswa_id, true, ); // Ubah JSON menjadi array
                                                                            dump($siswaIds);
                                                                        @endphp --}}

                                                                        {{-- blade-formatter-disable --}}
                                                                        @php
                                                                            $siswaIds = json_decode( $data->detailsiswa_id,  true,) ?? []; // Pastikan array
                                                                            $Siswas = [];
                                                                            if (!empty($siswaIds) && is_array($siswaIds) ) {
                                                                                $Siswas = App\Models\WakaKurikulum\Perangkat\PesertaTest::whereIn(
                                                                                    'id',
                                                                                    $siswaIds,
                                                                                )->get();
                                                                            }
                                                                        @endphp
                                                                        @if (empty($siswaIds))
                                                                        -
                                                                        @else
                                                                            {{count($siswaIds)}} Siswa <br>
                                                                        @endif
                                                                        @foreach ($Siswas as $index => $Siswa)
                                                                               {{ $Siswa->Siswa->nama_siswa ?? '-' }}{{ $index < $Siswas->count() - 1 ? ', ' : '' }}
                                                                        @endforeach

                                                                       {{-- blade-formatter-enable --}}
                                                                        <br>
                                                                    </p>
                                                                    <br>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-xl-3 mb-2">
                                                                    <b>Pengawas Test : </b> <br>
                                                                    Pengawas 1 <br>
                                                                    Pengawas 2 <br>
                                                                </div>
                                                                <div class="col-xl-4">
                                                                    {{-- blade-formatter-disable --}}
                                                                        <b>Nama Pengawas</b> <br>
                                                                        : {{ $data->Guru->nama_guru }} <br>
                                                                        : ..........................<br>
                                                                        {{-- blade-formatter-enable --}}
                                                                </div>
                                                                <div class="col-xl-5">
                                                                    {{-- blade-formatter-disable --}}
                                                                        <b>Tanda Tangan</b> <br>
                                                                        : .......................... <br>
                                                                        : ..........................<br>
                                                                        {{-- blade-formatter-enable --}}
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12 mb-2">
                                                                <p>Hal hal yang terjadi dalam pelaksanaan test
                                                                    berlangsung sebagai berikut :</p>
                                                                <div class="col-xl-12">
                                                                    {{ $data->keterangan ??
                                                                        '.............................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................' }}<br><br>

                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12 d-flex justify-content-between">
                                                                <div class="col-xl-4"></div>
                                                                <div class="col-xl-8 d-flex justify-content-between">
                                                                    <p></p>
                                                                    <p>Banjarharjo,
                                                                        {{ \Carbon\Carbon::parse($data->tanggal_pelaksanaan)->translatedFormat('d M Y') }}<br>Kepala
                                                                        Sekolah
                                                                        <br><br><br><br>Farid Attallah
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
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
                                    <th>Absensi</th>
                                    <th>Keterangan</th>
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

{{-- <button class='btn btn-warning btn-sm' onclick='ModalBeritaAcara()'><i class='fa fa-edit right'></i> Edit</button> --}}
{{--
onclick='ModalBeritaAcara()'
 --}}

<script>
    function ModalBeritaAcara(data) {
        var ModalBeritaAcara = new bootstrap.Modal(document.getElementById('ModalBeritaAcara'));
        ModalBeritaAcara.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='ModalBeritaAcara' tabindex='-1' aria-labelledby='LabelModalBeritaAcara'
    aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelModalBeritaAcara'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <style>
                    .data-berita-acara {
                        line-height: 45px;
                    }
                </style>
                @php
                    $find_Etaples = App\Models\Admin\Etapel::where('aktiv', 'Y')->first();
                    // dd($find_Etaples);
                @endphp
                <h3>Berita Acara</h3>
                <div class="data-berita-acara col-xl-12">
                    <x-kop-surat></x-kop-surat>
                    <div class="col-xl-12 mb-2">
                        <h4 class="text-center mt-3"><b>BERITA ACARA TEST</b></h4>
                        <h5 class="text-center"><b>TAHUN PELAJARAN {{ $find_Etaples->tapel }} -
                                {{ $find_Etaples->tapel + 1 }}</b></h5>
                    </div>
                    <div class="col-xl-12 mb-2 mt-4">

                        <p>Pada Hari ................ Tanggal ........................ telah
                            dilaksanakan test ................... tahun pelajaran
                            {{ $find_Etaples->tapel }} dengan rincian sebagai berikut :</p>
                    </div>
                    <div class="row mb-2">
                        <div class="col-xl-4 mb-2">
                            <p>
                                Mata Pelajaran <br>
                                Ruang <br>
                                Tanggal Ujian <br>
                                Waktu Ujian <br>
                                Peserta Tidak Hadir <br>
                                Jumlah Peserta Seharusnya <br>
                            </p>
                        </div>
                        <div class="col-xl-8">
                            {{-- blade-formatter-disable --}}
                                            <p>
                                                : .......................................................................................... <br>
                                                : .......................................................................................... <br>
                                                : .......................................................................................... <br>
                                                : .......................................................................................... <br>
                                                : .......................................................................................... <br>
                                                : .......................................................................................... <br>
                                            </p>
                                            {{-- blade-formatter-enable --}}
                            <br>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-xl-4 mb-2">
                            <b>Pengawas Test : </b> <br>
                            Pengawas 1 <br>
                            Pengawas 2 <br>
                        </div>
                        <div class="col-xl-8">
                            {{-- blade-formatter-disable --}}
                                            Tanda Tangan <br>
                                            : .......................................................................................... <br>
                                            : .......................................................................................... <br>
                                            {{-- blade-formatter-enable --}}
                        </div>
                    </div>
                    <div class="col-xl-12 mb-2">
                        <p>Hal hal yang terjadi dalam pelaksanaan test berlangsung sebagai berikut :</p>
                        <div class="col-xl-12">
                            .............................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................

                        </div>
                    </div>
                    <div class="col-xl-12 d-flex justify-content-between">
                        <div class="col-xl-4"></div>
                        <div class="col-xl-8 d-flex justify-content-between">
                            <p></p>
                            <p>Kepala Sekolah <br>Banjarharjo, 2 September {{ date('Y') }}
                                <br><br><br><br>Farid Attallah
                            </p>
                        </div>
                    </div>
                </div>

            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
            </div>
        </div>
    </div>

</div>
