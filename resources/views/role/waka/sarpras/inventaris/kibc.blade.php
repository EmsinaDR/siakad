@php
    //KIB C
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
                <h3 class='card-title'>{{ $title }} - Gedung dan Bangunan</H3>
            </div>
            <!--Car Header-->

            <div class='card-body'>
                <div class="row">
                    <div class="col-xl-2">
                        <button type='button' class='btn btn-default bg-primary btn-md' onclick='TambahData()'><i
                                class="fa fa-plus"></i> Tambah Data</button>
                    </div>
                    <div class="col-xl-10"></div>
                </div>
            </div>


            <div class='ml-2 my-4'>
                KIB C
                <div class="card">
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>Data KIB C</h3>
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
                                        <td class="text-center">{{ $data->kode_ruangan }}</td>
                                        <td class="text-center">{{ $data->nama_ruangan }}</td>
                                        <td class="text-center">
                                            @if ($data->panjang === 0)
                                                <span class="bg-danger p-2">{{ $data->panjang }}m</span>
                                            @else
                                                {{ $data->panjang }} m
                                            @endif

                                        </td>
                                        <td class="text-center">
                                            @if ($data->lebar === 0)
                                                <span class="bg-danger p-2">{{ $data->lebar }}m</span>
                                            @else
                                                {{ $data->lebar }} m
                                            @endif

                                        </td>
                                        <td class="text-center">{{ $data->keterangan }}</td>

                                        <td width='10%'>
                                            <div class='gap-1 d-flex justify-content-center'>

                                                <!-- Button untuk melihat -->
                                                <!-- <button type='button' class='btn btn-success btn-sm btn-equal-width' data-toggle='modal' data-target='#viewModal{{ $data->id }}'><i class='fa fa-eye'></i> Lihat</button> -->
                                                <!-- Button untuk mengedit -->
                                                <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                                    data-toggle='modal' data-target='#editModal{{ $data->id }}'><i
                                                        class='fa fa-edit'></i> </button>
                                                <!-- Form untuk menghapus -->
                                                <form id='delete-form-{{ $data->id }}' action='{{ route('inventaris-kibc.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i> </button>

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
                                                    action='{{ route('inventaris-kibc.update', $data->id) }}'
                                                    method='POST'>
                                                    @csrf
                                                    @method('PATCH')

                                                    {{-- blade-formatter-disable --}}
                                                    <x-inputallin>type:Nama Ruangan:Nama ruangan:nama_ruangan:id_nama_ruangan:{{ $data->nama_ruangan }}:Required</x-inputallin>
                                                    <p><b>Catatan :</b> Tuliskan dengan jelas nama ruangan yang masih berhubungan dengan kode ruangan dipilih - <b class="text-success">{{$data->Barang->nama_barang}}</b></p>
                                                    <x-inputallin>type:Panjang Ruangan(m):Panjang ruangan:panjang:id_panjang:{{ $data->panjang }}:Required</x-inputallin>
                                                    <x-inputallin>type:Lebar Ruangan(m):Lebar ruangan:lebar:id_lebar:{{ $data->lebar }}:Required</x-inputallin>
                                                    @php
                                                        $kondisi = ['Baik', 'Rusak Ringan', 'Rusak Sedang', 'Rusak Berat'];
                                                    @endphp
                                                    <div class='form-group'>
                                                        <label for='kondisi'>Kondisi Ruangan {{$data->kondisi}}</label>
                                                        <select id='select2_{{ $data->id }}' name='kondisi' class='form-control' required>
                                                            <option value=''>--- Pilih Kondisi Ruangan ---</option>
                                                            @foreach ($kondisi as $newkondisi)
                                                                <option value='{{ $newkondisi }}'>{{ $newkondisi }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <script>
                                                       $(document).ready(function() {
                                                           // $('#semesteredit option[value='II']').prop('selected', true); // Single Select
                                                           $('#select2_{{ $data->id }}').val(@json($data->kondisi)).trigger('change'); // Mutiple Select Select value in array json
                                                       });
                                                    </script>
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

<script>
    function TambahData() {
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
                <form id='#id' action='' method='POST'>
                    @csrf
                    @method('POST')
                    @php
                        $dataBarangs = App\Models\WakaSarpras\Inventaris\Inventaris::orderBY(
                            'nama_barang',
                            'ASC',
                        )->get();
                    @endphp
                    <div class='form-group'>
                        <label for='barang_id'>Nama Barang</label>
                        <select id='select2' name='barang_id[]' multiple='multiple' class='select2 form-control'
                            required>
                            @foreach ($dataBarangs as $newkey)
                                <option value='{{ $newkey->id }}'>{{ $newkey->nama_barang }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
