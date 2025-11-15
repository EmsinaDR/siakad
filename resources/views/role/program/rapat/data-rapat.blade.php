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
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'> <i class='fa fa-plus'></i> Tambah Data</button>
                </div>
                <div class='col-xl-10'></div>
            </div>
            {{-- blade-formatter-enable --}}
            <div class='ml-2 my-4'>
                <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                    <thead>
                        <tr class='text-center'>
                            <th width='1%'>ID</th>
                            @foreach ($arr_ths as $arr_th)
                                <th class='text-center'> {{ $arr_th }}</th>
                            @endforeach
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr>
                                <td class='text-center'>{{ $loop->iteration }}</td>
                                <td class='text-left'> {{ $data->nama_rapat }}</td>
                                <td class='text-center'>
                                    {{ Carbon::create($data->tanggal_pelaksanaan)->translatedformat('l, d F Y') }}
                                </td>
                                <td class='text-left'> {!! $data->perihal !!}</td>
                                <td class='text-center'> {{ $data->jam_mulai }} - {{ $data->jam_selesai }}</td>
                                <td class='text-center'> {{ $data->tempat }}</td>
                                <td class='text-center'> {!! $data->tembusan !!}</td>

                                <td width='10%'>
                                    <div class='gap-1 d-flex justify-content-center'>
                                        {{-- blade-formatter-disable --}}
                                        <a href="{{route('data.rapat.cetak', ['id' => $data->id])}}" target='_blank'><button type='button' class='btn btn-success btn-sm btn-equal-width'> <i class='fa fa-print'></i></button></a>
                                        <a href="{{ route('data-rapat.edit', $data->id) }}"><button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i> </button></a>

                                        <!-- Form untuk menghapus -->
                                        <form id='delete-form-{{ $data->id }}'
                                            action='{{ route('data-rapat.destroy', $data->id) }}' method='POST'
                                            style='display: inline-block;'>
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i></button>
                                        {{-- blade-formatter-enable --}}
                                    </div>
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
onclick='TambahData()'
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

                <form id='#id' action='{{ route('data-rapat.store') }}' method='POST'>
                    @csrf
                    @method('POST')

                    {{-- blade-formatter-disable --}}
                    <div class='form-group'>
                       <label for='klasifikasi_id'>Klasifikasi Surat</label>
                       <select name='klasifikasi_id' id='klasifikasi_id' data-placeholder='Pilih data klasifikasi surat' class='select2 form-control' required>
                               <option value=''>--- Pilih Klasifikasi Surat ---</option>
                           @foreach($KlasifikasiSurats as $newKlasifikasiSurats)
                               <option value='{{$newKlasifikasiSurats->id}}'>{{$newKlasifikasiSurats->nama}}</option>
                           @endforeach
                       </select>
                    </div>
                    <div class='form-group'>
                        <label for='nomor_surat'>Nomor Surat</label>
                        <input type='text' class='form-control' id='nomor_surat' name='nomor_surat' placeholder='Nomor Surat' readonly>
                        <span class='mt-2'><b>Catatan :</b> <br></span>
                        <span>Nomor surat ini <b class="text-success">otomatis</b> sesuai dengan klasifikasi surat dan akan dimasukkan kedalam <b class="text-success">surat keluar</b> dan <b class="text-success">undangan rapat</b></span>
                    </div>
                    <script>
                        $('#klasifikasi_id').on('change', function() {
                            let klasifikasiId = $(this).val();

                            if (klasifikasiId) {
                                $.ajax({
                                    url: "{{ route('no.surat.get') }}",
                                    method: 'GET',
                                    data: {
                                        klasifikasi_id: klasifikasiId
                                    },
                                    success: function(response) {
                                        if (response.status === 'success') {
                                            $('#nomor_surat').val(response.nomor_surat);
                                        } else {
                                            $('#nomor_surat').val('');
                                            alert(response.message || 'Gagal mengambil nomor surat');
                                        }
                                    },
                                    error: function(xhr) {
                                        $('#nomor_surat').val('');
                                        alert('Terjadi kesalahan saat menghubungi server.');
                                    }
                                });
                            } else {
                                $('#nomor_surat').val('');
                            }
                        });
                    </script>
                    <div class='form-group'>
                        <i class='fa fa-bullhorn mr-2'></i><label for='nama_rapat'>Rapat</label>
                        <input type='text' class='form-control' id='nama_rapat' name='nama_rapat' placeholder='Tuliskan rapat yang ingin dilaksanakan' required>
                    </div>

                    <div class="row">
                        <div class='col-xl-6 form-group'>
                            <i class='fas fa-calendar mr-2'></i><label for='tanggal_pelaksanaan'>Tanggal Rapat</label>
                            <input type='date' class='form-control' id='tanggal_pelaksanaan' name='tanggal_pelaksanaan' placeholder='Tanggal' value='{{Carbon::create(now())->translatedformat('Y-m-d')}}' required>
                        </div>
                        <div class='col-xl-6 form-group'>
                            <i class='fa fa-map-marker-alt mr-2'></i><label for='tempat'>Tempat</label>
                            <input type='text' class='form-control' id='tempat' name='tempat' placeholder='Tempat' value='{{$Identitas->namasek}}' required>
                        </div>
                    </div>
                    <div class='form-group'>
                        <i class='fas fa-sticky-note mr-2'></i><label for='perihal'>Perihal</label>
                        <textarea name='perihal' id='perihalCreate' rows='3' class='editor perihal form-control' placeholder='Masukkan pembahasan pada rapat yang ingin dilaksanakan'></textarea>
                        <span class='text-success'>Data pembahasan rapat</span>
                    </div>
                    <div class="row">
                        <div class='col-xl-6 form-group'>
                        <i class='fas fa-clock mr-2'></i><label for='jam_mulai'>Jam Mulai</label>
                        <input type='time' class='form-control' id='jam_mulai' name='jam_mulai'  placeholder='Jam Mulai' value='{{Carbon::create(now())->translatedformat('H:i')}}' required>
                    </div>
                    <div class='col-xl-6 form-group'>
                        <i class='fas fa-clock mr-2'></i><label for='jam_selesai'>Jam Selesai</label>
                        <input type='time' class='form-control' id='jam_selesai' name='jam_selesai' placeholder='Jam Selesai' value="{{ Carbon::now()->addHours(2)->format('H:i') }}" required>
                    </div>
                    </div>
                    <div class='form-group'>
                            <i class='fas fa-sticky-note mr-2'></i><label for='tembusan'>Tembusan</label>
                            <textarea name='tembusan' id='tembusan' rows='3' class='editor form-control' placeholder='Masukkan tembusan jika ada yang digunakan untuk surat'></textarea>
                        </div>

                    <div class="form-group">
                        <i class="fas fa-sticky-note mr-2"></i>
                        <label for="notulenedit">Isi Notulen</label>
                        <textarea name="notulenedit" id="notulenedit" rows="3" class="notulen form-control" placeholder="Masukkan Keterangan Singkat"></textarea>
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
        initDataTable('#example1', 'Data Agenda Rapat', '#example1_wrapper .col-md-6:eq(0)');
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
                // {
                //     extend: 'pdf',
                //     title: exportTitle,
                //     exportOptions: {
                //         columns: ':visible:not(.noprint)'
                //     }
                // },
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
