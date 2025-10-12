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
        <h2>DATA PRESTASI {{ strtoupper($Identitas->judul) }}</h2>
    </x-slot:judul>
    <section>

        <link rel="stylesheet" href="{{ asset('css/viewpkks.css') }}">
        <div class="container">
            <x-kop-surat-cetak></x-kop-surat-cetak>
            <h5 class="header-title mt-5">DATA PRESTASI {{ strtoupper($Identitas->judul) }}</h5>
            <style>
                #myTable,
                #myTable td,
                #myTable th {
                    border: none !important;
                    border-collapse: collapse;
                }
            </style>

            <table id='example1' width='100%' class='table table-bordered table-hover'>
                <thead>
                    <tr class='table-primary text-center align-middle'>
                        <th>ID</th>
                        <th>Nama Kegiatan</th>
                        <th>Tingkat</th>
                        <th>Keterangan</th>
                        <th>Tahun</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($DataPrestasis as $DataPrestasi)
                        <tr class='text-center'>
                            <td>{{ $loop->iteration }}</td>
                            <td class='text-left'>{{ $DataPrestasi->keterangan }}</td>
                            <td>{{ $DataPrestasi->tingkat }}</td>
                            <td>{{ $DataPrestasi->juara }}</td>
                            <td>{{Carbon::create($DataPrestasi->pelaksanaan)->translatedformat('Y')}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


        </div>
    </section>
</x-layout-view-pkks>
