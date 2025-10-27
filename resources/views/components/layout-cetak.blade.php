<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Google Font: Source Sans Pro -->
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">

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

<!-- SweetAlert2 -->
<link rel="stylesheet" href="{{ asset('backend/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

<!-- Toastr -->
<link rel="stylesheet" href="{{ asset('backend/plugins/toastr/toastr.min.css') }}">

<!-- JS Tools -->
<script src="{{ asset('backend/tools/pdfq/html2pdf.bundle.min.js') }}"></script>
<script src="{{ asset('backend/js/sweetalert2@11.js') }}"></script>

<!-- CKEditor -->
<script src="{{ asset('backend/plugins/ckeditor/ckeditor.js') }}"></script>


<!-- Cover Page -->

<!-- Page break after cover -->

<!-- Main content (existing content) -->
<div class="print-page">
    <section>{{ $slot }}</section>
</div>
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
