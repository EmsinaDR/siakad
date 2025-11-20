@php
    use Illuminate\Support\Carbon;
    $Identitas = \App\Models\Admin\Identitas::first();
    $Tapels = \App\Models\Admin\Etapel::where('aktiv', 'Y')->first();
    Carbon::setLocale('id');
    $activecrud = collect([2, 4, 6, 8])->contains(Auth::id());
    $urlroot = request()->root();
@endphp
<x-layout-view-pkks>
    <x-slot:judul>
        <h2>DATA PERATURAN AKADEMIK {{ strtoupper($Identitas->namasek) }}</h2>
    </x-slot:judul>
    <section>
        {{-- @foreach ($DataSOPs as $DataSOP) --}}
        <link rel="stylesheet" href="{{ asset('css/viewpkks.css') }}">





        <div class="container">
            <x-kop-surat-cetak></x-kop-surat-cetak>
            {{-- <h5 class="header-title mt-5">DATA PERATURAN AKADEMIK {{ strtoupper($Identitas->namasek) }}</h5> --}}
            <style>
                #myTable,
                #myTable td,
                #myTable th {
                    border: none !important;
                    border-collapse: collapse;
                }
            </style>
            <div class="my-4">
                <h2 class='text-center'><b>TATA KRAMA DAN TATA TERTIB</b></h2>
                <h2 class='text-center'><b>KEHIDUPAN MADRASAH BAGI SISWA</b></h2>
                <h2 class='text-center'><b> {{ strtoupper($Identitas->namasek) }}</b></h2>
            </div>
            @php $DataPeraturan = $DataPeraturans->first(); @endphp

            @if ($DataPeraturan)
                <h3 class='text-center mt-2'><b>BAB I</b></h3>
                <h3 class='text-center mb-2'>{{ $DataPeraturan->sub_kategori }}</h3>
                <div class="col-12">
                    {!! $DataPeraturan->peraturan !!}
                </div>
                <div class="mb-4"></div>
            @endif
            @foreach ($DataPeraturans->skip(1)->whereNotIn('sub_kategori', ['LAIN-LAIN', 'PELANGGARAN DAN SANKSI']) as $DataPeraturan)
                <h3 class='text-center mt-2'>Pasal {{ $loop->iteration }}</h3>
                <h3 class='text-center mb-2'>{{ $DataPeraturan->sub_kategori }}</h3>
                {!! $DataPeraturan->peraturan !!}
                <div class="mb-4"></div>
            @endforeach

            @foreach ($DataPeraturans->where('sub_kategori', 'PELANGGARAN DAN SANKSI') as $DataPeraturan)
                <h3 class='text-center mt-2'>BAB II</h3>
                <h3 class='text-center  mb-2'>{{ $DataPeraturan->sub_kategori }}</h3>
                {!! $DataPeraturan->peraturan !!}
                <div class="mb-4"></div>
            @endforeach
            @foreach ($DataPeraturans->where('sub_kategori', 'LAIN-LAIN') as $DataPeraturan)
                <h3 class='text-center mt-2'>BAB III</h3>
                <h3 class='text-center  mb-2'>{{ $DataPeraturan->sub_kategori }}</h3>
                {!! $DataPeraturan->peraturan !!}
                <div class="mb-4"></div>
            @endforeach
        </div>


        <div class="container">
            <x-kop-surat-cetak></x-kop-surat-cetak>
            {{-- <h5 class="header-title mt-5">DATA PERATURAN AKADEMIK {{ strtoupper($Identitas->namasek) }}</h5> --}}
            <style>
                #myTable,
                #myTable td,
                #myTable th {
                    border: none !important;
                    border-collapse: collapse;
                }
            </style>

            {{-- BK --}}
            <div class="my-4">
                <h3 class="text-center"><b>JENIS DAN KRITERIA SANKSI PELANGGARAN</b></h3>
                <h3 class="text-center"><b>TATA TERTIB SISWA</b></h3>
                <h3 class="text-center"><b>{{ strtoupper($Identitas->namasek) }}</b></h3>
            </div>
            <table id='example1' width='100%' class='table table-bordered table-hover'>
                <thead>
                    <tr class='table-primary text-center align-middle'>
                        <th>ID</th>
                        <th>Kategori</th>
                        <th>Pelanggaran</th>
                        <th>Point</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($DataBKs as $data)
                        <tr class='text-left'>
                            <td class='text-center'>{{ $loop->iteration }}</td>
                            <td>{{ ucwords($data->kategori) }}</td>
                            <td class='text-left'>{{ $data->pelanggaran }}</td>
                            <td>{{ $data->point }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class='table-primary text-center align-middle'>
                        <th>ID</th>
                        <th>Kategori</th>
                        <th>Pelanggaran</th>
                        <th>Point</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="page-break"></div> <!-- Pemisah halaman -->
        <div class="container">
            <x-kop-surat-cetak></x-kop-surat-cetak>
            <h5 class='text-center'><b>PERUMUSAN BENTUK SANKSI</b></h5>
            <table id='example1' width='100%' class='table table-bordered table-hover'>
                <thead>
                    <tr class='table-primary text-center align-middle'>
                        <th width ='1%'>ID</th>
                        <th>Kriteria</th>
                        <th width='15%'>Bobot</th>
                        <th>Sanksi</th>
                    </tr>
                </thead>
                @php
                    $no = 1;
                @endphp
                <tbody>
                    <tr>
                        <td class='text-center'>{{ $no++ }}</td>
                        <td class='text-center'>Pelanggaran Ringan</td>
                        <td class='text-center'>1 - 10</td>
                        <td class='text-left'>Peringatan lisan</td>
                    </tr>
                    <tr>
                        <td class='text-center'>{{ $no++ }}</td>
                        <td class='text-center'>Pelanggaran Sedang</td>
                        <td class='text-center'>11 - 30</td>
                        <td class='text-left'>
                            <ol class="text-left">
                                <li>Peringatan tertulis dan hukuman edukatif</li>
                                <li>Panggilan orang tua/wali murid</li>
                            </ol>

                        </td>
                    </tr>
                    <tr>
                        <td class='text-center' rowspan='3'>{{ $no++ }}</td>
                        <td class='text-center' rowspan='3'>Pelanggaran Berat</td>
                        <td class='text-center'>31 - 50</td>
                        <td class='text-left'>Dikembalikan kepada orang tua dalam jangka waktu tertentu (skorsing) 3
                            hari</td>
                    </tr>
                    <tr>
                        <td class='text-center'>51 - 80</td>
                        <td class='text-left'>Dikembalikan kepada orang tua dalam jangka waktu tertentu (skorsing) 3
                            hari</td>
                    </tr>
                    <tr>
                        <td class='text-center'>81 - 100</td>
                        <td class='text-left'>Dikembalikan kepada orang tua selama-lamanya</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class='table-primary text-center align-middle'>
                        <th>ID</th>
                        <th>Kriteria</th>
                        <th>Bobot</th>
                        <th>Sanksi</th>
                    </tr>
                </tfoot>
            </table>


        </div>
        {{-- @endforeach --}}
    </section>
</x-layout-view-pkks>
