@php
    //content
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
@endphp
<x-layout-cetak>
    <section>
        <link rel="stylesheet" href="{{ asset('css/viewpkks.css') }}">
        <div class="container">
            <x-kop-surat-cetak></x-kop-surat-cetak>
            <h5 class="header-title mb-5">Rekap Keuangan</h5>
            <table id='example1' width='100%' class='table no-border table-hover'>
                <tbody>
                    <tr>
                        <td width='20%' class='text-left'>Periode</td>
                        <td class='text-left'>: {{Carbon::create($tanggal_awal)->translatedformat('d F Y')}} - {{Carbon::create($tanggal_akhir)->translatedformat('d F Y')}}</td>
                    </tr>
                    <tr>
                        <td width='20%' class='text-left'>Sumber Dana</td>
                        <td class='text-left'>: {{$sumber_dana}}</td>
                    </tr>
                </tbody>
            </table>

            <table id='example1' width='100%' class='table table-bordered table-hover'>
                <thead>
                    <tr class='table-primary text-center align-middle'>
                        <th>ID</th>
                        <th>Tamggal</th>
                        <th>Pemasukkan</th>
                        <th>Pengeluaran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $data)
                        <tr class='text-center'>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ Carbon::create($data->tanggal)->translatedformat('l, d F Y') }}</td>
                            <td>Rp. {{ number_format($data->penerimaan, 0) }}</td>
                            <td>Rp. {{ number_format($data->pengeluaran, 0) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class='table-primary text-center align-middle'>
                        <th>ID</th>
                        <th>Tamggal</th>
                        <th>Pemasukkan</th>
                        <th>Pengeluaran</th>
                    </tr>
                </tfoot>
            </table>
            {{-- @if (!$loop->last)
            <div class="page-break"></div>
        @endif --}}
        </div>
    </section>
    {{-- <x-layout-view-pkks> --}}
</x-layout-cetak>
{{-- </x-layout-view-pkks> --}}
