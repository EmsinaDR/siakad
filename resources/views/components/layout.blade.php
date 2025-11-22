<!DOCTYPE html>
<html lang="en">
<meta name="csrf-token" content="{{ csrf_token() }}">

@php
    // use App\Models\Identitas;
    use Illuminate\Support\Str;

    $identitas = App\Models\Admin\Identitas::get()[0];
    // $regiser = Hash::make($identitas->regis);
    $regiser = request($identitas->regis);
    if (Hash::check($regiser, $identitas->regis)) {
        echo 'no registrasi<br />';
        echo $identitas->regis . '<br />';

        echo $identitas->namasek . '<br />';

        echo $regiser . '<br />';
        echo $regiser . '<br />';
    } else {
        // session_start();
        $_SESSION['titleweb'] = $identitas->namasek;
        $_SESSION['judul'] = $title;
        // $member = 'pro';
    }
@endphp
<style>
</style>


{{-- Pengecekan Versi Gratis, Basic, Trial, Premium --}}
<!-- Data Header -->c
<x-property-header>{{ $slot }}</x-property-header>
<!-- / Data Header -->
<style>
    .offcanvas,
    .right-sidebar {
        position: fixed !important;
        top: 0;
        right: 0;
        height: 100vh !important;
        z-index: 1050 !important;
        visibility: visible !important;
        transform: none !important;
        /* pastikan tidak tersembunyi */
    }
</style>

