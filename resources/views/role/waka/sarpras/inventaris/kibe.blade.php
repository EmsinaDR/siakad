@php
    //KIB E
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
                <h3 class='card-title'>{{ $title }} - Jalan, Irigasi, dan Jaringan</H3>
            </div>
            <!--Car Header-->


            <div class='ml-2 my-4'>
                KIB E
                <div class="card">
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>Data Informasi KIB E</h3>
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
                                    <th>Action</th>
                                    {{-- @if ($activecrud === 1)
                                          {{-- @endif --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        <td class='text-center'>{{ $loop->iteration }}</td>
                                        <td class='text-center'>{{ $data->Vendor?->nama_vendor ?? 'Tidak Ada Vendor' }}
                                        </td>
                                        <td class='text-center'> {{ $data->nama_barang }}</td>
                                        <td class='text-center'> {{ $data->jenis }}</td>
                                        <td class='text-center'> {{ $data->tahun_masuk }}</td>
                                        <td class='text-center'> {{ $data->jumlah }}</td>
                                        <td class='text-center'> Rp. {{ number_format($data->harga, 2) }}</td>
                                        <td class='text-center'>
                                            @if ($data->status === 'Baik')
                                                <span class="bg-success p-2 rounded-pill">{{ $data->status }}</span>
                                            @elseif($data->status === 'Rusak Ringan')
                                                <span class="bg-info p-2 rounded-pill">{{ $data->status }}</span>
                                            @elseif($data->status === 'Rusak Sedang')
                                                <span class="bg-warning p-2 rounded-pill">{{ $data->status }}</span>
                                            @else
                                                <span class="bg-danger p-2 rounded-pill">{{ $data->status }}</span>
                                            @endif
                                        </td>

                                        <td width='10%'>
                                            <div class='gap-1 d-flex justify-content-center'>

                                                <!-- Button untuk melihat -->
                                                <!-- <button type='button' class='btn btn-success btn-sm btn-equal-width' data-toggle='modal' data-target='#viewModal{{ $data->id }}'><i class='fa fa-eye'></i> Lihat</button> -->
                                                <!-- Button untuk mengedit -->
                                                <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                                    data-toggle='modal' data-target='#editModal{{ $data->id }}'><i
                                                        class='fa fa-edit'></i> </button>
                                                <!-- Form untuk menghapus -->
                                                <form id='delete-form-{{ $data->id }}'
                                                    action='{{ route('inventaris-kibe.destroy', $data->id) }}'
                                                    method='POST' style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type='button' class='btn btn-danger btn-sm btn-equal-width'
                                                    onclick='confirmDelete({{ $data->id }})'> <i
                                                        class='fa fa-trash'></i> </button>
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- Modal View Data Akhir --}}

                                    <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                        aria-labelledby='EditModalLabel' aria-hidden='true'>

                                        <x-edit-modal>
                                            <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                            <section>
                                                <form id='updateurl'
                                                    action='{{ route('inventaris-kibe.update', $data->id) }}'
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
