@php
    //Tahfidz Riwayat Hafalan
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
                <div class="row m-2">
                    <div class="col-xl-2">
                        <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'><i class="fa fa-book"></i> Tambah Data</button>
                    </div>
                    <div class="col-xl-10"></div>
                </div>
                {{-- blade-formatter-enable --}}


            <div class='ml-2 my-4'>
                <div class='card-header bg-primary'>
                    <h3 class='card-title'>Data Peserta dan Hafalan Terakhir</h3>
                </div>
                <table id='example1' width='100%' class='table table-bordered table-hover'>
                    <thead>
                        <tr class='text-center table-primary'>
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
                                <td class='text-center'> {{ $data->siswa->nama_siswa }}</td>
                                <td class='text-center'> {{ $data->surat->nama_surat }}</td>
                                <td class='text-center'>
                                    {{-- blade-formatter-disable --}}
                                    @php
                                        $decodedAyats = json_decode($data->ayat, true) ?? [];
                                    @endphp

                                    @foreach ($decodedAyats as $index => $ayat)
                                        {{ $ayat }}@if (!$loop->last) ,
                                        @endif
                                    @endforeach
                                    {{-- blade-formatter-enable --}}

                                </td>

                                <td width='0%'>
                                    <div class='gap-1 d-flex justify-content-center'>
                                        {{-- blade-formatter-disable --}}
                                        <a href="{{route('riwayat-hafalan.index')}}/{{$data->detailsiswa_id}}"><button type='button' class='btn btn-success btn-sm btn-equal-width' > <i class='fa fa-eye'></i> </button></a>
                                        {{-- blade-formatter-enable --}}

                                    </div>
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
                <form id='#id' action='{{ route('riwayat-hafalan.store') }}' method='POST'>
                    @csrf
                    @method('POST')
                    <div class='form-group'>
                        <label for='detailsiswa_id'>Peserta</label>
                        <select name='detailsiswa_id' id='DataPesertas' class='form-control' required>
                            <option value=''>--- Pilih Peserta ---</option>
                            @foreach ($DataPesertas as $DataPeserta)
                                <option value='{{ $DataPeserta->detailsiswa_id }}'>{{ $DataPeserta->kelas->kelas }} -
                                    {{ $DataPeserta->SiswaOne->nama_siswa }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="surat_id">Nama Surat</label>
                        <select name="surat_id" id="surat_id" class="form-control" required>
                            <option value="">--- Pilih Nama Surat ---</option>
                            @foreach ($DataSurats as $DataSurat)
                                <option value="{{ $DataSurat->id }}" data-jumlah-ayat="{{ $DataSurat->jumlah_ayat }}">
                                    {{ $DataSurat->nama_surat }} - (1 - {{ $DataSurat->jumlah_ayat }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="ayat">Ayat</label>
                        <select name="ayat[]" id="id_single" class="form-control" multiple required>
                            <!-- Option akan diisi dengan JavaScript -->
                        </select>
                    </div>

                    <script>
                        $(document).ready(function() {
                            $('#surat_id').on('change', function() {
                                var jumlahAyat = $(this).find(':selected').data(
                                    'jumlah-ayat'); // Ambil jumlah ayat dari data-attribute
                                var $ayatSelect = $('#id_single');

                                $ayatSelect.empty(); // Hapus semua opsi sebelum diisi ulang

                                if (jumlahAyat) {
                                    for (var i = 1; i <= jumlahAyat; i++) {
                                        $ayatSelect.append('<option value="' + i + '">' + i + '</option>');
                                    }
                                }
                            });
                        });
                    </script>

                    <div class='form-group'>
                        <i class='fas fa-sticky-note'></i><label for='keterangan'>Keterangan</label>
                        <textarea name='keterangan' id='keterangan' rows='3' class='form-control'
                            placeholder='Masukkan Keterangan Singkat'></textarea>
                    </div>

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
        initDataTable('#example1', 'Data Peserta Tahfidz', '#example1_wrapper .col-md-6:eq(0)', 2);
    });

    function initDataTable(tableId, exportTitle, buttonContainer, groupByColumn) {
        if ($.fn.DataTable.isDataTable(tableId)) {
            $(tableId).DataTable().destroy();
        }

        var table = $(tableId).DataTable({
            lengthChange: true,
            autoWidth: false,
            responsive: true,
            ordering: true,
            searching: true,
            //searchCols: [
            //    null,  // Kolom 0 (ID)
            //   { search: '' }, // Kolom 1 (Nama Siswa)
            //    { search: '' }, // Kolom 2 (Kelas)
            //    { search: '' }, // Kolom 3 (Pembimbing)
            //   { search: '' }  // Kolom 4 (Hari Bimbingan)
            //],
            buttons: [{
                    extend: 'copy',
                    title: exportTitle
                },
                {
                    extend: 'excel',
                    title: exportTitle
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
                    targets: [],
                    visible: false
                }, // Sembunyikan kolom Action jika perlu
                //{ targets: groupByColumn, visible: true } // Pastikan kolom yang dikelompokkan tetap terlihat
            ],
            //rowGroup: { dataSrc: groupByColumn }
        });

        table.buttons().container().appendTo(buttonContainer);

    }
</script>
