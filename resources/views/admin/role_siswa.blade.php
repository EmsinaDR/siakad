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
            <div class='card-header bg-primary mx-2 mb-4'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->


            <div class='ml-2'>
                <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                    <thead>
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
                        @foreach ($datas as $data)
                            <tr>
                                <td class='text-center'>{{ $loop->iteration }}</td>
                                <td class='text-left'> {{ $data->UsersDetailsiswa->nama_siswa }}</td>
                                <td class='text-center'>
                                    <form action="{{ route('role-siswa.reseter', ['id' => $data->id]) }}" method="POST"
                                        style="display: inline-block;">
                                        @csrf
                                        @method('PUT')
                                        @if($data->aktiv !== 'Y')
                                        <button type='submit'  title='Buka Kunci Login Siswa'  class="btn btn-danger"><i class="fa fa-lock"> </i></button>
                                        @else
                                        <button type='submit' title='Kunci Login Siswa'  class="btn btn-success"><i class="fa fa-lock-open"> </i></button>
                                        @endif
                                    </form>
                                    </i>

                                </td>
                                <td class='text-center'> {{ $data->posisi }}</td>
                                <td class='text-center'> </td>
                                {{-- @if ($activecrud === 1 and Auth::user()->id === (int) $data->user_id) --}}
                                <td width='25%'>
                                    <div class="row d-flex gap-3 justify-content-center">
                                        <!-- Button untuk melihat -->
                                        <button type="button" title='Lihat Data' class="btn btn-success btn-sm btn-equal-width"
                                            data-toggle="modal" data-target="#viewModal{{ $data->id }}">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <!-- Button untuk mengedit -->
                                        <button type="button" title='Edit Data' class="btn btn-warning btn-sm btn-equal-width"
                                            data-toggle="modal" data-target="#editModal{{ $data->id }}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <!-- Form untuk menghapus -->
                                        <form action="{{ route('role-siswa.destroy', $data->id) }}" method="POST"
                                            style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title='Hapus Data' class="btn btn-danger btn-sm btn-equal-width"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                        <!-- Form untuk lock -->
                                        <form action="{{ route('role-siswa.reseter', ['id' => $data->id]) }}"
                                            method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" title='Reset Data Password' class="btn btn-info btn-sm btn-equal-width"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                <i class="fa fa-recycle"></i>
                                            </button>
                                        </form>
                                    </div>

                                </td>
                                {{-- Modal View Data Akhir --}}
                                <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                    aria-labelledby='EditModalLabel' aria-hidden='true'>
                                    <x-edit-modal>
                                        <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                        <section>
                                            <form id='updateurl' action='{{ route('role-siswa.update', $data->id) }}'
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

    </section>
</x-layout>
