@extends('layouts.cbt')

@section('content')
    <style>
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

        {{-- DROPDOWN FONT SIZE & TIMER --}}
        <div class="bg-white p-3 border-bottom d-flex justify-content-between flex-wrap align-items-center">
            <div class="d-flex align-items-center">
                <!-- Label untuk ukuran font -->
                <label class="form-label mb-0 me-3" for="fontSizeSelect">
                    <i class="fa fa-text-height"></i> Ukuran Font
                </label>

                <!-- Tombol untuk memilih ukuran font -->
                <div class="btn-group" role="group" aria-label="Font Size Selection">
                    <button id="smallFontBtn" class="btn btn-outline-success text-center" title="Font Kecil">
                        <i class="fas fa-font" style="font-size: 12px;"></i>
                    </button>
                    <button id="mediumFontBtn" class="btn btn-outline-success" title="Font Sedang">
                        <i class="fas fa-font" style="font-size: 16px;"></i>
                    </button>
                    <button id="largeFontBtn" class="btn btn-outline-success" title="Font Besar">
                        <i class="fas fa-font" style="font-size: 20px;"></i>
                    </button>
                </div>
            </div>


            <div class="border rounded px-3 py-2 d-flex align-items-center gap-2 mt-2 mt-md-0">
                <strong>Waktu Tersisa:</strong>
                <span id="time" class="fw-bold text-danger fs-5">--:--</span>
            </div>
        </div>

        <div class="row g-0">
            {{-- KIRI: SOAL --}}
            <div class="col-md-9 border-end p-4 bg-light" style="min-height: 100vh;">
                <form action="{{ route('cbt.submit') }}" method="POST" id="cbtForm">
                    @csrf

                    {{-- Identitas Tambahan --}}
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    <input type="hidden" name="test_id" value="{{ $Jadwal->id }}">

                    @foreach ($soals as $index => $soal)
                        <div class="soal-item font-medium {{ $index === 0 ? '' : 'd-none' }}"
                            data-index="{{ $index }}">
                            <div class="border bg-white rounded shadow-sm p-4 mb-4 shadow-lg">

                                {{-- Nomor Soal --}}
                                <div class="mb-3">
                                    <div class="border rounded px-3 py-2 bg-light d-inline-block">
                                        <strong>Soal Nomor :</strong>
                                        <span class="badge bg-primary text-white p-2">{{ $index + 1 }}</span>
                                    </div>
                                </div>

                                {{-- Soal --}}
                                {{-- Soal --}}
                                <div class="mb-3">
                                    <p class="soal-text">{!! $soal->soal !!}</p>
                                </div>

                                {{-- Jawaban --}}
                                @foreach (['A', 'B', 'C', 'D'] as $opt)
                                    @php
                                        $terjawab = $jawaban_terisi[$soal->id] ?? null;
                                    @endphp
                                    <div class="form-check mb-2">
                                        <input type="radio" class="form-check-input" name="jawaban[{{ $soal->id }}]"
                                            id="{{ strtolower($opt) }}_{{ $soal->id }}" value="{{ $opt }}"
                                            {{ $terjawab === $opt ? 'checked' : '' }}>
                                        <label class="form-check-label pilihan-text"
                                            for="{{ strtolower($opt) }}_{{ $soal->id }}">
                                            <strong>{{ $opt }}.</strong>
                                            {{ $soal->{'jawaban' . strtolower($opt)} }}
                                        </label>
                                    </div>
                                @endforeach


                            </div>
                        </div>
                    @endforeach


                    <div class="d-flex justify-content-between mt-4 ">
                        <button type="button" class="btn btn-secondary px-4 py-2" id="prevBtn">Sebelumnya</button>
                        <button type="button" class="btn btn-primary px-4 py-2" id="nextBtn">Berikutnya</button>
                        <button type="submit" class="btn btn-success px-4 py-2 d-none" id="submitBtn">Selesai</button>
                    </div>
                </form>

            </div>

            {{-- KANAN: NAVIGASI --}}
            <div class="col-md-3 bg-white p-3 shadow-lg">
                <div class="btn disabled bg-primary rounded d-flex justify-content-center py-3 my-2">
                    <h4 class="m-0 text-center text-light">Soal</h4>
                </div>

                <div class="d-grid gap-2 grid-template-columns-5">
                    @foreach ($soals as $index => $soal)
                        @php
                            $terjawab = $jawaban_terisi[$soal->id] ?? null;
                            $btnClass = $terjawab ? 'btn-success' : 'btn-outline-primary';
                        @endphp
                        <button type="button" class="btn {{ $btnClass }} nomor-soal-btn"
                            data-index="{{ $index }}" data-soalid="{{ $soal->id }}">
                            {{ $index + 1 }}
                        </button>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Mengambil tombol dan elemen yang akan diubah ukurannya
        const smallBtn = document.getElementById("smallFontBtn");
        const mediumBtn = document.getElementById("mediumFontBtn");
        const largeBtn = document.getElementById("largeFontBtn");

        const soalElements = document.querySelectorAll(".soal-text"); // Semua elemen soal
        const pilihanElements = document.querySelectorAll(".pilihan-text"); // Semua elemen pilihan

        // Fungsi untuk mengubah ukuran font
        function changeFontSize(size) {
            soalElements.forEach(function(soal) {
                soal.style.fontSize = size; // Mengubah ukuran font soal
            });

            pilihanElements.forEach(function(pilihan) {
                pilihan.style.fontSize = size; // Mengubah ukuran font pilihan
            });
        }

        // Event listener untuk tombol font kecil
        smallBtn.addEventListener("click", function() {
            changeFontSize("12px"); // Ukuran font kecil
        });

        // Event listener untuk tombol font sedang
        mediumBtn.addEventListener("click", function() {
            changeFontSize("16px"); // Ukuran font sedang
        });

        // Event listener untuk tombol font besar
        largeBtn.addEventListener("click", function() {
            changeFontSize("20px"); // Ukuran font besar
        });
    </script>

    <script>
        // Menangkap soal_id dan jawaban yang dipilih setiap kali ada perubahan pada radio button
        $(document).on('change', 'input[type="radio"]', function() {
            var soal_id = $(this).attr('name').match(/\d+/)[0]; // Mendapatkan soal_id dari atribut 'name'
            var jawaban = $(this).val(); // Mengambil nilai jawaban yang dipilih
            console.log({
                soal_id,
                jawaban,
                user_id: {{ auth()->id() }},
                mapel_id: {{ $Jadwal->mapel_id }},
                test_id: {{ $Jadwal->id }},
                detailguru_id: {{  $Jadwal->detailguru_id ?? 'null' }}
            });
            // Menyimpan jawaban menggunakan Ajax atau melakukan tindakan lainnya
            $.post("{{ route('cbt.autosave') }}", {
                _token: "{{ csrf_token() }}",
                soal_id: soal_id,
                jawaban: jawaban,
                user_id: {{ auth()->id() }},
                mapel_id: {{ $Jadwal->mapel_id }},
                test_id: {{ $Jadwal->id }},
                detailguru_id: {{  $Jadwal->detailguru_id ?? 'null' }},
            }).done(function(res) {
                if (res.status === 'success') {
                    console.log('Jawaban soal ID ' + soal_id + ' disimpan otomatis.');
                } else {
                    console.error('Gagal menyimpan jawaban otomatis: ', res.message);
                }
            }).fail(function(xhr, status, error) {
                console.error('Gagal menyimpan jawaban otomatis: ', error);
            });
        });
    </script>
    <script>
        $(document).on('change', 'input[type="radio"]', function() {
            var soalId = $(this).attr('name').match(/\d+/)[0];
            $('button[data-soalid="' + soalId + '"]').removeClass('btn-outline-primary').addClass('btn-success');
        });
    </script>

    <script>
        // LOGIKA MENAMPILKAN SOAL
        let current = 0;
        const soalItems = document.querySelectorAll('.soal-item');

        // Menampilkan soal berdasarkan index
        function showSoal(index) {
            soalItems.forEach((el, i) => {
                el.classList.toggle('d-none', i !== index); // Menyembunyikan soal yang tidak dipilih
            });

            // Mengatur tombol Previous dan Next
            document.getElementById('prevBtn').disabled = index === 0; // Tombol Previous non-aktif di soal pertama
            document.getElementById('nextBtn').classList.toggle('d-none', index === soalItems.length -
                1); // Tombol Next non-aktif di soal terakhir
            document.getElementById('submitBtn').classList.toggle('d-none', index !== soalItems.length -
                1); // Tombol Selesai muncul di soal terakhir
            current = index; // Menyimpan indeks soal yang sedang aktif
        }

        // Tombol Previous dan Next
        document.getElementById('prevBtn').addEventListener('click', () => showSoal(current - 1));
        document.getElementById('nextBtn').addEventListener('click', () => showSoal(current + 1));

        // Tombol nomor soal (untuk navigasi langsung)
        document.querySelectorAll('.nomor-soal-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                showSoal(parseInt(btn.getAttribute('data-index')));
            });
        });

        // Menampilkan soal pertama saat halaman pertama kali dimuat
        document.addEventListener('DOMContentLoaded', () => {
            showSoal(current);
        });
    </script>

    <script>
        // Saat radio dipilih, tandai tombol navigasi soal
        document.querySelectorAll('input[type="radio"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                let soalId = this.name.match(/\d+/)[0]; // ambil ID soal dari name="jawaban[xx]"
                let btn = document.querySelector(`.nomor-soal-btn[data-soalid="${soalId}"]`);
                if (btn) {
                    btn.classList.remove('btn-outline-primary');
                    btn.classList.add('btn-success');
                }
            });
        });
    </script>

    <script>
        const timerElement = document.getElementById("time");

        // Ambil waktu dari server (dalam menit), dikalikan 60 detik
        const TOTAL_TIME = {{ $Jadwal->waktu }} * 60;
        const testId = {{ $Jadwal->id }}; // ID Tes yang sedang dijalankan

        // Cek localStorage, gunakan sisa waktu jika ada, berdasarkan ID tes
        let savedTime = localStorage.getItem(`cbt_timer_${testId}`);
        let timer = savedTime ? parseInt(savedTime) : TOTAL_TIME;

        // Periksa apakah timer sudah terdefinisi dengan benar
        console.log("Initial Timer: " + timer);

        // Menampilkan waktu awal di layar
        function formatTime(time) {
            let h = Math.floor(time / 3600);
            let m = Math.floor((time % 3600) / 60);
            let s = time % 60;
            return `${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
        }

        timerElement.textContent = formatTime(timer); // Menampilkan waktu di awal

        const interval = setInterval(() => {
            timer--;

            // Simpan waktu yang tersisa di localStorage
            localStorage.setItem(`cbt_timer_${testId}`, timer);

            // Update tampilan waktu
            timerElement.textContent = formatTime(timer);

            // Habis waktunya
            if (timer <= 0) {
                clearInterval(interval);
                localStorage.removeItem(`cbt_timer_${testId}`); // Menghapus timer setelah waktu habis
                localStorage.setItem(`cbt_timer_expired_${testId}`, 'true'); // Menyimpan status waktu habis
                alert("Waktu habis!");
                document.getElementById("cbtForm").submit();
            }
        }, 1000);
    </script>


    <script>
        // FONT SIZE LOGIC
        document.addEventListener('DOMContentLoaded', function() {
            const fontSizeSelect = document.getElementById('fontSizeSelect');
            const soalItems = document.querySelectorAll('.soal-item');

            function updateFontSize(size) {
                soalItems.forEach(el => {
                    el.classList.remove('font-small', 'font-medium', 'font-large');
                    el.classList.add('font-' + size);
                });
            }

            fontSizeSelect.addEventListener('change', function() {
                updateFontSize(this.value);
            });

            updateFontSize(fontSizeSelect.value);
        });




        // NAVIGASI SOAL
        let current = 0;
        const soalItems = document.querySelectorAll('.soal-item');

        function showSoal(index) {
            soalItems.forEach((el, i) => {
                el.classList.toggle('d-none', i !== index);
            });
            document.getElementById('prevBtn').disabled = index === 0;
            document.getElementById('nextBtn').classList.toggle('d-none', index === soalItems.length - 1);
            document.getElementById('submitBtn').classList.toggle('d-none', index !== soalItems.length - 1);
            current = index;
        }

        document.getElementById('prevBtn').addEventListener('click', () => showSoal(current - 1));
        document.getElementById('nextBtn').addEventListener('click', () => showSoal(current + 1));
        document.querySelectorAll('.nomor-soal-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                showSoal(parseInt(btn.getAttribute('data-index')));
            });
        });

        // JAWABAN DICENTANG -> TOMBOL JADI HIJAU
        document.querySelectorAll('input[type="radio"]').forEach(input => {
            input.addEventListener('change', function() {
                const soalId = this.name.split('_')[1];
                const btn = document.querySelector(`.nomor-soal-btn[data-soalid="${soalId}"]`);
                if (btn) {
                    btn.classList.remove('btn-outline-primary');
                    btn.classList.add('btn-success');
                }
            });
        });
    </script>
@endsection
