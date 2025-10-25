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
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'> <i class='fa fa-plus'></i> Buat Jadwal</button>
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
                                <td class='text-center'> {{ Carbon::create($data->hari)->translatedformat('l, d F Y') }}
                                </td>
                                <td class='text-center'>
                                    @php
                                        $etapels = \App\Models\Admin\Etapel::where('aktiv', 'Y')->first();
                                        $kelasList = \App\Models\Program\JadwalShalat\JadwalShalat::where(
                                            'tapel_id',
                                            $etapels->id,
                                        )
                                            ->where('hari', $data->hari)
                                            ->pluck('kelas_id'); // Ambil daftar kelas_id
                                        $namaKelas = \App\Models\Admin\Ekelas::whereIn('id', $kelasList)
                                            ->pluck('kelas')
                                            ->toArray();
                                    @endphp
                                    {{ implode(', ', $namaKelas) }}
                                </td>
                                <td class='text-center'> {{ $data->Guru->nama_guru }}</td>
                                <td class='text-center'> {{ $data->keterangan }}</td>
                                <td width='10%'>
                                    <div class='gap-1 d-flex justify-content-center'>
                                        <!-- Button untuk mengedit -->
                                        <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                            data-toggle='modal' data-target='#editModal{{ $data->id }}'><i
                                                class='fa fa-edit'></i> </button>
                                        <!-- Form untuk menghapus -->
                                        <form id='delete-form-{{ $data->id }}'
                                            action='{{ route('jadwal-shalat.destroy', $data->id) }}' method='POST'
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
                                                    action='{{ route('jadwal-shalat.update', $data->hari) }}'
                                                    method='POST'>
                                                    @csrf
                                                    @method('PATCH')

                                                    {{-- blade-formatter-disable --}}
                                                    <div class="row">
                                                        <div class='col-xl-6 form-group'>
                                                            <label for='hari'>Tanggal</label>
                                                            <input type='date' class='form-control' id='hari' name='hari' value='{{ $data->hari }}' required>
                                                        </div>
                                                        <div class='col-xl-6 form-group'>
                                                            <label for='imam'>Nama Imam</label>
                                                            <select name='imam' id='imam_id-{{ $data->id }}' class='form-control' required>
                                                                <option value=''>--- Pilih Imam ---</option>
                                                                @foreach ($DataGurus as $DataGuru)
                                                                    <option value='{{ $DataGuru->id }}'>{{ $DataGuru->nama_guru }}</option>
                                                                @endforeach

                                                            </select>
                                                            <script>
                                                                $(document).ready(function() {
                                                                    // $('#semesteredit option[value='II']').prop('selected', true); // Single Select
                                                                    $('#imam_id-{{ $data->id }}').val(@json($data->imam)).trigger('change'); // Mutiple Select Select value in array json
                                                                });
                                                            </script>

                                                        </div>
                                                    </div>
                                                    <div class='form-group'>
                                                        <i class='fas fa-sticky-note'></i><label
                                                            for='keterangan'>Keterangan</label>
                                                        <textarea name='keterangan' id='keterangan' rows='3' class='form-control'
                                                            placeholder='Masukkan Keterangan Singkat'></textarea>
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
{{-- <button class='btn btn-warning btn-sm' onclick='TambahData()'><i class='fa fa-edit right'></i> Edit</button> --}}
{{--

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
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <div class="row">
                    <div class='col-xl-6 form-group'>
                        <label for='tanggal_awal'>Tanggal Mulai</label>
                        <input type='date' class='form-control' id='tanggal_awal' name='tanggal_awal' required>
                    </div>
                    <div class='col-xl-6 form-group'>
                        <label for='tanggal_akhir'>Tanggal Akhir</label>
                        <input type='date' class='form-control' id='tanggal_akhir' name='tanggal_akhir' required>
                    </div>
                </div>
                {{-- Hari yang dikecualikan --}}
                <div class="form-group">
                    <label for="excluded_days">Pilih Hari yang Dikecualikan:</label>
                    <select name="excluded_days[]" id="excluded_days" class="form-control select2" multiple>
                        @php
                            $hariIndo = [
                                'Monday' => 'Senin',
                                'Tuesday' => 'Selasa',
                                'Wednesday' => 'Rabu',
                                'Thursday' => 'Kamis',
                                'Friday' => 'Jumat',
                                'Saturday' => 'Sabtu',
                                'Sunday' => 'Minggu',
                            ];
                        @endphp
                        @foreach ($hariIndo as $key => $hari)
                            <option value="{{ $key }}">{{ $hari }}</option>
                        @endforeach
                    </select>

                    <br><small>
                        * Pilih hari yang ingin dikecualikan dari jadwal misalkan <b class="text-danger">minggu</b>
                        karena hari libur maka hari minggu tidak ada jadwal yang dibuat atau diliewati.</small>
                </div>

                <script>
                    $(document).ready(function() {
                        $('#excluded_days').select2({
                            placeholder: "Pilih hari yang dikecualikan...",
                            allowClear: true
                        });
                    });
                </script>

                {{-- Hari yang dikecualikan --}}

                <label for="excluded_dates">Pilih Tanggal yang Dikecualikan:</label>
                <select name="excluded_dates[]" id="excluded_dates" class="form-control select2" multiple></select>

                <br><small>
                    * Pilih tanggal yang ingin dikecualikan dari jadwal. Untuk tanggal libur pada kalender berbeda
                    dengan hari, ini <b class="text-success">hanya untuk tanggal</b>, tetapi jika hari maka semua hari
                    minggu akan dilewati</small>

                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                    <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                </div>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    $('#excluded_dates').select2({
                        placeholder: "Pilih tanggal yang dikecualikan, tuliskan hari untuk pencarian...",
                        allowClear: true
                    });

                    function generateDateOptions() {
                        let tanggalAwal = document.getElementById("tanggal_awal").value;
                        let tanggalAkhir = document.getElementById("tanggal_akhir").value;
                        let select = document.getElementById("excluded_dates");
                        select.innerHTML = ""; // Kosongkan dropdown sebelum diisi ulang

                        if (tanggalAwal && tanggalAkhir) {
                            let startDate = new Date(tanggalAwal);
                            let endDate = new Date(tanggalAkhir);

                            while (startDate <= endDate) {
                                let tanggalString = startDate.toISOString().split('T')[0];
                                let hari = startDate.toLocaleDateString('id-ID', {
                                    weekday: 'long',
                                    day: '2-digit',
                                    month: 'long',
                                    year: 'numeric'
                                });

                                let option = document.createElement("option");
                                option.value = tanggalString;
                                option.text = hari;
                                select.appendChild(option);

                                // Tambah 1 hari
                                startDate.setDate(startDate.getDate() + 1);
                            }
                        }
                    }

                    // Event listener saat tanggal_awal dan tanggal_akhir berubah
                    document.getElementById("tanggal_awal").addEventListener("change", generateDateOptions);
                    document.getElementById("tanggal_akhir").addEventListener("change", generateDateOptions);
                });
            </script>


        </div>
    </div>

</div>
<script>
    $(document).ready(function() {
        initDataTable('#example1', 'Data Jadwal Shalat Berjamaah', '#example1_wrapper .col-md-6:eq(0)');
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
                //{
                //     extend: 'pdf',
                //     text: 'Export PDF (Landscape)', // Tombol untuk landscape
                //     title: exportTitle,
                //     orientation: 'landscape',
                //     exportOptions: {
                //         columns: ':visible:not(.noprint)'
                //     }
                // },
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
