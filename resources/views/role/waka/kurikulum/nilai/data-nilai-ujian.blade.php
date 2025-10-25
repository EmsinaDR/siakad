@php
    //content
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
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


            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->


            {{-- blade-formatter-disable --}}
            <div class='row m-2'>
                <div class='col-xl-2'>

                    <a href="{{route('data-peserta-ujian.index')}}"><button type='button' class='btn btn-block btn-default bg-primary btn-md'> <i class='fa fa-plus'></i> Data Peserta</button></a>
                </div>
                <div class='col-xl-2'>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahMapel()'>
                        <i class='fa fa-plus'></i> Tambah Data Pelajaran</button>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='RemoveMapel()'>
                        <i class='fa fa-trash'></i> Hapus Data Pelajaran</button>
                </div>
                <div class='col-xl-10'></div>
            </div>
            {{-- blade-formatter-enable --}}


            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>Data Nilai UJian Sekolah</h3>
                    </div>
                    <div class='card-body'>
                        {{-- Catatan :
                        - Include Komponen Modal CRUD + Javascript / Jquery
                        - Perbaiki Onclick Tombol Modal Create, Edit
                        - Variabel Active Crud menggunakan ID User
                         --}}
                        <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                            <thead>
                                <tr class='text-center'>
                                    <th width='1%'>ID</th>
                                    @foreach ($arr_ths as $arr_th)
                                        <th class='text-center'> {{ $arr_th }}</th>
                                    @endforeach
                                    <th>Jumlah</th>
                                    <th>Rata - Rata</th>
                                    <th>Action</th>
                                    {{-- @if ($activecrud === 1)
                                              {{-- @endif --}}
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($datas as $data)
                                    <tr>
                                        <td class='text-center'>{{ $loop->iteration }}</td>

                                        {{-- blade-formatter-disable --}}
                                        @php
                                            $etapels = App\Models\Admin\Etapel::where('aktiv', 'Y')->first();
                                            $Nilai = App\Models\WakaKurikulum\Elearning\Nilai\KurikulumNilaiUjian::where( 'peserta_id',$data->id)->get();
                                            $jmmapel = $Nilai->count('nilai');
                                            $NilaiTotal = $Nilai->sum('nilai');
                                            $nomor_ujian = $Nilai->pluck('nomor_ujian')->toArray();
                                        @endphp
                                        <td class='text-center'> {{ $data->Siswa->nis }}</td>
                                        <td class='text-center'> {{ $data->nomor_ujian }}</td>
                                        <td class='text-center'> {{ $data->Kelas->kelas }}</td>
                                        <td class='text-center'> {{ $data->Siswa->nama_siswa }}</td>
                                        <td class='text-center'> {{ $Nilai->sum('nilai') }}</td>
                                        <td class='text-center'>
                                            @if ($Nilai->isEmpty())
                                            0
                                            @else
                                                {{ number_format($Nilai->sum('nilai') / $Nilai->count('nilai'), 2) }}
                                            @endif
                                        </td>
                                        {{-- blade-formatter-enable --}}
                                        <td width='10%'>
                                            {{-- blade-formatter-disable --}}
                                            <div class='gap-1 d-flex justify-content-center'>
                                                <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i> </button>
                                            </div>
                                            {{-- blade-formatter-enable --}}
                                            {{-- Modal View Data Akhir --}}

                                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                                aria-labelledby='EditModalLabel' aria-hidden='true'>

                                                <x-edit-modal>
                                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                    <section>
                                                        <form id='updateurl'
                                                            action='{{ route('data-nilai-ujian.update', $data->id) }}'
                                                            method='POST'>
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="row my-2">
                                                                <div class="col-xl-4 d-flex justify-content-center">
                                                                    <img src='{{app('request')->root()}}/img/siswa/user-siswa.png' alt='' style="width: 150px; height: 250px;">
                                                                </div>
                                                                <div class="col-xl-8">
                                                                    <x-inputallin>readonly:Nama Siswa:Placeholder::id_:{{ $data->Siswa->nama_siswa }}:readonly</x-inputallin>
                                                                    <x-inputallin>readonly:Kelas:Placeholder::id_:{{ $data->Kelas->kelas }}:readonly</x-inputallin>
                                                                    <x-inputallin>readonly:Nomor Ujian:Placeholder::id_:{{ $data->nomor_ujian }}:readonly</x-inputallin>
                                                                </div>
                                                            </div>
                                                            <table id='example1' width='100%'
                                                                class='table table-bordered table-hover'>
                                                                <thead>
                                                                    <tr class='text-center align-middle table-primary'>
                                                                        <th>ID</th>
                                                                        <th>Mapel</th>
                                                                        <th>KKM</th>
                                                                        <th>Nilai</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                   {{-- blade-formatter-disable --}}
                                                                    @foreach ($Nilai as $data)
                                                                        <tr class='text-center'>
                                                                            <td>{{ $loop->iteration }}</td>
                                                                            <td class='text-left align-middle'>{{ $data->Mapel->mapel }}</td>
                                                                            <td class='text-left align-center'>
                                                                                @php
                                                                                $KKM = $KKMMapel->where('mapel_id', $data->mapel_id)->first()
                                                                                @endphp
                                                                                {{$KKM ->kkm}}
                                                                            </td>
                                                                            <input type="hidden" name='id[]'
                                                                                value='{{ $data->id }}'>
                                                                            <td width='10%'><input type='text' class='form-control' name='nilai[]' id='nilai' placeholder='nilai' value='{{ $data->nilai }}'></td>
                                                                        </tr>
                                                                    @endforeach
                                                                   {{-- blade-formatter-enable --}}
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr class='text-center align-middle'>
                                                                        <th>ID</th>
                                                                        <th>Mapel</th>
                                                                        <th>KKM</th>
                                                                        <th>Nilai</th>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>

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
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class='text-center'>
                                    <th width='1%'>ID</th>
                                    @foreach ($arr_ths as $arr_th)
                                        <th class='text-center'> {{ $arr_th }}</th>
                                    @endforeach
                                    {{-- @if ($activecrud === 1) --}}
                                    <th>Jumlah</th>
                                    <th>Rata - Rata</th>
                                    <th>Action</th>
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
{{-- <button class='btn btn-warning btn-sm' onclick='TambahMapel()'><i class='fa fa-edit right'></i> Edit</button> --}}
{{--
onclick='TambahMapel()'
 --}}

<script>
    function TambahMapel(data) {
        var TambahMapel = new bootstrap.Modal(document.getElementById('TambahMapel'));
        TambahMapel.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='TambahMapel' tabindex='-1' aria-labelledby='LabelTambahMapel' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelTambahMapel'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <form id='#id' action='{{ route('data-nilai-ujian.store') }}' method='POST'>
                    @csrf
                    @method('POST')
                    @php
                        $MapelId = App\Models\Admin\Emapel::all();
                        $MapelIdRemove = App\Models\WakaKurikulum\Elearning\Nilai\KurikulumNilaiUjian::select(
                            'mapel_id',
                        )
                            ->distinct('mapel_id')
                            ->get();
                    @endphp

                    <div class='card'>
                        <div class='card-header bg-info'>
                            <h3 class='card-title'><i class='fas fa-text-width pr-2'></i>Data Informasi</h3>
                        </div><!-- /.card-header -->
                        <div class='card-body'>
                            <dl>
                                <dt>Penambahan Mata Pelajaran</dt>
                                <dd>Penambahan mata pelajaran dapat diartikan setiap siswa ditambahkan mata pelajaran
                                    yang
                                    terpilih
                                    disertai semua datanya termasuk nilai pada tahun pelajaran saat ini</dd>
                            </dl>
                            <dl>
                                <dt>Data Mata Pelajaran</dt>
                                <dd>Data mata pelajaran ujian saat ini : <b>{{ $MapelIdRemove->count() }} Data Mata
                                        Pelajaran</b> </dd>
                                @foreach ($MapelIdRemove as $index => $DataMapel)
                                    {{ $DataMapel->Mapel->mapel }}@if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </dl>
                        </div><!-- /.card-body -->
                    </div>
                    <div class='form-group'>
                        <!-- Jika menggunakan multiple select2 tambahkan id dengan id berbeda -->
                        <label for='select2-1'>Pilih Mata Pelajaran</label>
                        <select id='select2-1' class='select2' name='mapel_id[]' multiple='multiple'
                            data-placeholder='Pilih mata Pelajaran' style='width: 100%;'>
                            <option value=''>--- Pilih Mata Pelajaran ----</option>
                            @foreach ($MapelId as $mapel)
                                <option value='{{ $mapel->id }}'>{{ $mapel->mapel }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>
{{-- <button class='btn btn-warning btn-sm' onclick='RemoveMapel()'><i class='fa fa-edit right'></i> Edit</button> --}}
{{--
onclick='RemoveMapel()'
 --}}

<script>
    function RemoveMapel(data) {
        var RemoveMapel = new bootstrap.Modal(document.getElementById('RemoveMapel'));
        RemoveMapel.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='RemoveMapel' tabindex='-1' aria-labelledby='LabelRemoveMapel' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelRemoveMapel'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <form id='#id' action='{{ route('data-nilai-ujian.destroy') }}' method='POST'>
                    @csrf
                    @method('DELETE')
                    <div class='form-group'>
                        <div class='card'>
                            <div class='card-header bg-info'>
                                <h3 class='card-title'><i class='fas fa-text-width pr-2'></i>Data Informasi</h3>
                            </div><!-- /.card-header -->
                            <div class='card-body'>
                                <dl>
                                    <dt>Penghapusan Mata Pelajaran</dt>
                                    <dd>Penghapusan mata pelajaran dapat diartikan setiap siswa dihapus mata pelajaran
                                        yang terpilih
                                        disertai semua datanya termasuk nilai pada tahun pelajaran saat ini</dd>
                                </dl>
                                <dl>
                                    <dt>Data Mata Pelajaran</dt>
                                    <dd>Data mata pelajaran ujian saat ini : <b>{{ $MapelIdRemove->count() }} Data Mata
                                            Pelajaran</b> </dd>
                                </dl>
                            </div><!-- /.card-body -->
                        </div>
                        <!-- Jika menggunakan multiple select2 tambahkan id dengan id berbeda -->
                        <label for='select2-2'>Pilih Mata Pelajarann</label>
                        <select id='select2-2' class='select2' name='mapel_id[]' multiple='multiple'
                            data-placeholder='Pilih mata Pelajaran' style='width: 100%;'>
                            <option value=''>--- Pilih Mata Pelajaran ----</option>
                            @foreach ($MapelIdRemove as $DataMapel)
                                <option value='{{ $DataMapel->mapel_id }}'>{{ $DataMapel->Mapel->mapel }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>
