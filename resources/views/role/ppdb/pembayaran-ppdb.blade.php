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
            <div class='container-fluid'>
                <div class='row'>
                    <div class='col'>
                        <!-- Papan Informasi  -->
                        <div class='row mx-2'>
                            <div class='col-lg-4 col-6'>
                                <!-- small box / Data BOX-->
                                <div class='small-box bg-info'><!-- Background -->
                                    <h3 class='m-2'>Data PPDB</h3><!-- Judul -->
                                    <div class='inner'><!-- Isi Kontent -->
                                        <div class='d-flex justify-content-between'>
                                            <span>Jumlah Peserta</span><span>{{ $datas->count() }} Siswa</span>
                                        </div>
                                        <div class='d-flex justify-content-between'>
                                            <span>Jumlah Laki -
                                                Laki</span><span>{{ $datas->where('jenis_kelamin', 1)->count() }}
                                                Siswa</span>
                                        </div>
                                        <div class='d-flex justify-content-between'>
                                            <span>Jumlah
                                                Perempuan</span><span>{{ $datas->where('jenis_kelamin', 2)->count() }}
                                                Siswa</span>
                                        </div>
                                    </div>
                                    <div class='icon'>
                                        <i class='fa fa-wallet'></i><!-- Icon -->
                                    </div>
                                    <a href='#' class='small-box-footer'>More info <i
                                            class='fas fa-arrow-circle-right'></i></a>
                                </div>
                                <!-- small box -->
                            </div>
                            <!-- ./col -->
                            <div class='col-lg-4 col-6'>
                                <!-- small box / Data BOX-->
                                <div class='small-box bg-warning'><!-- Background -->
                                    <h3 class='m-2'>Anggaran PPDB</h3><!-- Judul -->
                                    <div class='inner'><!-- Isi Kontent -->
                                        <div class='d-flex justify-content-between'>
                                            <span>Dana Pendaftaran</span><span>Rp.
                                                {{ number_format($datapembayaran->sum('nominal'), 2) }}</span>
                                        </div>
                                        <div class='d-flex justify-content-between'>
                                            <span>Dana Pendaftaran Seharusnya</span><span>Rp.
                                                {{ number_format($datas->count() * 35000, 2) }}</span>
                                        </div>
                                        <div class='d-flex justify-content-between'>
                                            <span>Sisa</span><span>Rp.
                                                {{ number_format($datas->count() * 35000 - $datapembayaran->sum('nominal'), 2) }}</span>
                                        </div>
                                    </div>
                                    <div class='icon'>
                                        <i class='fa fa-wallet'></i><!-- Icon -->
                                    </div>
                                    <a href='#' class='small-box-footer'>More info <i
                                            class='fas fa-arrow-circle-right'></i></a>
                                </div>
                                <!-- small box -->
                            </div>
                            <!-- ./col -->
                            <div class='col-lg-4 col-6'>
                                <!-- small box / Data BOX-->
                                <div class='small-box bg-success'><!-- Background -->
                                    <h3 class='m-2'>Kepanitiaan PPDB</h3><!-- Judul -->
                                    <div class='inner'><!-- Isi Kontent -->
                                        <div class='d-flex justify-content-between'>
                                            <span>Ketua Panitia</span><span> Ketua</span>
                                        </div>
                                        <div class='d-flex justify-content-between'>
                                            <span>Wakil Ketua</span><span> Wakil</span>
                                        </div>
                                        <div class='d-flex justify-content-between'>
                                            <span>Bendahara Panitia</span><span> Bendahara</span>
                                        </div>
                                    </div>
                                    <div class='icon'>
                                        <i class='fa fa-user-cog'></i><!-- Icon -->
                                    </div>
                                    <a href='#' class='small-box-footer'>More info <i
                                            class='fas fa-arrow-circle-right'></i></a>
                                </div>
                                <!-- small box -->
                            </div>
                            <!-- ./col -->
                        </div>
                        <!-- Papan Informasi  -->
                        {{-- <x-footer></x-footer> --}}


                    </div>
                </div>
            </div>

            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2 mt-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->
            <div class="card mx-2 my-4">
                <div class='card-header bg-success'><h3 class='card-title'> Menu Pembayaran</h3></div>
                <div class='card-body'>
                    <div class="row">
                        <div class="col-xl-2">
                            <button type='button' class='btn btn-block btn-default bg-success btn-md' onclick='pembayaranPPDB()'><i class="fa fa-dollar-sign mr-2"></i> Pembayaran Siswa</button>
                            <button type='button' class='btn btn-block btn-default bg-success btn-md' onclick='PengeluaranPPDB()'><i class="fa fa-coins mr-2"></i> Pengeluaran</button>
                        </div>
                        <div class="col-xl-8"></div>
                    </div>
                </div>
            </div>


            <div class='ml-2 my-4'>
                {{-- Pembayaran PPDB --}}
                <div class="card">
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>Data Pembayaran PPDB</h3>
                    </div>
                    <div class='card-body'>
                        <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                            <thead>
                                <tr class='text-center table-primary'>
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
                                        <td class='text-center'> {{ $data->nomor_peserta }}</td>
                                        <td class='text-center'>
                                            @if ($data->status_penerimaan === 'Diterima')
                                                <span class="bg-success p-2">{{ $data->status_penerimaan }}</span>
                                            @elseif($data->status_penerimaan === 'Ditolak')
                                                <span class="bg-danger p-2">{{ $data->status_penerimaan }}</span>
                                            @else
                                                <span class="bg-warning p-2">{{ $data->status_penerimaan }}</span>
                                            @endif
                                        </td>
                                        <td class='text-center'> {{ $data->nama_calon }}</td>
                                        <td class='text-center'>
                                            @php
                                                $find_Pembayaran = App\Models\WakaKesiswaan\PPDB\PembayaranPPDB::where(
                                                    'calon_id',
                                                    $data->id,
                                                )->sum('nominal');
                                            @endphp
                                            Rp. {{ number_format($find_Pembayaran, 2) }}
                                        </td>

                                        <td width='20%'>
                                            <div class='gap-1 d-flex justify-content-center'>
                                                <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                                    data-toggle='modal' data-target='#editModal{{ $data->id }}'><i
                                                        class='fa fa-plus'></i> Edit</button>
                                                <!-- Form untuk menghapus -->
                                                <form action='{{ route('pembayaran-ppdb.destroy', $data->id) }}'
                                                    method='POST' style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type='submit' class='btn btn-danger btn-sm btn-equal-width'
                                                        onclick=`return confirm('Apakah Anda yakin ingin menghapus data
                                                        ini?');`><i class='fa fa-trash'></i> Hapus</button>
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
                                                <form id='updateurl'
                                                    action='{{ route('pembayaran-ppdb.update', $data->id) }}'
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
                {{-- Pembayaran PPDB --}}
            </div>

        </div>

    </section>
</x-layout>


<script>
    function pembayaranPPDB(data) {
        var pembayaranPPDB = new bootstrap.Modal(document.getElementById('pembayaranPPDB'));
        pembayaranPPDB.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='pembayaranPPDB' tabindex='-1' aria-labelledby='LabelpembayaranPPDB' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelpembayaranPPDB'>
                    Tambah Pembayaran PPDB
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


<script>
    function PengeluaranPPDB(data) {
        var PengeluaranPPDB = new bootstrap.Modal(document.getElementById('PengeluaranPPDB'));
        PengeluaranPPDB.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='PengeluaranPPDB' tabindex='-1' aria-labelledby='PengeluaranPPDB' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='PengeluaranPPDB'>
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
