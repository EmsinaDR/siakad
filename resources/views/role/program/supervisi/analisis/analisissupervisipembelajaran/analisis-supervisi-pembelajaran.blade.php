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
                            <thead class="table-light">
                                <tr>
                                    <th class='text-center align-middle'>No</th>
                                    <th  width='35%' class='text-center align-middle'>Indikator</th>
                                    <th class='text-center align-middle'>Jumlah Temuan</th>
                                    <th width='20%' class='text-center align-middle'>Nilai</th>
                                    <th width='5%' class='text-center align-middle'>Persentase Keterpenuhan</th>
                                    <th class='text-center align-middle'>Rekomendasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $indikatorId => $items)
                                    @php
                                        $indikatorNama = $items->first()->indikator->indikator ?? '-';
                                        // Temuan buruk: nilai 1-2
                                        $temuanBuruk = $items->where('nilai', '<=', 2);
                                        $kelasList = $temuanBuruk->pluck('kelas.kelas')->unique()->implode(', ');
                                        $nilaiList = $temuanBuruk->pluck('nilai')->implode(', ');
                                        $jumlahTemuan = $temuanBuruk->count();

                                        // Persentase keterpenuhan
                                        $total = $items->count();
                                        $baik = $items->where('nilai', '>', 2)->count();
                                        $persen = $total > 0 ? round(($baik / $total) * 100, 1) : 0;
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $indikatorNama }}</td>
                                        <td>{{ $jumlahTemuan }} temuan</td>
                                        <td  class='text-center align-middle'>
                                            @foreach (explode(',', $nilaiList) as $nilai)
                                                @php
                                                    $colorClass = match (true) {
                                                        $nilai <= 1 => 'bg-danger',
                                                        $nilai <= 2 => 'bg-warning',
                                                        default => 'bg-success',
                                                    };
                                                @endphp
                                                <span class="badge {{ $colorClass }} text-white">{{ $nilai }}</span>
                                            @endforeach
                                        </td>
                                        <td class='text-center align-middle'>
                                            <span
                                                class="badge
                        @if ($persen >= 80) bg-success
                        @elseif ($persen >= 50)
                            bg-warning
                        @else
                            bg-danger @endif
                        text-white rounded-pill">
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












                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th  class='text-center align-middle'>No</th>
                                    <th  class='text-center align-middle'>Indikator</th>
                                    <th  class='text-center align-middle'>Total <br>(Nilai <= 2)</th>
                                    <th  class='text-center align-middle'>Total Guru</th>
                                    <th  class='text-center align-middle'>Persentase</th>
                                    <th  class='text-center align-middle'>Rekomendasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                               {{-- blade-formatter-disable --}}
                                @foreach ($results->groupBy('sub_kategori') as $sub_kategori => $subKategoriGroup)
                                    <tr>
                                        <td colspan="8" class="bg-info text-white">{{ $sub_kategori }}</td>
                                    </tr>
                                    @foreach ($subKategoriGroup->groupBy('sub_sub_kategori') as $sub_sub_kategori => $subSubKategoriGroup)
                                        <tr>
                                            <td colspan="8" class="bg-secondary text-white">{{ $sub_sub_kategori }}</td>
                                        </tr>
                                        @foreach ($subSubKategoriGroup as $key => $result)
                                            <tr>
                                                <td class='text-center align-middle'>{{ $loop->parent->iteration . '.' . $loop->iteration }}</td>
                                                <td class='text-left align-middle' width='45%'>{{ $result->indikator }}</td>
                                                <td class='text-center align-middle'>{{ $result->total_pembelajaran_buruk }}</td>
                                                <td class='text-center align-middle'>{{ $result->total_pembelajaran }}</td>
                                                <td class='text-center align-middle'>
                                                    @php
                                                        $persen = $result->total_pembelajaran > 0
                                                            ? round(($result->total_pembelajaran_buruk / $result->total_pembelajaran) * 100, 2)
                                                            : 0;
                                                        // Tentukan warna berdasarkan persen
                                                        if ($persen <= 20) {
                                                            $colorClass = 'bg-success p-2 rounded-pill';  // Persentase 0% - 20%, gunakan warna hijau
                                                        } elseif ($persen <= 50) {
                                                            $colorClass = 'bg-warning p-2 rounded-pill';  // Persentase 21% - 50%, gunakan warna kuning
                                                        } else {
                                                            $colorClass = 'bg-danger p-2 rounded-pill';  // Persentase 51% - 100%, gunakan warna merah
                                                        }
                                                    @endphp

                                                    <span class="{{ $colorClass }}">
                                                        {{ $persen }}%
                                                    </span>
                                                </td>

                                                <td>
                                                    @if ($persen >= 80)
                                                        Sudah sangat baik, lanjutkan monitoring.
                                                    @elseif ($persen >= 50)
                                                        Perlu perhatian lebih, namun masih cukup baik.
                                                    @else
                                                        Harus mengadakan pelatihan terkait indikator ini.
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </tbody>
                                               {{-- blade-formatter-enable --}}
                        </table>

                        <div class='card-body my-2'>
                            <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; text-align: left;">
    <thead style="background-color: #f0f0f0;">
        <tr>
            <th class='text-center align-middle'>Interval Persentase</th>
            <th class='text-center align-middle'>Kategori</th>
            <th class='text-center align-middle'>Catatan</th>
        </tr>
    </thead>
    <tbody>
        <tr style="background-color: #d4edda; color: #155724;">
            <td>>= 80%</td>
            <td><strong>Sangat Baik</strong></td>
            <td>Sudah sangat baik, lanjutkan monitoring.</td>
        </tr>
        <tr style="background-color: #fff3cd; color: #856404;">
            <td>>= 50% dan &lt; 80%</td>
            <td><strong>Cukup Baik</strong></td>
            <td>Perlu perhatian lebih, namun masih cukup baik.</td>
        </tr>
        <tr style="background-color: #f8d7da; color: #721c24;">
            <td>&lt; 50%</td>
            <td><strong>Perlu Perbaikan</strong></td>
            <td>Harus mengadakan pelatihan terkait indikator ini.</td>
        </tr>
    </tbody>
</table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
