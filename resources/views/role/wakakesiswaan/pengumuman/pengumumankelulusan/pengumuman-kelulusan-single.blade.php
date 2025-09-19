@php
    //content
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
    $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
    $urlroot = app('request')->root();
@endphp
<x-layout>
    <style>
        textarea {
            resize: none,
        }

        .card-body {
            display: flex;
            flex-direction: column;
            /* Menyusun elemen secara vertikal */
            justify-content: center;
            /* Posisikan elemen di tengah secara vertikal */
            align-items: center;
            /* Posisikan elemen di tengah secara horizontal */
        }

        .countdown-container {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            font-size: 20px;
            margin-top: 20px;
        }

        .countdown-box {
            background-color: #218838;
            padding: 20px;
            text-align: center;
            color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            flex: 1;
            margin-right: 10px;
            /* Jarak antar kotak */
        }


        .countdown-box span {
            font-size: 50px;
            font-weight: bold;
            display: block;
            margin-top: -10px;
        }

        .countdown-box strong {
            font-size: 50px;
            display: block;
            margin-top: 1px;
        }

        .hari-text {
            position: relative;
            top: -5px;
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
            <!--Card Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</h3>
            </div>
            <!--Card Header-->
            <div class='row m-2'>
                <div class='col-xl-2'>
                </div>
                <div class='col-xl-10'></div>
            </div>
            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class=''>
                        <!-- Konten -->
                        @if ($show_pengumuman)
                            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<div class="card shadow-sm border-0 mb-4" style="background: linear-gradient(135deg, #e0f7fa, #ffffff);">
    <div class="card-body text-center">
        <h2 class="animate__animated animate__bounceIn mb-4" style="font-weight: bold; color: #00796b;">📢 Pengumuman Kelulusan</h2>

        <p class="lead">
            Selamat! Anda dinyatakan
            <span class="badge bg-warning text-dark animate__animated animate__fadeInDown" style="font-size: 18px;">
                🎖️ {{ strtoupper($data->status_kelulusan) }}
            </span>
        </p>

        <p><em>Keterangan:</em> <strong>{{ $data->keterangan ?? 'Tidak ada keterangan tambahan.' }}</strong></p>

        <div class="row align-items-center mt-4">
            <!-- Foto Siswa -->
            <div class="col-md-4 text-center mb-4">
                <img src="{{ asset('img/siswa/' . ($data->Siswa->foto ?? 'user-siswa.png')) }}"
                     alt="Foto Siswa"
                     class="img-fluid rounded-circle shadow-sm animate__animated animate__zoomIn"
                     style="width: 200px; height: 200px; object-fit: cover; border: 5px solid #ffc107;">
                <p class="mt-3"><strong>{{ $data->Siswa->nama_siswa }}</strong></p>
            </div>

            <!-- Biodata Table -->
            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" style="background: white;">
                        <tbody>
                            <tr>
                                <th style="width: 40%;" class="text-center bg-light">Nama</th>
                                <td class="text-center">{{ $data->Siswa->nama_siswa }}</td>
                            </tr>
                            <tr>
                                <th class="text-center bg-light">Kelas</th>
                                <td class="text-center">{{ $data->kelas->kelas }}</td>
                            </tr>
                            <tr>
                                <th class="text-center bg-light">No Ujian</th>
                                <td class="text-center">{{ $data->nomor_ujian }}</td>
                            </tr>
                            <tr>
                                <th class="text-center bg-light">Tahun Lulus</th>
                                <td class="text-center">{{ $data->tahun_lulus }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <a href="{{ route('home') }}" class="btn btn-success shadow-sm px-4 animate__animated animate__fadeInUp">🏠 Kembali ke Beranda</a>
        </div>
    </div>
</div>


                            <!-- Confetti JS -->
                            <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
                            <script>
                                window.addEventListener('load', function() {
                                    @if (strtolower($data->status_kelulusan) == 'lulus')
                                        confetti({
                                            particleCount: 150,
                                            spread: 70,
                                            origin: {
                                                y: 0.6
                                            }
                                        });
                                    @endif
                                });
                            </script>
                        @else
                            <div class="pengumuman-tutup">
                                <p>Pengumuman kelulusan akan diumumkan pada
                                <p><strong>{{ Carbon::create($data->tanggal_pengumuman)->translatedFormat('l, d F Y H:i') }}</strong>.
                                </p>
                                <div class='card-body d-flex justify-content-center align-items-center'>
                                    <div class="card-title text-center">
                                        <h3><b>Masih Kurang</b></h3>
                                    </div>
                                    <div id="countdown-timer" class="countdown-container">
                                        <div class="countdown-box" id="days"></div>
                                        <div class="countdown-box" id="hours"></div>
                                        <div class="countdown-box" id="minutes"></div>
                                        <div class="countdown-box" id="seconds"></div>
                                    </div>
                                </div>

                            </div>
                        @endif
                    </div>

                    <script>
                        @if (!$show_pengumuman)
                            // Ambil waktu pengumuman dari atribut data
                            var countdownDate = new Date(
                                "{{ Carbon::create($data->tanggal_pengumuman)->toDateString() }} {{ Carbon::create($data->tanggal_pengumuman)->format('H:i') }}"
                            ).getTime();

                            // Update setiap detik
                            var x = setInterval(function() {

                                var now = new Date().getTime();
                                var distance = countdownDate - now;

                                // Kalkulasi waktu untuk hari, jam, menit, detik
                                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                // Update kotak countdown
                                document.getElementById("days").innerHTML = "<strong>" + days +
                                    "</strong></strong> <span style='position: relative; top: -8px; font-size: 18px;'>Hari</span>";
                                document.getElementById("hours").innerHTML = "<strong>" + hours +
                                    "</strong></strong> <span style='position: relative; top: -8px; font-size: 18px;'>Jam</span> ";
                                document.getElementById("minutes").innerHTML = "<strong>" + minutes +
                                    "</strong> <span style='position: relative; top: -8px; font-size: 18px;'>Menit</span>";
                                document.getElementById("seconds").innerHTML = "<strong>" + seconds +
                                    "</strong> <span style='position: relative; top: -8px; font-size: 18px;'>Detik</span>";




                                // Jika pengumuman sudah lewat
                                if (distance < 0) {
                                    clearInterval(x);
                                    document.getElementById("countdown-timer").innerHTML =
                                        "<strong>Waktu Pengumuman Telah Tiba!</strong>";
                                }
                            }, 1000);
                        @endif
                    </script>



                </div>
            </div>
        </div>
    </section>
</x-layout>
