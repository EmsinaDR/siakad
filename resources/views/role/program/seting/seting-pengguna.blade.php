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
                   </div>
                   <div class='col-xl-10'>
                    <div class='card'>
                    <div class='card-header bg-success'><h3 class='card-title'><i class='fas fa-text-width'></i>Data Informasi</h3></div><!-- /.card-header -->
                    <div class='card-body'>
                    <dl><dt>Informasi Pengguna</dt>
                        <dd>Disini pengaturan pengguna program yang tersedia pada menu program yang akan aktiv berdasarkan pemegang program aktif</dd>
                        <dd>Pengaturan ini sama halnya pengaturan role user</dd>
                    <dt></dt><dd></dd>
                    <dt></dt><dd></dd></dl>
                    </div><!-- /.card-body -->
                    </div>
                   </div>
               </div>
               <div class="row p-2">
                <div class="col-xl-12">
                </div>
               </div>
               {{-- blade-formatter-enable --}}


            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
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
                                @foreach ($datas as $data)
                                    {{-- blade-formatter-disable --}}
                                    <tr>
                                        <td class='text-center'>{{ $loop->iteration }}</td>
                                        <td class='text-left'> {{ $data->nama_program }}</td>
                                        <td class='text-center'> {{ $data->pemegang }}</td>
                                        <td class='text-center'> {{ $data->jumlah_user }}</td>
                                        <td class='text-left'>
                                            @php
                                                $decoded_ids = json_decode($data->detailguru_id, true) ?? [];
                                                $data->daftar_guru = \App\Models\User\Guru\Detailguru::whereIn('id', $decoded_ids)->get();
                                            @endphp
                                            <ul>
                                                @forelse ($data->daftar_guru as $guru)
                                                    <li>{{ $guru->nama_guru }}</li>
                                                @empty
                                                    <em class='text-danger'>Belum ada guru yang dipilih</em>
                                                @endforelse
                                            </ul>

                                        </td>

                                        <td width='10%'>
                                            @if($Identitas->paket !== 'Gratis')
                                            <div class='gap-1 d-flex justify-content-center'>
                                                <!-- Button untuk mengedit -->
                                                <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i> </button>
                                                <!-- Form untuk menghapus -->
                                                <form id='delete-form-{{ $data->id }}' action='{{ route('seting-pengguna-program.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i> </button>
                                            </div>
                                            @endif
                                            {{-- blade-formatter-enable --}}
                                    {{-- Modal View Data Akhir --}}

                                    <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                        aria-labelledby='EditModalLabel' aria-hidden='true'>

                                        <x-edit-modal>
                                            <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                            <section>
                                                <form id='updateurl'
                                                    action='{{ route('seting-pengguna-program.update', $data->id) }}'
                                                    method='POST'>
                                                    @csrf
                                                    @method('PATCH')

                                                    {{-- blade-formatter-disable --}}
                                                            <x-inputallin>readonly:Nama Program:Label:Placeholder:Name:Program {{ $data->nama_program }}:readonly</x-inputallin>
                                                            @php
                                                                $datachoce = json_decode($data->detailguru_id, true);
                                                            @endphp
                                                            <div class='form-group'>
                                                                <label for='detailguru_id'>Nama Guru Pengguna</label>
                                                                <select id='id_detailguru-{{ $data->id }}'
                                                                    name='detailguru_id[]'
                                                                    data-placeholder="Data Guru"
                                                                    data-preselect='@json($datachoce)'
                                                                    class='select2 form-control' multiple="multiple"
                                                                    data-placeholder="Pilih Guru" style="width: 100%;">
                                                                    @foreach ($Gurus as $newnama)
                                                                        <option value='{{ $newnama->id }}'> {{ $newnama->nama_guru }}</option>
                                                                    @endforeach
                                                                </select>

                                                            </div>
                                                            {{-- blade-formatter-enable --}}
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
                                    <th class='text-center'>Action</th>
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
