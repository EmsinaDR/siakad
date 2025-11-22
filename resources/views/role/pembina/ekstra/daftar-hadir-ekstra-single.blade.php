@php
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
            <div class='container-fluid'>
                <div class='row'>
                    <div class='col'>
                        <!-- Papan Informasi  -->
                        <div class='row mx-2'>
                            <div class='col-lg-4 col-6'>
                                <!-- small box / Data BOX-->
                                <div class='small-box bg-info'><!-- Background -->
                                    <h3 class='m-2'>Anggota Ekstra</h3><!-- Judul -->
                                    <div class='inner'><!-- Isi Kontent -->
                                        <div class='d-flex justify-content-between'>
                                            <span>Kelas VII</span><span>{{ $anggotaekstra_vii->count() }}</span>
                                        </div>
                                        <div class='d-flex justify-content-between'>
                                            <span>Kelas VIII</span><span>{{ $anggotaekstra_viii->count() }}</span>
                                        </div>
                                        <div class='d-flex justify-content-between'>
                                            <span>Kelas IX</span><span>{{ $anggotaekstra_ix->count() }}</span>
                                        </div>
                                        <hr class='bg-light' style='height: 2px;'>

                                        <div class='d-flex justify-content-between'>
                                            <span>Total</span><span>{{ $anggotaekstra_vii->count() + $anggotaekstra_viii->count() + $anggotaekstra_ix->count() }}</span>
                                        </div>
                                    </div>
                                    <div class='icon'>
                                        <i class='fa fa-user'></i><!-- Icon -->
                                    </div>
                                    <a href='#' class='small-box-footer'>More info <i
                                            class='fas fa-arrow-circle-right'></i></a>
                                </div>
                                <!-- small box -->
                            </div>
                            <!-- ./col -->
                            <div class='col-lg-4 col-6'>
                                <!-- small box / Data BOX-->
                                <div class='small-box bg-warning'><!-- Background -->
                                    <h3 class='m-2'>Kas Ekstra</h3><!-- Judul -->
                                    <div class='inner'><!-- Isi Kontent -->
                                        <div class='d-flex justify-content-between'>
                                            <span>Kelas VII</span><span>{{ $anggotaekstra_vii->count() }}</span>
                                        </div>
                                        <div class='d-flex justify-content-between'>
                                            <span>Kelas VIII</span><span>{{ $anggotaekstra_viii->count() }}</span>
                                        </div>
                                        <div class='d-flex justify-content-between'>
                                            <span>Kelas IX</span><span>{{ $anggotaekstra_ix->count() }}</span>
                                        </div>
                                        <hr class='bg-light' style='height: 2px;'>

                                        <div class='d-flex justify-content-between'>
                                            <span>Total</span><span>{{ $anggotaekstra_vii->count() + $anggotaekstra_viii->count() + $anggotaekstra_ix->count() }}</span>
                                        </div>
                                    </div>
                                    <div class='icon'>
                                        <i class='fa fa-wallet'></i><!-- Icon -->
                                    </div>
                                    <a href='#' class='small-box-footer'>More info <i
                                            class='fas fa-arrow-circle-right'></i></a>
                                </div>
                                <!-- small box -->
                            </div>
                            <!-- ./col -->
                        </div>
                        <!-- Papan Informasi  -->
                        {{-- <x-footer></x-footer> --}}


                    </div>
                </div>
            </div>

            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>
                    {{ $title }}
                    <b>{{ optional($Ekstra_name?->Ekstra)->ekstra ?? 'Ekstra tidak tersedia' }}</b>
                </h3>

            </div>
            <!--Car Header-->

            <div class='ml-2 my-4'>
                <div class='row'>

                    <div class='col-xl-2 my-2'><button type='button'
                            class='btn btn-block btn-default bg-primary btn-md' onclick='DaftarHadir()'> <i
                                class='fa fa-plus'></i> Daftar Hadir</button></div>
                    <div class='col-xl-8 my-2'>

                    </div>
                </div>
                <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                    <thead>
                        <tr class='text-center table-primary'>
                            <th width='1%'>ID</th>
                            @foreach ($arr_ths as $arr_th)
                                <th class='text-center'> {{ $arr_th }}</th>
                            @endforeach

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr>

                                @php
                                    $jumlah_hadir = App\Models\WakaKesiswaan\Ekstra\DaftarHadirEkstra::where(
                                        'tapel_id',
                                        $etapels->id,
                                    )
                                        ->where('ekstra_id', request()->segment(3))
                                        ->where('detailsiswa_id', $data->detailsiswa_id)
                                        ->get();
                                @endphp

                                <td class='text-center'>{{ $loop->iteration }}</td>
                                <td class='text-center'> {{ $data->Siswa->nis }} / {{ $data->detailsiswa_id }}</td>
                                <td class='text-center'> {{ $data->Siswa->nama_siswa }}</td>
                                <td class='text-center'> {{ $data->Kelas->kelas }}</td>
                                <td class='text-center'> {{ $jumlah_hadir->count() }}</td>
                                <td class='text-center'>
                                    {{ Number::forHumans(($jumlah_hadir->count() / 40) * 100, 0) }}%</td>

                            </tr>
                            {{-- Modal View Data Akhir --}}

                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                aria-labelledby='EditModalLabel' aria-hidden='true'>

                                <x-edit-modal>
                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                    <section>
                                        <form id='updateurl' action='{{ route('absensi-ekstra.update', $data->id) }}'
                                            method='POST'>
                                            @csrf
                                            @method('PATCH')

                                            contentEdit

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
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>

    </section>
