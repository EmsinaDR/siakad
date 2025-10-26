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

                <div class='col-xl-2'>
                    <input type="hidden" name="format_kode" id="input_format_kode">
                    <!-- Input hidden untuk format kode -->

                    {{-- blade-formatter-disable --}}
                    <button type="button" id="btn-submit" class="btn btn-block btn-default bg-primary btn-md" data-toggle="modal" data-target="#formatKodeModal"> <i class="fa fa-plus"></i> Tambah Data </button>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='UbahRuangan()'> <i class='fa fa-plus'></i> Ubah Ruang Test  </button>
                   <form id="hapusForm" action="{{ route('hapus-semua-nilai-ujian.destroy') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger" onclick="confirmDelete()">Hapus Semua</button>
                    </form>


                    {{-- blade-formatter-enable --}}
                </div>

                <!-- Modal untuk Input Format Kode -->
                <div class="modal fade" id="formatKodeModal" tabindex="-1" aria-labelledby="formatKodeModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="formatKodeModalLabel">Masukkan Format Kode</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="id-form" action="{{ route('data-peserta-ujian.store') }}" method="POST">
                                    @csrf
                                    <strong>Contoh Format Kode:</strong>
                                    <code>2-18-20-09-110-001-4</code>
                                    <br><br>
                                    <ul style="text-align: left; font-size: 14px;">
                                        <li><strong>2</strong> : Jenjang SMP</li>
                                        <li><strong>XX</strong> : Tahun Lulus (Otomatis)</li>
                                        <li><strong>20</strong> : Kode Provinsi</li>
                                        <li><strong>09</strong> : Kode Kabupaten</li>
                                        <li><strong>110</strong> : Kode Sekolah</li>
                                        <li><strong id="auto-number">001</strong> : Nomor Urut Siswa</li>
                                        <li><strong>4</strong> : Digit Nomor Siswa</li>
                                    </ul>

                                    {{-- blade-formatter-disable --}}
                    <div class="form-group">
                        <label>Jenjang</label>
                        <input type="number" name="jenjang" id="jenjang" class="form-control" placeholder="Jenjang (ex: 2)" value='2' required>
                    </div>

                    <div class="form-group">
                        <label>Kode Provinsi</label>
                        <input type="number" name="kode_provinsi" id="kode_provinsi" class="form-control" placeholder="Kode Provinsi (ex: 20)" value='20' required>
                    </div>
                    <div class="form-group">
                        <label>Kode Kabupaten</label>
                        <input type="number" name="kode_kabupaten" id="kode_kabupaten" class="form-control" placeholder="Kode Kabupaten (ex: 09)" value='09' required>
                    </div>
                    <div class="form-group">
                        <label>Kode Sekolah</label>
                        <input type="number" name="kode_sekolah" id="kode_sekolah" class="form-control" placeholder="Kode Sekolah (ex: 110)" value='110' required>
                    </div>
                    <div class="form-group">
                        <label>Nomor Urut</label>
                        <input type="text" name="nomor_urut" id="nomor_urut" class="form-control" placeholder="Nomor Urut (ex: 001)" required readonly>
                    </div>
                    <div class="form-group">
                        <label>Digit Siswa</label>
                        <input type="number" name="digit_siswa" id="digit_siswa" class="form-control" placeholder="Digit Siswa (2-9)" value='2' required>
                    </div>
                    {{-- blade-formatter-enable --}}
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary" id="simpanKode">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    document.getElementById("simpanKode").addEventListener("click", function() {
                        const jenjang = document.getElementById("jenjang").value.trim();
                        const tahunLulus = new Date().getFullYear().toString().slice(-2); // Ambil 2 digit terakhir tahun ini
                        const kodeProvinsi = document.getElementById("kode_provinsi").value.trim();
                        const kodeKabupaten = document.getElementById("kode_kabupaten").value.trim();
                        const kodeSekolah = document.getElementById("kode_sekolah").value.trim();
                        const digitSiswa = document.getElementById("digit_siswa").value.trim();

                        if (!jenjang || !kodeProvinsi || !kodeKabupaten || !kodeSekolah || !digitSiswa) {
                            alert("Semua kolom harus diisi!");
                            return;
                        }

                        let formatKode =
                            `${jenjang}-${tahunLulus}-${kodeProvinsi}-${kodeKabupaten}-${kodeSekolah}-XXX-${digitSiswa}`;
                        document.getElementById("input_format_kode").value = formatKode; // Set input hidden

                        // Tutup modal dan submit form
                        $("#formatKodeModal").modal("hide");
                        document.getElementById("id-form").submit();
                    });
                </script>


                <div class='col-xl-10'></div>
            </div>


            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>Peserta Ujian</h3>
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
                                        <td class='text-center'> {{ $data->nomor_ujian }}</td>
                                        <td class='text-center'> {{ $data->nomor_ruangan }}</td>
                                        <td class='text-center'> {{ $data->Siswa->nama_siswa }}</td>

                                        <td width='10%'>
                                            <div class='gap-1 d-flex justify-content-center'>
                                                <!-- Button untuk mengedit -->
                                                <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                                    data-toggle='modal' data-target='#editModal{{ $data->id }}'><i
                                                        class='fa fa-edit'></i> </button>
                                                <!-- Form untuk menghapus -->
                                                <form id='delete-form-{{ $data->id }}'
                                                    action='{{ route('data-peserta-ujian.destroy', $data->id) }}'
                                                    method='POST' style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type='button' class='btn btn-danger btn-sm btn-equal-width'
                                                    onclick='confirmDelete({{ $data->id }})'> <i
                                                        class='fa fa-trash'></i> </button>
                                            </div>
                                            {{-- Modal View Data Akhir --}}

                                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                                aria-labelledby='EditModalLabel' aria-hidden='true'>

                                                <x-edit-modal>
                                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                    <section>
                                                        <form id='updateurl'
                                                            action='{{ route('data-peserta-ujian.update', $data->id) }}'
                                                            method='POST'>
                                                            @csrf
                                                            @method('PATCH')

                                                            contentEdit

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
                                        </td>
                                    </tr>
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
{{-- <button class='btn btn-warning btn-sm' onclick='UbahRuangan()'><i class='fa fa-edit right'></i> Edit</button> --}}
{{--
onclick='UbahRuangan()'
 --}}

