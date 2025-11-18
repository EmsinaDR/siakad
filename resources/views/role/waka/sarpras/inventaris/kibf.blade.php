@php
    //Data KIB F
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
        <div class="card">
            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }} - Aset Tetap Lainnya</H3>
            </div>
            <!--Car Header-->

            <div class='m-2'>
                {{-- Papan Informasi --}}
                <div class="row">
                    <div class="col-xl-2">
                        {{-- blade-formatter-disable --}}
                        <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahAsset()'><i class="fa fa-plus"></i> Tambah Aset</button>
                        <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahAsset()'><i class="fa fa-print"></i> Cetak Aset</button>
                        {{-- blade-formatter-enable --}}
                    </div>
                    <div class="col-xl-10">
                        <div class='card-header bg-primary'>
                            <h3 class='card-title'>Data Barang</h3>
                        </div>
                        <div class='card-body'>
                            <table id='example1' width='100%'
                                class='table table-responsive table-bordered table-hover'>
                                <thead>
                                    <tr class='text-center align-middle'>
                                        <th>ID</th>
                                        <th>Nama Barang</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datakibA as $data)
                                        <tr class='text-center'>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->nama_barang }}</td>
                                            <td><button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i> </button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class='text-center align-middle'>
                                        <th>ID</th>
                                        <th>Nama Barang</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>


                {{-- Papan Informasi --}}
            </div>


            <div class='ml-2 my-4'>
                <div class="card">
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>Data Aset KIB F</h3>
                    </div>
                    <div class='card-body'>
                        <table id='example2' width='100%' class='table table-responsive table-bordered table-hover'>
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
                                @if ($datas->isEmpty())
                                    <tr>
                                        <td colspan='7' class='text-center'>Tidak ada data ditemukan</td>
                                    </tr>
                                @else
                                    @foreach ($datas as $data)
                                        <tr>
                                            {{-- blade-formatter-disable --}}
                                            <td class='text-center'>{{ $loop->iteration }}</td>
                                            <td class='text-center'> {{ $data->nama_barang }}</td>
                                            <td class='text-center'> {{ $data->jumlah }}</td>
                                            <td class='text-center'> {{ $data->tahun_masuk }}</td>
                                            <td class='text-center'> {{ $data->lokasi }}</td>
                                            <td class='text-center'>
                                                @if ($data->status === 'Baik')
                                                    <span class="bg-success p-2 rounded-pill">{{ $data->status }}</span>
                                                @elseif($data->status === 'Rusak Ringan')
                                                    <span class="bg-info p-2 rounded-pill">{{ $data->status }}</span>
                                                @elseif($data->status === 'Rusak Sedang')
                                                    <span class="bg-warning p-2 rounded-pill">{{ $data->status }}</span>
                                                @else
                                                    <span class="bg-danger p-2 rounded-pill">{{ $data->status }}</span>
                                                @endif
                                            </td>
                                            <td width='10%'>
                                                <div class='gap-1 d-flex justify-content-center'>
                                                    <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i> </button>
                                                    <!-- Form untuk menghapus -->
                                                    <form id='delete-form-{{ $data->id }}' action='{{ route('inventaris-kibf.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i> </button>
                                                </div>
                                            </td>
                                            {{-- blade-formatter-enable --}}
                                        </tr>
                                        {{-- Modal View Data Akhir --}}

                                        <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                            aria-labelledby='EditModalLabel' aria-hidden='true'>

                                            <x-edit-modal>
                                                <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                <section>
                                                    <form id='updateurl'
                                                        action='{{ route('inventaris-kibf.update', $data->id) }}'
                                                        method='POST'>
                                                        @csrf
                                                        @method('PATCH')

                                                        {{-- blade-formatter-disable --}}
                                                        <x-inputallin>type:Nama Barang:Nama Barang:nama_barang:id_nama_barang:{{ $data->nama_barang }}:Required</x-inputallin>
                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <x-inputallin>type:Jumlah:Jumlah:jumlah:id_jumlah:{{ $data->jumlah }}:Required</x-inputallin>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <x-inputallin>type:Tahun Masuk:Tahun Masuk Barang:tahun_masuk:id_tahun_masuk:{{ $data->tahun_masuk }}:Required</x-inputallin>
                                                            </div>
                                                        </div>
                                                        <x-inputallin>type:Lokasi:Lokasi Barang:lokasi:id_lokasi:{{ $data->lokasi }}:Required</x-inputallin>
                                                        @php
                                                            $DataStatus = [
                                                                'Baik',
                                                                'Rusak Ringan',
                                                                'Rusak Sedang',
                                                                'Rusak Berat',
                                                            ];
                                                        @endphp
                                                        <div class='form-group'>
                                                            <label>Status Barang</label>
                                                            <select id='status-{{ $data->id }}' class='select2 form-control' name='status' data-placeholder='Status Kondisi' style='width: 100%;'>
                                                                <option value=''>--- Pilih judul ----</option>
                                                                @foreach ($DataStatus as $DataStatusNew)
                                                                    <option value='{{ $DataStatusNew }}'> {{ $DataStatusNew }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        {{-- blade-formatter-enable --}}
                                                        <script>
                                                            $(document).ready(function() {
                                                                // $('#semesteredit option[value='II']').prop('selected', true); // Single Select
                                                                $('#status-{{ $data->id }}').val(@json($data->status)).trigger(
                                                                    'change'); // Mutiple Select Select value in array json
                                                            });
                                                        </script>



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

                                @endif
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
{{-- <button class='btn btn-warning btn-sm' onclick='TambahAsset()'><i class='fa fa-edit right'></i> Edit</button> --}}
{{--
onclick='TambahAsset()'
 --}}

<script>
    function TambahAsset(data) {
        var TambahAsset = new bootstrap.Modal(document.getElementById('TambahAsset'));
        TambahAsset.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='TambahAsset' tabindex='-1' aria-labelledby='LabelTambahAsset' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelTambahAsset'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <form action="{{ route('inventaris-kibf.store') }}" method="POST">
                    @csrf


                </form>


            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
            </div>
        </div>
    </div>

</div>
