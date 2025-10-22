<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Jika Anda menggunakan Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Jika Anda belum menggunakan Vite, aktifkan link CSS manual seperti ini --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> --}}

    {{-- Menambahkan FontAwesome untuk ikon (optional) --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    {{-- Menambahkan Bootstrap untuk tampilan --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Jika menggunakan jQuery (opsional) --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Menambahkan beberapa plugin tambahan seperti SweetAlert2 untuk notifikasi --}}
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
</head>

<body>
    {{-- <div class="bg-gray-100 min-h-screen d-flex justify-content-center align-items-center py-12"> --}}
    {{-- Konten utama di sini --}}
    {{ $slot }}
    {{-- </div> --}}
    {{-- Jika menggunakan jQuery atau SweetAlert, pastikan menambahkannya setelah konten --}}
    <script>
        // Contoh penggunaan SweetAlert untuk notifikasi
        document.addEventListener('DOMContentLoaded', function() {
            // Misalnya notifikasi sukses setelah form submit
            @if (session('status'))
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('status') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>

    {{-- Menambahkan Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
