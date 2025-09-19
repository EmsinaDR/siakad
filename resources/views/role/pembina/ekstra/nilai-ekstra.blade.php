@php
    //data-ekstra-waka
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
    $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
    $urlroot = app('request')->root();

    $Pembina = App\Models\User\Guru\Detailguru::orderBy('nama_guru', 'ASC')->get();
    $hariLatihan = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
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
                {{-- <div class='col-xl-2'>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahEkstra()'>
                        <i class='fa fa-plus'></i> Tambah Data</button>
                </div>
                <div class='col-xl-10'></div> --}}
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr>
                                <td class='text-center'>{{ $loop->iteration }}</td>
                                <td class='text-left'> {{ $data->Ekstra->ekstra }}</td>
                                <td class='text-center'> {{ $data->Detailguru->nama_guru }}</td>
                                <td class='text-center'> {{ $data->pelatih }}</td>
                                <td class='text-center'> {{ $data->jadwal }}</td>
                                <td class='text-center'>
                                    {{-- blade-formatter-disable --}}
                                    @php
                                        $JumlahAnggota = App\Models\WakaKesiswaan\Ekstra\PesertaEkstra::where('ekstra_id', $data->id, )->get();
                                    @endphp
                                    <a href="{{ app('request')->root() }}/waka-kesiswaan/daftar-hadir-ekstrakurikuler/{{ $data->id }}"><span class="p-2 bg-success">{{ $JumlahAnggota->count() }}</span></a>
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
                        </tr>
                    </tfoot>
                </table>
            </div>


        </div>

    </section>
</x-layout>
{{-- <button class='btn btn-warning btn-sm' onclick='TambahEkstra()'><i class='fa fa-edit right'></i> Edit</button> --}}
{{--

 --}}

<script>
    function TambahEkstra(data) {
        var TambahEkstra = new bootstrap.Modal(document.getElementById('TambahEkstra'));
        TambahEkstra.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='TambahEkstra' tabindex='-1' aria-labelledby='LabelTambahEkstra' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelTambahEkstra'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <form id='#id' action='' method='POST'>
                    @csrf
                    @method('POST')

                    {{-- blade-formatter-disable --}}
                    @php
                    $DataEkstra = App\Models\WakaKesiswaan\Ekstra\Ekstra::orderBy('ekstra', 'ASC')->get()
                    @endphp
                    <div class='form-group'>
                        <label for='ekstra_id'>Nama Ekstra</label>
                        <select name='ekstra_id' class='form-control' required>
                            <option value=''>--- Pilih Nama Ekstra ---</option>
                            @foreach ($DataEkstra as $newDataEkstra)
                                <option value='{{ $newDataEkstra->id }}'>{{ $newDataEkstra->ekstra }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='form-group'>
                        <label for='detailguru_id'>Pembina</label>
                        <select id='select2-{{ $data->id }}' name='detailguru_id' class='form-control' required>
                            <option value=''>--- Pilih Pembina ---</option>
                            @foreach ($Pembina as $newPembina)
                                <option value='{{ $newPembina->id }}'>{{ $newPembina->nama_guru }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <x-inputallin>type:Pelatih:Pelatih:pelatih:id_pelatih::Required</x-inputallin>
                    <div class='form-group'>
                        <label for='jadwal'>Hari Latihan</label>
                        <select id='select2jadwal-{{ $data->id }}' name='jadwal' class='form-control' required>
                            <option value=''>--- Pilih Hari Latihan ---</option>
                            @foreach ($hariLatihan as $newhariLatihan)
                                <option value='{{ $newhariLatihan }}'>{{ $newhariLatihan }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- blade-formatter-enable --}}
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
        initDataTable('#example1', 'Data Peserta Ekstra', '#example1_wrapper .col-md-6:eq(0)');
        initDataTable('#example2', 'Data Peserta Ekstra 2', '#example2_wrapper .col-md-6:eq(0)');
    });

    // Fungsi untuk inisialisasi DataTable
    function initDataTable(tableId, exportTitle, buttonContainer) {
        // Hancurkan DataTable jika sudah ada
        $(tableId).DataTable().destroy();

        // Inisialisasi DataTable
        var table = $(tableId).DataTable({
            lengthChange: true,
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
            rowGroup: {
                dataSrc: 0
            } // Mengelompokkan berdasarkan kolom pertama (index 0)
        });

        // Menambahkan tombol-tombol di atas tabel
        table.buttons().container().appendTo(buttonContainer);
    }
</script>
