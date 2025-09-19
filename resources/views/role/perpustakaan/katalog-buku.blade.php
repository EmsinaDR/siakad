@php
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
@endphp
<x-layout>

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            {{-- Header Menu --}}
            {{-- blade-formatter-disable --}}
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
                        <a href='#' class='small-box-footer'>More info <i class='fas fa-arrow-circle-right'></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class='col-lg-3 col-6'>
                    <!-- small box -->
                    <div class='small-box bg-success'>
                        <div class='inner'>
                            <h3>{{$KategoriBuku->count()}}</h3>
                            <p>Kategori Buku</p>
                        </div>
                        <div class='icon'>
                            <i class='fa fa-coin'></i>
                        </div>
                        <a href='#' class='small-box-footer'>More info <i class='fas fa-arrow-circle-right'></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class='col-lg-3 col-6'>
                    <!-- small box -->
                    <div class='small-box bg-warning'>
                        <div class='inner'>
                            <h3>{{ $DataUserSekolah }}</h3>
                            <p>Anggota Perpustakaan</p>
                        </div>
                        <div class='icon'>
                            <i class='ion ion-person-add'></i>
                        </div>
                        <a href='#' class='small-box-footer'>More info <i class='fas fa-arrow-circle-right'></i></a>
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
                        <a href='#' class='small-box-footer'>More info <i class='fas fa-arrow-circle-right'></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            {{-- blade-formatter-enable --}}

            {{-- Header Menu --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2 mt-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->


            <div class='ml-2 my-4'>
                <div class="row gap-2">
                    <div class="col-xl-2">
                        {{-- blade-formatter-disable --}}
                        <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick="TambahBuku()"> <i class="fa fa-plus mr-2"></i>Tambah Buku</button>
                        <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#TambahKategori'><i class='fa fa-book mr-2'></i> Tambah Data</button>
                        {{-- blade-formatter-enable --}}
                    </div>
                    <div class="col-xl-6">
                        <div class='card-header bg-success'>
                            <h3 class='card-title'>Buku Favorite</h3>
                        </div>
                        <table id='example2' width='100%' class='table table-bordered table-hover'>
                            <thead>
                                <tr class='text-center align-middle table-success'>
                                    <th class='text-center align-middle table-success' width='1%'>ID</th>
                                    <th class='text-center align-middle table-success'>Judul Buku</th>
                                    <th class='text-center align-middle table-success' width='10%'>Jumlah Peminjaman
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_riwayat_peminjaman as $item)
                                    <tr>
                                        <td class='text-center'>{{ $loop->iteration }}</td>
                                        <td class='text-center'>{{ $item->buku->judul_buku }}</td>
                                        <td class='text-center'>{{ $item->total_peminjaman }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class='text-center align-middle table-success'>
                                    <th class='text-center align-middle table-success'>ID</th>
                                    <th class='text-center align-middle table-success'>Judul Buku</th>
                                    <th class='text-center align-middle table-success' width='10%'>Jumlah Peminjaman
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class='card-header bg-success'>
                    <h3 class='card-title'>Data Katalog</h3>
                </div>
                <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                    <thead>
                        <tr class='text-center align-middle table-success'>
                            <th class='text-center align-middle' rowspan='2' width='1%'>ID</th>
                            @foreach ($arr_ths as $arr_th)
                                <th rowspan='2' class='text-center align-middle'> {{ $arr_th }}</th>
                            @endforeach
                            <th class='text-center align-middle' colspan='2'>Kondisi</th>
                            <th class='text-center align-middle' rowspan='2'>Total</th>
                            <th class='text-center align-middle' rowspan='2'>Action</th>
                        </tr>
                        <th class='text-center align-middle table-success'>Baik</th>
                        <th class='text-center align-middle table-success'>Rusak</th>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr>
                                <td class='text-center'>{{ $loop->iteration }}</td>
                                <td width='10%' class='text-center'>
                                    {{-- @if (File::exists(public_path('uploads/example.jpg')))
                                        <img src="{{ asset('img/perpustakaan/buku/default.jpg') }}" alt="Gambar" class="img-fluid rounded-circle shadow-sm" style="max-width: 25%; height: auto;">
                                    @else
                                        <img src="{{ asset('img/perpustakaan/buku/default.jpg') }}" alt="Gambar" class="img-fluid rounded-circle shadow-sm" style="max-width: 50%; height: auto;">
                                    @endif --}}
                                </td>
                                <td class='text-center'> {{ $data->kode_buku ?? '' }}</td>
                                <td class='text-center'> {{ $data->judul_buku ?? '' }}</td>
                                <td class='text-center'> {{ $data->penulis ?? '' }}</td>
                                <td class='text-center'>
                                    @php
                                        $varData = App\Models\Perpustakaan\Eperpuspeminjam::where('buku_id', $data->id)
                                            ->where('status', '!=', 'dikembalikan')
                                            ->count();
                                    @endphp
                                    {{ $varData }} / {{ $data->baik }} Buku
                                </td>
                                <td class='text-center'> {{ $data->baik ?? '' }}</td>
                                <td class='text-center'> {{ $data->rusak ?? '' }}</td>
                                <td class='text-center'> {{ $data->baik + $data->rusak ?? '' }}</td>

                                <td width='10%'>
                                    {{-- blade-formatter-disable --}}
                                    <div class='gap-1 d-flex justify-content-center'>
                                        <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i> </button>
                                        <form action='{{ route('katalog-buku.destroy', $data->id) }}' method='POST'
                                            style='display: inline-block;'>
                                            @csrf
                                            @method('DELETE')
                                            <button type='submit' class='btn btn-danger btn-sm btn-equal-width' onclick=`return confirm('Apakah Anda yakin ingin menghapus data ini?');`><i class='fa fa-trash'></i> </button>
                                        </form>
                                    </div>
                                    {{-- blade-formatter-enable --}}
                                </td>
                            </tr>
                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                aria-labelledby='EditModalLabel' aria-hidden='true'>
                                <x-edit-modal>
                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                    {{-- blade-formatter-disable --}}
                                    <section>
                                        <form id='updateurl' action='{{ route('katalog-buku.update', $data->id) }}'
                                            method='POST'>
                                            @csrf
                                            @method('PATCH')
                                            {{-- blade-formatter-disable --}}
                                            <x-inputallin>type:Kode Buku:Kode Buku:kode_buku:id_kode_buku:{{ $data->kode_buku ?? ''  }}:Required</x-inputallin>
                                            <x-inputallin>type:Judul Buku:Judul Buku:judul_buku:id_judul_buku:{{ $data->judul_buku ?? ''  }}:Required</x-inputallin>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <x-inputallin>type:Penulis:Penulis:penulis:id_penulis:{{ $data->penulis ?? ''  }}:Required</x-inputallin>
                                                    <x-inputallin>type:Tahun Terbit:Tahun Terbit:tahun_terbit:id_tahun_terbit:{{ $data->tahun_terbit  ?? '' }}:Required</x-inputallin>
                                                    <x-inputallin>type:Kondisi Baik:Kondisi Baik:baik:id_baik:{{ $data->baik ?? ''  }}:Required</x-inputallin>
                                                    <x-inputallin>type:Harga:Harga Satuan:harga:id_harga:{{ $data->harga ?? ''  }}:Required</x-inputallin>
                                                </div>
                                                <div class="col-xl-6">
                                                    <x-inputallin>type:Penerbit:Penerbit:penerbit:id_penerbit:{{ $data->penerbit ?? ''  }}:Required</x-inputallin>
                                                    <x-inputallin>type:ISBN:ISBN:isbn:id_isbn:{{ $data->isbn }}:Required</x-inputallin>
                                                    <x-inputallin>type:Kondisi Rusak:Kondisi Rusak:rusak:id_rusak:{{ $data->rusak ?? ''  }}:Required</x-inputallin>
                                                    <x-inputallin>type:Sumber Dana:Sumber Dana:sumber_dana:id_sumber_dana:{{ $data->sumber_dana ?? ''  }}:Required</x-inputallin>
                                                </div>
                                            </div>
                                            {{-- blade-formatter-enable --}}

                                    <button id='kirim' type='submit'
                                        class='btn float-right btn-default bg-primary btn-xl mt-4'> Kirim</button>
                                    </form>
    </section>
    {{-- blade-formatter-enable --}}
    </x-edit-modal>
    </div>
    @endforeach
    </tbody>
    <tfoot>
        <tr class='text-center'>
            <th width='1%'>ID</th>
            @foreach ($arr_ths as $arr_th)
                <th class='text-center'> {{ $arr_th }}</th>
            @endforeach
            <th>Baik</th>
            <th>Rusak</th>
            <th>Total</th>
            <th class='text-center'>Action</th>
        </tr>
    </tfoot>
    </table>

    </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let successMessage = "{{ session('Success') }}";
            if (successMessage) {
                Swal.fire({
                    title: "{{ session('Title') }}",
                    text: successMessage,
                    icon: "success"
                });
            }
        });
    </script>
    </section>
