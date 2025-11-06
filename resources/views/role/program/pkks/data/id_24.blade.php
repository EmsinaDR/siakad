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
        <h2>DATA PRESTASI {{ strtoupper($Identitas->namasek) }}</h2>
    </x-slot:judul>
    <section>
        {{-- @foreach ($DataSOPs as $DataSOP) --}}
        <link rel="stylesheet" href="{{ asset('css/viewpkks.css') }}">
        <div class="container">
            <x-kop-surat-cetak></x-kop-surat-cetak>
            <h5 class="header-title mt-5 mb-3">DATA PRESTASI {{ strtoupper($Identitas->namasek) }}</h5>
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
                        <th>Pelaksanaan</th>
                        <th>Kategori</th>
                        <th>Juara</th>
                        <th>Tingkat</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- {{dump($datas->first())}} --}}
                    @foreach ($datas as $data)
                        <tr class='text-center'>
                            <td class='text-center'>{{ $loop->iteration }}</td>
                            <td class='text-center'>{{ $data->pelaksanaan }}</td>
                            <td class='text-center'>{{ $data->kategori }}</td>
                            <td class='text-center'>{{ $data->juara }}</td>
                            <td class='text-center'>{{ $data->tingkat }}</td>
                            <td class='text-left'>{{ $data->keterangan }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class='table-primary text-center align-middle'>
                        <th>ID</th>
                        <th>Pelaksanaan</th>
                        <th>Kategori</th>
                        <th>Juara</th>
                        <th>Tingkat</th>
                        <th>Keterangan</th>
                    </tr>
                </tfoot>
            </table>


        </div>
        {{-- @endforeach --}}
    </section>
</x-layout-view-pkks>
