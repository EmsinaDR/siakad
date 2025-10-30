<x-layout>
    @php
        $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
        $urlroot = app('request')->root();
    @endphp

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
            <div class='card-header bg-primary mx-2 mt-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->

            <div class='ml-2 my-4'>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="card-header bg-chocolate">
                            <H3 class="card-title">List Pembayaran</H3>
                        </div>
                        <div class="col-xl-12 d-flex m-2">
                            <button type='submit' onclick='TambahDataListKeuangan()' class='btn bg-success btn-md'><i
                                    class='fa fa-plus'></i> Tambah
                                Data</button>
                        </div>
                        <div class='card-body'>
                            <table id='example1' width='100%' class='table table-bordered table-hover'>
                                <thead>
                                    <tr class='text-center table-lightyellow align-middle'>
                                        <th class='align-middle' width='1%'>ID</th>
                                        <th class='align-middle' width='15%'>Kode</th>
                                        <th class='align-middle'>Jenis Pembayaran</th>
                                        <th class='align-middle' width='50%'>Keterangan</th>
                                        <th class='align-middle'>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $data)
                                        <tr>
                                            <td class='text-center'>{{ $loop->iteration }}</td>
                                            <td class='text-left'>{{ $data->singkatan }}</td>
                                            <td class='text-left'>{{ $data->jenis_pembayaran }}</td>
                                            <td class='text-left'>{{ $data->keterangan }}</td>
                                            <td>
                                                <div class='gap-1 d-flex justify-content-center'>
                                                    <!-- Button untuk mengedit -->
                                                    <button type='button' class='btn btn-chocolate btn-sm '
                                                        data-toggle='modal' data-target='#editModal{{ $data->id }}'>
                                                        <i class='fa fa-edit'></i>
                                                    </button>
                                                    <!-- Form untuk menghapus -->
                                                    <form action='{{ route('keuangan-list.destroy', $data->id) }}'
                                                        method='POST' style='display: inline-block;'>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type='submit' class='btn btn-danger btn-sm'
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                            <i class='fa fa-trash'></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        {{-- Modal View Data Akhir --}}
                                        <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                            aria-labelledby='EditModalLabel' aria-hidden='true'>
                                            <x-edit-modal>
                                                <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                <section>
                                                    <form id='updateEdata'
                                                        action='{{ route('keuangan-list.update', $data->id) }}'
                                                        method='POST'>
                                                        @csrf
                                                        @method('PATCH')
                                                        <x-inputallin>type:Singkatan / Kode:Singkatan atau
                                                            kode:singkatan:id_singkatan:{{ $data->singkatan }}:Required</x-inputallin>
                                                        <x-inputallin>type:Jenis Pembayaran:Jenis
                                                            Pembayaran:jenis_pembayaran:id_jenis_pembayaran:{{ $data->jenis_pembayaran }}:Required</x-inputallin>
                                                        <x-inputallin>textarea:Keterangan:Keterangan:keterangan:id_keterangan:{{ $data->keterangan }}:Required</x-inputallin>
                                                        {{-- <x-dropdown-materib>{{ mapel_id }}/{{ tingkat_id }}</x-dropdown-materib> --}}
                                                        {{-- <x-inputallin>date:Batas Waktu::deadline:edeadline:{{ $data->deadline }}:Disabled</x-inputallin> --}}
                                                        {{-- <x-inputallin>type:Placeholder::name:id:{{ $data->deadline }}:Disabled</x-inputallin> --}}

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
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class='text-center table-lightyellow align-middle'>
                                        <th class='align-middle'>ID</th>
                                        <th class='align-middle'>Kode</th>
                                        <th class='align-middle'>Jenis Pembayaran</th>
                                        <th class='align-middle'>Keterangan</th>
                                        <th class='align-middle'>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card-header bg-success">
                            <H3 class="card-title">List Pembayaran Aktif</H3>
                        </div>
                        <div class='col-lg-12 col-12'>
                            <!-- small box -->
                            <div class='small-box bg-warning '>
                                <h3 class='m-2 pt-2 text-shadow' style="text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);">
                                    Total Pembayaran</h3>
                                <hr class="border border-light border-2">
                                <div class='inner p-2'>
                                    <div class=" d-flex justify-content-between">
                                        <span>Total Kelas VII</span><span>Rp. {{ number_format($total_tingkat_a, 2) }}</span>
                                    </div>
                                    <div class=" d-flex justify-content-between">
                                        <span>Total Kelas VIII</span><span>Rp. {{ number_format($total_tingkat_b, 2) }}</span>
                                    </div>
                                    <div class=" d-flex justify-content-between">
                                        <span>Total Kelas IX</span><span>Rp. {{ number_format($total_tingkat_c, 2) }}</span>
                                    </div>
                                </div>

                                <div class='icon'>
                                    <i class='ion ion-person-add'></i>
                                </div>
                                {{-- <hr class="border border-light border-2"> --}}
                                <div class="col-xl-12 p-2 bg-success">
                                    <h5>Catatan : </h5>
                                    <p>
                                        {{-- blade-formatter-disable --}}
                                    <ul>
                                        <li>Total data ini berlaku untuk tahun pelajar pada semester aktif</li>
                                        <li>Bendahara menghitung pengeluaran siswa sebagai pemasukkan dalam setiap semester aktif</li>
                                        <li>Tombol :
                                            <ul>
                                                <li><i class='fa fa-copy'></i> Copy Data : berfungsi menggandakan data dari semester I ke semester II pada tahun pelajaran aktif</li>
                                                <li><i class='fa fa-undo'></i> Copy Data : berfungsi menggandakan data dari semester I ke semester II pada tahun pelajaran aktif/li>
                                            </ul>
                                        </li>
                                    </ul>
                                    {{-- blade-formatter-enable --}}
                                    </p>
                                </div>
                                {{-- <div class='small-box ml-2'>
                                    <p>Total data ini berlaku untuk tahun pelajar pada semester berjalan</p>
                                    <p>Bendahara menghitung pengeluaran siswa sebagai pemasukkan dalam setiap semester</p>
                                </div> --}}
                                {{-- <a href='#' class='small-box-footer'>More info <i
                                    class='fas fa-arrow-circle-right'></i></a> --}}
                            </div>
                            {{-- blade-formatter-disable --}}
                            <div class="col-xl-12 d-flex">
                                <form id='#id' action='{{ route('CopyKomite') }}' method='POST'>
                                    @csrf
                                    @method('POST')
                                    <button type='submit' class='btn bg-success btn-md  mx-1'><i class='fa fa-copy'></i> Copy Data</button>
                                </form>
                                <form id='#id' action='{{ route('ResetKomite') }}' method='POST'>
                                    @csrf
                                    @method('POST')
                                    <button type='submit' class='btn bg-success btn-md mx-1'><i class='fa fa-undo'></i>Reset Data</button>
                                </form>
                                <button type='submit' class='btn bg-success btn-md mx-1' onClick='ImportData()'><i  class='fa fa-file-import'></i> Import Data</button>
                                <button type='submit' class='btn bg-warning btn-md mx-1' onclick='InsertNominal()'><i class='fa fa-edit'></i>Insert Nominal</button>
                            </div>
                            {{-- blade-formatter-enable --}}
                        </div>
                        <div class='card-body'>

                            <table id='example2' width='100%' class='table table-bordered table-hover'>
                                <thead>
                                    <tr class='text-center table-success align-middle'>
                                        <th width='1%'>ID</th>
                                        <th>Tingkat</th>
                                        <th>Jenis Pembayaran</th>
                                        <th>Nominal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas_riwayats as $datas_riwayat)
                                        <tr>
                                            <td class='text-center'>{{ $loop->iteration }}</td>
                                            <td width='3%' class='text-center'>{{ $datas_riwayat->tingkat_id }}
                                            </td>
                                            <td class='text-left'>
                                                {{ $datas_riwayat->jenis_pembayaran }}
                                            </td>
                                            <td class='text-center'>
                                                @if ($datas_riwayat->nominal !== null)
                                                    Rp. {{ number_format($datas_riwayat->nominal, 2) }}
                                                @else
                                                @endif
                                            </td>

                                            <td>
                                                <div class='gap-1 d-flex justify-content-center'>
                                                    <!-- Button untuk melihat -->
                                                    <button type='button' class='btn btn-success btn-sm '
                                                        data-toggle='modal'
                                                        data-target='#viewModal{{ $datas_riwayat->id }}'>
                                                        <i class='fa fa-eye'></i>
                                                    </button>
                                                    <!-- Button untuk mengedit -->
                                                    <button type='button' class='btn btn-warning btn-sm '
                                                        data-toggle='modal'
                                                        data-target='#editModal{{ $datas_riwayat->id }}'>
                                                        <i class='fa fa-edit'></i>
                                                    </button>
                                                    <!-- Form untuk menghapus -->
                                                    <form
                                                        action='{{ route('keuangan-riwayat-list.destroy', $datas_riwayat->id) }}'
                                                        method='POST' style='display: inline-block;'>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type='submit' class='btn btn-danger btn-sm '
                                                            onclick="return confirm(' Apakah Anda yakin ingin menghapus data ini?');">
                                                            <i class='fa fa-trash'></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        {{-- Modal View Data Akhir --}}
                                        <div class='modal fade' id='editModal{{ $datas_riwayat->id }}'
                                            tabindex='-1' aria-labelledby='EditModalLabel' aria-hidden='true'>
                                            <x-edit-modal>
                                                <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                <section>
                                                    <form id='updateEdata'
                                                        action='{{ route('keuangan-riwayat-list.update', $datas_riwayat->id) }}'
                                                        method='POST'>
                                                        @csrf
                                                        @method('PATCH')
                                                        <x-inputallin>type:Jenis
                                                            Pembayaran:Placeholder:jenis_pembayaran:id_jenis_pembayaran:{{ $datas_riwayat->jenis_pembayaran }}:Required</x-inputallin>
                                                        <x-inputallin>type:Nominal:Nominal:nominal:id_nominal:{{ $datas_riwayat->nominal }}:Required</x-inputallin>
                                                        {{-- <x-dropdown-materib>{{ mapel_id }}/{{ tingkat_id }}</x-dropdown-materib> --}}
                                                        {{-- <x-inputallin>date:Batas Waktu::deadline:edeadline:{{ $data->deadline }}:Disabled</x-inputallin> --}}
                                                        {{-- <x-inputallin>type:Placeholder::name:id:{{ $data->deadline }}:Disabled</x-inputallin> --}}

                                                        <button id='kirim' type='submit'
                                                            class='btn float-right btn-default bg-primary btn-xl mt-4'>
                                                            Kirim</button>


                                                    </form>

                                                </section>
                                            </x-edit-modal>
                                        </div>
                                        {{-- Modal Edit Data Akhir --}}
                                        {{-- Modal View --}}
                                        <div class='modal fade' id='viewModal{{ $datas_riwayat->id }}'
                                            tabindex='-1' aria-labelledby='ViewModalLabel' aria-hidden='true'>

                                            <x-view-modal>
                                                <x-slot:titleviewModal>{{ $titleviewModal }}</x-slot:titleviewModal>
                                                <section>
                                                    ccc
                                                </section>
                                            </x-view-modal>
                                        </div>
                                        {{-- Modal View Akhir --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class='text-center table-success align-middle'>
                                        <th>ID</th>
                                        <th>Tingkat</th>
                                        <th>Jenis Pembayaran</th>
                                        <th>Nominal</th>
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
{{-- <button class='btn btn-warning btn-sm' onclick='ImportData()'><i class='fa fa-edit right'></i> Edit</button> --}}

<script>
    function ImportData(data) {
        var ImportData = new bootstrap.Modal(document.getElementById('ImportData'));
        ImportData.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='ImportData' tabindex='-1' aria-labelledby='LabelImportData' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelImportData'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <form id='#id' action='{{ route('keuangan-riwayat-list.store') }}' method='POST'>
                    @csrf
                    @method('POST')
                    <div class='form-group'>
                        @php
                            $tingkat = [7, 8, 9];
                        @endphp
                        <label for='id_name'>Tingkat Kelas</label>
                        <select id='tingkat_id' name='tingkat_id' class='form-control' style='width: 100%;'>
                            <option value=''>--- Pilih Tingkat ---</option>
                            @foreach ($tingkat as $list)
                                <option value='{{ $list }}'>{{ $list }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='form-group'>
                        <label for='id_name'>Jenis Pembayaran</label>
                        <select id='select1' class='select2' name='jenis_pembayaran[]' multiple='multiple'
                            data-placeholder='Pilih Jenis Pembayaran' style='width: 100%;'>
                            <option value=''>--- Pilih Pembayaran ---</option>
                            @foreach ($datas as $list)
                                <option value='{{ $list->jenis_pembayaran }}'>{{ $list->jenis_pembayaran }}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
            </div>
            </form>
        </div>
    </div>

</div>
<button class='btn btn-warning btn-sm' onclick='InsertNominal()'><i class='fa fa-edit right'></i> Edit</button>

<script>
    function InsertNominal(data) {
        var InsertNominal = new bootstrap.Modal(document.getElementById('InsertNominal'));
        InsertNominal.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='InsertNominal' tabindex='-1' aria-labelledby='LabelInsertNominal' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelInsertNominal'>
                    Data Nominal Pembayaran
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <div class='card'>
                    <div class='card-header bg-warning'>
                        <h3 class='card-title'><i class='fas fa-text-width pl-3'></i>Informasi Pengisian Nominal</h3>
                    </div><!-- /.card-header -->
                    <div class='card-body'>
                        <ul>
                            <ol>Pembayaran sifatnya global, bukan pembayaran berulang</ol>
                            <ol>ika sifatnya berulang seperti SPP maka harus dikalikan 6 terlebih dahulu jadi misalkan perbulan 35.000, maka 35.000 x 6 = 210000. <br>Masukkan Rp. 210.000</ol>
                        </ul>
                    </div><!-- /.card-body -->
                </div>
                <form id='#id' action='{{ route('BulkUpdate') }}' method='POST'>
                    @csrf
                    @method('POST')
                    <div class='form-group' id='tingkat_data'>
                        @php
                            $key = [7, 8, 9];
                        @endphp
                        <label for='tingkat_id'>Tingkat</label>
                        <select id='tingkat_id_nominal' name='tingkat_id' class='form-control' required>
                            <option value=''>--- Pilih Tingkat ---</option>
                            @foreach ($key as $newkey)
                                <option value='{{ $newkey }}'>{{ $newkey }}</option>
                            @endforeach
                        </select>
                    </div>
                    <table id="example1" width="100%" class="table table-bordered table-hover">
                        <thead>
                            <tr class="text-center align-middle">
                                <th width='1%'>ID</th>
                                <th>Jenis Pembayaran</th>
                                <th>Nominal</th>
                            </tr>
                        </thead>
                        <tbody id="tdcontent"></tbody>
                        <tfoot>
                            <tr class="text-center align-middle">
                                <th>ID</th>
                                <th>Jenis Pembayaran</th>
                                <th>Nominal</th>
                            </tr>
                        </tfoot>
                    </table>
                    <script>
                        $('#tingkat_id_nominal').on('change', function() {
                            var tingkat_id_nominal = $(this).val();
                            if (tingkat_id_nominal) {
                                $.ajax({
                                    url: '/get-pembayaran-komite/' + tingkat_id_nominal,
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function(data) {
                                        if (data && data.length > 0) {
                                            $('#tdcontent')
                                                .empty(); // Hapus semua baris sebelumnya untuk menghindari duplikasi
                                            data.forEach((item, index) => {
                                                // Ganti null atau undefined menjadi 0
                                                let nominalValue = item.nominal ??
                                                    0; // Menggunakan nullish coalescing
                                                $('#example1 #tdcontent').append(`
                                                    <tr>
                                                        <td class="text-center">${index + 1}<input name="id[]" class="form-control mb-2" value="${item.id}" hidden></td>
                                                        <td class="text-left"><input name="jenis_pembayaran[]" class="form-control mb-2" value="${item.jenis_pembayaran}" hidden>${item.jenis_pembayaran}</td>
                                                        <td width="35%" class="text-center"><input name="nominal[]" class="form-control mb-2" value="${nominalValue}"></td>
                                                    </tr>
                                                `);
                                            });
                                        } else {
                                            alert("Data kosong.");
                                        }
                                    },
                                    error: function() {
                                        alert("Terjadi kesalahan saat mengambil data siswa.");
                                    },
                                });
                            } else {
                                $('#tdcontent').empty(); // Kosongkan tabel jika tidak ada ID yang dipilih
                            }
                        });
                    </script>

                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>
// <button class='btn btn-warning btn-sm'><i class='fa fa-edit right'></i> Edit</button>

<script>
    function TambahDataListKeuangan(data) {
        var TambahDataListKeuangan = new bootstrap.Modal(document.getElementById('TambahDataListKeuangan'));
        TambahDataListKeuangan.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='TambahDataListKeuangan' tabindex='-1' aria-labelledby='LabelTambahDataListKeuangan'
    aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelTambahDataListKeuangan'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <form id='#id' action='{{ route('keuangan-list.store') }}' method='POST'>
                    @csrf
                    @method('POST')
                    <input type='hidden' name='kategori' id='kategori' value='komite'>
                    <x-inputallin>type:Kode / Singkatan:Contoh -> ATK untuk Alat
                        Tulis:singkatan:singkatan::Required</x-inputallin>
                    <x-inputallin>type:Jenis Pembayaran:Jenis Pembayaran ->
                        SPP:jenis_pembayaran:id_jenis_pembayaran::Required</x-inputallin>
                    <x-inputallin>textarea:Keterangan:Keterangan Sebagai
                        pengingat:keterangan:id_keterangan::Required</x-inputallin>

                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>
