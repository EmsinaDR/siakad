@php
use App\Models\User\Guru\Detailguru;
use App\Models\Elist;


$activecrud = collect([2,4, 6, 8])->search(Auth::user()->id);
$UserDetailguru = Detailguru::find(Auth::user()->detailguru_id)->first();
$urlroot = app('request')->root();

$foto = $urlroot.'/img/guru/'.$UserDetailguru->foto !== '' ? $urlroot.'/dist/img/user2-160x160.jpg' : $urlroot.'/img/guru/'. $UserDetailguru->foto;
// dd($foto);





@endphp
<x-layout>

    <style>
        textarea {
            resize: none,
        }

    </style>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>
    <section class='content mx-2'>
        <div class='card'>
            {{-- Papan Informasi --}}
            <div class='card-body'>
                <div class='row float-right'>
                    <x-btn>submit/Tambah Data/fa fa-plus/btn btn-primary btn-xl bg-primary btn-app/TambahMapel()</x-btn>
                </div>
            </div>
            {{-- Papan Informasi --}}
            <!--Car Header-->
            <div class='card-header bg-primary mx-2 mb-3'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->
            {{-- user-guru.png --}}
            <div class='ml-2'>
                {{-- Profile {{ $user->posisi === 'Admindev' ? 'Oke' : 'No' }} --}}
                @if($user->posisi === 'Admindev')
                <div class="row">
                    <div class="col-xl-4">
                        <div class='card-header bg-primary mb-5'>

                            <h3 class='card-title'>Foto</h3>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <img width="612px" src="{{empty($UserDetailguru->foto) ? $urlroot.'/dist/img/user2-160x160.jpg' : $urlroot.'/img/guru/'. $UserDetailguru->foto}}" class='img-fluid' alt="">
                        </div>
                        <form id='#id' action='{{ route('UploadFotoGuru', $data->id) }}' method='POST' enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            @error('profile')
                            <p style="color: red;">{{ $message }}</p>
                            @enderror
                            <x-inputallin>file:::profile:id_profile::Required</x-inputallin>
                            <x-btn>submit/Save/fa fa-save/btn btn-default bg-primary float-right</x-btn>
                        </form>
                    </div>
                    <div class="col-xl-8">
                        <div class='card-header bg-primary'>
                            <h3 class='card-title'>Data Guru</h3>
                        </div>
                        <div class='card-body'>
                            <form id='updateEtugas' action='{{ route('guru.update', $data->id) }}' method='POST'>
                                @csrf
                                @method('PUT')
                                <x-inputallin>readonly:Nama:Nama Lengkap Guru:nama_guru:id_nama_guru:{{ $data->nama_guru }}:readonly</x-inputallin>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <x-inputallin>:NIP:NIP:nip:id_nip:{{ $data->nip }}:Required</x-inputallin>
                                    </div>
                                    <div class="col-xl-6">
                                        <x-inputallin>:NIK:NIK:nik:id_nik:{{ $data->nik }}:Required</x-inputallin>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 mt-2">
                                        @php
                                        $statuss = App\Models\Elist::where('kategori', 'Statu Kepegawaian')->get();
                                        @endphp
                                        <div class='form-group'>
                                            <label for='status'>Status</label>
                                            <select name='status' id='id_status' class='form-control' required>
                                                <option id='rid_status' value='{{ $data->status }}'>{{ $data->status }}</option>
                                                @foreach($statuss as $status)
                                                <option value='{{ $status->list }}'>{{ $status->list }}</option>
                                                @endforeach
                                            </select>
                                            {{-- <x-inputallin>:Pendidikan Terakhir:Pendidikan Terakhir:pendidikan:id_pendidikan:{{ $data->pendidikan }}:Required</x-inputallin> --}}
                                        </div>
                                    </div>
                                    {{--
                                    <div class="col-xl-6">
                                        <x-inputallin>:Status:Status Kepegawaian:status:id_status:{{ $data->status }}:Required</x-inputallin>
                                </div> --}}
                                @if($data->jenis_kelamin === '')
                                <div class="col-xl-6">
                                    <x-inputallin>dropdown-single:Jenis Kelamin:Jenis Kelamin:jenis_kelamin:id_jenis_kelamin:jenis_kelamin:Required</x-inputallin>
                                </div>
                                @else
                                <div class="col-xl-6 mt-2">
                                    {{-- <x-inputallin>:Jenis Kelamin:Jenis Kelamin:jenis_kelamin:id_jenis_kelamin:{{ $data->jenis_kelamin }}:Required</x-inputallin> --}}
                                    <div class='form-group'>
                                        <label for='jenis_kelamin'>Jenis Kelamin</label>
                                        <select name='jenis_kelamin' id='jenis_kelamin' class=' form-control' required>
                                            <option id='idjenis_kelamin' value='{{ $data->jenis_kelamin }}'>{{ $data->jenis_kelamin }}</option>
                                            <option value='L'>L</option>
                                            <option value='P'>P</option>
                                        </select>
                                    </div>
                                </div>

                                @endif
                        </div>
                        <div class="row">
                            <div class="col-xl-6 mt-2">
                                @php
                                $pendidikans = App\Models\Elist::where('kategori', 'Pendidikan')->get();
                                @endphp

                                <div class='form-group'>
                                    <label for='pendidikan'>Pendidikan</label>
                                    <select name='pendidikan' id='id_pendidikan' class='form-control' required>
                                        <option id='rid_pendidikan' value='{{ $data->pendidikan }}'>{{ $data->pendidikan }}</option>
                                        @foreach($pendidikans as $pendidikan)
                                        <option value='{{ $pendidikan->list }}'>{{ $pendidikan->list }}</option>
                                        @endforeach
                                    </select>
                                    {{-- <x-inputallin>:Pendidikan Terakhir:Pendidikan Terakhir:pendidikan:id_pendidikan:{{ $data->pendidikan }}:Required</x-inputallin> --}}
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <x-inputallin>:Tahun Lulus:Tahun Lulus:tahun_lulus:id_tahun_lulus:{{ $data->tahun_lulus }}:Required</x-inputallin>
                            </div>
                        </div>
                        <x-inputallin>:Lulusan:Sekolah atau Kampus terakhir menempuh pendidikan:lulusan:id_lulusan:{{ $data->lulusan }}:Required</x-inputallin>

                        <x-inputallin>textarea:Alamat:Alamat rumah saat ini:alamat:id_alamat:{{ $data->alamat }}:rows=4 Required</x-inputallin>

                        <div class="row">
                            <div class="col-xl-6 mt-2">
                                @php
                                $agamas = App\Models\Elist::where('kategori', 'Agama')->get();
                                @endphp
                                <div class='form-group'>
                                    <label for='agama'>Agama</label>
                                    <select name='agama' id='id_agama' class='form-control' required>
                                        <option id='rid_agama' value='{{ $data->agama }}'>{{ $data->agama }}</option>
                                        @foreach($agamas as $agama)
                                        <option value='{{ $agama->list }}'>{{ $agama->list }}</option>
                                        @endforeach
                                    </select>
                                    {{-- <x-inputallin>:Pendidikan Terakhir:Pendidikan Terakhir:pendidikan:id_pendidikan:{{ $data->pendidikan }}:Required</x-inputallin> --}}
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <x-inputallin>:No Handphone:No Handphone aktif:no_hp:id_no_hp:{{ $data->no_hp }}:Required</x-inputallin>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <x-inputallin>:Tempat Lahir:Tempat Kelahiran:tempat_lahir:id_tempat_lahir:{{ $data->tempat_lahir }}:Required</x-inputallin>
                            </div>
                            <div class="col-xl-6">
                                <x-inputallin>date:Tanggal Lahir:Tanggal kelahiran:tanggal_lahir:id_tanggal_lahir:{{ $data->tanggal_lahir }}:Required</x-inputallin>
                            </div>
                        </div>
                        <x-inputallin>date:TMT Mengajar:TMT Mengajar:tmt_mengajar:id_tmt_mengajar:{{ $data->tmt_mengajar }}:Required</x-inputallin>
                        <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'> Save</button>
                        </form>
                    </div>
                </div>
            </div>
            @elseif($user->posisi === 'Karyawan')
            @else
            @endif

        </div>

        </div>
    </section>
    <script>
        $('#jenis_kelamin').click(function() {
            $('#idjenis_kelamin').remove();
        })
        $('#id_pendidikan').change(function() {
            $('#rid_pendidikan').remove();
        })
        $('#id_agama').change(function() {
            $('#rid_agama').remove();
        })

    </script>
</x-layout>
