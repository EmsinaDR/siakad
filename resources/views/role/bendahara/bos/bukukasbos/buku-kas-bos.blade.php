@php
    //content
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
    $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
    $urlroot = app('request')->root();
@endphp
<x-layout>
    <style>
        textarea {
            resize: none,
        }
    </style>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>
    <section class='content mx-2 my-4'>
        {{-- Validator --}}
        @if ($errors->any())
            <div class='alert alert-danger'>
                <ul class='mb-0'>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- Validator --}}
        <div class='card'>
            <!--Card Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</h3>
            </div>
            <!--Card Header-->
            <div class='row m-2'>
                <div class='col-xl-2'>
                    {{-- <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'><i class='fa fa-plus'></i> Tambah Data</button> --}}
                </div>
                <div class='col-xl-10'>
                    <table id='examplex' width='100%' class='table table-bordered table-hover'>
                        <thead>
                            <tr class='table-primary text-center align-middle'>
                                <th>ID</th>
                                <th>Sumber Dana</th>
                                <th>Pemasukkan</th>
                                <th>Pengeluaran</th>
                                <th>Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($DanaBos as $data)
                                <tr class='text-center'>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->sumber_dana }}</td>
                                    <td>Rp. {{ number_format($data->nominal, 0) }}</td>
                                    @php
                                        $PengeluaranBos = \App\Models\Bendahara\BOS\PengeluaranBOS::where(
                                            'keuangan_bos_id',
                                            $data->id,
                                        )->sum('nominal');
                                    @endphp
                                    <td>Rp. {{ number_format($PengeluaranBos, 0) }}</td>
                                    <td @if($data->nominal - $PengeluaranBos < 0) class='text-danger' @else class='text-success' @endif>Rp. {{ number_format($data->nominal - $PengeluaranBos, 0) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class='table-primary text-center align-middle'>
                                <th>ID</th>
                                <th>Sumber Dana</th>
                                <th>Pemasukkan</th>
                                <th>Pengeluaran</th>
                                <th>Saldo</th>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <!-- Konten -->
                        <table id='example1' width='100%' class='table table-bordered table-hover'>
                            <thead>
                                <tr class='table-primary text-center align-middle'>
                                    <th>ID</th>
                                    <th>Tanggal</th>
                                    <th>Sumber Dana</th>
                                    <th>Penggunaan</th>
                                    <th>Pemasukkan</th>
                                    <th>Pengeluaran</th>
                                    <th>Uraian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    {{-- @dump($data) --}}
                                    {{-- blade-formatter-disable --}}
                                    @php
                                        $IdList = $data->Anggraran->rencana_anggaran_id ?? '';
                                        if ($IdList !== null) {
                                            $dataList = \App\Models\Bendahara\RencanaAnggaranList::where('id',$IdList)->first();
                                        }
                                    @endphp
                                    {{-- blade-formatter-enable --}}
                                    <tr class='text-center'>
                                        <td class='text-center'>{{ $loop->iteration }}</td>
                                        <td class='text-center'>
                                            {{ Carbon::create($data->tanggal)->translatedformat('l, d F Y') }}</td>
                                        <td class='text-center'>{{ $data->SumberDana->sumber_dana ?? '' }}</td>
                                        <td class='text-left'>
                                            {{ $dataList->jenis_pengeluaran ?? '' }}
                                        </td>
                                        <td class='text-success'>Rp. {{ number_format($data->pemasukkan, 0) }}</td>
                                        <td class='text-danger'>Rp. {{ number_format($data->pengeluaran, 0) }}</td>
                                        <td class='text-left'>{{ $data->uraian }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class='table-primary text-center align-middle'>
                                    <th>ID</th>
                                    <th>Tanggal</th>
                                    <th>Sumber Dana</th>
                                    <th>Penggunaan</th>
                                    <th>Pemasukkan</th>
                                    <th>Pengeluaran</th>
                                    <th>Uraian</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
