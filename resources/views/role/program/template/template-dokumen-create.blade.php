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

            <div class='row m-2'>
                <div class='col-xl-2'>

                </div>
                <div class='col-xl-10'>


                </div>
            </div>
            <div class="row p-2">
                <div class="col-xl-12">
                </div>
            </div>

            <div class="mt-4 p-2">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">{{ $title ?? 'Tambah Template Dokumen' }}</h3>
                    </div>

                    <div class="card-body">
                        <form id="form-template-dokumen" action="{{ route('template-dokumen.store') }}" method="POST">
                            @csrf

                            <div class="accordion mb-4" id="formAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFields">
                                        <button class="bg-primary accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFields"
                                            aria-expanded="false" aria-controls="collapseFields">
                                            Tambahkan Variabel
                                        </button>
                                    </h2>
                                    <div id="collapseFields" class="accordion-collapse collapse"
                                        aria-labelledby="headingFields" data-bs-parent="#formAccordion">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <div class="col-xl-2 form-group form-check">
                                                    <input type="checkbox" class="form-check-input" id="nama_sekolah"
                                                        name="nama_sekolah"
                                                        value='{"name":"nama_sekolah","type":"text"}'>
                                                    <label class="form-check-label" for="nama_sekolah">Nama
                                                        Sekolah</label>
                                                </div>
                                                <div class="col-xl-2 form-group form-check">
                                                    <input type="checkbox" class="form-check-input" id="alama_sekolah"
                                                        name="alama_sekolah">
                                                    <label class="form-check-label" for="alama_sekolah">Alamat
                                                        Sekolah</label>
                                                </div>
                                                <div class="col-xl-2 form-group form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                        id="nama_guru_dropdown" name="nama_guru_dropdown"
                                                        value='{"name":"nama_guru_dropdown","type":"select"}'>
                                                    <label class="form-check-label" for="nama_guru_dropdown">Nama Guru
                                                        Dropdown</label>
                                                </div>
                                                <div class="col-xl-2 form-group form-check">
                                                    <input type="checkbox" class="form-check-input" id="nama_kegiatan"
                                                        name="nama_kegiatan"
                                                        value='{"name":"nama_kegiatan","type":"text"}'>
                                                    <label class="form-check-label" for="nama_kegiatan">Nama
                                                        Kegiatan</label>
                                                </div>
                                                <div class="col-xl-2 form-group form-check">
                                                    <input type="checkbox" class="form-check-input" id="tempat_kegiatan"
                                                        name="tempat_kegiatan"
                                                        value='{"name":"tempat_kegiatan","type":"text"}'>
                                                    <label class="form-check-label" for="tempat_kegiatan">Tempat
                                                        Kegiatan</label>
                                                </div>
                                                <div class="col-xl-2 form-group form-check">
                                                    <input type="checkbox" class="form-check-input" id="jumlah_hari"
                                                        name="jumlah_hari" value='{"name":"jumlah_hari","type":"text"}'>
                                                    <label class="form-check-label" for="jumlah_hari">Jumlah
                                                        Hari</label>
                                                </div>
                                                <div class="col-xl-2 form-group form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                        id="waktu_pelaksanaan" name="waktu_pelaksanaan"
                                                        value='{"name":"waktu_pelaksanaan","type":"text"}'>
                                                    <label class="form-check-label" for="waktu_pelaksanaan">Waktu
                                                        Pelaksanaan</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class='form-group'>
                                <label for='kategori'>Kategori</label>
                                <select name='kategori' id='kategori' data-placeholder='Pilih Data Kategori'
                                    class='select2 form-control' required>
                                    <option value=''>--- Pilih Kategori ---</option>
                                    @foreach ($KategoriDokumens as $newKategoriDokumen)
                                        <option value='{{ $newKategoriDokumen }}'>{{ $newKategoriDokumen }}</option>
                                    @endforeach
                                    <option value='lainnya'>Lainnya</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="nama_dokumen" class="form-label">Nama Dokumen</label>
                                <input type="text" class="form-control" id="nama_dokumen" name="nama_dokumen"
                                    placeholder="Masukkan nama dokumen" required>
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Isi Dokumen</label>
                                <textarea class="editor form-control" id="content" name="content" required></textarea>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Simpan Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <x-editor-tiny/>


        </div>

    </section>
</x-layout>
