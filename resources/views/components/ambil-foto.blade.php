<style>#video {
    width: 100%;           /* penuh lebar container */
    height: 100%;          /* penuh tinggi container */
    object-fit: cover;     /* isi penuh, crop kalau perlu */
    background: black;     /* biar nggak putih kalau kamera belum nyala */
}
.video-container {
    {{-- width: 300px;          /* contoh: lebar preview */
    height: 400px;          /* contoh: lebar preview */ --}}
    width: 576px;          /* contoh: lebar preview */
    height: 768px;         /* tinggi sesuai 3:4 */
    overflow: hidden;      /* sembunyikan area crop */
    border: 2px solid #ccc;
    border-radius: 8px;
}
</style>
<div class="p-4 bg-light rounded shadow">
    <div class="mb-3">
        <label for="cameraSelect" class="form-label fw-semibold">Pilih Kamera</label>
        <select id="cameraSelect" class="select2 form-select"></select>
    </div>

    <!-- Kamera dan Preview -->
    <div class="row align-items-start mb-4">
        <!-- Kamera -->
        <div class="col-md-5 text-center">
            <h5 class="mb-3 text-primary">Live Kamera</h5>
            {{-- <video id="video" autoplay class="rounded border border-primary shadow" style="width: 100%; height: 600px; object-fit: cover;"></video> --}}
            {{-- <video id="video" autoplay style="width: 100%; object-fit: cover;"></video> --}}
<div class="video-container">
    <video id="video" autoplay playsinline></video>
