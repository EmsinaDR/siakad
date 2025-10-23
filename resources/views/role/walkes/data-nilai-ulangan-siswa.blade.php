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
                    {{-- <x-btnjs>submit/Tambah Data/fa fa-plus/btn btn-primary btn-xl bg-primary btn-app/FNnamaModal()()</x-btnjs> --}}
                </div>
            </div>
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->

            <div class='row m-2'>
                <div class="col-3 my-4">

                    <form id='post_mapel'
                        action='{{ route('Walkes-DataNilai.ulangan', ['kelas_id' => request('kelas_id')]) }}'
                        method='POST'>
                        @csrf

                        <div class='form-group'>
                            <div class='card-header bg-primary mb-2'>
                                <h3 class='card-title'>Data Pilih Mata Pelajaran</h3>
                            </div>
                            <label for='mapel_id'>Mata Pelajaran</label>
                            <select id='mapels' name='mapel_id' class='form-control' required>
                                <option value=''>--- Pilih Mata Pelajaran ---</option>
                                @foreach ($mapels as $newkey)
                                    <option value='{{ $newkey->id }}'>{{ $newkey->mapel }} - {{ $newkey->id }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class='form-group'>
                            <label for='semester'>Semester</label>
                            <select id='semester' name='semester' class='form-control' disabled>
                                <option value=''>--- Pilih Semester ---</option>
                                <option value='I'>I</option>
                                <option value='II'>II</option>
                            </select>
                        </div>
                        <div class="col">
                            <button id='submiter' type='submit' class='btn btn-default bg-primary btn-lg float-right'
                                style="display: none;">Kirim</button>
                        </div>
                    </form>
                </div>
                <div class="col-3 my-4">
                    {{-- {{dd($_POST['mapel_id'])}} --}}
                    @if (isset($_POST['mapel_id']))
                        @php
                            $find_Emapel = App\Models\Learning\Emengajar::where('kelas_id', request('kelas_id'))
                                ->where('tapel_id', $etapels->id)
                                ->where('semester', request('semester'))
                                ->where('mapel_id', $_POST['mapel_id'])
                                ->first();
                            // dd($etapels->id);
                            // dd($find_Emapel);
                        @endphp
                        @if ($find_Emapel !== null)
                            <div class='form-group'>
                                <div class='card-header bg-primary mb-2'>
                                    <h3 class='card-title'>Data Mata Pelajaran</h3>
                                </div>
                                <x-inputallin>readonly:Mata Pelajaran:Mata
                                    Pelajaran:Name:id_Name:{{ $find_Emapel->EmengajarToMapel->mapel }}:disabled</x-inputallin>
                                <x-inputallin>readonly:Nama Guru:Nama
                                    Guru:detailguru_id:detailguru_id:{{ $find_Emapel->emengajartoDetailgurus->nama_guru }}:disabled</x-inputallin>
                            </div>
                        @else
                        <div class='form-group'>
                            <div class='card-header bg-primary mb-2'>
                                <h3 class='card-title'>Data Mata Pelajaran</h3>
                            </div>
                            TIdak Ada Data Di Database yang ditampilkan
                        </div>
                         @endif
                    @else
                    @endif
                </div>
                <div class="col-3 my-4">
                    {{-- {{dd($_POST['mapel_id'])}} --}}
                    @if (isset($_POST['mapel_id']))
                        @php
                            $find_Emapel = App\Models\Learning\Emengajar::where('kelas_id', request('kelas_id'))
                                ->where('tapel_id', $etapels->id)
                                ->where('semester', request('semester'))
                                ->where('mapel_id', $_POST['mapel_id'])
                                ->first();
                            // dd($etapels->id);
                            // dd($find_Emapel);
                        @endphp
                        @if ($find_Emapel !== null)
                            <div class='form-group'>
                                <div class='card-header bg-success mb-2'>
                                    <h3 class='card-title'>Data Mata Pelajaran</h3>
                                </div>
                                <x-inputallin>readonly:KKM Mapel:KKM Mapel:::{{ $find_Emapel->EmengajarToMapel->mapel }}:disabled</x-inputallin>
                                <x-inputallin>readonly:Nama Guru:Nama Guru:detailguru_id:detailguru_id:{{ $find_Emapel->emengajartoDetailgurus->nama_guru }}:disabled</x-inputallin>
                            </div>
                        @else
                        <div class='form-group'>
                            <div class='card-header bg-primary mb-2'>
                                <h3 class='card-title'>Data Mata Pelajaran</h3>
                            </div>
                            TIdak Ada Data Di Database yang ditampilkan
                        </div>
                         @endif
                    @else
                    @endif
                </div>

            </div>
            <div class='ml-2'>
                <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                    <thead>
                        <tr class='text-center table-primary'>
                            <th class='text-center align-middle' width='1%' rowspan='2'>ID</th>
                            @foreach ($arr_ths as $arr_th)
                                <th class='text-center align-middle' rowspan='2'> {{ $arr_th }}</th>
                            @endforeach
                            <th class='text-center' colspan='5'> Nilai</th>
                            <th class='text-center align-middle' width='10%' rowspan='2'>Rata - Rata</th>
                        </tr>
                        <th class='text-center table-primary'> TA</th>
                        <th class='text-center table-primary'> TB</th>
                        <th class='text-center table-primary'> TC</th>
                        <th class='text-center table-primary'> TD</th>
                        <th class='text-center table-primary'> TE</th>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr>
                                <td class='text-center'>{{ $loop->iteration }}</td>
                                <td width='8%' class='text-center'> {{ $data->EnilaiUlangantoDetailSiswas->nis }}
                                </td>
                                <td class='text-left'> {{ $data->EnilaiUlangantoDetailSiswas->nama_siswa }}</td>
                                <td class='text-center'> {{ $data->ulangana }}</td>
                                <td class='text-center'> {{ $data->ulanganb }}</td>
                                <td class='text-center'> {{ $data->ulanganc }}</td>
                                <td class='text-center'> {{ $data->ulangand }}</td>
                                <td class='text-center'> {{ $data->ulangane }}</td>
                                <td class='text-center'>
                                    {{ ($data->tugasa + $data->tugasb + $data->tugasc + $data->tugasd + $data->tugase) / 5 }}
                                </td>
                            </tr>
                            {{-- Modal View Data Akhir --}}
                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                aria-labelledby='EditModalLabel' aria-hidden='true'>
                                <x-edit-modal>
                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                    <section>
                                        {{-- <form id='updateurl' action='{{ route('url.update', $data->id) }}' --}}
                                        <form id='updateurl' action='#' method='POST'>
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
                            <th class='text-center'> TA</th>
                            <th class='text-center'> TB</th>
                            <th class='text-center'> TC</th>
                            <th class='text-center'> TD</th>
                            <th class='text-center'> TE</th>
                            <th class='text-center align-middle'>Rata - Rata</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>

    </section>
</x-layout>


{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

<script>
    $(document).ready(function() {
        // Sembunyikan tombol submit saat halaman dimuat
        $('#submiter').hide();

        // Saat Mata Pelajaran dipilih
        $('#mapels').change(function() {
            if ($(this).val() !== '') {
                $('#semester').prop('disabled', false).attr('required',
                    'required'); // Aktifkan dropdown semester
            } else {
                $('#semester').prop('disabled', true).removeAttr('required').val(''); // Reset semester
                $('#submiter').hide(); // Sembunyikan tombol submit
            }
        });

        // Saat Semester dipilih, pastikan dua-duanya tidak kosong
        $('#semester').change(function() {
            if ($('#mapels').val() !== '' && $(this).val() !== '') {
                $('#post_mapel #submiter').fadeIn(); // Tampilkan tombol submit
            } else {
                $('#post_mapel #submiter').fadeOut(); // Sembunyikan jika salah satu kosong
            }
        });

        // Saat tombol submit ditekan
        $('#submiter').click(function() {
            $('#post_mapel').submit(); // Submit form
        });
    });
</script>