<body class="hold-transition sidebar-mini layout-fixed">
    {{-- @stack('scripts') --}}

    <x-plugins-multiple-select-header></x-plugins-multiple-select-header>
    <x-alert-header></x-alert-header>
    <x-plugins-tabel-header></x-plugins-tabel-header>

    <div class="wrapper">
        <x-header-menu>{{ $slot }}</x-header-menu>

        <!-- Main Sidebar Container -->
        <x-right-navbar-pro>{{ $slot }}</x-right-navbar-pro>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            {{-- Konten Header Bredcume --}}
            <x-content-header>{{ $breadcrumb }}</x-content-header>
            {{-- Konten Header Bredcume --}}

            {{-- Data Konten Blade in section --}}
            <section>{{ $slot }}</section>
            {{-- Data Konten Blade in section Akhir --}}

            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <x-footer>{{ $slot }}</x-footer>


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->


    {{-- plugin in footer --}}
    <x-property-footer>{{ $slot }}</x-property-footer>
    {{-- plugin in footer --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data akan dihapus secara permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>

    @if (Session::has('warning'))
        <script>
            Swal.fire({
                title: "Peringatan!",
                text: "{{ Session::get('warning') }}",
                icon: "warning",
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    @if (Session::has('error'))
        <script>
            Swal.fire({
                title: "Gagal!",
                text: "{{ Session::get('error') }}",
                icon: "error",
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif
    <script>
        $(document).ready(function() {
            // Inisialisasi select2 hanya untuk elemen <select> yang tidak berada di dalam SweetAlert
            $('select').not('.swal2-container select').each(function() {
                $(this).select2({
                    width: '100%',
                    placeholder: $(this).data('placeholder') || 'Pilih Opsi'
                });

                const preselect = $(this).data('preselect');
                if (preselect) {
                    $(this).val(preselect).trigger('change');
                }
            });
        });

        // Jika menggunakan Livewire atau komponen lainnya, panggil ulang
        document.addEventListener("livewire:load", function() {
            $('select').not('.swal2-container select').each(function() {
                $(this).select2({
                    width: '100%',
                    placeholder: $(this).data('placeholder') || 'Pilih Opsi'
                });
            });
        });
    </script>
</body>
<x-plugins-tabel-footer></x-plugins-tabel-footer>
<x-plugins-multiple-select-footer></x-plugins-multiple-select-footer>

<x-alert-footer></x-alert-footer>

</html>
<script src="{{ asset('backend/plugins/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('backend/plugins/moment/moment.min.js') }}"></script>
<script>
    moment.locale('id');
</script>

<style>
    .tox-notifications-container {
        display: none !important;
    }

    .tox-toolbar {
        display: flex !important;
    }

    .modal .fade {
        z-index: 100;
    }


    /* Pastikan modal TinyMCE berada di atas modal Bootstrap */

    .tox-silver-sink,
    .tox-tinymce-aux {
        z-index: 9999 !important;
        /* Ensure it's higher than Bootstrap modals */
    }

    .modal-backdrop {
        pointer-events: none;
    }

    .tox-promotion {
        display: none !important;
    }

    .tox-tinymce-aux>textarea {
        pointer-events: auto;
    }
</style>
<style>
    @media print {
        body {
            font-family: Arial, sans-serif;
        }

        ol {
            padding-left: 30px;
            margin-left: 20px;
            list-style-position: outside;
        }

        ol li {
            text-indent: -20px;
            margin-bottom: 10px;
        }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const inputs = document.querySelectorAll(".form-control");
        inputs.forEach(input => {
            input.addEventListener("input", function() {
                if (input.value.trim() !== "") {
                    input.classList.add("bg-success", "text-white");
                } else {
                    input.classList.remove("bg-success", "text-white");
                }
            });
        });
        if (typeof tinymce !== "undefined") {
            document.querySelectorAll('textarea.editor, textarea.content').forEach(function(el) {
                const isEditor = el.classList.contains('editor');
                const tinggi = isEditor ? 400 : 1000;

                tinymce.init({
                    target: el,
                    height: tinggi,
                    branding: false,
                    menubar: 'file edit view insert format tools table help',
                    plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table pagebreak',
                    toolbar: 'undo redo | formatselect | bold italic underline strikethrough backcolor | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | link image media table | removeformat fullscreen code | pagebreak',
                    table_default_attributes: {
                        border: "1"
                    },
                    table_sizing_mode: 'responsive',
                    quickbars_insert_toolbar: 'inserttable',
                    quickbars_selection_toolbar: 'bold italic | quicklink',
                    convert_urls: false,
                    indent: true,
                    entity_encoding: "named",
                    paste_remove_styles: true,
                    paste_remove_spans: true,
                    // ✅ PREPROCESS: Deteksi simbol bullet dan ubah jadi list numerik/huruf
                    paste_preprocess: function(plugin, args) {
                        let content = args.content;

                        // Ganti simbol manual jadi list <li>
                        content = content.replace(
                            /<p[^>]*>(?:&nbsp;|\s)*(?:·|•|-)\s*(.*?)<\/p>/gi,
                            '<li>$1</li>');

                        // Tambahkan <ul> jika ditemukan list bullet
                        if (/<li>/.test(content)) {
                            content = '<ul>' + content + '</ul>';
                        }

                        // Ganti "1." atau "a." jadi <li>
                        content = content.replace(
                            /<p[^>]*>(?:&nbsp;|\s)*[1-9]\.\s+(.*?)<\/p>/gi,
                            '<li>$1</li>');
                        content = content.replace(
                            /<p[^>]*>(?:&nbsp;|\s)*[a-zA-Z]\.\s+(.*?)<\/p>/gi,
                            '<li>$1</li>');

                        // Jika sudah ada <li> dan mengandung "a.", jadikan <ol type="a">
                        if (/<li>[a-zA-Z]\.\s/.test(args.content)) {
                            content = '<ol type="a">' + content + '</ol>';
                        } else if (/<li>\d+\.\s/.test(args.content)) {
                            content = '<ol type="1">' + content + '</ol>';
                        }

                        args.content = content;
                    },

                    // ✅ CSS seperti Word
                    content_style: `
                    body {
                        font-family: Calibri, sans-serif;
                        font-size: 14px;
                        line-height: 1.6;
                        margin: 20px;
                    }
                        ol, ul {
      padding-left: 30px;
    }
    ol li {
      margin-bottom: 6px;
      text-indent: -20px;
    }
                    ol, ul {
                        margin-left: 30px;
                        padding-left: 15px;
                        list-style-position: outside;
                    }
                    ol[type="a"] {
                        list-style-type: lower-alpha;
                    }
                    ol[type="1"] {
                        list-style-type: decimal;
                    }
                    li {
                        margin-bottom: 6px;
                    }
                    table {
                        width: 85% !important;
                        border-collapse: collapse !important;
                        margin-top: 10px;
                    }
                    td, th {
                        padding: 5px !important;
                        // border: 1px solid #444 !important;
                        vertical-align: top;
                    }
                        li {
  margin-bottom: 6px;
  text-indent: 0 !important;
}
// @media print {
//     /* Pastikan body dan konten editor tidak terpengaruh oleh pengaturan lainnya */
//     body {
//         font-family: Arial, sans-serif;
//         font-size: 12px;
//         line-height: 1.4;
//         margin: 0;
//     }

//     /* Styling untuk list numerik atau bullet */
//     ol, ul {
//         padding-left: 30px;
//         margin-left: 20px;
//         list-style-position: outside;
//     }

//     ol li, ul li {
//         margin-bottom: 10px;
//         text-indent: -20px; /* Agar indentasi rapi pada baris kedua */
//     }

//     /* Pastikan nomor di daftar tetap ditampilkan */
//     ol li::before, ul li::before {
//         content: counter(item) ") "; /* Menampilkan nomor atau bullet */
//         position: absolute;
//         left: 0;
//         width: 30px;
//         display: inline-block;
//     }

//     /* Agar area konten tidak terpotong */
//     .tox-edit-area {
//         padding: 10px;
//     }
// }



                `,

                    setup: function(editor) {
                        editor.on('init', function() {
                            document.querySelectorAll(
                                    ".tox-tinymce-aux, .tox.tox-silver-sink")
                                .forEach(el => el.style.zIndex = "1500000");
                            const printButton = document.querySelector(
                                '#printButton');
                            if (printButton) {
                                printButton.addEventListener('click', function() {
                                    const editorContent = editor
                                        .getContent(); // Mendapatkan konten editor

                                    // Tentukan aturan untuk mencetak konten editor
                                    const printWindow = window.open('', '',
                                        'height=600,width=800');
                                    printWindow.document.write(
                                        '<html><head><title>Print</title>'
                                    );
                                    printWindow.document.write(
                                        '<style>@media print { body { font-family: Arial, sans-serif; } ol { padding-left: 30px; margin-left: 20px; list-style-position: outside; } ol li { text-indent: -20px; margin-bottom: 10px; } }</style>'
                                    );
                                    printWindow.document.write(
                                        '</head><body>');
                                    printWindow.document.write(
                                        editorContent);
                                    printWindow.document.write(
                                        '</body></html>');
                                    printWindow.document.close();
                                    printWindow.print();
                                });
                            }
                        });

                        editor.on("change", function() {
                            tinymce.triggerSave();
                        });

                        editor.ui.registry.addButton('pagebreak', {
                            text: 'Page Break',
                            onAction: function() {
                                editor.insertContent(
                                    '<div class="mce-pagebreak"></div>');
                            }
                        });

                        editor.on('Paste', function() {
                            setTimeout(() => {
                                editor.dom.select('td, th').forEach(
                                    cell => {
                                        cell.style.height = 'auto';
                                    });
                            }, 100);
                        });
                    }
                });
            });

            document.querySelectorAll("form").forEach(function(form) {
                form.addEventListener("submit", function() {
                    tinymce.triggerSave();
                });
            });

        } else {
            console.error("TinyMCE tidak ditemukan!");
        }
    });
</script>

<script>
    $(document).ready(function() {
        // Ketika modal muncul
        $('.modal').on('shown.bs.modal', function() {
            // Temukan semua elemen dengan class .select2
            $(this).find('.select2').each(function() {
                // Jika elemen sudah memiliki class select2-hidden-accessible, reset Select2
                if ($.fn.select2 && $(this).hasClass("select2-hidden-accessible")) {
                    $(this).select2('destroy'); // Menghancurkan instance lama Select2
                }
                // Inisialisasi Select2 dengan dropdownParent yang terkait dengan modal
                $(this).select2({
                    dropdownParent: $(this).closest('.modal')
                });
            });
        });
    });
</script>
