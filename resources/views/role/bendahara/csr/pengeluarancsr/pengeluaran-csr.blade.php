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
            <!--Card Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</h3>
            </div>
            <!--Card Header-->
            <div class='row m-2'>
                <div class='col-xl-2'>
                    {{-- <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'><i class='fa fa-plus'></i> Tambah Data </button> --}}
                </div>
                <div class='col-xl-10'></div>
            </div>
            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <div class='row'>
                            <div class="col-xl-3">
                                <div class='card-header bg-primary mb-2'>
                                    <h3 class='card-title'>Input Pengeluaran</h3>
                                </div>
                                {{-- blade-formatter-disable --}}
                                <form id='#id' action='{{ route('pengeluaran-csr.store') }}' method='POST'>
                                    @csrf
                                    @method('POST')
                                    <div class='form-group'>
                                        <label for='date'>Tanggal</label>
                                        <input type="date" class="form-control" id="date" name="tanggal" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>

                                    </div>
                                    <div class='form-group'>
                                        <label for='sumber_dana'>Sumber Dana</label>
                                        <select name='sumber_dana' id='id' class='form-control'  data-placeholder='Pilih Sumber Dana' required>
                                            <option value=''>--- Pilih Sumber Dana ---</option>
                                            @foreach ($DanaPemasukkans as $DanaPemasukkan)
                                                <option value='{{ $DanaPemasukkan->id }}'>
                                                    {{ $DanaPemasukkan->sumber_dana }} -
                                                    {{ $DanaPemasukkan->nama_corporate }} - Rp.
                                                    {{ number_format($DanaPemasukkan->nominal, 0) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class='form-group'>
                                        <label for='pengeluaran'>Nominal</label>
                                        <input type='text' class='form-control' id='pengeluaran' name='nominal' placeholder='Nominal Pengeluaran' required>
                                    </div>
                                    <div class='form-group'>
                                        <label for='keterangan'>Keterangan</label>
                                        <textarea type='text' class='form-control' rows='4' id='keterangan' name='keterangan' required></textarea>
                                    </div>
                                    <button type='submit' class='btn  btn-default bg-primary btn-md float-right'>Simpan</button>
                                </form>
                                {{-- blade-formatter-enable --}}


                            </div>
                            <div class="col-xl-9">

                                <div class='card-header bg-primary mb-2'>
                                    <h3 class='card-title'>Riwayat Transaksi Penggunaan Dana CSR</h3>
                                </div>
                                <table id='example1' width='100%'
                                    class='table table-responsive table-bordered table-hover'>
                                    <thead>
                                        <tr class='text-center table-primary'>
                                            <th width='1%'>ID</th>
                                            @foreach ($arr_ths as $arr_th)
                                                <th class='text-center'> {{ $arr_th }}</th>
                                            @endforeach
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datas as $data)
                                            <tr>
                                                {{-- blade-formatter-disable --}}
                                                <td class='text-center'>{{ $loop->iteration }}</td>
                                                <td class='text-center'>
                                                    {{ Carbon::parse($data->tanggal)->setTimezone('Asia/Jakarta')->translatedformat('l, d F Y') }}
                                                </td>
                                                <td class='text-center'> {{ $data->DanaCsr->sumber_dana ?? '' }}</td>
                                                <td class='text-center'>Rp. {{ number_format($data->nominal, 0) }}</td>
                                                <td class='text-left'> {{ $data->jenis_pengeluaran }}</td>
                                                {{-- blade-formatter-enable --}}
                                                <td width='10%'>
                                                    {{-- blade-formatter-disable --}}
                                                    <div class='gap-1 d-flex justify-content-center'>
                                                        <!-- Button untuk mengedit -->
                                                        <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i> </button>
                                                        <!-- Form untuk menghapus -->
                                                        <form id='delete-form-{{ $data->id }}' action='{{ route('pengeluaran-csr.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                        <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i> </button>
                                                    </div>
                                                    {{-- blade-formatter-enable --}}
                                                    {{-- Modal View Data Akhir --}}

                                                    {{-- blade-formatter-disable --}}
                                                    <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1' aria-labelledby='EditModalLabel' aria-hidden='true'>
                                                        <x-edit-modal>
                                                            <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                            <section>
                                                                <form id='updateurl' action='{{ route('pengeluaran-csr.update', $data->id) }}' method='POST'>
                                                                    @csrf
                                                                    @method('PATCH')

                                                                    contentEdit

                                                                    <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'> Kirim</button>
                                                                </form>

                                                            </section>
                                                        </x-edit-modal>
                                                    </div>
                                                    {{-- blade-formatter-enable --}}
                                                    {{-- Modal Edit Data Akhir --}}
                                                    {{-- Modal View --}}

                                                    {{-- blade-formatter-disable --}}
                                                    <div class='modal fade' id='viewModal{{ $data->id }}' tabindex='-1' aria-labelledby='ViewModalLabel' aria-hidden='true'>
                                                        <x-view-modal>
                                                            <x-slot:titleviewModal>{{ $titleviewModal }}</x-slot:titleviewModal>
                                                            <section>
                                                                //Content View
                                                            </section>
                                                        </x-view-modal>
                                                    </div>
                                                    {{-- blade-formatter-enable --}}
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
                                            <th class='text-center'>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
