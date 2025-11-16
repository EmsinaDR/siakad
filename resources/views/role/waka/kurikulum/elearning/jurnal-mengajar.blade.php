
@php
//content
use Illuminate\Support\Carbon;
\Carbon\Carbon::setLocale('id');
    $activecrud = collect([2,4, 6, 8])->search(Auth::user()->id);
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


               <div class='row m-2'>
                   <div class='col-xl-2'>
                       <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'> <i class='fa fa-plus'></i> Tambah Data</button>
                   </div>
                   <div class='col-xl-10'></div>
               </div>


            <div class='ml-2 my-4'>
                   <table id="example1" width="100%" class="table table-bordered table-hover">
                    <thead class="bg-info">
                        <tr class="text-center align-middle">
                            <th>No</th>
                            <th>Hari dan Tanggal</th>
                            <th>Nama Guru</th>
                            <th>Kelas</th>
                            <th>Jam Ke</th>
                            <th>Indikator</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            @php
                                // dd($datas);
                            @endphp
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>

                                <td class="text-center">
                                    {{ Carbon::parse($data->created_at)->translatedFormat('l, d F Y') }}</td>
                                    <td class="text-center">
                                    {{ $data->Guru->nama_guru }}
                                </td>
                                <td class="text-center">
                                    {{ $data->Kelas->kelas }}
                                </td>
                                @php
                                    $riwayatIndikator = json_decode($data->indikator_id, true); // Konversi JSON ke array
                                    $jamke = json_decode($data->jam_ke, true); // Konversi JSON ke array
                                    $jam_ke = implode(', ', $jamke); //

                                @endphp
                                <td class="text-center">
                                    {{ $jam_ke }}
                                </td>
                                <td>

                                    @foreach ($riwayatIndikator as $indikatorId)
                                        @php
                                            $viewIndikator = App\Models\Learning\Emateri::find($indikatorId);
                                        @endphp
                                        @if ($viewIndikator)
                                            {{ $loop->index }}. {{ $viewIndikator->indikator }} <br>
                                        @endif
                                    @endforeach

                                </td>
                                <td>
                                    <p>Sakit : {{ count(explode(',',$data->siswa_sakit)) }} <br>
                                        Alfa : {{ count(explode(',',$data->siswa_alfa)) }} <br>
                                        Ijin : {{ count(explode(',',$data->siswa_ijin)) }} <br>
                                        Bolos : {{ count(explode(',',$data->siswa_bolos)) }} <br>
                                    </p>

                                </td>
                                <td>
                                    <div class='gap-1 d-flex justify-content-center'>
                                        <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                            data-toggle='modal' data-target='#editModal{{ $data->id }}'>
                                            <i class='fa fa-eye'></i>
                                        </button>
                                        <form id='delete-form-{{ $data->id }}' action='{{ route('jurnal-mengajar.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i> </button>
                                    </div>
                                </td>
                            </tr>
                            {{-- Modal View Data Akhir --}}
                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                aria-labelledby='EditModalLabel' aria-hidden='true'>
                                <x-edit-modal>
                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                    <section>

                                    </section>
                                </x-edit-modal>
                            </div>




                            {{-- Modal Edit Data Akhir --}}
                            {{-- Modal View --}}
                            <div class='modal fade' id='viewModal{{ $data->id }}' tabindex='-1'
                                aria-labelledby='ViewModalLabel' aria-hidden='true'>

                                <x-view-modal>
                                    <x-slot:titleviewModal>{{ $titleviewModal }}</x-slot:titleviewModal>
                                    <section>
                                        //Content View
                                    </section>
                                </x-view-modal>
                            </div>
                            {{-- Modal View Akhir --}}
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="text-center align-middle">
                            <th>No</th>
                            <th>Hari dan Tanggal</th>
                            <th>Nama Guru</th>
                            <th>Kelas</th>
                            <th>Jam Ke</th>
                            <th>Indikator</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                </table>
            </div>


        </div>

    </section>
</x-layout>
