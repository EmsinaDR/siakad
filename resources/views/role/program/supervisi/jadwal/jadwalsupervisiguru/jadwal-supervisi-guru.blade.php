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
            <!--Card Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</h3>
            </div>
            <!--Card Header-->
            <div class='row m-2'>
                <div class='col-xl-2'>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'>
                        <i class='fa fa-plus'></i> Tambah Data
                    </button>
                </div>
                <div class='col-xl-10'></div>
            </div>
            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
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
                        @php $no = 1; @endphp

                                @foreach ($datas as $tingkat_id => $group)
                                    @foreach ($group as $data)
                                        <tr>
                                            <td class='text-center'>{{ $no++ }}</td>
                                            <td>{{ $data->Guru->nama_guru }}</td>
                                            <td>{{ $data->Mapel->mapel ?? 'Tidak ada data' }}</td>
                                            <td class='text-center'>{{ $data->Kelas->kelas }}</td>

                                            @php
                                                $baseQuery = \App\Models\Program\Supervisi\Jadwal\JadwalSupervisiGuru::where('kelas_id', $data->kelas_id)
                                                    ->where('mapel_id', $data->mapel_id)
                                                    ->where('detailguru_id', $data->detailguru_id)
                                                    ->where('tapel_id', $Tapels->id);

                                                $datasJadwalPB = (clone $baseQuery)->where('kategori', 'Pelaksanaan Pembelajaran')->first();
                                                $datasJadwalMA = (clone $baseQuery)->where('kategori', 'Modul Ajar')->first();
                                                $datasJadwalATP = (clone $baseQuery)->where('kategori', 'Alur Tujuan Pembelajaran')->first();
                                                $datasJadwalAdm = (clone $baseQuery)->where('kategori', 'Administrasi Pembelajaran')->first();
                                            @endphp

                                            <td class='text-center'>
                                                {!! $datasJadwalPB
                                                    ? Carbon::parse($datasJadwalPB->tanggal_pelaksanaan)->translatedFormat('l, d F Y')
                                                    : '<span class="badge bg-danger p-2 rounded"><i class="fa fa-times"></i></span>' !!}
                                            </td>
                                            <td class='text-center'>
                                                {!! $datasJadwalATP
                                                    ? Carbon::parse($datasJadwalATP->tanggal_pelaksanaan)->translatedFormat('l, d F Y')
                                                    : '<span class="badge bg-danger p-2 rounded"><i class="fa fa-times"></i></span>' !!}
                                            </td>
                                            <td class='text-center'>
                                                {!! $datasJadwalMA
                                                    ? Carbon::parse($datasJadwalMA->tanggal_pelaksanaan)->translatedFormat('l, d F Y')
                                                    : '<span class="badge bg-danger p-2 rounded"><i class="fa fa-times"></i></span>' !!}
                                            </td>
                                            <td class='text-center'>
                                                {!! $datasJadwalAdm
                                                    ? Carbon::parse($datasJadwalAdm->tanggal_pelaksanaan)->translatedFormat('l, d F Y')
                                                    : '<span class="badge bg-danger p-2 rounded"><i class="fa fa-times"></i></span>' !!}
                                            </td>

                                            <td width='10%'>
                                                <div class='gap-1 d-flex justify-content-center'>
                                                    <button type="button" class='btn btn-primary btn-sm' onclick='editData{{ $data->id }}()'>
                                                        <i class="fa fa-edit"></i>
                                                    </button>

                                                    <form id='delete-form-{{ $data->id }}'
                                                        action='{{ route('supervisi-pembelajaran.destroy', $data->id) }}'
                                                        method='POST' style='display: inline-block;'>
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>

                                                    <button type='button' class='btn btn-danger btn-sm'
                                                        onclick='confirmDelete({{ $data->id }})'>
                                                        <i class='fa fa-trash'></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- Modal Edit --}}
                                        <div class='modal fade' id='editData{{ $data->id }}' tabindex='-1' aria-labelledby='LabeleditData' aria-hidden='true'>
                                            <div class='modal-dialog modal-lg'>
                                                <div class='modal-content'>
                                                    <div class='modal-header bg-primary'>
                                                        <h5 class='modal-title' id='LabeleditData'>Tambah Data Baru</h5>
                                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                            <span aria-hidden='true'>&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class='modal-body'>
                                                        <form action="{{ route('jadwal-supervisi-guru.store', $data->id) }}" method="POST">
                                                            @csrf
                                                            @method('POST')
                                                            {{-- blade-formatter-disable --}}
                                                            <div class='form-group'>
                                                                <label for='detailguru_id'>Nama Guru</label>
                                                                <input type='text' class='form-control' id='nama_guru' name='detailguru_id' placeholder='Nama Guru' value='{{ $data->Guru->nama_guru }}' required>
                                                            </div>
                                                            <div class='form-group'>
                                                                <label for='mapel_id'>Mata Pelajaran</label>
                                                                <input type='text' class='form-control' id='mapel_id' name='nama_mapel' value='{{ $data->Mapel->mapel }}' required>
                                                            </div>
                                                            <div class='form-group'>
                                                                <label for='kelas_id'>Kelas</label>
                                                                <input type='text' class='form-control' id='kelas_id' name='kelas' placeholder='Kelas' value='{{ $data->Kelas->kelas }}' required>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class='form-group'>
                                                                        <label for='pembelajaran'>Pelaksanaan Pembelajaran</label>
                                                                        <input type='date' class='form-control' id='pembelajaran' name='pembelajaran'
                                                                            value='{{ $datasJadwalPB ? \Carbon\Carbon::parse($datasJadwalPB->tanggal_pelaksanaan)->format('Y-m-d') : '' }}' required>
                                                                    </div>
                                                                    <input type='hidden' name='detailguru_id' id='detailguru_id' placeholder='detailguru_id' value='{{ $data->detailguru_id }}'>
                                                                    <input type='hidden' name='kelas_id' id='kelas_id' placeholder='kelas_id' value='{{ $data->kelas_id }}'>
                                                                    <input type='hidden' name='mapel_id' id='mapel_id' placeholder='mapel_id' value='{{ $data->mapel_id }}'>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class='form-group'>
                                                                        <label for='atp'>Alur Tujuan Pembelajaran (ATP)</label>
                                                                        <input type='date' class='form-control' id='atp' name='atp'
                                                                            value='{{ $datasJadwalATP ? \Carbon\Carbon::parse($datasJadwalATP->tanggal_pelaksanaan)->format('Y-m-d') : '' }}' required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class='form-group'>
                                                                        <label for='modul_ajar'>Perangkat Pembelajaran (Modul Ajar)</label>
                                                                        <input type='date' class='form-control' id='modul_ajar' name='modul_ajar'
                                                                            value='{{ $datasJadwalMA ? \Carbon\Carbon::parse($datasJadwalMA->tanggal_pelaksanaan)->format('Y-m-d') : '' }}' required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class='form-group'>
                                                                        <label for='perangkat'>Perangkat Pembelajaran</label>
                                                                        <input type='date' class='form-control' id='perangkat' name='perangkat'
                                                                            value='{{ $datasJadwalAdm ? \Carbon\Carbon::parse($datasJadwalAdm->tanggal_pelaksanaan)->format('Y-m-d') : '' }}' required>
                                                                    </div>
                                                                </div>
                                                            </div>
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


                                        {{-- Modal Trigger Script --}}
                                        <script>
                                            function editData{{ $data->id }}() {
                                                var modal = new bootstrap.Modal(document.getElementById('editData{{ $data->id }}'));
                                                modal.show();
                                            }
                                        </script>
                                @endforeach
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
        initDataTable('#example1', 'Jadwal Supervisi Guru', '#example1_wrapper .col-md-6:eq(0)');
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
                // {
                //     extend: 'pdf',
                //     title: exportTitle,
                //     exportOptions: {
                //         columns: ':visible:not(.noprint)'
                //     }
                // },
               {
                   extend: 'pdf',
                   text: 'PDF', // Tombol untuk landscape
                   title: exportTitle,
                   orientation: 'landscape',
                   exportOptions: {
                       columns: ':visible:not(.noprint)'
                   }
               },
               // {
               //     extend: 'pdf',
               //     text: 'Export PDF (Portrait)', // Tombol untuk portrait
               //     title: exportTitle,
               //     orientation: 'portrait',
               //     exportOptions: {
               //         columns: ':visible:not(.noprint)'
               //     }
               // },
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
