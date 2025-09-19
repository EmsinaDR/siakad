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
                       <button type='button' class='btn btn-block btn-default bg-secondary btn-md' onclick='window.location.href=`{{ route('berita-acara-rapat.index')}}`'><i class='fa fa-undo'></i> Kembali</button>
                   </div>
                   <div class='col-xl-10'></div>
               </div>
               {{-- blade-formatter-enable --}}


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
                            <h3 class='text-center'><b>BERITA ACARA</b></h3>
                            <div class="col-xl-12 mt-4">
                                <p>Pada hari {{ Carbon::create($datas->tanggal_pelaksanaan)->translatedformat('l') }} di bulan {{ Carbon::create($datas->tanggal_pelaksanaan)->translatedformat('F') }} Tahun {{ Carbon::create($datas->tanggal_pelaksanaan)->translatedformat('Y') }},
                                    pukul {{ $datas->jam_mulai }} sampai dengan {{ $datas->jam_selesai }} telah
                                    dilaksanakan
                                    <b>{{ $datas->nama_rapat }}</b> tahun pelajaran {{ date('Y') }} dipimpin oleh
                                    <b>{{ $datas->ketua }}</b> yang bertempat di <b>{{ $datas->tempat }}</b> dan menghasilkan :
                                </p>
                                {!! $datas->notulen !!}.
                                <p>Demikian berita acara ini dibuat dengan sebenarnya dan sesuai dengan fakta yang dapat
                                    dipertanggungjawabkan kebenarannya.</p>

                            </div>
                        </div>

                        <script>
                            function generatePDF() {
                                // Ambil elemen yang ingin diekspor ke PDF
                                const element = document.getElementById('divToExport');

                                // Konfigurasi opsi untuk konversi HTML ke PDF
                                const options = {
                                    margin: [10, 10, 0, 10], // Menghapus margin untuk menghindari halaman kosong [atas, kanan, bawah, kiri]
                                    filename: 'Berita Acara Rapat {{ $datas->nama_rapat }}.pdf', // Nama file yang akan diunduh

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
<script>
    $(document).ready(function() {
        initDataTable('#example1', 'Data Peserta Ekstra', '#example1_wrapper .col-md-6:eq(0)');
        initDataTable('#example2', 'Data Peserta Ekstra 2', '#example2_wrapper .col-md-6:eq(0)');
    });

    // Fungsi untuk inisialisasi DataTable
    function initDataTable(tableId, exportTitle, buttonContainer) {
        // Hancurkan DataTable jika sudah ada
        $(tableId).DataTable().destroy();

        // Inisialisasi DataTable
        var table = $(tableId).DataTable({
            lengthChange: true, //False jika ingin dilengkapi dropdown
            autoWidth: false,
            responsive: true, // Membuat tabel menjadi responsif agar bisa menyesuaikan dengan ukuran layar
            lengthChange: true, // Menampilkan dropdown untuk mengatur jumlah data per halaman
            autoWidth: false, // Mencegah DataTables mengatur lebar kolom secara otomatis agar tetap sesuai dengan CSS
            buttons: [{
                    extend: 'copy',
                    title: exportTitle,
                    exportOptions: {
                        columns: ':visible:not(.noprint)'
                    }
                },
                {
                    extend: 'excel',
                    title: exportTitle,
                    exportOptions: {
                        columns: ':visible:not(.noprint)'
                    }
                },
                {
                    extend: 'pdf',
                    title: exportTitle,
                    orientation: 'landscape', // Ubah ke 'portrait' jika ingin mode potrait
                    exportOptions: {
                        columns: ':visible:not(.noprint)'
                    }
                },
                {
                    extend: 'colvis',
                    titleAttr: 'Pilih Kolom'
                }
            ],
            columnDefs: [{
                targets: -1, // Kolom terakhir (Action) bisgunkan array contoh [-1, -2, -4]
                visible: false // Menyembunyikan kolom Action
            }],
            rowGroup: {
                dataSrc: 0
            } // Mengelompokkan berdasarkan kolom pertama (index 0)
        });

        // Menambahkan tombol-tombol di atas tabel
        table.buttons().container().appendTo(buttonContainer);
    }
</script>
