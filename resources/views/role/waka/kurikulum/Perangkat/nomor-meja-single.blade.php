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
                    {{-- <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'> <i class='fa fa-plus'></i> Tambah Data</button> --}}
                </div>
                <div class='col-xl-10'></div>
            </div>

            <div class='ml-2 my-4'>
                {{-- <div class="col-xl-12">
                    @foreach ($paired_data as $ruang => $pairs)
                        <h4 class="mt-3">No Meja Test - {{ $ruang }}</h4>
                        <div class="row g-3">
                            @foreach ($pairs as $pair)
                                <div class="col-xl-6">
                                    <div class="card p-3">
                                        <div class="col-xl-12 text-center">
                                            <x-kop-surat></x-kop-surat>
                                        </div>
                                        <div class="bg-primary text-center p-2 text-white">
                                            <b>MEJA TEST - {{ $ruang }}</b>
                                        </div>
                                        <div class="row p-3">
                                            <div class="col-4 fw-bold">
                                                Nama <br>
                                                Kelas <br>
                                                Nomor Test <br>
                                                Ruang <br>
                                            </div>
                                            <div class="col-8">
                                                :
                                                {{ $pair['first'] ? $pair['first']->PesertaTestToDetailSiswa->nama_siswa : '-' }}
                                                <br>
                                                : {{ $pair['first'] ? $pair['first']->PesertaTestToKelas->kelas : '-' }}
                                                <br>
                                                : {{ $pair['first'] ? $pair['first']->nomor_test : '-' }}<br>
                                                : {{ $ruang }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if (isset($pair['second']))
                                    <div class="col-xl-6">
                                        <div class="card p-3">
                                            <div class="col-xl-12 text-center">
                                                <x-kop-surat></x-kop-surat>
                                            </div>
                                            <div class="bg-primary text-center p-2 text-white">
                                                <b>MEJA TEST - {{ $ruang }}</b>
                                            </div>
                                            <div class="row p-3">
                                                <div class="col-4 fw-bold">
                                                    Nama <br>
                                                    Kelas <br>
                                                    Nomor Test <br>
                                                    Ruang <br>
                                                </div>
                                                <div class="col-8">
                                                    :
                                                    {{ $pair['second'] ? $pair['second']->PesertaTestToDetailSiswa->nama_siswa : '-' }}
                                                    <br>
                                                    :
                                                    {{ $pair['second'] ? $pair['second']->PesertaTestToKelas->kelas : '-' }}
                                                    <br>
                                                    : {{ $pair['second'] ? $pair['second']->nomor_test : '-' }}<br>
                                                    : {{ $ruang }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div> --}}
<button id="downloadPdf" class="btn btn-danger">Download PDF</button>

<div id="exportDiv">
    <div class="col-xl-12">
        @foreach ($paired_data as $ruang => $pairs)
            <h4 class="mt-3">No Meja Test - {{ $ruang }}</h4>
            <div class="row g-3">
                @foreach ($pairs as $pair)
                    <div class="kartu">
                        <div class="card p-3 kartu-content">
                            <div class="col-xl-12 text-center">
                                <x-kop-surat></x-kop-surat>
                            </div>
                            <div class="bg-primary text-center p-2 text-white">
                                <b>MEJA TEST - {{ $loop->iteration }}</b>
                            </div>
                            <div class="row p-3">
                                <div class="col-4 fw-bold">
                                    Nama <br>
                                    Kelas <br>
                                    Nomor Test <br>
                                    Ruang <br>
                                </div>
                                <div class="col-8">
                                    : {{ $pair['first'] ? $pair['first']->PesertaTestToDetailSiswa->nama_siswa : '-' }} <br>
                                    : {{ $pair['first'] ? $pair['first']->PesertaTestToKelas->kelas : '-' }} <br>
                                    : {{ $pair['first'] ? $pair['first']->nomor_test : '-' }} / {{ $pair['first'] ? $pair['first']->PesertaTestToKelas->kelas : '-' }} / {{date('Y')}}<br>
                                    : {{ $ruang }}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(isset($pair['second']))
                    <div class="kartu">
                        <div class="card p-3 kartu-content">
                            <div class="col-xl-12 text-center">
                                <x-kop-surat></x-kop-surat>
                            </div>
                            <div class="bg-primary text-center p-2 text-white">
                                <b>MEJA TEST - {{ $loop->iteration }}</b>
                            </div>
                            <div class="row p-3">
                                <div class="col-4 fw-bold">
                                    Nama <br>
                                    Kelas <br>
                                    Nomor Test <br>
                                    Ruang <br>
                                </div>
                                <div class="col-8">
                                    : {{ $pair['second'] ? $pair['second']->PesertaTestToDetailSiswa->nama_siswa : '-' }} <br>
                                    : {{ $pair['second'] ? $pair['second']->PesertaTestToKelas->kelas : '-' }} <br>
                                    : {{ $pair['second'] ? $pair['second']->nomor_test : '-' }} / {{ $pair['second'] ? $pair['second']->PesertaTestToKelas->kelas : '-' }} / {{date('Y')}}<br>
                                    : {{ $ruang }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        @endforeach
    </div>
</div>

<style>
    /* Pastikan latar belakang tetap putih */
    .kartu {
        width: 48%;
        display: inline-block;
        margin: 5px;
        box-sizing: border-box;
        background-color: white !important;
        border: 1px solid black; /* Untuk membantu debugging */
    }

    .kartu-content {
        background-color: white !important;
    }
</style>

<!-- Tambahkan Library jsPDF & html2canvas -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script> --}}

<script>
document.getElementById('downloadPdf').addEventListener('click', async function() {
    const { jsPDF } = window.jspdf;
    let doc = new jsPDF('p', 'mm', 'a4');
    let y = 10;
    let kartuPerHalaman = 10;
    let kartuCount = 0;

    let kartuElements = document.querySelectorAll('.kartu');

    for (let index = 0; index < kartuElements.length; index++) {
        let kartu = kartuElements[index];

        let canvas = await html2canvas(kartu, {
            scale: 2,
            backgroundColor: '#ffffff',
            useCORS: true
        });

        // let imgData = canvas.toDataURL('image/png', 1.0);
        let imgData = canvas.toDataURL('image/png', 0.5);
        let imgWidth = 85;
        let imgHeight = (canvas.height * imgWidth) / canvas.width;

        if (kartuCount === kartuPerHalaman) {
            doc.addPage();
            y = 10;
            kartuCount = 0;
        }

        let posX = 10 + (index % 2) * 95;
        doc.addImage(imgData, 'PNG', posX, y, imgWidth, imgHeight);

        // **Tambahkan Garis Potong**
        doc.setDrawColor(0); // Warna hitam
        doc.setLineWidth(0.2);

        let cutPadding = 2; // Jarak dari kartu
        let cutLength = 5; // Panjang garis potong

        // Garis Potong Atas
        doc.line(posX - cutPadding, y, posX - cutPadding + cutLength, y); // Kiri atas
        doc.line(posX + imgWidth + cutPadding, y, posX + imgWidth + cutPadding - cutLength, y); // Kanan atas

        // Garis Potong Bawah
        doc.line(posX - cutPadding, y + imgHeight, posX - cutPadding + cutLength, y + imgHeight); // Kiri bawah
        doc.line(posX + imgWidth + cutPadding, y + imgHeight, posX + imgWidth + cutPadding - cutLength, y + imgHeight); // Kanan bawah

        // Garis Potong Kiri
        doc.line(posX, y - cutPadding, posX, y - cutPadding + cutLength); // Atas kiri
        doc.line(posX, y + imgHeight + cutPadding, posX, y + imgHeight + cutPadding - cutLength); // Bawah kiri

        // Garis Potong Kanan
        doc.line(posX + imgWidth, y - cutPadding, posX + imgWidth, y - cutPadding + cutLength); // Atas kanan
        doc.line(posX + imgWidth, y + imgHeight + cutPadding, posX + imgWidth, y + imgHeight + cutPadding - cutLength); // Bawah kanan

        if (index % 2 === 1) {
            y += imgHeight + 5;
        }

        kartuCount++;
    }

    doc.save('nomor_meja_test_ruang_{{request()->segment(3)}}.pdf');
});
</script>




            </div>

        </div>


        </div>

    </section>
</x-layout>
