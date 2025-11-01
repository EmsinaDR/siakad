@php
use App\Models\Emateri;

$activecrud = collect([2,4, 6, 8])->search(Auth::user()->id);
$urlroot = app('request')->root();
$urlUpdateInModal = app('request')->root().'/etugas-siswa/createtugas/';

// dd($etugas);

@endphp


<x-layout>

    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- {{ dd($mapel_id .'/'.$tingkat_id) }} --}}
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
            {{-- Papan Informasi --}}
            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->
            <div class='my-2 mr-2'>
                <div class="row pl-2">
                    <div class="col-xl-4">
                        <form id='#id' action='' method='POST'>
                            @csrf
                            {{-- @method('POST') --}}
                            <div class='card-header bg-success pl-2'>
                                <h3 class='card-title'>Tugas</h3>
                            </div>
                            <div class='alert alert-info alert-dismissible m-2'>
                                <h5><i class='icon fas fa-info'></i> Information !</h5>
                                <hr>
                                <p>Tugas yang di input disini akan dikirim ke akun siswa berdasarkan kelasnya masing - masing</p>
                            </div>
                            @php
                            // $kelas_mengajar = ekel
                            @endphp
                            <div class='card-body'>
                                <input type='hidden' name='mapel_id' id='mapel_id' value='{{ request('mapel_id') }}'>
                                <input type='hidden' name='tingkat_id' id='tingkat_id' value='{{ request('tingkat_id') }}'>

                                <div class='form-group'>
                                    <!-- Jika menggunakan multiple select2 tambahkan id dengan id berbeda -->
                                    <label>Kelas</label>
                                    <select id='kelas_id' class='select2' name='kelas_id[]' multiple='multiple' data-placeholder='Kelas Mengajar' style='width: 100%;'>
                                        <option value=''>--- Pilih Kelas ----</option>
                                        @foreach($kelas_mengajar as $kelas)
                                        <option value='{{ $kelas->kelas_id }}'>{{ $kelas->emengajartokelas->kelas }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-dropdownmateri>{{ $mapel_id }}/{{ $tingkat_id }}</x-dropdownmateri>
                                {{-- type/Label/Placeholder/name/id/Required + dll --}}
                                <x-inputallin>date:Batas Waktu::deadline:deadline:::Required:</x-inputallin>
                                <x-inputallin>textarea:Keterangan:Isikan Keterangan Detail Tugas yang dapat dijelaskan:keterangan:keterangan:::Required:</x-inputallin>
                                <x-inputallin>type:Link:Sumber referensi:link:id_link:::Required</x-inputallin>
                                <x-btn>submit/Save/fa fa-save/btn-primary float-right</x-btn>
                            </div>
                        </form>
                    </div>
                    <div class="col-xl-8">
                        <div class='card-header bg-success'>
                            <h3 class='card-title'>Riwayat Tugas</h3>
                        </div>
                        <div class="card-body">
                            <table id='example1' width='100%' class='table table-bordered table-hover'>
                                <thead class="table-primary">
                                    <tr class='text-center'>
                                        <th class='text-center' width="1%">#</th>
                                        <th class='text-center'>Materi</th>
                                        <th class='text-center' width="5%">Kelas</th>
                                        <th class='text-center'>Dealine</th>
                                        <th class='text-center'>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($etugas as $tugas)
                                    @php
                                    // dd($tugas->indikator_id);

                                    $tugas['indikator'] = explode(',', $tugas->indikator_id);
                                    // dd($tugas['indikator']);

                                    $tugas['kelas'] = $kelas->emengajartokelas->kelas;
                                    foreach($tugas['indikator'] as $indikator){
                                    // $tugas= Emateri::select('indikator')->where('id', $indikator)->pluck('indikator');
                                    $tugase= Emateri::find($indikator);
                                    $tugas->indikator =$tugase->indikator;

                                    // dd($tugas->indikator);
                                    // $tugas= $indikator->etugastomateri();
                                    }
                                    @endphp


                                    <tr>
                                        <td class='text-center'>{{$loop->iteration}}</td>
                                        <td class='text-center'>{{ $tugas->materi }}</td>
                                        <td class='text-center'>{{ $tugas->etugastokelas->kelas }}</td>
                                        <td class='text-center'>{{ $tugas->deadline }}</td>

                                        <td width="35%">
                                            <div class='gap-1 d-flex justify-content-center'>
                                                <!-- Button untuk melihat -->
                                                <button type='button' class='btn btn-success btn-sm btn-equal-width' data-toggle='modal' data-target='#viewModal{{ $tugas->id }}'>
                                                    <i class='fa fa-eye'></i> Lihat
                                                </button>
                                                <!-- Button untuk mengedit -->
                                                <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $tugas->id }}'>
                                                    <i class='fa fa-edit'></i> Edit
                                                </button>
                                                <!-- Form untuk menghapus -->
                                                <form action='{{ route('data-tugas.destroy', ['mapel_id' => $mapel_id, 'semester' => 'II', 'tingkat_id' => $tingkat_id, 'kelas_id' => $kelas_id, 'data_tuga' => $tugas->id]) }}' method='POST' style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type='submit' class='btn btn-danger btn-sm btn-equal-width' onclick="return confirm(' Apakah Anda yakin ingin menghapus tugas ini?');">
                                                        <i class='fa fa-trash'></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- Modal View Data Akhir --}}
                                    <div class='modal fade' id='editModal{{ $tugas->id }}' tabindex='-1' aria-labelledby='EditModalLabel' aria-hidden='true'>
                                        <x-edit-modal>
                                            <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                            <section>
                                                <form id='updateEtugas' action='{{ route('data-tugas.update', ['mapel_id' => $mapel_id, 'semester' => 'II', 'tingkat_id' => $tingkat_id, 'kelas_id' => $kelas_id, 'data_tuga' => $tugas->id]) }}' method='POST'>

                                                    @csrf
                                                    @method('PUT')
                                                    <div class='form-group'>
                                                        <label for='ekelas_id'>Kelas {{ $tugas->kelas_id }}</label>
                                                        {{-- <select id='ekelas' name='kelas_id' class='form-control' required>
                                                            <option value=''>--- Pilih ---</option>
                                                            @foreach($kelas_mengajar as $kelas)
                                                            <option value='{{ $kelas->kelas_id }}'>{{ $kelas->emengajartokelas->kelas }}</option>
                                                            @endforeach

                                                        </select> --}}
                                                        <select id='ekelas_id1' name='kelas_id' class='form-control' multiple='multiple' data-placeholder='Kelas Mengajar' style='width: 100%;'>
                                                            <option value=''>--- Pilih ---</option>
                                                            @foreach($kelas_mengajar as $kelas)
                                                            @if($kelas->kelas_id !== $tugas->kelas_id)
                                                                <option value='{{ $kelas->kelas_id }}'>{{ $tugas->kelas_id }}</option>
                                                            @else
                                                                <option value='{{ $kelas->kelas_id }}' selected>{{ $kelas->emengajartokelas->kelas }} {{ $tugas->kelas_id }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <x-inputallin>date:Batas Waktu::deadline:edeadline:{{ $tugas->deadline }}:Required</x-inputallin>
                                                    <div class='form-group'>
                                                        <label for='link'>Link Referensi</label>
                                                        <input type='text' class='form-control' id='link' name='link' placeholder='Link Referensi' value='{{ $tugas->link }}' required>
                                                    </div>
                                                    <x-inputallin>textarea:Keterangan:Isikan Keterangan Detail Tugas yang dapat dijelaskan:keterangan:eketerangan:{{ $tugas->keterangan }}:Required</x-inputallin>

                                                    <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'> Kirim</button>



                                                </form>

                                            </section>
                                        </x-edit-modal>
                                    </div>
                                    {{-- Modal Edit Data Akhir --}}
                                    {{-- Modal View --}}
                                    <div class='modal fade' id='viewModal{{ $tugas->id }}' tabindex='-1' aria-labelledby='ViewModalLabel' aria-hidden='true'>

                                        <x-view-modal>
                                            <x-slot:titleviewModal>{{ $titleviewModal }}</x-slot:titleviewModal>
                                            <section>
                                                <x-inputallin>date:Batas Waktu::deadline:edeadline:{{ $tugas->deadline }}:Disabled</x-inputallin>
                                                <div class='form-group'>
                                                    <label for='link'>Link Referensi</label>
                                                    <input type='text' class='form-control' id='link' name='link' placeholder='Link Referensi' value='{{ $tugas->link }}' Disabled>

                                                </div>
                                                <x-inputallin>textarea:Keterangan:Isikan Keterangan Detail Tugas yang dapat dijelaskan:keterangan:eketerangan:{{ $tugas->keterangan }}:Disabled</x-inputallin>
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
            </div>
        </div>
    </section>
</x-layout>
<script>
    function CreateModal(data) {
        // Show Modal Create Data
        var CreateteModal = new bootstrap.Modal(document.getElementById('createModal'));
        CreateteModal.show();
        // Kirim Nilai Ke Modal byID
        document.getElementById('ctapel_id').value = data.tapel_id;
    }

</script>
