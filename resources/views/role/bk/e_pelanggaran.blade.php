@php
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
@endphp
<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>
    <section class='content mx-2'>
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
            <div class='card-body'>
                <div class='row float-right'>
                    <x-btnjs>submit/Tambah Data/fa fa-plus/btn btn-primary btn-xl bg-primary
                        btn-app/FNModalTmabah()</x-btnjs>
                </div>
            </div>
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->
            <div class='ml-2'>
                @php
                @endphp
                <div class='row'>
                    <div class="col col-xl-6 mt-2">
                        <div class='card-header bg-success'>
                            <h3 class='card-title'>
                                Data Point Siswa</h3>
                        </div>
                        <div class="card-body mt-2">
                            <table id="example2" class="table table-striped">
                                <thead class='table-success'>
                                    <tr class='text-center align-middle'>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>Jumlah Pelanggaran</th>
                                        <th>Total Point</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataTotals as $PelanggaranSiswa)
                                        <tr>
                                            <td class='text-center'>{{ $loop->iteration }}</td>
                                            <td>{{ $PelanggaranSiswa->siswa->nama_siswa ?? '' }}</td>
                                            <td class='text-center'>{{ $PelanggaranSiswa->kelas->kelas ?? '' }}</td>
                                            <td class='text-center'>{{ $PelanggaranSiswa->point }}</td>
                                            <td class='text-center'>
                                                <span
                                                    @if ($PelanggaranSiswa->total_point <= 20) class="bg-success border-pill p-2"
                                                @elseif($PelanggaranSiswa->total_point <= 40)
                                                class="bg-warning border-pill p-2"
                                                @else
                                                class="bg-danger border-pill p-2" @endif>
                                                    {{ $PelanggaranSiswa->total_point }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class='table-success'>
                                    <tr class='text-center align-middle'>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>Jumlah Pelanggaran</th>
                                        <th>Total Point</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="col col-xl-6 mt-2">
                        <div class='card-header bg-success'>
                            <h3 class='card-title'>
                                Data Point Siswa</h3>
                        </div>
                        {{-- Disini --}}
                        <div class='card-body'>
                            @php

                                $labels = collect($Kelas)->flatten(1);
                                $labels = $labels->values()->all();
                                $data = Cache::tags(['cache_data'])->remember(
                                    'remember_data',
                                    now()->addHours(2),
                                    function () {
                                        return App\Models\User\Siswa\Detailsiswa::whereNotNull('kelas_id')
                                            ->join('ekelas', 'detailsiswas.kelas_id', '=', 'ekelas.id')
                                            ->select(
                                                'ekelas.id',
                                                'ekelas.kelas',
                                                \DB::raw('COUNT(detailsiswas.kelas_id) as jumlah_siswa'),
                                            )
                                            ->groupBy('ekelas.id', 'ekelas.kelas')
                                            ->orderBy('ekelas.id')
                                            ->get();
                                    },
                                );

                                $kelasArray = $data->pluck('kelas')->toArray(); // Array label kelas
                                $jumlahSiswaArray = $data->pluck('jumlah_siswa')->toArray(); // Array jumlah siswa
                            @endphp

                            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                            <div style="width: 70%; margin: auto;">
                                <h3>Grafik Data Jumlah Siswa</h3>
                                <canvas id="myChart" width="400" height="400"></canvas>
                            </div>

                            <script>
                                const labels = @json($kelasArray);
                                const data = {
                                    labels: labels,
                                    datasets: [{
                                        label: 'Jumlah Siswa per Kelas',
                                        data: @json($jumlahSiswaArray),
                                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                        borderColor: 'rgba(54, 162, 235, 1)',
                                        borderWidth: 2,
                                        tension: 0.4
                                    }]
                                };

                                const config = {
                                    type: 'line', // Ganti ke 'bar' atau 'doughnut' sesuai selera
                                    data: data,
                                    options: {
                                        responsive: true,
                                        plugins: {
                                            legend: {
                                                position: 'top'
                                            },
                                            title: {
                                                display: true,
                                                text: 'Jumlah Siswa di Tiap Kelas'
                                            }
                                        }
                                    }
                                };

                                const ctx = document.getElementById('myChart').getContext('2d');
                                const myChart = new Chart(ctx, config);
                            </script>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                        <thead class='table-secondary'>
                            <tr class='text-center'>
                                <th width='1%'>ID</th>
                                @foreach ($arr_ths as $arr_th)
                                    <th class='text-center'> {{ $arr_th }}</th>
                                @endforeach

                                {{-- @if ($activecrud === 1) --}}
                                <th>Action</th>
                                {{-- @endif --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($DataPelanggaran as $data)
                                <tr>
                                    <td class='text-center'>{{ $loop->iteration }}</td>
                                    <td class='text-center'>
                                        {{ Carbon::create($data->created_at)->translatedformat('l, d F Y') }}</td>
                                    <td class='text-center'>
                                        @if ($data->pelaku_id !== null)
                                            {{ $data->Siswa->nama_siswa }}
                                        @endif
                                    </td>
                                    <td class='text-left'>
                                        @php
                                            $pelanggaranview = App\Models\bk\Ebkkreditpoint::whereIn(
                                                'id',
                                                json_decode($data->kreditpoint_id, true),
                                            )->get();
                                        @endphp
                                        @foreach ($pelanggaranview as $pelanggarans)
                                            Point( {{ $pelanggarans->point }} ) -
                                            {{ $pelanggarans->pelanggaran }}<br>
                                        @endforeach
                                    </td>

                                    <td class='text-center'> {{ $data->point }}</td>
                                    <td class='text-center'> {{ $data->kelas_korban_id }}</td>

                                    <td width='20%'>
                                        <div class='gap-1 d-flex justify-content-center'>
                                            <!-- Button untuk melihat -->
                                            <button type='button' class='btn btn-success btn-sm btn-equal-width'
                                                data-toggle='modal' data-target='#viewModal{{ $data->id }}'>
                                                <i class='fa fa-eye'></i> Lihat
                                            </button>
                                            <!-- Button untuk mengedit -->
                                            <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                                data-toggle='modal' data-target='#editModal{{ $data->id }}'>
                                                <i class='fa fa-edit'></i> Edit
                                            </button>
                                            <!-- Form untuk menghapus -->
                                            <form
                                                action='{{ route('pelanggaran.destroy', ['pelanggaran' => $data->id]) }}'
                                                method='POST' style='display: inline-block;'>
                                                @csrf
                                                @method('DELETE')
                                                <button type='submit' class='btn btn-danger btn-sm btn-equal-width'
                                                    onclick="return confirm(' Apakah Anda yakin ingin menghapus data ini?');">
                                                    <i class='fa fa-trash'></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                {{-- Modal View Data Akhir --}}
                                <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                    aria-labelledby='EditModalLabel' aria-hidden='true'>
                                    <x-edit-modal>
                                        <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                        <section>

                                            {{-- @json($dataupdate) --}}
                                            <form id='updatepelanggaran'
                                                action='{{ route('pelanggaran.update', $data->id) }}' method='POST'>
                                                @csrf
                                                @method('PATCH')


                                                {{-- DROPDOWN korban_id Multiple --}}

                                                {{-- blade-formatter-disable --}}
                                                @php
                                                    $id_korban = $data->korban_id;
                                                @endphp
                                                <div class='form-group'>
                                                    <label for='korban_id'>Korban</label>
                                                    <select id='id_korban-{{ $loop->index }}' class='select2' name='korban_id' data-placeholder='Tuliskan jika terjadi korban' style='width: 100%;'>
                                                        @foreach ($Siswas as $detailsiswa)
                                                            <option value='{{ $detailsiswa->id }}'>
                                                                {{ $detailsiswa->nama_siswa }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <script>
                                                    $(document).ready(function() {
                                                        $('#id_korban-{{ $loop->index }}').val(@json($id_korban)).trigger(
                                                            'change'); // Mutiple Select Select value in array json

                                                    });
                                                </script>

                                                {{-- DROPDOWN pelaku_id Multiple --}}

                                                @php
                                                    $id_pelaku = json_decode($data->pelaku_id, true); // Konversi JSON ke array
                                                @endphp
                                                <div class='form-group'>
                                                    <label for='pelaku_id'>Pelaku</label>
                                                    <select id='id_pelaku-{{ $loop->index }}' class='select2' name='pelaku_id' multiple='multiple' data-placeholder='Pelaku pelanggaran' style='width: 100%;'>
                                                        @foreach ($Siswas as $detailsiswa)
                                                            <option value='{{ $detailsiswa->id }}'>
                                                                {{ $detailsiswa->nama_siswa }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <script>
                                                    $(document).ready(function() {
                                                        $('#id_pelaku-{{ $loop->index }}').val(@json($id_pelaku)).trigger(
                                                            'change'); // Mutiple Select Select value in array json

                                                    });
                                                </script>

                                                {{-- DROPDOWN saksi_id Multiple --}}

                                                @php
                                                    $id_saksi = json_decode($data->saksi_id, true); // Konversi JSON ke array
                                                @endphp

                                                <div class='form-group'>
                                                    <label for='saksi_id'>Saksi</label>
                                                    <select id='id_saksi-{{ $loop->index }}' class='select2' name='saksi_id[]' multiple='multiple' data-placeholder='Tulikan jika memiliki saksi' style='width: 100%;'>
                                                        @foreach ($Siswas as $detailsiswa)
                                                            <option value='{{ $detailsiswa->id }}'>
                                                                {{ $detailsiswa->nama_siswa }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <script>
                                                    $(document).ready(function() {
                                                        $('#id_saksi-{{ $loop->index }}').val(@json($id_saksi)).trigger(
                                                            'change'); // Mutiple Select Select value in array json

                                                    });
                                                </script>

                                                @php

                                                    $id_kreditpoint = json_decode($data->kreditpoint_id, true); // Konversi JSON ke array
                                                @endphp
                                                <div class='form-group'>
                                                    <label for='kreditpoint_id'>Pelanggaran</label>
                                                    <select id='id_kreditpoint-{{ $loop->index }}' class='select2'  name='kreditpoint_id[]' multiple='multiple' data-placeholder='Data pelanggaran' style='width: 100%;'>
                                                        <option value=''>--- Pilih Pelanggaran ---</option>
                                                        @foreach ($ebkkreditpoints as $ebkkreditpoint)
                                                            <option value='{{ $ebkkreditpoint->id }}'>
                                                                {{ $ebkkreditpoint->pelanggaran }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <script>
                                                    $(document).ready(function() {
                                                        $('#id_kreditpoint-{{ $loop->index }}').val(@json($id_kreditpoint)).trigger(
                                                            'change'); // Mutiple Select Select value in array json
                                                    });
                                                </script>
                                                {{-- Data input id_kronologi --}}
                                                <x-inputallin>textarea:Kronologi Kejadian:Ceritakan deskripsi singkat:kronologi::{{ $data->kronologi }}:Required</x-inputallin>

                                                {{-- DROPDOWN status_penanganan Single --}}
                                                @php
                                                    $array_options = ['Proses', 'Selesai', 'Pending'];
                                                    $id_status_penanganan = $data->status_penanganan;
                                                @endphp
                                                <div class='form-group'>
                                                    <label for='status_penanganan'>Status Peanganan ( Proses, Selesai, Pending)</label>
                                                    <select name='status_penanganan' id='id_status_penanganan_{{ $loop->index }}' class='select2 form-control' required>
                                                        <option value=''>--- Pilih Status Peanganan ( Proses, Selesai, Pending) ---</option>
                                                        @foreach ($array_options as $array_option)
                                                            <option value='{{ $array_option }}'>{{ $array_option }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <script>
                                                    $(document).ready(function() {
                                                        $('#id_status_penanganan_{{ $loop->index }}').val(@json($id_status_penanganan)).trigger(
                                                            'change'); // Mutiple Select Select value in array json
                                                    });
                                                </script>
                                                {{-- Data input id_penanganan --}}
                                                <x-inputallin>textarea:Deskripsi penanganan:Ceritakan proses penangan secara singkat dan padat:penanganan::{{ $data->penanganan }}:Required</x-inputallin>
                                                <button id='kirim' type='submit'
                                                    class='btn float-right btn-default bg-primary btn-xl mt-4'>
                                                    Kirim</button>
                                                {{-- blade-formatter-enable --}}


                                            </form>

                                        </section>
                                    </x-edit-modal>
                                </div>
                                {{-- Modal Edit Data Akhir --}}
                            @endforeach
                        </tbody>
                        <tfoot class='table-secondary'>

                            <tr class='text-center'>
                                <th width='1%'>ID</th>

                                @foreach ($arr_ths as $arr_th)
                                    <th class='text-center'> {{ $arr_th }}</th>
                                @endforeach
                                <th class='text-center'>Action</th>
                            </tr>
                            </>
                    </table>
                </div>


            </div>

        </div>

    </section>
</x-layout>

<button class='btn btn-warning btn-sm' onclick='FNModalTmabah()'><i class='fa fa-edit right'></i> Edit</button>
<script>
    function FNModalTmabah(data) {
        var ModalTmabah = new bootstrap.Modal(document.getElementById('ModalTmabah'));
        ModalTmabah.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='ModalTmabah' tabindex='-1' aria-labelledby='LabelModalTmabah' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelModalTmabah'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <form id='#id' action='{{ route('pelanggaran.store') }}' method='POST'>
                @csrf
                @method('POST')
                <div class='modal-body'>
                    {{-- DROPDOWN korban_id Single --}}
                    {{-- blade-formatter-disable --}}
                    <div class='form-group'>
                        <label for='korban_id'>Korban</label>
                        <select name='korban_id' class='select2 form-control' required>
                            <option value=''>Pilih Jika Ada Korban</option>
                            @foreach ($Siswas as $detailsiswa)
                                <option value='{{ $detailsiswa->id }}'>{{ $detailsiswa->nama_siswa }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- DROPDOWN pelaku_id Multiple --}}
                    <div class='form-group'>
                        <label for='id_pelaku'>Pelaku</label><select id='menuselect_5' class='select2' name='pelaku_id[]' multiple='multiple' data-placeholder='Pelaku pelanggaran' style='width: 100%;'>
                            @foreach ($Siswas as $detailsiswa)
                                <option value='{{ $detailsiswa->id }}'>{{ $detailsiswa->nama_siswa }}</option>
                            @endforeach
                        </select>
                    </div>
                    <script>
                        $(function() {
                            //Initialize Select2 Elements
                            $('#id_pelaku').select2()

                        });
                    </script>
                    {{-- DROPDOWN saksi_id Multiple --}}
                    <div class='form-group'>
                        <label for='id_saksi'>Saksi</label><select id='menuselect_6' class='select2' name='saksi_id[]' multiple='multiple' data-placeholder='Tulikan jika memiliki saksi' style='width: 100%;'>
                            @foreach ($Siswas as $detailsiswa)
                                <option value='{{ $detailsiswa->id }}'>{{ $detailsiswa->nama_siswa }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- DROPDOWN kreditpoint_id Multiple --}}

                    <div class='form-group'>
                        <label for='id_kreditpoint'>Pelanggaran</label><select id='menuselect_8' class='select2' name='kreditpoint_id[]' multiple='multiple' data-placeholder='Data pelanggaran' style='width: 100%;'>
                            @foreach ($ebkkreditpoints as $ebkkreditpoint)
                                <option value='{{ $ebkkreditpoint->id }}'>{{ $ebkkreditpoint->pelanggaran }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Data input id_kronologi --}}
                    <x-inputallin>textarea:Kronologi Kejadian:Ceritakan deskripsi singkat:kronologi:::Required</x-inputallin>

                    {{-- DROPDOWN status_penanganan Single --}}
                    @php $array_options = ['Proses','Pending','Selesai'];  @endphp
                    <div class='form-group'>
                        <label for='id_status_penanganan'>Status Peanganan ( Proses, Selesai, Pending)</label>
                        <select name='status_penanganan' class='select2 form-control' placeholde='Status Permasalahan'
                            required>
                            <option value=''>Pilih Status Peanganan ( Proses, Selesai, Pending)</option>
                            @foreach ($array_options as $array_option)
                                <option value='{{ $array_option }}'>{{ $array_option }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- Data input id_penanganan --}}
                    <x-inputallin>textarea:Deskripsi penanganan:Ceritakan proses penangan secara singkat dan padat:penanganan:::Required</x-inputallin>


                    {{-- blade-formatter-enable --}}

                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                    <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>

</div>
