<style>
    .bg-azzure {
        background-color: #F0FFFF;
    }

    .bg-cornsilk {

        background-color: #FFF8DC;
    }

    .bg-darkseagreen {

        background-color: #8FBC8F;

    }

</style>

@php

use App\Models\User\Guru\Detailguru;
use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;

use App\Models\Learning\Emengajar;
$activecrud = collect([1, 2,4, 6, 8])->search(Auth::user()->id);
$arr_thsb = ['Mata Pelajaran'];
// dd($etapels->tapel);

//

@endphp

<style>
</style>
{{-- {{ dd($tingkatb) }} --}}

<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>
    <section class='content mx-2'>


        <div class='card'>
            {{-- Papan Informasi --}}
            <div class="card-body">
                <div class='row float-right'>
                    {{-- <x-btn>submit/Ubah Data/fa fa-edit/btn btn-primary btn-xl bg-primary btn-app/InserDataMengajar()</x-btn> --}}

                    {{-- <x-btn>submit/Mapel Aktiv/fa fa-check/btn btn-primary btn-xl bg-primary btn-app/ModalAktivMapel()</x-btn> --}}
                </div>
            </div>
            {{-- Papan Informasi --}}
            <hr>
            <div class='ml-2'>
                <div class='card-header bg-primary mt-2'>
                    <h3 class='card-title'>{{ $title }}</H3>
                </div>
                <div class='alert alert-info alert-dismissible mt-2 mr-2'>

                    <h5><b>Penting !!!</b></h5>
                    <hr>
                    <p>Sebelum mengisi data disini diharapkan sekolah telah memilih kelas yang diaktifkan pada tahun pelajaran saat ini.</p>
                </div>

                <div class='card-body'>
                    <div class="">
                        <form id='formkirim' action='' method="GET">
                            @csrf
                            <div class="row ">
                                <div id='tingkat' class="col-2">
                                    <!-- Dropdown Category -->
                                    <div class='form-group'>

                                        <label for="category">Tingkat</label>

                                        <select id="category" class='form-control'>
                                            <option value="">Pilih Tingkat</option>

                                            <option value="VII">VII</option>
                                            <option value="VIII">VIII</option>
                                            <option value="IX">IX</option>
                                        </select>
                                    </div>

                                </div>
                                <div id='kelas' class="col-2">
                                    <div class='form-group'>
                                        <!-- Dropdown Subcategory -->
                                        <label for="subcategory">Kelas</label>
                                        <select onchange="datachange()" name='kelas_id' id="subcategory" class='form-control'>
                                            <option value="">Pilih Kelas</option>
                                        </select>
                                    </div>
                                </div>
                        </form>
                    </div>

                    @if(isset($request['tingkat_id']))
                    {{ $request['tingkat_id'] }}
                    @endif
                    @php
                    // dd($tingkata);
                    @endphp
                    <script>
                        $(document).ready(function() {

                            // Data untuk subkategori berdasarkan kategori
                            var subcategories = {
                                //  fruits: ['Apple', 'Banana', 'Orange']
                                VII: @json($tingkata)
                                , VIII: @json($tingkatb)
                                , IX: @json($tingkatc)

                            };
                            // Ketika kategori dipilih
                            $('#category').change(function() {
                                var category = $(this).val();
                                var options = '<option value="">Pilih Data Kelas</option>';


                                // Cek jika kategori yang dipilih ada dalam data subkategori
                                if (category) {
                                    var subcategoryList = subcategories[category];
                                    subcategoryList.forEach(function(sub) {
                                        options += `<option value="${sub}">${sub}</option>`;
                                    });
                                }

                                // Set subcategory dropdown
                                $('#subcategory').html(options);
                            });
                        });

                        function datachange() {
                            $('#formkirim').submit();

                        }

                    </script>


                </div>
                <hr>
                @php

                if(isset($_GET['kelas_id'])){
                $kelas_id = Ekelas::select('id')->where('kelas', $_GET['kelas_id'])->where('tapel_id', $etapels->id)->count();
                if($kelas_id > 0){
                $kelas_id = Ekelas::select('id')->where('kelas', $_GET['kelas_id'])->where('tapel_id', $etapels->id)->firstOrFail();
                $ekelas = $kelas_id->id;

                }else{
                $ekelas = 1;

                }

                }else{
                // $ekelas = '';
                }

                @endphp
                <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                    <thead>
                        <tr class='text-center  bg-secondary'>
                            <th class=' d-flex align-items-center' width=' 1%'>ID</th>

                            @foreach ($arr_ths as $arr_th)
                            <th> {{ $arr_th }}</th>
                            @endforeach
                            @if($activecrud === 0 or $activecrud === 1)
                            <th>Action</th>
                            @endif
                        </tr>

                    </thead>
                    <tbody>
                        @if(isset($_GET['kelas_id']))
                        @php
                        $etapels = Etapel::where('aktiv', 'Y')->first();
                        $datamengajar = Emengajar::with('emengajartoDetailgurus')->where('kelas_id', $ekelas)->where('tapel_id', $etapels->id)->get();
                        @endphp
                        @foreach ($datamengajar as $mengajar)
                        <tr>
                            <td class='text-center'>{{ $loop->iteration }}</td>
                            <td> {{ $mengajar->emengajartomapel->mapel}}</td>
                            <td class='text-center'> {{ $mengajar->emengajartomapel->kategori}}</td>
                            <td class='text-center'> {{ $mengajar->emengajartomapel->kelompok}}</td>

                            <td class='text-center'> {{ $mengajar->emengajartomapel->kelompok}}</td>
                            <td class='text-center'> {{ $mengajar->emengajartomapel->jtm}}</td>
                            <td class='text-center'>
                                {{-- blade-formatter-disable --}}
                                <select id='dataq' onchange="DataViewAll({{ $mengajar }}, this.value)" name='mengajar' class='form-control' required>
                                    @if($mengajar->detailguru_id === Null)
                                        <option value=''>--- Pilih Guru ---</option>
                                        @foreach($gurus as $user)
                                            <option value='{{ $user['id'] }}'>{{ $user['nama_guru'] }}</option>
                                        @endforeach
                                    @else
                                        <option value='{{ $mengajar->detailguru_id}}'>{{ $mengajar->emengajartoDetailgurus->nama_guru}}</option>
                                        @foreach($gurus as $user)
                                            <option value='{{ $user['id'] }}'>{{ $user['nama_guru'] }}</option>
                                        @endforeach
                                    @endif

                                </select>
                                {{-- blade-formatter-enable --}}

                            </td>
                            <td>
                                <form action="{{ route('emengajar.destroy', $mengajar->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type='submit' class='btn  btn-default bg-danger btn-sm'><i class='fa fa-trash'></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan='8' class='text-center'>Tidak Ada data Kelas yang dipilih</td>
                        </tr>
                        @endif

                    </tbody>
                    <tfoot>
                        <tr class='text-center  bg-secondary'>

                            <th width='1%'>ID</th>
                            @foreach ($arr_ths as $arr_th)
                            <th> {{ $arr_th }}</th>
                            @endforeach
                            @if($activecrud === 1 or $activecrud === 0)

                            <th>Action</th>
                            @endif
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
        </div>
    </section>

    <script>
        function DataViewAll(mengajar, iddata) {
            // alert('id ' + iddata)

            // alert('DataId_tabel : ' + mengajar.id + ' Dataguru_id :' + iddata)
            data(mengajar, iddata)

            function data() {
                $.ajax({
                    url: `emengajar/UpdateMengajar`, // Route sesuai dengan yang dibuat


                    // url: `emengajar/updatedata`, // Route sesuai dengan yang dibuat

                    type: 'POST'
                    , data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                        , detailguru_id: mengajar.id
                        , id: iddata

                    , }
                    // , success: function(response) {
                    //     alert(response.message);
                    // }
                    // , error: function(xhr, status, error) {
                    //     console.log(xhr.responseJSON);
                    //     alert('Error: ' + xhr.responseJSON.message);
                    // }
                })


                // alert(mengajar.mapel_id);

                // alert(mengajar.id + '/' + value);
                // e.preventDefault();
                // Kirim data dengan AJAX
                // let id = mengajar.id;
                // let detailguru_id = value;
                // $.ajax({

            }
        }

    </script>
    {{-- {{ JavaScript Modal Akhir }} --}}

