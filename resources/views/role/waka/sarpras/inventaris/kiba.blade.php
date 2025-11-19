@php
    //kib A
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
                <h3 class='card-title'>{{ $title }} : Tanah</H3>
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
                        <h3 class='card-title'>Data Inventaris KIB A</h3>
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
                                @if ($datas->isEmpty())
                                    <tr>
                                        <td class="text-center" colspan='6'>Data tidak ditemukan</td>
                                    </tr>
                                @else
                                    @foreach ($datas as $data)
                                        <tr>
                                            <td class='text-center'>{{ $loop->iteration }}</td>
                                            <td class='text-center'>
                                                @if (empty($data->nama_barang) && !isset($data->nama_barang))
                                                    {{ $data->DataBarang->nama_barang }}
                                                @else
                                                    {{ $data->nama_barang }}
                                                @endif


                                            </td>
                                            <td class='text-center'> {{ $data->letak }}</td>
                                            <td class='text-center'> {{ number_format($data->luas, 0) }} m²</td>
                                            {{-- number_format(data, 2) --}}

                                            <td class='text-center'> {{ $data->tahun_masuk }}</td>
                                            <td class='text-center'> {{ $data->penggunaan }}</td>

                                            <td width='20%'>
                                                <div class='gap-1 d-flex justify-content-center'>

                                                    <!-- Button untuk melihat -->
                                                    <!-- <button type='button' class='btn btn-success btn-sm btn-equal-width' data-toggle='modal' data-target='#viewModal{{ $data->id }}'><i class='fa fa-eye'></i> Lihat</button> -->
                                                    <!-- Button untuk mengedit -->
                                                    <button type='button'
                                                        class='btn btn-warning btn-sm btn-equal-width'
                                                        data-toggle='modal'
                                                        data-target='#editModal{{ $data->id }}'><i
                                                            class='fa fa-edit'></i> Edit</button>
                                                    <!-- Form untuk menghapus -->
                                                    <form id='delete-form-{{ $data->id }}'
                                                        action='{{ route('inventaris-kiba.destroy', $data->id) }}'
                                                        method='POST' style='display: inline-block;'>
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <button type='button' class='btn btn-danger btn-sm btn-equal-width'
                                                        onclick='confirmDelete({{ $data->id }})'> <i
                                                            class='fa fa-trash'></i> Hapus </button>

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
                                                        action='{{ route('inventaris-kiba.update', $data->id) }}'
                                                        method='POST'>
                                                        @csrf
                                                        @method('PATCH')

                                                        {{-- Input Fields --}}
                                                        {{-- blade-formatter-disable --}}
                                                        <x-inputallin>type:Nama Barang:Nama Barang:nama_barang:id_nama_barang:{{ $data->nama_barang }}:Required</x-inputallin>
                                                        <x-inputallin>textarea:Letak:Letak Tanah:letak:id_letak:{{ $data->letak }}:Required</x-inputallin>
                                                        <x-inputallin>type:Luas Tanah dalam (m²):Luas Tanah:luas:id_luas:{{ $data->luas }}:Required</x-inputallin>
                                                        <x-inputallin>type:Tahun Penerimaan:TahunPenerimaan:tahun_masuk:id_tahun_masuk:{{ $data->tahun_masuk }}:Required</x-inputallin>
                                                        <x-inputallin>type:Penggunaan:Penggunaan:penggunaan:id_penggunaan:{{ $data->penggunaan }}:Required</x-inputallin>

                                                        @php
                                                        $hak_barang = ['Milik', 'Sewa', 'Hibah', 'Pinjaman', 'Guna Pakai'];
                                                        @endphp
                                                        {{-- blade-formatter-enable --}}


                                                        {{-- blade-formatter-disable --}}
                                                        <div class='form-group mt-2'>
                                                            <label for='status_hak_{{ $data->id }}'>Hak Kepemilikan</label>
                                                            <select class="select2-dropdown status-hak" name='status_hak' style='width: 100%;' data-id="{{ $data->status_hak }}">
                                                                <option value=''>--- Pilih Hak Kepemilikan ---</option>
                                                                @foreach ($hak_barang as $newhak_barang)
                                                                    <option value='{{ $newhak_barang }}'
                                                                        @if ($data->status_hak == $newhak_barang) selected @endif>
                                                                        {{ $newhak_barang }}
                                                                    </option>
                                                                @endforeach
                                                                <option value="lainnya">Pilih Lainnya...</option>
                                                            </select>
                                                            <!-- Input tambahan untuk pilihan lainnya -->
                                                            <input type="text" class="form-control mt-2 input-lainnya" name="status_hak_lainnya" placeholder="Masukkan Hak Kepemilikan" style="display: none;">
                                                        </div>
                                                       {{-- blade-formatter-enable --}}

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


                                                        <button id='kirim' type='submit'
                                                            class='btn float-right btn-default bg-primary btn-xl mt-4'>
                                                            Kirim
                                                        </button>
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
