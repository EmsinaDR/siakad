@php
    use Illuminate\Support\Carbon;
    Carbon::setLocale('id');
    $Identitas = \App\Models\Admin\Identitas::first();
    $Tapels = \App\Models\Admin\Etapel::where('aktiv', 'Y')->first();
    $activecrud = collect([2, 4, 6, 8])->contains(Auth::id());
    $urlroot = request()->root();
@endphp
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">

<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet"
    href="{{ asset('backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

<!-- iCheck -->
<link rel="stylesheet" href="{{ asset('backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

<!-- JQVMap -->
<link rel="stylesheet" href="{{ asset('backend/plugins/jqvmap/jqvmap.min.css') }}">

<!-- Theme style AdminLTE -->
<link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">

<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{ asset('backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset('backend/plugins/daterangepicker/daterangepicker.css') }}">

<!-- Summernote -->
<link rel="stylesheet" href="{{ asset('backend/plugins/summernote/summernote-bs4.min.css') }}">

<!-- Eksport PDF dengan html2pdf -->
<script src="{{ asset('backend/tools/pdfq/html2pdf.bundle.min.js') }}"></script>

<!-- SweetAlert2 -->
<script src="{{ asset('backend/js/sweetalert2@11.js') }}"></script>

<!-- CKEditor -->
<script src="{{ asset('backend/plugins/ckeditor/ckeditor.js') }}"></script>

<!-- Cover Page -->
<div class="cover-container">
    <div class="my-4">
        <div class='my-4'>
            {{ $judul }}
        </div>
    </div>
    <img src="{{ app('request')->root() }}/img/logo.png" style='width:400px;height:auto' alt="Logo Instansi"
        class="logo">
    <div class="data-cover mt-5">
        <h2>{{ $Identitas->jenjang }} {{ $Identitas->nomor }} {{ $Identitas->namasek }}</h2>
        <h2>Provnsi {{ $Identitas->provinsi }}</h2>
        <h2>Kecamatan {{ $Identitas->kecamatan }}</h2>
        <h2>Kabupaten {{ $Identitas->kabupaten }}</h2>
        <p>{{ $Identitas->alamat }}</p>
        <p>{{ $Identitas->email }}</p>
        <p>{{ Carbon::now()->translatedFormat('l, d F Y') }}</p>
    </div>

</div>
<!-- Page break after cover -->
<div class="page-break"></div>

<!-- Main content (existing content) -->
<section>{{ $slot }}</section>
{{--
<script>
    window.onload = function() {
        window.print();
    };
</script> --}}
{{-- <script>
    window.onload = function() {
        window.print(); // Memanggil dialog cetak

        // Menutup jendela jika cetak selesai atau dibatalkan
        window.onafterprint = function() {
            window.close();
        };

        // Untuk beberapa browser yang tidak mendukung `onafterprint`, gunakan `setTimeout`
        setTimeout(function() {
            window.close();
        }, 1000);
    };
</script> --}}
