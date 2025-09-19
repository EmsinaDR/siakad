@php
    use Illuminate\Http\Request;
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
@endphp

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo $_SESSION['judul']; ?> | <?php echo $_SESSION['titleweb']; ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS Bundle (termasuk Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">

    {{-- <link rel="stylesheet" href="{{app('request')->root()}}/"> --}}

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/jqvmap/jqvmap.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/summernote/summernote-bs4.min.css') }}">
    {{-- Eksport PDF dengan htmlToPDF --}}
    <link rel="stylesheet" href="{{ asset('backend/tools/pdfq/html2pdf.bundle.min.js') }}">
    <link rel="stylesheet" href="{{ asset('backend/js/sweetalert2@11.js') }}">

    <link rel="stylesheet" href="{{ asset('backend/css/btn.css') }}">
    <script src='{{ asset('backend/plugins/ckeditor/ckeditor.js') }}'></script>
    {{--
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE -->
    <script src="path/to/adminlte.min.js"></script>
 --}}








</head>
{{-- <style>
    .btn-equal-width {
        height: 35px;
        width: 75px;
        /* Tetapkan ukuran sesuai kebutuhan */
        text-align: center;
    }

    .bg-azzure {
        background-color: #F0FFFF;
    }

    .bg-cornsilk {

        background-color: #FFF8DC;
    }

    .bg-darkseagreen {

        background-color: #8FBC8F;

    }

    .bg-bluex {

        background-color: #9FCDFF;

    }

</style> --}}
