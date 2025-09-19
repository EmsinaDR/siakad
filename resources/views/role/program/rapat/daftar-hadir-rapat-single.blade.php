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
            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <button id='BTNpdf' type='button' onclick='generatePDF()'
                            class='btn btn-default bg-success btn-md'> <i class='fa fa-file-pdf mr-2'></i>Export to PDF
                        </button>


                        <div id='divToExport' class='mt-1'>
                            <x-kop-surat></x-kop-surat>
                            <h3 class='text-center'><b>Daftar Hadir Rapat</b></h3>
                            <div class="row">
                                <div class="row ml-3">
                                    <div class="col-xl-3">
                                        <p style="display: inline-block; width: 150px;">
                                            Nama Acara
                                        </p>
                                        <p style="display: inline-block; width: 150px;">
                                            Pukul
                                        </p>
                                        <p style="display: inline-block; width: 150px;">
                                            Tempat
                                        </p>
                                    </div>
                                    <div class="col-xl-9">
                                        <p style="display: inline-block; width: 10px;">:</p>
                                        <p style="display: inline-block;">
                                            {{ $datas->nama_rapat }} <br>
                                        </p> <br>
                                        <p style="display: inline-block; width: 10px;">:</p>
                                        <p style="display: inline-block;">
                                            {{ $datas->jam_mulai }} - {{ $datas->jam_selesai }}
                                        </p><br>
                                        <p style="display: inline-block; width: 10px;">:</p>
                                        <p style="display: inline-block;">
                                            {{ $datas->tempat }}
                                        </p><br>
                                    </div>
                                </div>
                            </div>
                            <table id='example1x' class='table table-bordered table-hover'>
                                <thead>
                                    <tr class='table-primary text-center align-middle'>
                                        <th>ID</th>
                                        <th>Nama Guru</th>
                                        <th class="tanda-tangan">Tanda Tangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (json_decode($datas->vote_id) as $data)
                                        {{-- blade-formatter-disable --}}
                                        @php
                                            $DataGuru = \App\Models\User\Guru\Detailguru::where('id', $data )->first();
                                        @endphp
                                        {{-- blade-formatter-enable --}}
                                        <tr class="text-center">
                                            <td>{{ $loop->iteration }}</td>
                                            <td  class='text-left'>{{ $DataGuru->nama_guru }}</td>
                                            <td
                                                class="{{ $loop->iteration % 2 == 0 ? 'text-right' : 'text-left' }} tanda-tangan">
                                                {{ $loop->iteration }}. .....................
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class='table-primary text-center align-middle'>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Tanda Tangan</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- CSS -->
                        <style>
                            .tanda-tangan {
                                width: 30%;
                                /* Atur lebar kolom tanda tangan */
                                white-space: nowrap;
                                /* Mencegah teks membungkus */
                                padding: 10px 20px;
                                /* Menambahkan padding agar tidak terlalu sempit */
                            }

                            /* Pastikan tanda tangan bisa diratakan dengan benar */
                            .text-right {
                                text-align: right;
                            }

                            .text-left {
                                text-align: left;
                            }
                        </style>


                        <script>
                            function generatePDF() {
                                // Ambil elemen yang ingin diekspor ke PDF
                                const element = document.getElementById('divToExport');

                                // Konfigurasi opsi untuk konversi HTML ke PDF
                                const options = {
                                    margin: [10, 10, 0, 10], // Menghapus margin untuk menghindari halaman kosong [atas, kanan, bawah, kiri]
                                    filename: 'Daftar Hadir Rapat.pdf', // Nama file yang akan diunduh

                                    // Konfigurasi gambar dalam PDF
                                    image: {
                                        type: 'jpeg', // Format gambar dalam PDF
                                        quality: 0.98 // Kualitas gambar (0-1), semakin tinggi semakin bagus
                                    },

                                    // Pengaturan untuk html2canvas (digunakan untuk menangkap elemen HTML)
                                    html2canvas: {
                                        scale: 2, // Meningkatkan skala untuk meningkatkan kualitas hasil tangkapan
                                        scrollY: 0 // Mencegah efek scroll saat menangkap elemen
                                    },

                                    // Konfigurasi untuk jsPDF (library yang menangani pembuatan PDF)
                                    jsPDF: {
                                        unit: 'mm', // Menggunakan satuan milimeter
                                        format: 'legal', // Ukuran kertas yang digunakan (Legal: 216 × 356 mm)
                                        // format: [210, 400] // (Opsional) Custom ukuran kertas jika diperlukan
                                        orientation: 'portrait' // Mode orientasi PDF (portrait atau landscape)
                                    }
                                };

                                // Proses konversi elemen HTML menjadi PDF dan mengunduhnya
                                html2pdf().from(element).set(options).save();
                            }
                        </script>


                    </div>
                </div>
            </div>


        </div>

    </section>
</x-layout>
