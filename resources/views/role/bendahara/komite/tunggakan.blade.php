<x-layout>
    @php
        $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
        $urlroot = app('request')->root();
    @endphp
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
            <div class='card-body'>
                <div class='row float-right'>
                    <x-btnjs>submit/Tambah Data/fa fa-plus/btn btn-primary btn-xl bg-primary
                        btn-app/FNnamaModal()()</x-btnjs>
                </div>
            </div>
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->


            <div class='ml-2 my-4'>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="row p-2">
                            <div class="col-xl-3">
                                <div class='card-header bg-primary'>
                                    <h3 class='card-title'><i class="fa fa-search mr-2"></i>Cari Data Siswa</h3>
                                </div>
                                <form id='#id' action='{{ route('TunggakanSiswa') }}' method='POST'>
                                    @csrf
                                    @method('POST')
                                    {{-- blade-formatter-disable --}}
                                    <div class='form-group mt-2'>
                                        <label for='detailsiswa_id'>Nama Siswa</label>
                                        {{-- <select name='detailsiswa_id' class='form-control' required> --}}
                                        <select id='id_siswa1' name='detailsiswa_id' class='form-control' data-placeholder='Masukkan Nama Siswa' style='width: 100%;'>
                                            <option value=''>--- Pilih Nama Siswa ---</option>
                                            @foreach ($data_siswa as $newkey)
                                                <option value='{{ $newkey->id }}'> {{ $newkey->DetailsiswaToKelas->kelas }} - {{ $newkey->nama_siswa }} - {{ $newkey->tingkat_id }} - {{ $newkey->id }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type='Submit' class='btn btn-default bg-primary btn-xl float-right'>Kirim</button>
                                    {{-- blade-formatter-enable --}}
                                </form>
                            </div>
                            {{-- {{dd(request('tingkat_id'))}} --}}
                            @if (request('detailsiswa_id') !== null)
                                {{-- blade-formatter-disable --}}
                                @php
                                    $tapelid_skrg = App\Models\Admin\Etapel::where('aktiv', 'Y')->first();
                                    $tapelid_skrg = $tapelid_skrg->id;
                                    $find_Detailsiswa = App\Models\User\Siswa\Detailsiswa::find(request('detailsiswa_id'));
                                    $data_pembayaranvii_i = App\Models\bendahara\KeuanganRiwayatList::where('tapel_id', $tapelid_skrg - 5)
                                        ->where('tingkat_id', $find_Detailsiswa->Detailsiswatokelas->tingkat_id - 2)
                                        ->where('semester', 'I')
                                        ->get();
                                        // dump($data_pembayaranvii_i, $tapelid_skrg);
                                    $data_pembayaranvii_ii = App\Models\bendahara\KeuanganRiwayatList::where('tapel_id', $tapelid_skrg - 4) //7
                                        ->where('tingkat_id', $find_Detailsiswa->Detailsiswatokelas->tingkat_id - 2)
                                        ->where('semester', 'II')
                                        ->get();
                                    $data_pembayaranviii_i = App\Models\bendahara\KeuanganRiwayatList::where('tapel_id', $tapelid_skrg - 3) //8
                                        ->where('tingkat_id', $find_Detailsiswa->Detailsiswatokelas->tingkat_id - 1)
                                        ->where('semester', 'I')
                                        ->get();
                                    $data_pembayaranviii_ii = App\Models\bendahara\KeuanganRiwayatList::where(
                                        'tapel_id',
                                        $tapelid_skrg - 2,
                                    ) //8
                                        ->where('tingkat_id', $find_Detailsiswa->Detailsiswatokelas->tingkat_id - 1)
                                        ->where('semester', 'II')
                                        ->get();
                                    $data_pembayaranix_i = App\Models\bendahara\KeuanganRiwayatList::where(
                                        'tapel_id',
                                        $tapelid_skrg - 1,
                                    ) //9
                                        ->where('tingkat_id', $find_Detailsiswa->Detailsiswatokelas->tingkat_id)
                                        ->where('semester', 'I')
                                        ->get();
                                    $data_pembayaranix_ii = App\Models\bendahara\KeuanganRiwayatList::where(
                                        'tapel_id',
                                        $tapelid_skrg,
                                    ) //9
                                        ->where('tingkat_id', $find_Detailsiswa->Detailsiswatokelas->tingkat_id)
                                        ->where('semester', 'II')
                                        ->get();
                                    $find_KeuanganKomite = App\Models\bendahara\BendaharaKomite::where(
                                        'detailsiswa_id',
                                        3,
                                    )->sum('nominal');
                                    $looper = 1;
                                @endphp

                                <div class="col-xl-9">
                                    {{-- blade-formatter-disable --}}
                                    <div class="row mb-4">
                                        <div class="col-xl-1"></div>
                                        <div class="col-xl-2 p-2 d-flex justify-content-center">
                                            <img src='{{ app('request')->root() }}/img/siswa/user-siswa.png' alt='#' style='width:200px;heght:auto'>
                                        </div>
                                        <div class="col-xl-1"></div>
                                        <div class="col-xl-8 p-2">
                                            <div class='card-header bg-primary'>
                                                <h3 class='card-title'>Data Siswa</h3>
                                            </div>
                                            <x-inputallin>readonly:Nama Siswa:Nama Siswa:nama_siswa:id_nama_siswa:{{ $find_Detailsiswa->nama_siswa }}:readonly</x-inputallin>
                                            <x-inputallin>readonly:NIS:NIS:nis:id_nis:{{ $find_Detailsiswa->nis }}:readonly</x-inputallin>
                                            <x-inputallin>readonly:Kelas:Kelas:kelas_id:id_kelas_id:{{ $find_Detailsiswa->Detailsiswatokelas->kelas }}:readonly</x-inputallin>
                                        </div>
                                        <div class="col-xl-2"></div>

                                    </div>
                                    {{-- blade-formatter-enable --}}
                        </div>

                    </div>
                    <hr class="rounded-pill border-2 border-primary" />
                    <table id='example1' width='100%' class='table table-bordered table-hover'>
                        <thead>
                            <tr class='text-center align-middle'>
                                <th width='1%'>ID</th>
                                <th width='5%'>Semester</th>
                                <th width='5%'>Tingkat</th>
                                <th>Jenis Pembayaran</th>
                                <th width='5%'>Nominal</th>
                                <th width='5%'>Terbayar</th>
                                <th width='15%'>Sisa</th>
                                <th width='15%'>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Data Semester 1 --}}
                            @if ($data_pembayaranvii_i !== null)
                                @foreach ($data_pembayaranvii_i as $dataPembayaranpembayaranvii_i)
                                    <tr>
                                        {{-- blade-formatter-disable --}}
                                            <td class='text-center'>{{ $looper++ }}</td>
                                            <td class='text-center'>
                                                @if ($dataPembayaranpembayaranvii_i->semester !== null)
                                                    {{ $dataPembayaranpembayaranvii_i->tapel_id }} / {{ $dataPembayaranpembayaranvii_i->semester }}
                                                @else
                                                @endif
                                            </td>
                                            <td class='text-center'>
                                                @if ($dataPembayaranpembayaranvii_i->tingkat_id !== null)
                                                    {{ $dataPembayaranpembayaranvii_i->tingkat_id }}
                                                @else
                                                @endif
                                            </td>
                                            <td class='text-left'>
                                                {{ $dataPembayaranpembayaranvii_i->jenis_pembayaran }}
                                                @php
                                                    $total_data_pembayaranvii_i = App\Models\Bendahara\BendaharaKomite::where('pembayaran_id',$dataPembayaranpembayaranvii_i->id)
                                                        ->where('tapel_id', $tapelid_skrg - 5)
                                                        ->where('semester', 'I')
                                                        ->where('detailsiswa_id', request('detailsiswa_id'))
                                                        ->sum('nominal');
                                                @endphp
                                            </td>
                                            <td class='text-center'>Rp. {{ Number_format($dataPembayaranpembayaranvii_i->nominal, 0) }}</td>
                                            <td class='text-center'>
                                                @if ($total_data_pembayaranvii_i !== null)
                                                    Rp. {{ number_format($total_data_pembayaranvii_i, 0)}}
                                                @else
                                                @endif
                                            </td>
                                            <td class='text-center'>
                                                @if ($dataPembayaranpembayaranvii_i->nominal - $total_data_pembayaranvii_i !== 0)
                                                   Rp. {{ number_format($dataPembayaranpembayaranvii_i->nominal - $total_data_pembayaranvii_i, 0)}}
                                                @else
                                                    <span class="bg-success p-1"> <i class="fa fa-check mr-2"></i>Lunas</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($dataPembayaranpembayaranvii_i->nominal - $total_data_pembayaranvii_i !== 0)
                                                    <div class='gap-1 d-flex justify-content-center'>
                                                        <!-- Button untuk melihat -->
                                                        <button type='button' class='btn btn-success btn-sm mr-2' data-toggle='modal' data-target='#viewModal{{ $dataPembayaranpembayaranvii_i->id }}'> <i class='fa fa-eye'></i> </button>
                                                        <!-- Button untuk mengedit -->
                                                        <button type='button' class='btn btn-warning btn-sm mr-2' data-toggle='modal' data-target='#editModal{{ $dataPembayaranpembayaranvii_i->id }}'> <i class='fa fa-plus-square'></i></button>
                                                    </div>
                                                @else
                                                @endif
                                            </td>
                                        </tr>
                                            {{-- blade-formatter-enable --}}
                                        {{-- Modal View Data Akhir --}}
                                        <div class='modal fade' id='editModal{{ $dataPembayaranpembayaranvii_i->id }}'
                                            tabindex='-1' aria-labelledby='EditModalLabel' aria-hidden='true'>
                                            <x-edit-modal>
                                                <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                <section>
                                                    <form id='updateEdata'
                                                        action='{{ route('PembayaranTunggakanKomite') }}'
                                                        method='POST'>
                                                        @csrf
                                                        @method('POST')
                                                        {{-- blade-formatter-disable --}}
                                                        <div class="row">
                                                            <div class="col-xl-12">
                                                                <input type='hidden' name='tapel_id' id='tapel_id' placeholder='tapel_id' value='{{ $dataPembayaranpembayaranvii_i->tapel_id }}'>
                                                                <input type='hidden' name='detailsiswa_id' id='detailsiswa_id' placeholder='detailsiswa_id' value='{{ $find_Detailsiswa->id }}'>
                                                                <input type='hidden' name='pembayaran_id' id='pembayaran_id' placeholder='pembayaran_id' value='{{ $dataPembayaranpembayaranvii_i->id }}'>
                                                                <x-inputallin>readonly:Nama Siswa:Nama Siswa:nama_siswa:id_nama_siswa:{{ $find_Detailsiswa->nama_siswa }}:reado nly</x-inputallin>
                                                                <x-inputallin>hidden:::detailsiswa_id:detailsiswa_id:{{ $find_Detailsiswa->id }}:readonly</x-inputallin>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <x-inputallin>readonly:NIS:NIS:nis:id_nis:{{ $find_Detailsiswa->nis }}:readonly</x-inputallin>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <x-inputallin>readonly:Kelas:Kelas:kelas:kelas:{{ $find_Detailsiswa->Detailsiswatokelas->kelas }}:readonly</x-inputallin>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <x-inputallin>readonly:Tingkat:Tingkat:tingkat_id:id_tingkat_id:{{ $dataPembayaranpembayaranvii_i->tingkat_id }}:readonly</x-inputallin>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <x-inputallin>readonly:Semester:Semester:semester:semester:{{ $dataPembayaranpembayaranvii_i->semester }}:readonly</x-inputallin>
                                                            </div>
                                                        </div>
                                                        <x-inputallin>readonly:Jenis Pembyaran:Jenis Pembayaran:jenis_pembayaran:id_jenis_pembayaran:{{ $dataPembayaranpembayaranvii_i->jenis_pembayaran }}:readonly</x-inputallin>
                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <x-inputallin>readonly:Nominal Terbayar:Nominal Terbayar::id_nominal:{{ number_format($total_data_pembayaranvii_i, 0)}}:readonly</x-inputallin>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <x-inputallin>type:Nominal Bayar:Nominal Terbayar:nominal:id_nominal::Required</x-inputallin>
                                                            </div>
                                                        </div>
                                                        <x-inputallin>textarea:Keterangan:Keterangan data:keterangan:id_keterangan:{{ $dataPembayaranpembayaranvii_i->keterangan }}:Required</x-inputallin>

                                                        <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'> Kirim</button>
                                                        {{-- blade-formatter-enable --}}
                                                    </form>

                                                </section>
                                            </x-edit-modal>
                                        </div>
                                        {{-- Modal Edit Data Akhir --}}
                                        {{-- Modal View --}}
                                        <div class='modal fade' id='viewModal{{ $dataPembayaranpembayaranvii_i->id }}'
                                            tabindex='-1' aria-labelledby='ViewModalLabel' aria-hidden='true'>

                                            <x-view-modal>
                                                <x-slot:titleviewModal>{{ $titleviewModal }}</x-slot:titleviewModal>
                                                <section>
                                                    //Content View
                                                </section>
                                            </x-view-modal>
                                        </div>
                                        {{-- Modal View Akhir --}}
                                    </tr>
                                @endforeach
                            @else
                            @endif
                            {{-- Data Semester 1 --}}

                            {{-- Data Semester 2 --}}
                            @if ($data_pembayaranvii_ii !== null)
                                @foreach ($data_pembayaranvii_ii as $dataPembayaranpembayaranvii_ii)
                                    {{-- blade-formatter-disable --}}
                                    <tr>
                                        <td class='text-center'>{{ $looper++ }}</td>
                                        <td class='text-center'>
                                            @if ($dataPembayaranpembayaranvii_ii->semester !== null)
                                                {{ $dataPembayaranpembayaranvii_ii->tapel_id }}/{{ $dataPembayaranpembayaranvii_ii->semester }}
                                            @else
                                            @endif
                                        </td>
                                        <td class='text-center'>
                                            @if ($dataPembayaranpembayaranvii_ii->tingkat_id !== null)
                                                {{ $dataPembayaranpembayaranvii_ii->tingkat_id }}
                                            @else
                                            @endif
                                        </td>
                                        <td class='text-left'>
                                            {{ $dataPembayaranpembayaranvii_ii->jenis_pembayaran }}
                                            @php
                                                $total_data_pembayaranvii_ii = App\Models\Bendahara\BendaharaKomite::where('pembayaran_id',$dataPembayaranpembayaranvii_ii->id)
                                                    ->where('tapel_id', $tapelid_skrg - 4)
                                                    ->where('semester', 'II')
                                                    ->where('detailsiswa_id', request('detailsiswa_id'))
                                                    ->sum('nominal');
                                            @endphp
                                        </td>
                                        <td class='text-center'>Rp. {{ Number_format($dataPembayaranpembayaranvii_ii->nominal, 0) }}
                                        <td class='text-center'>
                                            @if ($total_data_pembayaranvii_ii !== null)
                                                Rp. {{ number_format($total_data_pembayaranvii_ii, 0)}}
                                            @else
                                            @endif
                                        </td>
                                        <td class='text-center'>
                                            @if ($dataPembayaranpembayaranvii_ii->nominal - $total_data_pembayaranvii_ii !== 0)
                                                Rp. {{ Number_format($dataPembayaranpembayaranvii_ii->nominal - $total_data_pembayaranvii_ii, 0) }}
                                            @else
                                                <span class="bg-success p-1"> <i class="fa fa-check mr-2"> </i>Lunas</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if ($dataPembayaranpembayaranvii_ii->nominal - $total_data_pembayaranvii_ii !== 0)
                                                <div class='gap-1 d-flex justify-content-center'>
                                                    <!-- Button untuk melihat -->
                                                    <button type='button' class='btn btn-success btn-sm mr-2' data-toggle='modal' data-target='#viewModal{{ $dataPembayaranpembayaranvii_ii->id }}'><i class='fa fa-eye'></i></button>
                                                    <!-- Button untuk mengedit -->
                                                    <button type='button' class='btn btn-warning btn-sm mr-2' data-toggle='modal' data-target='#editModal{{ $dataPembayaranpembayaranvii_ii->id }}'><i class='fa fa-plus-square'></i></button>
                                                </div>
                                            @else
                                            @endif
                                        </td>
                                    </tr>
                                    {{-- blade-formatter-enable --}}
                                    {{-- Modal View Data Akhir --}}
                                    <div class='modal fade' id='editModal{{ $dataPembayaranpembayaranvii_ii->id }}'
                                        tabindex='-1' aria-labelledby='EditModalLabel' aria-hidden='true'>
                                        <x-edit-modal>
                                            <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                            <section>
                                                {{-- blade-formatter-disable --}}
                                                <form id='updateEdata'
                                                    action='{{ route('PembayaranTunggakanKomite') }}' method='POST'>
                                                    @csrf
                                                    @method('POST')
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                                <input type='hidden' name='tapel_id' id='tapel_id' placeholder='tapel_id' value='{{ $dataPembayaranpembayaranvii_ii->tapel_id }}'>
                                                                <input type='hidden' name='detailsiswa_id' id='detailsiswa_id' placeholder='detailsiswa_id' value='{{ $find_Detailsiswa->id }}'>
                                                            <x-inputallin>readonly:Nama Siswa:Nama Siswa:nama_siswa:id_nama_siswa:{{ $find_Detailsiswa->nama_siswa }}:readonly</x-inputallin>
                                                            <x-inputallin>hidden:::detailsiswa_id:detailsiswa_id:{{ $find_Detailsiswa->id }}:readonly</x-inputallin>
                                                                <input type='hidden' name='pembayaran_id' id='pembayaran_id' placeholder='pembayaran_id' value='{{ $dataPembayaranpembayaranvii_ii->id }}'>
                                                        </div>
                                                        <div class="col-xl-6">

                                                            <x-inputallin>readonly:NIS:NIS:nis:id_nis:{{ $find_Detailsiswa->nis }}:readonly</x-inputallin>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <x-inputallin>readonly:Kelas:Kelas:kelas:kelas:{{ $find_Detailsiswa->Detailsiswatokelas->kelas }}:readonly</x-inputallin>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <x-inputallin>readonly:Tingkat:Tingkat:tingkat_id:id_tingkat_id:{{ $dataPembayaranpembayaranvii_ii->tingkat_id }}:readonly</x-inputallin>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <x-inputallin>hidden:Semester:Semester:tapel_id:tapel_id:{{ $dataPembayaranpembayaranvii_ii->tapel_id }}:readonly</x-inputallin>
                                                            <x-inputallin>readonly:Semester:Semester:semester:semester:{{ $dataPembayaranpembayaranvii_ii->semester }}:readonly</x-inputallin>
                                                        </div>
                                                    </div>
                                                    <x-inputallin>readonly:Jenis Pembyaran:Jenis Pembayaran:jenis_pembayaran:id_jenis_pembayaran:{{ $dataPembayaranpembayaranvii_ii->jenis_pembayaran }}:readonly</x-inputallin>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <x-inputallin>readonly:Nominal Terbayar:Nominal Terbayar::id_nominal:{{ number_format($total_data_pembayaranvii_ii, 0)}}:readonly</x-inputallin>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <x-inputallin>type:Nominal Bayar:Nominal Terbayar:nominal:id_nominal::Required</x-inputallin>
                                                        </div>
                                                    </div>
                                                    <x-inputallin>textarea:Keterangan:Keterangan data:keterangan:id_keterangan:{{ $dataPembayaranpembayaranvii_ii->keterangan }}:Required</x-inputallin>
                                                    <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'>Kirim</button>
                                                </form>
                                                {{-- blade-formatter-enable --}}

                                            </section>
                                        </x-edit-modal>
                                    </div>
                                    {{-- Modal Edit Data Akhir --}}
                                    {{-- Modal View --}}
                                    <div class='modal fade' id='viewModal{{ $dataPembayaranpembayaranvii_ii->id }}'
                                        tabindex='-1' aria-labelledby='ViewModalLabel' aria-hidden='true'>

                                        <x-view-modal>
                                            <x-slot:titleviewModal>{{ $titleviewModal }}</x-slot:titleviewModal>
                                            <section>
                                                //Content View
                                            </section>
                                        </x-view-modal>
                                    </div>
                                    {{-- Modal View Akhir --}}
                                    </tr>
                                @endforeach
                            @else
                            @endif

                            {{-- Data Semester 2 --}}
                            {{-- Data Semester 3 --}}
                            @if ($data_pembayaranviii_i !== null)
                                @foreach ($data_pembayaranviii_i as $dataPembayaranpembayaranviii_i)
                                    <tr>
                                        {{-- blade-formatter-disable --}}
                                        <td class='text-center'>{{ $looper++ }}</td>
                                        <td class='text-center'>
                                            {{ $dataPembayaranpembayaranviii_i->tapel_id }} /{{ $dataPembayaranpembayaranviii_i->semester }}</td>
                                        <td class='text-center'>{{ $dataPembayaranpembayaranviii_i->tingkat_id }}
                                        </td>
                                        <td class='text-left'>
                                            {{ $dataPembayaranpembayaranviii_i->jenis_pembayaran }}
                                            @php
                                                $total_data_pembayaranviii_i = App\Models\Bendahara\BendaharaKomite::where('pembayaran_id', $dataPembayaranpembayaranviii_i->id)
                                                    ->where('tapel_id', $tapelid_skrg - 3)
                                                    ->where('semester', 'I')
                                                    ->where('detailsiswa_id', request('detailsiswa_id'))
                                                    ->sum('nominal');
                                            @endphp
                                        </td>
                                        <td class='text-center'>Rp. {{ Number_format(($dataPembayaranpembayaranviii_i->nominal),0) }}</td>
                                        <td class='text-center'>Rp. {{ number_format($total_data_pembayaranviii_i, 0)}}</td>
                                        <td class='text-center'>
                                            @if ($dataPembayaranpembayaranviii_i->nominal - $total_data_pembayaranviii_i !== 0)
                                                Rp. {{ Number_format(($dataPembayaranpembayaranviii_i->nominal - $total_data_pembayaranviii_i),0) }}
                                            @else
                                                <span class="bg-success p-1"> <i class="fa fa-check mr-2"></i>Lunas</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($dataPembayaranpembayaranviii_i->nominal - $total_data_pembayaranviii_i !== 0)
                                                <div class='gap-1 d-flex justify-content-center'>
                                                    <!-- Button untuk melihat -->
                                                    <button type='button' class='btn btn-success btn-sm mr-2' data-toggle='modal' data-target='#viewModal{{ $dataPembayaranpembayaranviii_i->id }}'><i class='fa fa-eye'></i></button>
                                                    <!-- Button untuk mengedit -->
                                                    <button type='button' class='btn btn-warning btn-sm mr-2' data-toggle='modal' data-target='#editModal{{ $dataPembayaranpembayaranviii_i->id }}'><i class='fa fa-plus-square'></i></button>
                                                </div>
                                            @else
                                            @endif

                                        </td>
                                        {{-- blade-formatter-enable --}}
                                    </tr>
                                    {{-- Modal View Data Akhir --}}
                                    <div class='modal fade' id='editModal{{ $dataPembayaranpembayaranviii_i->id }}'
                                        tabindex='-1' aria-labelledby='EditModalLabel' aria-hidden='true'>
                                        <x-edit-modal>
                                            <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                            <section>
                                                <form id='updateEdata'
                                                    action='{{ route('PembayaranTunggakanKomite') }}' method='POST'>
                                                    @csrf
                                                    @method('POST')
                                                    {{-- blade-formatter-disable --}}
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                                <input type='hidden' name='tapel_id' id='tapel_id' placeholder='tapel_id' value='{{ $dataPembayaranpembayaranviii_i->tapel_id }}'>
                                                                <input type='hidden' name='detailsiswa_id' id='detailsiswa_id' placeholder='detailsiswa_id' value='{{ $find_Detailsiswa->id }}'>
                                                            <x-inputallin>readonly:Nama Siswa:NamaSiswa:nama_siswa:id_nama_siswa:{{ $find_Detailsiswa->nama_siswa }}:readonly</x-inputallin>
                                                            <x-inputallin>hidden:::detailsiswa_id:detailsiswa_id:{{ $find_Detailsiswa->id }}:readonly</x-inputallin>
                                                                <input type='hidden' name='pembayaran_id' id='pembayaran_id' placeholder='pembayaran_id' value='{{ $dataPembayaranpembayaranviii_i->id }}'>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <x-inputallin>readonly:NIS:NIS:nis:id_nis:{{ $find_Detailsiswa->nis }}:readonly</x-inputallin>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <x-inputallin>readonly:Kelas:Kelas:kelas:kelas:{{ $find_Detailsiswa->Detailsiswatokelas->kelas ?? '-' }}:readonly</x-inputallin>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <x-inputallin>readonly:Tingkat:Tingkat:tingkat_id:id_tingkat_id:{{ $dataPembayaranpembayaranviii_i->tingkat_id }}:readonly</x-inputallin>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <x-inputallin>hidden:::tapel_id:tapel_id:{{ $dataPembayaranpembayaranviii_i->tapel_id }}:readonly</x-inputallin>
                                                            <x-inputallin>readonly:Semester:Semester:semester:semester:{{ $dataPembayaranpembayaranviii_i->semester }}:readonly</x-inputallin>
                                                        </div>
                                                    </div>
                                                    <x-inputallin>readonly:Jenis Pembyaran:Jenis Pembayaran:jenis_pembayaran:id_jenis_pembayaran:{{ $dataPembayaranpembayaranviii_i->jenis_pembayaran }}:readonly</x-inputallin>

                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <x-inputallin>readonly:Nominal Terbayar:Nominal Terbayar::id_nominal:{{ number_format($total_data_pembayaranviii_i, 0)}}:readonly</x-inputallin>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <x-inputallin>type:Nominal Bayar:Nominal Terbayar:nominal:id_nominal::Required</x-inputallin>
                                                        </div>
                                                    </div>
                                                    <x-inputallin>textarea:Keterangan:Keterangan data:keterangan:id_keterangan:{{ $dataPembayaranpembayaranviii_i->keterangan }}:Required</x-inputallin>
                                                    <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'>Kirim</button>
                                                    {{-- blade-formatter-enable --}}

                                                </form>

                                            </section>
                                        </x-edit-modal>
                                    </div>
                                    {{-- Modal Edit Data Akhir --}}
                                    {{-- Modal View --}}
                                    <div class='modal fade' id='viewModal{{ $dataPembayaranpembayaranviii_i->id }}'
                                        tabindex='-1' aria-labelledby='ViewModalLabel' aria-hidden='true'>

                                        <x-view-modal>
                                            <x-slot:titleviewModal>{{ $titleviewModal }}</x-slot:titleviewModal>
                                            <section>
                                                //Content View
                                            </section>
                                        </x-view-modal>
                                    </div>
                                    {{-- Modal View Akhir --}}
                                    </tr>
                                @endforeach
                            @else
                            @endif
                            {{-- Data Semester 3 --}}
                            {{-- Data Semester 4 --}}
                            @if ($data_pembayaranviii_ii !== null)
                                @foreach ($data_pembayaranviii_ii as $dataPembayaranviii_ii)
                                    {{-- blade-formatter-disable --}}
                                    <tr>
                                        <td class='text-center'>{{ $looper++ }}</td>
                                        <td class='text-center'>{{ $dataPembayaranviii_ii->tapel_id }} / {{ $dataPembayaranviii_ii->semester }}</td>
                                        <td class='text-center'>{{ $dataPembayaranviii_ii->tingkat_id }}</td>
                                        <td class='text-left'>{{ $dataPembayaranviii_ii->jenis_pembayaran }}
                                            @php
                                                $total_data_pembayaranviii_ii = App\Models\Bendahara\BendaharaKomite::where('pembayaran_id', $dataPembayaranviii_ii->id)
                                                    ->where('tapel_id', $tapelid_skrg - 2)
                                                    ->where('semester', 'II')
                                                    ->where('detailsiswa_id', request('detailsiswa_id'))
                                                    ->sum('nominal');
                                            @endphp
                                        </td>
                                        <td class='text-center'>Rp. {{ Number_format($dataPembayaranviii_ii->nominal, 0) }}</td>
                                        <td class='text-center'>Rp. {{ number_format($total_data_pembayaranviii_ii, 0)}}</td>
                                        <td class='text-center'>
                                            @if ($dataPembayaranviii_ii->nominal - $total_data_pembayaranviii_ii !== 0)
                                                Rp. {{ Number_format($dataPembayaranviii_ii->nominal - $total_data_pembayaranviii_ii, 0) }}
                                            @else
                                                <span class="bg-success p-1"> <i class="fa fa-check mr-2"></i>Lunas</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($dataPembayaranviii_ii->nominal - $total_data_pembayaranviii_ii !== 0)
                                                <div class='gap-1 d-flex justify-content-center'>
                                                    <!-- Button untuk melihat -->
                                                    <button type='button' class='btn btn-success btn-sm mr-2' data-toggle='modal' data-target='#viewModal{{ $dataPembayaranviii_ii->id }}'><i class='fa fa-eye'></i></button>
                                                    <!-- Button untuk mengedit -->
                                                    <button type='button' class='btn btn-warning btn-sm mr-2' data-toggle='modal' data-target='#editModal{{ $dataPembayaranviii_ii->id }}'> <i class='fa fa-plus-square'></i></button>
                                                </div>
                                            @else
                                            @endif
                                        </td>
                                    </tr>
                                    {{-- blade-formatter-enable --}}
                                    {{-- Modal View Data Akhir --}}
                                    <div class='modal fade' id='editModal{{ $dataPembayaranviii_ii->id }}'
                                        tabindex='-1' aria-labelledby='EditModalLabel' aria-hidden='true'>
                                        <x-edit-modal>
                                            <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                            <section>
                                                {{-- blade-formatter-disable --}}
                                                <form id='updateEdata'
                                                    action='{{ route('PembayaranTunggakanKomite') }}' method='POST'>
                                                    @csrf
                                                    @method('POST')
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                                <input type='hidden' name='tapel_id' id='tapel_id' placeholder='tapel_id' value='{{ $dataPembayaranviii_ii->tapel_id }}'>
                                                                <input type='hidden' name='detailsiswa_id' id='detailsiswa_id' placeholder='detailsiswa_id' value='{{ $find_Detailsiswa->id }}'>
                                                            <x-inputallin>readonly:Nama Siswa:Nama Siswa:nama_siswa:id_nama_siswa:{{ $find_Detailsiswa->nama_siswa }}:readonly</x-inputallin>
                                                            <x-inputallin>hidden:::detailsiswa_id:detailsiswa_id:{{ $find_Detailsiswa->id }}:readonly</x-inputallin>
                                                                <input type='hidden' name='pembayaran_id' id='pembayaran_id' placeholder='pembayaran_id' value='{{ $dataPembayaranpembayaranviii_ii->id ?? '' }}'>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <x-inputallin>readonly:NIS:NIS:nis:id_nis:{{ $find_Detailsiswa->nis }}:readonly</x-inputallin>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <x-inputallin>readonly:Kelas:Kelas:kelas:kelas:{{ $find_Detailsiswa->Detailsiswatokelas->kelas }}:readonly</x-inputallin>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <x-inputallin>readonly:Tingkat:Tingkat:tingkat_id:id_tingkat_id:{{ $dataPembayaranviii_ii->tingkat_id }}:readonly</x-inputallin>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <x-inputallin>hidden:::tapel_id:tapel_id:{{ $dataPembayaranviii_ii->tapel_id }}:readonly</x-inputallin>
                                                            <x-inputallin>readonly:Semester:Semester:semester:semester:{{ $dataPembayaranviii_ii->semester }}:readonly</x-inputallin>
                                                        </div>
                                                    </div>
                                                    <x-inputallin>readonly:Jenis Pembyaran:Jenis Pembayaran:jenis_pembayaran:id_jenis_pembayaran:{{ $dataPembayaranviii_ii->jenis_pembayaran }}:readonly</x-inputallin>

                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <x-inputallin>readonly:Nominal Terbayar:Nominal Terbayar::id_nominal:{{ number_format($total_data_pembayaranviii_ii, 0)}}:readonly</x-inputallin>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <x-inputallin>type:Nominal Bayar:Nominal Terbayar:nominal:id_nominal::Required</x-inputallin>
                                                        </div>
                                                    </div>
                                                    <x-inputallin>textarea:Keterangan:Keterangan data:keterangan:id_keterangan:{{ $dataPembayaranviii_ii->keterangan }}:Required</x-inputallin>
                                                    <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'>Kirim</button>


                                                </form>
                                                {{-- blade-formatter-enable --}}

                                            </section>
                                        </x-edit-modal>
                                    </div>
                                    {{-- Modal Edit Data Akhir --}}
                                    {{-- Modal View --}}
                                    <div class='modal fade' id='viewModal{{ $dataPembayaranviii_ii->id }}'
                                        tabindex='-1' aria-labelledby='ViewModalLabel' aria-hidden='true'>

                                        <x-view-modal>
                                            <x-slot:titleviewModal>{{ $titleviewModal }}</x-slot:titleviewModal>
                                            <section>
                                                //Content View
                                            </section>
                                        </x-view-modal>
                                    </div>
                                    {{-- Modal View Akhir --}}
                                    </tr>
                                @endforeach
                            @else
                            @endif
                            {{-- Data Semester 4 --}}
                            {{-- Data Semester 5 --}}
                            @if ($data_pembayaranix_i !== null)
                                @foreach ($data_pembayaranix_i as $data_pembayaranix_i)
                                    {{-- blade-formatter-disable --}}
                                    <tr>
                                        <td class='text-center'>{{ $looper++ }}</td>
                                        <td class='text-center'>
                                            @if ($data_pembayaranix_i->semester !== null)
                                                {{ $data_pembayaranix_i->tapel_id }} / {{ $data_pembayaranix_i->semester }}
                                            @else
                                            @endif
                                        </td>
                                        <td class='text-center'>
                                            @if ($data_pembayaranix_i->tingkat_id !== null)
                                                {{ $data_pembayaranix_i->tingkat_id }}
                                            @else
                                            @endif
                                        </td>
                                        <td class='text-left'>
                                            {{ $data_pembayaranix_i->jenis_pembayaran }}
                                            @php
                                                $total_data_pembayaranix_i = App\Models\Bendahara\BendaharaKomite::where('pembayaran_id', $data_pembayaranix_i->id)
                                                    ->where('tapel_id', $tapelid_skrg - 1)
                                                    ->where('semester', 'I')
                                                    ->where('detailsiswa_id', request('detailsiswa_id'))
                                                    ->sum('nominal');
                                            @endphp
                                        </td>
                                        <td class='text-center'>Rp.
                                            {{ Number_format($data_pembayaranix_i->nominal, 0) }}
                                        </td>
                                        <td class='text-center'>
                                            @if ($total_data_pembayaranix_i !== null)
                                                Rp. {{ number_format($total_data_pembayaranix_i, 0)}}
                                            @else
                                            @endif
                                        </td>
                                        <td class='text-center'>

                                            @if ($data_pembayaranix_i->nominal - $total_data_pembayaranix_i !== 0)
                                                Rp. {{ Number_format($data_pembayaranix_i->nominal - $total_data_pembayaranix_i, 0) }}
                                            @else
                                                <span class="bg-success p-1"> <i class="fa fa-check mr-2"></i>Lunas</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($data_pembayaranix_i->nominal - $total_data_pembayaranix_i !== 0)
                                                <div class='gap-1 d-flex justify-content-center'>
                                                    <!-- Button untuk melihat -->
                                                    <button type='button' class='btn btn-success btn-sm mr-2' data-toggle='modal' data-target='#viewModal{{ $data_pembayaranix_i->id }}'><i class='fa fa-eye'></i>
                                                    </button>
                                                    <!-- Button untuk mengedit -->
                                                    <button type='button' class='btn btn-warning btn-sm mr-2' data-toggle='modal' data-target='#editModal{{ $data_pembayaranix_i->id }}'><i class='fa fa-plus-square'></i>
                                                    </button>
                                                </div>
                                            @else
                                            @endif
                                        </td>
                                    </tr>
                                    {{-- blade-formatter-enable --}}
                                    {{-- Modal View Data Akhir --}}
                                    <div class='modal fade' id='editModal{{ $data_pembayaranix_i->id }}' tabindex='-1'
                                        aria-labelledby='EditModalLabel' aria-hidden='true'>
                                        <x-edit-modal>
                                            <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                            <section>
                                                {{-- blade-formatter-disable --}}
                                                <form id='updateEdata'
                                                    action='{{ route('PembayaranTunggakanKomite') }}' method='POST'>
                                                    @csrf
                                                    @method('POST')
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                                <input type='hidden' name='tapel_id' id='tapel_id' placeholder='tapel_id' value='{{ $data_pembayaranix_i->tapel_id }}'>
                                                                <input type='hidden' name='detailsiswa_id' id='detailsiswa_id' placeholder='detailsiswa_id' value='{{ $find_Detailsiswa->id }}'>
                                                            <x-inputallin>readonly:Nama Siswa:Nama Siswa:nama_siswa:id_nama_siswa:{{ $find_Detailsiswa->nama_siswa }}:readonly</x-inputallin>
                                                            <x-inputallin>hidden:::detailsiswa_id:detailsiswa_id:{{ $find_Detailsiswa->id }}:readonly</x-inputallin>
                                                                <input type='hidden' name='pembayaran_id' id='pembayaran_id' placeholder='pembayaran_id' value='{{ $data_pembayaranix_i->id }}'>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <x-inputallin>readonly:NIS:NIS:nis:id_nis:{{ $find_Detailsiswa->nis }}:readonly</x-inputallin>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <x-inputallin>readonly:Kelas:Kelas:kelas:kelas:{{ $find_Detailsiswa->Detailsiswatokelas->kelas }}:readonly</x-inputallin>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <x-inputallin>readonly:Tingkat:Tingkat:tingkat_id:id_tingkat_id:{{ $data_pembayaranix_i->tingkat_id }}:readonly</x-inputallin>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <x-inputallin>hidden:::tapel_id:tapel_id:{{ $data_pembayaranix_i->tapel_id }}:readonly</x-inputallin>
                                                            <x-inputallin>readonly:Semester:Semester:semester:semester:{{ $data_pembayaranix_i->semester }}:readonly</x-inputallin>
                                                        </div>
                                                    </div>
                                                    <x-inputallin>readonly:Jenis Pembyaran:Jenis Pembayaran:jenis_pembayaran:id_jenis_pembayaran:{{ $data_pembayaranix_i->jenis_pembayaran }}:readonly</x-inputallin>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <x-inputallin>readonly:Nominal Terbayar:Nominal Terbayar::id_nominal:{{ number_format($total_data_pembayaranix_i, 0)}}:readonly</x-inputallin>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <x-inputallin>type:Nominal Bayar:Nominal Terbayar:nominal:id_nominal::Required</x-inputallin>
                                                        </div>
                                                    </div>
                                                    <x-inputallin>textarea:Keterangan:Keterangan data:keterangan:id_keterangan:{{ $data_pembayaranix_i->keterangan }}:Required</x-inputallin>
                                                    <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'>Kirim</button>
                                                </form>
                                                {{-- blade-formatter-enable --}}

                                            </section>
                                        </x-edit-modal>
                                    </div>
                                    {{-- Modal Edit Data Akhir --}}
                                    {{-- Modal View --}}
                                    <div class='modal fade' id='viewModal{{ $data_pembayaranix_i->id }}' tabindex='-1'
                                        aria-labelledby='ViewModalLabel' aria-hidden='true'>

                                        <x-view-modal>
                                            <x-slot:titleviewModal>{{ $titleviewModal }}</x-slot:titleviewModal>
                                            <section>
                                                //Content View
                                            </section>
                                        </x-view-modal>
                                    </div>
                                    {{-- Modal View Akhir --}}
                                    </tr>
                                @endforeach
                            @else
                            @endif
                            {{-- Data Semester 5 --}}
                            {{-- Data Semester 6 --}}
                            @if ($data_pembayaranix_ii !== null)
                                @foreach ($data_pembayaranix_ii as $data_pembayaranix_ii)
                                    {{-- blade-formatter-disable --}}
                                    <tr>
                                        <td class='text-center'>{{ $looper++ }}</td>
                                        <td class='text-center'>
                                            @if ($data_pembayaranix_ii->semester !== null)
                                                {{ $data_pembayaranix_ii->tapel_id }} / {{ $data_pembayaranix_ii->semester }}
                                            @else
                                            @endif
                                        </td>
                                        <td class='text-center'>
                                            @if ($data_pembayaranix_ii->tingkat_id !== null)
                                                {{ $data_pembayaranix_ii->tingkat_id }}
                                            @else
                                            @endif
                                        </td>
                                        <td class='text-left'>
                                            {{ $data_pembayaranix_ii->jenis_pembayaran }}
                                            @php
                                                $total_data_pembayaranix_ii = App\Models\Bendahara\BendaharaKomite::where('pembayaran_id', $data_pembayaranix_ii->id)
                                                    ->where('tapel_id', $tapelid_skrg)
                                                    ->where('semester', 'II')
                                                    ->where('detailsiswa_id', request('detailsiswa_id'))
                                                    ->sum('nominal');
                                            @endphp
                                        </td>
                                        <td class='text-center'>Rp.
                                            {{ Number_format($data_pembayaranix_ii->nominal, 0) }}
                                        <td class='text-center'>
                                            @if ($total_data_pembayaranix_ii !== null)
                                                Rp. {{ number_format($total_data_pembayaranix_ii, 0)}}
                                            @else
                                            @endif
                                        </td>
                                        <td class='text-center'>
                                            @if ($data_pembayaranix_ii->nominal > $total_data_pembayaranix_ii)
                                                Rp. {{ Number_format($data_pembayaranix_ii->nominal - $total_data_pembayaranix_ii, 0) }}
                                            @elseif($data_pembayaranix_ii->nominal < $total_data_pembayaranix_ii)
                                                <span class="bg-warning p-1"> <i class="fas fa-check-circle mr-2 text-danger"> </i>Dana Berlebih</span>
                                            @else
                                                <span class="bg-success p-1"> <i class="fa fa-check mr-2"></i>Lunas</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($data_pembayaranix_ii->nominal - $total_data_pembayaranix_ii !== 0)
                                                <div class='gap-1 d-flex justify-content-center'>
                                                    <!-- Button untuk melihat -->
                                                    <button type='button' class='btn btn-success btn-sm mr-2' data-toggle='modal' data-target='#viewModal{{ $data_pembayaranix_ii->id }}'> <i class='fa fa-eye'></i></button>
                                                    <!-- Button untuk mengedit -->
                                                    <button type='button' class='btn btn-warning btn-sm mr-2' data-toggle='modal' data-target='#editModal{{ $data_pembayaranix_ii->id }}'><i class='fa fa-plus-square'></i> </button>
                                                </div>
                                            @else
                                            @endif
                                        </td>
                                    </tr>
                                    {{-- blade-formatter-enable --}}
                                    {{-- Modal View Data Akhir --}}
                                    <div class='modal fade' id='editModal{{ $data_pembayaranix_ii->id }}'
                                        tabindex='-1' aria-labelledby='EditModalLabel' aria-hidden='true'>
                                        <x-edit-modal>
                                            <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                            <section>
                                                {{-- blade-formatter-disable --}}

                                                <form id='updateEdata'
                                                    action='{{ route('PembayaranTunggakanKomite') }}' method='POST'>
                                                    @csrf
                                                    @method('POST')
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                            <x-inputallin>readonly:Nama Siswa:Nama Siswa:nama_siswa:id_nama_siswa:{{ $find_Detailsiswa->nama_siswa }}:readonly</x-inputallin>
                                                            <x-inputallin>hidden:::detailsiswa_id:detailsiswa_id:{{ $find_Detailsiswa->id }}:readonly</x-inputallin>
                                                                <input type='hidden' name='pembayaran_id' id='pembayaran_id' placeholder='pembayaran_id' value='{{ $data_pembayaranix_ii->id }}'>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <x-inputallin>readonly:NIS:NIS:nis:id_nis:{{ $find_Detailsiswa->nis }}:readonly</x-inputallin>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <x-inputallin>readonly:Kelas:Kelas:kelas:kelas:{{ $find_Detailsiswa->Detailsiswatokelas->kelas }}:readonly</x-inputallin>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <x-inputallin>readonly:Tingkat:Tingkat:tingkat_id:id_tingkat_id:{{ $data_pembayaranix_ii->tingkat_id }}:readonly</x-inputallin>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <x-inputallin>hidden:::tapel_id:tapel_id:{{ $data_pembayaranix_ii->tapel_id }}:readonly</x-inputallin>
                                                            <x-inputallin>readonly:Semester:Semester:semester:semester:{{ $data_pembayaranix_ii->semester }}:readonly</x-inputallin>
                                                        </div>
                                                    </div>
                                                    <x-inputallin>readonly:Jenis Pembyaran:Jenis Pembayaran:jenis_pembayaran:id_jenis_pembayaran:{{ $data_pembayaranix_ii->jenis_pembayaran }}:readonly</x-inputallin>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <x-inputallin>readonly:Nominal Terbayar:Nominal Terbayar::id_nominal:{{ number_format($total_data_pembayaranix_ii, 0)}}:readonly</x-inputallin>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <x-inputallin>type:Nominal Bayar:Nominal Terbayar:nominal:id_nominal::Required</x-inputallin>
                                                        </div>
                                                    </div>
                                                    <x-inputallin>textarea:Keterangan:Keterangan data:keterangan:id_keterangan:{{ $data_pembayaranix_ii->keterangan }}:Required</x-inputallin>
                                                    <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'>Kirim</button>
                                                    </div>

                                                </form>
                                                {{-- blade-formatter-enable --}}

                                            </section>
                                        </x-edit-modal>
                                    </div>
                                    {{-- Modal Edit Data Akhir --}}
                                    {{-- Modal View --}}
                                    <div class='modal fade' id='viewModal{{ $data_pembayaranix_ii->id }}'
                                        tabindex='-1' aria-labelledby='ViewModalLabel' aria-hidden='true'>

                                        <x-view-modal>
                                            <x-slot:titleviewModal>{{ $titleviewModal }}</x-slot:titleviewModal>
                                            <section>
                                                //Content View
                                            </section>
                                        </x-view-modal>
                                    </div>
                                    {{-- Modal View Akhir --}}
                                    </tr>
                                @endforeach
                            @else
                            @endif
                            {{-- Data Semester 6 --}}
                        </tbody>
                        <tfoot>
                            <tr class='text-center align-middle'>
                                <th>ID</th>
                                <th>Semester</th>
                                <th>Tingkat</th>
                                <th>Jenis Pembayaran</th>
                                <th>Nominal</th>
                                <th>Terbayar</th>
                                <th>Sisa</th>
                                <th>action</th>
                            </tr>
                        </tfoot>
                    </table>
                @else
                    @endif
                    {{-- {{ dd($datax)}} --}}
                    {{-- @if ($datax->isEmpty())
                            <p>Data tidak tersedia.</p>
                        @else
                            <table border="1" cellpadding="10">
                                <thead>
                                    <tr>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Jenis Pembayaran</th>
                                        <th>Total Tagihan</th>
                                        <th>Total Terbayar</th>
                                        <th>Sisa Pembayaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datax as $item)
                                        <tr>
                                            <td>{{ $item->siswa }}</td>
                                            <td>{{ $item->kelas_id }}</td>
                                            <td>{{ $item->jenis_pembayaran }}</td>
                                            <td>{{ number_format($item->total_tagihan, 0, ',', '.') }}</td>
                                            <td>{{ number_format($item->total_terbayar, 0, ',', '.') }}
                                            </td>
                                            <td>{{ number_format($item->total_tagihan - $item->total_terbayar, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif --}}

                </div>
            </div>

        </div>

    </section>
</x-layout>

<button class='btn btn-warning btn-sm' onclick='FNnamaModal()'><i class='fa fa-edit right'></i></button>

<script>
    function namaModal(data) {
        var namaModal = new bootstrap.Modal(document.getElementById('namaModal'));
        namaModal.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='namaModal' tabindex='-1' aria-labelledby='LabelnamaModal' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelnamaModal'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                content

            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
            </div>
        </div>
    </div>

</div>
