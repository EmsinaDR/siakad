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
                       <button type="button" class="btn btn-block btn-default bg-secondary btn-md" onclick="window.location.href=`{{ route('data-rapat.index') }}`"><i class="fa fa-undo"></i> Kembali</button>
                   </div>
                   <div class='col-xl-10'></div>
               </div>
               {{-- blade-formatter-enable --}}


            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <form id='updateurl' action='{{ route('data-rapat.update', $data->id) }}' method='POST'>
                            @csrf
                            @method('PATCH')

                            {{-- blade-formatter-disable --}}

                            <div class='form-group'>
                                <label for='nama_rapat'>Rapat</label>
                                <input type='text' class='form-control' id='nama_rapat' name='nama_rapat' placeholder='Rapat' value='{{ $data->nama_rapat}}' required>
                            </div>
                            <div class="row">
                                <div class='col-xl-4 form-group'>
                                    <label for='nomor_surat'>Nomor Surat</label>
                                    <input type='text' class='form-control' id='nomor_surat' name='nomor_surat' placeholder='Nomor Surat' value='{{ old('nomor_surat', $data->nomor_surat)}}' required>
                                </div>
                                <div class='col-xl-4 form-group'>
                                    <label for='tanggal_pelaksanaan'>Tanggal</label>
                                    <input type='date' class='form-control' id='tanggal_pelaksanaan' name='tanggal_pelaksanaan' value='{{ $data->tanggal_pelaksanaan}}' placeholder='Tanggal' required>
                                </div>
                                <div class='col-xl-4 form-group'>
                                    <label for='tempat'>Tempat</label>
                                    <input type='text' class='form-control' id='tempat' name='tempat' placeholder='Tempat' value='{{ old('tempat', $data->tempat)}}' required>
                                </div>
                            </div>
                            <div class='form-group'>
                                    <i class='fas fa-sticky-note'></i><label for='perihal'>Perihal</label>
                                    <textarea name='perihal' id='perihal' rows='3' class='editor form-control' placeholder='Masukkan Keterangan Singkat'>{{ $data->perihal}}</textarea>
                                </div>
                            <div class="row">
                                <div class='col-xl-6 form-group'>
                                <label for='jam_mulai'>Jam Mulai</label>
                                <input type="text" class="form-control" id="jam_mulai" name="jam_mulai" placeholder="Jam Mulai" value="{{ old('jam_mulai', \Carbon\Carbon::parse($data->jam_mulai)->format('h:i')) }}" required>

                            </div>
                            <div class='col-xl-6 form-group'>
                                <label for='jam_selesai'>Jam Selesai</label>
                                <input type="text" class="form-control" id="jam_selesai" name="jam_selesai" placeholder="Jam Selesai" value="{{ old('jam_selesai', \Carbon\Carbon::parse($data->jam_selesai)->format('h:i')) }}" required>

                            </div>
                            </div>
                            <div class='form-group'>
                                <i class='fas fa-sticky-note'></i><label for='tembusan'>Tembusan</label>
                                <textarea name='tembusan' id='tembusan' rows='3' class='editor form-control' placeholder='Masukkan Keterangan Singkat'>{{old('tembusan',  $data->tembusan)}}</textarea>
                            </div>
                            {{-- blade-formatter-enable --}}
                            <div class="form-group">
                                <i class="fas fa-sticky-note"></i>
                                <label for="notulen">Notulen</label>
                                <textarea name="notulen" id="notulen" rows="5" class="editor form-control"
                                    placeholder="Masukkan Keterangan Singkat">{!! $data->notulen !!}</textarea>
                            </div>
                            <textarea id="content_sekolah" name="content_sekolah" class="editor form-control p-2 border border-gray-300 rounded-lg">
                                    {{ old('content_sekolah', $data->content_sekolah ?? '') }}
                                </textarea>

                            <x-plugins-tiny></x-plugins-tiny>
                            <button id='kirim' type='submit'
                                class='btn float-right btn-default bg-primary btn-xl mt-4'>
                                Kirim</button>
                        </form>
                    </div>
                </div>
            </div>


        </div>


    </section>
</x-layout>
<script>
    $(document).ready(function() {
        initDataTable('#example1', 'Data Peserta Ekstra', '#example1_wrapper .col-md-6:eq(0)');
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
                    orientation: 'landscape', // Ubah ke 'portrait' jika ingin mode potrait
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
                targets: -1, // Kolom terakhir (Action) bisgunkan array contoh [-1, -2, -4]
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
