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


            {{-- <div class='row m-2'>
                <div class='col-xl-2'>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'> <i
                            class='fa fa-plus'></i> Tambah Data</button>
                </div>
                <div class='col-xl-10'></div>
            </div> --}}


            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>Daftar Nilai PTS dan PAS</h3>
                    </div>
                    <div class='card-body'>
                        <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                            <thead>
                                <tr class='text-center align-middle'>
                                    <th class='text-center align-middle' rowspan='2' width='1%'>ID</th>
                                    @foreach ($arr_ths as $arr_th)
                                        <th rowspan='2' class='text-center align-middle'> {{ $arr_th }}</th>
                                    @endforeach
                                    <th class='text-center align-middle' colspan='2'>Nilai</th>
                                    <th class='text-center align-middle' rowspan='2'>Total</th>
                                    <th class='text-center align-middle' rowspan='2'>Rata - rata</th>
                                </tr>
                                    <th>PTS</th>
                                    <th>PAS</th>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        <td class='text-center'>{{ $loop->iteration }}</td>
                                        <td class='text-center'> {{ $data->nis }}</td>
                                        <td class='text-center'> {{ $data->nama_siswa }}</td>
                                        <td class='text-center'> {{ $data->KelasOne->kelas }}</td>
                                        @php
                                            // dd($data->id);
                                            $Nilai = \App\Models\WakaKurikulum\Elearning\Nilai\KurikulumNilaiPTSPAS::where(
                                                'detailsiswa_id',
                                                $data->id,
                                            )
                                                ->where('mapel_id', request()->segment(3))
                                                ->get();
                                            // dd($Nilai);
                                        @endphp
                                        @if ($Nilai->isEmpty())
                                            @for ($i = 0; $i < count($arr_ths) + 4; $i++)
                                                <td class='text-center' colspan='1'></td>
                                            @endfor
                                        @else
                                            @foreach ($Nilai as $nilai)
                                                @php
                                                    $NKKM = $KKM->where('mapel_id', $nilai->mapel_id)->first();
                                                @endphp
                                                <td class='text-center'> {{ $nilai->Mapel->mapel ?? '-' }}</td>
                                                <td class='text-center'> {{ $NKKM->kkm }}</td>
                                                <td class='text-center'> {{ $nilai->Guru->nama_guru }}</td>
                                                <td class='text-center'>
                                                    @if ($nilai->pts < $NKKM->kkm)
                                                        <span class="bg-danger p-2">{{ $nilai->pts ?? '-' }}</span>
                                                    @else
                                                        {{ $nilai->pts ?? '-' }}
                                                    @endif
                                                </td>
                                                <td class='text-center'>
                                                    @if ($nilai->pas < $NKKM->kkm)
                                                        <span class="bg-danger p-2">{{ $nilai->pas ?? '-' }}</span>
                                                    @else
                                                        {{ $nilai->pas ?? '-' }}
                                                    @endif
                                                </td>

                                                @php
                                                    $nilai = [
                                                        $nilai->pts,
                                                        $nilai->pas
                                                    ];
                                                    $nilai_numeric = array_filter($nilai, 'is_numeric');
                                                    $total = array_sum($nilai_numeric);
                                                    $jumlah_data = count($nilai_numeric);
                                                @endphp
                                                <td class='text-center'>{{ $total ?: '-' }} </td>
                                                <td class='text-center'>{{ $total / $jumlah_data ?: '-' }} </td>
                                            @endforeach
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr class='text-center'>
                                    <th width='1%'>ID</th>
                                    @foreach ($arr_ths as $arr_th)
                                        <th class='text-center'> {{ $arr_th }}</th>
                                    @endforeach
                                    <th>PTS</th>
                                    <th>PAS</th>
                                    <th>Total</th>
                                    <th>Rata - rata</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>


        </div>

    </section>
</x-layout>
