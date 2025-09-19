@php
    $activecrud = collect([1, 2, 4, 6, 8])->search(Auth::user()->id);
@endphp

<style>
</style>

<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>


    <section class='content mx-2'>
        <div class='card'>
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }} {{ $Identitas->namasek }}</H3>
            </div>
            <!--Car Header-->
            <div class='card-body mr-2 ml-2'>
                <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                    <thead>
                        <tr class='text-center'></tr>
                        <th class='text-center' width='1%'>ID</th>
                        @foreach ($arr_ths as $arr_th)
                            <th class='text-center'> {{ $arr_th }}</th>
                        @endforeach
                        @if ($activecrud === 0 or $activecrud === 1)
                            <th class='text-center'>Action</th>
                        @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($DataSiswa as $data)
                            <tr>
                                <td class='text-center'>{{ $loop->iteration }}</td>
                                {{-- blade-formatter-disable --}}
                                    <td>{{ $data->nama_siswa }}</td>
                                    <td class='text-center'>{{ $data->nis }}</td>
                                    <td class='text-center'>{{ $data->KelasOne->kelas ?? ''}}</td>
                                    <td class='text-center'>{{ $data->jenis_kelamin ?? '' }}</td>
                                    <td class='text-center'>{{ $data->nohp ?? '' }}</td>
                                    <td class='text-center'>{{ $data->ayah_nohp ?? '' }}</td>
                                    <td class='text-center'>{{ $data->ibu_nohp ?? '' }}</td>
                                    <td class='text-left'>{{ $data->alamat_siswa ?? ''}}</td>
                                    {{-- blade-formatter-enable --}}
                                @if ($activecrud === 0 or $activecrud === 1)
                                    <td>
                                        {{-- blade-formatter-disable --}}
                                            <div class='gap-1 d-flex justify-content-center'>
                                                <!-- Button untuk melihat -->
                                                <a href="{{ route('siswa.edit', $data->id) }}">
                                                    <button type="button" class="btn btn-success btn-sm btn-equal-width">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </a>
                                                <a href="{{ route('siswa.cetak', $data->id) }}">
                                                    <button type="button" class="btn btn-success btn-sm btn-equal-width">
                                                        <i class="fa fa-print"></i>
                                                    </button>
                                                </a>
                                                <!-- Form untuk menghapus -->
                                                <form id='delete-form-{{ $data->id }}' action='{{ route('siswa.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i>  </button>
                                            </div>
                                        </td>
                                            {{-- blade-formatter-enable --}}
                                        {{-- </tr> --}}
                                        {{-- Modal View Data Akhir --}}

                                        {{-- Modal Edit Data Akhir --}}
                                        {{-- Modal View --}}
                                        <div class='modal fade' id='viewModal{{ $data->id }}' tabindex='-1'
                                            aria-labelledby='ViewModalLabel' aria-hidden='true'>

                                            <x-view-modal>
                                                <x-slot:titleviewModal>{{ $titleviewModal }}</x-slot:titleviewModal>
                                                <section>
                                                    Belum dicopy
                                                </section>
                                            </x-view-modal>
                                        </div>
                                        {{-- Modal View Akhir --}}
                                    @elseif($activecrud === 1 and Auth::user()->id != (int) $data->user_id)
                                    <td></td>
                                @else
                                @endif
                                {{-- @endforeach --}}

                            </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr class='text-center'>

                            <th width='1%'>ID</th>

                            @foreach ($arr_ths as $arr_th)
                                <th class='text-center'> {{ $arr_th }}</th>
                            @endforeach
                            @if ($activecrud === 0 or $activecrud === 1)
                                <th>Action</th>
                            @endif
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </section>

</x-layout>


<script>
    $(document).ready(function() {
        initDataTable('#example1', 'Data Siswa', '#example1_wrapper .col-md-6:eq(0)');
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
                DataSiswarc: 0
            } // Mengelompokkan berdasarkan kolom pertama (index 0)
        });

        // Menambahkan tombol-tombol di atas tabel
        table.buttons().container().appendTo(buttonContainer);
    }
</script>
