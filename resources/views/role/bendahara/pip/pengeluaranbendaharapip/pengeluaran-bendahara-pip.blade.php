@php
    //content
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
            <!--Card Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</h3>
            </div>
            <!--Card Header-->
            <div class='row m-2'>
                {{-- blade-formatter-disable --}}
                <div class='col-xl-2'>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#DataPengeluaranPIP'><i class='fa fa-plus'></i> Tambah Pengeluaran</button>
                </div>
                {{-- blade-formatter-enable --}}
                <div class='col-xl-10'>
                   <div class='alert alert-success alert-dismissible'>
                   <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                   <h5><i class='icon fas fa-info-circle'></i> Informasi !</h5><hr>
                   <p>Jika tombol tidak muncul ini karena lintas pembayaran, dengan kata lain pembayaran masuk ke bagian lain sehingga tidak bisa di hapus dan diubah.</p>
                   </div>

                </div>
            </div>
            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
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
                                        <td class='text-center'>
                                            {{ Carbon::create($data->tanggal_pengeluaran)->translatedformat('l, d F Y') }}
                                        </td>
                                        <td class='text-center'> {{ $data->Siswa->nama_siswa }}</td>
                                        <td class='text-center'> Rp. {{ number_format($data->pengeluaran, 2) }}</td>
                                        <td class='text-left'> {{ $data->tujuan_penggunaan }}</td>

                                        <td width='10%'>
                                            @if ($data->is_transfer === 1)
                                            @else
                                                {{-- blade-formatter-disable --}}
                                                   <div class='gap-1 d-flex justify-content-center'>
                                                       <!-- Button untuk mengedit -->
                                                       <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i> </button>
                                                       <!-- Form untuk menghapus -->
                                                       <form id='delete-form-{{ $data->id }}' action='{{ route('pengeluaran-pip.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                           @csrf
                                                           @method('DELETE')
                                                       </form>
                                                       <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i>  </button>
                                                   </div>
                                                   {{-- blade-formatter-enable --}}
                                                {{-- Modal View Data Akhir --}}
                                            @endif

                                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                                aria-labelledby='EditModalLabel' aria-hidden='true'>

                                                <x-edit-modal>
                                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                    <section>
                                                        <form id='updateurl'
                                                            action='{{ route('pengeluaran-pip.update', $data->id) }}'
                                                            method='POST'>
                                                            @csrf
                                                            @method('PATCH')

                                                            contentEdit

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
                                        </td>
                                    </tr>
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

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='DataPengeluaranPIP' tabindex='-1' aria-labelledby='LabelData PengeluaranPIP'
    aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelData PengeluaranPIP'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('pengeluaran-pip.store') }}">
    @csrf
    <div class='modal-body'>
        <div class='form-group'>
            <label for='detailsiswa_id'>Nama Siswa</label>
            <select name='detailsiswa_id' id='detailsiswa_id' class='form-control' required>
                <option value=''>--- Pilih Nama Siswa ---</option>
                @foreach ($DataPenerimaPIP as $Siswa)
                    <option value='{{ $Siswa->detailsiswa_id }}'>{{ $Siswa->Siswa->nama_siswa }}</option>
                @endforeach
            </select>
        </div>

        <div class='form-group'>
            <i class="fa fa-hand-holding-usd mr-2"></i>
            <label for='jenis_pembayaran'>Jenis Pembayaran</label>
            <select name='pembayaran_id' id='jenis_pembayaran' class='select2 form-control' disabled required>
                <!-- Diisi via AJAX -->
            </select>

            <!-- Input untuk jenis pembayaran manual ketika memilih "Lainnya" -->
            <div id="jenis_pembayaran_manual" class="form-group" style="display: none;">
                <label for="jenis_pembayaran_other">Jenis Pembayaran (Manual)</label>
                <input type="text" name="jenis_pembayaran_other" id="jenis_pembayaran_other" class="form-control" placeholder="Masukkan jenis pembayaran">
            </div>
        </div>

        <i class="fa fa-dollar-sign mr-2"></i>
        <x-inputallin>type:Nominal:Rp. 50.0000:nominal:id_nominal::disabled</x-inputallin>

        <i class="fa fa-info-circle mr-2 mt-2"></i>
        <x-inputallin>textarea:Keterangan:Keterangan pembayaran jika ada:keterangan:id_keterangan::disabled</x-inputallin>

        <div class="form-group form-check mt-3">
            <input type="checkbox" class="form-check-input" id="kirim_wa" name="kirim_wa" value="1">
            <label class="form-check-label" for="kirim_wa">
                <i class="fa fa-whatsapp text-success mr-1"></i> Centang jika ingin mengirim notifikasi ke WhatsApp
            </label>
        </div>
    </div>

    <div class='modal-footer'>
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
        <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
    </div>
</form>

{{-- blade-formatter-enable --}}
<script>
    $(document).ready(function() {
        $('#detailsiswa_id').on('change', function() {
            var siswaId = $(this).val();
            $('#jenis_pembayaran').empty();
            $('#jenis_pembayaran_manual').hide();  // Sembunyikan input manual

            if (siswaId) {
                $.ajax({
                    url: '/get-siswa/' + siswaId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data && data.detailsiswatokelas) {
                            $('#kelas').val(data.detailsiswatokelas.kelas || '');
                            $('#tingkat_id').val(data.detailsiswatokelas.tingkat_id || '');
                            $('#nis').val(data.nis || '');

                            $('#jenis_pembayaran').prop('disabled', false);
                            $('#id_nominal').prop('disabled', false);
                            $('#id_keterangan').prop('disabled', false);

                            // AJAX kedua: ambil jenis pembayaran berdasarkan tingkat_id
                            $.ajax({
                                url: '/get-pembayaran-komite/' + data.detailsiswatokelas.tingkat_id,
                                type: 'GET',
                                dataType: 'json',
                                success: function(pembayaranData) {

                                    function formatRupiah(angka) {
                                        return new Intl.NumberFormat('id-ID').format(angka);
                                    }

                                    $('#jenis_pembayaran').empty();
                                    $('#jenis_pembayaran').append('<option value="">Pilih Jenis Pembayaran</option>');

                                    pembayaranData.forEach(item => {
                                        $('#jenis_pembayaran').append(
                                            `<option value="${item.id}">
                                                ${item.jenis_pembayaran} (Rp. ${formatRupiah(item.nominal)})
                                            </option>`
                                        );
                                    });

                                    // Tambahkan pilihan "Lainnya"
                                    $('#jenis_pembayaran').append(
                                        `<option value="lainnya">Lainnya (Tulis manual)</option>`
                                    );
                                },
                                error: function() {
                                    alert('Gagal mengambil data jenis pembayaran.');
                                }
                            });
                        } else {
                            $('#kelas').val('');
                            $('#tingkat_id').val('');
                            $('#nis').val('');
                            alert('Data siswa tidak ditemukan atau belum lengkap.');
                        }
                    },
                    error: function() {
                        alert('Gagal mengambil data siswa.');
                    }
                });
            } else {
                $('#kelas').val('');
                $('#tingkat_id').val('');
                $('#nis').val('');
            }
        });

        // Menampilkan input manual jika memilih "Lainnya"
        $('#jenis_pembayaran').on('change', function() {
            if ($(this).val() == 'lainnya') {
                $('#jenis_pembayaran_manual').show();
            } else {
                $('#jenis_pembayaran_manual').hide();
            }
        });
    });
</script>


        </div>
    </div>

</div>
