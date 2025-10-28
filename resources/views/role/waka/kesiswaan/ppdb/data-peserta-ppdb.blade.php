@php
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
        {{-- Papan Informasi --}}
        <div class='row'>
            <div class='col'>
                <!-- Papan Informasi  -->
                <div class='row mx-2'>
                    <div class='col-lg-4 col-6'>
                        <!-- small box / Data BOX-->
                        <div class='small-box bg-info'><!-- Background -->
                            <h3 class='m-2'>Jenis Kelamin</h3><!-- Judul -->
                            <div class='inner'><!-- Isi Kontent -->
                                <div class='d-flex justify-content-between'>
                                    <span>Laki - Laki</span><span>{{ $datas->where('jenis_kelamin', '1')->count() }}
                                        Orang</span>
                                </div>
                                <div class='d-flex justify-content-between'>
                                    <span>Perempuan</span><span>{{ $datas->where('jenis_kelamin', '2')->count() }}
                                        Orang</span>
                                </div>
                                <div class='d-flex justify-content-between'>
                                    <span>Total</span><span>{{ $datas->count() }} Orang</span>
                                </div>
                            </div>
                            <div class='icon'>
                                <i class='fa fa-pie'></i><!-- Icon -->
                            </div>
                            <a href='#' class='small-box-footer'>More info <i
                                    class='fas fa-arrow-circle-right'></i></a>
                        </div>
                        <!-- small box -->
                    </div>
                    <!-- ./col -->
                    <div class='col-lg-4 col-6'>
                        <!-- small box / Data BOX-->
                        <div class='small-box bg-success'><!-- Background -->
                            <h3 class='m-2'>Sekolah Pendaftar</h3><!-- Judul -->
                            <div class='inner'><!-- Isi Kontent -->
                                <div class='d-flex justify-content-between'>
                                    <span>Unik
                                        Sekolah</span><span>{{ $datas->pluck('namasek_asal')->unique()->count() }}
                                        Sekolah</span>
                                </div>
                                <div class='d-flex justify-content-between'>
                                    <span> <br></span><span> </span>
                                </div>
                                <div class='d-flex justify-content-between'>
                                    <span>Total</span><span>{{ $datas->pluck('namasek_asal')->unique()->count() }}</span>
                                </div>
                            </div>
                            <div class='icon'>
                                <i class='fa fa-solid fa-school'></i><!-- Icon -->
                            </div>
                            <a href='#' class='small-box-footer'>More info <i
                                    class='fas fa-arrow-circle-right'></i></a>
                        </div>
                        <!-- small box -->
                    </div>
                    <!-- ./col -->
                    <div class='col-lg-4 col-6'>
                        <!-- small box / Data BOX-->
                        <div class='small-box bg-warning'><!-- Background -->
                            <h3 class='m-2'>Jalur Masuk</h3><!-- Judul -->
                            <div class='inner'><!-- Isi Kontent -->
                                <div class='d-flex justify-content-between'>
                                    <span>Prestasi</span><span>{{$datas->where('jalur', 'Prestasi')->count()}}</span>
                                </div>
                                <div class='d-flex justify-content-between'>
                                    <span>Reguler</span><span>{{$datas->where('jalur', 'Reguler')->count()}}</span>
                                </div>
                                <div class='d-flex justify-content-between'>
                                    <span>Afirmasi</span><span>{{$datas->where('jalur', 'Afirmasi')->count()}}</span>
                                </div>
                            </div>
                            <div class='icon'>
                                <i class='fa fa-door-open'></i><!-- Icon -->
                            </div>
                            <a href='#' class='small-box-footer'>More info <i
                                    class='fas fa-arrow-circle-right'></i></a>
                        </div>
                        <!-- small box -->
                    </div>
                    <!-- ./col -->
                </div>
                <!-- Papan Informasi  -->
                {{-- <x-footer></x-footer> --}}


            </div>
        </div>
        <div class='card'>

            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->
            <div class='ml-2 my-4'>
                <div class="row gap-1">
                    <div class="col-xl-5">
                        <div class="card p-2">
                            <div class="card-header bg-primary mb-4">
                                <h3 class="card-title">Pemetaan Pendaftar</h3>
                            </div>
                            {{-- <div class='card-body'> --}}
                            <table id='example0' width='100%' class='table table-bordered table-hover'>
                                <thead>
                                    <tr class='text-center align-middle'>
                                        <th class='text-center align-middle' rowspan='2'>ID</th>
                                        <th class='text-center align-middle' rowspan='2'>Asal Sekolah</th>
                                        <th class='text-center align-middle' colspan='2'>J. Kelamin</th>
                                        <th class='text-center align-middle' rowspan='2'>Jumlah</th>
                                    </tr>
                                    <th>L</th>
                                    <th>P</th>
                                </thead>
                                <tbody>
                                    @foreach ($kelompok_sekolah as $index => $sekolah)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td class="text-center">{{ $sekolah->namasek_asal }}</td>
                                            <td class="text-center">{{ $sekolah->laki_laki }}</td>
                                            <td class="text-center">{{ $sekolah->perempuan }}</td>
                                            <td class="text-center">{{ $sekolah->total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Asal Sekolah</th>
                                        <th>L</th>
                                        <th>P</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </tfoot>
                            </table>
                            {{-- </div> --}}
                        </div>
                    </div>
                    <div class="col-xl-7">
                        <div class="card p-2">
                            <div class='card-header bg-primary'>
                                <h3 class='card-title'>Riwayat Pendaftaran</h3>
                            </div>
                            <div class='card-body'>
                                <table id='example1' width='100%'
                                    class='table table-responsive table-bordered table-hover'>
                                    <thead>
                                        <tr class='text-center'>
                                            <th width='1%'>ID</th>
                                            @foreach ($arr_ths as $arr_th)
                                                <th class='text-center'> {{ $arr_th }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datas as $data)
                                            <tr>
                                                <td class='text-center'>{{ $loop->iteration }}</td>
                                                <td class='text-center'> {{ $data->nomor_peserta }}</td>
                                                <td class='text-center'> {{ $data->status_penerimaan }}</td>
                                                <td class='text-center'> {{ $data->nama_calon }}</td>
                                                <td class='text-center'> {{ $data->namasek_asal }}</td>


                                            </tr>
                                            {{-- Modal View Data Akhir --}}
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class='text-center'>
                                            <th width='1%'>ID</th>
                                            @foreach ($arr_ths as $arr_th)
                                                <th class='text-center'> {{ $arr_th }}</th>
                                            @endforeach
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


<script>
    $(document).ready(function() {
        initDataTable('#example1', 'Data Calon Siswa', '#example1_wrapper .col-md-6:eq(0)');
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
                targets: -1, // Kolom terakhir (Action)
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
