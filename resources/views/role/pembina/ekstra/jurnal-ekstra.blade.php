@php
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
            <div class='container-fluid'>
                <div class='row'>
                    <div class='col'>
                        <!-- Papan Informasi  -->
                        <div class='row mx-2'>
                            <div class='col-lg-4 col-6'>
                                <!-- small box / Data BOX-->
                                <div class='small-box bg-info'><!-- Background -->
                                    <h3 class='m-2'>Materi Ekstra</h3><!-- Judul -->
                                    <div class='inner'><!-- Isi Kontent -->
                                        <div class='d-flex justify-content-between'>
                                            <span>Jumlah Materi Pokok</span><span>{{ $materiEkstra->count() }}</span>
                                        </div>
                                        <div class='d-flex justify-content-between'>
                                            <span>Jumlah Sub Materi</span><span>{{ $materiEkstra_sub->count() }}</span>
                                        </div>
                                        <div class='d-flex justify-content-between'>
                                            <span>Indikator
                                                Selesai</span><span>{{ $materiEkstra_indikator->count() }}</span>
                                        </div>
                                    </div>
                                    <div class='icon'>
                                        <i class='fa fa-wallet'></i><!-- Icon -->
                                    </div>
                                    <a href='#' class='small-box-footer'>More info <i
                                            class='fas fa-arrow-circle-right'></i></a>
                                </div>
                                <!-- small box -->
                            </div>
                            <!-- ./col -->
                            <div class='col-lg-4 col-6'>
                                <!-- small box / Data BOX-->
                                <div class='small-box bg-warning'><!-- Background -->
                                    <h3 class='m-2'>Data Ekstra</h3><!-- Judul -->
                                    <div class='inner'><!-- Isi Kontent -->
                                        <div class='d-flex justify-content-between'>
                                            <span>Pembina</span><span>{{ $Ekstra_name->Detailguru->nama_guru }}</span>
                                        </div>
                                        <div class='d-flex justify-content-between'>
                                            <span>Pelatih</span><span>{{ $Ekstra_name->pelatih }}</span>
                                        </div>
                                        <div class='d-flex justify-content-between'>
                                            <span>Jadwal</span><span>{{ $Ekstra_name->jadwal }}</span>
                                        </div>
                                    </div>
                                    <div class='icon'>
                                        <i class='fa fa-user-cog'></i><!-- Icon -->
                                    </div>
                                    <a href='#' class='small-box-footer'>More info <i
                                            class='fas fa-arrow-circle-right'></i></a>
                                </div>
                                <!-- small box -->
                            </div>
                            <!-- ./col -->
                            <div class='col-lg-4 col-6'>
                                <!-- small box / Data BOX-->
                                <div class='small-box bg-success'><!-- Background -->
                                    <h3 class='m-2'>Data Pengurus</h3><!-- Judul -->
                                    <div class='inner'><!-- Isi Kontent -->
                                        <div class='d-flex justify-content-between'>
                                            <span>Ketua Ekstra</span><span>-</span>
                                        </div>
                                        <div class='d-flex justify-content-between'>
                                            <span>Wakil</span><span>-</span>
                                        </div>
                                        <div class='d-flex justify-content-between'>
                                            <span>Bendahara</span><span>-</span>
                                        </div>
                                    </div>
                                    <div class='icon'>
                                        <i class='fa fa-user-cog'></i><!-- Icon -->
                                    </div>
                                    <a href='#' class='small-box-footer'>More info <i
                                            class='fas fa-arrow-circle-right'></i></a>
                                </div>
                                <!-- small box -->
                            </div>
                            <!-- ./col -->
                        </div>
                        <!-- Papan Informasi  -->
                        {{-- <x-footer></x-footer> --}}


                    </div>
                </div>
            </div>
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}
                    <b>{{ optional($Ekstra_name?->Ekstra)->ekstra ?? 'Ekstra tidak tersedia' }}</b>
                </h3>
            </div>
            <!--Car Header-->


            <div class='ml-2 my-4'>
                <div class="row mt-2">
                    <div class="col-xl-3">
                        <div class="col-xl-12">
                            <div class='alert alert-info alert-dismissible'>
                                <button type='button' class='close' data-dismiss='alert'
                                    aria-hidden='true'>&times;</button>
                                <h5><i class='icon fas fa-info'></i> Information !</h5>
                                <hr>
                                Jangan lupa isi absensi di menu absen
                            </div>
                        </div>
                        <form id='#id' action='{{ route('jurnal-ekstra.store') }}' method='POST'>
                            @csrf
                            @method('POST')
                            <input type='hidden' name='ekstra_id' id='ekstra_id' placeholder='ekstra_id'
                                value='{{ request()->segment(3) }}'>

                            <div class='card-header bg-primary mb-4'>
                                <h3 class='card-title'>
                                    Input Jurnal Latiah Ekstra</h3>
                            </div>
                            <!-- Dropdown Materi Ekstra -->
                            <div class="form-group">
                                <label for="id_materi">Materi Ekstra</label>
                                <select name="materi" id="id_materi" class="form-control" required>
                                    <option value="">--- Pilih Materi Ekstra ---</option>
                                    @foreach ($materiEkstra as $m)
                                        <option value="{{ $m->materi }}">{{ $m->materi }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Dropdown Sub Materi -->
                            <div class="form-group">
                                <label for="id_sub_materi">Sub Materi</label>
                                <select name="sub_materi" id="id_sub_materi" class="form-control" required>
                                    <option value="">--- Pilih Sub Materi ---</option>
                                </select>
                            </div>

                            <!-- Dropdown Indikator Materi -->
                            <div class="form-group">
                                <label for="indikator_id">Indikator Materi</label>
                                <select name="indikator_id" id="indikator_id" class="form-control" required>
                                    <option value="">--- Pilih Indikator Materi ---</option>
                                </select>
                            </div>

                            <script>
                                $(document).ready(function() {
                                    // Memuat data Materi Ekstra saat halaman dimuat
                                    $.ajax({
                                        url: '/ekstrakurikuler/get-materi', // URL untuk mengambil data Materi Ekstra
                                        method: 'GET',
                                        success: function(data) {
                                            $('#id_materi').empty(); // Bersihkan dropdown
                                            $('#id_materi').append(
                                                '<option value="">--- Pilih Materi Ekstra ---</option>'); // Pilihan default
                                            data.forEach(function(materi) {
                                                $('#id_materi').append('<option value="' + materi.materi + '">' + materi
                                                    .materi + '</option>');
                                            });
                                        }
                                    });

                                    // Ketika Materi Ekstra dipilih, memuat Sub Materi terkait
                                    $('#id_materi').change(function() {
                                        var materi = $(this).val(); // Dapatkan nama materi
                                        if (materi) {
                                            $.ajax({
                                                url: '/ekstrakurikuler/get-sub-materi/' +
                                                    materi, // Ganti ID dengan nama materi
                                                method: 'GET',
                                                success: function(data) {
                                                    $('#id_sub_materi').empty(); // Bersihkan dropdown
                                                    $('#id_sub_materi').append(
                                                        '<option value="">--- Pilih Sub Materi ---</option>'
                                                    ); // Pilihan default
                                                    data.forEach(function(sub_materi) {
                                                        $('#id_sub_materi').append('<option value="' +
                                                            sub_materi.sub_materi + '">' + sub_materi
                                                            .sub_materi + '</option>');
                                                    });
                                                }
                                            });
                                        } else {
                                            $('#id_sub_materi').empty(); // Bersihkan dropdown
                                            $('#id_sub_materi').append(
                                                '<option value="">--- Pilih Sub Materi ---</option>'); // Pilihan default
                                            $('#indikator_id').empty(); // Bersihkan dropdown indikator
                                            $('#indikator_id').append(
                                                '<option value="">--- Pilih Indikator Materi ---</option>'); // Pilihan default
                                        }
                                    });

                                    // Ketika Sub Materi dipilih, memuat Indikator Materi terkait
                                    $('#id_sub_materi').change(function() {
                                        var subMateri = $(this).val(); // Dapatkan nama sub materi
                                        if (subMateri) {
                                            $.ajax({
                                                url: '/ekstrakurikuler/get-indikator-materi/' +
                                                    subMateri, // Ganti ID dengan nama sub materi
                                                method: 'GET',
                                                success: function(data) {
                                                    $('#indikator_id').empty(); // Bersihkan dropdown
                                                    $('#indikator_id').append(
                                                        '<option value="">--- Pilih Indikator Materi ---</option>' // Pilihan default
                                                    );

                                                    data.forEach(function(indikator) {
                                                        // Menggunakan indikator.id sebagai value dan indikator.indikator sebagai teks
                                                        $('#indikator_id').append(
                                                            '<option value="' + indikator.id + '">' +
                                                            indikator.indikator + '</option>'
                                                        );
                                                    });

                                                }
                                            });
                                        } else {
                                            $('#indikator_id').empty(); // Bersihkan dropdown
                                            $('#indikator_id').append(
                                                '<option value="">--- Pilih Indikator Materi ---</option>'); // Pilihan default
                                        }
                                    });
                                });
                            </script>

                            <button type='submit' class='btn btn-block btn-default bg-primary btn-md'>Save</button>
                        </form>

                    </div>
                    <div class="col-xl-9">
                        <div class='card-header bg-primary mb-4'>
                            <h3 class='card-title'>Riwayat Materi Ekstra</h3>
                        </div>
                        <table id='example1' width='100%'
                            class='table table-responsive table-bordered table-hover mt-2'>
                            <thead>
                                <tr class='text-center table-primary'>
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
                                            {{ Carbon::create($data->tanggal_latihan)->translatedformat('l, d F Y') }}
                                        </td>
                                        <td class='text-center'> {{ $data->MateriEkstra->materi }}</td>
                                        <td class='text-center'> {{ $data->MateriEkstra->indikator }}</td>

                                        <td width='20%'>
                                            <div class='gap-1 d-flex justify-content-center'>

                                                <!-- Button untuk melihat -->
                                                <!-- <button type='button' class='btn btn-success btn-sm btn-equal-width' data-toggle='modal' data-target='#viewModal{{ $data->id }}'><i class='fa fa-eye'></i> Lihat</button> -->
                                                <!-- Button untuk mengedit -->
                                                <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                                    data-toggle='modal'
                                                    data-target='#editModal{{ $data->id }}'><i
                                                        class='fa fa-edit'></i> Edit</button>
                                                <!-- Form untuk menghapus -->
                                                {{-- blade-formatter-disable --}}
                                                <form id='delete-form-{{ $data->id }}' action='{{ route('jurnal-ekstra.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                {{-- blade-formatter-enable --}}
                                                <button type='button' class='btn btn-danger btn-sm btn-equal-width'
                                                    onclick='confirmDelete({{ $data->id }})'> <i
                                                        class='fa fa-trash'></i> Hapus </button>

                                            </div>
                                        </td>
                                    </tr>
                                    {{-- Modal View Data Akhir --}}

                                    <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                        aria-labelledby='EditModalLabel' aria-hidden='true'>

                                        <x-edit-modal>
                                            <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                            <section>
                                                <form id='updateurl'
                                                    action='{{ route('jurnal-ekstra.update', $data->id) }}'
                                                    method='POST'>
                                                    @csrf
                                                    @method('PATCH')
                                                    <!-- Dropdown Materi Ekstra -->
                                                    <div class="form-group">
                                                        <label for="id_materi_edit{{ $data->id }}">Materi
                                                            Ekstra</label>
                                                        <select name="materi" id="id_materi_edit{{ $data->id }}"
                                                            class="form-control" required>
                                                            <option value="">--- Pilih Materi Ekstra ---</option>
                                                            @foreach ($materiEkstra as $m)
                                                                <option value="{{ $m->materi }}">
                                                                    {{ $m->materi }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- Dropdown Sub Materi -->
                                                    <div class="form-group">
                                                        <label for="id_sub_materi_edit">Sub Materi</label>
                                                        <select name="sub_materi"
                                                            id="id_sub_materi_edit{{ $data->id }}"
                                                            class="form-control" required>
                                                            <option value="">--- Pilih Sub Materi ---</option>
                                                        </select>
                                                    </div>

                                                    <!-- Dropdown Indikator Materi -->
                                                    <div class="form-group">
                                                        <label for="indikator_id_edit">Indikator Materi</label>
                                                        <select name="indikator_id"
                                                            id="indikator_id_edit{{ $data->id }}"
                                                            class="form-control" required>
                                                            <option value="">--- Pilih Indikator Materi ---
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <x-inputallin>date:Tanggal Latihan:Tanggal
                                                        latihan:tanggal_latihan:id_tanggal_latihan:{{ $data->tanggal_latihan }}:Required</x-inputallin>

                                                    <script>
                                                        $(document).ready(function() {
                                                            // Memuat data Materi Ekstra saat halaman dimuat
                                                            $.ajax({
                                                                url: '/ekstrakurikuler/get-materi', // URL untuk mengambil data Materi Ekstra
                                                                method: 'GET',
                                                                success: function(data) {
                                                                    $('#id_materi_edit{{ $data->id }}').empty(); // Bersihkan dropdown
                                                                    $('#id_materi_edit{{ $data->id }}').append(
                                                                        '<option value="">--- Pilih Materi Ekstra ---</option>'); // Pilihan default
                                                                    data.forEach(function(materi) {
                                                                        $('#id_materi_edit{{ $data->id }}').append('<option value="' +
                                                                            materi.materi + '">' +
                                                                            materi
                                                                            .materi + '</option>');
                                                                    });
                                                                }
                                                            });

                                                            // Ketika Materi Ekstra dipilih, memuat Sub Materi terkait
                                                            $('#id_materi_edit{{ $data->id }}').change(function() {
                                                                var materi = $(this).val(); // Dapatkan nama materi
                                                                if (materi) {
                                                                    $.ajax({
                                                                        url: '/ekstrakurikuler/get-sub-materi/' +
                                                                            materi, // Ganti ID dengan nama materi
                                                                        method: 'GET',
                                                                        success: function(data) {
                                                                            $('#id_sub_materi_edit{{ $data->id }}')
                                                                        .empty(); // Bersihkan dropdown
                                                                            $('#id_sub_materi_edit{{ $data->id }}').append(
                                                                                '<option value="">--- Pilih Sub Materi ---</option>'
                                                                            ); // Pilihan default
                                                                            data.forEach(function(sub_materi) {
                                                                                $('#id_sub_materi_edit{{ $data->id }}').append(
                                                                                    '<option value="' +
                                                                                    sub_materi.sub_materi + '">' + sub_materi
                                                                                    .sub_materi + '</option>');
                                                                            });
                                                                        }
                                                                    });
                                                                } else {
                                                                    $('#id_sub_materi_edit{{ $data->id }}').empty(); // Bersihkan dropdown
                                                                    $('#id_sub_materi_edit{{ $data->id }}').append(
                                                                        '<option value="">--- Pilih Sub Materi ---</option>'); // Pilihan default
                                                                    $('#indikator_id_edit{{ $data->id }}').empty(); // Bersihkan dropdown indikator
                                                                    $('#indikator_id_edit{{ $data->id }}').append(
                                                                        '<option value="">--- Pilih Indikator Materi ---</option>'); // Pilihan default
                                                                }
                                                            });

                                                            // Ketika Sub Materi dipilih, memuat Indikator Materi terkait
                                                            $('#id_sub_materi_edit{{ $data->id }}').change(function() {
                                                                var subMateri = $(this).val(); // Dapatkan nama sub materi
                                                                if (subMateri) {
                                                                    $.ajax({
                                                                        url: '/ekstrakurikuler/get-indikator-materi/' +
                                                                            subMateri, // Ganti ID dengan nama sub materi
                                                                        method: 'GET',
                                                                        success: function(data) {
                                                                            $('#indikator_id_edit{{ $data->id }}')
                                                                        .empty(); // Bersihkan dropdown
                                                                            $('#indikator_id_edit{{ $data->id }}').append(
                                                                                '<option value="">--- Pilih Indikator Materi ---</option>' // Pilihan default
                                                                            );

                                                                            data.forEach(function(indikator) {
                                                                                // Menggunakan indikator.id sebagai value dan indikator.indikator sebagai teks
                                                                                $('#indikator_id_edit{{ $data->id }}').append(
                                                                                    '<option value="' + indikator.id + '">' +
                                                                                    indikator.indikator + '</option>'
                                                                                );
                                                                            });

                                                                        }
                                                                    });
                                                                } else {
                                                                    $('#indikator_id_edit{{ $data->id }}').empty(); // Bersihkan dropdown
                                                                    $('#indikator_id_edit{{ $data->id }}').append(
                                                                        '<option value="">--- Pilih Indikator Materi ---</option>'); // Pilihan default
                                                                }
                                                            });
                                                        });
                                                    </script>

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

<button class='btn btn-warning btn-sm' onclick='FNnamaModal()'><i class='fa fa-edit right'></i> Edit</button>

<script>
    function namaModal(data) {
        var namaModal = new bootstrap.Modal(document.getElementById('namaModal'));
        namaModal.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='namaModal' tabindex='-1' aria-labelledby='LabelnamaModal' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelnamaModal'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                content

            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
            </div>
        </div>
    </div>

</div>
