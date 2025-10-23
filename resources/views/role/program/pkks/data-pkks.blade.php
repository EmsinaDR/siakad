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
                       <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'> <i class='fa fa-plus'></i> Tambah Data</button>
                       <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='ConverterDocx()'> <i class='fa fa-plus'></i> Converter Data</button>
                   </div>
                   <div class='col-xl-10'>
                    {{$datas->where('system', 'Y')->count()}} / {{$datas->count()}} <br><br><br>
                    {{$datas->count() * 75 / 100}} <br><br><br>
                    @if(($datas->count() > 0 ? number_format(($datas->where('system', 'Y')->count() / $datas->count()) * 100, 0) : 0) > 75 )
                    <span class='bg-success p-2'>{{$datas->count() > 0 ? number_format(($datas->where('system', 'Y')->count() / $datas->count()) * 100, 0) : 0 }} %</span>
                    @elseif(($datas->count() > 0 ? number_format(($datas->where('system', 'Y')->count() / $datas->count()) * 100, 0) : 0) > 30)
                    <span class='bg-warning p-2'>{{$datas->count() > 0 ? number_format(($datas->where('system', 'Y')->count() / $datas->count()) * 100, 0) : 0 }} %</span>
                    @else
                     <span class='bg-danger p-2'>{{$datas->count() > 0 ? number_format(($datas->where('system', 'Y')->count() / $datas->count()) * 100, 0) : 0 }} %</span>
                     @endif
                   </div>
               </div>
               {{-- blade-formatter-enable --}}


            <div class='ml-2 my-4'>
                {{-- Catatan :
                   - Include Komponen Modal CRUD + Javascript / Jquery
                   - Perbaiki Onclick Tombol Modal Create, Edit
                   - Variabel Active Crud menggunakan ID User
                    --}}
                <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                    <thead>
                        <tr class='text-center'>
                            <th class='text-center align-middle'width='1%'>ID</th>
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
                                <td class='text-center'>
                                    @if ($data->system !== 'Y')
                                    @else
                                        <span class=''><i class="fa fa-check-circle text-success"></i></span>
                                    @endif
                                </td>
                                <td class='text-center'> {{ $data->kategori }}</td>
                                <td class='text-center'> {{ $data->indikator }}</td>
                                {{-- <td class='text-center'> {{ $data->point }}</td> --}}
                                <td class='text-center'> {{ $data->kode_dokumen }}</td>
                                <td class='text-left'> {{ $data->nama_dokumen }}</td>

                                <td class='text-center'>
                                    @if (!empty($data->referensi))
                                        <a href="{{ $data->referensi }}" target="_blank">
                                            <i class="fa fa-eye text-success"></i>
                                        </a>
                                    @else
                                        <i class="fa fa-times text-danger"></i>
                                    @endif

                                </td>

                                <td width='10%'>
                                    <div class='gap-1 d-flex justify-content-center'>
                                        <!-- Button untuk mengedit -->
                                        {{-- blade-formatter-disable --}}

                                        <a href="data-view-pkks/id_{{$data->id}}"><button type='button' class='btn btn-success btn-sm btn-equal-width'><i class='fa fa-eye'></i> </button></a>



                                        <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#viewModal{{ $data->id }}'><i class='fa fa-eye'></i> </button>
                                        <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i> </button>
                                        {{-- blade-formatter-enable --}}

                                        <!-- Form untuk menghapus -->
                                        <form id='delete-form-{{ $data->id }}'
                                            action='{{ route('data-pkks.destroy', $data->id) }}' method='POST'
                                            style='display: inline-block;'>
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button type='button' class='btn btn-danger btn-sm btn-equal-width'
                                            onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i>
                                        </button>
                                    </div>
                                    {{-- Modal View Data Akhir --}}

                                    <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                        aria-labelledby='EditModalLabel' aria-hidden='true'>

                                        <x-edit-modal>
                                            <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                            <section>
                                                <form id='updateurl'
                                                    action='{{ route('data-pkks.update', $data->id) }}' method='POST'>
                                                    @csrf
                                                    @method('PATCH')
                                                    {{-- blade-formatter-disable --}}
                                                    @php
                                                    $Identitas = App\Models\Admin\Identitas::first();
                                                    $cari = ['MTs Ma&rsquo;arif NU Gandusari', '2024/2025', '2024 - 2025', 'Gandusari', 'Blitar'];
                                                    $ganti = [$Identitas->namasek, '2025/2026', '2025 - 2026', 'Banjarharjo', 'Brebes'];
                                                    $hasil = str_replace($cari, $ganti, $data->converter);
                                                    @endphp
                                                    <input type='checkbox' name='system' id='system'>
                                                    {{-- blade-formatter-disable --}}

                                                    {{-- blade-formatter-enable --}}
                                                    {{-- <textarea name="editor" class="editor">{!! $hasil !!}</textarea>
                                                    <style>
                                                        .tox .tox-toolbar-overlord {
                                                            z-index: 10000 !important;
                                                            /* Pastikan toolbar tidak tersembunyi */
                                                        }

                                                        table {
                                                            border-collapse: collapse;
                                                            width: 100%;
                                                        }

                                                        table td,
                                                        table th {
                                                            border: 1px solid black;
                                                            padding: 5px;
                                                        }
                                                    </style>

                                                    <script src="{{ asset('plugins/tinymce/tinymce.min.js') }}"></script>
                                                    <style>
                                                        .tox-notifications-container {
                                                            display: none !important;
                                                        }
                                                    </style>
                                                    <script>
                                                        document.addEventListener("DOMContentLoaded", function() {
                                                            if (typeof tinymce !== "undefined") {
                                                                tinymce.init({
                                                                    selector: '.editor',
                                                                    plugins: 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help',
                                                                    menubar: 'file edit view insert format tools table help',
                                                                    toolbar: 'undo redo | formatselect | bold italic underline strikethrough backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table | removeformat fullscreen code',
                                                                    height: 400,
                                                                    setup: function(editor) {
                                                                        editor.on('init', function() {
                                                                            console.log('TinyMCE siap digunakan!');
                                                                        });
                                                                    }
                                                                });
                                                            }

                                                            // Memastikan TinyMCE menyimpan data sebelum form dikirim
                                                            document.getElementById('updateurl').addEventListener('submit', function() { tinymce.triggerSave(); // Pastikan nilai textarea diperbarui sebelum dikirim
                                                            });
                                                        }); --}}
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
                                                <!-- Tombol ekspor -->
                                                <button id="exportButton" onclick="exportToWord('export-doc')">Export to
                                                    DOCX</button>

                                                <!-- Konten yang ingin diekspor -->
                                                <div id="export-doc">
                                                    {!! $hasil !!}
                                                </div>

                                                <script>
                                                    // Ambil CSRF Token dari meta tag
                                                    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                                                    function exportToWord(divId) {
                                                        // Ambil HTML dari div yang dipilih berdasarkan ID
                                                        var htmlContent = document.getElementById(divId).innerHTML;

                                                        // Kirim data ke server untuk diproses menggunakan AJAX
                                                        var xhr = new XMLHttpRequest();
                                                        xhr.open("POST", "/export-docx", true);
                                                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                                                        // Tambahkan CSRF Token ke header permintaan
                                                        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

                                                        xhr.onreadystatechange = function() {
                                                            if (xhr.readyState == 4) {
                                                                if (xhr.status == 200) {
                                                                    // Langsung mengunduh file dari server setelah ekspor selesai
                                                                    var blob = xhr.response;
                                                                    var link = document.createElement('a');
                                                                    link.href = URL.createObjectURL(blob);
                                                                    link.download = 'data-pkks.docx';
                                                                    link.click();
                                                                } else {
                                                                    // Log jika terjadi kesalahan
                                                                    console.error("Error: " + xhr.statusText);
                                                                }
                                                            }
                                                        };
                                                        xhr.responseType = 'blob'; // Agar responsnya berupa blob (file)
                                                        xhr.send("content=" + encodeURIComponent(htmlContent));
                                                    }
                                                </script>


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

    </section>
