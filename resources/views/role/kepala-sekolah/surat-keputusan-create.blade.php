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
                        {{ route('surat-keputusan.show', 1) }}
                        <form id='updateurl' action='{{ route('surat-keputusan.store') }}' method='POST'>
                            @csrf
                            @method('PATCH')
                            {{-- blade-formatter-disable --}}
                            <div class="row">
                                <div class="col-6 form-group">
                                    <label class="text-gray-700">Nomor SK</label>
                                    <input id='nomor_sk' type="text" name="nomor_sk" value="{{ old('nomor_sk',) }}" class="form-control p-2 border border-gray-300 rounded-lg   focus:ring focus:ring-blue-200" required>

                                <label><input type="checkbox" id="check_keterangan"> Format No Sk </label> <br>
                                <span><b class="text-success">format baku</b> : {{$JmData}}/KODE-SEKOLAH/KODE-DOKUMEN/BULAN/TAHUN</span>
                                </div>
                                <div class="col-6 form-group">
                                    <label class="text-gray-700">Nama SK</label>
                                    <input type="text" name="nama_sk" value="{{ old('nama_sk') }}" class="form-control p-2 border border-gray-300 rounded-lg focus:ring     focus:ring-blue-200">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 form-group">
                                    <label class="block text-gray-700">Tanggal SK</label>
                                    <input type="date" name="tanggal_sk" value="{{ old('tanggal_sk') }}" class="form-control p-2 border border-gray-300 rounded-lg focus:ring   focus:ring-blue-200">
                                </div>
                                <div class="col-6 form-group">
                                    <label class="block text-gray-700">Pejabat Penerbit</label>
                                    <input type="text" name="pejabat_penerbit" value="{{ old('pejabat_penerbit') }}" class="form-control p-2 border border-gray-300 rounded-lg  focus:ring focus:ring-blue-200">
                                </div>
                            </div>

                            <script>
                                document.addEventListener("DOMContentLoaded", function () {
                                    let namaSekolah = @json($Identitas->KodeSingkat()); // Ambil dari backend
                                    let kodeDokumen = "SK"; // Kode dokumen
                                    let nomorUrut = @json($JmData); // Nomor urut SK

                                    let checkbox = document.getElementById("check_keterangan");
                                    let inputNomorSK = document.getElementById("nomor_sk");

                                    // Cek apakah elemen ada sebelum menambahkan event listener
                                    if (checkbox && inputNomorSK) {
                                        checkbox.addEventListener("change", function () {
                                            if (this.checked) {
                                                let date = new Date();
                                                let bulan = String(date.getMonth() + 1).padStart(2, '0'); // Format 2 digit (01-12)
                                                let tahun = date.getFullYear(); // Tahun 4 digit

                                                let nomorSK = `${nomorUrut}/${namaSekolah}/${kodeDokumen}/${bulan}/${tahun}`;
                                                inputNomorSK.value = nomorSK;
                                            } else {
                                                inputNomorSK.value = "";
                                            }
                                        });
                                    } else {
                                        console.error("Elemen checkbox atau input nomor SK tidak ditemukan!");
                                    }
                                });
                            </script>
                            <div class="form-group">
                                <label class="block text-gray-700">Perihal</label>
                                <textarea name="perihal" class="editor form-control p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">{{ old('perihal') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="block text-gray-700">Content System</label>
                                <textarea id="content_system" name="content_system" class="editor form-control p-2 border border-gray-300  rounded-lg">{{ old('content_system') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="block text-gray-700">Content Sekolah</label>
                                <textarea id="content_sekolah" name="content_sekolah" class="editor form-control p-2 border border-gray-300  rounded-lg">{{ old('content_sekolah') }}</textarea>
                            </div>

                            <!-- Tambahkan Script TinyMCE -->


                            <div class="form-group">
                                <label class="block text-gray-700">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control p-2 border border-gray-300 rounded-lg focus:ring  focus:ring-blue-200">{{ old('deskripsi') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="block text-gray-700">Unggah File SK</label>
                                <input type="file" name="file"
                                    class="form-control p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">

                            </div>
                            <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-md mt-4'> Kirim</button>
                            {{-- blade-formatter-enable --}}

                        </form>

                    </div>
                </div>
            </div>


        </div>

    </section>
</x-layout>

<script>
    function CekDataRapat(data) {
        var CekDataRapat = new bootstrap.Modal(document.getElementById('CekDataRapat'));
        CekDataRapat.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='CekDataRapat' tabindex='-1' aria-labelledby='LabelCekDataRapat' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelCekDataRapat'>
                    Data Rapat
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <table id='example1' width='100%' class='table table-bordered table-hover'>
                    <thead>
                        <tr class='table-primary text-center align-middle'>
                            <th>ID</th>
                            <th>Tanggal Rapat</th>
                            <th>Nama Rapat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($DataRapats as $data)
                           <tr class='text-center'>
                               <td>{{ $loop->iteration }}</td>
                               <td>{{Carbon::create($data->tanggal_pelaksanaan)->translatedformat('l, d F Y')}}</td>
                               <td>{{ $data->nama_rapat }}</td>
                           </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class='table-primary text-center align-middle'>
                            <th>ID</th>
                            <th>Tanggal Rapat</th>
                            <th>Nama Rapat</th>
                        </tr>
                    </tfoot>
                </table>

            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
            </div>
        </div>

            </div>
    </div>

</div>