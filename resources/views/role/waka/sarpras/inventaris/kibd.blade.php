@php
    //KIB D
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
                <h3 class='card-title'>{{ $title }} - Konstruksi Dalam Pengerjaan</H3>
            </div>
            <!--Car Header-->
            <div class="col-xl-12">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-2">
                            <button type='button' class='btn btn-block btn-default bg-primary btn-md'
                                onclick='TambahData()'> <i class="fa fa-plus"></i> Tambah Data Perbaikan</button>
                        </div>
                        <div class="col-xl-10">
                            <div class='card-header bg-warning'>
                                <h3 class='card-title'>Rekomendasi Perbaikan Ruangan</h3>
                            </div>
                            <div class='card-body'>
                                @php
                                    // $DataKIBC = App\Models\WakaSarpras\Inventaris\KIBC::where('kondisi', '!=', 'Baik')->get();
                                    $DataKIBCs = App\Models\WakaSarpras\Inventaris\KIBC::whereNotIn('kondisi', ['Baik'])
                                        ->orWhereNull('kondisi')
                                        ->get();

                                @endphp
                                <table id='example1' width='100%' class='table table-bordered table-hover'>
                                    <thead>
                                        <tr class='text-center  table-warning align-middle'>
                                            <th>ID</th>
                                            <th>Data Ruangan</th>
                                            <th>Kondisi</th>
                                            <th>Panjang</th>
                                            <th>Lebar</th>
                                            <th>Keterangan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($DataKIBCs as $data)
                                            <tr class='text-center'>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->nama_ruangan }}</td>
                                                <td>
                                                    @if ($data->kondisi === 'Rusak Ringan')
                                                        <span
                                                            class="bg-info p-2 rounded-pill">{{ $data->kondisi }}</span>
                                                    @elseif ($data->kondisi === 'Rusak Sedang')
                                                        <span
                                                            class="bg-warning p-2 rounded-pill">{{ $data->kondisi }}</span>
                                                    @else
                                                        <span
                                                            class="bg-danger p-2 rounded-pill">{{ $data->kondisi }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $data->panjang }} m</td>
                                                <td>{{ $data->lebar }} m</td>
                                                <td>{{ $data->keterangan }}</td>
                                                <td>
                                                    <button type='button'
                                                        class='btn btn-warning btn-sm btn-equal-width'
                                                        data-toggle='modal'
                                                        data-target='#tambahProject{{ $data->id }}'><i
                                                            class='fa fa-edit'></i> Edit</button>
                                                </td>
                                            </tr>
                                            {{-- Modal View Data Akhir --}}

                                            <div class='modal fade' id='tambahProject{{ $data->id }}'
                                                tabindex='-1' aria-labelledby='EditModalLabel' aria-hidden='true'>

                                                <x-edit-modal>
                                                    <x-slot:titleeditModal>Tambah Project</x-slot:titleeditModal>
                                                    <section>
                                                        <form id='updateurl'
                                                            action='{{ route('inventaris-kibd.store') }}'
                                                            method='POST'>
                                                            @csrf
                                                            @method('POST')

                                                            {{-- blade-formatter-disable --}}
                                                        <x-inputallin>type:Nama Proyek:Nama Proyek:nama_proyek:id_nama_proyek:{{ $data->nama_ruangan }}:Required</x-inputallin>

                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <x-inputallin>date:Tanggal Mulai:Tanggal mulai project:tanggal_mulai:id_tanggal_mulai::Required</x-inputallin>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <x-inputallin>date:Tanggal Selesai:Tanggan selesai project:tanggal_selesai:id_tanggal_selesai::Required</x-inputallin>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <x-inputallin>type:Volum Pekerjaan:Volum:volum_pekerjaan:id_volum::Required</x-inputallin>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <x-inputallin>type:Status:Status proses pekerjaan:status:id_status_pengerjaan::Required</x-inputallin>
                                                                <p><b>Catatan :</b> Isikan persentasi proses pekerjaan</p>
                                                            </div>
                                                        </div>
                                                        <x-inputallin>type:Estimasi Anggaran / Perkiraan anggaran:Estimasi anggaran:estimasi_anggaran:id_estimasi_anggaran::Required</x-inputallin>
                                                        <x-inputallin>textarea:Lokasi:Lokasi Konstruksi:lokasi:id_lokasi::Required</x-inputallin>
                                                        <div class='form-group'>
                                                            <label for="keterangan_proyek">Keterangan Proyek</label>
                                                            <textarea name='keterangan_proyek' id='keterangan_proyek' rows='4' class='form-control' placeholder='Masukkan Keterangan Project Singkat'></textarea>
                                                        </div>
                                                            @php
                                                                $DataVendor = App\Models\Wakasarpras\Inventaris\InventarisVendor::orderBy('nama_vendor', 'ASC')->get();
                                                            @endphp
                                                            <div class="form-group">
                                                                <label for="vendor_data">Vendor</label>
                                                                <select id="vendor_data{{$data->id}}" class="form-control" name="vendor_id">
                                                                    <option value="">--- Pilih Vendor ----</option>
                                                                    @foreach ($DataVendor as $vendor)
                                                                        <option value="{{ $vendor->id }}"> {{ $vendor->nama_vendor }}</option>
                                                                    @endforeach
                                                                    <option value="lainnya">Lainnya (Tulis Vendor Baru)</option>
                                                                </select>
                                                            </div>
                                                        {{-- blade-formatter-enable --}}

                                                            <!-- Input Teks untuk Vendor Baru (Tersembunyi Awalnya) -->
                                                            {{-- blade-formatter-disable --}}
                                                            <div class="form-group" id="input_vendor_baru{{$data->id}}" style="display: none;">
                                                                <div class='card-header bg-primary'><h3 class='card-title'>Data Vendor Baru</h3></div>
                                                                <label for="vendor_baru">Nama Vendor Baru</label>
                                                                <input type="text" id="vendor_baru"  name="vendor_baru" class="form-control" placeholder="Masukkan Nama Vendor">
                                                                <label for="nama_kontak">Nama Kontak</label>
                                                                <input type="text" id="nama_kontak"  name="nama_kontak" class="form-control" placeholder="Masukkan Nama Kontak">
                                                                <label for="nomor_hp">Nomor HP Kontak</label>
                                                                <input type="text" id="nomor_hp"  name="nomor_hp" class="form-control" placeholder="Masukkan No HP Kontak">
                                                                <label for="alamat">Alamat</label>
                                                                <input type="text" id="alamat"  name="alamat" class="form-control" placeholder="Masukkan Alamat">
                                                                <label for="keterangan">Keterangan</label>
                                                                <input type="text" id="keterangan"  name="keterangan" class="form-control" placeholder="Masukkan Keterangan Singkat">
                                                            </div>
                                                            {{-- blade-formatter-enable --}}
                                                            <script>
                                                                $(document).ready(function() {
                                                                    // Event ketika pilihan vendor berubah
                                                                    $('#vendor_data{{ $data->id }}').on('change', function() {
                                                                        let selectedValue = $(this).val();
                                                                        if (selectedValue === 'lainnya') {
                                                                            $('#input_vendor_baru{{ $data->id }}').slideDown(); // Efek animasi muncul
                                                                            $('#vendor_baru').prop('required', true).focus(); // Fokus ke input
                                                                        } else {
                                                                            $('#input_vendor_baru{{ $data->id }}').slideUp();
                                                                            $('#vendor_baru').prop('required', false).val(""); // Reset input jika tidak diperlukan
                                                                        }
                                                                    });
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
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class='text-center align-middle'>
                                            <th>ID</th>
                                            <th>Data Ruangan</th>
                                            <th>Kondisi</th>
                                            <th>Panjang</th>
                                            <th>Lebar</th>
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

            <div class='ml-2 my-4'>
                <div class="card">
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>Data Inventaris KB D - Project Berjalan</h3>
                    </div>
                    <div class='card-body'>
                        {{-- Catatan :
                        - Include Komponen Modal CRUD + Javascript / Jquery
                        - Perbaiki Onclick Tombol Modal Create, Edit
                        - Variabel Active Crud menggunakan ID User
                         --}}
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
                                        <td colspan='9' class='text-center align-middle'> Tidak ada data peroses
                                            perbaikan dalam pengerjaan</td>
                                    </tr>
                                @else
                                    @foreach ($datas as $data)
                                        <tr>
                                            <td class='text-center'>{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $data->nama_proyek }}</td>
                                            <td class="text-center">{{ $data->lokasi }}
                                                {{ $data->Vendor->nama_vendor ?? 'Tidak Ada Vendor' }}
                                            </td>
                                            <td class="text-center">{{ $data->volum_pekerjaan }}</td>
                                            <td class="text-center">
                                                {{ Carbon::create($data->tanggal_mulai)->translatedformat('l, d F Y') }}
                                            </td>
                                            <td class="text-center">
                                                {{ Carbon::create($data->tanggal_mulai)->translatedformat('l, d F Y') }}
                                            </td>
                                            <td class="text-center">
                                                <span class="bg-info p-2 rounded-pill">{{ $data->status }} %</span>
                                            </td>
                                            <td class="text-center">Rp.
                                                {{ number_format($data->estimasi_anggaran, 2) }}</td>

                                            <td width='10%'>
                                                <div class='gap-1 d-flex justify-content-center'>

                                                    <!-- Button untuk melihat -->
                                                    <!-- <button type='button' class='btn btn-success btn-sm btn-equal-width' data-toggle='modal' data-target='#viewModal{{ $data->id }}'><i class='fa fa-eye'></i> Lihat</button> -->
                                                    <!-- Button untuk mengedit -->
                                                    <button type='button'
                                                        class='btn btn-warning btn-sm btn-equal-width'
                                                        data-toggle='modal'
                                                        data-target='#editModal{{ $data->id }}'><i
                                                            class='fa fa-edit'></i> </button>
                                                    <!-- Form untuk menghapus -->
                                                    <form id='delete-form-{{ $data->id }}'
                                                        action='{{ route('inventaris-kibd.destroy', $data->id) }}'
                                                        method='POST' style='display: inline-block;'>
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <button type='button' class='btn btn-danger btn-sm btn-equal-width'
                                                        onclick='confirmDelete({{ $data->id }})'> <i
                                                            class='fa fa-trash'></i> </button>

                                                </div>
                                            </td>
                                        </tr>
                                        {{-- Modal View Data Akhir --}}

                                        <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                            aria-labelledby='EditModalLabel' aria-hidden='true'>

                                            <x-edit-modal>
                                                <x-slot:titleeditModal>Edit Data Proyek KIB -
                                                    {{ $data->nama_proyek }}</x-slot:titleeditModal>
                                                <section>
                                                    <form id='updateurl'
                                                        action='{{ route('inventaris-kibd.update', $data->id) }}'
                                                        method='POST'>
                                                        @csrf
                                                        @method('PATCH')

                                                        {{-- blade-formatter-disable --}}
                                                        <x-inputallin>type:Nama Proyek:Nama Proyek:nama_proyek:id_nama_proyek:{{ $data->nama_proyek }}:Required</x-inputallin>
                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <x-inputallin>date:Tanggal Mulai:Tanggal mulai  project:tanggal_mulai:id_tanggal_mulai:{{ $data->tanggal_mulai }}:Required</x-inputallin>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <x-inputallin>date:Tanggal Selesai:Tanggan selesai project:tanggal_selesai:id_tanggal_selesai:{{ $data->tanggal_selesai }}:Required</x-inputallin>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <x-inputallin>type:Volum Pekerjaan:Volum:volum_pekerjaan:id_volum:{{ $data->volum_pekerjaan }}:Required</x-inputallin>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <x-inputallin>type:Status:Status proses pekerjaan:status:id_status_pengerjaan:{{ $data->status }}:Required</x-inputallin>
                                                                <p><b>Catatan :</b> Isikan persentasi proses pekerjaan
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <x-inputallin>type:Estimasi Anggaran / Perkiraan anggaran:Estimasi anggaran:estimasi_anggaran:id_estimasi_anggaran:{{ $data->estimasi_anggaran }}:Required</x-inputallin>
                                                        <x-inputallin>textarea:Lokasi:Lokasi  Konstruksi:lokasi:id_lokasi:{{ $data->lokasi }}:Required</x-inputallin>

                                                        <div class='form-group'>
                                                            <label for="keterangan_proyek">Keterangan Proyek</label>
                                                            <textarea name='keterangan_proyek' id='keterangan_proyek' rows='4' class='form-control' placeholder='Masukkan Keterangan Project Singkat'>{{ $data->keterangan_proyek }}</textarea>
                                                        </div>
                                                        {{-- Data Vendor --}}
                                                        <div class='card-header bg-primary my-2'>
                                                            <h3 class='card-title'>Data Vendor</h3>
                                                        </div>
                                                        @php
                                                            $DataVendor = App\Models\Wakasarpras\Inventaris\InventarisVendor::orderBy(
                                                                'nama_vendor',
                                                                'ASC',
                                                            )->get();
                                                        @endphp
                                                        <div class="form-group">
                                                            <label for="vendor_data">Vendor</label>
                                                            <select id="vendor_data_edit{{ $data->id }}" class="form-control" name="vendor_id">
                                                                <option value="">--- Pilih Vendor ----</option>
                                                                @foreach ($DataVendor as $vendor)
                                                                    <option value="{{ $vendor->id }}"> {{ $vendor->nama_vendor }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <script>
                                                            $(document).ready(function() {
                                                                // $('#semesteredit option[value='II']').prop('selected', true); // Single Select
                                                                $('#vendor_data{{ $data->id }}').val(@json($data->vendor_id)).trigger('change'); // Mutiple Select Select value in array json
                                                            });
                                                        </script>
                                                        <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'> Kirim</button>
                                                        {{-- blade-formatter-enable --}}
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
{{-- <button class='btn btn-warning btn-sm' onclick='TambahData()'><i class='fa fa-edit right'></i> Edit</button> --}}
{{--

 --}}

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

                <section>
                    <form id='updateurl' action='{{ route('inventaris-kibd.store') }}' method='POST'>
                        @csrf
                        @method('POST')

                        {{-- blade-formatter-disable --}}
                    <x-inputallin>type:Nama Proyek:Nama Proyek:nama_proyek:id_nama_proyek:{{ $data->nama_ruangan }}:Required</x-inputallin>

                    <div class="row">
                        <div class="col-xl-6">
                            <x-inputallin>date:Tanggal Mulai:Tanggal mulai project:tanggal_mulai:id_tanggal_mulai::Required</x-inputallin>
                        </div>
                        <div class="col-xl-6">
                            <x-inputallin>date:Tanggal Selesai:Tanggan selesai project:tanggal_selesai:id_tanggal_selesai::Required</x-inputallin>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <x-inputallin>type:Volum Pekerjaan:Volum:volum_pekerjaan:id_volum::Required</x-inputallin>
                        </div>
                        <div class="col-xl-6">
                            <x-inputallin>type:Status:Status proses pekerjaan:status:id_status_pengerjaan::Required</x-inputallin>
                            <p><b>Catatan :</b> Isikan persentasi proses pekerjaan</p>
                        </div>
                    </div>
                    <x-inputallin>type:Estimasi Anggaran / Perkiraan anggaran:Estimasi anggaran:estimasi_anggaran:id_estimasi_anggaran::Required</x-inputallin>
                    <x-inputallin>textarea:Lokasi:Lokasi Konstruksi:lokasi:id_lokasi::Required</x-inputallin>

                    <div class='form-group'>
                        <label for="keterangan_proyek">Keterangan Proyek</label>
                        <textarea name='keterangan_proyek' id='keterangan_proyek' rows='4' class='form-control' placeholder='Masukkan Keterangan Project Singkat'>{{$data->keterangan_proyek }}</textarea>
                    </div>
                        @php
                            $DataVendor = App\Models\Wakasarpras\Inventaris\InventarisVendor::orderBy('nama_vendor', 'ASC')->get();
                        @endphp
                        <div class="form-group">
                            <label for="vendor_data">Vendor</label>
                            <select id="vendor_datax" class="form-control" name="vendor_id">
                                <option value="">--- Pilih Vendor ----</option>
                                @foreach ($DataVendor as $vendor)
                                    <option value="{{ $vendor->id }}"> {{ $vendor->nama_vendor }}</option>
                                @endforeach
                                <option value="lainnya">Lainnya (Tulis Vendor Baru)</option>
                            </select>
                        </div>
                    {{-- blade-formatter-enable --}}

                        <!-- Input Teks untuk Vendor Baru (Tersembunyi Awalnya) -->
                        {{-- blade-formatter-disable --}}
                        <div class="form-group" id="input_vendor_barux" style="display: none;">
                            <div class='card-header bg-primary'><h3 class='card-title'>Data Vendor Baru</h3></div>
                            <label for="vendor_baru">Nama Vendor Baru</label>
                            <input type="text" id="vendor_baru"  name="vendor_baru" class="form-control" placeholder="Masukkan Nama Vendor">
                            <div class="row">
                                <div class="col-xl-6">
                                    <label for="nama_kontak">Nama Kontak</label>
                                    <input type="text" id="nama_kontak"  name="nama_kontak" class="form-control" placeholder="Masukkan Nama Kontak">

                                </div>
                                <div class="col-xl-6">
                                    <label for="nomor_hp">Nomor HP Kontak</label>
                                    <input type="text" id="nomor_hp"  name="nomor_hp" class="form-control" placeholder="Masukkan No HP Kontak"></div>
                            </div>
                            <label for="alamat">Alamat</label>
                            <input type="text" id="alamat"  name="alamat" class="form-control" placeholder="Masukkan Alamat">
                            <label for="keterangan">Keterangan Vendor</label>
                            <input type="textare" id="keterangan"  name="keterangan" class="form-control" placeholder="Masukkan Keterangan Singkat">
                        </div>
                        {{-- blade-formatter-enable --}}
                        <script>
                            $(document).ready(function() {
                                // Event ketika pilihan vendor berubah
                                $('#vendor_datax').on('change', function() {
                                    let selectedValue = $(this).val();
                                    if (selectedValue === 'lainnya') {
                                        $('#input_vendor_barux').slideDown(); // Efek animasi muncul
                                        $('#vendor_baru').prop('required', true).focus(); // Fokus ke input
                                    } else {
                                        $('#input_vendor_barux{{ $data->id }}').slideUp();
                                        $('#vendor_baru').prop('required', false).val(""); // Reset input jika tidak diperlukan
                                    }
                                });
                            });
                        </script>
                        <button id='kirim' type='submit'
                            class='btn float-right btn-default bg-primary btn-xl mt-4'>
                            Kirim</button>
                    </form>

                </section>
            </div>
        </div>
    </div>

</div>
