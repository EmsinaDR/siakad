<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 8px;
        text-align: left;
    }

    thead {
        display: table-header-group;
        /* Memastikan thead tetap muncul di setiap halaman */
    }

    tfoot {
        display: table-footer-group;
        /* Memastikan tfoot muncul di bagian bawah setiap halaman */
    }

    .col-xl-8.d-flex {
        flex-direction: column;
        /* Mengatur elemen-elemen di bawah satu sama lain */
    }

    .text-red {
        color: red !important;
        /* Mengubah warna teks menjadi merah */
    }
</style>

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
                        btn-app/namaModal()</x-btnjs>
                </div>
            </div>
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->


            <div class='ml-2 my-4'>
                {{-- <div class="row d-flex justify-content-center">
                    <div class="col-xl-6">
                        <form id='#id' action='{{route('LaporanBulananTabungan')}}' method='POST'>
                            @csrf
                            @method('POST')
                            <div class="row">
                                <div class="col-xl-6"><x-inputallin>date:Tangga
                                        Awal:Placeholder:tanggal_awal:id_tanggal_awal::Required</x-inputallin></div>
                                <div class="col-xl-6"><x-inputallin>date:Tanggal
                                        Akhir::tanggal_akhir:id_tanggal_akhir::Required</x-inputallin></div>
                                <div class="col-xl-12 mt-2">
                                    <button type='submit' class='btn btn-default bg-primary btn-md float-right'> <i
                                            class="fa fa-search"></i> Cari Data</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div> --}}
                <!-- Tab content -->
                <div class="col-xl-12">
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
                        rel="stylesheet">

                    <div class="row">
                        <!-- Tab navigation (vertical) -->
                        <div class="col-2">
                            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-home" type="button" role="tab"
                                    aria-controls="v-pills-home" aria-selected="true">Home</button>
                                <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-profile" type="button" role="tab"
                                    aria-controls="v-pills-profile" aria-selected="false">Laporan Bulanan</button>
                                <button class="nav-link" id="v-pills-laporan-siswa-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-laporan-siswa" type="button" role="tab"
                                    aria-controls="v-pills-laporan-siswa" aria-selected="false">Rekap Tabungan
                                    Siswa</button>
                            </div>
                        </div>

                        <!-- Tab content -->
                        <div class="col-10">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                    aria-labelledby="v-pills-home-tab">
                                    <h3><b>Data Tabungan</b></h3>
                                    <div class='alert alert-info alert-dismissible'>
                                        <h5><i class='icon fas fa-info'></i> Information !</h5>
                                        <hr>
                                        <ul>
                                            <li>Menu Data ini hanya diakses oleh bendahara tabungan masing - masing
                                            </li>
                                            <li>Baian laporan adalah pembuatan rekap data berdasarkan interval waktu
                                                tertentu sesuai kebutuhan</li>
                                            <li>Rekap data global dan laporan / rekap data siswa dipisahkan pada
                                                menu
                                                masing masing</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                    aria-labelledby="v-pills-profile-tab">
                                    <h3><b>Laporan Bulanan</b></h3>
                                    <div class='alert alert-info alert-dismissible'>

                                        <h5><i class='icon fas fa-info'></i> Information !</h5>
                                        <hr>
                                        <ul>
                                            <li>Masukkan tanggal yang akan dibuat data laporan bulanan Data Keuangan
                                            </li>
                                            <li>Masukkan sesuai interval tanggal yang diinginkan, setelah klik
                                                tombol search</li>
                                            <li>Tabel data akan dibuat dan menu tonol ekspor pdf akan muncul</li>
                                        </ul>
                                    </div>
                                    <div class="card border-shadow p-3">
                                        <div class="col-xl-6">
                                            {{-- <form id='#id' action='{{route('LaporanBulananTabungan')}}' method='POST'> --}}
                                            <form id="form-laporan">
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <x-inputallin>
                                                            date:Tanggal
                                                            Awal:Placeholder:tanggal_awal:id_tanggal_awal::Required
                                                        </x-inputallin>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <x-inputallin>
                                                            date:Tanggal Akhir::tanggal_akhir:id_tanggal_akhir::Required
                                                        </x-inputallin>
                                                    </div>
                                                    <div class="col-xl-12 mt-2">
                                                        <button id='BTNpdf'type="button" onclick="generatePDF()"
                                                            class="btn btn-default bg-success btn-md float-right ml-2"><i
                                                                class="fa fa-file-pdf mr-2"></i>Export to
                                                            PDF</button>
                                                        <button type="button" id="btnKirim"
                                                            class="btn btn-default bg-primary btn-md float-right">
                                                            <i class="fa fa-search"></i> Cari Data
                                                        </button>
                                                    </div>
                                                </div>

                                            </form>

                                        </div>

                                        {{-- <table id="laporan-tabungan" width='100%' border="1"> --}}


                                        {{-- <script src="http://127.0.0.1:8000/tools/pdfq/html2pdf.bundle.min.js"></script> --}}

                                        {{-- <x-kop-surat></x-kop-surat> --}}

                                        <div id="divToExport" class='mt-1 p-2'>
                                            <x-kop-surat></x-kop-surat>
                                            <div class="col-xl-12 d-flex justify-content-center mb-3">
                                                <H2 style='font-size:20px'><b>LAPORAN DATA TABUNGAN</b></H2>
                                            </div>

                                            <div id="laporan-summary">
                                                <!-- Summary total pemasukan dan pengeluaran akan ditampilkan di sini -->
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-3 ">
                                                    <p><i class="fas fa-plus-circle"></i> Periode</p>
                                                    <p><i class="fas fa-arrow-up"></i> Total Pemasukkan</p>
                                                    <p><i class="fas fa-arrow-down"></i> Total Pengeluaran</p>
                                                </div>
                                                <div
                                                    class="col-xl-8 d-flex justify-content-start d-flex justify-content-start">
                                                    <p id='laporan-periode'> </p>
                                                    <p id='laporan-pemasukkan'> </p>
                                                    <p id='laporan-pengeluaran'> </p>
                                                </div>
                                            </div>
                                            <table id='laporan-tabungan' width='100%'
                                                class='table table-bordered table-hover'>
                                                <thead>
                                                    <tr class='table-success text-center'>
                                                        <th>No</th>
                                                        <th>Type</th>
                                                        <th>Nominal</th>
                                                        <th>Tanggal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Data akan ditambahkan di sini oleh JavaScript -->
                                                </tbody>
                                            </table>
                                        </div>
                                        <script>
                                            $('#divToExport').hide();
                                            $('#BTNpdf').hide();
                                            $(document).ready(function() {
                                                $("#btnKirim").click(function() {
                                                    // Ambil nilai dari input tanggal
                                                    var tanggalAwal = $("#id_tanggal_awal").val();
                                                    var tanggalAkhir = $("#id_tanggal_akhir").val();

                                                    // Lakukan validasi sederhana
                                                    if (!tanggalAwal || !tanggalAkhir) {
                                                        alert("Harap isi kedua tanggal sebelum mencari data.");
                                                        return;
                                                    }

                                                    // Lakukan AJAX POST
                                                    $.ajax({
                                                        url: "/bendahara/tabungan/laporan/bulanan/ajax",
                                                        type: "POST",
                                                        data: {
                                                            _token: "{{ csrf_token() }}", // Tambahkan CSRF token untuk Laravel
                                                            tanggal_awal: tanggalAwal,
                                                            tanggal_akhir: tanggalAkhir
                                                        },
                                                        success: function(response) {
                                                            if (response.data && Array.isArray(response.data)) {
                                                                var tableBody = $("#laporan-tabungan tbody");

                                                                tableBody.empty(); // Kosongkan tabel sebelum menambahkan data baru

                                                                // Format Rupiah function
                                                                function formatRupiah(amount) {
                                                                    return 'Rp ' + amount.toString().replace(
                                                                        /(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                                                                }

                                                                // Menampilkan data transaksi
                                                                response.data.forEach(function(item, index) {
                                                                    // Mengonversi nominal ke format Rupiah
                                                                    var nominalRupiah = formatRupiah(item.nominal);
                                                                    $('#divToExport').show();
                                                                    $('#BTNpdf').show();

                                                                    var rowClass = ''; // Default tidak ada kelas
                                                                    var icon = ''; // Default tidak ada ikon

                                                                    if (item.type.toLowerCase() === 'pengeluaran') {
                                                                        rowClass =
                                                                            'text-red'; // Tambahkan kelas 'text-red' jika transaksi adalah pengeluaran
                                                                        icon =
                                                                            '<i class="fas fa-arrow-down mr-2"></i> '; // Ikon untuk pengeluaran
                                                                    } else if (item.type.toLowerCase() === 'pemasukkan') {
                                                                        icon =
                                                                            '<i class="fas fa-arrow-up mr-2"></i> '; // Ikon untuk pemasukkan
                                                                    }

                                                                    var row = `
                                                                            <tr>
                                                                                <td class='text-center ${rowClass}'>${index + 1}</td> <!-- Nomor urut -->
                                                                                <td class='text-center ${rowClass}'>${icon} ${item.type}</td>
                                                                                <td class='text-center ${rowClass}'>${nominalRupiah}</td> <!-- Nominal dalam Rupiah -->
                                                                                <td class='text-center ${rowClass}'>${item.created_at}</td>
                                                                            </tr>
                                                                        `;
                                                                    tableBody.append(row);
                                                                });


                                                                // Menampilkan periode yang dikirim
                                                                var periodeSection = $("#laporan-periode");
                                                                periodeSection
                                                                    .empty(); // Kosongkan periode sebelum menambahkan yang baru
                                                                periodeSection.text(
                                                                    `: ${response.periode.tanggal_awal} sampai ${response.periode.tanggal_akhir}`
                                                                );

                                                                // Menampilkan total pemasukan
                                                                var summarySection = $("#laporan-pemasukkan");
                                                                summarySection
                                                                    .empty(); // Kosongkan summary sebelum menambahkan yang baru
                                                                summarySection.text(
                                                                    `: ${formatRupiah(response.summary.total_pemasukan)}`);
                                                                // Menampilkan total pemasukan
                                                                var summarySection = $("#laporan-pengeluaran");
                                                                summarySection
                                                                    .empty(); // Kosongkan summary sebelum menambahkan yang baru
                                                                summarySection.text(
                                                                    `: ${formatRupiah(response.summary.total_pengeluaran)}`);

                                                                // var totalPemasukan = formatRupiah(response.summary.total_pemasukan);
                                                                // var totalPengeluaran = formatRupiah(response.summary.total_pengeluaran);


                                                                // summarySection.append(`
                        //             <p>Total Pengeluaran: ${totalPengeluaran}</p>
                        //         `);

                                                                $('#laporan-tabungan tbody td').addClass('text-center');
                                                            } else {
                                                                alert("Data tidak valid");
                                                            }
                                                        },
                                                        error: function() {
                                                            alert("Terjadi kesalahan saat mengambil data");
                                                        }
                                                    });
                                                });
                                            });
                                        </script>

                                    </div>

                                </div>
                                <div class="tab-pane fade" id="v-pills-laporan-siswa" role="tabpanel"
                                    aria-labelledby="v-pills-laporan-siswa-tab">
                                    <h3><b>Data Tabungan Siswa</b></h3>
                                    <p>Rekap data tabungan siswa</p>
                                    <div class='alert alert-info alert-dismissible'>
                                        <button type='button' class='close' data-dismiss='alert'
                                            aria-hidden='true'>&times;</button>
                                        <h5><i class='icon fas fa-info'></i> Information !</h5>
                                        <hr>
                                        <ul>
                                            <li>
                                                Masukkan Pilih Siswa</li>
                                            <li>Masukkan tanggal yang akan dibuat data laporan bulanan Data Keuangan
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card border-shadow p-3">
                                        {{-- <h3>Laporan Bulanan</h3> --}}


                                        <div class="col-xl-6">
                                            {{-- <form id='#id' action='{{route('LaporanBulananTabungan')}}' method='POST'> --}}
                                            <form id="form-laporan-Siswa">
                                                @csrf
                                                <div class='form-group'>
                                                    <label for='detailsiswa_id'>Nama Siswa</label>
                                                    <select id='detailsiswa_id' name='detailsiswa_id'
                                                        class='form-control' required>
                                                        <option value=''>--- Pilih Nama Siswa ---</option>
                                                        @foreach ($dataSiswas as $newkey)
                                                            <option value='{{ $newkey->id }}'>
                                                                {{ $newkey->nama_siswa }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <x-inputallin>
                                                            date:Tanggal
                                                            Awal:Placeholder:tanggal_awal:id_tanggal_awal_siswa::Required
                                                        </x-inputallin>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <x-inputallin>
                                                            date:Tanggal
                                                            Akhir::tanggal_akhir:id_tanggal_akhir_siswa::Required
                                                        </x-inputallin>
                                                    </div>
                                                    <div class="col-xl-12 mt-2">
                                                        <button id='BTNSiswapdf'type="button"
                                                            onclick="generateSiswa()"
                                                            class="btn btn-default bg-success btn-md float-right ml-2"><i
                                                                class="fa fa-file-pdf mr-2"></i>Export to
                                                            PDF</button>
                                                        <button type="button" id="BTNKirimSiswapdf"
                                                            class="btn btn-default bg-primary btn-md float-right">
                                                            <i class="fa fa-search"></i> Cari Data
                                                        </button>
                                                    </div>
                                                </div>

                                            </form>

                                        </div>
                                        <hr class='bg-dark' style='height: 3px;'>

                                        {{-- <table id="laporan-tabungan" width='100%' border="1"> --}}


                                        {{-- <script src="http://127.0.0.1:8000/tools/pdfq/html2pdf.bundle.min.js"></script> --}}
                                        <div id="divToExportSiswa">
                                            <x-kop-surat></x-kop-surat>
                                            <div class="col-xl-12 d-flex justify-content-center mb-3">
                                                <H2 style='font-size:20px'><b>LAPORAN DATA TABUNGAN</b></H2>
                                            </div>

                                            <div id="laporan-summary">
                                                <!-- Summary total pemasukan dan pengeluaran akan ditampilkan di sini -->
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-3 ">
                                                    <p><i class="fas fa-plus-circle"></i> Periode</p>
                                                    <p><i class="fas fa-arrow-up"></i> Total Pemasukkan</p>
                                                    <p><i class="fas fa-arrow-down"></i> Total Pengeluaran</p>
                                                </div>
                                                <div
                                                    class="col-xl-8 d-flex justify-content-start d-flex justify-content-start">
                                                    <p id='laporan-periode-siswa'> </p>
                                                    <p id='laporan-pemasukkan-siswa'> </p>
                                                    <p id='laporan-pengeluaran-siswa'> </p>
                                                </div>
                                            </div>
                                            <table id='laporan-tabungan-siswa' width='100%'
                                                class='table table-bordered table-hover'>
                                                <thead>
                                                    <tr class='table-success text-center'>
                                                        <th>No</th>
                                                        <th>Type</th>
                                                        <th>Nominal</th>
                                                        <th>Tanggal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Data akan ditambahkan di sini oleh JavaScript -->
                                                </tbody>
                                            </table>
                                        </div>
                                        <script>
                                            $('#divToExportSiswa').hide();
                                            $('#BTNSiswapdf').hide();
                                            $(document).ready(function() {
                                                $("#BTNKirimSiswapdf").click(function() {
                                                    // alert('btn klik');
                                                    $('#divToExportSiswa').show();
                                                    $('#BTNSiswapdf').show();
                                                    // Ambil nilai dari input tanggal
                                                    var tanggalAwal = $("#id_tanggal_awal_siswa").val();
                                                    var tanggalAkhir = $("#id_tanggal_akhir_siswa").val();
                                                    var detailsiswa_id = $("#detailsiswa_id").val();

                                                    // Lakukan validasi sederhana
                                                    if (!tanggalAwal || !tanggalAkhir || !detailsiswa_id) {
                                                        alert(
                                                            "Harap isi ketiga parameter (Tanggal Awal, Tanggal Akhir, dan Nama Siswa) sebelum mencari data."
                                                        );
                                                        return;
                                                    }

                                                    // Lakukan AJAX POST
                                                    $.ajax({
                                                        url: "/bendahara/tabungan/laporan/bulanan/siswa-ajax",
                                                        type: "POST",
                                                        data: {
                                                            _token: "{{ csrf_token() }}",
                                                            tanggal_awal: tanggalAwal,
                                                            tanggal_akhir: tanggalAkhir,
                                                            detailsiswa_id: detailsiswa_id
                                                        },
                                                        success: function(response) {
                                                            if (response.data && Array.isArray(response.data)) {
                                                                var tableBody = $("#laporan-tabungan-siswa tbody");

                                                                tableBody.empty(); // Kosongkan tabel sebelum menambahkan data baru

                                                                // Format Rupiah function
                                                                function formatRupiah(amount) {
                                                                    return 'Rp ' + amount.toString().replace(
                                                                        /(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                                                                }

                                                                // Menampilkan data transaksi
                                                                response.data.forEach(function(item, index) {
                                                                    // Mengonversi nominal ke format Rupiah
                                                                    var nominalRupiah = formatRupiah(item.nominal);
                                                                    $('#divToExport').show();
                                                                    $('#BTNpdf').show();

                                                                    var rowClass = ''; // Default tidak ada kelas
                                                                    var icon = ''; // Default tidak ada ikon

                                                                    if (item.type.toLowerCase() === 'pengeluaran') {
                                                                        rowClass =
                                                                            'text-red'; // Tambahkan kelas 'text-red' jika transaksi adalah pengeluaran
                                                                        icon =
                                                                            '<i class="fas fa-arrow-down mr-2"></i> '; // Ikon untuk pengeluaran
                                                                    } else if (item.type.toLowerCase() === 'pemasukkan') {
                                                                        icon =
                                                                            '<i class="fas fa-arrow-up mr-2"></i> '; // Ikon untuk pemasukkan
                                                                    }

                                                                    var row = `
                                                                            <tr>
                                                                                <td class='text-center ${rowClass}'>${index + 1}</td> <!-- Nomor urut -->
                                                                                <td class='text-center ${rowClass}'>${icon} ${item.type}</td>
                                                                                <td class='text-center ${rowClass}'>${nominalRupiah}</td> <!-- Nominal dalam Rupiah -->
                                                                                <td class='text-center ${rowClass}'>${item.created_at}</td>
                                                                            </tr>
                                                                        `;
                                                                    tableBody.append(row);
                                                                });


                                                                // Menampilkan periode yang dikirim
                                                                var periodeSection = $("#laporan-periode-siswa");
                                                                periodeSection
                                                                    .empty(); // Kosongkan periode sebelum menambahkan yang baru
                                                                periodeSection.text(
                                                                    `: ${response.periode.tanggal_awal} sampai ${response.periode.tanggal_akhir}`
                                                                );

                                                                // Menampilkan total pemasukan
                                                                var summarySection = $("#laporan-pemasukkan-siswa");
                                                                summarySection
                                                                    .empty(); // Kosongkan summary sebelum menambahkan yang baru
                                                                summarySection.text(
                                                                    `: ${formatRupiah(response.summary.total_pemasukan)}`);
                                                                // Menampilkan total pemasukan
                                                                var summarySection = $("#laporan-pengeluaran-siswa");
                                                                summarySection
                                                                    .empty(); // Kosongkan summary sebelum menambahkan yang baru
                                                                summarySection.text(
                                                                    `: ${formatRupiah(response.summary.total_pengeluaran)}`);

                                                                // var totalPemasukan = formatRupiah(response.summary.total_pemasukan);
                                                                // var totalPengeluaran = formatRupiah(response.summary.total_pengeluaran);


                                                                // summarySection.append(`
                        //             <p>Total Pengeluaran: ${totalPengeluaran}</p>
                        //         `);

                                                                $('#laporan-tabungan tbody td').addClass('text-center');
                                                            } else {
                                                                alert("Data tidak valid");
                                                            }
                                                        },
                                                        error: function() {
                                                            alert("Terjadi kesalahan saat mengambil data");
                                                        }
                                                    });
                                                });
                                            });
                                        </script>

                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-contactx" role="tabpanel"
                                    aria-labelledby="v-pills-contactx-tab">
                                    <h3>Data Tabungan Siswa</h3>
                                    <p>Feel free to contact us.</p>

                                </div>
                            </div>
                        </div>
                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
                </div>


            </div>

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

<script type="text/javascript">
    function generatePDF() {
        var element = document.getElementById('divToExport');

        var opt = {
            margin: 10,
            filename: 'data.pdf',
            image: {
                type: 'jpeg',
                quality: 1
            },
            html2canvas: {
                scale: 2, // Meningkatkan resolusi PDF
                backgroundColor: null, // ✅ Biarkan background tetap ada
                useCORS: true, // ✅ Pastikan gambar/background dari URL luar tetap ada
                logging: true // ✅ Debugging untuk melihat error jika ada
            },
            jsPDF: {
                unit: 'mm',
                format: 'letter',
                orientation: 'portrait',
                precision: '12'
            }
            // function generatePDF() {
            //     const element = document.querySelector('table');
            //     html2pdf()
            //         .from(element)
            //         .set({
            //             margin: 10,
            //             filename: 'tabel-dengan-header-footer.pdf',
            //             html2canvas: {
            //                 scale: 2
            //             },
            //             jsPDF: {
            //                 unit: 'mm',
            //                 format: 'a4',
            //                 orientation: 'portrait'
            //             }
            //         })
            //         .save();
            // }

            // // Panggil fungsi generatePDF saat diperlukan
            // generatePDF();
        };
        html2pdf().set(opt).from(element).save();

    }

    function generateSiswa() {
        var element = document.getElementById('divToExportSiswa');

        var opt = {
            margin: 0,
            filename: 'Data Tabungan Siswa.pdf',
            image: {
                type: 'jpeg',
                quality: 1
            },
            html2canvas: {
                scale: 2, // Meningkatkan resolusi PDF
                backgroundColor: null, // ✅ Biarkan background tetap ada
                useCORS: true, // ✅ Pastikan gambar/background dari URL luar tetap ada
                logging: true // ✅ Debugging untuk melihat error jika ada
            },
            jsPDF: {
                unit: 'in',
                format: 'letter',
                orientation: 'portrait',
                precision: '12'
            }
        };

        html2pdf().set(opt).from(element).save();
    }
</script>
