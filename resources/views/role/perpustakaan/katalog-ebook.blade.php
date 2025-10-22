@php
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
            <div class='row m-2'>
                <div class='col-lg-3 col-6'>
                    <!-- small box -->
                    <div class='small-box bg-info'>
                        <div class='inner'>
                            <h3>{{ $datas->count() }}</h3>

                            <p>Buku</p>
                        </div>
                        <div class='icon'>
                            <i class='fa fa-book'></i>
                        </div>
                        <a href='#' class='small-box-footer'>More info <i
                                class='fas fa-arrow-circle-right'></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class='col-lg-3 col-6'>
                    <!-- small box -->
                    <div class='small-box bg-success'>
                        <div class='inner'>
                            <h3>53<sup style='font-size: 20px'>%</sup></h3>

                            <p>Kas</p>
                        </div>
                        <div class='icon'>
                            <i class='fa fa-coins'></i>
                        </div>
                        <a href='#' class='small-box-footer'>More info <i
                                class='fas fa-arrow-circle-right'></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class='col-lg-3 col-6'>
                    <!-- small box -->
                    <div class='small-box bg-warning'>
                        <div class='inner'>
                            <h3>{{ $data_user_sekolah }}</h3>

                            <p>Anggota Perpustakaan</p>
                        </div>
                        <div class='icon'>
                            <i class='ion ion-person-add'></i>
                        </div>
                        <a href='#' class='small-box-footer'>More info <i
                                class='fas fa-arrow-circle-right'></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class='col-lg-3 col-6'>
                    <!-- small box -->
                    <div class='small-box bg-danger'>
                        <div class='inner'>
                            <h3>65</h3>

                            <p>Unique Visitors</p>
                        </div>
                        <div class='icon'>
                            <i class='ion ion-pie-graph'></i>
                        </div>
                        <a href='#' class='small-box-footer'>More info <i
                                class='fas fa-arrow-circle-right'></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->
            <div class="row my-2 p-2">
                <div class="col-xl-2">
                    {{-- blade-formatter-disable --}}
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick="TambahEbook()"> <i class="fa fa-file-pdf mr-2"></i>Tambah Ebook</button>
                    {{-- blade-formatter-enable --}}
                </div>
                <div class="col-xl-8"></div>
            </div>


            <div class='ml-2 my-4'>

                <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                    <thead>
                        <tr class='text-center'>
                            <th width='1%'>ID</th>
                            @foreach ($arr_ths as $arr_th)
                                <th class='text-center'> {{ $arr_th }}</th>
                            @endforeach
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr>
                                <td class='text-center'>{{ $loop->iteration }}</td>
                                <td class='text-center'></td>
                                <td class='text-left'> {{ $data->judul_ebook }}</td>
                                <td class='text-left'> {{ $data->EbookToKategori->nama_kategori }}</td>
                                <td width='10%' class='text-center'> {{ $data->isbn }}</td>
                                <td width='20%' class='text-left'>
                                    @php
                                        $penuliss = explode(',', $data->penulis); // Memecah Array yang yang telah diterima, lanjut fungsi loop fetch
                                    @endphp
                                    @foreach ($penuliss as $penulis)
                                        {{ $penulis }} <br>
                                    @endforeach
                                </td>

                                <td>
                                    <div class='gap-1 d-flex justify-content-center'>
                                        {{-- blade-formatter-disable --}}
                                       <!-- Button untuk melihat -->
                                       <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i> </button>
                                       <!-- Form untuk menghapus -->
                                       <form id="delete-form-{{ $data->id }}" action="{{ route('katalog-ebook.destroy', $data->id) }}" method="POST" >
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                            <button type="button" class="btn btn-danger btn-sm btn-equal-width" onclick="confirmDelete({{ $data->id }})"> <i class="fa fa-trash"></i>  </button>
                                       {{-- blade-formatter-enable --}}
                                    </div>
                                </td>
                            </tr>
                            {{-- Modal View Data Akhir --}}
                            {{-- blade-formatter-disable --}}
                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                aria-labelledby='EditModalLabel' aria-hidden='true'>
                                <x-edit-modal>
                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                    <section>
                                        <form id='updateurl' action='{{ route('katalog-ebook.update', $data->id) }}'
                                            method='POST'>
                                            @csrf
                                            @method('PATCH')
                                            {{-- blade-formatter-disable --}}
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <x-inputallin>text:ISBN:ISBN:isbn:id_isbn:{{ $data->isbn }}:Required</x-inputallin>
                                                    <div class='form-group mt-2'>
                                                        <label for='kategori'>Kategori</label>
                                                        <select name='kategori' id='kategori_select{{ $data->id }}' class='select2 form-control' required>
                                                            <option value=''>--- Pilih Kategori ---</option>
                                                            @foreach ($kategoriBuku as $newkey)
                                                                <option value='{{ $newkey->id }}' {{ $data->kategori_id == $newkey->id ? 'selected' : '' }}>
                                                                    {{ $newkey->nama_kategori }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <script>
                                                        $(document).ready(function() {
                                                            let dataupdatee = @json($data->kategori_id); // Ambil nilai kategori_id
                                                            // Pastikan elemen dengan ID yang benar ada
                                                            let selectElement = $('#kategori_select{{ $data->id }}');
                                                            if (selectElement.length) {
                                                                selectElement.val(dataupdatee).trigger('change');
                                                            }
                                                        });
                                                    </script>

                                                    <x-inputallin>text:Kode Buku:Kode Buku:kode_buku:id_kode_buku:{{ $data->kode_buku }}:Required</x-inputallin>
                                                </div>
                                                <div class="col-xl-6">
                                                    <x-inputallin>text:Tahun Terbit:Tahun Terbit:tahun_terbit:id_tahun_terbit:{{ $data->tahun_terbit }}:Required</x-inputallin>
                                                    <x-inputallin>text:Tahun Masuk:Tahun Masuk:tahun_masuk:id_tahun_masuk:{{ $data->tahun_masuk }}:Required</x-inputallin>
                                                </div>
                                                <div class="col-xl-12 mx-1 mb-2">
                                                    <x-inputallin>type:Judul Ebook:Judul Ebook:judul_ebook:id_judul_ebook:{{ $data->judul_ebook }}:Required</x-inputallin>
                                                    <x-inputallin>text:Penulis:Penulis:penulis:id_penulis:{{ $data->penulis }}:Required</x-inputallin>
                                                    <x-inputallin>text:Penerbit:Penerbit:penerbit:id_penerbit:{{ $data->penerbit }}:Required</x-inputallin>
                                                    <x-inputallin>textarea:Abstraksi:Abstraksi:abstraksi:id_abstraksi:{{ $data->abstraksi }}:Required</x-inputallin>
                                                </div>
                                            </div>
                                            {{-- blade-formatter-enable --}}
                            <button type='submit' class='btn btn-default bg-primary btn-md float-right'><i
                                    class="fa fa-save"></i> Save</button>
                            </form>
    </section>
    </x-edit-modal>
    </div>
    {{-- blade-formatter-enable --}}
    {{-- Modal Edit Data Akhir --}}
    {{-- Modal View --}}
    <div class='modal fade' id='viewModal{{ $data->id }}' tabindex='-1' aria-labelledby='ViewModalLabel'
        aria-hidden='true'>

        <x-view-modal>
            <x-slot:titleviewModal>{{ $titleviewModal }}</x-slot:titleviewModal>
            <section>
                //Content View
            </section>
        </x-view-modal>
    </div>
    {{-- Modal View Akhir --}}
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
    </section>
</x-layout>

<button class='btn btn-warning btn-sm' onclick='FNnamaModal()'><i class='fa fa-edit right'></i> Edit</button>

<script>
    function namaModal(data) {
        var namaModal = new bootstrap.Modal(document.getElementById('namaModal'));
        namaModal.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='namaModal' tabindex='-1' aria-labelledby='LabelnamaModal' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelnamaModal'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                content

            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
            </div>
        </div>
    </div>

</div>

<script>
    function TambahEbook(data) {
        var TambahEbook = new bootstrap.Modal(document.getElementById('TambahEbook'));
        TambahEbook.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='TambahEbook' tabindex='-1' aria-labelledby='LabelTambahEbook' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelTambahEbook'>
                    Tambah E Book
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                {{-- blade-formatter-disable --}}
                <form id='updateurl' action='{{ route('katalog-ebook.store', $data->id) }}' method='POST'>
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="col-xl-6">
                            <x-inputallin>text:ISBN:ISBN:isbn:id_isbn:{{ $data->isbn }}:Required</x-inputallin>
                            @php
                                $kategoris = App\Models\Perpustakaan\Ebook::get();
                            @endphp
                            <div class='form-group mt-2'>
                                <label for='kategori'>Kategori</label>
                                <select name='kategori' id='kategori_select{{ $data->id }}' class='select2 form-control' required>
                                    <option value=''>--- Pilih Kategori ---</option>
                                    @foreach ($kategoriBuku as $newkey)
                                        <option value='{{ $newkey->id }}' {{ $data->kategori_id == $newkey->id ? 'selected' : '' }}>
                                            {{ $newkey->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <x-inputallin>text:Kode Buku:Kode Buku:kode_buku:id_kode_buku::Required</x-inputallin>
                        </div>
                        <div class="col-xl-6">
                            <x-inputallin>text:Tahun Terbit:Tahun Terbit:tahun_terbit:id_tahun_terbit::Required</x-inputallin>
                            <x-inputallin>text:Tahun Masuk:Tahun Masuk:tahun_masuk:id_tahun_masuk::Required</x-inputallin>
                        </div>
                        <div class="col-xl-12 mx-1">
                            <x-inputallin>type:Judul Ebook:Judul Ebook:judul_ebook:id_judul_ebook::Required</x-inputallin>
                            <x-inputallin>text:Penulis:Penulis:penulis:id_penulis::Required</x-inputallin>
                            <x-inputallin>text:Penerbit:Penerbit:penerbit:id_penerbit::Required</x-inputallin>
                            <x-inputallin>textarea:Abstraksi:Abstraksi:abstraksi:id_abstraksi::Required</x-inputallin>
                        </div>
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
