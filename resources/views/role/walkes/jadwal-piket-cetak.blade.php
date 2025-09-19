@php
    $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
    $urlroot = app('request')->root();
    $title = '';
    $breadcrumb = 'Cetak / Jadwal Piket';
@endphp
<style>
    textarea {
        resize: none,
    }
</style>
<section class='content mx-2 my-4'>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }

        table {
            width: 50%;
            margin: auto;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f4f4f4;
        }

        .data {
            background-image: url(https://marketplace.canva.com/EAE60Tqk3kM/1/0/1600w/canva-merah-muda-ilustrasi-minimalis-jadwal-piket-class-schedule-oUEZMv4670s.jpg);
            background-repeat: none;
            background-size: cover;
        }
    </style>
    {{-- <x-layout> --}}
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ app('request')->root() }}/plugins/fontawesome-free/css/all.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ app('request')->root() }}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

    <!-- iCheck -->
    <link rel="stylesheet" href="{{ app('request')->root() }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ app('request')->root() }}/plugins/jqvmap/jqvmap.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ app('request')->root() }}/dist/css/adminlte.min.css">

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ app('request')->root() }}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ app('request')->root() }}/plugins/daterangepicker/daterangepicker.css">

    <!-- summernote -->
    <link rel="stylesheet" href="{{ app('request')->root() }}/plugins/summernote/summernote-bs4.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ app('request')->root() }}/plugins/fontawesome-free/css/all.min.css">

    <!-- SweetAlert2 -->
    <link rel="stylesheet"
        href="{{ app('request')->root() }}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/toastr/toastr.min.css') }}">
      <script src="{{ asset('tools/pdfq/html2pdf.bundle.min.js') }}"></script>
    <x-plugins-multiple-select-header></x-plugins-multiple-select-header>
    <x-alert-header></x-alert-header>
    <x-plugins-tabel-header></x-plugins-tabel-header>

        <a href="{{ route('print.data_jadwal_piket', request('kelas_id')) }}" target="_blank" class="btn btn-primary">
            Cetak PDF
        </a><button type="button" onClick="generatePDF()" class="btn-sm btn-danger pull-right">Export to PDF</button>
    <div id="divToExport" class="card p-4 data mt-5">
        @foreach ($data as $dataq)
            {{ $dataq->nama_siswa }}
        @endforeach
        <div class="col text-center">
            <h2 id='sampleText'><b>Jadwal Piket Mingguan</b></h2>

            <h2>Kelas VII A</h2>

        </div>
        <div class="row">
            {{-- {{dd($data)}} --}}

            <div id='senin' width='31%' class='col m-2 p-2' style='background-color:hsla(46, 71%, 73%, 0.478)'>
                <div class='card-header d-flex justify-content-center bg-primary mb-3'>
                    <h2 class='card-title'>SENIN</h2>
                </div>
                <ul class='mt-2'>
                <li class='text-left p-1'>Dany a</li>
                <li class='text-left p-1'>Ata</li>
                <li class='text-left p-1'>Aufa</li>
                <li class='text-left p-1'>Azmi</li>
                <li class='text-left p-1'>Aufa</li>
                <li class='text-left p-1'>Azmi</li>
                </ul class=>
            </div>
            <div id='selasa' width='31%' class='col m-2 p-2' style='background-color:hsla(46, 71%, 73%, 0.478)'>
                <div class='card-header d-flex justify-content-center bg-primary mb-3'>
                    <h2 class='card-title'>SELASA</h2>
                </div>
                <ul class='mt-2'>
                    <li class='text-left p-1'>Dany</li>
                    <li class='text-left p-1'>Ata</li>
                    <li class='text-left p-1'>Aufa</li>
                    <li class='text-left p-1'>Azmi</li>
                </ul>
            </div>
            <div id='rabu' width='31%' class='col m-2 p-2' style='background-color:hsla(46, 71%, 73%, 0.478)'>
                <div class='card-header d-flex justify-content-center bg-primary mb-3'>
                    <h2 class='card-title'>RABU</h2>
                </div>
                <ul class='mt-2'>
                    <li class='text-left p-1'>Dany</li>
                    <li class='text-left p-1'>Ata</li>
                    <li class='text-left p-1'>Aufa</li>
                    <li class='text-left p-1'>Azmi</li>
                </ul>
            </div>
        </div>
        <div class="row">

            <div id='kamis' width='31%' class='col m-2 p-2' style='background-color:hsla(46, 71%, 73%, 0.478)'>
                <div class='card-header d-flex justify-content-center bg-primary mb-3'>
                    <h2 class='card-title'>KAMIS</h2>
                </div>
                <ul class='mt-2'>
                    <li class='text-left p-1'>Dany</li>
                    <li class='text-left p-1'>Ata</li>
                    <li class='text-left p-1'>Aufa</li>
                    <li class='text-left p-1'>Azmi</li>
                </ul>
            </div>
            <div id='jumat' width='31%' class='col m-2 p-2' style='background-color:hsla(46, 71%, 73%, 0.478)'>
                <div class='card-header d-flex justify-content-center bg-primary mb-3'>
                    <h2 class='card-title'>JUM'AT</h2>
                </div>
                <ul class='mt-2'>
                    <li class='text-left p-1'>Dany</li>
                    <li class='text-left p-1'>Ata</li>
                    <li class='text-left p-1'>Aufa</li>
                    <li class='text-left p-1'>Azmi</li>
                </ul>
            </div>
            <div id='sabtu' width='31%' class='col m-2 p-2' style='background-color:hsla(46, 71%, 73%, 0.478)'>
                <div class='card-header d-flex justify-content-center bg-primary mb-3'>
                    <h2 class='card-title'>SABTU</h2>
                </div>
                <ul class='mt-2'>
                    <li class='text-left p-1'>Dany</li>
                    <li class='text-left p-1'>Ata</li>
                    <li class='text-left p-1'>Aufa</li>
                    <li class='text-left p-1'>Azmi</li>
                </ul>
            </div>


        </div>
        <div class='alert alert-info alert-dismissible'>
            <h5><i class='icon fas fa-info'></i> Information !</h5>
            <hr>
            <ol>
                <l1>1. Dikerjakan sebelum proses pembelajaran</l1>
                <l1></l1>
                <l1></l1>
                <l1></l1>
                <l1></l1>
            </ol>
        </div>
    </div>


    {{-- </section> --}}
    {{-- </x-layout> --}}
    <!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">

<!-- Tempusdominus -->
<link rel="stylesheet" href="{{ asset('backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

<!-- AdminLTE -->
<link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">

<!-- jQuery -->
<script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap 4 -->
<script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script type="text/javascript">
  function generatePDF() {

        // Choose the element id which you want to export.
        var element = document.getElementById('divToExport');
        // element.style.width = '700px';
        // element.style.height = '900px';
        var opt = {
            margin:       0,
            filename:     'myfile.pdf',
            image:        { type: 'jpeg', quality: 1 },
            html2canvas:  { scale: 1 },
            jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait',precision: '12' }
          };

        // choose the element and pass it to html2pdf() function and call the save() on it to save as pdf.
        html2pdf().set(opt).from(element).save();
      }
</script>