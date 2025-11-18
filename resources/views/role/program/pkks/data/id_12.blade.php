@php
    use Illuminate\Support\Carbon;
    $Identitas = \App\Models\Admin\Identitas::first();
    $Tapels = \App\Models\Admin\Etapel::where('aktiv', 'Y')->first();
    Carbon::setLocale('id');
    $activecrud = collect([2, 4, 6, 8])->contains(Auth::id());
    $urlroot = request()->root();
    // $DataSiswas = \App\Models\User\Siswa\Detailsiswa::get();
@endphp
<x-layout-view-pkks>
    <x-slot:judul>
        <h2>DATA ALUMNI {{ strtoupper($Identitas->namasek) }}</h2>
    </x-slot:judul>
    <section>
        {{-- @foreach ($TapelSelecteds as $TapelSelected) --}}
            <link rel="stylesheet" href="{{ asset('css/viewpkks.css') }}">
            <div class="container">
                <x-kop-surat-cetak></x-kop-surat-cetak>
                <h5 class="header-title mt-5">DATA ALUMNI {{ strtoupper($Identitas->namasek) }}</h5>
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
                            <th class='text-center align-middle'>ID</th>
                            <th class='text-center align-middle'>Tahun Lulus</th>
                            <th class='text-center align-middle'>NIS</th>
                            <th class='text-center align-middle'>Nama Siswa</th>
                            <th class='text-center align-middle'>Sekolah Lanjutan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($DataSiswas as $data)
                               <tr class='text-center'>
                                   <td>{{ $loop->iteration }}</td>
                                   <td>
                                    {{\App\Models\Admin\Etapel::find($data->tahun_lulus)->tapel}}
                                   </td>
                                   <td>{{ $data->nis }}</td>
                                   <td class='text-left'>{{ $data->nama_siswa }}</td>
                                   <td class='text-left'>{{ $data->nama_siswa }}</td>
                               </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>
        {{-- @endforeach --}}
    </section>
</x-layout-view-pkks>
