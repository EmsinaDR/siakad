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
                <h3 class='card-title'>{{ $title }} - {{ $dataEkstra->ekstra }}</H3>
            </div>
            <!--Car Header-->


            {{-- blade-formatter-disable --}}
            <div class='row m-2'>
                <div class='col-xl-2'>
                       <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='NilaiEkstra()'> <i class='fa fa-plus'></i> Ubah Data Nilai</button>
                   </div>
                   <div class='col-xl-10'></div>
            </div>
            {{-- blade-formatter-enable --}}


            <div class='ml-2 my-4'>
                <div class="card">
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>Data Nilai Ekstra</h3>
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
                                        <td class='text-left'> {{ $data->Siswa->nama_siswa }}</td>
                                        <td class='text-center'> {{ $data->nilai }}</td>
                                        <td class='text-center'>
                                            @if ($data->predikat !== null && $data->predikat !== '')
                                                <!-- Jika predikat ada dan tidak kosong -->
                                                @if ($data->predikat === 'A')
                                                    <span class="bg-success p-2">A</span>
                                                @elseif ($data->predikat === 'D')
                                                    <span class="bg-danger p-2">D</span>
                                                @elseif($data->predikat === 'C')
                                                    <span class="bg-warning p-2">C</span>
                                                @elseif($data->predikat === 'B')
                                                    <span class="bg-primary p-2">B</span>
                                                @else
                                                    <span class="bg-danger p-2">E</span>
                                                @endif
                                            @else
                                                <!-- Jika predikat null atau kosong -->
                                                @if ($data->nilai < 70)
                                                    <span class="bg-warning p-2">C</span>
                                                @elseif ($data->nilai < 85)
                                                    <span class="bg-primary p-2">B</span>
                                                @elseif ($data->nilai < 100)
                                                    <span class="bg-primary p-2">A</span>
                                                @else
                                                    <span class="bg-danger p-2">D</span>
                                                @endif
                                            @endif


                                        </td>

                                        <td width='10%'>
                                            <div class='gap-1 d-flex justify-content-center'>
                                                <!-- Button untuk mengedit -->
                                                <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                                    data-toggle='modal' data-target='#editModal{{ $data->id }}'><i
                                                        class='fa fa-edit'></i> </button>
                                                <!-- Form untuk menghapus -->
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
                                                    action='{{ route('nilai-ekstrakurikuler.update', $data->id) }}'
                                                    method='POST'>
                                                    @csrf
                                                    @method('PATCH')

                                                    <x-inputallin>type:Nilai:nilai:nilai:id_nilai:{{ $data->nilai }}:Required</x-inputallin>
                                                    <x-inputallin>type:Predikat:Predikat:predikat:id_predikat:{{ $data->predikat }}:</x-inputallin>

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
{{-- <button class='btn btn-warning btn-sm' onclick='NilaiEkstra()'><i class='fa fa-edit right'></i> Edit</button> --}}
{{--

 --}}

<script>
    function NilaiEkstra(data) {
        var NilaiEkstra = new bootstrap.Modal(document.getElementById('NilaiEkstra'));
        NilaiEkstra.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='NilaiEkstra' tabindex='-1' aria-labelledby='LabelNilaiEkstra' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelNilaiEkstra'>
                    Ubah Data Nilai Ekstra
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <form id='#id' action='{{ route('update.bulk.nilai.ekstra') }}' method='POST'>
                    @csrf
                    @method('POST')
                    <div class="cal-xl-12 my-2">
                        <div class='card-header bg-primary'>
                            <h3 class='card-title'>Data Predikat System</h3>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Interval Nilai</th>
                                    <th>Predikat</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Nilai < 70</td>
                                    <td><span class="bg-warning p-2">C</span></td>
                                    <td>Perlu Perbaikan</td>
                                </tr>
                                <tr>
                                    <td>70 <= Nilai < 85</td>
                                    <td><span class="bg-primary p-2">B</span></td>
                                    <td>Baik</td>
                                </tr>
                                <tr>
                                    <td>Nilai >= 85</td>
                                    <td><span class="bg-success p-2">A</span></td>
                                    <td>Sangat Baik</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class='alert alert-info alert-dismissible'>
                            <button type='button' class='close' data-dismiss='alert'
                                aria-hidden='true'>&times;</button>
                            <h5><i class='icon fas fa-info'></i> Information !</h5>
                            <hr>
                            System akan bekerja jika anda tidak mengisi predikat secara manual, jadi jika predikat kosong akan di buat data predikat tanpa disimpan di database

                        </div>
                    </div>
                    <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                        <thead>
                            <tr class='table-primary text-center align-middle'>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th width='15%'>Nilai</th>
                                <th width='10%'>Predikat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                                {{-- blade-formatter-disable --}}
                            <tr class='text-center align-middle'>

                                <td class='text-center'>{{ $loop->iteration }}</td>
                                <td class='text-left'> {{ $data->Siswa->nama_siswa }}</td>
                                <td class='text-left'> {{ $data->KelasOne->kelas }}</td>
                                <td class='text-center'> <input type="hidden" class='form-control text-center' name='id[]' value='{{ $data->id }}'><input type="number" class='form-control text-center' name='nilai[]' value='{{ $data->nilai }}'></td>
                                <td class='text-center'> <input type="text" class='form-control text-center' name='predikat[]' value='{{ $data->predikat }}'></td>
                            </tr>
                            {{-- blade-formatter-enable --}}
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class='table-primary text-center align-middle'>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Nilai</th>
                                <th>Predikat</th>
                            </tr>
                        </tfoot>
                    </table>

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
        initDataTable('#example1', 'Data Nilai Peserta Ekstra', '#example1_wrapper .col-md-6:eq(0)');
    });

    // Fungsi untuk inisialisasi DataTable
    function initDataTable(tableId, exportTitle, buttonContainer) {
        // Hancurkan DataTable jika sudah ada
        $(tableId).DataTable().destroy();

        // Inisialisasi DataTable
        var table = $(tableId).DataTable({
            lengthChange: false,
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
