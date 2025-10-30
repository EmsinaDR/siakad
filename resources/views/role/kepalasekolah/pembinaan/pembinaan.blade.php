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
                {{-- blade-formatter-disable --}}
                <div class='col-xl-2'>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#TambahData'><i class='fa fa-plus'></i> Tambah Data</button>
                </div>
                {{-- blade-formatter-enable --}}
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
                                @foreach ($datas as $data)
                                    <tr>
                                        <td class='text-center'>{{ $loop->iteration }}</td>
                                        <td class='text-center'>
                                            {{ Carbon::create($data->tanggal)->translatedformat('l, d F Y') }}</td>
                                        <td class='text-center'> {{ $data->Guru->nama_guru }}</td>
                                        <td class='text-center'>
                                            <span
                                                class="
                                                    @if ($data->status == 'Belum') bg-danger p-2 rounded-pill
                                                    @elseif ($data->status == 'Proses')
                                                        bg-warning p-2 rounded-pill
                                                    @elseif ($data->status == 'Selesai')
                                                        bg-success p-2 rounded-pill @endif
                                                ">
                                                {{ $data->status }}
                                            </span>

                                        </td>
                                        <td class='text-left'> {!! $data->indikator !!}</td>
                                        <td class='text-left'> {!! $data->kesimpulan_umum !!}</td>
                                        <td class='text-left'> {!! $data->tindak_lanjut !!}</td>

                                        <td width='10%'>
                                            {{-- blade-formatter-disable --}}
                                            <div class='gap-1 d-flex justify-content-center'>
                                                <!-- Button untuk mengedit -->
                                                <a href="{{route('pembinaan.show', $data->id)}}"><button type='button' class='btn btn-warning btn-sm btn-equal-width'><i class='fa fa-edit'></i> </button></a>
                                                <!-- Form untuk menghapus -->
                                                <form id='delete-form-{{ $data->id }}'
                                                    action='{{ route('pembinaan.destroy', $data->id) }}' method='POST'
                                                    style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i> </button>
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

                {{-- blade-formatter-disable --}}
                <form id='#id' action='{{route('pembinaan.store')}}' method='POST'>
                    @csrf
                    @method('POST')
                    <div class='form-group'>
                        <label for='tanggal'>Tanggal</label>

                        <input type='date' class='form-control' id='tanggal' name='tanggal' placeholder='Tanggal' value='{{Carbon::now()->translatedFormat('Y-m-d')}}' required>
                    </div>
                    <div class='form-group'>
                        <label for='detailguru_id'>Nama Guru</label>
                        <select name='detailguru_id'  id='id' class='select2 form-control' data-placeholder='Nama guru' required>
                            <option value=''></option>
                            @foreach($Gurus as $Guru)
                                <option value='{{$Guru->id}}'>{{$Guru->nama_guru}}</option>
                            @endforeach
                        </select>
                    </div>

                    @php
                    $statuss = ['Belum', 'Proses', 'Selesai'];
                    @endphp
                    <div class='form-group'>
                        <label for='status'>Status</label>
                        <select name='status' id='status' class='select2 form-control' data-placeholder='Status' required>
                            <option value=''></option>
                            @foreach($statuss as $status)
                                <option value='{{$status}}'>{{$status}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='form-group'>
                        <label for='Indikator'>Indikator</label>
                        <input type='text' class='form-control' id='Indikator' name='indikator' placeholder='Indikator' required>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                    </div>
                </form>
                {{-- blade-formatter-enable --}}
            </div>

        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        initDataTable('#example1', 'Data Pembinaan Guru', '#example1_wrapper .col-md-6:eq(0)');
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
                targets: [5, 6], // Kolom terakhir (Action) bisgunkan array contoh [-1, -2, -4]
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
