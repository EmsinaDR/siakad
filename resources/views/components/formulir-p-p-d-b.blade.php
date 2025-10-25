<x-inputallin>:Nama Siswa::nama_siswa:id_nama_siswa::Required</x-inputallin>
<div class='form-group'>
    @php
        $statusList = [
            'aktif' => 'Aktif',
            'pindah' => 'Pindah Sekolah',
            'lulus' => 'Lulus',
            'dropout' => 'Drop Out',
            'cuti' => 'Cuti',
            'meninggal' => 'Meninggal Dunia',
            'diskors' => 'Diskors',
            'tidak_diketahui' => 'Tidak Diketahui',
        ];
    @endphp
    <label for='status_siswa'>Status Siswa</label>
    <select name='status_siswa' class='select2 form-control' required>
        <option value=''>--- Pilih Status Siswa ---</option>
        @foreach ($statusList as $key => $value)
            <option value="{{ $key }}">{{ $value }}</option>
        @endforeach
    </select>
</div>
<div class="row mt-2">
    <div class="col-xl-4">
        <x-inputallin>:NIS::nis:id_nis:{{ date('Y') }}:Required</x-inputallin>
    </div>
    <div class="col-xl-4">
        <x-inputallin>:NISN::nisn:id_nisn::Required</x-inputallin>
    </div>
    <div class="col-xl-4">
        <x-inputallin>:NIK::nik:id_nik::Required</x-inputallin>
    </div>
