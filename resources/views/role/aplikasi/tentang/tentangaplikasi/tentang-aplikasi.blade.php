@php
    //content
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
    $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
    $urlroot = app('request')->root();
@endphp
<style>
    .check-item {
        position: relative;
        padding-left: 25px;
        /* Memberikan ruang untuk icon */
    }

    .check-item::before {
        content: '✔️';
        /* Menambahkan icon checklist */
        list-style-type: none;
        position: absolute;
        left: 0;
        top: 0;
        font-size: 20px;
        /* Ukuran icon */
        margin-right: 8px;
        /* Kasih jarak ke kanan dari icon */
    }

    ul {
        list-style-type: none;
        padding-left: 0;
    }

    /* Jarak antar judul */
    h2,
    h3,
    h4 {
        margin-bottom: 15px;
        /* Menambah jarak bawah pada judul */
    }

    /* Jarak antar paragraf */
    p {
        margin-bottom: 20px;
        /* Menambah jarak bawah pada paragraf */
        line-height: 1.6;
        /* Mengatur jarak antar baris dalam paragraf */
    }

    /* Jarak antar list item */
    ul {
        padding-left: 0;
        margin-bottom: 20px;
        /* Menambah jarak bawah pada seluruh list */
    }

    ul li {
        margin-bottom: 10px;
        /* Menambah jarak bawah pada setiap item dalam list */
    }
</style>

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
            <!--Card Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</h3>
            </div>
            <!--Card Header-->
            <div class='row m-2'>
                <div class='col-xl-2'>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'>
                        <i class='fa fa-plus'></i> Tambah Data
                    </button>
                </div>
                <div class='col-xl-10'></div>
            </div>
            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <!-- Konten -->
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
                                        <td class='text-left'> {{ $data->judul }}</td>
                                        <td class='text-center'> {{ $data->versi }}</td>
                                        <td class='text-center'> {{ $data->level }}</td>
                                        <td class='text-left'> </td>

                                        <td width='10%'>
                                            <div class='gap-1 d-flex justify-content-center'>
                                                <button type='button' class='btn btn-success btn-sm btn-equal-width' data-toggle='modal' data-target='#viewModal{{ $data->id }}'><i class='fa fa-eye'></i> </button>
                                                @if (Auth::user()->posisi === 'Admindev')
                                                <!-- Button untuk mengedit -->
                                                <a href="{{route('tentang-aplikasi.show', $data->id)}}"><button type='button' class='btn btn-warning btn-sm btn-equal-width'><i class='fa fa-edit'></i> </button></a>
                                                <!-- Form untuk menghapus -->
                                                    <form id='delete-form-{{ $data->id }}' action='{{ route('tentang-aplikasi.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <button type='button' class='btn btn-danger btn-sm btn-equal-width'
                                                        onclick='confirmDelete({{ $data->id }})'> <i
                                                            class='fa fa-trash'></i> </button>
                                                @endif
                                            </div>
                                            {{-- Modal View Data Akhir --}}

                                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                                aria-labelledby='EditModalLabel' aria-hidden='true'>

                                                <x-edit-modal>
                                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                    <section>


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
                                                        {!! $data->content !!}
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
