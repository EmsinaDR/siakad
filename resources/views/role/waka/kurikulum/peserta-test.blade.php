@php
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
    $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
    $urlroot = app('request')->root();
@endphp
<x-layout>

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('Success'))
        <script>
            console.log("Flash message tersedia: {{ session('Success') }}")
        </script>
    @endif

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
                        btn-app/namaModal()</x-btnjs>
                </div>
            </div>
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</h3>
            </div>
            <!--Car Header-->

            <div class='ml-2 my-4'>
                <!-- Tambahkan Bootstrap 5 -->
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

                <div class="mt-4">
                    <div class="row">
                        <!-- Sidebar (Menu Tab) -->
                        <div class="col-md-2">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                @php
                                    $menus = [
                                        ['id' => 'home', 'name' => 'Home'],
                                        ['id' => 'kartu_test', 'name' => 'Kartu Test'],
                                        ['id' => 'ruang_test', 'name' => 'Ruang Test'],
                                        ['id' => 'peserta_test', 'name' => 'Peserta Test'],
                                        ['id' => 'berita_acara', 'name' => 'Berita Acara'],
                                        ['id' => 'daftar_hadir', 'name' => 'Daftar Hadir'],
                                        ['id' => 'tempat_duduk', 'name' => 'Tempat Duduk'],
                                        ['id' => 'jadwal_test', 'name' => 'Jadwal'],
                                        ['id' => 'nomor_meja', 'name' => 'Nomor Meja'],
                                    ];
                                @endphp

                                {{-- blade-formatter-disable --}}
                                @foreach ($menus as $index => $menu)
                                    <button class="nav-link {{ $index == 0 ? 'active' : '' }}" id="v-pills-{{ $menu['id'] }}-tab" data-bs-toggle="pill" data-bs-target="#v-pills-{{ $menu['id'] }}" type="button" role="tab"  aria-controls="v-pills-{{ $menu['id'] }}" aria-selected="{{ $index == 0 ? 'true' : 'false' }}"> {{ $menu['name'] }}
                                    </button>
                                @endforeach
                                {{-- blade-formatter-enable --}}
                            </div>
                        </div>

                        <!-- Konten Tab -->
                        <div class="col-md-10">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade active show active" id="v-pills-home" role="tabpanel"
                                    aria-labelledby="v-pills-jadwal_test-home">
                                    <h3>Home</h3>
                                    <p>Konten untuk Home.</p>
                                    <div class="col-xl-12">
                                        <a href="{{ route('PesertaTest') }}"><button type='button'
                                                class='btn btn-default bg-primary btn-md'><i
                                                    class="fa fa-file-import"></i> Import Siswa</button></a>
                                    </div>
                                   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let successMessage = "{{ session('Success') }}";
        if (successMessage) {
            Swal.fire({
                title: "{{ session('Title') }}",
                text: successMessage,
                icon: "success"
            });
        }
    });
