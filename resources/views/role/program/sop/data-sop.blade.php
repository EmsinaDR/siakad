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


            {{-- blade-formatter-disable --}}
               <div class='row m-2'>
                   <div class='col-xl-2'>
                       <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'> <i class='fa fa-plus'></i> Tambah Data</button>
                       <a href="/program/pkks/data-view-pkks/id_6"><button type='button' class='btn btn-block btn-default bg-primary btn-md'> <i class='fa fa-print'></i> Cetak</button></a>
                   </div>
                   <div class='col-xl-10'></div>
               </div>
               <div class="row p-2">
                <div class="col-xl-12">
                    {{-- <x-inputallin>readonly:Nama Dokumen::::{{$DataPPKS->nama_dokumen}}:readonly</x-inputallin> --}}
                </div>
               </div>
               {{-- blade-formatter-enable --}}


            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
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
                                        <td class='text-center'> {{ $data->bidang }}</td>
                                        <td class='text-center'> {{ $data->judul }}</td>
                                        <td class='text-left'> {!! $data->dasar_hukum !!}</td>

                                        <td width='10%'>
                                            <div class='gap-1 d-flex justify-content-center'>
                                                {{-- blade-formatter-disable --}}
                                                <a href="{{route('data-sop.show', $data->id)}}"><button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' ><i class='fa fa-edit'></i> </button></a>
                                                {{-- blade-formatter-enable --}}
                                                <!-- Form untuk menghapus -->
                                                <form id='delete-form-{{ $data->id }}'
                                                    action='{{ route('data-sop.destroy', $data->id) }}' method='POST'
                                                    style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type='button' class='btn btn-danger btn-sm btn-equal-width'
                                                    onclick='confirmDelete({{ $data->id }})'> <i
                                                        class='fa fa-trash'></i> </button>
                                            </div>
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

                        </form>
                    </div>
                </div>
            </div>


        </div>

    </section>
</x-layout>

<script>
    function TambahData(data) {
        var TambahData = new bootstrap.Modal(document.getElementById('TambahData'));
        TambahData.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

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

                <form id='#id' action='{{route('data-sop.store')}}' method='POST'>
                    @csrf
                    @method('POST')
                    {{-- blade-formatter-disable --}}

                    <div>
                        <label for="bidang">Bidang</label>
                        <input type="text" id="bidang" name="bidang" value="{{ old('bidang') }}" class="form-control">
                    </div>
                    <div>
                        <label for="kategori">Kategori</label>
                        <input type="text" id="kategori" name="kategori" value="{{ old('kategori') }}" class="form-control">
                    </div>
                    <div>
                        <label for="judul">Judul</label>
                        <input type="text" id="judul" name="judul" value="{{ old('judul') }}" class="form-control">
                    </div><div>
                        <label for="dasar_hukum">Dasar Hukum</label>
                        <textarea id="dasar_hukum" name="dasar_hukum" class="editor form-control p-2 border border-gray-300 rounded-lg">{{ old('dasar_hukum') }}</textarea>
                    </div>
                    <div>
                        <label for="kualifikasi_pelaksana">Kualifikasi Pelaksana</label>
                        <textarea id="kualifikasi_pelaksana" name="kualifikasi_pelaksana" class="form-control editor">{{ old('kualifikasi_pelaksana') }}</textarea>
                    </div>
                    <div>
                        <label for="keterkaitan">Keterkaitan</label>
                        <textarea id="keterkaitan" name="keterkaitan" class="form-control editor">{{ old('keterkaitan') }}</textarea>
                    </div>
                    <div>
                        <label for="peralatan">Peralatan</label>
                        <textarea id="peralatan" name="peralatan" class="form-control editor">{{ old('peralatan') }}</textarea>
                    </div>
                    <div>
                        <label for="peringatan">Peringatan</label>
                        <textarea id="peringatan" name="peringatan" class="form-control editor">{{ old('peringatan') }}</textarea>
                    </div>
                    <div>
                        <label for="pencatatan">Pencatatan</label>
                        <textarea id="pencatatan" name="pencatatan" class="editor form-control">{{ old('pencatatan') }}</textarea>
                    </div>
                    <div>
                        <label for="keterangan">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" class="editor">{{ old('keterangan') }}</textarea>
                    </div>
                    <div class='my-2'>
                        <button type="submit" class="btn btn-primary float-right">simpan</button>
                    </div>
                    {{-- blade-formatter-enable --}}


                </form>
            </div>

        </div>
    </div>

</div>
