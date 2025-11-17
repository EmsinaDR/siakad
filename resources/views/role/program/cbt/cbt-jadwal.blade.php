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
                        <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#TambahData'><i class='fa fa-plus'></i> Tambah Data</button>
                   </div>
                   <div class='col-xl-10'></div>
               </div>
               <div class="row p-2">
                <div class="col-xl-12">
{{-- <x-inputallin>readonly:Nama Dokumen::::{{$DataPPKS->nama_dokumen}}:readonly</x-inputallin> --}}
                </div>
               </div>
               {{-- blade-formatter-enable --}}


            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
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
                                        <td class='text-center'> {{ $data->nama_test }}</td>
                                        <td class='text-center'> {{ $data->Kelas->kelas }}</td>
                                        <td class='text-center'> {{ $data->Guru->nama_guru }}</td>
                                        <td class='text-center'> {{ $data->Mapel->mapel }}</td>

                                        <td width='10%'>
                                            {{-- blade-formatter-disable --}}
                                            <div class='gap-1 d-flex justify-content-center'>
                                                <a href="{{route('test-cbt.index')}}/{{$data->id}}"><button type='submit' class='btn btn-primary btn-sm btn-equal-width'><i class='fa fa-eye'></i> </button></a>
                                                <a href="{{route('hasil-test.index')}}/{{$data->id}}"><button type='submit' class='btn btn-success btn-sm btn-equal-width'><i class="fas fa-sticky-note"></i> </button></a>
                                                <!-- Button untuk mengedit -->
                                                <form action="{{ url('cbt/test-cbt-mulai') }}" method="POST">
    @csrf <!-- CSRF Protection -->
    <!-- Input ID yang akan dikirimkan -->
    <input type="hidden" name="id" id="id" value="{{ $data->id }}" required>
    <!-- Tombol Submit -->
    <button type='submit' class='btn btn-primary btn-sm btn-equal-width'><i class='fa fa-eye'></i> </button>
</form>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector("form");  // Pilih form yang ada
        const submitButton = form.querySelector("button[type='submit']");

        // Mengecek apakah form sudah disubmit sebelumnya menggunakan sessionStorage
        if (sessionStorage.getItem("formSubmitted") === "true") {
            submitButton.disabled = true;  // Nonaktifkan tombol submit jika form sudah disubmit
        }

        form.addEventListener("submit", function() {
            // Tandai bahwa form telah disubmit dengan menyimpan status di sessionStorage
            sessionStorage.setItem("formSubmitted", "true");
        });

        // Mencegah pop-up konfirmasi saat halaman di-refresh atau meninggalkan halaman
        window.addEventListener("beforeunload", function(event) {
            if (sessionStorage.getItem("formSubmitted") === "true") {
                // Jangan tampilkan pop-up konfirmasi saat form sudah disubmit
                event.returnValue = ''; // Ini akan mencegah pop-up
            }
        });
    });
