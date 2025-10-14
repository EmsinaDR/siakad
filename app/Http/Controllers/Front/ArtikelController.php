<?php

namespace App\Http\Controllers\Front;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\Front\Artikel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ArtikelController extends Controller
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

php artisan make:view front.artikel
php artisan make:view front.artikel-single
php artisan make:model Front/Artikel
php artisan make:controller Front/ArtikelController --resource



php artisan make:seeder Front/ArtikelSeeder
php artisan make:migration Migration_Artikel




*/
    /*
    Artikel
    $artikel
    front
    front.artikel
    front.blade_show
    Index = Data Artikel
    Breadcume Index = 'Data artikel / Data Artikel';
    Single = Data Artikel
    php artisan make:view program.front.artikel
    php artisan make:view program.front.artikel-single
    php artisan make:seed ArtikelSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Artikel';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Data artikel / Data Artikel';
        $titleviewModal = 'Lihat Data Artikel';
        $titleeditModal = 'Edit Data Artikel';
        $titlecreateModal = 'Create Data Artikel';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = Artikel::where('tapel_id', $etapels->id)->get();


        return view('front.artikel', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view front.artikel

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Data Artikel';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Data artikel / Data Artikel';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = Artikel::where('tapel_id', $etapels->id)->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('front.artikel-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view front.artikel-single
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



        Artikel::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, Artikel $artikel)
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
        $varmodel = Artikel::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //Artikel
        // dd($id);
        // dd($request->all());
        $data = Artikel::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
