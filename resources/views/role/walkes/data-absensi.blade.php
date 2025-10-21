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
                        btn-app/FNcekabsen()()</x-btnjs>
                </div>
            </div>
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->


            <div class='ml-2 my-4'>
                <table id='example6' class='table table-bordered table-responsive table-hover mt-5 mr-3'>
                    <thead>
                        <tr class='text-center bg-secondary'>
                            <th width='1%'>ID</th>
                            @foreach ($arr_ths as $arr_th)
                                <th class='text-center'> {{ $arr_th }}</th>
                            @endforeach
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)

                                    @php
                                    $id_absencek = App\Models\Absensi\Eabsen::select('waktu_absen', 'user_id')->whereDate('waktu_absen', Carbon::today())->where('user_id', $data->id)->get();
                                    // dd($id_absencek);
                                    @endphp
                            <tr>
                                <td class='text-center'>{{ $loop->iteration }}</td>
                                <td class='text-center'>
                                    {{ $data->nis }}
                                </td>
                                <td class='text-left'>
                                    {{ $data->nama_siswa }}</td>
                                <td class='text-left'>
                                    {{ Carbon::create($data->waktu_absen)->translatedformat('l, d F Y') }}
                                </td>
                                <td class='text-center'>
                                    {{ Carbon::create($data->waktu_absen)->format('H:i:s') }}
                                </td>
                                <td class='text-left text-center'>

                                    {{-- {{ $data->id }}-{{ $id_absencek }} --}}
                                    @if ($data->absen === 'hadir')
                                        <span><i class="text-success fa fa-check"></i></span>
                                    @else
                                        <i class='fa fa-times-circle p-2 text-danger'></i>
                                    @endif
                                    {{-- {{$id_absencek}} --}}
                                </td>
                                <td width='20%'>
                                    <div class='gap-1 d-flex justify-content-center'>
                                        </button>
                                        <!-- Button untuk mengedit -->
                                        <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                            data-toggle='modal' data-target='#editModal{{ $data->id }}'>
                                            <i class='fa fa-edit'></i> Edit
                                        </button>
                                        <!-- Form untuk menghapus -->
                                        <form action='#' method='POST' style='display: inline-block;'>
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
                                        <form id='updateurl' action='#}' method='POST'>
                                            @csrf
                                            @method('PATCH')
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
                        <tr class='text-center bg-secondary'>
                            <th width='1%'>ID</th>
                            @foreach ($arr_ths as $arr_th)
                                <th class='text-center'> {{ $arr_th }}</th>
                            @endforeach
                            <th class='text-center'>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>

    </section>
</x-layout>

<button class='btn btn-warning btn-sm' onclick='FNcekabsen()'><i class='fa fa-edit right'></i> Edit</button>

<script>
    function cekabsen(data) {
        var cekabsen = new bootstrap.Modal(document.getElementById('cekabsen'));
        cekabsen.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='cekabsen' tabindex='-1' aria-labelledby='Labelcekabsen' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='Labelcekabsen'>
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
