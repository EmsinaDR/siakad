<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>

    <!-- ✅ Tambahkan Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f9f9f9;
            padding: 2rem;
        }

        h1 {
            text-align: center;
            margin-bottom: 2rem;
        }

        fieldset {
            margin-bottom: 2rem;
            padding: 1rem;
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
        }

        legend {
            font-weight: bold;
            font-size: 1.2rem;
            padding: 0 10px;
        }

        @media print {

            .btn,
            .form-control,
            select {
                border: none !important;
                box-shadow: none !important;
            }
        }
    </style>
</head>

<body>

    <h1>LEMBAR BUKU INDUK SMK</h1>

    <form class="container bg-white p-4 rounded shadow" method="post">
        @csrf
        @method('POST')

        <!-- Identitas Awal -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="nis" class="form-label">NIS:</label>
                <input type="text" id="nis" name="nis" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="nisn" class="form-label">NISN:</label>
                <input type="text" id="nisn" name="nisn" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label">Email:</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">No Peserta:</label>
                <input type="text" name="no_peserta" class="form-control">
            </div>
        </div>

        <!-- A. Keterangan Peserta Didik -->
        <fieldset>
            <legend>A. KETERANGAN PESERTA DIDIK</legend>
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap:</label>
                    <input type="text" name="nama_siswa" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Panggilan:</label>
                    <input type="text" name="nama_panggilan" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Jenis Kelamin:</label>
                    <input type="text" name="jenis_kelamin" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tempat Lahir:</label>
                    <input type="text" name="tempat_lahir" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal Lahir:</label>
                    <input type="date" name="tanggal_lahir" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">No HP:</label>
                    <input type="date" name="nohp_siswa" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="agama">Agama:</label>
                    <select name="agama" id="agama" class="form-control" required>
                        <option value="">--- Pilih Agama ---</option>
                        <option value="Islam">Islam</option>
                        <option value="Kristen">Kristen</option>
                        <option value="Katolik">Katolik</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Buddha">Buddha</option>
                        <option value="Khonghucu">Khonghucu</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>


                <div class="col-md-6">
                    <label class="form-label">Kewarganegaraan:</label>
                    <input type="text" name="kewarganegaraan" class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Anak ke:</label>
                    <input type="number" name="anak_ke" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Saudara Kandung:</label>
                    <input type="number" name="jml_saudara" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Saudara Tiri:</label>
                    <input type="number" name="saudara_tiri" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jumlah Saudara Angkat:</label>
                    <input type="number" name="saudara_angkat" class="form-control" min="0"
                        placeholder="0">
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="status_yatim_piatu">Status Yatim / Piatu / Yatim Piatu:</label>
                    <select name="status_yatim_piatu" id="status_yatim_piatu" class="form-control" required>
                        <option value="">--- Pilih Status ---</option>
                        <option value="yatim">Yatim</option>
                        <option value="piatu">Piatu</option>
                        <option value="yatim_piatu">Yatim Piatu</option>
                        <option value="lengkap">Orang Tua Lengkap</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="bahasa">Bahasa Sehari-hari:</label>
                    <select name="bahasa" id="bahasa" class="form-control" required>
                        <option value="">--- Pilih Bahasa ---</option>
                        <option value="Jawa">Jawa</option>
                        <option value="Sunda">Sunda</option>
                        <option value="Indonesia">Indonesia</option>
                        <option value="Madura">Madura</option>
                        <option value="Betawi">Betawi</option>
                        <option value="Banjar">Banjar</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

            </div>
        </fieldset>
        <!-- B. Keterangan Tempat Tinggal -->
        <fieldset class="mt-4">
            <legend>B. KETERANGAN TEMPAT TINGGAL</legend>
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label">Alamat Jalan:</label>
                    <input type="text" name="alamat_jalan" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">RT:</label>
                    <input type="text" name="rt" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">RW:</label>
                    <input type="text" name="rw" class="form-control">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Desa:</label>
                    <input type="text" name="desa" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kecamatan:</label>
                    <input type="text" name="kecamatan" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kabupaten:</label>
                    <input type="text" name="kabupaten" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Provinsi:</label>
                    <input type="text" name="provinsi" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kode Pos:</label>
                    <input type="text" name="kode_pos" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="tinggal_bersama">Tinggal Bersama:</label>
                    <select name="tinggal_bersama" id="tinggal_bersama" class="form-control" required>
                        <option value="">--- Pilih ---</option>
                        <option value="Ayah">Ayah</option>
                        <option value="Ibu">Ibu</option>
                        <option value="Ayah & Ibu">Ayah & Ibu</option>
                        <option value="Kakek / Nenek">Kakek / Nenek</option>
                        <option value="Paman / Bibi">Paman / Bibi</option>
                        <option value="Kakak">Kakak</option>
                        <option value="Wali Lainnya">Wali Lainnya</option>
                    </select>
                </div>


                <div class="col-md-6">
                    <label class="form-label">Jarak ke Sekolah (km):</label>
                    <input type="number" step="0.1" name="jarak_sekolah" class="form-control">
                </div>
            </div>
        </fieldset>
        <!-- C. Keterangan Kesehatan -->
        <fieldset class="mt-4">
            <legend>C. KETERANGAN KESEHATAN</legend>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" for="golongan_darah">Golongan Darah:</label>
                    <select name="golongan_darah" id="golongan_darah" class="form-control" required>
                        <option value="">--- Pilih Golongan Darah ---</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="AB">AB</option>
                        <option value="O">O</option>
                        <option value="Tidak Tahu">Tidak Tahu</option>
                    </select>
                </div>


                <div class="col-md-6">
                    <label class="form-label">Penyakit yang Pernah Diderita:</label>
                    <input type="text" name="penyakit" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Kelainan Jasmani:</label>
                    <input type="text" name="kelainan_jasmani" class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Tinggi Badan (cm):</label>
                    <input type="number" name="tinggi_badan" class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Berat Badan (kg):</label>
                    <input type="number" name="berat_badan" class="form-control">
                </div>
            </div>
        </fieldset>
        <!-- D. Keterangan Pendidikan -->
        <fieldset class="mt-4">
            <legend>D. KETERANGAN PENDIDIKAN</legend>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Sekolah Asal:</label>
                    <input type="text" name="namasek_asal" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Alamat Sekolah Asal:</label>
                    <input type="text" name="alamatsek_asal" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tanggal Ijazah:</label>
                    <input type="text" name="tanggal_ijazah_sd" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">No. Ijazah:</label>
                    <input type="text" name="nomor_ijazah_sd" class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Lama Belajar (tahun):</label>
                    <input type="number" name="lama_belajar" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Pindahan dari Sekolah:</label>
                    <input type="text" name="asal_pindahan" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Alasan Pindah:</label>
                    <input type="text" name="alasan_pindah" class="form-control">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Diterima di Kelas:</label>
                    <input type="text" name="kelas_penerimaan" class="form-control">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Kelompok:</label>
                    <input type="text" name="kelompok_penerimaan" class="form-control">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Jurusan:</label>
                    <input type="text" name="jurusan_penerimaan" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tanggal Diterima:</label>
                    <input type="date" name="tanggal_diterima" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal Diterima:</label>
                    <input type="date" name="tahun_masuk" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal Diterima:</label>
                    <input type="date" name="tahun_lulus" class="form-control">
                </div>
            </div>
        </fieldset>
        <!-- E. Keterangan Orang Tua -->
        <fieldset class="mt-4">
            <legend>E. KETERANGAN ORANG TUA</legend>

            <h5 class="fw-bold mt-3">Ayah Kandung</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama:</label>
                    <input type="text" name="nama_ayah" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Agama:</label>
                    <input type="text" name="agama_ayah" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kewarganegaraan:</label>
                    <input type="text" name="ayah_kewarganegaraan" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Pendidikan Terakhir:</label>
                    <input type="text" name="ayah_pendidikan" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Pekerjaan:</label>
                    <input type="text" name="ayah_pekerjaan" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Penghasilan per Bulan:</label>
                    <input type="text" name="ayah_penghasilan" class="form-control">
                </div>
                <div class="col-md-12">
                    <label class="form-label">Alamat Jalan:</label>
                    <input type="text" name="alamat_ayah" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">RT:</label>
                    <input type="text" name="ayah_rt" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">RW:</label>
                    <input type="text" name="ayah_rw" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Desa:</label>
                    <input type="text" name="ayah_desa" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kecamatan:</label>
                    <input type="text" name="ayah_kecamatan" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kabupaten:</label>
                    <input type="text" name="ayah_kabupaten" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Provinsi:</label>
                    <input type="text" name="ayah_provinsi" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kode Pos:</label>
                    <input type="text" name="ayah_kodepos" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">No. Telepon/HP:</label>
                    <input type="text" name="ayah_telepon" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Keadaan:</label>
                    <input type="text" name="ayah_keadaan" class="form-control"
                        placeholder="Masih hidup / Wafat">
                </div>
            </div>

            <h5 class="fw-bold mt-4">Ibu Kandung</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama:</label>
                    <input type="text" name="nama_ibu" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Agama:</label>
                    <input type="text" name="agama_ibu" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kewarganegaraan:</label>
                    <input type="text" name="ibu_kewarganegaraan" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Pendidikan Terakhir:</label>
                    <input type="text" name="ibu_pendidikan" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Pekerjaan:</label>
                    <input type="text" name="ibu_pekerjaan" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Penghasilan per Bulan:</label>
                    <input type="text" name="ibu_penghasilan" class="form-control">
                </div>
                <div class="col-md-12">
                    <label class="form-label">Alamat Jalan:</label>
                    <input type="text" name="alamat_ibu" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">RT:</label>
                    <input type="text" name="ibu_rt" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">RW:</label>
                    <input type="text" name="ibu_rw" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Desa:</label>
                    <input type="text" name="ibu_desa" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kecamatan:</label>
                    <input type="text" name="ibu_kecamatan" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kabupaten:</label>
                    <input type="text" name="ibu_kabupaten" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Provinsi:</label>
                    <input type="text" name="ibu_provinsi" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kode Pos:</label>
                    <input type="text" name="ibu_kodepos" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">No. Telepon/HP:</label>
                    <input type="text" name="ibu_telepon" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Keadaan:</label>
                    <input type="text" name="ibu_keadaan" class="form-control" placeholder="Masih hidup / Wafat">
                </div>
            </div>
        </fieldset>
        <!-- F. Keterangan Wali -->
        <fieldset class="mt-4">
            <legend>F. KETERANGAN WALI</legend>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama:</label>
                    <input type="text" name="nama_wali" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Agama:</label>
                    <input type="text" name="agama_wali" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kewarganegaraan:</label>
                    <input type="text" name="wali_kewarganegaraan" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Pendidikan Terakhir:</label>
                    <input type="text" name="wali_pendidikan" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Pekerjaan:</label>
                    <input type="text" name="wali_pekerjaan" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Penghasilan per Bulan:</label>
                    <input type="text" name="wali_penghasilan" class="form-control">
                </div>
                <div class="col-md-12">
                    <label class="form-label">Alamat Jalan:</label>
                    <input type="text" name="alamat_wali" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">RT:</label>
                    <input type="text" name="wali_rt" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">RW:</label>
                    <input type="text" name="wali_rw" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Desa:</label>
                    <input type="text" name="wali_desa" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kecamatan:</label>
                    <input type="text" name="wali_kecamatan" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kabupaten:</label>
                    <input type="text" name="wali_kabupaten" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Provinsi:</label>
                    <input type="text" name="wali_provinsi" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kode Pos:</label>
                    <input type="text" name="wali_kodepos" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">No. Telepon/HP:</label>
                    <input type="text" name="wali_telepon" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Keadaan:</label>
                    <input type="text" name="wali_keadaan" class="form-control"
                        placeholder="Masih hidup / Wafat">
                </div>
            </div>

        </fieldset>
        <!-- G. Perkembangan Peserta Didik -->
        <fieldset class="mt-4">
            <legend>G. PERKEMBANGAN PESERTA DIDIK</legend>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Menerima Beasiswa:</label>
                    <input type="text" name="beasiswa" class="form-control"
                        placeholder="Contoh: Ya / Tidak atau jenis beasiswa">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tahun Menerima Beasiswa:</label>
                    <input type="text" name="tahun_beasiswa" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tanggal Meninggalkan Sekolah:</label>
                    <input type="date" name="tanggal_keluar" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Alasan Meninggalkan Sekolah:</label>
                    <input type="text" name="alasan_keluar" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tanggal Tamat Sekolah:</label>
                    <input type="date" name="tanggal_lulus" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Nomor Ijazah:</label>
                    <input type="text" name="nomor_ijazah" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Nomor SKHUN:</label>
                    <input type="text" name="nomor_skhun" class="form-control">
                </div>
            </div>
        </fieldset>
        <!-- H. Setelah Selesai Pendidikan -->
        <fieldset class="mt-4">
            <legend>H. SETELAH SELESAI PENDIDIKAN</legend>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Melanjutkan ke:</label>
                    <input type="text" name="lanjut_ke" class="form-control"
                        placeholder="Contoh: SMA, SMK, Kuliah, Tidak">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Nama Sekolah/Instansi Tujuan:</label>
                    <input type="text" name="nama_tujuan" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tanggal Mulai Bekerja:</label>
                    <input type="date" name="tanggal_mulai_kerja" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Nama Perusahaan:</label>
                    <input type="text" name="nama_perusahaan" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Bidang Pekerjaan:</label>
                    <input type="text" name="bidang_pekerjaan" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Penghasilan:</label>
                    <input type="text" name="penghasilan" class="form-control"
                        placeholder="Contoh: Rp2.000.000 / bulan">
                </div>
            </div>
        </fieldset>


        <!-- Contoh Submit Button -->
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Simpan Data</button>
        </div>
    </form>

    <!-- ✅ Tambahkan Bootstrap JS (opsional kalau gak ada JS interaktif) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
