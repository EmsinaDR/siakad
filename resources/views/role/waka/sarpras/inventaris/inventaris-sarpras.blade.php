@php
    //Data Inventaris Index Sarprass
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


            <div class='ml-2 my-4'>
                Data Inventaris Index Sarprass
                <div class="row">
                    <div class="col-xl-2">
                        <button type='button' class='btn btn-block btn-default bg-primary btn-md'
                            onclick='TambahBarang()'><i class="fa fa-plus mr-2"></i>Tambah Data</button>
                        <button type='button' class='btn btn-block btn-default bg-primary btn-md'><i
                                class="fa fa-plus mr-2"></i>Data Peminjaman Barang</button>
                    </div>
                    <div class="col-xl-10"></div>
                </div>
            </div>
            {{-- Data ruangan : 711, 736 --}}
            <div class="row p-2">
                <div class="col-xl-12">
                    <div class="card">
                        <div class='card-header bg-primary'>
                            <h3 class='card-title'>Data Inventaris System</h3>
                        </div>
                        <div class='card-body'>
                            <table id='example1' width='100%'
                                class='table table-responsive table-bordered table-hover'>
                                <thead>
                                    <tr class='text-center table-primary'>
                                        <th class='text-center align-middle' width='1%'>ID</th>
                                        @foreach ($arr_ths as $arr_th)
                                            <th class='text-center align-middle'> {{ $arr_th }}</th>
                                        @endforeach
                                        <th class='text-center align-middle'>Keterangan</th>
                                        <th class='text-center align-middle'>Action</th>
                                        {{-- @if ($activecrud === 1)
                                          {{-- @endif --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $data)
                                        <tr>
                                            <td class='text-center'>{{ $loop->iteration }}</td>
                                            <td class='text-center'> {{ $data->kode }}</td>
                                            <td class='text-center'> {{ $data->nama_barang }}</td>
                                            {{-- <td class='text-center'> {{ $data->Kategori->nama_kategori }}</td> --}}
                                            <td class='text-center'> {{ $data->keterangan }}</td>
                                            {{-- <td class='text-center'> {{ $data->rusak_sedang }}</td>
                                    <td class='text-center'> {{ $data->rusak_berat }}</td>
                                    <td class='text-center'> {{ $data->baik }}</td>
                                    <td class='text-center'> {{ $data->jumlah }}</td> --}}

                                            <td width='20%'>
                                                <div class='gap-1 d-flex justify-content-center'>
                                                    @if ($data->system === 'Y')
                                                    @else
                                                        <button type='button'
                                                            class='btn btn-warning btn-sm btn-equal-width'
                                                            data-toggle='modal'
                                                            data-target='#editModal{{ $data->id }}'><i
                                                                class='fa fa-edit'></i> Edit</button>
                                                        <!-- Form untuk menghapus -->
                                                        {{-- blade-formatter-disable --}}
                                                        <form id='delete-form-{{ $data->id }}' action='{{ route('inventaris-sarpras.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                        <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i> Hapus </button>
                                                        {{-- blade-formatter-enable --}}
                                                    @endif
                                                    


                                                </div>
                                            </td>
                                        </tr>
                                        {{-- Modal View Data Akhir --}}

                                        <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                            aria-labelledby='EditModalLabel' aria-hidden='true'>

                                            <x-edit-modal>
                                                <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                <section>
                                                    <form id='updateurl'
                                                        action='{{ route('inventaris-sarpras.update', $data->id) }}'
                                                        method='POST'>
                                                        @csrf
                                                        @method('PATCH')
                                                            {{-- blade-formatter-disable --}}
                                                            <x-inputallin>type:Nama Barang:Nama barang:nama_barang:id_nama_barang:{{ $data->nama_barang }}:Required</x-inputallin>
                                                            <x-inputallin>textarea:Keterangan:Keterangan:keterangan:id_keterangan:{{ $data->keterangan }}:Required</x-inputallin>
                                                            {{-- blade-formatter-enable --}}
                                                        <button id='kirim' type='submit'
                                                            class='btn float-right btn-default bg-primary btn-xl mt-4'>
                                                            Kirim</button>
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
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class='text-center'>
                                        <th>ID</th>
                                        @foreach ($arr_ths as $arr_th)
                                            <th> {{ $arr_th }}</th>
                                        @endforeach
                                        <th>Keterangan</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </section>
</x-layout>
{{-- <button class='btn btn-warning btn-sm' onclick='TambahBarang()'><i class='fa fa-edit right'></i> Edit</button> --}}
{{--

 --}}

<script>
    function TambahBarang() {
        var TambahBarang = new bootstrap.Modal(document.getElementById('TambahBarang'));
        TambahBarang.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='TambahBarang' tabindex='-1' aria-labelledby='LabelTambahBarang' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelTambahBarang'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <form id='#id' action='{{ route('inventaris-sarpras.store') }}' method='POST'>
                    @csrf
                    @method('POST')
                    {{-- blade-formatter-disable --}}
                    <x-inputallin>type:Nama Barang:Nama barang:nama_barang:id_nama_barang::Required</x-inputallin>
                    <x-inputallin>textarea:Keterangan:Keterangan:keterangan:id_keterangan::Required</x-inputallin>
                    {{-- blade-formatter-enable --}}

            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
            </div>
            </form>
        </div>
    </div>

</div>
