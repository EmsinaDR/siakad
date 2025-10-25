@php
    use App\Models\User;
    $activecrud = collect([2, 3, 2, 8])->search(Auth::user()->id);
    use App\Models\User\Siswa\Detailsiswa;
    // use App\Models\User;
    // dd($activecrud);
@endphp
<style>
</style>
<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>
    <section class='content mx-2'>
        <div class='card'>
            <div class="card-body">
                {{-- blade-formatter-disable --}}
                <div class='row float-right'>
                    {{-- <x-btnjs>submit/Tambah File/fa fa-plus/btn btn-primary btn-xl bg-primary btn-app/CreateModal()</x-btnjs>
                    <x-btnjs>submit/Upload Data/fa fa-upload/btn btn-primary btn-xl bg-primary btn-app/TambahMapel()</x-btnjs>
                    <x-btnjs>submit/Mapel Aktiv/fa fa-check/btn btn-primary btn-xl bg-primary btn-app/ModalAktivMapel()</x-btnjs> --}}
                </div>
                {{-- blade-formatter-enable --}}
            </div>
            {{-- Papan Informasi --}}
            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }} {{ $Identitas->namasek }}</H3>
            </div>
            <!--Car Header-->
            <div class='card-body mr-2 ml-2'>
                <div class='card-body'>
                    <div class="col-xl-2">
                        <button type='button' class='btn btn-block btn-default bg-primary btn-md'
                            onclick='CreateModal()'><i class="fa fa-plus"></i> Tambah data</button>

                    </div>
                    <div class="col-xl-10"></div>
                </div>
                <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                    <thead>
                        <tr class='text-center'>
                            <th width='1%'>ID</th>
                            @foreach ($arr_ths as $arr_th)
                                <th class='text-center'> {{ $arr_th }}</th>
                            @endforeach
                            {{-- @if ($activecrud === 0 or $activecrud === 1) --}}

                            <th width='20%'>Action</th>
                            {{-- @endif --}}
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @dump($userDataGuru) --}}
                        @foreach ($userDataGuru as $data)
                            <tr>
                                <td class='text-center'>{{ $loop->iteration }}</td>
                                {{-- blade-formatter-disable --}}
                                @if ($data->foto === null or $data->foto === '')
                                    <td class='text-center'>
                                        <img src="{{asset('img/guru/user-guru.png')}}" alt="" style='width:50px;height:50px'>
                                    </td>
                                @else
                                    <td class='text-center'><img src="/img/guru/{{ $data->foto }}" alt="{{ $data->foto }}" style='width:35px;height:35px'></td>
                                @endif
                                <td>{{ ucwords_nama_dengan_gelar($data->UsersDetailgurus->nama_guru) ?? '' }}</td>
                                <td>{{ $data->UsersDetailgurus->nip ?? '' }}</td>
                                <td class='text-center text-middle'>{{ $data->UsersDetailgurus->nik ?? '' }}</td>
                                <td class='text-center text-middle'>{{ $data->UsersDetailgurus->lulusan ?? '' }}</td>
                                <td class='text-center text-middle'>{{ $data->UsersDetailgurus->tahun_lulus ?? '' }} </td>
                                <td class='text-center text-middle'>{{ $data->UsersDetailgurus->no_hp ?? '' }}</td>
                                <td>Rt {{ $data->UsersDetailgurus->rt ?? '' }}, Rw
                                    {{ $data->UsersDetailgurus->rw ?? '' }}, Desa
                                    {{ $data->UsersDetailgurus->desa ?? '' }}, Kecamatan
                                    {{ $data->UsersDetailgurus->kecamatan ?? '' }}</td>
                                <td class='text-center'>{{ $data->UsersDetailgurus->status ?? '' }}</td>
                                <td>{{ $data->UsersDetailgurus->pendidikan ?? '' }} -
                                    {{ $data->UsersDetailgurus->jurusan ?? '' }}
                                </td>
                                <td class='text-center'>{{ $data->UsersDetailgurus->jenis_kelamin ?? '' }}</td>
                                {{-- blade-formatter-enable --}}
                                <td width='10%'>
                                    <div class='gap-1 d-flex justify-content-center'>
                                        <!-- Button untuk melihat -->
                                        <button type='button' class='btn btn-success btn-sm btn-equal-width'
                                            data-toggle='modal' data-target='#viewModal{{ $data->id }}'>
                                            <i class='fa fa-eye'></i>
                                        </button>
                                        <!-- Button untuk mengedit -->
                                        <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                            data-toggle='modal' data-target='#editModal{{ $data->id }}'>
                                            <i class='fa fa-edit'></i>
                                        </button>
                                        <!-- Form untuk menghapus -->
                                        <form id='delete-form-{{ $data->id }}'
                                            action='{{ route('guru.destroy', $data->id) }}' method='POST'
                                            style='display: inline-block;'>
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button type='button' class='btn btn-danger btn-sm btn-equal-width'
                                            onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            {{-- Modal View Data Akhir --}}
                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                aria-labelledby='EditModalLabel' aria-hidden='true'>
                                <x-edit-modal>
                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                    <section>
                                        <form id='updateEtugas' action='{{ route('guru.update', $data->id) }}'
                                            method='POST'>
                                            @csrf
                                            @method('PUT')
                                            {{-- blade-formatter-disable --}}

                                            <x-inputallin>text:Nama:Nama Lengkap  Guru:nama_guru:id_nama_guru:{{ $data->UsersDetailgurus->nama_guru ?? '' }}:Required</x-inputallin>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <x-inputallin>:NIP:NIP:nip:id_nip:{{ $data->UsersDetailgurus->nip ?? '' }}:Required</x-inputallin>
                                                </div>
                                                <div class="col-xl-6">
                                                    <x-inputallin>:NIK:NIK:nik:id_nik:{{ $data->UsersDetailgurus->nik ?? '' }}:Required</x-inputallin>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <x-inputallin>text:Status:Status  Kepegawaian:status:id_status:{{ $data->UsersDetailgurus->status ?? '' }}:Required</x-inputallin>
                                                </div>
                                                <div class="col-xl-6">
                                                    <x-inputallin>text:Jenis Kelamin:Jenis  Kelamin:jenis_kelamin:id_jenis_kelamin:{{ $data->UsersDetailgurus->jenis_kelamin ?? '' }}:Required</x-inputallin>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <x-inputallin>text:Pendidikan Terakhir:Pendidikan Terakhir:pendidikan:id_pendidikan:{{ $data->UsersDetailgurus->pendidikan ?? '' }}:Required</x-inputallin>
                                                </div>
                                                <div class="col-xl-6">
                                                    <x-inputallin>text:Lulusan:Sekolah atau Kampus terakhir menempuh pendidikan:lulusan:id_lulusan:{{ $data->UsersDetailgurus->lulusan ?? '' }}:Required</x-inputallin>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <x-inputallin>text:Tahun Lulus:Tahun Lulus:tahun_lulus:id_tahun_lulus:{{ $data->UsersDetailgurus->tahun_lulus ?? '' }}:Required</x-inputallin>
                                                </div>
                                                <div class="col-xl-6">
                                                    <x-inputallin>text:Jurusan:Jurusan:jurusan:id_jurusan:{{ $data->UsersDetailgurus->jurusan ?? '' }}:Required</x-inputallin>
                                                </div>
                                            </div>
                                            <x-inputallin>textarea:Alamat:Alamat rumah saat ini:alamat:id_alamat:{{ $data->UsersDetailgurus->alamat ?? '' }}:rows=4  Required</x-inputallin>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <x-inputallin>text:Agama:Agama:agama:id_agama:{{ $data->UsersDetailgurus->agama ?? '' }}:Required</x-inputallin>
                                                </div>
                                                <div class="col-xl-6">
                                                    <x-inputallin>:No Handphone:No Handphone aktif:no_hp:id_no_hp:{{ $data->UsersDetailgurus->no_hp ?? '' }}:Required</x-inputallin>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <x-inputallin>:Tempat Lahir:Tempat Kelahiran:tempat_lahir:id_tempat_lahir:{{ $data->UsersDetailgurus->tempat_lahir ?? '' }}:Required</x-inputallin>
                                                </div>
                                                <div class="col-xl-6">
                                                    <x-inputallin>date:Tanggal Lahir:Tanggal kelahiran:tanggal_lahir:id_tanggal_lahir:{{ $data->UsersDetailgurus->tanggal_lahir ?? '' }}:Required</x-inputallin>
                                                </div>
                                            </div>
                                            <x-inputallin>date:TMT Mengajar:TMT Mengajar:tmt_mengajar:id_tmt_mengajar:{{ $data->UsersDetailgurus->tmt_mengajar ?? '' }}:Required</x-inputallin>
                                            <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'> Kirim</button>
                                            {{-- blade-formatter-enable --}}
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
                                        <x-inputallin>:Nama:Nama Lengkap
                                            Guru:nama_guru:id_nama_guru:{{ $data->UsersDetailgurus->nama_guru ?? '' }}:Disabled</x-inputallin>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <x-inputallin>:NIP:NIP:nip:id_nip:{{ $data->UsersDetailgurus->nip ?? '' }}:Disabled</x-inputallin>
                                            </div>
                                            <div class="col-xl-6">
                                                <x-inputallin>:NIK:NIK:nik:id_nik:{{ $data->UsersDetailgurus->nik ?? '' }}:Disabled</x-inputallin>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <x-inputallin>:Status:Status
                                                    Kepegawaian:status:id_status:{{ $data->UsersDetailgurus->status ?? '' }}:Disabled</x-inputallin>
                                            </div>
                                            <div class="col-xl-6">
                                                <x-inputallin>:Jenis Kelamin:Jenis
                                                    Kelamin:jenis_kelamin:id_jenis_kelamin:{{ $data->UsersDetailgurus->jenis_kelamin ?? '' }}:Disabled</x-inputallin>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <x-inputallin>:Pendidikan Terakhir:Pendidikan
                                                    Terakhir:pendidikan:id_pendidikan:{{ $data->UsersDetailgurus->pendidikan ?? '' }}:Disabled</x-inputallin>
                                            </div>
                                            <div class="col-xl-6">
                                                <x-inputallin>:Lulusan:Sekolah atau Kampus terakhir menempuh
                                                    pendidikan:lulusan:id_lulusan:{{ $data->UsersDetailgurus->lulusan ?? '' }}:Disabled</x-inputallin>
                                            </div>
                                        </div>
                                        <x-inputallin>:Tahun Lulus:Tahun
                                            Lulus:tahun_lulus:id_tahun_lulus:{{ $data->UsersDetailgurus->tahun_lulus ?? '' }}:Disabled</x-inputallin>
                                        <x-inputallin>textarea:Alamat:Alamat rumah saat
                                            ini:alamat:id_alamat:{{ $data->UsersDetailgurus->alamat ?? '' }}:rows=4
                                            Disabled</x-inputallin>

                                        <div class="row">
                                            <div class="col-xl-6">
                                                <x-inputallin>:Agama:Agama:agama:id_agama:{{ $data->UsersDetailgurus->agama ?? '' }}:Disabled</x-inputallin>
                                            </div>
                                            <div class="col-xl-6">
                                                <x-inputallin>:No Handphone:No Handphone
                                                    aktif:no_hp:id_no_hp:{{ $data->UsersDetailgurus->no_hp ?? '' }}:Disabled</x-inputallin>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <x-inputallin>:Tempat Lahir:Tempat
                                                    Kelahiran:tempat_lahir:id_tempat_lahir:{{ $data->UsersDetailgurus->tempat_lahir ?? '' }}:Disabled</x-inputallin>
                                            </div>
                                            <div class="col-xl-6">
                                                <x-inputallin>date:Tanggal Lahir:Tanggal
                                                    kelahiran:tanggal_lahir:id_tanggal_lahir:{{ $data->UsersDetailgurus->tanggal_lahir ?? '' }}:Disabled</x-inputallin>
                                            </div>
                                        </div>
                                        <x-inputallin>type:TMT Mengajar:TMT
                                            Mengajar:tmt_mengajar:id_tmt_mengajar:{{ $data->UsersDetailgurus->tmt_mengajar ?? '' }}:Disabled</x-inputallin>
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
                            {{-- @if ($activecrud === 0 or $activecrud === 1) --}}
                            <th>Action</th>
                            {{-- @endif --}}
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>
</x-layout>
{{-- {{ JavaScript Awal Modal}} --}}
<script>
    function CreateModal(data) {
        // Show Modal Create Data
        var CreateteModal = new bootstrap.Modal(document.getElementById('createModal'));
        CreateteModal.show();
        // Kirim Nilai Ke Modal byID
        // document.getElementById('ctapel_id').value = data.tapel_id;
    }
