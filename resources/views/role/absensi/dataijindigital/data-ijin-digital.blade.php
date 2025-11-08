<x-layout>
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
                    {{-- <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'> <i class='fa fa-plus'></i> Tambah Data</button> --}}
                </div>
                <div class='col-xl-4'>
                    <table id='example1' width='100%' class='table table-bordered table-hover'>
                        <thead>
                            <tr class='table-primary text-center align-middle'>
                                <th>ID</th>
                                <th>Ijin</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class='text-center'>1</td>
                                <td class='text-center'>Sakit</td>
                                <td class='text-center'>{{ $DataIjinDigital->where('ijin', 'Sakit')->count() }}</td>
                            </tr>
                            <tr>
                                <td class='text-center'>2</td>
                                <td class='text-center'>Ijin</td>
                                <td class='text-center'>
                                    {{ $DataIjinDigital->whereIn('ijin', ['Ijin', 'ijin'])->count() }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class='table-primary text-center align-middle'>
                                <th>ID</th>
                                <th>Ijin</th>
                                <th>Jumlah</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
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
                                @foreach ($DataIjinDigital as $data)
                                    <tr>
                                        <td class='text-center'>{{ $loop->iteration }}</td>
                                        <td class='text-center'> {{ $data->Siswa->nama_siswa }}</td>
                                        <td class='text-center'> {{ $data->Siswa->kelasOne->kelas }}</td>
                                        <td class='text-center'> {{ $data->ijin }}</td>
                                        <td class='text-center'> {{ $data->keterangan }}</td>
                                        <td width='10%'>
                                            {{-- blade-formatter-disable --}}
                                            <div class="d-flex justify-content-center gap-2">
                                                <!-- Tombol Edit -->
                                                <button type="button" class="btn btn-warning btn-sm btn-equal-width"
                                                    data-toggle="modal" data-target="#editModal{{ $data->id }}">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <!-- Tombol Hapus -->
                                                <form id="delete-form-{{ $data->id }}"
                                                    action="{{ route('absensi.ijin-digital-siswa.destroy', $data->id) }}"
                                                    method="POST" onsubmit="return false;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm btn-equal-width"
                                                        onclick="confirmDelete({{ $data->id }})">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            {{-- blade-formatter-enable --}}
                                            {{-- Modal View Data Akhir --}}
                                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                                aria-labelledby='EditModalLabel' aria-hidden='true'>
                                                <x-edit-modal>
                                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                    <section>
                                                        <form id='updateijin-digital-siswa'
                                                            action='{{ route('absensi.ijin-digital-siswa.update', $data->id) }}'
                                                            method='POST'>
                                                            @csrf
                                                            @method('PATCH')
                                                            @php
                                                                $Ijins = ['Ijin', 'Sakit', 'Alfa'];
                                                            @endphp
                                                            {{-- blade-formatter-disable --}}
                                                            <div class='form-group'>
                                                                <label for='ijin'>Data Ijin</label>
                                                                <select name='ijin' id='ijin' data-placeholder='Pilih Data Ijin' class='select2 form-control' required>
                                                                    <option value=''>--- Pilih Data Ijin ---</option>
                                                                    @foreach ($Ijins as $newIjins)
                                                                        <option value='{{ $newIjins }}' @if($data->ijin === $newIjins) selected @endif >{{ $newIjins }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class='form-group'>
                                                                <i class='fas fa-sticky-note pr-2'></i><label for='keterangan'>Keterangan</label>
                                                                <textarea name='keterangan' id='keterangan' rows='3' class='form-control' placeholder='Masukkan Keterangan Singkat'>{{ $data->keterangan }}</textarea>
                                                            </div>

                                                            <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'>Simpan</button>
                                                           {{-- blade-formatter-enable --}}
                                                        </form>

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
    </section>
</x-layout>