</div>
<div class="row">
    <div class="col-xl-4">
        <x-inputallin>:Tahun Masuk::tahun_masuk:id_tahun_masuk:{{ date('Y') }}:Required</x-inputallin>
    </div>
    <div class="col-xl-4">
        <x-inputallin>:Tahun Masuk::tahun_masuk:id_tahun_masuk:{{ date('Y') + 3 }}:Required</x-inputallin>
    </div>
    <div class="col-xl-4">
        @php
            $lists_agama = App\Models\Elist::where('kategori', 'Agama')->get();
        @endphp
        <div class='form-group mt-2'>
            <label for='id_agama'>Agama</label>
            <select name='agama' id='id_agama' class='select2 form-control' required>
                <option value=''>--- Pilih Agama ---</option>
                @foreach ($lists_agama as $list)
                    <option value='{{ $list->id }}'>{{ $list->list }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">

    <div class="col-xl-4">
        @php
            $lists_status_anak = App\Models\Elist::where('kategori', 'Status Anak')->get();

        @endphp
        <div class='form-group mt-2'>
            <label for='id_status_anak'>Status Anak</label>
            <select name='status_anak' id='id_status_anak' class='select2 form-control' required>
                <option value=''>--- Pilih Status Anak ---</option>
                @foreach ($lists_status_anak as $list)
                    <option value='{{ $list->id }}'>{{ $list->list }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xl-4">
        <x-inputallin>:Jumlah Saudara::jml_saudara:id_jml_saudara::Required</x-inputallin>
    </div>
    <div class="col-xl-4">
        <x-inputallin>:Anak Ke::anak_ke:id_anak_ke::Required</x-inputallin>
    </div>
</div>
<div class="row">
    <div class="col-xl-4">
        @php
            $jenis_kelamin = App\Models\Elist::where('kategori', 'Jenis Kelamin')->get();
        @endphp
        <div class='form-group mt-2'>
            <label for='id'>Jenis Kelamin</label>
            <select name='jenis_kelamin' id='id' class='select2 form-control' required>
                <option value=''>--- Pilih Jenis Kelamin ---</option>
                @foreach ($jenis_kelamin as $list)
                    <option value='{{ $list->id }}'>{{ $list->list }}</option>
                @endforeach

            </select>
        </div>
    </div>
    <div class="col-xl-4">
        <x-inputallin>type:Tempat Lahir::tempat_lahir:id_tempat_lahir::Required</x-inputallin>
    </div>
    <div class="col-xl-4">
        <x-inputallin>date:Tanggal Lahir::tanggal_lahir:tanggal_lahir::Required</x-inputallin>
    </div>
</div>
<div class="row mt-2">
    <div class="col-xl-4">
        {{-- <x-inputallin>:Hobi::hobi:id_hobi:{{ $datay->hobi }}:Required</x-inputallin> --}}
        @php
            $list_hobi = App\Models\Elist::where('kategori', 'Hobi')->get();
        @endphp
        <div class='form-group'>
            <label for='id_hobi'>Hobi</label>
            <select name='hobi' id='id_hobi' class='select2 form-control' required>
                <option value=''>--- Pilih Hobi ---</option>
                @foreach ($list_hobi as $list)
                    <option value='{{ $list->id }}'>{{ $list->list }}</option>
                @endforeach
            </select>
        </div>

    </div>
    <div class="col-xl-4">
        @php
            $listed_cita_cita = App\Models\Elist::where('kategori', 'Cita Cita')->get();
        @endphp
        <div class='form-group'>
            <label for='id_lists'>Cita Cita</label>
            <select name='cita_cita' id='id_lists' class='select2 form-control' required>
                <option value=''>--- Pilih Cita - Cita ---</option>
                @foreach ($listed_cita_cita as $list)
                    <option value='{{ $list->id }}'>{{ $list->list }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xl-4">
        <x-inputallin>:No HP Siswa::nohp_siswa:id_nohp_siswa::Required</x-inputallin>
    </div>
</div>
<div class='card-header bg-primary mt-2'>
    <h3 class='card-title'>Data Tempat Tinggal</h3>
</div>

<div class="row mt-2">
    <div class="col-xl-4">
        <x-inputallin>type:RT:RT:rt:id_rt::Required</x-inputallin>
    </div>
    <div class="col-xl-4">
        <x-inputallin>type:RW:RW:rw:id_rw::Required</x-inputallin>
    </div>
    <div class="col-xl-4">
        <x-inputallin>type:Desa:Desa tempat tinggal:desa:id_desa::Required</x-inputallin>

    </div>
</div>
<div class="row mt-2">
    <div class="col-xl-4">
        <x-inputallin>type:Kecamatan:Kecamatan tempat
            tinggal:kecamatan:id_kecamatan::Required</x-inputallin>

    </div>
    <div class="col-xl-4">
        <x-inputallin>type:Kabupaten:Kabupaten tempat
            tinggal:kabupaten:id_kabupaten::Required</x-inputallin>

    </div>
    <div class="col-xl-4">
        @php
            $lists_provinsi = App\Models\Elist::where('kategori', 'Provinsi')->get();
        @endphp
        <div class='form-group'>
            <label for='id_provinsi'>Provinsi</label>
            <select name='provinsi' id='id_provinsi' class='select2 form-control' required>
                <option value=''>--- Pilih Provinsi ---</option>

                @foreach ($lists_provinsi as $list)
                    <option value='{{ $list->id }}'>{{ $list->list }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<x-inputallin>textarea:Alamat Siswa:Alamat lengkap siswa diengan dilengkapi jalan dan blok Contoh ( Jl. Makensi No 2 - Block Chagor ):alamat_siswa:id_alamat_siswa::row = 4Required</x-inputallin>


<div class='card-header bg-primary mt-4'>
    <h3 class='card-title'>Pengaturan Kelas</h3>
</div>
<div class="row mt-2">
    <div class="col-xl-4">
        @php
            $lists_jabatan_kelas = App\Models\Elist::where('kategori', 'Jabatan Kelas')->get();

        @endphp
        <div class='form-group'>
            <label for='id_jabatan_kelas'>Jabatan Kelas</label>
            <select name='jabatan_kelas' id='id_jabatan_kelas' class='select2 form-control' required>
                <option value=''>--- Pilih Jabatan Kelas ---</option>
                @foreach ($lists_jabatan_kelas as $list)
                    <option value='{{ $list->id }}'>{{ $list->list }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xl-4">
        @php
            $lists_piket_kelas = App\Models\Elist::where('kategori', 'Hari')->get();
        @endphp
        <div class='form-group'>
            <label for='id_piket_kelas'>Piket Kelas</label>
            <select name='piket_kelas' id='id_piket_kelas' class='select2 form-control' required>
                <option value=''>--- Pilih Piket Kelas ---</option>
                @foreach ($lists_piket_kelas as $list)
                    <option value='{{ $list->id }}'>{{ $list->list }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xl-4">
        @php
            $lists_petugas_upacara = App\Models\Elist::where('kategori', 'Petugas Upacara')->get();
        @endphp
        <div class='form-group'>
            <label for='id_petugas_upacara'>Petugas Upacara</label>
            <select name='petugas_upacara' id='id_petugas_upacara' class='select2 form-control' required>
                <option value=''>--- Pilih Petugas Upacara ---</option>
                @foreach ($lists_petugas_upacara as $list)
                    <option value='{{ $list->id }}'>{{ $list->list }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class='card-header bg-primary mt-4'>
    <h3 class='card-title'>Data Sekolah Asal</h3>
</div>
<div class="row mt-2">
    <div class="col-xl-6">
        <x-inputallin>type:Sekolah Asal::namasek_asal:id_namasek_asal::Required</x-inputallin>
    </div>
    <div class="col-xl-6">
        <x-inputallin>type:Alamat Sekolah Asal::alamatsek_asal:id_alamatsek_asal::Required</x-inputallin>
    </div>
</div>
<div class='card-header bg-primary mt-4'>
    <h3 class='card-title'>Data Orang Tua</h3>
</div>
<div class="row">
    <div class="col-xl-6 mt-2 p-2">
        <div class='card-header bg-primary mb-2'>
            <h3 class='card-title'>Data Ayah</h3>
        </div>
        <x-inputallin>type:Nama Ayah::nama_ayah:id_nama_ayah::Required</x-inputallin>
        @php
            $lists_pekerjaan_ayah = App\Models\Elist::where('kategori', 'Pekerjaan')->get();
        @endphp
        <div class='form-group mt-2 '>

            <label for='id_pekerjaan_ayah'>Pekerjaan Ayah</label>
            <select name='pekerjaan_ayah' id='id_pekerjaan_ayah' class='select2 form-control' required>
                <option value=''>--- Pilih Pekerjaan Ayah ---</option>
                @foreach ($lists_pekerjaan_ayah as $list)
                    <option value='{{ $list->id }}'>{{ $list->list }}</option>
                @endforeach
            </select>
        </div>
        @php
            $lists_penghasilan_ayah = App\Models\Elist::where('kategori', 'Penghasilan')->get();
        @endphp
        <div class='form-group mt-2 '>

            <label for='id_penghasilan_ayah'>Penghasilan</label>
            <select name='penghasilan_ayah' id='id_penghasilan_ayah' class='select2 form-control' required>
                <option value=''>--- Pilih Penghasilan ---</option>
                @foreach ($lists_penghasilan_ayah as $list)
                    <option value='{{ $list->id }}'>{{ $list->list }}</option>
                @endforeach
            </select>
        </div>
        <x-inputallin>type:No HP::nohp_ayah:id_nohp_ayah::Required</x-inputallin>
        <x-inputallin>textarea:Alamat::alamat_ayah:id_alamat_ayah::rows=3 Required</x-inputallin>


    </div>
    <div class="col-xl-6 mt-2 p-2">

        <div class='card-header bg-primary mb-2'>
            <h3 class='card-title'>Data Ibu</h3>
        </div>
        <x-inputallin>type:Nama Ibu::nama_ibu:id_nama_ibu::Required</x-inputallin>
        @php
            $lists_pekerjaan_ibu = App\Models\Elist::where('kategori', 'Pekerjaan')->get();
        @endphp
        <div class='form-group mt-2 '>

            <label for='id_pekerjaan_ibu'>Pekerjaan</label>
            <select name='pekerjaan_ibu' id='id_pekerjaan_ibu' class='select2 form-control' required>
                <option value=''>--- Pilih Pekerjaan ---</option>

                @foreach ($lists_pekerjaan_ibu as $list)
                    <option value='{{ $list->id }}'>{{ $list->list }}</option>
                @endforeach
            </select>
        </div>
        @php
            $lists_penghasilan = App\Models\Elist::where('kategori', 'Penghasilan')->get();

        @endphp
        <div class='form-group mt-2'>
            @php
                $lists_penghasilan_ibu = App\Models\Elist::where('kategori', 'Penghasilan')->get();
            @endphp
            <div class='form-group'>
                <label for='id_penghasilan_ibu'>Penghasilan</label>
                <select name='penghasilan_ibu' id='id_penghasilan_ibu' class='select2 form-control' required>
                    <option value=''>--- Pilih Penghasilan ---</option>

                    @foreach ($lists_penghasilan_ibu as $list)
                        <option value='{{ $list->id }}'>{{ $list->list }}</option>
                    @endforeach
                </select>

            </div>

        </div>
        <x-inputallin>type:No HP::nohp_ibu:id_nohp_ibu::Required</x-inputallin>
        <x-inputallin>textarea:Alamat::alamat_ibu:id_alamat_ibu::rows=3 Required</x-inputallin>

    </div>
    <div class="col-xl-12">
        <div class='card-header bg-primary mb-2'>
            <h3 class='card-title'>Data Wali</h3>
        </div>
        <x-inputallin>type:Nama Wali::nama_wali:id_nama_wali::Required</x-inputallin>
        @php
            $lists_pekerjaan_wali = App\Models\Elist::where('kategori', 'Pekerjaan')->get();
        @endphp
        <div class='form-group mt-2 '>

            <label for='id_pekerjaan_wali'>Pekerjaan</label>
            <select name='pekerjaan_wali' id='id_pekerjaan_wali' class='select2 form-control' required>
                <option value=''>--- Pilih Pekerjaan ---</option>
                @foreach ($lists_pekerjaan_wali as $list)
                    <option value='{{ $list->id }}'>{{ $list->list }}</option>
                @endforeach
            </select>

        </div>
        @php
            $lists_penghasilan = App\Models\Elist::where('kategori', 'Penghasilan')->get();

        @endphp
        <div class='form-group mt-2'>
            @php
                $lists_penghasilan_wali = App\Models\Elist::where('kategori', 'Penghasilan')->get();
            @endphp
            <div class='form-group'>
                <label for='id_penghasilan_wali'>Penghasilan</label>
                <select name='penghasilan_wali' id='id_penghasilan_wali' class='select2 form-control' required>
                    <option value=''>--- Pilih Penghasilan ---</option>
                    @foreach ($lists_penghasilan_wali as $list)
                        <option value='{{ $list->id }}'>{{ $list->list }}</option>
                    @endforeach
                </select>

            </div>

        </div>
        <x-inputallin>type:No HP::nohp_wali:id_nohp_wali::Required</x-inputallin>
        <x-inputallin>textarea:Alamat::alamat_wali:id_alamat_wali::rows=3 Required</x-inputallin>

    </div>
</div>
