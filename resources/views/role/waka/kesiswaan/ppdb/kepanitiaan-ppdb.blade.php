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
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'> <i class='fa fa-plus'></i> Tambah Panitia</button>
                </div>
                <div class='col-xl-10'></div>
            </div>

            {{-- blade-formatter-enable --}}

            <div class='ml-2 my-4'>
                {{-- Catatan :
                   - Include Komponen Modal CRUD + Javascript / Jquery
                   - Perbaiki Onclick Tombol Modal Create, Edit
                   - Variabel Active Crud menggunakan ID User
                    --}}
                <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                    <thead>
                        <tr class='table-primary text-center'>
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
                                <td class='text-center'> {{ $data->Tapel->tapel }}</td>
                                <td class='text-center'> {{ $data->jabatan }}</td>
                                <td class='text-center'> {{ $data->Guru->nama_guru }}</td>

                                <td width='10%'>
                                    <div class='gap-1 d-flex justify-content-center'>
                                        <!-- Button untuk mengedit -->
                                        <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                            data-toggle='modal' data-target='#editModal{{ $data->id }}'><i
                                                class='fa fa-edit'></i> </button>
                                        <!-- Form untuk menghapus -->
                                        <form id='delete-form-{{ $data->id }}'
                                            action='{{ route('kepanitiaan-ppdb.destroy', $data->id) }}' method='POST'
                                            style='display: inline-block;'>
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button type='button' class='btn btn-danger btn-sm btn-equal-width'
                                            onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i>
                                        </button>
                                    </div>
                                    {{-- Modal View Data Akhir --}}

                                    <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                        aria-labelledby='EditModalLabel' aria-hidden='true'>

                                        <x-edit-modal>
                                            <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                            <section>
                                                <form id='updateurl'
                                                    action='{{ route('kepanitiaan-ppdb.update', $data->id) }}'
                                                    method='POST'>
                                                    @csrf
                                                    @method('PATCH')


                                                    <div class='form-group'>
                                                        <label for='detailguru_id'>Nama Panitia</label>
                                                        <select name='detailguru_id' id='selectId-{{ $data->id }}' class='form-control'
                                                            required>
                                                            <option value=''>--- Pilih Nama Panitia ---</option>
                                                            @foreach ($DataGurus as $DataGuru)
                                                                <option value='{{ $DataGuru->id }}'>
                                                                    {{ $DataGuru->nama_guru }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <script>
                                                       $(document).ready(function() {
                                                           // $('#semesteredit option[value='II']').prop('selected', true); // Single Select
                                                           $('#selectId-{{ $data->id }}').val(@json($data->detailguru_id)).trigger('change'); // Mutiple Select Select value in array json
                                                       });
                                                    </script>

                                                    <div class='form-group'>
                                                        <label for='jabatan'>Jabatan</label>
                                                        <select name='jabatan' id='select2-{{ $data->id }}' class='form-control' required>
                                                            <option value=''>--- Pilih Jabatan ---</option>
                                                            @foreach ($Jabatans as $Jabatan)
                                                            <option value='{{ $Jabatan }}'> {{ $Jabatan }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <script>
                                                       $(document).ready(function() {
                                                           // $('#semesteredit option[value='II']').prop('selected', true); // Single Select
                                                           $('#select2-{{ $data->id }}').val(@json($data->jabatan)).trigger('change'); // Mutiple Select Select value in array json
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

    </section>
</x-layout>
<script>
    $(document).ready(function() {
        initDataTable('#example1', 'Data Peserta Ekstra', '#example1_wrapper .col-md-6:eq(0)');
        initDataTable('#example2', 'Data Peserta Ekstra 2', '#example2_wrapper .col-md-6:eq(0)');
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
                targets: -1, // Kolom terakhir (Action)
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
                    Tambah Data Kepanitian
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <form id='#id' action='{{ route('kepanitiaan-ppdb.store') }}' method='POST'>
                    @csrf
                    @method('POST')
                    @php
                        $Jabatans = ['Ketua', 'Wakil', 'Bendahara', 'Sekretaris', 'Humas', 'Dokumentasi'];
                    @endphp

                    <div class='form-group'>
                        <label for='detailguru_id'>Nama Panitia</label>
                        <select name='detailguru_id' id='id' class='form-control' required>
                            <option value=''>--- Pilih Nama Panitia ---</option>
                            @foreach ($DataGurus as $DataGuru)
                                <option value='{{ $DataGuru->id }}'>{{ $DataGuru->nama_guru }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='form-group'>
                        <label for='jabatan'>Jabatan</label>
                        <select name='jabatan' id='jabatan' class='form-control' required
                            onchange="toggleJabatanLainnya(this)">
                            <option value=''>--- Pilih Jabatan ---</option>
                            @foreach ($Jabatans as $Jabatan)
                                <option value='{{ $Jabatan }}'>{{ $Jabatan }}</option>
                            @endforeach
                            <option value='lainnya'>Lainnya...</option>
                        </select>
                    </div>

                    <div class='form-group' id='jabatan-lainnya' style='display: none;'>
                        <label for='jabatan_lainnya'>Jabatan Lainnya</label>
                        <input type='text' name='jabatan_lainnya' id='jabatan_lainnya' class='form-control'>
                    </div>

                    <script>
                        function toggleJabatanLainnya(select) {
                            var jabatanLainnya = document.getElementById('jabatan-lainnya');
                            var inputJabatanLainnya = document.getElementById('jabatan_lainnya');

                            if (select.value === 'lainnya') {
                                jabatanLainnya.style.display = 'block';
                                inputJabatanLainnya.setAttribute('required', 'required');
                            } else {
                                jabatanLainnya.style.display = 'none';
                                inputJabatanLainnya.removeAttribute('required');
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
