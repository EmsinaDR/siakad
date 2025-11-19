@php
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
@endphp
<!DOCTYPE html>
<html lang="en">

<!-- Bootstrap JS and dependencies -->
@if (session('success'))
    <div class="m-4">
        <script>
            //   var Toast = Swal.mixin({
            //       toast: true
            //       , position: 'top-end'
            //       , showConfirmButton: false
            //       , timer: 3000
            //   });

            //   Toast.fire({
            //       icon: 'success'
            //       , title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
            //   })

            //   $('.toastsDefaultSuccess').click(function() {
            $(document).Toasts('create', {
                autohide: true,
                delay: 5000,
                class: 'bg-success',
                title: @json(session('Title'))

                    ,
                body: @json(session('success'))

            })
            //   });
        </script>
    </div>
@endif

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Scan QR Code</title>
    <!-- Bootstrap CSS -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    {{-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet"> --}}
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
       <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/toastr/toastr.min.css') }}">

    <style>
        body {
            background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQlkf5w_kMhasj8ERvaGvasnxqX76OUDGOLuA&s');
            background-size: cover;
            background-repeat: no-repeat;
        }

        /* .body {
            width: 100%;
        } */

        .containerscan {
            /* width: 1500px; */
            margin-top: 50px;
            margin-left: 20px;
            margin-right: 20px;

        }

        .header-tagline {
            margin: 20px;
        }

        .header-tagline img {
            /* margin-top: -20px; */
        }

        .text-start {
            margin-left: 10px;
        }

        .cam {
            margin-left: -10px;
        }

        .tableview {
            margin-left: 5px;
            margin-top: 20px;
            /* widows: 80%; */
            font-size: 18px;
        }
    </style>
</head>

<x-plugins-multiple-select-header></x-plugins-multiple-select-header>
<x-alert-header></x-alert-header>
<x-plugins-tabel-header></x-plugins-tabel-header>

<body>
    @if (session('gagal'))
        <div class="alert alert-danger">{{ session('gagal') }}</div>
    @endif
    @if (session('Success'))
        <div class="alert alert-success">{{ session('Success') }}</div>
    @endif
    <div class="containerscan">
        <div class="card  d-flex justify-content-between gap-3">
            <div class="card-body">
                <div class="col-lg-12">
                    {{-- <div class="row"> --}}
                    <div class="card shadow">
                        <div
                            class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                            <!-- Logo Sekolah -->
                            <div class="d-flex align-items-center gap-3">
                                <img class='img-circle img-fluid d-block mx-auto  mb-2'
                                    src="{{ app('request')->root() }}/img/logo.png" alt="Logo Sekolah" width="60"
                                    height="60" class="me-3">
                                <div class="text-start">
                                    <h2 class="mb-0 fw-bold">SMP Cipta IT</h2>
                                    <h4>Sistem Absensi Berbasis QR Code</h4>
                                </div>
                            </div>
                            <!-- Judul -->
                            {{-- <div class="d-flex justify-content-end"> --}}
                            {{-- <h4 class="mb-0">
                                    <i class="fa fa-user"></i> Scan Absensi QR Code
                                </h4> --}}
                            {{-- </div> --}}
                        </div>
                    </div>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.1/socket.io.js"></script>
                    <h4 id="status"></h4>
                    <script>
                        function ucfirst(str) {
                            return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
                        }

                        function checkServerStatus() {
                            fetch("{{ route('wa.status') }}")
                                .then(response => response.json())
                                .then(data => {
                                    let statusFormatted = ucfirst(data.status); // Huruf besar di awal saja
                                    document.getElementById("status").innerText = 'Status Server : ' + statusFormatted;
                                    document.getElementById("status").style.color = "green";
                                })
                                .catch(error => {
                                    document.getElementById("status").innerText = "⚠️ Server WhatsApp JS belum aktif!";
                                    document.getElementById("status").style.color = "red";
                                });
                        }

                        document.addEventListener("DOMContentLoaded", checkServerStatus);
                    </script>



                    <div class="row">
                        <!-- Untuk QR Scanner di sebelah kiri -->
                        <div class="cam col-lg-4">
                            <x-qr-scaner></x-qr-scaner>
                        </div>
                        <!-- Untuk tabel di sebelah kanan -->
                        <div class="tableview col-lg-8">
                            <table id='example1' class='table table-bordered table-hover mt-5 mr-3'>
                                <thead class='table-primary'>
                                    <tr class='text-center align-middle'>
                                        <th class='text-center' width='1%'>ID</th>
                                        <th class='text-center' width='20%'>Waktu Absen</th>
                                        <th class='text-center' width='5%'>Jam</th>
                                        <th class='text-center' width='10%'>NIS</th>
                                        <th class='text-center'>Nama</th>
                                        <th class='text-center'width='5%'>Kelas</th>
                                        <th class='text-center'>Absen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($DataAbsenHarIni as $data)
                                        <tr>
                                            <td class='text-center'>{{ $loop->iteration }}</td>
                                            <td class='text-left'>
                                                {{ Carbon::create($data->waktu_absen)->translatedformat('l, d F Y') }}
                                            </td>
                                            <td class='text-center'>
                                                {{ Carbon::create($data->created_at)->format('H:i:s') }}
                                            </td>
                                            <td class='text-center'>
                                                {{ $data->EabsentoDetailsiswa->nis }}
                                            </td>
                                            <td class='text-left'>
                                                {{ $data->EabsentoDetailsiswa->nama_siswa }}
                                            </td>
                                            <td class='text-center'>
                                                {{ $data->EabsentoDetailsiswa->DetailsiswaToKelas->kelas }}
                                            </td>
                                            <td class='text-left text-center'>
                                                {{-- blade-formatter-disable --}}
                                                @if ($data->absen === 'hadir')
                                                    <span class="bg-success p-2 rounded-pill">{{ ucfirst($data->absen) }}</span>
                                                @elseif($data->absen === 'sakit')
                                                    <span class="bg-warning p-2 rounded-pill">{{ ucfirst($data->absen) }}</span>
                                                @elseif($data->absen === 'ijin')
                                                    <span class="bg-primary p-2 rounded-pill">{{ ucfirst($data->absen) }}</span>
                                                @else
                                                    <span class="bg-danger p-2 rounded-pill">{{ ucfirst($data->absen) }}</span>
                                                @endif
                                                {{-- blade-formatter-enable --}}

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class='table-primary'>
                                    <tr class='text-center align-middle'>
                                        <th class='text-center'>ID</th>
                                        <th class='text-center'>Waktu Absen</th>
                                        <th class='text-center'>Jam</th>
                                        <th class='text-center'>NIS</th>
                                        <th class='text-center'>Nama</th>
                                        <th class='text-center'>Kelas</th>
                                        <th class='text-center'>Absen</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>


    {{-- </div> --}}

    </div>
    <x-plugins-tabel-footer></x-plugins-tabel-footer>
    <x-plugins-multiple-select-footer></x-plugins-multiple-select-footer>
    <x-alert-footer></x-alert-footer>

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> --}}
</body>

</html>
<script>
    $(document).ready(function() {
        initDataTable('#example1', 'Data Absensi', '#example1_wrapper .col-md-6:eq(0)');
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
