@php
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
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
                <div class='row float-right'>
                    <x-btnjs>submit/Tambah Data/fa fa-plus/btn btn-primary btn-xl bg-primary
                        btn-app/namaModal()</x-btnjs>
                </div>
            </div>
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->


            <div class='ml-2 my-4'>
                <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                    <thead>
                        <tr class='text-center'>
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
                        @foreach ($DataPeraturans as $data)
                            <tr>
                                <td class='text-center'>{{ $loop->iteration }}</td>
                                <td class='text-left'> {{ $data->peraturan }}</td>
                                <td class='text-left'> {{ $data->keterangan }}</td>

                                <td width='10%'>
                                    <div class='gap-1 d-flex justify-content-center'>
                                        {{-- blade-formatter-disable --}}
                                                       <!-- Button untuk melihat -->
                                                       <!-- Button untuk mengedit -->
                                                       <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i> </button>
                                                       <!-- Form untuk menghapus -->
                                                       <form id='delete-form-{{ $data->id }}' action='{{ route('peraturan.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                           @csrf
                                                           @method('DELETE')
                                                       </form>
                                                       <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i>  </button>
                                                       {{-- blade-formatter-enable --}}
                                    </div>
                                </td>
                            </tr>
                            {{-- Modal View Data Akhir --}}
                            {{-- blade-formatter-disable --}}
                                        <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1' aria-labelledby='EditModalLabel' aria-hidden='true'>
                                        {{-- blade-formatter-enable --}}
                            <x-edit-modal>
                                <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                <section>
                                    <form id='updateurl' action='{{ route('peraturan.update', $data->id) }}'
                                        method='POST'>
                                        @csrf
                                        @method('PATCH')

                                        {{-- blade-formatter-disable --}}
                                                              <x-inputallin>type:Peraturan:Peraturan:peraturan:id_peraturan:{{ $data->peraturan }}:Required</x-inputallin>
                                                              <x-inputallin>type:Keterangan:Keterangan:keterangan:id_keterangan:{{ $data->keterangan }}:Required</x-inputallin>
                                                              {{-- blade-formatter-enable --}}

                                        <button id='kirim' type='submit'
                                            class='btn float-right btn-default bg-primary btn-xl mt-4'> Kirim</button>
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

                <form action="{{ route('peraturan.store') }}" method="POST">
                    @csrf
                    {{-- blade-formatter-disable --}}
                    <div class='form-group'>
                       <label for='kategori'>Perpustakaan</label>
                       <input type='text' class='form-control' id='kategori' name='kategori' placeholder='peraturan' value='Perpustakaan' readonly>
                    </div>
                    {{-- <x-inputallin>text:Kategori:Masukkan Kategori:kategori::{{ old('kategori') }}:required</x-inputallin> --}}
                    <x-inputallin>text:Peraturan:Masukkan Peraturan:peraturan:id_peraturan:{{ old('peraturan') }}:required</x-inputallin>
                    <x-inputallin>text:Keterangan:Masukkan Keterangan:keterangan:id_keterangan:{{ old('keterangan') }}:required</x-inputallin>
                    {{-- blade-formatter-enable --}}

                    <button type="submit" class="btn btn-primary float-right mt-4">Simpan</button>
                </form>


            </div>
        </div>
    </div>

</div>
