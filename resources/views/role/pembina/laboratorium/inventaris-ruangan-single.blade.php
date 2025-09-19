@php
    //Inventaris Lab
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
            <div class='card-body'>
                <div class="row">
                    <div class="col-xl-2">
                        <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='PengajuanInventaris()'><i class="fa fa-user"></i> Pengajuan Inventaris</button>
                    </div>
                    <div class="col-xl-10">
                        <div class='card-header bg-success'>
                            <h3 class='card-title'>Riwayat Pengajuan Inventaris</h3>
                        </div>
                        <div class='card-body'>
                            <table id='example1' width='100%' class='table table-bordered table-hover'>
                                <thead>
                                    <tr class='text-center align-middle'>
                                        <th>ID</th>
                                        <th>Kode Barang</th>
                                        <th>Kategori</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class='text-center align-middle'>
                                        <th>ID</th>
                                        <th>Kode Barang</th>
                                        <th>Kategori</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>status</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card m-2">
                <div class='card-header bg-primary'>
                    <h3 class='card-title'>Data Inventaris</h3>
                </div>
                <div class='card-body'>
                    <table id='example2' width='100%' class='table table-responsive table-bordered table-hover'>
                        <thead>
                            <tr class='text-center table-primary'>
                                <th class='text-center align-middle' width='1%' rowspan='2'>ID</th>
                                @foreach ($arr_ths as $arr_th)
                                    <th class='text-center align-middle' rowspan='2'> {{ $arr_th }}</th>
                                @endforeach
                                <th class='text-center align-middle' colspan='2'>Jumlah</th>
                                <th class='text-center align-middle' rowspan='2'>Total</th>
                                <th class='text-center align-middle' rowspan='2'>Action</th>
                            </tr>
                            <th class='text-center align-middle  table-primary'>Baik</th>
                            <th class='text-center align-middle  table-primary'>Rusak</th>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                                <tr>
                                    <td class='text-center'>{{ $loop->iteration }}</td>
                                    <td class='text-center'> {{ $data->DataKIBB->kode_barang }}</td>
                                    <td class='text-center'> {{ $data->DataKIBB->nama_barang }}</td>
                                    {{-- <td class='text-center'> {{ $data->Kategori->nama_kategori }}</td>
                                    <td class='text-center'> {{ $data->Barang->nama_barang }}</td>
                                    <td class='text-center'> {{ $data->Barang->baik }}</td> --}}
                                    <td class='text-center'>{{ $data->baik }}</td>
                                    <td class='text-center'>{{ $data->rusak }}</td>
                                    <td class='text-center'>{{ $data->jumlah }}</td>
                                    <td width='10%'>
                                        <div class='gap-1 d-flex justify-content-center'>
                                            {{-- blade-formatter-disable --}}
                                            <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i> </button>
                                            <form id='delete-form-{{ $data->id }}' action='{{ route('inventaris-laboratorium.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i> </button>
                                            {{-- blade-formatter-enable --}}

                                        </div>
                                    </td>
                                </tr>
                                {{-- Modal View Data Akhir --}}

                                <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                    aria-labelledby='EditModalLabel' aria-hidden='true'>

                                    <x-edit-modal>
                                        <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                        <section>
                                            {{-- blade-formatter-disable --}}
                                            <div class='card'>
                                                <div class='card-header bg-warning'>
                                                    <h3 class='card-title'><i class='fas fa-text-width mr-2'></i><b>Informasi !!!</b></h3>
                                                </div><!-- /.card-header -->
                                                <div class='card-body'>
                                                    <dl>
                                                        <dt>- Perubahan Stock</dt>
                                                        <dd>  Data DIsini Hanya Dapapat Memperbaharui Kondisi Diruangan Bukan Stock</dd>
                                                        <dt>- Perubahan Data</dt>
                                                        <dd>  Silahkan hubungi bagian inventaris untuk mengajukan perubahan data atau penambahan inventaris</dd>
                                                        <dt></dt>
                                                        <dd></dd>
                                                    </dl>
                                                </div><!-- /.card-body -->
                                            </div>
                                            {{-- blade-formatter-enable --}}
                                            <form id='updateurl'
                                                action='{{ route('inventaris-laboratorium.update', $data->id) }}'
                                                method='POST'>
                                                @csrf
                                                @method('PATCH')
                                                {{-- blade-formatter-disable --}}

                                                <i class="fa fa-barcode"></i> <x-inputallin>readonly:Kode Barang:Kode Barang:kode_barang:id_kode_barang::readonly</x-inputallin>
                                                <i class="fa fa-tag"></i> <x-inputallin>readonly:Nama Barang:Kode Barang:nama_barang:nama_barang::readonly</x-inputallin>

                                                <div class="row my-2">
                                                    <div class="col-xl-6">
                                                        <div class='card-header bg-primary'><h3 class='card-title'>Stok Inventaris</h3></div>

                                                        <i class="fa fa-check-circle text-success"></i> <x-inputallin>readonly:Baik:Baik:baik:id_baik::readonly</x-inputallin>
                                                        <i class="fa fa-wrench text-warning"></i> <x-inputallin>readonly:Rusak Ringan:Rusak Ringan:rusak_ringan:id_rusak_ringan::readonly</x-inputallin>
                                                        <i class="fa fa-exclamation-triangle text-danger"></i> <x-inputallin>readonly:Rusak Sedang:Rusak Sedang:rusak_sedang:id_rusak_sedang::readonly</x-inputallin>
                                                        <i class="fa fa-times-circle text-danger"></i> <x-inputallin>readonly:Rusak Berat:Rusak Berat:rusak_berat:id_rusak_berat::readonly</x-inputallin>
                                                    </div>

                                                    <div class="col-xl-6">
                                                        <div class='card-header bg-primary'><h3 class='card-title'>Data</h3></div>

                                                        <i class="fa fa-box"></i> <x-inputallin>type:Baik:Baik:rusak:id_rusak::Required</x-inputallin>
                                                        <i class="fa fa-tools"></i> <x-inputallin>type:Rusak:Rusak:baik:baik::Required</x-inputallin>
                                                    </div>
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
                                <th>Baik</th>
                                <th>Rusak</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>

            <div class='ml-2 my-4'>
                Inventaris Lab
            </div>


        </div>

    </section>
