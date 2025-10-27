
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


               {{-- blade-formatter-disable --}}
               <div class='row m-2'>
                   <div class='col-xl-2'>
                       {{-- <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'> <i class='fa fa-plus'></i> Tambah Data</button> --}}
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
<form id='updateurl'
                                                            action='{{ route('data-sop.update', $data->id) }}'
                                                            method='POST'>
                                                            @csrf
                                                            @method('PATCH')

                                                            <div>
                                                                <label for="bidang">Bidang</label>
                                                                <input type="text" id="bidang" name="bidang" value="{{ old('bidang', $data->bidang) }}" class="form-control">
                                                            </div>
                                                            <div class="row my-3">
    <div class="col-xl-4">
        <div class="form-group">
            <label for="tanggal_pembuatan">Tanggal Pembuatan</label>
            <input type="date" class="form-control" id="tanggal_pembuatan" name="tanggal_pembuatan" value="{{ isset($data->tanggal_pembuatan) ? \Carbon\Carbon::parse($data->tanggal_pembuatan)->format('Y-m-d') : '' }}"
 required>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="form-group">
            <label for="tanggal_revisi">Tanggal Revisi</label> <!-- Ini diperbaiki -->
            <input type="date" class="form-control" id="tanggal_revisi" name="tanggal_revisi" value="{{ isset($data->tanggal_revisi) ? \Carbon\Carbon::parse($data->tanggal_revisi)->format('Y-m-d') : '' }}"
 required>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="form-group">
            <label for="tanggal_pengesahan">Tanggal Pengesahan</label> <!-- Ini diperbaiki -->
            <input type="date" class="form-control" id="tanggal_pengesahan" name="tanggal_pengesahan" value="{{ isset($data->tanggal_pengesahan) ? \Carbon\Carbon::parse($data->tanggal_pengesahan)->format('Y-m-d') : '' }}"
 required>
        </div>
    </div>
</div>


                                                            <div>
                                                                <label for="kategori">Kategori</label>
                                                                <input type="text" id="kategori" name="kategori" value="{{ old('kategori', $data->kategori) }}" class="form-control">
                                                            </div>

                                                            <div>
                                                                <label for="judul">Judul</label>
                                                                <input type="text" id="judul" name="judul" value="{{ old('judul', $data->judul) }}" class="form-control">
                                                            </div>

                                                            <div>
                                                                <label for="dasar_hukum">Dasar Hukum</label>
                                                                <textarea id="dasar_hukum" name="dasar_hukum" class="form-control editor">{{ old('dasar_hukum', $data->dasar_hukum) }}</textarea>
                                                            </div>

                                                            <div>
                                                                <label for="kualifikasi_pelaksana">Kualifikasi Pelaksana</label>
                                                                <textarea id="kualifikasi_pelaksana" name="kualifikasi_pelaksana" class="form-control editor">{{ old('kualifikasi_pelaksana', $data->kualifikasi_pelaksana) }}</textarea>
                                                            </div>

                                                            <div>
                                                                <label for="keterkaitan">Keterkaitan</label>
                                                                <textarea id="keterkaitan" name="keterkaitan" class="form-control editor">{{ old('keterkaitan', $data->keterkaitan) }}</textarea>
                                                            </div>

                                                            <div>
                                                                <label for="peralatan">Peralatan</label>
                                                                <textarea id="peralatan" name="peralatan" class="form-control editor">{{ old('peralatan', $data->peralatan) }}</textarea>
                                                            </div>

                                                            <div>
                                                                <label for="peringatan">Peringatan</label>
                                                                <textarea id="peringatan" name="peringatan" class="form-control editor">{{ old('peringatan', $data->peringatan) }}</textarea>
                                                            </div>

                                                            <div>
                                                                <label for="pencatatan">Pencatatan</label>
                                                                <textarea id="pencatatan" name="pencatatan" class="editor form-control">{{ old('pencatatan', $data->pencatatan) }}</textarea>
                                                            </div>

                                                            <div>
                                                                <label for="keterangan">Keterangan</label>
                                                                <textarea id="keterangan" name="keterangan" class="editor">{{ old('keterangan', $data->keterangan) }}</textarea>
                                                            </div>


                                                            <div>
                                                                <button type="submit" class="btn btn-primary float-right">Update</button>
                                                            </div>
                                                        </form>
                                                        {{-- blade-formatter-enable --}}



                       </div>
                   </div>
            </div>


        </div>

    </section>
</x-layout>
