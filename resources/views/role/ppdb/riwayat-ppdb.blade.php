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
        <div class='card'>
            {{-- Papan Informasi --}}

            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->


            <div class='ml-2 my-4'>
                <div class="row my-2">
                    <div class="col-xl-2">
                        <button type='button' class='btn btn-block btn-default bg-primary btn-md'
                            onclick='DataRekapSekolah()'> <i class="fa fa-school"> Data Rekap</i></button>
                        <button type='button' class='btn btn-block btn-default bg-primary btn-md'
                            onclick='FormulirPPDB()'> <i class="fa fa-file"> </i> Data Formulir</button>
                    </div>
                </div>
                {{-- Data Penerimaan dalam 3 tahun --}}
                <div class="card">


                    <div class='card-header bg-primary mb-2'>
                        <h3 class='card-title'><b>Data Penerimaan Dalam 3 Tahun</b></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- TABEL DATA -->
                            <div class="col-xl-6">
                                <table id='example0' width='100%'
                                    class='table table-responsive table-bordered table-hover'>
                                    <thead>
                                        <tr class='table-success text-center align-middle'>
                                            <th>ID</th>
                                            <th>Tahun</th>
                                            <th>Diterima</th>
                                            <th>Ditolak</th>
                                            <th>Menunggu</th>
                                            <th>Total Pendaftar</th>
                                            <th>Catatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datas_old as $data)
                                            <tr class='text-center align-middle'>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->Tahun->tapel }}</td>
                                                <td><span class="bg-success p-2">{{ $data->jumlah_diterima }}</span>
                                                </td>
                                                <td><span class="bg-danger p-2">{{ $data->jumlah_ditolak }}</span></td>
                                                <td><span class="bg-warning p-2">{{ $data->jumlah_pending }}</span></td>
                                                <td>{{ $data->total_pendaftar }}</td>
                                                <td>{{ Number::forHumans($data->jumlah_diterima / 32) }} Kelas</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tahun</th>
                                            <th>Diterima</th>
                                            <th>Ditolak</th>
                                            <th>Menunggu</th>
                                            <th>Total Pendaftar</th>
                                            <th>Catatan</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <!-- DIAGRAM BATANG -->
                            <div class="col-xl-6">
                                <canvas id="chartPerbandingan"></canvas>
                            </div>
                        </div>
                    </div>

                    {{-- Tambahkan Chart.js --}}
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            var ctx = document.getElementById("chartPerbandingan").getContext("2d");

                            var tahunLabels = @json($datas_old->pluck('Tahun.tapel')); // Ambil tahun dari datas_old
                            var diterimaData = @json($datas_old->pluck('jumlah_diterima'));
                            var ditolakData = @json($datas_old->pluck('jumlah_ditolak'));
                            var pendingData = @json($datas_old->pluck('jumlah_pending'));

                            var chart = new Chart(ctx, {
                                type: "bar",
                                data: {
                                    labels: tahunLabels,
                                    datasets: [{
                                            label: "Diterima",
                                            data: diterimaData,
                                            backgroundColor: "rgba(40, 167, 69, 0.7)", // Hijau
                                            borderColor: "rgba(40, 167, 69, 1)",
                                            borderWidth: 1,
                                        },
                                        {
                                            label: "Ditolak",
                                            data: ditolakData,
                                            backgroundColor: "rgba(220, 53, 69, 0.7)", // Merah
                                            borderColor: "rgba(220, 53, 69, 1)",
                                            borderWidth: 1,
                                        },
                                        {
                                            label: "Menunggu",
                                            data: pendingData,
                                            backgroundColor: "rgba(255, 193, 7, 0.7)", // Kuning
                                            borderColor: "rgba(255, 193, 7, 1)",
                                            borderWidth: 1,
                                        }
                                    ],
                                },
                                options: {
                                    responsive: true,
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                        },
                                    },
                                },
                            });
                        });
                    </script>
                    {{-- Data Penerimaan dalam 3 tahun --}}

                </div>
                {{-- Data Perubahan 3 Tahun --}}
                <div class="card">
                    <div class='card-header bg-primary mb-4'>
                        <h3 class='card-title'><b>Perubahan Data Penerimaan Dalam 3 Tahun</b></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- TABEL DATA -->
                            <div class="col-xl-6">
                                <table id='example2' width='100%' class='table table-bordered table-hover'>
                                    <thead>
                                        <tr class='text-center align-middle'>
                                            <th>ID</th>
                                            <th>Tahun</th>
                                            <th>Jumlah Diterima</th>
                                            <th>Perubahan</th>
                                            <th>Persentase</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($trenData as $tahun => $data)
                                            <tr class='text-center align-middle'>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    @php
                                                        $tahun_ppdb = App\Models\Admin\Etapel::find($tahun);
                                                        $datatapel;
                                                    @endphp
                                                    {{ $tahun_ppdb->tapel }}
                                                </td>
                                                <td>{{ $data['jumlah_diterima'] }}</td>
                                                <td>
                                                    @if ($data['perubahan'] !== null)
                                                        @php
                                                            $arrowIcon =
                                                                $data['perubahan'] > 0
                                                                    ? 'fa-arrow-up'
                                                                    : ($data['perubahan'] < 0
                                                                        ? 'fa-arrow-down'
                                                                        : 'fa-arrow-right');
                                                            $arrowColor =
                                                                $data['perubahan'] > 0
                                                                    ? 'text-success'
                                                                    : ($data['perubahan'] < 0
                                                                        ? 'text-danger'
                                                                        : 'text-warning');
                                                        @endphp
                                                        <span class="{{ $arrowColor }}">
                                                            <i class="fa {{ $arrowIcon }}"></i>
                                                            {{ $data['perubahan'] > 0 ? '+' : '' }}{{ $data['perubahan'] }}
                                                        </span>
                                                    @else
                                                        <span>-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($data['persentase_perubahan'] !== 'N/A')
                                                        @php
                                                            $badgeColor =
                                                                $data['persentase_perubahan'] > 0
                                                                    ? 'bg-success'
                                                                    : ($data['persentase_perubahan'] < 0
                                                                        ? 'bg-danger'
                                                                        : 'bg-warning');
                                                        @endphp
                                                        <span class="badge p-2 {{ $badgeColor }}">
                                                            {{ $data['persentase_perubahan'] }}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-secondary">Data Awal</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tahun</th>
                                            <th>Jumlah Diterima</th>
                                            <th>Perubahan</th>
                                            <th>Persentase</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <!-- DIAGRAM BATANG -->
                            <div class="col-xl-6">
                                <canvas id="chartPenerimaan"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Tambahkan Chart.js --}}
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        var ctx = document.getElementById('chartPenerimaan').getContext('2d');
                        var dataPenerimaan = {
                            labels: @json(array_values(array_column($trenData, 'tapel'))), // Label Tahun Akademik
                            datasets: [{
                                label: 'Data PPDB',
                                data: @json(array_values(array_column($trenData, 'jumlah_diterima'))),
                                backgroundColor: ['#007bff', '#28a745', '#dc3545'], // Warna Bar
                                // borderColor: '#000000',
                                borderWidth: 1
                            }]
                        };

                        var chartPenerimaan = new Chart(ctx, {
                            type: 'bar',
                            data: dataPenerimaan,
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    });
                </script>



                {{-- Data Perubahan 3 Tahun --}}
                <div class='card'>
                    <div class='card-header bg-success'>
                        <h3 class='card-title'>Data Pendaftar</h3>
                    </div>
                    <div class='card-body'>
                        <table id='example3' width='100%' class='table table-responsive table-bordered table-hover'>
                            <thead>
                                <tr class='text-center table-success text-middle'>
                                    <th width='1%'>ID</th>
                                    @foreach ($arr_ths as $arr_th)
                                        <th class='text-center'> {{ $arr_th }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataRiwayat as $data)
                                    <tr>
                                        <td class='text-center'>{{ $loop->iteration }}</td>
                                        <td class='text-center'> {{ $data->Tahun->tapel }} /
                                            {{ $data->Tahun->tapel + 1 }}
                                        </td>
                                        <td class='text-center'> {{ $data->nomor_peserta }}</td>
                                        <td class='text-center'> {{ $data->status_penerimaan }}</td>
                                        <td class='text-center'> {{ $data->nama_calon }}</td>
                                        <td class='text-center'> {{ $data->namasek_asal }}</td>


                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class='text-center'>
                                    <th width='1%'>ID</th>
                                    @foreach ($arr_ths as $arr_th)
                                        <th class='text-center'> {{ $arr_th }}</th>
                                    @endforeach
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </section>
</x-layout>

