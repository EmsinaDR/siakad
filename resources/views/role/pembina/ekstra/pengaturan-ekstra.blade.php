@php
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
            <div class='card-body'>
                {{-- blade-formatter-disable --}}
                <div class='row float-right'>
                    <x-btnjs>submit/Tambah Data/fa fa-plus/btn btn-primary btn-xl bg-primary btn-app/namaModal()</x-btnjs>
                    <button class='btn btn-warning btn-sm' onclick='PengaturanJadwal()'><i class='fa fa-edit right'></i> Edit</button>
                </div>
                {{-- blade-formatter-enable --}}
            </div>
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                {{ $title }} <b>{{ optional($Ekstra_name?->Ekstra)->ekstra ?? 'Ekstra tidak tersedia' }}</b>
            </div>
            <!--Car Header-->


            <div class='ml-2 my-4'>
                <div class="row">
                    <div class="col-xl-6">
                        <div class='card-header bg-primary'>
                            <h3 class='card-title'>Data Ekstra</h3>
                        </div>
                        <div class='card-body'>
                            @php
                                $data_ekstra = App\Models\WakaKesiswaan\Ekstra\RiwayatEkstra::where(
                                    'ekstra_id',
                                    request()->segment(3),
                                )->first();
                            @endphp
                            {{-- blade-formatter-disable --}}
                            <x-inputallin>readonly:Nama Ekstra:Placeholder:ekstra:id_ekstra:{{$data_ekstra->Ekstra->ekstra}}:readonly</x-inputallin>
                            <x-inputallin>readonly:Pembina:Placeholder:pembina:id_pembina:{{$data_ekstra->Detailguru->nama_guru}}:readonly</x-inputallin>
                            <x-inputallin>readonly:Pelatih:::id_:{{ $data_ekstra->pelatih }}:readonly</x-inputallin>
                            <x-inputallin>readonly:Jadwal Latihan:Placeholder:jadwal:id_jadwal:{{$data_ekstra->jadwal}}:readonly</x-inputallin>
                            <x-inputallin>readonly:Peserta:Placeholder:peserta:id_peserta:{{ $data_ekstra->peserta }}:readonly</x-inputallin>
                            {{-- blade-formatter-enable --}}
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class='card-header bg-primary'>
                            <h3 class='card-title'>Total Jumlah Kehadiran</h3>
                        </div>

                                <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                                    <thead>
                                           <tr class='text-center'>
                                            <th width='1%'>ID</th>
                                               @foreach ($arr_ths as $arr_th)
                                            <th class='text-center'> {{ $arr_th }}</th>
                                               @endforeach
                                            <th>Action</th>
                                               {{-- @if($activecrud === 1)
                                              {{-- @endif--}}
                                           </tr>
                                    </thead>
                                    <tbody>
                                           @foreach ($datas as $data)
                                           <tr>
                                               <td class='text-center'>{{ $loop->iteration }}</td>
                                               <td class='text-center'> {{ $data->nama_pengaturan}}</td>
                                               <td class='text-center'> {{ $data->isi}}</td>
                                               <td class='text-center'> {{ $data->keterangan}}</td>

                                               <td width='20%'>
                                                     <div class='gap-1 d-flex justify-content-center'>

                                                            <!-- Button untuk melihat -->
                                                            <!-- <button type='button' class='btn btn-success btn-sm btn-equal-width' data-toggle='modal' data-target='#viewModal{{ $data->id }}'><i class='fa fa-eye'></i> Lihat</button> -->
                                                            <!-- Button untuk mengedit -->
                                                            <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i> Edit</button>
                                                            <!-- Form untuk menghapus -->
                                                            {{-- <form action='{{ route('url.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type='submit' class='btn btn-danger btn-sm btn-equal-width' onclick=`return confirm('Apakah Anda yakin ingin menghapus data ini?');`><i class='fa fa-trash'></i> Hapus</button>
                                                            </form> --}}

                                                     </div>
                                                </td>
                                             </tr>
                                             {{-- Modal View Data Akhir --}}

                                             <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1' aria-labelledby='EditModalLabel' aria-hidden='true'>

                                                 <x-edit-modal>
                                                     <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                     <section>
                                                            <form id='updateurl' action='{{ route('pengaturan-ekstra.update', $data->id) }}' method='POST'>
                                                                @csrf
                                                                @method('PATCH')

                                                                   contentEdit

                                                                <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'> Kirim</button>
                                                            </form>

                                                     </section>
                                                 </x-edit-modal>
                                             </div>
                                             {{-- Modal Edit Data Akhir --}}
                                             {{-- Modal View --}}

                                             <div class='modal fade' id='viewModal{{ $data->id }}' tabindex='-1' aria-labelledby='ViewModalLabel' aria-hidden='true'>


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
                                               {{-- @if($activecrud === 1)--}}
                                               <th class='text-center'>Action</th>
                                               {{-- @endif--}}
                                           </tr>
                                    </tfoot>
                                </table>
                        <form id='#id' action='{{ route('pengaturan-ekstra.store') }}' method='POST'>
                            @csrf
                            @method('POST')
                            {{-- blade-formatter-disable --}}
                            <x-inputallin>hidden:::ekstra_id::{{request()->segment(3)}}:Required</x-inputallin>
                            <x-inputallin>hidden:::nama_pengaturan:id_nama_pengaturan:Total Kehadiran:Required</x-inputallin>
                            <x-inputallin>type:Jumlah Kehadiran:Jumlah Kehadiran Total:isi:id_isi::Required</x-inputallin>
                            {{-- blade-formatter-enable --}}
                            <div class="col-xl-12"><button type='submit'
                                    class='btn btn-default bg-primary btn-md float-right mt-2'><i class="fa fa-save"></i> Save</button>
                            </div>
                        </form>
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

                <x-inputallin>type:Total Kehadiran:Jumlah pelaksanaa
                    ekstra:total_kehadiran:id_total_kehadiran::Required</x-inputallin>

            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
            </div>
        </div>
    </div>
</div>


<script>
    function PengaturanJadwal(data) {
        var PengaturanJadwal = new bootstrap.Modal(document.getElementById('PengaturanJadwal'));
        PengaturanJadwal.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='PengaturanJadwal' tabindex='-1' aria-labelledby='LabelPengaturanJadwal' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelPengaturanJadwal'>
                    Pengaturan Jadwal Ekstra
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                @php
                    $jadwal_latihan = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    $pesertas = ['Sebagian', 'Seluruh'];

                @endphp
                <div class='form-group'>
                    <label for='jadwal'>Pilih Hari Latihan</label>
                    <select name='jadwal' class='form-control' required>
                        <option value=''>--- Pilih Hari Latihan ---</option>
                        @foreach ($jadwal_latihan as $newjadwal_latihan)
                            <option value='{{ $newjadwal_latihan }}'>{{ $newjadwal_latihan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class='form-group'>
                    <label for='peserta'>Keterangan Peserta</label>
                    <select name='peserta' class='form-control' required>
                        <option value=''>--- Pilih Keterangan Peserta ---</option>
                        @foreach ($pesertas as $peserta)
                            <option value='{{ $peserta }}'>{{ $peserta }}</option>
                        @endforeach
                    </select>
                </div>
                <x-inputallin>type:Nama Pelatih:Nama Pelatih:pelatih:pelatih::Required</x-inputallin>

            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
            </div>
        </div>
    </div>

</div>
