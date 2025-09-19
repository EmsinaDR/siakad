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
        <div class='card'>
            {{-- Papan Informasi --}}
            <div class='card-body'>
                <div class='row float-right'>
                    <x-btnjs>submit/Tambah Data/fa fa-plus/btn btn-primary btn-xl bg-primary
                        btn-app/namaModal()</x-btnjs>
                </div>
            </div>
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->


            <div class='ml-2 my-4'>
                {{-- role.bendahara.studytour.pengaturan-study-tour --}}
                <div class="row">
                    <div class="col-xl-3">
                        <div class='card-header bg-primary'>
                            <h3 class='card-title'>Tambah Data Riwayat</h3>
                        </div>
                        <div class="card-body">
                            {{-- blade-formatter-disable --}}
                            <x-inputallin>type:Nama Biro:Nama Biro:nama_biro:id_nama_biro::Required</x-inputallin>
                            <x-inputallin>type:Nama Kontak:Nama kontak biro:nama_kontak:id_nama_kontak::Required</x-inputallin>
                            <x-inputallin>type:No HP:Nomor Handphone:nomor_handphone:id_nomor_handphone::Required</x-inputallin>
                            <x-inputallin>type:Nominal:Nominal:nominal:id_nominal::Required</x-inputallin>
                            <x-inputallin>textarea:Tujuan:Tujuan Wisata:tujuan_wisata:id_tujuan_wisata::Required</x-inputallin>
                            <x-inputallin>textarea:Fasilitas:Fasilitas Biro:fasilitas_biro:id_fasilitas_biro::Required</x-inputallin>
                            <x-inputallin>date:Tanggal Berangkat:Tanggal pemberangkatan:tanggal_pemberangkatan:id_tanggal_pemberangkatan::Required</x-inputallin>
                            <x-inputallin>date:Tanggal Pulang:Tanggal kembali:tanggal_kembali:id_tanggal_kembali::Required</x-inputallin>
                            {{-- blade-formatter-enable --}}
                            <div class='form-group'>
                                <label for='keterangan'>Keterangan</label>
                                <textarea type='text' class='form-control' id='keterangan' name='keterangan' placeholder='' rowspan='10' required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9">
                        <div class='card-header bg-primary'>
                            <h3 class='card-title'>Riwayat Data Study Tour</h3>
                        </div>

                        <table id='example1' width='100%' class='table table-bordered table-hover'>
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
                                        <td class='text-center'> {{ $data->RiwayatStudyTourToTapel->tapel }}</td>
                                        <td class='text-center'> {{ $data->nama_biro }}</td>
                                        <td class='text-center'> {{ $data->nama_kontak }}</td>
                                        <td class='text-center'> {{ $data->nomor_handphone }}</td>
                                        <td class='text-center'> Rp. {{ number_format($data->nominal, 2) }}</td>

                                        <td width='20%'>
                                            <div class='gap-1 d-flex justify-content-center'>
                                                <!-- Button untuk melihat -->
                                                <!-- <button type='button' class='btn btn-success btn-sm btn-equal-width' data-toggle='modal' data-target='#viewModal{{ $data->id }}'>
                                                <i class='fa fa-eye'></i> Lihat
                                                </button> -->
                                                <!-- Button untuk mengedit -->
                                                <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                                    data-toggle='modal' data-target='#editModal{{ $data->id }}'>
                                                    <i class='fa fa-edit'></i> Edit
                                                </button>
                                                <!-- Form untuk menghapus -->
                                                <form action='#' method='POST' style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                    {{-- blade-formatter-disable --}}
                                                    <button type='submit' class='btn btn-danger btn-sm btn-equal-width' onclick=`return confirm('Apakah Anda yakin ingin menghapus data ini?');`>
                                                    {{-- blade-formatter-enable --}}
                                                    <i class='fa fa-trash'></i> Hapus
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
                                                <form id='updateurl' action='#' method='POST'>
                                                    @csrf
                                                    @method('PATCH')
                                                    <button id='kirim' type='submit'
                                                        class='btn float-right btn-default bg-primary btn-xl mt-4'>
                                                        Kirim</button>
                                                </form>

                                            </section>
                                        </x-edit-modal>
                                    </div>
                                    {{-- Modal Edit Data Akhir --}}
                                    {{-- Modal View --}}
                                    <div class='modal fade' id='viewModal{{ $data->id }}' tabindex='-1' aria-labelledby='ViewModalLabel' aria-hidden='true'>

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
