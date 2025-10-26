@php
    //Data KIB B
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
                <h3 class='card-title'>{{ $title }} - Peralatan dan Mesin</H3>
            </div>
            <!--Car Header-->
            <div class='card-body'>
                <div class="row">
                    <div class="col-xl-2">
                        <button type='button' class='btn btn-default bg-primary btn-md' onclick='TambahData()'><i
                                class="fa fa-plus"></i> Tambah Data</button>
                    </div>
                    <div class="col-xl-10"></div>
                </div>
            </div>


            <div class='ml-2 my-4'>
                <div class="card">
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>Data Inventaris Barang KIB</h3>
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
                                    @if (empty($data->nama_barang))
                                        <tr class='table-warning'>
                                        @else
                                        <tr class=''>
                                    @endif
                                    <td class='text-center  align-middle'>{{ $loop->iteration }}</td>
                                    <td class='text-center  align-middle'> {{ $data->nama_barang }}</td>
                                    {{-- <td class='text-center  align-middle'> {{$data->InventarisVendor->nama_vendor}}</td> --}}
                                    <td class='text-center  align-middle'> {{ $data->merek }}</td>
                                    <td class='text-center  align-middle'> {{ $data->tahun_masuk }}</td>
                                    <td class='text-center align-middle'>
                                        @if ($data->kondisi === 'Baik')
                                            <span class="bg-success p-1">{{ $data->kondisi }}</span>
                                        @elseif($data->kondisi === 'Hilang')
                                            <span class="bg-danger p-1">{{ $data->kondisi }}</span>
                                        @elseif(empty($data->kondisi) or $data->kondisi === null)
                                            <span class="">{{ $data->kondisi }}</span>
                                        @else
                                            <span class="bg-warning p-1">{{ $data->kondisi }}</span>
                                        @endif
                                    <td class='text-center align-middle'> {{ $data->jumlah }}</td>
                                    <td class='text-center align-middle'>Rp. {{ number_format($data->harga, 0) }}
                                    </td>
                                    <td class='text-center align-middle'> {{ $data->spesifikasi }}</td>

                                    <td width='10%'>
                                        {{-- blade-formatter-disable --}}
                                        <div class='gap-1 d-flex justify-content-center'>
                                            <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                                data-toggle='modal' data-target='#editModal{{ $data->id }}'><i
                                                    class='fa fa-edit'></i> </button>
                                            <!-- Form untuk menghapus -->
                                            <form id='delete-form-{{ $data->id }}' action='{{ route('inventaris-kibb.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i> </button>
                                        </div>
                                        {{-- blade-formatter-enable --}}
                                    </td>
                                    </tr>
                                    {{-- Modal View Data Akhir --}}

                                    <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                        aria-labelledby='EditModalLabel' aria-hidden='true'>

                                        <x-edit-modal>
                                            <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                            <section>
                                                <form id='updateurl'
                                                    action='{{ route('inventaris-kibb.update', $data->id) }}'
                                                    method='POST'>
                                                    @csrf
                                                    @method('PATCH')

                                                    {{-- blade-formatter-disable --}}
                                                    <x-inputallin>type:Nama Barang:Nama Barang:nama_barang:id_nama_barang:{{ $data->Barang->nama_barang }} / {{ $data->kode_barang }}:Required</x-inputallin>
                                                    {{-- blade-formatter-enable --}}
                                                    @php
                                                        $DataVendor = App\Models\WakaSarpras\Inventaris\InventarisVendor::all();
                                                    @endphp
                                                    <div class='form-group'>
                                                        <!-- Jika menggunakan multiple select2 tambahkan id dengan id berbeda -->
                                                        <label>Vendor </label>
                                                        <select id='vendor_id' class='select2-dropdown form-control'
                                                            name='vendor_id' data-placeholder='Data Vendor'
                                                            style='width: 100%;' data-id="{{ $data->vendor_id }}">
                                                            <option value=''>--- Pilih judul ----</option>
                                                            @foreach ($DataVendor as $Vendor)
                                                                <option value='{{ $Vendor->id }}'>
                                                                    {{ $Vendor->nama_vendor }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    {{-- blade-formatter-disable --}}

                                                    <x-inputallin>type:Merk:Merk barang:merk:id_merk:{{ $data->merk }}:Required</x-inputallin>
                                                    <x-inputallin>type:Tahun Masuk:Tahun masuk atau pemeblian:tahun_masuk:id_tahun_masuk:{{ $data->tahun_masuk }}:Required</x-inputallin>
                                                    <x-inputallin>type:Kondisi:Kondis barang saat ini:kondisi:id_kondisi:{{ $data->kondisi }}:Required</x-inputallin>
                                                    <x-inputallin>textarea:Spesifikasi:Spesifikasi barang:spesifikasi:id_spesifikasi:{{ $data->spesifikasi }}:Required</x-inputallin>
                                                    <x-inputallin>type:Jumlah:Jumlah items:jumlah:id_jumlah:{{ $data->jumlah }}:Required</x-inputallin>
                                                    <x-inputallin>type:Harga:Harga barang per unit:harga:id_harga:{{ $data->harga }}:Required</x-inputallin>
                                                    <x-inputallin>type:Lokasi Pengimpanan / Penggunaan:Lokasi barang:lokasi:id_lokasi:{{ $data->lokasi }}:Required</x-inputallin>
                                                    <x-inputallin>type:Keterangan:Keterangan:keterangan:id_keterangan:{{ $data->keterangan }}:Required</x-inputallin>
                                                    {{-- blade-formatter-enable --}}

                                                    <button id='kirim' type='submit'
                                                        class='btn float-right btn-default bg-primary btn-xl mt-4'>
                                                        Kirim</button>
                                                    <script>
                                                        $(document).ready(function() {
                                                            // Saat modal ditampilkan, jalankan fungsi ini
                                                            $('.modal').on('shown.bs.modal', function() {
                                                                let modal = $(this);

                                                                // Fokus otomatis ke input pertama yang bisa diketik
                                                                setTimeout(function() {
                                                                    modal.find('input:not([type="hidden"]), select, textarea').filter(
                                                                        ':visible:first').focus();
                                                                }, 300);

                                                                // Inisialisasi Select2 dalam modal
                                                                modal.find('.select2-dropdown').select2({
                                                                    dropdownParent: modal, // Fix dropdown agar tidak terpotong dalam modal
                                                                    width: '100%',
                                                                    allowClear: true,
                                                                    placeholder: "Pilih Hak Kepemilikan",
                                                                    minimumResultsForSearch: 0 // Aktifkan pencarian
                                                                });

                                                                // Set nilai default dari database jika ada
                                                                modal.find('.select2-dropdown').each(function() {
                                                                    let selectedValue = $(this).attr("data-id");
                                                                    if (selectedValue) {
                                                                        $(this).val(selectedValue).trigger('change');
                                                                    }
                                                                });

                                                                // Event untuk menangani pilihan "Pilih Lainnya"
                                                                modal.find('.select2-dropdown').on('change', function() {
                                                                    let selectedValue = $(this).val();
                                                                    let inputLainnya = $(this).closest('.form-group').find('.input-lainnya');

                                                                    if (selectedValue === "lainnya") {
                                                                        inputLainnya.show().focus(); // Tampilkan input dan fokuskan
                                                                    } else {
                                                                        inputLainnya.hide().val(''); // Sembunyikan input jika pilihan lain dipilih
                                                                    }
                                                                });
                                                            });
                                                        });
                                                    </script>
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

<script>
    function TambahData() {
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
                <form id='#id' action='' method='POST'>
                    @csrf
                    @method('POST')
                    @php
                        $dataBarangs = App\Models\WakaSarpras\Inventaris\Inventaris::orderBY(
                            'nama_barang',
                            'ASC',
                        )->get();
                    @endphp
                    <div class='form-group'>
                        <label for='barang_id'>Nama Barang</label>
                        <select id='select2' name='barang_id[]' multiple='multiple' class='select2 form-control'
                            required>
                            <option value=''>--- Pilih Nama Barang ---</option>
                            @foreach ($dataBarangs as $newkey)
                                <option value='{{ $newkey->id }}'>{{ $newkey->nama_barang }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