</x-layout>
<script>
    function InserDataMengajar(data) {
        var InserDataMengajar = new bootstrap.Modal(document.getElementById('InserMengajar'));
        InserDataMengajar.show();
        document.getElementById('Eid').value = data.id;
    }

</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='InserMengajar' tabindex='-1' aria-labelledby='InsertDataMengajarModal' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='InsertDataMengajarModal'>Ubah Data Mengajar</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                @php
                $users = App\Models\User\Guru\Detailguru::get();
                @endphp
                <div class="row">
                    <div class='form-group col-6'>
                        <label for='kelas'>Kelas</label>
                        <select name='kelas' class='form-control' required>
                            <option class='text-center' value=''>--- Pilih Guru ---</option>
                            @foreach($Ekelass as $ekelas)
                            <option value='{{ $ekelas['id'] }}'>{{ $ekelas['kelas'] }}</option>
                            @endforeach

                        </select>

                    </div>
                    <div class='form-group col-6'>
                        <label for='tapel'>Tahun Pelajaran</label>
                        <select name='kelas' class='form-control' required>
                            <option value=''>--- Pilih Tahun Pelajaran ---</option>
                            {{-- @foreach($etapels as $tapel)
                            <option value='{{ $tapel->id }}'>{{ $tapel->tapel }}{{ $tapel->id }}</option>

                            @endforeach --}}
                            <option value='value'>{{ $etapels->tapel}}{{ $etapels->id}}</option>


                            @for($i=-2; $i < 3; $i++) <option value='value'>{{ $etapels->tapel +$i }}</option>
                                @endfor

                        </select>
                    </div>
                </div>

            </div>
            <div class='card-body'>
                {{-- <x-plugins-tabel-header></x-plugins-tabel-header> --}}

                <table id='example2' width='100%' class='table table-responsive table-bordered table-hover'>
                    <thead>
                        <tr class='text-center'>

                            <th width='1%'>ID</th>
                            @foreach ($arr_thsb as $arr_th)

                            <th class='text-center'> {{ $arr_th }}</th>

                            @endforeach
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($emapels as $mengajar)

                        <tr>
                            <td class='text-center'>{{ $loop->iteration }}</td>
                            <td>{{ $mengajar->mapel }}</td>

                            <td>
                                <select name='mengajar' class='form-control' required>
                                    <option value=''>--- Pilih Guru ---</option>
                                    @foreach($users as $user)
                                    <option value='{{ $user['id'] }}'>{{ $user['nama_guru'] }}</option>
                                    @endforeach

                                </select>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr class='text-center'>

                            <th width='1%'>ID</th>

                            @foreach ($arr_thsb as $arr_th)

                            <th class='text-center'> {{ $arr_th }}</th>

                            @endforeach
                            <th class='text-center'>Action</th>
                    </tfoot>
                </table>
            </div>

            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
            </div>
        </div>
    </div>

