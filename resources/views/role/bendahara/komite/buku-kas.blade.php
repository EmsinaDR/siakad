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
                   </div>
               {{-- blade-formatter-enable --}}
            <div class='col-xl-10'>
                <table id='example1x' width='100%' class='table table-bordered table-hover'>
                    <thead>
                        <tr class='table-primary'>
                            <th class='text-center align-middle' rowspan='2'>Program</th>
                            <th class='text-center align-middle' rowspan='2'>Total Penerimaan</th>
                            <th class='text-center align-middle' rowspan='1' colspan='2'>Total Pengeluaran</th>
                        </tr>
                        <tr class='table-primary text-center align-middle'>
                            <th>Terencana</th>
                            <th>Tak Terencana</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- blade-formatter-disable --}}
                            <tr>
                                @php
                                    $rekapsPengeluaran = \App\Models\Bendahara\BukukasKomite::where('tapel_id', $Tapels->id)->get();
                                    $terencana = $rekapsPengeluaran->where('program', 'Terencana')->sum('pengeluaran');
                                    $takterencana = $rekapsPengeluaran->where('program', 'Tak Terencana')->sum('pengeluaran');
                                @endphp
                                <td width='20%'>Rincian Anggaran</td>
                                <td class='text-center align-middle'>Rp.
                                    {{ number_format($rekapsPengeluaran->where('program', 'Pembayaran Komite')->sum('penerimaan'), 0) }}
                                </td>
                                <td class='text-center align-middle'>Rp. {{ number_format($terencana, 0) }}</td>
                                <td class='text-center align-middle'>Rp. {{ number_format($takterencana, 0) }}</td>
                            </tr>
                            <tr>
                                <td>Saldo</td>
                                <td colspan='1'><span class="bg-success p-2">Rp. {{ number_format($rekapsPengeluaran->where('program', 'Pembayaran Komite')->sum('penerimaan') - ($rekapsPengeluaran->where('program', 'Terencana')->sum('pengeluaran') + $rekapsPengeluaran->where('program', 'Tak Terencana')->sum('pengeluaran')), 0) }}</span>
                                </td>
                                <td colspan='2'>
                                    @php
    $totalPenerimaan = $rekapsPengeluaran->where('program', 'Pembayaran Komite')->sum('penerimaan');

    if ($totalPenerimaan > 0) {
        $persentase = ($takterencana / $totalPenerimaan) * 100;
        $status = 'dinilai';
    } else {
        $persentase = null;
        $status = 'belum_ada_data';
    }
@endphp


                                    @if ($status === 'belum_ada_data')
    <span class="bg-secondary p-2 text-white rounded d-inline-block">
        <i class="fas fa-info-circle"></i> <b>Belum Ada Data Pemasukan</b>
    </span>
@else
    @if ($persentase > 75)
        <span class="bg-danger p-2 text-white rounded d-inline-block">
            <i class="fas fa-skull-crossbones"></i> <b>Sangat Tidak Terkendali</b>
        </span>
    @elseif($persentase > 50)
        <span class="bg-danger p-2 text-white rounded d-inline-block">
            <i class="fas fa-fire-alt"></i> <b>Tidak Terkendali</b>
        </span>
    @elseif($persentase > 10)
        <span class="bg-warning p-2 text-dark rounded d-inline-block">
            <i class="fas fa-exclamation-triangle"></i> <b>Kurang Terkendali</b>
        </span>
    @else
        <span class="bg-success p-2 text-white rounded d-inline-block">
            <i class="fas fa-check-circle"></i> <b>Terkendali</b>
        </span>
    @endif

    <!-- Tampilkan persentase dan total -->
    <span class="p-2 text-white rounded d-inline-block bg-secondary">
        <i class="fas fa-percentage"></i> {{ number_format($persentase, 2) }}%
    </span>
    <span class="bg-info p-2 text-white rounded d-inline-block">
        <i class="fas fa-wallet"></i> Rp. {{ number_format($terencana + $takterencana, 0) }}
    </span>
@endif

                                </td>
                            </tr>

                            <tr>
                                @php
    // Ambil total penerimaan dari program "Pembayaran Komite"
    $totalPenerimaan = $rekapsPengeluaran
                            ->where('program', 'Pembayaran Komite')
                            ->sum('penerimaan');

    // Hitung persentase jika total penerimaan lebih dari 0
    $persentase = $totalPenerimaan > 0
        ? ($takterencana / $totalPenerimaan) * 100
        : 0;
