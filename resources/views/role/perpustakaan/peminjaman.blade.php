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
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2 mt-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->
            <div class="row m-2">
                <div class='col-xl-3'>
                    <form id='#id' action='' method='POST'>
                        @csrf
                        @method('POST')
                        {{-- blade-formatter-disable --}}
                        <div class='card-header bg-success my-4'><h3 class='card-title'><i class="fa fa-search mr-2"></i> Cari Data Siswa</h3></div>
                        <x-dropdown-allsiswa type='single' :listdata='$Siswas' label='Data Siswa' name='detailsiswa_id' id_property='id_single' />
                        <div class='form-group mt-2'>
                            <label for='buku_id'><i class="fa fa-book mr-2"></i> Buku</label>
                            <select id='select2-1' name='buku_id[]' class='form-control' multiple='multiple' data-placeholder='Pilih Buku' style='width: 100%;'required>
                                <option value=''>--- Pilih Buku ---</option>
                                @foreach ($buku_ids as $newdata_buku)
                                    <option value='{{ $newdata_buku->id }}'>{{ $newdata_buku->judul_buku }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type='submit' class='btn float-right btn-default bg-primary btn-md'> <i class="fa fa-save mr-2"></i> Simpan</button>
                        {{-- blade-formatter-enable --}}
                    </form>
                </div>
                <div class="col-xl-9">
                    <div class='card-header bg-primary my-4'>
                        <h3 class='card-title'><i class="fa fa-list mr-2"></i></h3> Riwayat Peminjaman Siswa
                    </div>
                    <table id="example3" class="table table-bordered table-hover">
                        <thead>
                            <tr class='text-center align-middle table-primary'>
                                {{-- <th>ID Peminjam</th> --}}
                                <th width='10%'>NIS</th>
                                <th>Judul Buku</th>
                                <th>Kategori</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- blade-formatter-disable --}}
            <script>
                $(document).ready(function () {
                var table;

                function initDataTable() {
                    if ($.fn.DataTable.isDataTable("#example3")) {
                        table.destroy(); // Hancurkan instance DataTable yang ada
                        $("#example3 tbody").empty(); // Kosongkan isi tabel sebelum reinit
                    }
                    table = $("#example3").DataTable({
                        responsive: true,
                        processing: true,
                        paging: true,
                        searching: true,
                        info: true
                    });
                }

                $.fn.dataTable.ext.errMode = 'none'; // Nonaktifkan warning DataTables

                // Inisialisasi DataTable pertama kali
                initDataTable();

                $('#single-single').on('change', function () {
                    var siswa_id = $(this).val();
                    console.log("siswa_id yang dipilih:", siswa_id);

                    if (siswa_id) {
                        $.ajax({
                            url: "{{ route('AjaxPeminjam', ':siswa_id') }}".replace(':siswa_id', siswa_id),
                            type: "GET",
                            dataType: "json",
                            success: function (response) {
                                console.log("Response dari server:", response);

                                if (!response || response.length === 0) {
                                    alert("Tidak ada data peminjaman untuk siswa ini.");
                                    return;
                                }

                                if (response.error) {
                                    alert(response.error);
                                    return;
                                }

                                // Hancurkan dan buat ulang DataTable
                                initDataTable();

                                // Tambahkan data baru ke DataTable
                                $.each(response, function (index, data) {
                                    table.row.add([
                                        data.siswa?.nis ?? '<span class="text-danger">Tidak ada NIS</span>', // Kolom NIS
                                        data.buku?.judul_buku ?? '<span class="text-danger">Tidak ada Buku</span>', // Kolom Judul Buku
                                        data.kategori_buku?.nama_kategori ?? '<span class="text-danger">Tidak ada Kategori</span>', // Kolom 4 - Nama Kategori
                                        data.status ?? '<span class="text-danger">Belum ada status</span>' // Kolom Status

                                    ]).draw();
                                });

                                table.draw(); // Render ulang tabel
                            },
                           error: function (xhr, status, error) {
                            console.error("AJAX Error Status:", status);
                            console.error("AJAX Error Response:", xhr.responseText);
                            console.error("AJAX Error Message:", error);
                            alert("Terjadi kesalahan saat mengambil data. Cek console untuk detailnya.");
                        }

                        });
                    }
                });
                });

            </script>
             {{-- blade-formatter-enable --}}
            <div class='ml-2 my-4'>
                <div class="row">
                    <div class="col-xl-8">
                        <div class='card-header bg-success my-2'>
                            <h3 class='card-title'>Riwayat Peminjaman</h3>
                        </div>
                        <table id='example2' width='100%' class='table table-responsive table-bordered table-hover'>
                            <thead>
                                <tr class='table-success text-center align-middle'>
                                    <th class='text-center align-middle' width='1%'>ID</th>
                                    @foreach ($arr_ths as $arr_th)
                                        <th class='text-center align-middle'> {{ $arr_th }}</th>
                                    @endforeach
                                    <th class='text-center align-middle'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataPeminjaman as $data)
                                    <tr>
                                        <td class='text-center'>{{ $loop->iteration }}</td>
                                        <td class='text-center'> {{ $data->siswa->nama_siswa ?? '' }}</td>
                                        <td class='text-center'> {{ $data->buku->judul_buku ?? '' }}</td>
                                        <td class='text-center'>
                                            {{ Carbon::create($data->tanggal_peminjaman)->translatedformat('l, d F Y') }}
                                        </td>
                                        <td class='text-center'>
                                            {{ Carbon::create($data->batas_pengembalian)->translatedformat('l, d F Y') }}
                                            {{-- / --}}
                                            {{-- {{ round($data->tanggal_peminjaman->diffInDays($data->batas_pengembalian)) }} --}}
                                        </td>
                                        {{-- <td class='text-center'> {{ $data->tanggal_pengembalian}}</td> --}}
                                        <td class='text-center'>
                                            @if ($data->status === 'terlambat')
                                                <span class="bg-danger p-2">{{ ucfirst($data->status) }}</span>
                                            @elseif($data->status === 'dikembalikan')
                                                <span class="bg-success p-2">{{ ucfirst($data->status) }}</span>
                                            @else
                                                <span class="bg-info p-2">{{ ucfirst($data->status) }}</span>
                                            @endif
                                        </td>
                                        <td width='20%'>
                                            <div class='gap-1 d-flex justify-content-center'>
                                                {{-- blade-formatter-disable --}}
                                                       <!-- Button untuk melihat -->
                                                       <!-- <button type='button' class='btn btn-success btn-sm btn-equal-width' data-toggle='modal' data-target='#viewModal{{ $data->id }}'><i class='fa fa-eye'></i> Lihat</button> -->
                                                       <!-- Button untuk mengedit -->
                                                       <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i></button>
                                                       <!-- Form untuk menghapus -->
                                                       <form action='{{ route('peminjaman-buku.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                           @csrf
                                                           @method('DELETE')
                                                           <button type='submit' class='btn btn-danger btn-sm btn-equal-width' onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');"><i class='fa fa-trash'></i></button>
                                                       </form>
                                                       {{-- blade-formatter-enable --}}
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- Modal View Data Akhir --}}
                                    <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                        aria-labelledby='EditModalLabel' aria-hidden='true'>
                                        <x-edit-modal>
                                            <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                            <section>
                                                {{-- blade-formatter-disable --}}
                                                <form id='updateurl'
                                                    action='{{ route('peminjaman-buku.update', $data->id) }}'
                                                    method='POST'>
                                                    @csrf
                                                    @method('PATCH')
                                                    @php
                                                    $status = ['dipinjam', 'dikembalikan', 'terlambat'];
                                                    @endphp

                                                    <div class='form-group'>
                                                        <label for='status'>Status Peminjaman</label>
                                                        <select name='status' class='select2 form-control' required>
                                                            <option value=''>--- Pilih Status Peminjaman --- </option>
                                                            @foreach ($status as $newkey)
                                                                <option value='{{ $newkey}}' @if($data->status === $newkey) selected @endif>{{ucfirst( $newkey) }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <button id='kirim' type='submit'
                                                        class='btn float-right btn-default bg-primary btn-xl mt-4'>
                                                        Kirim</button>
                                                </form>
                                                {{-- blade-formatter-enable --}}

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
                    <div class="col-xl-4">
                        <div class='card-header bg-danger my-2'>
                            <h3 class='card-title'> Data Peminjaman Limit Hari Ini</h3>
                        </div>
                        <table id='example1' width='100%' class='table table-bordered table-hover'>
                            <thead>
                                <tr class='text-center align-middle table-danger'>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Judul Buku</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- blade-formatter-disable --}}
                                @foreach ($dataPeminjaman as $data)
                                    @if (Carbon::create($data->batas_pengembalian)->translatedformat('l, d F Y') !== Carbon::create(now())->translatedformat('l, d F Y'))
                                    @else
                                        <tr>
                                            <td class='text-center'>{{ $loop->iteration }}</td>
                                            <td class='text-center'> {{ $data->siswa->nama_siswa }}</td>
                                            <td class='text-center'> {{ $data->buku->judul_buku }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                {{-- blade-formatter-enable --}}
                            </tbody>
                            <tfoot>
                                <tr class='text-center align-middle'>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Judul Buku</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
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
