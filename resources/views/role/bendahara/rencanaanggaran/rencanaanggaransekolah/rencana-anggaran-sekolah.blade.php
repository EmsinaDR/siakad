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
            {{-- blade-formatter-disable --}}
            <div class='row m-2'>
                <div class='col-xl-2'>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#TambahData'>
    <i class='fa fa-database'></i> Tambah Data
</button>

<button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#BuatRencana'>
    <i class='fa fa-tasks'></i> Penetapan Kategori
</button>

<button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#RencanaBulanDepan'>
    <i class='fa fa-calendar-alt'></i> Anggaran Bulan Depan
</button>

<button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#DataInformasi'>
    <i class='fa fa-info-circle'></i> Informasi
</button>

                </div>
                <div class='col-xl-10'>
                    <table id='example5' width='100%' class='table table-responsive table-bordered table-hover'>
                        <thead>
                            <tr class='table-primary text-center align-middle'>
                                <th>Kegiatan</th>
                                <th>Rencana Anggaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class='text-center'>{{$rencanaAnggaransSekolah->count()}}</td>
                                <td class='text-center'>Rp. {{number_format($rencanaAnggaransSekolah->sum('nominal'), 0)}}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class='table-primary text-center align-middle'>
                                <th>Kegiatan</th>
                                <th>Rencana Anggaran</th>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
            {{-- blade-formatter-enable --}}
            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                            <thead>
                                <tr class='text-center align-middle'>
                                    <th class='text-center align-middle' rowspan='2' width='1%'>ID</th>
                                    @foreach ($arr_ths as $arr_th)
                                        <th rowspan='2' class='text-center align-middle'> {{ $arr_th }}</th>
                                    @endforeach
                                    <th class='text-center align-middle' rowspan='1' colspan='2'>Sumber Dana
                                        Keluar</th>
                                    <th class='text-center align-middle' rowspan='2'>Saldo</th>
                                    <th class='text-center align-middle' rowspan='2'>Keterangan</th>
                                    <th class='text-center align-middle' rowspan='2'>Action</th>
                                </tr>
                                <th class='text-center align-middle'>Komite</th>
                                <th class='text-center align-middle'>BOS</th>
                            </thead>
                            <tbody>
                                @foreach ($RencanaAnggaranSekolahAll as $data)
                                    <tr>
                                        <td class='text-center'>{{ $loop->iteration }}</td>
                                        <td class='text-center'> {{ $data->RencanaAnggaranLis->kode ?? '' }}</td>
                                        <td class="text-center">
                                            @php
                                                $kategori = $data->RencanaAnggaranLis->kategori;
                                                $badge = [
                                                    'Event' => [
                                                        'icon' => 'fa-calendar-alt',
                                                        'bg' => 'bg-primary',
                                                        'text' => 'text-primary',
                                                    ],
                                                    'Rutin' => [
                                                        'icon' => 'fa-sync-alt',
                                                        'bg' => 'bg-success',
                                                        'text' => 'text-success',
                                                    ],
                                                    'Insidental' => [
                                                        'icon' => 'fa-exclamation-triangle',
                                                        'bg' => 'bg-warning',
                                                        'text' => 'text-warning',
                                                    ],
                                                ];
                                            @endphp

                                            @if (isset($badge[$kategori]))
                                                <span
                                                    class="inline-flex items-center gap-1 px-2 py-1 text-sm font-medium rounded-full {{ $badge[$kategori]['bg'] }} {{ $badge[$kategori]['text'] }}">
                                                    <i class="fas {{ $badge[$kategori]['icon'] }}"></i>
                                                    {{ $kategori }}
                                                </span>
                                            @else
                                                {{ $kategori }}
                                            @endif
                                        </td>
                                        {{-- blade-formatter-disable --}}
                                        <td class='text-left'> {{ $data->RencanaAnggaranLis->jenis_pengeluaran ?? '' }}</td>
                                        <td class='text-center'>
                                            @if($data->kategori === 'Rutin')
                                            Rp. {{ number_format($data->nominal, 0) }}
                                            @else
                                            Rp. {{ number_format($data->nominal, 0) }}
                                            @endif
                                        </td>
                                        @php
                                            // var
                                            $PengeluaranKoomite = \App\Models\Bendahara\KomitePengeluaran::where('jenis_pengeluaran_id', $data->id)
                                                ->where('tapel_id', $Tapels->id)
                                                ->sum('nominal');
                                            $PengeluaranBOS = \App\Models\Bendahara\BOS\PengeluaranBOS::where('jenis_pengeluaran_id', $data->id)
                                                ->where('tapel_id', $Tapels->id)
                                                ->sum('nominal');
                                        @endphp
                                        <td class='text-center'>Rp. {{ number_format($PengeluaranKoomite, 0) }}</td>
                                        <td class='text-center'>Rp. {{ number_format($PengeluaranBOS, 0) }}</td>
                                        <td @if($data->nominal - ($PengeluaranKoomite + $PengeluaranBOS) > 0) class='text-center text-success' @else class='text-center text-danger' @endif>Rp. {{ number_format($data->nominal - ($PengeluaranKoomite + $PengeluaranBOS), 0) }}</td>
                                        <td class='text-center'> {{ $data->keterangan }}</td>
                                        <td width='10%'>
                                            <div class='gap-1 d-flex justify-content-center'>
                                                <!-- Button untuk mengedit -->
                                                <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i> </button>
                                                <!-- Form untuk menghapus -->
                                                <form id='delete-form-{{ $data->id }}' action='{{ route('rencana-anggaran-sekolah.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i> </button>
                                            </div>
                                            {{-- blade-formatter-enable --}}
                                        {{-- Modal View Data Akhir --}}

                                        <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                            aria-labelledby='EditModalLabel' aria-hidden='true'>

                                            <x-edit-modal>
                                                <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                <section>
                                                    {{-- blade-formatter-disable --}}
                                                        <form id='updateurl' action='{{ route('rencana-anggaran-sekolah.update', $data->id) }}' method='POST'>
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class='form-group'>
                                                                <label for='tanggal'>Tanggal</label>
                                                                <input type='date' class='form-control' id='tanggal' name='tanggal' placeholder='Tanggal' value='{{ \Carbon\Carbon::parse($data->tanggal)->format('Y-m-d') }}' required>
                                                            </div>
                                                            <div class='form-group'>
                                                                <label for='rencana_anggaran'>Rencana Anggaran</label>
                                                                <select name='rencana_anggaran' id='id' class='select2 form-control' disabled>
                                                                    <option value=''>--- Pilih Rencana Anggaran ---</option>
                                                                    @foreach ($rencanaAnggaransSekolah as $rencanaAnggaran)
                                                                        <option @if($rencanaAnggaran->rencana_anggaran_id === $data->RencanaAnggaranLis->id) selected @endif value='{{ $rencanaAnggaran->id }}'>{{ $rencanaAnggaran->RencanaAnggaranLis->jenis_pengeluaran }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class='form-group'>
                                                                <label for='nominal'>Nominal</label>
                                                                <input type='text' class='form-control' id='nominal' name='nominal' placeholder='Nominal' value='{{$data->nominal}}' >
                                                            </div>
                                                            <div class='form-group'>
                                                                <label for='keterangan'>Keterangan</label>
                                                                <textarea cols='4' class='form-control' id='keterangan' name='keterangan'></textarea>
                                                            </div>
                                                            <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'> Kirim</button>
                                                        </form>
                                                        {{-- blade-formatter-enable --}}

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
                <form id='storeurl' action='{{ route('rencana-anggaran-sekolah.store', $data->id) }}' method='POST'>
                    @csrf
                    @method('POST')
                    <div class='form-group'>
                        <label for='tanggal'>Tanggal</label>
                        <input type='date' class='form-control' id='tanggal' name='tanggal' placeholder='Tanggal' required>
                    </div>
                    <div class='form-group'>
                        <label for='rencana_anggaran'>Rencana Anggaran</label>
                        <select name='rencana_anggaran' id='id' class='select2 form-control' required>
                            <option value=''>--- Pilih Rencana Anggaran ---</option>
                            @foreach ($rencanaAnggaransList as $rencanaAnggaran)
                                <option value='{{ $rencanaAnggaran->id }}'>{{ $rencanaAnggaran->jenis_pengeluaran }} - {{ strtolower($rencanaAnggaran->kategori) === 'rutin' ? '🟢 RUTIN' : strtoupper($rencanaAnggaran->kategori) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='form-group'>
                    <label for='kategori'>Kategori</label>
                    <select name='kategori'  id='id' class='select2 form-control' required>
                        <option value=''>--- Pilih Kategori ---</option>
                        <option value='Rutin'>Rutin</option>
                        <option value='Insidental'>Insidental</option>
                        <option value='Event'>Event</option>
                    </select>
                    </div>
                    <div class='form-group'>
                        <label for='nominal'>Nominal</label>
                        <input type='text' class='form-control' id='nominal' name='nominal' placeholder='Nominal' required>
                    </div>
                    <div class='form-group'>
                        <label for='keterangan'>Keterangan</label>
                        <textarea cols='4' class='form-control' id='keterangan' name='keterangan' required></textarea>
                    </div>
                    <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'> Kirim</button>
                </form>
                {{-- blade-formatter-enable --}}
            </div>

        </div>
    </div>

</div>
{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='BuatRencana' tabindex='-1' aria-labelledby='LabelBuatRencana' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelBuatRencana'>
                    Penetapan Kategori
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                {{-- blade-formatter-disable --}}
                <form id='storeurl' action='{{ route('kategori.ubah') }}' method='POST'>
                    @csrf
                    @method('POST')
                    <div class='form-group'>
                        <label for='rencana_anggaran'>Rencana Anggaran</label>
                        <select name='rencana_anggaran[]' id='select2' multiple class='select2 form-control' data-placeholder='Pilih rencana pengeluran' required>
                            @foreach ($rencanaAnggaransSekolah as $rencanaAnggaran)
                                <option value='{{ $rencanaAnggaran->id }}'>
                                    {{ $rencanaAnggaran->RencanaAnggaranLis->jenis_pengeluaran }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class='form-group'>
                        <label for='kategori'>Kategori</label>
                        <select name='kategori' id='id' class='select2 form-control' required>
                            <option value=''>--- Pilih Kategori ---</option>
                            <option value='Rutin'>Rutin</option>
                            <option value='Insidental'>Insidental</option>
                            <option value='Event'>Event</option>
                        </select>
                    </div>
                    <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'>Kirim</button>
                </form>
                {{-- blade-formatter-enable --}}
            </div>

        </div>
    </div>

</div>
{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='DataInformasi' tabindex='-1' aria-labelledby='LabelDataInformasi' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelDataInformasi'>
                    Data Informasi
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <table id='example2' width='100%' class='table table-bordered table-hover'>
                    <thead>
                        <tr class='table-primary text-center align-middle'>
                            <th>ID</th>
                            <th>Kategori</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    @php
                        $Informasis = [
                            [
                                'kategori' => 'Rutin',
                                'keterangan' => 'Pengeluaran yang berjalan setiap bulan',
                            ],
                            [
                                'kategori' => 'Insidental',
                                'keterangan' =>
                                    'Pengeluaran tidak termasuk ke dalam rencana anggaran atau bisa dikatakan pengeluaran tidak terencana',
                            ],
                            [
                                'kategori' => 'Event',
                                'keterangan' =>
                                    'Pengeluaran sudah direncanakan perdasarkan pelaksanaannya tidak berulang atau hanya sekali tetapi terencana sesuai kegiatannya',
                            ],
                        ];
                    @endphp
                    <tbody>
                        @foreach ($Informasis as $data)
                            <tr class='text-center'>
                                <td class='text-center'>{{ $loop->iteration }}</td>
                                <td class='text-center'>{{ $data['kategori'] }}</td>
                                <td class='text-left'>{{ $data['keterangan'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class='table-primary text-center align-middle'>
                            <th>ID</th>
                            <th>Kategori</th>
                            <th>Keterangan</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>

</div>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='RencanaBulanDepan' tabindex='-1' aria-labelledby='LabelRencanaBulanDepan'
    aria-hidden='true'>
    <div class='modal-dialog modal-xl'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelRencanaBulanDepan'>
                    Rencana Pengeluaran Bulan Depan
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <table id='example3' width='100%' class='table table-responsive table-bordered table-hover'>
                    <thead>
                        <tr class='table-primary text-center align-middle'>
                            <th>ID</th>
                            <th>Rencana Pengeluaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>1</th>
                            <td class='text-center'>Rp. {{ number_format($RencanaBulanDepan->where('kategori', '!=', 'Rutin')->sum('nominal'), 0) }}
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class='table-primary text-center align-middle'>
                            <th>ID</th>
                            <th>Rencana Pengeluaran</th>
                        </tr>
                    </tfoot>
                </table>


                <table id='example4' width='100%' class='table table-bordered table-hover'>
                    <thead>
                        <tr class='table-primary text-center align-middle'>
                            <th width='1%'>ID</th>
                            <th width='15%'>Tanggal</th>
                            <th width='5%'>Kategori</th>
                            <th>Rencana Kegiatan</th>
                            <th width='15%'>Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($RencanaBulanDepan->where('kategori', '!=', 'Rutin') as $data)
                            <tr class='text-center'>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ Carbon::create($data->tanggal)->translatedformat('l, d F Y') }}</td>
                                <td>{{ $data->RencanaAnggaranLis->kategori }}</td>
                                <td class='text-left'>{{ $data->RencanaAnggaranLis->jenis_pengeluaran }}</td>
                                <td>Rp. {{ number_format($data->nominal, 0) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class='table-primary text-center align-middle'>
                            <th width='1%'>ID</th>
                            <th width='15%'>Tanggal</th>
                            <th width='5%'>Kategori</th>
                            <th>Rencana Kegiatan</th>
                            <th width='15%'>Nominal</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>

</div>
<!-- DataTables CSS -->
<link rel='stylesheet' href='https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css'>
<link rel='stylesheet' href='https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css'>
<!-- DataTables JS -->
<script src='https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js'></script>
<script src='https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js'></script>
<script src='https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js'></script>
<script src='https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js'></script>
<script src='https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js'></script>

<script>
    $(document).ready(function() {
        initDataTable('#example1', 'Data Rencana Anggaran');
        initDataTable('#example4', 'Data Pengeluaran Bulan Depan');
    });

    function initDataTable(tableId, tableTitle) {
        $(tableId).DataTable({
            responsive: true,
            lengthChange: true,
            autoWidth: false,
            dom: 'Bfrtip', // Pastikan tombol muncul
            buttons: [{
                    extend: 'copy',
                    text: 'Salin',
                    title: tableTitle, // Judul dokumen ekspor
                    exportOptions: {
                        columns: ':visible:not(.noprint)'
                    }
                },
                {
                    extend: 'excel',
                    text: 'Excel',
                    title: tableTitle, // Judul dokumen ekspor
                    exportOptions: {
                        columns: ':visible:not(.noprint)'
                    }
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    title: tableTitle, // Judul dokumen ekspor
                    exportOptions: {
                        columns: ':visible:not(.noprint)'
                    }
                },
                {
                    extend: 'colvis',
                    text: 'Pilih Kolom', // Pastikan teks tombol sesuai
                    titleAttr: 'Tampilkan/sembunyikan kolom'
                }
            ],
            columnDefs: [{
                targets: [], // Kolom terakhir (Action)
                visible: false // Sembunyikan secara default
            }]
        }).buttons().container().appendTo(tableId + '_wrapper .col-md-6:eq(0)');
    }
</script>