<script>
    function UbahRuangan(data) {
        var UbahRuangan = new bootstrap.Modal(document.getElementById('UbahRuangan'));
        UbahRuangan.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='UbahRuangan' tabindex='-1' aria-labelledby='LabelUbahRuangan' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelUbahRuangan'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <form id="id-form"
                    action="{{ route('data-peserta-ujian.update', ['data_peserta_ujian' => 'batch']) }}"
                    method="POST">

                    @csrf
                    @method('PUT')
                    <div class='form-group'>
                        @php
                            $etapels = \App\Models\Admin\Etapel::where('aktiv', 'Y')->first();
                            $siswas = App\Models\WakaKurikulum\Elearning\Nilai\KurulumDataPesertaUjian::With('Kelas')
                                ->where('tapel_id', $etapels->id)
                                ->OrderBy('kelas_id', 'ASC')
                                ->OrderBy('nama_siswa', 'ASC')
                                ->get();
                        @endphp
                        <i class='fa fa-user mr-2'></i><label for='detailsiswa_id'>Nama Siswa</label>
                        <select name='detailsiswa_id[]' id='select2-1' class='form-control' multiple='multiple'
                            data-placeholder='Pilih Siswa' required>
                            @foreach ($siswas as $siswa)
                                <option value='{{ $siswa->id }}'>{{ $siswa->Kelas->kelas }} -
                                    {{ $siswa->Siswa->nama_siswa }}</option>
                            @endforeach
                        </select>
                    </div>
                    @php
                        $nomore = range(1, 50);
                    @endphp
                    <div class='form-group'>
                        <label for='nomor_ruangan'>Nomor Ruang</label>
                        <select name='nomor_ruangan' class='form-control' required>
                            <option value=''>--- Pilih Nomor Ruang ---</option>
                            @foreach ($nomore as $newkey)
                                <option value='{{ $newkey }}'>{{ $newkey }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>