</div>





        </div>

        <!-- Preview -->
        <div class="col-md-7">
            <div class="row h-100 align-items-center">
                <div class="col-6 text-center">
                    <h6 class="mb-2">Preview Foto 2x3</h6>
                    <img id="preview2x3" src="" alt="Foto 2x3" class="img-thumbnail"
                        style="height: 600px; width: auto; object-fit: cover;">
                </div>
                <div class="col-6 text-center">
                    <h6 class="mb-2">Preview Foto 3x4</h6>
                    <img id="preview3x4" src="" alt="Foto 3x4" class="img-thumbnail"
                        style="height: 600px; width: auto; object-fit: cover;">
                </div>
            </div>
        </div>
    </div>

    <!-- Form Pilihan dan Tombol -->
    <div class="row g-3">
        <div class="col-md-4">
            <label for="ukuran" class="form-label fw-semibold">Ukuran Foto</label>
            <select id="ukuran" class="form-select" required>
                <option value="2x3">2x3 cm</option>
                <option value="3x4" selected>3x4 cm</option>
            </select>
        </div>

        <div class="col-md-4">
            <label for="nis" class="form-label fw-semibold">Data Siswa</label>
            <select name="nis" id="nis" class="form-select" required>
                <option value="">--- Pilih Data Siswa ---</option>
                @foreach ($Siswas as $Siswa)
                    <option value="{{ $Siswa->nis }}">{{ $Siswa->nis }} - {{ $Siswa->nama_siswa }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 d-flex align-items-end">
            <div class="d-flex gap-2">
                <button id="snap" class="btn btn-primary">Ambil Foto</button>
                <button id="upload" class="btn btn-success" style="display: none;">Upload Foto</button>
            </div>
        </div>
    </div>
</div>


<!-- Hidden Elements -->
<form id="uploadForm" style="display: none;">
    <input type="hidden" name="foto" id="fotoInput">
    <input type="hidden" name="ukuranFoto" id="ukuranFoto">
</form>

<canvas id="canvas" style="display: none;"></canvas>

<script>
const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const preview2x3 = document.getElementById('preview2x3');
const preview3x4 = document.getElementById('preview3x4');
const snapButton = document.getElementById('snap');
const uploadButton = document.getElementById('upload');
const ukuranSelect = document.getElementById('ukuran');
const fotoInput = document.getElementById('fotoInput');
const nisInput = document.getElementById('nis');
const ukuranFotoInput = document.getElementById('ukuranFoto');
const cameraSelect = document.getElementById('cameraSelect');
let currentStream = null;

// Fungsi untuk menyalakan kamera tertentu
function startCamera(deviceId = null) {
    if (currentStream) {
        currentStream.getTracks().forEach(track => track.stop());
    }

    const constraints = {
        video: {
            width: { ideal: 900 },
            height: { ideal: 1200 },
            aspectRatio: { ideal: 0.75 } // 3:4 potrait
        }
    };

    if (deviceId) {
        constraints.video.deviceId = { exact: deviceId };
    }

    navigator.mediaDevices.getUserMedia(constraints)
        .then(stream => {
            currentStream = stream;
            video.srcObject = stream;
            video.play();
        })
        .catch(err => {
            console.error("Gagal akses kamera:", err);
        });
}

// Ambil daftar kamera
navigator.mediaDevices.enumerateDevices()
    .then(devices => {
        const videoDevices = devices.filter(device => device.kind === 'videoinput');

        videoDevices.forEach((device, index) => {
            const option = document.createElement('option');
            option.value = device.deviceId;
            option.text = device.label || `Kamera ${index + 1}`;
            cameraSelect.appendChild(option);
        });

        if (videoDevices.length > 0) {
            startCamera(videoDevices[0].deviceId);
        }
    })
    .catch(err => {
        console.error("Gagal mendapatkan daftar kamera:", err);
    });

// Ganti kamera saat dipilih
cameraSelect.addEventListener('change', function() {
    startCamera(this.value);
});

// Fungsi Snap Foto
snapButton.addEventListener('click', () => {
    const context = canvas.getContext('2d');
    const ukuran = ukuranSelect.value;

    // Tentukan ukuran output
    let scaleFactor = 3; // 300 DPI
    if (ukuran === '2x3') {
        canvas.width = 600 * scaleFactor;
        canvas.height = 900 * scaleFactor;
    } else {
        canvas.width = 900 * scaleFactor;
        canvas.height = 1200 * scaleFactor;
    }

    // Hitung rasio untuk crop
    const targetAspect = canvas.width / canvas.height;
    const videoAspect = video.videoWidth / video.videoHeight;

    let sx, sy, sWidth, sHeight;
    if (videoAspect > targetAspect) {
        sHeight = video.videoHeight;
        sWidth = sHeight * targetAspect;
        sx = (video.videoWidth - sWidth) / 2;
        sy = 0;
    } else {
        sWidth = video.videoWidth;
        sHeight = sWidth / targetAspect;
        sx = 0;
        sy = (video.videoHeight - sHeight) / 2;
    }

    context.drawImage(video, sx, sy, sWidth, sHeight, 0, 0, canvas.width, canvas.height);

    const imageData = canvas.toDataURL('image/png');
    fotoInput.value = imageData;
    ukuranFotoInput.value = ukuran;

    if (ukuran === '2x3') {
        preview2x3.src = imageData;
    } else {
        preview3x4.src = imageData;
    }

    uploadButton.style.display = 'inline-block';
    document.getElementById('uploadForm').style.display = 'block';
});

// Fungsi Upload Foto
uploadButton.addEventListener('click', () => {
    const formData = new FormData();
    formData.append('foto', fotoInput.value);
    formData.append('nis', nisInput.value);
    formData.append('ukuran', ukuranFotoInput.value);

    fetch('{{ route('foto-digital-siswa.store') }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert('Foto berhasil diupload!');
        loadExistingPhotos();
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

// Fungsi Load Preview Foto
function loadExistingPhotos() {
    const nis = nisInput.value;
    preview2x3.src = '/img/siswa/' + nis + '-2x3.png?' + new Date().getTime();
    preview3x4.src = '/img/siswa/' + nis + '-3x4.png?' + new Date().getTime();
}

// Auto load saat pertama kali
loadExistingPhotos();
</script>
