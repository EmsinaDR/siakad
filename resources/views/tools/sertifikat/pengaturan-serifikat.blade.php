@php
    //content
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
    $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
    $urlroot = app('request')->root();
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


            <div class='row m-2'>
                {{-- blade-formatter-disable --}}
                   <div class='col-xl-2'>
                       <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#BuatSertifikatPenghargaan'><i class='fa fa-plus'></i> Sertifikat Siswa</button>
                   </div>
                   <div class='col-xl-10'></div>
               </div>
               {{-- blade-formatter-enable --}}


                <div class='ml-2 my-4'>

                </div>


            </div>

    </section>
</x-layout>
{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='BuatSertifikatPenghargaan' tabindex='-1' aria-labelledby='LabelBuatSertifikatPenghargaan'
    aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelBuatSertifikatPenghargaan'>
                    Buat Sertifikat
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                {{-- <form id='BuatSertifikatPenghargaan-form' action='{{route('pengaturan-sertifikat.store')}}' method='POST'> --}}
                <form id='BuatSertifikatPenghargaan-form' action='{{ route('cetak.sertifikat') }}' method='POST'>
                    @csrf
                    @method('POST')
                    @php
                        $Perans = ['Peserta', 'Panitia', 'Ketua Panitia', 'Juara 1'];
                        $NamaFile = ['1', '2'];
                        $Judul = ['Sertifikat', 'Piagam'];
                    @endphp
                    <div class='form-group'>
                       <label for='judul'>Judul</label>
                       <select name='judul' id='judul' data-placeholder='Pilih Data Judul' class='select2 form-control' required>
                               <option value=''>--- Pilih Judul ---</option>
                           @foreach($Judul as $newJudul)
                               <option value='{{$newJudul}}'>{{$newJudul}}</option>
                           @endforeach
                       </select>
                    </div>
                    <div class='form-group'>
                        <label for='detailsiswa_id'>Nama Siswa</label>
                        <select name='detailsiswa_id[]' multiple id='detailsiswa_id'
                            data-placeholder='Pilih Data Nama Siswa' class='select2 form-control' required>
                            <option value=''>--- Pilih Nama Siswa ---</option>
                            @foreach ($Siswas as $newSiswas)
                                <option value='{{ $newSiswas->id }}'>{{ $newSiswas->nama_siswa }} -
                                    {{ $newSiswas->kelasOne->kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='form-group'>
                        <label for='nama_kegiatan'>Nama Kegiatan</label>
                        <input type='text' class='form-control' id='nama_kegiatan' name='nama_kegiatan'
                            placeholder='Nama kegiatan yang diselenggarakan' required>
                    </div>
                    <div class="row">
                        <div class='col-xl-6 form-group'>
                            <label for='peran'>Peran</label>
                            <select name='peran' id='peran' data-placeholder='Pilih Data Peran'
                                class='select2 form-control' required>
                                <option value=''>--- Pilih Peran ---</option>
                                @foreach ($Perans as $newPerans)
                                    <option value='{{ $newPerans }}'>{{ $newPerans }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class='col-xl-6 form-group'>
                            <label for='tanggal_pelaksanaan'>Tanggal Pelaksanaan</label>
                            <input type='date' class='form-control' id='tanggal_pelaksanaan'
                                name='tanggal_pelaksanaan' placeholder='placeholder' required>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='tempat_pelaksanaan'>Tempat Pelaksanaan</label>
                        <input type='text' class='form-control' id='tempat_pelaksanaan' name='tempat_pelaksanaan'
                            value='{{ $Identitas->namasek }}' placeholder='Tempat Pelaksanaan' required>
                    </div>
                    <div class='form-group'>
                        <label for='detailguru_id'>Nama Guru / Ketua Panitia</label>
                        <select name='detailguru_id' id='detailguru_id' data-placeholder='Pilih Data Nama Guru'
                            class='select2 form-control' required>
                            <option value=''>--- Pilih Nama Guru ---</option>
                            @foreach ($Gurus as $newGurus)
                                <option value='{{ $newGurus->id }}'>{{ $newGurus->nama_guru }}</option>
                            @endforeach
                            <option value='lainnya'>✏️ Pilih Lainnya / Input Manual</option>
                        </select>
                    </div>

                    <div class="form-group mt-2" id="input-nama-guru" style="display: none;">
                        <label for="nama_guru_manual">Nama Guru / Ketua Panitia</label>
                        <input type="text" name="nama_guru_manual" id="nama_guru_manual" class="form-control"
                            placeholder="Masukkan nama guru">
                    </div>
                    <script>
                        $(document).on('change', '#detailguru_id', function() {
                            if ($(this).val() === 'lainnya') {
                                $('#input-nama-guru').show();
                                $('#nama_guru_manual').attr('required', true);
                            } else {
                                $('#input-nama-guru').hide();
                                $('#nama_guru_manual').removeAttr('required');
                            }
                        });
                    </script>
                    <div class='form-group'>
                        <label for='background_sertifikat'>Background</label>
                        <select name='background_sertifikat' id='background_sertifikat'
                            data-placeholder='Pilih Data Background' class='select2 form-control' required>
                            <option value=''>--- Pilih Background ---</option>
                            @foreach ($NamaFile as $newNamaFile)
                                <option value='{{ $newNamaFile }}'>{{ $newNamaFile }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- blade-formatter-disable --}}
                           <div class='modal-footer'>
                               <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Generate</button>
                           </div>
                           {{-- blade-formatter-enable --}}
                </form>
            </div>

        </div>
    </div>

</div>
