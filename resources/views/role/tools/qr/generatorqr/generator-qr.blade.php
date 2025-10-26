@php
    //content
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
@endphp
<x-layout>
    <style>
        textarea,
        .textoff {
            resize: none !important;
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
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#TambahData'><i class='fa fa-plus'></i> Tambah Data</button>
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
                                @foreach ($GeneratorQr as $data)
                                    <tr>
                                        <td class='text-center'>{{ $loop->iteration }}</td>
                                        <td class='text-center'> <a href="#" data-toggle="modal"
                                                data-target="#previewModal{{ $data->id }}">
                                                <img src="{{ asset('img/qrcode/qrgenerator/' . $data->judul . '.png') }}"
                                                    alt="QR Code" style="max-width: 100px; cursor: pointer;">
                                            </a>
                                        </td>
                                        <td class='text-center'> {{ $data->judul }}</td>
                                        <td class='text-left'> {{ $data->isi }}</td>

                                        <td width='10%'>
                                            {{-- blade-formatter-disable --}}
                                                   <div class='gap-1 d-flex justify-content-center'>
                                                    <a href="{{ asset('img/qrcode/qrgenerator/' . $data->judul . '.png') }}" class="btn btn-warning btn-sm btn-equal-width" download="{{ $data->judul }}.png"><i class="fa fa-download"></i> </a>

                                                       <!-- Button untuk mengedit -->
                                                       <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i> </button>
                                                       <!-- Form untuk menghapus -->
                                                       <form id='delete-form-{{ $data->id }}' action='{{ route('generator-qrcode.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                           @csrf
                                                           @method('DELETE')
                                                       </form>
                                                       <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i>  </button>
                                                   </div>
                                                   {{-- blade-formatter-enable --}}
                                            {{-- Modal View Data Akhir --}}

                                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                                aria-labelledby='EditModalLabel' aria-hidden='true'>

                                                <x-edit-modal>
                                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                    <section>
                                                        <form id='updategenerator-qrcode'
                                                            action='{{ route('generator-qrcode.update', $data->id) }}'
                                                            method='POST'>
                                                            @csrf
                                                            @method('PATCH')

                                                            <div class='form-group'>
                                                                <label for='judul'>Judul</label>
                                                                <input type='text' class='form-control'
                                                                    id='judul' name='judul' placeholder='Judul qr'
                                                                    value='{{ $data->judul }}' required>
                                                            </div>
                                                            <div class='form-group'>
                                                                <i class='fas fa-sticky-note pr-2'></i><label
                                                                    for='isi'>Isi Qr</label>
                                                                <textarea name='isi' id='isi' rows='3' class='textoff form-control'
                                                                    placeholder='Masukkan Isi Qr Singkat'>{{ $data->isi }}</textarea>
                                                            </div>

                                                            <button id='kirim' type='submit'
                                                                class='btn float-right btn-default bg-primary btn-xl mt-4'>
                                                                Kirim</button>
                                                        </form>

                                                    </section>
                                                </x-edit-modal>
                                            </div>
                                            {{-- Modal Edit Data Akhir --}}
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

<!-- Modal Preview -->
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            {{-- <div class="modal-header">
        <h5 class="modal-title" id="previewModalLabel{{ $data->id }}">Preview QR Code</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> --}}
            @php
                // Jika $data ada dan punya judul, pakai itu; kalau tidak, pakai placeholder
                $judul = isset($data) && !empty($data->judul) ? $data->judul : null;
                $imgPath = $judul ? "img/qrcode/qrgenerator/{$judul}.png" : 'img/qrcode/placeholder.png'; // siapkan file ini di /public/img/qrcode/
            @endphp

            <!-- Modal Preview -->
            <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <img src="{{ asset($imgPath) }}" alt="QR Code" style="max-width:100%; height:auto;">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='TambahData' tabindex='-1' aria-labelledby='LabelTambahData' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelTambahData'>
                    Tambah Data Qr
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <form id='TambahData-form' action='{{ route('generator-qrcode.store') }}' method='POST'>
                    @csrf
                    @method('POST')
                    <div class='form-group'>
                        <label for='judul'>Judul</label>
                        <input type='text' class='form-control' id='judul' name='judul'
                            placeholder='Judul qr' value="{{ old('judul') }}" required>
                    </div>
                    <div class='form-group'>
                        <i class='fas fa-sticky-note pr-2'></i><label for='isi'>Isi Qr</label>
                        <textarea name='isi' id='isi' rows='3' class='form-control' placeholder='Masukkan Isi Qr Singkat'>{{ old('isi') }}</textarea>
                    </div>

                    {{-- blade-formatter-disable --}}
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                    </div>
                    {{-- blade-formatter-enable --}}
                </form>

            </div>

        </div>
    </div>

</div>
