@php
    use Illuminate\Http\Request;
    $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
@endphp


<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>
    <section class='content mx-2'>
        <div class='card'>
            {{-- Papan Informasi --}}
            <div class='card-body'>
                <div class='row float-right'>
                    <x-btnjs>submit/Tambah Data/fa fa-plus/btn btn-primary btn-xl bg-primary
                        btn-app/TambahMateri()</x-btnjs>

                </div>
            </div>
            {{-- Papan Informasi --}}
            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->
            <div class='ml-2'>
                @if ($errors->any())
                    <div class="alert alert-danger my-2">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class='alert alert-info alert-dismissible mt-2 mr-2'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h5><i class='icon fas fa-info'></i> Information !</h5>
                    <hr>
                    KS : Kompleksitas<br>
                    DS : Daya Serap<br>
                    DD : Daya Dukung<br>

                </div>
                <div class='card-body mr-2 ml-2'>
                    <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                        <thead>
                            <tr class='text-center'>
                                <th class='text-center  align-middle' rowspan="2" width='2%'>ID</th>
                                {{-- @foreach ($arr_ths as $arr_th)
                                <th rowspan="2" class='text-center  align-middle'> {{ $arr_th }}</th>
                                @endforeach --}}
                                @foreach ($arr_ths as $arr_th)
                                    <th class='text-center align-middle' rowspan='2'> {{ $arr_th }}</th>
                                @endforeach
                                <th width='10%' class='text-center  align-middle' colspan="3">KKM</th>
                                <th width='3%' class='text-center  align-middle' rowspan="2">KKM Total</th>
                                <th width='20%' class='text-center  align-middle' rowspan="2">Action</th>
                            </tr>
                            <th class='text-center'>KS</th>
                            <th class='text-center'>DS</th>
                            <th class='text-center'>DD</th>



                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                                <tr>
                                    <td class='text-center'>{{ $loop->iteration }}</td>
                                    {{-- Hilangkan Bagian untuk update materi --}}
                                    @if (isset($mapel_id))
                                    @else
                                        <td width="7%" class='text-center'>{{ $data->EmaeritoMapel->mapel }}</td>
                                        {{-- Hilangkan Bagian untuk update materi --}}
                                    @endif
                                    <td class='text-center'>{{ $data->materi }}</td>
                                    {{-- Hilangkan Bagian untuk update materi --}}
                                    @if (isset($mapel_id))
                                    @else
                                        <td class='text-left'>{{ $data->sub_materi }}</td>
                                        {{-- Hilangkan Bagian untuk update materi --}}
                                    @endif
                                    <td class='text-justify'>{{ $data->indikator }}</td>
                                    <td class='text-center'>{{ $data->kkm_kompleksitas }}</td>
                                    <td class='text-center'>{{ $data->kkm_dayaserap }}</td>
                                    <td class='text-center'>{{ $data->kkm_dayadukung }}</td>
                                    <td class='text-center'>
                                        {{ number_format(($data->kkm_kompleksitas + $data->kkm_dayaserap + $data->kkm_dayadukung) / 3, 1) }}
                                    </td>

                                    <td>
                                        <div class='gap-1 d-flex justify-content-center'>
                                            <!-- Button untuk melihat -->
                                            {{-- <button type='button' class='btn btn-success btn-sm btn-equal-width' data-toggle='modal' data-target='#viewModal{{ $data->id }}'>
                                            <i class='fa fa-eye'></i> Lihat
                                        </button> --}}
                                            <!-- Button untuk mengedit -->
                                            <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                                data-toggle='modal' data-target='#editModal{{ $data->id }}'>
                                                <i class='fa fa-edit'></i> Edit
                                            </button>
                                            <!-- Form untuk menghapus -->
                                            <form
                                                action='{{ route('data-materi.destroy', ['mapel_id' => $mapel_id, 'semester' => 'II', 'tingkat_id' => $tingkat_id, 'kelas_id' => $kelas_id, 'data_materi' => $data->id]) }}'
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
                                <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                    aria-labelledby='EditModalLabel' aria-hidden='true'>
                                    <x-edit-modal>
                                        <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                        <section>
                                            <form
                                                action='{{ route('data-materi.update', ['mapel_id' => $mapel_id, 'semester' => 'II', 'tingkat_id' => $tingkat_id, 'kelas_id' => $kelas_id, 'data_materi' => $data->id]) }}'
                                                method='POST' style='display: inline-block;'>
                                                @csrf
                                                @method('PATCH')
                                                <section>
                                                    <div class='form-group'>
                                                        <label for='semester'>Semester</label>
                                                        <select id='semesteredit' name='semester' class='form-control'
                                                            required>
                                                            {{-- <option value='I'>I</option>
                                                        <option value='II'>II</option> --}}
                                                            @php
                                                                $dataq = ['I', 'II'];
                                                            @endphp
                                                            @foreach ($dataq as $datar)
                                                                <option value='{{ $datar }}'>
                                                                    {{ $datar }}</option>
                                                            @endforeach
                                                        </select>
                                                        <script>
                                                            $('#semesteredit option[value="II"]').prop('selected', true);
                                                        </script>
                                                    </div>
                                                    <x-inputallin>type:Materi
                                                        Ajar:Materi:materi:id_materi:{{ $data->materi }}:Required</x-inputallin>
                                                    <x-inputallin>type:Sub Materi Ajar:Sub
                                                        Materi:sub_materi:id_sub_materi:{{ $data->sub_materi }}:Required</x-inputallin>
                                                    <x-inputallin>type:Indikator:Indikator proeses
                                                        pembelajaran:indikator:id_indikator:{{ $data->indikator }}:Required</x-inputallin>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <x-inputallin>type:KKM Komplesotas:KKM Kompleksitas
                                                                mtaeri:kkm_kompleksitas:id_kkm_kompleksitas:{{ $data->kkm_kompleksitas }}:Required</x-inputallin>
                                                        </div>
                                                        <div class="col-4">
                                                            <x-inputallin>type:KKM Daya Setap:KKM Daya Serap
                                                                Materi:kkm_dayaserap:id_kkm_daya_serap:{{ $data->kkm_dayaserap }}:Required</x-inputallin>
                                                        </div>
                                                        <div class="col-4">
                                                            <x-inputallin>type:KKM Daya Dukung:KKM Daya Dukung
                                                                Materi:kkm_dayadukung:id_kkm_daya_dukung:{{ $data->kkm_dayadukung }}:Required</x-inputallin>
                                                        </div>
                                                    </div>
                                                </section>
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
                                <th style='width:50px'>KS</th>
                                <th width='2%' class='text-center'>DS</th>
                                <th width='5%' class='text-center'>DD</th>
                                <th class='text-center  align-middle'>KKM Total</th>
                                <th class='text-center'>Action</th>
                            </tr>
                        </tfoot>
                    </table>


                </div>
            </div>

        </div>
    </section>

