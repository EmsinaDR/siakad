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
            {{-- blade-formatter-disable --}}
            <div class='row m-2'>
                <div class='col-xl-2'>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#TambahData'><i class='fa fa-plus'></i> Tambah Data</button>
                </div>
                <div class='col-xl-10'></div>
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
                                <tr class='text-center table-primary'>
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
                                @foreach ($ListRencanaAnggaran as $data)
                                    <tr>
                                        <td class='text-center'>{{ $loop->iteration }}</td>
                                        <td class='text-center'> {{ $data->kode }}</td>
                                        <td class='text-center'> {{ $data->kategori }}</td>
                                        <td class='text-left'> {{ $data->jenis_pengeluaran }}</td>
                                        <td class='text-left'> {{ $data->keterangan }}</td>

                                        <td width='10%'>
                                            @if ($data->system !== 'Y')
                                                <div class='gap-1 d-flex justify-content-center'>
                                                    <!-- Button untuk mengedit -->
                                                    <button type='button'
                                                        class='btn btn-warning btn-sm btn-equal-width'
                                                        data-toggle='modal'
                                                        data-target='#editModal{{ $data->id }}'><i
                                                            class='fa fa-edit'></i> </button>
                                                    <!-- Form untuk menghapus -->

                                                    <form id='delete-form-{{ $data->id }}'
                                                        action='{{ route('rencana-anggaran-list.destroy', $data->id) }}'
                                                        method='POST' style='display: inline-block;'>
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <button type='button' class='btn btn-danger btn-sm btn-equal-width'
                                                        onclick='confirmDelete({{ $data->id }})'> <i
                                                            class='fa fa-trash'></i> </button>
                                            @endif
                    </div>
                    {{-- Modal View Data Akhir --}}

                    <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                        aria-labelledby='EditModalLabel' aria-hidden='true'>

                        <x-edit-modal>
                            <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                            <section>
                                {{-- blade-formatter-disable --}}
                                                        <form id='updateurl'
                                                            action='{{ route('rencana-anggaran-list.update', $data->id) }}'
                                                            method='POST'>
                                                            @csrf
                                                            @method('PATCH')
                                                            @php
                                                                $dropdowss = ['Rutin', 'Terencana', 'Event'];
                                                            @endphp
                                                            <div class='form-group'>
                                                                <label for='kategori'>Kategori</label>
                                                                <select name='kategori' id='id' class='select2 form-control' required>
                                                                    <option value=''>--- Pilih Kategori ---</option>
                                                                    @foreach ($dropdowss as $dropdows)
                                                                        <option value='{{ $dropdows }}' @if($data->kategori ===  $dropdows) selected @endif>{{ $dropdows }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class='form-group'>
                                                                <label for='jenis_pengeluaran'>Jenis Pembayaran</label>
                                                                <input type='text' class='form-control' id='jenis_pengeluaran' name='jenis_pengeluaran' placeholder='Jenis Pembayaran' value='{{$data->jenis_pengeluaran}}' required>
                                                            </div>
                                                            <div class='form-group'>
                                                                <i class='fas fa-sticky-note'></i>
                                                                <label for='keterangan'>Keterangan</label>
                                                                <textarea name='keterangan' id='keterangan' rows='3' class='form-control' placeholder='Masukkan Keterangan Singkat'>{{$data->keteramgan}}</textarea>
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
{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='TambahData' tabindex='-1' aria-labelledby='LabelTambahData' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelTambahData'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <form id='#id' action='' method='POST'>
                    @csrf
                    @method('POST')
                    @php
                        $dropdowss = ['Rutin', 'Terencana', 'Event'];
                    @endphp
                    <div class='form-group'>
                        <label for='kategori'>Kategori</label>
                        <select name='kategori' id='id' class='select2 form-control' required>
                            <option value=''>--- Pilih Kategori ---</option>
                            @foreach ($dropdowss as $dropdows)
                                <option value='{{ $dropdows }}'>{{ $dropdows }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='form-group'>
                        <label for='jenis_pengeluaran'>Jenis Pembayaran</label>
                        <input type='text' class='form-control' id='jenis_pengeluaran' name='jenis_pengeluaran'
                            placeholder='Jenis Pembayaran' required>
                    </div>
                    <div class='form-group'>
                        <i class='fas fa-sticky-note'></i><label for='keterangan'>Keterangan</label>
                        <textarea name='keterangan' id='keterangan' rows='3' class='form-control'
                            placeholder='Masukkan Keterangan Singkat'></textarea>
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
