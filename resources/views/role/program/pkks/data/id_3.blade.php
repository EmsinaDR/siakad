@php
    use Illuminate\Support\Carbon;

    Carbon::setLocale('id');
    $activecrud = collect([2, 4, 6, 8])->contains(Auth::id());
    $urlroot = request()->root();
@endphp
<x-layout-view-pkks>
    <x-slot:judul>SUSUNAN DAN TUGAS ORGANISASI</x-slot:judul>
    <link rel="stylesheet" href="{{ asset('css/viewpkks.css') }}">
    <section>
        @foreach ($dataRapats as $dataRapat)
            <div class="container">
                <x-kop-surat-cetak />
                <h2 class="header-title">Daftar Hadir Rapat</h2>
                <table style='border:none' width="100%" border="0">
                    <tr>
                        <td width='30%' style='text-align:left;border:none'>Hari Dan Tanggal</td>
                        <td style='text-align:left;border:none'>:
                            {{ Carbon::parse($dataRapat->tanggal_pelaksanaan)->translatedFormat('l, d F Y') }}</td>
                    </tr>
                    <tr>
                        <td style='text-align:left;border:none'>Pembahasan</td>
                        <td style='text-align:left;border:none'>: {!! $dataRapat->perihal !!}</td>
                    </tr>
                </table>

                <table class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr class="table-primary text-center align-middle">
                            <th id='idnumber'>ID</th>
                            <th>Nama</th>
                            <th id='ttd' width="45%">Tanda Tangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr class="text-center">
                                <td width='2%'>{{ $loop->iteration }}</td>
                                <td class="text-left">{{ $data->nama_guru }}</td>
                                <td width="10%" class="{{ $loop->iteration % 2 != 0 ? 'text-left' : 'text-right' }}">
                                    {{ $loop->iteration }}..................................
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="page-break"></div>
        @endforeach
        {{-- @endforeach --}}
    </section>
</x-layout-view-pkks>
