<?php

use Illuminate\Support\Str;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

use App\Models\AdminDev\Modul;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Artisan::command('make:custom-controller {name} {fillablin} {routename} {--force}', function ($name, $fillablin, $routename) {

    // Mendapatkan nama controller dan model
    $controllerClass = class_basename($name); // Misalnya 'FiturAplikasiController'

    $modelName = str_replace('Controller', '', $controllerClass); // Misalnya 'FiturAplikasi'
    // dd($modelName);
    $modelNamespace = "App\\Models\\" . str_replace('/', '\\', dirname($name)); // Misalnya 'App\\Models\\Aplikasi\\Fitur'
    $pathingviewcontroller = str_replace('/', '.', dirname($name)); // Misalnya 'App\\Models\\Aplikasi\\Fitur'
    // $pathingviewViewr = str_replace('/', '.', dirname($name)); // Misalnya 'App\\Models\\Aplikasi\\Fitur'
    $DirNmaes = dirname($name);
    // $this->info("Controller '{$pathingviewcontroller}' pathingviewcontroller.");
    // $this->info("Controller '{$DirNmaes}' pathingviewcontroller.");
    $Title = str_replace('/', ' ', $DirNmaes);

    $Breadcumber = Str::headline(class_basename($modelName));
    function ArrayTabel($fillablin)
    {
        $explode = explode('/', $fillablin);
        $hasil = '';

        foreach ($explode as $stringdata) {
            $keya = trim($stringdata);
            $key = ucwords(str_replace("_", " ", $keya));
            $hasil .= "'{$key}'," . PHP_EOL;
        }

        return $hasil;
    }
    $dataArray = ArrayTabel($fillablin);
    function Fillabel($fillablin)
    {
        $explode = explode('/', $fillablin);
        $hasil = '';

        foreach ($explode as $stringdata) {
            $key = trim($stringdata);
            $cekId = explode('_', $key);
            if (end($cekId) === 'id') {
                $typeData = 'integer';
            } else {
                $typeData = 'string|min:3|max:255';
            }
            $hasil .= "'{$key}' => 'required|{$typeData}'," . PHP_EOL;
        }

        return $hasil;
    }

    $fillableNew = Fillabel($fillablin);
    // dd($fillableNew);

    // Nama view sesuai model, dengan format huruf kecil dan pemisahan dengan '-'
    $viewName = strtolower(str_replace('\\', '-', $modelName)); // Misalnya 'fitur-aplikasi'

    // Membuat nama view untuk aksi index, show, dan edit
    function camelToKebab($string)
    {
        // Menambahkan tanda hubung sebelum huruf besar dan mengubahnya menjadi huruf kecil
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $string));
    }

    $string = $modelName;
    $newString = camelToKebab($string);




    $viewIndex = $newString; // fitur-aplikasi (untuk index)
    // $this->info("Controller '{$viewIndex}' namaceker.");
    $viewShow = $newString . '-single'; // fitur-aplikasi-single (untuk show)
    $viewEdit = $newString . '-edit'; // fitur-aplikasi-edit (untuk edit)
    $viewCreate = $newString . '-create'; // fitur-aplikasi-single (untuk show)
    $viewCetak = $newString . '-cetak'; // fitur-aplikasi-single (untuk show)

    // Memecah nama view berdasarkan '-'
    $viewNameParts = explode('-', $viewName); // ['fitur', 'aplikasi']

    // Menyusun folder dan file view
    $viewFolder = implode('/', $viewNameParts); // fitur/aplikasi
    $viewFile = $viewName; // nama file view default
    // $rootBlade = 'role.' . strtolower($pathingviewcontroller) . '.' . $viewFolder . '.' . $newString;
    $rootBlade =  strtolower($pathingviewcontroller) . '.' . $viewFolder . '.' . $newString;
    // $this->info("Controller '{$rootBlade}' rootBlade.");
    // Menyusun namespace controller
    $namespace = 'App\\Http\\Controllers\\' . str_replace('/', '\\', dirname($name)); // Misalnya 'App\\Http\\Controllers\\Aplikasi\\Fitur'

    // Membaca stub controller
    $stub = file_get_contents(base_path('stubs/custom-controller.stub'));

    // Pembuatan variabel Controller
    // Mengganti placeholder di stub dengan data yang sesuai ( bisa tambahkan variabel )
    $stub = str_replace(
        ['{{ namespace }}', '{{ class }}', '{{ model }}', '{{ view }}', '{{ title }}', '{{ view_create }}', '{{ view_show }}', '{{ view_cetak }}', '{{ view_edit }}', '{{ modelName }}',  '{{ Breadcumber }}', '{{ fillableNew }}', '{{ dataArray }}'],
        [$namespace, $controllerClass, $modelNamespace . '\\' . $modelName, $rootBlade, $Title, $rootBlade . '-create', $rootBlade . '-single', $rootBlade . '-cetak', $rootBlade . '-edit', $modelName, $Breadcumber, $fillableNew, $dataArray],
        $stub
    );


    // Menyimpan file controller yang dihasilkan
    $controllerPath = app_path('Http/Controllers/' . str_replace('\\', '/', $name) . '.php');
    if (!is_dir(dirname($controllerPath))) {
        mkdir(dirname($controllerPath), 0755, true);
    }

    // Menimpa file controller jika opsi --force diberikan atau file belum ada
    if ($this->option('force') || !file_exists($controllerPath)) {
        file_put_contents($controllerPath, $stub);
        $this->info("Controller '{$name}' berhasil dibuat.");
    } else {
        $this->error("Controller '{$name}' sudah ada. Gunakan opsi --force untuk menimpa.");
    }
    $Dirawal = 'role.' . strtolower($pathingviewcontroller) . '.' . $viewFolder;
    $direktor = str_replace('.', '/', $Dirawal);
    $this->info("Controller '{$direktor}' direktor.");
    // Membuat folder dan file view untuk index, show, dan edit
    $bladePaths = [
        'index' => resource_path("views/" . $direktor . "/{$viewIndex}.blade.php"),
        'show'  => resource_path("views/" . $direktor . "/{$viewShow}.blade.php"),
        'edit'  => resource_path("views/" . $direktor . "/{$viewEdit}.blade.php"),
        'create'  => resource_path("views/" . $direktor . "/{$viewCreate}.blade.php"),
        'cetak'  => resource_path("views/" . $direktor . "/{$viewCetak}.blade.php"),
    ];

    // Membuat file view
    // Membuat folder jika belum ada
    foreach ($bladePaths as $fileKey => $bladePath) {
        if (!is_dir(dirname($bladePath))) {
            mkdir(dirname($bladePath), 0755, true);
        }

        // Membuat file blade jika belum ada atau jika opsi --force diberikan
        if (!file_exists($bladePath) || $this->option('force')) {
            // $content = "<h1>View untuk {{ \$title }} - $fileKey</h1>\\n<p>Generated automatically</p>";
            switch ($fileKey) {
                case 'index':
                    // ============================
                    // Konten khusus untuk INDEX
                    // ============================
                    $content = <<<'BLADE'
@php
//content
use Illuminate\Support\Carbon;
\Carbon\Carbon::setLocale('id');
@endphp
<x-layout>
    <style>
        textarea {
            resize: none;
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
                {{-- blade-formatter-disable --}}
                <div class='col-xl-2'>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#TambahData'><i class='fa fa-plus'></i> Tambah Data</button>
                </div>
                {{-- blade-formatter-enable --}}
                <div class='col-xl-10'></div>
            </div>
            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <!-- Konten -->
                                <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
            <thead>
                   <tr class='text-center'>
                    <th width='1%'>ID</th>
                       @foreach ($arr_ths as $arr_th)
                    <th class='text-center'> {{ $arr_th }}</th>
                       @endforeach
                    <th>Action</th>
                   </tr>
            </thead>
            <tbody>
                   @foreach (${modename} as $data)
                   <tr>
                       <td class='text-center'>{{ $loop->iteration }}</td>
                       {varfillable}

                       <td width='10%'>
                                            {{-- blade-formatter-disable --}}
                                            <div class='d-flex justify-content-center'>
                                                <!-- Button untuk mengedit -->
                                                <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i> </button>
                                                <!-- Form untuk menghapus -->
                                                <form id='delete-form-{{ $data->id }}' action='{{ route('{routename}.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i>  </button>
                                            </div>
                                            {{-- blade-formatter-enable --}}
                              {{-- Modal View Data Akhir --}}
                              <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1' aria-labelledby='EditModalLabel' aria-hidden='true'>
                                  <x-edit-modal>
                                      <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                      <section>
                                             <form id='update-{routename}' action='{{ route('{routename}.update', $data->id) }}' method='POST'>
                                                 @csrf
                                                 @method('PATCH')

                                                    {formInputEdit}

                                                 <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'> Kirim</button>
                                             </form>
                                      </section>
                                  </x-edit-modal>
                              </div>
                              {{-- Modal Edit Data Akhir --}}
                              {{-- Modal View --}}
                              <div class='modal fade' id='viewModal{{ $data->id }}' tabindex='-1' aria-labelledby='ViewModalLabel' aria-hidden='true'>
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
                       <th class='text-center'>Action</th>
                   </tr>
            </tfoot>
        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
<button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#TambahData'><i class='fa fa-plus'></i> Tambah Data</button>

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

                   <form id='TambahData-form' action='{{route('{routename}.store')}}' method='POST'>
                          @csrf
                          @method('POST')
                         {formInputCreate}

                           {{-- blade-formatter-disable --}}
                           <div class='modal-footer'>
                               <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                               <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                           </div>
                           {{-- blade-formatter-enable --}}
                   </form>
           </div>

            </div>
    </div>

</div>
BLADE;
                    break;

                case 'show':
                    // ============================
                    // Konten khusus untuk SHOW
                    // ============================
                    $content = <<<'BLADE'
@php
//content
use Illuminate\Support\Carbon;
\Carbon\Carbon::setLocale('id');
@endphp
<x-layout>
    <style>
        textarea {
            resize: none;
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
                     <a href="{{ route('{routename}.index') }}" class="btn btn-secondary btn-md w-100"><i class="fa fa-arrow-left"></i> Kembali</a>
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
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
BLADE;
                    break;

                case 'edit':
                    // ============================
                    // Konten khusus untuk EDIT
                    // ============================
                    $content = <<<'BLADE'
@php
//content
use Illuminate\Support\Carbon;
\Carbon\Carbon::setLocale('id');
@endphp
<x-layout>
    <style>
        textarea {
            resize: none;
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
                     <a href="{{ route('{routename}.index') }}" class="btn btn-secondary btn-md w-100"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div>
                <div class='col-xl-10'></div>
            </div>
            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <form id='#id' action='{{route('{routename}.update', $data->id)}}' method='POST'>
                            @csrf
                            @method('PATCH')
                            {formInputEdit}
                            <button type='submit' class='btn btn-block btn-default bg-primary btn-md float-right'></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
BLADE;
                    break;
                case 'create':
                    // ============================
                    // Konten khusus untuk Create
                    // ============================
                    $content = <<<'BLADE'
@php
//content
use Illuminate\Support\Carbon;
\Carbon\Carbon::setLocale('id');
@endphp
<x-layout>
    <style>
        textarea {
            resize: none;
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
                         <a href="{{ route('{routename}.index') }}" class="btn btn-secondary btn-md w-100"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>
                    <div class='col-xl-10'></div>
                </div>
            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <form id='#id' action='{{route('{routename}.store', $data->id)}}' method='POST'>
                            @csrf
                            @method('POST')
                            {formInputCreate}
                            {{-- blade-formatter-disable --}}
                            <button type='submit' class='btn btn-block btn-default bg-primary btn-md float-right'></button>
                            {{-- blade-formatter-enable --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
BLADE;
                    break;
                case 'cetak':
                    // ============================
                    // Konten khusus untuk Cetak
                    // ============================
                    $content = <<<'BLADE'
                    @php
    //content
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
@endphp
<x-layout-cetak>

    <link rel='stylesheet' href='{{ asset('css/layout-cetak.css') }}'>
    {{-- Undangan Rapat --}}
    <div class='container'>
        <x-kop-surat-cetak></x-kop-surat-cetak>
        <div class="mt-4"></div>

    Isi Cetak
    </div>
</x-layout-cetak>
BLADE;
                    break;

                default:
                    // ============================
                    // Fallback konten jika tidak dikenali
                    // ============================
                    $content = <<<'BLADE'
@php
//content
use Illuminate\Support\Carbon;
\Carbon\Carbon::setLocale('id');
    $activecrud = collect([2,4, 6, 8])->search(Auth::user()->id);
    $urlroot = app('request')->root();
@endphp
<x-layout>
    <style>
        textarea {
            resize: none;
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
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
BLADE;
            }

            $routename = $this->argument('routename');
            $modelName = $modelName; // pastikan ini sudah di-set sebelumnya
            $dataFIlLable = explode('/', $fillablin);
            $hasilFill = '';
            foreach ($dataFIlLable as $datafil) {
                $hasilFill .=  "<td class='text-center'> {{ \$data->$datafil}}</td>";
            }
            $formInputCreate = '';
            foreach ($dataFIlLable as $datafil) {
                $formInputCreate .=  "<div class='form-group'>" .
                    "    <label for='{{datafill}}'></label>" .
                    "    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' required>" .
                    "</div>";
            }
            $formInputEdit = '';
            foreach ($dataFIlLable as $datafil) {
                $formInputEdit .=  "<div class='form-group'>" .
                    "    <label for='{{datafill}}'></label>" .
                    "    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' value='{{ \$data->$datafil}}' required>" .
                    "</div>";
            }

            // Ganti placeholder sekaligus pakai array
            $replacements = [
                '{routename}' => $routename,
                '{modename}' => $modelName,
                '{filable}' => $fillablin,
                '{varfillable}' => $hasilFill,
                '{formInputCreate}' => $formInputCreate,
                '{formInputEdit}' => $formInputEdit,
            ];

            $content = str_replace(array_keys($replacements), array_values($replacements), $content);

            file_put_contents($bladePath, $content);
            $this->info("File view 'resources/views/{$viewFolder}/{$fileKey}.blade.php' berhasil dibuat.");
        } else {
            $this->error("File view 'resources/views/{$viewFolder}/{$fileKey}.blade.php' sudah ada. Gunakan opsi --force untuk menimpa.");
        }
    }




    // Membuat model secara otomatis
    $modelPath = app_path('Models/' . str_replace('App\\Models\\', '', $modelNamespace) . '/' . $modelName . '.php');
    $tableName = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $modelName));
    if (!file_exists($modelPath) || $this->option('force')) {
        $modelStub = file_get_contents(base_path('stubs/custom-model.stub'));

        $fillableNew = "'" . Str::replace("/", "','", $fillablin) . "'"; // Ganti '/' jadi spasi
        // Ganti placeholder model
        $modelStub = str_replace(
            ['{{ namespace }}', '{{ model }}', '{{ table }}', '{{ fillableNew }}'],
            [$modelNamespace, $modelName, $tableName, $fillableNew],
            $modelStub
        );

        // Menyimpan file model
        if (!is_dir(dirname($modelPath))) {
            mkdir(dirname($modelPath), 0755, true);
        }

        file_put_contents($modelPath, $modelStub);
        $this->info("Model '{$modelNamespace}\\{$modelName}' berhasil dibuat.");
    } else {
        $this->error("Model '{$modelNamespace}\\{$modelName}' sudah ada. Gunakan opsi --force untuk menimpa.");
    }

    // ==== MAPPING VIEW CUSTOM ====
    $customViewMap = [
        'Program/DataTestter/DataTesteredController' => 'DataTestered',
        // Tambahkan mapping lain jika dibutuhkan
    ];

    // Nama controller dalam format path
    $controllerPath = str_replace('\\', '/', $name);
    $controllerKey = trim($controllerPath, '/');

    // Gunakan custom mapping jika tersedia
    if (isset($customViewMap[$controllerKey])) {
        $viewFolder = $customViewMap[$controllerKey];
    } else {
        // Default: gunakan nama controller tanpa 'Controller'
        $controllerBaseName = class_basename($name); // e.g. DataTesteredController
        $viewFolder = str_replace('Controller', '', $controllerBaseName);
    }

    // === SEEDER ===
    $seederClass = $modelName . 'Seeder';
    $modelPath = app_path('Models/' . str_replace('App\\Models\\', '', $modelName));
    // $this->info("Seeder '{$modelPath}\\{$seederClass}' modelPath");
    $relativeSeederNamespace = str_replace('/', '\\', dirname($name));
    $seederNamespace = 'Database\\Seeders' . ($relativeSeederNamespace ? '\\' . $relativeSeederNamespace : '');
    $seederDirectory = base_path('database/seeders/' . ($relativeSeederNamespace ? str_replace('\\', '/', $relativeSeederNamespace) . '/' : ''));
    $seederFullPath = $seederDirectory . $seederClass . '.php';


    function FillabelSeeder($fillablin)
    {
        $explode = explode('/', $fillablin);
        $hasil = '';

        foreach ($explode as $stringdata) {
            $key = trim($stringdata);
            $hasil .= "'{$key}' => \$Data['$key']," . PHP_EOL;
        }

        return $hasil;
    }

    function PembentukArray($fillablin)
    {
        $explode = explode('/', $fillablin);
        $hasil = '';

        foreach ($explode as $stringdata) {
            $key = trim($stringdata);
            $hasil .= "'{$key}' => null," . PHP_EOL;
        }

        return "[" . $hasil . "],";
    }
    //Array Create
    function ArrayFillable($fillablin)
    {
        $explode = explode('/', $fillablin);
        $hasil = '';

        foreach ($explode as $stringdata) {
            $key = trim($stringdata);
            $hasil .= "'{$key}' => '$key'," . PHP_EOL;
        }

        return $hasil;
    }

    $fillableSeeder = FillabelSeeder($fillablin);
    $ArraySeeder = ArrayFillable($fillablin);
    $PembentukArray = PembentukArray($fillablin);

    if (!file_exists($seederFullPath) || $this->option('force')) {
        $seederStub = file_get_contents(base_path('stubs/custom-seeder.stub'));

        $seederStub = str_replace(
            ['{{ model_namespace }}', '{{ model }}', '{{ class }}', '{{ model_class }}', '{{ data }}', '{{ PembentukArray }}'],
            [$seederNamespace, $modelPath, $seederClass, '\\' . $modelNamespace . '\\' . $modelName, $fillableSeeder, $PembentukArray],
            $seederStub
        );

        if (!is_dir(dirname($seederFullPath))) {
            mkdir(dirname($seederFullPath), 0755, true);
        }

        file_put_contents($seederFullPath, $seederStub);
        $this->info("Seeder '{$seederNamespace}\\{$seederClass}' berhasil dibuat.");
    } else {
        $this->error("Seeder '{$seederNamespace}\\{$seederClass}' sudah ada. Gunakan opsi --force untuk menimpa.");
    }





    // === MIGRASI ===

    // 1. Buat nama tabel dari model (snake_case)
    $tableName = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $modelName));
    // Output: rincian_daftar_ulang

    // 2. Format nama class migrasi
    $modelNameFormatted = preg_replace('/([a-z0-9])([A-Z])/', '$1_$2', $modelName);
    $modelNameFormatted = ucwords($modelNameFormatted); // Rincian_Daftar_Ulang
    $classMigrationName = 'Migration_' . $modelNameFormatted; // Migration_Rincian_Daftar_Ulang

    // 3. Buat nama file migrasi dengan format timestamp Laravel
    $timestamp = date('Y_m_d_His');
    $fileMigrationName = $timestamp . '_migration_' . strtolower($modelNameFormatted) . '.php';
    // Contoh: 2025_07_18_235959_migration_rincian_daftar_ulang.php

    // 4. Path file migrasi
    $migrationPath = database_path('migrations/' . $fileMigrationName);

    // 5. Baca stub dan ganti placeholder
    $migrationStub = file_get_contents(base_path('stubs/custom-migration.stub'));

    //Bagian fillabel diruba ke tabel
    function FillabelMigration($fillablin)
    {
        $explode = explode('/', $fillablin);
        $hasil = '';

        // Mapping foreign keys: kolom => [referensi_tabel, onDelete]
        $foreignMap = [
            'tapel_id' => ['etapels', 'set null'],
            'detailsiswa_id' => ['detailsiswas', 'cascade'],
            'detailguru_id' => ['detailgurus', 'set null'],
            // Tambah sesuai kebutuhan
        ];

        foreach ($explode as $key) {
            $key = trim($key);
            $tipe = 'string'; // default

            // Tentukan tipe data otomatis berdasarkan nama kolom
            if (preg_match('/_id$/', $key)) {
                $tipe = 'unsignedInteger';
            } elseif (preg_match('/^tanggal_/', $key)) {
                $tipe = 'date';
            } elseif (preg_match('/^waktu_/', $key)) {
                $tipe = 'time';
            } elseif (preg_match('/^(jumlah|total)_/', $key)) {
                $tipe = 'double';
            } elseif (preg_match('/^(is_|status_)/', $key)) {
                $tipe = 'boolean';
            }

            // Tambahkan definisi kolom
            $hasil .= "\$table->$tipe('$key')->nullable();" . PHP_EOL;

            // Tambahkan foreign key jika ada dalam mapping
            if (isset($foreignMap[$key])) {
                [$referensi, $onDelete] = $foreignMap[$key];
                $hasil .= "\$table->foreign('$key')->references('id')->on('$referensi')->onDelete('$onDelete');" . PHP_EOL;
            }
        }

        return $hasil;
    }

    $fillableNew = FillabelMigration($fillablin);
    $migrationStub = str_replace(
        ['{{ class }}', '{{ table }}', '{{ data }}', '{{ fileMigrationName }}'],
        [$classMigrationName, $tableName, $fillableNew, $fileMigrationName], // contoh: Migration_Rincian_Daftar_Ulang, rincian_daftar_ulang
        $migrationStub
    );

    // 6. Simpan file migrasi
    if (!file_exists($migrationPath) || $this->option('force')) {
        file_put_contents($migrationPath, $migrationStub);
        $this->info("✅ Migrasi '{$fileMigrationName}' berhasil dibuat.");
    } else {
        $this->error("⚠️ Migrasi '{$fileMigrationName}' sudah ada. Gunakan opsi --force untuk menimpa.");
    }
});
//

/*
        |--------------------------------------------------------------------------
        | 📌 Menyisipkan ke kernel :
        |--------------------------------------------------------------------------
        |
        | Fitur :
        | - Pembuatan Custom Command
        | - Menambahkan command ke kernel otomatis
        |
        | Tujuan :
        | - Mempersingkat proses
        |
        |
        | Penggunaan :
        | - php artisan make:custom-command namacommand "Deskripsi" "Nama Modul Terhubung : Contoh : Perpustakaan"
        | php artisan make:custom-command sync:user User/SyncCommand "Sinkronisasi User" MyApp
        | php artisan make:custom-command sync:user User/namacommand "Sinkronisasi User" MyApp
        | php artisan make:custom-command "coba:halo" "Test/Hallo" "Command uji coba" "Siakad"
        |
        */
Artisan::command('make:custom-command {signature} {name} {deskripsi} {namaapps} {--force}', function ($signature, $name, $deskripsi, $namaapps) {
    $force = $this->option('force');

    // --- Handle Subfolder ---
    $name = str_replace('\\', '/', $name);
    $parts = explode('/', $name);
    // $className = ucfirst(array_pop($parts));
    $className = ucfirst(array_pop($parts)) . 'Command';
    $subPath = implode('/', array_map('ucfirst', $parts));

    $namespace = 'App\\Console\\Commands' . ($subPath ? '\\' . str_replace('/', '\\', $subPath) : '');
    $filePath = app_path("Console/Commands" . ($subPath ? "/$subPath" : '') . "/{$className}.php");

    // --- Cegah overwrite ---
    if (File::exists($filePath) && !$force) {
        $this->error("❌ File '{$className}.php' sudah ada. Gunakan --force untuk menimpa.");
        return;
    }
    if ($force) $this->warn("⚠️ Menimpa file '{$className}.php' karena --force dipakai.");

    // --- Template file command ---
    $template = <<<PHP
<?php

namespace {$namespace};

use Illuminate\Console\Command;

class {$className} extends Command
{
    protected \$signature = '{$signature}';
    protected \$description = '{$deskripsi}';

    public function handle()
    {
        \$this->info("Command '{$className}' berhasil dijalankan.");
    }
}
PHP;

    File::ensureDirectoryExists(dirname($filePath));
    File::put($filePath, $template);
    $this->info("✅ Custom command '{$className}' berhasil dibuat di: {$filePath}");

    // --- Auto-register ke Kernel.php ---
    $kernelPath = app_path('Console/Kernel.php');
    $commandClass = "\\{$namespace}\\{$className}::class";

    $kernelContents = File::get($kernelPath);
    if (!str_contains($kernelContents, $commandClass)) {
        $updatedContents = preg_replace(
            '/protected \$commands\s*=\s*\[[^\]]*/',
            '$0' . "\\n        {$commandClass},\\n",
            $kernelContents
        );
        File::put($kernelPath, $updatedContents);
        $this->info("📌 Command '{$className}' berhasil di-register ke Kernel.php");
    } else {
        $this->warn("ℹ️ Command '{$className}' sudah ada di Kernel.php.");
    }
})->describe('Membuat file command baru');
/*
    |--------------------------------------------------------------------------
    | 📌 Seeder :
    |--------------------------------------------------------------------------
    |
    | Fitur :
    | - xxxxxxxxxxx
    | - xxxxxxxxxxx
    |
    | Tujuan :
    | - xxxxxxxxxxx
    |
    |
    | Penggunaan :
    | - php artisan make:custom-seeder Vendor/DataVendor vendor "id:token:paket:trial_ends_at:nama_vendor" --force

    |
    */
// Proses Coding
Artisan::command('make:custom-seeder {name} {db} {fillable} {--force}', function ($name, $db, $fillable) {
    $force = $this->option('force');

    // --- Handle subfolder ---
    $name = str_replace('\\', '/', $name);
    $parts = explode('/', $name);
    $className = ucfirst(array_pop($parts)) . 'Seeder';
    $subPath = implode('/', array_map('ucfirst', $parts));
    $fillableAdd = explode(":", $fillable);
    $addFill = "";
    foreach ($fillableAdd as $add) {
        $addFill .= "'{$add}' => 'xxxxxxxxx',";
    }
    // $fillableAdd
    $namespace = 'Database\\Seeders' . ($subPath ? '\\' . str_replace('/', '\\', $subPath) : '');
    $filePath = database_path("seeders" . ($subPath ? "/$subPath" : '') . "/{$className}.php");

    // --- Cegah overwrite ---
    if (File::exists($filePath) && !$force) {
        $this->error("❌ File '{$className}.php' sudah ada. Gunakan --force untuk menimpa.");
        return;
    }
    if ($force) $this->warn("⚠️ Menimpa file '{$className}.php' karena --force dipakai.");

    // --- Template file seeder ---
    $template = <<<PHP
<?php

namespace {$namespace};

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class {$className} extends Seeder
{
    public function run()
    {
        // TODO: tambahkan data seed di sini
        // Contoh:
        DB::table('{$db}')->insert([
        //     'nama_vendor' => 'Contoh Vendor',
        //     'alamat' => 'Jl. Contoh No.1',
        //     'kontak' => '08123456789',
        {$addFill}
        //     'status' => 'aktif',
        //     'created_at' => now(),
        //     'updated_at' => now(),
         ]);

        \$this->command->info("Seeder '{$className}' berhasil dijalankan.");
    }
}
PHP;

    File::ensureDirectoryExists(dirname($filePath));
    File::put($filePath, $template);
    $this->info("✅ Custom seeder '{$className}' berhasil dibuat di: {$filePath}");
})->describe('Membuat file seeder baru secara custom');
/*
    |--------------------------------------------------------------------------
    | 📌 Helpers :
    |--------------------------------------------------------------------------
    |
    | Fitur :
    | - Pembuatan Helper
    | - xxxxxxxxxxx
    |
    | Tujuan :
    | - xxxxxxxxxxx
    |
    |
    | Penggunaan :
    | - php artisan make:custom-helper User/SyncCommand
    |
    */
// Proses Coding
Artisan::command('make:custom-helper {name} {--force}', function ($name) {
    $force = $this->option('force');

    // --- Handle Subfolder ---
    $name = str_replace('\\', '/', $name);
    $parts = explode('/', $name);
    $className = ucfirst(array_pop($parts));
    $subPath = implode('/', array_map('ucfirst', $parts));

    $helperClassName = preg_replace('/Command$/', 'Helper', $className);
    $helperDir = app_path('Helpers' . ($subPath ? "/$subPath" : ''));
    $helperFile = $helperDir . '/' . $helperClassName . '.php';

    // --- Cegah overwrite ---
    if (File::exists($helperFile) && !$force) {
        $this->warn("❌ Helper '{$helperClassName}' sudah ada. Gunakan --force untuk menimpa.");
    } else {
        if ($force) $this->warn("⚠️ Menimpa helper '{$helperClassName}' karena --force dipakai.");

        $stub = <<<PHP
<?php

/*
    |----------------------------------------------------------------------
    | 📌 Helper {$helperClassName}
    |----------------------------------------------------------------------
    |
*/

if (!function_exists('{$helperClassName}')) {
    function {$helperClassName}(\$Kode) {
        return "Helper {$helperClassName} dijalankan dengan param: ";
    }
}
PHP;

        File::ensureDirectoryExists($helperDir);
        File::put($helperFile, $stub);
        $this->info("✅ Helper '{$helperClassName}' berhasil dibuat di: {$helperFile}");
    }

    // --- Auto-inject ke Helpers.php ---
    $helpersIndexFile = app_path('Helpers/Helpers.php');
    $requireLine = "" .
        "\nrequire_once __DIR__ . '" . ($subPath ? '/' . $subPath : '') . '/' . $helperClassName . ".php';";

    if (File::exists($helpersIndexFile)) {
        $currentContents = File::get($helpersIndexFile);
        if (!str_contains($currentContents, $requireLine)) {
            File::append($helpersIndexFile, "$requireLine");
            $this->info("📌 Baris require '{$helperClassName}.php' ditambahkan ke Helpers.php");
        } else {
            $this->warn("⚠️ Baris require '{$helperClassName}.php' sudah ada di Helpers.php");
        }
    } else {
        $stubHelpers = "<?php\\n $requireLine\\n";
        File::put($helpersIndexFile, $stubHelpers);
        $this->info("📌 Helpers.php dibuat dan require '{$helperClassName}.php' ditambahkan");
    }
})->describe('Membuat file helper baru');


//php artisan make:custom-command program:shalat-berjamaah ShalatBerjamaahCommand "Untuk mengelola jadwal shalat berjamaah dan informasi terkait shalat berjamaah" ShalatBerjamaah --force
//php artisan make:custom-command my:command MyCommand "Deskripsi command" MyApp --force
// php artisan make:custom-observer Siswa Siswa


/*
    |--------------------------------------------------------------------------
    | 📌 Observer :
    |--------------------------------------------------------------------------
    |
    | Fitur :
    | - xxxxxxxxxxx
    | - xxxxxxxxxxx
    |
    | Tujuan :
    | - xxxxxxxxxxx
    |
    |
    | Penggunaan :
    | - php artisan make:custom-observer NamaObserver NamaModel
    | - php artisan make:custom-observer Detailsiswa Detailsiswa
    |
    */
// Proses Coding
Artisan::command('make:custom-observer {name} {model} {--force}', function () {
    $name   = $this->argument('name');   // Nama Observer
    $model  = $this->argument('model');  // Nama Model target
    $force  = $this->option('force');

    $className     = ucfirst($name) . 'Observer';
    $modelVariable = Str::camel(class_basename($model)); // ex: Siswa => $siswa
    $filePath      = app_path("Observers/{$className}.php");

    // Cegah overwrite
    if (File::exists($filePath) && !$force) {
        $this->error("❌ Observer '{$className}' sudah ada. Gunakan --force untuk menimpa.");
        return;
    }

    // Template file observer
    $template = <<<PHP
<?php

namespace App\Observers;

// use App\Models\\{$model};

class {$className}
{
    public function creating({$model} \${$modelVariable}): void
    {
        //
    }

    public function created({$model} \${$modelVariable}): void
    {
        //
    }

    public function updating({$model} \${$modelVariable}): void
    {
        //
    }

    public function updated({$model} \${$modelVariable}): void
    {
        //
    }

    public function deleting({$model} \${$modelVariable}): void
    {
        //
    }

    public function deleted({$model} \${$modelVariable}): void
    {
        //
    }

    public function restored({$model} \${$modelVariable}): void
    {
        //
    }

    public function forceDeleted({$model} \${$modelVariable}): void
    {
        //
    }
}

PHP;

    // Simpan file
    File::ensureDirectoryExists(app_path('Observers'));
    File::put($filePath, $template);
    $this->info("✅ Observer '{$className}' berhasil dibuat di: {$filePath}");

    // Auto-register ke AppServiceProvider
    $providerPath = app_path('Providers/AppServiceProvider.php');
    $providerContents = File::get($providerPath);

    $useStatement = "use App\\Models\\{$model};\\nuse App\\Observers\\{$className};";
    if (!str_contains($providerContents, "use App\\Observers\\{$className};")) {
        $providerContents = preg_replace(
            '/(namespace App\\\\Providers;)/',
            "$1\\n\\n{$useStatement}",
            $providerContents,
            1
        );
    }

    $bootRegister = "{$model}::observe({$className}::class);";
    if (!str_contains($providerContents, $bootRegister)) {
        $providerContents = preg_replace(
            '/public function boot\(\)\s*:?[\s\w]*\{/',
            "public function boot(): void\\n    {\\n        {$bootRegister};",
            $providerContents,
            1
        );
    }

    File::put($providerPath, $providerContents);
    $this->info("📌 Observer '{$className}' otomatis terdaftar di AppServiceProvider@boot!");
})->describe('Membuat custom observer dan auto-register ke AppServiceProvider');
/*
    |--------------------------------------------------------------------------
    | 📌 Commands :
    |--------------------------------------------------------------------------
    |
    | Fitur :
    | - Pembuatan commands dan helper otomatis
    | - xxxxxxxxxxx
    |
    | Tujuan :
    | - xxxxxxxxxxx
    |
    |
    | Penggunaan :
    | - php artisan make:comhelp sync:user User/Sync "Sinkronisasi User" MyApp
    |
    */
// Proses Coding
Artisan::command('make:comhelp {signature} {name} {deskripsi} {namaapps} {--force}', function ($signature, $name, $deskripsi, $namaapps) {
    $force = $this->option('force');

    // --- Handle Subfolder ---
    $name = str_replace('\\', '/', $name); // normalize backslash ke slash
    $parts = explode('/', $name);
    $baseName = ucfirst(array_pop($parts));   // nama terakhir (ex: Sync)
    $className = $baseName . 'Command';       // class command (ex: SyncCommand)
    $helperClassName = $baseName . 'Helper';  // class helper (ex: SyncHelper)
    $subPath = implode('/', array_map('ucfirst', $parts)); // subfolder (ex: User)

    // Namespace Command
    $namespace = 'App\\Console\\Commands' . ($subPath ? '\\' . str_replace('/', '\\', $subPath) : '');
    $filePath = app_path("Console/Commands" . ($subPath ? "/$subPath" : '') . "/{$className}.php");

    // Path Helper
    $helperDir = app_path('Helpers' . ($subPath ? "/$subPath" : ''));
    $helperFile = $helperDir . '/' . $helperClassName . '.php';

    // --- Cegah overwrite ---
    if (File::exists($filePath) && !$force) {
        $this->error("❌ File '{$className}.php' sudah ada. Gunakan --force untuk menimpa.");
        return;
    }
    if ($force) $this->warn("⚠️ Menimpa file '{$className}.php' karena --force dipakai.");

    // --- Template file command ---
    $template = <<<PHP
<?php

namespace {$namespace};

use Illuminate\Console\Command;

class {$className} extends Command
{
    protected \$signature = '{$signature}';
    protected \$description = '{$deskripsi}';

    /*
        |----------------------------------------------------------------------
        | 📌 {$namaapps}
        |----------------------------------------------------------------------
        | Jelaskan tujuan dan contoh schedule di sini
        |
    */

    public function handle()
    {
        // Tuliskan logika command di sini
        \$this->info("Command '{$className}' berhasil dijalankan.");
    }
}
PHP;

    File::ensureDirectoryExists(dirname($filePath));
    File::put($filePath, $template);
    $this->info("✅ Custom command '{$className}' berhasil dibuat di: {$filePath}");

    // --- Auto-register ke Kernel.php ---
    $kernelPath = app_path('Console/Kernel.php');
    $commandClass = "\\{$namespace}\\{$className}::class";

    $kernelContents = File::get($kernelPath);
    if (!str_contains($kernelContents, $commandClass)) {
        $updatedContents = preg_replace(
            '/protected \$commands\s*=\s*\[[^\]]*/',
            '$0' . "\\n        {$commandClass},\\n",
            $kernelContents
        );
        File::put($kernelPath, $updatedContents);
        $this->info("📌 Command '{$className}' berhasil di-register ke Kernel.php");
    } else {
        $this->warn("ℹ️ Command '{$className}' sudah ada di Kernel.php.");
    }

    // --- Buat Helper ---
    File::ensureDirectoryExists($helperDir);

    if (File::exists($helperFile) && !$force) {
        $this->warn("❌ Helper '{$helperClassName}' sudah ada. Gunakan --force untuk menimpa.");
    } else {
        if ($force) $this->warn("⚠️ Menimpa helper '{$helperClassName}' karena --force dipakai.");

        $stub = <<<PHP
<?php

/*
    |----------------------------------------------------------------------
    | 📌 Helper {$helperClassName}
    |----------------------------------------------------------------------
    |
*/

if (!function_exists('{$helperClassName}')) {
    function {$helperClassName}(\$param = null) {
        return "Helper {$helperClassName} dijalankan dengan param: " . json_encode(\$param);
    }
}
PHP;

        File::put($helperFile, $stub);
        $this->info("✅ Helper '{$helperClassName}' berhasil dibuat di: {$helperFile}");
    }

    // --- Auto-inject ke Helpers.php ---
    $helpersIndexFile = app_path('Helpers/Helpers.php');
    $requireLine = "require_once __DIR__ . '" . ($subPath ? '/' . $subPath : '') . '/' . $helperClassName . ".php';";

    if (File::exists($helpersIndexFile)) {
        $currentContents = File::get($helpersIndexFile);
        if (!str_contains($currentContents, $requireLine)) {
            File::append($helpersIndexFile, "\\n$requireLine");
            $this->info("📌 Baris require '{$helperClassName}.php' ditambahkan ke Helpers.php");
        } else {
            $this->warn("⚠️ Baris require '{$helperClassName}.php' sudah ada di Helpers.php");
        }
    } else {
        $stubHelpers = "<?php\\n$requireLine\\n";
        File::put($helpersIndexFile, $stubHelpers);
        $this->info("📌 Helpers.php dibuat dan require '{$helperClassName}.php' ditambahkan");
    }
})->describe('Membuat Command + Helper otomatis (make:comhelp)');
/*
    |--------------------------------------------------------------------------
    | 📌 Route :
    |--------------------------------------------------------------------------
    |
    | Fitur :
    | - xxxxxxxxxxx
    | - xxxxxxxxxxx
    |
    | Tujuan :
    | - xxxxxxxxxxx
    |
    |
    | Penggunaan :
    | - php artisan make:routefile admin/portal
    |
    */
// Proses Coding

Artisan::command('make:routefile {name} {--force}', function ($name) {
    $force = $this->option('force');

    // --- Normalisasi Nama ---
    $name = str_replace('\\', '/', strtolower($name)); // kecil semua biar konsisten
    $parts = explode('/', $name);
    $baseName = array_pop($parts); // misal: absensi
    $subPath = implode('/', $parts); // misal: admin
    $fileName = $baseName . '.php'; // absensi.php

    $routeDir = base_path('routes' . ($subPath ? "/$subPath" : ''));
    $filePath = $routeDir . '/' . $fileName;

    // --- Cegah overwrite ---
    if (File::exists($filePath) && !$force) {
        $this->error("❌ File route '{$fileName}' sudah ada. Gunakan --force untuk menimpa.");
        return;
    }
    if ($force) $this->warn("⚠️ Menimpa file '{$fileName}' karena --force dipakai.");

    File::ensureDirectoryExists($routeDir);

    // --- Template File Route ---
    $template = <<<PHP
<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 📌 Route: {$baseName}
|--------------------------------------------------------------------------
| Daftarkan route untuk modul {$baseName} di sini
|
*/

Route::prefix('{$baseName}')->group(function () {
    Route::get('/', function () {
        return "Ini route {$baseName}";
    });
});
PHP;

    File::put($filePath, $template);
    $this->info("✅ Route file '{$fileName}' berhasil dibuat di: {$filePath}");

    // --- Auto-inject ke RouteServiceProvider ---
    $rspPath = app_path('Providers/RouteServiceProvider.php');

    // --- Pakai loadRoutesFrom langsung ---
    $loadLine = "\$this->loadRoutesFrom(base_path('routes"
        . ($subPath ? "/$subPath" : '') . "/$fileName'));\\n";

    $rspContents = File::get($rspPath);

    if (!str_contains($rspContents, $loadLine)) {
        // Sisipkan sebelum line load api.php atau di akhir boot() routes()
        $updatedContents = str_replace(
            "\$this->loadRoutesFrom(base_path('routes/api.php'));",
            $loadLine . "        \$this->loadRoutesFrom(base_path('routes/api.php'));",
            $rspContents
        );

        File::put($rspPath, $updatedContents);
        $this->info("📌 Route file '{$fileName}' berhasil di-register ke RouteServiceProvider menggunakan loadRoutesFrom");
    } else {
        $this->warn("ℹ️ Route file '{$fileName}' sudah ada di RouteServiceProvider");
    }
})->describe('Membuat file route otomatis + inject ke RouteServiceProvider');




// belum jelas alurnya
//php artisan make:addon Perpustakaan --force
Artisan::command('make:addon {modul} {--force}', function () {
    $modul  = Str::studly($this->argument('modul'));   // Nama modul, ex: Perpustakaan
    $slug   = Str::kebab($modul);                      // ex: perpustakaan
    $force  = $this->option('force');

    // 1️⃣ Buat folder provider
    $providerDir  = app_path("Providers/Program");
    $providerPath = "{$providerDir}/{$modul}ServiceProvider.php";
    File::ensureDirectoryExists($providerDir);

    if (!File::exists($providerPath) || $force) {
        $providerTemplate = <<<PHP
<?php

namespace App\Providers\Program;

use Illuminate\Support\ServiceProvider;

class {$modul}ServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        \$this->loadRoutesFrom(base_path('routes/program/{$slug}.php'));
    }
}
PHP;
        File::put($providerPath, $providerTemplate);
        $this->info("✅ Provider '{$modul}ServiceProvider' berhasil dibuat di {$providerPath}");
    } else {
        $this->warn("⚠️ Provider '{$modul}ServiceProvider' sudah ada. Gunakan --force untuk menimpa.");
    }

    // 2️⃣ Buat folder & file route (tanpa subfolder modul)
    $routeDir  = base_path("routes/program");
    $routePath = "{$routeDir}/{$slug}.php";
    File::ensureDirectoryExists($routeDir);

    if (!File::exists($routePath) || $force) {
        $routeTemplate = <<<PHP
<?php

use Illuminate\Support\Facades\Route;

Route::prefix('{$slug}')->group(function () {
    // Tambahkan route modul di sini
});
PHP;
        File::put($routePath, $routeTemplate);
        $this->info("✅ Route file '{$slug}.php' berhasil dibuat di {$routePath}");
    } else {
        $this->warn("⚠️ Route file '{$slug}.php' sudah ada. Gunakan --force untuk menimpa.");
    }

    // 3️⃣ Inject ke RouteServiceProvider
    $routeProviderPath = app_path('Providers/RouteServiceProvider.php');
    if (File::exists($routeProviderPath)) {
        $content = File::get($routeProviderPath);

        // baris loader
        $injectLine = "        \$this->loadRoutesFrom(base_path('routes/program/{$slug}.php'));";

        if (!Str::contains($content, $injectLine)) {
            // Regex aman: cari boot() lengkap (non-greedy)
            $pattern = '/(public function boot\(\)\s*:\s*void\s*\{)([\s\S]*?)(\})/m';
            $replacement = "$1$2\\n{$injectLine}\\n$3";

            $newContent = preg_replace($pattern, $replacement, $content);

            if ($newContent) {
                File::put($routeProviderPath, $newContent);
                $this->info("📌 Route '{$slug}.php' otomatis diinject ke RouteServiceProvider");
            } else {
                $this->warn("⚠️ Gagal inject ke RouteServiceProvider, cek format file bro");
            }
        } else {
            $this->warn("⚠️ Route '{$slug}.php' sudah ada di RouteServiceProvider, skip inject");
        }
    } else {
        $this->warn("⚠️ RouteServiceProvider.php tidak ditemukan di {$routeProviderPath}");
    }

    // 4️⃣ Auto-register modul di DB
    Modul::updateOrCreate(
        ['modul' => $modul],
        [
            'provider_class' => "App\\Providers\\Program\\{$modul}ServiceProvider",
            'route' => "routes\\program\\{$slug}.php",
            'is_active'      => 1,
            'slug'           => $slug,
        ]
    );
    $this->info("📌 Modul '{$modul}' otomatis terdaftar di DB moduls (is_active=1)");

    // 5️⃣ Inject juga ke Seeder
    $seederPath = database_path('seeders/AdminDev/ModulSeeder.php');
    if (File::exists($seederPath)) {
        $seederContent = File::get($seederPath);

        if (Str::contains($seederContent, "'{$slug}'") === false) {
            $pattern = '/(\$x\s*=\s*\[)([\s\S]*?)(\];)/';
            $replacement = "$1$2    '{$slug}',\\n$3";

            $newContent = preg_replace($pattern, $replacement, $seederContent);

            if ($newContent) {
                File::put($seederPath, $newContent);
                $this->info("📌 Modul '{$slug}' otomatis ditambahkan ke ModulSeeder");
            } else {
                $this->warn("⚠️ Gagal inject modul ke ModulSeeder, edit manual ya Bro");
            }
        } else {
            $this->warn("⚠️ Modul '{$slug}' sudah ada di ModulSeeder, skip inject");
        }
    } else {
        $this->warn("⚠️ File ModulSeeder.php tidak ditemukan di {$seederPath}, inject dilewati");
    }
})->describe('Membuat addon modular lengkap dengan provider, route file (tanpa subfolder), auto-register ke DB, dan inject ke RouteServiceProvider & Seeder');
// Seeder Indetitas
Artisan::command('make:custom-guru {dataseeder} {--force}', function ($dataseeder) {
    $force = $this->option('force');

    // 1️⃣ Parse folder & nama file
    $dataseeder = str_replace('\\', '/', $dataseeder); // normalize
    $parts = explode('/', $dataseeder);
    $name  = array_pop($parts);
    $folder = database_path('seeders/' . implode('/', $parts));
    $path   = "{$folder}/{$name}.php";

    // 2️⃣ Pastikan folder ada
    File::ensureDirectoryExists($folder);

    // 3️⃣ Cek file exist / force
    if (!File::exists($path) || $force) {
        $className = Str::studly($name);
        $template = <<<PHP
<?php

namespace Database\Seeders\Identitas\{name};

use Carbon\Carbon;
use Faker\Factory as Faker;
use App\Models\Admin\Identitas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class {$className} extends Seeder
{
    public function run(): void
    {
        // Tambahkan logic seeder di sini
         //
        \$faker = Faker::create('id_ID'); //Simpan didalam code run
        \$randomCreatedAt = Carbon::now()->startOfMonth()->addDays(rand(0, Carbon::now()->day - 1));
        \$randomUpdatedAt = \$randomCreatedAt->copy()->addMinutes(rand(10, 300));
        \$CounterData = 1;
        \$guruArray = [
            [
                'user_id' => null,
                'kelas_id' => null,
                'foto' => null,
                'kode_guru' => 'CY',
                'nama_guru' => 'Cahya Nurwenda, S.Pd',
                'nip' => null,
                'nuptk' => '3951762664110030',
                'nik' => '3329161906840000',
                'status' => 'HonorSertifikasi',
                'tahun_sertifikasi' => '2014',
                'jenis_kelamin' => 'Laki - Laki',
                'pendidikan' => 'S1',
                'lulusan' => '2007',
                'jurusan' => 'Pendidikan B. Inggris',
                'tahun_lulus' => '2007',
                'rt' => '2',
                'rw' => '8',
                'desa' => 'Kubangsari',
                'kecamatan' => 'ketanggungan',
                'kabupaten' => 'Brebes',
                'provinsi' => 'Jawa Tengah',
                'jalan' => 'Kubangsari',
                'alamat' => 'Kubangsari, Rt 2, Rw 8, Desa Kubangsari, Kecamatan ketanggungan, Kabupaten Brebes',
                'no_hp' => '628989290441',
                'agama' => 'Islam',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '19/06/1984',
                'tmt_mengajar' => '16/07/2005',
            ],

       \$DataGurusArray = array_map(fn(\$guru) => (object) \$guru, \$guruArray);
        // dd(count(\$DataGurusArray));
        // \$DataGurus = (object) \$DataGurusArray;
        // \$TotalData = count(\$DataGurus);
        // echo "\\n🔢 Data Guru Real.\\n";
        // echo "\\n🔢 Jumlah Data : \$TotalData.\\n";
        // echo "\\n___________________________________\\n";
        foreach (\$DataGurusArray as \$dataGuru) {

            try {
                DB::beginTransaction(); // 🚀 Mulai transaksi
                \$namaExplode = explode(",", \$dataGuru->nama_guru);
                \$nama = ucwords(strtolower(\$namaExplode[0]));
                \$gelar = \$namaExplode[1];
                // Insert user
                DB::table('users')->insert([
                    'posisi'                => 'Guru',
                    'aktiv'                 => 'Y',
                    'detailguru_id'         => null,
                    'name'                  => \$nama,
                    'email'                 => \$dataGuru->kode_guru . '@gmail.com',
                    'email_verified_at'     => now(),
                    'password'              => Hash::make('Password'),
                    'remember_token'        => Str::random(10),
                    'created_at'            => now(),
                    'updated_at'            => now(),
                ]);
                \$this->command->info("✅ DB User masuk! {\$nama}");

                // Ambil ID user terakhir
                \$lasUser = User::orderBy('id', 'desc')->value('id');

                // Insert detail guru
                DB::table('detailgurus')->insert([
                    'user_id'               => \$lasUser,
                    'kode_guru'             => \$dataGuru->kode_guru,
                    'nama_guru'             => \$nama,
                    'gelar'                 => \$gelar,
                    'nip'                   => \$dataGuru->nip,
                    'nik'                   => \$dataGuru->nik,
                    'status'                => \$dataGuru->status,
                    'tahun_sertifikasi'     => \$dataGuru->tahun_sertifikasi,
                    'jenis_kelamin'         => \$dataGuru->jenis_kelamin === 'Laki - Laki' ? 'Laki-laki' : 'Perempuan',
                    'lulusan'               => \$dataGuru->lulusan,
                    'rt'                    => str_pad(\$dataGuru->rt, 3, '0', STR_PAD_LEFT),
                    'rw'                    => str_pad(\$dataGuru->rw, 3, '0', STR_PAD_LEFT),
                    'jurusan'               => ucwords(\$dataGuru->jurusan),
                    'tahun_lulus'           => \$dataGuru->tahun_lulus,
                    'alamat'                => \$dataGuru->alamat,
                    'kabupaten'             => \$dataGuru->kabupaten,
                    'provinsi'              => \$dataGuru->provinsi,
                    'pendidikan'            => \$dataGuru->pendidikan,
                    'agama'                 => 'Islam',
                    'tempat_lahir'          => \$dataGuru->tempat_lahir,
                    'tanggal_lahir'         => \$dataGuru->tanggal_lahir
                        ? Carbon::create(format_tanggal_lahir(\$dataGuru->tanggal_lahir))->format('Y-m-d')
                        : null,
                    'no_hp' => \$dataGuru->no_hp,
                    'tmt_mengajar' => \$dataGuru->tmt_mengajar
                        ? Carbon::create(format_tanggal_lahir(\$dataGuru->tmt_mengajar))->format('Y-m-d')
                        : null,

                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Ambil ID detail guru terakhir dan update user
                \$LatestDetailGuru = Detailguru::orderBy('id', 'desc')->value('id');
                DB::table('users')->where('id', \$lasUser)->update([
                    'detailguru_id' => \$LatestDetailGuru
                ]);


                DB::commit(); // 🎉 Simpan transaksi jika semua aman

                GQrGuru(\$dataGuru->kode_guru);
                \$CounterData++;
                echo "\r Data Ke {\$CounterData}";
            } catch (\Exception \$e) {
                DB::rollBack(); // 🧨 Gagal? Rollback semuanya!
                \$this->command->error("❌ Gagal insert data guru: " . \$dataGuru->nama_guru);
                \$this->command->error("🔁 Alasan: " . \$e->getMessage());
            }
        }

        // \$Gurus = Detailguru::get();
        // foreach (\$Gurus as \$Guru) {
        //     GQrGuru(\$Guru->kode_guru);
        // }
        echo "\\n___________________________________\\n";
        \$this->command->info("✅ Seeder RealGUruSeeder berhasil dijalankan!");
    }
}
PHP;

        // Tentukan namespace
        $namespace = implode('\\', array_map([Str::class, 'studly'], $parts));
        $template = str_replace('{namespace}', $namespace ?: 'AdminDev', $template);

        File::put($path, $template);
        $this->info("✅ Custom seeder '{$className}' berhasil dibuat di {$path}");
    } else {
        $this->warn("⚠️ Seeder '{$name}.php' sudah ada, gunakan --force untuk menimpa");
    }
})->describe('Membuat custom seeder di folder yang ditentukan dengan namespace otomatis');

// Seeder Indetitas
Artisan::command('make:custom-identitas {dataseeder} {--force}', function ($dataseeder) {
    $force = $this->option('force');

    // 1️⃣ Parse folder & nama file
    $dataseeder = str_replace('\\', '/', $dataseeder); // normalize
    $parts = explode('/', $dataseeder);
    $name  = array_pop($parts);
    $folder = database_path('seeders/identitas' . implode('/', $parts));
    $path   = "{$folder}/{$name}.php";

    // 2️⃣ Pastikan folder ada
    File::ensureDirectoryExists($folder);

    // 3️⃣ Cek file exist / force
    if (!File::exists($path) || $force) {
        $className = Str::studly($name);
        $template = <<<PHP
<?php

namespace Database\Seeders\{namespace};

use Carbon\Carbon;
use Faker\Factory as Faker;
use App\Models\Admin\Identitas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class {$className} extends Seeder
{
    public function run(): void
    {
        // Tambahkan logic seeder di sini
        // dd(Identitas::first());
        \$namasek =  'Sekolah Cipta IT';
        \$namasingkat =  'MTSMH';
        \$faker = Faker::create('id_ID');
        \$paket = 'Kerjasama'; //Gratis
        \$trial_ends_at = now()->addDays(365);
        /**
         * Ambil serial number hardisk dan gabungkan dengan tanda "-"
         *
         * @return string
         */
        function getDiskSerials(): string
        {
            // Jalankan command WMIC untuk Windows
            \$serials = shell_exec('wmic diskdrive get serialnumber');

            if (!\$serials) {
                return ''; // kembalikan string kosong kalau gagal
            }

            // Pecah ke array per baris dan trim whitespace
            \$lines = array_filter(array_map('trim', explode("\\n", \$serials)));

            // Hapus header "SerialNumber" jika ada
            if (isset(\$lines[0]) && strtolower(\$lines[0]) === 'serialnumber') {
                array_shift(\$lines);
            }

            // Gabungkan dengan tanda "-"
            return implode('-', \$lines);
        }

        // Contoh pemakaian
        \$disk = getDiskSerials();
        // TokenApp =
        \$tokenPlain = \$namasek . '|' . \$paket . '|' . \$trial_ends_at . '|admindev' . uniqid();

        \$tokenEncrypted = Crypt::encryptString(\$tokenPlain); // Enkripsi
        // dd(\$tokenEncrypted);
        DB::table('identitas')->insert(
            [
                'token'                 => \$tokenEncrypted,
                'paket'                 => \$paket,
                'trial_ends_at'         => null,
                'jenjang'               => 'MTS S',
                'nomor'                 => null,
                'kode_sekolahan'        => null,
                'kode_kabupaten'        => 29,
                'kode_provinsi'         => 33,
                'namasek'               => \$namasek,
                'namasingkat'           => \$namasingkat,
                'nsm'                   =>  null,
                'npsn'                  =>  null,
                'status'                => 'Swasta',
                'akreditasi'            => 'B',
                'logo'                  => 'logo.png',
                'phone'                 => null,
                'email'                 => 'xxxxxxxxxx@gmail.com',
                'alamat'                => 'null',
                'jalan'                 => 'null',
                'desa'                  => 'null',
                'kecamatan'             => 'Kersana',
                'kabupaten'             => 'Brebes',
                'provinsi'              => 'Jawa Tengah',
                'kode_pos'              => 'null',
                'namakepala'            => 'null',
                'nip_kepala'            => null,
                'visi'                  => null,
                'misi'                  => null,
                'tujuan'                => null,
                'website'               => null,
                'youtube'               => null,
                'facebook_fanspage'     => null,
                // 'facebook_fanspage'  => null,
                'facebook_group'        => null,
                'twiter'                => null,
                'instagram'             => null,
                'whatsap_group_guru'    => null,
                'internet'              => 'Indehome',
                'speed'                 => '30 Mbps',
                'referensi_data'        => 'https://referensi.data.kemendikdasmen.go.id/pendidikan/npsn/20364751',
                'sekolah_data'          => 'https://sekolah.data.kemendikdasmen.go.id/index.php/Chome/profil/676CC516-0170-436F-A55C-E59C773CCA4B',
                'created_at'            => now(),
                'updated_at'            => now(),

            ]
        );
    }
}
PHP;

        // Tentukan namespace
        $namespace = implode('\\', array_map([Str::class, 'studly'], $parts));
        $template = str_replace('{namespace}', $namespace ?: 'AdminDev', $template);

        File::put($path, $template);
        $this->info("✅ Custom seeder '{$className}' berhasil dibuat di {$path}");
    } else {
        $this->warn("⚠️ Seeder '{$name}.php' sudah ada, gunakan --force untuk menimpa");
    }
})->describe('Membuat custom seeder di folder yang ditentukan dengan namespace otomatis');

Artisan::command('make:custom-allidentitas {dataseeder} {--force}', function ($dataseeder) {
    $force = $this->option('force');

    // 1️⃣ Normalize input & parse folder/nama
    $dataseeder = str_replace('\\', '/', $dataseeder);
    $parts = explode('/', $dataseeder);
    $name = array_pop($parts);                       // nama file seeder
    $subFolder = $parts ? implode('/', $parts) : ''; // folder sub-namespace

    // 2️⃣ Tentukan folder & path file seeder utama
    $folder = database_path('seeders/identitas' . ($subFolder ? '/' . $subFolder : ''));
    File::ensureDirectoryExists($folder);
    $path = "{$folder}/{$name}.php";

    // 3️⃣ Tentukan namespace
    $namespace = 'Database\\Seeders\\Identitas' . ($parts ? '\\' . implode('\\', array_map([Str::class, 'studly'], $parts)) : '');

    // 4️⃣ Buat seeder utama
    if (!File::exists($path) || $force) {
        $className = Str::studly($name);
        $template = <<<PHP
<?php

namespace {$namespace};

use Carbon\Carbon;
use Faker\Factory as Faker;
use App\Models\Admin\Identitas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class {$className} extends Seeder
{
    public function run(): void
    {
        // Tambahkan logic seeder di sini
        // dd(Identitas::first());
        \$namasek =  'Sekolah Cipta IT';
        \$namasingkat =  'MTSMH';
        \$faker = Faker::create('id_ID');
        \$paket = 'Kerjasama'; //Gratis
        \$trial_ends_at = now()->addDays(365);
        /**
         * Ambil serial number hardisk dan gabungkan dengan tanda "-"
         *
         * @return string
         */
        function getDiskSerials(): string
        {
            // Jalankan command WMIC untuk Windows
            \$serials = shell_exec('wmic diskdrive get serialnumber');

            if (!\$serials) {
                return ''; // kembalikan string kosong kalau gagal
            }

            // Pecah ke array per baris dan trim whitespace
            \$lines = array_filter(array_map('trim', explode("\\n", \$serials)));

            // Hapus header "SerialNumber" jika ada
            if (isset(\$lines[0]) && strtolower(\$lines[0]) === 'serialnumber') {
                array_shift(\$lines);
            }

            // Gabungkan dengan tanda "-"
            return implode('-', \$lines);
        }

        // Contoh pemakaian
        \$disk = getDiskSerials();
        // TokenApp =
        \$tokenPlain = \$namasek . '|' . \$paket . '|' . \$trial_ends_at . '|admindev' . uniqid();

        \$tokenEncrypted = Crypt::encryptString(\$tokenPlain); // Enkripsi
        // dd(\$tokenEncrypted);
        DB::table('identitas')->insert(
            [
                'token'                 => \$tokenEncrypted,
                'paket'                 => \$paket,
                'trial_ends_at'         => null,
                'jenjang'               => 'MTS S',
                'nomor'                 => null,
                'kode_sekolahan'        => null,
                'kode_kabupaten'        => 29,
                'kode_provinsi'         => 33,
                'namasek'               => \$namasek,
                'namasingkat'           => \$namasingkat,
                'nsm'                   =>  null,
                'npsn'                  =>  null,
                'status'                => 'Swasta',
                'akreditasi'            => 'B',
                'logo'                  => 'logo.png',
                'phone'                 => null,
                'email'                 => 'xxxxxxxxxx@gmail.com',
                'alamat'                => 'null',
                'jalan'                 => 'null',
                'desa'                  => 'null',
                'kecamatan'             => 'Kersana',
                'kabupaten'             => 'Brebes',
                'provinsi'              => 'Jawa Tengah',
                'kode_pos'              => 'null',
                'namakepala'            => 'null',
                'nip_kepala'            => null,
                'visi'                  => null,
                'misi'                  => null,
                'tujuan'                => null,
                'website'               => null,
                'youtube'               => null,
                'facebook_fanspage'     => null,
                // 'facebook_fanspage'  => null,
                'facebook_group'        => null,
                'twiter'                => null,
                'instagram'             => null,
                'whatsap_group_guru'    => null,
                'internet'              => 'Indehome',
                'speed'                 => '30 Mbps',
                'referensi_data'        => 'https://referensi.data.kemendikdasmen.go.id/pendidikan/npsn/20364751',
                'sekolah_data'          => 'https://sekolah.data.kemendikdasmen.go.id/index.php/Chome/profil/676CC516-0170-436F-A55C-E59C773CCA4B',
                'created_at'            => now(),
                'updated_at'            => now(),

            ]
        );
    }
}
PHP;
        File::put($path, $template);
        $this->info("✅ Seeder utama '{$className}' berhasil dibuat di {$path}");
    } else {
        $this->warn("⚠️ Seeder '{$name}.php' sudah ada, gunakan --force untuk menimpa");
    }

    // 5️⃣ Buat seeders tambahan (RealUserAdminSeeder & RealGuruSeeder) di subfolder yang sama
    $additionalSeeders = [
        'RealUserAdminSeeder' => <<<PHP
<?php

namespace {$namespace};

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Admin\Identitas;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Facades\DB;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Hash;


class RealUserAdminSeeder extends Seeder
{
        public function run(): void
    {
        \$faker = FakerFactory::create('id_ID');
        \$status = ['GTY', 'Guru Honorer', 'Sertifikasi'];
        \$pendidikan = ['D2', 'D3', 'D4', 'S1', 'S2'];
        \$agama = ['Islam'];
        \$jenis_kelamin = ['L', 'P'];
        // 🚨 Nonaktifkan foreign key sementara
        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        // 🔥 Truncate semua tabel yang dibutuhkan (urutan bebas!)
        //DB::table('edokrapats')->truncate();
        //DB::table('users')->truncate();
        //DB::table('detailgurus')->truncate(); // misal ada relasi lain

        // ✅ Nyalakan lagi FK check
        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
        // DB::table('users')->truncate(); // Hapus semua data sebelum insert baru
        // DB::table('detailgurus')->truncate(); // Hapus semua data sebelum insert baru
        \$Identitas = Identitas::first();
        // Admin Dev User
        DB::table('users')->insert([
            'posisi' => 'Admindev',
            'aktiv' => 'Y',
            'detailguru_id' => null,
            'detailsiswa_id' => null,
            'tingkat_id' => null,
            'kelas_id' => null,
            'name' => 'Admin Dev',
            'email' => 'admindev@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admindev'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \$nama_guru = \$faker->name;
        DB::table('detailgurus')->insert([
            'user_id' => 1,
            'kode_guru' => 1,
            'nama_guru' => 'Admin Dev',
            'nip' => \$faker->unique()->numerify('############'),
            'status' => \$status[array_rand(\$status)],
            'jenis_kelamin' => \$jenis_kelamin[array_rand(\$jenis_kelamin)],
            'pendidikan' => \$pendidikan[array_rand(\$pendidikan)],
            'agama' => \$agama[0],
            'no_hp' => \$faker->phoneNumber,
            'tmt_mengajar' => \$faker->dateTimeBetween('-1 week', '+1 week'),
            'created_at' => \$faker->dateTimeBetween('-1 week', '+1 week'),
            'updated_at' => now(),
        ]);
        // Generate Dummy Data for DetailGuru and Users
        for (\$i = 1; \$i <= 2; \$i++) {
            \$jenis_kelamin = \$faker->randomElement(['male', 'female']);
            if (\$jenis_kelamin === 'L') {
                \$jengkel = 'Laki-laki';
            } else {
                \$jengkel = 'Perempuan';
            }
            // \$nama_guru = \$faker->name(\$jenis_kelamin);
            \$nama_guru = 'Admin';
            \$user = DB::table('users')->insertGetId([
                'posisi' => \$i === 1 ? 'Admin' : (\$i === 2 ? 'Kepala Sekolah' : (\$i === 3 ? 'Guru' : (\$i === 4 ? 'Guru' : (\$i === 5 ? 'Guru' : (\$i === 6 ? 'Karyawan' : 'Karyawan'))))),
                'aktiv' => 'Y',
                'detailguru_id' => null,
                'detailsiswa_id' => null,
                'tingkat_id' => null,
                'kelas_id' => null,
                'name' => \$nama_guru,
                // 'email' => \$faker->unique()->safeEmail,
                'email' => \$i === 1 ? \$Identitas->email : (\$i === 2 ? 'kepalasekolah@gmail.com' : (\$i === 3 ? 'wakakurikulum@gmail.com' : (\$i === 4 ? 'wakakesiswaan@gmail.com' : (\$i === 5 ? 'wakaksarpras' : (\$i === 6 ? 'katu@gmail.com' : 'karyawan@gmail.com'))))),
                'email_verified_at' => now(),
                'password' => Hash::make('Password'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            preg_match_all('/[A-Z]/', \$nama_guru, \$matches);
            \$kode = implode('', \$matches[0]);
            DB::table('detailgurus')->insert([
                'user_id' => \$user,
                'kode_guru' => \$kode,
                'nama_guru' => \$nama_guru,
                'nip' => \$faker->unique()->numerify('############'),
                'status' => \$status[array_rand(\$status)],
                'jenis_kelamin' => \$jengkel,
                'pendidikan' => \$pendidikan[array_rand(\$pendidikan)],
                'agama' => \$agama[0],
                'no_hp' => \$faker->phoneNumber,
                'tmt_mengajar' => \$faker->dateTimeBetween('-1 week', '+1 week'),
                'created_at' => \$faker->dateTimeBetween('-1 week', '+1 week'),
                'updated_at' => now(),
            ]);
        }
        \$Identitas = Identitas::first();
        \$updatedataUser = User::where('posisi', 'Kepala Sekolah')->first();

        if (\$Identitas && \$updatedataUser) {
            // Update nama di tabel User
            \$updatedataUser->update([
                'name' => \$Identitas->namakepala
            ]);

            // Update nama di tabel Detailguru
            \$UpdateDataGuru = Detailguru::where('id', \$updatedataUser->detailguru_id)->update([
                'nama_guru' => \$Identitas->namakepala
            ]);
        }
    }
}
PHP,
        'RealGuruSeeder' => <<<PHP
<?php

namespace {$namespace};


use Carbon\Carbon;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Hash;
class RealGuruSeeder extends Seeder
{
    public function run(): void
    {
        // Tambahkan logic seeder RealGuruSeeder di sini
        //
        \$faker = Faker::create('id_ID'); //Simpan didalam code run
        \$randomCreatedAt = Carbon::now()->startOfMonth()->addDays(rand(0, Carbon::now()->day - 1));
        \$randomUpdatedAt = \$randomCreatedAt->copy()->addMinutes(rand(10, 300));
        \$CounterData = 1;
        \$guruArray = [
            [
                'user_id' => null,
                'kelas_id' => null,
                'foto' => null,
                'kode_guru' => 'CY',
                'nama_guru' => 'Cahya Nurwenda, S.Pd',
                'nip' => null,
                'nuptk' => '3951762664110030',
                'nik' => '3329161906840000',
                'status' => 'HonorSertifikasi',
                'tahun_sertifikasi' => '2014',
                'jenis_kelamin' => 'Laki - Laki',
                'pendidikan' => 'S1',
                'lulusan' => '2007',
                'jurusan' => 'Pendidikan B. Inggris',
                'tahun_lulus' => '2007',
                'rt' => '2',
                'rw' => '8',
                'desa' => 'Kubangsari',
                'kecamatan' => 'ketanggungan',
                'kabupaten' => 'Brebes',
                'provinsi' => 'Jawa Tengah',
                'jalan' => 'Kubangsari',
                'alamat' => 'Kubangsari, Rt 2, Rw 8, Desa Kubangsari, Kecamatan ketanggungan, Kabupaten Brebes',
                'no_hp' => '628989290441',
                'agama' => 'Islam',
                'tempat_lahir' => 'Brebes',
                'tanggal_lahir' => '19/06/1984',
                'tmt_mengajar' => '16/07/2005',
            ]
        ];
        \$DataGurusArray = array_map(fn(\$guru) => (object) \$guru, \$guruArray);
        // dd(count(\$DataGurusArray));
        // \$DataGurus = (object) \$DataGurusArray;
        // \$TotalData = count(\$DataGurus);
        // echo "\\n🔢 Data Guru Real.\\n";
        // echo "\\n🔢 Jumlah Data : \$TotalData.\\n";
        // echo "\\n___________________________________\\n";
        foreach (\$DataGurusArray as \$dataGuru) {

            try {
                DB::beginTransaction(); // 🚀 Mulai transaksi
                \$namaExplode = explode(",", \$dataGuru->nama_guru);
                \$nama = ucwords(strtolower(\$namaExplode[0]));
                \$gelar = \$namaExplode[1];
                // Insert user
                DB::table('users')->insert([
                    'posisi'                => 'Guru',
                    'aktiv'                 => 'Y',
                    'detailguru_id'         => null,
                    'name'                  => \$nama,
                    'email'                 => \$dataGuru->kode_guru . '@gmail.com',
                    'email_verified_at'     => now(),
                    'password'              => Hash::make('Password'),
                    'remember_token'        => Str::random(10),
                    'created_at'            => now(),
                    'updated_at'            => now(),
                ]);
                \$this->command->info("✅ DB User masuk! {\$nama}");

                // Ambil ID user terakhir
                \$lasUser = User::orderBy('id', 'desc')->value('id');

                // Insert detail guru
                DB::table('detailgurus')->insert([
                    'user_id'               => \$lasUser,
                    'kode_guru'             => \$dataGuru->kode_guru,
                    'nama_guru'             => \$nama,
                    'gelar'                 => \$gelar,
                    'nip'                   => \$dataGuru->nip,
                    'nik'                   => \$dataGuru->nik,
                    'status'                => \$dataGuru->status,
                    'tahun_sertifikasi'     => \$dataGuru->tahun_sertifikasi,
                    'jenis_kelamin'         => \$dataGuru->jenis_kelamin === 'Laki - Laki' ? 'Laki-laki' : 'Perempuan',
                    'lulusan'               => \$dataGuru->lulusan,
                    'rt'                    => str_pad(\$dataGuru->rt, 3, '0', STR_PAD_LEFT),
                    'rw'                    => str_pad(\$dataGuru->rw, 3, '0', STR_PAD_LEFT),
                    'jurusan'               => ucwords(\$dataGuru->jurusan),
                    'tahun_lulus'           => \$dataGuru->tahun_lulus,
                    'alamat'                => \$dataGuru->alamat,
                    'kabupaten'             => \$dataGuru->kabupaten,
                    'provinsi'              => \$dataGuru->provinsi,
                    'pendidikan'            => \$dataGuru->pendidikan,
                    'agama'                 => 'Islam',
                    'tempat_lahir'          => \$dataGuru->tempat_lahir,
                    'tanggal_lahir'         => \$dataGuru->tanggal_lahir
                        ? Carbon::create(format_tanggal_lahir(\$dataGuru->tanggal_lahir))->format('Y-m-d')
                        : null,
                    'no_hp' => \$dataGuru->no_hp,
                    'tmt_mengajar' => \$dataGuru->tmt_mengajar
                        ? Carbon::create(format_tanggal_lahir(\$dataGuru->tmt_mengajar))->format('Y-m-d')
                        : null,

                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Ambil ID detail guru terakhir dan update user
                \$LatestDetailGuru = Detailguru::orderBy('id', 'desc')->value('id');
                DB::table('users')->where('id', \$lasUser)->update([
                    'detailguru_id' => \$LatestDetailGuru
                ]);


                DB::commit(); // 🎉 Simpan transaksi jika semua aman

                GQrGuru(\$dataGuru->kode_guru);
                \$CounterData++;
                echo "\r Data Ke {\$CounterData}";
            } catch (\Exception \$e) {
                DB::rollBack(); // 🧨 Gagal? Rollback semuanya!
                \$this->command->error("❌ Gagal insert data guru: " . \$dataGuru->nama_guru);
                \$this->command->error("🔁 Alasan: " . \$e->getMessage());
            }
        }

        // \$Gurus = Detailguru::get();
        // foreach (\$Gurus as \$Guru) {
        //     GQrGuru(\$Guru->kode_guru);
        // }
        echo "\\n___________________________________\\n";
        \$this->command->info("✅ Seeder RealGUruSeeder berhasil dijalankan!");
    }
}
PHP,
        'EkelasRealSeeder' => <<<PHP
<?php

namespace {$namespace};
use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use App\Models\User\Guru\Detailguru;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class EkelasRealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        \$dataReal = 1;
        \$kelas = ['a', 'VII A', 'VII B', 'VII C', 'VII D', 'VIII A', 'VIII B', 'VIII C', 'VIII D', 'IX A', 'IX B', 'IX C', 'IX D'];
        \$tingkat_id = ['a', '7', '7', '7', '7', '8', '8', '8', '8', '9', '9', '9', '9'];

        //Tapel
        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        DB::table('emengajars')->truncate(); // anak dulu!
        DB::table('ekelas')->truncate();     // induk

        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
        // \$DataKelas = Ekelas::with('Guru')->where('aktiv', 'Y')->get();
        // dd(\$DataKelas);
        \$etapels = Etapel::where('aktiv', 'Y')->first();
        \$tapel = 3;
        \$jumlahGuru = Detailguru::count();
        \$Detailguru = Detailguru::get();
        // dd(\$Detailguru);
        \$dataKelas = [
            ['kelas'    => 'VII A',     'tingkat_id'    => 7, 'nama_wali_kelas' => 'Dea Tri Komalasari'],
            ['kelas'    => 'VII B',     'tingkat_id'    => 7, 'nama_wali_kelas' => 'Niswah Qonita Amar'],
            ['kelas'    => 'VIII A',    'tingkat_id'    => 8, 'nama_wali_kelas' => 'Ella Yulia Rahmawati'],
            ['kelas'    => 'VIII B',    'tingkat_id'    => 8, 'nama_wali_kelas' => 'Jiddan Zulfa Maulana'],
            ['kelas'    => 'IX A',      'tingkat_id'    => 9, 'nama_wali_kelas' => 'Samsul Arifin'],
        ];

        \$tapel = \$etapels->id;
        foreach (\$dataKelas as \$kelas) {
            \$Walkes = Detailguru::where('nama_guru', \$kelas['nama_wali_kelas'])->value('id');
            // dd(\$Walkes);

            \$kelasseed = [
                'tapel_id' => \$etapels->id, // Pastikan sesuai kebutuhan
                'aktiv' => 'Y',
                'tingkat_id' => \$kelas['tingkat_id'] ?? null, // Pastikan indeks tidak error
                'kelas' => \$kelas['kelas'] ?? null, // Pastikan indeks tidak error
                'semester' => \$etapels->semester,
                'detailguru_id' => \$Walkes ?? 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            DB::table('ekelas')->insert(\$kelasseed);
            echo "\\n___________________________________\\n";
            \$this->command->info("✅ Kelas : {\$kelas['kelas']}\\n");
            \$this->command->info("✅ nama Wali Kelas : {\$kelas['nama_wali_kelas']}\\n");
            \$this->command->info("✅ Success dimasukan\\n");
        }
    }
}
PHP
    ];


    foreach ($additionalSeeders as $fileName => $code) {
        $addPath = "{$folder}/{$fileName}.php";
        if (!File::exists($addPath) || $force) {
            File::put($addPath, $code);
            $this->info("✅ Seeder tambahan '{$fileName}' berhasil dibuat di {$addPath}");
        } else {
            $this->warn("⚠️ Seeder '{$fileName}.php' sudah ada, gunakan --force untuk menimpa");
        }
    }
})->describe('Membuat custom seeder di folder yang ditentukan dengan sub-namespace otomatis, termasuk RealUserAdminSeeder & RealGuruSeeder');

/*
    |--------------------------------------------------------------------------
    | 📌 Migrasi :
    |--------------------------------------------------------------------------
    |
    | Fitur :
    | - xxxxxxxxxxx
    | - xxxxxxxxxxx
    |
    | Tujuan :
    | - xxxxxxxxxxx
    |
    |
    | Penggunaan :
    | - xxxxxxxxxxx
    |
    */
// Proses Coding
Artisan::command('make:custom-migration {name} {namaapps} {--force}', function ($name, $namaapps) {
    $force = $this->option('force');

    // --- Handle Subfolder ---
    $name = str_replace('\\', '/', $name);
    $parts = explode('/', $name);
    $classBaseName = ucfirst(array_pop($parts));
    $subPath = implode('/', array_map('ucfirst', $parts));

    $timestamp = date('Y_m_d_His');
    $fileName = $timestamp . '_' . Str::snake($classBaseName) . '.php';
    $dirPath = database_path("migrations" . ($subPath ? "/$subPath" : ''));

    $filePath = $dirPath . '/' . $fileName;

    // --- Cegah overwrite ---
    if (File::exists($filePath) && !$force) {
        $this->error("❌ File migration '{$fileName}' sudah ada. Gunakan --force untuk menimpa.");
        return;
    }
    if ($force) $this->warn("⚠️ Menimpa file migration '{$fileName}' karena --force dipakai.");

    // --- Template file migration ---
    $className = $classBaseName . 'Table';
    $namespace = $subPath ? 'Database\\Migrations\\' . str_replace('/', '\\', $subPath) : 'Database\\Migrations';

    $template = <<<PHP
<?php

namespace {$namespace};

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class {$className} extends Migration
{
    public function up()
    {
        Schema::create('{$classBaseName}', function (Blueprint \$table) {
            \$table->id();
            \$table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('{$classBaseName}');
    }
}
PHP;

    File::ensureDirectoryExists($dirPath);
    File::put($filePath, $template);
    $this->info("✅ Custom migration '{$className}' berhasil dibuat di: {$filePath}");
})->describe('Membuat file migration baru dengan subfolder custom');
// view
Artisan::command('make:dokumen {path} {--force}', function ($path) {
    $force = $this->option('force');

    // 1️⃣ Normalisasi path
    $path = str_replace('\\', '/', $path);
    $parts = explode('/', $path);
    $name = array_pop($parts); // contoh: "nama-dokumen"

    // 2️⃣ Lokasi view
    $folder = resource_path('views/role/dokumen/' . implode('/', $parts));
    $file = "{$folder}/{$name}.blade.php";

    // 3️⃣ Pastikan folder ada
    File::ensureDirectoryExists($folder);

    // 4️⃣ Buat judul dari nama terakhir
    $judul = strtoupper(str_replace('-', ' ', $name));
    // contoh: "nama-dokumen" → "NAMA DOKUMEN"

    // 5️⃣ Cek file exist / force
    if (!File::exists($file) || $force) {
        $template = <<<BLADE
{{-- View: {$path} --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{$judul}</title>
    <style>
        @page {
            size: A4;
            margin: 2cm;
        }

        html,
        body {
            height: 100%;
            overflow: hidden;
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.5;
            box-sizing: border-box;
        }

        .text-center {
            text-align: center;
        }

        .text-justify {
            text-align: justify;
        }

        .kop {
            display: flex;
            align-items: center;
            border-bottom: 3px double black;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .kop img {
            height: 80px;
            margin-right: 15px;
        }

        .ttd {
            float: right;
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>

<body>

    <x-kop-surat-cetak>{{ \$logo }}</x-kop-surat-cetak>

    <h3 class="text-center"><u>{$judul}</u></h3>
    <p class="text-center">{{\$nomor_surat}}</p>
    <br>

    <div class="ttd">
        <p>{{ \$kabupaten }}, {{ date('d F Y') }}</p>
        Kepala {{ \$kedinasan }}<br><br><br><br>
        <p><strong>{{ \$nama_kepala ?? '' }}</strong><br></p>
        <b style='margin-left:-145px'>NIP. {{ \$nip_kepala ?? '__________' }}</b>
    </div>

</body>

</html>
BLADE;

        File::put($file, $template);
        $this->info("✅ View '{$name}.blade.php' berhasil dibuat di {$file}");
    } else {
        $this->warn("⚠️ View '{$name}.blade.php' sudah ada, gunakan --force untuk menimpa");
    }
})->describe('Membuat dokumen view baru di resources/views/role/dokumen dengan judul otomatis dari nama file');


// Data Custom dokumen list
Artisan::command('make:dokumen-default {data} {--force}', function ($data) {
    $list = [
        "{$data}/surat-home-visit",
        "{$data}/surat-keterangan-pip",
        "{$data}/surat-keterangan-aksioma",
        "{$data}/surat-keterangan-sppd",
        "{$data}/surat-penerimaan-pindahan",
        "{$data}/surat-tugas",
    ];

    foreach ($list as $item) {
        $this->call('make:dokumen', [
            'path'    => $item,
            '--force' => $this->option('force'),
        ]);
    }

    $this->info("✅ Semua dokumen custom berhasil dibuat!");
})->describe('Generate banyak dokumen view sekaligus sesuai daftar preset');
