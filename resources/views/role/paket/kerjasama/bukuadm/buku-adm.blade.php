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
                {{-- blade-formatter-disable --}}
                   <div class='col-xl-2'>
                       <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle="modal" data-target="#DokumenLomba"><i class='fa fa-plus'></i> Dokumen Lomba</button>
                        <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#BukuWaliKelas'><i class='fa fa-plus'></i> Doumen Wali Kelas</button>
                        <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#JurnalMengajar'><i class='fa fa-plus'></i> Jurnal Mengajar</button>
                        <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#DokumenRapat'><i class='fa fa-plus'></i> Dokumen Rapat</button>


                   </div>
                   <div class='col-xl-10'></div>
               </div>
               {{-- blade-formatter-enable --}}


                <div class='ml-2 my-4'>
                    <table id='example1' width='100%' class='table table-bordered table-hover'>
                        <thead>
                            <tr class='table-primary text-center align-middle'>
                                <th>ID</th>
                                <th>Nama Buku</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($DataBukus as $DataBuku)
                                <tr class='text-center'>
                                    <td  class='text-center align-middle'>{{ $loop->iteration }}</td>
                                    <td  class='text-center align-middle'>{{ $DataBuku['nama_dokumen'] ?? '' }}</td>
                                    <td  class='text-left align-middle'>{{ $DataBuku['keterangan'] ?? '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class='table-primary text-center align-middle'>
                                <th>ID</th>
                                <th>Nama Buku</th>
                                <th>Keterangan</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>


            </div>

    </section>
</x-layout>


{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='BukuWaliKelas' tabindex='-1' aria-labelledby='LabelBukuWaliKelas' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelBukuWaliKelas'>
                    Generate Buku Wali Kelas
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <form id='BukuWaliKelas-form' action='{{ route('buku.wali.kelas.cetak') }}' method='POST'>
                    {{-- <form id='BukuWaliKelas-form' action='#' method='POST'> --}}
                    @csrf
                    @method('POST')
                    {{-- http://localhost/siakad/public/kerjasama/buku-wali-kelas-potrait --}}
                    <div class='form-group'>
                        <label for='pengaturan'>Dokumen Wali Kelas</label>
                        <select name='pengaturan' id='id' class='select2 form-control' required>
                            <option value='potrait'>Potrait</option>
                            <option value='landscape'>Landscape</option>
                        </select>
                    </div>
                    <div class='form-group'>
                        <label for='kelas_id'>Kelas</label>
                        <select name='kelas_id' id='kelas_id' data-placeholder='Pilih Data Kelas'
                            class='select2 form-control' required>
                            <option value=''>--- Pilih Kelas ---</option>
                            @foreach ($Kelas as $newKelas)
                                <option value='{{ $newKelas->id }}'>{{ $newKelas->kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- blade-formatter-disable --}}
                           <div class='modal-footer'>
                               <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                           </div>
                           {{-- blade-formatter-enable --}}
                </form>
            </div>

        </div>
    </div>

</div>
@if ($Identitas->paket === 'Kerjasama')

    <div class="modal fade" id="DokumenLomba" tabindex="-1" aria-labelledby="LabelDokumenLomba" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="LabelDokumenLomba">Pembuatan Dokumen Lomba</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('master.dokumen') }}">
                        @csrf
                        <!-- FORM ISI -->
                        {{-- <div class='card'>
                            <div class='card-header bg-primary'>
                                <h3 class='card-title'><i class='fas fa-text-width'></i>Dokumen Lomba</h3>
                            </div><!-- /.card-header -->
                            <div class='card-body'>
                                <dl>
                                    <dt>Dokumen Kebutuhan Lomba</dt>
                                    <dd>1. Surat Aktif Siswa</dd>
                                    <dt>2. Kartu Pelajar</dt>
                                </dl>
                            </div><!-- /.card-body -->
                        </div> --}}
                        <div class='form-group'>
                            <label for='detailsiswa_id'>Nama Siswa</label>
                            <select name='detailsiswa_id' id='detailsiswa_id' data-placeholder='Pilih Data Nama Siswa'
                                class='select2 form-control' required>
                                <option value=''>--- Pilih Nama Siswa ---</option>
                                @foreach ($Siswas as $newSiswas)
                                    <option value='{{ $newSiswas->id }}'>{{ $newSiswas->nama_siswa }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit Data Awal --}}
    <div class='modal fade' id='JurnalMengajar' tabindex='-1' aria-labelledby='LabelJurnalMengajar' aria-hidden='true'>
        <div class='modal-dialog modal-lg'>
            <div class='modal-content'>
                <div class='modal-header bg-primary'>
                    <h5 class='modal-title' id='LabelJurnalMengajar'>
                        Generate Jurnal Mengajar
                    </h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>

                    <form id='JurnalMengajar-form' action='#' method='POST'>
                        @csrf
                        @method('POST')
                        content_form

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

    {{-- Modal Edit Data Awal --}}
    <div class='modal fade' id='DokumenRapat' tabindex='-1' aria-labelledby='LabelDokumenRapat'
        aria-hidden='true'>
        <div class='modal-dialog modal-lg'>
            <div class='modal-content'>
                <div class='modal-header bg-primary'>
                    <h5 class='modal-title' id='LabelDokumenRapat'>
                        Generator Dokumen Rapat
                    </h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>

                    <form id='DokumenRapat-form' action='{{route('buku.rapat')}}' method='POST'>
                        @csrf
                        @method('POST')
                        {{-- blade-formatter-disable --}}
                        <div class='form-group'>
                            <label for='nama_kegiatan'>Nama Kegiatan</label>
                            <input type='text' class='form-control' id='nama_kegiatan' name='nama_kegiatan' placeholder='Nama kegiatan' required>
                        </div>
                        <div class="row">
                            <div class='col-xl-6 form-group'>
                                <label for='tanggal_pelaksanaan'>Tanggal Pelaksanaan</label>
                                <input type='date' class='form-control' id='tanggal_pelaksanaan' name='tanggal_pelaksanaan' placeholder='Tanggal dialksanakannya kegiatan' required>
                            </div>
                            <div class='col-xl-6 form-group'>
                                <label for='waktu'>Waktu</label>
                                <input type='time' class='form-control' id='waktu' name='waktu' placeholder='placeholder' required>
                            </div>
                        </div>
                        <div class='form-group'>
                                <i class='fas fa-sticky-note pr-2'></i><label for='pembahasan'>Pembahasan</label><br>
                                <span>Gunakan bulet dan numbering</span>
                                <textarea name='pembahasan' id='pembahasan' rows='3' class='editor form-control' placeholder='Masukkan Pembahasan'></textarea>
                            </div>

                        {{-- blade-formatter-enable --}}

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
@endif
