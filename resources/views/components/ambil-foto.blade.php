<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS Bundle (termasuk Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">

    {{-- <link rel="stylesheet" href="{{app('request')->root()}}/"> --}}

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/jqvmap/jqvmap.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/summernote/summernote-bs4.min.css') }}">
    {{-- Eksport PDF dengan htmlToPDF --}}
    <link rel="stylesheet" href="{{ asset('backend/tools/pdfq/html2pdf.bundle.min.js') }}">
    <link rel="stylesheet" href="{{ asset('backend/js/sweetalert2@11.js') }}">

    <link rel="stylesheet" href="{{ asset('backend/css/btn.css') }}">
    <script src='{{ asset('backend/plugins/ckeditor/ckeditor.js') }}'></script>
    {{--
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE -->
    <script src="path/to/adminlte.min.js"></script>
 --}}








</head>
<style>
    #video {
        width: 100%;
        /* penuh lebar container */
        height: 100%;
        /* penuh tinggi container */
        object-fit: cover;
        /* isi penuh, crop kalau perlu */
        background: black;
        /* biar nggak putih kalau kamera belum nyala */
    }

    .video-container {
        /* width: 300px; */
        /* contoh: lebar preview */
        /* height: 400px; */
        /* contoh: lebar preview */
        width: 576px;
        /* contoh: lebar preview */
        height: 768px;
        /* tinggi sesuai 3:4 */
        overflow: hidden;
        /* sembunyikan area crop */
        border: 2px solid #ccc;
        border-radius: 8px;
    }

    .table-siswa {
        table-layout: fixed;
        width: 100%;
    }

    .table-siswa th {
        width: 35%;
    }

    .table-siswa td select {
        width: 100%;
        /* isi select ikut kolom, nggak ikut teks */
        max-width: 100%;
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
            <label for="nis" class="form-label fw-semibold">Preview Data Siswa</label>
            {{-- <select name="nis" id="nis" class="form-select" required>
                <option value="">--- Pilih Data Siswa ---</option>
                @php
                    $siswasFoto = \App\Models\User\Siswa\Detailsiswa::with(['KelasOne'])
                        ->whereNotNull('kelas_id')
                        ->orderBy('kelas_id')
                        ->orderBy('nama_siswa')
                        ->get();
                @endphp
                @foreach ($siswasFoto as $Siswa)
                    @php
                        $FotoIn = $Siswa->foto;
                        if ($FotoIn > 0) {
                            $InFoto = '✅';
                        } else {
                            $InFoto = '';
                        }
                    @endphp
                    <option value="{{ $Siswa->nis }}">{{ $InFoto }}{{ $Siswa->nis }} -
                        {{ $Siswa->nama_siswa }} - {{ $Siswa->KelasOne->kelas }}</option>
                @endforeach
            </select> --}}
            @php
                $siswasFoto = \App\Models\User\Siswa\Detailsiswa::with(['KelasOne'])
                    ->whereNotNull('kelas_id')
                    ->orderBy('kelas_id')
                    ->orderBy('nama_siswa')
                    ->get();
            @endphp
            <select name="nis" id="nis" class="form-select" required>
                <option value="">--- Pilih Data Siswa ---</option>
                @foreach ($siswasFoto as $Siswa)
                    @php $InFoto = $Siswa->foto > 0 ? '✅' : ''; @endphp
                    <option value="{{ $Siswa->nis }}">
                        {{ $InFoto }}{{ $Siswa->nis }} - {{ $Siswa->nama_siswa }} -
                        {{ $Siswa->KelasOne->kelas ?? '-' }}
                    </option>
                @endforeach
            </select>
            <script>
                $(document).ready(function() {
                    let currentNIS = null;

                    // Init Select2
                    $('#nis').select2().on('select2:select', function(e) {
                        currentNIS = $(this).val();
                        loadSiswa();
                    });

                    // Ganti ukuran foto
                    $('#ukuran').on('change', function() {
                        loadSiswa();
                    });

                    function loadSiswa() {
                        if (!currentNIS) return;

                        const ukuran = $('#ukuran').val();

                        // Foto langsung dari filesystem (pakai asset Laravel)
                        const fotoPath = "{{ asset('img/siswa') }}/" + currentNIS + "-" + ukuran + ".png";
                        const defaultPath = "{{ asset('img/default') }}/blanko-foto.png";
                        // Preview Foto
                        const img = $('#preview-foto');
                        img.off('error').on('error', function() {
                            $(this).attr('src', defaultPath);
                        });
                        img.attr('src', fotoPath);

                        // Preview Karpel
                        const fotoKarpel = "{{ asset('img/karpel') }}/" + currentNIS + ".png";
                        const imgKarpel = $('#preview-karpel');
                        const blankodepan = "{{ asset('img/default') }}/blanko-karpel.png";
                        imgKarpel.off('error').on('error', function() {
                            $(this).attr('src', blankodepan);
                        });
                        imgKarpel.attr('src', fotoKarpel);
                        // Preview Karpel Belakang
                        const fotoKarpelbel = "{{ asset('img/karpel') }}/belakang_" + currentNIS + ".png";
                        const imgKarpelbel = $('#preview-karpelbel');
                        const blankobelakang = "{{ asset('img/default') }}/blanko-karpel-belakang.png";
                        imgKarpelbel.off('error').on('error', function() {
                            $(this).attr('src', blankobelakang);
                        });
                        imgKarpelbel.attr('src', fotoKarpelbel);

                        // Ambil data siswa dari server
                        const formData = new FormData();
                        formData.append('nis', currentNIS);

                        fetch('{{ route('siswa.scan') }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: formData
                            })
                            .then(res => res.json())
                            .then(data => {
                                const infoDiv = $('#data-siswa');
                                if (data.success) {
                                    const siswa = data.data;
                                    infoDiv.html(`
            <table class="table table-siswa table-bordered table-sm">
                <tr>
                    <th>NIS</th>
                    <td>${siswa.nis}</td>
                </tr>
                <tr>
                    <th>NISN</th>
                    <td>${siswa.nisn}</td>
                </tr>
                <tr>
                    <th>Nama</th>
                    <td>${siswa.nama_siswa}</td>
                </tr>
                <tr>
                    <th>Kelas</th>
                    <td>${siswa.kelas}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>${siswa.alamat}</td>
                </tr>
                <tr>
                    <th>No HP Ayah</th>
                    <td>${siswa.nohpayah}</td>
                </tr>
                <tr>
                    <th>No HP Ibu</th>
                    <td>${siswa.nohpibu}</td>
                </tr>
                <tr>
                    <th>Tempat Lahir</th>
                    <td>${siswa.tempat_lahir ?? '-'}</td>
                </tr>
                <tr>
                    <th>Tanggal Lahir</th>
                    <td>${siswa.tanggal_lahir_pretty ?? '-'}</td>
                </tr>
                <tr>
                    <th>Wali Kelas</th>
                    <td>${siswa.wali_kelas ?? '-'}</td>
                </tr>
            </table>


<button type='button' class='btn float-right btn-default bg-primary btn-md' data-toggle='modal'
    data-target='#EditDataSiswa'><i class='fa fa-plus'></i> Ubah</button>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='EditDataSiswa' tabindex='-1' aria-labelledby='LabelEditDataSiswa' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelEditDataSiswa'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <form id='EditDataSiswa-form' action='{{ route('ubah.data.karpel') }}' method='POST'>
                    @csrf
                    @method('POST')

   <input type='hidden' class='form-control' id='id' name='id' placeholder='placeholder' value='${siswa.id}'>
<div class="row">
    <div class="col-xl-6"><div class='form-group'>
   <label for='nisn'>NISN</label>
   <input type='text' class='form-control' id='nisn' name='nisn' placeholder='placeholder' value='${siswa.nisn}' required>
</div></div>
    <div class="col-xl-6"><div class='form-group'>
   <label for='nis'>NIS</label>
   <input type='text' class='form-control' id='nis' name='nis' placeholder='placeholder' value='${siswa.nis}' required>
</div></div>
</div>


                    <div class='form-group'>
                        <label for='nama_siswa'>Nama Siswa</label>
                        <input type='text' class='form-control' id='nama_siswa' name='nama_siswa'
                            placeholder='placeholder' value='${siswa.nama_siswa}' required>
                    </div>
                    <div class='form-group'>
                        <label for='desa'>Desa</label>
                        <input type='text' class='form-control' id='desa' name='desa' placeholder='placeholder' required>
                    </div>
                    <div class='row'>
                        <div class='col-xl-6'>
                            <div class='form-group'>
                                <label for='rt'>RT</label>
                                <input type='text' class='form-control' id='rt' name='rt'
                                    placeholder='placeholder' value='${siswa.rt ?? '-'}' required>
                            </div>
                        </div>
                        <div class='col-xl-6'>
                            <div class='form-group'>
                                <label for='rw'>RW</label>
                                <input type='text' class='form-control' id='rw' name='rw'
                                    placeholder='placeholder' value='${siswa.rw ?? '-'}' required>
                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-xl-6'>
                            <div class='form-group'>
                                <label for='tempat_lahir'>Tempat Lahir</label>
                                <input type='text' class='form-control' id='tempat_lahir' name='tempat_lahir'
                                    placeholder='placeholder' value='${siswa.tempat_lahir ?? '-'}' required>
                            </div>
                        </div>
                        <div class='col-xl-6'>
                            <div class="form-group">
    <label for="tanggal_lahir">Tanggal Lahir</label>
    <input
        type="date"
        class="form-control"
        id="tanggal_lahir"
        name="tanggal_lahir"
        value="${siswa.tanggal_lahir ?? ''}"
        required
    >
</div>


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

        `);
                                } else {
                                    infoDiv.html(`<p class="text-danger">${data.message}</p>`);
                                }
                            })

                            .catch(err => console.error('Error fetch:', err));
                    }
                });
            </script>


        </div>
        <div class="col-md-4 d-flex align-items-end">
            <div class="d-flex gap-2">
                <button id="snap" class="btn btn-primary">Ambil Foto</button>
                <button id="upload" class="btn btn-success" style="display: none;">Upload Foto</button>
            </div>
        </div>
    </div>
    <div class="card mt-4">
        <div class="row">
            <div class='card-header bg-primary'>
                <h3 class='card-title'>Data Siswa</h3>
            </div>
            <div class="row">
                <div class="col-xl-5 p-4 d-flex justify-content-center">
                    <img id="preview-karpel" src="{{ asset('img/default/blanko-karpel.png') }}"
                        alt="Foto Karpel Depan Siswa" class="img-fluid shadow">
                </div>
                <div class="col-xl-7 p-4">
                    <div class="row">
                        <div class="col-md-3">
                            <img id="preview-foto" src="{{ asset('img/default/blanko-foto.png') }}" alt="Foto Siswa"
                                class="img-fluid rounded">
                        </div>
                        <div class="col-md-9">
                            <div id="data-siswa">
                                <p>Pilih siswa untuk melihat detail...</p>
                                <table class="table table-siswa table-bordered table-sm">
                                    <tr>
                                        <th>NIS</th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>NISN</th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>Nama</th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>Kelas</th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>No HP Ayah</th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>No HP Ibu</th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>Tempat Lahir</th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Lahir</th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>Wali Kelas</th>
                                        <td></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class='card-body'>

        <div class="row">
            <div class="col-xl-5 p-4 d-flex justify-content-center">
                <img class="m-2 img-fluid shadow" id="preview-karpelbel"
                    src="{{ asset('img/default/blanko-karpel-belakang.png') }}" alt="Foto Karpel Belakang Siswa">
            </div>
            <div class="col-xl-7 p-4">
                @php
                    $KelasFotos = \App\Models\Admin\Ekelas::where('tapel_id', $Tapels->id)->get();
                @endphp
                <div class='card-header bg-primary'>
                    <h3 class='card-title'>Data Foto</h3>
                </div>
                <table id='example1' width='100%' class='table table-bordered table-hover p-2'>
                    <thead>
                        <tr class='table-primary text-center align-middle'>
                            <th width='1%'>ID</th>
                            <th>Kelas</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($KelasFotos as $data)
                            <tr class='text-center'>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->kelas }}</td>
                                @php
                                    $JumlahFoto = $siswasFoto
                                        ->where('kelas_id', $data->id)
                                        ->whereNotNull('foto')
                                        ->count();
                                @endphp
                                <td>{{ $JumlahFoto }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class='table-primary text-center align-middle'>
                            <th>ID</th>
                            <th>Kelas</th>
                            <th>Jumlah</th>
                        </tr>
                    </tfoot>
                </table>
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

    let constraints;

    if (deviceId) {
        // kalau pilih kamera dari <select>, pakai deviceId saja
        constraints = {
            video: { deviceId: { exact: deviceId } }
        };
    } else {
        // default: coba kamera belakang
        constraints = {
            video: { facingMode: { ideal: "environment" } }
        };
    }

    navigator.mediaDevices.getUserMedia(constraints)
        .then(stream => {
            currentStream = stream;
            video.srcObject = stream;
            video.play();

            // debug: cek kamera aktif
            console.log("Kamera aktif:", stream.getVideoTracks()[0].label);
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
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message); // <-- langsung pakai respon dari controller
                loadExistingPhotos();
                // Refresh halaman supaya tampilan <select> update
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });

    // Fungsi Load Preview Foto
    function loadExistingPhotos() {
        const nis = nisInput.value;
        preview2x3.src = '/img/siswa/' + nis + '-2x3.png';
        preview3x4.src = '/img/siswa/' + nis + '-3x4.png';
    }

    // Auto load saat pertama kali
    loadExistingPhotos();
</script>
