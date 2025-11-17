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
        <h2>FOTO FOTO DOKUMENTASI KEGIATAN {{ strtoupper($Identitas->namasek) }}</h2>
    </x-slot:judul>
    <section>

        <link rel="stylesheet" href="{{ asset('css/viewpkks.css') }}">
        <div class="container">
            <x-kop-surat-cetak></x-kop-surat-cetak>
            <h5 class="header-title mt-5">FOTO FOTO DOKUMENTASI KEGIATAN {{ strtoupper($Identitas->namasek) }}</h5>
            <style>
                #myTable,
                #myTable td,
                #myTable th {
                    border: none !important;
                    border-collapse: collapse;
                }
            </style>
            @foreach ($datas as $data)
                <div class="col">
                    <table id='example1' width='100%'
                        class='table border-0 table-responsive table-bordered table-hover'>
                        <tr>
                            <td class='text-left'>Nama Kegiatan</th>
                            <td class='text-left'>:</th>
                            <td class='text-left'>{{ $data->nama_kegiatan }}</td>
                        </tr>
                        <tr>
                            <td class='text-left'>Tanggal Pelaksanaan</th>
                            <td class='text-left'>:</th>
                            <td class='text-left'>
                                {{ Carbon::create($data->tanggal_pelaksanaan)->translatedformat('l, d F Y') }}</td>
                        </tr>
                        <tr>
                            <td class='text-left'>Keterangan</th>
                            <td class='text-left'>:</th>
                            <td class='text-left'>{{ $data->keterangan }}</td>
                        </tr>
                    </table>

                </div>
                <div class="row my-4">
                    @if (!empty($data->foto))
                        @php
                            $fotoList = json_decode($data->foto, true);
                            shuffle($fotoList); // Acak urutan foto
                            $fotoTerbatas = array_slice($fotoList, 0, 2); // Ambil 2 foto secara acak
                        @endphp


                        <div class="row mt-2">
                            @foreach ($fotoTerbatas as $foto)
                                <div class="d-flex justify-content-center align-content-center col-xl-12 my-2">
                                    <img src="{{ asset('img/foto-kegiatan/' . $foto) }}" alt="Foto Kegiatan"
                                        class="img-fluid w-100 border"
                                        style="height: 450px; background-color: #f8f9fa; border-color: #dee2e6; border-radius: 35px; overflow: hidden;">
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            @endforeach


        </div>
    </section>
</x-layout-view-pkks>

<div class="d-flex justify-content-center align-content-center col-xl-12 my-2">
    {{-- <img src="{{ asset('img/foto-kegiatan/' . $foto) }}" alt="Foto Kegiatan" class="img-fluid" style="max-height: 450px; object-fit: cover;"> --}}
    {{-- <img src="{{ asset('img/foto-kegiatan/' . $foto) }}" alt="Foto Kegiatan" class="img-fluid w-100"> --}}
    {{-- <img src="{{ asset('img/foto-kegiatan/' . $foto) }}" alt="Foto Kegiatan" class="img-fluid w-100" style="height: 450px; object-fit: cover;"> --}}
