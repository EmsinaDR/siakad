<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Absensi Siswa QR AJAX</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <script src="https://unpkg.com/html5-qrcode" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js" defer></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
        }

        #reader {
            width: 300px;
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f0f0f0;
        }

        .success {
            background-color: #e0ffe0;
        }

        .error {
            background-color: #ffe0e0;
        }
    </style>

</head>

<body>
    <div class="card shadow mb-4 ">
        <div class="card-header bg-success text-white d-flex align-items-center justify-content-between">
            <!-- Logo Sekolah -->
            <div class="d-flex align-items-center gap-3">
                <img class='img-circle img-fluid d-block mx-auto  mb-2' src="{{ app('request')->root() }}/img/logo.png"
                    alt="Logo Sekolah" width="60" height="60" class="me-3">
                <div class="text-start">
                    <h2 class="mb-0 fw-bold">{{ $Identitas->namasek }}</h2>
                    <h4>Sistem Absensi Siswa Berbasis QR Code</h4>
                </div>
            </div>
        </div>
    </div>


    {{-- <div class="container"> --}}
    <div class="row">
        <div class="col-md-4">
            <h2>Scan QR Absensi</h2>
            <div id="reader"></div>
            <div id="result" class="p-4 mt-3"></div>
        </div>
        <div class="col-md-8">
            <div class='card-header bg-success text-white p-1'>
                <h3 class='card-title'>Rekap Absen Kelas</h3>
            </div>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">Kelas</th>
                        <th class="text-center">Total Siswa</th>
                        <th class="text-center">Sudah Absen</th>
                        <th class="text-center">Belum Absen</th>
                    </tr>
                </thead>
                <tbody id="rekap-per-kelas">
                    @foreach ($rekapPerKelas as $rekap)
                        <tr>
                            <td class="text-center">
                                <span class="badge bg-primary">{{ $rekap['kelas_nama'] }}</span>
                            </td>

                            <td class="text-center">{{ $rekap['total_siswa'] }}</td>

                            <td class="text-center">
                                <span class="badge bg-success">{{ $rekap['sudah_absen'] }}</span>
                            </td>

                            <td class="text-center">
                                <span class="badge bg-danger">{{ $rekap['belum_absen'] }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <script>
                function updateRekap() {
                    axios.get("{{ route('absensi.rekap.absen.ajax') }}")
                        .then(response => {
                            const tbody = document.querySelector("#rekap-per-kelas");
                            let rows = "";

                            Object.values(response.data).forEach(r => {
                                rows += `
                    <tr>
                        <td class="text-center"><span class="badge bg-primary">${r.kelas_nama}</span></td>
                        <td class="text-center">${r.total_siswa}</td>
                        <td class="text-center"><span class="badge bg-success">${r.sudah_absen}</span></td>
                        <td class="text-center"><span class="badge bg-danger">${r.belum_absen}</span></td>
                    </tr>
                `;
                            });

                            tbody.innerHTML = rows;
                        })
                        .catch(err => console.error(err));
                }

                // panggil setiap 5 detik
                setInterval(updateRekap, 5000);

                // panggil langsung ketika page load
                updateRekap();
            </script>
            <div class='card-header bg-success text-white p-1'>
                <h3 class='card-title'>Daftar Absen</h3>
            </div>
            <table class="table table-bordered">
                <thead class="table-success">
                    <tr>
                        <th class="text-center">Nama</th>
                        <th class="text-center">NIS</th>
                        <th class="text-center">Absen</th>
                        <th class="text-center">Jenis Absen</th>
                        <th class="text-center">Waktu</th>
                    </tr>
                </thead>
                <tbody id="absenList">
                    @foreach ($absensi as $data)
                        <tr>
                            <td>( <span class="badge bg-primary">{{ $data->detailsiswa_id ?? '-' }}</span> )
                                {{ $data->detailsiswa->nama_siswa ?? '-' }}</td>
                            <td>{{ $data->detailsiswa->nis ?? '-' }}</td>
                            <td class="text-center">{{ $data->absen ? ucfirst($data->absen) : '-' }}</td>
                            <td class="text-center">{{ $data->jenis_absen ? ucfirst($data->jenis_absen) : '-' }}</td>

                            <td>{{ $data->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- </div> --}}

    {{-- axios.post("{{ route('absensi.store.siswa.ajax') }}", { --}}

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const resultDiv = document.getElementById("result");
            const absenList = document.getElementById("absenList");

            const html5QrCode = new Html5Qrcode("reader");
            const config = {
                fps: 10,
                qrbox: 250
            };
            function statusBadge(statusRaw) {
                if (!statusRaw) return `<span class="badge bg-secondary">-</span>`;

                const s = statusRaw.toLowerCase();
                const ucfirst = statusRaw.charAt(0).toUpperCase() + statusRaw.slice(1);

                if (s === 'alfa') {
                    return `<span class="badge bg-danger"><i class="bi bi-x-circle"></i> ${ucfirst}</span>`;
                }
                if (s === 'hadir') {
                    return `<span class="badge bg-success"><i class="bi bi-check-circle"></i> ${ucfirst}</span>`;
                }
                if (s === 'sakit') {
                    return `<span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle"></i> ${ucfirst}</span>`;
                }

                return `<span class="badge bg-secondary">${ucfirst}</span>`;
            }


            function onScanSuccess(decodedText) {
                html5QrCode.stop();

                resultDiv.textContent = "Memproses NIS: " + decodedText;
                resultDiv.className = "";

                axios.post("{{ route('absensi.store.siswa.ajax') }}", {
                        nis: decodedText
                    })
                    .then(response => {
                        const res = response.data;

                        if (!res.success) {
                            resultDiv.textContent = res.message || "Terjadi kesalahan saat absen";
                            resultDiv.className = "error";
                            return;
                        }

                        const data = res.data;

                        // Badge status absen
                        const badgeAbsen = statusBadge(data.absen);

                        // Badge ID siswa
                        const badgeID = `<span class="badge bg-primary">${data.detailsiswa_id ?? '-'}</span>`;

                        const row = document.createElement("tr");
                        row.innerHTML = `
                <td>( ${badgeID} ) ${data.nama}</td>
                <td>${data.nis}</td>
                <td class="text-center">${badgeAbsen}</td>
                <td>${ucfirstx(data.jenis_absen)}</td>
                <td>${data.waktu}</td>
            `;
                        row.classList.add("success");

                        // Refresh list agar sinkron dengan server
                        loadAbsenList();

                        resultDiv.textContent = "Absensi berhasil untuk " + data.nama;
                    })
                    .catch(error => {
                        resultDiv.textContent = error.response?.data?.message || "Terjadi kesalahan saat absen";
                        resultDiv.className = "error";
                    })
                    .finally(() => {
                        setTimeout(() => {
                            resultDiv.textContent = "";
                            resultDiv.className = "";
                            html5QrCode.start({
                                    facingMode: "environment"
                                },
                                config,
                                onScanSuccess
                            );
                        }, 2000);
                    });
            }

            Html5Qrcode.getCameras().then(devices => {
                if (devices && devices.length) {
                    html5QrCode.start({
                            facingMode: "environment"
                        },
                        config,
                        onScanSuccess
                    );
                }
            });
            loadAbsenList();
            setInterval(loadAbsenList, 10000); // tiap 10 detik

        });
    </script>
    <script>
        // Format badge status absen
        function statusBadge(statusRaw) {
            if (!statusRaw) return `<span class="badge bg-secondary">-</span>`;

            const s = statusRaw.toLowerCase();
            const ucfirst = statusRaw.charAt(0).toUpperCase() + statusRaw.slice(1);

            if (s === 'alfa') {
                return `<span class="badge bg-danger"><i class="bi bi-x-circle"></i> ${ucfirst}</span>`;
            }

            if (s === 'hadir') {
                return `<span class="badge bg-success"><i class="bi bi-check-circle"></i> ${ucfirst}</span>`;
            }

            if (s === 'sakit') {
                return `<span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle"></i> ${ucfirst}</span>`;
            }

            return `<span class="badge bg-secondary">${ucfirst}</span>`;
        }

        function loadAbsenList() {
            const absenListUrl = "{{ route('absensi.list.siswa') }}";

            axios.get(absenListUrl)
                .then(response => {
                    const absenList = document.getElementById("absenList");

                    const rows = response.data.map(data => {

                        const badgeID = `<span class="badge bg-primary">${data.detailsiswa_id ?? '-'}</span>`;
                        const badgeAbsen = statusBadge(data.absen);

                        return `
                        <tr>
                            <td>( ${badgeID} ) ${data.nama}</td>
                            <td>${data.nis}</td>
                            <td class='text-center'>${badgeAbsen}</td>
                <td>${ucfirstx(data.jenis_absen)}</td>
                            <td>${data.waktu}</td>
                        </tr>
                    `;
                    }).join("");

                    absenList.innerHTML = rows;
                })
                .catch(error => {
                    console.error("Gagal memuat data absensi:", error);
                });
        }
    </script>



</body>

</html>
