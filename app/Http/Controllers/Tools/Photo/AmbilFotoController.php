<?php

namespace App\Http\Controllers\Tools\Photo;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tools\Foto\Fotoguru;
use Illuminate\Support\Facades\File;
use App\Models\Tools\Photo\AmbilFoto;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AmbilFotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

php artisan make:view Tools.Photo.ambil-foto-guru
php artisan make:view Tools.Photo.ambil-foto-guru-single
php artisan make:model Tools/Photo/AmbilFoto
php artisan make:controller Tools/Photo/AmbilFotoController --resource



php artisan make:seeder Tools/Photo/AmbilFotoSeeder
php artisan make:migration Migration_AmbilFoto


    AmbilFoto
    $ambilfoto
    Tools.Photo
    Tools.Photo.ambil-foto-guru
    Tools.Photo.blade_show
    Index = Ambil Foto
    Breadcume Index = 'Tools/ Ambil Foto';
    Single = Ambil Foto
    php artisan make:view Tools.Photo.ambil-foto-guru
    php artisan make:view Tools.Photo.ambil-foto-guru-single
    php artisan make:seed AmbilFotoSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Ambil Foto';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Tools/ Ambil Foto';
        $titleviewModal = 'Lihat Data Ambil Foto';
        $titleeditModal = 'Edit Data Ambil Foto';
        $titlecreateModal = 'Create Data Ambil Foto';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = AmbilFoto::where('tapel_id', $etapels->id)->get();


        return view('Tools.Photo.ambil-foto-guru', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view Tools.Photo.ambil-foto-guru

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Ambil Foto';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Tools/ Ambil Foto';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = AmbilFoto::where('tapel_id', $etapels->id)->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('Tools.Photo.ambil-foto-guru-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view Tools.Photo.ambil-foto-guru-single
    }

    public function store(Request $request)
    {
        //
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            //data_field_validator
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }



        AmbilFoto::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, AmbilFoto $ambilfoto)
    {
        //

        dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            //data_field_validator
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $varmodel = AmbilFoto::find($id); // Pastikan $id didefikodeguruikan atau diterima dari request
        if ($varmodel) {
            $varmodel->update($validator->validated());
            return Redirect::back()->with('Title', 'Berhasil')->with('success', 'Data Berhasil di Update');
        } else {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Data tidak ditemukan');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //AmbilFoto
        // dd($id);
        // dd($request->all());
        $data = AmbilFoto::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
    public function FotoDigitalGuru()
    {
        //dd($request->all());
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Tools Foto';
        $breadcrumb = 'Foto Digital / Foto Guru';
        $titleviewModal = 'Lihat Tools Foto';
        $titleeditModal = 'Edit Tools Foto';
        $titlecreateModal = 'Buat Tools Foto';
        $arr_ths = [
            'Nama guru',
            'kodeguru',
            'Kelas',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        // $datas = \App\Models\Tools\Foto\Fotoguru::WhereNotNull('kelas_id')->get();

        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.tools.foto.foto-guru', compact(
            'title',
            'title',
            'arr_ths',
            // 'datas',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
        ));
    }
    public function storeFotoGuru(Request $request)
    {
        $request->validate([
            'foto' => 'required',
            'kodeguru' => 'required',
            'ukuran' => 'required', // <--- Tambahkan validasi ukuran
        ]);

        $foto = $request->input('foto');
        $kodeguru = $request->input('kodeguru');
        $ukuran = $request->input('ukuran');

        // Bersihkan base64 header
        if (strpos($foto, 'data:image/png;base64,') === 0) {
            $foto = substr($foto, strlen('data:image/png;base64,'));
        }

        $foto = str_replace(' ', '+', $foto); // Ganti spasi jadi +
        $fotoBinary = base64_decode($foto);

        if ($fotoBinary === false) {
            return response()->json([
                'message' => 'Gagal decode base64',
            ], 400);
        }

        // Pastikan folder public/img/guru ada
        $path = public_path('img/guru');
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        // Buat nama file: kodeguru-ukuran.png
        $filename = $kodeguru . '-' . $ukuran . '.png';

        // Simpan file
        $fullPath = $path . '/' . $filename;
        $saved = file_put_contents($fullPath, $fotoBinary);

        if (!$saved) {
            return response()->json([
                'message' => 'Gagal simpan file ke server',
            ], 500);
        }

        return response()->json([
            'message' => 'Foto guru berhasil diunggah!',
            'filename' => $filename,
            'path' => asset('img/guru/' . $filename), // Biar link bisa langsung diakses browser
        ]);
    }
}
