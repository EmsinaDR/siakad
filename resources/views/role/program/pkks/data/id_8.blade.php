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
        <h2>DATA SOP {{strtoupper($Identitas->namasek)}}</h2>
    </x-slot:judul>
    <section>
       @foreach ($DataSOPs as $DataSOP)
        <link rel="stylesheet" href="{{ asset('css/viewpkks.css') }}">
        <div class="container">
            <x-kop-surat-cetak></x-kop-surat-cetak>
            <h5 class="header-title mt-5">DATA SOP {{ strtoupper($DataSOP->judul) }}</h5>
            <style>
                #myTable,
                #myTable td,
                #myTable th {
                    border: none !important;
                    border-collapse: collapse;
                }
            </style>
            <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                <tbody>
                    <tr>
                        <td width="50%" rowspan="1" class="text-center align-middle">
                            <img src="{{ app('request')->root() }}/img/logo.png" style="width: 200px; height: auto;"
                                alt="Logo Instansi" class="logo">
                        </td>
                        <td>
                            <table id="myTable" style="width: 100%;" cellspacing='0' celpadding='1'>
                                <tr>
                                    <td width="40%" class="text-left">Nomor SOP</td>
                                    <td class="text-left">: 2 September 2025 {{ $DataSOP->nomor_sop }}</td>
                                </tr>
                                <tr>
                                    <td class="text-left">Tanggal Pembuatan</td>
                                    <td class='text-left'>: {{Carbon::create($DataSOP->tanggal_pembuatan)->translatedformat('d F Y')}}</td>
                                </tr>
                                <tr>
                                    <td class="text-left">Tanggal Revisi</td>
                                    <td class='text-left'>: {{Carbon::create($DataSOP->tanggal_revisi)->translatedformat('d F Y')}}</td>
                                </tr>
                                <tr>
                                    <td class="text-left">Tanggal Pengesahan</td>
                                    <td class='text-left'>: {{Carbon::create($DataSOP->tanggal_pengesahan)->translatedformat('d F Y')}} </td>
                                </tr>
                                <tr>
                                    <td colspan='2' class="text-left">
                                        Disahkan oleh: <br>
                                        Kepala {{$Identitas->namasek}} <br> <br> <br> <br>

                                        {{ $Identitas->nama_kepala }}. <br>
                                        NIP: {{ $Identitas->nip }}<br>

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td width='50%' class='table-primary text-center'>{{ $Identitas->namasek }}</td>
                        <td width='50%' class='table-primary text-center'>{{ $DataSOP->judul }}</td>
                    </tr>
                    <tr>
                        <td class='table-primary text-center'>Dasar Hukum</td>
                        <td class='table-primary text-center'>Kualifikasi Pelaksana</td>
                    </tr>
                    <tr>
                        <td class='text-left'>{!! $DataSOP->dasar_hukum !!}</td>
                        <td class='text-left'>{!! $DataSOP->kualifikasi_pelaksana !!}</td>
                    </tr>
                    <tr>
                        <td class='table-primary text-center'>Keterkaitan</td>
                        <td class='table-primary text-center'>Peralatan / Perlengkapan</td>
                    </tr>
                    <tr>
                        <td class='text-left'>{!! $DataSOP->keterkaitan !!}</td>
                        <td class='text-left'>{!! $DataSOP->peralatan !!}</td>
                    </tr>
                    <tr>
                        <td class='table-primary text-center'>Peringatan</td>
                        <td class='table-primary text-center'>Pencatatan dan Pendataan</td>
                    </tr>
                    <tr>
                        <td class='text-left'>{!! $DataSOP->peringatan !!}</td>
                        <td class='text-left'>{!! $DataSOP->pencatatan !!}</td>
                    </tr>
                </tbody>

            </table>


        </div>
    @endforeach
    </section>
</x-layout-view-pkks>
