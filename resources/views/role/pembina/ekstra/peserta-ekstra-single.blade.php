s
@php
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
            {{-- Header Menu --}}
            <div class='row m-2'>
                <div class='col-lg-3 col-6'>
                    <!-- small box -->
                    <div class='small-box bg-info'>
                        <div class='inner'>
                            <h3>150</h3>
                            <p>KAS Ekstra</p>
                        </div>
                        <div class='icon'>
                            <i class='fa fa-solid fa-wallet'></i>
                        </div>
                        <a href='#' class='small-box-footer'>More info <i
                                class='fas fa-arrow-circle-right'></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class='col-lg-3 col-6'>
                    <!-- small box -->
                    <div class='small-box bg-success'>
                        <div class='inner'>
                            <h3>53<sup style='font-size: 20px'>%</sup></h3>
                            <p>Bounce Rate</p>
                        </div>
                        <div class='icon'>
                            <i class='ion ion-stats-bars'></i>
                        </div>
                        <a href='#' class='small-box-footer'>More info <i
                                class='fas fa-arrow-circle-right'></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class='col-lg-3 col-6'>
                    <!-- small box -->
                    <div class='small-box bg-warning'>
                        <div class='inner'>
                            <h3>{{ $datas->count() }} Anggota</h3>
                            <p>Anggota Ekstra</p>
                        </div>
                        <div class='icon'>
                            <i class='ion ion-person-add'></i>
                        </div>
                        <a href='#' class='small-box-footer'>More info <i
                                class='fas fa-arrow-circle-right'></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class='col-lg-3 col-6'>
                    <!-- small box -->
                    <div class='small-box bg-danger'>
                        <div class='inner'>
                            <h3>65</h3>
                            <p>Unique Visitors</p>
                        </div>
                        <div class='icon'>
                            <i class='ion ion-pie-graph'></i>
                        </div>
                        <a href='#' class='small-box-footer'>More info <i
                                class='fas fa-arrow-circle-right'></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>

            {{-- Header Menu --}}

            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }} - {{ $dataEkstra->Ekstra->ekstra }}</H3>
            </div>
            <!--Car Header-->


            <div class='ml-2 my-4'>

                <div class='row'>
                    <div class='col-xl-3 mb-4'>
                        <button type='button' class='btn  btn-default bg-primary btn-md' onClick='TambahPeserta()'><i
                                class='fa fa-plus-circle  text-white'></i> Tambah Peserta</button>
                    </div>
                    <div class='col-xl-9'>
                    </div>
                </div>
                <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                    <thead>
                        <tr class='text-center'>
                            <th width='1%'>ID</th>
                            @foreach ($arr_ths as $arr_th)
                                <th class='text-center'> {{ $arr_th }}</th>
                            @endforeach
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr>
                                <td class='text-center'>{{ $loop->iteration }}</td>
                                <td class='text-center'> {{ $data->Siswa->nis }}</td>
                                <td class='text-center'> {{ $data->Siswa->nama_siswa }}</td>
                                <td class='text-center'> {{ $data->Kelas->kelas }}</td>
                                <td class='text-center'> {{ $data->EkstraNew->ekstra }}</td>

                                <td width='10%'>
                                    <div class='gap-1 d-flex justify-content-center'>
                                        {{-- blade-formatter-disable --}}
                                                       <!-- Form untuk menghapus -->
                                                       <form action='{{ route('peserta-ekstra.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                           @csrf
                                                           @method('DELETE')
                                                           <button type='submit' class='btn btn-danger btn-sm btn-equal-width' onclick=`return confirm('Apakah Anda yakin ingin menghapus data ini?');`><i class='fa fa-trash'></i> </button>
                                                       </form>
                                                       {{-- blade-formatter-enable --}}
                                    </div>
                                </td>
                            </tr>
                            {{-- Modal View Data Akhir --}}
                            {{-- blade-formatter-disable --}}
                                        <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1' aria-labelledby='EditModalLabel' aria-hidden='true'>
                                        {{-- blade-formatter-enable --}}
                            <x-edit-modal>
                                <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                <section>
                                    <form id='updateurl' action='{{ route('peserta-ekstra.update', $data->id) }}'
                                        method='POST'>
                                        @csrf
                                        @method('PATCH')

                                        contentEdit

                                        <button id='kirim' type='submit'
                                            class='btn float-right btn-default bg-primary btn-xl mt-4'> Kirim</button>
                                    </form>

                                </section>
                            </x-edit-modal>
            </div>
            {{-- Modal Edit Data Akhir --}}
            {{-- Modal View --}}
            {{-- blade-formatter-disable --}}
                                        <div class='modal fade' id='viewModal{{ $data->id }}' tabindex='-1' aria-labelledby='ViewModalLabel' aria-hidden='true'>
                                        {{-- blade-formatter-enable --}}

            <x-view-modal>
                <x-slot:titleviewModal>{{ $titleviewModal }}</x-slot:titleviewModal>
                <section>
                    //Content View
                </section>
            </x-view-modal>
        </div>
        {{-- Modal View Akhir --}}
        @endforeach
        </tbody>
        <tfoot>
            <tr class='text-center'>
                <th width='1%'>ID</th>
                @foreach ($arr_ths as $arr_th)
                    <th class='text-center'> {{ $arr_th }}</th>
                @endforeach
                {{-- @if ($activecrud === 1) --}}
                <th class='text-center'>Action</th>
                {{-- @endif --}}
            </tr>
        </tfoot>
        </table>
        </div>

        </div>

    </section>
</x-layout>
<button class='btn btn-warning btn-sm' onclick='TambahPeserta()'><i class='fa fa-edit right'></i> Edit</button>

<script>
    function TambahPeserta(data) {
        var TambahPeserta = new bootstrap.Modal(document.getElementById('TambahPeserta'));
        TambahPeserta.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='TambahPeserta' tabindex='-1' aria-labelledby='TambahPeserta' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='TambahPeserta'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <form id='#id' action='{{ route('peserta-ekstra.store') }}' method='POST'>
                    @csrf
                    @method('POST')
                    <div class='form-group'>
                        @php
                            // dd($DatapesertEkstra);
                            $siswas = App\Models\User\Siswa\Detailsiswa::whereNotNull('kelas_id')
                                ->orderby('kelas_id', 'ASC')
                                ->get();
                        @endphp
                        <i class="fa fa-user mr-2"></i><label for='detailsiswa_id'>Nama Siswa</label>
                        <input type='hidden' name='ekstra_id' value='{{ request()->segment(3) }}'
                            placeholder='ekstra_id'>
                        <select id='select2-1' name='detailsiswa_id[]' class='form-control' multiple='multiple'
                            data-placeholder='Pilih Siswa'style='width: 100%;'>
                            <option value=''>--- Pilih Nama Siswa ---</option>
                            @foreach ($siswas as $siswa)
                                <option value='{{ $siswa->id }}'>{{ $siswa->Detailsiswatokelas->kelas }} -
                                    {{ $siswa->nama_siswa }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>
