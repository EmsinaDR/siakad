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
                    <x-btn>submit/Tambah Data/fa fa-network-wired/btn btn-primary btn-xl bg-success
                        btn-app/TambahMapel()</x-btn>
                    <x-btn>submit/Struktur Kelas/fa fa-plus/btn btn-primary btn-xl bg-primary
                        btn-app/TambahMapel()</x-btn>
                    <x-btn>submit/Pertugas Upacara/fa fa-network-wired/btn btn-primary btn-xl bg-warning
                        btn-app/TambahMapel()</x-btn>
                    <x-btn>submit/Pertugas Piktet/fa fa-network-wired/btn btn-primary btn-xl bg-secondary
                        btn-app/TambahMapel()</x-btn>
                </div>
            </div>
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->
            <div class='row ml-2 my-4'>
                <div class="col-xl-2">
                    <div class='card-header bg-success'>
                        <h3 class='card-title'>Daftar Menu</h3>
                    </div>
                    <button type='button' class='d-flex justify-content-start align-items-center btn btn-block bg-warning mt-2'><i
                            class="fa fa-print mr-1"></i> Struktur </button>
                    <button type='button' class='d-flex justify-content-start align-items-center btn btn-block bg-warning mt-1'><i
                            class="fa fa-print mr-2"></i> Jadwal Piket</button>
                    <button type='button' class='d-flex justify-content-start align-items-center btn btn-block bg-warning mt-1'><i
                            class="fa fa-print mr-2"></i> Jadwal Pelajaran</button>
                    <button type='button' class='d-flex justify-content-start align-items-center btn btn-block bg-warning mt-1'><i
                            class="fa fa-print mr-2"></i> Jadwal </button>
                </div>
                <div class="col-xl-10">
                    <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
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
                            @foreach ($datas as $data)
                                <tr>
                                    <td class='text-center'>{{ $loop->iteration }}</td>
                                    <td width='10%' class='text-center'> {{ $data->nis }}</td>
                                    <td class='text-left'> {{ $data->nama_siswa }}</td>
                                    <td class='text-center'>
                                        @if (is_null($data->DetailsiswaToElistsJabatanKelas?->list))
                                            <!-- Lakukan sesuatu jika null -->
                                            -
                                        @else
                                            {{ $data->DetailsiswaToElistsJabatanKelas->list }}
                                        @endif</td>
                                    <td class='text-center'>
                                        @if (is_null($data->DetailsiswaToElistsPiketKelas?->list))
                                            <!-- Lakukan sesuatu jika null -->
                                            -
                                        @else
                                            {{ $data->DetailsiswaToElistsPiketKelas->list }}
                                        @endif</td>
                                    <td class='text-center'>
                                        @if (is_null($data->DetailsiswaToElistsPetugasUpacaraKelas?->list))
                                            <!-- Lakukan sesuatu jika null -->
                                           -
                                        @else
                                            {{ $data->DetailsiswaToElistsPetugasUpacaraKelas->list }}
                                        @endif

                                    </td>

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
                                            <button type='button' class='btn btn-info btn-sm' data-toggle='modal'
                                                data-target='#editModal{{ $data->id }}'>
                                                <i class='fa fa-print'></i> Cetak
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
                                            <form id='updateurl'
                                                action='{{ route('Walkes-DataSiswa.update', $data->id) }}'
                                                method='POST'>
                                                @csrf
                                                @method('PATCH')
                                                @php
                                                    $lists_jabatan_kelas = App\Models\Elist::where(
                                                        'kategori',
                                                        'Jabatan Kelas',
                                                    )->get();
                                                @endphp
                                                {{-- {{ $data->jabatan_kelas }} --}}
                                                <div class='form-group mt-2'>
                                                    <label for='id_jabatan_kelas'>Jabatan Kelas</label>
                                                    <select name='jabatan_kelas'
                                                        id='id_jabatan_kelas{{ $data->id }}' class='form-control'
                                                        required>
                                                        <option value=''>--- Pilih Jabatan Kelas ---</option>
                                                        @foreach ($lists_jabatan_kelas as $list)
                                                            <option value='{{ $list->id }}'>{{ $list->list }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <script>
                                                        $(document).ready(function() {
                                                            $('#id_jabatan_kelas{{ $data->id }} option[value="' + @json($data->jabatan_kelas) + '"]').prop(
                                                                'selected', true); // Single Select
                                                        });
                                                    </script>
                                                </div>
                                                @php
                                                    $lists_piket_kelas = App\Models\Elist::where(
                                                        'kategori',
                                                        'Hari',
                                                    )->get();
                                                @endphp
                                                <div class='form-group'>
                                                    <label for='id_piket_kelas'>Piket Kelas</label>
                                                    <select name='piket_kelas' id='id_piket_kelas{{ $data->id }}'
                                                        class='form-control' required>
                                                        <option value=''>--- Pilih Piket Kelas ---</option>
                                                        @foreach ($lists_piket_kelas as $list)
                                                            <option value='{{ $list->id }}'>{{ $list->list }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <script>
                                                    $(document).ready(function() {
                                                        $('#id_piket_kelas{{ $data->id }} option[value="' + @json($data->piket_kelas) + '"]').prop(
                                                            'selected', true); // Single Select
                                                    });
                                                </script>
                                                @php
                                                    $lists_petugas_upacara = App\Models\Elist::where(
                                                        'kategori',
                                                        'Petugas Upacara',
                                                    )->get();
                                                @endphp
                                                <div class='form-group mt-2'>
                                                    <label for='id_petugas_upacara'>Petugas Upacara</label>
                                                    <select name='petugas_upacara'
                                                        id='id_petugas_upacara{{ $data->id }}' class='form-control'
                                                        required>
                                                        <option value=''>--- Pilih Petugas Upacara ---</option>
                                                        @foreach ($lists_petugas_upacara as $list)
                                                            <option value='{{ $list->id }}'>{{ $list->list }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <script>
                                                        $(document).ready(function() {
                                                            $('#id_petugas_upacara{{ $data->id }} option[value="' + @json($data->petugas_upacara) + '"]').prop(
                                                                'selected', true); // Single Select
                                                        });
                                                    </script>
                                                </div>

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
                                            @php
                                                $lists_jabatan_kelas = App\Models\Elist::where(
                                                    'kategori',
                                                    'Jabatan Kelas',
                                                )->get();
                                            @endphp
                                            <div class='form-group'>
                                                <label for='id_jabatan_kelas'>Jabatan Kelas</label>
                                                <select name='jabatan_kelas' id='id_jabatan_kelas{{ $data->id }}'
                                                    class='form-control' disabled>
                                                    <option value=''>--- Pilih Jabatan Kelas ---</option>
                                                    @foreach ($lists_jabatan_kelas as $list)
                                                        <option value='{{ $list->id }}'>{{ $list->list }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <script>
                                                    $(document).ready(function() {
                                                        $('#id_jabatan_kelas{{ $data->id }} option[value="' + @json($data->jabatan_kelas) + '"]').prop(
                                                            'selected', true); // Single Select
                                                    });
                                                </script>
                                            </div>
                                            {{-- {{ $data->piket_kelas }} --}}
                                            @php
                                                $lists_Piket_kelas = App\Models\Elist::where('kategori', 'Hari')->get();
                                            @endphp
                                            <div class='form-group mt-2'>
                                                <label for='id_Piket_kelas'>Piket Kelas</label>
                                                <select name='Piket_kelas' id='id_Piket_kelas{{ $data->id }}'
                                                    class='form-control' Required>
                                                    <option value=''>--- Pilih Piket Kelas ---</option>
                                                    @foreach ($lists_Piket_kelas as $list)
                                                        <option value='{{ $list->id }}'>{{ $list->list }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <script>
                                                    $(document).ready(function() {
                                                        $('#id_Piket_kelas{{ $data->id }} option[value="' + @json($data->piket_kelas) + '"]').prop(
                                                            'selected', true); // Single Select
                                                    });
                                                </script>
                                            </div>

                                            @php
                                                $lists_petugas_upacara = App\Models\Elist::where(
                                                    'kategori',
                                                    'Petugas Upacara',
                                                )->get();
                                            @endphp
                                            <div class='form-group mt-2'>
                                                <label for='id_petugas_upacara'>Petugas Upacara</label>
                                                <select name='petugas_upacara' id='id_petugas_upacara'
                                                    class='form-control' required>
                                                    <option value=''>--- Pilih Petugas Upacara ---</option>
                                                    @foreach ($lists_petugas_upacara as $list)
                                                        <option value='{{ $list->list }}'>{{ $list->list }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

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

    </section>
</x-layout>
