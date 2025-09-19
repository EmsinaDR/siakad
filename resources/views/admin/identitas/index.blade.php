<style>
    #alamat {
        resize: none;
    }
</style>
@php

    use Carbon\Carbon;
@endphp
<x-layout>
    <x-slot:title>{{ $title ?? '' }}</x-slot:title>
    <x-slot:breadcrumb>{{ $breadcrumb ?? '' }}</x-slot:breadcrumb>
    <section class='content'>
        <div class='container-fluid'>
            {{-- {{dd($_SESSION)}} --}}
            <div class='card'>

                <div class='card-header bg-primary m-2'>
                    <h3 class='card-title'>Identitas Sekolah </h3>
                </div>
                <div class='card-body'>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class='form-group'>
                                <label for='paket'>Paket</label>
                                <input type='text' class='form-control bg-white' id='paket' name='paket'
                                    placeholder='placeholder' value='{{ $identitas_sekolah->paket }}' readonly>
                            </div>
                            <div class='form-group'>
                                <label for='trial_ends'>Batas Waktu</label>
                                <input type='text' class='form-control bg-white' id='trial_ends' name='trial_ends'
                                    placeholder='placeholder'
                                    value='{{ Carbon::create($identitas_sekolah->trial_ends_at)->translatedformat('l, d F Y') }}'
                                    readonly>
                            </div>
                        </div>
                        <div class="col-xl-6"></div>
                    </div>
                </div>
                <div class="row m-2">
                    <div class="col-xl-8">
                        <div class='card-header bg-primary'>
                            <h3 class='card-title'>Data Sekolah </h3>
                        </div>

                        <form id='#id' action='{{ route('identitas.update', 1) }}' method='POST'>

                            @csrf
                            @method('PUT')
                            <div class='card-body'>
                                {{-- blade-formatter-disable --}}
                                <div class='form-group'>
                                    <label for='namasek'>Nama Sekolah</label>
                                    <input type='text' class='form-control' id='namasek' name='namasek' value='{{ $identitas_sekolah->namasek ?? '' }}' required>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class='form-group'>
                                            <label for='nsm'>NSM</label>
                                            <input type='text' class='form-control' id='nsm' name='nsm' value='{{ $identitas_sekolah->nsm ?? '' }}' required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class='form-group'>
                                            <label for='npsn'>NPSN</label>
                                            <input type='text' class='form-control' id='npsn' name='npsn' value='{{ $identitas_sekolah->npsn ?? '' }}' required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class='form-group'>
                                            <label for='status'>Status</label>
                                            <input type='text' class='form-control' id='status' name='status' value='{{ $identitas_sekolah->status ?? '' }}' required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class='form-group'>
                                            <label for='akreditasi'>Akreditasi</label>
                                            <input type='text' class='form-control' id='akreditasi' name='akreditasi' value='{{ $identitas_sekolah->akreditasi ?? '' }}' required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class='form-group col-xl-6'>
                                            <label for='desa'>Desa</label>
                                            <input type='text' class='form-control' id='desa' name='desa' placeholder='Desa' value='{{ $identitas_sekolah->desa ?? '' }}' required>
                                        </div>
                                        <div class='form-group col-xl-6'>
                                            <label for='kecamatan'>Kecamatan</label>
                                            <input type='text' class='form-control' id='kecamatan' name='kecamatan' placeholder='Kecamatan' value='{{ $identitas_sekolah->kecamatan ?? '' }}' required>
                                        </div>
                                        <div class='form-group col-xl-6'>
                                            <label for='kabupaten'>kabupaten</label>
                                            <input type='text' class='form-control' id='kabupaten' name='kabupaten' placeholder='Kabupaten' value='{{ $identitas_sekolah->kabupaten ?? '' }}' required>
                                        </div>
                                        <div class='form-group col-xl-6'>
                                            <label for='provinsi'>Provinsi</label>
                                            <input type='text' class='form-control' id='provinsi' name='provinsi' placeholder='Provinsi' value='{{ $identitas_sekolah->provinsi ?? '' }}' required>
                                        </div>
                                </div>
                                <div class='form-group'>
                                    <label for='alamat'>Alamat</label>
                                    <textarea type='text' class='form-control' row="4" id='alamat' name='alamat' required>{{ $identitas_sekolah->alamat ?? '' }}</textarea>
                                </div>
                                <div class='form-group'>
                                    <label for='phone'>Telp</label>
                                    <input type='text' class='form-control' id='phone' name='phone' value='{{ $identitas_sekolah->phone ?? '' }}' required>
                                </div>
                                <div class='form-group'>
                                    <label for='email'>Email</label>
                                    <input type='text' class='form-control' id='email' name='email' value='{{ $identitas_sekolah->email ?? '' }}' required>
                                </div>
                                <div class="row">
                                    <div class='form-group col-xl-6'>
                                    <label for='namakepala'>Nama Kepala</label>
                                    <input type='text' class='form-control' id='namakepala' name='namakepala'  value='{{ $identitas_sekolah->namakepala ?? '' }}' required>
                                </div>
                                <div class='form-group col-xl-6'>
                                   <label for='nip_kepala'>NIP Kepala</label>
                                   <input type='text' class='form-control' id='nip_kepala' name='nip_kepala' placeholder='NIP Kepala' value='{{ $identitas_sekolah->nip_kepala ?? '-' }}' required>
                                </div>
                                </div>
                                <div class='card-header bg-primary'>
                                    <h3 class='card-title'>Sosial Media</h3>
                                </div>
                                {{-- <pre>{{ $identitas_sekolah }}</pre> --}}
                                <div class='form-group'>
                                    <label for='website'>Website</label>
                                    <input type='text' class='form-control' id='website' name='website' placeholder='Website' value='{{ $identitas_sekolah->website ?? '' }}' required>
                                </div>
                                <div class='form-group'>
                                    <label for='facebook'>Facebook</label>
                                    <input type='text' class='form-control' id='facebook' name='facebook'  placeholder='Facebook' value='{{ $identitas_sekolah->facebook_fanspage ?? '' }}'  required>
                                </div>
                                <div class='form-group'>
                                    <label for='twiter'>Twiter</label>
                                    <input type='text' class='form-control' id='twiter' name='twiter' placeholder='Twiter' value='{{ $identitas_sekolah->twiter ?? '' }}' required>
                                </div>
                                <div class='form-group'>
                                    <label for='instagram'>Instagram</label>
                                    <input type='text' class='form-control' id='instagram' name='instagram' placeholder='Instagram' value='{{ $identitas_sekolah->instagram ?? '' }}' required>
                                </div>
                                <div class='form-group'>
                                    <label for='internet'>Internet</label>
                                    <input type='text' class='form-control' id='internet' name='internet' placeholder='Internet Provider' value='{{ $identitas_sekolah->internet ?? '' }}' required>
                                </div>
                                <div class='form-group'>
                                    <label for='speed'>Internet Speed</label>
                                    <input type='text' class='form-control' id='speed' name='speed' placeholder='Speed' value='{{ $identitas_sekolah->speed ?? '' }}' required>
                                </div>
                                {{-- blade-formatter-enable --}}
                            </div>
                            <x-btn>submit/Save/fa fa-save/btn btn-default bg-primary float-right</x-btn>

                        </form>
                    </div>

                    <div class="col-xl-4">

                        <div class='card-header bg-primary'>
                            <h3 class='card-title'>Logo Sekolah</h3>
                        </div>
                        <div class=" d-flex justify-content-center">
                            {{-- <img class='p-4' src="{{app('request')->root()}}/img/{{ $identitas_sekolah->logo }}" alt="" width="400px"> --}}
                            <img class='p-4' src="{{ app('request')->root() }}/img/logo.png" alt=""
                                width="400px">
                        </div>
                        <form id='#id' action='{{ route('UploadLogo') }}' method='POST'
                            enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            @error('logo')
                                <p style="color: red;">{{ $message }}</p>
                            @enderror
                            <x-inputallin>file:Logo Sekolah::logo:id_logo:: Required</x-inputallin>
                            <div class="p-2">📸 <strong>Catatan:</strong><br>
                                Logo harus berformat gambar : (.jpg, .jpeg, .png, .bmp, .gif, .svg)<br>
                                maksimal : 255KB<br>
                                ukuran persis 300x300 pixel.</div>

                            <x-btn>submit/Save/fa fa-save/btn btn-default bg-primary float-right</x-btn>



                        </form>

                    </div>

                </div>
            </div>



        </div>


    </section>

</x-layout>
