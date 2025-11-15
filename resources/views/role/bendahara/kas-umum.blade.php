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
            {{-- Papan Informasi --}}


            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->


            {{-- blade-formatter-disable --}}
            <div class='row m-2'>
                <div class='col-xl-2'>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#ReportPdf'><i class='fa fa-file-pdf'></i> Report Data</button>
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
                            @php
                                $total_penerimaan = 0;
                                $total_pengeluaran = 0;
                            @endphp

                            @foreach ($rekaps as $rekap)
                                <tr>
                                    <td class="p-2 border text-green-600 text-center">{{ $loop->iteration }}</td>
                                    <td class="p-2 border text-center">{{ $rekap->sumber_dana }}</td>
                                    <td class="p-2 border text-green-600 text-center">
                                        Rp. {{ number_format($rekap->total_penerimaan, 0, ',', '.') }}
                                    </td>
                                    <td class="p-2 border text-red-600 text-center">
                                        Rp. {{ number_format($rekap->total_pengeluaran, 0, ',', '.') }}
                                    </td>

                                    @php
                                        $selisih = $rekap->total_penerimaan - $rekap->total_pengeluaran;
                                        $total_penerimaan += $rekap->total_penerimaan;
                                        $total_pengeluaran += $rekap->total_pengeluaran;
                                    @endphp

                                    <td class="p-2 border text-center">
                                        @if($selisih < 0)
                                            <span class="text-danger font-semibold">
                                                Rp. {{ number_format($selisih, 0, ',', '.') }}
                                            </span>
                                        @else
                                            <span class="text-success font-semibold">
                                                Rp. {{ number_format($selisih, 0, ',', '.') }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            @php
                                $total_selisih = $total_penerimaan - $total_pengeluaran;
                            @endphp

                            <tr class="table-primary">
                                <td colspan="2" class="p-2 border text-center">Total</td>
                                <td class="p-2 border text-green-600 text-center">
                                    Rp. {{ number_format($total_penerimaan, 0, ',', '.') }}
                                </td>
                                <td class="p-2 border text-red-600 text-center">
                                    Rp. {{ number_format($total_pengeluaran, 0, ',', '.') }}
                                </td>
                                <td class="p-2 border text-center">
                                    @if($total_selisih < 0)
                                        <span class="text-danger">
                                            Rp. {{ number_format($total_selisih, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-success">
                                            Rp. {{ number_format($total_selisih, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- blade-formatter-enable --}}
            <div class="row p-2">
                <div class="col-xl-12">
                </div>
            </div>

            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>Riwayat Transaksi {{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                            <thead>
                                {{-- blade-formatter-disable --}}
                                <tr class='text-center'>
                                    <th width='1%'>ID</th>
                                    @foreach ($arr_ths as $arr_th)
                                        <th class='text-center' @if ($arr_th === 'Tanggal') width='15%' @endif>{{ $arr_th }}</th>
                                    @endforeach
                                </tr>
                                {{-- blade-formatter-enable --}}
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        <td class='text-center'>{{ $loop->iteration }}</td>
                                        <td class='text-center'>
                                            {{ Carbon::create($data->tanggal)->translatedformat('l, d F Y') }}</td>
                                        <td class='text-center'> {{ $data->sumber_dana }}</td>
                                        <td class="text-success">Rp.
                                            {{ number_format($data->penerimaan, 0, ',', '.') }}
                                        <td class="text-danger">Rp.
                                            {{ number_format($data->pengeluaran, 0, ',', '.') }}
                                        </td>
                                        <td class='text-left'> {{ $data->uraian }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class='text-center'>
                                    <th width='1%'>ID</th>
                                    @foreach ($arr_ths as $arr_th)
                                        <th class='text-center'> {{ $arr_th }}</th>
                                    @endforeach
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>


        </div>

    </section>
</x-layout>
{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='ReportPdf' tabindex='-1' aria-labelledby='LabelReportPdf' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelReportPdf'>
                    Laporan Data
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                {{-- blade-formatter-disable --}}
                <form id='#id' action='{{route('laporan.buku.kas.umum')}}' method='POST'>
                    @csrf
                    @method('POST')
                    <div class='form-group'>
                    <label for='sumber_data'>Sumber Dana</label>
                        <select name='sumber_dana'  id='id' class='form-control' data-placeholder='Pilih sumber dana' required>
                            <option value=''>--- Pilih Sumber Dana ---</option>
                            @foreach($sumber_dana_lists as $sumber_dana_list)
                                <option value='{{$sumber_dana_list}}'>{{$sumber_dana_list}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-xl-6">
                            <div class='form-group'>
                                <label for='tanggal_awal'>Tanggal Awal</label>
                                <input type='date' class='form-control' id='tanggal_awal' name='tanggal_awal' placeholder='Tanggal Awal' value='{{Carbon::now()->translatedFormat('Y-m-d')}}' required>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class='form-group'>
                                <label for='tanggal_akhir'>Tanggal Akhir</label>
                                <input type='date' class='form-control' id='tanggal_akhir' name='tanggal_akhir' placeholder='Tanggal Akhir' value="{{ \Carbon\Carbon::now()->addMonth(1)->startOfMonth()->format('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class='modal-footer'>
                        <button type='submit' class='btn btn-primary'><i class='fa fa-print'></i> Print</button>
                    </div>
                </form>
                {{-- blade-formatter-enable --}}
            </div>

        </div>
    </div>

</div>
