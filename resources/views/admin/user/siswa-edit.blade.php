@php
    //content
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
    $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
    $urlroot = app('request')->root();
    use App\Models\User;
    use App\Models\Elist;
@endphp
<x-layout>
    <style>
        textarea {
            resize: none,
        }
    </style>
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
            {{-- Papan Informasi --}}


            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->


            {{-- blade-formatter-disable --}}
               <div class='row m-2'>
                   <div class='col-xl-2'>
                       <button type="button" class="btn btn-block btn-default bg-secondary btn-md" onclick="window.location.href='{{ route('siswa.index') }}'"><i class="fa fa-undo"></i> Kembali</button>

                   </div>
                   <div class='col-xl-10'></div>
               </div>
               <div class="row p-2">
                <div class="col-xl-12">

                </div>
               </div>
               {{-- blade-formatter-enable --}}


            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        {{-- blade-formatter-disable --}}
                        <form id='update' action='{{ route('siswa.update', $data->id) }}'
                                                            method='POST'>
                                                            @csrf
                                                            @method('PUT')
                                                            <x-inputallin>:Nama Siswa::nama_siswa:id_nama_siswa:{{ $data->nama_siswa }}:Required</x-inputallin>
                                                            <div class="row mt-2">
                                                                <div class='form-group col-xl-6'>
                                                                   <label for='kelas'>Kelas</label>
                                                                   <input type='text' class='form-control' id='kelas' name='kelas' placeholder='placeholder' value='{{$data->KelasOne->kelas}}' readonly>
                                                                </div>
                                                                <div class='form-group col-xl-6'>
                                                                   <label for='wali_kelas'>Wali Kelas</label>
                                                                   <input type='text' class='form-control' id='wali_kelas' name='wali_kelas' placeholder='placeholder' value='{{$data->KelasOne->Guru->nama_guru ?? ''}}, {{$data->KelasOne->Guru->gelar ?? ''}}' readonly>
                                                                </div>
                                                            </div>

                                                            <div class="row mt-2">
                                                                <div class="col-xl-4">
                                                                    <x-inputallin>readonly:NIS::nis:id_nis:{{ $data->nis }}:Readonly</x-inputallin>
                                                                </div>
                                                                <div class="col-xl-4">
                                                                    <x-inputallin>:NISN::nisn:id_nisn:{{ $data->nisn }}:Required</x-inputallin>
                                                                </div>
                                                                <div class="col-xl-4">
                                                                    <x-inputallin>:NIK::nik:id_nik:{{ $data->nik }}:Required</x-inputallin>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-xl-4">
                                                                    <x-inputallin>:Tahun Masuk::tahun_masuk:id_tahun_masuk:{{ $data->tahun_masuk }}:Required</x-inputallin>
                                                                </div>
                                                                <div class="col-xl-4">
                                                                    <x-inputallin>readonly:Tahun Lulus::tahun_lulus:id_tahun_lulus:{{ $data->tahun_lulus }}:readonly</x-inputallin>
                                                                </div>
                                                                <div class="col-xl-4">
                                                                    @php
                                                                        $lists_agama = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu', 'Lainnya'];
                                                                    @endphp
                                                                    <div class="form-group mt-2">
                                                                        <label for="id_agama">Agama</label>
                                                                        <select name="agama" id="id_agama" class="form-control" required>
                                                                            <option value="">--- Pilih Agama ---</option>
                                                                            @foreach ($lists_agama as $list)
                                                                                <option value="{{ $list }}" @if($data->agama === $list) selected @endif>{{ $list }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-xl-4">
                                                                    @php
                                                                        $lists_status_anak = ['Kandung', 'Angkat', 'Tiri', 'Lainnya'];
                                                                    @endphp
                                                                    <div class="form-group mt-2">
                                                                        <label for="id_status_anak">Status Anak</label>
                                                                        <select name="status_anak" id="id_status_anak" class="form-control" required>
                                                                            <option value="">--- Pilih Status Anak ---</option>
                                                                            @foreach ($lists_status_anak as $list)
                                                                                <option value="{{ $list }}" @if($data->status_anak === $list) selected @endif>{{ $list }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-4">
                                                                    <x-inputallin>:Jumlah Saudara::jml_saudara:id_jml_saudara:{{ $data->jml_saudara }}:Required</x-inputallin>
                                                                </div>
                                                                <div class="col-xl-4">
                                                                    <x-inputallin>:Anak Ke::anak_ke:id_anak_ke:{{ $data->anak_ke }}:Required</x-inputallin>
                                                                </div>
                                                            </div>

                                                                                                                        <div class="row">
                                                                <div class="col-xl-4">
                                                                    @php $jenis_kelamins = ['Laki-laki', 'Perempuan']; @endphp
                                                                    <div class='form-group mt-2'>
                                                                        <label for='id'>Jenis Kelamin</label>
                                                                        <select name='jenis_kelamin' id='id' class='form-control' required>
                                                                            <option value=''>--- Pilih Jenis Kelamin ---</option>
                                                                            @foreach ($jenis_kelamins as $list)
                                                                            <option value='{{ $list }}' @if($list === $data->jenis_kelamin) selected @endif>{{ $list }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-4"><x-inputallin>type:Tempat Lahir::tempat_lahir:id_tempat_lahir:{{ $data->tempat_lahir }}:Required</x-inputallin></div>
                                                                <div class="col-xl-4 mt-2">
                                                                    <label for="tanggal_lahir mt-2">Tanggal Lahir</label>
                                                                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ $data->tanggal_lahir ? \Carbon\Carbon::parse($data->tanggal_lahir)->format('Y-m-d') : '' }}" required>
                                                                </div>

                                                            </div>

                                                            <div class="row mt-2">
                                                                <div class="col-xl-4">
                                                                    @php $list_hobi = App\Models\Elist::where('kategori', 'Hobi')->get(); @endphp
                                                                    <div class='form-group'><label for='id_hobi'>Hobi</label>
                                                                        <select name='hobi' id='id_hobi' class='form-control' required>
                                                                            <option value=''>--- Pilih Hobi ---</option>
                                                                            @foreach ($list_hobi as $list)
                                                                                <option value='{{ $list->id }}' @if($data->hobi === $list->list) selected @endif>{{ $list->list }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-4">
                                                                    @php $listed_cita_cita = App\Models\Elist::where('kategori', 'Cita Cita')->get(); @endphp
                                                                    <div class='form-group'><label for='id_lists'>Cita Cita</label>
                                                                        <select name='cita_cita' id='id_lists' class='form-control' required>
                                                                            <option value=''>--- Pilih Cita - Cita ---</option>
                                                                            @foreach ($listed_cita_cita as $list)
                                                                                <option value='{{ $list->id }}' @if($data->cita_cita === $list->list) selected @endif> {{ $list->list }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-4">
                                                                   <label for='nohp_siswa'>No HP Siswa ( Whatsapp )</label>
                                                                   <input type='text' class='form-control' id='nohp_siswa' name='nohp_siswa' placeholder='No HP Siswa khususny whatsapp' value='{{ $data->nohp_siswa }}' required>
                                                                </div>
                                                            </div>

                                                            <div class='card-header bg-primary mt-2'><h3 class='card-title'>Data Tempat Tinggal</h3></div>

                                                            <div class="row mt-2">
                                                                <div class="col-xl-4"><x-inputallin>type:RT:RT:rt:id_rt:{{ $data->rt }}:Required</x-inputallin></div>
                                                                <div class="col-xl-4"><x-inputallin>type:RW:RW:rw:id_rw:{{ $data->rw }}:Required</x-inputallin></div>
                                                                <div class="col-xl-4"><x-inputallin>type:Desa:Desa tempat tinggal:desa:id_desa:{{ $data->desa }}:Required</x-inputallin></div>
                                                            </div>

                                                            <div class="row mt-2">
                                                                <div class="col-xl-4"><x-inputallin>type:Kecamatan:Kecamatan tempat tinggal:kecamatan:id_kecamatan:{{ $data->kecamatan }}:Required</x-inputallin></div>
                                                                <div class="col-xl-4"><x-inputallin>type:Kabupaten:Kabupaten tempat tinggal:kabupaten:id_kabupaten:{{ $data->kabupaten }}:Required</x-inputallin></div>
                                                                <div class="col-xl-4">
                                                                    @php $lists_provinsi = App\Models\Elist::where('kategori', 'Provinsi')->get(); @endphp
                                                                    <div class='form-group'><label for='id_provinsi'>Provinsi</label>
                                                                        <select name='provinsi' id='id_provinsi{{ $data->id }}' class='form-control' required>
                                                                            @if (empty($data->provinsi)) <option value=''>--- Pilih Provinsi ---</option>
                                                                            @else <option id='remove_id_provinsi{{ $data->id }}' value='{{ $data->id }}'>{{ $data->provinsi }}</option> @endif
                                                                            @foreach ($lists_provinsi as $list) <option value='{{ $list->id }}'>{{ $list->list }}</option> @endforeach
                                                                        </select>
                                                                        <script>$('#id_provinsi{{ $data->id }}').change(function() { $('#remove_id_provinsi{{ $data->id }}').remove(); })</script>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class='form-group'>
                                                                    <i class='fas fa-sticky-note pr-2'></i><label for='alamat_siswa'>Keterangan</label>
                                                                    <textarea name='alamat_siswa' id='alamat_siswa' rows='3' class='form-control' placeholder='Alamat lengkap siswa dengan dilengkapi jalan dan blok Contoh (Jl. Makensi No 2 - Block Chagor)'>{{ $data->alamat_siswa }}</textarea>
                                                                </div>
                                                            <div class='card-header bg-primary mt-4'><h3 class='card-title'>Pengaturan Kelas</h3></div>

                                                            <div class="row mt-2">
                                                                <div class="col-xl-4">
                                                                    @php $lists_jabatan_kelas = App\Models\Elist::where('kategori', 'Jabatan Kelas')->get(); @endphp
                                                                    <div class='form-group'><label for='id_jabatan_kelas'>Jabatan Kelas</label>
                                                                        <select name='jabatan_kelas' id='id_jabatan_kelas' class='form-control' required>
                                                                            <option value=''>--- Pilih Jabatan Kelas ---</option>
                                                                            @foreach ($lists_jabatan_kelas as $list)
                                                                                <option value='{{ $list->id }}' @if($list->list === $data->jabatan_kelas) selected @endif>{{ $list->list }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-4">
                                                                    @php $Haris = ['Senin', 'Selasa','Rabu','Kamis', 'Jum\'at', 'Sabtu']; @endphp
                                                                    <div class='form-group'><label for='id_piket_kelas'>Piket Kelas</label>
                                                                        <select name='piket_kelas' id='id_piket_kelas' class='form-control' required>
                                                                            <option value=''>--- Pilih Piket Kelas ---</option>
                                                                            @foreach ($Haris as $Hari)
                                                                                <option value='{{ $Hari}}' @if($Hari === $data->piket_kelas) selected @endif> {{ $Hari }}</option>
                                                                             @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-4">
                                                                    @php $lists_petugas_upacara = App\Models\Elist::where('kategori', 'Petugas Upacara')->get(); @endphp
                                                                    <div class='form-group'><label for='id_petugas_upacara'>Petugas Upacara</label>
                                                                        <select name='petugas_upacara' id='id_petugas_upacara' class='form-control' required>
                                                                            <option value=''>--- Pilih Petugas Upacara ---</option>
                                                                            @foreach ($lists_petugas_upacara as $list)
                                                                            <option value='{{ $list->id }}' @if($data->petugas_upacara === $list->lis) selected @endif> {{ $list->list }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class='card-header bg-primary mt-4'>
                                                                <h3 class='card-title'>Data Sekolah Asal</h3>
                                                            </div>
                                                            <div class="row mt-2">
                                                                <div class="col-xl-6"><x-inputallin>type:Sekolah Asal::namasek_asal:id_namasek_asal:{{ $data->namasek_asal }}:Required</x-inputallin></div>
                                                                <div class="col-xl-6"><x-inputallin>type:Alamat Sekolah Asal::alamatsek_asal:id_alamatsek_asal:{{ $data->alamatsek_asal }}:Required</x-inputallin></div>
                                                                <div class='form-group col-xl-6'>
                                                                   <label for='tanggal_ijazah_sd'>Tanggal Ijzah SD</label>
                                                                   <input type='date' class='form-control' id='tanggal_ijazah_sd' name='tanggal_ijazah_sd' value='{{ $data->tanggal_ijazah_sd }}' placeholder='placeholder' required>
                                                                </div>
                                                                <div class='form-group col-xl-6'>
                                                                   <label for='nomor_ijazah_sd'>No Ijazah SD</label>
                                                                   <input type='text' class='form-control' id='nomor_ijazah_sd' name='nomor_ijazah_sd' value='{{$data->nomor_ijazah_sd}}' placeholder='Isikan no ijazah SD' required>
                                                                </div>
                                                                <div class='form-group col-xl-6'>
                                                                   <label for='tanggal_penerimaan'>Tanggal Penerimaan</label>
                                                                   <input type='date' class='form-control' id='tanggal_penerimaan' name='tanggal_penerimaan' value='{{$data->tanggal_penerimaan}}' required>
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
                                                                    <div class='form-group mt-2'>
                                                                       <label for='nama_ayah'>Nama Ayah</label>
                                                                       <input type='text' class='form-control' id='nama_ayah' name='nama_ayah' placeholder='Nama Ayah' value='{{ $data->ayah_nama }}' required>
                                                                    </div>
                                                                    @php $lists_pekerjaan_ayah = App\Models\Elist::where('kategori', 'Pekerjaan')->get(); @endphp
                                                                    <div class='form-group mt-2'>
                                                                        <label for='id_pekerjaan_ayah'>Pekerjaan Ayah</label>
                                                                        <select name='ayah_pekerjaan' id='id_pekerjaan_ayah' class='form-control' required>
                                                                            <option value=''>--- Pilih Pekerjaan Ayah ---</option>
                                                                            @foreach ($lists_pekerjaan_ayah as $list) <option value='{{ $list->id }}'>{{ $list->list }}</option> @endforeach
                                                                        </select>
                                                                    </div>
                                                                    @php $lists_penghasilan_ayah = App\Models\Elist::where('kategori', 'Penghasilan')->get(); @endphp
                                                                    <div class='form-group mt-2'>
                                                                        <label for='id_penghasilan_ayah'>Penghasilan</label>
                                                                        <select name='ayah_penghasilan' id='id_penghasilan_ayah{{ $data->id }}' class='form-control' required>
                                                                            @if (empty($data->penghasilan_ayah)) <option value=''>--- Pilih Penghasilan ---</option>
                                                                            @else <option id='remove_id_penghasilan_ayah{{ $data->id }}' value='{{ $data->id }}'>{{ $data->penghasilan_ayah }}</option> @endif
                                                                            @foreach ($lists_penghasilan_ayah as $list) <option value='{{ $list->id }}'>{{ $list->list }}</option> @endforeach
                                                                        </select>
                                                                        <script>$('#id_penghasilan_ayah{{ $data->id }}').change(function() { $('#remove_id_penghasilan_ayah{{ $data->id }}').remove(); })</script>
                                                                    </div>
                                                                    <x-inputallin>type:No HP:Isikan no HP Contoh 6285329860005:ayah_nohp:id_nohp_ayah:{{ $data->ayah_nohp }}:Required</x-inputallin>
                                                                    <x-inputallin>textarea:Alamat::alamat_ayah:id_alamat_ayah:{{ $data->ayah_alamat }}:rows=3 Required</x-inputallin>
                                                                </div>
                                                                <div class="col-xl-6 mt-2 p-2">
                                                                    <div class='card-header bg-primary mb-2'>
                                                                        <h3 class='card-title'>Data Ibu</h3>
                                                                    </div>
                                                                    <div class='form-group mt-2'>
                                                                        <label for='nama_ibu'>Nama Ibu</label>
                                                                        <input type='text' class='form-control' id='nama_ibu' name='nama_ibu' placeholder='Nama Ibu' value='{{ $data->ibu_nama }}' required>
                                                                    </div>

                                                                    @php $lists_pekerjaan_ibu = App\Models\Elist::where('kategori', 'Pekerjaan')->get(); @endphp
                                                                    <div class='form-group mt-2'>
                                                                        <label for='id_pekerjaan_ibu'>Pekerjaan Ibu</label>
                                                                        <select name='ibu_pekerjaan' id='id_pekerjaan_ibu' class='form-control' required>
                                                                            <option value=''>--- Pilih Pekerjaan Ibu ---</option>
                                                                            @foreach ($lists_pekerjaan_ibu as $list)
                                                                                <option value='{{ $list->id }}'>{{ $list->list }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    @php $lists_penghasilan_ibu = App\Models\Elist::where('kategori', 'Penghasilan')->get(); @endphp
                                                                    <div class='form-group mt-2'>
                                                                        <label for='id_penghasilan_ibu'>Penghasilan</label>
                                                                        <select name='ibu_penghasilan' id='id_penghasilan_ibu{{ $data->id }}' class='form-control' required>
                                                                            @if (empty($data->penghasilan_ibu))
                                                                                <option value=''>--- Pilih Penghasilan ---</option>
                                                                            @else
                                                                                <option id='remove_id_penghasilan_ibu{{ $data->id }}' value='{{ $data->id }}'>{{ $data->penghasilan_ibu }}</option>
                                                                            @endif
                                                                            @foreach ($lists_penghasilan_ibu as $list)
                                                                                <option value='{{ $list->id }}'>{{ $list->list }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <script>
                                                                            $('#id_penghasilan_ibu{{ $data->id }}').change(function() {
                                                                                $('#remove_id_penghasilan_ibu{{ $data->id }}').remove();
                                                                            });
                                                                        </script>
                                                                    </div>

                                                                    <x-inputallin>type:No HP:Isikan no HP Contoh 6285329860005:ibu_nohp:id_nohp_ibu:{{ $data->ibu_nohp }}:Required</x-inputallin>
                                                                    <x-inputallin>textarea:Alamat::alamat_ibu:id_alamat_ibu:{{ $data->ibu_alamat }}:rows=3 Required</x-inputallin>

                                                                </div>
                                                            </div>
                                                            <script>$('#id_pekerjaan_ibu{{ $data->id }}').change(function() { $('#remove_id_pekerjaan_ibu{{ $data->id }}').remove(); });</script>

                                                            <div class="col-xl-12">
                                                                <div class='card-header bg-primary mb-2'>
                                                                    <h3 class='card-title'>Data Wali</h3>
                                                                </div>
                                                                <div class='form-group mt-2'>
                                                                    <label for='nama_wali'>Nama Wali</label>
                                                                    <input type='text' class='form-control' id='nama_wali' name='nama_wali' placeholder='Nama Wali' value='{{ $data->wali_nama }}' required>
                                                                </div>

                                                                @php $lists_pekerjaan_wali = App\Models\Elist::where('kategori', 'Pekerjaan')->get(); @endphp
                                                                <div class='form-group mt-2'>
                                                                    <label for='id_pekerjaan_wali'>Pekerjaan Wali</label>
                                                                    <select name='wali_pekerjaan' id='id_pekerjaan_wali' class='form-control' required>
                                                                        <option value=''>--- Pilih Pekerjaan Wali ---</option>
                                                                        @foreach ($lists_pekerjaan_wali as $list)
                                                                            <option value='{{ $list->id }}'>{{ $list->list }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                @php $lists_penghasilan_wali = App\Models\Elist::where('kategori', 'Penghasilan')->get(); @endphp
                                                                <div class='form-group mt-2'>
                                                                    <label for='id_penghasilan_wali'>Penghasilan</label>
                                                                    <select name='wali_penghasilan' id='id_penghasilan_wali{{ $data->id }}' class='form-control' required>
                                                                        @if (empty($data->penghasilan_wali))
                                                                            <option value=''>--- Pilih Penghasilan ---</option>
                                                                        @else
                                                                            <option id='remove_id_penghasilan_wali{{ $data->id }}' value='{{ $data->id }}'>{{ $data->penghasilan_wali }}</option>
                                                                        @endif
                                                                        @foreach ($lists_penghasilan_wali as $list)
                                                                            <option value='{{ $list->id }}'>{{ $list->list }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <script>
                                                                        $('#id_penghasilan_wali{{ $data->id }}').change(function() {
                                                                            $('#remove_id_penghasilan_wali{{ $data->id }}').remove();
                                                                        });
                                                                    </script>
                                                                </div>

                                                                <x-inputallin>type:No HP:Isikan no HP Contoh 6285329860005:wali_nohp:id_nohp_wali:{{ $data->wali_nohp }}:Required</x-inputallin>
                                                                <x-inputallin>textarea:Alamat::alamat_wali:id_alamat_wali:{{ $data->wali_alamat }}:rows=3 Required</x-inputallin>

                                                                <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4 mb-4'>Kirim</button>
                                                            </div>
                                                        </form>
                        {{-- blade-formatter-enable --}}
                    </div>
                </div>
            </div>


        </div>

    </section>
</x-layout>
{{-- <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#DokumenPelengkap'><i class='fa fa-plus'></i> Tambah Data</button> --}}

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='DokumenPelengkap' tabindex='-1' aria-labelledby='LabelDokumenPelengkap' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
           <div class='modal-content'>
               <div class='modal-header bg-primary'>
                   <h5 class='modal-title' id='LabelDokumenPelengkap'>
                       Tambah Data Baru
                   </h5>
                   <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                       <span aria-hidden='true'>&times;</span>
                   </button>
               </div>
               <div class='modal-body'>

                   {{-- <form id='DokumenPelengkap-form' action='{{route('url.store')}}' method='POST'> --}}
                   <form id='DokumenPelengkap-form' action='#' method='POST'>
                          @csrf
                          @method('POST')
                         content_form

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