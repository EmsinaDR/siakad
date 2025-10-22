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
                {{-- bendahara.RiwayatStudyTour.index --}}
                <div class="row">
                    <div class="col-xl-3">
                        <div class='card-header bg-primary'>
                            <h3 class='card-title'>Input Data</h3>
                        </div>
                        <div class='card-body'>








                            <form id='#id' action='#' method='POST'>
                                @csrf
                                @method('POST')
                                <div class='form-group'>
                                    @php
                                        $siswas = App\Models\User\Siswa\Detailsiswa::orderby('kelas_id', 'ASC')->get();
                                    @endphp
                                    <i class="fa fa-user mr-2"></i><label for='detailsiswa_id'>Nama Siswa</label>
                                    <select name='detailsiswa_id' id='detailsiswa_id' class='form-control' required>
                                        <option value=''>--- Pilih Nama Siswa ---</option>
                                        @foreach ($siswas as $siswa)
                                            <option value='{{ $siswa->id }}'>{{ $siswa->Detailsiswatokelas->kelas }}
                                                - {{ $siswa->nama_siswa }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- blade-formatter-disable --}}
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
                                <i class="fa fa-coins mr-1"></i><x-inputallin>type:Nominal:Nominal:nominal:id_nominal::disabled</x-inputallin>
                                <i class="fa fa-info mr-1"></i><x-inputallin>textarea:Keterangan:Keterangan:keterangan:id_keterangan::disabled</x-inputallin>
                                {{-- blade-formatter-enable --}}
                                <button type='submit' class='btn btn-default bg-primary btn-md mt-2 float-right'> <i
                                        class="fa fa-save"></i> Simpan</button>
                                <script>
                                    $('#detailsiswa_id').on('change', function() {
                                        var siswaId = $(this).val();
                                        if (siswaId) {
                                            $.ajax({
                                                url: '/get-siswa/' + siswaId,
                                                type: 'GET',
                                                dataType: 'json',
                                                success: function(data) {
                                                    console.log(data); // Memeriksa data yang diterima dari server
                                                    if (data) {
                                                        $('#nis').val(data.nis || '');
                                                        $('#kelas').val(data.detailsiswatokelas.kelas || '');
                                                        $('#tingkat_id').val(data.detailsiswatokelas.tingkat_id || '');

                                                        $('#id_nominal').prop('disabled', false);
                                                        $('#id_keterangan').prop('disabled', false);
                                                    } else {
                                                        $('#kelas').val('');
                                                        $('#nis').val('');
                                                    }
                                                },
                                                error: function() {
                                                    alert('Terjadi kesalahan saat mengambil data siswa.');
                                                }
                                            });
                                        } else {
                                            // $('#kelas').val('');
                                            // $('#alamat').val('');
                                        }
                                    });
                                    $('#type').on('change', function() {
                                        $('#id_nominal').prop('disabled', false);
                                        $('#id_keterangan').prop('disabled', false);
                                    });
                                </script>
                            </form>
                        </div>
                    </div>
                    <div class="col-xl-9">
                        <div class='card-header bg-primary'>
                            <h3 class='card-title'>Data Riwayat Pembayaran Study Tour</h3>
                        </div>
                        <div class="col-xl-12 p-2">
                            <div class='alert alert-info alert-dismissible'>
                                <h5><i class='icon fas fa-info'></i> Information !</h5>
                                <hr>
                                {{-- blade-formatter-disable --}}
                                @php
                                $data_study_tour = App\Models\Bendahara\RiwayatStudytour::where('tapel_id', 8)->first();
                                @endphp
                                {{-- blade-formatter-enable --}}
                                <div class="row">
                                    <div class="col-xl-3">
                                        Nominal Pembayaran <br>
                                        Tujuan <br>
                                        Objek Wisana <br>
                                        Biro <br>
                                    </div>
                                    <div class="col-xl-9">
                                        : Rp. {{ number_format($data_study_tour->nominal, 2) }} <br>
                                        : {{ $data_study_tour->tujuan_wisata }} <br>
                                        : {{ $data_study_tour->objek_wisata }} <br>
                                        : {{ $data_study_tour->nama_biro }} <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
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
                                        <td class='text-center'> {{ $data->BendaharaStudyTourToDetailsiswa->nis }}</td>
                                        <td class='text-center'> {{ $data->BendaharaStudyTourTokelas->kelas }}</td>
                                        <td class='text-center'>
                                            {{ $data->BendaharaStudyTourToDetailsiswa->nama_siswa }}</td>
                                        @php
                                            $total_terbayara = App\Models\Bendahara\BendaharaStudytour::select(
                                                'nominal',
                                            )
                                                ->where('detailsiswa_id', $data->detailsiswa_id)
                                                ->sum('nominal');
                                        @endphp
                                        <td class='text-center'>Rp. {{ number_format($data->nominal, 2) }} / Rp.
                                            {{ number_format($total_terbayara, 2) }}</td>
                                        @php
                                            $data_pembayaran_study_tour = App\Models\Bendahara\RiwayatStudyTour::where(
                                                'tapel_id',
                                                $data->tapel_id,
                                            )->first();
                                        @endphp
                                        {{-- blade-formatter-disable --}}
                                        @if ($data_pembayaran_study_tour->nominal - $total_terbayara !== 0)
                                            <td class='text-center'>Rp. {{ number_format($data_pembayaran_study_tour->nominal - $total_terbayara, 2) }} </td>
                                        @else
                                            <td class='text-center'><span class='bg-success p-2'><i class="fa fa-check-circle"></i> Lunas</span></td>
                                        @endif
                                        {{-- blade-formatter-enable --}}

                                        <td width='20%'>
                                            {{-- blade-formatter-disable --}}
                                            <div class='gap-1 d-flex justify-content-center'>
                                                <!-- Button untuk melihat -->
                                                <!-- <button type='button' class='btn btn-success btn-sm btn-equal-width' data-toggle='modal' data-target='#viewModal{{ $data->id }}'>
                                                                <i class='fa fa-eye'></i> Lihat
                                                            </button> -->
                                                <!-- Button untuk mengedit -->
                                                <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'> <i class='fa fa-edit'></i> Edit </button>
                                                <!-- Form untuk menghapus -->
                                                <form action='#' method='POST' style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type='submit' class='btn btn-danger btn-sm btn-equal-width' onclick=`return confirm('Apakah Anda yakin ingin menghapus data ini?');`><i class='fa fa-trash'></i> Hapus </button>
                                                </form>
                                            </div>
                                           {{-- blade-formatter-enable --}}
                                        </td>
                                    </tr>
                                    {{-- Modal View Data Akhir --}}
                                    {{-- blade-formatter-disable --}}
                                    <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1' aria-labelledby='EditModalLabel' aria-hidden='true'>
                                   {{-- blade-formatter-enable --}}
                                    <x-edit-modal>
                                        <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                        <section>
                                            <form id='updateurl' action='{{route('bendahara.studytour.update', ['study_tour' => $data->id])}}' method='POST'>
                                                @csrf
                                                @method('PATCH')

                                                {{-- blade-formatter-disable --}}
                                                <x-inputallin>type:Nominal:Nominal:nominal:id_nominal:{{ $data->nominal }}:Required</x-inputallin>
                                                {{-- blade-formatter-enable --}}

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