</script>



                                </div>
                                {{-- blade-formatter-disable --}}

                                <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="v-pills-kartu_test" role="tabpanel" aria-labelledby="v-pills-kartu_test-tab">
                                    <h3>Kartu Test</h3>
                                    <p>Konten untuk {{ $menu['name'] }}.</p>
                                    {{-- blade-formatter-disable --}}
                                    <button id="BTNpdf" type="button" onclick="generatePDF()" class="btn btn-default bg-success btn-md"> <i class="fa fa-file-pdf mr-2"></i>Export to PDF </button>
                                    {{-- blade-formatter-enable --}}
                                <div class="row">
                                    <div class="col-xl-12">
                                        <section class="content mx-2 my-4">
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul class="mb-0">
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                            <div class="card">

                                                <div class="ml-2 my-4">
                                                    <style>
                                                        body {
                                                            font-family: 'Arial', sans-serif;
                                                            background-color: #f4f4f9;
                                                            margin: 0;
                                                            padding: 0;
                                                        }

                                                        .kop-kartu-tes {
                                                            display: flex;
                                                            align-items: center;
                                                            border-bottom: 3px solid #4CAF50;
                                                            margin-bottom: 15px;
                                                        }

                                                        .header-info {
                                                            text-align: center;
                                                            width: 100%;
                                                        }

                                                        .page-container {
                                                            display: flex;
                                                            flex-wrap: wrap;
                                                            justify-content: space-between;
                                                            padding: 2px;
                                                            page-break-inside: avoid;
                                                            min-height: 100px;
                                                            /* Hindari halaman kosong */
                                                            overflow: hidden;
                                                        }

                                                        .page-container:last-of-type {
                                                            page-break-after: auto;
                                                            overflow: hidden;
                                                        }

                                                        .header-info h1 {
                                                            font-size: 12px;
                                                            /* Ukuran kop lebih kecil */
                                                            margin: 0;
                                                        }

                                                        .header-info h2 {
                                                            font-size: 12px;
                                                        }

                                                        .header-info p {
                                                            font-size: 12px;
                                                        }

                                                        .col-xl-6 {
                                                            width: calc(50% - 10px);
                                                            padding: 10px;
                                                            page-break-inside: avoid;
                                                        }

                                                        .jadwal-table th,
                                                        .jadwal-table td {
                                                            font-size: 8px !important;
                                                            height: 75%;
                                                        }

                                                        .data-siswa-table th,
                                                        .data-siswa-table td {
                                                            font-size: 10px !important;
                                                        }


                                                        .header-info span {
                                                            font-size: 6px !important;
                                                        }


                                                        .kop-kartu-tes {
                                                            font-size: 8px;
                                                            /* Atur ukuran font sesuai kebutuhan */
                                                        }

                                                        .kop-kartu-tes .h2 {
                                                            font-size: 6px !important;
                                                        }

                                                        .kop-kartu-tes .header-info span {
                                                            font-size: 8px;
                                                            /* Ukuran font untuk informasi tambahan */
                                                        }

                                                        .tanda-tangan {
                                                            font-size: 8px !important;
                                                        }

                                                        #divToExport {
                                                            width: 100%;
                                                            /* Sesuaikan ukuran elemen */
                                                            font-size: 10px;
                                                            /* Kurangi ukuran font jika diperlukan */
                                                        }

                                                        @media print {
                                                            .page-container {
                                                                page-break-after: always;
                                                            }

                                                            .jadwal-table th,
                                                            .jadwal-table td {
                                                                font-size: 6px !important;
                                                            }


                                                            .kop-kartu-tes img.logo {
                                                                height: 50px;
                                                                /* Sesuaikan ukuran gambar jika perlu */
                                                                margin-right: 5px;
                                                            }
                                                        }

                                                        .jadwal-table {
                                                            width: 100%;
                                                            border-collapse: collapse;
                                                            margin-bottom: 5px;
                                                        }

                                                        .jadwal-table th,
                                                        .jadwal-table td {
                                                            padding: 4px;
                                                            text-align: left;
                                                            border: 1px solid #ddd;
                                                            /* Menambahkan border */
                                                            font-size: 12px;
                                                        }

                                                        .jadwal-table th {
                                                            background-color: #4CAF50;
                                                            color: white;
                                                        }

                                                        .page-container {
                                                            /* border: 1px solid red; */
                                                            margin-bottom: 5px;
                                                            /* width:21.5cm; */

                                                        }
                                                    </style>

                                                    {{-- blade-formatter-disable --}}
                                                        @php
                                                            $jadwal = [
                                                                ['hari' => 'Senin', 'jam' => '08:00 - 09:30', 'mata_pelajaran' => 'Matematika','pengajar' => 'Mr. A',],
                                                                ['hari' => 'Senin','jam' => '09:30 - 11:00','mata_pelajaran' => 'Bahasa Indonesia',],
                                                                [ 'hari' => 'Senin', 'jam' => '11:15 - 12:30', 'mata_pelajaran' => 'Fisika', ],

                                                                ['hari' => 'Selasa','jam' => '08:00 - 09:30','mata_pelajaran' => 'Fisika',],
                                                                [ 'hari' => 'Selasa', 'jam' => '09:30 - 11:00', 'mata_pelajaran' => 'Fisika', ],
                                                                [ 'hari' => 'Selasa', 'jam' => '11:15 - 12:30', 'mata_pelajaran' => 'Fisika', ],

                                                                ['hari' => 'Rabu', 'jam' => '08:00 - 09:30', 'mata_pelajaran' => 'Fisika',],
                                                                [ 'hari' => 'Rabu', 'jam' => '09:30 - 11:00', 'mata_pelajaran' => 'Fisika', ],
                                                                [ 'hari' => 'Rabu', 'jam' => '11:15 - 12:30', 'mata_pelajaran' => 'Fisika', ],

                                                                ['hari' => 'Kamis', 'jam' => '08:00 - 09:30', 'mata_pelajaran' => 'Fisika', ],
                                                                [ 'hari' => 'Kamis', 'jam' => '09:30 - 11:00', 'mata_pelajaran' => 'Fisika', ],

                                                                [ 'hari' => 'Jum at', 'jam' => '08:00 - 09:30', 'mata_pelajaran' => 'Fisika', ],
                                                                [ 'hari' => 'Jum at', 'jam' => '09:30 - 11:00', 'mata_pelajaran' => 'Fisika', ],
                                                                [ 'hari' => 'Sabtu', 'jam' => '08:00 - 09:30', 'mata_pelajaran' => 'Fisika', ],
                                                                [ 'hari' => 'Sabtu', 'jam' => '09:30 - 11:00', 'mata_pelajaran' => 'Fisika', ],
                                                                [ 'hari' => 'Sabtu', 'jam' => '11:15 - 12:30', 'mata_pelajaran' => 'Fisika', ],
                                                            ];
                                                        @endphp

                                                    {{-- blade-formatter-enable --}}

                                                    <div class="row">

                                                        <div id="divToExport" class="mt-1">
                                                            @foreach ($datas_kartu_test->chunk(4) as $chunkedData)
                                                                @if ($chunkedData->isNotEmpty())
                                                                    <div class="page-container">
                                                                        @foreach ($chunkedData as $data)
                                                                            @if (!empty($data))
                                                                                <div class="col-xl-6">
                                                                                    <div class="kop-kartu-tes">
                                                                                        <img class="logo"
                                                                                            src="{{ app('request')->root() }}/img/logo.png"
                                                                                            alt="Logo Sekolah"
                                                                                            style="height: 100px; margin-right: 15px;">
                                                                                        <div class="header-info">
                                                                                            <h1 class="kop">SEKOLAH
                                                                                                CIPTA IT</h1>
                                                                                            <h2>Akreditasi A</h2>
                                                                                            {{-- blade-formatter-disable --}}
                                                                                                <span>Alamat Sekolah: Jl. Pendidikan No. 123, Kota. Kontak: (021) 123456789</span>
                                                                                                {{-- <span>Alamat Sekolah: Jl. Pendidikan No. 123</span> --}}
                                                                                                {{-- blade-formatter-enable --}}
                                                                                        </div>
                                                                                    </div>

                                                                                    <table
                                                                                        class="data-siswa-table mb-1">
                                                                                        <tr>
                                                                                            <th width='45%'>Nama
                                                                                                Lengkap</th>
                                                                                            <td>:
                                                                                                {{ $data->PesertaTestToDetailSiswa->nama_siswa }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th width='45%'>Nomor
                                                                                                Induk Siswa</th>
                                                                                            <td>:
                                                                                                {{ $data->PesertaTestToDetailSiswa->nis }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th width='45%'>Kelas
                                                                                            </th>
                                                                                            <td>:
                                                                                                {{ $data->PesertaTestToKelas->kelas }}
                                                                                                /
                                                                                                {{ $data->nomor_test }}
                                                                                            </td>
                                                                                        </tr>

                                                                                    </table>
                                                                                    <h2 class='my-1 bg-primary p-2'
                                                                                        style="text-align: center; font-size: 8px;">
                                                                                        <b>Jadwal Pelajaran</b>
                                                                                    </h2>
                                                                                    <table class="jadwal-table"
                                                                                        style="width: 100%; border-collapse: collapse;">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th class='text-center align-middle'
                                                                                                    width='1%'>No
                                                                                                </th>
                                                                                                <th class='text-center align-middle'
                                                                                                    width='35%'>Hari
                                                                                                </th>
                                                                                                <th class='text-center align-middle'
                                                                                                    width='30%'>Jam
                                                                                                </th>
                                                                                                <th
                                                                                                    class='text-center align-middle'>
                                                                                                    Mata Pelajaran</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            @foreach ($jadwal as $pelajaran)
                                                                                                <tr class='text-center'>
                                                                                                    <td
                                                                                                        class='text-center'>
                                                                                                        {{ $loop->index + 1 }}
                                                                                                    </td>
                                                                                                    <td
                                                                                                        class='text-center'>
                                                                                                        {{ $pelajaran['hari'] }},
                                                                                                        2
                                                                                                        September 2025
                                                                                                    </td>
                                                                                                    <td
                                                                                                        class='text-center'>
                                                                                                        {{ $pelajaran['jam'] }}
                                                                                                    </td>
                                                                                                    <td
                                                                                                        class='text-left'>
                                                                                                        {{ $pelajaran['mata_pelajaran'] }}
                                                                                                    </td>
                                                                                                </tr>
                                                                                            @endforeach

                                                                                        </tbody>
                                                                                    </table>
                                                                                    <table class='tanda-tangan'
                                                                                        widt='100%'>
                                                                                        <tr class='text-center'>
                                                                                            <td width='65%'></td>
                                                                                            <td>
                                                                                                <p>Banjarharjo, 2
                                                                                                    September 2025
                                                                                                    <br><br><br><br>
                                                                                                    Farid Attallah
                                                                                                </p>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

                                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
                                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

                                                    <script>
                                                        function generatePDF() {
                                                            const element = document.getElementById('divToExport');

                                                            const options = {
                                                                margin: [0, 0, 0, 0], // Menghapus margin untuk menghindari halaman kosong
                                                                filename: 'kartu-tes-sekolah.pdf',
                                                                image: {
                                                                    type: 'jpeg',
                                                                    quality: 0.98
                                                                },
                                                                html2canvas: {
                                                                    scale: 2,
                                                                    scrollY: 0
                                                                },

                                                                jsPDF: {
                                                                    unit: 'mm',
                                                                    format: 'legal',
                                                                    // format: [210, 400] // Lebar 210mm, tinggi 330mm (custom)

                                                                    orientation: 'portrait'
                                                                }
                                                            };


                                                            html2pdf().from(element).set(options).save();
                                                        }
                                                    </script>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="v-pills-ruang_test"
                                role="tabpanel" aria-labelledby="v-pills-ruang_test-tab">
                                <h3>Ruang Test</h3>
                                <p>Konten untuk {{ $menu['name'] }}.</p>
                                <div class="col-xl-12">
                                           <div class="col-xl-12">
                                                <table id='example1' width='100%' class='table table-bordered table-hover'>
                                                    <thead>
                                                        <tr class='text-center'>
                                                            <th width='1%'>No</th>
                                                            <th>Kelas VII <br>( No Ruangan / Kelas / Nama )</th>
                                                            <th>Kelas VIII <br>( No Ruangan / Kelas / Nama )</th>
                                                            <th>Kelas IX <br>( No Ruangan / Kelas / Nama )</th>
                                                            <th>Ruang</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $max_rows = max(count($datas_kelas_vii), count($datas_kelas_viii), count($datas_kelas_ix));
                                                        @endphp

                                                        @for ($i = 0; $i < $max_rows; $i++)
                                                            <tr>
                                                                <td width='1%' class='text-center'>{{ $i + 1 }}</td>
                                                                <td class="{{ isset($datas_kelas_vii[$i]) ? '' : 'table-danger' }}">
                                                                    {{ $datas_kelas_vii[$i]->detailsiswa_id ?? '-' }} -
                                                                    {{ $datas_kelas_vii[$i]->nomor_ruangan ?? '-' }} /
                                                                    <input type="hidden" class="id-input" data-index="{{ $i }}" name="nomor_ruangan_vii[]" value="{{ $datas_kelas_vii[$i]->id ?? '-' }}">
                                                                    {{ $datas_kelas_vii[$i]->PesertaTestToKelas->kelas ?? '' }} /
                                                                    {{ $datas_kelas_vii[$i]->PesertaTestToDetailSiswa->nama_siswa ?? '-' }}
                                                                </td>
                                                                <td class="{{ isset($datas_kelas_viii[$i]) ? '' : 'table-danger' }}">
                                                                    {{ $datas_kelas_viii[$i]->nomor_ruangan ?? '-' }} /
                                                                    <input type="hidden" class="id-input" data-index="{{ $i }}" name="nomor_ruangan_viii[]" value="{{ $datas_kelas_viii[$i]->id ?? '-' }}">
                                                                    {{ $datas_kelas_viii[$i]->PesertaTestToKelas->kelas ?? '' }} /
                                                                    {{ $datas_kelas_viii[$i]->PesertaTestToDetailSiswa->nama_siswa ?? '-' }}
                                                                </td>
                                                                <td class="{{ isset($datas_kelas_ix[$i]) ? '' : 'table-danger' }}">
                                                                    {{ $datas_kelas_ix[$i]->nomor_ruangan ?? '-' }} /
                                                                    <input type="hidden" class="id-input" data-index="{{ $i }}" name="nomor_ruangan_ix[]" value="{{ $datas_kelas_ix[$i]->id ?? '-' }}">
                                                                    {{ $datas_kelas_ix[$i]->PesertaTestToKelas->kelas ?? '' }} /
                                                                    {{ $datas_kelas_ix[$i]->PesertaTestToDetailSiswa->nama_siswa ?? '-' }}
                                                                </td>
                                                                <td width='10%'>
                                                                    @php $ruang = range(1, 50); @endphp
                                                                    <div class="form-group">
                                                                        <select name="ruang_test[]" class="form-control ruang-test" data-index="{{ $i }}" required>
                                                                            <option value=""></option>
                                                                            @foreach ($ruang as $newkey)
                                                                                <option value="{{ $newkey }}">{{ $newkey }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endfor
                                                    </tbody>


                                                </table>
                                            </div>
                                </div>

                            </div>
                            <script>
                            $(document).ready(function() {
                                $(document).off('change', '.ruang-test').on('change', '.ruang-test', function() {
                                    var select = $(this);
                                    select.prop('disabled', true);

                                    var ruang_test = select.val();
                                    var index = select.data('index');
                                    var siswa_ids = [];

                                    // Mengumpulkan siswa IDs
                                    var siswa_id_vii = $('.id-input[data-index="' + index + '"]:eq(0)').val();
                                    var siswa_id_viii = $('.id-input[data-index="' + index + '"]:eq(1)').val();
                                    var siswa_id_ix = $('.id-input[data-index="' + index + '"]:eq(2)').val();

                                    // Pastikan ID tidak kosong sebelum dimasukkan ke dalam array
                                    if (siswa_id_vii !== '-' && siswa_id_vii !== '') {
                                        siswa_ids.push(siswa_id_vii);
                                    }
                                    if (siswa_id_viii !== '-' && siswa_id_viii !== '') {
                                        siswa_ids.push(siswa_id_viii);
                                    }
                                    if (siswa_id_ix !== '-' && siswa_id_ix !== '') {
                                        siswa_ids.push(siswa_id_ix);
                                    }

                                    // Cek data yang akan dikirim
                                    console.log('Data yang akan dikirim:', {
                                        _token: '{{ csrf_token() }}',
                                        siswa_ids: siswa_ids,
                                        nomor_ruangan: ruang_test
                                    });

                                    // Pastikan data siswa_ids tidak kosong
                                    if (siswa_ids.length === 0) {
                                        console.log("Tidak ada siswa yang dipilih untuk dikirim");
                                        return;
                                    }

                                    // Kirim data melalui AJAX
                                    $.ajax({
                                        url: '/waka-kurikulum/update-ruang-test', // Ganti dengan URL yang benar
                                        method: 'POST',
                                        data: {
                                            _token: '{{ csrf_token() }}',
                                            siswa_ids: siswa_ids,
                                            nomor_ruangan: ruang_test
                                        },
                                        success: function(response) {
                                            console.log("Respon dari server:", response);
                                            if (response.flash) {
                                                alert(response.flash.success);  // Pesan sukses
                                            }
                                        },
                                        error: function(xhr, status, error) {
                                            console.error("Terjadi error:", xhr.responseText);
                                            alert('Error: ' + xhr.responseJSON.error);
                                        }
                                    });
                                });
                            });


                            </script>


                            <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}"
                                id="v-pills-peserta_test" role="tabpanel" aria-labelledby="v-pills-peserta_test-tab">
                                <h3>Peserta Test</h3>
                                <p>Konten untuk {{ $menu['name'] }}.</p>
                                <div class="col-xl-12">
                                    @foreach ($group_by_ruang as $ruang => $siswa_list)
                                        <!-- Header untuk Menampilkan Nama Ruangan -->
                                        <x-kop-surat></x-kop-surat>
                                        <h4 class='text-center'><b>Data Peserta Tes</b></h4>
                                        <h5 class='text-center'>RUANG {{ $ruang }}</h5>

                                        <div class="page-break">
                                            <table id="example1" width="100%"
                                                class="table table-bordered table-hover">
                                                <thead>
                                                    <tr class='text-center'>
                                                        <th>No</th>
                                                        <th>NIS</th>
                                                        <th>Nama</th>
                                                        <th>Nomor Test</th>
                                                        <th>Ruangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($siswa_list as $index => $siswa)
                                                        <tr>
                                                            <td class='text-center'>{{ $index + 1 }}</td>
                                                            <td class='text-center'>
                                                                {{ $siswa->PesertaTestToDetailSiswa->nis }}</td>
                                                            <td class='text-left'>
                                                                {{ $siswa->PesertaTestToDetailSiswa->nama_siswa }}</td>
                                                            <td class='text-center'>{{ $siswa->nomor_test }}</td>
                                                            <td class='text-center'>{{ $siswa->nomor_ruangan }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                            <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}"
                                id="v-pills-berita_acara" role="tabpanel" aria-labelledby="v-pills-berita_acara-tab">
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
                                <p>Konten untuk {{ $menu['name'] }}.</p>
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
                                                Mata Pelaajra <br>
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
                            <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}"
                                id="v-pills-daftar_hadir" role="tabpanel" aria-labelledby="v-pills-daftar_hadir-tab">
                                <h3>Daftar Hadir</h3>
                                <p>Konten untuk Daftar Hadir.</p>
                                <div class="col-xl-12">

                                    <div class="col-xl-12">

                                        @foreach ($group_by_ruang as $ruang => $siswa_list)
                                            <!-- Header untuk Menampilkan Nama Ruangan -->
                                            <x-kop-surat></x-kop-surat>
                                            <h4 class='text-center'><b>DAFTAR HADIR</b></h4>
                                            <h5 class='text-center'><b>RUANG {{ $ruang }}</b></h5>

                                            <div class="page-break">
                                                <table id="example1" width="100%"
                                                    class="table table-bordered table-hover">
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
                                                                <td
                                                                    class="{{ ($index + 1) % 2 == 0 ? 'text-right' : 'text-left' }}">
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
                            <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}"
                                id="v-pills-tempat_duduk" role="tabpanel" aria-labelledby="v-pills-tempat_duduk-tab">
                                <h3>Tempat Duduk</h3>
                                <p>Konten untuk {{ $menu['name'] }}.</p>
                                <div class="col-xl-12">
                                    @foreach ($paired_data as $ruang => $pairs)
                                        <h3>Ruangan: {{ $ruang }}</h3>
                                        <table id="example1" width="100%"
                                            class="table table-bordered table-hover">
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
                            </div>
                            {{-- blade-formatter-enable --}}

                            <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}"
                                id="v-pills-jadwal_test" role="tabpanel" aria-labelledby="v-pills-jadwal_test-tab">
                                <h3>Jadwal Test</h3>
                                <p>Konten untuk {{ $menu['name'] }}.</p>
                                <div class="col-xl-12">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <x-inputallin>date:Tanggal:Tanggal:tanggal_pelaksanaan:tanggal_pelaksanaan::Required</x-inputallin>
                                        </div>
                                        <div class="col-xl-6">
                                            {{-- blade-formatter-disable --}}
                                            <x-inputallin>numbe:Waktu:Waktu:waktu:id_waktu::Required</x-inputallin>
                                            {{-- blade-formatter-enable --}}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class='form-group'>
                                                @php
                                                    $mapels = ['Matematika', 'Bahasa Indonesia'];
                                                    $mapels = App\Models\Admin\Emapel::orderBy('mapel', 'ASC')->get();
                                                    // dd($mapels);
                                                @endphp
                                                <label for='mapel_id'>Nama Mapel</label>
                                                <select id='mapel_id' name='mapel_id' class='form-control' required>
                                                    <option value=''>--- Pilih Nama Mapel ---</option>
                                                    @foreach ($mapels as $newmapels)
                                                        <option value='{{ $newmapels->id }}'>{{ $newmapels->mapel }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        {{-- blade-formatter-disable --}}
                                        <div class="col-xl-6">
                                            <x-dropdown-guru-s>Pengawas/Nama Pengawas/detailguru_id/id_data_pengawas//</x-dropdown-guru-s>
                                        </div>
                                        {{-- blade-formatter-enable --}}
                                        @php
                                            $waktu = '09:00';
                                            $durasi = 25;
                                            $date = new DateTime($waktu);
                                            $date->modify($durasi . ' minutes');
                                            echo $date->format('H:i'); // Output: 09:30

                                        @endphp
                                        {{-- blade-formatter-disable --}}
                                        <x-kop-surat></x-kop-surat>
                                            <h4 class='text-center'><b>Jadwal Test</b></h4>
                                        <table id='example1' width='100%' class='table table-bordered table-hover'>
                                        {{-- blade-formatter-enable --}}
                                        <thead>
                                            <tr class='text-center align-middle table-success'>
                                                <th>No</th>
                                                <th>Hari dan Tanggal</th>
                                                <th>Mapel</th>
                                                <th>Jam</th>
                                                <th>Waktu</th>
                                                <th>Pengawas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @for ($i = 1; $i < 5; $i++)
                                                <tr>

                                                    @php
                                                        $waktu = '09:00';
                                                        $date = new DateTime($waktu);
                                                        $date->modify($durasi . ' minutes');
                                                    @endphp
                                                    <td class='text-center'>{{ $i }}</td>
                                                    <td class='text-center'>{{ $i }}</td>
                                                    <td class='text-center'>konten</td>
                                                    <td class='text-center'>{{ $waktu }} -
                                                        {{ $date->format('H:i') }}</td>
                                                    <td class='text-center'>konten</td>
                                                    <td class='text-center'>konten</td>
                                                </tr>
                                            @endfor
                                        </tbody>
                                        <tfoot>
                                            <tr class='text-center align-middle table-success'>
                                                <th>No</th>
                                                <th>Hari dan Tanggal</th>
                                                <th>Mapel</th>
                                                <th>Jam</th>
                                                <th>Waktu</th>
                                                <th>Pengawas</th>
                                            </tr>
                                        </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="v-pills-nomor_meja"
                                role="tabpanel" aria-labelledby="v-pills-nomor_meja-tab">
                                <h3>No Meja Test</h3>
                                <p>Konten untuk {{ $menu['name'] }}.</p>
                                <div class="col-xl-12">
                                    @foreach ($paired_data as $ruang => $pairs)
                                        <h3>Ruangan: {{ $ruang }}</h3>

                                        @foreach ($pairs as $pair)
                                            <div class="row gap-2">
                                                <div class="card col-xl-6">
                                                    <div class="col-xl-12">
                                                        <x-kop-surat></x-kop-surat>
                                                    </div>
                                                    <div class="bg-primary text-center p-2 mb-2"><b
                                                            class='text-center'>MEJA TEST</b></div>
                                                    <div class="row">
                                                        <div class="col-xl-4">
                                                            Nama <br>
                                                            Kelas <br>
                                                            Nomor Test <br>
                                                            Ruang <br>
                                                        </div>
                                                        <div class="col-xl-8">
                                                            :
                                                            {{ $pair['first']->PesertaTestToDetailSiswa->nama_siswa }}
                                                            <br>
                                                            :
                                                            {{ $pair['first'] ? $pair['first']->PesertaTestToKelas->kelas : '-' }}
                                                            <br>
                                                            : {{ $pair['first']->nomor_test }}<br>
                                                            : {{ $ruang }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card col-xl-6">
                                                    <div class="col-xl-12">
                                                        <x-kop-surat></x-kop-surat>
                                                    </div>
                                                    <div class="bg-primary text-center p-2 mb-2"><b
                                                            class='text-center'>MEJA TEST</b></div>
                                                    <div class="row">
                                                        <div class="col-xl-4">
                                                            Nama <br>
                                                            Kelas <br>
                                                            Nomor Test <br>
                                                            Ruang <br>
                                                        </div>
                                                        <div class="col-xl-8">
                                                            :
                                                            {{ $pair['second'] ? $pair['second']->PesertaTestToDetailSiswa->nama_siswa : '-' }}
                                                            <br>
                                                            :
                                                            {{ $pair['second'] ? $pair['second']->PesertaTestToKelas->kelas : '-' }}
                                                            <br>
                                                            : {{ $pair['second'] ? $pair['second']->nomor_test : '-' }}
                                                            <br>
                                                            : {{ $ruang }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endforeach

                                </div>
                            </div>

                            <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}"
                                id="v-pills-jadwal_test" role="tabpanel" aria-labelledby="v-pills-jadwal_test-tab">
                                <h3>Jadwal Test</h3>
                                <p>Konten untuk {{ $menu['name'] }}.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
























            {{-- Catatan :
                - Include Komponen Modal CRUD + Javascript / Jquery
                - Perbaiki Onclick Tombol Modal Create, Edit
                - Variabel Active Crud menggunakan ID User
                 --}}



            <hr class='bg-dark' style='height: 3px;'>
            <hr class='bg-dark' style='height: 3px;'>



        </div>



    </section>
</x-layout>

<button class='btn btn-warning btn-sm' onclick='FNnamaModal()'><i class='fa fa-edit right'></i> Edit</button>

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


<script>
    function SettingRuangan(data) {
        var SettingRuangan = new bootstrap.Modal(document.getElementById('SettingRuangan'));
        SettingRuangan.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='SettingRuangan' tabindex='-1' aria-labelledby='LabelSettingRuangan'
    aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelSettingRuangan'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <form id='#id' action='' method='POST'>
                    @csrf
                    @method('POST')
                    {{-- blade-formatter-disable --}}

                @php
                    $range_ruangs = range(1, 50);
                    $tests = ['PTS 1', 'PTS 2', 'PTS', 'PAS', 'PAT'];
                    $listdata = App\Models\User\Siswa\Detailsiswa::orderBy('kelas_id')->orderBy('nama_siswa')->get();
                    // dd($range_ruang);
                @endphp

                <div class='form-group'>
                    <label for='nomor_ruangan'>Nomor Ruangan</label>
                    <select id='nomor_ruangan' name='nomor_ruangan' class='form-control' required>
                        <option value=''>--- Pilih Nomor Ruangan ---</option>
                        @foreach ($range_ruangs as $range_ruang)
                            <option value='{{ $range_ruang }}'>{{ $range_ruang }}</option>
                        @endforeach
                    </select>
                </div>

                <div class='form-group'>
                    <label for='test'>Test</label>
                    <select id='test' name='test' class='form-control' required>
                        <option value=''>--- Pilih Nomor Ruangan ---</option>
                        @foreach ($tests as $test)
                            <option value='{{ $test }}'>{{ $test }}</option>
                        @endforeach
                    </select>
                </div>
                <x-dropdown-allsiswa type='multiple' :listdata='$listdata' label='Data Siswa X' name='detailsiswa_id' id_property='id_single' />
                {{-- blade-formatter-enable --}}

            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
            </div>
            </form>
        </div>
    </div>

</div>
<!-- Tambahkan di bagian <head> -->

{{-- @if (session('Success'))
    <script>
        Swal.fire("{{ session('Title') }}", "{{ session('Success') }}", "success");
    </script>
@endif --}}
