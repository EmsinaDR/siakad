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
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'> <i
                            class='fa fa-plus'></i> Tambah Data</button>
                </div>
                <div class='col-xl-10'></div>
            </div>


            <div class='ml-2 my-4'>
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
                                <td class='text-center'> {{ $data->SiswaOne->nama_siswa }}</td>
                                <td class='text-center'> {{ $data->kelas->kelas }}</td>
                                <td class='text-center'> {{ $data->Guru->nama_guru }}</td>
                                <td class='text-center'>
                                    @php
                                        $Halamans = json_decode($data->halaman, true);
                                    @endphp
                                    @foreach ($Halamans as $key => $Halaman)
                                        {{ $Halaman }}@if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach

                                </td>

                                <td width='10%'>
                                    {{-- blade-formatter-disable --}}
                                              <div class='gap-1 d-flex justify-content-center'>
                                                  <!-- Button untuk mengedit -->
                                                  <a href="{{route('riwayat-btq.index')}}/{{$data->detailsiswa_id}}"><button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-eye'></i> </button></a>
                                              </div>
                                              {{-- blade-formatter-enable --}}

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

                    <form id='#id' action='{{ route('riwayat-btq.store') }}' method='POST'>
                        @csrf
                        @method('POST')
                        @php
                            $Halamans = range(1, 100);
                        @endphp
                        <div class='form-group'>
                            <label for='detailsiswa_id'>Nama Siswa</label>
                            <select id='detailsiswa_id-1' name='detailsiswa_id' class='form-control' required>
                                <option value=''>--- Pilih Nama Siswa ---</option>
                                @foreach ($DataSiswas as $data)
                                    <option value='{{ $data->detailsiswa_id }}'>{{ $data->kelas->kelas }} -
                                        {{ $data->SiswaOne->nama_siswa }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class='form-group'>
                            <label for='halaman'>Halaman</label>
                            <select name='halaman[]' id='select2-1' class='form-control' multiple required>
                                @foreach ($Halamans as $Halaman)
                                    <option value='{{ $Halaman }}'>{{ $Halaman }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class='form-group'>
                            <i class='fas fa-sticky-note'></i><label for='keterangan'>Keterangan</label>
                            <textarea name='keterangan' id='keterangan' rows='3' class='form-control'
                                placeholder='Masukkan Keterangan Singkat'></textarea>
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

</x-layout>
<script>
    $(document).ready(function() {
        initDataTable('#example1', 'Data Tugas Riwayat BTQ', '#example1_wrapper .col-md-6:eq(0)');
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
            searching: true,    // Mengaktifkan pencarian di tabel
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
