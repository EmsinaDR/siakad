@php

    use App\Models\Admin\Etapel;
    use App\Models\User\Siswa\Detailsiswa;
    $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
    $urlroot = app('request')->root();
@endphp
<x-layout>

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
                    <x-btnjs>submit/Tambah Data/fa fa-plus/btn btn-primary btn-xl bg-primary
                        btn-app/inputAll()</x-btnjs>
                    <x-btnjs>submit/Ambil Data Siswa/fa fa-plus/btn btn-primary btn-xl bg-primary
                        btn-app/TambahMapel()</x-btnjs>
                    <a
                        href="{{ app('request')->root() }}/elearning/{{ request('mapel_id') }}/{{ request('semester') }}/{{ request('tingkat_id') }}/{{ request('kelas_id') }}/nilai/data-nilai-tugas">
                        <x-btnjs>button/Ambil Data Siswa/fa fa-users/btn btn-primary btn-xl bg-primary
                            btn-app/</x-btnjs>
                    </a>
                </div>
            </div>
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->


            <div class='ml-2 mt-5'>
                @php
                    $datakelas = App\Models\Admin\Ekelas::where('id', request('kelas_id'))->first();
                    $mapel = App\Models\Admin\Emapel::where('id', request('mapel_id'))->first();
                    $gurumengajar_id = App\Models\Learning\Emengajar::where('kelas_id', request('kelas_id'))
                        ->where('kelas_id', request('kelas_id'))
                        ->where('semester', request('semester'))
                        ->where('mapel_id', request('mapel_id'))
                        ->first();
                    // dd($datakelas);
                    $Jumlah_Siswa = App\Models\User\Siswa\Detailsiswa::where('kelas_id', request('kelas_id'))->count();
                    // dd($Jumlah_Siswa);
                @endphp
                <div class="row d-flex justify-content-center gap-4">
                    <div class="col-xl-3">
                        <x-inputallin>readonly:Kelas:Placeholder:kelas:id_kelas:{{ $datakelas->kelas }}:disabled</x-inputallin>
                        <x-inputallin>readonly:Wali
                            Kelas:Placeholder:detailguru_id:id_detailguru_id:{{ $datakelas->kelastoDetailguru->nama_guru }}:disabled</x-inputallin>
                    </div>
                    <div class="col-xl-3  ml-3">
                        <x-inputallin>:Mapel:Placeholder:mapel_id:id_mapel_id:{{ $gurumengajar_id->emengajartomapel->mapel }}:Required</x-inputallin>
                        <x-inputallin>type:Guru
                            Mapel:Placeholder:detailguru_id:detailguru_id:{{ $gurumengajar_id->emengajartoDetailgurus->nama_guru }}:Required</x-inputallin>
                        <x-inputallin>type:Jumlah
                            Siswa:Placeholder:Name:id_Name:{{ $Jumlah_Siswa }}:Required</x-inputallin>
                    </div>
                </div>
                <hr>
                <div class="card m-2">
                    <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                        <thead>
                            <tr class='text-center'>
                                <th class='text-center align-middle' rowspan='2' width='1%'>ID</th>
                                @foreach ($arr_ths as $arr_th)
                                    <th class='text-center align-middle' rowspan='2'> {{ $arr_th }}</th>
                                @endforeach
                                <th colspan='5'>Nilai Tugas</th>
                                <th class='text-center align-middle' rowspan='2'>Rata - Rata</th>
                                <th class='text-center align-middle' rowspan='2'>Action</th>
                            </tr>
                            <th class='text-center'>TA</th>
                            <th class='text-center'>TB</th>
                            <th class='text-center'>TC</th>
                            <th class='text-center'>TD</th>
                            <th class='text-center'>TE</th>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                                <tr>
                                    <td class='text-center'>{{ $loop->iteration }}</td>
                                    <td class='text-left'> {{ $data->EnilaitugastoDetailSiswas->nama_siswa }}</td>
                                    <td class='text-center'> {{ $data->EnilaitugastoDetailSiswas->nis }}</td>
                                    <td class='text-center'> {{ $data->tugasa }}</td>
                                    <td class='text-center'> {{ $data->tugasb }}</td>
                                    <td class='text-center'> {{ $data->tugasc }}</td>
                                    <td class='text-center'> {{ $data->tugasd }}</td>
                                    <td class='text-center'> {{ $data->tugase }}</td>
                                    <td class='text-center'>
                                        {{ array_sum([$data->tugasa, $data->tugasb, $data->tugasc, $data->tugasd, $data->tugase]) / count([$data->tugasa, $data->tugasb, $data->tugasc, $data->tugasd, $data->tugase]) }}
                                    </td>
                                    <td>
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
                                            <!-- Form untuk menghapus -->
                                            <form
                                                action='{{ route('nilai-tugas.destroy', [
                                                    'mapel_id' => request('mapel_id'),
                                                    'semester' => request('semester'),
                                                    'tingkat_id' => request('tingkat_id'),
                                                    'kelas_id' => request('kelas_id'),
                                                    'nilai_tuga' => $data->id,
                                                ]) }}'
                                                method='POST' style='display: inline-block;'>
                                                {{-- {{ route('nilai-tugas.destroy', ['kelas_id' => $data->kelas_id]) }} --}}
                                                @csrf
                                                @method('DELETE')
                                                <button type='submit' class='btn btn-danger btn-sm btn-equal-width'
                                                    onclick="return confirm(' Apakah Anda yakin ingin menghapus data ini?');"><i class='fa fa-trash'></i> Hapus
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
                                            <form id='updateurl'
                                                action='{{ route('nilai-tugas.update', [
                                                    'mapel_id' => request('mapel_id'),
                                                    'semester' => request('semester'),
                                                    'tingkat_id' => request('tingkat_id'),
                                                    'kelas_id' => request('kelas_id'),
                                                    'nilai_tuga' => $data->id,
                                                ]) }}'
                                                method='POST'>
                                                @csrf
                                                @method('PUT')

                                                {{-- <x-dropdown-materib>{{ mapel_id }}/{{ tingkat_id }}</x-dropdown-materib> --}}
                                                {{-- <x-inputallin>type:Placeholder::name:id:{{ $data->deadline }}:Disabled</x-inputallin> --}}
                                                <x-inputallin>readonly:Nama:Placeholder:nama_siswa:id_nama_siswa:{{ $data->EnilaitugastoDetailSiswas->nama_siswa }}:Readonly</x-inputallin>
                                                <x-inputallin>readonly:Kelas:Placeholder:kelas_idview:id_kelas_id:{{ $data->EnilaitugastoEkelass->kelas }}:readonly</x-inputallin>
                                                <x-inputallin>readonly:Kelas:Placeholder:kelas_id:id_kelas_id:{{ $data->kelas_id }}:readonly</x-inputallin>
                                                <div class="row">
                                                    <div width='23%' class="col mt-2">
                                                        <x-inputallin>number:Nilai Tugas
                                                            1:0:tugasa:tugasa:{{ $data->tugasa }}:Required</x-inputallin>
                                                    </div>
                                                    <div width='23%' class="col mt-2">
                                                        <x-inputallin>number:Nilai Tugas
                                                            2:0:tugasb:tugasb:{{ $data->tugasb }}:Required</x-inputallin>
                                                    </div>
                                                    <div width='23%' class="col mt-2">
                                                        <x-inputallin>number:Nilai Tugas
                                                            3:0:tugasc:tugasc:{{ $data->tugasc }}:Required</x-inputallin>
                                                    </div>
                                                    <div width='23%' class="col mt-2">
                                                        <x-inputallin>number:Nilai Tugas
                                                            4:0:tugasd:tugasd:{{ $data->tugasd }}:Required</x-inputallin>
                                                    </div>
                                                    <div width='23%' class="col mt-2">
                                                        <x-inputallin>number:Nilai Tugas
                                                            5:0:tugase:tugase:{{ $data->tugase }}:Required</x-inputallin>
                                                    </div>
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
<button class='btn btn-warning btn-sm' onclick='inputAll()'><i class='fa fa-edit right'></i> Edit</button>

