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
                        btn-app/TabunganSiswa()</x-btnjs>
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
                <div class="row">
                    <div class="col-3">
                        <div class='card-header bg-primary'>
                            <h3 class='card-title'>Input Data Tabungan</h3>
                        </div>
                        <div class="card-body">
                            <form id='#id' action='{{ route('bendahara.tabungan.store') }}' method='POST'>
                                @csrf
                                @method('POST')
                                <div class='form-group'>
                                    <i class="fa fa-user mr-1"></i><label for='detailsiswa_'>Nama Siswa</label>
                                    <select id='detailsiswa_id' name='detailsiswa_id' class='form-control' required>
                                        <option value=''>--- Pilih Nama Siswa ---</option>
                                        @foreach ($datasiswas as $newdatasiswas)
                                            <option value='{{ $newdatasiswas->id }}'>{{ $newdatasiswas->nama_siswa }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class='form-group'>
                                    @php
                                        $type_data = ['Pemasukkan', 'Pengeluaran'];
                                    @endphp
                                    <i class="fa fa-check-circle  mr-1"></i><label for='type'>Type</label>
                                    <select id='type' name='type' class='form-control' required disabled>
                                        <option value=''>--- Pilih Type ---</option>
                                        @foreach ($type_data as $type_data)
                                            <option value='{{ strtolower($type_data) }}'>{{ $type_data }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <i
                                    class="fa fa-address-card mr-1"></i><x-inputallin>readonly:NIS:NIS:nis:nis::readonly</x-inputallin>
                                <i
                                    class="fa fa-house-user mr-2"></i><x-inputallin>readonly:Kelas:Kelas:kelas:kelas::readonly</x-inputallin>
                                <x-inputallin>hidden:::kelas_id:kelas_id::readonly</x-inputallin>
                                <i
                                    class="fa fa-coins mr-1"></i><x-inputallin>type:Nominal:Nominal:nominal:id_nominal::disabled</x-inputallin>
                                <i
                                    class="fa fa-info mr-1"></i><x-inputallin>textarea:Keterangan:Keterangan:keterangan:id_keterangan::disabled</x-inputallin>
                                <button type='submit' class='btn btn-default bg-primary btn-md mt-2 float-right'> <i
                                        class="fa fa-save"></i> Simpan</button>
                            </form>
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                           <script>
    $(document).ready(function () {
        $('#detailsiswa_id').on('change', function () {
            var siswaId = $(this).val();

            // Sesuaikan URL target tanpa '/bendahara/'
            var finalURL = window.location.origin + '/get-siswa/' + siswaId;

            console.log("Request URL:", finalURL); // Debug log

            if (siswaId) {
                $.ajax({
                    url: finalURL,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        console.log('Data siswa:', data);

                        if (data && data.detailsiswatokelas) {
                            $('#kelas').val(data.detailsiswatokelas.kelas || '');
                            $('#kelas_id').val(data.kelas_id || '');
                            $('#nis').val(data.nis || '');

                            $('#type').prop('disabled', false);
                        } else {
                            $('#kelas').val('');
                            $('#kelas_id').val('');
                            $('#nis').val('');
                            $('#type').prop('disabled', true);
                            console.warn("Data tidak lengkap atau kosong.");
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', error);
                        console.log('Response Text:', xhr.responseText);
                        alert('Terjadi kesalahan saat mengambil data siswa.');
                    }
                });
            } else {
                $('#kelas').val('');
                $('#kelas_id').val('');
                $('#nis').val('');
                $('#type').prop('disabled', true);
            }
        });

        // Enable dropdown setelah type dipilih
        $('#type').on('change', function () {
            $('#id_nominal').prop('disabled', false);
            $('#id_keterangan').prop('disabled', false);
        });
    });
</script>

                        </div>

                    </div>
                    <div class="col-9">
                        <div class='card-header bg-success'>
                            <h3 class='card-title'>Riwayat Data Tabungan</h3>
                        </div>

                        <div class='card-body'>

                            <table id='example1' width='100%'
                                class='table table-responsive table-bordered table-hover'>
                                <thead>
                                    <tr class='text-center table-success'>
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
                                            <td class='text-center'> {{ $data->BendaharaTabunganToDetailsiswa->nis }}
                                            </td>
                                            <td class='text-center'>
                                                {{ $data->BendaharaTabunganToDetailsiswa->nama_siswa }}</td>
                                            <td class='text-center'> {{ $data->BendaharaTabunganTokelas->kelas }}</td>
                                            <td class='text-center'> Rp. {{ number_format($data->nominal, 2) }} -
                                                {{ $data->type }}</td>

                                            <td width='20%'>
                                                <div class='gap-1 d-flex justify-content-center'>
                                                    <!-- Button untuk melihat -->
                                                    <button type='button' class='btn btn-success btn-sm mr-2'
                                                        data-toggle='modal'
                                                        data-target='#viewModal{{ $data->id }}'>
                                                        <i class='fa fa-eye'></i>
                                                    </button>
                                                    <!-- Button untuk mengedit -->
                                                    <button type='button' class='btn btn-warning btn-sm mr-2'
                                                        data-toggle='modal'
                                                        data-target='#editModal{{ $data->id }}'>
                                                        <i class='fa fa-edit'></i>
                                                    </button>
                                                    <!-- Form untuk menghapus -->
                                                    <form action='{{ route('bendahara.tabungan.destroy', $data->id) }}'
                                                        method='POST' style='display: inline-block;'>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type='submit' class='btn btn-danger btn-sm mr-2'
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
                                                    <form id='updatebendahara.tabungan'
                                                        action='{{ route('bendahara.tabungan.update', $data->id) }}'
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
                                    <tr class='text-center table-success'>
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

        </div>

    </section>
</x-layout>

<button class='btn btn-warning btn-sm' onclick='FNTabunganSiswa()'><i class='fa fa-edit right'></i> Edit</button>

<script>
    function TabunganSiswa(data) {
        var TabunganSiswa = new bootstrap.Modal(document.getElementById('TabunganSiswa'));
        TabunganSiswa.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='TabunganSiswa' tabindex='-1' aria-labelledby='LabelTabunganSiswa' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelTabunganSiswa'>
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
