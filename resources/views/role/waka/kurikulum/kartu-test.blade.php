<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>

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
            <div class="card-header bg-primary mx-2">
                <h3 class="card-title">{{ $title }}</h3>
            </div>

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

                    // $jadwal = [
                    //     ['hari' => 'Senin', 'jam' => '08:00 - 09:30', 'mata_pelajaran' => 'Matematika','pengajar' => 'Mr. A',],
                    //     ['hari' => 'Senin','jam' => '09:30 - 11:00','mata_pelajaran' => 'Bahasa Indonesia',],
                    //     [ 'hari' => 'Senin', 'jam' => '11:15 - 12:30', 'mata_pelajaran' => 'Fisika', ],

                    //     ['hari' => 'Selasa','jam' => '08:00 - 09:30','mata_pelajaran' => 'Fisika',],
                    //     [ 'hari' => 'Selasa', 'jam' => '09:30 - 11:00', 'mata_pelajaran' => 'Fisika', ],
                    //     [ 'hari' => 'Selasa', 'jam' => '11:15 - 12:30', 'mata_pelajaran' => 'Fisika', ],

                    //     ['hari' => 'Rabu', 'jam' => '08:00 - 09:30', 'mata_pelajaran' => 'Fisika',],
                    //     [ 'hari' => 'Rabu', 'jam' => '09:30 - 11:00', 'mata_pelajaran' => 'Fisika', ],
                    //     [ 'hari' => 'Rabu', 'jam' => '11:15 - 12:30', 'mata_pelajaran' => 'Fisika', ],

                    //     ['hari' => 'Kamis', 'jam' => '08:00 - 09:30', 'mata_pelajaran' => 'Fisika', ],
                    //     [ 'hari' => 'Kamis', 'jam' => '09:30 - 11:00', 'mata_pelajaran' => 'Fisika', ],

                        // [ 'hari' => 'Jum at', 'jam' => '08:00 - 09:30', 'mata_pelajaran' => 'Fisika', ],
                        // [ 'hari' => 'Jum at', 'jam' => '09:30 - 11:00', 'mata_pelajaran' => 'Fisika', ],
                        // [ 'hari' => 'Sabtu', 'jam' => '08:00 - 09:30', 'mata_pelajaran' => 'Fisika', ],
                        // [ 'hari' => 'Sabtu', 'jam' => '09:30 - 11:00', 'mata_pelajaran' => 'Fisika', ],
                        // [ 'hari' => 'Sabtu', 'jam' => '11:15 - 12:30', 'mata_pelajaran' => 'Fisika', ],
                    // ];
                @endphp

               {{-- blade-formatter-enable --}}
                <button id="BTNpdf" type="button" onclick="generatePDF()" class="btn btn-default bg-success btn-md"> <i class="fa fa-file-pdf mr-2"></i>Export to PDF </button>
                <div class="row">

                    <div id="divToExport" class="mt-1">
                        @foreach ($datas->chunk(4) as $chunkedData)
                            @if ($chunkedData->isNotEmpty())
                                <div class="page-container ">
                                    @foreach ($chunkedData as $data)
                                        @if (!empty($data))
                                            <div class="col-xl-6 border-bottom">
                                                <div class="kop-kartu-tes">
                                                    <img class="logo" src="{{ app('request')->root() }}/img/logo.png"
                                                        alt="Logo Sekolah" style="height: 100px; margin-right: 15px;">
                                                    <div class="header-info">
                                                        <h1 class="kop">SEKOLAH CIPTA IT</h1>
                                                        <h2>Akreditasi A</h2>
                                                        {{-- blade-formatter-disable --}}
                                                        <span>Alamat Sekolah: Jl. Pendidikan No. 123, Kota. Kontak: (021) 123456789</span>
                                                        {{-- <span>Alamat Sekolah: Jl. Pendidikan No. 123</span> --}}
                                                        {{-- blade-formatter-enable --}}
                                                    </div>
                                                </div>

                                                <table class="data-siswa-table mb-1">
                                                    <tr>
                                                        <th width='45%'>Nama Lengkap</th>
                                                        <td>: {{ $data->PesertaTestToDetailSiswa->nama_siswa }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th width='45%'>Nomor Induk Siswa</th>
                                                        <td>: {{ $data->PesertaTestToDetailSiswa->nis }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th width='45%'>Kelas</th>
                                                        <td>: {{ $data->PesertaTestToKelas->kelas }} /
                                                            {{ $data->nomor_test }}</td>
                                                    </tr>

                                                </table>
                                                <h2 class='my-1 bg-primary p-2'
                                                    style="text-align: center; font-size: 8px;"><b>Jadwal Pelajaran</b>
                                                </h2>
                                                <table class="jadwal-table"
                                                    style="width: 100%; border-collapse: collapse;">
                                                    <thead>
                                                        <tr>
                                                            <th class='text-center align-middle' width='1%'>No</th>
                                                            <th class='text-center align-middle' width='35%'>Hari
                                                            </th>
                                                            <th class='text-center align-middle' width='30%'>Jam</th>
                                                            <th class='text-center align-middle'>Mata Pelajaran</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        {{-- @foreach($datas as $data)
                                                           <tr class='text-center'>
                                                               <td>{{ $loop->iteration }}</td>
                                                               <td>{{ $data->iteration }}</td>
                                                           </tr>
                                                        @endforeach --}}
                                                        {{-- @foreach ($jadwal as $pelajaran)
                                                            <tr class='text-center'>
                                                                <td class='text-center'>{{ $loop->index + 1 }}</td>
                                                                <td class='text-center'>{{ $pelajaran['hari'] }}, 2
                                                                    September 2025</td>
                                                                <td class='text-center'>{{ $pelajaran['jam'] }}</td>
                                                                <td class='text-left'>
                                                                    {{ $pelajaran['mata_pelajaran'] }}</td>
                                                            </tr>
                                                        @endforeach --}}
                                                        @if ($jadwal->isEmpty())
                                                        <td class='text-center align-middle' colspan='4'>Tidak ada jadwal tersedia</td>

                                                        @else
                                                        @foreach ($jadwal as $data)
                                                            @php $rowspan = count($data['jadwal']); @endphp
                                                            @foreach ($data['jadwal'] as $index => $pelajaran)
                                                                <tr>
                                                                    <td>{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                                                                    @if ($index === 0)
                                                                        <td rowspan="{{ $rowspan }}">{{ $data['hari'] }}, {{ $data['tanggal'] }}</td>
                                                                    @endif
                                                                    <td>{{ $pelajaran['jam'] }}</td>
                                                                    <td>{{ $pelajaran['mata_pelajaran'] }}</td>
                                                                </tr>
                                                            @endforeach
                                                        @endforeach

                                                        @endif



                                                    </tbody>
                                                </table>
                                                <table class='tanda-tangan' widt='100%'>
                                                    <tr class='text-center'>
                                                        <td width='65%'></td>
                                                        <td>
                                                            <p>Banjarharjo,
                                                                {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
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
                {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

                <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script> --}}

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
</x-layout>
