    @php
        use App\Models\User\Siswa\Detailsiswa;
    @endphp
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- {{ dd($users) }} --}}
    <x-layout>
        <x-slot:title>{{ $title }}</x-slot:title>
        <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>

        <section class='content mx-2'>
            <div class='card'>
                {{-- Papan Informasi --}}
                <div class="card p-2">
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>Menu Pengaturan Kelas</h3>
                    </div>
                    {{-- blade-formatter-disable --}}
                    <div class="row m-2">
                        <div class="col-xl-2">
                            <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#TambahKelas'><i class='fa fa-plus'></i> Tambah Kelas </button>
                            <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#PindahKelas'><i class='fa fa-plus'></i> Pindah Kelas </button>
                        </div>
                        <div class="col-xl-10"></div>
                    </div>
                   {{-- blade-formatter-enable --}}
                </div>


                {{-- Papan Informasi --}}
                <div class='card'>
                    <!--Car Header-->
                    <div class='card-header bg-primary mx-2'>
                        <h3 class='card-title'>{{ $title }}</H3>
                    </div>
                    <!--Car Header-->


                    <div class='card-body mr-2 ml-2'>
                        <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                            <thead>
                                <tr class='text-center align-middle'>
                                    <th class='text-center align-middle' colspan='1' rowspan='2' width='1%'>ID
                                    </th>
                                    @foreach ($arr_ths as $arr_th)
                                        <th class='text-center align-middle'
                                            @if ($arr_th === 'Jumlah Siswa') colspan='3' rowspan='1' @else colspan='1' rowspan='2' @endif>
                                            {{ $arr_th }}</th>
                                    @endforeach
                                    <th colspan='1' rowspan='2' class='text-center align-middle' width='20%'>
                                        Action</th>
                                </tr>
                                <th class='text-center'>L</th>
                                <th class='text-center'>P</th>
                                <th class='text-center'>Total</th>
                            </thead>
                            <tbody>
                                @foreach ($DataKelas as $data)
                                    @php
                                        $dataSiswaKelas = Detailsiswa::where('kelas_id', $data->id)->get();
                                    @endphp
                                    <tr class='text-center'>

                                        <td class='text-center'>{{ $loop->iteration }} </td>
                                        <td class='text-center'> {{ $data->kelastotapel->tapel }} -
                                            {{ $data->kelastotapel->tapel + 1 }}</td>
                                        <td class='text-center'> {{ $data->kelastotapel->semester ?? '' }}</td>
                                        <td class='text-center'> {{ $data->kelas }}</td>
                                        <td class='text-center'> {{ $data->siswas_laki_count }}</td>
                                        <td class='text-center'> {{ $data->siswas_perempuan_count }}</td>
                                        <td class='text-center'> {{ $data->siswas_count ?? '' }}</td>
                                        {{-- blade-formatter-disable --}}
                                        <td width='25%'>
                                             {{ $data->kelastoDetailguru->nama_guru ?? '' }}, {{ $data->kelastoDetailguru->gelar ?? '' }}
                                        </td>
                                       {{-- blade-formatter-enable --}}
                                        <td width="10%">
                                            <div class="d-flex justify-content-center gap-1">
                                                {{-- blade-formatter-disable --}}
                                                <button type="button" class="btn btn-success btn-sm equal-btn" data-toggle="modal" data-target="#uploadSiswa{{ $data->id }}">
                                                    <i class="fa fa-upload"></i>
                                                </button>

                                                <button type="button" class="btn btn-warning btn-sm equal-btn" data-toggle="modal" data-target="#editModal{{ $data->id }}">
                                                    <i class="fa fa-edit"></i>
                                                </button>

                                                <form id="delete-form-{{ $data->id }}" action="{{ route('kelas.destroy', $data->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>

                                                <button type="button" class="btn btn-danger btn-sm equal-btn" onclick="confirmDelete({{ $data->id }})">
                                                    <i class="fa fa-trash"></i>
                                                </button>
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
                                                <form id='updateEdata' action='{{ route('kelas.update', $data->id) }}'
                                                    method='POST'>
                                                    @csrf
                                                    @method('PATCH')
                                                    <x-inputallin>readonly:Kelas:Kelas:kelas:id_kelas:{{ $data->kelas }}:readonly</x-inputallin>
                                                    <x-inputallin>readonly:Semester:Semester:semester:id_semester:{{ $data->semester }}:readonly</x-inputallin>
                                                    <x-inputallin>readonly:Jumlah Siswa:Jumlah Siswa:jumlah_siswa:id_jumlah_siswa:{{ $data->siswas_count ?? '' }}:readonly</x-inputallin>
                                                    <div class="form-group">
                                                        <label for="detailguru_id{{ $data->id }}">Wali Kelas</label>
                                                        <select name="detailguru_id" id="detailguru_id{{ $data->id }}" class="select2 form-control" required>
                                                            <option value="">Pilih Wali Kelas</option>
                                                            @foreach ($Gurus as $userguru)
                                                                <option value="{{ $userguru->id }}"
                                                                    {{ $data->detailguru_id == $userguru->id ? 'selected' : '' }}>
                                                                    {{ $userguru->nama_guru }}
                                                                </option>

                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'> Kirim</button>
                                                </form>

                                                {{-- blade-formatter-enable --}}
                                            </section>
                                        </x-edit-modal>
                                    </div>
                                    {{-- Modal Edit Data Akhir --}}
                                    {{-- Modal View --}}
                                    <div class='modal fade' id='uploadSiswa{{ $data->id }}' tabindex='-1'
                                        aria-labelledby='ViewModalLabel' aria-hidden='true'>
                                        <x-view-modal>
                                            <x-slot:titleviewModal>Upload Data Siswa</x-slot:titleviewModal>
                                            {{-- blade-formatter-disable --}}
                                                <form action="{{ route('SiswaInKelas') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <x-inputallin>readonly:Kelas:Kelas:kelas:id_kelas_id:{{ $data->kelas }}:readonly</x-inputallin>
                                                    <input type="hidden" name='kelas_id' value='{{ $data->id }}'>
                                                    <x-inputallin>readonly:AktiF:Aktif:aktiv:id_aktiv:{{ $data->aktiv }}:Disabled</x-inputallin>
                                                    <x-inputallin>readonly:Jumlah Siswa:Jumlah Siswa:jumlah_siswa:id_jumlah_siswa:{{ $data->siswas_count ?? '' }}:Disabled</x-inputallin>
                                                    @if ($data->detailguru_id !== null)
                                                    @else
                                                        <x-inputallin>dropdown-single:Wali Kelas:Wali Kelas:detailguru_id:id_detailguru_id::Disabled</x-inputallin>
                                                    @endif
                                                    <div class="ml-2">
                                                        <div class="mb-3">
                                                            <label for="datasiswa" class="form-label fw-bold">📂 Upload Data Siswa</label>
                                                            <input type="file" name="datasiswa" id="datasiswa" class="form-control" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary w-100"> <i class="fa fa-upload"></i> Upload </button>
                                                    </div>
                                                </form>
                                                {{-- blade-formatter-enable --}}
                                        </x-view-modal>
                                    </div>
                                    {{-- Modal View Akhir --}}
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </section>

    </x-layout>

    <script>
        function TambahKelas(data) {
            var TambahKelas = new bootstrap.Modal(document.getElementById('TambahKelas'));
            TambahKelas.show();
            // document.getElementById('Eid').value = data.id;
        };
    </script>
    @php
        $alphabet = range('A', 'Z');
    @endphp
    {{-- Modal Edit Data Awal --}}
    <div class='modal fade' id='TambahKelas' tabindex='-1' aria-labelledby='TambahKelasLabel' aria-hidden='true'>
        <div class='modal-dialog modal-lg'>
            {{-- <form id='#id' action='admin/kelas/createbulk' method='POST'> --}}
            <form id='#id' action='{{ route('kelas.store') }}' method='POST'>
                @csrf
                @method('POST')
                <div class='modal-content'>
                    <div class='modal-header bg-primary'>
                        <h5 class='modal-title' id='TambahKelasLabel'>
                            Tambah Kelas
                        </h5>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>
                    <div class='modal-body'>
                        <x-dropdown-create-kelas>col-12</x-dropdown-create-kelas>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
    <script>
        $(document).ready(function() {
            initDataTable('#example1', 'Data Kelas Tahun {{ date('Y') }}',
                '#example1_wrapper .col-md-6:eq(0)');
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


    {{-- Modal Edit Data Awal --}}
    <div class='modal fade' id='PindahKelas' tabindex='-1' aria-labelledby='LabelPindahKelas' aria-hidden='true'>
        <div class='modal-dialog modal-lg'>
            <div class='modal-content'>
                <div class='modal-header bg-primary'>
                    <h5 class='modal-title' id='LabelPindahKelas'>
                        Ubah Kelas Siswa
                    </h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>

                    <form id='PindahKelas-form' action='{{ route('ekelas.pindah') }}' method='POST'>
                        @csrf
                        @method('POST')
                        <div class='card'>
                            <div class='card-header bg-info'>
                                <h3 class='card-title'><i class='fas fa-text-width'></i>Informasi</h3>
                            </div><!-- /.card-header -->
                            <div class='card-body'>
                                <dl>
                                    <dt>Perpindahan Kelas</dt>
                                    <dd>Digunakan untuk mengatur siswa yang ingin pindah kelas baik secara perorangan
                                        atau beberapa orang</dd>
                                    <dt>Kenaikan Kelas</dt>
                                    <dd>Menu ini bisa digunakan menaikkan kelas atau merubah dari kelas 7 menjadi kelas
                                        8, <br><b class='text-info'>Catatan :</b><br> Sebelum menaikkan agar tidak
                                        membingungkan mulai dari kelas atas, khususnya kelas 9 diluluskan terlebih
                                        dahulu agar kelas 9 kosong, dan lanjut kelas 7 ke kelas IX, berikutnya kelas 7
                                        ke kelas 8.</dd>
                                    <dt>Paket Premium</dt>
                                    <dd>Pada paket premium terintegrasi dengan pengumuman kelulusan, sehingga begitu
                                        dinyatakan lulus kelas 9 sudah tidak ada lagi dan kosong, sehingga bisa langsung
                                        menaikkan kelas 8 ke kelas 9</dd>
                                </dl>
                            </div><!-- /.card-body -->
                        </div>
                        <div class='form-group'>
                            <label for='detailsiswa_id'>Nama Siswa</label>
                            <select name='detailsiswa_id[]' id='id' multiple class='select2 form-control'
                                data-placeholder='Pilih siswa' required>
                                <option value=''>--- Pilih Nama Siswa ---</option>
                                @foreach ($Siswas as $siswa)
                                    <option value='{{ $siswa->id }}'>{{ $siswa->nama_siswa }} -
                                        {{ $siswa->KelasOne->kelas ?? '' }}</option>
                                @endforeach
                            </select>
                            <div class='form-group'>
                                <label for='kelas_id'>Kelas</label>
                                <select name='kelas_id' id='kelas_id' data-placeholder='Pilih Data Kelas'
                                    class='select2 form-control' required>
                                    @foreach ($Kelas as $newKelass)
                                        <option value='{{ $newKelass->id }}'>{{ $newKelass->kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- blade-formatter-disable --}}
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
