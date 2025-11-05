@extends('layouts.cbt')

@section('content')
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            overflow: hidden;
            /* Menghindari scroll di body */
        }

        .font-small {
            font-size: 14px !important;
        }

        .font-medium {
            font-size: 16px !important;
        }

        .font-large {
            font-size: 18px !important;
        }

        .grid-template-columns-5 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(45px, 1fr));
            gap: 6px;
        }

        /* Mengatur tata letak input group */
        .input-group.d-flex {
            display: flex;
            align-items: center;
            /* Agar elemen-elemen vertikal sejajar di tengah */
        }

        .input-group-text {
            display: flex;
            align-items: center;
            /* Menjaga ikon dan teks sejajar vertikal */
            padding: 5px 10px;
            background-color: #f1f1f1;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        .btn-group {
            display: flex;
            margin-left: 10px;
        }

        /* Styling untuk tombol agar ikon di tengah */
        .btn-group button {
            display: flex;
            align-items: center;
            /* Vertikal center */
            justify-content: center;
            /* Horizontal center */
            background-color: #4CAF50;
            /* Warna tombol */
            border: none;
            color: white;
            padding: 10px 15px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 5px;
            margin: 0 5px;
            transition: background-color 0.3s, transform 0.2s;
        }

        .btn-group button:hover {
            background-color: #45a049;
            transform: scale(1.1);
        }

        .btn-group button i {
            font-size: inherit;
            /* Ikon akan mengikuti ukuran font tombol */
        }
    </style>

    <div class="container-fluid p-0">
        {{-- HEADER CBT --}}
        <div class="bg-primary text-white p-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <img src="{{ asset('/img/logo.png') }}" alt="Logo" height="50" class="bg-white p-1 rounded">
                <div>
                    <h5 class="mb-0">{{ $Identitas->namasek }}</h5>
                    <small class="d-block">{{ $Identitas->alamat }}</small>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <img src="{{ asset('/dist/img/user2-160x160.jpg') }}" alt="Foto Siswa" height="50" width="50"
                    class="rounded-circle border border-light">
                <div class="text-start">
                    <small>Peserta:</small><br>
                    <strong>{{ auth()->user()->name }}</strong>
                </div>
            </div>
        </div>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

        <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="card shadow-lg"
                style="width: 100%; max-width: 750px; height: auto; max-height: 500px; margin-top: -150px;">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h3>Test Telah Selesai</h3>
                    <p class="lead">Terima kasih telah mengikuti ujian</p>

                    <!-- Foto Siswa -->
                    <img src="{{ asset('dist/img/user2-160x160.jpg') }}" alt="Foto Siswa" class="rounded-circle  shadow-lg"
                        style="width: 100px; height: 100px; object-fit: cover;">

                    <!-- Tabel Data Siswa -->
                    <table class="table table-bordered mt-4" style="width: 75%;">
                        <tbody>
                            <tr>
                                <td><strong>Nama Siswa</strong></td>
                                <td>John Doe</td>
                            </tr>
                            <tr>
                                <td><strong>Kelas</strong></td>
                                <td>9B</td>
                            </tr>
                            <tr>
                                <td><strong>Nomor Ujian</strong></td>
                                <td>123456789</td>
                            </tr>
                            <tr>
                                <td><strong>Nilai Anda</strong></td>
                                <td>85%</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="mt-4">
                        <!-- Menggunakan # untuk tidak pergi ke halaman lain -->
                        <a href="#" class="btn btn-primary">Kembali ke Daftar Soal</a>
                        <a href="#" class="btn btn-secondary">Kembali ke Beranda</a>
                    </div>
                </div>
            </div>
        </div>



    </div>
@endsection
