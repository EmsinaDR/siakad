@php
    //content
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
    $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
    $urlroot = app('request')->root();
@endphp

{{--
data_semester
data_acara
ketua_komite
data_kota
narasumber
ketua_komite

 --}}
<x-layout>
    <style>
        textarea {
            resize: none,
        }

        .editor {
            resize: none,
        }

        /* Pastikan TinyMCE mengambil seluruh tinggi yang ditetapkan */
        .mce-container {
            height: 1000px !important;
            /* Ganti dengan tinggi yang diinginkan */
        }

        .mce-edit-area {
            height: 1000px !important;
            /* Ganti dengan tinggi yang diinginkan */
        }

        .mce-panel {
            height: auto !important;
            /* Pastikan panel pengaturan di bawah editor tidak mengganggu */
        }

        .accordion-button {
            color: white;
            /* text warna putih */
        }

        .accordion-button::after {
            filter: invert(1);
            /* ubah panah jadi putih */
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
            <!--Card Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</h3>
            </div>
            <!--Card Header-->
            <div class='row m-2'>
                {{-- blade-formatter-disable --}}
                <div class='col-xl-2'>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#HelperPenggunaan'><i class='fa fa-info'></i> Help</button>
                    <button type='button' class='btn btn-block btn-default bg-secondary btn-md' onclick="window.location.href='{{ route('surat-keluar.index')}}'"><i class='fa fa-undo'></i> Kembali</button>
                </div>
                {{-- blade-formatter-enable --}}
                <div class='col-xl-10'>
                    {{-- blade-formatter-disable --}}
                    @php
                        $hobiListed = ['makan' => 'Makan', 'voly' => 'Voli', 'basket' => 'Basket'];
                        $KelasListed = $Kelas->pluck('kelas', 'id')->toArray();
                        $SiswaListed = $Siswas->pluck('nama_siswa', 'id')->toArray();

                        $DataInputs = [
                            'Data Siswa'=>[
                                ['field' => 'hobi', 'type' => 'select', 'options' => $hobiListed, 'value' => 'basket'],
                                ['field' => 'kelas', 'type' => 'select', 'options' => $KelasListed, 'value' => ''],
                                ['field' => 'nama_siswa', 'type' => 'select', 'options' => $SiswaListed, 'value' => ''],
                                ['field' => 'kelas_siswa', 'type' => 'text', 'value' => 'isi kelas'],
                                ['field' => 'umur', 'type' => 'number', 'value' => '1'],
                                // ['field' => 'keterangan', 'type' => 'textarea', 'value' => 'Isi keterangan'],
                            ],
                            'Data Sekolah'=>[
                                ['field' => 'hobi', 'type' => 'select', 'options' => $hobiListed, 'value' => 'basket'],
                                ['field' => 'kelas', 'type' => 'select', 'options' => $KelasListed, 'value' => ''],
                                ['field' => 'nama_siswa', 'type' => 'select', 'options' => $SiswaListed, 'value' => ''],
                                ['field' => 'kelas_siswa', 'type' => 'text', 'value' => 'isi kelas'],
                                ['field' => 'umur', 'type' => 'number', 'value' => '1'],
                            ],
                        ];
                    @endphp

                    @foreach ($DataInputs as $groupTitle => $inputs)
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0">{{ $groupTitle }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($inputs as $DataInput)
                                        @php
                                            $FieldInput = $DataInput['field'];
                                            $FieldType = $DataInput['type'];
                                            $FieldOptions = $DataInput['options'] ?? [];
                                            $Fieldvalue = $DataInput['value'] ?? '';
                                            $FieldLabel = ucwords(str_replace('_', ' ', $FieldInput));
                                            $FieldClass = $DataInput['class'] ?? '';
                                            $required = $DataInput['required'] ?? true;
                                        @endphp

                                        <div class='form-group @if($FieldType === "textarea") col-xl-12 @else col-xl-6 @endif'>
                                            @if ($FieldType === 'hidden')
                                                <input type='hidden' name='{{ $FieldInput }}' value='{{ old($FieldInput, $Fieldvalue) }}'>
                                            @else
                                                <label for='{{ $FieldInput }}'>{{ $FieldLabel }}</label>
                                                @if ($FieldType === 'select')
                                                    <select name='{{ $FieldInput }}' id='{{ $FieldInput }}' data-placeholder='Pilih Data {{$FieldLabel}}' class='select2 form-control {{$FieldClass}}' {{ $required ? 'required' : '' }}>
                                                        @foreach ($FieldOptions as $key => $value)
                                                            <option value='{{ $key }}' @selected(old($FieldInput, $Fieldvalue) == $key)>{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                @elseif($FieldType === 'textarea')
                                                    <textarea name='{{ $FieldInput }}' id='{{ $FieldInput }}' rows='3' class='{{$FieldClass}} editor form-control' placeholder='Masukkan {{$FieldLabel}}' {{ $required ? 'required' : '' }}>{{ old($FieldInput, $Fieldvalue) }}</textarea>
                                                @else
                                                    <input type='{{$FieldType}}' class='form-control {{$FieldClass}}' id='{{ $FieldInput }}' name='{{ $FieldInput }}' placeholder='{{$FieldLabel}}' value='{{ old($FieldInput, $Fieldvalue) }}' {{ $required ? 'required' : '' }}>
                                                @endif
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{-- blade-formatter-enable --}}

                </div>
            </div>
            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <!-- Konten -->
                        @php
                            $FormOptions = $FormOptions ?? [];
                            $TemplateContent = $TemplateContent ?? [];
                            $TingkatOptions = ['VII' => 'VII', 'VIII' => 'VIII', 'IX' => 'IX'];
                            $hobiList = ['makan' => 'Makan', 'voly' => 'Voli', 'basket' => 'Basket'];
                            $SiswaOptions = $Siswas->pluck('nama_siswa', 'id')->toArray();
                            $GurusOptions = $Gurus->pluck('nama_guru', 'id')->toArray();
                            $PenerimaSuratOptions = [
                                'Dewan Guru' => 'Dewan Guru',
                                'Dewan Guru dan Staf TU' => 'Dewan Guru dan Staf TU',
                                'Siswa' => 'Siswa',
                                'Siswa Kelas VII' => 'Siswa Kelas VII',
                                'Siswa Kelas VIII' => 'Siswa Kelas VIII',
                                'Siswa Kelas IX' => 'Siswa Kelas IX',
                                'Siswa dan Wali Murid' => 'Siswa dan Wali Murid',
                            ];
                            // ini isi dari name_inputs darabase

                            $MasterField = [
                                'nama_siswa' => ['type' => 'select', 'options' => $SiswaOptions],
                                // 'kelas' => ['type' => 'select', 'options' => $kelasList],
                                'tingkat_siswa' => ['type' => 'select', 'options' => $TingkatOptions],
                                'nama_guru_dropdown' => ['type' => 'select', 'options' => $GurusOptions],
                                'penerima_pemberitahuan' => ['type' => 'select', 'options' => $PenerimaSuratOptions],
                                'hobi' => ['type' => 'select', 'options' => $hobiList],
                                // 'keterangan' => ['type' => 'textarea'],
                                // 'nama_guru' => ['type' => 'text'],
                            ];
                        @endphp

                        <form id="form_surat_keluar" action="{{ route('surat.keluar.cetak') }}" method="POST">
                            @csrf
                            @method('POST')
                            {{-- blade-formatter-disable --}}
                            <div id='data-tambahan' class="col" style="display:none;">
                                <div class='card-header bg-success'><h3 class='card-title'>Data Tambahan</h3></div>
                                    <div class="accordion" id="accordionData">
                                        <!-- Data Surat -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingSurat">
                                            <button class="accordion-button collapsed bg-primary text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSurat" aria-expanded="false" aria-controls="collapseSurat">
                                                <i class="fas fa-envelope-open-text me-2"></i> Data Surat
                                            </button>
                                            </h2>
                                            <div id="collapseSurat" class="accordion-collapse collapse" aria-labelledby="headingSurat" data-bs-parent="#accordionData">
                                                <div class="accordion-body">
                                                    <div id="checkbox-list-surat" class="checkbox-grid">
                                                        <div class="form-group">
                                                            <label><input type="checkbox" value="Nomor Surat"> Nomor Surat</label>
                                                            <span>@{{nomor_surat}}</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><input type="checkbox" value="Tanggal Surat"> Tanggal Surat</label>
                                                            <span>@{{tanggal_surat}}</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><input type="checkbox" value="Perihal Surat"> Perihal</label>
                                                            <span>@{{perihal_surat}}</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><input type="checkbox" value="Penerima Surat"> Penerima Surat</label>
                                                            <span>@{{penerima_surat}}</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><input type="checkbox" value="Lampiran Surat"> Lampiran</label>
                                                            <span>@{{lampiran_surat}}</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><input type="checkbox" value="Tembusan Surat"> Tembusan</label>
                                                            <span>@{{tembusan_surat}}</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><input type="checkbox" value="Kontak Sekolah"> Kontak Sekolah</label>
                                                            <span>@{{kontak_sekolah}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Data Pelaksanaan -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingPelaksanaan">
                                            <button class="accordion-button collapsed bg-primary text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePelaksanaan" aria-expanded="false" aria-controls="collapsePelaksanaan">
                                                <i class="fa fa-calendar-alt mr-2"></i>Data Pelaksanaan
                                            </button>
                                            </h2>
                                            <div id="collapsePelaksanaan" class="accordion-collapse collapse" aria-labelledby="headingPelaksanaan" data-bs-parent="#accordionData">
                                                <div class="accordion-body">
                                                    <div id="checkbox-list-pelaksanaan" class="checkbox-grid">
                                                        <div class="form-group">
                                                            <label><input type="checkbox" value="Nama Kegiatan"> Nama Kegiatan</label>
                                                            <span>@{{waktu_kegiatan}}</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><input type="checkbox" value="Acara"> Nama Acara</label>
                                                            <span>@{{acara}}</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><input type="checkbox" value="Tempat Pelaksanaan"> Tempat Pelaksanaan</label>
                                                            <span>@{{tempat_pelaksanaan}}</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><input type="checkbox" value="Jam Masuk"> Jam Masuk</label>
                                                            <span>@{{jam_masuk}}</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><input type="checkbox" value="Jam Pulang"> Jam Pulang</label>
                                                            <span>@{{jam_pulang}}</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><input type="checkbox" value="Jam Operasional"> Jam Operasional</label>
                                                            <span>@{{jam_operasional}}</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><input type="checkbox" value="Waktu Pelaksanaan"> Waktu Pelaksanaan Kegiatan</label>
                                                            <span>@{{waktu_pelaksanaan}}</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><input type="checkbox" value="Tanggal Normal"> Tanggal Normal</label>
                                                            <span>@{{tanggal_normal}}</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><input type="checkbox" value="Tanggal Pelaksanaan"> Tanggal Pelaksanaan</label>
                                                            <span>@{{tanggal_pelaksanaan}}</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><input type="checkbox" value="Tanggal Pelaksanaan Mulai"> Tanggal Pelaksanaan Mulai</label>
                                                            <span>@{{tanggal_pelaksanaan_mulai}}</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><input type="checkbox" value="Tanggal Pelaksanaan Selesai"> Tanggal Pelaksanaan Selesai</label>
                                                            <span>@{{tanggal_pelaksanaan_selesai}}</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><input type="checkbox" value="Data Link"> Data Link</label>
                                                            <span>@{{data_link}}</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><input type="checkbox" value="Periode"> Periode</label>
                                                            <span>@{{periode}}</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><input type="checkbox" value="Jumlah Hari"> Jumlah Hari</label>
                                                            <span>@{{jumlah_hari}}</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><input type="checkbox" value="Materi"> Materi Seminar</label>
                                                            <span>@{{materi}}</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><input type="checkbox" value="Tingkat Lomba"> Tingkat Lomba</label>
                                                            <span>@{{tingkat_lomba}}</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><input type="checkbox" value="Sekolah Tujuan"> Sekolah Tujuan</label>
                                                            <span>@{{sekolah_tujuan}}</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><input type="checkbox" value="Alamat Tujuan"> Alamat Tujuan</label>
                                                            <span>@{{alamat_tujuan}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Data Siswa -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingSiswa">
                                            <button class="accordion-button collapsed bg-primary text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSiswa" aria-expanded="false" aria-controls="collapseSiswa">
                                                <i class="fa fa-user mr-2"></i>Data Siswa
                                            </button>
                                            </h2>
                                            <div id="collapseSiswa" class="accordion-collapse collapse" aria-labelledby="headingSiswa" data-bs-parent="#accordionData">
                                                <div class="accordion-body">
                                                    <div id="checkbox-list-siswa" class="checkbox-grid">
                                                        <div class="form-group">
                                                            <label><input type="checkbox" value="Nama Siswa"> Nama Siswa Blank</label>
                                                            <span>@{{nama_siswa}}</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><input type="checkbox" value="Nama Siswa Dropdown"> Nama Siswa Dropdown</label>
                                                            <span>@{{nama_siswa_dropdown}}</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><input type="checkbox" value="Tingkat Dropdown"> Tingkat Dropdown</label>
                                                            <span>@{{tingkat_dropdown}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Data Guru -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingGuru">
                                            <button class="accordion-button collapsed bg-primary text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGuru" aria-expanded="false" aria-controls="collapseGuru">
                                                👨‍🏫 Data Guru
                                            </button>
                                            </h2>
                                            <div id="collapseGuru" class="accordion-collapse collapse" aria-labelledby="headingGuru" data-bs-parent="#accordionData">
                                                <div class="accordion-body">
                                                    <div id="checkbox-list-guru" class="checkbox-grid">
                                                        <div class="form-group">
                                                            <label><input type="checkbox" value="Nama Guru"> Nama Guru Blank</label>
                                                            <span>@{{nama_guru}}</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><input type="checkbox" value="Nama Mapel"> Nama Mapel</label>
                                                            <span>@{{nama_mapel}}</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><input type="checkbox" value="Nama Guru Dropdown"> Nama Guru Dropdown</label>
                                                            <span>@{{nama_guru_dropdown}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <div class="col p-2">
                                    <div class="form-group pt-4">
                                    <label for="form_pilih">Pilih Template</label>
                                    <select id="form_pilih" name="form_pilih" class="form-control" data-placeholder="Pilih form surat" onchange="updateForm()">
                                        <option value=""></option>
                                        @foreach ($Templateform as $form)
                                            @php $slug = \Illuminate\Support\Str::slug($form); @endphp
                                            <option value="{{ $slug }}">{{ $form }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id='TitleVariabelU' class='card-header bg-primary' style="display:none;">
                                    <h3 class='card-title'>
                                        <i class="fas fa-envelope-open-text"></i> Data Variabel Utama
                                    </h3>
                                </div>
                                <div class='form-group mt-2'>
                                    <label for='klasifikasi_id'>Klasifikasi Surat</label>
                                    <select name='klasifikasi_id' id='klasifikasi_id' data-placeholder='Pilih data klasifikasi surat' class='select2 form-control' required>
                                            <option value=''>--- Pilih Klasifikasi Surat ---</option>
                                        @foreach($Klasifikasis as $newKlasifikasiSurats)
                                            <option value='{{$newKlasifikasiSurats->id}}'>{{$newKlasifikasiSurats->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div id='NomorSurat' class='form-group' style="display:none;">
                                        <label for='nomor_surat'>Nomor Surat</label>
                                        <input type='text' class='form-control bg-success' id='nomor_surat' name='nomor_surat' placeholder='Nomor Surat' readonly>
                                        <span class='mt-2'><b>Catatan :</b> <br></span>
                                        <span>Nomor surat ini <b class="text-success">otomatis</b> sesuai dengan klasifikasi surat dan akan dimasukkan kedalam <b class="text-success">surat keluar</b> dan <b class="text-success">undangan rapat</b></span>
                                </div>
                                    <script>
                                        $(document).ready(function () {
                                            $('#klasifikasi_id').on('change', function() {
                                                let klasifikasiId = $(this).val();

                                                const NomorSurat = document.getElementById('NomorSurat');
                                                if (NomorSurat) NomorSurat.style.display = 'block';

                                                const lampiranSurat = document.getElementById('lampiran_group');
                                                if (lampiranSurat) lampiranSurat.style.display = 'block';
                                                const PerihaLSurat = document.getElementById('perihal_group');
                                                if (PerihaLSurat) PerihaLSurat.style.display = 'block';

                                                if (klasifikasiId) {
                                                    $.ajax({
                                                        url: "{{ route('no.surat.get') }}",
                                                        method: 'GET',
                                                        data: {
                                                            klasifikasi_id: klasifikasiId
                                                        },
                                                        success: function(response) {
                                                            if (response.status === 'success') {
                                                                $('#nomor_surat').val(response.nomor_surat);
                                                            } else {
                                                                $('#nomor_surat').val('');
                                                                alert(response.message || 'Gagal mengambil nomor surat');
                                                            }
                                                        },
                                                        error: function(xhr) {
                                                            $('#nomor_surat').val('');
                                                            alert('Terjadi kesalahan saat menghubungi server.');
                                                        }
                                                    });
                                                } else {
                                                    $('#nomor_surat').val('');
                                                }
                                            });


                                        });
                                    </script>
                                <div class="row pb-2">
                                    <div id="perihal_group"  class='form-group col-xl-10' style="display:none;">
                                    <label for='perihal'>Perihal</label>
                                    <input type='text' class='form-control' id='perihal' name='perihal_surat' placeholder='Perihal surat' required>
                                    </div>
                                    <div id="lampiran_group"  class='form-group col-xl-2' style="display:none;">
                                        <label for='lampiran'>Lampiran</label>
                                        <input type='text' class='form-control' id='lampiran_surat' name='lampiran_surat' placeholder='Jumlah lampiran surat' value='0' required>
                                    </div>
                                </div>

                                <hr id='HrPembatas' class='bg-dark' style='height: 2px;display:none;'>

                                <div class="col-xl-12 py-2">
                                    <div id="input-area" class="row g-3"></div>
                                </div>
                            </div>




                        {{-- blade-formatter-disable --}}

                        {{-- blade-formatter-enable --}}
                            {{-- blade-formatter-enable --}}

                    </div>
                    <div class="p-4">
                        <div id='TitleVariabel' class='card-header bg-primary' style="display:none;">
                            <h3 class='card-title'>
                                <i class="fas fa-envelope-open-text"></i> Data Variabel Template
                            </h3>
                        </div>
                    </div>



                    <div class="row p-4">
                        {{-- blade-formatter-disable --}}
                                @foreach ($FormOptions as $formName => $fields)
                                    @if (!is_null($fields) && !empty($fields))
                                        @foreach ($fields as $field)
                                            @php
                                                $fieldName = $field['name'];
                                                $type = $field['type'];
                                                $value = $field['value'] ?? '';
                                            @endphp

                                            <div class="form-group dynamic-field col-xl-6" id="{{ $fieldName }}_group" style="display: none;">
                                                <label for="{{ $fieldName }}">{{ ucwords(str_replace('_', ' ', $fieldName)) }}</label>
                                                @if ($type === 'select')
                                                    @php
                                                        $options = isset($MasterField[$fieldName]['options']) && is_array($MasterField[$fieldName]['options'])
                                                            ? $MasterField[$fieldName]['options']
                                                            : [];
                                                    @endphp
                                                    <select class="select2 form-control" id="{{ $fieldName }}" name="{{ $fieldName }}" disabled>
                                                        <option value="">--- Pilih ---</option>
                                                        @foreach ($options as $id => $nama_siswa)
                                                            <option value="{{ $id }}">{{ $nama_siswa }}</option>
                                                        @endforeach
                                                    </select>
                                                @elseif($type === 'textarea')
                                                    <textarea class="form-control" id="{{ $fieldName }}" name="{{ $fieldName }}" placeholder="{{ ucwords(str_replace('_', ' ', $fieldName)) }}" disabled></textarea>
                                                @else
                                                    @php
                                                    if($fieldName === 'waktu_pelaksanaan'){
                                                        $value = '07:15';
                                                    }elseif($fieldName === 'tempat_pelaksanaan'){
                                                        $value = $Identitas->namasek;
                                                    }elseif($fieldName === 'peserta_kegiatan'){
                                                        $value = 'Guru dan Karyawan';
                                                    }elseif($fieldName === 'jumlah_hari'){
                                                        $value = 1;
                                                    }elseif($fieldName === 'tanggal_normal'){
                                                        $value = Carbon::now()->addDays(2)->translatedformat('Y-m-d');
                                                    }elseif($fieldName === 'tanggal_pelaksanaan'){
                                                        $value = Carbon::now()->addDays()->translatedformat('Y-m-d');
                                                    }elseif($fieldName === 'tanggal_pelaksanaan_mulai'){
                                                        $value = Carbon::now()->addDays()->translatedformat('Y-m-d');
                                                    }elseif($fieldName === 'tanggal_pelaksanaan_selesai'){
                                                        $value = Carbon::now()->addDays(5)->translatedformat('Y-m-d');
                                                    }elseif($fieldName === 'batas_pembayaran'){
                                                        $value = Carbon::now()->addDays()->translatedformat('Y-m-10');
                                                    }elseif($fieldName === 'jam_masuk'){
                                                        $value = Carbon::now()->addDays()->translatedformat('H:i');
                                                    }elseif($fieldName === 'jam_pulang'){
                                                        $value = Carbon::now()->addDays()->translatedformat('13:00');
                                                    }elseif($fieldName === 'jam_operasional'){
                                                        $value = Carbon::now()->addDays()->translatedformat('07:00');
                                                    }elseif($fieldName === 'waktu_pelaksanaan'){
                                                        $value = Carbon::now()->addDays()->translatedformat('08:00');
                                                    }else{

                                                    }
                                                    @endphp
                                                    <input type="{{ $type }}" class="form-control input-cek" id="{{ $formName }}_{{ $fieldName }}" name="{{ $fieldName }}" placeholder="{{ ucwords(str_replace('_', ' ', $fieldName)) }}" disabled oninput="console.log('nama_kegiatan:', this.value)" value='{{$value ?? ''}}'>
                                                @endif
                                            </div>

                                        @endforeach
                                    @endif
                                @endforeach
                                {{-- blade-formatter-enable --}}
                        {{-- blade-formatter-disable --}}
                            <div id="content_group" class="form-group p-4" style="display:none;">
                                <div class='card-header bg-success'>
                                    <h3 class='card-title'>Isi Surat</h3>
                                </div>
                                {{-- <label for="content">Template Surat</label> --}}
                                <textarea name="content" id="content" rows="6" class="editor form-control" placeholder="Masukkan Isi Template (HTML)"></textarea>
                            </div>
                            <div class="col-xl-12">
                                <button id="btn_save" style="display:none" type="submit" class="btn float-right bg-primary btn-md">
                                <i class="fa fa-save"></i> save
                            </button>
                            </div>
                            {{-- blade-formatter-enable --}}
                    </div>
                    </form>

                    <script>
                        // Mapping dari slug ke form & isi template
                        const FormOptions = @json(collect($FormOptions));
                        const TemplateContent = @json(collect($TemplateContent));

                        function updateForm() {
                            const selected = document.getElementById('form_pilih').value;
                            console.log('Selected form:', selected);

                            // Semua field disembunyikan & disabled
                            const allFields = document.querySelectorAll('.dynamic-field');
                            allFields.forEach(field => {
                                field.style.display = 'none';
                                field.querySelectorAll('input, select, textarea').forEach(el => el.disabled = true);
                            });

                            // Tampilkan dan enable field yang sesuai form
                            if (FormOptions[selected]) {
                                FormOptions[selected].forEach(field => {
                                    const el = document.getElementById(field.name + '_group');
                                    if (el) {
                                        el.style.display = 'block';
                                        el.querySelectorAll('input, select, textarea').forEach(elm => elm.disabled = false);
                                    }
                                });
                            }
                            // Tampilkan textarea content dan tombol save
                            const contentGroup = document.getElementById('content_group');
                            if (contentGroup) contentGroup.style.display = 'block';
                            const saveBtn = document.getElementById('btn_save');
                            if (saveBtn) saveBtn.style.display = 'block';
                            // Tampilkan textarea content dan tombol Perihal
                            const DataTambahan = document.getElementById('data-tambahan');
                            if (DataTambahan) DataTambahan.style.display = 'block';
                            const KlasifikasiSurat = document.getElementById('klasifikasi_id');
                            if (KlasifikasiSurat) KlasifikasiSurat.style.display = 'block';
                            const HrPembatas = document.getElementById('HrPembatas');
                            if (HrPembatas) HrPembatas.style.display = 'block';
                            const TitleVariabel = document.getElementById('TitleVariabel');
                            if (TitleVariabel) TitleVariabel.style.display = 'block';
                            const TitleVariabelU = document.getElementById('TitleVariabelU');
                            if (TitleVariabelU) TitleVariabelU.style.display = 'block';

                            // Set isi TinyMCE
                            if (TemplateContent[selected]) {
                                tinymce.get('content').setContent(TemplateContent[selected]);
                            } else {
                                tinymce.get('content').setContent('');
                            }

                        }

                        // Daftar variabel yang bisa dipanggil di editor
                        // {{-- blade-formatter-disable --}}
                            const variableList = [
                                    { key: 'tahun_pelajaran', label: '📘 Tahun Pelajaran', type: 'text', default: '' },
                                    { key: 'nama_sekolah', label: '🏫 Nama Sekolah', type: 'text', default: '' },
                                    { key: 'alamat_sekolah', label: '📍 Alamat Sekolah', type: 'text', default: '' },
                                    { key: 'nama_kepala', label: '👨‍💼 Nama Kepala Sekolah', type: 'text', default: '' },
                                    { key: 'nip_kepala', label: '🆔 NIP Kepala Sekolah', type: 'text', default: '' },
                                    { key: 'rekening_sekolah', label: '🆔 Rekening Sekolah', type: 'text', default: '' },

                                    { key: 'nama_guru', label: '👨‍🏫 Nama Guru', type: 'text', default: '' },
                                    { key: 'nip_guru', label: '🆔 NIP Guru', type: 'text', default: '' },
                                    { key: 'alamat_guru', label: '🆔 Alamat Guru', type: 'text', default: '' },
                                    { key: 'nama_mapel', label: '🆔 Mapel', type: 'text', default: '' },

                                    { key: 'nomor_surat', label: '✉️ Nomor Surat', type: 'text', default: '' },
                                    { key: 'perihal_surat', label: '📝 Perihal Surat', type: 'text', default: '' },
                                    { key: 'acara', label: '📝 Acara', type: 'text', default: '' },
                                    { key: 'lampiran_surat', label: '📎 Lampiran Surat', type: 'text', default: '' },
                                    { key: 'tembusan_surat', label: '📬 Tembusan Surat', type: 'textarea', default: '' },
                                    { key: 'data_hari', label: '📬 Data Hari', type: 'number', default: 0 },
                                    { key: 'data_link', label: '📬 Data Link', type: 'text', default: '' },
                                    { key: 'periode', label: '📬 Periode', type: 'text', default: '' },
                                    { key: 'tanggal_surat', label: '📬 Tanggal Surat', type: 'date', default: '' },

                                    { key: 'nama_kegiatan', label: '🎯 Nama Kegiatan', type: 'text', default: '' },
                                    { key: 'waktu_pelaksanaan', label: '🕒 Waktu Pelaksanaan', type: 'time', default: '07:00' },
                                    { key: 'jam_masuk', label: '🕒 Jam Masuk', type: 'time', default: '07:00' },
                                    { key: 'jam_pulang', label: '🕒 Jam Masuk', type: 'time', default: '13:00' },
                                    { key: 'tanggal_pelaksanaan', label: '📅 Tanggal Normal', type: 'date', default: '' },
                                    { key: 'tanggal_normal', label: '📅 Tanggal Pelaksanaan', type: 'date', default: '' },
                                    { key: 'tanggal_pelaksanaan_mulai', label: '⏳ Tanggal Mulai', type: 'date', default: '' },
                                    { key: 'tanggal_pelaksanaan_selesai', label: '🏁 Tanggal Selesai', type: 'date', default: '' },
                                    { key: 'tempat_pelaksanaan', label: '🏁 Tempat Pelaksanaan', type: 'text', default: '' },
                                    { key: 'jumlah_hari', label: '🏁 Jumlah Hari', type: 'number', default: 0 },
                                    { key: 'jam_operasional', label: '🏁 Jam Operasional', type: 'time', default: '07:00' },

                                    { key: 'nama_siswa', label: '👦 Nama Siswa', type: 'text', default: '' },
                                    { key: 'kelas_siswa', label: '🏷️ Kelas Siswa', type: 'text', default: '' },
                                    { key: 'alamat_siswa', label: '🏠 Alamat Siswa', type: 'text', default: '' },
                                    { key: 'tempat_lahir_siswa', label: '🗺️ Tempat Lahir', type: 'text', default: '' },
                                    { key: 'tanggal_lahir_siswa', label: '🎂 Tanggal Lahir', type: 'date', default: '' },
                                    { key: 'nama_ibu', label: '👩 Nama Ibu', type: 'text', default: '' },
                                    { key: 'pekerjaan_ibu', label: '🧹 Pekerjaan Ibu', type: 'text', default: '' },
                                    { key: 'tingkat_siswa', label: '🧹 Tingkat Siswa', type: 'text', default: '' },
                                    { key: 'tingkat_dropdown', label: '🧹 Tingkat', type: 'select', default: '' },
                                    { key: 'penerima_surat', label: '📝 Penerima Surat', type: 'select', default: '' },
                                ];

                            // {{-- blade-formatter-enable --}}


                        // Pastikan TinyMCE sudah diinisialisasi saat halaman dimuat
                        document.addEventListener('DOMContentLoaded', function() {
                            tinymce.init({
                                selector: '.editor', // Pastikan selector sesuai dengan textarea yang diinginkan
                                height: 1000, // Atur tinggi editor sesuai keinginan
                                branding: false,
                                menubar: 'file edit view insert format tools table help',
                                plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table pagebreak',
                                toolbar: 'undo redo | formatselect | bold italic underline strikethrough backcolor | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | link image media table | removeformat fullscreen code | pagebreak',

                                setup: function(editor) {
                                    // Buat suggestion autocomplete variabel
                                    const variableSuggestions = variableList.map(function(item) {
                                        return {
                                            value: '#' + item.key,
                                            text: item.label,
                                            insertValue: '@{{ ' + item.key + ' }}'
                                        };
                                    });


                                    editor.ui.registry.addAutocompleter('customVariables', {
                                        ch: '#',
                                        minChars: 1,
                                        fetch: function(pattern) {
                                            return new Promise(function(resolve) {
                                                const matches = variableSuggestions.filter(function(
                                                    s) {
                                                    return s.value.toLowerCase().includes(
                                                        pattern.toLowerCase());
                                                });
                                                resolve(matches);
                                            });
                                        },
                                        onAction: function(autocompleteApi, rng, value) {
                                            const selected = variableSuggestions.find(function(s) {
                                                return s.value === value;
                                            });
                                            editor.selection.setRng(rng);
                                            // Gunakan insertValue, jangan value
                                            if (selected && selected.insertValue) {
                                                editor.insertContent(selected.insertValue);
                                            } else {
                                                editor.insertContent(value);
                                            }
                                            autocompleteApi.hide();
                                        }

                                    });

                                    editor.on('change', function() {
                                        editor.save(); // Menyimpan perubahan di TinyMCE ke dalam textarea
                                    });
                                }
                            });
                        });
                    </script>


                    @php
                        $ListKelas = ['VII' => 'VII', 'VIII' => 'VIII', 'IX' => 'IX'];
                        $ListSiswa = $Siswas->pluck('nama_siswa', 'id')->toArray();
                        $ListGuru = $Gurus->pluck('nama_guru', 'id')->toArray();
                        $Penerima_surat = [
                            'Dewan Guru' => 'Dewan Guru',
                            'Dewan Guru dan Staf TU' => 'Dewan Guru dan Staf TU',
                            'Siswa' => 'Siswa',
                            'Siswa Kelas VII' => 'Siswa Kelas VII',
                            'Siswa Kelas VIII' => 'Siswa Kelas VIII',
                            'Siswa Kelas IX' => 'Siswa Kelas IX',
                            'Siswa dan Wali Murid' => 'Siswa dan Wali Murid',
                            'Warga Sekolah' => 'Warga Sekolah',
                        ];

                    @endphp
                    <style>
                        .checkbox-grid {
                            display: grid;
                            grid-template-columns: repeat(4, 1fr);
                            /* Maksimal 4 kolom */
                            gap: 10px;
                        }

                        .checkbox-grid label {
                            display: flex;
                            align-items: center;
                            gap: 5px;
                        }

                        @media (max-width: 768px) {
                            .checkbox-grid {
                                grid-template-columns: repeat(2, 1fr);
                                /* Responsif di layar kecil */
                            }
                        }

                        @media (max-width: 480px) {
                            .checkbox-grid {
                                grid-template-columns: 1fr;
                                /* 1 kolom di layar sangat kecil */
                            }
                        }
                    </style>

                    <script>
                        // {{-- blade-formatter-disable --}}
                            const fieldConfigs = {
                                    "Nama Siswa Dropdown": {
                                        type: "select",
                                        options: @json($ListSiswa),
                                        default: "{{ array_key_first($ListSiswa) }}"
                                    },
                                    "Nama Guru Dropdown": {
                                        type: "select",
                                        options: @json($ListGuru),
                                        default: "{{ strval(array_key_first($ListGuru)) }}"
                                    },
                                    "Tingkat Dropdown": {
                                        type: "select",
                                        options: @json($ListKelas),
                                        default: "XI"
                                    },
                                    "Penerima Surat": {
                                        type: "select",
                                        options: @json($Penerima_surat),
                                        default: "{{ array_key_first($Penerima_surat) }}"
                                    },
                                    "Jenis Kelamin": {
                                        type: "select",
                                        options: ["Laki-laki", "Perempuan"],
                                        default: "Laki-laki"
                                    },
                                    "NIS": { type: "text", default: "" },
                                    "Jam Masuk": { type: "time", default: "07:00" },
                                    "Jam Pulang": {
                                        type: "time",
                                        default: @json(\Carbon\Carbon::createFromTime(13, 0)->format('H:i'))
                                    },
                                    "Jam Operasional": {
                                        type: "time",
                                        default: @json(\Carbon\Carbon::createFromTime(7, 0)->format('H:i'))
                                    },
                                    "Waktu Pelaksanaan": { type: "time", default: "07:00" },
                                    "Nomor Surat": { type: "text", default: "" },
                                    "Link Pengumuman": { type: "text", default: "" },
                                    "Periode": { type: "text", default: "" },
                                    "Tembusan Surat": { type: "textarea", default: "" },
                                    "Perihal Surat": { type: "text", default: "" },
                                    "Lampiran": { type: "text", default: "" },
                                    "Nama Siswa": { type: "text", default: "" },
                                    "Nama Guru": { type: "text", default: "" },
                                    "Data Link": { type: "text", default: "" },
                                    "Jumlah Hari": { type: "number", default: "" },
                                    "Tanggal Normal": {
                                        type: "date",
                                        default: @json(\Carbon\Carbon::now()->format('Y-m-d'))
                                    },
                                    "Tanggal Surat": {
                                        type: "date",
                                        default: @json(\Carbon\Carbon::now()->format('Y-m-d'))
                                    },
                                    "Tanggal Pelaksanaan": {
                                        type: "date",
                                        default: @json(\Carbon\Carbon::now()->format('Y-m-d'))
                                    },
                                    "Tanggal Pelaksanaan Mulai": {
                                        type: "date",
                                        default: @json(\Carbon\Carbon::now()->addDays(0)->format('Y-m-d'))
                                    },
                                    "Tanggal Pelaksanaan Selesai": {
                                        type: "date",
                                        default: @json(\Carbon\Carbon::now()->addDays(5)->format('Y-m-d'))
                                    }
                                };


                            // {{-- blade-formatter-enable --}}

                        // {{-- blade-formatter-enable --}}
                        function toSnakeCase(text) {
                            return text.normalize("NFD").replace(/[\u0300-\u036f]/g, "")
                                .replace(/\W+/g, ' ').trim().toLowerCase().replace(/\s+/g, '_');
                        }
                        document.querySelectorAll(
                            '#checkbox-list-surat input[type="checkbox"], #checkbox-list-siswa input[type="checkbox"], #checkbox-list-lomba input[type="checkbox"], #checkbox-list-pelaksanaan input[type="checkbox"], #checkbox-list-guru input[type="checkbox"]'
                        ).forEach(cb => {
                            cb.addEventListener('change', function() {
                                const label = this.value.trim();
                                const fieldName = toSnakeCase(label);
                                const inputArea = document.getElementById('input-area');
                                const existing = document.getElementById('group_' + fieldName);

                                if (this.checked && !existing) {
                                    const config = fieldConfigs[label] || {
                                        type: "text"
                                    };

                                    const col = document.createElement('div');
                                    col.className = (config.type === "textarea") ? 'col-12' : 'col-xl-6';
                                    col.id = 'group_' + fieldName;

                                    const wrapper = document.createElement('div');
                                    wrapper.className = 'form-group';

                                    const labelElem = document.createElement('label');
                                    labelElem.setAttribute('for', fieldName);
                                    labelElem.textContent = label;
                                    wrapper.appendChild(labelElem);

                                    if (config.type === "select") {
                                        const select = document.createElement('select');
                                        select.className = 'select2 form-control';
                                        select.id = fieldName;
                                        select.name = fieldName;

                                        if (Array.isArray(config.options)) {
                                            config.options.forEach(opt => {
                                                const option = document.createElement('option');
                                                option.value = opt;
                                                option.textContent = opt;
                                                if (config.default && config.default == opt) {
                                                    option.selected = true;
                                                }
                                                select.appendChild(option);
                                            });
                                        } else {
                                            Object.entries(config.options).forEach(([val, text]) => {
                                                const option = document.createElement('option');
                                                option.value = val;
                                                option.textContent = text;
                                                if (config.default && config.default == val) {
                                                    option.selected = true;
                                                }
                                                select.appendChild(option);
                                            });
                                        }

                                        wrapper.appendChild(select);
                                    } else if (config.type === "textarea") {
                                        const textarea = document.createElement('textarea');
                                        textarea.className = 'editor form-control';
                                        textarea.id = fieldName;
                                        textarea.name = fieldName;
                                        textarea.placeholder = label;
                                        if (config.default) {
                                            textarea.value = config.default;
                                        }
                                        wrapper.appendChild(textarea);
                                    } else {
                                        const input = document.createElement('input');
                                        input.type = config.type;
                                        input.className = 'form-control';
                                        input.id = fieldName;
                                        input.name = fieldName;
                                        input.placeholder = label;
                                        if (config.default) {
                                            input.value = config.default;
                                        }
                                        wrapper.appendChild(input);
                                    }
                                    col.appendChild(wrapper);
                                    inputArea.appendChild(col);
                                    if (config.type === "select") {
                                        // Inisialisasi Select2
                                        $('#' + fieldName).select2({
                                            width: '100%',
                                            theme: 'bootstrap4' // kalau kamu pakai tema bootstrap
                                        });
                                    }

                                    // Inisialisasi TinyMCE hanya untuk textarea
                                    if (config.type === "textarea") {
                                        tinymce.init({
                                            selector: `#${fieldName}`,
                                            branding: false,
                                            resize: false,
                                            menubar: 'file edit view insert format tools table help',
                                            plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table pagebreak',
                                            toolbar: 'undo redo | formatselect | bold italic underline strikethrough backcolor | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | link image media table | removeformat fullscreen code | pagebreak',
                                            table_default_attributes: {
                                                border: "1"
                                            },
                                            table_sizing_mode: 'responsive',
                                            quickbars_insert_toolbar: 'inserttable',
                                            quickbars_selection_toolbar: 'bold italic | quicklink',
                                            convert_urls: false,
                                            indent: true,
                                            entity_encoding: "named",
                                            paste_remove_styles: true,
                                            paste_remove_spans: true,
                                            setup: function(editor) {
                                                editor.on('init', function() {
                                                    editor.setContent(config.default || '');
                                                });
                                            }
                                        });
                                    }
                                } else if (!this.checked && existing) {
                                    existing.remove();
                                    // Optional: destroy TinyMCE editor instance if needed
                                    if (tinymce.get(fieldName)) {
                                        tinymce.get(fieldName).remove();
                                    }
                                }
                            });
                        });
                    </script>
                    {{-- blade-formatter-enable --}}
                </div>
            </div>
        </div>
        </div>
        </div>
        </div>
    </section>
</x-layout>
{{-- <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='HelperPenggunaan()'><i class='fa fa-plus'></i> Dokumen Siswa</button> --}}
{{--
onclick='HelperPenggunaan()'
 --}}

<script>
    function HelperPenggunaan(data) {
        var HelperPenggunaan = new bootstrap.Modal(document.getElementById('HelperPenggunaan'));
        HelperPenggunaan.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='HelperPenggunaan' tabindex='-1' aria-labelledby='LabelHelperPenggunaan' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelHelperPenggunaan'>
                    Cara Penggunaan
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <div class='card'>
                    <div class='card-header bg-warning'>
                        <h3 class='card-title'><i class='fas fa-text-width pr-2'></i><b>Cara Penggunaan</b></h3>
                    </div><!-- /.card-header -->
                    <div class='card-body'>
                        <dl>
                            <dt>1. Penggunaan Variabel</dt>
                            <ul>
                                <li>Gunakan variabel sesuai yang ada di dalam isi template jika ingin maksimal dan
                                    berubah otomatis</li>
                                <li>Contoh Variabel <b class="text-success">@{{ waktu_pelaksanaan }}</b> yang artinya
                                    saat anda mengisi input data tersebut akan tergantikan otomatis sesuai dengan isi
                                    forma yang dimasukkan. Jika bingung bisa melihat konteks yang ada di tab <b
                                        class="text-success">Data Tambahan</b></li>
                                <li>Setiap template memiliki variabel berbeda - beda dengan form sesuai kebutuhan masing
                                    - masing</li>
                            </ul>
                            <dt>2. Variabel Guru dan Siswa</dt>
                            <ul>

                                @php
                                    $VariabelGuru = [
                                        '{{ nama_guru }}' => 'Nama Guru',
                                        '{{ nip_guru }}' => 'NIP Guru',
                                        '{{ alamat_guru }}' => 'Alamat Guru',
                                        '{{ kode_guru }}' => 'Kode Guru',
                                        '{{ status_guru }}' => 'Status Guru',
                                        '{{ no_hp }}' => 'No. HP',
                                    ];
                                @endphp
                                <li>
                                    Variabel Guru yang bisa ditambahkan di antaranya: <br>

                                    <table class="table table-bordered table-hover" width="100%">
                                        <thead class="table-primary text-center align-middle">
                                            <tr>
                                                <th width='1%'>ID</th>
                                                <th>Keterangan</th>
                                                <th>Variabel</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($VariabelGuru as $key => $label)
                                                <tr class="text-center">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $label }}</td>
                                                    <td>{{ $key }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="table-primary text-center align-middle">
                                            <tr>
                                                <th>ID</th>
                                                <th>Keterangan</th>
                                                <th>Variabel</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </li>

                                <li>Variabel Siswa yang bisa di tambahkan diantaranya : <br>
                                    <table class="table table-bordered table-hover" width="100%">
                                        <thead class="table-primary text-center align-middle">
                                            <tr class='table-primary text-center align-middle'>
                                                <th width='1%'>ID</th>
                                                <th>Data</th>
                                                <th>Variabel</th>
                                            </tr>
                                        </thead>

                                        @php
                                            $Variabel = [
                                                '{{ nama_siswa }}' => 'Nama Siswa',
                                                '{{ nis_siswa }}' => 'NIS Siswa',
                                                '{{ nisn_siswa }}' => 'NISN Siswa',
                                                '{{ alamat_siswa }}' => 'Alamat Siswa',
                                            ];
                                        @endphp

                                        <tbody>
                                            @foreach ($Variabel as $key => $label)
                                                <tr class='text-center'>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $label }}</td>
                                                    <td>{{ $key }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                        <tfoot>
                                            <tr class='table-primary text-center align-middle'>
                                                <th>ID</th>
                                                <th>Data</th>
                                                <th>Variabel</th>
                                            </tr>
                                        </tfoot>
                                    </table>

                                </li>
                            </ul>
                            <b>Catatan :</b> <br>
                            Ini bisa digunakan jika menggunakan Guru Dropdwon atau Siswa Dropdown
                            <dt>3. Template Lain</dt>
                            <ul>
                                <li>Jika anda memiliki konsep atau template bisa ditambahkan pada data template database
                                    agar bisa dimasukkan ke dalam daftar template</li>
                            </ul>
                        </dl>
                    </div><!-- /.card-body -->
                </div>
            </div>

        </div>
    </div>

</div>
