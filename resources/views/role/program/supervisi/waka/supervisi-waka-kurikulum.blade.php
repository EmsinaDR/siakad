@php
    //content
    use App\Models\Admin\Ekelas;
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
                       <form action="{{ route('supervisi-waka-kurikulum.store') }}"
                            method="POST">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="bidang" value="Waka Kurikulum">
                            {{-- <input type="hidden" name="kelas_id" value="{{ $data->id }}"> --}}
                            <button type="submit" class='btn btn-block  btn-primary btn-sm btn-equal-width'><i class="fa fa-plus"></i> Tambah Data Supervisi</button>
                        </form>
                   </div>
                   <div class='col-xl-10'></div>
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
                        {{-- Catatan :
                        - Include Komponen Modal CRUD + Javascript / Jquery
                        - Perbaiki Onclick Tombol Modal Create, Edit
                        - Variabel Active Crud menggunakan ID User
                         --}}
                        <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                            <thead>
                                <tr class='text-center'>
                                    <th class='text-center align-middle' width='1%'>ID</th>
                                    @foreach ($arr_ths as $arr_th)
                                        <th class='text-center align-middle'> {{ $arr_th }}</th>
                                    @endforeach
                                    <th class='text-center align-middle'>Action</th>
                                    {{-- @if ($activecrud === 1)
                                              {{-- @endif --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        <td class='text-center'>{{ $loop->iteration }}</td>
                                        <td class='text-center' width='10%'> {{ $data->Tapel->tapel }} / {{ $data->Tapel->tapel + 1 }}</td>
                                        <td class='text-center' width='10%'>{{$data->Guru->nama_guru ?? ''}}</td>
                                        <td class='text-center' width='10%'> {{ $Instrumens }} Indikator</td>
                                        <td class='text-center' width='10%'>
                                            {{ optional($data->where('bidang', $data->bidang))->sum('nilai') ?? 0 }}
                                        </td>

                                        <td width='10%'>
                                            <div class='gap-1 d-flex justify-content-center'>
                                                <!-- Button untuk mengedit -->
                                                <form action="{{ route('supervisi-waka-kurikulum.store') }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('POST')
                                                    <input type="hidden" name="bidang" value="Waka Kurikulum">
                                                    <button type="submit"
                                                        class='btn btn-primary btn-sm btn-equal-width'><i
                                                            class="fa fa-edit"></i></button>
                                                </form>
                                                <!-- Form untuk menghapus -->
                                                <form id='delete-form-{{ $data->tapel_id }}'
                                                    action='{{ route('supervisi-waka-kurikulum.destroy', $data->tapel_id) }}'
                                                    method='POST' style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                </form>

                                                <button type='button' class='btn btn-danger btn-sm btn-equal-width'
                                                    onclick='confirmDelete({{ $data->tapel_id }})'>
                                                    <i class='fa fa-trash'></i>
                                                </button>

                                                <script>
                                                    function confirmDelete(tapelId) {
                                                        if (confirm('Apakah Anda yakin ingin menghapus semua data dengan tapel_id ini?')) {
                                                            document.getElementById('delete-form-' + tapelId).submit();
                                                        }
                                                    }
                                                </script>

                                            </div>
                                            {{-- Modal View Data Akhir --}}

                                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                                aria-labelledby='EditModalLabel' aria-hidden='true'>

                                                <x-edit-modal>
                                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                    <section>
                                                        <form id='updateurl'
                                                            action='{{ route('supervisi-waka-kurikulum.update', $data->tapel_id) }}'
                                                            method='POST'>
                                                            @csrf
                                                            @method('PATCH')

                                                            contentEdit

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
