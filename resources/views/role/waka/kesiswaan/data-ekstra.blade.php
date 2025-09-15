@php
    //data-ekstra-waka
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
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahEkstra()'>
                        <i class='fa fa-plus'></i> Tambah Data</button>
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
                            <th class='noprint'>Action</th>
                            {{-- @if ($activecrud === 1)
                                      {{-- @endif --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr>
                                <td class='text-center'>{{ $loop->iteration }}</td>
                                <td class='text-center'> {{ $data->Ekstra->ekstra }}</td>
                                <td class='text-center'> {{ $data->Detailguru->nama_guru }}</td>
                                <td class='text-center'> {{ $data->pelatih }}</td>
                                <td class='text-center'> {{ $data->jadwal }}</td>
                                <td class='text-center'>
                                    @php
                                        $JumlahAnggota = App\Models\WakaKesiswaan\Ekstra\PesertaEkstra::where(
                                            'ekstra_id',
                                            $data->id,
                                        )->get();
                                    @endphp


                                    <a
                                        href="{{ app('request')->root() }}/waka-kesiswaan/peserta-ekstrakurikuler/{{ $data->id }}"><span
                                            class="p-2 bg-success">{{ $JumlahAnggota->count() }}</span></a>
                                </td>

                                <td class='noprint' width='10%'>
                                    <div class='gap-1 d-flex justify-content-center'>
                                        <!-- Button untuk mengedit -->
                                        <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                            data-toggle='modal' data-target='#editModal{{ $data->id }}'><i
                                                class='fa fa-edit'></i> </button>
                                        <!-- Form untuk menghapus -->
                                        <form id='delete-form-{{ $data->id }}'
                                            action='{{ route('ekstrakurikuler.destroy', $data->id) }}' method='POST'
                                            style='display: inline-block;'>
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button type='button' class='btn btn-danger btn-sm btn-equal-width'
                                            onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            {{-- Modal View Data Akhir --}}

                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                aria-labelledby='EditModalLabel' aria-hidden='true'>

                                <x-edit-modal>
                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                    <section>
                                        <form id='updateurl' action='{{ route('ekstrakurikuler.update', $data->id) }}'
                                            method='POST'>
                                            @csrf
                                            @method('PATCH')
                                            @php
                                                $Pembina = App\Models\User\Guru\Detailguru::orderBy(
                                                    'nama_guru',
                                                    'ASC',
                                                )->get();
                                                $hariLatihan = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                                            @endphp

                                            {{-- blade-formatter-disable --}}
                                            <div class='form-group'>
                                                <label for='detailguru_id'>Pembina</label>
                                                <select id='select2_{{ $data->id }}' name='detailguru_id' class='form-control' required>
                                                    <option value=''>--- Pilih Pembina ---</option>
                                                    @foreach ($Pembina as $newPembina)
                                                        <option value='{{ $newPembina->id }}'>{{ $newPembina->kode_guru }} - {{ $newPembina->nama_guru }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <script>
                                               $(document).ready(function() {
                                                   // $('#semesteredit option[value='II']').prop('selected', true); // Single Select
                                                   $('#select2_{{ $data->id }}').val(@json($data->detailguru_id)).trigger('change'); // Mutiple Select Select value in array json
                                               });
                                            </script>

                                            <x-inputallin>type:Pelatih:Pelatih:pelatih:id_pelatih:{{ $data->pelatih }}:Required</x-inputallin>
                                            <div class='form-group'>
                                                <label for='jadwal'>Hari Latihan</label>
                                                <select id='select2jadwal-{{ $data->id }}' name='jadwal' class='form-control' required>
                                                    <option value=''>--- Pilih Hari Latihan ---</option>
                                                    @foreach($hariLatihan as $newhariLatihan)
                                                        <option value='{{$newhariLatihan}}'>{{$newhariLatihan}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <script>
                                               $(document).ready(function() {
                                                   // $('#semesteredit option[value='II']').prop('selected', true); // Single Select
                                                   $('#select2jadwal-{{ $data->id }}').val(@json($data->jadwal)).trigger('change'); // Mutiple Select Select value in array json
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
                            <th class='noprint text-center'>Action</th>
                            {{-- @endif --}}
                        </tr>
                    </tfoot>
                </table>
            </div>


        </div>

    </section>
</x-layout>
{{-- <button class='btn btn-warning btn-sm' onclick='TambahEkstra()'><i class='fa fa-edit right'></i> Edit</button> --}}
{{--

 --}}

<script>
    function TambahEkstra(data) {
        var TambahEkstra = new bootstrap.Modal(document.getElementById('TambahEkstra'));
        TambahEkstra.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='TambahEkstra' tabindex='-1' aria-labelledby='LabelTambahEkstra' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelTambahEkstra'>
                    Tambah Data Ekstra Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <form id='#id' action='{{ route('ekstrakurikuler.store') }}' method='POST'>
                    @csrf
                    @method('POST')

                    {{-- blade-formatter-disable --}}
                    @php
                    $DataEkstra = App\Models\WakaKesiswaan\Ekstra\Ekstra::orderBy('ekstra', 'ASC')->get()
                    @endphp
                    <div class='form-group'>
                        <label for='ekstra_id'>Nama Ekstra</label>
                        <select name='ekstra_id' class='form-control' required>
                            <option value=''>--- Pilih Nama Ekstra ---</option>
                            @foreach ($DataEkstra as $newDataEkstra)
                                <option value='{{ $newDataEkstra->id }}'>{{ $newDataEkstra->ekstra }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='form-group'>
                        <label for='detailguru_id'>Pembina</label>
                        <select id='select2-{{ $data->id }}' name='detailguru_id' class='form-control' required>
                            <option value=''>--- Pilih Pembina ---</option>
                            @foreach ($Pembina as $newPembina)
                                <option value='{{ $newPembina->id }}'>{{ $newPembina->kode_guru }} - {{ $newPembina->nama_guru }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <x-inputallin>type:Pelatih:Pelatih:pelatih:id_pelatih::Required</x-inputallin>
                    <div class='form-group'>
                        <label for='jadwal'>Hari Latihan</label>
                        <select id='select2jadwal-{{ $data->id }}' name='jadwal' class='form-control' required>
                            <option value=''>--- Pilih Hari Latihan ---</option>
                            @foreach ($hariLatihan as $newhariLatihan)
                                <option value='{{ $newhariLatihan }}'>{{ $newhariLatihan }}</option>
                            @endforeach
                        </select>
                    </div>
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
<script>
    $(document).ready(function() {
        // Variabel untuk judul export
        var exportTitle = 'Data Ekstrakurikuler X';

        // Hancurkan DataTable jika sudah ada
        $('#example1').DataTable().destroy();

        // Inisialisasi ulang DataTable dengan konfigurasi yang diinginkan
        var table = $('#example1').DataTable({
            responsive: true,
            lengthChange: true, // Tetap mengaktifkan dropdown data
            autoWidth: false,
            buttons: [{
                    extend: 'copy',
                    title: exportTitle,
                    exportOptions: {
                        columns: ':not(:last-child)' // Hapus kolom terakhir dan yang memiliki class "noprint"
                    }
                },
                {
                    extend: 'excel',
                    title: exportTitle,
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
                {
                    extend: 'pdf',
                    title: exportTitle,
                    exportOptions: {
                        columns: ':not(:last-child):not(.noprint)'
                    }
                },
                {
                    extend: 'colvis',
                    titleAttr: 'Pilih Kolom'
                }
            ],
            rowGroup: {
                dataSrc: 0 // Mengelompokkan berdasarkan kolom pertama (index 0)
            }
        });

        // Menambahkan tombol-tombol di atas tabel
        table.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>
