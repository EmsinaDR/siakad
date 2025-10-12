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
        <h2>DATA KEGIATAN KEGIATAN {{ strtoupper($Identitas->namasek) }}</h2>
    </x-slot:judul>
    <section>

        <link rel="stylesheet" href="{{ asset('css/viewpkks.css') }}">
        <div class="container">
            <x-kop-surat-cetak></x-kop-surat-cetak>
            <h5 class="header-title mt-5">DATA KEGIATAN KEGIATAN {{ strtoupper($Identitas->namasek) }}</h5>
            <style>
                #myTable,
                #myTable td,
                #myTable th {
                    border: none !important;
                    border-collapse: collapse;
                }
            </style>
            {{-- @foreach ($datas as $data) --}}
                <div class="col">
                    <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                        <thead>
                            <tr class='table-primary text-center align-middle'>
                                <th>ID</th>
                                <th>Tanggal Pelaksanaan</th>
                                <th>Nama Kegiatan</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($datas as $data)
                               <tr class='text-center'>
                                   <td>{{ $loop->iteration }}</td>
                                   <td class='text-left'> {{Carbon::create($data->tanggal_pelaksanaan)->translatedformat('l, d F Y')}}</td>
                                   <td class='text-left'>{{ $data->nama_kegiatan }}</td>
                                   <td class='text-left'>{{ $data->keterangan }}</td>
                               </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class='table-primary text-center align-middle'>
                                <th>ID</th>
                                <th>Nama Kegiatan</th>
                                <th>Tanggal Pelaksanaan</th>
                                <th>Keterangan</th>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            {{-- @endforeach --}}


        </div>
    </section>
</x-layout-view-pkks>

<div class="d-flex justify-content-center align-content-center col-xl-12 my-2">
    {{-- <img src="{{ asset('img/foto-kegiatan/' . $foto) }}" alt="Foto Kegiatan" class="img-fluid" style="max-height: 450px; object-fit: cover;"> --}}
    {{-- <img src="{{ asset('img/foto-kegiatan/' . $foto) }}" alt="Foto Kegiatan" class="img-fluid w-100"> --}}
    {{-- <img src="{{ asset('img/foto-kegiatan/' . $foto) }}" alt="Foto Kegiatan" class="img-fluid w-100" style="height: 450px; object-fit: cover;"> --}}
