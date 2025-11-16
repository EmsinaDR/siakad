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

        .btn-primary {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: none;
            transition: all 0.2s ease-in-out;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0056b3, #003f7f);
            transform: scale(1.03);
        }

        .btn i {
            width: 20px;
            text-align: center;
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
            <div class='row m-2'>
                {{-- blade-formatter-disable --}}
                    {{-- <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#TambahData'><i class='fa fa-plus'></i> Dokumen Siswa</button> --}}
                <div class="col-xl-2">
                    <div class="d-grid gap-2">
                    <a href="{{route('surat.keluar.edaran')}}"><button type='button' class='btn btn-block btn-default bg-primary btn-md'><i class="fa fa-envelope pr-2"></i>Buat Surat</button></a>
                </div>

                {{-- blade-formatter-enable --}}
                <div class='col-xl-10'>





                </div>
            </div>
            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                            <thead>
                                <tr class='text-center'>
                                    <th width='1%'>ID</th>
                                    @foreach ($arr_ths as $arr_th)
                                        <th class='text-center'> {{ $arr_th }}</th>
                                    @endforeach
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        <td class='text-center'>{{ $loop->iteration }}</td>
                                        <td class='text-center'> {{ $data->nomor_surat }}</td>
                                        <td class='text-center'>
                                            {{ Carbon::create($data->tanggal_surat)->translatedformat('l, d F Y') }}
                                        </td>
                                        <td class='text-center'> {{ $data->Klasifikasi->nama }}</td>
                                        <td class='text-left'> {{ $data->perihal }}</td>
                                        <td class='text-left'> {{ $data->tujuan }}</td>
                                        <td class='text-left'> {{ $data->keterangan }}</td>

                                        {{-- <td width='10%'>
                                            <div class='gap-1 d-flex justify-content-center'>
                                                <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                                    data-toggle='modal' data-target='#editModal{{ $data->id }}'><i
                                                        class='fa fa-edit'></i> </button>
                                                <form id='delete-form-{{ $data->id }}'
                                                    action='{{ route('surat-keluar.destroy', $data->id) }}'
                                                    method='POST' style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type='button' class='btn btn-danger btn-sm btn-equal-width'
                                                    onclick='confirmDelete({{ $data->id }})'> <i
                                                        class='fa fa-trash'></i> </button>
                                            </div>

                                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                                aria-labelledby='EditModalLabel' aria-hidden='true'>

                                                <x-edit-modal>
                                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                    <section>
                                                        <form id='updateurl'
                                                            action='{{ route('surat-keluar.update', $data->id) }}'
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

                                            <div class='modal fade' id='viewModal{{ $data->id }}' tabindex='-1'
                                                aria-labelledby='ViewModalLabel' aria-hidden='true'>


                                                <x-view-modal>
                                                    <x-slot:titleviewModal>{{ $titleviewModal }}</x-slot:titleviewModal>
                                                    <section>
                                                        //Content View
                                                    </section>
                                                </x-view-modal>
                                            </div>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class='text-center'>
                                    <th width='1%'>ID</th>
                                    @foreach ($arr_ths as $arr_th)
                                        <th class='text-center'> {{ $arr_th }}</th>
                                    @endforeach
                                    {{-- <th class='text-center'>Action</th> --}}
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>

{{-- Data Surat Keluar --}}
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
                    targets: [-1],
                    visible: false
                }, // Sembunyikan kolom Action jika perlu
                //{ targets: groupByColumn, visible: true } // Pastikan kolom yang dikelompokkan tetap terlihat
            ],
            //rowGroup: { dataSrc: groupByColumn }
        });

        table.buttons().container().appendTo(buttonContainer);
        $('#example1_filter input').attr('placeholder', 'Tuliskan nama...');

        // ✅ Pencarian yang bekerja termasuk untuk tombol 'X'
        $('#example1_filter input').on('input', function() {
            var value = this.value.trim();
            table.column(1).search(value).draw(); //Kolom Pencarian

            // Jika input kosong, reset pencarian
            if (value === '') {
                table.search('').columns().search('').draw();
            }
        });
    }
</script>
