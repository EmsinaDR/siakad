@php
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
    use App\Models\User\Siswa\Detailsiswa;

    // Ambil semua siswa dengan eager loading kelas
    $data_siswa = Detailsiswa::with('DetailsiswaToKelas')->whereNotNull('kelas_id')->orderBy('kelas_id')->get();

    // Ambil semua absensi hari ini untuk semua siswa
    $absensi_hari_ini = \App\Models\Absensi\Eabsen::whereDate('created_at', Carbon::today())
        ->get()
        ->keyBy('detailsiswa_id'); // bikin key map by user_id
@endphp
<x-layout>
    @php
        $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
        $urlroot = app('request')->root();
    @endphp
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
            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->
            <div class="row mx-2">
                {{-- blade-formatter-disable --}}
               <div class="col-xl-2 mt-4">
                <button type="button" onclick="CekDataAbsensi()"
                    class="btn bg-warning btn-block btn-xl d-flex justify-content-left align-items-center mb-2">
                    <i class="fa fa-print mr-2"></i> Laporan Harian
                </button>

                <button type="button" onclick="CekDataAbsensi()"
                    class="btn bg-success btn-block btn-xl d-flex justify-content-left align-items-center mb-2">
                    <i class="fa fa-check mr-2"></i> Cek Data Absensi
                </button>

                <button type="button" onclick="absenNow()"
                    class="btn bg-secondary btn-block btn-xl d-flex justify-content-left align-items-center mb-2">
                    <i class="fa fa-qrcode mr-2"></i> Mulai Absensi
                </button>

                <a href="{{ route('absensi.rekap.absensi.cetak') }}" class="btn bg-secondary btn-block btn-xl d-flex justify-content-left align-items-center mb-2">
                    <i class="fa fa-print mr-2"></i> Cetak Rekap
                </a>

                <button type="button"
                    class='btn btn-block btn-default bg-primary btn-md text-left' data-toggle='modal' data-target='#DataIjinSakit'>
                    <i class="fa fa-qrcode mr-2"></i> Input Ketidak Hadiran
                </button>
                <button type="button"
                    class='btn btn-block btn-default bg-primary btn-md text-left' data-toggle='modal' data-target='#RiawaytAbsensi'>
                    <i class="fa fa-qrcode mr-2"></i> Riwayat Absen
                </button>
            </div>
                {{-- blade-formatter-enable --}}
                {{-- <script>
                    function absenNow() {
                        setTimeout(function() {
                            window.location.href = "{{ route('absensi.absensiSiswa') }}"
                        }, 3000); // Redirect setelah 3 detik
                    }
                </script> --}}
                <script>
                    function absenNow() {
                        setTimeout(function() {
                            window.location.href = "{{ secure_url(route('absensi.absensiSiswa', [], false)) }}";
                        }, 3000);
                    }
                </script>

                <div class="col-xl-4 mt-4 mb-2">
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>Rekapitulasi Absen</h3>
                    </div>
                    <table id='example2x' width='100%' class='table table-responsive table-bordered table-hover mt-1'
                        style='font-size:13pt'>
                        <thead style='background-color:#D4ECFC'>
                            <tr class="text-center align-middle">
                                <th width='1%'>No</th>
                                <th>Kelas</th>
                                <th>Jumlah Siswa Absen</th>
                                <th>Ceklist</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($jumlahAbsenPerKelas as $index => $data)
                                {{-- blade-formatter-disable --}}
                                <tr>
                                    <td class='text-center'>{{ $loop->iteration }}</td>
                                    <td class='text-center'>{{ $data->kelas }}</td>
                                    <td class='text-center'>{{ $data->jumlah_absen }}</td>
                                    @php
                                        $find_Detailsiswa = App\Models\User\Siswa\Detailsiswa::where('kelas_id',  $data->id)->count();
                                    @endphp
                                    <td class='text-center' style='font-size:15pt'>
                                        @if ($find_Detailsiswa - $data->jumlah_absen !== 0)
                                            <span> <i class='fa fa-times-circle p-2 text-danger'></i><span>
                                        @else
                                            <span> <i class='fa fa-check-circle p-2 text-success'></i><span>
                                        @endif
                                    </td>
                                </tr>
                                {{-- blade-formatter-enable --}}
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada absensi hari ini</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot style='background-color:#D4ECFC'>
                            <tr class="text-center align-middle">
                                <th width='1%'>No</th>
                                <th>Kelas</th>
                                <th>Jumlah Siswa Absen</th>
                                <th>Ceklist</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="col-xl-6">
                    <div class='card-header mt-4 mb-2' style='background:#D7F4F4'>
                        <h3 class='card-title'>Rekapitulasi Absen</h3>
                    </div>
                    {{-- blade-formatter-disable --}}
                    <x-grafik>{{ implode(',', $label_grafik) }}/{{ implode(',', $data_grafik) }}/bar/100%,75%/Garfik Absensi Siswa,Data Absensi Siswa</x-grafik>
                    {{-- blade-formatter-enable --}}
                </div>
            </div>
            <hr>
            <div class='ml-2 my-4'>

                <table id='example1' width='100%' class='table table-bordered table-hover'>
                    <thead>
                        <tr class='table-primary text-center align-middle'>
                            <th width='1%'>ID</th>
                            @foreach ($arr_ths as $arr_th)
                                <th class='text-center'> {{ $arr_th }}</th>
                            @endforeach
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($AbsensiHaraIni as $data)
                            <tr>
                                {{-- blade-formatter-disable --}}
                                <td class='text-center'>{{ $loop->iteration }}</td>
                                <td class='text-left'>
                                    {{ Carbon::create($data->waktu_absen)->translatedformat('l, d F Y') }}
                                </td>
                                <td class='text-center'>
                                    {{ Carbon::create($data->created_at)->format('H:i:s') }}
                                </td>
                                <td class='text-center'>
                                    {{ $data->EabsentoDetailsiswa->nis }}
                                </td>
                                <td class='text-left'>
                                    {{ $data->EabsentoDetailsiswa->nama_siswa }}</td>
                                <td class='text-center'>
                                    {{ $data->EabsentoDetailsiswa->Detailsiswatokelas->kelas }}
                                </td>
                                <td class='text-left text-center'>
                                    @if ($data->absen === 'hadir')
                                        <span class="bg-success p-2">{{ ucfirst($data->absen) }}</span>
                                    @else
                                        <span class="bg-danger p-2">{{ ucfirst($data->absen) }}</span>
                                    @endif
                                </td>
                                {{-- blade-formatter-enable --}}
                                <td>
                                    {{-- blade-formatter-disable --}}
                                    <div class='gap-1 d-flex justify-content-center'>
                                        </button>
                                        <!-- Button untuk mengedit -->
                                        <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'> <i class='fa fa-edit'></i></button>
                                        <!-- Form untuk menghapus -->
                                        <form action='{{ route('absensi.data-absensi-siswa.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                            @csrf
                                            @method('DELETE')
                                            <button type='submit' class='btn btn-danger btn-sm btn-equal-width' onclick="return confirm(' Apakah Anda yakin ingin menghapus data ini?');"><i class='fa fa-trash'></i></button>
                                        </form>
                                    </div>
                                    {{-- blade-formatter-enable --}}

                                    {{-- Modal View Data Akhir --}}
                                    <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                        aria-labelledby='EditModalLabel' aria-hidden='true'>
                                        <x-edit-modal>
                                            <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                            <section>
                                                <form id='updateurl' action='{{ route('absensi.data-absensi-siswa.update', $data->id) }}' method='POST'>
                                                    @csrf
                                                    @method('PATCH')
                                                    @php
                                                        $valueAbsens = ['hadir', 'alfa', 'sakit', 'ijin'];
                                                    @endphp

                                                    {{-- blade-formatter-disable --}}
                                                    <div class='form-group'>
                                                        <label for='detailsiswa_id'>Nama Siswa</label>
                                                        <input type='text' class='form-control' id='detailsiswa_id_edit' name='detailsiswa_id' placeholder='Nama Siswa' value='{{ $data->detailsiswa->nama_siswa }}' readonly>
                                                    </div>
                                                    <div class='form-group'>
                                                        <label for='absen'>Absensi</label>
                                                        <select name='absen' id='id' class='select2 form-control' required>
                                                            @foreach($valueAbsens as $valueAbsen)
                                                                <option value='{{$valueAbsen}}'  @if($data->absen === $valueAbsen) selected @endif >{{ucfirst($valueAbsen)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class='modal-footer'>
                                                        <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                                                    </div>
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
                                                //Content View
                                            </section>
                                        </x-view-modal>
                                    </div>
                                    {{-- Modal View Akhir --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <script>
                    $('#example2').DataTable({
                        searching: true, // Pastikan fitur search diaktifkan
                        lengthChange: true
                    });
                </script>
            </div>
        </div>
    </section>

    {{-- Modal Data Absensi --}}
    <div class='modal fade' id='CekDataAbsensi' tabindex='-1' aria-labelledby='LabelCekDataAbsensi' aria-hidden='true'>
        <div class='modal-dialog modal-lg'>
            <div class='modal-content'>
                <div class='modal-header bg-primary'>
                    <h5 class='modal-title' id='LabelCekDataAbsensi'>
                        Cek Absensi Hari Ini
                    </h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                    <table id='example4' width='100%' class='table table-bordered table-hover'>
                        <thead>
                            <tr class='text-center align-middle'>
                                <th class='text-center' width='1%'>ID</th>
                                <th>NIS</th>
                                <th width='35%'>Nama</th>
                                <th>Kelas</th>
                                <th>Jam</th>
                                <th>Ceklist</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_siswa as $siswa)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $siswa->nis }}</td>
                                    <td>{{ $siswa->nama_siswa }}</td>
                                    <td class="text-center">
                                        {{ optional($siswa->DetailsiswaToKelas)->kelas ?? '-' }}
                                    </td>

                                    @php
                                        $absen = $absensi_hari_ini->get($siswa->id); // ambil berdasarkan user_id
                                    @endphp

                                    <td class="text-center">
                                        @if ($absen)
                                            {{ \Carbon\Carbon::create($absen->waktu_absen)->format('H:i:s') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($absen)
                                            <i class="text-success fa fa-check"></i>
                                        @else
                                            <i class="text-danger fa fa-times"></i>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class='text-center' width='1%'>ID</th>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Jam</th>
                                <th>Ceklist</th>
                            </tr>
                        </tfoot>
                    </table>

                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                    <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                </div>
            </div>
        </div>

    </div>

</x-layout>


<script>
    function FNAbsenQr(data) {
        var AbsenQr = new bootstrap.Modal(document.getElementById('AbsenQr'));
        AbsenQr.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='AbsenQr' tabindex='-1' aria-labelledby='LabelAbsenQr' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelAbsenQr'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                content

            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
            </div>
        </div>
    </div>

</div>

<script>
    function CekDataAbsensi(data) {
        var CekDataAbsensi = new bootstrap.Modal(document.getElementById('CekDataAbsensi'));
        CekDataAbsensi.show();
        document.getElementById('Eid').value = data.id;
    }
</script>
<script>
    $(document).ready(function() {
        initDataTable('#example1', 'Data Absensi Siswa', '#example1_wrapper .col-md-6:eq(0)');
        initDataTable('#example2', 'Data Absensi Kelas - {{ Carbon::now()->format('d M Y') }}',
            '#example2_wrapper .col-md-6:eq(0)');
        initDataTable('#example4', 'Data Absensi - {{ Carbon::now()->format('d M Y') }}',
            '#example4_wrapper .col-md-6:eq(0)');
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


{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='DataIjinSakit' tabindex='-1' aria-labelledby='LabelDataIjinSakit' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelDataIjinSakit'>
                    Tambah Data Tidak Hadir
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                {{-- <form id='DataIjinSakit-form' action='' method='POST'> --}}
                <form id='DataIjinSakit-form' action='{{ route('absensi.AbsenManual') }}' method='POST'>
                    @csrf
                    @method('POST')
                    <div class='form-group'>
                        <label for='absen'>Absensi</label>
                        <select name='absen' id='id' class='select2 form-control' required>
                            <option value=''>--- Pilih Label ---</option>
                            <option value='hadir'>Hadir</option>
                            <option value='alfa'>Alfa</option>
                            <option value='sakit'>Sakit</option>
                            <option value='ijin'>Ijin</option>
                        </select>
                    </div>
                    <div class='form-group'>
                        <label for='detailsiswa_id'>Nama Siswa</label>
                        <select name='detailsiswa_id[]' id='detailsiswa_id' data-placeholder='Pilih Data Nama Siswa'
                            multiple='multiple' class='select2 form-control' required>
                            <option value=''>--- Pilih Nama Siswa ---</option>
                            @foreach ($Siswas as $newSiswa)
                                <option value='{{ $newSiswa->id }}'>{{ $newSiswa->nama_siswa }}</option>
                            @endforeach
                        </select>
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

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='RiawaytAbsensi' tabindex='-1' aria-labelledby='RiawaytAbsensi' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='RiawaytAbsensi'>
                    Riwayat Data Absensi
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <form id='RiawaytAbsensi-form' action='{{ route('absensi.riwayat.absensi.global') }}'
                    method='POST'>
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class='form-group'>
                            <label for='detailsiswa_id'>Nama Siswa</label>
                            <select name='detailsiswa_id' id='detailsiswa_id'
                                data-placeholder='Pilih Data Nama Siswa' class='select2 form-control' required>
                                <option value=''>--- Pilih Nama Siswa ---</option>
                                @foreach ($Siswas as $newSiswa)
                                    <option value='{{ $newSiswa->id }}'>{{ $newSiswa->nama_siswa }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class='col-xl-6 form-group'>
                            <label for='tanggal_awal'>Tanggal Awal</label>
                            <input type='date' class='form-control' id='tanggal_awal' name='tanggal_awal'
                                placeholder='placeholder' required>
                        </div>
                        <div class='col-xl-6 form-group'>
                            <label for='tanggal_akhir'>Tanggal Akhir</label>
                            <input type='date' class='form-control' id='tanggal_akhir' name='tanggal_akhir'
                                placeholder='placeholder' required>
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