</x-layout>


<script>
    function DaftarHadir(data) {
        var DaftarHadir = new bootstrap.Modal(document.getElementById('DaftarHadir'));
        DaftarHadir.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='DaftarHadir' tabindex='-1' aria-labelledby='LabelDaftarHadir' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelDaftarHadir'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>

            <div class='modal-body'>
                <form id='#id' action='{{ route('absensi-ekstra.store') }}' method='POST'>
                    @csrf
                    @method('POST')
                    <div class='form-group'>
                        @php
                            $peserta_ekstras = App\Models\WakaKesiswaan\Ekstra\PesertaEkstra::where(
                                'ekstra_id',
                                request()->segment(3),
                            )->get();
                        @endphp

                        <!-- Checkbox Pilih Semua -->
                        <input type='checkbox' id='select_all'>
                        <label for='select_all'><i class="fa fa-user mr-2"></i> Pilih Semua Siswa</label>

                        <!-- Hidden input ekstra_id -->
                        <input type='hidden' name='ekstra_id' value='{{ request()->segment(3) }}'>

                        <!-- Dropdown Select2 -->
                        <select id='select2-1' name='detailsiswa_id[]' class='form-control' multiple='multiple'
                            data-placeholder='Pilih Siswa Hadir' style='width: 100%;'>
                            @foreach ($peserta_ekstras as $peserta_ekstra)
                                <option value='{{ $peserta_ekstra->detailsiswa_id }}'>
                                    {{ $peserta_ekstra->Siswa->nama_siswa }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            let selectAllCheckbox = document.getElementById("select_all");
                            let selectBox = document.getElementById("select2-1");

                            selectAllCheckbox.addEventListener("change", function() {
                                let allOptions = selectBox.options;
                                for (let i = 0; i < allOptions.length; i++) {
                                    allOptions[i].selected = this.checked;
                                }
                            });

                            // Jika ada perubahan manual di select, update status checkbox
                            selectBox.addEventListener("change", function() {
                                let allSelected = Array.from(selectBox.options).every(option => option.selected);
                                selectAllCheckbox.checked = allSelected;
                            });
                        });
                        $(document).ready(function() {
                            $('#select2-1').select2();

                            $('#select_all').on('change', function() {
                                if (this.checked) {
                                    let values = $('#select2-1 option').map(function() {
                                        return this.value;
                                    }).get();
                                    $('#select2-1').val(values).trigger('change'); // Pilih semua di Select2
                                } else {
                                    $('#select2-1').val(null).trigger('change'); // Hapus semua pilihan
                                }
                            });

                            $('#select2-1').on('change', function() {
                                let allSelected = ($('#select2-1 option').length === $('#select2-1').val().length);
                                $('#select_all').prop('checked', allSelected);
                            });
                        });
                    </script>


                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                    </div>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function() {
            initDataTable('#example1', 'Daftar Hadir Peserta Ekstra', '#example1_wrapper .col-md-6:eq(0)');
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
