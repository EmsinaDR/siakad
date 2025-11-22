<!DOCTYPE html>
<html lang="en">
<meta name="csrf-token" content="{{ csrf_token() }}">

@php
    use Illuminate\Http\Request;
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
@endphp
<style>
    body {
        background: linear-gradient(45deg, #2196F3, #21CBF3);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .form-container {
        /* background-color: white; */
        border-radius: 15px;
        padding: 40px;
        max-width: 1200px !important;
        ;
        /* Menetapkan lebar maksimum form */
        width: 100%;
        /* Agar form bisa menyesuaikan lebar layar */
        margin: 0 auto;
        /* Agar form berada di tengah halaman */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        animation: fadeIn 1s ease-out;
    }

    .form-container h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .btn-primary {
        background-color: #2196F3;
        border-color: #2196F3;
    }

    .btn-primary:hover {
        background-color: #1976D2;
        border-color: #1976D2;
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
            transform: translateY(50px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
<!-- Data Header -->
<link rel="icon" type="image/x-icon" href="{{ app('request')->root() }}/img/myicon.ico">


<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pendaftaran Sekolah</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ app('request')->root() }}/plugins/fontawesome-free/css/all.min.css">

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


<body class="hold-transition sidebar-mini layout-fixed">
    {{-- @stack('scripts') --}}

    <x-plugins-multiple-select-header></x-plugins-multiple-select-header>
    <x-alert-header></x-alert-header>
    <x-plugins-tabel-header></x-plugins-tabel-header>

    <div class="wrapper">
        <section>{{ $slot }}</section>

    </div>
    <x-property-footer>{{ $slot }}</x-property-footer>

    <x-plugins-tabel-footer></x-plugins-tabel-footer>
    <x-plugins-multiple-select-footer></x-plugins-multiple-select-footer>

    <x-alert-footer></x-alert-footer>