@endphp


                                <td>Indikator</td>
                                <td colspan='3'>
                                    <!-- Berdasarkan nilai $persentase, tentukan indikator status -->
                                    @if ($persentase > 75)
                                        <!-- Jika persentase pengeluaran tidak terencana lebih dari 75%, beri peringatan dengan warna merah -->
                                        <span class="bg-danger p-2"><b>Informasi</b></span> <br>
                                        <!-- Saran tindakan jika pengeluaran tidak terencana sudah melebihi 75% -->
                                        <ol class='mt-3'>
                                            <li>Perlu perhatian khusus untuk pelaksanaan berikutnya dalam penggunaan biasa agar pengeluaran <b class="text-danger">Tidak Terencana</b> tetap < <b class="text-success">Terencana</b>.</li>
                                            <li>Pengeluaran tidak terencana harus dikendalikan agar tidak melebihi 75% dari anggaran yang terencana.</li>
                                        </ol>
                                    @elseif ($persentase > 50)
                                        <!-- Jika persentase pengeluaran tidak terencana lebih dari 50%, beri peringatan dengan warna merah -->
                                        <span class="bg-danger p-2"><b>Informasi</b></span> <br>
                                        <!-- Saran tindakan jika pengeluaran tidak terencana antara 50% - 75% -->
                                        <ol class='mt-3'>
                                            <li>Segera lakukan evaluasi dan kontrol lebih ketat pada pengeluaran <b  class="text-danger">Tidak Terencana</b> agar tidak meningkat lebih tinggi.</li>
                                            <li>Usahakan pengeluaran tidak terencana di bawah 50% agar anggaran lebih efisien.</li>
                                        </ol>
                                    @elseif ($persentase > 10)
                                        <!-- Jika persentase pengeluaran tidak terencana lebih dari 10%, beri peringatan dengan warna biru -->
                                        <span class="bg-primary p-2"><b>Informasi</b></span> <br>
                                        <!-- Saran tindakan jika pengeluaran tidak terencana antara 10% - 50% -->
                                        <ol class='mt-3'>
                                            <li>Perlu waspada terhadap pengeluaran <b class="text-danger">Tidak Terencana</b> yang mulai meningkat.</li>
                                            <li>Pengeluaran tidak terencana sebaiknya tidak lebih dari 10% dari anggaran terencana.</li>
                                        </ol>
                                    @else
                                        <!-- Jika pengeluaran tidak terencana kurang dari 10%, beri tanda hijau yang menunjukkan baik -->
                                        <span class="bg-success p-2"><b>Informasi</b></span> <br>
                                        <!-- Saran tindakan jika pengeluaran tidak terencana kurang dari 10% -->
                                        <ol class='mt-3'>
                                            <li>Pengeluaran tidak terencana terjaga dengan baik. Pertahankan tingkat efisiensi anggaran ini.</li>
                                            <li>Usahakan agar pengeluaran tidak terencana tetap di bawah 10% untuk menjaga kontrol anggaran yang baik.</li>
                                        </ol>
                                    @endif
                                </td>

                                </td>
                            </tr>
                            {{-- blade-formatter-enable --}}
                    </tbody>
                </table>


            </div>
        </div>

        {{-- blade-formatter-disable --}}
               <div class="row p-2">
                <div class="col-xl-12">
{{-- <x-inputallin>readonly:Nama Dokumen::::{{$DataPPKS->nama_dokumen}}:readonly</x-inputallin> --}}
                </div>
               </div>
               {{-- blade-formatter-enable --}}


        <div class='ml-2 my-4'>
            <div class='card'>
                <div class='card-header bg-primary'>
                    <h3 class='card-title'>{{ $title }}</h3>
                </div>
                <div class='card-body'>
                    <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Uraian</th>
                                <th>Program</th>
                                <th>Penerimaan</th>
                                <th>Pengeluaran</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ Carbon::create($item->tanggal)->translatedformat('l, d F Y') }}</td>
                                    <td>{{ $item->uraian }}</td>
                                    <td>{{ $item->program }}</td>
                                    <td class="text-success">Rp. {{ number_format($item->penerimaan, 0, ',', '.') }}
                                        // {{ $item->pemasukkan_id }}
                                    </td>
                                    <td class="text-danger">Rp.
                                        {{ number_format($item->pengeluaran, 0, ',', '.') }} //
                                        {{ $item->pengeluaran_id }}
                                    </td>
                                    <td>{{ $item->keterangan }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>


        </div>

    </section>
</x-layout>