</x-layout>
{{-- <button class='btn btn-warning btn-sm' ><i class='fa fa-edit right'></i> Edit</button> --}}
{{--
onclick='PengajuanInventaris()'
 --}}

<script>
    function PengajuanInventaris(data) {
        var PengajuanInventaris = new bootstrap.Modal(document.getElementById('PengajuanInventaris'));
        PengajuanInventaris.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='PengajuanInventaris' tabindex='-1' aria-labelledby='LabelPengajuanInventaris'
    aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelPengajuanInventaris'>
                    Tambah Data Pengajuan Inventaris
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <form id='#id' action='' method='POST'>
                    @csrf
                    @method('POST')
                    <div class='form-group'>
                        <label for='inventaris_id'>Nama Barang</label>
                        <select name='inventaris_id' id="inventarisSelect" class='form-control' required
                            onchange="toggleInput()">
                            <option value=''>--- Pilih Nama Barang ---</option>
                            @foreach ($DataKIBBs as $newInventarisBarang)
                                <option value='{{ $newInventarisBarang->id }}'>{{ $newInventarisBarang->kode_barang }} - {{ $newInventarisBarang->nama_barang }}
                                </option>
                            @endforeach
                            <option value="lainnya">Lainnya...</option>
                        </select>

                        <!-- Input Text (Awalnya Tersembunyi) -->
                        <input type="text" name="nama_barang_lainnya" id="namaBarangInput"
                            class="form-control mt-2" placeholder="Masukkan Nama Barang" style="display: none;">
                    </div>

                    <!-- Kategori (Awalnya Tersembunyi) -->
                    <div class='form-group' id="kategoriContainer" style="display: none;">
                        <label for='nama_kategori'>Pilih Kategori</label>
                        <select name='nama_kategori' class='form-control'>
                            <option value=''>--- Pilih Kategori ---</option>
                            {{-- @foreach ($kategoriBarang as $newkategoriBarang)
                                <option value='{{ $newkategoriBarang->id }}'>{{ $newkategoriBarang->nama_kategori }}
                                </option>
                            @endforeach --}}
                        </select>
                    </div>
                    <div class='form-group' id='id_harga' style="display: none;">
                        <label for='id_harga_barang'>Harga Per Unit</label>
                        <input type='text' class='form-control' id='id_harga_barang' name='harga'
                            value='0' placeholder='Harga Per Unit' required>
                    </div>
                    <x-inputallin>type:Jumlah:Jumlah Permintaan:jumlah:id_jumlah:0:Required</x-inputallin>

                    <script>
                        function toggleInput() {
                            let selectBox = document.getElementById("inventarisSelect");
                            let inputBox = document.getElementById("namaBarangInput");
                            let kategoriContainer = document.getElementById("kategoriContainer");
                            let harga_unit = document.getElementById("id_harga");

                            if (selectBox.value === "lainnya") {
                                inputBox.style.display = "block"; // Tampilkan input Nama Barang
                                inputBox.setAttribute("required", "required"); // Jadikan required

                                kategoriContainer.style.display = "block"; // Tampilkan kategori
                                harga_unit.style.display = "block"; // Tampilkan kategori
                            } else {
                                inputBox.style.display = "none"; // Sembunyikan input Nama Barang
                                inputBox.removeAttribute("required"); // Hapus required

                                kategoriContainer.style.display = "none"; // Sembunyikan kategori
                                harga_unit.style.display = "none"; // Sembunyikan kategori
                            }
                        }
                    </script>

                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<script>
    $(document).ready(function() {
        initDataTable('#example1', 'Data Riwayat Pengajuan Inventaris', '#example1_wrapper .col-md-6:eq(0)');
        initDataTable('#example2', 'Data Inventaris Laboratorium', '#example2_wrapper .col-md-6:eq(0)');
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

    // lengthChange: true,  // (Opsional) Jika diaktifkan, pengguna dapat mengubah jumlah data yang ditampilkan
    // autoWidth: false,    // (Opsional) Pastikan ini aktif jika ingin kontrol lebih besar atas lebar kolom
    // paging: true,        // (Opsional) Mengaktifkan pagination (jika ingin menampilkan semua data, bisa di-set ke false)
    // pageLength: 25,      // (Opsional) Menentukan jumlah data yang ditampilkan per halaman (default: 10)

    // ordering: true,      // (Opsional) Mengaktifkan fitur sorting pada kolom
    // order: [[1, 'desc']], // (Opsional) Menentukan sorting default (misal: kolom index ke-1, urutan descending)

    // searching: true,     // (Opsional) Mengaktifkan fitur pencarian global dalam tabel
    // fixedHeader: true,   // (Opsional) Header tabel tetap terlihat saat pengguna melakukan scroll ke bawah
    // scrollX: true,       // (Opsional) Mengaktifkan scroll horizontal jika tabel terlalu lebar

    //buttons: ['copy', 'excel', 'pdf', 'colvis'] // Menambahkan tombol export dan visibilitas kolom
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
