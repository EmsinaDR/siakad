<x-layout-portal-wa-siswa>
    <script src="https://unpkg.com/html5-qrcode" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
            background: #f8f9fa;
            font-family: sans-serif;
        }

        #reader {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        .success {
            background-color: #e0ffe0;
        }

        .error {
            background-color: #ffe0e0;
        }
    </style>

    <h3 class="mb-4 bg-success text-white text-center">Scan QR untuk Menampilkan Data Siswa</h3>

    <div class="row">
        <div class="col-md-5">
            <div id="reader" class="border rounded shadow-sm mb-4"></div>
        </div>
        <div class="col-md-7">
            <div id="result" class="p-4 bg-white border rounded shadow-sm text-center">
                <p class="text-muted">Silakan scan QR Code yang berisi NIS.</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const resultDiv = document.getElementById("result");
            const html5QrCode = new Html5Qrcode("reader");
            const config = {
                fps: 10,
                qrbox: 250
            };

            function startScanner() {
                const qrDiv = document.getElementById("reader");
                if (!qrDiv || !resultDiv) return;

                function onScanSuccess(decodedText) {
                    html5QrCode.stop();
                    resultDiv.innerHTML = `<div class="text-muted">Proses Pencarian NIS: ${decodedText}...</div>`;
                    resultDiv.className = "";

                    axios.post("{{ route('siswa.scan') }}", {
                            nis: decodedText
                        })
                        .then(response => {
                            const res = response.data;
                            if (!res.success) {
                                resultDiv.textContent = res.message;
                                resultDiv.className = "error";
                                return;
                            }

                            const data = res.data;
                            resultDiv.innerHTML = `
                                    <div class="card shadow-sm p-1">
                                        <h5 class="bg-success text-white mb-3 p-2">${data.nama_siswa}</h5>
                                        <table class="table table-sm mb-0">
                                            <tbody>
                                                <tr>
                                                    <th scope="row">NIS</th>
                                                    <td>: ${data.nis}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Kelas</th>
                                                    <td>: ${data.kelas}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">No HP Ayah</th>
                                                    <td>: ${data.nohpayah}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">No HP Ibu</th>
                                                    <td>: ${data.nohpibu}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="p-1 mt-3">
                                            <div class="form-group">
                                                <label for="pesan">Pesan</label>
                                                <input type="text" class="form-control" id="pesan" name="pesan" placeholder="placeholder" required>
                                            </div>
                                        </div>
                                    </div>


                                `;

                            resultDiv.className = "success";
                        })
                        .catch(error => {
                            resultDiv.textContent = error.response?.data?.message || "Gagal mengambil data.";
                            resultDiv.className = "error";
                        })
                        .finally(() => {
                            setTimeout(() => {
                                html5QrCode.start({
                                    facingMode: "environment"
                                }, config, onScanSuccess);
                            }, 3000);
                        });
                }

                html5QrCode.start({
                        facingMode: "environment"
                    }, config, onScanSuccess)
                    .catch(err => {
                        resultDiv.textContent = "Gagal memulai kamera: " + err;
                        resultDiv.className = "error";
                    });
            }

            startScanner(); // 🔥 Panggil fungsi scanner di sini!
        });
    </script>
</x-layout-portal-wa-siswa>
