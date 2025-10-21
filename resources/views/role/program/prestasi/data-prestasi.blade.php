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


            {{-- blade-formatter-disable --}}
            <div class='row m-2'>
                <div class='col-xl-2'>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'> <i class='fa fa-plus'></i> Tambah Data Prestasi</button>
                </div>
                <div class='col-xl-10'></div>
            </div>
            {{-- blade-formatter-enable --}}


            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>Data Prestasi Akademik dan Non Akademik</h3>
                    </div>
                    <div class='card-body'>
                        {{-- Catatan :
                          - Include Komponen Modal CRUD + Javascript / Jquery
                          - Perbaiki Onclick Tombol Modal Create, Edit
                          - Variabel Active Crud menggunakan ID User
                           --}}
                        <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                            <thead>
                                <tr class='text-center'>
                                    <th width='1%'>ID</th>
                                    @foreach ($arr_ths as $arr_th)
                                        <th class='text-center'> {{ $arr_th }}</th>
                                    @endforeach
                                    <th>Action</th>
                                    {{-- @if ($activecrud === 1)
                                                {{-- @endif --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        <td class='text-center'>{{ $loop->iteration }}</td>
                                        <td class='text-center'>
                                            @if ($data->juara === 'Juara 1')
                                                🏆
                                            @elseif($data->juara === 'Juara 2')
                                                🏆🏆
                                            @elseif($data->juara === 'Juara 3')
                                                🏆🏆🏆
                                            @else
                                                🎖
                                            @endif
                                        </td>
                                        <td class='text-center'>{{ $data->juara }}</td>
                                        <td class='text-center'>{{ $data->kategori }}</td>
                                        <td class='text-center'> {{ $data->Siswa->nama_siswa }}</td>
                                        <td class='text-center'> {{ $data->tingkat }}</td>
                                        <td class='text-center'>
                                            {{ Carbon::create($data->pelaksanaan)->translatedformat('l, d F Y') }}
                                        </td>
                                        <td class='text-center'> {{ $data->keterangan }}</td>

                                        <td width='10%'>
                                            <div class='gap-1 d-flex justify-content-center'>
                                                <!-- Button untuk mengedit -->
                                                <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                                    data-toggle='modal' data-target='#editModal{{ $data->id }}'><i
                                                        class='fa fa-edit'></i> </button>
                                                <!-- Form untuk menghapus -->
                                                <form id='delete-form-{{ $data->id }}'
                                                    action='{{ route('prestasi.destroy', $data->id) }}' method='POST'
                                                    style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type='button' class='btn btn-danger btn-sm btn-equal-width'
                                                    onclick='confirmDelete({{ $data->id }})'> <i
                                                        class='fa fa-trash'></i> </button>
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- Modal View Data Akhir --}}

                                    <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                        aria-labelledby='EditModalLabel' aria-hidden='true'>

                                        <x-edit-modal>
                                            <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                            <section>
                                                <form id='updateurl' action='{{ route('prestasi.update', $data->id) }}'
                                                    method='POST'>
                                                    @csrf
                                                    @method('PATCH')

                                                    {{-- blade-formatter-disable --}}
                                                    @php
                                                        $juaraList = [ 'Juara 1' => 'Juara 1 🥇', 'Juara 2' => 'Juara 2 🥈', 'Juara 3' => 'Juara 3 🥉', 'Harapan 1' => 'Harapan 1 🎖️', 'Harapan 2' => 'Harapan 2 🎖️', 'Harapan 3' => 'Harapan 3 🎖️', 'Terbaik'                                  => 'Terbaik 🌟', 'lainnya' => 'Pilih Lainnya ➕', ];
                                                        $tingkatLomba = ['Sekolah', 'Kabupaten', 'Provinsi', 'Nasional', 'Internasional'];
                                                        $kategoriLomba = ['Akademik', 'Non Akademik'];
                                                        // $kategoriLomba = ['Kelompok', 'Individu'];
                                                        $dataIdSiswa = 'detailsiswaku-'.$data->id;

                                                    @endphp
                                                    <div class="form-group mt-2">
                                                        🥇 <label for="juara">Juara{{$data->juara}}</label>
                                                        <select id="juara-{{ $data->id }}" name="juara" class="form-control" onchange="toggleInput()">
                                                            @foreach ($juaraList as $key => $value)
                                                                <option value="{{ $key }}">{{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <input type="text" id="lainnyaInput" name="juara_lainnya" class="form-control mt-2" placeholder="Masukkan juara lainnya" style="display: none;">
                                                    <script>
                                                        function toggleInput() {
                                                            let dropdown = document.getElementById("juara");
                                                            let inputField = document.getElementById("lainnyaInput");
                                                            if (dropdown.value === "lainnya") {
                                                                inputField.style.display = "block";
                                                                inputField.required = true;
                                                            } else {
                                                                inputField.style.display = "none";
                                                                inputField.required = false;
                                                            }
                                                        }
                                                    </script>
                                                    <script>
                                                       $(document).ready(function() {
                                                           // $('#semesteredit option[value='II']').prop('selected', true); // Single Select
                                                           $('#juara-{{ $data->id }}').val(@json($data->juara)).trigger('change'); // Mutiple Select Select value in array json
                                                       });
                                                    </script>
                                                    <div class='form-group'>
                                                         <i class="fa fa-user"></i><label for='detailsiswa'>Nama Siswa</label>
                                                        <select name='detailsiswa'  id='detailsiswa-{{$data->id}}' class='form-control' required>
                                                        <option value=''>--- Pilih Nama Siswa ---</option>
                                                            @foreach ($listdata as $datasiswa)
                                                                <option value="{{ $datasiswa->id }}">{{ $datasiswa->nama_siswa }}</option>
                                                            @endforeach
                                                    </select>
                                                    </div>
                                                    <script>
                                                       $(document).ready(function() {
                                                           // $('#semesteredit option[value='II']').prop('selected', true); // Single Select
                                                           $('#detailsiswa-{{ $data->id }}').val(@json($data->detailsiswa_id)).trigger('change'); // Mutiple Select Select value in array json
                                                       });
                                                    </script>

                                                    <div class="form-group mt-2">
                                                        <i class="fas fa-users"></i><label for="kategori">Kategori Lomba {{$data->kategori}}   </label>
                                                        <select name="kategori-{{$data->id}}" id="kategori-{{ $data->id }}" class="form-control" required onchange="toggleInput()">
                                                            <option value="">--- Pilih Kategori Lomba ---</option>
                                                            @foreach ($kategoriLomba as $kategori)
                                                                <option value="{{ $kategori }}">{{ $kategori }}</option>
                                                            @endforeach
                                                            <option value="lainnya">Lainnya</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group" id="kategoriLainnya" style="display: none;">
                                                        <label for="kategori_lainnya">Kategori Lomba (Lainnya)</label>
                                                        <input type="text" name="kategori_lainnya" id="kategori_lainnya" class="form-control"
                                                            placeholder="Masukkan kategori lain">
                                                    </div>
                                                    <script>
                                                       $(document).ready(function() {
                                                           // $('#semesteredit option[value='II']').prop('selected', true); // Single Select
                                                           $('#kategori-{{ $data->id }}').val(@json($data->kategori)).trigger('change'); // Mutiple Select Select value in array json
                                                       });
                                                    </script>
                                                    <script>
                                                        function toggleInput() {
                                                            var kategoriDropdown = document.getElementById("kategori");
                                                            var kategoriLainnya = document.getElementById("kategoriLainnya");
                                                            var kategoriInput = document.getElementById("kategori_lainnya");

                                                            if (kategoriDropdown.value === "lainnya") {
                                                                kategoriLainnya.style.display = "block";
                                                                kategoriInput.required = true;
                                                            } else {
                                                                kategoriLainnya.style.display = "none";
                                                                kategoriInput.required = false;
                                                                kategoriInput.value = "";
                                                            }
                                                        }
                                                    </script>

                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <i class="fas fa-calendar-alt"></i><x-inputallin>date:Tanggal Pelaksanaan:Tanggal pelaksanaan:pelaksanaan:id_pelaksanaan:{{ \Carbon\Carbon::parse($data->tgl_awal)->format('Y-m-d') }}:Required</x-inputallin>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class='form-group mt-2'>
                                                                <i class="fas fa-school"></i><label for='tingkat'>Tingkat Lomba</label>
                                                                <select id='tingkat-{{ $data->id }}' name='tingkat' class='form-control' required>
                                                                    <option value=''>--- Pilih Tingkat Lomba ---</option>
                                                                    @foreach ($tingkatLomba as $newtingkatLomba)
                                                                        <option value='{{ $newtingkatLomba }}'>{{ $newtingkatLomba }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <script>
                                                       $(document).ready(function() {
                                                           // $('#semesteredit option[value='II']').prop('selected', true); // Single Select
                                                           $('#tingkat-{{ $data->id }}').val(@json($data->tingkat)).trigger('change'); // Mutiple Select Select value in array json
                                                       });
                                                    </script>


                                                    <div class='form-group'>
                                                        <i class="fas fa-sticky-note"></i><label for='keterangan'>Keterangan</label>
                                                        <textarea name='keterangan' id='keterangan' rows='3' class='form-control' placeholder='Masukkan Keterangan Singkat'>{{$data->keterangan}}</textarea>
                                                    </div>
                                                    {{-- blade-formatter-enable --}}

                                                    <button id='kirim' type='submit'
                                                        class='btn float-right btn-default bg-primary btn-xl mt-4'>
                                                        Kirim</button>
                                                </form>

                                            </section>
                                        </x-edit-modal>
                                    </div>
                                    {{-- Modal Edit Data Akhir --}}
                                    {{-- Modal View --}}

                                    <div class='modal fade' id='viewModal{{ $data->id }}' tabindex='-1'
                                        aria-labelledby='ViewModalLabel' aria-hidden='true'>


                                        <x-view-modal>
                                            <x-slot:titleviewModal>{{ $titleviewModal }}</x-slot:titleviewModal>
                                            <section>
                                                //Content View
                                            </section>
                                        </x-view-modal>
                                    </div>
                                    {{-- Modal View Akhir --}}
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class='text-center'>
                                    <th width='1%'>ID</th>
                                    @foreach ($arr_ths as $arr_th)
                                        <th class='text-center'> {{ $arr_th }}</th>
                                    @endforeach
                                    {{-- @if ($activecrud === 1) --}}
                                    <th class='text-center'>Action</th>
                                    {{-- @endif --}}
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>


        </div>

    </section>
</x-layout>
{{-- <button class='btn btn-warning btn-sm' onclick='TambahData()'><i class='fa fa-edit right'></i> Edit</button> --}}
{{--
onclick='TambahData()'
 --}}

<script>
    function TambahData(data) {
        var TambahData = new bootstrap.Modal(document.getElementById('TambahData'));
        TambahData.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='TambahData' tabindex='-1' aria-labelledby='LabelTambahData' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelTambahData'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <form id='#id' action='{{ route('prestasi.store') }}' method='POST'>
                    @csrf
                    @method('POST')
                    {{-- blade-formatter-disable --}}
                @php
                    $juaraList = [ 'Juara 1' => 'Juara 1 🥇', 'Juara 2' => 'Juara 2 🥈', 'Juara 3' => 'Juara 3 🥉', 'Harapan 1' => 'Harapan 1 🎖️', 'Harapan 2' => 'Harapan 2 🎖️', 'Harapan 3' => 'Harapan 3 🎖️', 'Terbaik' => 'Terbaik 🌟', 'lainnya' => 'Pilih Lainnya ➕', ];
                    $tingkatLomba = ['Sekolah', 'Kabupaten', 'Provinsi', 'Nasional', 'Internasional'];

                    $kategoriLomba = ['Akademik', 'Non Akademik'];

                @endphp
                <div class="form-group mt-2">
                    🥇 <label for="juara">Juara</label>
                    <select id="juara" name="juara" class="form-control" onchange="toggleInput()">
                        @foreach ($juaraList as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <input type="text" id="lainnyaInput" name="juara_lainnya" class="form-control mt-2" placeholder="Masukkan juara lainnya" style="display: none;">
                <script>
                    function toggleInput() {
                        let dropdown = document.getElementById("juara");
                        let inputField = document.getElementById("lainnyaInput");
                        if (dropdown.value === "lainnya") {
                            inputField.style.display = "block";
                            inputField.required = true;
                        } else {
                            inputField.style.display = "none";
                            inputField.required = false;
                        }
                    }
                </script>
                <x-dropdown-allsiswa type='multiple' :listdata='$listdata' label='Data Siswa' name='detailsiswa_id' id_property='id_single' />
                <div class="form-group mt-2">
                    <i class="fas fa-users"></i><label for="kategori">Kategori Lomba</label>
                    <select name="kategori" id="kategori" class="form-control" required onchange="toggleInput()">
                        <option value="">--- Pilih Kategori Lomba ---</option>
                        @foreach ($kategoriLomba as $kategori)
                            <option value="{{ $kategori }}">{{ $kategori }}</option>
                        @endforeach
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="form-group" id="kategoriLainnya" style="display: none;">
                    <label for="kategori_lainnya">Kategori Lomba (Lainnya)</label>
                    <input type="text" name="kategori_lainnya" id="kategori_lainnya" class="form-control"
                        placeholder="Masukkan kategori lain">
                </div>

                <script>
                    function toggleInput() {
                        var kategoriDropdown = document.getElementById("kategori");
                        var kategoriLainnya = document.getElementById("kategoriLainnya");
                        var kategoriInput = document.getElementById("kategori_lainnya");

                        if (kategoriDropdown.value === "lainnya") {
                            kategoriLainnya.style.display = "block";
                            kategoriInput.required = true;
                        } else {
                            kategoriLainnya.style.display = "none";
                            kategoriInput.required = false;
                            kategoriInput.value = "";
                        }
                    }
                </script>

                <i class="fas fa-calendar-alt"></i><x-inputallin>date:Tanggal Pelaksanaan:Tanggal pelaksanaan:pelaksanaan:id_pelaksanaan:{{ $data->pelaksanaan }}:Required</x-inputallin>
                <div class='form-group mt-2'>
                    <i class="fas fa-school"></i><label for='tingkat'>Tingkat Lomba</label>
                    <select name='tingkat' class='form-control' required>
                        <option value=''>--- Pilih Tingkat Lomba ---</option>
                        @foreach ($tingkatLomba as $newtingkatLomba)
                            <option value='{{ $newtingkatLomba }}'>{{ $newtingkatLomba }}</option>
                        @endforeach
                    </select>
                </div>

                <div class='form-group'>
                    <i class="fas fa-sticky-note"></i><label for='keterangan'>Keterangan</label>
                    <textarea name='keterangan' id='keterangan' rows='3' class='form-control' placeholder='Masukkan Keterangan Singkat'></textarea>
                </div>
                {{-- blade-formatter-enable --}}

                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>
