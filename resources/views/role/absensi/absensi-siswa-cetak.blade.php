@php
    //content
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
    $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
    $urlroot = app('request')->root();
@endphp
<x-layout-cetak>

    <link rel='stylesheet' href='{{ asset('css/layout-cetak.css') }}'>
    {{-- data_judul --}}
    <div class='container'>
        <x-kop-surat-cetak></x-kop-surat-cetak>
        <div class="row">
            <div class="col-xl-12">
                <div class='card-header mt-4 mb-2' style='background:#D7F4F4'>
                    <h3 class='card-title'>Rekapitulasi Absen</h3>
                </div>
                {{-- blade-formatter-disable --}}
                    <x-grafik>{{ implode(',', $label_grafik) }}/{{ implode(',', $data_grafik) }}/bar/100%,85%/Garfik Absensi Siswa,Data Absensi Siswa</x-grafik>
                    {{-- blade-formatter-enable --}}
            </div>
            <div class="col-xl-12">
                <div class='card-header bg-primary'>
                    <h3 class='card-title'>Rekapitulasi Absen</h3>
                </div>
                <table id='example2' width='100%' class='table table-responsive table-bordered table-hover mt-1'
                    style='font-size:13pt'>
                    <thead style='background-color:#D4ECFC'>
                        <tr class="text-center align-middle">
                            <th width='1%'>No</th>
                            <th>Kelas</th>
                            <th>Jumlah Siswa Absen</th>
                            <th>Ceklist</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($datas as $index => $data)
                            <tr>
                                <td class='text-center'>{{ $loop->iteration }}</td>
                                <td class='text-center'>{{ $data->kelas }}</td>
                                <td class='text-center'>{{ $data->jumlah_absen }}</td>

                                @php
                                    $find_Detailsiswa = App\Models\User\Siswa\Detailsiswa::where(
                                        'kelas_id',
                                        $data->id,
                                    )->count();
                                @endphp
                                <td class='text-center' style='font-size:15pt'>
                                    @if ($find_Detailsiswa - $data->jumlah_absen !== 0)
                                        <span> <i class='fa fa-times-circle p-2 text-danger'></i><span>
                                            @else
                                                <span> <i class='fa fa-check-circle p-2 text-success'></i><span>
                                    @endif

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada absensi hari ini</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot style='background-color:#D4ECFC'>
                        <tr class="text-center align-middle">
                            <th width='1%'>No</th>
                            <th>Kelas</th>
                            <th>Jumlah Siswa Absen</th>
                            <th>Ceklist</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class='page-break'></div>

        <div class='card-header bg-primary'>
            <h3 class='card-title'>Total Kehadiran</h3>
        </div>
        <table class="table table-bordered">
            <thead>
                <thead style='background-color:#D4ECFC'>
                    <th class='text-center'>Kelas</th>
                    <th class='text-center'>Sakit</th>
                    <th class='text-center'>Izin</th>
                    <th class='text-center'>Alfa</th>
                    <th class='text-center'>Hadir</th>
                    <th class='text-center'>Presentase</th>
                    </tr>
                </thead>
            <tbody>
                @foreach ($rekapKelas as $kelas)
    <tr>
        <td class='text-center'>{{ $kelas->kelas }}</td>
        <td class='text-center'>{{ $kelas->sakit_count }}</td>
        <td class='text-center'>{{ $kelas->ijin_count }}</td>
        <td class='text-center'>{{ $kelas->alfa_count }}</td>
        <td class='text-center'>{{ $kelas->hadir_count }}</td>
        <td class='text-center'>
            @if($kelas->total_siswa > 0)
                {{ number_format(($kelas->hadir_count / $kelas->total_siswa) * 100, 0) }}%
            @else
                0%
            @endif
        </td>
    </tr>
@endforeach

            </tbody>
        </table>

    </div>
    {{-- data_judul --}}

    {{-- @dump($datas, $ProcessedTemplate, $Identitas, $DataGuru) --}}
</x-layout-cetak>