</div>
{{-- <script>
    $(document).ready(function() {
        $('#dataForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: 'insert.php'
                , type: 'POST'
                , data: $(this).serialize()
                , success: function(response) {
                    $('#result').html(response);
                    $('#dataForm')[0].reset();
                }
                , error: function() {
                    $('#result').html('Terjadi kesalahan.');
                }
            });
        });
    });

</script>
<script>
    $(document).ready(function() {
        $('#dataForm').on('submit', function(e) {
            e.preventDefault();

            // Ambil nilai dari form
            const name = $('#name').val();
            const email = $('#email').val();

            // Kirim data dengan AJAX
            $.ajax({
                url: 'insert.php'
                , type: 'POST'
                , data: {
                    name: name
                    , email: email
                }
                , success: function(response) {
                    $('#result').html(response);
                    $('#dataForm')[0].reset();
                }
                , error: function() {
                    $('#result').html('Terjadi kesalahan.');
                }
            });
        });
    });

</script> --}}
<script>
    $(document).ready(function() {
        initDataTable('#example1', 'Data Peserta Ekstra', '#example1_wrapper .col-md-6:eq(0)');
        initDataTable('#example2', 'Data Peserta Ekstra 2', '#example2_wrapper .col-md-6:eq(0)');
    });

    // Fungsi untuk inisialisasi DataTable
    function initDataTable(tableId, exportTitle, buttonContainer) {
        // Hancurkan DataTable jika sudah ada
        $(tableId).DataTable().destroy();

        // Inisialisasi DataTable
        var table = $(tableId).DataTable({
            lengthChange: true, //False jika ingin dilengkapi dropdown
            autoWidth: false,
            responsive: true, // Membuat tabel menjadi responsif agar bisa menyesuaikan dengan ukuran layar
            lengthChange: true, // Menampilkan dropdown untuk mengatur jumlah data per halaman
            autoWidth: false, // Mencegah DataTables mengatur lebar kolom secara otomatis agar tetap sesuai dengan CSS
            buttons: [{
                    extend: 'copy',
                    title: exportTitle,
                    exportOptions: {
                        columns: ':visible:not(.noprint)'
                    }
                },
                {
                    extend: 'excel',
                    title: exportTitle,
                    exportOptions: {
                        columns: ':visible:not(.noprint)'
                    }
                },
                {
                   extend: 'pdf',
                   title: exportTitle,
                   exportOptions: {
                       columns: ':visible:not(.noprint)'
                   }
                },
                {
                    extend: 'colvis',
                    titleAttr: 'Pilih Kolom'
                }
            ],
            columnDefs: [{
                targets: -1, // Kolom terakhir (Action) bisgunkan array contoh [-1, -2, -4]
                visible: false // Menyembunyikan kolom Action
            }],
            rowGroup: {
                dataSrc: 0
            } // Mengelompokkan berdasarkan kolom pertama (index 0)
        });

        // Menambahkan tombol-tombol di atas tabel
        table.buttons().container().appendTo(buttonContainer);
    }
</script>
