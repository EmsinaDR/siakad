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
                <div class='col-xl-2'>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal'
                        data-target='#PembayaranKomite'><i class='fa fa-plus'></i> Transfer Pembayaran</button>

                </div>
                <div class='col-xl-10'></div>
            </div>
            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <!-- Konten -->
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        <td class='text-center'>{{ $loop->iteration }}</td>
                                        @php
                                            //Menghitung pembayaran di tiap tingkat
                                            $total_pembayaran_tingkat = App\Models\Bendahara\KeuanganRiwayatList::where(
                                                'id',
                                                $data->pembayaran_id,
                                            )->first();
                                        @endphp
                                        <td class='text-center'> {{ $total_pembayaran_tingkat->jenis_pembayaran }}</td>
                                        <td class='text-center'> {{ $data->Siswa->nama_siswa }}</td>
                                        <td class='text-center'>
                                            Rp. {{ number_format($data->nominal, 2) }}
                                        </td>
                                        <td class='text-center'>
                                            @if ($data->status === 'Pending')
                                                <span class="p-2 bg-primary rounded-pill">{{ $data->status }}</span>
                                            @elseif($data->status === 'Success')
                                                <span class="p-2 bg-success rounded-pill">{{ $data->status }}</span>
                                            @else
                                                <span class="p-2 bg-danger rounded-pill">{{ $data->status }}</span>
                                            @endif
                                        <td class='text-center'> {{ $data->keterangan }}</td>

                                        <td width='10%'>
                                            <div class='gap-1 d-flex justify-content-center'>
                                                @if ($data->status === 'Success')
                                                @else
                                                    <!-- Button untuk mengedit -->
                                                    <button type='button'
                                                        class='btn btn-warning btn-sm btn-equal-width'
                                                        data-toggle='modal'
                                                        data-target='#editModal{{ $data->id }}'><i
                                                            class='fa fa-edit'></i> </button>
                                                    <!-- Form untuk menghapus -->
                                                    <form id='delete-form-{{ $data->id }}'
                                                        action='{{ route('transfer-pembayaran.destroy', $data->id) }}'
                                                        method='POST' style='display: inline-block;'>
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <button type='button' class='btn btn-danger btn-sm btn-equal-width'
                                                        onclick='confirmDelete({{ $data->id }})'> <i
                                                            class='fa fa-trash'></i> </button>
                                                @endif
                                            </div>
                                            {{-- Modal View Data Akhir --}}

                                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                                aria-labelledby='EditModalLabel' aria-hidden='true'>

                                                <x-edit-modal>
                                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                    <section>
                                                        <form id='updateurl'
                                                            action='{{ route('transfer-pembayaran.update', $data->id) }}'
                                                            method='POST'>
                                                            @csrf
                                                            @method('PATCH')
                                                            @php
                                                                // Asumsi $DataStatus adalah array yang berisi beberapa ID terpilih
                                                                $DataStatus = ['Pending', 'Success']; // pastikan ini adalah array
                                                            @endphp
                                                            <select name='status' class='form-control'
                                                                style='width: 100%;'>
                                                                @foreach ($DataStatus as $Status)
                                                                    <option value='{{ $Status }}'
                                                                        @if ($Status === $data->status) selected @endif>
                                                                        {{ $Status }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <input type='text' name='keterangan' id='keterangan'
                                                                placeholder='keterangan'
                                                                value='Telah diterima dari {{ $data->GuruPerantara->nama_guru }}'>


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
<div class='modal fade' id='PembayaranKomite' tabindex='-1' aria-labelledby='LabelPembayaranKomite' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelPembayaranKomite'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <form id='form-komite' action='{{ route('transfer-pembayaran.store') }}' method='POST'>
                    @csrf
                    @method('POST')
                        {{-- blade-formatter-disable --}}
                                <div class='form-group'>
                                    @php
                                        $siswas = App\Models\User\Siswa\Detailsiswa::orderby('kelas_id', 'ASC')->get();
                                        $sumberdanas = ['PIP', 'Tabungan'];
                                    @endphp
                                    <i class="fa fa-user mr-2"></i><label for='detailsiswa_id'>Nama Siswa</label>
                                    <select name='detailsiswa_id' id='detailsiswa_id' class='select2 form-control' required>
                                        <option value=''>--- Pilih Nama Siswa ---</option>
                                        @foreach ($siswas as $siswa)
                                            <option value='{{ $siswa->id }}'>{{ $siswa->Detailsiswatokelas->kelas }} - {{ $siswa->nama_siswa }}</option>
                                        @endforeach
                                    </select>
                                </div><div class='form-group'>
                                    <label for='sumber_dana'>Sumber Dana</label>
                                    <select name='sumber_dana' id='id' class='form-control' required>
                                        <option value=''>--- Pilih Sumber Dana ---</option>
                                        @foreach ($sumberdanas as $sumberdana)
                                            <option value='{{ $sumberdana }}'>{{ $sumberdana }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class='form-group'>
                                    <i class="fa fa-user-tag mr-2"></i><label for="nis">NIS</label>
                                    <input type="text" id="nis" name="nis" class="form-control" readonly>
                                </div>
                                <div class='form-group'>
                                    <i class="fa fa-layer-group mr-2"></i><label for="kelas">Kelas</label>
                                    <input type="text" id="kelas" name="kelas" class="form-control" readonly>
                                </div>
                                <div class='form-group'>
                                    <i class="fa fa-graduation-cap mr-2"></i><label for="kelas">Tingkat</label>
                                    <input type="text" id="tingkat_id" name="tingkat_id" class="form-control" readonly>
                                </div>
                                @php
                                    $lists_pembayaran_Komite = App\Models\Bendahara\KeuanganList::where('kategori','komite')->get();
                                @endphp
                                @php
                                    $data_list = App\Models\Bendahara\KeuanganList::get();
                                @endphp
                                <div class='form-group'>
                                    <i class="fa fa-hand-holding-usd mr-2"></i>
                                    <label for='jenis_pembayaran'>Jenis Pembayaran</label>
                                    <select name='pembayaran_id' id='jenis_pembayaran' class='select2 form-control' disabled>
                                    </select>
                                </div>
                                <i class="fa fa-dollar-sign mr-2"></i><x-inputallin>type:Nominal:Rp. 50.0000:nominal:id_nominal::disabled</x-inputallin>
                                <i class="fa fa-info-circle mr-2 mt-2"></i><x-inputallin>textarea:Keterangan:Keterangan pembaaran jika ada:keterangan:id_keterangan::disabled</x-inputallin>
                                <div class="form-group form-check mt-3">
                                    <input type="checkbox" class="form-check-input" id="kirim_wa" name="kirim_wa" value="1">
                                    <label class="form-check-label" for="kirim_wa">
                                        <i class="fa fa-whatsapp text-success mr-1"></i> Centang jika ingin mengirim notifikasi ke WhatsApp
                                    </label>
                                </div>

                                {{-- blade-formatter-enable --}}
                        <script>
                            $(document).ready(function() {
                                $('#detailsiswa_id').on('change', function() {
                                    var siswaId = $(this).val();
                                    $('#jenis_pembayaran').empty();

                                    if (siswaId) {
                                        $.ajax({
                                            url: '/get-siswa/' + siswaId,
                                            type: 'GET',
                                            dataType: 'json',
                                            success: function(data) {
                                                if (data) {
                                                    $('#kelas').val(data.detailsiswatokelas.kelas || '');
                                                    $('#tingkat_id').val(data.detailsiswatokelas.tingkat_id || '');
                                                    $('#nis').val(data.nis || '');

                                                    $('#jenis_pembayaran').prop('disabled', false);
                                                    $('#id_nominal').prop('disabled', false);
                                                    $('#id_keterangan').prop('disabled', false);

                                                    // AJAX kedua untuk ambil jenis pembayaran
                                                    $.ajax({
                                                        url: '/get-pembayaran-komite/' + data
                                                            .detailsiswatokelas.tingkat_id,
                                                        type: 'GET',
                                                        dataType: 'json',
                                                        success: function(pembayaranData) {

                                                            // Fungsi untuk format angka ke Rupiah (misal: 44000 ➝ 44.000)
                                                            function formatRupiah(angka) {
                                                                return new Intl.NumberFormat('id-ID')
                                                                    .format(angka);
                                                            }

                                                            // Kosongkan dulu select-nya biar nggak numpuk
                                                            $('#jenis_pembayaran').empty();

                                                            // Tambahkan satu opsi default (optional)
                                                            $('#jenis_pembayaran').append(
                                                                '<option value="">Pilih Jenis Pembayaran</option>'
                                                            );

                                                            // Loop data dan masukkan option ke select
                                                            pembayaranData.forEach(item => {
                                                                $('#jenis_pembayaran').append(
                                                                    `<option value="${item.id}">
                                                                                ${item.jenis_pembayaran} ( Rp. ${formatRupiah(item.nominal)} )
                                                                            </option>`
                                                                );
                                                            });
                                                        },
                                                        error: function() {
                                                            alert('Gagal ambil data pembayaran.');
                                                        }
                                                    });

                                                } else {
                                                    $('#kelas').val('');
                                                    $('#nis').val('');
                                                }
                                            },
                                            error: function() {
                                                alert('Gagal ambil data siswa.');
                                            }
                                        });
                                    } else {
                                        $('#kelas').val('');
                                        $('#nis').val('');
                                    }
                                });
                            });
                        </script>

                        {{-- blade-formatter-disable --}}
                                <div class="col-12">
                                    <button type='submit' class='btn btn-default bg-primary btn-xl float-right mt-4'>Simpan</button>
                                </div>
                                {{-- blade-formatter-enable --}}
                </form>
            </div>

        </div>
    </div>

</div>

{{-- <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'><i class='fa fa-plus'></i> Dokumen Siswa</button> --}}
{{--
onclick='TambahData()'
<button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#TambahData'><i class='fa fa-plus'></i> Dokumen Siswa</button>
 --}}
