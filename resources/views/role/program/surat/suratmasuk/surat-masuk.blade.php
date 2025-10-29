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
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal'
                        data-target='#TambahData'><i class='fa fa-plus'></i>Tambah Data</button>

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
                                        <td class='text-center'>
                                            {{ Carbon::create($data->tanggal_terima)->translatedformat('l, d F Y') }}
                                        </td>
                                        <td class='text-center'> {{ $data->jenis_pengirim }}</td>
                                        <td class='text-center'> {{ $data->Klasifikasi->nama }}</td>
                                        <td class='text-left'> {{ $data->perihal }}</td>

                                        <td width='10%'>
                                            <div class='gap-1 d-flex justify-content-center'>
                                                <!-- Button untuk mengedit -->
                                                <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                                    data-toggle='modal' data-target='#editModal{{ $data->id }}'><i
                                                        class='fa fa-edit'></i> </button>
                                                <!-- Form untuk menghapus -->
                                                <form id='delete-form-{{ $data->id }}'
                                                    action='{{ route('surat-masuk.destroy', $data->id) }}'
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
                                                        <form id='updateurl'
                                                            action='{{ route('surat-masuk.update', $data->id) }}'
                                                            method='POST'>
                                                            @csrf
                                                            @method('PATCH')

                                                            @php
                                                                $jenis_pengirims = ['Instansi', 'Perorangan', 'Persero', 'PT'];
                                                                $kategoris = [
                                                                    'Surat Biasa',
                                                                    'Surat Rahasia',
                                                                    'Surat Pemberitahuan',
                                                                    'Surat Undangan',
                                                                    'Surat Keputusan',
                                                                    'Surat Permohonan',
                                                                    'Surat Dinas',
                                                                    'Surat Pribadi',
                                                                ];
                                                                // ['Surat Biasa', 'Surat Rahasia', 'Surat Pemberitahuan', 'Surat Undangan', 'Surat Keputusan', 'Surat Permohonan', 'Surat Perintah', 'Surat Dinas', 'Surat Pribadi']
                                                            @endphp
                                                            <div class="form-group">
                                                                <label for="klasifikasi_id">Klasifikasi</label>
                                                                <select class="select2 form-control" id="klasifikasi_id" name="klasifikasi_id">
                                                                    <option value="">Pilih Klasifikasi</option>
                                                                    @foreach ($suratKlasifikasis as $klasifikasi)
                                                                        <option value="{{ $klasifikasi->id }}" @if($data->klasifikasi_id === $klasifikasi->id) selected @endif> {{ $klasifikasi->nama }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="nomorl_surat">Nomor Surat</label>
                                                                <input type="text" class="form-control" id="nomorl_surat" name="nomorl_surat" value="{{ old('nomorl_surat', $data->nomor_surat) }}" placeholder="Nomor Surat" required>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <label for="tanggal_surat">Tanggal Surat</label>
                                                                        <input type="date" class="form-control" id="tanggal_surat" name="tanggal_surat" value="{{ old('tanggal_surat', $data->tanggal_surat) }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <label for="tanggal_terima">Tanggal Terima</label>
                                                                        <input type="date" class="form-control" id="tanggal_terima" name="tanggal_terima" value="{{ old('tanggal_terima', $data->tanggal_surat) }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class='form-group'>
                                                                        <label for='jenis_pengirim'>Jenis Pengirim</label>
                                                                        <select name='jenis_pengirim' id='jenis_pengirim' class='select2 form-control' required>
                                                                            <option value=''>--- Pilih Jenis Pengirim ---</option>
                                                                            @foreach ($jenis_pengirims as $jenis)
                                                                                <option value='{{ $jenis }}' @if($data->jenis_pengirim === $jenis) selected @endif> {{ $jenis }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <label for="nama_pengirim">Nama Pengirim</label>
                                                                        <input type="text" class="form-control" id="nama_pengirim" name="nama_pengirim" value="{{ old('nama_pengirim', $data->nama_pengirim) }}" placeholder="Nama Pengirim ( PT, Dany Rosepta, Dinas Pendidikan)" required>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="form-group">
                                                                <label for="perihal">Perihal</label>
                                                                <input type="text" class="form-control" id="perihal" name="perihal" value="{{ old('perihal', $data->perihal) }}" placeholder="Perihal Surat" required>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class='form-group'>
                                                                        <label for='kategori'>Kategori</label>
                                                                        <select name='kategori' id='kategori' class='select2 form-control' required>
                                                                            <option value=''>--- Pilih Kategori ---</option>
                                                                            @foreach ($kategoris as $kategori)
                                                                                <option value='{{ $kategori }}' @if($data->kategori === $kategori) selected @endif>{{ $kategori }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <label for="lampiran">Lampiran</label>
                                                                        <input type="number" class="form-control" id="lampiran" name="lampiran" value="{{ old('lampiran', $data->lampiran) }}" placeholder="Lampiran : 1 Lembar (1)" required>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="keterangan">Keterangan</label>
                                                                <textarea class="editor form-control" id="keterangan" name="keterangan" placeholder="Keterangan" rows="3">{{ old('keterangan', $data->keterangan) }}</textarea>
                                                            </div>
                                                            <div class='modal-footer'>
                                                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                                                <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                                                            </div>
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
                {{-- blade-formatter-disable --}}
                <form id='#id' action='{{route('surat-masuk.store')}}' method='POST'>
                    @csrf
                    @method('POST')
                    @php
                        $jenis_pengirims = ['Instansi', 'Perorangan', 'Persero', 'PT'];
                        $kategoris = [
                            'Surat Biasa',
                            'Surat Rahasia',
                            'Surat Pemberitahuan',
                            'Surat Undangan',
                            'Surat Keputusan',
                            'Surat Permohonan',
                            'Surat Dinas',
                            'Surat Pribadi',
                        ];
                        // ['Surat Biasa', 'Surat Rahasia', 'Surat Pemberitahuan', 'Surat Undangan', 'Surat Keputusan', 'Surat Permohonan', 'Surat Perintah', 'Surat Dinas', 'Surat Pribadi']
                    @endphp
                    <div class="form-group">
                        <label for="klasifikasi_id">Klasifikasi</label>
                        <select class="select2 form-control" id="klasifikasi_id" name="klasifikasi_id">
                            <option value="">Pilih Klasifikasi</option>
                            @foreach ($suratKlasifikasis as $klasifikasi)
                                <option value="{{ $klasifikasi->id }}"> {{ $klasifikasi->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nomorl_surat">Nomor Surat</label>
                        <input type="text" class="form-control" id="nomorl_surat" name="nomorl_surat" value="{{ old('nomorl_surat') }}" placeholder="Nomor Surat" required>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="tanggal_surat">Tanggal Surat</label>
                                <input type="date" class="form-control" id="tanggal_surat" name="tanggal_surat" value="{{ old('tanggal_surat') }}" required>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="tanggal_terima">Tanggal Terima</label>
                                <input type="date" class="form-control" id="tanggal_terima" name="tanggal_terima" value="{{ old('tanggal_terima', Carbon::now()->format('Y-m-d')) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class='form-group'>
                                <label for='jenis_pengirim'>Jenis Pengirim</label>
                                <select name='jenis_pengirim' id='jenis_pengirim' class='select2 form-control' required>
                                    <option value=''>--- Pilih Jenis Pengirim ---</option>
                                    @foreach ($jenis_pengirims as $jenis)
                                        <option value='{{ $jenis }}' {{ old('jenis_pengirim') == $jenis ? 'selected' : '' }}> {{ $jenis }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="nama_pengirim">Nama Pengirim</label>
                                <input type="text" class="form-control" id="nama_pengirim" name="nama_pengirim" value="{{ old('nama_pengirim') }}" placeholder="Nama Pengirim ( PT, Dany Rosepta, Dinas Pendidikan)" required>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="perihal">Perihal</label>
                        <input type="text" class="form-control" id="perihal" name="perihal" value="{{ old('perihal') }}" placeholder="Perihal Surat" required>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class='form-group'>
                                <label for='kategori'>Kategori</label>
                                <select name='kategori' id='kategori' class='select2 form-control' required>
                                    <option value=''>--- Pilih Kategori ---</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value='{{ $kategori }}'>{{ $kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="lampiran">Lampiran</label>
                                <input type="number" class="form-control" id="lampiran" name="lampiran" value="{{ old('lampiran') }}" placeholder="Lampiran : 1 Lembar (1)" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="editor form-control" id="keterangan" name="keterangan" placeholder="Keterangan" rows="3">{{ old('keterangan') }}</textarea>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                    </div>
                </form>
                {{-- blade-formatter-enable --}}
            </div>

        </div>
    </div>

</div>
