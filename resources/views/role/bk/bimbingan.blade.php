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
                        btn-app/TambahData()()</x-btnjs>
                </div>
            </div>
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->


            <div class='ml-2 my-4'>

                <table id='example1' width='100%' class='table table-responsive table-bordered table-hover mt-4'>
                    <thead>
                        <tr class='text-center'>
                            <th width='1%'>ID</th>
                            @foreach ($arr_ths as $arr_th)
                                <th class='text-center'> {{ $arr_th }}</th>
                            @endforeach

                            {{-- @if ($activecrud === 1)
                    <th>Action</th>
                      {{-- @endif --}}
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataBimbingan as $data)
                            <tr>
                                {{-- blade-formatter-disable --}}
                                <td class='text-center'>{{ $loop->iteration }}</td>
                                <td class='text-center'>{{Carbon\Carbon::create($data->created_at)->translatedformat('l, d F Y')}}</td>
                                <td class='text-center'> {{ $data->Siswa->nis }}</td>
                                <td class='text-left'> {{ $data->Siswa->nama_siswa }}</td>
                                <td class='text-center'>{{$data->Siswa->kelas->kelas ?? ''}}</td>
                                {{-- blade-formatter-enable --}}
                                <td class='text-center'>

                                    @if ($data->proses === 'Proses')
                                        <span class='bg-primary rounded-pill p-2'>
                                        @elseif($data->proses === 'Pending')
                                            <span class='bg-danger rounded-pill p-2'>
                                            @else($data->proses === 'selesai')
                                                <span class='bg-success rounded-pill p-2'>
                                    @endif
                                    {{ $data->proses }}</span>
                                </td>
                                <td class='text-left'> {{ $data->permasalahan }}</td>

                                <td width='20%'>
                                    <div class='gap-1 d-flex justify-content-center'>
                                        <!-- Button untuk mengedit -->
                                        <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                            data-toggle='modal' data-target='#editModal{{ $data->id }}'>
                                            <i class='fa fa-edit'></i> 
                                        </button>
                                        <!-- Form untuk menghapus -->
                                        <form action='{{ route('bimbingan.destroy', $data->id) }}' method='POST'
                                            style='display: inline-block;'>
                                            @csrf
                                            @method('DELETE')
                                            <button type='submit' class='btn btn-danger btn-sm btn-equal-width'
                                                onclick="return confirm(' Apakah Anda yakin ingin menghapus data ini?');">
                                                <i class='fa fa-trash'></i>
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
                                        {{-- blade-formatter-disable --}}
                                        <form id='updateurl' action='{{ route('bimbingan.update', $data->id) }}' method='POST'>
                                            @csrf
                                            @method('PATCH')
                                            {{-- DROPDOWN id Single --}}
                                            @php
                                                $detailsiswas = App\Models\User\Siswa\Detailsiswa::get();
                                                $id_id = $data->detailsiswa_id;
                                            @endphp
                                            <div class='form-group'>
                                                <label for='id'>Siswa</label>
                                                <select name='detailsiswa_id' id='id_id_{{ $loop->index }}' class='select2 form-control' required>
                                                    <option value=''>--- Pilih Siswa ---</option>
                                                    @foreach ($detailsiswas as $detailsiswa)
                                                        <option value='{{ $detailsiswa->id }}'>{{ $detailsiswa->nama_siswa }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    $('#id_id_{{ $loop->index }}').val(@json($id_id)).trigger(
                                                    'change'); // Mutiple Select Select value in array json
                                                });
                                            </script>
                                            {{-- Data input id_permasalahan --}}
                                            <x-inputallin>textarea:Permasalahan:Permasalahan yang disampaikan:permasalahan:id_permasalahan:{{ $data->permasalahan }}:Required</x-inputallin>
                                            {{-- Data input id_solusi --}}
                                            <x-inputallin>textarea:Solusi:Solusi Permasalahan:solusi:id_solusi:{{ $data->solusi }}:</x-inputallin>
                                            {{-- DROPDOWN proses Multiple --}}
                                            @php
                                            $array_options = ['Proses', 'Pending', 'Selesai'];
                                                $id_proses = $data->proses;
                                            @endphp
                                            <div class='form-group'>
                                                <label for='proses'>Proses</label>
                                                <select name='proses' id='id_proses-{{ $loop->index }}' class='select2 form-control' required>
                                                    <option value=''>--- Pilih Proses ---</option>
                                                    @foreach ($array_options as $array_option)
                                                        <option value='{{ $array_option }}'>{{ $array_option }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    $('#id_proses-{{ $loop->index }}').val(@json($id_proses)).trigger(
                                                    'change'); // Mutiple Select Select value in array json

                                                });
                                            </script>
                                            <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'>Kirim</button>
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

        </div>

    </section>
</x-layout>

<button class='btn btn-warning btn-sm' onclick='FNTambahData()'><i class='fa fa-edit right'></i> Edit</button>

<script>
    function TambahData(data) {
        var TambahData = new bootstrap.Modal(document.getElementById('TambahData'));
        TambahData.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='TambahData' tabindex='-1' aria-labelledby='LabelTambahData' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelTambahData'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <form id='#id' action='' method='POST'>
                    @csrf
                    @method('POST')
                    {{-- DROPDOWN id Single --}}
                    <x-inputallin>date:Tanggal:Tanggal Pelaksanaan:tanggal:id_tanggal::Required</x-inputallin>
                    @php $detailsiswas = App\Models\User\Siswa\Detailsiswa::get(); @endphp
                    <div class='form-group'>
                        <label for='id'>Siswa</label>
                        <select name='detailsiswa_id' class='form-control' required>
                            <option value=''>--- Pilih Siswa ---</option>
                            @foreach ($detailsiswas as $detailsiswa)
                                <option value='{{ $detailsiswa->id }}'>{{ $detailsiswa->nama_siswa }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- Data input id_permasalahan --}}
                    <x-inputallin>textarea:Permasalahan:Permasalahan yang
                        disampaikan:permasalahan:id_permasalahan::Required</x-inputallin>
                    {{-- Data input id_solusi --}}
                    <x-inputallin>textarea:Solusi:Solusi Permasalahan:solusi:id_solusi::Required</x-inputallin>

                    {{-- DROPDOWN proses Multiple --}}
                    @php $array_options = ['Proses','Pending','Selesai'];  @endphp
                    <div class='form-group'>
                        <label for='proses'>Proses</label>
                        <select name='proses' class='form-control' required>
                            <option value=''>--- Pilih Proses ---</option>
                            @foreach ($array_options as $array_option)
                                <option value='{{ $array_option }}'>{{ $array_option }}</option>
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
