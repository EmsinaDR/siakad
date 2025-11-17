@php
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
@endphp
<x-layout>
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

            <div class='ml-2 my-4'>
                <div class="card">
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>Pengumuman PPDB</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            {{-- blade-formatter-disable --}}
                            <div class="col-xl-2">
                                <button type='button' class='btn btn-block btn-default bg-success btn-md' onclick='Pengumuman()'> <i class="fa fa-bullhorn"></i> Pengumuman All</button>
                                <button type='button' class='btn btn-block btn-default bg-success btn-md' onclick='Pengumuman()'> <i class="fa fa-bullhorn"></i> Penetuan Kelas</button>
                                <button type='button' class='btn btn-block btn-default bg-success btn-md' onclick='Pengumuman()'> <i class="fa fa-bullhorn"></i> Generate NIS</button>
                            </div>
                            {{-- blade-formatter-enable --}}
                            <div class="col-xl-4">
                                <table id='examplexe' width='100%' class='table table-bordered table-hover'>
                                    <thead>
                                        <tr class='table-primary text-center align-middle'>
                                            <th class='text-center align-middle' rowspan='2'>ID</th>
                                            <th class='text-center align-middle' rowspan='2'>Status</th>
                                            <th class='text-center align-middle' colspan='2'>Jumlah</th>
                                            <th class='text-center align-middle' rowspan='2'>Total</th>
                                        </tr>
                                        <th class='table-success text-center align-middle'>L</th>
                                        <th class='table-success text-center align-middle'>P</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class='text-center'>1</td>
                                            <td class='text-center'>Diterima</td>
                                            <td class='text-center'>{{$dataPendaftaran->where('status_penerimaan', 'Diterima')->where('jenis_kelamin', 2)->count()}}</td>
                                            <td class='text-center'>{{$dataPendaftaran->where('status_penerimaan', 'Diterima')->where('jenis_kelamin', 2)->count()}}</td>
                                            <td class='text-center'>{{$dataPendaftaran->where('status_penerimaan', 'Diterima')->count()}}</td>
                                        </tr>
                                        <tr>
                                            <td class='text-center'>2</td>
                                            <td class='text-center'>Ditolak</td>
                                            <td class='text-center'>{{$dataPendaftaran->where('status_penerimaan', 'Ditolak')->where('jenis_kelamin', 2)->count()}}</td>
                                            <td class='text-center'>{{$dataPendaftaran->where('status_penerimaan', 'Ditolak')->where('jenis_kelamin', 2)->count()}}</td>
                                            <td class='text-center'>{{$dataPendaftaran->where('status_penerimaan', 'Ditolak')->count()}}</td>
                                        </tr>
                                        <tr>
                                            <td class='text-center'>3</td>
                                            <td class='text-center'>Menunggu</td>
                                            <td class='text-center'>{{$dataPendaftaran->where('status_penerimaan', 'Menunggu')->where('jenis_kelamin', 2)->count()}}</td>
                                            <td class='text-center'>{{$dataPendaftaran->where('status_penerimaan', 'Menunggu')->where('jenis_kelamin', 2)->count()}}</td>
                                            <td class='text-center'>{{$dataPendaftaran->where('status_penerimaan', 'Menunggu')->count()}}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class='table-primary text-center align-middle'>
                                            <th>ID</th>
                                            <th>Status</th>
                                            <th class='table-success text-center align-middle'>L</th>
                                            <th class='table-success text-center align-middle'>P</th>
                                            <th rowspan='2'>Total</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <table width='100%' class='table table-bordered table-hover'>
                                    <thead>
                                        <tr class='table-success text-center align-middle'>
                                            <th class='text-center align-middle' rowspan='2'>Tapel</th>
                                            <th class='text-center align-middle' colspan='2'>Jenis Kelamin</th>
                                            <th class='text-center align-middle' rowspan='2'>Total</th>
                                        </tr>
                                        <th class='table-success text-center align-middle'>L</th>
                                        <th class='table-success text-center align-middle'>P</th>
                                    </thead>
                                    <tbody>
                                        {{-- blade-formatter-disable --}}
                                       @foreach ($dataPendaftaran->groupBy('tapel_id') as $tapel_id => $data)
                                            <tr class="text-center">
                                                <td>{{ $data->first()->tapel->tapel ?? 'N/A' }}</td>
                                                <td>{{ $data->where('jenis_kelamin', 1)->count() }}</td>
                                                <td>{{ $data->where('jenis_kelamin', 2)->count() }}</td>
                                                <td>{{ $data->count() }}</td>
                                            </tr>
                                        @endforeach

                                        {{-- blade-formatter-enable --}}
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class='text-center align-middle'>Tapel</th>
                                            <th class='text-center align-middle'>L</th>
                                            <th class='text-center align-middle'>P</th>
                                            <th class='text-center align-middle' colspan='2'>Total</th>
                                        </tr>
                                    </tfoot>
                                </table>

                            </div>

                            {{-- <pre>{{ json_encode($chartData, JSON_PRETTY_PRINT) }}</pre> --}}

                            <div class="col-xl-5">
                                <script>
                                    var chartData = @json($chartData);
                                    console.log("📌 Data dari Laravel:", chartData);
                                </script>

                                <canvas id="genderChart"></canvas>
                                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        // Ambil elemen canvas untuk menggambar grafik
                                        var ctx = document.getElementById("genderChart").getContext("2d");

                                        console.log("🚀 Data Chart Sebelum Manipulasi:", chartData);

                                        // Cek apakah chartData valid (bukan array kosong atau bukan array)
                                        if (!Array.isArray(chartData) || chartData.length === 0) {
                                            console.error("❌ chartData kosong atau bukan array:", chartData);
                                            return;
                                        }

                                        // 🔥 Tambahkan Data Dummy (0) untuk memastikan sumbu Y mulai dari 0
                                        chartData.push({
                                            tapel: "Dummy", // Label "Dummy" akan kita sembunyikan di grafik
                                            "Laki-laki": 0,
                                            "Perempuan": 0
                                        });

                                        console.log("📌 Data Chart Setelah Manipulasi:", chartData);

                                        // 🔹 Ambil label (tapel) dan data jumlah laki-laki serta perempuan
                                        var labels = chartData.map(data => data.tapel);
                                        var lakiLaki = chartData.map(data => data["Laki-laki"]);
                                        var perempuan = chartData.map(data => data["Perempuan"]);

                                        // 🔥 Sembunyikan label "Dummy" dari sumbu X agar tidak muncul di grafik
                                        labels = labels.map(label => label === "Dummy" ? "" : label);

                                        // 🔹 Hitung nilai tertinggi agar grafik lebih proporsional
                                        var maxValue = Math.max(...lakiLaki, ...perempuan) + 10; // Tambahkan sedikit margin

                                        // 🔥 Hapus grafik lama jika ada, untuk menghindari duplikasi
                                        if (window.genderChart instanceof Chart) {
                                            window.genderChart.destroy();
                                        }

                                        // 🔹 Buat grafik baru
                                        window.genderChart = new Chart(ctx, {
                                            type: "bar",
                                            data: {
                                                labels: labels, // Sumbu X (Tahun ajaran)
                                                datasets: [{
                                                        label: "Laki-laki",
                                                        backgroundColor: "#3498db", // Warna biru untuk laki-laki
                                                        data: lakiLaki
                                                    },
                                                    {
                                                        label: "Perempuan",
                                                        backgroundColor: "#e74c3c", // Warna merah untuk perempuan
                                                        data: perempuan
                                                    }
                                                ]
                                            },
                                            options: {
                                                responsive: true, // Grafik menyesuaikan ukuran layar
                                                scales: {
                                                    y: {
                                                        suggestedMin: 0, // 🔥 Paksa sumbu Y mulai dari 0
                                                        suggestedMax: maxValue, // 🔥 Pastikan batas atas lebih tinggi dari data tertinggi
                                                        ticks: {
                                                            stepSize: 50 // 🔹 Jarak angka di sumbu Y agar lebih mudah dibaca
                                                        }
                                                    }
                                                },
                                                plugins: {
                                                    legend: {
                                                        position: "top"
                                                    }, // 🔹 Letak legenda (keterangan warna)
                                                    title: {
                                                        display: true,
                                                        text: "Jumlah Laki-laki & Perempuan per Tahun Ajaran"
                                                    }
                                                }
                                            }
                                        });

                                        console.log("✅ Grafik berhasil dimuat.");
                                    });
                                </script>
                            </div>



                        </div>
                        <div class="card">
                            <div class='card-header bg-success'>
                                <h3 class='card-title'>Data Pengumuman Peserta PPDB</h3>
                            </div>
                            <div class='card-body'>
                                <table id='example1' width='100%' class='table table-bordered table-hover'>
                                    <thead>
                                        <tr class='text-center table-success'>
                                            <th width='1%'>ID</th>
                                            @foreach ($arr_ths as $arr_th)
                                                <th class='text-center'> {{ $arr_th }}</th>
                                            @endforeach
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataPendaftaran as $data)
                                            <tr>
                                                <td class='text-center'>{{ $loop->iteration }}</td>
                                                <td class='text-center'> {{ $data->jalur ?? '' }}</td>
                                                <td class='text-center'> {{ $data->nomor_peserta ?? '' }}</td>
                                                <td class='text-center'> {{ $data->nis ?? '' }}</td>
                                                <td class='text-center'>
                                                    {{-- blade-formatter-disable --}}
                                                    @if ($data->status_penerimaan === 'Diterima')
                                                        <span class="bg-success p-2">{{ $data->status_penerimaan }}</span>
                                                    @elseif($data->status_penerimaan === 'Menunggu')
                                                        <span  class="bg-warning p-2">{{ $data->status_penerimaan }}</span>
                                                    @else
                                                        <span class="bg-danger p-2">{{ $data->status_penerimaan }}</span>
                                                    @endif
                                                    {{-- blade-formatter-enable --}}
                                                </td>
                                                <td class='text-left'> {{ $data->nama_calon }}</td>

                                                <td width='10%'>
                                                        {{-- blade-formatter-disable --}}
                                                    <div class='gap-1 d-flex justify-content-center'>
                                                        <!-- Button untuk mengedit -->
                                                        <button type='button'  class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i> </button>
                                                        <!-- Form untuk menghapus -->
                                                <form action='{{ route('pengumuman-ppdb.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type='submit' class='btn btn-danger btn-sm btn-equal-width' onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');"><i class='fa fa-trash'></i> </button>
                                                </form>
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
                                                        <form id='updateurl' action='{{ route('pengumuman-ppdb.update', $data->id) }}' method='POST'>
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="row">
                                                                <div class="col-xl-6"><i class="fa fa-id-badge m-2"></i>
                                                                    <x-inputallin>type:Nomor Peserta:Nomor Peserta:nomor_peserta:id_nomor_peserta:{{ $data->nomor_peserta }}:Required</x-inputallin>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    @php
                                                                        $dataupdate = $data->status_penerimaan; // Ini bisa diambil dari database
                                                                    @endphp

                                                                    <div class='form-group'>
                                                                        <label for='status_penerimaan'><i class="fa fa-check-circle m-2"></i> Status Penerimaan</label>
                                                                        <select name='status_penerimaan' id='select2-{{ $data->id }}' class='select2 form-control' required>
                                                                            @foreach ($status as $newkey)
                                                                                <option value='{{ $newkey }}' @if($data->status_penerimaan === $newkey) selected @endif> {{ $newkey }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <i class="fa fa-user m-2"></i><x-inputallin>type:Nama Peserta:Nama Peserta / Calon:nama_calon:id_nama_calon:{{ $data->nama_calon }}:Required</x-inputallin>

                                                            <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'> Kirim</button>
                                                        </form>
                                                            {{-- blade-formatter-enable --}}

                                                    </section>
                                                </x-edit-modal>
                                            </div>
                                            {{-- Modal Edit Data Akhir --}}
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class='text-center'>
                                            <th width='1%'>ID</th>
                                            @foreach ($arr_ths as $arr_th)
                                                <th class='text-center'> {{ $arr_th }}</th>
                                            @endforeach
                                            <th class='text-center'>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>

    </section>
</x-layout>

{{-- <button class='btn btn-warning btn-sm' ><i class='fa fa-edit right'></i> Edit</button> --}}

<script>
    function Pengumuman(data) {
        var Pengumuman = new bootstrap.Modal(document.getElementById('Pengumuman'));
        Pengumuman.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='Pengumuman' tabindex='-1' aria-labelledby='LabelPengumuman' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelPengumuman'>
                    Pengumumman<i class="fa fa-bullhorn ml-2"></i>
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>


                <form id='#id' action='{{ route('pengumuman.ppdb.bulk') }}' method='POST'>
                    @csrf
                    @method('POST')
                    <div class='form-group'>
                        <label for='status_penerimaan'>Status Penerimaan</label>
                        <select name='status_penerimaan' id='id' class='select2 form-control' required>
                            <option value=''>--- Pilih Status Penerimaan ---</option>
                            @foreach ($status as $newstatus)
                                <option value='{{ $newstatus }}'>{{ $newstatus }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- blade-formatter-disable --}}
                <div class='form-group'>
                    <label for='nama_peserta'>Nama Peserta</label>
                    <select id='select2-1' class='select2' name='id[]' multiple='multiple' data-placeholder='Nama Calon' style='width: 100%;'>
                        <option value=''>--- Pilih Nama Peserta ---</option>
                        @foreach ($dataPendaftaran->where('status_penerimaan', '!=', 'Diterima') as $newcalon)
                            <option value='{{ $newcalon->id }}'>{{ $newcalon->nomor_peserta }} - {{ $newcalon->nama_calon }} - {{ $newcalon->status_penerimaan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class='form-group'>
                   <label for='kelas_id'>Kelas</label>
                   <select name='kelas_id' id='kelas_id' data-placeholder='Pilih Data Kelas' class='select2 form-control' required>
                           <option value=''>--- Pilih Kelas ---</option>
                       @foreach($Kelas as $newKelas)
                           <option value='{{$newKelas->id}}'>{{$newKelas->kelas}}</option>
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
        initDataTable('#example1', 'Data Pengumuman PPDB', '#example1_wrapper .col-md-6:eq(0)');
        // initDataTable('#example2', 'Data Peserta 2', '#example2_wrapper .col-md-6:eq(0)');
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
