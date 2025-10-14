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
        <h2>DAFTAR MGMP {{ strtoupper($Identitas->namasek) }}</h2>
    </x-slot:judul>
    <section>
        {{-- @foreach ($DataSOPs as $DataSOP) --}}
        <link rel="stylesheet" href="{{ asset('css/viewpkks.css') }}">
        <div class="container">
            <x-kop-surat-cetak></x-kop-surat-cetak>
            <h5 class="header-title mt-5">DAFTAR GURU YANG IKUT MGMP {{ strtoupper($Identitas->namasek) }}</h5>
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
                        <th>Nama</th>
                        <th>NUPTK / NIP</th>
                        <th>Mata Pelajaran</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $data)
                        <tr class='text-center'>
                            <td>{{ $loop->iteration }}</td>
                            <td class='text-left'>{{ $data->Guru->nama_guru }}</td>
                            <td class='text-left'>{{ $data->Guru->nip }}</td>
                            <td class='text-left'>{{ $data->Mapel->mapel }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class='table-primary text-center align-middle'>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>NUPTK / NIP</th>
                        <th>Mata Pelajaran</th>
                        <th>Keterangan</th>
                    </tr>
                </tfoot>
            </table>

        </div>
        {{-- @endforeach --}}
    </section>
</x-layout-view-pkks>