</script>

                                                <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i> </button>
                                                <!-- Form untuk menghapus -->
                                                <form id='delete-form-{{ $data->id }}'
                                                    action='{{ route('data-test.destroy', $data->id) }}' method='POST'
                                                    style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type='button' class='btn btn-danger btn-sm btn-equal-width'
                                                    onclick='confirmDelete({{ $data->id }})'> <i
                                                        class='fa fa-trash'></i> </button>
                                            </div>
                                            {{-- blade-formatter-enable --}}
                                            {{-- Modal View Data Akhir --}}

                                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                                aria-labelledby='EditModalLabel' aria-hidden='true'>

                                                <x-edit-modal>
                                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                    <section>
                                                        <form id='updateurl'
                                                            action='{{ route('data-test.update', $data->id) }}'
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

                <form id='TambahData-form' action='{{ route('data-test.store') }}' method='POST'>
                    @csrf
                    @method('POST')
                    <!-- Nama Test -->
                    <div class="mb-3">
                        <label for="nama_test" class="form-label">Nama Test</label>
                        <input type="text" class="form-control" id="nama_test" name="nama_test" required>
                    </div>
                    <!-- Mapel -->
                    <div class="mb-3">
                        <label for="mapel_id" class="form-label">Mata Pelajaran</label>
                        <select class="select2 form-select" id="mapel_id" name="mapel_id" required>
                            <option value="">-- Pilih Mapel --</option>
                            @foreach ($Mapels as $m)
                                <option value="{{ $m->id }}">{{ $m->mapel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Kelas -->
                    <div class="mb-3">
                        <label for="kelas_id" class="form-label">Kelas</label>
                        <select class="select2 form-select" id="kelas_id" name="kelas_id" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($Kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Soal -->
                   <div class="mb-3">
    <label for="soal_id" class="form-label">Soal</label>
    <select class="select2 form-select" id="soal_id" name="soal_id[]" multiple required>
        <option value="">-- Pilih Soal --</option>
    </select>
</div>

                    <script>
                        $(document).ready(function() {
                            function loadSoal() {
                                let mapelID = $('#mapel_id').val();
                                let kelasID = $('#kelas_id').val();
                                let soalSelect = $('#soal_id');

                                // Kalau salah satu belum dipilih, jangan lanjut
                                if (!mapelID || !kelasID) {
                                    soalSelect.prop('disabled', true)
                                        .html('<option value="">-- Pilih Mapel & Kelas Dulu --</option>');
                                    return;
                                }

                                soalSelect.prop('disabled', true).html('<option>Memuat...</option>');
                                $.ajax({
                                    url: "{{ url('get-soal') }}/" + mapelID + "/" + kelasID,
                                    type: "GET",
                                    success: function(data) {
                                        soalSelect.empty();

                                        if (data.length > 0) {
                                            soalSelect.append('<option value="">-- Pilih Soal --</option>');
                                            $.each(data, function(i, s) {
                                                // Gabungkan indikator + soal
                                                let text = s.indikator + ' — ' + s.soal;
                                                // Biar dropdown gak kepanjangan, potong soal kalau terlalu panjang
                                                if (text.length > 120) text = text.substring(0, 117) + '...';

                                                soalSelect.append('<option value="' + s.id + '">' + text +
                                                    '</option>');
                                            });
                                            soalSelect.prop('disabled', false);
                                        } else {
                                            soalSelect.html(
                                                '<option value="">Tidak ada soal untuk kombinasi ini</option>');
                                        }
                                    },
                                    error: function() {
                                        soalSelect.html('<option value="">Gagal memuat soal</option>');
                                    }
                                });

                            }

                            $('#mapel_id, #kelas_id').on('change', loadSoal);
                        });
                    </script>


                    <div class='row'>

                        <!-- Waktu -->
                        <div class="col-xl-6 mb-3">
                            <label for="waktu" class="form-label">Waktu Ujian (menit)</label>
                            <select class="select2 form-select" id="waktu" name="waktu" required>
                                <option value="30">30</option>
                                <option value="45">45</option>
                                <option value="60">60</option>
                                <option value="90">90</option>
                                <option value="120">120</option>
                            </select>
                        </div>

                        <!-- Tanggal Pelaksanaan -->
                        <div class="col-xl-6 mb-3">
                            <label for="tanggal_pelaksanaan" class="form-label">Tanggal Pelaksanaan</label>
                            <input type="date" class="form-control" id="tanggal_pelaksanaan"
                                name="tanggal_pelaksanaan" required>
                        </div>
                    </div>

                    <!-- Guru -->
                    <div class="mb-3">
                        <label for="detailguru_id" class="form-label">Guru</label>
                        <select class="select2 form-select" id="detailguru_id" name="detailguru_id" required>
                            @foreach ($Gurus as $g)
                                <option value="{{ $g->id }}">{{ $g->nama_guru }}</option>
                            @endforeach
                        </select>
                    </div>

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
