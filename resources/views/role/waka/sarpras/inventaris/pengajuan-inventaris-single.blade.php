@php
    //Pengjuan Inventaris Waka
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


            <div class='ml-2 my-4'>
                Pengjuan Inventaris Waka
            </div>
            <div class="card">
                <div class='card-header bg-primary'>
                    <h3 class='card-title'>FORMULIR PENGAJUAN INVENTARIS RUANGAN</h3>
                </div>
                <div class='card-body'>
                    <div class="row">
                        <div class="col-xl-2">
                            <p>Nama Ruangan</p>
                            <p>Tanggal Pengajuan</p>
                            <p>Nama Penanggung Jawab</p>
                        </div>
                        <div class="col-xl-8">
                            <p> : ..........................................................</p>
                            <p> : ..........................................................</p>
                            <p> : ..........................................................</p>
                        </div>
                    </div>
                    <div class="col-xl-10">
                        <table id='example1x' width='100%' class='table table-bordered table-hover'>
                            <thead>
                                <tr class='text-center align-middle'>
                                    <th>ID</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr class='text-center'>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->nama_barang }}</td>
                                        <td>{{ $data->jumlah }}</td>
                                        <td>{{ $data->harga }}</td>
                                        <td>{{ $data->jumlah * $data->harga }}</td>
                                        <td>{{ $data->keterangan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class='text-center align-middle'>
                                    <th class='text-left' colspan='3'>Total</th>
                                    <th class='text-left align-middle' colspan='2'>.................</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>

        </div>

    </section>
</x-layout>