{{-- <button class='btn btn-warning btn-sm' onclick='DataRekapSekolah()'><i class='fa fa-edit right'></i> Edit</button> --}}

<script>
    function DataRekapSekolah(data) {
        var DataRekapSekolah = new bootstrap.Modal(document.getElementById('DataRekapSekolah'));
        DataRekapSekolah.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='DataRekapSekolah' tabindex='-1' aria-labelledby='LabelDataRekapSekolah' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelDataRekapSekolah'>
                    Data Rekapitulasi Sekolah
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>


                {{-- Data Siswa Daftar 3 tahun masing masing sekolah --}}

                <table id='example4' width='100%' class='table table-bordered table-hover'>
                    <thead>
                        <tr class='text-center text-middle'>
                            <th rowspan='2' width='1%' class='text-center align-middle'>ID</th>
                            <th rowspan='2' class='text-center align-middle'>Sekolah Asal</th>
                            <th colspan='3' class='text-center align-middle'>Tahun</th>
                        </tr>
                        @if (!empty($data_sekolah['years']))
                            @foreach ($data_sekolah['years'] as $year)
                                <th width='5%' class='text-center align-middle'>
                                    @php
                                        $find_Etapel = App\Models\Admin\Etapel::find($year);
                                    @endphp
                                    {{ $find_Etapel->tapel }}
                                </th>
                            @endforeach
                        @endif
                    </thead>

                    <tbody>
                        @foreach ($data_sekolah['pivotData'] as $school => $yearData)
                            <tr>
                                <td width='1%'>{{ $loop->iteration }}</td>
                                <td>{{ $school }}</td>
                                @php $previousValue = null; @endphp {{-- Inisialisasi nilai sebelumnya --}}

                                @foreach ($data_sekolah['years'] as $year)
                                    @php
                                        $currentValue = $yearData[$year] ?? 0;
                                        $class = 'bg-secondary text-white'; // Default warna abu-abu
                                        $icon = ''; // Default tidak ada ikon
                                        $iconClass = ''; // Kelas ikon Font Awesome

                                        if ($previousValue !== null) {
                                            if ($currentValue > $previousValue) {
                                                $class = 'bg-success text-white'; // Kenaikan
                                                $iconClass = 'fa fa-arrow-up'; // Icon naik
                                            } elseif ($currentValue < $previousValue) {
                                                $class = 'bg-danger text-white'; // Penurunan
                                                $iconClass = 'fa fa-arrow-down'; // Icon turun
                                            } else {
                                                $class = 'bg-warning text-dark'; // Tetap
                                                $iconClass = 'fa fa-arrow-right'; // Icon tetap
                                            }
                                        }
                                    @endphp

                                    <td width='10%' class='text-center align-middle'>
                                        <span class="badge rounded {{ $class }}">

                                            @if ($previousValue !== null)
                                                <i class="{{ $iconClass }} p-1"></i>
                                            @endif
                                            {{ $currentValue }}
                                        </span>

                                    </td>

                                    @php $previousValue = $currentValue; @endphp {{-- Update nilai sebelumnya --}}
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- Data Siswa Daftar 3 tahun masing masing sekolah --}}

            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
            </div>
        </div>
    </div>

