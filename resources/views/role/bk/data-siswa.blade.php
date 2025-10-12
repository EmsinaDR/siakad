@php
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
@endphp
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
    <section class='content mx-2'>
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
                        btn-app/FNTambahData()()</x-btnjs>
                </div>
            </div>
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2  my-4'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->
            <div class='ml-2'>
                <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                    <thead>
                        <tr class='text-center'>
                            <th width='1%'>ID</th>
                            @foreach ($arr_ths as $arr_th)
                                <th class='text-center'> {{ $arr_th }}</th>
                            @endforeach
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($DataSiswa as $data)
                            <td class='text-center'>{{ $loop->iteration }}</td>
                            <td class='text-center'> {{ $data->nis }}</td>
                            <td class='text-left'> {{ $data->nama_siswa }}</td>
                            <td class='text-center'> {{ $data->kelas->kelas ?? '' }}</td>
                            <td class='text-center'>
                                @php
                                    $find_Ekelas = App\Models\Admin\Ekelas::find($data->kelas_id);
                                @endphp
                                {{ $find_Ekelas->kelastoDetailguru->nama_guru }}
                            </td>
                            <td class='text-left'> {{ $data->alamat_siswa }}</td>
                            <td width='20%'>
                                {{-- blade-formatter-disable --}}
                                <div class='gap-1 d-flex justify-content-center'>
                                    <!-- Button untuk melihat -->
                                    <button type='button' class='btn btn-success btn-sm btn-equal-width'  data-toggle='modal' data-target='#viewModal{{ $data->id }}'>
                                        <i class='fa fa-eye'></i>
                                    </button>
                                        <!-- Form untuk menghapus -->
                                        <form action='{{ route('bk-data-siswa.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                            @csrf
                                            @method('DELETE')
                                            <button type='submit' class='btn btn-danger btn-sm btn-equal-width' onclick="return confirm(' Apakah Anda yakin ingin menghapus data ini?');">
                                                <i class='fa fa-trash'></i>
                                            </button>
                                        </form>
                                </div>
                                {{-- blade-formatter-enable --}}
                            </td>
                            </tr>
                            {{-- Modal View --}}

                            <div class='modal fade' id='viewModal{{ $data->id }}'
                                tabindex='-1'aria-labelledby='ViewModalLabel' aria-hidden='true'>

                                <x-view-modal>
                                    <x-slot:titleviewModal>{{ $titleviewModal }}</x-slot:titleviewModal>
                                    <section>
                                        <div class='card-body'>
                                            @foreach ($data->ebkpelanggaran ?? [] as $pel)
                                                <div class="row">
                                                    <div class="col-xl-4">
                                                        {{ \Carbon\Carbon::parse($pel->created_at)->translatedFormat('l, d F Y') }}
                                                    </div>
                                                    <div class="col-xl-8">
                                                        @php
                                                            $Pelanggarans = Cache::tags([
                                                                'cache_Pelanggarans',
                                                            ])->remember(
                                                                'remember_Pelanggarans_' . Auth::id(),
                                                                now()->addMinute(2),
                                                                function () use ($pel) {
                                                                    return \App\Models\bk\Ebkkreditpoint::whereIn(
                                                                        'id',
                                                                        json_decode($pel->kreditpoint_id),
                                                                    )
                                                                        ->take(10)
                                                                        ->get();
                                                                },
                                                            );
                                                        @endphp
                                                        <ul>
                                                            @foreach ($Pelanggarans as $nama_pelanggaran)
                                                                <li>{{ $nama_pelanggaran->pelanggaran }}</li>
                                                            @endforeach
                                                        </ul>

                                                    </div>
                                                </div>
                                                <hr>
                                            @endforeach

                                        </div>
                                    </section>
                                </x-view-modal>
                                <script>
                                    $(document).ready(function() {
                                        $('viewModal{{ $data->id }}').modal('hide'); // Sembunyikan semua modal saat halaman dimuat
                                    });
                                </script>
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

    </section>
</x-layout>

<button class='btn btn-warning btn-sm' onclick='FNTambahData()'><i class='fa fa-edit right'></i> Edit</button>

<script>
    function TambahData(data) {
        var TambahData = new bootstrap.Modal(document.getElementById('TambahData'));
        TambahData.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='TambahData' tabindex='-1' aria-labelledby='LabelTambahData' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelTambahData'>
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