</x-layout>

<script>
    function ConverterDocx(data) {
        var ConverterDocx = new bootstrap.Modal(document.getElementById('ConverterDocx'));
        ConverterDocx.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Uploader docx to database --}}
{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='ConverterDocx' tabindex='-1' aria-labelledby='LabelConverterDocx' aria-hidden='true'>
    <div class='modal-dialog modal-xl'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelConverterDocx'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <div class="modal-body">
                    {{-- Form Upload --}}
                    <form action="{{ url('program/pkks/upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="uploadModalLabel">Upload / Update File DOCX</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                {{-- Form Upload / Update --}}
                                <form id="uploadForm" action="{{ url('program/pkks/upload') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    {{-- Pilih ID jika ingin update --}}
                                    <div class='form-group'>
                                        <label for='id'>Pilih Kode Dokumen (Opsional untuk Update)</label>
                                        <select name='id' id='id' class='form-control'>
                                            <option value=''>--- Upload Baru ---</option>
                                            @foreach ($datas as $data)
                                                <option value='{{ $data->id }}'>{{ $data->kode_dokumen }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-gray-700 font-bold mb-2">Pilih File DOCX:</label>
                                        <input type="file" name="file" accept=".docx" required
                                            class="form-control">
                                        @error('file')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Upload</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </form>
                </div>
                {{-- Script untuk update action URL berdasarkan pilihan ID --}}
                <script>
                    document.getElementById('id').addEventListener('change', function() {
                        let selectedId = this.value;
                        let form = document.getElementById('uploadForm');

                        if (selectedId) {
                            form.action = "{{ url('program/pkks/upload') }}/" + selectedId;
                        } else {
                            form.action = "{{ url('program/pkks/upload') }}";
                        }
                    });
                </script>
            </div>

        </div>
    </div>

</div>
{{--
php artisan make:view role.program.pkks.data.id_1
php artisan make:view role.program.pkks.data.id_2
php artisan make:view role.program.pkks.data.id_3
php artisan make:view role.program.pkks.data.id_4
php artisan make:view role.program.pkks.data.id_5

php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

php artisan make:view role.ro.namablade
php artisan make:view role.ro.namablade-single
php artisan make:model Program/PKKS/Data/ViewPKKSID
php artisan make:controller Program/PKKS/Data/ViewPKKSIDController --resource



php artisan make:seeder Program/PKKS/Data/ViewPKKSIDSeeder
php artisan make:migration Migration_ViewPKKSID

 --}}
