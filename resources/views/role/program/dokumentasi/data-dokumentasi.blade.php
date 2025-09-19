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
                       <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'> <i class='fa fa-plus'></i> Tambah Data</button>
                   </div>
                   <div class='col-xl-10'></div>
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
                                <tr class='table-primary text-center align-middle'>
                                    <th class='table-primary text-center align-middle' width='1%'>ID</th>
                                    @foreach ($arr_ths as $arr_th)
                                        <th class='table-primary text-center align-middle'> {{ $arr_th }}</th>
                                    @endforeach
                                    <th class='table-primary text-center align-middle'>Action</th>
                                    {{-- @if ($activecrud === 1)
                                                {{-- @endif --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        <td class='text-center'>{{ $loop->iteration }}</td>
                                        <td class='text-center'>
                                            {{ Carbon::create($data->tanggal_pelaksanaan)->translatedformat('l, d F Y') }}
                                        </td>
                                        <td class='text-center'> {{ $data->nama_kegiatan }}</td>
                                        <td class='text-center'>
                                            {{ is_null($data->foto) ? 0 : count(json_decode($data->foto, true)) }} </td>
                                        <td class='text-left'> {{ $data->keterangan }}</td>

                                        <td width='10%'>
                                            @if ($data->detailguru_id !== Auth::user()->id)
                                            @else
                                                {{-- blade-formatter-disable --}}
                                                <div class='gap-1 d-flex justify-content-center'>
                                                    <!-- Button untuk mengedit -->
                                                    {{-- <a href="{{route('data-dokumentasi.show', $data->id)}}"><button type='button' class='btn btn-success btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-eye'></i> </button></a> --}}
                                                    <button type='button' class='btn btn-success btn-sm btn-equal-width' data-toggle='modal' data-target='#viewModal{{ $data->id }}'><i class='fa fa-eye'></i> </button>
                                                    <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i> </button>
                                                    <!-- Form untuk menghapus -->
                                                    <form id='delete-form-{{ $data->id }}' action='{{ route('data-dokumentasi.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i> </button>
                                                </div>
                                                {{-- blade-formatter-enable --}}
                                                {{-- Modal View Data Akhir --}}

                                                <div class='modal fade' id='editModal{{ $data->id }}'
                                                    tabindex='-1' aria-labelledby='EditModalLabel' aria-hidden='true'>

                                                    <x-edit-modal>
                                                        <x-slot:titleeditModal><i
                                                                class="fas fa-edit mr-2"></i>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                        <section>
                                                            <form
                                                                action="{{ route('data-dokumentasi.update', $data->id) }}"
                                                                method="POST" enctype="multipart/form-data">

                                                                {{-- blade-formatter-disable --}}
                                                                    <div class="card shadow-lg p-4 rounded-3">
                                                                           <form action="{{ route('dokumentasi.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                                                                               @csrf
                                                                               @method('PUT')
                                                                               {{-- Tanggal Pelaksanaan --}}
                                                                               <div class="mb-3">
                                                                                   <label for="tanggal_pelaksanaan" class="form-label fw-bold"><i class="fas fa-calendar-day"></i> Tanggal Pelaksanaan</label>
                                                                                   <input type="date" class="form-control border-primary" id="tanggal_pelaksanaan" name="tanggal_pelaksanaan"
                                                                                       value="{{ old('tanggal_pelaksanaan', $data->tanggal_pelaksanaan) }}" required>
                                                                               </div>
                                                                               {{-- Nama Kegiatan --}}
                                                                               <div class="mb-3">
                                                                                   <label for="nama_kegiatan" class="form-label fw-bold"><i class="fas fa-tasks"></i> Nama Kegiatan</label>
                                                                                   <input type="text" class="form-control border-primary" id="nama_kegiatan" name="nama_kegiatan"
                                                                                       placeholder="Masukkan Nama Kegiatan"
                                                                                       value="{{ old('nama_kegiatan', $data->nama_kegiatan) }}" required>
                                                                               </div>
                                                                               {{-- Foto Kegiatan --}}
                                                                               <div class="mb-3">
                                                                                   <label for="foto" class="form-label fw-bold"><i class="fas fa-image"></i> Foto Kegiatan</label>
                                                                                   <input type="file" class="form-control border-primary" id="foto" name="foto[]" multiple>
                                                                                   <small class="text-muted">Unggah hingga beberapa gambar (JPG, PNG, GIF, max 2MB)</small>
                                                                                   {{-- **📌 TAMPILKAN FOTO LAMA** --}}
                                                                                   @if (!empty($data->foto))
                                                                                       <div class="mt-2">
                                                                                           @foreach (json_decode($data->foto, true) as $foto)
                                                                                               <div class="d-inline-block position-relative me-2">
                                                                                                   <img src="{{ asset('img/foto-kegiatan/' . $foto) }}" alt="Foto Kegiatan" class="img-thumbnail" width="100">
                                                                                                   <input type="checkbox" name="hapus_foto[]" value="{{ $foto }}" class="position-absolute top-0 end-0">
                                                                                               </div>
                                                                                           @endforeach
                                                                                       </div>
                                                                                       <small class="text-muted">Centang untuk menghapus foto saat update</small>
                                                                                   @endif
                                                                               </div>
                                                                               {{-- Keterangan --}}
                                                                               <div class="mb-3">
                                                                                   <label for="keterangan" class="form-label fw-bold"><i class="fas fa-sticky-note"></i> Keterangan</label>
                                                                                   <textarea name="keterangan" id="keterangan" rows="3" class="form-control border-primary"
                                                                                       placeholder="Masukkan Keterangan Singkat">{{ old('keterangan', $data->keterangan) }}</textarea>
                                                                               </div>
                                                                               {{-- Tombol Aksi --}}
                                                                               <div class="d-flex justify-content-end gap-2">
                                                                                   <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
                                                                                   <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                                                                               </div>
                                                                            </form>
                                                                        </div>

                                                                    {{-- blade-formatter-enable --}}
                                                            </form>

                                                        </section>
                                                    </x-edit-modal>
                                                </div>
                                                {{-- Modal Edit Data Akhir --}}
                                                {{-- Modal View --}}

                                                <div class='modal fade' id='viewModal{{ $data->id }}'
                                                    tabindex='-1' aria-labelledby='ViewModalLabel' aria-hidden='true'>
                                                    <x-view-modal>
                                                        <x-slot:titleviewModal>{{ $titleviewModal }}</x-slot:titleviewModal>
                                                        <button id='BTNpdf' type='button'
                                                            onclick='generatePDF{{ $data->id }}()'
                                                            class='btn btn-default bg-success btn-md'> <i
                                                                class='fa fa-file-pdf mr-2'></i>Export to PDF </button>


                                                        <div id='divToExport{{ $data->id }}' class='mt-1'>
                                                            <section>
                                                                <h3>Data Dokumentasi
                                                                    {{ ucwords($data->nama_kegiatan) }}
                                                                </h3>
                                                                <p>Deskripsi : {{ $data->keterangan }}</p>
                                                                {{-- {{dd($data->foto)}} --}}
                                                                <div class="row">
                                                                    @php
                                                                        $fotos = json_decode($data->foto, true); // Mengubah JSON ke array
                                                                    @endphp

                                                                    @if (!empty($fotos) && is_array($fotos))
                                                                        <div class="row d-flex justify-content-between">
                                                                            @foreach ($fotos as $foto)
                                                                                <div class="col-6 text-center mb-3">
                                                                                    <img src="{{ asset('img/foto-kegiatan/' . $foto) }}"
                                                                                        alt="Foto Kegiatan"
                                                                                        class="img-fluid"
                                                                                        style="width: 100%; height: 350px; object-fit: cover; border-radius: 8px;">
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    @else
                                                                        <p class="text-center">Tidak ada foto tersedia.
                                                                        </p>
                                                                    @endif


                                                                </div>
                                                            </section>
                                                        </div>

                                                        <script>
                                                            function generatePDF{{ $data->id }}() {
                                                                // Ambil elemen yang ingin diekspor ke PDF
                                                                const element = document.getElementById('divToExport{{ $data->id }}');

                                                                // Konfigurasi opsi untuk konversi HTML ke PDF
                                                                const options = {
                                                                    margin: [20, 10, 0, 10], // Menghapus margin untuk menghindari halaman kosong [atas, kanan, bawah, kiri]
                                                                    filename: 'Data Dokumentasi.pdf', // Nama file yang akan diunduh

                                                                    // Konfigurasi gambar dalam PDF
                                                                    image: {
                                                                        type: 'jpeg', // Format gambar dalam PDF
                                                                        quality: 0.98 // Kualitas gambar (0-1), semakin tinggi semakin bagus
                                                                    },

                                                                    // Pengaturan untuk html2canvas (digunakan untuk menangkap elemen HTML)
                                                                    html2canvas: {
                                                                        scale: 2, // Meningkatkan skala untuk meningkatkan kualitas hasil tangkapan
                                                                        scrollY: 0 // Mencegah efek scroll saat menangkap elemen
                                                                    },

                                                                    // Konfigurasi untuk jsPDF (library yang menangani pembuatan PDF)
                                                                    jsPDF: {
                                                                        unit: 'mm', // Menggunakan satuan milimeter
                                                                        format: 'legal', // Ukuran kertas yang digunakan (Legal: 216 × 356 mm)
                                                                        // format: [210, 400] // (Opsional) Custom ukuran kertas jika diperlukan
                                                                        orientation: 'portrait' // Mode orientasi PDF (portrait atau landscape)
                                                                    }
                                                                };

                                                                // Proses konversi elemen HTML menjadi PDF dan mengunduhnya
                                                                html2pdf().from(element).set(options).save();
                                                            }
                                                        </script>

                                                    </x-view-modal>
                                                </div>
                                                {{-- Modal View Akhir --}}
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class='text-center align-middle'>
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
<script>
    $(document).ready(function() {
        initDataTable('#example1', 'Data Dokumentasi', '#example1_wrapper .col-md-6:eq(0)');
    });

    // Fungsi untuk inisialisasi DataTable
    function initDataTable(tableId, exportTitle, buttonContainer) {
        // Hancurkan DataTable jika sudah ada
        $(tableId).DataTable().destroy();

        // Inisialisasi DataTable
        var table = $(tableId).DataTable({
            lengthChange: true, //False jika ingin dilengkapi dropdown
            autoWidth: false,
            responsive: true, // Membuat tabel menjadi responsif agar bisa menyesuaikan dengan ukuran layar
            lengthChange: true, // Menampilkan dropdown untuk mengatur jumlah data per halaman
            autoWidth: false, // Mencegah DataTables mengatur lebar kolom secara otomatis agar tetap sesuai dengan CSS
            buttons: [{
                    extend: 'copy',
                    title: exportTitle,
                    exportOptions: {
                        columns: ':visible:not(.noprint)'
                    }
                },
                {
                    extend: 'excel',
                    title: exportTitle,
                    exportOptions: {
                        columns: ':visible:not(.noprint)'
                    }
                },
                {
                    extend: 'pdf',
                    title: exportTitle,
                    orientation: 'landscape', // Ubah ke 'portrait' jika ingin mode potrait
                    exportOptions: {
                        columns: ':visible:not(.noprint)'
                    }
                },
                {
                    extend: 'colvis',
                    titleAttr: 'Pilih Kolom'
                }
            ],
            columnDefs: [{
                targets: [], // Kolom terakhir (Action) bisgunkan array contoh [-1, -2, -4]
                visible: false // Menyembunyikan kolom Action
            }],
            rowGroup: {
                dataSrc: 0
            } // Mengelompokkan berdasarkan kolom pertama (index 0)
        });

        // Menambahkan tombol-tombol di atas tabel
        table.buttons().container().appendTo(buttonContainer);
    }
</script>
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
                    <i class="fas fa-calendar-alt mr-2"></i>Tambah Data Dokumtasi Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <form id='#id' action='{{ route('data-dokumentasi.store') }}' enctype="multipart/form-data"
                    method='POST'>
                    @csrf
                    @method('POST')
                    <div class="card shadow-lg p-4 rounded-3">

                        {{-- blade-formatter-disable --}}
                        <div class="mb-3">
                            <label for="tanggal_pelaksanaan" class="form-label fw-bold"><i class="fas fa-calendar-day"></i> Tanggal Pelaksanaan</label>
                            <input type="date" class="form-control border-primary" id="tanggal_pelaksanaan" name="tanggal_pelaksanaan" value="{{ old('tanggal_pelaksanaan') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="nama_kegiatan" class="form-label fw-bold"><i class="fas fa-tasks"></i> Nama Kegiatan</label>
                            <input type="text" class="form-control border-primary" id="nama_kegiatan" name="nama_kegiatan" placeholder="Masukkan Nama Kegiatan" value="{{ old('nama_kegiatan') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label fw-bold"><i class="fas fa-image"></i> Foto Kegiatan</label>
                            <input type="file" class="form-control border-primary" id="foto" name="foto[]" multiple required>
                            <small class="text-muted">Unggah hingga beberapa gambar (JPG, PNG, GIF, max 2MB)</small>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label fw-bold"><i class="fas fa-sticky-note"></i> Keterangan</label>
                            <textarea name="keterangan" id="keterangan" rows="3" class="form-control border-primary"
                                placeholder="Masukkan Keterangan Singkat">{{ old('keterangan') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                        </div>
                        {{-- blade-formatter-enable --}}
                    </div>

                </form>
            </div>

        </div>
    </div>

</div>