<script>
    function inputAll(data) {
        var inputAll = new bootstrap.Modal(document.getElementById('inputAllNilai'));
        inputAll.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='inputAllNilai' tabindex='-1' aria-labelledby='modalLabel' aria-hidden='true'>
    <div class='modal-dialog modal-xl'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='modalLabel'>
                    Input Data Nilai
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                @php
                    $datasiswa = App\Models\User\Siswa\Detailsiswa::where('kelas_id', request('kelas_id'))->get();
                @endphp
                <form id='updateurl'
                    action='{{ route('upadaAllIn-tugas.update', [
                        'mapel_id' => request('mapel_id'),
                        'semester' => request('semester'),
                        'tingkat_id' => request('tingkat_id'),
                        'kelas_id' => request('kelas_id'),
                        'nilai_tuga' => 'NIlai Tugas',
                    ]) }}'
                    method='POST'>
                    @csrf
                    @method('POST')

                    {{-- <button type='button' id='allin' class='btn btn-block btn-default bg-primary btn-sm'>All In</button> --}}
                    {{-- <table id='example2' width='100%' class='table table-bordered table-hover'> --}}
                    <table id='example2' width='100%' class='table table-responsive table-bordered table-hover'>
                        <thead>
                            <tr class='text-center align-middle'>
                                <th class='text-center align-middle' width='2%' rowspan='2'>ID</th>
                                <th class='text-center align-middle' width='30%' rowspan='2'>Nama</th>
                                <th class='text-center align-middle' colspan='5'>Tugas</th>
                            </tr>
                            <th width='10%' class='text-center align-middle'>TA</th>
                            <th width='10%' class='text-center align-middle'>TB</th>
                            <th width='10%' class='text-center align-middle'>TC</th>
                            <th width='10%' class='text-center align-middle'>TD</th>
                            <th width='10%' class='text-center align-middle'>TE</th>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                                <input type='hidden' name='id_data[]' id='id' placeholder='id'
                                    value='{{ $data->id }}'>
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class='text-left'> {{ $data->EnilaitugastoDetailSiswas->nama_siswa }}</td>
                                    <td class='text-center'>
                                        <x-inputallin-nolabel>number::0:tugasa[]:id_tugasa:{{ $data->tugasa }}:</x-inputallin-nolabel>
                                    <td class='text-center'>
                                        <x-inputallin-nolabel>number::0:tugasb[]:id_tugasb:{{ $data->tugasb }}:</x-inputallin-nolabel>
                                    <td class='text-center'>
                                        <x-inputallin-nolabel>number::0:tugasc[]:id_tugasc:{{ $data->tugasc }}:</x-inputallin-nolabel>
                                    <td class='text-center'>
                                        <x-inputallin-nolabel>number::0:tugasd[]:id_tugasd:{{ $data->tugasd }}:</x-inputallin-nolabel>
                                    <td class='text-center'>
                                        <x-inputallin-nolabel>number::0:tugase[]:id_tugase:{{ $data->tugase }}:</x-inputallin-nolabel>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class='text-center align-middle'>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>TA</th>
                                <th>TB</th>
                                <th>TC</th>
                                <th>TD</th>
                                <th>TE</th>
                            </tr>
                        </tfoot>
                    </table>
                    <script>
                        $('#allin').click(function() {
                            $('input').val(80);
                            $('#id_tugasa').val(80);
                        })
                    </script>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
