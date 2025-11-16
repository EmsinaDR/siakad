<!DOCTYPE html>
<html lang="id">
{{-- blade-formatter-disable --}}
@php
    // use App\Models\Identitas;
    use Illuminate\Support\Str;

    $identitas = App\Models\Admin\Identitas::get()[0];
    // $regiser = Hash::make($identitas->regis);
    $regiser = request($identitas->regis);
    if (Hash::check($regiser, $identitas->regis)) {
        echo 'no registrasi<br />';
        echo $identitas->regis . '<br />';

        echo $identitas->namasek . '<br />';

        echo $regiser . '<br />';
        echo $regiser . '<br />';
    } else {
        // session_start();
        $_SESSION['titleweb'] = $identitas->namasek;
        $_SESSION['judul'] = $title;
        // $_SESSION['user'] = 'Dany Rospeta, S.Pd';
        // $_SESSION['rool'] = 'Administrator';
        $member = 'pro';
    }
    $StatusYatims = ['Lengkap', 'Yatim', 'Piatu', 'Yatim Piatu'];
    $Pekerjaan = ['Petani','Nelayan','Guru','Dokter','Polisi','Tentara','Pengusaha','Karyawan Swasta','Pegawai Negeri Sipil (PNS)','Pedagang','Supir','Montir','Tukang Kayu','Tukang Bangunan','Arsitek','Pengacara','Insinyur','Pilot','Pelaut','Penjahit','Pemadam Kebakaran','Satpam','Jurnalis','Teknisi','Ahli IT','Desainer Grafis','Fotografer','Animator','Peternak','Sopir Truk'];
    $agamas =['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu', 'Lainnya'];
    $statusanaks = ['Kandung', 'Angkat', 'Tiri', 'Lainnya'];
    $Penghasilans = ['< Rp. 1.000.000', 'Rp. 1.000.000 - Rp. 5.000.000', '> Rp. 5.000.000']

@endphp
{{-- blade-formatter-enable --}}

