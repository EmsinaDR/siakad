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
        {{-- Papan Informasi --}}
        <div class='row'>
            <div class='col'>
                <!-- Papan Informasi  -->
                <div class='row mx-2'>
                    <div class='col-lg-4 col-6'>
                        <!-- small box / Data BOX-->
                        <div class='small-box bg-info'><!-- Background -->
                            <h3 class='m-2'>Jenis Kelamin</h3><!-- Judul -->
                            <div class='inner'><!-- Isi Kontent -->
                                <div class='d-flex justify-content-between'>
                                    <span>Laki - Laki</span><span>{{ $datas->where('jenis_kelamin', '1')->count() }}
                                        Orang</span>
                                </div>
                                <div class='d-flex justify-content-between'>
                                    <span>Perempuan</span><span>{{ $datas->where('jenis_kelamin', '2')->count() }}
                                        Orang</span>
                                </div>
                                <div class='d-flex justify-content-between'>
                                    <span>Total</span><span>{{ $datas->count() }} Orang</span>
                                </div>
                            </div>
                            <div class='icon'>
                                <i class='fa fa-pie'></i><!-- Icon -->
                            </div>
                            <a href='#' class='small-box-footer'>More info <i
                                    class='fas fa-arrow-circle-right'></i></a>
                        </div>
                        <!-- small box -->
                    </div>
                    <!-- ./col -->
                    <div class='col-lg-4 col-6'>
                        <!-- small box / Data BOX-->
                        <div class='small-box bg-success'><!-- Background -->
                            <h3 class='m-2'>Sekolah Pendaftar</h3><!-- Judul -->
                            <div class='inner'><!-- Isi Kontent -->
                                <div class='d-flex justify-content-between'>
                                    <span>Unik
                                        Sekolah</span><span>{{ $datas->pluck('namasek_asal')->unique()->count() }}
                                        Sekolah</span>
                                </div>
                                <div class='d-flex justify-content-between'>
                                    <span> <br></span><span> </span>
                                </div>
                                <div class='d-flex justify-content-between'>
                                    <span>Total</span><span>{{ $datas->pluck('namasek_asal')->unique()->count() }}</span>
                                </div>
                            </div>
                            <div class='icon'>
                                <i class='fa fa-solid fa-school'></i><!-- Icon -->
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
                            <h3 class='m-2'>Jalur Masuk</h3><!-- Judul -->
                            <div class='inner'><!-- Isi Kontent -->
                                <div class='d-flex justify-content-between'>
                                    <span>Prestasi</span><span>{{ $datas->where('jalur', 'Prestasi')->count() }}</span>
                                </div>
                                <div class='d-flex justify-content-between'>
                                    <span>Reguler</span><span>{{ $datas->where('jalur', 'Reguler')->count() }}</span>
                                </div>
                                <div class='d-flex justify-content-between'>
                                    <span>Afirmasi</span><span>{{ $datas->where('jalur', 'Afirmasi')->count() }}</span>
                                </div>
                            </div>
                            <div class='icon'>
                                <i class='fa fa-door-open'></i><!-- Icon -->
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
        <div class='card'>

            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }} : Peserta PPDB Tahun {{$Tapels->tapel}}</H3>
            </div>
            <!--Car Header-->
            <div class='ml-2 my-4'>
                <div class="row">
                    <div class="col-xl-4">
                        <div class="card p-2">
                            <div class="card-header bg-primary mb-4">
                                <h3 class="card-title">Pemetaan Sekolah Pendaftar</h3>
                            </div>
                            {{-- <div class='card-body'> --}}
                            <table id='example0' width='100%' class='table table-bordered table-hover'>
                                <thead>
                                    <tr class='text-center align-middle'>
                                        <th class='text-center align-middle' rowspan='2'>ID</th>
                                        <th class='text-center align-middle' rowspan='2'>Asal Sekolah</th>
                                        <th class='text-center align-middle' colspan='2'>J. Kelamin</th>
                                        <th class='text-center align-middle' rowspan='2'>Jumlah</th>
                                    </tr>
                                    <th>L</th>
                                    <th>P</th>
                                </thead>
                                <tbody>
                                    @foreach ($kelompok_sekolah as $index => $sekolah)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td class="text-center">{{ $sekolah->namasek_asal }}</td>
                                            <td class="text-center">{{ $sekolah->laki_laki }}</td>
                                            <td class="text-center">{{ $sekolah->perempuan }}</td>
                                            <td class="text-center">{{ $sekolah->total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class='text-center align-middle' >ID</th>
                                        <th class='text-center align-middle' >Asal Sekolah</th>
                                        <th class='text-center align-middle' >L</th>
                                        <th class='text-center align-middle' >P</th>
                                        <th class='text-center align-middle' >Jumlah</th>
                                    </tr>
                                </tfoot>
                            </table>
                            {{-- </div> --}}
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="card p-2">
                            <div class='card-header bg-primary'>
                                <h3 class='card-title'>Data Pendaftaran</h3>
                            </div>
                            <div class='card-body'>
                                <table id='example1' width='100%'
                                    class='table table-responsive table-bordered table-hover'>
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
                                                <td class='text-center'> {{ $data->nomor_peserta }}</td>
                                                <td class='text-center'>
                                                    {{ $data->tanggal_lahir ? Carbon::parse($data->tanggal_lahir)->age : '' }}
                                                    tahun</td>
                                                <td class='text-center'> {{ $data->status_penerimaan }}</td>
                                                <td class='text-center'> {{ $data->nama_calon }}</td>
                                                <td class='text-center'> {{ $data->namasek_asal }}</td>

                                                <td width='8%'>
                                                    <div class='gap-1 d-flex justify-content-center'>
                                                        <button type='button'
                                                            class='btn btn-warning btn-sm btn-equal-width'
                                                            data-toggle='modal'
                                                            data-target='#editModal{{ $data->id }}'><i
                                                                class='fa fa-edit'></i> </button>
                                                        <!-- Form untuk menghapus -->
                                                        <form action='{{ route('peserta-ppdb.destroy', $data->id) }}'
                                                            method='POST' style='display: inline-block;'>
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type='submit'
                                                                class='btn btn-danger btn-sm btn-equal-width'
                                                                onclick=`return confirm('Apakah Anda yakin ingin
                                                                menghapus data ini?');`><i class='fa fa-trash'></i>
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
                                                        <form id='updateurl'
                                                            action='{{ route('peserta-ppdb.update', $data->id) }}'
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

                <div class="row">
                    <div class="col-xl-4">
                        <div class='card-header bg-primary'><h3 class='card-title'>Kelompok Berdasarkan Usia</h3></div>
                        <table id='example3' width='100%'
                            class='table table-responsive table-bordered table-hover'>
                            <thead>
                                <tr class='table-primary text-center align-middle'>
                                    <th>Umur (Tahun)</th>
                                    <th>Jumlah Peserta</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($umurCounts as $umur => $jumlah)
                                    <tr>
                                        <td class='text-center'>{{ $umur }}</td>
                                        <td class='text-center'>{{ $jumlah }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class='table-primary text-center align-middle'>
                                    <th>Umur (Tahun)</th>
                                    <th>Jumlah Peserta</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>


        </div>

    </section>
</x-layout>

<button class='btn btn-warning btn-sm' onclick='FNnamaModal()'><i class='fa fa-edit right'></i> Edit</button>

<script>
    function namaModal(data) {
        var namaModal = new bootstrap.Modal(document.getElementById('namaModal'));
        namaModal.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='namaModal' tabindex='-1' aria-labelledby='LabelnamaModal' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelnamaModal'>
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
    $(document).ready(function() {
        initDataTable('#example1', 'Data Peserta PPDB', '#example1_wrapper .col-md-6:eq(0)', 2);
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
            buttons: [
                { extend: 'copy', title: exportTitle },
                { extend: 'excel', title: exportTitle },
                { extend: 'pdf', title: exportTitle, exportOptions: { columns: ':visible:not(.noprint)' }},
                { extend: 'colvis', titleAttr: 'Pilih Kolom' }
            ],
            columnDefs: [
                { targets: [], visible: false }, // Sembunyikan kolom Action jika perlu
                //{ targets: groupByColumn, visible: true } // Pastikan kolom yang dikelompokkan tetap terlihat
            ],
            //rowGroup: { dataSrc: groupByColumn }
        });

        table.buttons().container().appendTo(buttonContainer);
 $('#example1_filter input').attr('placeholder', 'Tuliskan nama...');

        // ✅ Pencarian yang bekerja termasuk untuk tombol 'X'
        $('#example1_filter input').on('input', function() {
            var value = this.value.trim();
            table.column(value).search(value).draw();//Kolom Pencarian

            // Jika input kosong, reset pencarian
            if (value === '') {
                table.search('').columns().search('').draw();
            }
        });
    }
</script>