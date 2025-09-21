<!DOCTYPE html>
<html lang="id">
@php
    use Carbon\Carbon;
@endphp

<head>
    <meta charset="UTF-8">
    <title>Absensi Guru QR AJAX </title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <!-- atau ICO -->
    {{-- <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}"> --}}
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
                    <h4>Sistem Absensi Guru Berbasis QR Code</h4>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="container"> --}}
    <div class="row">
        <div class="col-md-4">
            <h2>Scan QR Absensi</h2>
            IP : {{ getIp() }}<br>
            <div id="reader"></div>
            <div id="result" class="p-4 mt-3"></div>
            {{-- <input type="hidden" id="ip" name="ip" value='{{ getIp() }}' readonly> <br>
            <input type="hidden" id="Agent" name="Agent" value='{{ getUserAgent() }}' readonly> <br>
            <input type="hidden" id="getDeviceName" name="getDeviceName" value='{{ getDeviceName() }}' readonly> <br> --}}
            {{-- User Agent : {{ getUserAgent() }} <br>
            Device : {{ getDeviceName() }}<br>
            Map :<br>
            Lat : <input type="text" id="lat" name="lat" readonly>
            Long: <input type="text" id="lng" name="lng" readonly> --}}

            <script>
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        let lat = position.coords.latitude;
                        let lng = position.coords.longitude;

                        console.log("Lat:", lat, "Lng:", lng);

                        // contoh kirim ke Laravel via hidden input
                        document.getElementById("lat").value = lat;
                        document.getElementById("lng").value = lng;
                    });
                } else {
                    alert("Browser tidak support geolocation.");
                }
            </script>

        </div>
        <div class="col-md-8">
            <h2>Daftar Absensi Guru {{ Carbon::now()->translatedformat('l, d F Y') }}</h2>

            <table class="table table-bordered">
                <thead class="table-success">
                    <tr>
                        <th>Nama</th>
                        <th>Kode Guru</th>
                        <th>Waktu</th>
                        <th>Terlambat</th>
                    </tr>
                </thead>
                <tbody id="absenList">
                    @foreach ($absensiGuru as $data)
                        <tr>
                            <td>{{ $data->guru->nama_guru ?? '-' }}</td>
                            <td>{{ $data->guru->kode_guru ?? '-' }}</td>
                            <td>{{ $data->created_at }}</td>
                            <td>{{ $data->terlambat }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- </div> --}}


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const resultDiv = document.getElementById("result");
            const absenList = document.getElementById("absenList");
            // const lat = document.getElementById("lat").value;
            // const lng = document.getElementById("lng").value;

            const html5QrCode = new Html5Qrcode("reader");
            const config = {
                fps: 10,
                qrbox: 250
            };

            function onScanSuccess(decodedText) {
                html5QrCode.stop();
                resultDiv.textContent = "Memproses Kode Guru: " + decodedText;
                resultDiv.className = "";

                axios.post("{{ route('absensi.store.guru.ajax') }}", {
                        kode_guru: decodedText,
                        lat: lat, // Untuk map lat
                        lng: lng, // Untuk map long

                    })
                    .then(response => {
                        const res = response.data;

                        if (!res.success) {
                            resultDiv.textContent = res.message || "Terjadi kesalahan saat absen";
                            resultDiv.className = "error";
                            return;
                        }

                        const data = res.data;
                        const row = document.createElement("tr");
                        row.innerHTML = `
                                            <td>${data.nama_guru}</td>
                                            <td>${data.kode_guru}</td>
                                            <td>${data.waktu}</td>
                                            <td>${data.terlambat}</td>
                                        `;
                        row.classList.add("success");
                        // absenList.prepend(row);
                        loadAbsenList(); // reload data dari server agar sinkron
                        resultDiv.textContent = "Absensi berhasil untuk " + data.nama_guru;
                    })
                    .catch(error => {
                        resultDiv.textContent = error.response?.data?.message || "Terjadi kesalahan saat absen";
                        resultDiv.className = "error";
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
                            }, config, onScanSuccess);
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
        function loadAbsenList() {
            axios.get("{{ route('absensi.list.guru') }}")
                .then(response => {
                    const absenList = document.getElementById("absenList");
                    const rows = response.data.map(data => {
                        return `
                        <tr>
                            <td>${data.nama_guru}</td>
                            <td>${data.kode_guru}</td>
                            <td>${data.waktu}</td>
                            <td>${data.terlambat}</td>
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
