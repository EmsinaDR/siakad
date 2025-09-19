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
                                        <td class='text-center'>
                                            {{ Carbon::create($data->tanggal_sk)->translatedformat('d F Y') }}
                                        </td>
                                        <td class='text-center'> {{ $data->nomor_sk }}</td>
                                        <td class='text-center'> {{ $data->Guru->nama_guru ?? '' }}</td>
                                        <td class='text-left'> {{ $data->nama_sk }}</td>
                                        <td class='text-left'> {!! $data->perihal !!}</td>

                                        <td width='10%'>
                                            {{-- blade-formatter-disable --}}
                                            <div class='gap-1 d-flex justify-content-center'>
                                                <a href="{{route('skview', $data->id)}}" target='_blank'><button type='button' class='btn btn-success btn-sm btn-equal-width' ><i class='fa fa-eye'></i> </button></a>
                                                <!-- Button untuk mengedit -->
                                                <a href="{{route('surat-keputusan.show', $data->id)}}"><button type='button' class='btn btn-warning btn-sm btn-equal-width' ><i class='fa fa-edit'></i> </button></a>
                                                <!-- Form untuk menghapus -->
                                                <form id='delete-form-{{ $data->id }}' action='{{ route('surat-keputusan.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i> </button>
                                                <button type='button' class='btn btn-primary btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i></button>
                                            </div>
                                            {{-- blade-formatter-enable --}}
                                            {{-- Modal View Data Akhir --}}

                                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                                aria-labelledby='EditModalLabel' aria-hidden='true'>
                                                <x-edit-modal>
                                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                    <section>
                                                        <form id='updateurl'
                                                            action='{{ route('surat-keputusan.update', $data->id) }}'
                                                            method='POST'>
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="row">
                                                                <div class="col-6 form-group">
                                                                    <label class="block text-gray-700">Nama SK</label>
                                                                    <input type="text" name="nama_sk"
                                                                        value="{{ old('nama_sk', $data->nama_sk ?? '') }}"
                                                                        class="form-control p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
                                                                </div>
                                                                <div class="col-6 form-group">
                                                                    <label class="block text-gray-700">Tanggal
                                                                        SK</label>
                                                                    <input type="date" name="tanggal_sk"
                                                                        value="{{ old('tanggal_sk', $data->tanggal_sk ?? '') }}"
                                                                        class="form-control p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
                                                                </div>
                                                            </div>
                                                            <div class='form-group'>
                                                                <label for='detailguru_id'>Nama Guru</label>
                                                                <select name='detailguru_id'
                                                                    id='detailguru_sk_id{{ $data->id }}'
                                                                    class='select2 form-control' required>
                                                                    <option value=''>--- Pilih Nama Guru ---
                                                                    </option>
                                                                    @foreach ($Gurus as $Guru)
                                                                        <option value='{{ $Guru->id }}'>
                                                                            {{ $Guru->nama_guru }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class='form-group'>
                                                                <label for='template_id'>Template</label>
                                                                <select name='template_id' id='id'
                                                                    class='select2 form-control' required>
                                                                    <option value=''>--- Pilih Template ---
                                                                    </option>
                                                                    @foreach ($idTemplates->where('kategori', 'SK') as $idTemplate)
                                                                        <option value='{{ $idTemplate->id }}'>
                                                                            {{ $idTemplate->nama_dokumen }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            {{-- <div class="form-group">
                                                            <label class="block text-gray-700">Pejabat Penerbit</label>
                                                            <input type="text" name="pejabat_penerbit"
                                                                value="{{ old('pejabat_penerbit', $data->pejabat_penerbit ?? '') }}"
                                                                class="form-control p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
                                                        </div> --}}
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
<script>
    $(document).ready(function() {
        initDataTable('#example1', 'Data Surat Keputusan', '#example1_wrapper .col-md-6:eq(0)');
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
            searching: true, // Mengaktifkan pencarian di tabel
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
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <form id='#id' action='{{ route('surat-keputusan.store') }}' method='POST'>
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <label class="block text-gray-700">Nomor SK</label>
                        <input id='nomor_sk' type="text" name="nomor_sk"
                            value="{{ old('nomor_sk', $data->nomor_sk ?? '') }}"
                            class="form-control p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200"
                            required>
                    </div>
                    <label><input type="checkbox" id="check_keterangan"> Format No Sk </label> <br>
                    <span><b class="text-success">format baku</b> : 001/KODE-SEKOLAH/KODE-DOKUMEN/BULAN/TAHUN</span>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            let namaSekolah = "SMKN1JKT"; // Bisa diganti dengan variabel dari backend
                            let kodeDokumen = "SK"; // Kode dokumen, bisa disesuaikan
                            let nomorUrut = "001"; // Nomor urut SK
                            let checkbox = document.getElementById("check_keterangan");
                            let inputNomorSK = document.getElementById("nomor_sk");

                            checkbox.addEventListener("change", function() {
                                if (this.checked) {
                                    let date = new Date();
                                    let bulan = String(date.getMonth() + 1).padStart(2, '0'); // Format 2 digit (01-12)
                                    let tahun = date.getFullYear(); // Tahun 4 digit

                                    let nomorSK = `${nomorUrut}/${namaSekolah}/${kodeDokumen}/${bulan}/${tahun}`;
                                    inputNomorSK.value = nomorSK;
                                } else {
                                    inputNomorSK.value = "";
                                }
                            });
                        });
                    </script>
                    <div class="form-group">
                        <label class="block text-gray-700">Nama SK</label>
                        <input type="text" name="nama_sk" value="{{ old('nama_sk', $data->nama_sk ?? '') }}"
                            class="form-control p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
                    </div>

                    <div class="form-group">
                        <label class="block text-gray-700">Tanggal SK</label>
                        <input type="date" name="tanggal_sk"
                            value="{{ old('tanggal_sk', $data->tanggal_sk ?? '') }}"
                            class="form-control p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
                    </div>

                    <div class="form-group">
                        <label class="block text-gray-700">Pejabat Penerbit</label>
                        <input type="text" name="pejabat_penerbit"
                            value="{{ old('pejabat_penerbit', $data->pejabat_penerbit ?? '') }}"
                            class="form-control p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
                    </div>

                    <div class="form-group">
                        <label class="block text-gray-700">Perihal</label>
                        <textarea name="perihal"
                            class="editor form-control p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">{{ old('perihal', $data->perihal ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="block text-gray-700">Content System</label>
                        <textarea id="content_system" name="content_system"
                            class="editor form-control p-2 border border-gray-300  rounded-lg">{{ old('content_system', $data->content_system ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="block text-gray-700">Content Sekolah</label>
                        <textarea id="content_sekolah" name="content_sekolah"
                            class="editor form-control p-2 border border-gray-300  rounded-lg">{{ old('content_sekolah', $data->content_sekolah ?? '') }}</textarea>
                    </div>

                    <!-- Tambahkan Script TinyMCE -->


                    <div class="form-group">
                        <label class="block text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control p-2 border border-gray-300 rounded-lg focus:ring  focus:ring-blue-200">{{ old('deskripsi', $data->deskripsi ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="block text-gray-700">Unggah File SK</label>
                        <input type="file" name="file"
                            class="form-control p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
                        @if (isset($data) && $data->file_path)
                            <p class="text-sm mt-2">File saat ini: <a
                                    href="{{ asset('storage/' . $data->file_path) }}" class="text-blue-600 underline"
                                    target="_blank">{{ $data->file_name }}</a>
                            </p>
                        @endif
                    </div>
                    {{-- blade-formatter-enable --}}

                    <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'>
                        Kirim</button>
                </form>

                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                    <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                </div>
            </div>

        </div>
    </div>

</div>
