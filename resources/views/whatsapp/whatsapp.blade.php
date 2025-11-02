<x-layout>
    <style>
        textarea {
            resize: none,
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
            {{-- rm -rf .wwebjs_auth <br> --}}

            {{-- Papan Informasi --}}
            <div class='card-body'>
                <div class="row">
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>Data Akun</h3>
                    </div>
                    <div class="col-xl-2 my-2">
                        {{-- blade-formatter-disable --}}
                        <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#TambahAkun'><i class='fa fa-user'></i> Tambah Akun</button>
                        <button type='button' class='btn btn-block btn-default bg-primary btn-md' id='runServerBtn'></i> 🔥 Jalankan WA Server</button>
                        <button type="button" class="btn btn-block btn-default bg-primary btn-md" id="restartServer"><i class="fas fa-sync-alt"></i> Restart Server</button>
                        <meta name="csrf-token" content="{{ csrf_token() }}">

                        <script>
                            document.getElementById('runServerBtn').addEventListener('click', function() {
                                // alert('ddd');
                                fetch('{{ url('/run-wa-server') }}', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                            'Content-Type': 'application/json',
                                            'Accept': 'application/json'
                                        }
                                    })
                                    .then(res => res.json())
                                // .then(data => alert(data.message))
                                // .catch(err => alert('Gagal: ' + err.message));
                            });
                            document.getElementById('restartServer').addEventListener('click', function() {
                                // alert('ddd');
                                fetch('{{ url('/restart-wa-server') }}', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                            'Content-Type': 'application/json',
                                            'Accept': 'application/json'
                                        }
                                    })
                                    .then(res => res.json())
                                // .then(data => alert(data.message))
                                // .catch(err => alert('Gagal: ' + err.message));
                            });
                        </script>
                        {{-- blade-formatter-enable --}}

                    </div>
                    <div class="col-xl-8 my-2"></div>
                </div>
            </div>

            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->


            <div class='ml-2 my-4'>

                <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.1/socket.io.js"></script>
                <h2>WhatsApp WebJS - Scan QR Code</h2>
                {{-- <input type="text" id="session_id" placeholder="Enter your session ID"> --}}
                <div class="row">
                    <div class="col-xl-6">
                        <div class='form-group'>
                            <label for='session_id'>Pilih Sesi</label>
                            <select name='session_id' id='session_id' class='form-control'
                                data-placeholder="Pilih sesi yang ingin diaktifkan">
                                <option value=''>--- Pilih Sesi ---</option>
                                {{-- <option value='Siswa'>Siswa</option> --}}
                                {{-- <option value='Pembayaran'>Pembayaran</option> --}}
                                @foreach ($whatsappAkuns as $whatsappAkun)
                                    <option value='{{ $whatsappAkun->akun_id }}'>{{ $whatsappAkun->nama_akun }}</option>
                                @endforeach
                                <option value='GuruId'>Guru</option>
                                @foreach ($DataSessionNames as $DataSessionName)
                                    <option value='{{ $DataSessionName->akun_id }}'>{{ $DataSessionName->nama_akun }} -
                                        {{ $DataSessionName->no_hp }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button class='btn btn-sm btn-primary'onclick="startSession()">Start Session</button>
                        <button class='btn btn-sm btn-primary'onclick="checkStatus()">Check Status</button>
                        <button class='btn btn-sm btn-primary'onclick="removeSession()">Remove Session</button>
                        <br><br>
                    </div>
                    <div class="col-xl-6">
                        <img id="qr_code" style="width: 300px; display: none;">
                        <h3 id="status"></h3>
                        <script>
                            function checkServerStatus() {
                                fetch("{{ route('wa.status') }}")
                                    .then(response => response.json())
                                    .then(data => {
                                        document.getElementById("status").innerText = data.status;
                                        document.getElementById("status").style.color = "green";
                                    })
                                    .catch(error => {
                                        document.getElementById("status").innerText = "⚠️ Server WhatsApp JS belum aktif!";
                                        document.getElementById("status").style.color = "red";
                                    });
                            }

                            document.addEventListener("DOMContentLoaded", checkServerStatus);
                        </script>
                        <script>
                            function removeSession() {
                                const sessionId = document.getElementById('session_id').value;
                                if (!sessionId) {
                                    alert('⚠️ Pilih dulu sesi yang ingin dihapus!');
                                    return;
                                }

                                if (!confirm(`Yakin ingin hapus sesi '${sessionId}'?`)) return;

                                fetch("{{ url('/hapus-sesi-wa') }}", {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Content-Type': 'application/json'
                                        },
                                        body: JSON.stringify({
                                            session_id: sessionId
                                        })
                                    })
                                    .then(res => res.json())
                                    .then(data => alert(data.message))
                                    .catch(err => alert('❌ Gagal: ' + err.message));
                            }
                        </script>
                        {{-- <h3 id="server-status" style="color: red;">Memeriksa server...</h3> --}}

                    </div>
                </div>

                <script>
                    // Ambil IP server secara otomatis
                    const baseUrl = `${window.location.protocol}//${window.location.hostname}:3000`;

                    // Koneksi socket.io
                    const socket = io(baseUrl, {
                        transports: ["websocket", "polling"]
                    });
                    // Fungsi untuk mengecek status sesi WhatsApp
                    async function checkStatus() {
                        let sessionId = document.getElementById("session_id").value;
                        let statusElement = document.getElementById("status");

                        if (!sessionId) {
                            alert("Masukkan ID sesi terlebih dahulu.");
                            return;
                        }

                        statusElement.innerText = "Mengecek status...";

                        try {
                            const response = await fetch(`${baseUrl}/status/${sessionId}`);
                            const data = await response.json();

                            if (response.ok && data.status) {
                                statusElement.innerText = `Status sesi "${sessionId}": ${data.status}`;
                            } else {
                                statusElement.innerText = `Status tidak tersedia: ${data.error || "Tidak dikenal"}`;
                            }
                        } catch (error) {
                            console.error("Gagal cek status:", error);
                            statusElement.innerText = "Gagal mengecek status sesi.";
                        }
                    }


                    // Fungsi untuk memulai sesi WhatsApp
                    async function startSession() {
                        let sessionId = document.getElementById("session_id").value;
                        let statusElement = document.getElementById("status");
                        let qrElement = document.getElementById("qr_code");

                        if (!sessionId) {
                            alert("Harap masukkan ID sesi terlebih dahulu.");
                            return;
                        }

                        statusElement.innerText = "Memulai sesi, harap tunggu...";
                        qrElement.style.display = "none";

                        try {
                            let response = await fetch(`${baseUrl}/start-session`, {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json"
                                },
                                body: JSON.stringify({
                                    id: sessionId
                                })
                            });

                            let data = await response.json();
                            if (!response.ok) {
                                throw new Error(data.error || "Terjadi kesalahan saat memulai sesi");
                            }

                            statusElement.innerText = data.message || "Sesi berhasil dimulai!";
                            listenForQRCode(sessionId);
                        } catch (error) {
                            console.error("Error saat memulai sesi:", error);
                            statusElement.innerText = `Gagal: ${error.message}`;
                        }
                    }

                    function listenForQRCode(sessionId) {
                        let qrCodeElement = document.getElementById("qr_code");
                        let statusElement = document.getElementById("status");

                        console.log(`📡 Menunggu QR Code untuk sesi: ${sessionId}...`);
                        statusElement.innerText = "⌛ Menunggu QR Code dari server...";
                        statusElement.style.color = "orange";

                        socket.off(`qr-${sessionId}`); // bersihin listener lama biar gak dobel
                        socket.on(`qr-${sessionId}`, (qr) => {
                            if (qr) {
                                console.log(`✅ QR Code diterima untuk sesi ${sessionId}`);
                                qrCodeElement.src = qr;
                                qrCodeElement.style.display = "block";
                                statusElement.innerText = "📲 Silakan scan QR Code dengan WhatsApp";
                                statusElement.style.color = "blue";
                            } else {
                                console.log(`ℹ️ Tidak ada QR Code (kemungkinan sudah login)`);
                                qrCodeElement.style.display = "none";
                                statusElement.innerText = `✅ Sesi "${sessionId}" sudah aktif, tidak perlu scan QR lagi.`;
                                statusElement.style.color = "green";
                            }
                        });

                        socket.on(`error-${sessionId}`, (error) => {
                            console.error(`❌ Error dari server untuk sesi ${sessionId}:`, error);
                            statusElement.innerText = `Error: ${error}`;
                            statusElement.style.color = "red";
                        });
                    }

                    // Fungsi untuk menangkap QR Code dan status koneksi
                    // function listenForQRCode(sessionId) {
                    //     let qrCodeElement = document.getElementById("qr_code");
                    //     let statusElement = document.getElementById("status");

                    //     socket.on(`qr-${sessionId}`, (qr) => {
                    //         console.log(`QR Code diterima untuk sesi ${sessionId}:`, qr);

                    //         // Cek apakah QR kosong (berarti sesi sudah aktif)
                    //         if (!qr) {
                    //             qrCodeElement.style.display = "none";
                    //             statusElement.innerText = `✅ Sesi "${sessionId}" sudah aktif, tidak perlu scan QR lagi.`;
                    //             statusElement.style.color = "green";
                    //             return;
                    //         }

                    //         // Jika QR valid, tampilkan QR dan instruksi
                    //         qrCodeElement.src = qr;
                    //         qrCodeElement.style.display = "block";
                    //         statusElement.innerText = "📲 Silakan scan QR Code dengan WhatsApp";
                    //         statusElement.style.color = "blue";
                    //     });



                    //     socket.on(`authenticated-${sessionId}`, (msg) => {
                    //         console.log(`Sesi ${sessionId} berhasil di-autentikasi`);
                    //         statusElement.innerText = msg;
                    //     });

                    //     socket.on(`disconnected-${sessionId}`, (msg) => {
                    //         console.warn(`Sesi ${sessionId} terputus.`);
                    //         statusElement.innerText = "Sesi terputus. Silakan mulai ulang.";
                    //         qrCodeElement.style.display = "none";
                    //     });

                    //     socket.on(`error-${sessionId}`, (error) => {
                    //         console.error(`Error dari server: ${error}`);
                    //         statusElement.innerText = `Error: ${error}`;
                    //     });

                    //     // Debug semua event
                    //     socket.onAny((event, ...args) => {
                    //         console.log(`📡 [SOCKET EVENT]: ${event}`, args);
                    //     });
                    // }

                    // Fungsi untuk menghapus sesi
                    // async function removeSession() {
                    //     let sessionId = document.getElementById("session_id").value;
                    //     let statusElement = document.getElementById("status");
                    //     let qrElement = document.getElementById("qr_code");

                    //     if (!sessionId) {
                    //         alert("Masukkan ID sesi untuk menghapus.");
                    //         return;
                    //     }

                    //     statusElement.innerText = "Menghapus sesi...";
                    //     qrElement.style.display = "none";

                    //     try {
                    //         let response = await fetch(`${baseUrl}/remove-session/${sessionId}`, {
                    //             method: "DELETE",
                    //             headers: {
                    //                 "Content-Type": "application/json"
                    //             }
                    //         });

                    //         let data = await response.json();
                    //         if (!response.ok) {
                    //             throw new Error(data.error || "Gagal menghapus sesi");
                    //         }

                    //         console.log("Response from server:", data);
                    //         statusElement.innerText = data.message || "Sesi berhasil dihapus!";
                    //     } catch (error) {
                    //         console.error("Error menghapus sesi:", error);
                    //         statusElement.innerText = "Gagal menghapus sesi.";
                    //     }
                    // }
                </script>






            </div>

        </div>

    </section>
