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
                                <th width="1%" rowspan="3">ID</th>
                                @foreach ($arr_ths as $arr_th)
                                    <th rowspan="3">{{ $arr_th }}</th>
                                @endforeach

                                {{-- Hitung total kolom bulan --}}
                                <th colspan="{{ count($bulanArray) * 3 }}">Bulan</th>

                                {{-- Total per jenis absen (S, I, A) --}}
                                <th colspan="3" rowspan="2">Total</th>

                                {{-- Total keseluruhan --}}
                                <th width="5%" rowspan="3" class="text-wrap">Total Tidak Hadir</th>
                            </tr>

                            {{-- Nama Bulan --}}
                            <tr class="text-center align-middle">
                                @foreach ($bulanArray as $bulan)
                                    @php
                                        $bulanName = \Carbon\Carbon::create()
                                            ->month($bulan)
                                            ->locale('id')
                                            ->isoFormat('MMM');
                                    @endphp
                                    <th colspan="3" class="text-center text-uppercase">{{ $bulanName }}</th>
                                @endforeach
                            </tr>

                            {{-- Subkolom: S, I, A --}}
                            <tr class="text-center align-middle">
                                @foreach ($bulanArray as $bulan)
                                    <th class="table-warning">S</th>
                                    <th>I</th>
                                    <th class="table-danger">A</th>
                                @endforeach

                                <th class="table-warning">S</th>
                                <th>I</th>
                                <th class="table-danger">A</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach ($datas as $data)
                                @php
                                    $data_siswa = App\Models\User\Siswa\Detailsiswa::find($data['detailsiswa_id']);
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $data_siswa->nis }}</td>
                                    <td class="text-left">{{ $data_siswa->nama_siswa }}</td>

                                    @php
                                        $totalS = 0;
                                        $totalI = 0;
                                        $totalA = 0;
                                    @endphp

                                    @foreach ($bulanArray as $bulan)
                                        @php
                                            $bulanName = \Carbon\Carbon::create()->month($bulan)->format('M');
                                            $S = $data['S_' . $bulanName] ?? 0;
                                            $I = $data['I_' . $bulanName] ?? 0;
                                            $A = $data['A_' . $bulanName] ?? 0;
                                            $totalS += $S;
                                            $totalI += $I;
                                            $totalA += $A;
                                        @endphp

                                        <td class="text-center table-warning">{{ $S }}</td>
                                        <td class="text-center">{{ $I }}</td>
                                        <td class="text-center table-danger">{{ $A }}</td>
                                    @endforeach

                                    {{-- Total per siswa --}}
                                    <td class="text-center">{{ $totalS }}</td>
                                    <td class="text-center">{{ $totalI }}</td>
                                    <td class="text-center">{{ $totalA }}</td>
                                    <td class="text-center">{{ $totalS + $totalI + $totalA }}</td>
                                </tr>
                                {{-- Modal View Data Akhir --}}
                                <div class='modal fade' id='editModal{{ $data['detailsiswa_id'] }}' tabindex='-1'
                                    aria-labelledby='EditModalLabel' aria-hidden='true'>
                                    <x-edit-modal>
                                        <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                        <section>
                                            <form id='updateurl' action='#' method='POST'>
                                                {{-- <form id='updateurl' action='{{ route('url.update', $data['detailsiswa_id']) }}' method='POST'> --}}
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
                                <div class='modal fade' id='viewModal{{ $data['detailsiswa_id'] }}' tabindex='-1'
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
