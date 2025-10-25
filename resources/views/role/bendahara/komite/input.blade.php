<x-layout>
    @php
        $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
        $urlroot = app('request')->root();
    @endphp
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
        {{-- <div class='card'> --}}
        {{-- Papan Informasi --}}

        {{-- Papan Informasi --}}

        <!--Car Header-->
        <div class='card-header bg-primary mx-2'>
            <h3 class='card-title'>{{ $title }}</H3>
        </div>
        <!--Car Header-->

        <div class='ml-2 my-4'>
            <div class="row">
                <div class="col-xl-3">
                    <div class="card">
                        <div class="card-header bg-primary m-2">
                            <h3 class="card-title">Pembayaran</h3>
                        </div>
                        <div class='card-body'>
                            <form id='form-komite' action='{{ route('dasboard-komite.store') }}' method='POST'>
                                @csrf
                                @method('POST')

                                {{-- blade-formatter-disable --}}
                                <div class='form-group'>
                                    @php
                                        $siswas = App\Models\User\Siswa\Detailsiswa::orderby('kelas_id', 'ASC')->get();
                                    @endphp
                                    <i class="fa fa-user mr-2"></i><label for='detailsiswa_id'>Nama Siswa</label>
                                    <select name='detailsiswa_id' id='detailsiswa_id' class='select2 form-control' required>
                                        <option value=''>--- Pilih Nama Siswa ---</option>
                                        @foreach ($siswas as $siswa)
                                            <option value='{{ $siswa->id }}'>{{ $siswa->Detailsiswatokelas->kelas }} - {{ $siswa->nama_siswa }}</option>
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
                                                                url: '/get-pembayaran-komite/' + data.detailsiswatokelas.tingkat_id,
                                                                type: 'GET',
                                                                dataType: 'json',
                                                                success: function(pembayaranData) {

                                                                    // Fungsi untuk format angka ke Rupiah (misal: 44000 ➝ 44.000)
                                                                    function formatRupiah(angka) {
                                                                        return new Intl.NumberFormat('id-ID').format(angka);
                                                                    }

                                                                    // Kosongkan dulu select-nya biar nggak numpuk
                                                                    $('#jenis_pembayaran').empty();

                                                                    // Tambahkan satu opsi default (optional)
                                                                    $('#jenis_pembayaran').append('<option value="">Pilih Jenis Pembayaran</option>');

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
                <div class="col-xl-9">
                    <div class="card">
                        <div class="card-header bg-primary m-2">
                            <h3 class="card-title">Riwayat Pembayaran Terakhir</h3>
                        </div>
                        <div class='card-body'>
                            <table id='example1' width='100%' class='table table-bordered table-hover'>
                                <thead>
                                    <tr class='text-center table-primary align-middle'>
                                        <th width='1%'>ID</th>
                                        <th>No Transaksi</th>
                                        <th>Jenis Pembayaran</th>
                                        <th>Nama Siswa</th>
                                        <th>Nominal</th>
                                        <th>Checklist</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $data)
                                        <tr>
                                            {{-- <td></td> --}}
                                            {{-- blade-formatter-disable --}}
                                            <td class='text-center'>{{ $loop->iteration }}</td>
                                            <td class='text-left'>{{ $data->nomor_pembayaran }}</td>
                                            <td class='text-left'>{{ $data->KeuanganRiwayat->jenis_pembayaran }}</td>
                                            <td class='text-left'>
                                                {{ $data->BendaharaKomiteToDetailsiswa->nama_siswa }}</td>
                                            <td class='text-left'>
                                                Rp. {{ number_format($data->nominal, 0) }}
                                                {{-- Pengecekan Lunas --}}
                                                @php
                                                    $total_terbayar = App\Models\Bendahara\BendaharaKomite::select('nominal')
                                                        ->where('detailsiswa_id', $data->detailsiswa_id)
                                                        ->where('tapel_id', $data->tapel_id)
                                                        ->where('semester', $data->semester)
                                                        ->where('pembayaran_id', $data->pembayaran_id)
                                                        ->sum('nominal');
                                                    $harus = App\Models\Bendahara\KeuanganRiwayatList::where('id', $data->pembayaran_id)->value('nominal');

                                                @endphp
                                                / Rp. {{ number_format($harus, 0) }}
                                            </td>
                                            <td class='text-center'>
                                                @if ($total_terbayar >= $harus)
                                                    @php
                                                        $kelebihan = $total_terbayar - $harus;
                                                    @endphp
                                                    @if ($kelebihan > 0)
                                                        <span class="bg-warning p-2"><i class="fa fa-info-circle text-dark"></i> Kelebihan:  <br>Rp. {{ number_format($kelebihan, 0) }}</span>
                                                    @else
                                                        <span class="bg-success p-2"><i class="fa fa-check text-white"></i> Lunas</span>
                                                    @endif
                                                @else
                                                    <span><i class="fa fa-times text-danger"></i> {{ number_format($harus - $total_terbayar, 0) }}</span>
                                                @endif
                                            </td>
                                            {{-- BendaharaKomiteToDetailsiswa->id --}}

                                            {{-- blade-formatter-enable --}}

                                            <td class='text-center'>
                                                {{-- blade-formatter-disable --}}
                                                <div class='gap-1 d-flex justify-content-center'>
                                                    <!-- Button untuk mengedit -->
                                                    <button type='button' class='btn btn-warning btn-sm' data-toggle='modal' data-target='#editModal{{ $data->id }}'> <i class='fa fa-edit'></i> </button>
                                                    <!-- Form untuk menghapus -->
                                                    <form id='delete-form-{{ $data->id }}' action='{{ route('dasboard-komite.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i> </button>
                                                </div>
                                                {{-- blade-formatter-enable --}}
                                            </td>
                                            {{-- Modal View Data Akhir --}}
                                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                                aria-labelledby='EditModalLabel' aria-hidden='true'>
                                                <x-edit-modal>
                                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                    <section>
                                                        <form id='updateEdata'
                                                            action='{{ route('dasboard-komite.update', $data->id) }}'
                                                            method='POST'>
                                                            @csrf
                                                            @method('PATCH')
                                                            {{-- blade-formatter-disable --}}
                                                            <x-inputallin>readonly:Nama Siswa:Nama siswa:nama_siswa:id_nama_siswa:{{ $data->BendaharaKomiteToDetailsiswa->nama_siswa }}:readonly</x-inputallin>
                                                            <x-inputallin>readonly:Tapel:Tapel:tapel:tapel:{{ $data->BendaharaKomiteToEtapel->tapel }} - {{ $data->BendaharaKomiteToEtapel->tapel + 1}}:readonly</x-inputallin>
                                                            <x-inputallin>hidden:::tapel_id:tapel_id:{{ $data->tapel_id }}:Required</x-inputallin>
                                                            <div class='form-group'>
                                                                @php
                                                                    $keuangan_komite = App\Models\Bendahara\KeuanganRiwayatList::where('kategori', 'komite')->where('tapel_id', $data->tapel_id)->get();
                                                                    $dataupdate_jenis_pembayaran = $data->KeuanganRiwayat->jenis_pembayaran;
                                                                @endphp
                                                                <label for='jenis_pembayaran'>Jenis Pembayaran</label>
                                                                <select name='jenis_pembayaran' id='jenis_pembayaran-{{ $loop->index }}'
                                                                    class='form-control'>
                                                                    @foreach ($keuangan_komite as $item)
                                                                        <option value="{{$item->jenis_pembayaran}}">{{$item->jenis_pembayaran}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <script>
                                                                $(document).ready(function() {
                                                                    $("#jenis_pembayaran-{{ $loop->index }}").val(@json($dataupdate_jenis_pembayaran)).trigger("change"); // Mutiple Select Select value in array json
                                                                });
                                                            </script>

                                                            <x-inputallin>type:Nominal:Rp. 50.0000:nominal:id_nominal:{{ $data->nominal }}:</x-inputallin>
                                                            <x-inputallin>textarea:Keterangan:Keterangan pembaaran jika ada:keterangan:id_keterangan::</x-inputallin>
                                                            <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'> Kirim</button>
                                                            {{-- blade-formatter-enable --}}
                                                        </form>

                                                    </section>
                                                </x-edit-modal>
                                            </div>
                                            {{-- Modal Edit Data Akhir --}}

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class='text-center table-primary align-middle'>
                                        <th>ID</th>
                                        <th>No Transaksi</th>
                                        <th>Jenis Pembayaran</th>
                                        <th>Nama Siswa</th>
                                        <th>Nominal</th>
                                        <th>Checklist</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- </div> --}}

    </section>
</x-layout>


<script>
    function Importdata() {
        var Importdata = new bootstrap.Modal(document.getElementById('Importdata'));
        alert('aaa');
        Importdata.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='Importdata' tabindex='-1' aria-labelledby='Labeldatainput' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='Labeldatainput'>
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