</x-layout>

<button class='btn btn-warning btn-sm' onclick='FNTambahBuku()'><i class='fa fa-edit right'></i> Edit</button>

<script>
    function TambahBuku(data) {
        var TambahBuku = new bootstrap.Modal(document.getElementById('TambahBuku'));
        TambahBuku.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='TambahBuku' tabindex='-1' aria-labelledby='LabelTambahBuku' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelTambahBuku'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <form action="{{ route('katalog-buku.store') }}" method="POST">
                    @csrf
                    {{-- blade-formatter-disable --}}
                    <div class='form-group'>
                       <label for='kategori_id'>Kategori Buku</label>
                       <select name='kategori_id' id='kategori_id' data-placeholder='Pilih Data Kategori Buku' class='select2 form-control' required>
                               <option value=''>--- Pilih Kategori Buku ---</option>
                           @foreach($KategoriBuku as $newKategoriBuku)
                               <option value='{{$newKategoriBuku->id}}'>{{$newKategoriBuku->nama_kategori}}</option>
                           @endforeach
                       </select>
                    </div>
                    <x-inputallin>type:Kode Buku:Kode Buku:kode_buku:id_kode_buku:{{ old('kode_buku', $data->kode_buku ?? '') }}:Required</x-inputallin>
                    <x-inputallin>type:Judul Buku:Judul Buku:judul_buku:id_judul_buku:{{ old('judul_buku', $data->judul_buku ?? '') }}:Required</x-inputallin>
                    <div class="row">
                        <div class="col-xl-6">
                            <x-inputallin>type:Penulis:Penulis:penulis:id_penulis:{{ old('penulis', $data->penulis) }}:Required</x-inputallin>
                            <x-inputallin>text:Tahun Terbit:Tahun Terbit:tahun_terbit:id_tahun_terbit:{{ old('tahun_terbit', $data->tahun_terbit) }}:Required</x-inputallin>
                            <x-inputallin>text:Kondisi Baik:Kondisi Baik:baik:id_baik:{{ old('baik', $data->baik ?? '') }}:Required</x-inputallin>
                            <x-inputallin>text:Harga:Harga Satuan:harga:id_harga:{{ old('harga', $data->harga ?? '') }}:Required</x-inputallin>
                        </div>
                        <div class="col-xl-6">
                            <x-inputallin>type:Penerbit:Penerbit:penerbit:id_penerbit:{{ old('penerbit', $data->penerbit ?? '') }}:Required</x-inputallin>
                            <x-inputallin>type:ISBN:ISBN:isbn:id_isbn:{{ old('isbn', $data->isbn ?? '') }}:Required</x-inputallin>
                            <x-inputallin>text:Kondisi Rusak:Kondisi Rusak:rusak:id_rusak:{{ old('rusak', $data->rusak) }}:Required</x-inputallin>
                            <x-inputallin>type:Sumber Dana:Sumber Dana:sumber_dana:id_sumber_dana:{{ old('sumber_dana', $data->sumber_dana ?? '') }}:Required</x-inputallin>
                        </div>
                    </div>
                    <x-inputallin>textarea:Keterangan:Masukkan Keterangan:keterangan:id_keterangan:{{ old('keterangan', $data->keterangan ?? '') }}:required</x-inputallin>
                    {{-- blade-formatter-enable --}}

                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='TambahKategori' tabindex='-1' aria-labelledby='LabelTambahKategori' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelTambahKategori'>
                    Tambah Data Kategori Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <form id='TambahKategori-form' action='{{ route('kategori-buku.store') }}' method='POST'>
                    @csrf
                    @method('POST')
                    <div class='form-group'>
                        <label for='nama_kategori'>Kategori</label>
                        <input type='text' class='form-control' id='nama_kategori' name='nama_kategori'
                            placeholder='Nama kategori yang akan didaftarkan' required>
                    </div>
                    <div class='form-group'>
                        <label for='kode'>Kode Kategori</label>
                        <input type='text' class='form-control' id='kode' name='kode'
                            placeholder='Kode kategori' required>
                    </div>
                    <div class='form-group'>
                        <i class='fas fa-sticky-note pr-2'></i><label for='keterangan'>Keterangan</label>
                        <textarea name='keterangan' id='keterangan' rows='3' class='form-control'
                            placeholder='Masukkan Keterangan Singkat'></textarea>
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
