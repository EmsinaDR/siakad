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
                        btn-app/ImportData()</x-btnjs>
                </div>
            </div>
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->


            <div class='ml-2 my-4'>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="card-header bg-primary">
                            <H3 class="card-title">List Pembayaran</H3>
                        </div>
                        <div class='card-body'>
                            <table id='example1' width='100%' class='table table-bordered table-hover'>
                                <thead>
                                    <tr class='text-center table-primary align-middle'>
                                        <th width='1%'>ID</th>
                                        <th>Jenis Pembayaran</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $data)
                                        <tr>
                                            <td class='text-center'>{{ $loop->iteration }}</td>
                                            <td class='text-left'>{{ $data->jenis_pembayaran }}</td>
                                            <td class='text-center'>{{ $data->keterangan }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class='text-center table-primary align-middle'>
                                        <th>ID</th>
                                        <th>Jenis Pembayaran</th>
                                        <th>Keterangan</th>
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
                            <h3 class='m-2 pt-2 text-shadow' style="text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);">Total Pembayaran</h3>
                            <hr class="border border-light border-2">
                            <div class='inner p-2'>
                                <div class=" d-flex justify-content-between">
                                    <span>Total Kelas VII</span><span>Rp. {{$total_tingkat_a}}</span>
                                </div>
                                <div class=" d-flex justify-content-between">
                                    <span>Total Kelas VIII</span><span>Rp. {{$total_tingkat_b}}</span>
                                </div>
                                <div class=" d-flex justify-content-between">
                                    <span>Total Kelas IX</span><span>Rp. {{$total_tingkat_c}}</span>
                                </div>
                            </div>

                            <div class='icon'>
                                <i class='ion ion-person-add'></i>
                            </div>
                            <div class='small-box ml-2'> <span>Total data ini berlaku untuk tahun pelajar pada semester ini</span></div>
                            {{-- <a href='#' class='small-box-footer'>More info <i
                                    class='fas fa-arrow-circle-right'></i></a> --}}
                        </div>
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
                                            <td width='3%' class='text-center'>{{ $datas_riwayat->tingkat_id }}</td>
                                            <td class='text-left'>
                                                {{ $datas_riwayat->jenis_pembayaran }}</td>
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
                                        <div class='modal fade' id='editModal{{ $datas_riwayat->id }}' tabindex='-1'
                                            aria-labelledby='EditModalLabel' aria-hidden='true'>
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
                                        <div class='modal fade' id='viewModal{{ $datas_riwayat->id }}' tabindex='-1'
                                            aria-labelledby='ViewModalLabel' aria-hidden='true'>

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
                        <label for='id_name'>Label</label>
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
                            data-placeholder='Jenis Pembayaran' style='width: 100%;'>
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
