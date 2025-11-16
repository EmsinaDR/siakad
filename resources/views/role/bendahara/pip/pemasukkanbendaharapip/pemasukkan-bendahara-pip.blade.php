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
                {{-- blade-formatter-disable --}}
                <div class='col-xl-2'>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'><i class='fa fa-plus'></i> Tambah Data</button>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#TetapkanAnggaran' ><i class='fa fa-plus'></i> Tetapkan Anggaran</button>
                </div>
                {{-- blade-formatter-enable --}}
                <div class='col-xl-10'></div>
            </div>
            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <!-- Konten -->
                        {{-- Catatan :
                        - Include Komponen Modal CRUD + Javascript / Jquery
                        - Perbaiki Onclick Tombol Modal Create, Edit
                        - Variabel Active Crud menggunakan ID User
                         --}}
                        <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                            <thead>
                                <tr class='text-center'>
                                    <th width='1%'>ID</th>
                                    @foreach ($arr_ths as $arr_th)
                                        <th class='text-center'> {{ $arr_th }}</th>
                                    @endforeach
                                    <th>Action</th>
                                    {{-- @if ($activecrud === 1)
                                              {{-- @endif --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        <td class='text-center'>{{ $loop->iteration }}</td>
                                        <td class='text-center'> {{ $data->Tapel->tapel ?? '' }}</td>
                                        <td class='text-center'> {{ $data->tahap ?? '' }}</td>
                                        <td class='text-left'> {{ $data->Siswa->nama_siswa }}</td>
                                        <td class='text-center'> {{ $data->Kelas->kelas }}</td>
                                        <td class='text-center'>Rp. {{ number_format($data->nominal) }}</td>
                                        <td class='text-center'> {{ $data->keterangan }}</td>

                                        <td width='10%'>
                                            <div class='gap-1 d-flex justify-content-center'>
                                                <!-- Button untuk mengedit -->
                                                <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                                    data-toggle='modal' data-target='#editModal{{ $data->id }}'><i
                                                        class='fa fa-edit'></i> </button>
                                                <!-- Form untuk menghapus -->
                                                <form id='delete-form-{{ $data->id }}'
                                                    action='{{ route('pemasukkan-pip.destroy', $data->id) }}'
                                                    method='POST' style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type='button' class='btn btn-danger btn-sm btn-equal-width'
                                                    onclick='confirmDelete({{ $data->id }})'> <i
                                                        class='fa fa-trash'></i> </button>
                                            </div>
                                            {{-- Modal View Data Akhir --}}

                                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                                aria-labelledby='EditModalLabel' aria-hidden='true'>

                                                <x-edit-modal>
                                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                    <section>
                                                        {{-- blade-formatter-disable --}}
                                                        <form id='updateurl' action='{{ route('pemasukkan-pip.update', $data->id) }}' method='POST'>
                                                            @csrf
                                                            @method('PATCH')
                                                            @php
                                                                $DataTahaps = [
                                                                    'Tahap 1',
                                                                    'Tahap 2',
                                                                    'Tahap 3',
                                                                    'Tahap 4',
                                                                ];
                                                            @endphp
                                                            <div class='form-group'>
                                                                <label for='tahap'>Tahap</label>
                                                                <select name='tahap' id='id' class='form-control' required>
                                                                    <option value=''>--- Pilih Tahap ---</option>
                                                                    @foreach ($DataTahaps as $DataTahap)
                                                                        <option value='{{ $DataTahap }}' @if ($DataTahap === $data->tahap) selected @endif>{{ $DataTahap }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class='form-group'>
                                                                <label for='nominal'>Nominal</label>
                                                                <input type='text' class='form-control' id='nominal' name='nominal' placeholder='Nominal' value='{{$data->nominal}}' required>
                                                            </div>
                                                            <div class='form-group'>
                                                                <i class='fas fa-sticky-note'></i><label for='keterangan'>Keterangan</label>
                                                                <textarea name='keterangan' id='keterangan' rows='5' class='form-control' placeholder='Masukkan Keterangan Singkat'>{{$data->keterangan}}</textarea>
                                                            </div>
                                                            <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'>Kirim</button>
                                                        </form>
                                                        {{-- blade-formatter-enable --}}

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
                                        </td>
                                    </tr>
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
            </div>
        </div>
    </section>
</x-layout>

{{-- <button class='btn btn-warning btn-sm' onclick='TetapkanAnggaran()'><i class='fa fa-edit right'></i> Edit</button> --}}
{{--
onclick='TetapkanAnggaran()'
 --}}


{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='TetapkanAnggaran' tabindex='-1' aria-labelledby='LabelTetapkanAnggaran' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelTetapkanAnggaran'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

<form id='updateurl' action='{{ route('pip.anggaran.update') }}' method='POST'>
                                                            @csrf
                                                            @method('POST')
                                                            @php
                                                                $DataTahaps = [
                                                                    'Tahap 1',
                                                                    'Tahap 2',
                                                                    'Tahap 3',
                                                                    'Tahap 4',
                                                                ];
                                                                $tahuns = range(date('Y') - 2 , date('Y'));
                                                            @endphp
                                                            <div class='form-group'>
                                                                <label for='tahap'>Tahun</label>
                                                                <select name='tahun' id='id' class='form-control' required>
                                                                    <option value=''>--- Pilih Tahun ---</option>
                                                                    @foreach ($tahuns as $Tapel)
                                                                        <option value='{{ $Tapel }}'>{{$Tapel}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class='form-group'>
                                                            <label for='detailsiswa_id'>Nama Siswa</label>
                                                            <select name='detailsiswa_id[]' multiple='multiple' class='form-control' required>
                                                            <option value=''>--- Pilih Nama Siswa ---</option>
                                                            @foreach($DataPenerimaDropdwon as $newkey)
                                                            <option value='{{$newkey->detailsiswa_id}}'>{{$newkey->Siswa->nama_siswa}}</option>
                                                            @endforeach
                                                            </select>
                                                            </div>
                                                            <div class='form-group'>
                                                                <label for='tahap'>Tahap</label>
                                                                <select name='tahap' id='id' class='form-control' required>
                                                                    <option value=''>--- Pilih Tahap ---</option>
                                                                    @foreach ($DataTahaps as $DataTahap)
                                                                        <option value='{{ $DataTahap }}'>{{ $DataTahap }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class='form-group'>
                                                                <label for='nominal'>Nominal</label>
                                                                <input type='text' class='form-control' id='nominal' name='nominal' placeholder='Nominal' value='' required>
                                                            </div>
                                                            <div class='form-group'>
                                                                <i class='fas fa-sticky-note'></i><label for='keterangan'>Keterangan</label>
                                                                <textarea name='keterangan' id='keterangan' rows='5' class='form-control' placeholder='Masukkan Keterangan Singkat'></textarea>
                                                            </div>
                                                            <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'>Kirim</button>
                                                        </form>

        </div>

            </div>
    </div>

</div>