</x-layout>

<script>
    function ModalUpdateSemester(data) {
        var ModalUpdateSemester = new bootstrap.Modal(document.getElementById('ModalUpdateSemester'));
        ModalUpdateSemester.show();
        document.getElementById('Eid').value = data.id;
    }

    function ViewModal(data) {
        // Show Modal View Data
        var ViewModal = new bootstrap.Modal(document.getElementById('viewModal'));
        ViewModal.show();
        // Kirim Nilai Ke Modal byID
        document.getElementById('vmateri').value = data.materi;
        document.getElementById('vsub_materi').value = data.sub_materi;
        document.getElementById('vindikator').value = data.indikator;
        document.getElementById('vkkm_kompleksitas').value = data.kkm_kompleksitas;
        document.getElementById('vkkm_dayaserap').value = data.kkm_dayaserap;
        document.getElementById('vkkm_dayadukung').value = data.kkm_dayadukung;

    }

    function TambahMateri(data) {
        // Show Modal Edit Data
        var TambahMateri = new bootstrap.Modal(document.getElementById('createModal'));
        TambahMateri.show();
    }
</script>

{{-- Modal Create Data Awal --}}
<div class='modal fade' id='createModal' tabindex='-1' aria-labelledby='CreateModalLabel' aria-hidden='true'>
    <x-create-modal>
        <form id='#id'
            {{-- action='{{ route('data-materi.store', ['mapel_id' => $mapel_id, 'semester' => 'II', 'tingkat_id' => $tingkat_id, 'kelas_id' => $kelas_id, 'data_materi' => $data->id]) }}' --}}
            method='POST'>
            @csrf
            <x-slot:titlecreateModal>{{ $titlecreateModal }} </x-slot:titlecreateModal>
            <section>
                <input type="hidden" name="mapel_id" id="mapel_id" value="{{ $mapel_id }}">
                <input type="hidden" name="tingkat_id" id="tingkat_id" value='{{ $tingkat_id }}'>

                <div class='form-group'>
                    <label for='semester'>Semester</label>
                    <select id='semester' name=' semester' class='form-control' required>
                        <option value='I'>I</option>
                        <option value='II'>II</option>
                    </select>
                </div>
                <x-inputallin>type:Materi Pokok:Tuliskan Materi Pokok:materi:id_materi::Required</x-inputallin>
                <x-inputallin>type:Sub Materi:Tuliskan Sub Materi:sub_materi:id_sub_materi::Required</x-inputallin>
                <x-inputallin>type:Indikator:Tuiiskan indikator materi:indikator:id_indikator::Required</x-inputallin>
                {{-- <x-inputs-typeb>Materi:Tuliskan materi pokok:cmateri:Required::/Sub Materi:Tuliskan sub materi:csub_materi:Required::/Indikator:indikator:cindikator:Required::</x-inputs-typeb> --}}
                <div class="row">
                    <div class="col-4">
                        <x-inputs-typeb>KKM Kompleksitas:kkm_kompleksitas:ckkm_kompleksitas:Required::</x-inputs-typeb>
                    </div>
                    <div class="col-4">
                        <x-inputs-typeb>KKM Dayaserap:kkm_dayaserap:ckkm_dayaserap:Required::</x-inputs-typeb>
                    </div>
                    <div class="col-4">
                        <x-inputs-typeb>KKM Daya Dukung:kkm_dayadukung:ckkm_dayadukung:Required::</x-inputs-typeb>
                    </div>
                </div>
                <x-btn>submit/Save/fa fa-save/btn btn-default bg-primary float-right</x-btn>
            </section>
        </form>
    </x-create-modal>
</div>
{{-- Modal Create Data Akhir --}}
