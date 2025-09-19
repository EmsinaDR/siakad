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
    <section class='content mx-2'>
        <div class='card'>
            {{-- Papan Informasi --}}
            <div class='card-body'>
                <div class='row float-right'>
                    <x-btn>submit/Tambah Data/fa fa-plus/btn btn-primary btn-xl bg-primary btn-app/TambahMapel()</x-btn>
                </div>
            </div>
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->

            <div class="mx-2 my-4">
                <div class="row">
                    <div class="col-4">
                        <div class='card-header bg-success mb-2'>
                            <h3 class='card-title'>Kelompok Siswa Berdasarkan Kecamatan</h3>
                        </div>
                        <table id='example1' width='100%' class='table table-bordered table-hover  mt-4'>
                            <thead>
                                <tr class='text-center align-middle'>
                                    <th>ID</th>
                                    <th>Desa</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class='text-center'>1</td>
                                    <td class='text-center'>Banjarharjo</td>
                                    <td class='text-center'>10</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class='text-center align-middle'>
                                    <th>ID</th>
                                    <th>Desa</th>
                                    <th>Jumlah</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-4">
                        <div class='card-header mb-2 text-white' style='background-color:#17A2B8'>
                            <h3 class='card-title'>Kelompok Siswa Berdasarkan Desa</h3>
                        </div>
                        <table id='example3' width='100%' class='table table-bordered table-hover  mt-4'>
                            <thead>
                                <tr class='text-center align-middle'>
                                    <th>ID</th>
                                    <th>Desa</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class='text-center'>1</td>
                                    <td class='text-center'>Banjarharjo</td>
                                    <td class='text-center'>10</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class='text-center align-middle'>
                                    <th>ID</th>
                                    <th>Desa</th>
                                    <th>Jumlah</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-4"></div>
                </div>
            </div>
            <div class='ml-2 my-4'>
                Walkes Data Siswa
                {{-- Catatan :
                - Include Komponen Modal CRUD + Javascript / Jquery
                - Perbaiki Onclick Tombol Modal Create, Edit
                - Variabel Active Crud menggunakan ID User
                 --}}

                <table id='example2' width='100%' class='table table-responsive table-bordered table-hover'>
                    <thead class='table table-info bg-info'>
                        <tr class='text-center'>
                            <th width='1%'>ID</th>
                            @foreach ($arr_ths as $arr_th)
                                <th class='text-center'> {{ $arr_th }}</th>
                            @endforeach

                            {{-- @if ($activecrud === 1) --}}
                            <th>Action</th>
                            {{-- @endif --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($DataSiswa as $data)
                            <tr>
                                <td class='text-center'>{{ $loop->iteration }}</td>
                                <td width='10%' class='text-center'> {{ $data->nis }}</td>
                                <td width='10%' class='text-center'> {{ $data->nisn }}</td>
                                <td class='text-left'> {{ $data->nama_siswa }}</td>
                                <td width='10%' class='text-center'> {{ $data->desa }}</td>
                                <td width='10%' class='text-center'> {{ $data->kecamatan }}</td>
                                <td width='10%' class='text-center'> {{ $data->rt }} / {{ $data->rw }}</td>
                                <td class='text-left'> {{ $data->alamt_siswa }}</td>

                                {{-- @if ($activecrud === 1 and Auth::user()->id === (int) $data->user_id) --}}
                                <td width='25%'>
                                    <div class='gap-1 d-flex justify-content-center'>
                                        <!-- Button untuk melihat -->
                                        <button type='button' class='btn btn-success btn-sm btn-equal-width'
                                            data-toggle='modal' data-target='#viewModal{{ $data->id }}'>
                                            <i class='fa fa-eye'></i> Lihat
                                        </button>
                                        <!-- Button untuk mengedit -->
                                        <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                            data-toggle='modal' data-target='#editModal{{ $data->id }}'>
                                            <i class='fa fa-edit'></i> Edit
                                        </button>
                                        <button type='button' class='btn btn-info btn-sm btn-equal-width'
                                            data-toggle='modal' data-target='#editModal{{ $data->id }}'>
                                            <i class='fa fa-file'></i> Edit
                                        </button>
                                        <!-- Form untuk menghapus -->
                                        {{-- <form action='{{ route('url.destroy', $data->id) }}' method='POST'
                                                style='display: inline-block;'>
                                                @csrf
                                                @method('DELETE')
                                                <button type='submit' class='btn btn-danger btn-sm btn-equal-width'
                                                    onclick="return confirm(' Apakah Anda yakin ingin menghapus data ini?');">
                                                    <i class='fa fa-trash'></i> Hapus
                                                </button>
                                            </form> --}}
                                    </div>
                                </td>
                            </tr>
                            {{-- Modal View Data Akhir --}}
                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                aria-labelledby='EditModalLabel' aria-hidden='true'>
                                <x-edit-modal>
                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                    <section>
                                        <form id='updateurl' action='{{ route('Walkes-DataSiswa.update', $data->id) }}'
                                            method='POST'>
                                            @csrf
                                            @method('PATCH')
                                            {{-- <x-dropdown-materib>{{ mapel_id }}/{{ tingkat_id }}</x-dropdown-materib> --}}
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

    </section>
</x-layout>
