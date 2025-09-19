@php
    //Inventaris Vendor
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
                                <td class='text-center'> {{ $data->nama_vendor }}</td>
                                <td class='text-center'> {{ $data->nama_kontak }}</td>
                                <td class='text-center'> {{ $data->nomor_hp }}</td>
                                <td class='text-center'> {{ $data->alamat }}</td>
                                <td class='text-center'> {{ $data->keterangan }}</td>

                                <td width='10%'>
                                    <div class='gap-1 d-flex justify-content-center'>
                                        <!-- Button untuk mengedit -->
                                        <button type='button' class='btn btn-success btn-sm btn-equal-width'
                                            data-toggle='modal' data-target='#VendorId{{ $data->id }}'><i
                                                class="fas fa-history"></i> </button>
                                        <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                            data-toggle='modal' data-target='#editModal{{ $data->id }}'><i
                                                class='fa fa-edit'></i> </button>
                                        <!-- Form untuk menghapus -->
                                        <form id='delete-form-{{ $data->id }}' action='{{ route('inventaris-vendor.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i> </button>

                                    </div>
                                    {{-- Modal View Data Akhir --}}

                                    <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                        aria-labelledby='EditModalLabel' aria-hidden='true'>

                                        <x-edit-modal>
                                            <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                            <section>
                                                <form id='updateurl'
                                                    action='{{ route('inventaris-vendor.update', $data->id) }}'
                                                    method='POST'>
                                                    @csrf
                                                    @method('PATCH')
                                                    <x-inputallin>type:Nama Vendor:Nama Vendor:nama_vendor:id_nama_vendor:{{ $data->nama_vendor }}:Required</x-inputallin>
                                                    <x-inputallin>type:Nama Kontak:Nama Kontak:nama_kontak:id_nama_kontak:{{ $data->nama_kontak }}:Required</x-inputallin>
                                                    <x-inputallin>type:No HP:Nomor HP:nomor_hp:id_nomor_hp:{{ $data->nomor_hp }}:Required</x-inputallin>
                                                    <x-inputallin>textarea:Alamat Vendor:Alamat lengkap vendor:alamat:id_alamat_vendor:{{ $data->alamat }}:Required</x-inputallin>
                                                    <x-inputallin>textarea:Keterangan:Keterangan:keterangan:id_keterangan:{{ $data->keterangan }}:Required</x-inputallin>

                                                    <button id='kirim' type='submit'
                                                        class='btn float-right btn-default bg-primary btn-xl mt-4'>
                                                        Kirim</button>
                                                </form>

                                            </section>
                                        </x-edit-modal>
                                    </div>
                                    {{-- Modal Edit Data Akhir --}}
                                    {{-- Modal View --}}

                                    <div class='modal fade' id='VendorId{{ $data->id }}' tabindex='-1'
                                        aria-labelledby='ViewModalLabel' aria-hidden='true'>
                                        <x-view-modal>
                                            <x-slot:titleviewModal>{{ $titleviewModal }}</x-slot:titleviewModal>
                                            <section>
                                                @php
                                                    $VendorRiwayats = App\Models\WakaSarpras\Inventaris\KIBB::where(
                                                        'vendor_id',
                                                        $data->id,
                                                    )->get();
                                                    //    dd($VendorRiwayats);
                                                    if ($VendorRiwayats->isEmpty()) {
                                                    }
                                                @endphp
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <dl class="row">
                                                            <dt class="col-md-3 fw-bold">Nama Vendor</dt>
                                                            <dd class="col-md-9 border-bottom mb-2">:
                                                                {{ $data->nama_vendor }}</dd>

                                                            <dt class="col-md-3 fw-bold">Nama Kontak</dt>
                                                            <dd class="col-md-9 border-bottom mb-2">:
                                                                {{ $data->nama_kontak }}</dd>

                                                            <dt class="col-md-3 fw-bold">No HP</dt>
                                                            <dd class="col-md-9 border-bottom mb-2">:
                                                                {{ $data->nomor_hp }}</dd>
                                                        </dl>
                                                    </div>
                                                </div>


                                                <table id='example-{{ $data->id }}' width='100%'
                                                    class='table table-bordered table-hover'>
                                                    <thead>
                                                        <tr class='text-center align-middle table-primary'>
                                                            <th>ID</th>
                                                            <th>Nama Barang</th>
                                                            <th>Harga</th>
                                                            <th>Jumlah</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    {{-- blade-formatter-disable --}}
                                                    <tbody>
                                                        @if ($VendorRiwayats->isEmpty())
                                                            <tr class='text-center'>
                                                                <td colspan='5'>Tidak Ada Riwayat Pembelian</td>
                                                            </tr>
                                                        @else
                                                            @foreach ($VendorRiwayats as $VendorRiwayat)
                                                                <tr class='text-center'>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td class='text-center'> {{ $VendorRiwayat->nama_barang }}</td>
                                                                    <td class='text-center'> {{ $VendorRiwayat->jumlah }}</td>
                                                                    <td class='text-center'>Rp. {{ number_format($VendorRiwayat->harga, 0) }}</td>
                                                                    <td class='text-center'>Rp.  {{ number_format($VendorRiwayat->harga * $VendorRiwayat->jumlah, 0)  }}</td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                    {{-- blade-formatter-enable --}}
                                                    <tfoot>
                                                        <tr class='text-center align-middle'>
                                                            <th>ID</th>
                                                            <th>Nama Barang</th>
                                                            <th>Harga</th>
                                                            <th>Jumlah</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </section>
                                        </x-view-modal>
                                    </div>
                                </td>
                            </tr>
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
{{-- <button class='btn btn-warning btn-sm' onclick='RiawayatVendor()'><i class='fa fa-edit right'></i> Edit</button> --}}
{{--
onclick='RiawayatVendor()'
 --}}

<script>
    function RiawayatVendor(data) {
        var RiawayatVendor = new bootstrap.Modal(document.getElementById('RiawayatVendor'));
        RiawayatVendor.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='RiawayatVendor' tabindex='-1' aria-labelledby='LabelRiawayatVendor' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelRiawayatVendor'>
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
