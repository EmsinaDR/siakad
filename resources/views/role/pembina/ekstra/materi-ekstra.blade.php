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
               <div class='container-fluid'>
                    <div class='row'>
                        <div class='col'>
                            <!-- Papan Informasi  -->
                            <div class='row'>
                                <div class='col-lg-3 col-6'>
                                    <!-- small box / Data BOX-->
                                    <div class='small-box bg-info'><!-- Background -->
                                        <h3 class='m-2'>Materi</h3><!-- Judul -->
                                        <div class='inner'><!-- Isi Kontent -->
                                            <div class='d-flex justify-content-between'>
                                                <span>Jumlah Materi</span><span>{{$jumlah_materi}}</span>
                                            </div>
                                            <div class='d-flex justify-content-between'>
                                                <span>Sub Materi</span><span>{{$jumlah_sub_materi}}</span>
                                            </div>
                                            <div class='d-flex justify-content-between'>
                                                <span>Indikator</span><span>{{$jumlah_indikator}}</span>
                                            </div>
                                        </div>
                                        <div class='icon'>
                                            <i class='fa fa-wallet'></i><!-- Icon -->
                                        </div>
                                        <a href='#' class='small-box-footer'>More info <i class='fas fa-arrow-circle-right'></i></a>
                                    </div>
                                    <!-- small box -->
                                </div>
                                <!-- ./col -->
                            </div>
                            <!-- Papan Informasi  -->
                            {{-- <x-footer></x-footer> --}}


                        </div>
                    </div>
                </div>
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2 mt-2'>
                <h3 class='card-title'>{{ $title }} <b>{{ optional($Ekstra_name?->Ekstra)->ekstra ?? 'Ekstra tidak tersedia' }}</b></h3>
            </div>
            <!--Car Header-->


            <div class='ml-2 my-4'>
                <div class='card-body'>
                    <div class='row float-right'>
                        <x-btnjs>submit/Tambah Data/fa fa-plus/btn btn-primary btn-xl bg-primary
                            btn-app/namaModal()</x-btnjs>
                    </div>
                </div>
                <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                    <thead>
                        <tr class='text-center table-primary'>
                            <th width='1%'>ID</th>
                            @foreach ($arr_ths as $arr_th)
                                <th class='text-center'> {{ $arr_th }}</th>
                            @endforeach
                            <th>Action</th>
                            {{-- @if ($activecrud === 1)
                                         {{-- @endif --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr>
                                <td class='text-center'>{{ $loop->iteration }}</td>
                                <td class='text-center'> {{ $data->materi }}</td>
                                <td class='text-center'> {{ $data->sub_materi }}</td>
                                <td class='text-center'> {{ $data->indikator }}</td>

                                <td width='20%'>
                                    <div class='gap-1 d-flex justify-content-center'>
                                        <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                            data-toggle='modal' data-target='#editModal{{ $data->id }}'><i
                                                class='fa fa-edit'></i> Edit</button>
                                        <form id='delete-form-{{ $data->id }}'
                                            action='{{ route('materi-ekstra.destroy', $data->id) }}' method='POST'
                                            style='display: inline-block;'>
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button type='button' class='btn btn-danger btn-sm btn-equal-width'
                                            onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i>
                                            Hapus </button>
                                    </div>
                                </td>
                            </tr>
                            {{-- Modal View Data Akhir --}}

                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                aria-labelledby='EditModalLabel' aria-hidden='true'>

                                <x-edit-modal>
                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                    <section>
                                        <form id='updateurl' action='{{ route('materi-ekstra.update', $data->id) }}'
                                            method='POST'>
                                            @csrf
                                            @method('PATCH')

                                            {{-- blade-formatter-disable --}}
                                            <x-inputallin>type:Materi:Materi Ekstra:materi:id_materi:{{ $data->materi }}:Required</x-inputallin>
                                            <x-inputallin>type:Sub Materi:Sub Materi:sub_materi:id_sub_materi:{{ $data->sub_materi }}:Required</x-inputallin>
                                            <x-inputallin>type:Indikator:Indikator materi:indikator:id_indikator:{{ $data->indikator }}:Required</x-inputallin>
                                            {{-- blade-formatter-enable --}}

                                            <button id='kirim' type='submit'
                                                class='btn float-right btn-default bg-primary btn-xl mt-4'>
                                                Kirim</button>
                                        </form>

                                    </section>
                                </x-edit-modal>
                            </div>
                            {{-- Modal Edit Data Akhir --}}
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class='text-center'>
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

                <form id='updateurl' action='{{ route('materi-ekstra.store') }}' method='POST'>
                    @csrf
                    @method('POST')
                    <input type='hidden' name='ekstra_id' id='ekstra_id' placeholder='ekstra_id'
                        value='{{ request()->segment(3) }}'>
                    {{-- blade-formatter-disable --}}
                    <x-inputallin>type:Materi:Materi Ekstra:materi:id_materi::Required</x-inputallin>
                    <x-inputallin>type:Sub Materi:Sub Materi:sub_materi:id_sub_materi::Required</x-inputallin>
                    <x-inputallin>type:Indikator:Indikator materi:indikator:id_indikator::Required</x-inputallin>
                    {{-- blade-formatter-enable --}}
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>