<head>
    <meta charset="UTF-8">
    <title>Formulir PPDB - {{ $Identitas->namasek }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<x-property-header></x-property-header>

<body class="bg-light py-4">

    <div class="container border-1">
        <div class='card-header bg-success'>
            <h3 class="text-left text-white">📋 Formulir Pendaftaran Siswa</h3>
        </div>
        <div class="card m-2">
            <div class='card-body'>
                <form action="{{ route('peserta-ppdb.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class='card-header bg-success'>
                        <h4 class='card-title text-white'>Data Pendaftaran</h4>
                    </div>
                    <div class="row">
                        <div class="my-2 col-md-3">
                            <label class='mb-2'>Jalur Pendaftaran</label>
                            <select name="jalur" class="form-control" data-placeholder='Contoh : xxxxxxxxxxx'>
                                <option value="Afirmasi">Afirmasi</option>
                                <option value="Reguler">Reguler</option>
                                <option value="Prestasi">Prestasi</option>
                            </select>
                        </div>
                        {{-- <div class="my-2 col-md-3">
                            <label class='mb-2'>Nomor Peserta</label>
                            <input type="text" name="nomor_peserta" class="form-control" placeholder='Contoh : xxxxxxxxxxx' value='{{date('Y')}}{{$jumlahPeserta}}'>
                        </div> --}}
                        {{-- <div class="my-2 col-md-3">
                            <label class='mb-2'>Rekomendasi</label>
                            <input type="text" name="rekomendasi" class="form-control" placeholder='Contoh :  -'>
                        </div> --}}
                    </div>

                    <!-- 🔹 Data Pribadi -->
                    <div class='card-header bg-success'>
                        <h4 class='card-title text-white'>Data Calon Siswa</h4>
                    </div>
                    {{-- <h4>Data Calon Siswa</h4> --}}
                    {{-- blade-formatter-disable --}}
                    <div class="row">
                        <div class="my-2 col-md-6">
                            <label class='mb-2'>Nama Calon</label>
                            <input type="text" name="nama_calon" class="form-control" placeholder='Contoh :  Dany Rosepta'>
                        </div>
                        <div class="my-2 col-md-6">
                            <label class='mb-2'>Nama Panggilan</label>
                            <input type="text" name="nama_panggilan" class="form-control" placeholder='Contoh :  Dany'>
                        </div>
                        <div class="my-2 col-md-3">
                            <label class='mb-2'>NISN</label>
                            <input type="text" name="nisn" class="form-control" placeholder='Contoh :  29891989'>
                        </div>
                        <div class="my-2 col-md-3">
                            <label class='mb-2'>NIK</label>
                            <input type="text" name="nik" class="form-control placeholder='Contoh :  322948565698">
                        </div>
                        <div class="my-2 col-md-3">
                            <label class='mb-2'>No KK</label>
                            <input type="text" name="nokk" class="form-control" placeholder='Contoh :  32986536985222'>
                        </div>
                        <div class="my-2 col-md-3">
                            <label class='mb-2'>Foto</label>
                            <input type="file" name="foto" class="form-control" placeholder='Contoh : xxxxxxxxxxx'>
                        </div>
                        {{-- <div class="my-2 col-md-3">
                            <label class='mb-2'>Status Penerimaan</label>
                            <select name="status_penerimaan" class="form-control" placeholder='Contoh : xxxxxxxxxxx'>
                                <option value="">- Pilih -</option>
                                <option value="Diterima">Diterima</option>
                                <option value="Cadangan">Cadangan</option>
                            </select>
                        </div> --}}
                        <div class="my-2 col-md-3">
                            <label class='mb-2'>Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-control" placeholder='Contoh : xxxxxxxxxxx'>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="my-2 col-md-3">
                           <label for='agama'>Agama</label>
                           <select name='agama' id='agama' data-placeholder='Pilih Data Agama' class='select2 form-control' required>
                                   <option value=''>--- Pilih Agama ---</option>
                               @foreach($agamas as $newagamas)
                                   <option value='{{$newagamas}}'>{{$newagamas}}</option>
                               @endforeach
                           </select>
                        </div>
                        <div class="my-2 col-md-3">
                            <label class='mb-2'>Hobi</label>
                            <input type="text" name="hobi" class="form-control"
                                placeholder='Contoh : xxxxxxxxxxx'>
                        </div>
                        <div class="my-2 col-md-3">
                            <label class='mb-2'>Cita-cita</label>
                            <input type="text" name="cita_cita" class="form-control"
                                placeholder='Contoh : xxxxxxxxxxx'>
                        </div>
                        <div class="my-2 col-md-3">
                            <label class='mb-2'>No HP</label>
                            <input type="text" name="nohp_calon" class="form-control"
                                placeholder='Contoh : 6285329860005'>
                        </div>
                        <div class="my-2 col-md-3">
                            <label class='mb-2'>Anak ke-</label>
                            <input type="number" name="anak_ke" class="form-control" placeholder='Contoh : 2 '>
                        </div>
                        <div class="my-2 col-md-3">
                            <label class='mb-2'>Jumlah Saudara</label>
                            <input type="number" name="jml_saudara" class="form-control"
                                placeholder='Contoh : 2 (Jumlahs audara)'>
                        </div>
                        <div class="my-2 col-md-3">
                           <label for='status_anak'>Status Anak</label>
                           <select name='status_anak' id='status_anak' data-placeholder='Pilih Data Status Anak' class='select2 form-control' required>
                                   <option value=''>--- Pilih Status Anak ---</option>
                               @foreach($statusanaks as $newstatusanaks)
                                   <option value='{{$newstatusanaks}}'>{{$newstatusanaks}}</option>
                               @endforeach
                           </select>
                        </div>
                       <div class="my-2 col-md-3">
                           <label for='status_yatim_piatu'>Status Yatim / Piatu</label>
                           <select name='status_yatim_piatu' id='status_yatim_piatu' data-placeholder='Pilih Data Status Yatim / Piatu' class='select2 form-control' required>
                                   <option value=''>--- Pilih Status Yatim / Piatu ---</option>
                               @foreach($StatusYatims as $newStatusYatim)
                                   <option value='{{$newStatusYatim}}'>{{$newStatusYatim}}</option>
                               @endforeach
                           </select>
                        </div>
                        <div class="my-2 col-md-3">
                            <label class='mb-2'>Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" placeholder='Contoh : Brebes'>
                        </div>
                        <div class="my-2 col-md-3">
                            <label class='mb-2'>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control">
                        </div>
                    </div>
                    {{-- blade-formatter-enable --}}

                    <hr>

                    <!-- 🔹 Alamat Calon -->
                    <div class='card-header bg-success'>
                        <h4 class='card-title text-white'>Alamat Tempat Tinggal</h4>
                    </div>
                    <div class="row">

                        {{-- blade-formatter-disable --}}
                        <div class="my-2 col-md-4">
                            <label class='mb-2'>Jarak Rumah</label>
                            <input type="number" name="jarak_rumah" class="form-control" placeholder='Contoh : 5 (Dalam Km)'>
                        </div>
                        <div class="my-2 col-md-4">
                            <label class='mb-2'>Jalan</label>
                            <input type="text" name="jalan" class="form-control" placeholder='Contoh : Jl. Makensi BLock Chagor'>
                        </div>
                        <div class="my-2 col-md-2">
                            <label class='mb-2'>RT</label>
                            <input type="number" name="rt" class="form-control" placeholder='Contoh : 008'>
                        </div>
                        <div class="my-2 col-md-2">
                            <label class='mb-2'>RW</label>
                            <input type="number" name="rw" class="form-control" placeholder='Contoh : 001'>
                        </div>
                        <div class="my-2 col-md-4">
                            <label class='mb-2'>Desa</label>
                            <input type="text" name="desa" class="form-control" placeholder='Contoh : Banjarharjo'>
                        </div>
                        <div class="my-2 col-md-4">
                            <label class='mb-2'>Kecamatan</label>
                            <input type="text" name="kecamatan" class="form-control"
                                placeholder='Contoh : Banjarhajo'>
                        </div>
                        <div class="my-2 col-md-4">
                            <label class='mb-2'>Kabupaten</label>
                            <input type="text" name="kabupaten" class="form-control" placeholder='Contoh : Brebes'>
                        </div>
                        <div class="my-2 col-md-4">
                            <label class='mb-2'>Provinsi</label>
                            <input type="text" name="provinsi" class="form-control" placeholder='Contoh : Jawa Tengah'>
                        </div>

                        <div class="my-2 col-md-6">
                            <label class='mb-2'>Alamat Lengkap</label>
                            <textarea name="alamat_calon" class="form-control" placeholder='Contoh :  Jl. Makensi BLock Chagor Belakang PDAM Rt 08 Rw 01 Desa Banjarharjo '></textarea>
                        </div>
                        {{-- blade-formatter-enable --}}
                    </div>

                    <hr>

                    <!-- 🔹 Sekolah Asal -->
                    <div class='card-header bg-success'>
                        <h4 class='card-title text-white'>Data Asal Sekolah</h4>
                    </div>
                    {{-- blade-formatter-disable --}}
                    <div class="row">
                        <div class="my-2 col-md-6">
                            <label class='mb-2'>Nama Sekolah Asal</label>
                            <input type="text" name="namasek_asal" class="form-control" placeholder='Contoh : SDN 01 Harapan Bangsa'>
                        </div>
                        <div class="my-2 col-md-6">
                            <label class='mb-2'>Alamat Sekolah Asal</label>
                            <textarea name="alamatsek_asal" class="form-control" placeholder='Contoh : Jl. Merdeka No 17 Banjarharjo'></textarea>
                        </div>
                    </div>
                    {{-- blade-formatter-enable --}}

                    <hr>

                    <!-- 🔹 Data Orang Tua -->
                    <div class='card-header bg-success'>
                        <h4 class='card-title text-white'>Data Ayah</h4>
                    </div>
                    {{-- blade-formatter-disable --}}
                    <div class="row">
                        <div class="my-2 col-md-4">
                            <label class='mb-2'>Nama Ayah</label>
                            <input type="text" name="nama_ayah" class="form-control"
                                placeholder='Contoh : Suhana'>
                        </div>
                        <div class="my-2 col-md-4">
                           <label for='ayah_pekerjaan'>Pekerjaan</label>
                           <select name='ayah_pekerjaan' id='ayah_pekerjaan' data-placeholder='Pilih Data Pekerjaan' class='select2 form-control' required>
                                   <option value=''>--- Pilih Pekerjaan ---</option>
                               @foreach($Pekerjaan as $newPekerjaan)
                                   <option value='{{$newPekerjaan}}'>{{$newPekerjaan}}</option>
                               @endforeach
                           </select>
                        </div>
                        <div class="my-2 col-md-4">
                           <label for='ayah_penghasilan'>Penghasilan Ayah</label>
                           <select name='ayah_penghasilan' id='ayah_penghasilan' data-placeholder='Pilih Data Penghasilan Ayah' class='select2 form-control' required>
                                   <option value=''>--- Pilih Penghasilan Ayah ---</option>
                               @foreach($Penghasilans as $newPenghasilans)
                                   <option value='{{$newPenghasilans}}'>{{$newPenghasilans}}</option>
                               @endforeach
                           </select>
                        </div>
                        <div class="my-2 col-md-4">
                            <label class='mb-2'>No HP Ayah</label>
                            <input type="number" name="ayah_nohp" class="form-control" placeholder='Contoh : 6285329860005'>
                        </div>
                        <div class="my-2 col-md-8">
                            <label class='mb-2'>Alamat Ayah</label>
                            <textarea name="ayah_alamat" class="form-control" placeholder='Contoh : Jl. Makensi BLock Chagor Belakang PDAM Rt 08 Rw 01 Desa Banjarharjo '></textarea>
                        </div>
                    </div>
                    {{-- blade-formatter-enable --}}

                    <div class='card-header bg-success'>
                        <h4 class='card-title text-white'>Data Ibu</h4>
                    </div>
                    {{-- blade-formatter-disable --}}
                    <div class="row">
                        <div class="my-2 col-md-4">
                            <label class='mb-2'>Nama Ibu</label>
                            <input type="text" name="nama_ibu" class="form-control" placeholder='Contoh : Sarti Kumala'>
                        </div>
                        <div class="my-2 col-md-4">
                            <label class='mb-2'>Pekerjaan</label>
                            <input type="text" name="ibu_pekerjaan" class="form-control" placeholder='Contoh : Ibu Rumah Tangga'>
                        </div>
                        <div class="my-2 col-md-4">
                            <label class='mb-2'>Penghasilan</label>
                            <input type="text" name="ibu_penghasilan" class="form-control" placeholder='Contoh : xxxxxxxxxxx'>
                        </div>
                        <div class="my-2 col-md-4">
                            <label class='mb-2'>No HP Ibu</label>
                            <input type="text" name="ibu_nohp" class="form-control" placeholder='Contoh : 6285329860005'>
                        </div>
                        <div class="my-2 col-md-8">
                            <label class='mb-2'>Alamat Ibu</label>
                            <textarea name="ibu_alamat" class="form-control" placeholder='Contoh :  Jl. Makensi BLock Chagor Belakang PDAM Rt 08 Rw 01 Desa Banjarharjo '></textarea>
                        </div>
                    </div>
                    {{-- blade-formatter-enable --}}
                    <hr>

                    <!-- 🔹 Dokumen Upload -->
                    <div class='card-header bg-success'>
                        <h4 class='card-title text-white'>Data Dokumen Pendukung</h4>
                    </div>
                    {{-- blade-formatter-disable --}}
                    <div class="row">
                        @foreach (['kartu_keluarga', 'akta_kelahiran', 'ktp_ayah', 'ktp_ibu', 'ijazah', 'surat_keterangan_lulus', 'kartu_kia', 'kartu_nisn', 'kartu_bantuan_1', 'kartu_bantuan_2', 'kartu_bantuan_3', 'kartu_bantuan_4', 'kartu_bantuan_5'] as $dokumen)
                            <div class="my-2 col-md-4">
                                <label class='mb-2'>{{ ucwords(str_replace('_', ' ', $dokumen)) }}</label>
                                <input type="file" name="{{ $dokumen }}" class="form-control" placeholder='Contoh : xxxxxxxxxxx'>
                            </div>
                        @endforeach
                    </div>
                    {{-- blade-formatter-enable --}}

                    <hr>
                    <button type="submit" class="btn btn-primary float-right">Simpan</button>
                </form>
            </div>
        </div>

    </div>
    <x-footer></x-footer>
</body>

</html>
