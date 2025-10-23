<?php

namespace App\Http\Controllers\Program\Tagline;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Program\Tagline\DataTagline;

class DataTaglineController extends Controller
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

php artisan make:view role.role.program.tagline.data-tagline
php artisan make:view role.role.program.tagline.data-tagline-single
php artisan make:model Program/Tagline/DataTagline
php artisan make:controller Program/Tagline/DataTaglineController --resource



php artisan make:seeder Program/Tagline/DataTaglineSeeder
php artisan make:migration Migration_DataTagline




*/
    /*
    DataTagline
    $dttagline
    role.program.tagline.data-tagline
    role.program.tagline.data-tagline.blade_index
    role.program.tagline.data-tagline.blade_show
    Index = Data Tagline
    Breadcume Index = 'Data Artikel / Data Tagline';
    Single = Data Tagline
    php artisan make:view role.program.tagline.data-tagline.blade_index
    php artisan make:view role.program.tagline.data-tagline.blade_index-single
    php artisan make:seed DataTaglineSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Tagline';
        $arr_ths = [
            'Judul',
        ];
        $breadcrumb = 'Data Artikel / Data Tagline';
        $titleviewModal = 'Lihat Data Data Tagline';
        $titleeditModal = 'Edit Data Data Tagline';
        $titlecreateModal = 'Create Data Data Tagline';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = DataTagline::get();
        $datas = \App\Models\Program\Tagline\DataTagline::get();


        return view('role.program.tagline.data-tagline', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.program.tagline.data-tagline.blade_index

    }


    public function create()
    {
        //Title to Controller
        $title = 'Data Tagline';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Data Artikel / Data Tagline';
        $titleviewModal = 'Lihat Data Data Tagline';
        $titleeditModal = 'Edit Data Data Tagline';
        $titlecreateModal = 'Create Data Data Tagline';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = DataTagline::where('tapel_id', $etapels->id)->get();
        return view('role.program.tagline.data-tagline-create', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
    }
    public function show($id)
    {
        //
        //Title to Controller
        $title = 'Data Tagline';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Data Artikel / Data Tagline';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();

        $datas = DataTagline::findOrFail($id);


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.program.tagline.data-tagline-single', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.program.tagline.data-tagline.blade_index-single
    }
    public function edit($id)
    {
        //
        //Title to Controller
        $title = 'Data Tagline';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Data Artikel / Data Tagline';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();

        $datas = DataTagline::findOrFail($id);


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.program.tagline.data-tagline-edit', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.program.tagline.data-tagline.blade_index-single
    }

    public function store(Request $request)
    {
        //
        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'author' => 'nullable|integer',
            'judul' => 'nullable|string|max:255',
            'isi' => 'nullable|string',
            'is_aktif' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }



        DataTagline::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, DataTagline $dttagline)
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
            'author' => 'nullable|integer',
            'judul' => 'nullable|string|max:255',
            'isi' => 'nullable|string',
            'is_aktif' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $varmodel = DataTagline::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //DataTagline
        // dd($id);
        // dd($request->all());
        $data = DataTagline::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}
