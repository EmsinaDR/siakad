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


            {{-- <div class='row m-2'>
                <div class='col-xl-2'>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'> <i
                            class='fa fa-plus'></i> Tambah Data</button>
                </div>
                <div class='col-xl-10'></div>
            </div> --}}


            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>Daftar Nilai TGS</h3>
                    </div>
                    <div class='card-body'>
                        <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                            <thead>
                                <tr class='text-center align-middle'>
                                    <th class='text-center align-middle' rowspan='2' width='1%'>ID</th>
                                    @foreach ($arr_ths as $arr_th)
                                        <th rowspan='2' class='text-center align-middle'> {{ $arr_th }}</th>
                                    @endforeach
                                    <th class='text-center align-middle' colspan='5'>Nilai</th>
                                    <th class='text-center align-middle' rowspan='2'>Total</th>
                                    <th class='text-center align-middle' rowspan='2'>Rata - rata</th>
                                </tr>
                                <th class='text-center align-middle'>TGS1</th>
                                <th class='text-center align-middle'>TGS2</th>
                                <th class='text-center align-middle'>TGS3</th>
                                <th class='text-center align-middle'>TGS4</th>
                                <th class='text-center align-middle'>TGS5</th>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        <td class='text-center'>{{ $loop->iteration }}</td>
                                        <td class='text-center'> {{ $data->nis }}</td>
                                        <td class='text-center'> {{ $data->nama_siswa }}</td>
                                        <td class='text-center'> {{ $data->KelasOne->kelas }}</td>
                                        {{-- blade-formatter-disable --}}
                                        @php
                                            // dd($data->id);
                                            $Nilai = \App\Models\WakaKurikulum\Elearning\Nilai\KurikulumNilaiTugas::where('detailsiswa_id', $data->id)->where('mapel_id', request()->segment(3))
                                                ->get();
                                            // dump($Nilai);
                                        @endphp
                                       {{-- blade-formatter-enable --}}
                                        @if ($Nilai->isEmpty())
                                            @for ($i = 0; $i < count($arr_ths) + 4; $i++)
                                                <td class='text-center' colspan='1'></td>
                                            @endfor
                                        @else
                                            @foreach ($Nilai as $nilai)
                                                @php
                                                    $NKKM = $KKM->where('mapel_id', $nilai->mapel_id)->first();
                                                @endphp
                                                <td class='text-center'> {{ $NKKM->kkm }}</td>
                                                <td class='text-center'> {{ $nilai->Mapel->mapel ?? '-' }}</td>
                                                <td class='text-center'> {{ $nilai->DataGuru->nama_guru }}</td>
                                                <td class='text-center'>
                                                    @if ($nilai->tugasa < $NKKM->kkm)
                                                        <span class="bg-danger p-2">{{ $nilai->tugasa ?? '-' }}</span>
                                                    @else
                                                        {{ $nilai->tugasa ?? '-' }}
                                                    @endif
                                                </td>
                                                <td class='text-center'>
                                                    @if ($nilai->tugasb < $NKKM->kkm)
                                                        <span class="bg-danger p-2">{{ $nilai->tugasb ?? '-' }}</span>
                                                    @else
                                                        {{ $nilai->tugasb ?? '-' }}
                                                    @endif
                                                </td>
                                                <td class='text-center'>
                                                    @if ($nilai->tugasc < $NKKM->kkm)
                                                        <span class="bg-danger p-2">{{ $nilai->tugasc ?? '-' }}</span>
                                                    @else
                                                        {{ $nilai->tugasc ?? '-' }}
                                                    @endif
                                                </td>
                                                <td class='text-center'>
                                                    @if ($nilai->tugasd < $NKKM->kkm)
                                                        <span class="bg-danger p-2">{{ $nilai->tugasd ?? '-' }}</span>
                                                    @else
                                                        {{ $nilai->tugasd ?? '-' }}
                                                    @endif
                                                </td>
                                                <td class='text-center'>
                                                    @if ($nilai->tugase < $NKKM->kkm)
                                                        <span class="bg-danger p-2">{{ $nilai->tugase ?? '-' }}</span>
                                                    @else
                                                        {{ $nilai->tugase ?? '-' }}
                                                    @endif

                                                </td>
                                                @php
                                                    $nilai = [
                                                        $nilai->tugasa,
                                                        $nilai->tugasb,
                                                        $nilai->tugasc,
                                                        $nilai->tugasd,
                                                        $nilai->tugase,
                                                    ];
                                                    $nilai_numeric = array_filter($nilai, 'is_numeric');
                                                    $total = array_sum($nilai_numeric);
                                                    $jumlah_data = count($nilai_numeric);
                                                @endphp
                                                <td class='text-center'>{{ $total ?: '-' }} </td>
                                                <td class='text-center'>{{ $total / $jumlah_data ?: '-' }} </td>
                                            @endforeach
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr class='text-center'>
                                    <th width='1%'>ID</th>
                                    @foreach ($arr_ths as $arr_th)
                                        <th class='text-center'> {{ $arr_th }}</th>
                                    @endforeach
                                    <th>TGS1</th>
                                    <th>TGS2</th>
                                    <th>TGS3</th>
                                    <th>TGS4</th>
                                    <th>TGS5</th>
                                    <th>Total</th>
                                    <th>Rata - rata</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>


        </div>

    </section>
</x-layout>
@php
$NamaMapel = \App\Models\Admin\Emapel::where('id', request()->segment(3))->first();
@endphp
<script>
    $(document).ready(function() {
        initDataTable('#example1', 'Daftar Nilai Tugas - {{$NamaMapel->mapel}}', '#example1_wrapper .col-md-6:eq(0)');
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