</script>
{{-- {{ JavaScript Modal Akhir }} --}}

{{-- Modal Create Data Awal --}}
<div class='modal fade' id='createModal' tabindex='-1' aria-labelledby='CreateModalLabel' aria-hidden='true'>
    <x-create-modal>
        <x-slot:titlecreateModal>{{ $titlecreateModal }}</x-slot:titlecreateModal>
        <section>
            <form id='updateEtugas' action='{{ route('guru.store') }}' method='POST'>
                @csrf
                @method('POST')
                <x-inputallin>hidden:::posisi:id_posisi:Guru:</x-inputallin>
                <x-inputallin>:Nama:Nama Lengkap Guru:nama_guru:id_nama_guru::Required</x-inputallin>
                <div class="row">
                    <div class="col-xl-6">
                        <x-inputallin>email:Email:Contoh user@gmail.com:email:id_email::Required</x-inputallin>
                    </div>
                    <div class="col-xl-6">
                        <x-inputallin>password:Password:Password:password:id_password::Required</x-inputallin>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <x-inputallin>:NIP:NIP:nip:id_nip::Required</x-inputallin>
                    </div>
                    <div class="col-xl-6">
                        <x-inputallin>:NIK:NIK:nik:id_nik::Required</x-inputallin>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <x-inputallin>:Status:Status Kepegawaian:status:id_status::Required</x-inputallin>
                    </div>
                    <div class="col-xl-6">
                        <x-inputallin>:Jenis Kelamin:Jenis
                            Kelamin:jenis_kelamin:id_jenis_kelamin::Required</x-inputallin>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <x-inputallin>:Pendidikan Terakhir:Pendidikan
                            Terakhir:pendidikan:id_pendidikan::Required</x-inputallin>
                    </div>
                    <div class="col-xl-6">
                        <x-inputallin>:Lulusan:Sekolah atau Kampus terakhir menempuh
                            pendidikan:lulusan:id_lulusan::Required</x-inputallin>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <x-inputallin>:Tahun Lulus:Tahun Lulus:tahun_lulus:id_tahun_lulus::Required</x-inputallin>
                    </div>
                    <div class="col-xl-6">
                        <x-inputallin>:Jurusan:Jurusan:jurusan:id_jurusan::Required</x-inputallin>
                    </div>
                </div>
                <x-inputallin>textarea:Alamat:Alamat rumah saat ini:alamat:id_alamat::rows=4 Required</x-inputallin>
                <div class="row">
                    <div class="col-xl-6">
                        <x-inputallin>:Agama:Agama:agama:id_agama::Required</x-inputallin>
                    </div>
                    <div class="col-xl-6">
                        <x-inputallin>:No Handphone:No Handphone aktif:no_hp:id_no_hp::Required</x-inputallin>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <x-inputallin>:Tempat Lahir:Tempat
                            Kelahiran:tempat_lahir:id_tempat_lahir::Required</x-inputallin>
                    </div>
                    <div class="col-xl-6">
                        <x-inputallin>date:Tanggal Lahir:Tanggal
                            kelahiran:tanggal_lahir:id_tanggal_lahir::Required</x-inputallin>
                    </div>
                </div>
                <x-inputallin>date:TMT Mengajar:TMT Mengajar:tmt_mengajar:id_tmt_mengajar::Required</x-inputallin>

                <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'>
                    Kirim</button>
            </form>
        </section>
    </x-create-modal>
</div>
{{-- Modal Create Data Akhir --}}
<script>
    $(document).ready(function() {
        initDataTable('#example1', 'Data Guru', '#example1_wrapper .col-md-6:eq(0)');
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
                //{
                //    extend: 'pdf',
                //    title: exportTitle,
                //    exportOptions: {
                //        columns: ':visible:not(.noprint)'
                //    }
                //},
                {
                    extend: 'pdf',
                    text: 'Export PDF (Landscape)', // Tombol untuk landscape
                    title: exportTitle,
                    orientation: 'landscape',
                    exportOptions: {
                        columns: ':visible:not(.noprint)'
                    }
                },
                {
                    extend: 'pdf',
                    text: 'Export PDF (Portrait)', // Tombol untuk portrait
                    title: exportTitle,
                    orientation: 'portrait',
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
                targets: [-1, -5, -6, -
                    9
                ], // Kolom terakhir (Action) bisgunkan array contoh [-1, -2, -4]
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