</div>
{{-- <button class='btn btn-warning btn-sm' onclick='FormulirPPDB()'><i class='fa fa-edit right'></i> Edit</button> --}}
{{--
onclick='FormulirPPDB()'
 --}}

<script>
    function FormulirPPDB(data) {
        var FormulirPPDB = new bootstrap.Modal(document.getElementById('FormulirPPDB'));
        FormulirPPDB.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='FormulirPPDB' tabindex='-1' aria-labelledby='LabelFormulirPPDB' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelFormulirPPDB'>
                    Formulit PPDB
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <form id='update' action='{{ route('siswa.store') }}' method='POST'>
                    @csrf
                    @method('POST')
                    <x-formulir-p-p-d-b></x-formulir-p-p-d-b>
                </form>

            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
            </div>
        </div>
    </div>

</div>
<script>
    $(document).ready(function() {
        initDataTable('#example0', 'Data Penerimaan Dalam 3 Tahun', '#example0_wrapper .col-md-6:eq(0)');
        initDataTable('#example2', 'Perubahan Data Penerimaan Dalam 3 Tahun', '#example2_wrapper .col-md-6:eq(0)');
        // initDataTable('#example2', 'Data Pendaftaran', '#example2_wrapper .col-md-6:eq(0)');
        initDataTable('#example3', 'Data Pendaftaran', '#example3_wrapper .col-md-6:eq(0)');
        initDataTable('#example4', 'Data Rekapitulasi Sekolah', '#example4_wrapper .col-md-6:eq(0)');
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

            // lengthChange: true,  // (Opsional) Jika diaktifkan, pengguna dapat mengubah jumlah data yang ditampilkan
            // autoWidth: false,    // (Opsional) Pastikan ini aktif jika ingin kontrol lebih besar atas lebar kolom
            // paging: true,        // (Opsional) Mengaktifkan pagination (jika ingin menampilkan semua data, bisa di-set ke false)
            // pageLength: 25,      // (Opsional) Menentukan jumlah data yang ditampilkan per halaman (default: 10)

            // ordering: true,      // (Opsional) Mengaktifkan fitur sorting pada kolom
            // order: [[1, 'desc']], // (Opsional) Menentukan sorting default (misal: kolom index ke-1, urutan descending)

            // searching: true,     // (Opsional) Mengaktifkan fitur pencarian global dalam tabel
            // fixedHeader: true,   // (Opsional) Header tabel tetap terlihat saat pengguna melakukan scroll ke bawah
            // scrollX: true,       // (Opsional) Mengaktifkan scroll horizontal jika tabel terlalu lebar

            //buttons: ['copy', 'excel', 'pdf', 'colvis'] // Menambahkan tombol export dan visibilitas kolom

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
            rowGroup: {
                dataSrc: 0
            } // Mengelompokkan berdasarkan kolom pertama (index 0)
        });

        // Menambahkan tombol-tombol di atas tabel
        table.buttons().container().appendTo(buttonContainer);
    }
</script>
