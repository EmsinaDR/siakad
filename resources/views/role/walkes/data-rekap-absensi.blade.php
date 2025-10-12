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
                        btn-app/FNRekapAbsensi()()</x-btnjs>
                </div>
            </div>
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->


            <div class='ml-2 my-4'>
                {{-- Catatan :
                - Include Komponen Modal CRUD + Javascript / Jquery
                - Perbaiki Onclick Tombol Modal Create, Edit
                - Variabel Active Crud menggunakan ID User
                 --}}
                <div class="col-xl-12">
                    <table id='example1' width='100%' class='table table-responsive table-bordered table-hover mr-2'>
                        <thead>
                            <tr class="text-center align-middle">
                                <th width="1%" class="text-center align-middle" rowspan="3">ID</th>
                                @foreach ($arr_ths as $arr_th)
                                    <th class="text-center align-middle" rowspan="3">{{ $arr_th }}</th>
                                @endforeach
                                <th class="text-center align-middle" colspan="18">Bulan</th>
                                <th class="text-center align-middle" colspan='3' rowspan="2">Total</th>
                                <th width='5%' class="text-center align-middle text-wrap" rowspan="3">Total Tidak
                                    Hadir</th>
                            </tr>
                            <tr class="text-center align-middle">
                                @for ($i = 1; $i <= 6; $i++)
                                    <th class="text-center align-middle" colspan="3">{{ $i }}</th>
                                @endfor
                            </tr>
                            <tr class="text-center align-middle">
                                @for ($i = 1; $i <= 7; $i++)
                                    <th class="text-center align-middle">S</th>
                                    <th class="text-center align-middle">I</th>
                                    <th class="text-center align-middle">A</th>
                                @endfor
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($datas as $data)
                                @php
                                    $data_siswa = App\Models\User\Siswa\Detailsiswa::where('id', $data['user_id'])->first();
                                    // dd($data_siswa);
                                @endphp
                                <tr>
                                    <td class='text-center'>{{ $loop->iteration }}</td>
                                    <td width='8%' class='text-center'>
                                        {{-- {{ $data->EabsentoDetailsiswa->nis }}  --}}
                                        {{ $data_siswa->nis }}

                                    </td>
                                    <td width='15%' class='text-left'>
                                        {{-- {{ $data->EabsentoDetailsiswa->nama_siswa }}  --}}
                                        {{ $data_siswa->nama_siswa }}
                                    </td>
                                    <td class='text-center table-warning'> {{ $data['S_Jan'] }}</td>
                                    <td class='text-center'> {{ $data['I_Jan'] }}</td>
                                    <td class='text-center table-danger'> {{ $data['A_Jan'] }}</td>

                                    <td class='text-center table-warning'> {{ $data['S_Feb'] }}</td>
                                    <td class='text-center'> {{ $data['I_Feb'] }}</td>
                                    <td class='text-center table-danger'> {{ $data['A_Feb'] }}</td>

                                    <td class='text-center table-warning'> {{ $data['S_Mar'] }}</td>
                                    <td class='text-center'> {{ $data['I_Mar'] }}</td>
                                    <td class='text-center table-danger'> {{ $data['A_Mar'] }}</td>


                                    <td class='text-center table-warning'> {{ $data['S_Apr'] }}</td>
                                    <td class='text-center'> {{ $data['I_Apr'] }}</td>
                                    <td class='text-center table-danger'> {{ $data['A_Apr'] }}</td>


                                    <td class='text-center table-warning'> {{ $data['S_May'] }}</td>
                                    <td class='text-center'> {{ $data['I_May'] }}</td>
                                    <td class='text-center table-danger'> {{ $data['A_May'] }}</td>


                                    <td class='text-center table-warning'> {{ $data['S_Jun'] }}</td>
                                    <td class='text-center'> {{ $data['I_Jun'] }}</td>
                                    <td class='text-center table-danger'> {{ $data['A_Jun'] }}</td>
                                    <td class='text-center'>
                                        {{ $data['S_Jan'] + $data['S_Feb'] + $data['S_Mar'] + $data['S_Apr'] + $data['S_May'] + $data['S_Jun'] }}
                                    </td>
                                    <td class='text-center'>
                                        {{ $data['I_Jan'] + $data['I_Feb'] + $data['I_Mar'] + $data['I_Apr'] + $data['I_May'] + $data['I_Jun'] }}
                                    </td>
                                    <td class='text-center'>
                                        {{ $data['A_Jan'] + $data['A_Feb'] + $data['A_Mar'] + $data['A_Apr'] + $data['A_May'] + $data['A_Jun'] }}
                                    </td>
                                    <td class='text-center'>
                                        {{ $data['S_Jan'] + $data['S_Feb'] + $data['S_Mar'] + $data['S_Apr'] + $data['S_May'] + $data['S_Jun'] + ($data['I_Jan'] + $data['I_Feb'] + $data['I_Mar'] + $data['I_Apr'] + $data['I_May'] + $data['I_Jun']) + ($data['A_Jan'] + $data['A_Feb'] + $data['A_Mar'] + $data['A_Apr'] + $data['A_May'] + $data['A_Jun']) }}
                                    </td>
                                    {{-- tdce --}}
                                </tr>

                                {{-- Modal View Data Akhir --}}
                                <div class='modal fade' id='editModal{{ $data['user_id'] }}' tabindex='-1'
                                    aria-labelledby='EditModalLabel' aria-hidden='true'>
                                    <x-edit-modal>
                                        <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                        <section>
                                            <form id='updateurl' action='#' method='POST'>
                                                {{-- <form id='updateurl' action='{{ route('url.update', $data['user_id']) }}' method='POST'> --}}
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
                                <div class='modal fade' id='viewModal{{ $data['user_id'] }}' tabindex='-1'
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

                    </table>
                </div>
            </div>

        </div>

    </section>
</x-layout>

<button class='btn btn-warning btn-sm' onclick='FNRekapAbsensi()'><i class='fa fa-edit right'></i> Edit</button>

<script>
    function RekapAbsensi(data) {
        var RekapAbsensi = new bootstrap.Modal(document.getElementById('RekapAbsensi'));
        RekapAbsensi.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='RekapAbsensi' tabindex='-1' aria-labelledby='LabelRekapAbsensi' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelRekapAbsensi'>
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
