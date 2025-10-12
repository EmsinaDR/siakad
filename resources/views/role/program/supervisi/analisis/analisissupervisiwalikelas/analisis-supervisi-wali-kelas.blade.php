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
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'>
                        <i class='fa fa-plus'></i> Tambah Data
                    </button>
                </div>
                <div class='col-xl-10'></div>
            </div>
            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <!-- Konten -->
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Indikator</th>
                                    <th>Kelas yang Bermasalah</th>
                                    <th>Jumlah Temuan</th>
                                    <th>Nilai</th>
                                    <th>Rekomendasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $indikatorId => $items)
                                    @php
                                        $indikatorNama = $items->first()->indikator->indikator ?? '-';
                                        $kelasList = $items->pluck('kelas.kelas')->unique()->implode(', ');
                                        $nilaiList = $items->pluck('nilai')->implode(', ');
                                        $jumlahTemuan = $items->count();
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $indikatorNama }}</td>
                                        <td>{{ $kelasList }}</td>
                                        <td>{{ $jumlahTemuan }} temuan</td>
                                        <td>{{ $nilaiList }}</td>
                                        <td>Harus mengadakan pelatihan terkait indikator ini</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>








                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Indikator</th>
                                    <th>Kelas yang Bermasalah</th>
                                    <th>Jumlah Temuan</th>
                                    <th>Nilai</th>
                                    <th>Persentase Keterpenuhan</th>
                                    <th>Rekomendasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datasx as $indikatorId => $items)
                                    @php
                                        $indikatorNama = $items->first()->indikator->indikator ?? '-';

                                        // Data nilai buruk (1-2)
                                        $temuanBuruk = $items->where('nilai', '<=', 2);
                                        $kelasList = $temuanBuruk->pluck('kelas.kelas')->unique()->implode(', ');
                                        $nilaiList = $temuanBuruk->pluck('nilai')->implode(', ');
                                        $jumlahTemuan = $temuanBuruk->count();

                                        // Persentase keterpenuhan: nilai > 2
                                        $total = $items->count();
                                        $baik = $items->where('nilai', '>', 2)->count();
                                        $persen = $total > 0 ? round(($baik / $total) * 100, 1) : 0;
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $indikatorNama }}</td>
                                        <td>{{ $kelasList ?: '-' }}</td>
                                        <td>{{ $jumlahTemuan }} temuan</td>
                                        <td>
                                            @foreach (explode(',', $nilaiList) as $nilai)
                                                @php
                                                    // Menentukan warna berdasarkan nilai
                                                    $colorClass = '';
                                                    if ($nilai <= 1) {
                                                        $colorClass = 'bg-danger'; // Merah
                                                    } elseif ($nilai <= 2) {
                                                        $colorClass = 'bg-warning'; // Kuning
                                                    } else {
                                                        $colorClass = 'bg-success'; // Hijau
                                                    }
                                                @endphp
                                                <span
                                                    class="badge {{ $colorClass }} text-white">{{ $nilai }}</span>
                                            @endforeach
                                        </td>

                                        <td>
    <span class="badge
        @if ($persen >= 80)
            bg-success text-white rounded-pill
        @elseif ($persen >= 50)
            bg-warning text-white rounded-pill
        @else
            bg-danger text-white rounded-pill
        @endif
    ">
        {{ $persen }}%
    </span>
</td>

                                        <td>
                                            @if ($persen < 70)
                                                Harus mengadakan pelatihan terkait indikator ini
                                            @else
                                                Sudah cukup baik, lanjutkan monitoring
                                            @endif
                                        </td>
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