</x-layout>


{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='TambahAkun' tabindex='-1' aria-labelledby='LabelTambahAkun' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelTambahAkun'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                {{-- {{route('AkaunBaru')}} --}}
                <form id='TambahAkun-form' action='{{ route('AkaunBaru') }}' method='POST'>
                    @csrf
                    @method('POST')
                    <div class='card'>
                        <div class='card-header bg-info'>
                            <h3 class='card-title'><i class='fas fa-text-width'></i>Cara Penggunaan dan Menambahkan akun
                            </h3>
                        </div><!-- /.card-header -->
                        <div class='card-body'>
                            <dl>
                                <dt>Catatan :</dt>
                                <dd>Isikan data nama akun sebagai Id Pengguna</dd>
                                <dd>No HP sebagai bantuan untuk mengingat no mana yang digunakan</dd>
                                <dd>Tujuan di isi sebagai pembagian akun dalam absensi</dd>
                            </dl>
                            <dl>
                                <dt>Cara Penggunaan</dt>
                                <dd>Isikan data semua yang dibutuhkan</dd>
                                <dd>Simpan data untuk menyimpan ke database</dd>
                                <dd>Setelah semua selesai aktifkan server / jalankan server jika belum aktif</dd>
                                <dd>Jika status server aktif silahkan pilih sesi id yang akan diaktifkan</dd>
                                <dd>Klik <b class='text-primary'>Start Session</b> (jika belum pernah login tunggu
                                    sampai keluar QrCode dan silahkan scan)</dd>
                                <dd>Untuk lihat proses silahkan cek cmd yang terbuka statusnya jika sudah siap maka
                                    telah siap digunakan</dd>
                            </dl>
                        </div><!-- /.card-body -->
                    </div>
                    <div class='form-group'>
                        <label for='nama_akun'>Nama Akun</label>
                        <input type='text' class='form-control' id='nama_akun' name='nama_akun'
                            placeholder='Tuliskan nama akun akan digunakan sebagai Id' required>
                    </div>
                    <div class='form-group'>
                        <label for='tujuan'>Tujuan Pengiriman</label>
                        <select name='tujuan[]' id='id' multiple class='select2 form-control'
                            data-placeholder='Tujuan pengiriman untuk ke bagian mana' required>
                            @foreach ($Kelas as $kelasId)
                                <option value='{{ $kelasId->id }}'>{{ $kelasId->kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='form-group'>
                        <label for='no_hp'>No HP</label>
                        <input type='text' class='form-control' id='no_hp' name='no_hp'
                            placeholder='No HP, Contoh penulisan : 62853860005' required>
                    </div>
                    <div class='form-group'>
                        <label for='keterangan'>Keterangan</label>
                        <div class='form-group'>
                            <i class='fas fa-sticky-note pr-2'></i><label for='keterangan'>Keterangan</label>
                            <textarea name='keterangan' id='keterangan' rows='3' class='form-control'
                                placeholder='Masukkan Keterangan Singkat'></textarea>
                        </div>

                    </div>

                    {{-- blade-formatter-disable --}}
                           <div class='modal-footer'>
                               <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                               <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                           </div>
                           {{-- blade-formatter-enable --}}
                </form>
            </div>

        </div>
    </div>

</div>
{{-- Aktifkan server silent --}}
