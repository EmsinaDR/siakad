
<section>
    <form id='update' action='{{ 'siswa.update' }}{{ $datay->id }}' method='POST'>
        @csrf
        @method('POST')
        <x-inputallin>:Nama Siswa::nama_siswa:id_nama_siswa:{{ $datay->nama_siswa }}:Required</x-inputallin>
        <div class="row mt-2">
            <div class="col-xl-4">
                <x-inputallin>:NIS::nis:id_nis:{{ $datay->nis }}:Required</x-inputallin>
            </div>
            <div class="col-xl-4">
                <x-inputallin>:NISN::nisn:id_nisn:{{ $datay->nisn }}:Required</x-inputallin>
            </div>
            <div class="col-xl-4">
                <x-inputallin>:NIK::nik:id_nik:{{ $datay->nik }}:Required</x-inputallin>
            </div>
        </div>
        <x-inputallin>:Alamat Siswa::alamat:id_nama_siswa:{{ $datay->nama_siswa }}:Required</x-inputallin>
        <div class="row">
            <div class="col-xl-4">
                <x-inputallin>:Tahun Masuk::tahun_masuk:id_tahun_masuk:{{ $datay->tahun_masuk }}:Required</x-inputallin>
            </div>
            <div class="col-xl-4">
                <x-inputallin>:Tahun Lulus::tahun_lulus:id_tahun_lulus:{{ $datay->tahun_lulus }}:Required</x-inputallin>
            </div>
            <div class="col-xl-4">
                <x-inputallin>:Agama::agama:id_agama:{{ $datay->agama }}:Required</x-inputallin>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-xl-4">
                <x-inputallin>:Status Anak::status_anak:id_status_anak:{{ $datay->status_anak }}:Required</x-inputallin>
            </div>
            <div class="col-xl-4">
                <x-inputallin>:Jumlah Saudara::jml_saudara:id_jml_saudara:{{ $datay->jml_saudara }}:Required</x-inputallin>
            </div>
            <div class="col-xl-4">
                <x-inputallin>:Anak Ke::anakke:id_anakke:{{ $datay->anakke }}:Required</x-inputallin>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-xl-4">
                <x-inputallin>:Jenis Kelamin::jengkel:id_jengkel:{{ $datay->jengkel }}:Required</x-inputallin>
            </div>
            <div class="col-xl-4">
                <x-inputallin>type:Tempat Lahir::tmpt_lahir:id_tmpt_lahir:{{ $datay->tmpt_lahir }}:Required</x-inputallin>
            </div>
            <div class="col-xl-4">
                <x-inputallin>date:Tanggal Lahir::tgl_lahir:tgl_lahir:{{ $datay->tgl_lahir }}:Required</x-inputallin>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-xl-4">
                <x-inputallin>:Hobi::hobi:id_hobi:{{ $datay->hobi }}:Required</x-inputallin>
            </div>
            <div class="col-xl-4">
                <x-inputallin>:Cita Cita::cita_cita:id_cita_cita:{{ $datay->cita_cita }}:Required</x-inputallin>
            </div>
            <div class="col-xl-4">
                <x-inputallin>:No HP Siswa::nohp_siswa:id_nohp_siswa:{{ $datay->nohp_siswa }}:Required</x-inputallin>
            </div>
        </div>

        <div class='card-header bg-primary mt-2'>
            <h3 class='card-title'>Pengaturan Kelas</h3>
        </div>
        <div class="row mt-2">
            <div class="col-xl-4">
                <x-inputallin>:Jabatan Kelas::jabatan_kelas:id_jabatan_kelas:{{ $datay->jabatan_kelas }}:Required</x-inputallin>
            </div>
            <div class="col-xl-4">
                <x-inputallin>type:Piket Kelas::piket:id_piket:{{ $datay->piket }}:Required</x-inputallin>
            </div>
            <div class="col-xl-4">
                <x-inputallin>type:Petugas Upacara::petugas_upacara:id_petugas_upacara:{{ $datay->petugas_upacara }}:Required</x-inputallin>
            </div>
        </div>
        <x-inputallin>type:Alamat Siswa::alamat_siswa:id_alamat_siswa:{{ $datay->alamat_siswa }}:Required</x-inputallin>
        <div class='card-header bg-primary mt-2'>
            <h3 class='card-title'>Data Sekolah Asal</h3>
        </div>
        <div class="row mt-2">
            <div class="col-xl-6">
                <x-inputallin>type:Sekolah Asal::namasek_asal:id_namasek_asal:{{ $datay->namasek_asal }}:Required</x-inputallin>
            </div>
            <div class="col-xl-6">
                <x-inputallin>type:Alamat Sekolah Asal::alamatsek_asal:id_alamatsek_asal:{{ $datay->alamatsek_asal }}:Required</x-inputallin>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-xl-6 p-2">
                <div class='card-header bg-primary mb-2'>
                    <h3 class='card-title'>Data Ayah</h3>
                </div>
                <x-inputallin>type:Nama Ayah::nama_ayah:id_nama_ayah:{{ $datay->nama_ayah }}:Required</x-inputallin>
                <x-inputallin>type:Pekerjaan::pekerjaan_ayah:id_pekerjaan_ayah:{{ $datay->pekerjaan_ayah }}:Required</x-inputallin>
                <x-inputallin>type:Penghasilam::penghasilan_ayah:id_penghasilan_ayah:{{ $datay->penghasilan_ayah }}:Required</x-inputallin>
                <x-inputallin>type:No HP::nohp_ayah:id_nohp_ayah:{{ $datay->nohp_ayah }}:Required</x-inputallin>
                <x-inputallin>type:Alamat::alamat_ayah:id_alamat_ayah:{{ $datay->alamat_ayah }}:Required</x-inputallin>
            </div>
            <div class="col-xl-6 p-2">
                <div class='card-header bg-primary mb-2'>
                    <h3 class='card-title'>Data Ibu</h3>
                </div>
                <x-inputallin>type:Nama Ibu::nama_ibu:id_nama_ibu:{{ $datay->nama_ibu }}:Required</x-inputallin>
                <x-inputallin>type:Pekerjaan::pekerjaan_ibu:id_pekerjaan_ibu:{{ $datay->pekerjaan_ibu }}:Required</x-inputallin>
                <x-inputallin>type:Penghasilam::penghasilan_ibu:id_penghasilan_ibu:{{ $datay->penghasilan_ibu }}:Required</x-inputallin>
                <x-inputallin>type:No HP::nohp_ibu:id_nohp_ibu:{{ $datay->nohp_ibu }}:Required</x-inputallin>
                <x-inputallin>type:Alamat::alamat_ibu:id_alamat_ibu:{{ $datay->alamat_ibu }}:Required</x-inputallin>
            </div>
        </div>
        <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'> Kirim</button>
    </form>
</section>
