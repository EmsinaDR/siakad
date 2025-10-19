@php
    use Illuminate\Support\Carbon;
    use App\Models\User\Siswa\Detailsiswa;
    use App\Models\Admin\Emapel;
    use App\Models\Admin\Ekelas;
    use App\Models\Learning\Emateri;

    Carbon::setLocale('id');
    //$semester

    $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
    $mapel = Emapel::select('mapel')->where('id', $mapel_id)->first();
    $kelas = Ekelas::select('id', 'kelas')->where('id', $kelas_id)->first();
    // dd($mapel);
@endphp
<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>

    <section class='content mx-2'>
        <div class='card'>
            {{-- Papan Informasi --}}
            <div class='card-body'>
                <div class='row float-right'>
                    <x-btn>submit/Tambah tugas/fa fa-plus/btn btn-primary btn-xl bg-primary btn-app/TambahMapel()
                    </x-btn>
                    <x-btn>submit/Mapel Aktiv/fa fa-check/btn btn-primary btn-xl bg-primary btn-app/ModalAktivMapel()
                    </x-btn>
                </div>
            </div>

            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <div class="my-4 mx-2">
                <table id="example1" width="100%" class="table table-bordered table-hover">
                    <thead class="bg-info">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Hari dan Tanggal</th>
                            <th>Jam Ke</th>
                            <th>Indikator</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jurnal_riwayats as $jurnal_riwayat)
                            @php
                                // dd($jurnal_riwayats);
                            @endphp
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">
                                    {{ Carbon::parse($jurnal_riwayat->created_at)->translatedFormat('l, d F Y') }}</td>
                                @php
                                    // $riwayatIndikator = explode(',', $jurnal_riwayat->indikator_id);
                                    // $riwayatIndikator = explode(',', $jurnal_riwayat->indikator_id);
                                    $riwayatIndikator = json_decode($jurnal_riwayat->indikator_id, true); // Konversi JSON ke array
                                    $jamke = json_decode($jurnal_riwayat->jam_ke, true); // Konversi JSON ke array
                                    $jam_ke = implode(', ', $jamke); //

                                @endphp
                                <td class="text-center">
                                    {{ $jam_ke }}
                                </td>
                                <td>

                                    @foreach ($riwayatIndikator as $indikatorId)
                                        @php
                                            $viewIndikator = App\Models\Learning\Emateri::find($indikatorId);
                                        @endphp
                                        @if ($viewIndikator)
                                            {{ $loop->index }}. {{ $viewIndikator->indikator }} <br>
                                        @endif
                                    @endforeach

                                </td>
                                <td>
                                    <div class='gap-1 d-flex justify-content-center'>
                                        <!-- Button untuk melihat -->
                                        {{-- <button type='button' class='btn btn-success btn-sm btn-equal-width'
                                            data-toggle='modal' data-target='#viewModal{{ $jurnal_riwayat->id }}'>
                                            <i class='fa fa-eye'></i> Lihat
                                        </button> --}}
                                        <!-- Button untuk mengedit -->
                                        <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                            data-toggle='modal' data-target='#editModal{{ $jurnal_riwayat->id }}'>
                                            <i class='fa fa-edit'></i> Edit
                                        </button>
                                        <!-- Form untuk menghapus -->
                                        {{-- <form action='{{ route('ejurnalmengajar.destroy', ['mapel_id' => $mapel_id, 'semester' => 'II', 'tingkat_id' => $tingkat_id, 'kelas_id' => $kelas_id, 'id' => $jurnal_riwayat->id]) }}' method='POST' style='display: inline-block;'> --}}
                                        <form
                                            action='{{ route('ejurnalmengajar.destroy', ['mapel_id' => $mapel_id, 'semester' => 'II', 'tingkat_id' => $tingkat_id, 'kelas_id' => $kelas_id, 'id' => $jurnal_riwayat->id]) }}'
                                            method='POST' style='display: inline-block;'>
                                            @csrf
                                            @method('DELETE')
                                            <button type='submit' class='btn btn-danger btn-sm btn-equal-width'
                                                onclick="return confirm(' Apakah Anda yakin ingin menghapus data ini?');">
                                                <i class='fa fa-trash'></i> Hapus
                                            </button>

                                        </form>
                                    </div>
                                </td>
                            </tr>
                            {{-- Modal View Data Akhir --}}
                            <div class='modal fade' id='editModal{{ $jurnal_riwayat->id }}' tabindex='-1'
                                aria-labelledby='EditModalLabel' aria-hidden='true'>
                                <x-edit-modal>
                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                    <section>
                                        {{-- <form id='updateEdata' action='#}}' method='POST'> --}}
                                        {{-- <form id='updateEdata' action='{{ route('ejurnalmengajar.update', $jurnal_riwayat->id) }}' method='POST'> --}}

                                        <form id='updateEdata_jurnal{{ $loop->index }}'
                                            action='{{ route('ejurnalmengajar.update', ['mapel_id' => $mapel_id, 'semester' => 'II', 'tingkat_id' => $tingkat_id, 'kelas_id' => $kelas_id, 'id' => $jurnal_riwayat->id]) }}'
                                            method='POST'>
                                            @csrf
                                            @method('PATCH')
                                            <div class="row">
                                                <div class="col-xl-6">

                                                    <div class="card-header bg-success my-2 shadow-lg">
                                                        <h3 class="card-title">Jurnal Mengajar</h3>
                                                    </div>

                                                    <input type="hidden" name="kelas_id" value="{{ $kelas_id }}">
                                                    <input type="hidden" name="detailguru_id"
                                                        value="{{ Auth::user()->detailguru_id }}">

                                                    <div class="form-group">
                                                        <label for="kelas">Kelas</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $kelas->kelas }}" disabled>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="mapel">Mata Pelajaran</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $mapel->mapel }}" disabled>
                                                    </div>

                                                    @php
                                                        $jam_ke = json_decode($jurnal_riwayat->jam_ke, true);
                                                    @endphp
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <label for="jam_ke">Jam Ke</label>
                                                                <select id="select2-{{ $loop->index }}"
                                                                    name="jam_ke[]" class="form-control" multiple
                                                                    data-placeholder="Jam Ke" style="width: 100%;">
                                                                    <option value="">--- Pilih Jam Ke ---
                                                                    </option>
                                                                    @for ($i = 1; $i <= 12; $i++)
                                                                        <option value="{{ $i }}">
                                                                            {{ $i }}</option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <script>
                                                            $(document).ready(function() {
                                                                $('#select2-{{ $loop->index }}').val(@json($jam_ke)).trigger(
                                                                    'change'); // Mutiple Select Select value in array json

                                                            });
                                                        </script>
                                                        @php
                                                            $pertemuan_ke = $jurnal_riwayat->pertemuan_ke;
                                                            // $jurnal_riwayats = $jurnal_riwayats->values()->all();
                                                            // dd($jurnal_riwayats);
                                                        @endphp
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <label for="pertemuan_ke">Pertemuan Ke
                                                                    {{ $jurnal_riwayat->pertemuan_ke }}
                                                                    {{ $jurnal_riwayat->pertemuan_ke }}</label>
                                                                <select id='select2_{{ $loop->index }}'
                                                                    name="pertemuan_ke" class="form-control" required>
                                                                    <option value="">--- Pilih Pertemuan Ke ---
                                                                    </option>
                                                                    @for ($i = 1; $i <= 100; $i++)
                                                                        <option value="{{ $i }}">
                                                                            {{ $i }}</option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                            <script>
                                                                $(document).ready(function() {
                                                                    $('#select2_{{ $loop->index }}').val(@json($jurnal_riwayat->pertemuan_ke)).trigger(
                                                                        'change'); // Mutiple Select Select value in array json

                                                                });
                                                            </script>
                                                        </div>
                                                        <x-dropdownmateri-edit>{{ $mapel_id }}/{{ $tingkat_id }}/{{ $loop->index }}</x-dropdownmateri-edit>
                                                    </div>

                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="card-header bg-info my-2 shadow-lg">
                                                        <h3 class="card-title">Jurnal Absensi</h3>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                @php
                                                                    $siswa_alfa = json_decode(
                                                                        $jurnal_riwayat->siswa_alfa,
                                                                        true,
                                                                    );
                                                                @endphp
                                                                <label>Data Siswa Alfa</label>
                                                                <select id="amenuselect_{{ $loop->index }}"
                                                                    class="select2" name="siswa_alfa[]" multiple
                                                                    data-placeholder="Data Siswa Alfa"
                                                                    style="width: 100%;">
                                                                    <option value="">--- Pilih Data Siswa Alfa ---
                                                                    </option>
                                                                    @foreach ($users as $user)
                                                                        <option value="{{ $user->id }}">
                                                                            {{ $user->nama_siswa }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <script>
                                                                $(document).ready(function() {
                                                                    $('#amenuselect_{{ $loop->index }}').val(@json($siswa_alfa)).trigger(
                                                                        'change'); // Mutiple Select Select value in array json

                                                                });
                                                            </script>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                @php
                                                                    $siswa_bolos = json_decode(
                                                                        $jurnal_riwayat->siswa_bolos,
                                                                        true,
                                                                    );
                                                                @endphp
                                                                <label>Data Siswa Bolos</label>
                                                                <select id="bmenuselect_{{ $loop->index }}"
                                                                    class="select2" name="siswa_bolos[]" multiple
                                                                    data-placeholder="Data Siswa Bolos"
                                                                    style="width: 100%;">
                                                                    <option value="">--- Pilih Data Siswa Bolos
                                                                        ---</option>
                                                                    @foreach ($users as $user)
                                                                        <option value="{{ $user->id }}">
                                                                            {{ $user->nama_siswa }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <script>
                                                            $(document).ready(function() {
                                                                $('#bmenuselect_{{ $loop->index }}').val(@json($siswa_bolos)).trigger(
                                                                    'change'); // Mutiple Select Select value in array json

                                                            });
                                                        </script>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="form-group">@php
                                                                $siswa_ijin = json_decode(
                                                                    $jurnal_riwayat->siswa_ijin,
                                                                    true,
                                                                );
                                                            @endphp
                                                                <label>Data Siswa Ijin</label>
                                                                <select id="cmenuselect_{{ $loop->index }}"
                                                                    class="select2" name="siswa_ijin[]" multiple
                                                                    data-placeholder="Data Siswa Ijin"
                                                                    style="width: 100%;">
                                                                    <option value="">--- Pilih Data Siswa Ijin
                                                                        ---</option>
                                                                    @foreach ($users as $user)
                                                                        <option value="{{ $user->id }}">
                                                                            {{ $user->nama_siswa }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <script>
                                                                $(document).ready(function() {
                                                                    $('#cmenuselect_{{ $loop->index }}').val(@json($siswa_ijin)).trigger(
                                                                        'change'); // Mutiple Select Select value in array json

                                                                });
                                                            </script>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="form-group">@php
                                                                $siswa_sakit = json_decode(
                                                                    $jurnal_riwayat->siswa_sakit,
                                                                    true,
                                                                );
                                                            @endphp
                                                                <label>Data Siswa Sakit</label>
                                                                <select id="dmenuselect_{{ $loop->index }}"
                                                                    class="select2" name="siswa_sakit[]" multiple
                                                                    data-placeholder="Data Siswa Sakit"
                                                                    style="width: 100%;">
                                                                    <option value="">--- Pilih Data Siswa Sakit
                                                                        ---</option>
                                                                    @foreach ($users as $user)
                                                                        <option value="{{ $user->id }}">
                                                                            {{ $user->nama_siswa }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <script>
                                                                $(document).ready(function() {
                                                                    $('#dmenuselect_{{ $loop->index }}').val(@json($siswa_sakit)).trigger(
                                                                        'change'); // Mutiple Select Select value in array json

                                                                });
                                                            </script>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mx-3">
                                                        <label for="keterangan_bolos">Keterangan Bolos / Kejadian
                                                            Khusus</label>
                                                        <textarea id="keterangan_bolos" style='resize:none' name="kejadian_khusus" class="form-control" rows="4"
                                                            placeholder="Keterangan Kejadian Khusus">{{ $jurnal_riwayat->kejadian_khusus }}</textarea>
                                                    </div>

                                                </div>

                                                <button id='kirim_btn{{ $loop->index }}' type='submit'
                                                    class='btn float-right btn-default bg-primary btn-xl mt-4'>
                                                    Kirim X</button>
                                            </div>

                                        </form>
                                        <script>
                                            $('#updateEdata_jurnal{{ $loop->index }}').submit(function(e) {
                                                e.preventDefault(); // Mencegah submit langsung untuk debugging
                                                console.log($(this).serializeArray()); // Cek semua data yang dikirim
                                            });
                                            $('#kirim_btn{{ $loop->index }}').click(function() {
                                                $('#updateEdata_jurnal{{ $loop->index }}').submit();
                                            })
                                        </script>

                                    </section>
                                </x-edit-modal>
                            </div>




                            {{-- Modal Edit Data Akhir --}}
                            {{-- Modal View --}}
                            <div class='modal fade' id='viewModal{{ $jurnal_riwayat->id }}' tabindex='-1'
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
                        <tr class="text-center">
                            <th>No</th>
                            <th>Hari dan Tanggal</th>
                            <th>Jam Ke</th>
                            <th>Indikator</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                </table>


            </div>
            <form id="jurnalForm"
                action="{{ route('ejurnalmengajar.store', ['mapel_id' => $mapel_id, 'semester' => 'II', 'tingkat_id' => $tingkat_id, 'kelas_id' => $kelas_id]) }}"
                method="POST">
                @csrf
                @method('POST')

                <div class='my-2 mr-2'>
                    <div class='row pl-2'>
                        <div class="col-xl-6">

                            <div class="card-header bg-success my-2 shadow-lg">
                                <h3 class="card-title">Jurnal Mengajar</h3>
                            </div>

                            <input type="hidden" name="kelas_id" value="{{ $kelas_id }}">
                            <input type="hidden" name="detailguru_id" value="{{ Auth::user()->detailguru_id }}">

                            <div class="form-group">
                                <label for="kelas">Kelas</label>
                                <input type="text" class="form-control" value="{{ $kelas->kelas }}" disabled>
                            </div>

                            <div class="form-group">
                                <label for="mapel">Mata Pelajaran</label>
                                <input type="text" class="form-control" value="{{ $mapel->mapel }}" disabled>
                            </div>
                            <x-dropdownmateri>{{ $mapel_id }}/{{ $tingkat_id }}</x-dropdownmateri>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="jam_ke">Jam Ke</label>
                                        <select id="ejam_ke" name="jam_ke[]" class="form-control" multiple
                                            data-placeholder="Jam Ke" style="width: 100%;">
                                            <option value="">--- Pilih Jam Ke ---</option>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="pertemuan_ke">Pertemuan Ke</label>
                                        <select name="pertemuan_ke" class="form-control" required>
                                            <option value="">--- Pilih Pertemuan Ke ---</option>
                                            @for ($i = 1; $i <= 100; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card-header bg-info my-2 shadow-lg">
                                <h3 class="card-title">Jurnal Absensi</h3>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Data Siswa Alfa</label>
                                        <select id="menuselect-1" class="select2" name="siswa_alfa[]" multiple
                                            data-placeholder="Data Siswa Alfa" style="width: 100%;">
                                            <option value="">--- Pilih Data Siswa Alfa ---</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->nama_siswa }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Data Siswa Bolos</label>
                                        <select id="menuselect-2" class="select2" name="siswa_bolos[]" multiple
                                            data-placeholder="Data Siswa Bolos" style="width: 100%;">
                                            <option value="">--- Pilih Data Siswa Bolos ---</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->nama_siswa }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Data Siswa Ijin</label>
                                        <select id="menuselect-3" class="select2" name="siswa_ijin[]" multiple
                                            data-placeholder="Data Siswa Ijin" style="width: 100%;">
                                            <option value="">--- Pilih Data Siswa Ijin ---</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->nama_siswa }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Data Siswa Sakit</label>
                                        <select id="menuselect-4" class="select2" name="siswa_sakit[]" multiple
                                            data-placeholder="Data Siswa Sakit" style="width: 100%;">
                                            <option value="">--- Pilih Data Siswa Sakit ---</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->nama_siswa }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mx-3">
                                <label for="keterangan_bolos">Keterangan Bolos / Kejadian Khusus</label>
                                <textarea id="keterangan_bolos" style='resize:none' name="kejadian_khusus" class="form-control" rows="4"
                                    placeholder="Keterangan Kejadian Khusus"></textarea>
                            </div>
                            <button id='kirim' type='submit'
                                class='btn float-right btn-default bg-primary btn-xl mt-4'>
                                Kirim</button>
                        </div>

                    </div>
                    {{-- </div> --}}
                </div>
            </form>

        </div>


    </section>
</x-layout>
