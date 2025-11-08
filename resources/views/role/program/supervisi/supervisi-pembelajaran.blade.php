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


            <div class='row m-2'>
                <div class='col-xl-2'>
                    {{-- <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'> <i class='fa fa-plus'></i> Tambah Data</button> --}}
                </div>
                <div class='col-xl-10'></div>
            </div>


            <div class='ml-2 my-4'>
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
                            <th>Action</th>
                            {{-- @if ($activecrud === 1)
                                         {{-- @endif --}}
                        </tr>
                    </thead>
                    <tbody>
                        {{-- blade-formatter-disable --}}
                        @php $no = 1; @endphp
                        {{-- blade-formatter-enable --}}
                        @foreach ($datas as $tingkat_id => $group)
                            @foreach ($group as $data)
                                <tr>
                                    <td class='text-center'>{{ $no++ }}</td>
                                    <td>{{ $data->Guru->nama_guru }}</td>
                                    <td>{{ $data->Mapel->mapel ?? 'Tidak ada data' }}</td>
                                    <td class='text-center'> {{ $data->Kelas->kelas }}</td>

                                    <td width='10%'>
                                        <div class='gap-1 d-flex justify-content-center'>
                                            <form action="{{ route('supervisi-pembelajaran.store') }}"
                                                method="POST">
                                                @csrf
                                                @method('POST')
                                                <input type="hidden" name="kategori" value="Modul Ajar">
                                                <input type="hidden" name="detailguru_id"
                                                    value="{{ $data->detailguru_id }}">
                                                <input type="hidden" name="kelas_id" value="{{ $data->kelas_id }}">
                                                <input type="hidden" name="mapel_id" value="{{ $data->mapel_id }}">
                                                <button type="submit" class='btn btn-primary btn-sm btn-equal-width'><i
                                                        class="fa fa-edit"></i></button>
                                            </form>
                                            <form id='delete-form-{{ $data->id }}'
                                                action='{{ route('supervisi-pembelajaran.destroy', $data->id) }}'
                                                method='POST' style='display: inline-block;'>
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <button type='button' class='btn btn-danger btn-sm btn-equal-width'
                                                onclick='confirmDelete({{ $data->id }})'> <i
                                                    class='fa fa-trash'></i>
                                            </button>
                                            {{-- blade-formatter-enable --}}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
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
